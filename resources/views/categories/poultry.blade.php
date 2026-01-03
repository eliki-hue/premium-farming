@extends('layouts.app')

@section('title', 'Poultry Feeds | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        Premium Poultry Feeds
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        Scientifically formulated feeds for optimal growth, health, and egg production
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
                        <div class="stat-number">22%+</div>
                        <div class="stat-label">Higher Protein</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">95%</div>
                        <div class="stat-label">Feed Efficiency</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">3000+</div>
                        <div class="stat-label">Poultry Farmers</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card animate-on-scroll">
                        <div class="stat-number">5</div>
                        <div class="stat-label">Growth Stages</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Complete Poultry Feed Range</h2>
                <p>Specialized feeds for every growth stage</p>
            </div>

            <div class="row g-4">
                <!-- Chick Starter -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/chick start.jpeg') }}" alt="Chick Starter Mash" class="product-image-full">
                            <span class="product-badge poultry">Starter</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Chick Starter / Mash</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Layer Chicks (0-8 weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                High protein formula for rapid early growth and organ development.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">18-22%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Form:</span>
                                    <span class="fw-bold">Fine Mash</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,500</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="7">
                                    <input type="hidden" name="name" value="Chick Starter Mash">
                                    <input type="hidden" name="price" value="2500">
                                    <input type="hidden" name="image" value="images/chick start.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Broiler Starter -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/chickmash.jpeg') }}" alt="Broiler Starter" class="product-image-full">
                            <span class="product-badge poultry premium">⭐ Broiler</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Broiler Starter ⭐</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Broiler Chicks (0-4 weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                Very high protein for fast muscle growth and meat production.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-danger">22-24%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Purpose:</span>
                                    <span class="fw-bold">Meat Production</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,800</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="8">
                                    <input type="hidden" name="name" value="Broiler Starter">
                                    <input type="hidden" name="price" value="2800">
                                    <input type="hidden" name="image" value="images/chickmash.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Growers Mash -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/growers.jpeg') }}" alt="Growers Mash" class="product-image-full">
                            <span class="product-badge poultry">Grower</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Growers Mash</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Pullets (8-18 weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                Balanced nutrition for steady growth without excess fat accumulation.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">14-18%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Goal:</span>
                                    <span class="fw-bold">Frame Development</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,300</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="9">
                                    <input type="hidden" name="name" value="Growers Mash">
                                    <input type="hidden" name="price" value="2300">
                                    <input type="hidden" name="image" value="images/growers.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Layers Mash -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/layers.jpeg') }}" alt="Layers Mash" class="product-image-full">
                            <span class="product-badge poultry">Layer</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Layers Mash</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Laying Hens (18+ weeks)</small>
                            </p>
                            <p class="product-description mb-3">
                                High calcium formula for consistent egg production and strong shells.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">~16%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Goal:</span>
                                    <span class="fw-bold">Egg Production</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,400</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="10">
                                    <input type="hidden" name="name" value="Layers Mash">
                                    <input type="hidden" name="price" value="2400">
                                    <input type="hidden" name="image" value="images/layers.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Superlayers -->
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/slayers.jpeg') }}" alt="Superlayers Mash" class="product-image-full">
                            <span class="product-badge poultry premium">⭐ Premium</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Superlayers ⭐</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Commercial Layers</small>
                            </p>
                            <p class="product-description mb-3">
                                Premium feed for maximum egg yield, size, and shell strength.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-warning">16-18%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Goal:</span>
                                    <span class="fw-bold">Maximum Yield</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,600</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="11">
                                    <input type="hidden" name="name" value="Superlayers Mash">
                                    <input type="hidden" name="price" value="2600">
                                    <input type="hidden" name="image" value="images/slayers.jpeg">
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
                <h2>Poultry Farming Tips</h2>
                <p>Best practices for successful poultry farming</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-thermometer-sun fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Temperature Control</h5>
                        <p class="text-muted">Maintain optimal brooding temperature: 35°C in week 1, reducing by 2.5°C weekly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-droplet fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Clean Water Supply</h5>
                        <p class="text-muted">Provide fresh, clean water daily. Birds drink 2-3 times more water than feed.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-shield-check fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Biosecurity</h5>
                        <p class="text-muted">Limit farm visits, disinfect equipment, and control wild birds to prevent disease.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Start Your Poultry Success Story!</h2>
                <p class="cta-text">
                    Join thousands of successful poultry farmers using Premium Farming Feeds.
                </p>
                <a href="{{ route('shop.products') }}" class="btn btn-dark btn-lg px-5 py-3 fw-bold me-3">
                    <i class="bi bi-cart-check me-2"></i>
                    Order Feeds Now
                </a>
                <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-telephone me-2"></i>
                    Get Expert Advice
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        min-height: 60vh;
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1595698164298-131a42c1aba2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        color: white;
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
        background: linear-gradient(135deg, #fef3c7, #fef2f2);
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
    
    .product-badge.poultry {
        background: linear-gradient(135deg, #dc2626, #f59e0b);
    }
    
    .product-badge.poultry.premium {
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