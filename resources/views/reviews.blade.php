{{-- reviews.blade.php --}}
@extends('layouts.app')

@section('title', 'Customer Reviews | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Reviews Hero -->
    <section class="reviews-hero" style="
        background: var(--gradient-dark-green),
                    url('https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=2070') center/cover;
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

    <!-- Featured Video Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-center mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                        <i class="bi bi-play-circle me-2"></i>Featured Video Testimonial
                    </h2>
                    <p class="text-center text-muted mb-0">
                        Watch how proper dairy cow rationing increases milk production
                    </p>
                </div>
            </div>
            
            <!-- Featured Video -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(42, 110, 63, 0.1);">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="https://www.youtube.com/embed/UQ91D2o1OU0" 
                                    title="Proper dairy cow rationing for more milk production"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" 
                                    allowfullscreen
                                    loading="lazy"
                                    class="rounded-top"
                                ></iframe>
                            </div>
                            <div class="p-4">
                                <h3 class="fw-bold mb-2" style="color: var(--navy-green);">
                                    <i class="bi bi-play-btn-fill me-2"></i>Proper dairy cow rationing for more milk production
                                </h3>
                                <p class="text-muted mb-3">
                                    Learn how our specialized dairy feeds and proper rationing techniques can significantly increase your milk production. This video demonstrates real results from farmers using Premium Farming Feeds.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <span class="badge" style="
                                        background: rgba(56, 161, 105, 0.1);
                                        color: var(--primary-green);
                                        border: 1px solid rgba(56, 161, 105, 0.2);
                                    ">
                                        <i class="bi bi-droplet me-1"></i>Dairy Farming
                                    </span>
                                    <span class="badge" style="
                                        background: rgba(247, 127, 0, 0.1);
                                        color: #f77f00;
                                        border: 1px solid rgba(247, 127, 0, 0.2);
                                    ">
                                        <i class="bi bi-cup-straw me-1"></i>Milk Production
                                    </span>
                                    <span class="badge" style="
                                        background: rgba(156, 163, 175, 0.1);
                                        color: #6b7280;
                                        border: 1px solid rgba(156, 163, 175, 0.2);
                                    ">
                                        <i class="bi bi-calendar3 me-1"></i>Updated Recently
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Reviews Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-center mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                        <i class="bi bi-collection-play me-2"></i>More Video Testimonials
                    </h2>
                    <p class="text-center text-muted mb-0">
                        Watch real farmers share their experiences with our products
                    </p>
                </div>
            </div>
            
            <!-- Video Cards Grid -->
            <div class="row g-4" id="videoReviewsContainer">
                @php
                    $youtubeVideos = [
                        [
                            'id' => 'dairy1',
                            'title' => 'Dairy Farmer Success Story',
                            'description' => 'Mwalimu Lawrence from Kiambu shares how our dairy feeds increased milk production by 50%',
                            'channel' => 'Premium Feeds Customer',
                            'views' => '1.2K',
                            'date' => '2 months ago',
                            'duration' => '4:20',
                            'thumbnail' => 'https://img.youtube.com/vi/UQ91D2o1OU0/maxresdefault.jpg',
                            'embedId' => 'UQ91D2o1OU0',
                            'category' => 'Dairy'
                        ],
                        [
                            'id' => 'poultry1',
                            'title' => 'Poultry Farming Transformation',
                            'description' => 'Mary shows her broiler growth results after switching to our feeds',
                            'channel' => 'Happy Farmer TV',
                            'views' => '850',
                            'date' => '1 month ago',
                            'duration' => '3:45',
                            'thumbnail' => 'https://img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg',
                            'embedId' => '9bZkp7q19f0',
                            'category' => 'Poultry'
                        ],
                        [
                            'id' => 'pig1',
                            'title' => 'Pig Farming Results',
                            'description' => 'Peter demonstrates weight gain in his pigs using our specialized feeds',
                            'channel' => 'Farm Success Stories',
                            'views' => '2.1K',
                            'date' => '3 months ago',
                            'duration' => '5:15',
                            'thumbnail' => 'https://img.youtube.com/vi/JGwWNGJdvx8/maxresdefault.jpg',
                            'embedId' => 'JGwWNGJdvx8',
                            'category' => 'Pig'
                        ],
                        [
                            'id' => 'mixed1',
                            'title' => 'Mixed Farming Success',
                            'description' => 'Kamau shares his experience with our complete farming solution',
                            'channel' => 'Kenya Farmers Hub',
                            'views' => '3.4K',
                            'date' => '4 months ago',
                            'duration' => '6:30',
                            'thumbnail' => 'https://img.youtube.com/vi/60ItHLz5WEA/maxresdefault.jpg',
                            'embedId' => '60ItHLz5WEA',
                            'category' => 'Mixed'
                        ],
                        [
                            'id' => 'service1',
                            'title' => 'Customer Service Review',
                            'description' => 'Sarah praises our delivery and technical support team',
                            'channel' => 'Agri Business Reviews',
                            'views' => '950',
                            'date' => '2 weeks ago',
                            'duration' => '4:10',
                            'thumbnail' => 'https://img.youtube.com/vi/mWRsgZuwf_8/maxresdefault.jpg',
                            'embedId' => 'mWRsgZuwf_8',
                            'category' => 'Service'
                        ],
                        [
                            'id' => 'farmvisit1',
                            'title' => 'Farm Visit & Review',
                            'description' => 'See our products in action at a real farm in Nakuru',
                            'channel' => 'Premium Farming Feeds',
                            'views' => '5.2K',
                            'date' => '6 months ago',
                            'duration' => '7:45',
                            'thumbnail' => 'https://img.youtube.com/vi/LDU_Txk06tM/maxresdefault.jpg',
                            'embedId' => 'LDU_Txk06tM',
                            'category' => 'Farm Visit'
                        ]
                    ];
                @endphp
                
                @foreach($youtubeVideos as $video)
                <div class="col-lg-4 col-md-6">
                    <div class="video-card card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden; border: 1px solid rgba(42, 110, 63, 0.1);">
                        <!-- Video Thumbnail with Play Button -->
                        <div class="video-thumbnail position-relative" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="{{ $video['embedId'] }}" data-video-title="{{ $video['title'] }}">
                            <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" class="img-fluid w-100 lazy-load" 
                                 data-src="{{ $video['thumbnail'] }}" 
                                 style="height: 200px; object-fit: cover;"
                                 onerror="this.src='https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070&auto=format&fit=crop'">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
                                <div class="play-button rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(56, 161, 105, 0.9);">
                                    <i class="bi bi-play-fill text-white fs-3"></i>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75 py-1 px-2" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $video['duration'] }}
                                </span>
                            </div>
                            @if($video['category'] == 'Dairy')
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge py-1 px-2" style="
                                    background: var(--gradient-green);
                                    color: white;
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
                                        background: rgba(56, 161, 105, 0.1);
                                        color: var(--primary-green);
                                        border: 1px solid rgba(56, 161, 105, 0.2);
                                        font-size: 0.75rem;
                                    ">
                                        <i class="bi bi-person-circle me-1"></i>{{ $video['channel'] }}
                                    </span>
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-eye me-1"></i>{{ $video['views'] }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Footer -->
                        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $video['date'] }}
                                </small>
                                <button class="btn btn-sm watch-btn" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="{{ $video['embedId'] }}" data-video-title="{{ $video['title'] }}" style="
                                    background: var(--gradient-green);
                                    color: white;
                                    padding: 0.25rem 0.75rem;
                                    font-size: 0.8rem;
                                ">
                                    <i class="bi bi-play-circle me-1"></i>Watch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Load More Button (Optional) -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button id="loadMoreVideos" class="btn" style="
                        border: 1px solid var(--primary-green);
                        color: var(--primary-green);
                    ">
                        <i class="bi bi-plus-circle me-2"></i>Load More Videos
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0" style="border-radius: 8px; overflow: hidden;">
                <div class="modal-header border-0 bg-dark">
                    <h5 class="modal-title text-white" id="videoModalLabel">Customer Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtubePlayer" src="" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                <div class="modal-footer bg-dark border-0">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal" style="
                        border: 1px solid white;
                        color: white;
                    ">
                        Close
                    </button>
                    <a href="https://www.youtube.com/watch?v=UQ91D2o1OU0" target="_blank" class="btn btn-sm" style="
                        background: #ff0000;
                        color: white;
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
                        <h2 class="fw-bold mb-0" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">Written Reviews</h2>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm active" id="filterAll" style="border: 1px solid var(--primary-green); color: var(--primary-green);">All</button>
                            <button class="btn btn-sm" id="filter5" style="border: 1px solid var(--primary-green); color: var(--primary-green);">5 Stars</button>
                            <button class="btn btn-sm" id="filter4" style="border: 1px solid var(--primary-green); color: var(--primary-green);">4 Stars</button>
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
                                'color' => 'green'
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
                                'color' => 'green'
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
                                'color' => 'green'
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
                                'color' => 'green'
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
                                'color' => 'green'
                            ]
                        ] as $review)
                        <div class="card border-0 shadow-sm mb-4" data-rating="{{ $review['rating'] }}" style="border-radius: 8px; border: 1px solid rgba(42, 110, 63, 0.1);">
                            <div class="card-body p-4">
                                <div class="row align-items-start">
                                    <div class="col-md-2 text-center mb-3 mb-md-0">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                             style="width: 50px; height: 50px; background: var(--gradient-green);">
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
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $review['date'] }}</small>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="mb-0 fw-bold text-dark">{{ $review['title'] }}</h5>
                                            <span class="badge ms-3" style="
                                                background: rgba(56, 161, 105, 0.1);
                                                color: var(--primary-green);
                                                border: 1px solid rgba(56, 161, 105, 0.2);
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
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px; border-radius: 8px; border: 1px solid rgba(42, 110, 63, 0.1);">
                        <div class="card-header bg-white border-bottom py-3">
                            <h3 class="card-title mb-0 fw-bold text-center" style="font-size: 1.1rem; color: var(--navy-green);">
                                <i class="bi bi-pencil-square me-2"></i>Add Your Review
                            </h3>
                        </div>
                        
                        <div class="card-body p-4">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius: 6px; border-left: 4px solid var(--secondary-green) !important;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2" style="color: var(--secondary-green);"></i>
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
                                           value="{{ old('name') }}" required style="border-radius: 4px; border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewLocation" class="form-label small fw-bold text-dark">
                                        Location *
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="reviewLocation" name="location" 
                                           placeholder="e.g., Kiambu, Nairobi, Thika" 
                                           value="{{ old('location') }}" required style="border-radius: 4px; border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewFarmType" class="form-label small fw-bold text-dark">
                                        Farm Type *
                                    </label>
                                    <select class="form-select form-select-sm" id="reviewFarmType" name="farm_type" required style="border-radius: 4px; border-color: rgba(42, 110, 63, 0.2);">
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
                                               style="font-size: 1.2rem; cursor: pointer; margin-right: 2px;"></i>
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
                                           value="{{ old('title') }}" required style="border-radius: 4px; border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="reviewContent" class="form-label small fw-bold text-dark">
                                        Your Review *
                                    </label>
                                    <textarea class="form-control form-control-sm" id="reviewContent" name="content" 
                                              rows="3" placeholder="Share your experience..." 
                                              required style="border-radius: 4px; border-color: rgba(42, 110, 63, 0.2);">{{ old('content') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-sm w-100" style="border-radius: 4px; background: var(--gradient-green); color: white;">
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
                <h2 class="h2 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
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
                            <i class="bi bi-star-fill fs-2" style="color: var(--gold-green);"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">4.8/5</h3>
                        <p class="text-muted small mb-2">Average Rating</p>
                        <div class="small">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Happy Farmers -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-people-fill fs-2" style="color: var(--primary-green);"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">500+</h3>
                        <p class="text-muted small mb-2">Satisfied Farmers</p>
                        <div class="progress" style="height: 3px; width: 80px; margin: 0 auto;">
                            <div class="progress-bar" style="width: 85%; background-color: var(--primary-green);"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Experience -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-award-fill fs-2" style="color: #8b5cf6;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">5+</h3>
                        <p class="text-muted small mb-2">Years Experience</p>
                        <span class="badge small py-1 px-2" style="background-color: rgba(56, 161, 105, 0.1) !important; color: var(--primary-green) !important; border: 1px solid rgba(56, 161, 105, 0.2);">
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
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">98%</h3>
                        <p class="text-muted small mb-2">Recommend Us</p>
                        <div class="progress" style="height: 3px; width: 80px; margin: 0 auto;">
                            <div class="progress-bar" style="width: 98%; background-color: var(--secondary-green);"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Products -->
                <div class="col-md-4 col-lg-2">
                    <div class="text-center py-3">
                        <div class="mb-3">
                            <i class="bi bi-basket2-fill fs-2" style="color: #f59e0b;"></i>
                        </div>
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">50+</h3>
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
                        <h3 class="fw-bold mb-1" style="color: var(--navy-green);">24/7</h3>
                        <p class="text-muted small mb-2">Support</p>
                        <a href="tel:+254786571173" class="btn btn-xs" style="border-color: var(--primary-green); color: var(--primary-green); padding: 0.15rem 0.5rem;">
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
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(42, 110, 63, 0.1) !important;">
                                    <i class="bi bi-shield-check d-block fs-4 mb-2" style="color: var(--secondary-green);"></i>
                                    <p class="mb-1 fw-semibold small">Premium Quality</p>
                                    <p class="text-muted small mb-0">Guaranteed</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(42, 110, 63, 0.1) !important;">
                                    <i class="bi bi-truck d-block fs-4 mb-2" style="color: var(--primary-green);"></i>
                                    <p class="mb-1 fw-semibold small">Reliable Delivery</p>
                                    <p class="text-muted small mb-0">On-time service</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(42, 110, 63, 0.1) !important;">
                                    <i class="bi bi-cash-coin text-warning d-block fs-4 mb-2"></i>
                                    <p class="mb-1 fw-semibold small">Competitive Prices</p>
                                    <p class="text-muted small mb-0">Best value</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 bg-light" style="border-color: rgba(42, 110, 63, 0.1) !important;">
                                    <i class="bi bi-award text-danger d-block fs-4 mb-2"></i>
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
                    <h3 class="h4 fw-bold mb-2" style="color: var(--navy-green);">
                        <i class="bi bi-chat-left-text me-2"></i>Share Your Experience
                    </h3>
                    <p class="text-muted mb-0">
                        Your feedback helps us improve and assists other farmers in making informed decisions.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#reviewForm" class="btn" style="background: var(--gradient-green); color: white;">
                        <i class="bi bi-pencil-square me-2"></i> Write a Review
                    </a>
                    <a href="{{ route('contact') }}" class="btn ms-2" style="border: 1px solid var(--primary-green); color: var(--primary-green);">
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
        box-shadow: 0 6px 20px rgba(42, 110, 63, 0.15) !important;
    }
    
    .play-button {
        transition: all 0.3s ease;
    }
    
    .video-thumbnail:hover .play-button {
        transform: scale(1.1);
        background: rgba(56, 161, 105, 1) !important;
    }
    
    .watch-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(56, 161, 105, 0.3);
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
        box-shadow: 0 4px 8px rgba(42, 110, 63, 0.2);
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
        color: #ffc107 !important;
    }
    
    .border {
        border-color: rgba(42, 110, 63, 0.1) !important;
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
    
    /* Featured video styling */
    .featured-video {
        position: relative;
    }
    
    .featured-video:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-green);
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
                star.classList.remove('text-secondary');
                star.classList.add('text-warning');
                if (!isHover) {
                    star.classList.add('active');
                }
            } else {
                star.classList.remove('text-warning');
                star.classList.add('text-secondary');
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
        
        videoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const videoId = button.getAttribute('data-video-id');
            const videoTitle = button.getAttribute('data-video-title');
            
            // Set the YouTube embed URL with autoplay
            youtubePlayer.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
            
            // Update modal title
            if (videoTitle) {
                videoModalLabel.textContent = videoTitle;
            }
        });
        
        videoModal.addEventListener('hidden.bs.modal', function() {
            // Stop the video when modal is closed
            youtubePlayer.src = '';
        });
    }
    
    // Load More Videos Functionality
    const loadMoreBtn = document.getElementById('loadMoreVideos');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const container = document.getElementById('videoReviewsContainer');
            const loadingText = this.innerHTML;
            
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
            
            // Simulate loading more videos (in real app, this would be an AJAX call)
            setTimeout(() => {
                // Example additional videos (in real app, fetch from server)
                const additionalVideos = [
                    {
                        'id': 'sample7',
                        'title': 'Quality Assurance Process',
                        'description' => 'See how we ensure quality in every batch of our feeds',
                        'channel' => 'Premium Farming Feeds',
                        'views' => '3.8K',
                        'date' => '5 months ago',
                        'duration': '5:45',
                        'thumbnail': 'https://img.youtube.com/vi/L_jWHffIx5E/maxresdefault.jpg',
                        'embedId': 'L_jWHffIx5E',
                        'category': 'Quality'
                    },
                    {
                        'id': 'sample8',
                        'title': 'Farmers Training Session',
                        'description' => 'Our nutritionist training farmers on proper feeding techniques',
                        'channel' => 'Agri Education',
                        'views' => '2.7K',
                        'date' => '7 months ago',
                        'duration': '8:20',
                        'thumbnail': 'https://img.youtube.com/vi/CduA0TULnow/maxresdefault.jpg',
                        'embedId': 'CduA0TULnow',
                        'category': 'Training'
                    }
                ];
                
                // Add new videos to container
                additionalVideos.forEach(video => {
                    const videoCard = document.createElement('div');
                    videoCard.className = 'col-lg-4 col-md-6';
                    videoCard.innerHTML = `
                        <div class="video-card card border-0 shadow-sm h-100" style="border-radius: 8px; overflow: hidden; border: 1px solid rgba(42, 110, 63, 0.1);">
                            <div class="video-thumbnail position-relative" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="${video.embedId}" data-video-title="${video.title}">
                                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070&auto=format&fit=crop" alt="${video.title}" class="img-fluid w-100 lazy-load" 
                                     data-src="${video.thumbnail}" 
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.src='https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070&auto=format&fit=crop'">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
                                    <div class="play-button rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(56, 161, 105, 0.9);">
                                        <i class="bi bi-play-fill text-white fs-3"></i>
                                    </div>
                                </div>
                                <div class="position-absolute bottom-0 end-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75 py-1 px-2" style="font-size: 0.7rem;">
                                        <i class="bi bi-clock me-1"></i>${video.duration}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold mb-2 text-dark" style="font-size: 0.95rem; line-height: 1.3;">
                                    ${video.title}
                                </h6>
                                <p class="card-text text-muted small mb-2" style="font-size: 0.85rem;">
                                    ${video.description}
                                </p>
                                
                                <div class="video-meta d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge" style="
                                            background: rgba(56, 161, 105, 0.1);
                                            color: var(--primary-green);
                                            border: 1px solid rgba(56, 161, 105, 0.2);
                                            font-size: 0.75rem;
                                        ">
                                            <i class="bi bi-person-circle me-1"></i>${video.channel}
                                        </span>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-eye me-1"></i>${video.views}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>${video.date}
                                    </small>
                                    <button class="btn btn-sm watch-btn" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-id="${video.embedId}" data-video-title="${video.title}" style="
                                        background: var(--gradient-green);
                                        color: white;
                                        padding: 0.25rem 0.75rem;
                                        font-size: 0.8rem;
                                    ">
                                        <i class="bi bi-play-circle me-1"></i>Watch
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(videoCard);
                    
                    // Initialize lazy loading for the new image
                    const img = videoCard.querySelector('img.lazy-load');
                    if (img) {
                        img.src = img.dataset.src;
                    }
                });
                
                // Hide load more button if we have enough videos
                if (container.children.length >= 8) {
                    loadMoreBtn.style.display = 'none';
                } else {
                    // Reset button state
                    this.disabled = false;
                    this.innerHTML = loadingText;
                }
            }, 1000);
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
    
    // Play featured video in modal when clicking on card
    const videoThumbnails = document.querySelectorAll('.video-thumbnail');
    videoThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const videoId = this.getAttribute('data-video-id');
            const videoTitle = this.getAttribute('data-video-title');
            
            // Special handling for the featured video (UQ91D2o1OU0)
            if (videoId === 'UQ91D2o1OU0') {
                // Open in modal
                const modal = new bootstrap.Modal(document.getElementById('videoModal'));
                const youtubePlayer = document.getElementById('youtubePlayer');
                const videoModalLabel = document.getElementById('videoModalLabel');
                
                youtubePlayer.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&playsinline=1`;
                videoModalLabel.textContent = videoTitle || 'Proper dairy cow rationing for more milk production';
                modal.show();
            }
        });
    });
});
</script>
@endsection