<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class DjangoApiService
{
    protected static $baseUrl;
    protected static $username;
    protected static $password;
    protected static $useMock = false;

    /**
     * Initialize configuration
     */
    public static function init()
    {
        self::$baseUrl = config('services.django_api.url');
        self::$username = config('services.django_api.username');
        self::$password = config('services.django_api.password');
        
        // Check if we should use mock data
        self::$useMock = env('DJANGO_API_USE_MOCK', false);
        
        // Debug logging
        Log::debug('Django API Config Loaded:', [
            'url' => self::$baseUrl,
            'username_set' => !empty(self::$username),
            'password_set' => !empty(self::$password),
            'use_mock' => self::$useMock
        ]);
        
        if (!self::$useMock && (empty(self::$baseUrl) || empty(self::$username) || empty(self::$password))) {
            throw new \Exception('Django API credentials not configured.');
        }
    }

    /**
     * Check if we should use mock data
     */
    private static function shouldUseMock()
    {
        if (self::$useMock) {
            return true;
        }
        
        // If no URL configured, use mock
        if (empty(self::$baseUrl)) {
            return true;
        }
        
        return false;
    }

    /**
     * Get mock products for testing
     */
    private static function getMockProducts($category = null)
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Laptop',
                'description' => 'High-performance laptop',
                'price' => 999.99,
                'category' => 'Electronics',
                'stock' => 50,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'id' => 2,
                'name' => 'Smartphone',
                'description' => 'Latest smartphone model',
                'price' => 699.99,
                'category' => 'Electronics',
                'stock' => 100,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
            [
                'id' => 3,
                'name' => 'Desk Chair',
                'description' => 'Ergonomic office chair',
                'price' => 299.99,
                'category' => 'Furniture',
                'stock' => 25,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ],
        ];
        
        // Filter by category if specified
        if ($category) {
            $products = array_filter($products, function($product) use ($category) {
                return strtolower($product['category']) === strtolower($category);
            });
        }
        
        return collect($products);
    }

    /**
     * Get or refresh the authentication token
     */
    public static function getToken()
    {
        // Check if we have a valid cached token
        $token = Cache::get('django_api_token');
        
        if ($token) {
            return $token;
        }
        
        // No valid token, authenticate to get new one
        return self::authenticate();
    }

    /**
     * Authenticate with Django API and get new token
     */
    public static function authenticate()
    {
        try {
            self::init();
            
            Log::info('Attempting Django API authentication', [
                'url' => self::$baseUrl . '/api/auth/login/'
            ]);
            
            $response = Http::withOptions(['verify' => false])
                ->post(self::$baseUrl . '/api/auth/login/', [
                    'username' => self::$username,
                    'password' => self::$password,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $token = $data['access'];
                $refreshToken = $data['refresh'] ?? null;
                
                // Cache the access token (cache for slightly less than expiry time)
                Cache::put('django_api_token', $token, now()->addMinutes(4));
                
                // Cache refresh token if available
                if ($refreshToken) {
                    Cache::put('django_api_refresh_token', $refreshToken, now()->addDays(7));
                }
                
                Log::info('Django API: New token obtained');
                return $token;
            }
            
            Log::error('Django API Authentication Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'url' => self::$baseUrl,
                'username' => self::$username
            ]);
            return null;
            
        } catch (\Exception $e) {
            Log::error('Django API Authentication Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Refresh expired token using refresh token
     */
    public static function refreshToken()
    {
        try {
            self::init();
            
            $refreshToken = Cache::get('django_api_refresh_token');
            
            if (!$refreshToken) {
                // No refresh token, need to re-authenticate
                return self::authenticate();
            }
            
            $response = Http::withOptions(['verify' => false])
                ->post(self::$baseUrl . '/api/auth/refresh/', [
                    'refresh' => $refreshToken,
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                $newToken = $data['access'];
                
                // Cache the new access token
                Cache::put('django_api_token', $newToken, now()->addMinutes(4));
                
                Log::info('Django API: Token refreshed');
                return $newToken;
            }
            
            // Refresh failed, try full authentication
            Cache::forget('django_api_refresh_token');
            Cache::forget('django_api_token');
            return self::authenticate();
            
        } catch (\Exception $e) {
            Log::error('Django API Refresh Error: ' . $e->getMessage());
            return self::authenticate();
        }
    }

    /**
     * Get products with automatic token handling
     */
   public static function getProducts($category = null)
{
    try {
        \Log::info('DjangoApiService: Getting REAL products from Django API');
        
        self::init();
        
        // FORCE real connection - ignore mock setting
        // Remove this line if you want to respect DJANGO_API_USE_MOCK
        self::$useMock = false;
        
        $endpoint = '/api/products/';
        
        if ($category) {
            $endpoint .= '?category=' . urlencode($category);
        }
        
        \Log::info('Fetching from: ' . self::$baseUrl . $endpoint);
        
        // Get token
        $token = self::getToken();
        
        if (!$token) {
            \Log::error('No token obtained');
            throw new \Exception('Failed to get authentication token');
        }
        
        // Make direct HTTP request
        $response = \Illuminate\Support\Facades\Http::withOptions([
            'verify' => false,
            'timeout' => 30,
        ])->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get(self::$baseUrl . $endpoint);
        
        \Log::info('Response status: ' . $response->status());
        
        if ($response->successful()) {
            $data = $response->json();
            
            \Log::info('Received ' . (is_array($data) ? count($data) : 0) . ' products');
            
            if (is_array($data)) {
                return collect($data);
            }
            
            return collect([]);
        }
        
        \Log::error('API error: ' . $response->status() . ' - ' . $response->body());
        throw new \Exception('Django API error: ' . $response->status());
        
    } catch (\Exception $e) {
        \Log::error('getProducts error: ' . $e->getMessage());
        // Return empty collection on error, not mock data
        return collect([]);
    }
}

    /**
     * Make API request with automatic token refresh on failure
     */
    public static function makeRequest($method, $endpoint, $data = [])
    {
        try {
            // If using mock, return mock response for non-GET requests
            if (self::shouldUseMock() && $method !== 'get') {
                return self::getMockResponse($method, $endpoint, $data);
            }
            
            self::init();
            
            $token = self::getToken();
            
            if (!$token) {
                throw new \Exception('Unable to obtain Django API token');
            }
            
            Log::debug('makeRequest using token: ' . substr($token, 0, 20) . '...');
            
            // Make request with token
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 30,
                'connect_timeout' => 10,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->baseUrl(self::$baseUrl)->{$method}($endpoint, $data);
            
            Log::debug('makeRequest Response', [
                'status' => $response->status(),
                'endpoint' => $endpoint
            ]);
            
            // If unauthorized, try to refresh token and retry
            if ($response->status() === 401) {
                Log::warning('Token expired, attempting refresh');
                
                // Get fresh token
                $newToken = self::refreshToken();
                
                if ($newToken) {
                    $response = Http::withOptions([
                        'verify' => false,
                        'timeout' => 30,
                        'connect_timeout' => 10,
                    ])->withHeaders([
                        'Authorization' => 'Bearer ' . $newToken,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ])->baseUrl(self::$baseUrl)->{$method}($endpoint, $data);
                }
            }
            
            return $response;
            
        } catch (\Exception $e) {
            Log::error('Django API Request Error: ' . $e->getMessage(), [
                'endpoint' => $endpoint,
                'method' => $method,
                'trace' => $e->getTraceAsString()
            ]);
            
            return new \Illuminate\Http\Client\Response(
                new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 
                    json_encode(['error' => 'API Connection Failed: ' . $e->getMessage()]))
            );
        }
    }

    /**
     * Get mock response for testing
     */
    private static function getMockResponse($method, $endpoint, $data)
    {
        $mockResponses = [
            'POST' => [
                'status' => 201,
                'body' => array_merge(['id' => rand(100, 999)], $data, [
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString()
                ])
            ],
            'PUT' => [
                'status' => 200,
                'body' => array_merge($data, [
                    'id' => (int) basename(rtrim($endpoint, '/')),
                    'updated_at' => now()->toDateTimeString()
                ])
            ],
            'PATCH' => [
                'status' => 200,
                'body' => array_merge(['id' => (int) basename(rtrim($endpoint, '/'))], $data, [
                    'updated_at' => now()->toDateTimeString()
                ])
            ],
            'DELETE' => [
                'status' => 204,
                'body' => null
            ]
        ];
        
        $method = strtoupper($method);
        $response = $mockResponses[$method] ?? ['status' => 200, 'body' => self::getMockProducts()];
        
        return new Response(
            new \GuzzleHttp\Psr7\Response($response['status'], ['Content-Type' => 'application/json'], 
                json_encode($response['body']))
        );
    }

    /**
     * Helper method for common HTTP methods
     */
    public static function get($endpoint, $params = [])
    {
        return self::makeRequest('get', $endpoint, $params);
    }

    public static function post($endpoint, $data = [])
    {
        return self::makeRequest('post', $endpoint, $data);
    }

    public static function put($endpoint, $data = [])
    {
        return self::makeRequest('put', $endpoint, $data);
    }

    public static function patch($endpoint, $data = [])
    {
        return self::makeRequest('patch', $endpoint, $data);
    }

    public static function delete($endpoint)
    {
        return self::makeRequest('delete', $endpoint);
    }
}