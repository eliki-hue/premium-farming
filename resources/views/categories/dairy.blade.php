@extends('layouts.app')

@section('title', 'Dairy Feeds | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        Premium Dairy Feeds
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        Scientifically formulated feeds for maximum milk production and cow health
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">40%</div>
                        <div class="stat-label">More Milk Production</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">18%</div>
                        <div class="stat-label">Higher Protein</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">5000+</div>
                        <div class="stat-label">Happy Dairy Farmers</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Natural Ingredients</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Our Dairy Feed Range</h2>
                <p>Complete nutrition solutions for all dairy production stages</p>
            </div>

            <div class="row g-4">
                <!-- High Yield Dairy Plus -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/sdairy.jpeg') }}" alt="High Yield Dairy Plus" class="product-image-full">
                            <span class="product-badge premium">⭐ Premium</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">High Yield Dairy Plus</h4>
                            <p class="text-muted mb-3">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>Target: 10-20+ Liters/Day</small>
                            </p>
                            <p class="product-description mb-3">
                                Premium feed for maximum milk production with 18%+ crude protein.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">18%+</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Energy:</span>
                                    <span class="fw-bold text-warning">High</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">Peak Production</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 3,200</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <button class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dairy Meal Standard -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/darym.jpeg') }}" alt="Dairy Meal Standard" class="product-image-full">
                            <span class="product-badge standard">Standard</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Dairy Meal Standard</h4>
                            <p class="text-muted mb-3">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>Target: 7-10 Liters/Day</small>
                            </p>
                            <p class="product-description mb-3">
                                Affordable daily feed with balanced nutrition for consistent production.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">15-16%</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Energy:</span>
                                    <span class="fw-bold text-warning">Balanced</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">Daily Maintenance</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,850</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <button class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dairy MaxPro -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/dairyh.jpeg') }}" alt="Dairy MaxPro" class="product-image-full">
                            <span class="product-badge premium">Premium</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Dairy MaxPro</h4>
                            <p class="text-muted mb-3">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>Target: Maximum Yield</small>
                            </p>
                            <p class="product-description mb-3">
                                Advanced formula for fertility support and fast post-calving recovery.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">Up to 19.5%</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Energy:</span>
                                    <span class="fw-bold text-warning">Very High</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">Fertility & Recovery</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 3,500</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <button class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tips Section -->
    <section class="section">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Dairy Farming Tips</h2>
                <p>Expert advice for better milk production</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-droplet-half fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Water Availability</h5>
                        <p class="text-muted">Ensure 24/7 access to clean water. A dairy cow drinks 3-4 liters of water for every liter of milk produced.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-clock fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Consistent Feeding</h5>
                        <p class="text-muted">Feed at regular intervals to maintain rumen pH and maximize nutrient absorption.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-heart-pulse fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Health Monitoring</h5>
                        <p class="text-muted">Regular health checks and vaccination schedules ensure optimal production.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Boost Your Milk Production Today!</h2>
                <p class="cta-text">
                    Join thousands of successful dairy farmers using Premium Farming Feeds.
                </p>
                <a href="{{ route('products') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3">
                    <i class="bi bi-cart-check me-2"></i>
                    Order Now
                </a>
                <a href="/contact" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-telephone me-2"></i>
                    Get Consultation
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        min-height: 60vh;
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1542838135-2dbba2fff66c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    /* Product Card with Large Visible Images */
    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }
    
    /* FULL SIZE IMAGE CONTAINER - No cropping */
    .product-image-container {
        position: relative;
        height: 300px; /* Fixed height for consistency */
        width: 100%;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .product-image-full {
        width: 100%;
        height: 100%;
        object-fit: contain !important; /* Show full image without cropping */
        object-position: center center;
        padding: 20px; /* Space around the image */
        transition: transform 0.5s ease;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }
    
    .product-card:hover .product-image-full {
        transform: scale(1.05);
        padding: 15px;
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        z-index: 2;
    }
    
    .product-badge.premium {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .product-badge.standard {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }
    
    .product-badge.calf {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
    }
    
    .product-badge.dog {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white;
    }
    
    .product-badge.rabbit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }
    
    .product-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-description {
        flex-grow: 1;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .price-tag {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .product-specs {
        background: rgba(42, 110, 63, 0.05);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .product-image-container {
            height: 280px;
        }
    }
    
    @media (max-width: 992px) {
        .product-image-container {
            height: 250px;
        }
        
        .product-image-full {
            padding: 15px;
        }
    }
    
    @media (max-width: 768px) {
        .product-image-container {
            height: 220px;
        }
        
        .product-content {
            padding: 1.25rem;
        }
        
        .price-tag {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .product-image-container {
            height: 200px;
        }
        
        .product-image-full {
            padding: 10px;
        }
    }
</style>

@endsection