@extends('layouts.app')

@section('title', 'Customer Reviews | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Reviews Hero -->
    <section class="reviews-hero" style="
        background: url('/public/images/rvws1.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 6rem 0 4rem;
        color: white;
        position: relative;
        overflow: hidden;
    ">
        <div class="position-absolute top-0 end-0 w-50 h-100" style="
            background: linear-gradient(45deg, transparent 50%, rgba(212, 175, 55, 0.1) 50%);
        "></div>
        
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown" 
                        style="font-family: 'Cormorant Garamond', serif;">
                        Customer Reviews
                    </h1>
                    <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s" 
                       style="font-size: 1.2rem;">
                        See what our farmers are saying about our products and services
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Video Section - Using your first video as featured -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-center mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue);">
                        <i class="bi bi-play-circle me-2"></i>Featured Video Testimonial
                    </h2>
                    <p class="text-center text-muted mb-0">
                        Watch how our premium feeds transform livestock farming
                    </p>
                </div>
            </div>
            
            <!-- Featured Video - First video as featured -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(30, 58, 138, 0.1);">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://www.youtube.com/embed/OSruP9B-_KA?autoplay=0&rel=0&modestbranding=1" 
                                    title="Healthy livestock starts with the right feeds"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" 
                                    allowfullscreen
                                    loading="lazy"
                                    class="rounded-top"
                                ></iframe>
                            </div>
                            <div class="p-4">
                                <h3 class="fw-bold mb-2" style="color: var(--navy-blue);">
                                    <i class="bi bi-play-btn-fill me-2"></i>Healthy Livestock Starts with the Right Feeds
                                </h3>
                                <p class="text-muted mb-3">
                                    Discover how Premium Farming Feeds helps farmers achieve optimal animal health and productivity with our scientifically formulated feed solutions.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <span class="badge" style="
                                        background: rgba(30, 58, 138, 0.1);
                                        color: var(--primary-blue);
                                        border: 1px solid rgba(30, 58, 138, 0.2);
                                    ">
                                        <i class="bi bi-heart-pulse me-1"></i>Livestock Health
                                    </span>
                                    <span class="badge" style="
                                        background: rgba(212, 175, 55, 0.1);
                                        color: var(--accent-gold);
                                        border: 1px solid rgba(212, 175, 55, 0.2);
                                    ">
                                        <i class="bi bi-graph-up-arrow me-1"></i>Featured Story
                                    </span>
                                    <span class="badge" style="
                                        background: rgba(156, 163, 175, 0.1);
                                        color: #6b7280;
                                        border: 1px solid rgba(156, 163, 175, 0.2);
                                    ">
                                        <i class="bi bi-calendar3 me-1"></i>Success Story
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Reviews Section - Using all your videos -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-center mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue);">
                        <i class="bi bi-collection-play me-2"></i>Success Stories & Testimonials
                    </h2>
                    <p class="text-center text-muted mb-0">
                        Watch real farmers share their experiences with our products
                    </p>
                </div>
            </div>
            
            <!-- Video Cards Grid - Using only your provided videos -->
            <div class="row g-4" id="videoReviewsContainer">
                @php
                    $youtubeVideos = [
                        [
                            'id' => 'healthy-livestock',
                            'title' => 'Healthy livestock starts with the right feeds',
                            'description' => 'See how proper nutrition transforms livestock health and productivity with Premium Farming Feeds.',
                            'embedId' => 'OSruP9B-_KA',
                            'duration' => '4:20',
                            'category' => 'General',
                            'featured' => true
                        ],
                        [
                            'id' => 'poultry-success-story',
                            'title' => "Poultry farmer's success story",
                            'description' => 'Powered by Premium Farming Feeds Limited. You can be the next farmer!',
                            'embedId' => 'z5nt5tkf0Z0',
                            'duration' => '4:20',
                            'category' => 'Poultry'
                        ],
                        [
                            'id' => 'dairy-success-story-1',
                            'title' => "Dairy farmer's success story",
                            'description' => 'Powered by Premium Farming Feeds Limited. You can be the next farmer!',
                            'embedId' => 'OJCD1oF768M',
                            'duration' => '4:20',
                            'category' => 'Dairy'
                        ],
                        [
                            'id' => 'dairy-success-story-2',
                            'title' => 'Another success story of a dairy farmer',
                            'description' => 'Using Premium Farming Feeds Limited feeds. You can be next!',
                            'embedId' => 'pFSdnNBOQhI',
                            'duration' => '4:20',
                            'category' => 'Dairy'
                        ],
                        [
                            'id' => 'dedicated-service',
                            'title' => 'We are dedicated to serve you',
                            'description' => 'Our commitment to quality and service for all our farmers.',
                            'embedId' => 'ZMoeb2V6hOU',
                            'duration' => '4:20',
                            'category' => 'General'
                        ],
                        [
                            'id' => 'swine-feeds',
                            'title' => 'Quality and affordable swine feeds',
                            'description' => 'Only in Premium Farming Feeds. Perfect for your pig farming needs.',
                            'embedId' => 'P_zTr6FqCGc',
                            'duration' => '4:20',
                            'category' => 'Swine'
                        ],
                        [
                            'id' => 'farming-highlight-1',
                            'title' => '#farming #animalnutrition #agriculture',
                            'description' => 'Life is but a dream with the right agricultural practices and nutrition.',
                            'embedId' => 'VAJ2C0tck6Q',
                            'duration' => '4:20',
                            'category' => 'General'
                        ],
                        [
                            'id' => 'farming-highlight-2',
                            'title' => '#agriculture #farming #animalnutrition',
                            'description' => 'The other side of make-believe - real farming success stories.',
                            'embedId' => 'aS7F9JqKX40',
                            'duration' => '4:20',
                            'category' => 'General'
                        ],
                        [
                            'id' => 'tides-and-smiles',
                            'title' => 'Tides & Smiles by Moavii',
                            'description' => 'Background music for farming inspiration and success stories.',
                            'embedId' => 'mpX6mFLBPFY',
                            'duration' => '4:20',
                            'category' => 'Inspiration'
                        ]
                    ];
                @endphp
                
                @foreach($youtubeVideos as $index => $video)
                <div class="col-lg-4 col-md-6">
                    <div class="video-card card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden; border: 1px solid rgba(30, 58, 138, 0.1);">
                        <!-- Video Thumbnail with Play Button -->
                        <div class="video-thumbnail position-relative" style="cursor: pointer;" 
                             data-bs-toggle="modal" 
                             data-bs-target="#videoModal" 
                             data-video-id="{{ $video['embedId'] }}" 
                             data-video-title="{{ $video['title'] }}">
                            <img src="https://img.youtube.com/vi/{{ $video['embedId'] }}/maxresdefault.jpg" 
                                 alt="{{ $video['title'] }}" 
                                 class="img-fluid w-100 lazy-load" 
                                 data-src="https://img.youtube.com/vi/{{ $video['embedId'] }}/maxresdefault.jpg" 
                                 style="height: 200px; object-fit: cover;"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $video['embedId'] }}/hqdefault.jpg'">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
                                <div class="play-button rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: var(--primary-blue); opacity: 0.9;">
                                    <i class="bi bi-play-fill text-white fs-3"></i>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75 py-1 px-2" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $video['duration'] }}
                                </span>
                            </div>
                            @if($index === 0)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge py-1 px-2" style="
                                    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
                                    color: var(--navy-blue);
                                    font-size: 0.7rem;
                                ">
                                    <i class="bi bi-star-fill me-1"></i>Featured
                                </span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Video Details -->
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold mb-2 text-dark" style="font-size: 0.95rem; line-height: 1.3;">
                                {{ $video['title'] }}
                            </h6>
                            <p class="card-text text-muted small mb-2" style="font-size: 0.85rem;">
                                {{ $video['description'] }}
                            </p>
                            
                            <div class="video-meta d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge" style="
                                        background: rgba(30, 58, 138, 0.1);
                                        color: var(--primary-blue);
                                        border: 1px solid rgba(30, 58, 138, 0.2);
                                        font-size: 0.75rem;
                                    ">
                                        <i class="bi bi-tag me-1"></i>{{ $video['category'] }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-play-circle me-1"></i>Testimonial
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Footer -->
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-youtube me-1" style="color: #ff0000;"></i>YouTube
                                </small>
                                <button class="btn btn-sm watch-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#videoModal" 
                                        data-video-id="{{ $video['embedId'] }}" 
                                        data-video-title="{{ $video['title'] }}"
                                        style="
                                    background: var(--primary-blue);
                                    color: white;
                                    padding: 0.25rem 0.75rem;
                                    font-size: 0.8rem;
                                    border: none;
                                ">
                                    <i class="bi bi-play-circle me-1"></i>Watch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Note: All videos from Premium Farming Feeds -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="text-muted small">
                        <i class="bi bi-youtube me-1" style="color: #ff0000;"></i>
                        All videos are official testimonials from Premium Farming Feeds Limited
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0" style="border-radius: 8px; overflow: hidden;">
                <div class="modal-header border-0" style="background: var(--navy-blue);">
                    <h5 class="modal-title text-white" id="videoModalLabel" style="font-family: 'Cormorant Garamond', serif;">Customer Testimonial</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" style="background: #000;">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtubePlayer" 
                            src="" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <div class="modal-footer border-0" style="background: var(--navy-blue);">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="
                        border: 1px solid white;
                        color: white;
                        background: transparent;
                    ">
                        Close
                    </button>
                    <a href="#" id="watchOnYoutubeBtn" target="_blank" class="btn btn-sm" style="
                        background: #ff0000;
                        color: white;
                        border: none;
                    ">
                        <i class="bi bi-youtube me-1"></i>Watch on YouTube
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Content -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <!-- Reviews List -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold mb-0" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue);">Written Reviews</h2>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm active" id="filterAll" style="border: 1px solid var(--primary-blue); color: var(--primary-blue); background: transparent;">All</button>
                            <button class="btn btn-sm" id="filter5" style="border: 1px solid var(--primary-blue); color: var(--primary-blue); background: transparent;">5 Stars</button>
                            <button class="btn btn-sm" id="filter4" style="border: 1px solid var(--primary-blue); color: var(--primary-blue); background: transparent;">4 Stars</button>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    <div class="reviews-list">
                        @foreach([
                            [
                                'initials' => 'J',
                                'name' => 'James Kariuki',
                                'location' => 'Kiambu',
                                'rating' => 5,
                                'date' => 'March 15, 2024',
                                'category' => 'Dairy Farming',
                                'title' => 'Excellent Dairy Meal!',
                                'content' => '"The dairy meal increased my milk production by 30%. My cows are healthier and more productive. The delivery was on time and the customer service is excellent! I recommend Premium Farming Feeds to all dairy farmers."',
                                'color' => 'blue'
                            ],
                            [
                                'initials' => 'M',
                                'name' => 'Mary Wanjiku',
                                'location' => 'Nairobi',
                                'rating' => 5,
                                'date' => 'March 10, 2024',
                                'category' => 'Poultry Farming',
                                'title' => 'Best Poultry Feeds!',
                                'content' => '"My broilers gained weight faster with Premium feeds compared to other brands I\'ve tried. The technical advice from their team helped me reduce mortality rates. Their feeds are well-balanced and affordable."',
                                'color' => 'blue'
                            ],
                            [
                                'initials' => 'P',
                                'name' => 'Peter Maina',
                                'location' => 'Thika',
                                'rating' => 4,
                                'date' => 'March 5, 2024',
                                'category' => 'Pig Farming',
                                'title' => 'Reliable Service',
                                'content' => '"Quality feeds at affordable prices. The delivery service to my farm is reliable even during rainy seasons. My pigs have shown significant growth improvement since switching to Premium feeds."',
                                'color' => 'blue'
                            ],
                            [
                                'initials' => 'S',
                                'name' => 'Sarah Njeri',
                                'location' => 'Murang\'a',
                                'rating' => 5,
                                'date' => 'February 28, 2024',
                                'category' => 'Dairy Farming',
                                'title' => 'Great Customer Support',
                                'content' => '"Whenever I have questions about feeding schedules or nutrition, their technical team is always available to help. The feeds have improved my herd\'s health significantly."',
                                'color' => 'blue'
                            ],
                            [
                                'initials' => 'K',
                                'name' => 'Kamau Waweru',
                                'location' => 'Nakuru',
                                'rating' => 4,
                                'date' => 'February 20, 2024',
                                'category' => 'Mixed Farming',
                                'title' => 'Good Quality Feeds',
                                'content' => '"I use their feeds for both my poultry and dairy cows. The quality is consistent and the animals are healthy. I appreciate the bulk delivery discounts they offer for large orders."',
                                'color' => 'blue'
                            ]
                        ] as $review)
                        <div class="card border-0 shadow-sm mb-4" data-rating="{{ $review['rating'] }}" style="border-radius: 8px; border: 1px solid rgba(30, 58, 138, 0.1);">
                            <div class="card-body p-4">
                                <div class="row align-items-start">
                                    <div class="col-md-2 text-center mb-3 mb-md-0">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));">
                                            <span class="text-white fw-bold fs-5">{{ $review['initials'] }}</span>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $review['name'] }}</h6>
                                        <small class="text-muted">{{ $review['location'] }}</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review['rating'])
                                                            <i class="bi bi-star-fill" style="color: var(--accent-gold);"></i>
                                                        @else
                                                            <i class="bi bi-star" style="color: var(--accent-gold);"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $review['date'] }}</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="mb-0 fw-bold text-dark">{{ $review['title'] }}</h5>
                                            <span class="badge ms-3" style="
                                                background: rgba(30, 58, 138, 0.1);
                                                color: var(--primary-blue);
                                                border: 1px solid rgba(30, 58, 138, 0.2);
                                            ">
                                                {{ $review['category'] }}
                                            </span>
                                        </div>
                                        <p class="mb-0 text-dark">{{ $review['content'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Add Review Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px; border-radius: 8px; border: 1px solid rgba(30, 58, 138, 0.1);">
                        <div class="card-header bg-white border-bottom py-3">
                            <h3 class="card-title mb-0 fw-bold text-center" style="font-size: 1.1rem; color: var(--navy-blue);">
                                <i class="bi bi-pencil-square me-2"></i>Add Your Review
                            </h3>
                        </div>
                        
                        <div class="card-body p-4">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius: 6px; border-left: 4px solid var(--accent-gold) !important;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2" style="color: var(--primary-blue);"></i>
                                    <div class="small">{{ session('success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-3" style="border-radius: 6px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <div class="small">
                                        <strong>Please fix errors:</strong>
                                        <ul class="mb-0 mt-1 small">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="reviewName" class="form-label small fw-bold text-dark">
                                        Your Name *
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="reviewName" name="name" 
                                           value="{{ old('name') }}" required style="border-radius: 4px; border-color: rgba(30, 58, 138, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewLocation" class="form-label small fw-bold text-dark">
                                        Location *
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="reviewLocation" name="location" 
                                           placeholder="e.g., Kiambu, Nairobi, Thika" 
                                           value="{{ old('location') }}" required style="border-radius: 4px; border-color: rgba(30, 58, 138, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewFarmType" class="form-label small fw-bold text-dark">
                                        Farm Type *
                                    </label>
                                    <select class="form-select form-select-sm" id="reviewFarmType" name="farm_type" required style="border-radius: 4px; border-color: rgba(30, 58, 138, 0.2);">
                                        <option value="">Select Farm Type</option>
                                        <option value="dairy" {{ old('farm_type') == 'dairy' ? 'selected' : '' }}>Dairy Farming</option>
                                        <option value="poultry" {{ old('farm_type') == 'poultry' ? 'selected' : '' }}>Poultry Farming</option>
                                        <option value="pig" {{ old('farm_type') == 'pig' ? 'selected' : '' }}>Pig Farming</option>
                                        <option value="mixed" {{ old('farm_type') == 'mixed' ? 'selected' : '' }}>Mixed Farming</option>
                                        <option value="other" {{ old('farm_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">
                                        Rating *
                                    </label>
                                    <div class="rating-stars mb-2" id="ratingStars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill star-icon {{ old('rating', 5) >= $i ? 'text-warning active' : 'text-secondary' }}" 
                                               data-value="{{ $i }}"
                                               style="font-size: 1.2rem; cursor: pointer; margin-right: 2px; color: {{ old('rating', 5) >= $i ? 'var(--accent-gold)' : '#6c757d' }};"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" id="reviewRating" name="rating" value="{{ old('rating', 5) }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewTitle" class="form-label small fw-bold text-dark">
                                        Review Title *
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="reviewTitle" name="title" 
                                           placeholder="e.g., Excellent Dairy Meal!" 
                                           value="{{ old('title') }}" required style="border-radius: 4px; border-color: rgba(30, 58, 138, 0.2);">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="reviewContent" class="form-label small fw-bold text-dark">
                                        Your Review *
                                    </label>
                                    <textarea class="form-control form-control-sm" id="reviewContent" name="content" 
                                              rows="3" placeholder="Share your experience..." 
                                              required style="border-radius: 4px; border-color: rgba(30, 58, 138, 0.2);">{{ old('content') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-sm w-100" style="border-radius: 4px; background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; border: none;">
                                    <i class="bi bi-send me-1"></i> Submit Review
                                </button>
                                
                                <div class="mt-3 text-center">
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-info-circle me-1"></i>Your review helps other farmers
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section - Classic Design -->
    <section class="py-5 bg-light border-top border-bottom" style="border-color: #e5e7eb !important;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="h2 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-blue);">
                    Trusted by Farmers Nationwide
                </h2>
                <p class="text-muted mb-0">
                    Excellence in quality and service since 2018
                </p>
            </div>
            
            <div class="row g-4">
                <!-- Rating -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-star-fill fs-2" style="color: var(--accent-gold);"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">4.8/5</h3>
                        <p class="text-muted small mb-2">Average Rating</p>
                        <div class="small">
                            <i class="bi bi-star-fill" style="color: var(--accent-gold);"></i>
                            <i class="bi bi-star-fill" style="color: var(--accent-gold);"></i>
                            <i class="bi bi-star-fill" style="color: var(--accent-gold);"></i>
                            <i class="bi bi-star-fill" style="color: var(--accent-gold);"></i>
                            <i class="bi bi-star-half" style="color: var(--accent-gold);"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Happy Farmers -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-people-fill fs-2" style="color: var(--primary-blue);"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">500+</h3>
                        <p class="text-muted small mb-2">Satisfied Farmers</p>
                        <div class="progress" style="height: 3px; width: 80px; margin: 0 auto; background: #e9ecef;">
                            <div class="progress-bar" style="width: 85%; background-color: var(--primary-blue);"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Experience -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-award-fill fs-2" style="color: #8b5cf6;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">5+</h3>
                        <p class="text-muted small mb-2">Years Experience</p>
                        <span class="badge small py-1 px-2" style="background-color: rgba(30, 58, 138, 0.1) !important; color: var(--primary-blue) !important; border: 1px solid rgba(30, 58, 138, 0.2);">
                            <i class="bi bi-check-circle me-1"></i>Established
                        </span>
                    </div>
                </div>
                
                <!-- Recommendation -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-hand-thumbs-up-fill fs-2" style="color: #10b981;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">98%</h3>
                        <p class="text-muted small mb-2">Recommend Us</p>
                        <div class="progress" style="height: 3px; width: 80px; margin: 0 auto; background: #e9ecef;">
                            <div class="progress-bar" style="width: 98%; background-color: var(--secondary-blue);"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Products -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-basket2-fill fs-2" style="color: #f59e0b;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">50+</h3>
                        <p class="text-muted small mb-2">Quality Products</p>
                        <span class="badge bg-light text-warning small py-1 px-2">
                            <i class="bi bi-tags me-1"></i>Variety
                        </span>
                    </div>
                </div>
                
                <!-- Support -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-headset fs-2" style="color: #ec4899;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-blue);">24/7</h3>
                        <p class="text-muted small mb-2">Support</p>
                        <a href="tel:+254786571173" class="btn btn-xs" style="border-color: var(--primary-blue); color: var(--primary-blue); padding: 0.15rem 0.5rem;">
                            <i class="bi bi-telephone me-1"></i> Call Now
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Trust Indicators -->
            <div class="row mt-5 pt-3">
                <div class="col-12">
                    <div class="text-center">
                        <div class="row g-3 justify-content-center">
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(30, 58, 138, 0.1) !important;">
                                    <i class="bi bi-shield-check d-block fs-4 mb-2" style="color: var(--primary-blue);"></i>
                                    <p class="mb-1 fw-semibold small">Premium Quality</p>
                                    <p class="text-muted small mb-0">Guaranteed</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(30, 58, 138, 0.1) !important;">
                                    <i class="bi bi-truck d-block fs-4 mb-2" style="color: var(--secondary-blue);"></i>
                                    <p class="mb-1 fw-semibold small">Reliable Delivery</p>
                                    <p class="text-muted small mb-0">On-time service</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(30, 58, 138, 0.1) !important;">
                                    <i class="bi bi-cash-coin d-block fs-4 mb-2" style="color: var(--accent-gold);"></i>
                                    <p class="mb-1 fw-semibold small">Competitive Prices</p>
                                    <p class="text-muted small mb-0">Best value</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(30, 58, 138, 0.1) !important;">
                                    <i class="bi bi-award d-block fs-4 mb-2" style="color: #8b5cf6;"></i>
                                    <p class="mb-1 fw-semibold small">Expert Advice</p>
                                    <p class="text-muted small mb-0">Professional support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h3 class="h4 fw-bold mb-2" style="color: var(--navy-blue);">
                        <i class="bi bi-chat-left-text me-2"></i>Share Your Experience
                    </h3>
                    <p class="text-muted mb-0">
                        Your feedback helps us improve and assists other farmers in making informed decisions.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#reviewForm" class="btn" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: white; border: none;">
                        <i class="bi bi-pencil-square me-2"></i> Write a Review
                    </a>
                    <a href="{{ route('contact') }}" class="btn ms-2" style="border: 1px solid var(--primary-blue); color: var(--primary-blue); background: transparent;">
                        <i class="bi bi-telephone me-2"></i> Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .reviews-hero {
        position: relative;
        overflow: hidden;
    }
    
    .video-card {
        transition: all 0.3s ease;
    }
    
    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(30, 58, 138, 0.15) !important;
    }
    
    .play-button {
        transition: all 0.3s ease;
    }
    
    .video-thumbnail:hover .play-button {
        transform: scale(1.1);
        background: var(--secondary-blue) !important;
    }
    
    .watch-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(30, 58, 138, 0.3);
    }
    
    .card {
        transition: all 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }
    
    .btn {
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(30, 58, 138, 0.2);
    }
    
    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .btn-xs {
        padding: 0.15rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .star-icon {
        transition: all 0.2s ease;
    }
    
    .star-icon:hover {
        transform: scale(1.2);
    }
    
    .star-icon.active {
        color: var(--accent-gold) !important;
    }
    
    .border {
        border-color: rgba(30, 58, 138, 0.1) !important;
    }
    
    .bg-light {
        background-color: #f9fafb !important;
    }
    
    /* Lazy loading for images */
    .video-thumbnail img {
        transition: opacity 0.3s ease;
        opacity: 1;
    }
    
    .video-thumbnail img.loading {
        opacity: 0.7;
    }
    
    .lazy-load {
        background-color: #f3f4f6;
        background-image: linear-gradient(90deg, #f3f4f6 0%, #e5e7eb 100%);
    }
    
    /* Modal styling */
    .modal-content {
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    /* Form validation styles */
    .needs-validation .form-control:invalid,
    .needs-validation .form-control.is-invalid {
        border-color: #dc3545;
        border-width: 1px;
    }
    
    .needs-validation .form-control:invalid:focus,
    .needs-validation .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }
    
    .was-validated .form-control:invalid {
        border-color: #dc3545;
        border-width: 1px;
    }
    
    .was-validated .form-control:invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }
    
    @media (max-width: 768px) {
        .reviews-hero {
            padding: 4rem 0 3rem;
        }
        
        .display-4 {
            font-size: 2rem;
        }
        
        .h2 {
            font-size: 1.5rem;
        }
        
        .h4 {
            font-size: 1.2rem;
        }
        
        .video-card .card-title {
            font-size: 0.9rem;
        }
        
        .ratio-16x9 {
            --bs-aspect-ratio: 56.25%;
        }
    }
    
    @media (max-width: 576px) {
        .featured-video {
            margin-left: -15px;
            margin-right: -15px;
            border-radius: 0 !important;
        }
    }
</style>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-icon');
    const ratingInput = document.getElementById('reviewRating');
    
    // Initialize stars based on current rating
    updateStars(ratingInput.value);
    
    // Add click event to stars
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        // Add hover effect
        star.addEventListener('mouseenter', function() {
            const hoverRating = this.getAttribute('data-value');
            updateStars(hoverRating, true);
        });
        
        star.addEventListener('mouseleave', function() {
            updateStars(ratingInput.value);
        });
    });
    
    function updateStars(rating, isHover = false) {
        stars.forEach(star => {
            const starValue = star.getAttribute('data-value');
            if (starValue <= rating) {
                star.style.color = 'var(--accent-gold)';
                if (!isHover) {
                    star.classList.add('active');
                }
            } else {
                star.style.color = '#6c757d';
                if (!isHover) {
                    star.classList.remove('active');
                }
            }
        });
    }
    
    // Filter functionality
    const filterAll = document.getElementById('filterAll');
    const filter5 = document.getElementById('filter5');
    const filter4 = document.getElementById('filter4');
    
    if (filterAll) {
        filterAll.addEventListener('click', function() {
            filterReviews('all');
            setActiveFilter(this);
        });
    }
    
    if (filter5) {
        filter5.addEventListener('click', function() {
            filterReviews('5');
            setActiveFilter(this);
        });
    }
    
    if (filter4) {
        filter4.addEventListener('click', function() {
            filterReviews('4');
            setActiveFilter(this);
        });
    }
    
    function filterReviews(rating) {
        const reviews = document.querySelectorAll('.reviews-list .card');
        reviews.forEach(review => {
            if (rating === 'all' || review.getAttribute('data-rating') === rating) {
                review.style.display = 'block';
                setTimeout(() => {
                    review.style.opacity = '1';
                }, 10);
            } else {
                review.style.opacity = '0';
                setTimeout(() => {
                    review.style.display = 'none';
                }, 200);
            }
        });
    }
    
    function setActiveFilter(button) {
        document.querySelectorAll('.btn').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
    }
    
    // Form submission button state
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Submitting...';
            }
        });
    }
    
    // Smooth scroll to review form
    const reviewFormLink = document.querySelector('a[href="#reviewForm"]');
    if (reviewFormLink) {
        reviewFormLink.addEventListener('click', function(e) {
            e.preventDefault();
            const formElement = document.getElementById('reviewForm');
            if (formElement) {
                formElement.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
    
    // Video Modal Functionality
    const videoModal = document.getElementById('videoModal');
    if (videoModal) {
        const youtubePlayer = document.getElementById('youtubePlayer');
        const videoModalLabel = document.getElementById('videoModalLabel');
        const watchOnYoutubeBtn = document.getElementById('watchOnYoutubeBtn');
        
        videoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const videoId = button.getAttribute('data-video-id');
            const videoTitle = button.getAttribute('data-video-title');
            
            // Set the YouTube embed URL
            youtubePlayer.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
            
            // Update modal title
            if (videoTitle) {
                videoModalLabel.textContent = videoTitle;
            }
            
            // Update watch on YouTube button
            watchOnYoutubeBtn.href = `https://www.youtube.com/watch?v=${videoId}`;
        });
        
        videoModal.addEventListener('hidden.bs.modal', function() {
            // Stop the video when modal is closed
            youtubePlayer.src = '';
        });
    }
    
    // Lazy loading for video thumbnails
    const lazyLoadImages = document.querySelectorAll('img.lazy-load');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.dataset.src;
                    if (src) {
                        img.src = src;
                        img.classList.remove('lazy-load');
                    }
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        lazyLoadImages.forEach(img => {
            imageObserver.observe(img);
        });
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyLoadImages.forEach(img => {
            const src = img.dataset.src;
            if (src) {
                img.src = src;
            }
        });
    }
});
</script>
@endsection