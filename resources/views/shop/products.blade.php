@extends('layouts.app')

@section('title', 'Our Products | Premium Farming Feeds')

@section('content')

{{-- ─────────────────────────── HERO WITH RESPONSIVE BANNER ─────────────────────────── --}}
<section class="hero-section-products">
    <div class="hero-banner">
        <picture>
            <!-- Mobile image for small screens -->
            <source 
                media="(max-width: 767px)" 
                srcset="{{ asset('images/product page banner image for mobile.png') }}">
            
            <!-- Tablet image for medium screens -->
            <source 
                media="(max-width: 991px)" 
                srcset="{{ asset('images/bann.jpeg') }}">
            
            <!-- Desktop image for larger screens -->
            <img 
                src="{{ asset('images/bann.jpeg') }}" 
                alt="Premium Farming Feeds Banner" 
                class="banner-image">
        </picture>
        <div class="banner-overlay"></div>
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

{{-- ─────────────────────────── PRODUCTS SECTION ─────────────────────────── --}}
<section class="products-section py-5" id="products">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Products</h2>
            <p class="section-subtitle">Discover our range of premium quality farming feeds</p>
        </div>

        @if(!empty($products) && count($products) > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-md-3 col-sm-6">
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <img
                                    src="{{ $product['image'] ?? $product['image_url'] ?? asset('images/no-image.png') }}"
                                    alt="{{ $product['name'] ?? $product['product_name'] ?? 'Product' }}"
                                    class="product-image"
                                    loading="lazy">
                                <div class="product-overlay">
                                    <button class="quick-view-btn" onclick="quickView({{ $product['id'] }})">
                                        <i class="bi bi-eye"></i> Quick View
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <h3 class="product-title">
                                    {{ $product['name'] ?? $product['product_name'] ?? 'Unknown Product' }}
                                </h3>
                                
                                <div class="product-price">
                                    <span class="currency">KES</span>
                                    <span class="amount">{{ number_format($product['price_per_bag'] ?? $product['price'] ?? $product['selling_price'] ?? 0, 2) }}</span>
                                </div>
                                
                                <div class="product-actions">
                                    <button
                                        class="btn-add-to-cart"
                                        data-product-id="{{ $product['id'] }}"
                                        data-product-name="{{ $product['name'] ?? $product['product_name'] }}"
                                        onclick="addItem(event, {{ $product['id'] }}, 1)">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('cart.view') }}" class="btn-view-cart">
                    <i class="bi bi-cart3 me-2"></i> View Cart
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h4>No products available</h4>
                <p>Please check back later or contact us for assistance.</p>
            </div>
        @endif
    </div>
</section>

{{-- ─────────────────────────── TOAST NOTIFICATION ─────────────────────────── --}}
<div id="cart-toast" class="cart-toast" style="display:none;">
    <i class="bi bi-check-circle-fill me-2 text-success"></i>
    <span id="cart-toast-msg"></span>
</div>


