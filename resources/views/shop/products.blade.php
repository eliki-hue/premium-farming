@extends('layouts.app')

@section('title', 'Our Products | Premium Farming Feeds')

@section('content')

{{-- ─────────────────────────── HERO ─────────────────────────── --}}
<section class="hero-section-products">
    <video autoplay muted loop playsinline preload="metadata" class="hero-video">
        <source src="{{ asset('videos/kkk.mp4') }}" type="video/mp4">
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

{{-- ─────────────────────────── FLASH MESSAGES ─────────────────────────── --}}
@if(session('success'))
    <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container mt-4">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

{{-- ─────────────────────────── PRODUCTS ─────────────────────────── --}}
<div class="container my-5" id="products">
    <h2 class="mb-4 text-center section-title">Our Products</h2>

    @if($products->isNotEmpty())
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">

                        {{-- Product image --}}
                        <div class="card-img-top-container">
                            <img
                                class="card-img-top"
                                src="{{ $product['image'] ?? asset('images/no-image.png') }}"
                                alt="{{ $product['name'] }}"
                                loading="lazy">
                        </div>

                        {{-- Card body --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">{{ $product['name'] }}</h5>

                            <p class="price-tag text-success fw-bold">
                                KES {{ number_format($product['unit_price'], 2) }}
                            </p>

                            @if(!empty($product['sku']))
                                <small class="text-muted mb-2">SKU: {{ $product['sku'] }}</small>
                            @endif

                            <div class="mt-auto">
                                @auth
                                    {{-- Logged-in users can directly add to cart --}}
                                    <button class="btn btn-primary w-100"
                                            onclick="addItem(event, {{ $product['id'] }}, 1)">
                                        Add to Cart
                                    </button>
                                @else
                                    {{-- Guests are redirected to login with product_id --}}
                                    <a href="{{ route('login') }}?product_id={{ $product['id'] }}"
                                       class="btn btn-outline-success w-100">
                                        <i class="bi bi-lock me-2"></i>Login to Purchase
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted mb-3 d-block"></i>
            <h4 class="text-muted">No products available</h4>
            <p class="text-muted">Please check back later or contact us for assistance.</p>
        </div>
    @endif
</div>


<style>
    /* ── Hero ── */
    .hero-section-products {
        position: relative;
        min-height: 60vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
        margin-top: 76px;
    }

    .hero-video {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.45);
    }

    .hero-overlay {
        position: relative;
        z-index: 2;
        padding: 90px 0;
        width: 100%;
    }

    .hero-title {
        font-size: 2.8rem;
        font-weight: 800;
    }

    .hero-subtitle {
        font-size: 1.2rem;
    }

    .product-card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;
    }

    .card-img-top-container {
        height: 200px;
        overflow: hidden;
        border-radius: 15px 15px 0 0;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
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

    .section-title::after {
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
        color: white;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .hero-section-products {
            min-height: 50vh;
            margin-top: 56px;
        }

        .hero-overlay { padding: 60px 0; }
        .hero-title   { font-size: 2.2rem; }
        .hero-subtitle { font-size: 1rem; }

        .card-img-top-container { height: 180px; }
        .col-md-3 { margin-bottom: 1.5rem; }
    }

    @media (max-width: 576px) {
        .hero-title { font-size: 1.8rem; }
        .hero-section-products { min-height: 40vh; }
        .hero-overlay { padding: 50px 0; }
    }
</style>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('.add-to-cart-btn').forEach(function (btn) {
        btn.addEventListener('click', async function () {
            const productId   = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');

            const originalHTML = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
            this.disabled = true;

            try {
                const response = await fetch('api/ecommerce/cart/items/', {
                    method: 'POST',
                    headers: {
                        'Content-Type':     'application/json',
                        'X-CSRF-TOKEN':     csrfToken,
                        'Accept':           'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'include',
                    body: JSON.stringify({ product_id: productId, quantity: 1 }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    this.innerHTML = '<i class="bi bi-check me-2"></i>Added!';
                    this.classList.replace('btn-success', 'btn-outline-success');

                    // Notify cart widget if available
                    if (window.showCartNotification) {
                        window.showCartNotification(`${productName} added to cart!`, 'success');
                    }

                    if (window.refreshCart) {
                        window.refreshCart();
                    }

                    setTimeout(() => {
                        window.location.href = data.redirect || '{{ route("cart.view") }}';
                    }, 1000);

                } else if (response.status === 401) {
                    const currentUrl = encodeURIComponent(window.location.href);
                    window.location.href = `/login?redirect=${currentUrl}`;
                } else {
                    showError(data.message || 'Failed to add to cart');
                    this.innerHTML = originalHTML;
                    this.disabled  = false;
                }

            } catch (error) {
                console.error('Error adding to cart:', error);
                showError('Error adding to cart. Please try again.');
                this.innerHTML = originalHTML;
                this.disabled  = false;
            }
        });
    });

    function showError(message) {
        const toast = document.createElement('div');
        toast.className = 'alert alert-danger position-fixed top-0 end-0 m-3 shadow-lg';
        toast.style.zIndex = '9999';
        toast.style.maxWidth = '320px';
        toast.innerHTML = `<i class="bi bi-exclamation-triangle me-2"></i>${message}`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (alert) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);

})();
</script>
@endpush