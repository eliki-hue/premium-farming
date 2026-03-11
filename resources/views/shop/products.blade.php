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

    @if(!empty($products) && count($products) > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm product-card">

                        {{-- Product image --}}
                        <div class="card-img-top-container">
                            <img
                                class="card-img-top"
                                src="{{ $product['image'] ?? $product['image_url'] ?? asset('images/no-image.png') }}"
                                alt="{{ $product['name'] ?? $product['product_name'] ?? 'Product' }}"
                                loading="lazy">
                        </div>

                        {{-- Card body --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">
                                {{ $product['name'] ?? $product['product_name'] ?? 'Unknown Product' }}
                            </h5>

                            <p class="price-tag text-success fw-bold">
                                KES {{ number_format($product['unit_price'] ?? $product['price'] ?? $product['selling_price'] ?? 0, 2) }}
                            </p>

                            @if(!empty($product['sku'] ?? $product['sku_code'] ?? null))
                                <small class="text-muted mb-2">
                                    SKU: {{ $product['sku'] ?? $product['sku_code'] }}
                                </small>
                            @endif

                            <div class="mt-auto">

                                {{-- ✅ THE KEY FIX:
                                     Use session('django_token') NOT @auth
                                     @auth always returns false because we use Django auth, not Laravel auth
                                     session('django_token') correctly tells us if the user is logged in
                                     Once logged in → always sees "Add to Cart" → no repeated login --}}

                                @if(session('django_token'))
                                    {{-- User is logged in → Add to Cart directly, no redirect --}}
                                    <button
                                        class="btn btn-primary w-100 add-to-cart-btn"
                                        data-product-id="{{ $product['id'] }}"
                                        data-product-name="{{ $product['name'] ?? $product['product_name'] }}"
                                        onclick="addItem(event, {{ $product['id'] }}, 1)">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>
                                @else
                                    {{-- Guest → redirect to login, saving product_id so it auto-adds after login --}}
                                    <a href="{{ route('login') }}?product_id={{ $product['id'] }}"
                                       class="btn btn-outline-success w-100">
                                        <i class="bi bi-lock me-2"></i>Login to Purchase
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- View Cart button — only shown when logged in --}}
        @if(session('django_token'))
            <div class="text-center mt-4 mb-2">
                <a href="{{ route('cart.view') }}" class="btn btn-success px-5 btn-lg">
                    <i class="bi bi-cart3 me-2"></i>View Cart
                </a>
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted mb-3 d-block"></i>
            <h4 class="text-muted">No products available</h4>
            <p class="text-muted">Please check back later or contact us for assistance.</p>
        </div>
    @endif
</div>

{{-- ─────────────────────────── TOAST NOTIFICATION ─────────────────────────── --}}
<div id="cart-toast" class="cart-toast" style="display:none;">
    <i class="bi bi-check-circle-fill me-2 text-success"></i>
    <span id="cart-toast-msg"></span>
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

    .btn-primary {
        background: linear-gradient(135deg, #1a6eb5, #2a8fd4);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #155a9a, #1a6eb5);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(26, 110, 181, 0.3);
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

    /* ── Cart Toast Notification ── */
    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #fff;
        border: 1px solid #d4edda;
        border-left: 5px solid #2a6e3f;
        border-radius: 10px;
        padding: 14px 20px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #1a1a1a;
        box-shadow: 0 6px 24px rgba(0,0,0,0.12);
        z-index: 9999;
        display: flex;
        align-items: center;
        animation: slideInRight 0.3s ease;
        max-width: 320px;
    }

    .cart-toast.error {
        border-left-color: #dc3545;
        border-color: #f5c6cb;
    }

    @keyframes slideInRight {
        from { transform: translateX(100px); opacity: 0; }
        to   { transform: translateX(0);     opacity: 1; }
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

        .cart-toast {
            bottom: 15px;
            right: 15px;
            left: 15px;
            max-width: 100%;
        }
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

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    /* ═══════════════════════════════════════════════════════════════
       addItem()

       HOW IT WORKS:
         1. User is already logged in (session has django_token)
         2. Clicks "Add to Cart" on any product
         3. POST /proxy/cart/add  ← Laravel route
         4. CartProxyController reads session('django_token')
         5. Forwards to Django: Authorization: Bearer <token>
         6. Django adds item to cart ✅
         7. Toast shows success
         8. Button resets after 2.5s → user can keep shopping
         9. NO login prompt unless session actually expires

       SESSION EXPIRY HANDLING:
         If Django returns 401 → session expired
         → redirect to /login?product_id=X
         → after login, item auto-adds, redirects back to cart
    ═══════════════════════════════════════════════════════════════ */
    window.addItem = async function (event, productId, quantity) {
        const btn          = event.currentTarget;
        const originalHTML = btn.innerHTML;
        const productName  = btn.getAttribute('data-product-name') || 'Item';

        // ── Show loading spinner ──
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
        btn.disabled  = true;

        try {
            const response = await fetch('/proxy/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type':     'application/json',
                    'X-CSRF-TOKEN':     CSRF,
                    'Accept':           'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin', // ← sends Laravel session cookie automatically
                body: JSON.stringify({ product: productId, quantity: quantity }),
            });

            const data = await response.json();

            if (response.ok) {
                // ── ✅ Success — stay on page, user keeps shopping ──
                btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Added!';
                btn.classList.replace('btn-primary', 'btn-success');

                showToast(`${productName} added to cart!`, 'success');

                // Update navbar cart badge if defined in layout
                if (typeof window.refreshCart === 'function') {
                    window.refreshCart();
                }

                // Reset button after 2.5s — ready to add again
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Add to Cart';
                    btn.classList.replace('btn-success', 'btn-primary');
                    btn.disabled = false;
                }, 2500);

            } else if (response.status === 401) {
                // ── Session expired — only redirect in this case ──
                showToast('Session expired. Redirecting to login...', 'error');
                setTimeout(() => {
                    window.location.href = `/login?product_id=${productId}`;
                }, 1200);

            } else {
                // ── Django returned a known error ──
                const msg = data?.detail || data?.message || 'Could not add to cart. Try again.';
                showToast(msg, 'error');
                btn.innerHTML = originalHTML;
                btn.disabled  = false;
            }

        } catch (err) {
            // ── Network / connection error ──
            console.error('[addItem] Error:', err);
            showToast('Network error. Please check your connection.', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled  = false;
        }
    };

    /* ═══════════════════════════════════════════════════════════════
       showToast()
       Non-blocking bottom-right notification.
       Does not navigate away — user stays on the products page.
       Auto-hides after 3 seconds.
    ═══════════════════════════════════════════════════════════════ */
    function showToast(message, type = 'success') {
        const toast = document.getElementById('cart-toast');
        const msg   = document.getElementById('cart-toast-msg');

        msg.textContent = message;
        toast.className = 'cart-toast' + (type === 'error' ? ' error' : '');

        const icon = toast.querySelector('i');
        icon.className = type === 'error'
            ? 'bi bi-exclamation-circle-fill me-2 text-danger'
            : 'bi bi-check-circle-fill me-2 text-success';

        toast.style.display = 'flex';

        clearTimeout(toast._hideTimer);
        toast._hideTimer = setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    /* ── Auto-dismiss flash alerts after 5s ── */
    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (alert) {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);

})();
</script>
@endpush