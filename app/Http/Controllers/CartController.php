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
public function view()
    {
        $token = session('django_token');

        $response = Http::withToken($token)
            ->get(config('services.django_api.url') . '/cart/');

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to load cart'], 500);
        }

        return response()->json($response->json());
    }

    // ADD ITEM
   public function add(Request $request)
    {
        $token = session('django_token');

        $response = Http::withToken($token)
            ->post(config('services.django_api.url') . '/cart/items/', [
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to add item'], 500);
        }

        return response()->json($response->json());
    }

    // UPDATE ITEM
    public function update(Request $request)
    {
        try {
            $response = Http::withToken($this->token())
                ->patch($this->apiUrl . '/cart/items/update/', [
                    'product' => $request->product,
                    'quantity' => max(1, (int)$request->quantity),
                ]);
            return response()->json($response->json() ?: ['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // REMOVE ITEM
    public function remove(Request $request)
    {
        try {
            $response = Http::withToken($this->token())
                ->delete($this->apiUrl . '/cart/items/remove/', [
                    'product' => $request->product
                ]);
            return response()->json($response->json() ?: ['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // CHECKOUT
    public function checkout()
    {
        try {
            $response = Http::withToken($this->token())
                ->post($this->apiUrl . '/checkout/mpesa/');
            return response()->json($response->json() ?: ['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // LOAD CART
    public function load()
    {
        try {
            $response = Http::withToken($this->token())
                ->get($this->apiUrl . '/cart/');
            $data = $response->json() ?: ['items' => [], 'subtotal' => 0];
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['items' => [], 'subtotal' => 0, 'error' => $e->getMessage()]);
        }
    }
}
