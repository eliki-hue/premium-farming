<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // <-- THIS IS REQUIRED
use App\Services\DjangoApiService;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
public function index()
{
    try {
        $response = Http::get(config('services.django_api.url') . '/products/');

        // DEBUG: Dump response
        if (!$response->successful()) {
            dd($response->status(), $response->body());
        }

        $products = $response->json()['data'] ?? [];
        $groupedProducts = ['uncategorized' => $products];

        return view('shop.products', compact('groupedProducts'));
    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getTraceAsString());
    }
}

    /**
     * Test Django API connection.
     */
    public function testConnection()
    {
        try {
            $token = DjangoApiService::getToken();

            if ($token) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully connected to Django API',
                    'token_obtained' => true,
                    'token_preview' => substr($token, 0, 20) . '...'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to obtain token from Django API'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage(),
                'config' => [
                    'url' => config('services.django_api.url'),
                    'username_configured' => !empty(config('services.django_api.username')),
                    'password_configured' => !empty(config('services.django_api.password'))
                ]
            ], 500);
        }
    }
}
