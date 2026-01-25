<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }

    public function order()
{
    return view('shop.order');
}
public function products()
{
    try {
        $products = DjangoApiService::getProducts();
        
        if ($products->isEmpty()) {
            // Try one more time with fresh authentication
            Cache::forget('django_api_token');
            Cache::forget('django_api_refresh_token');
            $products = DjangoApiService::getProducts();
        }
        
        $groupedProducts = [
            'pig' => $products->where('category', 'pig')->values(),
            'poultry' => $products->where('category', 'poultry')->values(),
            'pet' => $products->where('category', 'pet')->values(),
            'byproduct' => $products->where('category', 'byproduct')->values(),
        ];
        
        return view('shop.products', compact('products', 'groupedProducts'));
        
    } catch (\Exception $e) {
        \Log::error('Django API Error in ShopController: ' . $e->getMessage());
        
        return view('shop.products', [
            'products' => collect([]),
            'groupedProducts' => [],
            'error' => 'Products temporarily unavailable. Please try again in a moment.'
        ]);
    }
}

}
