<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display all available products (hardcoded + session-based)
     */
    public function getProducts()
    {
        // Hardcoded products
        $hardcodedProducts = [
            ['id' => 1, 'name' => 'Chick Mash 50kg', 'price' => 1700, 'stock' => 45, 'unit' => 'bag', 'image' => 'images/products/chick-mash.jpg'],
            ['id' => 2, 'name' => 'Layers Mash 50kg', 'price' => 1850, 'stock' => 3, 'unit' => 'bag', 'image' => 'images/products/layers-mash.jpg'],
            ['id' => 3, 'name' => 'Pig Fattener 50kg', 'price' => 2600, 'stock' => 120, 'unit' => 'bag', 'image' => 'images/products/pig-fattener.jpg'],
            ['id' => 4, 'name' => 'Dog Meal 25kg', 'price' => 2200, 'stock' => 8, 'unit' => 'bag', 'image' => 'images/products/dog-meal.jpg'],
            ['id' => 5, 'name' => 'Broiler Starter', 'price' => 1950, 'stock' => 0, 'unit' => 'bag', 'image' => 'images/products/broiler-starter.jpg'],
            ['id' => 6, 'name' => 'Pig Grower 50kg', 'price' => 2400, 'stock' => 67, 'unit' => 'bag', 'image' => 'images/products/pig-grower.jpg'],
        ];
        
        // Session-based custom products
        $customProducts = Session::get('custom_products', []);
        
        // Merge all products
        $allProducts = array_merge($hardcodedProducts, $customProducts);
        
        // Return JSON for AJAX requests or array for views
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'products' => $allProducts,
                'count' => count($allProducts)
            ]);
        }
        
        return $allProducts;
    }

    /**
     * Add a new custom product via modal/form
     */
    public function storeProduct(Request $request)
    {
        // KEEP AUTH FOR ADMIN FUNCTION - Adding custom products
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required for this action.',
                    'requires_auth' => true
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please sign in to perform this action.');
        }
        
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'unit' => 'required|string',
                'category' => 'nullable|string',
                'image' => 'nullable|string',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $customProducts = Session::get('custom_products', []);
            
            $newProduct = [
                'id' => 'custom_' . (count($customProducts) + 1),
                'name' => $request->name,
                'price' => $request->price,
                'selling_price' => $request->price,
                'stock' => $request->stock,
                'unit' => $request->unit,
                'image' => $request->image ?? 'images/default-product.jpg',
                'category' => $request->category ?? 'General',
                'description' => $request->description ?? '',
                'created_at' => now()->toDateTimeString()
            ];
            
            $customProducts[] = $newProduct;
            Session::put('custom_products', $customProducts);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product "' . $request->name . '" added successfully!',
                    'product' => $newProduct
                ]);
            }
            
            return redirect()->back()->with('success', 'Product "' . $request->name . '" added successfully!');
            
        } catch (\Exception $e) {
            Log::error('Store product error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding product: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    /**
     * Add item to cart (unified for both web and POS)
     */
    public function add(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'name' => 'required|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'sometimes|numeric|min:1',
                'unit' => 'sometimes|string',
                'image' => 'nullable|string'
            ]);
            
            $cart = Session::get('cart', []);
            $productId = $request->id;
            
            // Get quantity with default
            $quantity = $request->quantity ?? 1;
            
            // Get image with default
            $image = $request->image ?? 'images/default-product.jpg';
            
            // Get unit with default
            $unit = $request->unit ?? 'unit';
            
            if (isset($cart[$productId])) {
                // Update existing item quantity
                $cart[$productId]['quantity'] += $quantity;
                $message = 'Quantity updated in cart';
            } else {
                // Add new item
                $cart[$productId] = [
                    'id' => $productId,
                    'name' => $request->name,
                    'price' => $request->price,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'image' => $image,
                    'added_at' => now()->toDateTimeString()
                ];
                $message = 'Product added to cart';
            }
            
            Session::put('cart', $cart);
            
            $cartData = $this->getCartData();
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['total'],
                    'item' => $cart[$productId] ?? null,
                    'cart_summary' => $cartData
                ]);
            }
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding to cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error adding to cart: ' . $e->getMessage());
        }
    }

    /**
     * Increment cart item quantity
     */
    public function increment(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'index' => 'sometimes|numeric'
            ]);

            $cart = Session::get('cart', []);
            $productId = $request->id;
            
            // Debug: Log what we're receiving
            Log::info('Increment request:', [
                'product_id' => $productId,
                'cart_keys' => array_keys($cart)
            ]);
            
            if (isset($cart[$productId])) {
                // Increment by product ID (associative array)
                $cart[$productId]['quantity'] += 1;
                $item = $cart[$productId];
                $message = 'Quantity increased';
            } elseif ($request->has('index')) {
                // Try by index (for compatibility)
                $index = $request->index;
                $cartItems = array_values($cart);
                
                if (isset($cartItems[$index])) {
                    $item = $cartItems[$index];
                    $productId = $item['id'];
                    $cart[$productId]['quantity'] += 1;
                    $item = $cart[$productId];
                    $message = 'Quantity increased';
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item not found in cart'
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            Session::put('cart', $cart);
            
            $lineTotal = $item['price'] * $item['quantity'];
            $cartData = $this->getCartData();
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'quantity' => $item['quantity'],
                'item_total' => $lineTotal,
                'cart_count' => $cartData['count'],
                'cart_total' => $cartData['total'],
                'item' => $item
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cart increment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error increasing quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Decrement cart item quantity
     */
    public function decrement(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'index' => 'sometimes|numeric'
            ]);

            $cart = Session::get('cart', []);
            $productId = $request->id;
            $removed = false;
            
            // Debug: Log what we're receiving
            Log::info('Decrement request:', [
                'product_id' => $productId,
                'cart_keys' => array_keys($cart)
            ]);
            
            if (isset($cart[$productId])) {
                // Decrement by product ID
                if ($cart[$productId]['quantity'] <= 1) {
                    unset($cart[$productId]);
                    $removed = true;
                    $message = 'Item removed from cart';
                } else {
                    $cart[$productId]['quantity'] -= 1;
                    $item = $cart[$productId];
                    $message = 'Quantity decreased';
                }
            } elseif ($request->has('index')) {
                // Try by index
                $index = $request->index;
                $cartItems = array_values($cart);
                
                if (isset($cartItems[$index])) {
                    $existingItem = $cartItems[$index];
                    $productId = $existingItem['id'];
                    
                    if ($existingItem['quantity'] <= 1) {
                        unset($cart[$productId]);
                        $removed = true;
                        $message = 'Item removed from cart';
                    } else {
                        $cart[$productId]['quantity'] -= 1;
                        $item = $cart[$productId];
                        $message = 'Quantity decreased';
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Item not found in cart'
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in cart'
                ], 404);
            }
            
            Session::put('cart', $cart);
            
            $cartData = $this->getCartData();
            $response = [
                'success' => true,
                'message' => $message,
                'cart_count' => $cartData['count'],
                'cart_total' => $cartData['total']
            ];
            
            if (!$removed) {
                $lineTotal = $item['price'] * $item['quantity'];
                $response['quantity'] = $item['quantity'];
                $response['item_total'] = $lineTotal;
                $response['item'] = $item;
            }
            
            $response['removed'] = $removed;
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('Cart decrement error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error decreasing quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity (by ID or index)
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required_without:index',
                'index' => 'required_without:id|numeric',
                'quantity' => 'required|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $cart = Session::get('cart', []);
            $updated = false;
            
            if ($request->has('id')) {
                // Update by product ID
                $productId = $request->id;
                
                if (isset($cart[$productId])) {
                    if ($request->quantity <= 0) {
                        unset($cart[$productId]);
                        $message = 'Item removed from cart';
                    } else {
                        $cart[$productId]['quantity'] = $request->quantity;
                        $message = 'Cart updated successfully';
                    }
                    $updated = true;
                }
            } elseif ($request->has('index')) {
                // Update by array index (for backward compatibility)
                $index = $request->index;
                $cartItems = array_values($cart); // Convert to indexed array
                
                if (isset($cartItems[$index])) {
                    $item = $cartItems[$index];
                    $productId = $item['id'];
                    
                    if ($request->quantity <= 0) {
                        unset($cart[$productId]);
                        $message = 'Item removed from cart';
                    } else {
                        $cart[$productId]['quantity'] = $request->quantity;
                        $message = 'Cart updated successfully';
                    }
                    $updated = true;
                }
            }
            
            if ($updated) {
                Session::put('cart', $cart);
                $cartData = $this->getCartData();
                
                $response = [
                    'success' => true,
                    'message' => $message,
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['total'],
                    'cart_summary' => $cartData
                ];
                
                // Calculate line total if item still exists
                if ($request->quantity > 0 && isset($productId) && isset($cart[$productId])) {
                    $item = $cart[$productId];
                    $response['item_total'] = $item['price'] * $item['quantity'];
                }
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json($response);
                }
                
                return redirect()->back()->with('success', $message);
            }
            
            $errorMessage = 'Item not found in cart';
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 404);
            }
            
            return redirect()->back()->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error updating cart: ' . $e->getMessage());
        }
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required_without:index',
                'index' => 'required_without:id|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $cart = Session::get('cart', []);
            $removed = false;
            
            if ($request->has('id')) {
                // Remove by product ID
                $productId = $request->id;
                
                if (isset($cart[$productId])) {
                    unset($cart[$productId]);
                    $removed = true;
                }
            } elseif ($request->has('index')) {
                // Remove by array index (for backward compatibility)
                $index = $request->index;
                $cartItems = array_values($cart); // Convert to indexed array
                
                if (isset($cartItems[$index])) {
                    $item = $cartItems[$index];
                    $productId = $item['id'];
                    unset($cart[$productId]);
                    $removed = true;
                }
            }
            
            if ($removed) {
                Session::put('cart', $cart);
                $cartData = $this->getCartData();
                
                $response = [
                    'success' => true,
                    'message' => 'Item removed from cart',
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['total']
                ];
                
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json($response);
                }
                
                return redirect()->route('cart.view')->with('success', 'Item removed from cart');
            }
            
            $errorMessage = 'Item not found in cart';
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 404);
            }
            
            return redirect()->route('cart.view')->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error removing item: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error removing item: ' . $e->getMessage());
        }
    }

    /**
     * Get cart count and total (AJAX)
     */
    public function count(Request $request)
    {
        try {
            $cartData = $this->getCartData();
            
            return response()->json([
                'success' => true,
                'count' => $cartData['count'],
                'total' => $cartData['total'],
                'items_count' => $cartData['items_count'],
                'subtotal' => $cartData['subtotal'],
                'is_authenticated' => Auth::check()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cart count error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'count' => 0,
                'total' => 0,
                'items_count' => 0,
                'subtotal' => 0,
                'error' => $e->getMessage(),
                'is_authenticated' => Auth::check()
            ], 500);
        }
    }

    /**
     * Get detailed cart info
     */
    public function info()
    {
        try {
            $cartData = $this->getCartData();
            
            return response()->json([
                'success' => true,
                'cart' => $cartData['items'],
                'count' => $cartData['count'],
                'total' => $cartData['total'],
                'items_count' => $cartData['items_count'],
                'subtotal' => $cartData['subtotal']
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cart info error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'cart' => [],
                'count' => 0,
                'total' => 0,
                'items_count' => 0,
                'subtotal' => 0,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * View cart page
     */
    public function view()
    {
        $cartData = $this->getCartData();
        
        // Check if this is a POS request
        $isPOS = request()->is('pos/*') || request()->routeIs('pos.*') || 
                strpos(request()->path(), 'pos') !== false;
        
        if ($isPOS) {
            $products = $this->getProducts();
            return view('pos.cart', [
                'cart' => $cartData['items'],
                'cartTotal' => $cartData['total'],
                'cartCount' => $cartData['count'],
                'products' => $products
            ]);
        }
        
        return view('cart.view', [
            'cart' => $cartData['items'],
            'cartTotal' => $cartData['total'],
            'cartCount' => $cartData['count'],
            'subtotal' => $cartData['subtotal']
        ]);
    }

    /**
     * Checkout process - REMOVED AUTH FOR GUEST CHECKOUT
     */
    public function checkout(Request $request)
    {
        try {
            $cart = Session::get('cart', []);
            
            if (empty($cart)) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your cart is empty'
                    ], 400);
                }
                return redirect()->route('cart.view')->with('error', 'Your cart is empty');
            }
            
            $subtotal = 0;
            $itemsCount = 0;
            
            foreach ($cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $subtotal += $itemTotal;
                $itemsCount += $item['quantity'];
            }
            
            // Calculate shipping (free over certain amount or fixed)
            $shipping = ($subtotal > 5000) ? 0 : 500; // Free shipping over 5000
            
            // Calculate tax (16% VAT for Kenya)
            $tax = $subtotal * 0.16;
            
            $total = $subtotal + $shipping + $tax;
            
            // Save checkout data in session
            Session::put('checkout_data', [
                'cart' => $cart,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'items_count' => $itemsCount,
                'calculated_at' => now()->toDateTimeString()
            ]);
            
            // Return appropriate response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'checkout_data' => Session::get('checkout_data'),
                    'redirect_url' => route('checkout.index')
                ]);
            }
            
            return view('checkout.index', [
                'cart' => $cart,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'items_count' => $itemsCount
            ]);
            
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout error: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('cart.view')->with('error', 'Checkout error: ' . $e->getMessage());
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        try {
            Session::forget('cart');
            Session::forget('checkout_data');
            
            $response = [
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_total' => 0
            ];
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response);
            }
            
            return redirect()->back()->with('success', 'Cart cleared successfully');
            
        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error clearing cart: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error clearing cart: ' . $e->getMessage());
        }
    }

    /**
     * Add multiple items at once (for POS or bulk operations)
     */
    public function addMultiple(Request $request)
    {
        // KEEP AUTH FOR THIS - This is usually a POS/admin function
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required for this action.',
                'requires_auth' => true
            ], 401);
        }
        
        try {
            $request->validate([
                'items' => 'required|array',
                'items.*.id' => 'required',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.quantity' => 'sometimes|numeric|min:1',
                'items.*.unit' => 'sometimes|string'
            ]);

            $cart = Session::get('cart', []);
            $addedCount = 0;
            $errors = [];

            foreach ($request->items as $index => $item) {
                try {
                    $productId = $item['id'];
                    $quantity = $item['quantity'] ?? 1;
                    $unit = $item['unit'] ?? 'unit';
                    $image = $item['image'] ?? 'images/default-product.jpg';

                    if (isset($cart[$productId])) {
                        $cart[$productId]['quantity'] += $quantity;
                    } else {
                        $cart[$productId] = [
                            'id' => $productId,
                            'name' => $item['name'],
                            'price' => $item['price'],
                            'quantity' => $quantity,
                            'unit' => $unit,
                            'image' => $image,
                            'added_at' => now()->toDateTimeString()
                        ];
                    }
                    $addedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Item {$index}: " . $e->getMessage();
                }
            }

            Session::put('cart', $cart);
            $cartData = $this->getCartData();

            $response = [
                'success' => true,
                'message' => "{$addedCount} items added to cart",
                'cart_count' => $cartData['count'],
                'cart_total' => $cartData['total'],
                'added_count' => $addedCount
            ];

            if (!empty($errors)) {
                $response['warnings'] = $errors;
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Add multiple items error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error adding multiple items: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Quick add for POS (simplified version)
     */
    public function quickAdd(Request $request)
    {
        // KEEP AUTH FOR THIS - This is usually a POS/admin function
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required for this action.',
                    'requires_auth' => true
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Please sign in to perform this action.');
        }
        
        try {
            $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'sometimes|numeric|min:1',
                'unit' => 'sometimes|string'
            ]);

            // Generate a temporary ID for POS items
            $productId = 'pos_' . uniqid();
            
            $cart = Session::get('cart', []);
            
            $cart[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity ?? 1,
                'unit' => $request->unit ?? 'unit',
                'image' => 'images/pos-default.jpg',
                'added_at' => now()->toDateTimeString(),
                'is_pos_item' => true
            ];

            Session::put('cart', $cart);
            $cartData = $this->getCartData();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart',
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['total'],
                    'item' => $cart[$productId],
                    'cart_summary' => $cartData
                ]);
            }

            return redirect()->back()->with('success', 'Item added to cart');

        } catch (\Exception $e) {
            Log::error('Quick add error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error adding item: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error adding item: ' . $e->getMessage());
        }
    }

    /**
     * Get cart data (helper method)
     */
    private function getCartData()
    {
        $cart = Session::get('cart', []);
        
        $total = 0;
        $subtotal = 0;
        $itemsCount = 0;
        $cartItems = [];
        
        foreach ($cart as $item) {
            $itemTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
            $total += $itemTotal;
            $subtotal += $itemTotal;
            $itemsCount += ($item['quantity'] ?? 1);
            $cartItems[] = $item;
        }
        
        return [
            'items' => $cartItems,
            'count' => count($cart),
            'total' => $total,
            'subtotal' => $subtotal,
            'items_count' => $itemsCount,
            'raw_cart' => $cart
        ];
    }

    /**
     * Apply discount to cart - KEEP AUTH (usually admin/privileged action)
     */
    public function applyDiscount(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required for this action.',
                'requires_auth' => true
            ], 401);
        }
        
        try {
            $request->validate([
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0'
            ]);

            $cartData = $this->getCartData();
            $subtotal = $cartData['subtotal'];
            
            $discount = 0;
            
            if ($request->discount_type === 'percentage') {
                $discount = ($subtotal * $request->discount_value) / 100;
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            } else {
                $discount = $request->discount_value;
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            }
            
            // Store discount in session
            Session::put('cart_discount', [
                'type' => $request->discount_type,
                'value' => $request->discount_value,
                'amount' => $discount,
                'applied_at' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Discount applied successfully',
                'discount_amount' => $discount,
                'new_subtotal' => $subtotal - $discount
            ]);

        } catch (\Exception $e) {
            Log::error('Apply discount error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error applying discount: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove discount from cart - KEEP AUTH (usually admin/privileged action)
     */
    public function removeDiscount(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required for this action.',
                'requires_auth' => true
            ], 401);
        }
        
        try {
            Session::forget('cart_discount');
            
            return response()->json([
                'success' => true,
                'message' => 'Discount removed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Remove discount error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error removing discount: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user-specific cart (optional method for user isolation)
     */
    public function getUserCart()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
                'requires_auth' => true
            ], 401);
        }
        
        $userId = Auth::id();
        $cart = Session::get('cart', []);
        
        // Filter cart items by user ID (if stored)
        $userCart = array_filter($cart, function($item) use ($userId) {
            return ($item['user_id'] ?? null) == $userId;
        });
        
        return response()->json([
            'success' => true,
            'cart' => $userCart,
            'count' => count($userCart)
        ]);
    }
}