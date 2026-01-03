<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Add item to cart (works for both POS and e-commerce)
     */
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'sometimes|numeric|min:1',
        ]);

        $cart = Session::get('cart', []);
        $productId = $request->id;
        
        // Get image from request or use default for POS
        $image = $request->image ?? 'images/default-product.jpg';
        
        // Get quantity from request or default to 1
        $quantity = $request->quantity ?? 1;
        
        if (isset($cart[$productId])) {
            // Update existing item
            $cart[$productId]['quantity'] += $quantity;
            $message = 'Quantity updated in cart';
        } else {
            // Add new item
            $cart[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'price' => $request->price,
                'image' => $image,
                'quantity' => $quantity
            ];
            $message = 'Product added to cart';
        }
        
        Session::put('cart', $cart);
        
        // Return different responses based on request type
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => count($cart),
                'cart_total' => $this->calculateCartTotal($cart),
                'item' => $cart[$productId]
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            
            // If quantity is 0, remove the item
            if ($request->quantity <= 0) {
                unset($cart[$id]);
                $message = 'Item removed from cart';
            } else {
                $message = 'Cart updated successfully';
            }
            
            Session::put('cart', $cart);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => count($cart),
                    'cart_total' => $this->calculateCartTotal($cart)
                ]);
            }
            
            return redirect()->back()->with('success', $message);
        }
        
        return redirect()->back()->with('error', 'Item not found in cart');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
{
    $request->validate([
        'id' => 'required'
    ]);

    $cart = Session::get('cart', []);
    $id = $request->id;
    
    if (isset($cart[$id])) {
        unset($cart[$id]);
        Session::put('cart', $cart);
        
        return redirect()->route('cart.view')->with('success', 'Item removed from cart');
    }
    
    return redirect()->route('cart.view')->with('error', 'Item not found in cart');
}

    /**
     * View cart (works for both e-commerce and POS)
     */
    public function view()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateCartTotal($cart);
        
        // Check if this is a POS request (by route name or other indicator)
        $isPOS = request()->is('pos/*') || request()->routeIs('pos.*');
        
        if ($isPOS) {
            return view('pos.cart', compact('cart', 'total'));
        }
        
        return view('cart.view', compact('cart', 'total'));
    }

    /**
     * Checkout process
     */
    public function checkout(Request $request)
{
    $cart = Session::get('cart', []);
    
    if (empty($cart)) {
        return redirect()->route('cart.view')->with('error', 'Your cart is empty');
    }
    
    $subtotal = 0;
    $shipping = 500; // Default shipping fee
    $tax = 0; // Tax rate
    
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    // Calculate tax (16% VAT for Kenya)
    $tax = $subtotal * 0.16;
    $total = $subtotal + $shipping + $tax;
    
    // Save calculated totals in session for later use
    Session::put('checkout_totals', [
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'tax' => $tax,
        'total' => $total
    ]);
    
    return view('checkout.index', compact('cart', 'subtotal', 'shipping', 'tax', 'total'));
}
    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_total' => 0
            ]);
        }
        
        return redirect()->back()->with('success', 'Cart cleared successfully');
    }

    /**
     * Get cart info (for AJAX requests)
     */
    public function info()
    {
        $cart = Session::get('cart', []);
        
        return response()->json([
            'count' => count($cart),
            'total' => $this->calculateCartTotal($cart),
            'items' => array_values($cart) // Return as indexed array
        ]);
    }

    /**
     * Calculate cart total
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Add multiple items at once (useful for POS)
     */
    public function addMultiple(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'sometimes|numeric|min:1'
        ]);

        $cart = Session::get('cart', []);
        $addedCount = 0;

        foreach ($request->items as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'] ?? 1;
            $image = $item['image'] ?? 'images/default-product.jpg';

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'id' => $productId,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $image,
                    'quantity' => $quantity
                ];
            }
            $addedCount++;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => "{$addedCount} items added to cart",
            'cart_count' => count($cart),
            'cart_total' => $this->calculateCartTotal($cart)
        ]);
    }

       // Add this method to get all products (hardcoded + session)
    public function getProducts()
    {
        // Hardcoded products
        $hardcodedProducts = [
            ['id' => 1, 'name' => 'Chick Mash 50kg', 'selling_price' => 1700, 'stock' => 45, 'unit' => 'bag'],
            ['id' => 2, 'name' => 'Layers Mash 50kg', 'selling_price' => 1850, 'stock' => 3, 'unit' => 'bag'],
            ['id' => 3, 'name' => 'Pig Fattener 50kg', 'selling_price' => 2600, 'stock' => 120, 'unit' => 'bag'],
            ['id' => 4, 'name' => 'Dog Meal 25kg', 'selling_price' => 2200, 'stock' => 8, 'unit' => 'bag'],
            ['id' => 5, 'name' => 'Broiler Starter', 'selling_price' => 1950, 'stock' => 0, 'unit' => 'bag'],
            ['id' => 6, 'name' => 'Pig Grower 50kg', 'selling_price' => 2400, 'stock' => 67, 'unit' => 'bag'],
        ];
        
        // Session-based custom products
        $customProducts = Session::get('custom_products', []);
        
        // Merge all products
        $allProducts = array_merge($hardcodedProducts, $customProducts);
        
        return $allProducts;
    }
    
    // Add this method to add product from modal
    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string',
            'category' => 'nullable|string',
            'buying_price' => 'nullable|numeric|min:0',
            'low_stock_warning' => 'nullable|integer|min:1'
        ]);
        
        $customProducts = Session::get('custom_products', []);
        
        $newProduct = [
            'id' => 'custom_' . (count($customProducts) + 1),
            'name' => $validated['name'],
            'selling_price' => $validated['selling_price'],
            'stock' => $validated['stock'],
            'unit' => $validated['unit'],
            'category' => $validated['category'] ?? 'general',
            'buying_price' => $validated['buying_price'] ?? 0,
            'low_stock_warning' => $validated['low_stock_warning'] ?? 5,
            'created_at' => now()->format('Y-m-d H:i:s')
        ];
        
        $customProducts[] = $newProduct;
        Session::put('custom_products', $customProducts);
        
        return redirect()->back()->with('success', 'Product "' . $validated['name'] . '" added successfully!');
    }


    /**
     * Quick add for POS (simplified version)
     */
    public function quickAdd(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0'
        ]);

        // Generate a temporary ID for POS items
        $productId = 'pos_' . uniqid();
        
        $cart = Session::get('cart', []);
        
        $cart[$productId] = [
            'id' => $productId,
            'name' => $request->name,
            'price' => $request->price,
            'image' => 'images/pos-default.jpg',
            'quantity' => $request->quantity ?? 1
        ];

        Session::put('cart', $cart);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'cart_count' => count($cart),
                'cart_total' => $this->calculateCartTotal($cart),
                'item' => $cart[$productId]
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart');
    }
}