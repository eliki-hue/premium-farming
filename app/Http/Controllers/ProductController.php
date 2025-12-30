<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request; 

class ProductController extends Controller
{
public function index()
{
    $products = Product::orderBy('created_at', 'desc')->paginate(10);

    return view('products.index', compact('products'));
}



    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

     public function create()
    {
        return view('products.create');
    }

public function stores()
    {
        $products = Product::with('category')->orderBy('stock_quantity', 'asc')->get();
        $lowStock = $products->where('stock_quantity', '<=', 20)->count();
        
        return view('pos.stores', compact('products', 'lowStock'));
    }
    
    public function sell()
    {
        // Your POS sell logic
        return view('pos.sell');
    }
}
