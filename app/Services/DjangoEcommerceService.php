<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class DjangoEcommerceService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.django_api.url');
    }

    protected function client()
    {
        $sessionCookie = Cookie::get('django_session'); // Make sure your Django session cookie is set
        return Http::withHeaders([
            'Cookie' => 'sessionid=' . $sessionCookie,
        ])->withOptions([
            'verify' => false, // disable SSL verification if testing locally
        ]);
    }

    // Get current cart
    public function getCart()
    {
        try {
            $response = $this->client()
                ->get($this->baseUrl . '/api/ecommerce/cart/');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Get cart failed', ['status' => $response->status(), 'body' => $response->body()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Get cart exception: ' . $e->getMessage());
            return [];
        }
    }

    // Add item to cart
    public function addItem($productId, $quantity)
    {
        try {
            $response = $this->client()
                ->post($this->baseUrl . '/api/ecommerce/cart/items/', [
                    'product' => $productId,
                    'quantity' => $quantity,
                ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Add item error: ' . $e->getMessage());
            return null;
        }
    }

    // Update item quantity
    public function updateItem($itemId, $quantity)
    {
        try {
            $response = $this->client()
                ->patch($this->baseUrl . "/api/ecommerce/cart/items/{$itemId}/", [
                    'quantity' => $quantity,
                ]);

            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Update item error: ' . $e->getMessage());
            return null;
        }
    }

    // Remove item from cart (optional)
    public function removeItem($itemId)
    {
        try {
            $response = $this->client()
                ->delete($this->baseUrl . "/api/ecommerce/cart/items/{$itemId}/");

            return $response->successful() ? true : false;
        } catch (\Exception $e) {
            Log::error('Remove item error: ' . $e->getMessage());
            return false;
        }
    }
}
