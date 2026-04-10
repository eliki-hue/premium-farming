@extends('layouts.app')

@section('title', 'Customer Reviews | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Reviews Hero -->
    <section class="reviews-hero" style="
        background-image: url('{{ asset('images/rws1.jpg') }}');
        background-size: 80% auto;
        background-position: center;
        background-repeat: no-repeat;
        background-color: #f5f0e8;
        padding: 5rem 0 6rem;
        color: var(--navy-blue);
        position: relative;
        min-height: 380px;
        display: flex;
        align-items: center;
    ">
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    {{-- <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown" 
                        style="font-family: 'Cormorant Garamond', serif; background: rgba(255,255,255,0.7); display: inline-block; padding: 0.3rem 2rem; border-radius: 50px;">
                        Customer Reviews
                    </h1>
                    <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s mt-3" 
                       style="font-size: 1.2rem; background: rgba(255,255,255,0.6); display: inline-block; padding: 0.5rem 1.5rem; border-radius: 50px;">
                        See what our farmers are saying about our products and services
                    </p> --}}
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="py-3">
                        <h2 class="fw-bold mb-1" style="color: var(--navy-blue);">{{ number_format($averageRating, 1) }}</h2>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill" style="color: {{ $i <= round($averageRating) ? 'var(--accent-gold)' : '#dee2e6' }};"></i>
                            @endfor
                        </div>
                        <p class="text-muted small mb-0">Average Rating</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="py-3">
                        <h2 class="fw-bold mb-1" style="color: var(--navy-blue);">{{ $totalReviews }}</h2>
                        <p class="text-muted small mb-0">Customer Reviews</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="py-3">
                        <h2 class="fw-bold mb-1" style="color: var(--navy-blue);">98%</h2>
                        <p class="text-muted small mb-0">Recommend Us</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Video Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="d-inline-block mb-3" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); width: 60px; height: 3px; border-radius: 3px;"></div>
                    <h2 class="fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue); font-size: 2.5rem;">
                        <i class="bi bi-play-circle-fill me-2" style="color: var(--accent-gold);"></i>Featured Video
                    </h2>
                    <p class="text-muted mb-0">Watch how our products transform livestock farming</p>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="featured-card position-relative" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/Zn6FwAKazE4?autoplay=0&rel=0&modestbranding=1" title="Usage and benefits of molasses" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>
                        </div>
                        <div class="p-4" style="background: linear-gradient(135deg, var(--navy-blue), var(--primary-blue));">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div>
                                    <h3 class="fw-bold mb-2 text-white" style="font-family: 'Cormorant Garamond', serif;">
                                        <i class="bi bi-flower1 me-2"></i>Usage and Benefits of Molasses
                                    </h3>
                                    <p class="text-white-50 mb-0">Discover how molasses improves animal health, increases feed intake, and boosts milk production</p>
                                </div>
                                <span class="badge mt-2 mt-lg-0" style="background: var(--accent-gold); color: var(--navy-blue); padding: 8px 16px;">
                                    <i class="bi bi-star-fill me-1"></i> Featured Story
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Videos Grid Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="d-inline-block mb-3" style="background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold)); width: 60px; height: 3px; border-radius: 3px;"></div>
                    <h2 class="fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue); font-size: 2.5rem;">
                        <i class="bi bi-collection-play me-2"></i>All Testimonials
                    </h2>
                    <p class="text-muted mb-0">Real farmers, real stories, real results</p>
                </div>
            </div>
            
            <div class="row g-4">
                @php
                    $allVideos = [
                        ['id' => 'molasses', 'embedId' => 'Zn6FwAKazE4', 'title' => 'Usage and Benefits of Molasses', 'description' => 'Learn how molasses improves animal health, increases feed intake, and boosts milk production.', 'category' => 'Nutrition', 'duration' => '2:45', 'icon' => 'bi-flower1', 'color' => '#8B4513'],
                        ['id' => 'calf-pellets', 'embedId' => 'DYdFTA5mN00', 'title' => 'Calf Pellet Feeds for Healthy Calves', 'description' => 'Quality calf pellets that ensure proper growth and strong immunity.', 'category' => 'Calf Care', 'duration' => '3:12', 'icon' => 'bi-cup-straw', 'color' => '#2E7D32'],
                        ['id' => 'milking-salve', 'embedId' => 'BJoF9ELWy0M', 'title' => 'Benefits of Milking Salve', 'description' => 'Protect your dairy cows\' udders with our premium milking salve.', 'category' => 'Dairy Care', 'duration' => '2:58', 'icon' => 'bi-droplet', 'color' => '#1565C0'],
                        ['id' => 'dairy-farming', 'embedId' => 'n662UE7MsvQ', 'title' => 'Dairy Farming with Premium Feeds', 'description' => 'Quality, affordable, and reliable feeds for successful dairy farming.', 'category' => 'Dairy', 'duration' => '3:35', 'icon' => 'bi-cow', 'color' => '#6D4C41'],
                        ['id' => 'poultry-testimonial', 'embedId' => 's2TeOHKioxM', 'title' => 'Poultry Farmer Testimonial', 'description' => 'Happy poultry farmers share their success stories with Premium feeds.', 'category' => 'Poultry', 'duration' => '4:02', 'icon' => 'bi-egg-fried', 'color' => '#F57C00'],
                        ['id' => 'farmer-testimonial', 'embedId' => '-Egej37q0_g', 'title' => 'Daily Farmer Testimonial', 'description' => 'Farmers share how quality feeds transformed their livestock farming.', 'category' => 'Testimonial', 'duration' => '3:45', 'icon' => 'bi-chat-quote', 'color' => '#7B1FA2'],
                        ['id' => 'welcome-premium', 'embedId' => 'twZUzW17IkY', 'title' => 'Welcome to Premium Farming Feeds', 'description' => 'Manufacturing animal feeds and selling all agricultural products.', 'category' => 'Overview', 'duration' => '2:30', 'icon' => 'bi-building', 'color' => '#C62828']
                    ];
                @endphp
                
                @foreach($allVideos as $video)
                <div class="col-lg-4 col-md-6">
                    <div class="video-card card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                        <div class="video-thumbnail position-relative" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="{{ $video['embedId'] }}" data-video-title="{{ $video['title'] }}">
                            <img src="https://img.youtube.com/vi/{{ $video['embedId'] }}/maxresdefault.jpg" alt="{{ $video['title'] }}" class="img-fluid w-100" style="height: 220px; object-fit: cover;" onerror="this.src='https://img.youtube.com/vi/{{ $video['embedId'] }}/hqdefault.jpg'">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, rgba(0,0,0,0.4), rgba(0,0,0,0.6));">
                                <div class="play-button rounded-circle d-flex align-items-center justify-content-center" style="width: 65px; height: 65px; background: var(--primary-blue);">
                                    <i class="bi bi-play-fill text-white fs-2"></i>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 end-0 m-3">
                                <span class="badge" style="background: rgba(0,0,0,0.75); padding: 5px 10px; border-radius: 20px;"><i class="bi bi-clock me-1"></i>{{ $video['duration'] }}</span>
                            </div>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge" style="background: {{ $video['color'] }}; padding: 5px 12px; border-radius: 20px;"><i class="{{ $video['icon'] }} me-1"></i>{{ $video['category'] }}</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <h5 class="card-title fw-bold mb-2" style="color: var(--navy-blue); font-size: 1rem;">{{ $video['title'] }}</h5>
                            <p class="card-text text-muted small mb-0">{{ $video['description'] }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            <button class="btn w-100 watch-btn" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="{{ $video['embedId'] }}" data-video-title="{{ $video['title'] }}" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; border: none; border-radius: 10px; padding: 8px;">
                                <i class="bi bi-play-circle me-2"></i>Watch Now
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Written Reviews Section - DYNAMIC from Database -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="d-inline-block mb-3" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); width: 60px; height: 3px; border-radius: 3px;"></div>
                    <h2 class="fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue); font-size: 2.5rem;">
                        <i class="bi bi-star-fill me-2" style="color: var(--accent-gold);"></i>Customer Reviews
                    </h2>
                    <p class="text-muted mb-0">What our farmers say about us</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    @forelse($reviews as $review)
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                                        <span class="text-white fw-bold fs-5">{{ substr($review->customer_name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark">{{ $review->customer_name }}</h5>
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt me-1"></i>{{ $review->customer_location ?? 'Kenya' }}
                                            </small>
                                        </div>
                                        <div class="mt-1 mt-sm-0">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star-fill" style="color: {{ $i <= $review->rating ? 'var(--accent-gold)' : '#dee2e6' }}; font-size: 0.9rem;"></i>
                                            @endfor
                                            <small class="text-muted ms-2">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        @if($review->farm_type)
                                        <span class="badge me-2" style="background: rgba(30, 58, 138, 0.1); color: var(--primary-blue);">
                                            {{ $review->farm_type }} Farmer
                                        </span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-0">{{ $review->review }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                        <p class="text-muted mt-3">No reviews yet. Be the first to share your experience!</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary mt-2" style="background: var(--primary-blue); border: none;">Write a Review</a>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="text-muted">
                        <i class="bi bi-chat-dots me-1"></i> 
                        {{ $reviews->count() }} review(s) from our valued farmers
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Write Review Form -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 text-center">
                            <h3 class="fw-bold" style="color: var(--navy-blue);">
                                <i class="bi bi-pencil-square me-2"></i>Share Your Experience
                            </h3>
                            <p class="text-muted">Write a review and help other farmers</p>
                        </div>
                        <div class="card-body p-4">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Your Name *</label>
                                        <input type="text" name="customer_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Location *</label>
                                        <input type="text" name="customer_location" class="form-control" placeholder="e.g., Kiambu" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Farm Type *</label>
                                        <select name="farm_type" class="form-select" required>
                                            <option value="">Select</option>
                                            <option value="Dairy">Dairy Farming</option>
                                            <option value="Poultry">Poultry Farming</option>
                                            <option value="Pig">Pig Farming</option>
                                            <option value="Cattle">Cattle Rearing</option>
                                            <option value="Goat">Goat Farming</option>
                                            <option value="Rabbit">Rabbit Farming</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Rating *</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="5">★★★★★ (5/5) - Excellent</option>
                                            <option value="4">★★★★☆ (4/5) - Very Good</option>
                                            <option value="3">★★★☆☆ (3/5) - Good</option>
                                            <option value="2">★★☆☆☆ (2/5) - Fair</option>
                                            <option value="1">★☆☆☆☆ (1/5) - Poor</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Your Review *</label>
                                        <textarea name="review" rows="4" class="form-control" placeholder="Share your experience..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; border-radius: 10px; padding: 12px;">
                                            <i class="bi bi-send me-2"></i>Submit Review
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0" style="background: linear-gradient(135deg, var(--navy-blue), var(--primary-blue));">
                    <h5 class="modal-title text-white" id="videoModalLabel" style="font-family: 'Cormorant Garamond', serif;"><i class="bi bi-play-circle-fill me-2"></i>Premium Farming Feeds</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="background: #000;">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtubePlayer" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="modal-footer border-0" style="background: #1a1a2e;">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="border: 1px solid #666; color: #ccc; background: transparent; border-radius: 25px;">Close</button>
                    <a href="#" id="watchOnYoutubeBtn" target="_blank" class="btn btn-sm" style="background: #ff0000; color: white; border: none; border-radius: 25px;"><i class="bi bi-youtube me-1"></i>Watch on YouTube</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <section class="py-5 bg-white border-top">
        <div class="container text-center">
            <h3 class="h4 fw-bold mb-3" style="color: var(--navy-blue);">
                <i class="bi bi-chat-left-text me-2"></i>Have Something to Share?
            </h3>
            <p class="text-muted mb-4">Your feedback helps us improve and assists other farmers</p>
            <a href="{{ route('contact') }}" class="btn" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; border: none; border-radius: 50px; padding: 12px 32px;">
                <i class="bi bi-pencil-square me-2"></i> Write a Review
            </a>
        </div>
    </section>
</div>

<style>
    .reviews-hero{position:relative;overflow:hidden;}
    .video-card{transition:all 0.3s ease;}
    .video-card:hover{transform:translateY(-8px);box-shadow:0 20px 40px rgba(0,0,0,0.15)!important;}
    .video-card:hover .video-thumbnail img{transform:scale(1.05);}
    .video-card:hover .play-button{transform:scale(1.1);background:var(--secondary-blue)!important;}
    .play-button{transition:all 0.3s ease;box-shadow:0 4px 15px rgba(0,0,0,0.3);}
    .watch-btn{transition:all 0.3s ease;}
    .watch-btn:hover{transform:translateY(-2px);box-shadow:0 5px 15px rgba(30,58,138,0.3);}
    .featured-card{transition:all 0.3s ease;}
    .featured-card:hover{transform:translateY(-5px);box-shadow:0 25px 50px rgba(0,0,0,0.2)!important;}
    @media (max-width:768px){.reviews-hero{padding:3rem 0 4rem;}.display-4{font-size:2rem;}h2{font-size:1.5rem;}}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoModal = document.getElementById('videoModal');
    if (videoModal) {
        const youtubePlayer = document.getElementById('youtubePlayer');
        const watchOnYoutubeBtn = document.getElementById('watchOnYoutubeBtn');
        videoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const videoId = button.getAttribute('data-video-id');
            youtubePlayer.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
            watchOnYoutubeBtn.href = `https://www.youtube.com/watch?v=${videoId}`;
        });
        videoModal.addEventListener('hidden.bs.modal', function() {
            youtubePlayer.src = '';
        });
    }
});
</script>
@endsection