@extends('layouts.app')

@section('title', 'Pet Feeds | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        Premium Pet Feeds
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        Complete nutrition for your beloved pets - dogs, cats, rabbits, and more
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Our Pet Feed Collection</h2>
                <p>Specialized nutrition for different pet needs</p>
            </div>

            <div class="row g-4">
                <!-- Calf Pellets -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/cpellets.jpeg') }}" alt="Calf Pellets" class="product-image-full">
                            <span class="product-badge pet">🐮 Calves</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Calf Pellets</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Young calves (0-6 months)</small>
                            </p>
                            <p class="product-description mb-3">
                                High-protein formula for healthy growth and strong immunity in young calves.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-danger">High</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>For:</span>
                                    <span class="fw-bold">Young Calves</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 3,500</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="4">
                                    <input type="hidden" name="name" value="Calf Pellets">
                                    <input type="hidden" name="price" value="3500">
                                    <input type="hidden" name="image" value="images/cpellets.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dog Meal -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/dogm.jpeg') }}" alt="Dog Meal" class="product-image-full">
                            <span class="product-badge pet">🐕 Dogs</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Dog Meal</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: All breeds, puppies & adults</small>
                            </p>
                            <p class="product-description mb-3">
                                Balanced nutrition for puppies and adult dogs to support growth and coat health.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">Balanced</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>For:</span>
                                    <span class="fw-bold">Dogs & Puppies</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,800</span>
                                    <small class="text-muted d-block">per 25kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="5">
                                    <input type="hidden" name="name" value="Dog Meal">
                                    <input type="hidden" name="price" value="2800">
                                    <input type="hidden" name="image" value="images/dogm.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rabbit Pellets -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/rabit1.jpeg') }}" alt="Rabbit Pellets" class="product-image-full">
                            <span class="product-badge pet">🐰 Rabbits</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Rabbit Pellets</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>For: Rabbits (all ages)</small>
                            </p>
                            <p class="product-description mb-3">
                                High-fiber feed supporting gut health and steady growth in rabbits of all ages.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Fiber:</span>
                                    <span class="fw-bold text-success">High</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>For:</span>
                                    <span class="fw-bold">All Rabbits</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 2,200</span>
                                    <small class="text-muted d-block">per 20kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="6">
                                    <input type="hidden" name="name" value="Rabbit Pellets">
                                    <input type="hidden" name="price" value="2200">
                                    <input type="hidden" name="image" value="images/rabit1.jpeg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="mt-5 premium-card animate-on-scroll">
                <h4 class="fw-bold mb-4">Pet Feed Comparison Guide</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Feed Type</th>
                                <th>Target Animal</th>
                                <th>Protein / Energy</th>
                                <th>Primary Goal</th>
                                <th>Key Features</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Calf Pellets</strong></td>
                                <td>Young calves (0–6 months)</td>
                                <td class="fw-bold text-danger">High protein, moderate energy</td>
                                <td>Supports healthy growth & immune system</td>
                                <td>Easily digestible, enriched with vitamins</td>
                            </tr>
                            <tr>
                                <td><strong>Dog Meal</strong></td>
                                <td>All breeds, puppies & adult dogs</td>
                                <td class="fw-bold text-primary">Balanced protein & fats</td>
                                <td>Supports growth, coat health, and energy</td>
                                <td>Contains essential amino acids & vitamins</td>
                            </tr>
                            <tr>
                                <td><strong>Rabbit Pellets</strong></td>
                                <td>Rabbits (all ages)</td>
                                <td class="fw-bold text-warning">Moderate protein, high fiber</td>
                                <td>Supports gut health & steady growth</td>
                                <td>Contains essential fiber and minerals</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Tips Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Pet Care Tips</h2>
                <p>Keeping your pets healthy and happy</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-cup-hot fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Clean Water Always</h5>
                        <p class="text-muted">Ensure pets have access to fresh, clean water at all times for optimal hydration.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-calendar-check fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Regular Feeding Schedule</h5>
                        <p class="text-muted">Feed pets at consistent times daily to regulate digestion and metabolism.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-heart fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Health Check-ups</h5>
                        <p class="text-muted">Regular veterinary visits ensure early detection of health issues.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Give Your Pets the Best Nutrition!</h2>
                <p class="cta-text">
                    Premium quality feeds for healthy, happy pets.
                </p>
                <a href="{{ route('products') }}" class="btn btn-dark btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-cart-check me-2"></i>
                    Shop Pet Feeds
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        min-height: 60vh;
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1514984879728-be0aff75a6e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2076&q=80');
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
        background: linear-gradient(135deg, #fef2f2, #dbeafe);
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
    
    .product-badge.pet {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
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