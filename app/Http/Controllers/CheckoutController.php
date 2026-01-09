<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }
        
        // Calculate subtotal and weight
        $subtotal = 0;
        $totalWeight = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemWeight = $item['weight'] ?? 0;
            $totalWeight += $itemWeight * $item['quantity'];
        }
        
        $shipping = 500; // Default shipping
        $tax = $subtotal * 0.16;
        $total = $subtotal + $shipping + $tax;
        
        // Get delivery zones for the form
        $deliveryZones = DeliveryZone::where('is_active', true)->get();
        
        // Determine weight category for display
        $weightCategory = $this->getWeightCategory($totalWeight);
        
        return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total', 'totalWeight', 'deliveryZones', 'weightCategory'));
    }
    
    public function calculateDelivery(Request $request)
    {
        $request->validate([
            'zone_id' => 'required|exists:delivery_zones,id',
            'distance' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0'
        ]);

        $zone = DeliveryZone::find($request->zone_id);
        $distance = $request->distance;
        $weight = $request->weight;

        // Calculate delivery fee
        $baseFee = $zone->base_fee;
        $freeDistance = $zone->free_distance_km;
        $perKmFee = $zone->per_km_fee;
        $perKgFee = $zone->per_kg_fee ?? 10; // Default per kg fee
        
        // Calculate distance fee
        $distanceFee = 0;
        if ($distance > $freeDistance) {
            $distanceFee = ($distance - $freeDistance) * $perKmFee;
        }
        
        // Calculate weight fee
        $weightFee = $weight * $perKgFee;
        
        // Total delivery fee
        $deliveryFee = $baseFee + $distanceFee + $weightFee;
        
        // Store in session for later use
        Session::put([
            'delivery_zone_id' => $zone->id,
            'delivery_distance' => $distance,
            'delivery_weight' => $weight,
            'delivery_fee' => $deliveryFee,
            'delivery_zone_name' => $zone->name
        ]);

        return response()->json([
            'success' => true,
            'delivery_fee' => number_format($deliveryFee, 2),
            'zone_name' => $zone->name,
            'breakdown' => [
                'base_fee' => number_format($baseFee, 2),
                'distance_fee' => number_format($distanceFee, 2),
                'weight_fee' => number_format($weightFee, 2),
                'free_distance' => $freeDistance . 'km'
            ]
        ]);
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'delivery_address' => 'required|string|max:500',
            'delivery_notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:mpesa,cash_on_delivery,bank_transfer',
            'delivery_zone_id' => 'required|exists:delivery_zones,id',
            'delivery_distance' => 'required|numeric|min:0',
            'delivery_type' => 'required|in:farm_delivery,pickup_station',
            'county' => 'required|string|max:100',
            'town' => 'required|string|max:100',
            'mpesa_number' => 'required_if:payment_method,mpesa|nullable|string|max:20',
            'bank_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }

        // Calculate order totals
        $subtotal = 0;
        $totalWeight = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemWeight = $item['weight'] ?? 0;
            $totalWeight += $itemWeight * $item['quantity'];
        }
        
        // Get delivery fee from session or calculate default
        $deliveryFee = Session::get('delivery_fee', 500);
        $deliveryZoneId = $request->delivery_zone_id;
        $deliveryDistance = $request->delivery_distance;
        
        // Get delivery zone
        $deliveryZone = DeliveryZone::find($deliveryZoneId);
        $deliveryZoneName = $deliveryZone ? $deliveryZone->name : 'Standard Delivery';
        
        // Apply delivery type - pickup station is free
        $shipping = ($request->delivery_type === 'pickup_station') ? 0 : $deliveryFee;
        
        $tax = $subtotal * 0.16;
        $total = $subtotal + $shipping + $tax;
        
        // Generate order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        
        // Handle file upload if bank transfer
        $bankSlipPath = null;
        if ($request->hasFile('bank_slip')) {
            $bankSlipPath = $request->file('bank_slip')->store('bank-slips', 'public');
        }
        
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Create order in database
            $order = Order::create([
                'order_number' => $orderNumber,
                // REMOVED: 'user_id' => Auth::id(), // No user_id for guest checkout
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'county' => $request->county,
                'town' => $request->town,
                'delivery_zone_id' => $deliveryZoneId,
                'delivery_distance' => $deliveryDistance,
                'total_weight' => $totalWeight,
                'delivery_fee' => $shipping,
                'delivery_type' => $request->delivery_type,
                'delivery_notes' => $request->delivery_notes,
                'subtotal' => $subtotal,
                'vat' => $tax,
                'grand_total' => $total,
                'payment_method' => $request->payment_method,
                'mpesa_number' => $request->mpesa_number,
                'bank_slip_path' => $bankSlipPath,
                'payment_status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : ($request->payment_method === 'mpesa' ? 'pending' : 'pending'),
                'order_status' => 'pending',
                'notes' => $request->delivery_notes
            ]);
            
            // Add order items
            foreach ($cart as $itemId => $item) {
                // Try to find product by ID or name
                $product = Product::where('id', $itemId)->orWhere('name', $item['name'])->first();
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product ? $product->id : null,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'weight' => $item['weight'] ?? 0,
                ]);
                
                // If product exists and has stock, reduce stock
                if ($product && isset($product->stock)) {
                    $product->stock -= $item['quantity'];
                    $product->save();
                }
            }
            
            DB::commit();
            
            // Clear cart and delivery data
            Session::forget('cart');
            Session::forget('delivery_zone_id');
            Session::forget('delivery_distance');
            Session::forget('delivery_weight');
            Session::forget('delivery_fee');
            Session::forget('delivery_zone_name');
            
            // Handle M-Pesa payment if selected
            if ($request->payment_method === 'mpesa') {
                return $this->processMpesaPayment($order);
            }
            
            // Redirect to success page
            return redirect()->route('checkout.success', $order)
                ->with('success', 'Order placed successfully! Your order number is: ' . $orderNumber);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    private function processMpesaPayment($order)
    {
        // Here you would integrate with Safaricom M-Pesa API
        
        // For now, simulate M-Pesa payment process
        $order->update([
            'payment_status' => 'pending',
            'order_status' => 'payment_pending'
        ]);
        
        // Show M-Pesa payment instructions
        return view('checkout.mpesa', compact('order'));
    }
    
    public function success(Order $order)
    {
        // No authentication check - anyone with order ID can view success page
        return view('checkout.success', compact('order'));
    }
    
    public function receipt($orderId)
    {
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found');
        }
        
        // No authentication check - anyone with order number can view receipt
        return view('checkout.receipt', compact('order'));
    }
    
    public function orders()
    {
        // COMPLETELY REMOVE THIS METHOD OR REDIRECT TO TRACK ORDER
        
        // Since there's no authentication, we can't show user-specific orders
        // Redirect to track order page instead
        return redirect()->route('checkout.track')
            ->with('info', 'Please use the Track Order feature to find your orders');
    }
    
    public function viewOrder($orderId)
    {
        // COMPLETELY REMOVE THIS METHOD OR MAKE IT PUBLIC
        
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->route('checkout.track')->with('error', 'Order not found');
        }
        
        // Allow anyone to view order with order number
        return view('checkout.order-details', compact('order'));
    }
    
    public function printReceipt($orderId)
    {
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        
        // No authentication - anyone can print receipt
        return view('checkout.print-receipt', compact('order'));
    }
    
    public function trackOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'order_number' => 'required|string',
                'customer_email' => 'required|email'
            ]);
            
            $order = Order::where('order_number', $request->order_number)
                ->where('customer_email', $request->customer_email)
                ->first();
                
            if (!$order) {
                return view('checkout.track', [
                    'found' => false,
                    'message' => 'Order not found. Please check your order number and email.'
                ]);
            }
            
            return view('checkout.track', compact('order'));
        }
        
        return view('checkout.track');
    }
    
    // Helper method for weight category
    private function getWeightCategory($weight)
    {
        if ($weight <= 5) {
            return 'Light';
        } elseif ($weight <= 20) {
            return 'Medium';
        } else {
            return 'Heavy';
        }
    }
    
    // M-Pesa callback (for webhook)
    public function mpesaCallback(Request $request)
    {
        // Handle M-Pesa callback from Safaricom
        // This would be called by Safaricom's API
        
        $data = $request->all();
        
        // Process the callback data
        // Update order payment status, etc.
        
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}