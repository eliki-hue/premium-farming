<?php
// app/Http/Controllers/DebugController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    public function productsDebug()
    {
        echo "<h1>🎯 PRODUCTS DEBUG PAGE</h1>";
        echo "<style>pre {background: #f4f4f4; padding: 10px;}</style>";
        
        // 1. Check .env values
        echo "<h2>1. Environment Variables</h2>";
        $envVars = [
            'DJANGO_API_URL' => env('DJANGO_API_URL'),
            'DJANGO_API_USERNAME' => env('DJANGO_API_USERNAME'),
            'DJANGO_API_PASSWORD' => env('DJANGO_API_PASSWORD') ? '***SET***' : 'NOT SET',
        ];
        
        foreach ($envVars as $key => $value) {
            echo "<p><strong>$key:</strong> " . ($value ?: '<span style="color:red">NOT SET</span>') . "</p>";
        }
        
        // 2. Check config values
        echo "<h2>2. Config Values</h2>";
        $configVars = [
            'services.django_api.url' => config('services.django_api.url'),
            'services.django_api.username' => config('services.django_api.username'),
            'services.django_api.password' => config('services.django_api.password') ? '***SET***' : 'NOT SET',
        ];
        
        foreach ($configVars as $key => $value) {
            echo "<p><strong>$key:</strong> " . ($value ?: '<span style="color:red">NOT SET</span>') . "</p>";
        }
        
        // 3. Try to authenticate
        echo "<h2>3. Testing Authentication</h2>";
        $baseUrl = config('services.django_api.url');
        $username = config('services.django_api.username');
        $password = config('services.django_api.password');
        
        if (!$baseUrl || !$username || !$password) {
            echo "<p style='color:red'>❌ Missing credentials. Check your .env file.</p>";
            return;
        }
        
        try {
            // Clear cache first
            cache()->forget('django_api_token');
            
            echo "<p>Attempting login to: $baseUrl/api/auth/login/</p>";
            
            $authResponse = Http::withOptions(['verify' => false])
                ->timeout(10)
                ->post($baseUrl . '/api/auth/login/', [
                    'username' => $username,
                    'password' => $password,
                ]);
            
            echo "<p>Auth Status: <strong>" . $authResponse->status() . "</strong></p>";
            
            if ($authResponse->successful()) {
                $authData = $authResponse->json();
                echo "<p>✅ Authentication SUCCESSFUL</p>";
                echo "<p>Token: " . substr($authData['access'] ?? 'NO TOKEN', 0, 50) . "...</p>";
                
                // Store token
                $token = $authData['access'];
                cache(['django_api_token' => $token], 300);
                
                // 4. Fetch products
                echo "<h2>4. Fetching Products</h2>";
                
                $productResponse = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ])
                    ->timeout(10)
                    ->get($baseUrl . '/api/products/');
                
                echo "<p>Products API Status: <strong>" . $productResponse->status() . "</strong></p>";
                
                if ($productResponse->successful()) {
                    $products = $productResponse->json();
                    
                    echo "<p>✅ Products fetched: <strong>" . count($products) . " items</strong></p>";
                    
                    if (count($products) > 0) {
                        echo "<h3>Sample Product (First Item):</h3>";
                        echo "<pre>" . json_encode($products[0], JSON_PRETTY_PRINT) . "</pre>";
                        
                        echo "<h3>All Product Keys Found:</h3>";
                        $allKeys = [];
                        foreach ($products as $product) {
                            $allKeys = array_merge($allKeys, array_keys($product));
                        }
                        $allKeys = array_unique($allKeys);
                        echo "<p>" . implode(', ', $allKeys) . "</p>";
                        
                        echo "<h3>Categories Found:</h3>";
                        $categories = array_column($products, 'category');
                        $categoryCounts = array_count_values(array_filter($categories));
                        foreach ($categoryCounts as $cat => $count) {
                            echo "<p>$cat: $count products</p>";
                        }
                        
                        // 5. Test the transformation
                        echo "<h2>5. Testing Product Transformation</h2>";
                        $transformed = $this->transformSampleProduct($products[0]);
                        echo "<pre>" . json_encode($transformed, JSON_PRETTY_PRINT) . "</pre>";
                        
                        // 6. Show what the view will receive
                        echo "<h2>6. What Blade View Receives</h2>";
                        $controller = new ProductController();
                        $allProducts = collect($products)->map(function ($p) use ($controller) {
                            return $controller->transformProduct($p);
                        });
                        
                        echo "<p>Transformed products: " . $allProducts->count() . "</p>";
                        echo "<p>First transformed product categories: " . json_encode($allProducts->pluck('category')->toArray()) . "</p>";
                        
                    } else {
                        echo "<p style='color:orange'>⚠️ API returned empty array (0 products)</p>";
                    }
                    
                } else {
                    echo "<p style='color:red'>❌ Products API failed</p>";
                    echo "<pre>" . $productResponse->body() . "</pre>";
                }
                
            } else {
                echo "<p style='color:red'>❌ Authentication FAILED</p>";
                echo "<pre>" . $authResponse->body() . "</pre>";
            }
            
        } catch (\Exception $e) {
            echo "<p style='color:red'>❌ Exception: " . $e->getMessage() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
    
    private function transformSampleProduct($apiProduct)
    {
        $name = strtolower($apiProduct['name'] ?? '');
        $category = $apiProduct['category'] ?? null;
        
        if (!$category) {
            if (str_contains($name, 'pig') || str_contains($name, 'sow')) $category = 'pig';
            elseif (str_contains($name, 'chick') || str_contains($name, 'poultry')) $category = 'poultry';
            elseif (str_contains($name, 'dog') || str_contains($name, 'pet')) $category = 'pet';
            elseif (str_contains($name, 'bran') || str_contains($name, 'pollard')) $category = 'byproduct';
            else $category = 'uncategorized';
        }
        
        return [
            'id' => $apiProduct['id'] ?? 0,
            'name' => $apiProduct['name'] ?? 'Unnamed',
            'description' => $apiProduct['description'] ?? 'No description',
            'price' => floatval($apiProduct['unit_price'] ?? $apiProduct['price'] ?? 0),
            'image' => $apiProduct['image'] ?? 'images/default-product.jpg',
            'category' => $category,
            'type' => $apiProduct['type'] ?? 'Product',
            'stock' => $apiProduct['stock'] ?? 0,
        ];
    }
}