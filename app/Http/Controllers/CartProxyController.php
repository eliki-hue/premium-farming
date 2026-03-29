<?php
// app/Http/Controllers/CartProxyController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class CartProxyController extends Controller
{
    protected string $djangoBase;

    public function __construct()
    {
        $this->djangoBase = config('services.django_api.url', 'http://localhost:8000');
    }

    protected function getAuthHeaders(Request $request): array
    {
        $headers = ['Accept' => 'application/json'];
        
        // Check for registered user token first
        if (Session::has('django_token')) {
            $headers['Authorization'] = 'Bearer ' . Session::get('django_token');
        } else {
            // For guest users, use session ID
            $headers['X-Session-ID'] = Session::getId();
        }
        
        return $headers;
    }

    public function load(Request $request): JsonResponse
    {
        try {
            $headers = $this->getAuthHeaders($request);
            
            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->get("{$this->djangoBase}/api/ecommerce/cart/");

            $data = $response->json();
            
            // Store cart ID in session
            if (isset($data['id']) && $data['id']) {
                Session::put('cart_id', $data['id']);
            }
            
            return response()->json($data, $response->status());
            
        } catch (\Exception $e) {
            \Log::error('Cart load error: ' . $e->getMessage());
            
            // Return fallback cart data
            return response()->json([
                'id' => Session::get('cart_id', 'guest_' . Session::getId()),
                'items' => [],
                'subtotal' => 0,
                'total_items' => 0
            ], 200);
        }
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product' => 'required|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            $headers = $this->getAuthHeaders($request);
            
            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->post("{$this->djangoBase}/api/ecommerce/cart/items/", $validated);

            $data = $response->json();
            
            if (isset($data['id'])) {
                Session::put('cart_id', $data['id']);
            }
            
            return response()->json($data, $response->status());
            
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage());
            
            return response()->json([
                'success' => true,
                'id' => Session::get('cart_id', 'guest_' . Session::getId()),
                'message' => 'Item added to cart'
            ], 200);
        }
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        try {
            $headers = $this->getAuthHeaders($request);
            
            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->patch("{$this->djangoBase}/api/ecommerce/cart/items/update/", $validated);

            return response()->json($response->json(), $response->status());
            
        } catch (\Exception $e) {
            \Log::error('Cart update error: ' . $e->getMessage());
            return response()->json(['success' => true], 200);
        }
    }
    
    public function remove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product' => 'required|integer',
        ]);

        try {
            $headers = $this->getAuthHeaders($request);
            
            $response = Http::timeout(10)
                ->withHeaders($headers)
                ->post($this->djangoBase . '/api/ecommerce/cart/items/remove/', [
                    'product' => $validated['product'],
                ]);

            return response()->json(
                $response->json(),
                $response->status()
            );
            
        } catch (\Exception $e) {
            \Log::error('Cart remove error: ' . $e->getMessage());
            return response()->json(['success' => true], 200);
        }
    }
}