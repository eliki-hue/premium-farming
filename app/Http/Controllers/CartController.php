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

    // View cart
    public function view()
    {
        $cartData = $this->service->getCart();
        return view('shop.cart', compact('cartData'));
    }

    // Add item
  public function add(Request $request, DjangoCartService $cart)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);

        $response = $cart->add(
            $request->product_id,
            $request->quantity
        );

        return response()->json($response);
    }

    // Update item
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        if ($request->quantity == 0) {
            $this->service->removeItem($itemId);
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        $result = $this->service->updateItem($itemId, $request->quantity);

        if ($result) {
            return redirect()->back()->with('success', 'Cart updated!');
        }

        return redirect()->back()->with('error', 'Failed to update cart.');
    }

    // Remove item
    public function remove($itemId)
    {
        $removed = $this->service->removeItem($itemId);

        if ($removed) {
            return redirect()->back()->with('success', 'Item removed.');
        }

        return redirect()->back()->with('error', 'Failed to remove item.');
    }
}