<style>
    /* Reset and Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* ─────────────────────────── HERO SECTION ─────────────────────────── */
    .hero-section-products {
        position: relative;
        width: 100%;
        height: auto;
        min-height: 400px;
        max-height: 600px;
        overflow: hidden;
        background: #1a1a1a;
        margin: 0;
        padding: 0;
        display: block;
    }

    .hero-banner {
        position: relative;
        width: 100%;
        height: 100%;
        min-height: 400px;
        max-height: 600px;
        overflow: hidden;
    }

    .hero-banner picture,
    .hero-banner img {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 400px;
        max-height: 600px;
    }

    .banner-image {
        width: 100%;
        height: 100%;
        min-height: 400px;
        max-height: 600px;
        object-fit: cover;
        object-position: center center;
        display: block;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 2;
        pointer-events: none;
    }

    /* ─────────────────────────── PRODUCTS SECTION ─────────────────────────── */
    .products-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 60px 0;
        position: relative;
        z-index: 3;
    }

    .section-title {
        color: #2a6e3f;
        font-weight: 700;
        font-size: 2.5rem;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 15px;
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

    .section-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .product-image-wrapper {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 3;
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .quick-view-btn {
        background: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        color: #2a6e3f;
        font-weight: 600;
        font-size: 0.9rem;
        transform: translateY(20px);
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover .quick-view-btn {
        transform: translateY(0);
    }

    .quick-view-btn:hover {
        background: #2a6e3f;
        color: white;
    }

    .product-content {
        padding: 20px;
    }

    .product-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.4;
        height: 2.8em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-price {
        margin-bottom: 20px;
        display: flex;
        align-items: baseline;
        gap: 5px;
    }

    .product-price .currency {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .product-price .amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2a6e3f;
        line-height: 1;
    }

    .btn-add-to-cart {
        width: 100%;
        background: linear-gradient(135deg, #2a6e3f, #3a8e5c);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(42, 110, 63, 0.2);
    }

    .btn-add-to-cart:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5a2f, #2a6e3f);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.3);
    }

    .btn-add-to-cart:disabled {
        opacity: 0.75;
        cursor: not-allowed;
        transform: none;
    }

    .btn-view-cart {
        display: inline-flex;
        align-items: center;
        padding: 15px 40px;
        background: linear-gradient(135deg, #1a6eb5, #2a8fd4);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(26, 110, 181, 0.3);
    }

    .btn-view-cart:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(26, 110, 181, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 20px;
    }

    /* ─────────────────────────── CART TOAST ─────────────────────────── */
    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #fff;
        border: none;
        border-left: 5px solid #2a6e3f;
        border-radius: 15px;
        padding: 16px 24px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1a1a1a;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        z-index: 9999;
        display: flex;
        align-items: center;
        animation: slideInRight 0.3s ease;
        max-width: 380px;
    }

    .cart-toast.error {
        border-left-color: #dc3545;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* ─────────────────────────── RESPONSIVE BREAKPOINTS ─────────────────────────── */
    
    /* Large screens (1200px and up) */
    @media (min-width: 1200px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 500px;
            max-height: 700px;
        }
    }

    /* Desktop (992px - 1199px) */
    @media (min-width: 992px) and (max-width: 1199px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 450px;
            max-height: 650px;
        }
    }

    /* Tablet (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 350px;
            max-height: 500px;
        }

        .section-title {
            font-size: 2.2rem;
        }
    }

    /* Mobile Large (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 300px;
            max-height: 400px;
        }

        .section-title {
            font-size: 2rem;
        }

        .section-subtitle {
            font-size: 1rem;
        }

        .product-card {
            border-radius: 15px;
        }

        .product-content {
            padding: 15px;
        }

        .product-title {
            font-size: 1rem;
            height: 2.6em;
        }

        .product-price .amount {
            font-size: 1.3rem;
        }
    }

    /* Mobile Small (up to 575px) */
    @media (max-width: 575px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 250px;
            max-height: 350px;
        }

        .products-section {
            padding: 40px 0;
        }

        .section-title {
            font-size: 1.8rem;
        }

        .section-subtitle {
            font-size: 0.95rem;
        }

        .product-card {
            border-radius: 12px;
        }

        .product-content {
            padding: 12px;
        }

        .product-title {
            font-size: 0.95rem;
            height: 2.4em;
        }

        .product-price .amount {
            font-size: 1.2rem;
        }

        .btn-add-to-cart {
            padding: 10px;
            font-size: 0.9rem;
        }

        .btn-add-to-cart i {
            font-size: 1rem;
        }

        .btn-view-cart {
            padding: 12px 30px;
            font-size: 1rem;
        }

        .cart-toast {
            bottom: 15px;
            right: 15px;
            left: 15px;
            max-width: 100%;
        }
    }

    /* Extra Small (up to 400px) */
    @media (max-width: 400px) {
        .hero-section-products,
        .hero-banner,
        .hero-banner picture,
        .hero-banner img,
        .banner-image {
            min-height: 200px;
            max-height: 300px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .section-subtitle {
            font-size: 0.85rem;
        }

        .product-title {
            font-size: 0.85rem;
            height: 2.2em;
        }

        .product-price .amount {
            font-size: 1rem;
        }

        .btn-add-to-cart {
            padding: 8px;
            font-size: 0.8rem;
        }
    }
</style>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

   
    window.addItem = async function (event, productId, quantity) {
        const btn = event.currentTarget;
        const originalHTML = btn.innerHTML;
        const productName = btn.getAttribute('data-product-name') || 'Item';

        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
        btn.disabled = true;

        try {
            const response = await fetch('/proxy/cart/items/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ product: productId, quantity: quantity }),
            });

            const data = await response.json();

            if (response.ok) {
                btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Added!';
                btn.style.background = 'linear-gradient(135deg, #28a745, #34ce57)';
                
                showToast(`${productName} added to cart!`, 'success');
                updateCartBadge(data.total_items ?? null);

                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-cart-plus"></i><span>Add to Cart</span>';
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2500);

            } else if (response.status === 401) {
                showToast('Could not add to cart. Please refresh and try again.', 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;

            } else {
                const msg = data?.detail || data?.message || 'Could not add to cart. Try again.';
                showToast(msg, 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }

        } catch (err) {
            console.error('[addItem] Network error:', err);
            showToast('Network error. Please check your connection.', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }
    };

    function updateCartBadge(count) {
        if (count === null || count === undefined) return;
        const badge = document.querySelector('.cart-badge');
        if (!badge) return;
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }

    window.quickView = function (productId) {
        console.log('Quick view for product:', productId);
    };

    function showToast(message, type = 'success') {
        const toast = document.getElementById('cart-toast');
        const msg   = document.getElementById('cart-toast-msg');
        const icon  = toast.querySelector('i');

        msg.textContent = message;
        toast.className = 'cart-toast' + (type === 'error' ? ' error' : '');
        
        icon.className = type === 'error'
            ? 'bi bi-exclamation-circle-fill me-2 text-danger'
            : 'bi bi-check-circle-fill me-2 text-success';

        toast.style.display = 'flex';
        toast.style.opacity = '1';

        clearTimeout(toast._hideTimer);
        toast._hideTimer = setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.style.display = 'none';
                toast.style.opacity = '1';
            }, 300);
        }, 3000);
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