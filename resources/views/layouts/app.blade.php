{{-- app.blade --}}
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    @stack('styles')
    
    <style>
        :root {
            --primary-blue: #1e3a8a;       /* Deep classic blue */
            --secondary-blue: #2563eb;     /* Bright blue */
            --light-blue: #60a5fa;         /* Light blue */
            --navy-blue: #0f172a;          /* Dark navy */
            --accent-gold: #d4af37;        /* Classic gold accent */
            --warm-gold: #b8860b;          /* Warm gold */
            --pure-white: #ffffff;
            --off-white: #f8fafc;
            --cream-white: #faf9f6;        /* Cream white */
            --text-dark: #1e293b;
            --text-light: #64748b;
            --shadow-soft: 0 8px 30px rgba(30, 58, 138, 0.08);
            --shadow-medium: 0 15px 40px rgba(30, 58, 138, 0.12);
            --logo-border-color: #b8860b;  /* Darker gold for better contrast */
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            background-color: var(--cream-white);
            overflow-x: hidden;
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }
        
        /* Navigation - Classic Blue Style */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(30, 58, 138, 0.1);
            padding: 0.8rem 0;
            box-shadow: 0 2px 20px rgba(30, 58, 138, 0.05);
            transition: all 0.3s ease;
        }
        
        /* Classic Logo Design */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            padding: 5px 0;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo-wrapper {
            display: flex;
            align-items: center;
        }
        
        .logo-image-container {
            position: relative;
            display: inline-block;
        }
        
        .logo-image {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--logo-border-color);
            padding: 2px;
            background: white !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3),
                        0 0 0 2px rgba(255, 255, 255, 0.8) inset;
            transition: all 0.3s ease;
            display: block;
            outline: 1px solid rgba(255, 255, 255, 0.8);
            outline-offset: -1px;
        }
        
        .logo-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4),
                        0 0 0 2px rgba(255, 255, 255, 0.9) inset;
            border-color: var(--accent-gold);
        }
        
        .logo-text-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .company-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--navy-blue);
            letter-spacing: 0.3px;
            line-height: 1;
            margin-bottom: 3px;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.05);
        }
        
        .company-tagline {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 0.7rem;
            color: var(--text-light);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            position: relative;
            padding-top: 5px;
        }
        
        .company-tagline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 25px;
            height: 1px;
            background: var(--accent-gold);
        }
        
        .nav-link {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1.2rem !important;
            margin: 0 0.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            font-size: 0.95rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue) !important;
            background: rgba(30, 58, 138, 0.05);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
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
        
        /* Classic Blue Buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
            position: relative;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.5px;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
            color: white;
        }
        
        .btn-premium-outline {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.5px;
        }
        
        .btn-premium-outline:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.2);
        }
        
        /* Main Content */
        .main-content {
            width: 100%;
            padding: 0;
            margin: 0;
        }
        
        /* Card Styles */
        .premium-card {
            background: white;
            border-radius: 10px;
            padding: 2.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(30, 58, 138, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
        }
        
        .premium-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-medium);
        }
        
        /* Section Styles */
        .section {
            padding: 6rem 0;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2.8rem;
            color: var(--navy-blue);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-gold));
            border-radius: 2px;
        }
        
        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 2rem auto 0;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            line-height: 1.7;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--navy-blue), var(--primary-blue));
            color: rgb(131, 122, 122);
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
            background: linear-gradient(90deg, var(--accent-gold), var(--warm-gold));
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .footer a:hover {
            color: var(--accent-gold);
            padding-left: 5px;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
            color: white;
        }
        
        .social-icons a:hover {
            background: var(--accent-gold);
            transform: translateY(-3px);
            color: var(--navy-blue);
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
        }
        
        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-blue);
            color: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.2);
            font-size: 1.2rem;
        }
        
        .scroll-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-top:hover {
            background: var(--secondary-blue);
            transform: translateY(-5px);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .company-name {
                font-size: 1.6rem;
            }
        }
        
        @media (max-width: 992px) {
            .section {
                padding: 4rem 0;
            }
            
            .section-title h2 {
                font-size: 2.4rem;
            }
            
            .premium-card {
                padding: 2rem;
            }
            
            .logo-image {
                width: 60px;
                height: 60px;
            }
            
            .company-name {
                font-size: 1.4rem;
            }
            
            .company-tagline {
                font-size: 0.7rem;
            }
        }
        
        @media (max-width: 768px) {
            .section-title h2 {
                font-size: 2rem;
            }
            
            .logo-image {
                width: 55px;
                height: 55px;
            }
            
            .company-name {
                font-size: 1.2rem;
            }
            
            .company-tagline {
                font-size: 0.65rem;
                letter-spacing: 1px;
            }
            
            .btn-premium, .btn-premium-outline {
                padding: 0.7rem 1.5rem;
                font-size: 0.9rem;
            }
            
            .navbar-brand {
                gap: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .logo-container {
                gap: 10px;
            }
            
            .logo-image {
                width: 50px;
                height: 50px;
            }
            
            .company-name {
                font-size: 1.1rem;
            }
            
            .company-tagline {
                font-size: 0.6rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .section-title p {
                font-size: 1rem;
            }
        }
        
        @media (max-width: 480px) {
            .logo-text-container {
                display: none;
            }
            
            .logo-image {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <!-- Scroll to Top Button -->
    <div class="scroll-top" onclick="scrollToTop()">
        <i class="bi bi-chevron-up"></i>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="logo-container">
                    <div class="logo-wrapper">
                        <div class="logo-image-container">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-image">
                        </div>
                    </div>
                    <div class="logo-text-container d-none d-lg-block">
                        <div class="company-name">Premium Farming Feeds</div>
                        <div class="company-tagline">Quality Livestock Nutrition</div>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPremium">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarPremium">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.products') }}">Products</a>
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('pos.sell') }}">
                            <i class="bi bi-cart3 me-1"></i> POS
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/reviews">Reviews</a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
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
                            <a href="{{ route('login') }}" class="btn btn-premium-outline">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a href="{{ route('register') }}" class="btn btn-premium">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="logo-wrapper mb-4">
                        <div class="logo-image-container d-inline-block">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" 
                                 class="logo-image mb-3" 
                                 style="border-color: var(--accent-gold); filter: brightness(1.1);">
                        </div>
                        <div class="logo-text-container text-center text-lg-start">
                            <div class="company-name" style="color: white; font-size: 1.8rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Premium Farming Feeds</div>
                            <div class="company-tagline" style="color: rgba(255,255,255,0.9); letter-spacing: 1.5px;">Quality Livestock Nutrition</div>
                        </div>
                    </div>
                    <p class="mb-4" style="color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif;">
                        Leading provider of premium livestock nutrition solutions in Kenya. 
                        We're committed to enhancing agricultural productivity through science-backed feeds.
                    </p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.twitter.com/"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/"><i class="bi bi-linkedin"></i></a>
                        <a href="https://web.whatsapp.com/"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('shop.products') }}">Products</a></li>
                        <li class="mb-2"><a href="/about">About Us</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                        <li class="mb-2"><a href="/reviews">Reviews</a></li>
                        <li class="mb-2"><a href="{{ route('pos.sell') }}">POS System</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('category.poultry') }}">Poultry Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.dairy') }}">Dairy Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.swine') }}">Swine Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.pet-feeds') }}">Pet Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('category.by-products') }}">By-products</a></li>
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
        // Scroll to top functionality
        const scrollTopBtn = document.querySelector('.scroll-top');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
        
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.pageYOffset > 50) {
                navbar.style.padding = '0.5rem 0';
                navbar.style.boxShadow = '0 4px 20px rgba(30, 58, 138, 0.1)';
            } else {
                navbar.style.padding = '0.8rem 0';
                navbar.style.boxShadow = '0 2px 20px rgba(30, 58, 138, 0.05)';
            }
        });
        
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        // Observe elements with animation classes
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        });
        
        // Auto-dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>