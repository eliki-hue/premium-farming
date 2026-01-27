@extends('layouts.app')

@section('title', 'Dashboard - Premium Farming Feeds')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #2d6e4f 0%, #245a3f 100%);">
                <div class="card-body text-white p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="avatar-lg bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            </div>
                        </div>
                        <div>
                            <h1 class="h3 mb-1">Welcome, {{ auth()->user()->name }}!</h1>
                            <p class="mb-0 opacity-75">
                                <i class="bi bi-house-door me-1"></i>
                                Premium Farming Feeds Dashboard
                            </p>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->email }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h5 mb-3" style="color: #2d6e4f;">
                <i class="bi bi-lightning-charge me-2"></i>
                Quick Actions
            </h2>
        </div>
        
        <!-- Action Cards -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-box-seam display-6" style="color: #2d6e4f;"></i>
                    </div>
                    <h5 class="card-title">Products</h5>
                    <p class="card-text small text-muted">Browse our premium animal feeds</p>
                    <a href="{{ route('products') }}" class="btn btn-sm" style="background-color: #2d6e4f; color: white;">
                        View Products <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-cart display-6" style="color: #2d6e4f;"></i>
                    </div>
                    <h5 class="card-title">Shopping Cart</h5>
                    <p class="card-text small text-muted">View your selected items</p>
                    <a href="{{ route('cart.view') }}" class="btn btn-sm" style="background-color: #2d6e4f; color: white;">
                        View Cart <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-shop display-6" style="color: #2d6e4f;"></i>
                    </div>
                    <h5 class="card-title">Visit Shop</h5>
                    <p class="card-text small text-muted">Go to our online store</p>
                    <a href="/pos/sell" class="btn btn-sm" style="background-color: #2d6e4f; color: white;">
                        Go to Shop <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle display-6" style="color: #2d6e4f;"></i>
                    </div>
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text small text-muted">Manage your account</p>
                    <button class="btn btn-sm" style="background-color: #2d6e4f; color: white;">
                        My Account <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Information -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title" style="color: #2d6e4f;">
                        <i class="bi bi-info-circle me-2"></i>
                        About Premium Farming Feeds
                    </h5>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="mb-3">
                                Welcome to Premium Farming Feeds – your trusted partner for high-quality animal nutrition. 
                                We provide scientifically formulated feeds for healthier livestock and better yields.
                            </p>
                            <div class="row">
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            Quality Guaranteed
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            Expert Formulation
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            Free Delivery
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            24/7 Support
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            Competitive Prices
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #2d6e4f;"></i>
                                            Farm Tested
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-3">
                                <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" 
                                     class="img-fluid rounded-circle shadow" style="max-width: 150px;">
                                <h6 class="mt-3 mb-0">Premium Farming Feeds</h6>
                                <small class="text-muted">Quality Feeds, Better Yields</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links Sidebar (for reference) -->
    <div class="row mt-4 d-none">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0" style="color: #2d6e4f;">
                        <i class="bi bi-link-45deg me-2"></i>
                        Quick Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="/pos/sell" class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-store me-2"></i> Visit Shop
                        </a>
                        <a href="{{ route('products') }}" class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-box me-2"></i> Browse Products
                        </a>
                        <a href="{{ route('cart.view') }}" class="list-group-item list-group-item-action border-0">
                            <i class="fas fa-shopping-cart me-2"></i> View Cart
                        </a>
                        @if(auth()->user()->pos_access ?? false)
                        <a href="{{ route('pos.sell') }}" class="list-group-item list-group-item-action border-0 text-success">
                            <i class="fas fa-cash-register me-2"></i> POS System
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
    .card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .btn {
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        background-color: #245a3f !important;
        transform: translateY(-2px);
    }
    
    .list-group-item {
        border: none;
        padding: 0.75rem 1rem;
    }
    
    .list-group-item:hover {
        background-color: rgba(45, 110, 79, 0.05);
    }
</style>

<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endsection