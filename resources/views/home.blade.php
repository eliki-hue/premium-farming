{{-- home.blade.php --}}
@extends('layouts.app')

@section('title', 'Premium Farming Feeds | Quality Livestock Nutrition Solutions')

@push('styles')
<style>
    /* CSS Variables for Green Theme */
    :root {
        /* Green Color Palette */
        --primary-green: #2a6e3f;        /* Deep Forest Green */
        --secondary-green: #38a169;      /* Vibrant Green */
        --light-green: #68d391;          /* Light Mint Green */
        --dark-green: #22543d;           /* Dark Forest Green */
        --accent-green: #10b981;         /* Accent Emerald Green */
        --navy-green: #1e422e;           /* Dark Navy Green */
        --gold-green: #d4af37;           /* Accent Gold */
        --text-light: #4a5568;           /* Gray for text */
        --off-white: #f7fafc;            /* Light background */
        --card-bg: #ffffff;              /* White for cards */
        
        /* Gradients */
        --gradient-green: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        --gradient-dark-green: linear-gradient(135deg, var(--navy-green), var(--primary-green));
        --gradient-light-green: linear-gradient(135deg, var(--light-green), var(--accent-green));
        
        /* Shadows */
        --shadow-soft: 0 4px 20px rgba(42, 110, 63, 0.1);
        --shadow-medium: 0 8px 30px rgba(42, 110, 63, 0.15);
        --shadow-dark: 0 10px 40px rgba(30, 66, 46, 0.2);
    }

    /* Hero Section - Video Background */
    .hero-section {
        min-height: 90vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        color: white;
    }
    
    /* Video Background */
    .hero-video-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }
    
    .hero-video-bg video {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        object-fit: cover;
        filter: brightness(0.7);
        -webkit-filter: brightness(0.7);
    }
    
    /* Video Overlay - Classic Green Gradient */
    .hero-video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(42, 110, 63, 0.95), rgba(30, 66, 46, 0.95));
        z-index: 1;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        z-index: 2;
    }
    
    .hero-content {
        position: relative;
        z-index: 3;
        padding: 2rem 0;
    }
    
    .hero-logo-container {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .hero-logo-wrapper {
        position: relative;
        display: inline-block;
    }
    
    .hero-logo {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--gold-green);
        padding: 4px;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        box-shadow: 
            0 10px 30px rgba(0, 0, 0, 0.3),
            0 0 0 10px rgba(212, 175, 55, 0.1),
            0 0 0 20px rgba(212, 175, 55, 0.05);
        position: relative;
        z-index: 2;
        animation: logoPulse 2s ease-in-out infinite;
    }

    .hero-logo-glow {
        position: absolute;
        top: -15px;
        left: -15px;
        right: -15px;
        bottom: -15px;
        border-radius: 50%;
        background: radial-gradient(circle at center, rgba(212, 175, 55, 0.4), transparent 70%);
        z-index: 1;
        animation: glowPulse 3s ease-in-out infinite;
    }

    @keyframes logoPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    @keyframes glowPulse {
        0%, 100% { opacity: 0.4; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.05); }
    }
    
    .hero-company-name {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
        font-size: 3.5rem;
        color: white;
        letter-spacing: 1px;
        line-height: 1.1;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }
    
    .hero-tagline {
        font-family: 'Inter', sans-serif;
        font-weight: 300;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.95);
        letter-spacing: 2px;
        text-transform: uppercase;
        position: relative;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .hero-tagline::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--gold-green), transparent);
    }
    
    .hero-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 2rem auto 3rem;
        font-weight: 300;
        line-height: 1.7;
    }
    
    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    /* Button Styles */
    .btn-premium {
        background: var(--gradient-green);
        border: none;
        color: white;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-premium:hover {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(42, 110, 63, 0.3);
    }

    .btn-outline-green {
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        background: transparent;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-outline-green:hover {
        background: var(--primary-green);
        color: white;
    }

    /* Stats Section - All Green */
    .stats-section {
        background: var(--off-white);
        padding: 5rem 0;
        border-bottom: 1px solid rgba(42, 110, 63, 0.1);
    }
    
    .stat-card {
        text-align: center;
        padding: 2.5rem 1.5rem;
        background: var(--card-bg);
        border-radius: 8px;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        border: 1px solid rgba(42, 110, 63, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-green);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
        border-color: var(--light-green);
    }
    
    .stat-number {
        font-size: 3.5rem;
        font-weight: 700;
        color: var(--navy-green);
        margin-bottom: 0.5rem;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .stat-label {
        color: var(--text-light);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 500;
    }
    
    /* Features Section */
    .feature-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: var(--gradient-green);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.2);
        transition: all 0.3s ease;
    }
    
    .feature-icon {
        font-size: 1.8rem;
        color: white;
    }
    
    .premium-card:hover .feature-icon-wrapper {
        transform: rotate(10deg) scale(1.1);
    }

    .premium-card {
        transition: all 0.3s ease;
        padding: 2rem;
        border-radius: 8px;
        background: var(--card-bg);
        border: 1px solid rgba(42, 110, 63, 0.08);
        height: 100%;
    }

    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }
    
    /* Category Cards */
    .category-card {
        background: var(--card-bg);
        border-radius: 8px;
        padding: 2.5rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid rgba(42, 110, 63, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-green);
        transform: translateX(-100%);
        transition: transform 0.4s ease;
    }
    
    .category-card:hover::before {
        transform: translateX(0);
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        border-color: var(--light-green);
        box-shadow: var(--shadow-medium);
    }
    
    .category-icon {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        display: inline-block;
        transition: transform 0.3s ease;
        color: var(--primary-green);
        animation: leafFloat 3s ease-in-out infinite;
    }

    @keyframes leafFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }
    
    .category-card:hover .category-icon {
        transform: scale(1.2);
    }
    
    /* Testimonials */
    .testimonial-card {
        background: var(--card-bg);
        border-radius: 8px;
        padding: 2.5rem;
        box-shadow: var(--shadow-soft);
        position: relative;
        border: 1px solid rgba(42, 110, 63, 0.08);
        height: 100%;
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }
    
    .testimonial-card::before {
        content: '"';
        position: absolute;
        top: 20px;
        left: 25px;
        font-size: 5rem;
        color: var(--light-green);
        opacity: 0.1;
        font-family: 'Cormorant Garamond', serif;
        line-height: 1;
    }
    
    .testimonial-text {
        font-style: italic;
        color: var(--text-light);
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
        line-height: 1.7;
        font-size: 1.05rem;
    }
    
    .client-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        border-top: 1px solid rgba(42, 110, 63, 0.08);
        padding-top: 1.5rem;
    }
    
    .client-avatar {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: var(--gradient-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .client-name {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        color: var(--navy-green);
        margin-bottom: 0.2rem;
    }
    
    .client-role {
        color: var(--text-light);
        font-size: 0.9rem;
    }
    
    /* CTA Section */
    .cta-section {
        background: var(--gradient-dark-green);
        color: white;
        padding: 6rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
    
    .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }
    
    .cta-text {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2.5rem;
        line-height: 1.7;
        font-weight: 300;
    }

    /* Section Styles */
    .section-title h2 {
        color: var(--navy-green);
        position: relative;
        padding-bottom: 1rem;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gradient-green);
        border-radius: 2px;
    }

    .section-title.text-center h2::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .bg-light {
        background-color: #f8faf7 !important;
        position: relative;
        overflow: hidden;
    }

    .bg-light::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M41 28c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zM11 58c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zm68-20c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4zm-48 40c-2 0-4 2-4 4s2 4 4 4 4-2 4-4-2-4-4-4z' fill='%232a6e3f' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.1;
        z-index: 1;
    }

    .bg-light > * {
        position: relative;
        z-index: 2;
    }

    /* Text colors */
    .text-green {
        color: var(--primary-green) !important;
    }

    .text-dark-green {
        color: var(--navy-green) !important;
    }

    /* Progress bars */
    .progress-bar-green {
        background-color: var(--primary-green) !important;
    }

    .progress-bar-light-green {
        background-color: var(--light-green) !important;
    }

    /* Badge styles */
    .badge-green {
        background-color: rgba(56, 161, 105, 0.1) !important;
        color: var(--primary-green) !important;
        border: 1px solid rgba(56, 161, 105, 0.2);
    }

    /* Border colors */
    .border-green {
        border-color: rgba(42, 110, 63, 0.1) !important;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-logo {
            width: 120px;
            height: 120px;
        }
        
        .hero-company-name {
            font-size: 2.8rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-logo {
            width: 100px;
            height: 100px;
            border-width: 3px;
        }
        
        .hero-company-name {
            font-size: 2.2rem;
        }
        
        .hero-tagline {
            font-size: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            margin: 1.5rem auto 2.5rem;
        }
        
        .cta-title {
            font-size: 2rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .hero-buttons .btn {
            width: 100%;
            max-width: 300px;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 3rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-logo {
            width: 90px;
            height: 90px;
        }
        
        .hero-company-name {
            font-size: 1.8rem;
        }
        
        .hero-tagline {
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .stat-number {
            font-size: 2.5rem;
        }
        
        .cta-title {
            font-size: 1.8rem;
        }
        
        .cta-text {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section with Video Background -->
    <section class="hero-section">
        <!-- Video Background Added Here -->
        <div class="hero-video-bg">
            <video autoplay muted loop playsinline preload="metadata">
                <source src="{{ asset('public/videos/recaphm.mp4') }}" type="video/mp4">
                <!-- Fallback image if video doesn't load -->
                <img src="https://images.unsplash.com/photo-1542838135-4b6e3f616300?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" alt="Premium Farming Feeds" style="width: 100%; height: 100%; object-fit: cover;">
            </video>
            <div class="hero-video-overlay"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-logo-container animate__animated animate__fadeInDown">
                    <div class="hero-logo-wrapper">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="hero-logo">
                        <div class="hero-logo-glow"></div>
                    </div>
                    <h1 class="hero-company-name animate__animated animate__fadeInUp">Premium Farming Feeds</h1>
                    <div class="hero-tagline animate__animated animate__fadeInUp animate__delay-1s">Quality Livestock Nutrition</div>
                </div>
                
                <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-2s text-center">
                    Scientifically formulated feeds that transform livestock productivity. 
                    Trusted by thousands of farmers across Kenya for superior quality and proven results.
                </p>
                
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-3s">
                        <a href="{{ route('products') }}" class="btn btn-premium btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>
                        Browse Products
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll text-center">
                <h2>Our Product Categories</h2>
                <p>Comprehensive nutrition solutions for all livestock types</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['name' => 'Poultry Feeds', 'route' => 'category.poultry', 'icon' => '🐔', 'desc' => 'Broiler, layers & kienyeji feeds for optimal growth'],
                    ['name' => 'Dairy Feeds', 'route' => 'category.dairy', 'icon' => '🐄', 'desc' => 'Specialized feeds for higher milk production'],
                    ['name' => 'Swine Feeds', 'route' => 'category.swine', 'icon' => '🐖', 'desc' => 'Complete nutrition for pigs at all growth stages'],
                    ['name' => 'Pet Feeds', 'route' => 'category.pet-feeds', 'icon' => '🐶', 'desc' => 'Premium nutrition for dogs, cats & rabbits'],
                    ['name' => 'By-products', 'route' => 'category.by-products', 'icon' => '🌾', 'desc' => 'Maize germ, wheat bran & supplements'],
                    ['name' => 'Goat Feeds', 'route' => 'category.goat-feeds', 'icon' => '🐐', 'desc' => 'Specialized feeds for dairy & meat goats'],
                ] as $cat)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route($cat['route']) }}" class="text-decoration-none">
                        <div class="category-card animate-on-scroll">
                            <div class="category-icon mb-3">
                                {{ $cat['icon'] }}
                            </div>
                            <h4 class="fw-bold mb-2 text-dark-green">{{ $cat['name'] }}</h4>
                            <p class="text-muted mb-0">{{ $cat['desc'] }}</p>
                            <div class="mt-3">
                                <span class="text-green fw-bold">Explore →</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section">
        <div class="container">
            <div class="section-title animate-on-scroll text-center">
                <h2>Why Choose Premium Feeds?</h2>
                <p>Our commitment to excellence sets us apart in livestock nutrition</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['icon' => 'award', 'title' => 'Premium Quality', 'desc' => 'Scientifically formulated for optimal livestock performance and health.'],
                    ['icon' => 'clipboard-check', 'title' => 'Quality Control', 'desc' => 'Rigorous testing at every production stage ensures consistency.'],
                    ['icon' => 'truck', 'title' => 'Nationwide Delivery', 'desc' => 'Reliable supply chain serving farmers across Kenya.'],
                    ['icon' => 'people', 'title' => 'Expert Support', 'desc' => 'Dedicated agricultural experts for personalized advice.'],
                    ['icon' => 'leaf', 'title' => 'Natural Ingredients', 'desc' => 'Made from high-quality, locally-sourced natural ingredients.'],
                    ['icon' => 'graph-up', 'title' => 'Proven Results', 'desc' => 'Documented improvements in yield and livestock health.'],
                ] as $feature)
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card animate-on-scroll">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-{{ $feature['icon'] }} feature-icon"></i>
                        </div>
                        <h4 class="fw-bold mb-3 text-dark-green">{{ $feature['title'] }}</h4>
                        <p class="text-muted mb-0">{{ $feature['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section - All Green Version -->
    <section class="stats-section">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="text-dark-green">Trusted by Farmers Nationwide</h2>
                <p class="text-muted">Excellence in quality and service since 2018</p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    ['number' => '4.8/5', 'label' => 'Average Rating', 'icon' => 'star-fill', 'color' => 'gold-green'],
                    ['number' => '500+', 'label' => 'Satisfied Farmers', 'icon' => 'people-fill', 'color' => 'primary-green'],
                    ['number' => '5+', 'label' => 'Years Experience', 'icon' => 'award-fill', 'color' => 'secondary-green'],
                    ['number' => '98%', 'label' => 'Recommend Us', 'icon' => 'hand-thumbs-up-fill', 'color' => 'accent-green'],
                    ['number' => '50+', 'label' => 'Quality Products', 'icon' => 'basket2-fill', 'color' => 'light-green'],
                    ['number' => '24/7', 'label' => 'Support', 'icon' => 'headset', 'color' => 'dark-green'],
                ] as $stat)
                <div class="col-md-4 col-lg-2">
                    <div class="stat-card animate-on-scroll">
                        <div class="mb-3">
                            <i class="bi bi-{{ $stat['icon'] }} fs-2" style="color: var(--{{ $stat['color'] }});"></i>
                        </div>
                        <div class="stat-number">{{ $stat['number'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Trust Indicators -->
            <div class="row mt-5 pt-5">
                <div class="col-12">
                    <div class="text-center">
                        <h4 class="mb-4 text-dark-green">Why Farmers Trust Us</h4>
                        <div class="row g-3 justify-content-center">
                            @foreach([
                                ['icon' => 'shield-check', 'title' => 'Premium Quality', 'desc' => 'Guaranteed', 'color' => 'success'],
                                ['icon' => 'truck', 'title' => 'Reliable Delivery', 'desc' => 'On-time service', 'color' => 'primary'],
                                ['icon' => 'cash-coin', 'title' => 'Competitive Prices', 'desc' => 'Best value', 'color' => 'warning'],
                                ['icon' => 'award', 'title' => 'Expert Advice', 'desc' => 'Professional support', 'color' => 'danger'],
                            ] as $trust)
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-4 bg-light border-green">
                                    <i class="bi bi-{{ $trust['icon'] }} text-green d-block fs-4 mb-3"></i>
                                    <h6 class="fw-bold mb-2 text-dark-green">{{ $trust['title'] }}</h6>
                                    <p class="text-muted small mb-0">{{ $trust['desc'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll">
                <h2 class="cta-title">Ready to Transform Your Farm?</h2>
                <p class="cta-text">
                    Join thousands of successful farmers who trust Premium Farming Feeds. 
                    Experience the difference in quality, yield, and profitability.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('products') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold text-green">
                        <i class="bi bi-cart-check me-2"></i>
                        Start Buying Now
                    </a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold border-2">
                        <i class="bi bi-telephone me-2"></i>
                        Get Expert Advice
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Additional animations for the home page
    document.addEventListener('DOMContentLoaded', function() {
        // Counter animation for stats
        const statNumbers = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const text = target.textContent;
                    // Check if it's a percentage or regular number
                    if (text.includes('/')) {
                        // For ratings like 4.8/5
                        const parts = text.split('/');
                        const value = parseFloat(parts[0]);
                        const total = parts[1];
                        let current = 0;
                        const increment = value / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= value) {
                                target.textContent = value.toFixed(1) + '/' + total;
                                clearInterval(timer);
                            } else {
                                target.textContent = current.toFixed(1) + '/' + total;
                            }
                        }, 30);
                    } else if (text.includes('%')) {
                        // For percentages
                        const value = parseInt(text);
                        let current = 0;
                        const increment = value / 30;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= value) {
                                target.textContent = value + '%';
                                clearInterval(timer);
                            } else {
                                target.textContent = Math.floor(current) + '%';
                            }
                        }, 30);
                    } else {
                        // For regular numbers
                        const finalValue = parseInt(text);
                        let currentValue = 0;
                        const increment = finalValue / 30;
                        const timer = setInterval(() => {
                            currentValue += increment;
                            if (currentValue >= finalValue) {
                                target.textContent = finalValue + '+';
                                clearInterval(timer);
                            } else {
                                target.textContent = Math.floor(currentValue) + '+';
                            }
                        }, 30);
                    }
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });
        
        statNumbers.forEach(stat => observer.observe(stat));
    });
</script>
@endpush