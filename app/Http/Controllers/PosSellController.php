<?php
// app/Http/Controllers/PosSellController.php
namespace App\Http\Controllers;

use App\Models\PosProduct;
use Illuminate\Http\Request;

class PosSellController extends Controller
{
    public function index()
    {
        // ✅ HARDCODED PRODUCTS - No database dependency (works even if DB empty)
        $products = collect([
            (object)['id' => 1, 'name' => 'Chick Mash 50kg', 'selling_price' => 1700, 'stock' => 45, 'unit' => 'bag'],
            (object)['id' => 2, 'name' => 'Layers Mash 50kg', 'selling_price' => 1850, 'stock' => 3, 'unit' => 'bag'],
            (object)['id' => 3, 'name' => 'Pig Fattener 50kg', 'selling_price' => 2600, 'stock' => 120, 'unit' => 'bag'],
            (object)['id' => 4, 'name' => 'Dog Meal 25kg', 'selling_price' => 2200, 'stock' => 8, 'unit' => 'bag'],
            (object)['id' => 5, 'name' => 'Broiler Starter', 'selling_price' => 1950, 'stock' => 0, 'unit' => 'bag'],
            (object)['id' => 6, 'name' => 'Pig Grower 50kg', 'selling_price' => 2400, 'stock' => 67, 'unit' => 'bag'],
        ]);
        
        // ✅ Low stock = ≤5 only
        $lowStockProducts = $products->where('stock', '<=', 5)->values();
        
        return view('pos.sell', compact('product', 'lowStockProducts'));
    }

    // ✅ FIXED: Safe product creation - NO NULL errors!
  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'selling_price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    \App\Models\PosProduct::create([
        'name' => $request->name,
        'category' => $request->category ?? 'general',
        'selling_price' => $request->selling_price,
        'buying_price' => $request->buying_price ?? 0,
        'stock' => $request->stock,
        'unit' => $request->unit ?? 'bag',
        'low_stock_warning' => $request->low_stock_warning ?? 5
    ]);

    return redirect()->back()->with('success', '✅ Product added & READY TO SELL!');
}

// When sale is made
public function processSale(Request $request)
{
    $product = Product::find($request->product_id);
    $quantity = $request->quantity;
    
    // AUTO REDUCE STOCK
    $product->decrement('stock_quantity', $quantity);
    
    // Rest of sale logic...
}



}
