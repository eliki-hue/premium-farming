@extends('layouts.app')

@section('title', 'Swine Feeds | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('videos/kkk.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="container hero-overlay">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        Premium Swine Feeds
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        Complete nutrition solutions for profitable pig farming
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Complete Swine Feed Range</h2>
                <p>Specialized feeds for every growth stage</p>
            </div>

            <div class="row g-4">
                <!-- Pig Starter -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/piggrower.jpeg') }}" alt="Pig Starter Pellets" class="product-image-full">
                            <span class="product-badge pig">🐷 Starter</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Pig Starter Pellets</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Piglets (3-10 weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                Supports early growth and smooth weaning for piglets (3-10 weeks, 10-25kg).
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-danger">18-22%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Weight:</span>
                                    <span class="fw-bold">10-25kg</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 3,200</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="12">
                                    <input type="hidden" name="name" value="Pig Starter Pellets">
                                    <input type="hidden" name="price" value="3200">
                                    <input type="hidden" name="image" value="images/piggrower.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pig Grower -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/spig grower.jpeg') }}" alt="Pig Growers" class="product-image-full">
                            <span class="product-badge pig">🐖 Grower</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Pig Growers</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Growing Pigs (8-16 weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                Optimizes muscle development and steady weight gain (8-16 weeks, 25-60kg).
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">16-18%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Weight:</span>
                                    <span class="fw-bold">25-60kg</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,950</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="13">
                                    <input type="hidden" name="name" value="Pig Growers">
                                    <input type="hidden" name="price" value="2950">
                                    <input type="hidden" name="image" value="images/spig grower.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sow & Weaner -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/sowwen.jpeg') }}" alt="Sow and Weaner Feed" class="product-image-full">
                            <span class="product-badge pig">🐷 Sow & Weaner</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Sow and Weaner Feed</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Breeding Stock</small>
                            </p>
                            <p class="product-description mb-3">
                                Supports reproduction, milk production for sows, gilts and boars.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">16-18%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>For:</span>
                                    <span class="fw-bold">Sows & Gilts</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 3,100</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="14">
                                    <input type="hidden" name="name" value="Sow and Weaner Feed">
                                    <input type="hidden" name="price" value="3100">
                                    <input type="hidden" name="image" value="images/sowwen.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pig Finisher -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/pfter.jpeg') }}" alt="Pig Fattener" class="product-image-full">
                            <span class="product-badge pig premium">⭐ Finisher</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Pig Fattener</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Market Pigs (16+ weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                Maximizes weight gain and meat quality before market (60kg+).
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-warning">14-16%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Weight:</span>
                                    <span class="fw-bold">60kg+</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,850</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="15">
                                    <input type="hidden" name="name" value="Pig Fattener">
                                    <input type="hidden" name="price" value="2850">
                                    <input type="hidden" name="image" value="images/pfter.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
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
                <h2>Swine Farming Tips</h2>
                <p>Best practices for profitable pig farming</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-house fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Proper Housing</h5>
                        <p class="text-muted">Provide clean, dry, and well-ventilated housing with adequate space per pig.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-droplet fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Clean Water</h5>
                        <p class="text-muted">Pigs need constant access to clean water. They drink 2-5 liters daily per 100kg weight.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Health Management</h5>
                        <p class="text-muted">Regular deworming, vaccination, and biosecurity measures prevent diseases.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Start Your Profitable Pig Farm!</h2>
                <p class="cta-text">
                    Get premium feeds for faster growth and better returns.
                </p>
                <a href="{{ route('products') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3">
                    <i class="bi bi-cart-check me-2"></i>
                    Order Swine Feeds
                </a>
                <a href="/contact" class="btn btn-outline-dark btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-telephone me-2"></i>
                    Get Farming Advice
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
    }

   .hero-video {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: auto;
    min-height: 100%;
    z-index: 0;
    transform: translate(-50%, -50%);
    object-fit: contain; /* changed from cover */
    max-width: none;
    filter: brightness(0.5); /* keeps text readable */
}


    .hero-overlay {
        position: relative;
        z-index: 1;
    }

    /* Product Card Styles */
    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }

    .product-image-container {
        position: relative;
        height: 280px;
        width: 100%;
        overflow: hidden;
        background: linear-gradient(135deg, #fdf4f4, #fee2e2);
    }

    .product-image-full {
        width: 100%;
        height: 100%;
        object-fit: contain !important;
        object-position: center center;
        padding: 25px;
        transition: all 0.5s ease;
    }

    .product-card:hover .product-image-full {
        transform: scale(1.05);
        padding: 20px;
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
        color: white;
        z-index: 2;
    }

    .product-badge.pig {
        background: linear-gradient(135deg, #8b4513, #dc2626);
    }

    .product-badge.pig.premium {
        background: linear-gradient(135deg, #f59e0b, #d97706);
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

    /* Responsive */
    @media (max-width: 768px) {
        .product-image-container {
            height: 240px;
        }

        .product-image-full {
            padding: 20px;
        }
    }
</style>

@endsection
