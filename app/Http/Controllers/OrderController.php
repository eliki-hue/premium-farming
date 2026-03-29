<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $djangoBase = 'http://127.0.0.1:8000';

    /**
     * GET CSRF TOKEN FROM DJANGO
     */
    public function getCsrfToken()
    {
        try {
            $response = Http::withOptions([
                'verify' => false,
            ])->get($this->djangoBase . '/api/ecommerce/csrf-token/');

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Failed to fetch token'
                ], 500);
            }

            return response()->json($response->json())
                ->withHeaders([
                    'Set-Cookie' => $response->header('Set-Cookie')
                ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * CREATE ORDER
     */
    public function createOrder(Request $request)
    {
        try {
            $csrfToken = $request->header('X-CSRFToken');

            if (!$csrfToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSRF token missing'
                ], 400);
            }

            $data = $request->validate([
                'cart_id' => 'required|string',
                'customer_name' => 'required|string',
                'phone_number' => 'required|string'
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-CSRFToken' => $csrfToken,
                'X-Session-ID' => Session::getId()
            ])->post($this->djangoBase . '/api/ecommerce/place-order/', $data);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}