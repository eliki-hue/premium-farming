<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STATIC FEED PRODUCTS (Pig, Pet, Poultry, By-products)
    |--------------------------------------------------------------------------
    */
    private function staticProducts()
    {
        return [
            // 🐖 Pig Feeds
            [
                'id' => 1,
                'name' => 'Pig Starter Pellets',
                'price' => 2500,
                'image' => 'images/pig-starter.jpg',
                'category' => 'pig',
                'badge' => 'Starter Feed'
            ],
            [
                'id' => 2,
                'name' => 'Pig Grower Mash',
                'price' => 2450,
                'image' => 'images/pig-grower.jpg',
                'category' => 'pig',
                'badge' => 'Grower Feed'
            ],

            // 🐶 Pet Feeds
            [
                'id' => 3,
                'name' => 'Dog Meal',
                'price' => 2200,
                'image' => 'images/dog-meal.jpg',
                'category' => 'pet',
                'badge' => 'Pet Feed'
            ],
            [
                'id' => 4,
                'name' => 'Rabbit Pellets',
                'price' => 2000,
                'image' => 'images/rabbit.jpg',
                'category' => 'pet',
                'badge' => 'Pet Feed'
            ],

            // 🐔 Poultry Feeds
            [
                'id' => 5,
                'name' => 'Layers Mash',
                'price' => 1800,
                'image' => 'images/layers.jpg',
                'category' => 'poultry',
                'badge' => 'Best for Eggs'
            ],

            // 🌾 By-products
            [
                'id' => 6,
                'name' => 'Wheat Bran',
                'price' => 1300,
                'image' => 'images/bran.jpg',
                'category' => 'byproduct',
                'badge' => 'High Fiber'
            ],
            [
                'id' => 7,
                'name' => 'Wheat Pollard',
                'price' => 1500,
                'image' => 'images/pollard.jpg',
                'category' => 'byproduct',
                'badge' => 'Balanced Energy'
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | ALL FEEDS PAGE (Pig + Pet + Poultry + By-products)
    |--------------------------------------------------------------------------
    */
    public function Products()
    {
        session(['shopping_url' => url()->current()]);

        return view('shop.products', [
            'products' => $this->staticProducts(),
            'mode' => 'feeds'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CATEGORY PAGES (Pig / Pet / Poultry / By-product)
    |--------------------------------------------------------------------------
    */
    public function category($type)
    {
        session(['shopping_url' => url()->current()]);

        $products = collect($this->staticProducts())
            ->where('category', $type)
            ->values();

        return view('shop.products', [
            'products' => $products,
            'category' => $type,
            'mode' => 'feeds'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATABASE SHOP (Existing functionality – untouched)
    |--------------------------------------------------------------------------
    */

    // Online shop index (DB products)
public function index()
{
    // Public access to all products
    $products = Product::where('status', 'active')->paginate(20);
    
    return view('products.index', compact('products'));
}

    // Single DB product
   public function show(Product $product)
{
    // Public access to single product
    return view('products.show', compact('product'));
}

    /*
    |--------------------------------------------------------------------------
    | ORDERS, CUSTOMERS, REPORTS (UNCHANGED)
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        $orders = Order::with('customer')->latest()->get();
        $customers = Customer::with('orders')->get();

        return view('shop.orders', compact('orders', 'customers'));
    }

    public function customers()
    {
        $customers = Customer::latest()->get();
        return view('shop.customers', compact('customers'));
    }

    public function reports()
    {
        $totalSales = Order::sum('total');
        $totalOrders = Order::count();
        $totalCustomers = Customer::count();

        return view('shop.reports', compact(
            'totalSales',
            'totalOrders',
            'totalCustomers'
        ))->with('mode', 'shop');
    }
}
