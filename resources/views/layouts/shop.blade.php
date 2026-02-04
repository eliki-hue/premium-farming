<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Premium Farming Feeds | Quality Livestock Nutrition')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-color: #2a6e3f;
            --primary-dark: #1e522e;
            --primary-light: #3d8a55;
            --accent-gold: #d4af37;
            --accent-cream: #fffaf0;
            --text-dark: #1a2c1e;
            --text-light: #4a6352;
            --shadow-soft: 0 8px 30px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 15px 40px rgba(0, 0, 0, 0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: #fefefe;
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }
        
        /* Navigation - E-commerce Style */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(42, 110, 63, 0.1);
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            color: var(--accent-gold);
            font-size: 1.8rem;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(42, 110, 63, 0.05);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 70%;
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        /* Cart Badge */
        .cart-badge {
            position: relative;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-gold);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 300px);
            padding-top: 80px;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: white;
            padding: 5rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent-gold);
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* E-commerce Specific */
        .cart-icon {
            position: relative;
        }
        
        .cart-total {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-tree-fill"></i>
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
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.by-products') }}">By-products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pos.sell') }}">
                            <i class="bi bi-cart3 me-1"></i> POS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    
                    <!-- Cart Icon with Count -->
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart.view') }}">
                            <i class="bi bi-cart3"></i>
                            @php
                                $cartCount = 0;
                                if(session('cart')) {
                                    foreach(session('cart') as $item) {
                                        $cartCount += $item['quantity'] ?? 0;
                                    }
                                }
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart-count">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h5 class="mb-4">
                        <i class="bi bi-tree-fill me-2"></i>
                        Premium Farming Feeds
                    </h5>
                    <p class="mb-4" style="color: rgba(255,255,255,0.8);">
                        Your trusted partner for quality livestock nutrition. 
                        We deliver premium feeds right to your farm.
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('shop.products') }}">Shop</a></li>
                        <li class="mb-2"><a href="/about">About Us</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.swine') }}">Swine Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">Nairobi, Kenya</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-telephone me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">+254 700 123 456</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">info@premiumfeeds.co.ke</span>
                        </li>
                        <li>
                            <i class="bi bi-clock me-2"></i>
                            <span style="color: rgba(255,255,255,0.8);">Mon-Sat: 8AM - 6PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p class="mb-0">&copy; {{ date('Y') }} Premium Farming Feeds. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
        // Auto-dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Update cart count in real-time
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.querySelector('.cart-count');
                    if (data.count > 0) {
                        if (!cartCount) {
                            const cartIcon = document.querySelector('.cart-icon');
                            const countSpan = document.createElement('span');
                            countSpan.className = 'cart-count';
                            countSpan.textContent = data.count;
                            cartIcon.appendChild(countSpan);
                        } else {
                            cartCount.textContent = data.count;
                        }
                    } else if (cartCount) {
                        cartCount.remove();
                    }
                });
        }
        
        // Listen for cart updates
        document.addEventListener('DOMContentLoaded', () => {
            // Check for cart update events
            document.addEventListener('cartUpdated', updateCartCount);
        });
    </script>
</body>
</html>