@extends('layouts.app')

@section('title', 'GreenHarvest - Farm Fresh, Naturally Grown')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        height: 90vh;
        min-height: 600px;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.4)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2232&auto=format&fit=crop') center/cover no-repeat;
        display: flex;
        align-items: center;
        color: white;
        overflow: hidden;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: rgba(232, 155, 75, 0.9);
        padding: 10px 24px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 2rem;
        animation: fadeInUp 0.8s ease 0.2s forwards;
        opacity: 0;
    }

    .hero-badge i {
        font-size: 1.2rem;
    }

    .hero-title {
        font-size: 5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.8s ease 0.4s forwards;
        opacity: 0;
    }

    .hero-title .accent {
        color: var(--accent-orange);
        display: block;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        margin-bottom: 3rem;
        max-width: 600px;
        line-height: 1.6;
        animation: fadeInUp 0.8s ease 0.6s forwards;
        opacity: 0;
    }

    .hero-buttons {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        animation: fadeInUp 0.8s ease 0.8s forwards;
        opacity: 0;
    }

    .btn-primary-custom {
        background-color: var(--accent-orange);
        color: white;
        padding: 16px 40px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid var(--accent-orange);
    }

    .btn-primary-custom:hover {
        background-color: var(--accent-orange-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 155, 75, 0.4);
    }

    .btn-secondary-custom {
        background-color: transparent;
        color: white;
        padding: 16px 40px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .btn-secondary-custom:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
        transform: translateY(-2px);
    }

    /* Features Section */
    .features-section {
        background-color: var(--light-bg);
        padding: 6rem 0;
    }

    .feature-card {
        text-align: center;
        padding: 2rem;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .feature-card:nth-child(2) { animation-delay: 0.2s; }
    .feature-card:nth-child(3) { animation-delay: 0.3s; }
    .feature-card:nth-child(4) { animation-delay: 0.4s; }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(232, 155, 75, 0.1) 0%, rgba(45, 95, 78, 0.1) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--primary-green);
        transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
        background: linear-gradient(135deg, var(--accent-orange) 0%, var(--primary-green) 100%);
        color: white;
    }

    .feature-card h3 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .feature-card p {
        color: var(--text-muted);
        margin: 0;
    }

    /* Categories Section */
    .categories-section {
        padding: 6rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .section-header h2 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .section-header p {
        font-size: 1.2rem;
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
    }

    .category-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .category-card:nth-child(1) { animation-delay: 0.1s; }
    .category-card:nth-child(2) { animation-delay: 0.2s; }
    .category-card:nth-child(3) { animation-delay: 0.3s; }
    .category-card:nth-child(4) { animation-delay: 0.4s; }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-orange);
    }

    .category-icon {
        width: 100px;
        height: 100px;
        background-color: var(--light-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 3rem;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
        background-color: var(--accent-orange);
        transform: scale(1.1);
    }

    .category-card h3 {
        font-size: 1.5rem;
        margin: 0;
        color: var(--text-dark);
    }

    /* Products Section */
    .products-section {
        background-color: var(--light-bg);
        padding: 6rem 0;
    }

    .section-header-with-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
    }

    .section-header-with-link h2 {
        font-size: 3rem;
        font-weight: 700;
        margin: 0;
    }

    .section-header-with-link p {
        color: var(--text-muted);
        margin: 0.5rem 0 0 0;
    }

    .view-all-btn {
        background-color: white;
        color: var(--primary-green);
        padding: 12px 30px;
        border-radius: 8px;
        border: 2px solid var(--primary-green);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .view-all-btn:hover {
        background-color: var(--primary-green);
        color: white;
        transform: translateX(5px);
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--accent-orange);
    }

    .product-image-wrapper {
        position: relative;
        height: 280px;
        overflow: hidden;
        background-color: #f5f5f5;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        gap: 0.5rem;
    }

    .badge-organic {
        background-color: var(--primary-green);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .badge-sale {
        background-color: #dc3545;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .product-content {
        padding: 1.5rem;
    }

    .product-category {
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .product-name {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        color: var(--text-dark);
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .stars {
        color: #fbbf24;
        display: flex;
        gap: 2px;
    }

    .rating-text {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-price {
        display: flex;
        flex-direction: column;
    }

    .price-current {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    .price-old {
        font-size: 1rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }

    .price-unit {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        padding: 6rem 0;
        color: white;
        text-align: center;
    }

    .cta-section h2 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .cta-section p {
        font-size: 1.3rem;
        margin-bottom: 3rem;
        opacity: 0.9;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-buttons {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-cta-primary {
        background-color: var(--accent-orange);
        color: white;
        padding: 16px 40px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid var(--accent-orange);
    }

    .btn-cta-primary:hover {
        background-color: var(--accent-orange-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(232, 155, 75, 0.4);
        color: white;
    }

    .btn-cta-secondary {
        background-color: transparent;
        color: white;
        padding: 16px 40px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .btn-cta-secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 3rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .section-header h2,
        .cta-section h2 {
            font-size: 2.5rem;
        }

        .section-header-with-link {
            flex-direction: column;
            align-items: flex-start;
            gap: 1.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Premium Quality Feeds
                </div>
                <h1 class="hero-title">
                    Quality, Nutrition,
                    <span class="accent">Maximum Growth</span>
                </h1>
                <p class="hero-subtitle">
                    High-quality, balanced rations designed for optimal livestock health, faster growth, and increased production. Trusted by farmers across the region.
                </p>
                <div class="hero-buttons">
                    <a href="{{ url('/products') }}" class="btn-primary-custom">
                        Shop Now
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/about') }}" class="btn-secondary-custom">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row g-4">
            @foreach($features as $feature)
            <div class="col-lg-3 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-{{ $feature['icon'] }}"></i>
                    </div>
                    <h3>{{ $feature['title'] }}</h3>
                    <p>{{ $feature['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Premium feeds for every livestock need, formulated for specific animals and growth stages.</p>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-6">
                <a href="{{ url('/products?category=' . $category['slug']) }}" style="text-decoration: none;">
                    <div class="category-card">
                        <div class="category-icon">
                            {{ $category['icon'] }}
                        </div>
                        <h3>{{ $category['name'] }}</h3>
                        @if(isset($category['description']))
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0.5rem;">
                            {{ $category['description'] }}
                        </p>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header-with-link">
            <div>
                <h2>Featured Products</h2>
                <p>Top-quality feeds for optimal livestock performance</p>
            </div>
            <a href="{{ url('/products') }}" class="view-all-btn">
                View All Products
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-6">
                <div class="product-card">
                    <div class="product-image-wrapper">
                        @php
                            $imageMap = [
                                'kienyeji-mash.jpg' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'broiler-finisher.jpg' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'sow-weaner.jpg' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'dairy-meal.jpg' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1000'
                            ];
                        @endphp
                        <img src="{{ $imageMap[$product['image']] }}" alt="{{ $product['name'] }}" class="product-image">
                        
                        <div class="product-badges">
                            @if($product['is_premium'])
                            <span class="badge-organic">
                                <i class="bi bi-star-fill"></i> Premium
                            </span>
                            @endif
                            @if($product['is_sale'])
                            <span class="badge-sale">Sale</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="product-content">
                        <div class="product-category">{{ $product['category'] }}</div>
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                        
                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < floor($product['rating']))
                                        <i class="bi bi-star-fill"></i>
                                    @elseif($i < $product['rating'])
                                        <i class="bi bi-star-half"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text">({{ $product['reviews'] }})</span>
                        </div>
                        
                        <div class="product-footer">
                            <div class="product-price">
                                <div>
                                    <span class="price-current">KES {{ number_format($product['price']) }}</span>
                                    @if($product['old_price'])
                                    <span class="price-old">KES {{ number_format($product['old_price']) }}</span>
                                    @endif
                                </div>
                                <span class="price-unit">{{ $product['unit'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>Ready to Boost Your Livestock Production?</h2>
        <p>Join thousands of farmers who trust Premium Farming Feeds for quality nutrition, faster growth, and maximum production. Get the best results for your poultry, pigs, and cattle.</p>
        <div class="cta-buttons">
            <a href="{{ url('/products') }}" class="btn-cta-primary">
                Browse Products
                <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ url('/about') }}" class="btn-cta-secondary">
                Learn More
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.addEventListener('DOMContentLoaded', () => {
        const animatedElements = document.querySelectorAll('.fade-in-up, .feature-card, .category-card, .product-card');
        animatedElements.forEach(el => observer.observe(el));
    });
</script>
@endpush