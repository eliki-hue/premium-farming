@extends('layouts.app')

@section('title', 'By-Products & Supplements | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        By-Products & Supplements
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        High-quality by-products and essential supplements for complete livestock nutrition
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="section bg-white">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Quality By-Products</h2>
                <p>Essential supplements for balanced livestock nutrition</p>
            </div>

            <div class="row g-4">
                <!-- Wheat Bran -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/bran.jpg') }}" alt="Wheat Bran" class="product-image-full">
                            <span class="product-badge byproduct">🌾 Bran</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Wheat Bran</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>High-fiber supplement</small>
                            </p>
                            <p class="product-description mb-3">
                                High-fiber by-product ideal for ruminants. Rich in protein and energy.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-success">15-17%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">Ruminants</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 1,300</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="401">
                                    <input type="hidden" name="name" value="Wheat Bran">
                                    <input type="hidden" name="price" value="1300">
                                    <input type="hidden" name="image" value="images/bran.jpg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wheat Pollard -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/pollard.jpg') }}" alt="Wheat Pollard" class="product-image-full">
                            <span class="product-badge byproduct">🌾 Pollard</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Wheat Pollard</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>Energy supplement</small>
                            </p>
                            <p class="product-description mb-3">
                                Energy and protein-rich supplement for all livestock types.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">16-18%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">All Livestock</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 1,500</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="402">
                                    <input type="hidden" name="name" value="Wheat Pollard">
                                    <input type="hidden" name="price" value="1500">
                                    <input type="hidden" name="image" value="images/pollard.jpg">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Maize Germ -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset('images/maize.jpeg') }}" alt="Maize Germ" class="product-image-full">
                            <span class="product-badge byproduct premium">⭐ Premium</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">Maize Germ</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>High-energy supplement</small>
                            </p>
                            <p class="product-description mb-3">
                                High-energy supplement rich in oil and protein. Ideal for poultry and swine.
                            </p>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-warning">18-22%</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Best For:</span>
                                    <span class="fw-bold">Poultry/Swine</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="price-tag">Ksh 1,500</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="403">
                                    <input type="hidden" name="name" value="Maize Germ">
                                    <input type="hidden" name="price" value="1500">
                                    <input type="hidden" name="image" value="images/maize.jpeg">
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
                <h4 class="fw-bold mb-4">By-Products Comparison</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Protein Content</th>
                                <th>Energy Level</th>
                                <th>Best For</th>
                                <th>Price (50kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Wheat Bran</strong></td>
                                <td>15-17%</td>
                                <td>Medium</td>
                                <td>Ruminants, Dairy</td>
                                <td>Ksh 1,300</td>
                            </tr>
                            <tr>
                                <td><strong>Wheat Pollard</strong></td>
                                <td>16-18%</td>
                                <td>High</td>
                                <td>All Livestock</td>
                                <td>Ksh 1,500</td>
                            </tr>
                            <tr>
                                <td><strong>Maize Germ</strong></td>
                                <td>18-22%</td>
                                <td>Very High</td>
                                <td>Poultry, Swine</td>
                                <td>Ksh 1,500</td>
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
                <h2>Supplement Tips</h2>
                <p>Using by-products effectively in livestock feeding</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-scale fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Proper Mixing</h5>
                        <p class="text-muted">Mix by-products with main feeds in correct proportions for balanced nutrition.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-droplet-half fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Water Management</h5>
                        <p class="text-muted">Ensure adequate water supply when feeding high-fiber by-products.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <i class="bi bi-graph-up fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold mb-3">Gradual Introduction</h5>
                        <p class="text-muted">Introduce new supplements gradually to allow livestock adjustment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Need Expert Advice?</h2>
                <p class="cta-text">
                    Our nutrition experts can help you choose the right supplements for your livestock.
                </p>
                <a href="/contact" class="btn btn-light btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-chat-dots me-2"></i>
                    Consult Our Experts
                </a>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        min-height: 60vh;
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
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
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
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
    
    .product-badge.byproduct {
        background: linear-gradient(135deg, #047857, #065f46);
    }
    
    .product-badge.byproduct.premium {
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