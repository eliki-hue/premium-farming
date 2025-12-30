<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // ========================================
    // COMMON CART METHODS (POS + SHOP)
    // ========================================
    
    public function index()
    {
        $cart = session()->get('cart', []);
        $heldSales = session()->get('held_sales', []);
        return view('cart.index', compact('cart', 'heldSales'));
    }
    
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id ?? $request->name; // Flexible ID/Name
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$id] = [
                'id' => $request->id ?? null,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity ?? 1,
                'unit' => $request->unit ?? 'pcs',
                'image' => $request->image ?? null,
            ];
        }
        
        session()->put('cart', $cart);
        
        // POS: back to sell page | SHOP: back to products
        return $request->has('pos') 
            ? back()->with('success', 'Item added to POS!')
            : back()->with('success', 'Item added to cart!');
    }
    
    public function remove(Request $request)
    {
        $id = $request->id ?? $request->name;
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item removed.');
    }
    
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }
    
    public function increment(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }
    
    public function decrement(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }
    
    public function update(Request $request)
    {
        $id = $request->id;
        $quantity = max(1, $request->quantity);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }

    // ========================================
    // POS SPECIFIC METHODS
    // ========================================
    
    public function sell()
    {
        $cart = session()->get('cart', []);
        $heldSales = session()->get('held_sales', []);
        return view('pos.sell', compact('cart', 'heldSales'));
    }
    
    public function discount(Request $request)
    {
        $request->validate(['discount' => 'required|numeric|min:0']);
        session(['discount' => $request->discount]);
        return redirect()->back()->with('success', 'Discount applied!');
    }
    
    public function hold()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return back()->with('error', 'No items to hold.');
        
        $heldSales = session()->get('held_sales', []);
        $holdId = 'HOLD-' . time();
        $heldSales[$holdId] = [
            'items' => $cart,
            'time' => now()->format('d M Y H:i')
        ];
        
        session()->put('held_sales', $heldSales);
        session()->forget('cart');
        return back()->with('success', 'Sale held successfully.');
    }
    
    public function resume($holdId)
    {
        $heldSales = session()->get('held_sales', []);
        if (!isset($heldSales[$holdId])) {
            return back()->with('error', 'Held sale not found.');
        }
        
        session(['cart' => $heldSales[$holdId]['items']]);
        unset($heldSales[$holdId]);
        session(['held_sales' => $heldSales]);
        return back()->with('success', 'Held sale resumed.');
    }
    
    public function complete(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) return back()->with('error', 'Cart is empty!');
        
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = $request->discount ?? session('discount', 0);
        $vat = round((($subtotal - $discount) * 16 / 100));
        $grandTotal = ($subtotal - $discount) + $vat;
        $amountPaid = $request->amount_paid ?? 0;
        $change = $amountPaid - $grandTotal;
        
        $receipt = [
            'order_id' => 'ORD' . time(),
            'date' => now()->format('d/m/Y'),
            'time' => now()->format('H:i'),
            'cashier' => auth()->user()->name ?? 'Guest',
            'payment_method' => $request->payment_method ?? 'Cash',
            'items' => array_values($cart),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'vat' => $vat,
            'grand_total' => $grandTotal,
            'amount_paid' => $amountPaid,
            'change' => $change > 0 ? $change : 0,
            'phone' => $request->phone ?? null
        ];
        
        session(['receipts.' . $receipt['order_id'] => $receipt]);
        session(['receipt' => $receipt]);
        session()->forget('cart');
        
        return back()->with('success', 'Sale completed! Receipt ready.');
    }
    
    public function printReceipt($order_id)
    {
        $receipt = session('receipts.' . $order_id) ?? null;
        if (!$receipt) return redirect('/pos/sell')->with('error', 'Receipt not found!');
        return view('pos.receipt', compact('receipt'));
    }
}
