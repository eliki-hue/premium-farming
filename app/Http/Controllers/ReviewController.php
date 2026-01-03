<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display all reviews on a page
     */
    public function index()
    {
        // Get dummy reviews
        $dummyReviews = $this->getDummyReviews();
        
        // Create simple stats from dummy data
        $stats = [
            'total' => count($dummyReviews),
            'average' => round(collect($dummyReviews)->avg('rating'), 1),
            'five_star' => collect($dummyReviews)->where('rating', 5)->count(),
            'featured' => 0, // No featured in dummy data
        ];

        // Since we don't have a database, we'll use a simple view
        // If reviews/index.blade.php exists and uses database queries, 
        // we need to create a simple view or modify it
        return view('reviews', compact('dummyReviews', 'stats'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create()
    {
        // Since we're using dummy data, we don't need products
        // But we can redirect to the main reviews page where the form is
        return redirect()->route('reviews')->with('info', 'Please use the form on the right to submit your review.');
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'farm_type' => 'required|string|in:dairy,poultry,pig,mixed,other',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10|max:1000'
        ], [
            'name.required' => 'Please enter your name.',
            'location.required' => 'Please enter your location.',
            'farm_type.required' => 'Please select your farm type.',
            'rating.required' => 'Please select a rating.',
            'title.required' => 'Please enter a review title.',
            'content.required' => 'Please enter your review.',
            'content.min' => 'Your review must be at least 10 characters long.',
        ]);

        // For now, we'll just return to the page with a success message
        // In a real application, you would save to database here
        
        return redirect()->route('reviews')
            ->with('success', 'Thank you for your review! Your feedback has been submitted successfully.');
    }

    /**
     * Display thank you page
     */
    public function thankyou()
    {
        // Simple thank you message on the main page
        return redirect()->route('reviews')
            ->with('success', 'Thank you for your review! Your feedback is appreciated.');
    }

    /**
     * Display reviews for a specific product
     */
    public function productReviews($productId)
    {
        // Since we're using dummy data, redirect to main reviews page
        return redirect()->route('reviews');
    }

    /**
     * Get dummy reviews data
     */
    private function getDummyReviews()
    {
        return [
            [
                'id' => 1,
                'name' => 'James Kariuki',
                'location' => 'Kiambu',
                'rating' => 5,
                'title' => 'Excellent Dairy Meal!',
                'content' => 'The dairy meal increased my milk production by 30%. My cows are healthier and more productive. The delivery was on time and the customer service is excellent! I recommend Premium Farming Feeds to all dairy farmers.',
                'farm_type' => 'dairy',
                'date' => 'March 15, 2024',
                'is_approved' => true,
                'is_featured' => false,
                'photo_path' => null,
                'created_at' => '2024-03-15 10:30:00'
            ],
            [
                'id' => 2,
                'name' => 'Mary Wanjiku',
                'location' => 'Nairobi',
                'rating' => 5,
                'title' => 'Best Poultry Feeds!',
                'content' => 'My broilers gained weight faster with Premium feeds compared to other brands. The technical advice from their team helped me reduce mortality rates.',
                'farm_type' => 'poultry',
                'date' => 'March 10, 2024',
                'is_approved' => true,
                'is_featured' => false,
                'photo_path' => null,
                'created_at' => '2024-03-10 14:20:00'
            ],
            [
                'id' => 3,
                'name' => 'Peter Maina',
                'location' => 'Thika',
                'rating' => 4,
                'title' => 'Reliable Service',
                'content' => 'Quality feeds at affordable prices. The delivery service to my farm is reliable even during rainy seasons.',
                'farm_type' => 'pig',
                'date' => 'March 5, 2024',
                'is_approved' => true,
                'is_featured' => false,
                'photo_path' => null,
                'created_at' => '2024-03-05 09:15:00'
            ],
            [
                'id' => 4,
                'name' => 'Sarah Njeri',
                'location' => 'Murang\'a',
                'rating' => 5,
                'title' => 'Great Customer Support',
                'content' => 'Whenever I have questions about feeding schedules or nutrition, their technical team is always available to help.',
                'farm_type' => 'dairy',
                'date' => 'February 28, 2024',
                'is_approved' => true,
                'is_featured' => true,
                'photo_path' => null,
                'created_at' => '2024-02-28 11:45:00'
            ],
            [
                'id' => 5,
                'name' => 'Kamau Waweru',
                'location' => 'Nakuru',
                'rating' => 4,
                'title' => 'Good Quality Feeds',
                'content' => 'I use their feeds for both my poultry and dairy cows. The quality is consistent and the animals are healthy.',
                'farm_type' => 'mixed',
                'date' => 'February 20, 2024',
                'is_approved' => true,
                'is_featured' => false,
                'photo_path' => null,
                'created_at' => '2024-02-20 16:30:00'
            ],
            [
                'id' => 6,
                'name' => 'Jane Muthoni',
                'location' => 'Embu',
                'rating' => 5,
                'title' => 'Excellent Pig Feeds',
                'content' => 'My pigs have never been healthier! The growth rate is amazing and the feed conversion ratio is very good.',
                'farm_type' => 'pig',
                'date' => 'February 15, 2024',
                'is_approved' => true,
                'is_featured' => true,
                'photo_path' => null,
                'created_at' => '2024-02-15 13:20:00'
            ]
        ];
    }

    /**
     * Get rating distribution
     */
    private function getRatingDistribution()
    {
        $dummyReviews = $this->getDummyReviews();
        $distribution = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $count = collect($dummyReviews)->where('rating', $i)->count();
            $distribution[$i] = $count;
        }
        
        return $distribution;
    }

    /**
     * Admin: Display all reviews for moderation
     */
    public function adminIndex()
    {
        // Since we're using dummy data, show empty admin page
        $pending = collect([]);
        $approved = collect($this->getDummyReviews());
        
        return view('admin.reviews.index', compact('pending', 'approved'));
    }

    /**
     * Admin: Approve a review
     */
    public function approve($id)
    {
        // Since we're using dummy data, just show success message
        return back()->with('success', 'Review approved successfully.');
    }

    /**
     * Admin: Feature/unfeature a review
     */
    public function toggleFeature($id)
    {
        // Since we're using dummy data, just show success message
        $action = 'featured';
        return back()->with('success', "Review {$action} successfully.");
    }

    /**
     * Admin: Delete a review
     */
    public function destroy($id)
    {
        // Since we're using dummy data, just show success message
        return back()->with('success', 'Review deleted successfully.');
    }
}