<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversionController extends Controller
{
    // Show conversion page
    public function index()
    {
        // Dummy products with quantity in KG
        $products = [
            ['name' => 'Maize Germ', 'quantity' => session('products.Maize Germ.quantity', 12)],
            ['name' => 'Chick Mash', 'quantity' => session('products.Chick Mash.quantity', 20)],
            ['name' => 'Growers Mash', 'quantity' => session('products.Growers Mash.quantity', 15)],
        ];

        return view('pos.conversion', compact('products'));
    }

    // Handle conversion and add to POS cart
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'bag_weight' => 'required|numeric|min:1',
            'bags' => 'required|numeric|min:1',
        ]);

        $productName = $request->product_name;
        $totalKg = $request->bag_weight * $request->bags;

        // Update dummy product quantity in session
        $products = session('products', []);
        $currentQty = $products[$productName]['quantity'] ?? 0;
        $products[$productName]['quantity'] = $currentQty + $totalKg;
        session(['products' => $products]);

        // Add to cart session
        $cart = session('cart', []);
        if (isset($cart[$productName])) {
            $cart[$productName]['quantity'] += $totalKg;
        } else {
            $cart[$productName] = [
                'name' => $productName,
                'quantity' => $totalKg,
                'unit' => 'kg',
                'price' => 0, // price can be set manually in POS
            ];
        }
        session(['cart' => $cart]);

        return back()->with('success', "{$totalKg}kg of {$productName} added to POS cart.");
    }
}
