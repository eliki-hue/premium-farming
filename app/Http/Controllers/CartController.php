<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function view()
    {
        $cart = Session::get('cart', []);
        $subtotal = 0;
        $totalItems = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
        }
        
        return view('cart.view', compact('cart', 'subtotal', 'totalItems'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable',
            'quantity' => 'nullable|integer|min:1'
        ]);
        
        $id = $request->id;
        $quantity = $request->quantity ?? 1;
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $request->name,
                'price' => $request->price,
                'image' => $request->image,
                'quantity' => $quantity,
                'unit' => 'bag',
                'weight' => 50 // Assuming 50kg per bag
            ];
        }
        
        Session::put('cart', $cart);
        
        // Always redirect to cart page
        return redirect()->route('cart.view')
            ->with('success', 'Product added to cart successfully!');
    }

       /**
     * Increment cart item quantity
     */
    public function increment(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in to modify cart items.',
                'requires_auth' => true
            ], 401);
        }
        
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
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please sign in to modify cart items.',
                'requires_auth' => true
            ], 401);
        }
        
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
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            
            return redirect()->route('cart.view')
                ->with('success', 'Cart updated successfully');
        }
        
        return redirect()->route('cart.view')
            ->with('error', 'Item not found in cart');
    }
    
    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put('cart', $cart);
            
            return redirect()->route('cart.view')
                ->with('success', 'Item removed from cart');
        }
        
        return redirect()->route('cart.view')
            ->with('error', 'Item not found in cart');
    }
    
    public function clear()
    {
        Session::forget('cart');
        
        return redirect()->route('cart.view')
            ->with('success', 'Cart cleared successfully');
    }
    private function getCartData()
{
    $cart = Session::get('cart', []);
    $total = 0;
    $count = 0;
    
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
        $count += $item['quantity'];
    }
    
    return [
        'count' => $count,
        'total' => $total
    ];
}
}