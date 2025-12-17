<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Premium Farming Feeds - Quality, Nutrition, Growth')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2d5f4e;
            --primary-green-dark: #1e4436;
            --accent-orange: #e89b4b;
            --accent-orange-dark: #d68a3a;
            --light-bg: #f8f9f5;
            --text-dark: #1a1a1a;
            --text-muted: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }

        /* Navigation Styles */
        .navbar {
            background-color: rgba(45, 95, 78, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }

        .brand-icon {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            overflow: hidden;
            border: 2px solid var(--accent-orange);
        }

        .brand-icon i {
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .brand-text small {
            display: block;
            font-size: 0.65rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            opacity: 0.9;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-orange) !important;
        }

        .navbar-nav .nav-link.active {
            color: var(--accent-orange) !important;
        }

        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1.2rem;
            right: 1.2rem;
            height: 2px;
            background-color: var(--accent-orange);
        }

        .navbar-icons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .navbar-icons a {
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .navbar-icons a:hover {
            color: var(--accent-orange);
            transform: scale(1.1);
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
            color: white;
            padding: 4rem 0 2rem;
        }

        footer h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        footer p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.8;
        }

        footer ul {
            list-style: none;
            padding: 0;
        }

        footer ul li {
            margin-bottom: 0.8rem;
        }

        footer ul li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        footer ul li a:hover {
            color: var(--accent-orange);
            transform: translateX(5px);
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-icons a {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: var(--accent-orange);
            transform: translateY(-3px);
        }

        .contact-info {
            display: flex;
            align-items: start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .contact-info i {
            color: var(--accent-orange);
            font-size: 1.2rem;
            margin-top: 3px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 3rem;
            padding-top: 2rem;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            justify-content: flex-end;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent-orange);
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .footer-links {
                justify-content: center;
                margin-top: 1rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds Logo">
                </div>
                <div class="brand-text">
                    Premium
                    <small>Farming Feeds</small>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="background-color: rgba(255,255,255,0.1); border: none;">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About Us</a>
                    </li>
                </ul>
                
                <div class="navbar-icons">
                    <a href="{{ url('/account') }}"><i class="bi bi-person"></i></a>
                    <a href="{{ url('/cart') }}"><i class="bi bi-cart3"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="brand-icon">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds Logo">
                        </div>
                        <div>
                            <h5 class="mb-0">Premium</h5>
                            <small style="opacity: 0.8;">Farming Feeds</small>
                        </div>
                    </div>
                    <p>Providing quality, nutrition, and growth solutions for your farming needs. Premium feeds for premium results.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/products') }}">Products</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-4 mb-lg-0">
                    <h5>Categories</h5>
                    <ul>
                        <li><a href="{{ url('/products?category=poultry') }}">Poultry Feeds</a></li>
                        <li><a href="{{ url('/products?category=pigs') }}">Pig Feeds</a></li>
                        <li><a href="{{ url('/products?category=cattle') }}">Cattle Feeds</a></li>
                        <li><a href="{{ url('/products?category=concentrates') }}">Concentrates</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <h5>Contact Us</h5>
                    <div class="contact-info">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>Nairobi, Kenya</div>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-telephone-fill"></i>
                        <div>+254 700 000 000</div>
                    </div>
                    <div class="contact-info">
                        <i class="bi bi-envelope-fill"></i>
                        <div>info@premiumfeeds.co.ke</div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0" style="opacity: 0.8;">© 2025 Premium Farming Feeds. All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-links">
                            <a href="{{ url('/privacy') }}">Privacy Policy</a>
                            <a href="{{ url('/terms') }}">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add scrolled class to navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Set active nav link based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === currentPath || 
                    (currentPath === '/' && link.getAttribute('href') === '{{ url('/') }}')) {
                    link.classList.add('active');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>