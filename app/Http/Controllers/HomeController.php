<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured products data
        $featuredProducts = [
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
                'is_premium' => true,
                'is_sale' => true,
            ],
        ];

        // Categories
        $categories = [
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

        // Features
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
}