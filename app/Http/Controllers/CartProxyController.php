<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartProxyController extends Controller
{
    private $base = 'https://unmisanthropically-transcultural-minnie.ngrok-free.dev/api/ecommerce/cart';

    // Always send JWT token from session
    private function headers()
    {
        $headers = ['Accept' => 'application/json'];

        if (session()->has('django_token')) {
            $headers['Authorization'] = 'Bearer ' . session('django_token');
        }

        return $headers;
    }

    // GET /proxy/cart
    public function load()
    {
        $res = Http::withHeaders($this->headers())
            ->get($this->base . '/');

        return response()->json($res->json(), $res->status());
    }

    // POST /proxy/cart/add
   public function add(Request $request)
{
    $res = Http::withHeaders([
        'Accept'        => 'application/json',
        'Authorization' => 'Bearer ' . session('django_token'),
    ])->post(
        config('services.django_api.url') . '/api/ecommerce/cart/items/',
        [
            'product'  => $request->product,
            'quantity' => $request->quantity,
        ]
    );

    return response()->json($res->json(), $res->status());
}


    // PATCH /proxy/cart/update
    public function update(Request $request)
    {
        $res = Http::withHeaders($this->headers())
            ->patch($this->base . '/items/update/', [
                'product' => $request->product,
                'quantity' => $request->quantity,
            ]);

        return response()->json($res->json(), $res->status());
    }

    // DELETE /proxy/cart/remove
    public function remove(Request $request)
    {
        $res = Http::withHeaders($this->headers())
            ->delete($this->base . '/items/remove/', [
                'product' => $request->product,
            ]);

        return response()->json($res->json(), $res->status());
    }
}
