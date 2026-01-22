@extends('layouts.app')

@section('title', 'Our Products | Premium Farming Feeds')

@section('content')

<!-- Hero Section with Video -->
<section class="hero-section-products">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="hero-video">
        <source src="{{ asset('videos/kkk.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="hero-overlay">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-3">Premium Farming Products</h1>
                    <p class="hero-subtitle mb-4">Quality feeds for all your livestock needs</p>
                    <a href="#products" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-arrow-down me-2"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Original Products Section -->
<div class="container my-5" id="products">
    <h2 class="mb-4 text-center section-title">Our Products</h2>

    @if($products->isNotEmpty())
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">
                        <!-- Product Image -->
                        <div class="card-img-top-container">
                            <img 
                                class="card-img-top" 
                                src="{{ $product['image'] ?? asset('images/no-image.png') }}" 
                                alt="{{ $product['name'] ?? 'Product' }}" 
                            >
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $product['name'] ?? 'No Name' }}</h5>
                            <p class="card-text text-success fw-bold price-tag">
                                KES {{ number_format((float) ($product['unit_price'] ?? 0), 2) }}
                            </p>

                            @if(!empty($product['sku']))
                                <small class="text-muted mb-2">SKU: {{ $product['sku'] }}</small>
                            @endif

                            <div class="mt-auto">
                                @auth
                                    <form method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        <input type="hidden" name="quantity" value="1">

                                        <button class="btn btn-success w-100">
                                            <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button 
                                        class="btn btn-outline-success w-100"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#signupModal">
                                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
            <h4 class="text-muted">No products available</h4>
            <p class="text-muted">Check back soon for our latest products</p>
        </div>
    @endif
</div>

<style>
    /* Hero Section with Video */
    .hero-section-products {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
        margin-top: 76px; /* Adjust based on your navbar height */
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
        object-fit: contain;
        max-width: none;
        filter: brightness(0.5);
    }

    .hero-overlay {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 80px 0;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
    }

    /* Product Card Improvements */
    .product-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }

    .card-img-top-container {
        height: 200px;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
        background: #f8f9fa;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        padding: 1.5rem;
    }

    .price-tag {
        font-size: 1.3rem;
        margin: 0.5rem 0;
    }

    .section-title {
        color: #2a6e3f;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, #2a6e3f, #4caf50);
        border-radius: 2px;
    }

    /* Button Improvements */
    .btn-success {
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-shadow: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(42, 110, 63, 0.3);
    }

    .btn-outline-success {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        border-width: 2px;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: #2a6e3f;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section-products {
            min-height: 50vh;
            margin-top: 56px;
        }

        .hero-overlay {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2.2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .card-img-top-container {
            height: 180px;
        }

        .col-md-3 {
            margin-bottom: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.8rem;
        }

        .hero-section-products {
            min-height: 40vh;
        }

        .hero-overlay {
            padding: 50px 0;
        }
    }
</style>

@endsection