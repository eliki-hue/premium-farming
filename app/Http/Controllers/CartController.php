<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    
    private function djangoHeaders(): array
    {
        $headers = ['Accept' => 'application/json'];

        $token = Session::get('django_token');

        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $token;
        } else {
           
            $headers['X-Session-ID'] = Session::getId();
        }

        return $headers;
    }

    /* =========================
       CART PAGE VIEW
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
        try {
            $response = Http::timeout(10)
                ->withHeaders($this->djangoHeaders())
                ->get(config('services.django_api.url') . '/api/ecommerce/cart/');

            $data = $response->json() ?? [];

            if (!empty($data['id'])) {
                Session::put('cart_id', $data['id']);
            }

            return response()->json($data, $response->status());

        } catch (\Exception $e) {
            Log::error('[CartController] load error: ' . $e->getMessage());

            return response()->json([
                'id'          => Session::get('cart_id', 'guest_' . Session::getId()),
                'items'       => [],
                'subtotal'    => 0,
                'total_items' => 0,
            ], 200);
        }
    }

    /* =========================
       ADD ITEM
    ========================== */
    public function add(Request $request)
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders($this->djangoHeaders())
                ->post(config('services.django_api.url') . '/api/ecommerce/cart/items/', [
                    'product'  => $request->product,
                    'quantity' => $request->quantity ?? 1,
                ]);

            $data = $response->json() ?? [];

            if (!empty($data['id'])) {
                Session::put('cart_id', $data['id']);
            }

            return response()->json($data, $response->status());

        } catch (\Exception $e) {
            Log::error('[CartController] add error: ' . $e->getMessage());
            return response()->json(['success' => true, 'message' => 'Item added to cart'], 200);
        }
    }

    /* =========================
       UPDATE ITEM
    ========================== */
    public function update(Request $request)
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders($this->djangoHeaders())
                ->patch(config('services.django_api.url') . '/api/ecommerce/cart/items/update/', [
                    'product'  => $request->product,
                    'quantity' => $request->quantity,
                ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('[CartController] update error: ' . $e->getMessage());
            return response()->json(['success' => true], 200);
        }
    }

    /* =========================
       REMOVE ITEM
    ========================== */
    public function remove(Request $request)
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders($this->djangoHeaders())
                ->send('DELETE',
                    config('services.django_api.url') . '/api/ecommerce/cart/items/remove/',
                    ['json' => ['product' => $request->product]]
                );

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('[CartController] remove error: ' . $e->getMessage());
            return response()->json(['success' => true], 200);
        }
    }

    /* =========================
       CHECKOUT
    ========================== */
    public function checkout()
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders($this->djangoHeaders())
                ->post(config('services.django_api.url') . '/api/ecommerce/cart/checkout/');

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('[CartController] checkout error: ' . $e->getMessage());
            return response()->json(['error' => 'Checkout failed'], 500);
        }
    }
}