<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    private function djangoHeaders()
    {
        $token = session('django_token');

        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ];
    }

    /* =========================
       CART PAGE
    ========================== */
   public function view()
{
    return view('shop.cart');
}


    /* =========================
       LOAD CART
    ========================== */
    public function load()
    {
        $response = Http::withHeaders($this->djangoHeaders())
            ->get(config('services.django_api.url') . '/api/ecommerce/cart/');

        return response()->json($response->json(), $response->status());
    }

    /* =========================
       ADD ITEM
    ========================== */
    public function add(Request $request)
    {
        $response = Http::withHeaders($this->djangoHeaders())
            ->post(config('services.django_api.url') . '/api/ecommerce/cart/items/', [
                'product' => $request->product,
                'quantity' => $request->quantity,
            ]);

        return response()->json($response->json(), $response->status());
    }

    /* =========================
       UPDATE ITEM
    ========================== */
    public function update(Request $request)
    {
        $response = Http::withHeaders($this->djangoHeaders())
            ->patch(config('services.django_api.url') . '/api/ecommerce/cart/items/update/', [
                'product' => $request->product,
                'quantity' => $request->quantity,
            ]);

        return response()->json($response->json(), $response->status());
    }

    /* =========================
       REMOVE ITEM
    ========================== */
    public function remove(Request $request)
    {
        $response = Http::withHeaders($this->djangoHeaders())
            ->send('DELETE',
                config('services.django_api.url') . '/api/ecommerce/cart/items/remove/',
                [
                    'json' => [
                        'product' => $request->product
                    ]
                ]
            );

        return response()->json($response->json(), $response->status());
    }

    /* =========================
       CHECKOUT
    ========================== */
    public function checkout()
    {
        $response = Http::withHeaders($this->djangoHeaders())
            ->post(config('services.django_api.url') . '/api/ecommerce/cart/checkout/');

        return response()->json($response->json(), $response->status());
    }
}
