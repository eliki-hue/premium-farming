<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EnsureGuestCart
{
    public function handle(Request $request, Closure $next)
    {
        // Check if we have a cart ID
        if (!Session::has('cart_id')) {
            try {
                $djangoUrl = config('services.django_api.url', 'http://localhost:8000');
                
                $headers = [
                    'Accept' => 'application/json',
                    'X-Session-ID' => Session::getId()
                ];
                
                // Try to get or create cart
                $response = Http::timeout(10)
                    ->withHeaders($headers)
                    ->get($djangoUrl . '/api/ecommerce/cart/');
                
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['id'])) {
                        Session::put('cart_id', $data['id']);
                    }
                } else {
                    // Create new cart
                    $createResponse = Http::timeout(10)
                        ->withHeaders($headers)
                        ->post($djangoUrl . '/api/ecommerce/cart/', []);
                    
                    if ($createResponse->successful()) {
                        $newCart = $createResponse->json();
                        if (isset($newCart['id'])) {
                            Session::put('cart_id', $newCart['id']);
                        }
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to create cart: ' . $e->getMessage());
                Session::put('cart_id', 'guest_' . Session::getId());
            }
        }
        
        return $next($request);
    }
}