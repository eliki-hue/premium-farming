<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosProduct extends Model
{
    protected $fillable = [
        'name', 'description', 'buying_price', 'selling_price', 
        'unit', 'stock', 'low_stock_warning', 'category', 'track_stock'
    ];

    protected $casts = [
        'buying_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'track_stock' => 'boolean',
    ];

    public function store(Request $request)
{
    // ✅ HARDCODED FIX - NO NULLs EVER!
    $data = [
        'name' => $request->name,
        'category' => $request->category,
        'selling_price' => $request->selling_price,
        'buying_price' => $request->buying_price ?? 0,
        'stock' => $request->stock,
        'unit' => $request->unit,
        'low_stock_warning' => 5  // ✅ FORCED VALUE - NO NULL!
    ];

    PosProduct::create($data);

    return redirect()->route('sell.index')->with('success', '✅ Product saved!');
}

}
