<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestCartController extends Controller
{
    /**
     * Get guest cart from session
     */
    public function getCart()
    {
        $cart = Session::get('guest_cart', [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0
        ]);
        
        return response()->json($cart);
    }
    
    /**
     * Add item to guest cart
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'product_name' => 'required|string',
            'unit_price' => 'required|numeric'
        ]);
        
        $cart = Session::get('guest_cart', [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $unitPrice = $request->unit_price;
        
        // Check if item already exists
        $found = false;
        foreach ($cart['items'] as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $cart['items'][] = [
                'product_id' => $productId,
                'product_name' => $request->product_name,
                'quantity' => $quantity,
                'unit_price' => $unitPrice
            ];
        }
        
        // Recalculate totals
        $cart['subtotal'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + ($item['quantity'] * $item['unit_price']);
        }, 0);
        
        $cart['total_items'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + $item['quantity'];
        }, 0);
        
        Session::put('guest_cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'message' => 'Item added to cart'
        ]);
    }
    
    /**
     * Update item quantity
     */
    public function updateItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0'
        ]);
        
        $cart = Session::get('guest_cart', [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0
        ]);
        
        foreach ($cart['items'] as &$item) {
            if ($item['product_id'] == $request->product_id) {
                if ($request->quantity <= 0) {
                    // Remove item
                    $cart['items'] = array_filter($cart['items'], function($i) use ($request) {
                        return $i['product_id'] != $request->product_id;
                    });
                } else {
                    $item['quantity'] = $request->quantity;
                }
                break;
            }
        }
        
        // Recalculate totals
        $cart['subtotal'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + ($item['quantity'] * $item['unit_price']);
        }, 0);
        
        $cart['total_items'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + $item['quantity'];
        }, 0);
        
        Session::put('guest_cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
    
    /**
     * Remove item from cart
     */
    public function removeItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);
        
        $cart = Session::get('guest_cart', [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0
        ]);
        
        $cart['items'] = array_filter($cart['items'], function($item) use ($request) {
            return $item['product_id'] != $request->product_id;
        });
        
        // Recalculate totals
        $cart['subtotal'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + ($item['quantity'] * $item['unit_price']);
        }, 0);
        
        $cart['total_items'] = array_reduce($cart['items'], function($sum, $item) {
            return $sum + $item['quantity'];
        }, 0);
        
        Session::put('guest_cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
    
    /**
     * Clear guest cart
     */
    public function clearCart()
    {
        Session::forget('guest_cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared'
        ]);
    }
}