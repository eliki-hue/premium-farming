<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.django_api.url');
    }

    public function view()
    {
        if (!session('django_token')) {
            return redirect('/login');
        }

        return view('shop.cart');
    }

    private function token()
    {
        return session('django_token');
    }

    public function load()
    {
        return Http::withToken($this->token())
            ->get($this->apiUrl . '/cart/')
            ->json();
    }

    public function update(Request $request)
    {
        return Http::withToken($this->token())
            ->patch($this->apiUrl . '/cart/items/update/', [
                'product' => $request->product,
                'quantity' => max(1, (int)$request->quantity),
            ])->json();
    }

    public function remove(Request $request)
    {
        return Http::withToken($this->token())
            ->delete($this->apiUrl . '/cart/items/remove/', [
                'product' => $request->product
            ])->json();
    }

    public function checkout()
    {
        return Http::withToken($this->token())
            ->post($this->apiUrl . '/checkout/mpesa/')
            ->json();
    }
}
