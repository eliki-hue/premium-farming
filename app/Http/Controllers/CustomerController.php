// app/Http/Controllers/CategoryController.php
<?php

namespace App\Http\Controllers;

use App\Services\DjangoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    protected $djangoApi;
    
    // Map URL slugs to Django category names
    protected $categoryMap = [
        'poultry' => 'poultry',
        'pig' => 'pig',
        'swine' => 'pig',
        'dairy' => 'dairy',
        'pet' => 'pet',
        'pet-feeds' => 'pet',
        'raw-materials' => 'raw-materials',
        'by-products' => 'raw-materials'
    ];

    protected $categoryNames = [
        'poultry' => 'Poultry',
        'pig' => 'Swine',
        'dairy' => 'Dairy',
        'pet' => 'Pet',
        'raw-materials' => 'Raw Materials'
    ];

    protected $viewMap = [
        'poultry' => 'categories.poultry',
        'pig' => 'categories.swine',
        'dairy' => 'categories.dairy',
        'pet' => 'categories.pet-feeds',
        'raw-materials' => 'categories.by-products'
    ];

    public function __construct(DjangoApiService $djangoApi)
    {
        $this->djangoApi = $djangoApi;
    }

    /**
     * Display products for a specific category from Django API
     */
    public function show($category)
    {
        // Check if category exists
        if (!array_key_exists($category, $this->categoryMap)) {
            abort(404);
        }

        $dbCategory = $this->categoryMap[$category];
        $viewName = $this->viewMap[$dbCategory] ?? "categories.{$category}";
        
        // Check if view exists
        if (!view()->exists($viewName)) {
            abort(404);
        }

        // Try to get from cache first (cache for 5 minutes)
        $products = Cache::remember('category_' . $dbCategory, 300, function () use ($dbCategory) {
            $response = $this->djangoApi->getProductsByCategory($dbCategory);
            
            if ($response['success']) {
                return $response['data']['products'] ?? [];
            }
            
            return [];
        });

        $categoryName = $this->categoryNames[$dbCategory] ?? ucfirst($category);
        
        // Get category specific data for the view
        $categoryData = $this->getCategoryData($dbCategory);

        // If API failed, show error message but still load the view
        if (empty($products) && request()->has('debug')) {
            $apiError = $response['error'] ?? 'Could not load products';
        }

        return view($viewName, compact(
            'products', 
            'categoryName', 
            'categoryData',
            'dbCategory'
        ));
    }

    /**
     * API endpoint that proxies to Django backend
     */
    public function apiShow($category)
    {
        if (!array_key_exists($category, $this->categoryMap)) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $dbCategory = $this->categoryMap[$category];
        $response = $this->djangoApi->getProductsByCategory($dbCategory);

        if (!$response['success']) {
            return response()->json([
                'error' => $response['error'],
                'category' => $category
            ], $response['status'] ?? 500);
        }

        return response()->json($response['data']);
    }

    /**
     * Get category specific data for views
     */
    private function getCategoryData($category)
    {
        $data = [
            'poultry' => [
                'hero_title' => 'Premium Poultry Feeds',
                'hero_subtitle' => 'Scientifically formulated feeds for optimal growth, health, and egg production',
                'hero_image' => 'images/economy.jpeg',
                'stats' => [
                    ['number' => '22%+', 'label' => 'Higher Protein'],
                    ['number' => '95%', 'label' => 'Feed Efficiency'],
                    ['number' => '3000+', 'label' => 'Poultry Farmers'],
                    ['number' => '5', 'label' => 'Growth Stages']
                ],
                'tips' => [
                    [
                        'icon' => 'thermometer-sun',
                        'title' => 'Temperature Control',
                        'description' => 'Maintain optimal brooding temperature: 35°C in week 1, reducing by 2.5°C weekly.'
                    ],
                    [
                        'icon' => 'droplet',
                        'title' => 'Clean Water Supply',
                        'description' => 'Provide fresh, clean water daily. Birds drink 2-3 times more water than feed.'
                    ],
                    [
                        'icon' => 'shield-check',
                        'title' => 'Biosecurity',
                        'description' => 'Limit farm visits, disinfect equipment, and control wild birds to prevent disease.'
                    ]
                ]
            ],
            'pig' => [
                'hero_title' => 'Premium Swine Feeds',
                'hero_subtitle' => 'Complete nutrition solutions for profitable pig farming',
                'hero_video' => 'videos/kkk.mp4',
                'stats' => [
                    ['number' => '22%', 'label' => 'High Protein'],
                    ['number' => '98%', 'label' => 'Digestibility'],
                    ['number' => '1500+', 'label' => 'Pig Farmers'],
                    ['number' => '4', 'label' => 'Growth Stages']
                ],
                'tips' => [
                    [
                        'icon' => 'house',
                        'title' => 'Proper Housing',
                        'description' => 'Provide clean, dry, and well-ventilated housing with adequate space per pig.'
                    ],
                    [
                        'icon' => 'droplet',
                        'title' => 'Clean Water',
                        'description' => 'Pigs need constant access to clean water. They drink 2-5 liters daily per 100kg weight.'
                    ],
                    [
                        'icon' => 'shield-check',
                        'title' => 'Health Management',
                        'description' => 'Regular deworming, vaccination, and biosecurity measures prevent diseases.'
                    ]
                ]
            ],
            'dairy' => [
                'hero_title' => 'Premium Dairy Feeds',
                'hero_subtitle' => 'Scientifically formulated feeds for maximum milk production and cow health',
                'hero_image' => 'https://images.unsplash.com/photo-1542838135-2dbba2fff66c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'stats' => [
                    ['number' => '40%', 'label' => 'More Milk Production'],
                    ['number' => '18%', 'label' => 'Higher Protein'],
                    ['number' => '5000+', 'label' => 'Happy Dairy Farmers'],
                    ['number' => '100%', 'label' => 'Natural Ingredients']
                ],
                'tips' => [
                    [
                        'icon' => 'droplet-half',
                        'title' => 'Water Availability',
                        'description' => 'Ensure 24/7 access to clean water. A dairy cow drinks 3-4 liters of water for every liter of milk produced.'
                    ],
                    [
                        'icon' => 'clock',
                        'title' => 'Consistent Feeding',
                        'description' => 'Feed at regular intervals to maintain rumen pH and maximize nutrient absorption.'
                    ],
                    [
                        'icon' => 'heart-pulse',
                        'title' => 'Health Monitoring',
                        'description' => 'Regular health checks and vaccination schedules ensure optimal production.'
                    ]
                ]
            ],
            'pet' => [
                'hero_title' => 'Premium Pet Feeds',
                'hero_subtitle' => 'Complete nutrition for your beloved pets - dogs, cats, rabbits, and more',
                'hero_image' => 'https://images.unsplash.com/photo-1514984879728-be0aff75a6e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2076&q=80',
                'tips' => [
                    [
                        'icon' => 'cup-hot',
                        'title' => 'Clean Water Always',
                        'description' => 'Ensure pets have access to fresh, clean water at all times for optimal hydration.'
                    ],
                    [
                        'icon' => 'calendar-check',
                        'title' => 'Regular Feeding Schedule',
                        'description' => 'Feed pets at consistent times daily to regulate digestion and metabolism.'
                    ],
                    [
                        'icon' => 'heart',
                        'title' => 'Health Check-ups',
                        'description' => 'Regular veterinary visits ensure early detection of health issues.'
                    ]
                ]
            ],
            'raw-materials' => [
                'hero_title' => 'By-Products & Supplements',
                'hero_subtitle' => 'High-quality by-products and essential supplements for complete livestock nutrition',
                'hero_image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
                'tips' => [
                    [
                        'icon' => 'scale',
                        'title' => 'Proper Mixing',
                        'description' => 'Mix by-products with main feeds in correct proportions for balanced nutrition.'
                    ],
                    [
                        'icon' => 'droplet-half',
                        'title' => 'Water Management',
                        'description' => 'Ensure adequate water supply when feeding high-fiber by-products.'
                    ],
                    [
                        'icon' => 'graph-up',
                        'title' => 'Gradual Introduction',
                        'description' => 'Introduce new supplements gradually to allow livestock adjustment.'
                    ]
                ]
            ]
        ];

        return $data[$category] ?? [];
    }
}