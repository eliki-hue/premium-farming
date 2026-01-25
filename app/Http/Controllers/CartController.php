<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DjangoEcommerceService;

class CartController extends Controller
{
    protected $service;

    public function __construct(DjangoEcommerceService $service)
    {
        $this->service = $service;
    }

    /**
     * View cart
     */
    public function view()
    {
        $cartData = $this->service->getCart();
        return view('shop.cart', compact('cartData'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $result = $this->service->addItem($request->product_id, $request->quantity);

        if ($result) {
            return redirect()->route('cart.view')->with('success', 'Item added to cart successfully!');
        }

        return redirect()->back()->with('error', 'Failed to add item to cart. Please try again.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        // If quantity is 0, remove the item
        if ($request->quantity == 0) {
            $removed = $this->service->removeItem($itemId);
            
            if ($removed) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item removed from cart'
                    ]);
                }
                return redirect()->back()->with('success', 'Item removed from cart.');
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove item'
                ], 400);
            }
            return redirect()->back()->with('error', 'Failed to remove item.');
        }

        // Update quantity
        $result = $this->service->updateItem($itemId, $request->quantity);

        if ($result) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully'
                ]);
            }
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart'
            ], 400);
        }
        return redirect()->back()->with('error', 'Failed to update cart.');
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $removed = $this->service->removeItem($itemId);

        if ($removed) {
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Failed to remove item.');
    }

    /**
     * Get cart count (for navbar badge)
     */
    public function count()
    {
        $cartData = $this->service->getCart();
        $count = isset($cartData['items']) ? count($cartData['items']) : 0;
        
        return response()->json(['count' => $count]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $cleared = $this->service->clearCart();
        
        if ($cleared) {
            return redirect()->route('products')->with('success', 'Cart cleared successfully.');
        }
        
        return redirect()->back()->with('error', 'Failed to clear cart.');
    }
}