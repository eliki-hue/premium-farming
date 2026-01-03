<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class POSDashboardController extends Controller
{
    /**
     * Display POS dashboard/sell page
     */
    public function index()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access POS');
        }
        
        // Check POS access
        $user = auth()->user();
        if (!$this->hasPOSAccess($user)) {
            return redirect()->route('dashboard')->with('error', 'No POS access permission');
        }
        
        $VAT_RATE = 16; 
        $order_id = 'POS' . time() . rand(100, 999);


        // Get today's sales summary
        $todaySales = \App\Models\Order::whereDate('created_at', today())
        ->where('status', 'completed')
        ->sum('total_amount');
        
        $todayTransactions = \App\Models\Order::whereDate('created_at', today())
        ->where('status', 'completed')
        ->count();
        

         // Get products for low stock alert
    $products = \App\Models\Product::all();
    $lowStockProducts = $products->where('stock', '<=', 5)->where('stock', '>', 0);
    
    return view('pos.dashboard', compact(
        'todaySales',
        'todayTransactions',
        'lowStockProducts'
    ));


        // Get store ID (default to 1 for main store)
        $storeId = Session::get('pos_store_id') ?? 1;
        
        // Get products from database
        $dbProducts = Product::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function($product) {
                return (object)[
                    'id' => 'db_' . $product->id,
                    'name' => $product->name,
                    'selling_price' => $product->selling_price,
                    'stock' => $product->stock,
                    'unit' => $product->unit ?? 'bag',
                    'category' => $product->category ?? 'general',
                ];
            });
        
        // Hardcoded products as fallback
        $hardcodedProducts = collect([
            (object)['id' => 1, 'name' => 'Chick Mash 50kg', 'selling_price' => 1700, 'stock' => 45, 'unit' => 'bag', 'category' => 'poultry'],
            (object)['id' => 2, 'name' => 'Layers Mash 50kg', 'selling_price' => 1850, 'stock' => 3, 'unit' => 'bag', 'category' => 'poultry'],
            (object)['id' => 3, 'name' => 'Pig Fattener 50kg', 'selling_price' => 2600, 'stock' => 120, 'unit' => 'bag', 'category' => 'pig'],
            (object)['id' => 4, 'name' => 'Dog Meal 25kg', 'selling_price' => 2200, 'stock' => 8, 'unit' => 'bag', 'category' => 'pet'],
            (object)['id' => 5, 'name' => 'Broiler Starter', 'selling_price' => 1950, 'stock' => 0, 'unit' => 'bag', 'category' => 'poultry'],
            (object)['id' => 6, 'name' => 'Pig Grower 50kg', 'selling_price' => 2400, 'stock' => 67, 'unit' => 'bag', 'category' => 'pig'],
        ]);
        
        // Combine products
        $products = $dbProducts->merge($hardcodedProducts);
        $lowStockProducts = $products->where('stock', '<=', 5)->where('stock', '>', 0)->values();
        
        // Get today's sales summary
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');
            
        $todayTransactions = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();
        
        return view('pos.dashboard', compact(
            'products', 
            'lowStockProducts', 
            'order_id', 
            'VAT_RATE',
            'todaySales',
            'todayTransactions',
            'storeId'
        ));
    }
    
    /**
     * Check if user has POS access
     */
    private function hasPOSAccess($user)
    {
        if ($user->pos_access ?? false) return true;
        if (in_array($user->role ?? '', ['admin', 'manager', 'cashier'])) return true;
        if ($user->is_admin ?? false) return true;
        return false;
    }
    
    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'name' => 'required|string',
            'unit' => 'required|string'
        ]);
        
        $cart = session()->get('pos_cart', []);
        $productId = $request->product_id;
        
        // Check if product already in cart
        $existingKey = null;
        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $productId) {
                $existingKey = $key;
                break;
            }
        }
        
        if ($existingKey !== null) {
            // Update existing item
            $cart[$existingKey]['quantity'] += $request->quantity;
        } else {
            // Add new item
            $cart[] = [
                'product_id' => $productId,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'added_at' => now()
            ];
        }
        
        session()->put('pos_cart', $cart);
        
        return redirect()->route('pos.sell')->with('success', 'Product added to cart');
    }
    
    /**
     * Update cart item
     */
    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('pos_cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('pos_cart', $cart);
        }
        
        return redirect()->route('pos.sell');
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('pos_cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('pos_cart', array_values($cart));
        }
        
        return redirect()->route('pos.sell')->with('warning', 'Item removed from cart');
    }
    
    /**
     * Clear cart
     */
    public function clearCart()
    {
        session()->forget('pos_cart');
        session()->forget('pos_discount');
        
        return redirect()->route('pos.sell')->with('info', 'Cart cleared');
    }
    
    /**
     * Hold sale
     */
    public function holdSale()
    {
        $cart = session()->get('pos_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('pos.sell')->with('error', 'Cart is empty');
        }
        
        $subtotal = $this->calculateSubtotal($cart);
        
        $order = Order::create([
            'order_number' => 'HOLD-' . time(),
            'customer_name' => 'Walk-in',
            'total_amount' => $subtotal,
            'status' => 'hold',
            'user_id' => auth()->id(),
        ]);
        
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }
        
        session()->forget('pos_cart');
        
        return redirect()->route('pos.sell')->with('success', 'Sale held successfully');
    }
    
    /**
     * Complete sale
     */
    public function completeSale(Request $request)
    {
        $cart = session()->get('pos_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('pos.sell')->with('error', 'Cart is empty');
        }
        
        $subtotal = $this->calculateSubtotal($cart);
        $vatRate = 16;
        $discount = session()->get('pos_discount', 0);
        $vat = ($subtotal - $discount) * ($vatRate / 100);
        $grandTotal = ($subtotal - $discount) + $vat;
        
        $request->validate([
            'amount_paid' => 'required|numeric|min:' . $grandTotal,
            'payment_method' => 'required|in:cash,mpesa,card'
        ]);
        
        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'order_number' => 'ORD-' . time(),
                'customer_name' => $request->customer_name ?? 'Walk-in',
                'customer_phone' => $request->customer_phone,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'vat' => $vat,
                'total_amount' => $grandTotal,
                'amount_paid' => $request->amount_paid,
                'change_amount' => $request->amount_paid - $grandTotal,
                'status' => 'completed',
                'user_id' => auth()->id(),
            ]);
            
            foreach ($cart as $item) {
                // Update product stock if it's a database product
                if (strpos($item['product_id'], 'db_') === 0) {
                    $productId = str_replace('db_', '', $item['product_id']);
                    $product = Product::find($productId);
                    if ($product) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['price'] * $item['quantity']
                ]);
            }
            
            DB::commit();
            
            // Store receipt info
            session()->put('pos_receipt', [
                'order_id' => $order->order_number,
                'total' => $grandTotal,
                'date' => now()->format('Y-m-d H:i:s')
            ]);
            
            session()->forget('pos_cart');
            session()->forget('pos_discount');
            
            return redirect()->route('pos.sell')->with('success', 'Sale completed!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pos.sell')->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Process M-Pesa payment
     */
    public function processMpesa(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^07[0-9]{8}$/',
            'customer_name' => 'nullable|string'
        ]);
        
        // For now, just complete the sale
        $request->merge([
            'payment_method' => 'mpesa',
            'payment_reference' => $request->phone,
            'amount_paid' => $request->amount
        ]);
        
        return $this->completeSale($request);
    }
    
    /**
     * Print receipt
     */
    public function printReceipt($orderId)
    {
        $order = Order::where('order_number', $orderId)->firstOrFail();
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        
        return view('pos.receipt', compact('order', 'orderItems'));
    }
    
    /**
     * Calculate cart subtotal
     */
    private function calculateSubtotal($cart)
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }
    
    /**
     * Cash float management
     */
    public function cashFloat()
    {
        return view('pos.cash.float');
    }
    
    public function updateFloat(Request $request)
    {
        $request->validate([
            'opening_balance' => 'required|numeric|min:0'
        ]);
        
        Session::put('pos_cash_float', [
            'opening' => $request->opening_balance,
            'date' => now()->format('Y-m-d'),
            'user_id' => auth()->id()
        ]);
        
        return redirect()->route('pos.sell')->with('success', 'Cash float recorded');
    }
    
    /**
     * Products management (simple)
     */
    public function products()
    {
        $products = Product::orderBy('name')->paginate(50);
        return view('pos.products.index', compact('products'));
    }
    
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string'
        ]);
        
        Product::create([
            'name' => $request->name,
            'selling_price' => $request->selling_price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'category' => $request->category ?? 'general',
            'is_active' => true
        ]);
        
        return redirect()->route('pos.products.index')->with('success', 'Product added');
    }
    
    public function lowStock()
    {
        $products = Product::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->paginate(50);
            
        return view('pos.products.low-stock', compact('products'));
    }
    
    /**
     * Price updates
     */
    public function prices()
    {
        $products = Product::orderBy('name')->get();
        return view('pos.prices.index', compact('products'));
    }
    
    public function updatePrices(Request $request)
    {
        foreach ($request->prices as $productId => $newPrice) {
            if ($newPrice > 0) {
                Product::where('id', $productId)->update([
                    'selling_price' => $newPrice
                ]);
            }
        }
        
        return redirect()->route('pos.prices.index')->with('success', 'Prices updated');
    }
}