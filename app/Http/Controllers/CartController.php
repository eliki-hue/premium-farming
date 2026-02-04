<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
   
    private function getDjangoConfig()
    {
        return [
            'url' => config('services.django.url'),
            'domain' => config('services.django.domain', parse_url(config('services.django.url'), PHP_URL_HOST)),
        ];
    }


    private function attachDjangoCookies($djangoResponse, $laravelResponse)
    {
        $cookies = $djangoResponse->cookies();
        
        foreach ($cookies as $cookie) {
            $laravelResponse->withCookie(cookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime() ? ($cookie->getExpiresTime() - time()) / 60 : 60, 
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->getSecure(),
                $cookie->getHttpOnly(),
                false, 
                $cookie->getSameSite()
            ));
        }
        
        return $laravelResponse;
    }

   
    public function index(Request $request)
    {
        $config = $this->getDjangoConfig();

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])->withCookies(
                $request->cookies->all(),
                $config['domain']
            )->get($config['url'] . '/api/ecommerce/cart/');

            if ($response->successful()) {
                $cart = $response->json();
            } else {
                $cart = [
                    'items' => [],
                    'total' => 0,
                    'subtotal' => 0,
                    'item_count' => 0,
                ];
                Log::warning('Failed to fetch cart from Django', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
            
            $viewResponse = response()->view('shop.cart', ['cart' => $cart]);

            return $this->attachDjangoCookies($response, $viewResponse);

        } catch (\Throwable $e) {
            Log::error('Error fetching cart from Django', [
                'message' => $e->getMessage(),
            ]);
            
            return view('shop.cart', ['cart' => [
                'items' => [], 'total' => 0, 'subtotal' => 0, 'item_count' => 0
            ]]);
        }
    }

   
    public function getCart(Request $request)
    {
        $config = $this->getDjangoConfig();

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])->withCookies(
                $request->cookies->all(),
                $config['domain']
            )->get($config['url'] . '/api/ecommerce/cart/');

            $jsonData = $response->successful() ? $response->json() : [
                'items' => [], 'total' => 0, 'subtotal' => 0, 'item_count' => 0,
            ];

            $jsonResponse = response()->json($jsonData);

            return $this->attachDjangoCookies($response, $jsonResponse);

        } catch (\Throwable $e) {
            Log::error('Error fetching cart', ['message' => $e->getMessage()]);
            return response()->json([
                'items' => [], 'total' => 0, 'subtotal' => 0, 'item_count' => 0,
            ]);
        }
    }

   
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $config = $this->getDjangoConfig();

        $csrfToken = $request->cookie('csrftoken'); 

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])
            ->withCookies($request->cookies->all(), $config['domain']) 
            ->withHeaders([
                'X-CSRFToken' => $csrfToken, 
                'Referer' => $config['url']
            ])
            ->post($config['url'] . '/api/ecommerce/cart/items/', [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            if ($response->successful()) {
                $jsonResponse = response()->json([
                    'success' => true,
                    'message' => 'Item added to cart',
                    'cart' => $response->json(),
                    'redirect' => route('cart.view'),
                ]);
                
                return $this->attachDjangoCookies($response, $jsonResponse);

            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $errorData['detail'] ?? 'Failed to add item to cart';

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'debug_status' => $response->status() 
                ], $response->status());
            }
        } catch (\Throwable $e) {
            Log::error('Error adding to cart', [
                'message' => $e->getMessage(),
                'product_id' => $request->product_id,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error adding item to cart. Please try again.',
            ], 500);
        }
    }

   
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $config = $this->getDjangoConfig();
        $csrfToken = $request->cookie('csrftoken');

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])
            ->withCookies($request->cookies->all(), $config['domain'])
            ->withHeaders([
                'X-CSRFToken' => $csrfToken, 
                'Referer' => $config['url']
            ])
            ->patch($config['url'] . '/api/ecommerce/cart/items/', [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            if ($response->successful()) {
                $jsonResponse = response()->json([
                    'success' => true,
                    'message' => 'Cart updated',
                    'cart' => $response->json(),
                ]);
                return $this->attachDjangoCookies($response, $jsonResponse);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message'] ?? 'Failed to update cart',
                ], $response->status());
            }
        } catch (\Throwable $e) {
            Log::error('Error updating cart', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error updating cart'], 500);
        }
    }

    
    public function remove(Request $request, $productId)
    {
        $config = $this->getDjangoConfig();
        $csrfToken = $request->cookie('csrftoken');

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 15,
            ])
            ->withCookies($request->cookies->all(), $config['domain'])
            ->withHeaders([
                'X-CSRFToken' => $csrfToken, 
                'Referer' => $config['url']
            ])
            ->delete($config['url'] . "/api/ecommerce/cart/items/{$productId}/");

            if ($response->successful()) {
                $jsonResponse = response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart',
                    'cart' => $response->json(),
                ]);
                return $this->attachDjangoCookies($response, $jsonResponse);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response->json()['message'] ?? 'Failed to remove item',
                ], $response->status());
            }
        } catch (\Throwable $e) {
            Log::error('Error removing from cart', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Error removing item from cart'], 500);
        }
    }
}