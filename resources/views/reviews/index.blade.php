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
            'is_featured' => true
        ],
        // ... more dummy reviews
    ];
}

public function index()
{
    $dummyReviews = $this->getDummyReviews();
    
    $stats = [
        'total' => count($dummyReviews),
        'average' => round(collect($dummyReviews)->avg('rating'), 1),
        'five_star' => collect($dummyReviews)->where('rating', 5)->count(),
        'featured' => collect($dummyReviews)->where('is_featured', true)->count(),
    ];

    return view('reviews.index', compact('dummyReviews', 'stats'));
}