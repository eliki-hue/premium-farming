<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Premium Farming Feeds | Quality Livestock Nutrition')</title>
    
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @php
    $cartCount = 0;
    $cartTotal = 0;
    $cartItems = [];
    
    if(session()->has('cart')) {
        $cartItems = session('cart', []);
        $cartCount = count($cartItems);
        
        foreach($cartItems as $item) {
            $cartTotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
    }
@endphp
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-green: #2a6e3f;
            --secondary-green: #38a169;
            --light-green: #68d391;
            --dark-green: #22543d;
            --accent-green: #10b981;
            --gold-green: #d4af37;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --cream-white: #faf9f6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--cream-white);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .navbar {
            background: white !important;
            border-bottom: 1px solid rgba(42, 110, 63, 0.1);
            padding: 0.8rem 0;
            box-shadow: 0 2px 20px rgba(42, 110, 63, 0.05);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold-green);
        }
        
        .company-name {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark-green);
        }
        
        .nav-link {
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem !important;
        }
        
        .nav-link:hover {
            color: var(--primary-green) !important;
        }
        
        .btn-premium {
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .btn-premium:hover {
            background: var(--secondary-green);
            color: white;
        }
        
        .main-content {
            padding-top: 80px;
        }
        
        .footer {
            background: var(--dark-green);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--gold-green);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .logo-image {
                width: 40px;
                height: 40px;
            }
            .company-name {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-image">
                <span class="company-name d-none d-md-block">Premium Farming Feeds</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPremium">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarPremium">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.swine') }}">Swine Feeds</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('category.by-products') }}">Raw materials</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    
                    <li class="nav-item">
                        <div class="navbar-cart-container">
                            <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </button>
                        </div>
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
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" 
                             class="logo-image mb-2">
                        <div class="text-white fw-bold">Premium Farming Feeds</div>
                        <small class="text-white-50">Quality Livestock Nutrition</small>
                    </div>
                    <p class="text-white-50 small mb-3">
                        Leading provider of premium livestock nutrition solutions in Kenya.
                    </p>
                    <div>
                        <a href="#" class="text-white me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="bi bi-instagram"></i></a>
                        <a href="https://wa.me/254700680017" class="text-white"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="text-white mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 small">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products') }}" class="text-white-50 small">Products</a></li>
                        <li class="mb-2"><a href="/about" class="text-white-50 small">About Us</a></li>
                        <li class="mb-2"><a href="/contact" class="text-white-50 small">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-3">Categories</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('category.poultry') }}" class="text-white-50 small">Poultry Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.dairy') }}" class="text-white-50 small">Dairy Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.swine') }}" class="text-white-50 small">Swine Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.pet-feeds') }}" class="text-white-50 small">Pet Feeds</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h6 class="text-white mb-3">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 small text-white-50"><i class="bi bi-geo-alt me-2"></i>Nairobi, Kenya</li>
                        <li class="mb-2 small text-white-50"><i class="bi bi-telephone me-2"></i>+254 700 123 456</li>
                        <li class="mb-2 small text-white-50"><i class="bi bi-envelope me-2"></i>info@premiumfeeds.co.ke</li>
                        <li class="small text-white-50"><i class="bi bi-clock me-2"></i>Mon-Sat: 8AM - 6PM</li>
                    </ul>
                </div>
            </div>
            
            <div class="text-center mt-4 pt-3 border-top border-white-10">
                <p class="mb-0 small text-white-50">&copy; {{ date('Y') }} Premium Farming Feeds. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-cart3 me-2"></i>Shopping Cart
                        @if($cartCount > 0)
                            <span class="badge bg-white text-success ms-2">{{ $cartCount }}</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    @if($cartCount > 0)
                        <div class="list-group">
                            @foreach($cartItems as $id => $item)
                                @php
                                    $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                @endphp
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $item['name'] ?? 'Product' }}</div>
                                            <small class="text-muted">Qty: {{ $item['quantity'] ?? 1 }} × KSh {{ number_format($item['price'] ?? 0) }}</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">KSh {{ number_format($lineTotal) }}</div>
                                            <div class="mt-1">
                                                <button class="btn btn-sm btn-outline-danger" onclick="removeFromCart('{{ $id }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span class="fw-bold">KSh {{ number_format($cartTotal) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>VAT (16%):</span>
                                <span>KSh {{ number_format($cartTotal * 0.16) }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-2">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold text-success">KSh {{ number_format($cartTotal * 1.16) }}</span>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('checkout') }}" class="btn btn-success">Checkout Now</a>
                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <p class="mt-3">Your cart is empty</p>
                            <a href="{{ route('products') }}" class="btn btn-success mt-2">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
    function removeFromCart(id) {
        fetch('/cart/remove', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            }
        });
    }
    </script>
</body>
</html>