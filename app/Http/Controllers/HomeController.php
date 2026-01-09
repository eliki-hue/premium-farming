<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('app.api_url', env('API_BASE_URL', 'https://unmisanthropically-transcultural-minnie.ngrok-free.dev/api'));
    }

    public function index()
    {
        // Fetch featured products from API
        $featuredProducts = $this->getFeaturedProducts();

        // Fetch categories from API
        $categories = $this->getCategories();

        // Features (static data - usually doesn't change)
        $features = [
            [
                'icon' => 'star-fill',
                'title' => 'Premium Quality',
                'description' => 'High-quality balanced rations for optimal livestock health',
            ],
            [
                'icon' => 'graph-up-arrow',
                'title' => 'Faster Growth',
                'description' => 'Formulated for better feed conversion and rapid weight gain',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Targeted Nutrition',
                'description' => 'Specific formulas for different animals and growth stages',
            ],
            [
                'icon' => 'trophy',
                'title' => 'Increased Production',
                'description' => 'Enhanced egg, milk, and meat production results',
            ],
        ];

        return view('home', compact('featuredProducts', 'categories', 'features'));
    }

    /**
     * Fetch featured products from API with fallback to hardcoded data
     */
    private function getFeaturedProducts()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiBaseUrl}/public/products/", [
                'featured' => true,
                'limit' => 8
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                $products = $apiData['data'] ?? [];

                // Transform API data to match your frontend structure
                return collect($products)->map(function ($product) {
                    return [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'category' => strtoupper($product['category_name'] ?? 'GENERAL'),
                        'price' => $product['price'],
                        'old_price' => $product['old_price'] ?? null,
                        'unit' => $product['unit'] ?? 'per 70kg bag',
                        'rating' => $product['rating'] ?? 4.5,
                        'reviews' => $product['reviews_count'] ?? 0,
                        'image' => $product['image'] ?? 'placeholder.jpg',
                        'slug' => $product['slug'],
                        'is_premium' => $product['is_premium'] ?? false,
                        'is_sale' => isset($product['old_price']) && $product['old_price'] > $product['price'],
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching featured products from API: ' . $e->getMessage());
        }

        // Fallback to hardcoded data if API fails
        return $this->getFallbackProducts();
    }

    /**
     * Fetch categories from API with fallback to hardcoded data
     */
    private function getCategories()
    {
        try {
            $response = Http::timeout(10)->get("{$this->apiBaseUrl}/public/categories/");

            if ($response->successful()) {
                $apiData = $response->json();
                $categories = $apiData['data'] ?? [];

                // Transform API data to match your frontend structure
                return collect($categories)->map(function ($category) {
                    return [
                        'name' => $category['name'],
                        'icon' => $this->getCategoryIcon($category['slug']),
                        'slug' => $category['slug'],
                        'description' => $category['description'] ?? '',
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            Log::error('Error fetching categories from API: ' . $e->getMessage());
        }

        // Fallback to hardcoded data if API fails
        return $this->getFallbackCategories();
    }

    /**
     * Get category icon based on slug
     */
    private function getCategoryIcon($slug)
    {
        $icons = [
            'poultry' => '🐔',
            'pigs' => '🐷',
            'cattle' => '🐄',
            'concentrates' => '🌾',
            'dairy' => '🥛',
            'goats' => '🐐',
            'sheep' => '🐑',
            'rabbits' => '🐰',
            'fish' => '🐟',
        ];

        return $icons[$slug] ?? '🌾';
    }

    /**
     * Fallback hardcoded products (used when API is unavailable)
     */
    private function getFallbackProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Kienyeji Premium Mash',
                'category' => 'POULTRY',
                'price' => 3200,
                'old_price' => 3500,
                'unit' => 'per 70kg bag',
                'rating' => 4.9,
                'reviews' => 156,
                'image' => 'kienyeji-mash.jpg',
                'slug' => 'kienyeji-premium-mash',
                'is_premium' => true,
                'is_sale' => true,
            ],
            [
                'id' => 2,
                'name' => 'Broiler Finisher Pellets',
                'category' => 'POULTRY',
                'price' => 3400,
                'old_price' => null,
                'unit' => 'per 70kg bag',
                'rating' => 4.8,
                'reviews' => 203,
                'image' => 'broiler-finisher.jpg',
                'slug' => 'broiler-finisher-pellets',
                'is_premium' => true,
                'is_sale' => false,
            ],
            [
                'id' => 3,
                'name' => 'Sow & Weaner Premium',
                'category' => 'PIGS',
                'price' => 3800,
                'old_price' => null,
                'unit' => 'per 70kg bag',
                'rating' => 4.9,
                'reviews' => 98,
                'image' => 'sow-weaner.jpg',
                'slug' => 'sow-weaner-premium',
                'is_premium' => true,
                'is_sale' => false,
            ],
            [
                'id' => 4,
                'name' => 'Dairy Meal Concentrate',
                'category' => 'CATTLE',
                'price' => 3600,
                'old_price' => 3900,
                'unit' => 'per 70kg bag',
                'rating' => 4.7,
                'reviews' => 142,
                'image' => 'dairy-meal.jpg',
                'slug' => 'dairy-meal-concentrate',
                'is_premium' => true,
                'is_sale' => true,
            ],
        ];
    }

    /**
     * Fallback hardcoded categories (used when API is unavailable)
     */
    private function getFallbackCategories()
    {
        return [
            [
                'name' => 'Poultry Feeds',
                'icon' => '🐔',
                'slug' => 'poultry',
                'description' => 'Chick Starter, Growers, Layers & Broilers',
            ],
            [
                'name' => 'Pig Feeds',
                'icon' => '🐷',
                'slug' => 'pigs',
                'description' => 'Sow & Weaner, Starter, Finisher',
            ],
            [
                'name' => 'Cattle Feeds',
                'icon' => '🐄',
                'slug' => 'cattle',
                'description' => 'Dairy Meal, Beef Minerals',
            ],
            [
                'name' => 'Concentrates',
                'icon' => '🌾',
                'slug' => 'concentrates',
                'description' => 'High-quality feed supplements',
            ],
        ];
    }
}