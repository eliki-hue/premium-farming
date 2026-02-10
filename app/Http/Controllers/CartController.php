<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CartController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.django_api.url', 'http://127.0.0.1:8000');
    }

    // Show cart
    public function view(Request $request)
    {
        $token = $this->getToken();
        
        if (!$token) {
            return redirect('/login')->with('error', 'Please login to view your cart.');
        }

        try {
            // Verify token with Django
            $userResponse = Http::withToken($token)->get($this->apiUrl . '/api/auth/me/');
            
            if ($userResponse->status() === 401) {
                // Token expired or invalid
                $this->clearToken();
                return redirect('/login')->with('error', 'Session expired. Please login again.');
            }

            // Get cart items
            $cartResponse = Http::withToken($token)->get($this->apiUrl . '/cart/');
            
            if (!$cartResponse->successful()) {
                return view('shop.cart', [
                    'cart' => [],
                    'error' => 'Unable to fetch cart items.'
                ]);
            }

            $cart = $cartResponse->json();
            return view('shop.cart', compact('cart'));

        } catch (\Exception $e) {
            return view('shop.cart', [
                'cart' => [],
                'error' => 'Unable to connect to server. Please try again.'
            ]);
        }
    }

    // Add item to cart
    public function add(Request $request)
    {
        $token = $this->getToken();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add items to cart.',
                'redirect' => url('/login')
            ], 401);
        }

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            // First verify the token is still valid
            $verifyResponse = Http::withToken($token)->get($this->apiUrl . '/api/auth/me/');
            
            if ($verifyResponse->status() === 401) {
                $this->clearToken();
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.',
                    'redirect' => url('/login')
                ], 401);
            }

            // Add item to cart via Django API
            $response = Http::withToken($token)->post($this->apiUrl . '/cart/items/', [
                'product_id' => $request->id,
                'quantity' => $request->quantity ?? 1,
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully!',
                    'cart_count' => $this->getCartCount($token)
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to server.'
            ], 500);
        }
    }

    // Get cart count for badge
    public function count(Request $request)
    {
        $token = $this->getToken();
        
        if (!$token) {
            return response()->json([
                'success' => true,
                'count' => 0,
                'total' => 0
            ]);
        }

        try {
            $cartResponse = Http::withToken($token)->get($this->apiUrl . '/cart/');
            
            if ($cartResponse->successful()) {
                $cart = $cartResponse->json();
                $count = count($cart['items'] ?? []);
                $total = $cart['subtotal'] ?? 0;
                
                return response()->json([
                    'success' => true,
                    'count' => $count,
                    'total' => $total
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail
        }

        return response()->json([
            'success' => true,
            'count' => 0,
            'total' => 0
        ]);
    }

    // Helper: Get token from session or cookie
    private function getToken()
    {
        return session('django_token') ?? Cookie::get('django_token');
    }

    // Helper: Clear token
    private function clearToken()
    {
        Session::forget('django_token');
        Cookie::queue(Cookie::forget('django_token'));
    }

    // Helper: Get cart count
    private function getCartCount($token)
    {
        try {
            $cartResponse = Http::withToken($token)->get($this->apiUrl . '/cart/');
            if ($cartResponse->successful()) {
                $cart = $cartResponse->json();
                return count($cart['items'] ?? []);
            }
        } catch (\Exception $e) {
            // Ignore
        }
        return 0;
    }
}