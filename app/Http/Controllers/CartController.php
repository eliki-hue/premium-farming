<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Display POS page with current cart
    public function sell()
    {
        $cart = session()->get('cart', []);
        $heldSales = session()->get('held_sales', []);
        return view('pos.sell', compact('cart', 'heldSales'));
    }

    // Add product to cart
   public function add(Request $request)
{
    $cart = session()->get('cart', []);
    $name = $request->name;

    if (isset($cart[$name])) {
        $cart[$name]['quantity'] += $request->quantity ?? 1;
    } else {
        $cart[$name] = [
            'name' => $name,
            'price' => $request->price,
            'quantity' => $request->quantity ?? 1,
            'unit' => $request->unit ?? 'pcs', // ✅ ALWAYS SET
        ];
    }

    session()->put('cart', $cart);
    return back();
}

    // Hold current sale
    public function hold()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->back()->with('error', 'No items to hold.');

        $heldSales = session()->get('held_sales', []);
        $holdId = 'HOLD-' . time();
        $heldSales[$holdId] = [
            'items' => $cart,
            'time' => now()->format('d M Y H:i')
        ];

        session()->put('held_sales', $heldSales);
        session()->forget('cart');

        return redirect()->back()->with('success', 'Sale held successfully.');
    }

    // Resume held sale
    public function resume($holdId)
    {
        $heldSales = session()->get('held_sales', []);
        if(!isset($heldSales[$holdId])) return redirect()->back()->with('error', 'Held sale not found.');

        session(['cart' => $heldSales[$holdId]['items']]);
        unset($heldSales[$holdId]);
        session(['held_sales' => $heldSales]);

        return redirect()->back()->with('success', 'Held sale resumed.');
    }

    // Remove item from cart
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$request->id])) unset($cart[$request->id]);
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item removed.');
    }

    // Clear cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    // Complete sale and generate receipt
   public function complete(Request $request)
{
    $cart = session('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Cart is empty');
    }

    $receipt = [
        'items' => $cart,
        'total' => collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),
        'payment' => $request->payment_method ?? 'Cash',
        'time' => now()->format('Y-m-d H:i'),
    ];

    session([
        'receipt' => $receipt
    ]);

    session()->forget('cart');

    return redirect()->route('pos.receipt');
}


    // Display receipt
    public function receipt()
    {
        $receipt = session()->get('receipt', []);
        if(empty($receipt)) return redirect()->route('pos.sell')->with('error', 'No receipt found.');

        return view('pos.receipt', compact('receipt'));
    }
}
