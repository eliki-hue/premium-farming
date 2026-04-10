<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_location' => 'nullable|string|max:255',
            'farm_type' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'review' => 'required|string|min:10',
        ]);

        // Save to reviews table matching your model structure
        Review::create([
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_location' => $validated['customer_location'] ?? 'Kenya',
            'farm_type' => $validated['farm_type'] ?? null,
            'rating' => $validated['rating'] ?? 5,
            'review' => $validated['review'],
            'is_approved' => true,
            'is_featured' => false,
            'has_photo' => false,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Thank you for your message! Your review has been submitted and will appear on our website.');
    }
}