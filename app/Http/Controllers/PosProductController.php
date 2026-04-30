<?php

namespace App\Http\Controllers;
use App\Services\DjangoApiService;


use App\Models\Product;
use App\Models\PosProduct;  // Make sure PosProduct model exists
use Illuminate\Http\Request; 

class PosProductController extends Controller
{
    // ADD THIS INDEX METHOD
    public function index()
    {
        $response = DjangoApiService::client()
            ->get('/api/products/');

        $products = PosProduct::all();  // or Product::all() if using Product model
        return view('products.index', compact('product'));
    }

    public function create() {
        $categories = ['produce', 'feed', 'seeds', 'supplies'];
        return view('products.create', compact('categories'));
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

    public function show(PosProduct $product)  // Laravel auto-injects model by ID
{
    return view('products.show', compact('product'));
}



}
