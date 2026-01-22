<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $djangoUrl = config('services.django.url');
        $endpoint = $djangoUrl . '/api/public/products/';

        try {
            // Make the request to Django API
            $response = Http::withOptions([
                'verify' => false, // skip SSL verification for ngrok HTTPS
                'timeout' => 15,   // set timeout
            ])->get($endpoint);

            if ($response->successful()) {
                $products = collect($response->json());
            } else {
                $products = collect([]);
                Log::warning('Failed to fetch products from Django API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            $products = collect([]);
            Log::error('Error fetching products from Django API', [
                'message' => $e->getMessage(),
            ]);
        }

        // Debug: uncomment if needed
        // dd($products);

        return view('shop.products', [
            'products' => $products,
        ]);
    }
}
