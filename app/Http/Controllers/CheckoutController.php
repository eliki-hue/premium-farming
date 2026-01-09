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
use App\Models\Receipt;

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
        
        // Delivery fee commented out - set to 0
        $shipping = 0;
        
        // VAT commented out - set to 0
        $tax = 0;
        
        $total = $subtotal + $shipping + $tax;
        
        $deliveryZones = [];
        $weightCategory = 'Not Applicable';
        
        return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total', 'totalWeight', 'deliveryZones', 'weightCategory'));
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            
            // Updated payment methods: mpesa, cheque, bank_transfer (removed cash_on_delivery)
            'payment_method' => 'required|in:mpesa,cheque,bank_transfer',
            
            // Fields for specific payment methods
            'mpesa_number' => 'required_if:payment_method,mpesa|nullable|string|max:20',
            'cheque_number' => 'required_if:payment_method,cheque|nullable|string|max:50',
            'bank_name' => 'required_if:payment_method,bank_transfer|nullable|string|max:100',
            'account_name' => 'required_if:payment_method,bank_transfer|nullable|string|max:255',
            'account_number' => 'required_if:payment_method,bank_transfer|nullable|string|max:50',
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
        
        // Delivery fee commented out - set to 0
        $deliveryFee = 0;
        
        // Delivery zone fields commented out
        $deliveryZoneId = null;
        $deliveryDistance = 0;
        $deliveryZoneName = 'Not Applicable';
        
        // Apply delivery type - pickup station is free (commented out)
        $shipping = 0;
        
        // VAT commented out - set to 0
        $tax = 0;
        
        $total = $subtotal + $shipping + $tax;
        
        // Generate order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        
        // Handle file upload if bank transfer or cheque
        $paymentProofPath = null;
        if ($request->hasFile('bank_slip')) {
            $paymentProofPath = $request->file('bank_slip')->store('payment-proofs', 'public');
        }
        
        // Generate receipt number
        $receiptNumber = 'RCT-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Create order in database
            $order = Order::create([
                'order_number' => $orderNumber,
                'receipt_number' => $receiptNumber, // Add receipt number to order
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                
                // Delivery fields commented out - set placeholder values
                'delivery_address' => 'Not Required',
                'county' => 'Not Required',
                'town' => 'Not Required',
                'delivery_zone_id' => null,
                'delivery_distance' => 0,
                'total_weight' => $totalWeight,
                'delivery_fee' => $shipping,
                'delivery_type' => 'pickup',
                'delivery_notes' => 'No delivery required',
                'subtotal' => $subtotal,
                'vat' => 0,
                'grand_total' => $total,
                
                // Payment information
                'payment_method' => $request->payment_method,
                
                // M-Pesa details
                'mpesa_number' => $request->mpesa_number,
                
                // Cheque details
                'cheque_number' => $request->cheque_number,
                
                // Bank transfer details
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                
                'payment_proof_path' => $paymentProofPath,
                
                // Payment status - all methods require proof/confirmation
                'payment_status' => 'pending',
                'order_status' => 'pending',
                
                'notes' => 'Customer notes: ' . ($request->notes ?? 'None')
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
            
            // Create receipt record
            $receipt = Receipt::create([
                'receipt_number' => $receiptNumber,
                'order_id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'customer_email' => $order->customer_email,
                'amount' => $order->grand_total,
                'payment_method' => $order->payment_method,
                'payment_status' => 'pending',
                'issued_date' => now(),
                'issued_by' => 'System',
                'notes' => 'Order placed - Payment confirmation pending via WhatsApp'
            ]);
            
            DB::commit();
            
            // Clear cart and delivery data
            Session::forget('cart');
            
            // Store order and receipt info in session for receipt access
            Session::put('last_order', [
                'order_number' => $orderNumber,
                'receipt_number' => $receiptNumber,
                'customer_email' => $order->customer_email
            ]);
            
            // Handle payment method specific redirection
            if ($request->payment_method === 'mpesa') {
                return $this->processMpesaPayment($order);
            } elseif ($request->payment_method === 'cheque') {
                return $this->processChequePayment($order);
            } elseif ($request->payment_method === 'bank_transfer') {
                return $this->processBankTransferPayment($order);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Failed to place order. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    private function processMpesaPayment($order)
    {
        // Update order status
        $order->update([
            'payment_status' => 'pending',
            'order_status' => 'mpesa_pending'
        ]);
        
        // Update receipt status
        Receipt::where('order_id', $order->id)->update([
            'payment_status' => 'pending',
            'notes' => 'M-Pesa payment pending confirmation'
        ]);
        
        // WhatsApp message template
        $whatsappMessage = "Hello! I would like to make payment for Order #{$order->order_number} (Receipt: {$order->receipt_number}). Amount: KES " . number_format($order->grand_total, 2);
        
        // Show M-Pesa payment instructions with PayBill details and WhatsApp
        return view('checkout.mpesa', compact('order', 'whatsappMessage'));
    }
    
    private function processChequePayment($order)
    {
        // Update order status
        $order->update([
            'payment_status' => 'pending',
            'order_status' => 'cheque_pending'
        ]);
        
        // Update receipt status
        Receipt::where('order_id', $order->id)->update([
            'payment_status' => 'pending',
            'notes' => 'Cheque payment pending confirmation'
        ]);
        
        // WhatsApp message template
        $whatsappMessage = "Hello! I would like to confirm cheque payment for Order #{$order->order_number} (Receipt: {$order->receipt_number}). Cheque #: {$order->cheque_number}. Amount: KES " . number_format($order->grand_total, 2);
        
        // Show cheque payment instructions with WhatsApp
        return view('checkout.cheque', compact('order', 'whatsappMessage'));
    }
    
    private function processBankTransferPayment($order)
    {
        // Update order status
        $order->update([
            'payment_status' => 'pending',
            'order_status' => 'bank_transfer_pending'
        ]);
        
        // Update receipt status
        Receipt::where('order_id', $order->id)->update([
            'payment_status' => 'pending',
            'notes' => 'Bank transfer payment pending confirmation'
        ]);
        
        // WhatsApp message template
        $whatsappMessage = "Hello! I would like to confirm bank transfer for Order #{$order->order_number} (Receipt: {$order->receipt_number}). Amount: KES " . number_format($order->grand_total, 2);
        
        // Show bank transfer instructions with WhatsApp
        return view('checkout.bank-transfer', compact('order', 'whatsappMessage'));
    }
    
    public function success(Order $order)
    {
        // No authentication check - anyone with order ID can view success page
        return view('checkout.success', compact('order'));
    }
    
    public function receipt($orderId)
    {
        // Try to find by order number first
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        // If not found by order number, try by receipt number
        if (!$order) {
            $order = Order::with('items')->where('receipt_number', $orderId)->first();
        }
        
        // If still not found, try by ID
        if (!$order) {
            $order = Order::with('items')->find($orderId);
        }
        
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found');
        }
        
        // Get receipt information
        $receipt = Receipt::where('order_id', $order->id)->first();
        
        // No authentication check - anyone with order number can view receipt
        return view('checkout.receipt', compact('order', 'receipt'));
    }
    
    public function printReceipt($orderId)
    {
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            $order = Order::with('items')->find($orderId);
        }
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        
        $receipt = Receipt::where('order_id', $order->id)->first();
        
        return view('checkout.print-receipt', compact('order', 'receipt'));
    }
    
    public function trackOrder(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'order_number' => 'required_without_all:receipt_number,customer_email',
                'receipt_number' => 'required_without_all:order_number,customer_email',
                'customer_email' => 'required_without_all:order_number,receipt_number|email'
            ], [
                'order_number.required_without_all' => 'Please enter at least one search criteria',
                'receipt_number.required_without_all' => 'Please enter at least one search criteria',
                'customer_email.required_without_all' => 'Please enter at least one search criteria'
            ]);
            
            $query = Order::with('items');
            
            if ($request->filled('order_number')) {
                $query->where('order_number', $request->order_number);
            }
            
            if ($request->filled('receipt_number')) {
                $query->where('receipt_number', $request->receipt_number);
            }
            
            if ($request->filled('customer_email')) {
                $query->where('customer_email', $request->customer_email);
            }
            
            $order = $query->first();
                
            if (!$order) {
                return view('checkout.track', [
                    'found' => false,
                    'message' => 'Order not found. Please check your search criteria.'
                ]);
            }
            
            $receipt = Receipt::where('order_id', $order->id)->first();
            
            return view('checkout.track', compact('order', 'receipt'));
        }
        
        return view('checkout.track');
    }
    
    /**
     * Download receipt as PDF
     */
    public function downloadReceipt($orderId)
    {
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            $order = Order::with('items')->find($orderId);
        }
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        
        $receipt = Receipt::where('order_id', $order->id)->first();
        
        // Generate PDF (you'll need to install a PDF library like barryvdh/laravel-dompdf)
        // For now, we'll redirect to print view
        return view('checkout.receipt-pdf', compact('order', 'receipt'));
    }
    
    /**
     * Generate receipt after payment confirmation
     */
    public function generateReceipt($orderId)
    {
        $order = Order::with('items')->where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        
        // Check if receipt already exists
        $receipt = Receipt::where('order_id', $order->id)->first();
        
        if (!$receipt) {
            // Generate new receipt
            $receiptNumber = 'RCT-' . date('Ymd') . '-' . Str::upper(Str::random(6));
            
            $receipt = Receipt::create([
                'receipt_number' => $receiptNumber,
                'order_id' => $order->id,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'customer_email' => $order->customer_email,
                'amount' => $order->grand_total,
                'payment_method' => $order->payment_method,
                'payment_status' => 'completed',
                'issued_date' => now(),
                'issued_by' => 'System',
                'notes' => 'Payment confirmed via WhatsApp'
            ]);
            
            // Update order with receipt number
            $order->update(['receipt_number' => $receiptNumber]);
        }
        
        return redirect()->route('checkout.receipt', ['orderId' => $order->order_number])
            ->with('success', 'Receipt generated successfully!');
    }
    
    /**
     * Confirm payment and update receipt
     */
    public function confirmPayment(Request $request, $orderId)
    {
        $request->validate([
            'transaction_code' => 'required|string|max:50',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric'
        ]);
        
        $order = Order::where('order_number', $orderId)->first();
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        
        // Update order payment status
        $order->update([
            'payment_status' => 'completed',
            'order_status' => 'processing',
            'payment_date' => $request->payment_date
        ]);
        
        // Update or create receipt
        $receipt = Receipt::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_status' => 'completed',
                'transaction_code' => $request->transaction_code,
                'payment_date' => $request->payment_date,
                'amount_received' => $request->payment_amount,
                'notes' => 'Payment confirmed manually',
                'issued_by' => Auth::check() ? Auth::user()->name : 'Admin'
            ]
        );
        
        return redirect()->route('checkout.receipt', ['orderId' => $order->order_number])
            ->with('success', 'Payment confirmed and receipt updated!');
    }
}