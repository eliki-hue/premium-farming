<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::approved()
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        $featuredReviews = Review::approved()
                                 ->featured()
                                 ->orderBy('created_at', 'desc')
                                 ->take(3)
                                 ->get();
        
        $totalReviews = Review::approved()->count();
        $averageRating = Review::approved()->avg('rating') ?? 0;
        
        return view('reviews', compact('reviews', 'featuredReviews', 'totalReviews', 'averageRating'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_location' => 'required|string|max:255',
            'farm_type' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10',
        ]);

        Review::create([
            'customer_name' => $validated['customer_name'],
            'customer_location' => $validated['customer_location'],
            'farm_type' => $validated['farm_type'],
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'is_approved' => true,
            'is_featured' => false,
            'has_photo' => false,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}