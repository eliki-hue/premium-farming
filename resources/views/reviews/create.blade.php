@extends('layouts.app')

@section('title', 'Write a Review - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="text-center mb-6">
                    <h1 class="display-5 fw-bold text-dark mb-3">Write Your Review</h1>
                    <p class="lead text-muted">Share your experience with other farmers</p>
                </div>

                <!-- Review Form -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Personal Information -->
                            <div class="mb-5">
                                <h4 class="mb-4 border-bottom pb-2">👤 Your Information</h4>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customer_name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               value="{{ old('customer_name') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_location" class="form-label">Location (County/Town) *</label>
                                        <input type="text" class="form-control" id="customer_location" name="customer_location" 
                                               value="{{ old('customer_location') }}" required 
                                               placeholder="e.g., Kiambu, Nairobi">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                               value="{{ old('customer_email') }}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                               value="{{ old('customer_phone') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Farm Information -->
                            <div class="mb-5">
                                <h4 class="mb-4 border-bottom pb-2">🐄 Farm Information</h4>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="farm_type" class="form-label">Farm Type *</label>
                                        <select class="form-control" id="farm_type" name="farm_type" required>
                                            <option value="">Select Farm Type</option>
                                            @foreach($farmTypes as $type)
                                            <option value="{{ $type }}" {{ old('farm_type') == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="product_id" class="form-label">Product Reviewed (Optional)</label>
                                        <select class="form-control" id="product_id" name="product_id">
                                            <option value="">Select a Product</option>
                                            @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->category }})
                                            </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Leave blank if reviewing general experience</small>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label for="product_name" class="form-label">Or Enter Product Name</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" 
                                               value="{{ old('product_name') }}" 
                                               placeholder="e.g., Pig Starter Pellets, Dairy Meal">
                                        <small class="text-muted">If you can't find the product in the list above</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-5">
                                <h4 class="mb-4 border-bottom pb-2">⭐ Your Rating</h4>
                                
                                <div class="text-center">
                                    <div class="rating-stars mb-3" id="ratingStars">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star fs-1 text-warning rating-star" 
                                           data-rating="{{ $i }}" 
                                           style="cursor: pointer; margin: 0 5px;"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating" value="{{ old('rating', 5) }}" required>
                                    <div id="ratingText" class="text-muted mb-3">Select your rating</div>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="mb-5">
                                <h4 class="mb-4 border-bottom pb-2">📝 Your Review</h4>
                                
                                <div class="mb-3">
                                    <label for="review" class="form-label">Share Your Experience *</label>
                                    <textarea class="form-control" id="review" name="review" rows="6" required
                                              placeholder="Tell us about your experience with our products or service...">{{ old('review') }}</textarea>
                                    <small class="text-muted">Minimum 20 characters. Be specific about what you liked or didn't like.</small>
                                </div>
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-5">
                                <h4 class="mb-4 border-bottom pb-2">📸 Add a Photo (Optional)</h4>
                                
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Upload Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                    <small class="text-muted">Max 2MB. JPG, PNG, or WebP format. Show us your happy livestock!</small>
                                </div>
                                
                                <div id="photoPreview" class="mt-3 text-center" style="display: none;">
                                    <img id="previewImage" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Submission Guidelines -->
                            <div class="alert alert-info mb-5">
                                <h5><i class="bi bi-info-circle me-2"></i> Submission Guidelines</h5>
                                <ul class="mb-0">
                                    <li>Be honest and specific about your experience</li>
                                    <li>Focus on the product quality and service</li>
                                    <li>No offensive language or personal attacks</li>
                                    <li>Reviews are moderated and approved within 24 hours</li>
                                    <li>You can update or delete your review by contacting us</li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="bi bi-send me-2"></i> Submit Review
                                </button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-outline-secondary ms-2">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rating-star:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
    
    .rating-star.selected {
        color: #ffc107 !important;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
    }
</style>

<script>
// Star Rating
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('ratingText');
    
    const ratingDescriptions = {
        1: "Poor - Very disappointed",
        2: "Fair - Could be better",
        3: "Good - Met expectations",
        4: "Very Good - Exceeded expectations",
        5: "Excellent - Highly recommended"
    };
    
    // Set initial rating
    let currentRating = parseInt(ratingInput.value) || 5;
    updateStars(currentRating);
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        star.addEventListener('mouseover', function() {
            const rating = parseInt(this.dataset.rating);
            highlightStars(rating);
            ratingText.textContent = ratingDescriptions[rating] || "Select your rating";
        });
    });
    
    document.getElementById('ratingStars').addEventListener('mouseleave', function() {
        updateStars(currentRating);
    });
    
    function updateStars(rating) {
        currentRating = rating;
        stars.forEach(star => {
            const starRating = parseInt(star.dataset.rating);
            star.classList.toggle('bi-star-fill', starRating <= rating);
            star.classList.toggle('bi-star', starRating > rating);
        });
        ratingText.textContent = ratingDescriptions[rating] || "Select your rating";
    }
    
    function highlightStars(rating) {
        stars.forEach(star => {
            const starRating = parseInt(star.dataset.rating);
            star.classList.toggle('bi-star-fill', starRating <= rating);
            star.classList.toggle('bi-star', starRating > rating);
        });
    }
    
    // Photo Preview
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('previewImage');
                preview.src = e.target.result;
                document.getElementById('photoPreview').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection