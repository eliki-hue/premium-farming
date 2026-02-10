<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Shop | Premium Farming Feeds')</title>
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-green: #2a6e3f;
            --dark-green: #22543d;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .navbar {
            background: white !important;
            border-bottom: 1px solid #dee2e6;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary-green) !important;
        }
        
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 80px;
        }
        
        .footer {
            background: var(--dark-green);
            color: white;
            padding: 2rem 0 1rem;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-tree-fill me-1"></i>
                PremiumFeeds
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarShop">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarShop">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products') }}">Shop</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.swine') }}">Swine Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.view') }}">
                            <i class="bi bi-cart3"></i>
                            @php
                                $cartCount = 0;
                                if(session('cart')) {
                                    $cartCount = array_sum(array_column(session('cart'), 'quantity'));
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3">Premium Farming Feeds</h6>
                    <p class="small text-white-50 mb-3">
                        Your trusted partner for quality livestock nutrition.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-white-50 small">Home</a></li>
                        <li><a href="{{ route('shop.products') }}" class="text-white-50 small">Shop</a></li>
                        <li><a href="/about" class="text-white-50 small">About</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-3">Contact</h6>
                    <ul class="list-unstyled">
                        <li class="small text-white-50"><i class="bi bi-telephone me-2"></i>+254 700 123 456</li>
                        <li class="small text-white-50"><i class="bi bi-envelope me-2"></i>info@premiumfeeds.co.ke</li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-4 pt-3 border-top border-white-10">
                <p class="mb-0 small text-white-50">&copy; {{ date('Y') }} Premium Farming Feeds</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>