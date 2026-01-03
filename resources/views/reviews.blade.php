@extends('layouts.app')

@section('title', 'Customer Reviews - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Reviews Hero -->
    <section class="reviews-hero" style="
        background: linear-gradient(rgba(30, 82, 46, 0.9), rgba(42, 110, 63, 0.9)),
                    url('https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=2070') center/cover;
        padding: 6rem 0;
        color: white;
        text-align: center;
    ">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Customer Reviews</h1>
            <p class="lead mb-0">See what our farmers are saying about our products and services</p>
        </div>
    </section>

    <!-- Reviews Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Reviews List -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="fw-bold">All Reviews</h2>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success" id="filterAll">All</button>
                            <button class="btn btn-outline-success" id="filter5">5 Stars</button>
                            <button class="btn btn-outline-success" id="filter4">4 Stars</button>
                        </div>
                    </div>

                    <!-- Dummy Reviews -->
                    <div class="reviews-list">
                        <!-- Review 1 -->
                        <div class="card border-0 shadow-sm mb-4" data-rating="5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-white fw-bold fs-4">J</span>
                                        </div>
                                        <h6 class="mb-0">James Kariuki</h6>
                                        <small class="text-muted">Kiambu</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <span class="badge bg-success">Dairy Farming</span>
                                            </div>
                                            <small class="text-muted">March 15, 2024</small>
                                        </div>
                                        <h5 class="mb-2">Excellent Dairy Meal!</h5>
                                        <p class="mb-0">"The dairy meal increased my milk production by 30%. My cows are healthier and more productive. The delivery was on time and the customer service is excellent! I recommend Premium Farming Feeds to all dairy farmers."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review 2 -->
                        <div class="card border-0 shadow-sm mb-4" data-rating="5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-white fw-bold fs-4">M</span>
                                        </div>
                                        <h6 class="mb-0">Mary Wanjiku</h6>
                                        <small class="text-muted">Nairobi</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <span class="badge bg-warning text-dark">Poultry Farming</span>
                                            </div>
                                            <small class="text-muted">March 10, 2024</small>
                                        </div>
                                        <h5 class="mb-2">Best Poultry Feeds!</h5>
                                        <p class="mb-0">"My broilers gained weight faster with Premium feeds compared to other brands I've tried. The technical advice from their team helped me reduce mortality rates. Their feeds are well-balanced and affordable."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review 3 -->
                        <div class="card border-0 shadow-sm mb-4" data-rating="4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-white fw-bold fs-4">P</span>
                                        </div>
                                        <h6 class="mb-0">Peter Maina</h6>
                                        <small class="text-muted">Thika</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-half text-warning"></i>
                                                </div>
                                                <span class="badge bg-danger">Pig Farming</span>
                                            </div>
                                            <small class="text-muted">March 5, 2024</small>
                                        </div>
                                        <h5 class="mb-2">Reliable Service</h5>
                                        <p class="mb-0">"Quality feeds at affordable prices. The delivery service to my farm is reliable even during rainy seasons. My pigs have shown significant growth improvement since switching to Premium feeds."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review 4 -->
                        <div class="card border-0 shadow-sm mb-4" data-rating="5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-white fw-bold fs-4">S</span>
                                        </div>
                                        <h6 class="mb-0">Sarah Njeri</h6>
                                        <small class="text-muted">Murang'a</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <span class="badge bg-success">Dairy Farming</span>
                                            </div>
                                            <small class="text-muted">February 28, 2024</small>
                                        </div>
                                        <h5 class="mb-2">Great Customer Support</h5>
                                        <p class="mb-0">"Whenever I have questions about feeding schedules or nutrition, their technical team is always available to help. The feeds have improved my herd's health significantly."</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review 5 -->
                        <div class="card border-0 shadow-sm mb-4" data-rating="4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                             style="width: 60px; height: 60px;">
                                            <span class="text-white fw-bold fs-4">K</span>
                                        </div>
                                        <h6 class="mb-0">Kamau Waweru</h6>
                                        <small class="text-muted">Nakuru</small>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div>
                                                <div class="mb-2">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star text-warning"></i>
                                                </div>
                                                <span class="badge bg-primary">Mixed Farming</span>
                                            </div>
                                            <small class="text-muted">February 20, 2024</small>
                                        </div>
                                        <h5 class="mb-2">Good Quality Feeds</h5>
                                        <p class="mb-0">"I use their feeds for both my poultry and dairy cows. The quality is consistent and the animals are healthy. I appreciate the bulk delivery discounts they offer for large orders."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Review Form -->
<!-- Add Review Form -->
<div class="col-lg-4">
    <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
        <div class="card-body p-4">
            <h3 class="card-title mb-4 text-center">Add Your Review</h3>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" id="successAlert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" id="errorAlert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="reviewName" class="form-label">Your Name *</label>
                    <input type="text" class="form-control" id="reviewName" name="name" 
                           value="{{ old('name') }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="reviewLocation" class="form-label">Location *</label>
                    <input type="text" class="form-control" id="reviewLocation" name="location" 
                           placeholder="e.g., Kiambu, Nairobi, Thika" 
                           value="{{ old('location') }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="reviewFarmType" class="form-label">Farm Type *</label>
                    <select class="form-select" id="reviewFarmType" name="farm_type" required>
                        <option value="">Select Farm Type</option>
                        <option value="dairy" {{ old('farm_type') == 'dairy' ? 'selected' : '' }}>Dairy Farming</option>
                        <option value="poultry" {{ old('farm_type') == 'poultry' ? 'selected' : '' }}>Poultry Farming</option>
                        <option value="pig" {{ old('farm_type') == 'pig' ? 'selected' : '' }}>Pig Farming</option>
                        <option value="mixed" {{ old('farm_type') == 'mixed' ? 'selected' : '' }}>Mixed Farming</option>
                        <option value="other" {{ old('farm_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Rating *</label>
                    <div class="rating-stars mb-2" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star-fill star-icon {{ old('rating', 5) >= $i ? 'text-warning active' : 'text-secondary' }}" 
                               data-value="{{ $i }}"
                               style="font-size: 1.8rem; cursor: pointer; margin-right: 5px;"></i>
                        @endfor
                    </div>
                    <input type="hidden" id="reviewRating" name="rating" value="{{ old('rating', 5) }}">
                </div>
                
                <div class="mb-3">
                    <label for="reviewTitle" class="form-label">Review Title *</label>
                    <input type="text" class="form-control" id="reviewTitle" name="title" 
                           placeholder="e.g., Excellent Dairy Meal!" 
                           value="{{ old('title') }}" required>
                </div>
                
                <div class="mb-4">
                    <label for="reviewContent" class="form-label">Your Review *</label>
                    <textarea class="form-control" id="reviewContent" name="content" 
                              rows="4" placeholder="Share your experience..." 
                              required>{{ old('content') }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-success w-100 py-2" id="submitReviewBtn">
                    <i class="bi bi-send me-2"></i> Submit Review
                </button>
                
                <div class="mt-3 text-center">
                    <p class="text-muted small mb-0">
                        Your review will help other farmers make informed decisions
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>
        </div>
    </section>
</div>

<style>
    .reviews-hero {
        background-size: cover;
        background-position: center;
    }
    
    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .star-icon {
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .star-icon.active {
        color: #ffc107 !important;
    }
    
    .star-icon:hover {
        color: #ffc107;
    }
</style>

<script>
    // Simple star rating functionality
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
        
        // Form submission - simple validation
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                // Basic validation
                const name = document.getElementById('reviewName').value.trim();
                const location = document.getElementById('reviewLocation').value.trim();
                const farmType = document.getElementById('reviewFarmType').value;
                const title = document.getElementById('reviewTitle').value.trim();
                const content = document.getElementById('reviewContent').value.trim();
                
                let isValid = true;
                
                // Clear previous error highlights
                document.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                
                // Validate each field
                if (!name) {
                    document.getElementById('reviewName').classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!location) {
                    document.getElementById('reviewLocation').classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!farmType) {
                    document.getElementById('reviewFarmType').classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!title) {
                    document.getElementById('reviewTitle').classList.add('is-invalid');
                    isValid = false;
                }
                
                if (!content || content.length < 10) {
                    document.getElementById('reviewContent').classList.add('is-invalid');
                    isValid = false;
                }
                
                // If validation fails, prevent form submission
                if (!isValid) {
                    e.preventDefault();
                    
                    // Show error message
                    const errorAlert = document.getElementById('errorAlert');
                    if (!errorAlert) {
                        const form = document.getElementById('reviewForm');
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show mb-3';
                        alertDiv.id = 'errorAlert';
                        alertDiv.innerHTML = `
                            <strong>Please fill in all required fields correctly.</strong>
                            <ul class="mb-0 mt-2">
                                <li>All fields marked with * are required</li>
                                <li>Review must be at least 10 characters long</li>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        form.parentNode.insertBefore(alertDiv, form);
                    }
                } else {
                    // Disable button to prevent double submission
                    const submitBtn = document.getElementById('submitReviewBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Submitting...';
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
                } else {
                    review.style.display = 'none';
                }
            });
        }
        
        function setActiveFilter(button) {
            document.querySelectorAll('.btn-outline-success').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        }
    });
</script>

<style>
    /* Add some custom styles */
    .star-icon {
        transition: all 0.2s ease;
    }
    
    .star-icon:hover {
        transform: scale(1.2);
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .alert {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
@endsection