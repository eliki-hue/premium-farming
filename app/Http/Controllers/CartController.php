<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.django_api.url');
    }

    private function token()
    {
        return session('django_token');
    }

    // VIEW CART
    public function view()
    {
        $response = Http::withToken($this->token())
            ->get($this->apiUrl . '/cart/items');

        if ($response->failed()) {
            return response()->json(['items'=>[], 'subtotal'=>0], 500);
        }

        return response()->json($response->json());
    }

    // ADD ITEM
    public function add(Request $request)
    {
        $response = Http::withToken($this->token())
            ->post($this->apiUrl . '/cart/items/', [
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity ?? 1,
            ]);

        if ($response->failed()) {
            return response()->json(['error'=>'Failed to add item'],500);
        }

        return response()->json($response->json());
    }

    // UPDATE ITEM
    public function update(Request $request)
    {
        $response = Http::withToken($this->token())
            ->patch($this->apiUrl . '/cart/items/update/', [
                'product'  => $request->product,
                'quantity' => max(1,(int)$request->quantity),
            ]);

        return response()->json($response->json());
    }

    // REMOVE ITEM
    public function remove(Request $request)
    {
        $response = Http::withToken($this->token())
            ->delete($this->apiUrl . '/cart/items/remove/', [
                'product' => $request->product
            ]);

        return response()->json($response->json());
    }

    // CHECKOUT
    public function checkout()
    {
        $response = Http::withToken($this->token())
            ->post($this->apiUrl . '/checkout/mpesa/');

        return response()->json($response->json());
    }
}
