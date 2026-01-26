<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Premium Farming Feeds | Quality Livestock Nutrition')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    @php
    // Cart data - initialize properly
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
            --text-dark: #1e293b;
            --text-light: #64748b;
            --pure-white: #ffffff;
            --off-white: #f8fafc;
            --cream-white: #faf9f6;
            
            /* Gradients */
            --gradient-green: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            --gradient-dark-green: linear-gradient(135deg, var(--navy-green), var(--primary-green));
            --gradient-light-green: linear-gradient(135deg, var(--light-green), var(--accent-green));
            
            /* Shadows */
            --shadow-soft: 0 8px 30px rgba(42, 110, 63, 0.08);
            --shadow-medium: 0 15px 40px rgba(42, 110, 63, 0.12);
            --logo-border-color: #d4af37;  /* Gold for better contrast */
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
        
        /* Navigation - Classic Green Style */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(42, 110, 63, 0.1);
            padding: 0.8rem 0;
            box-shadow: 0 2px 20px rgba(42, 110, 63, 0.05);
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
            border-color: var(--gold-green);
        }
        
        .logo-text-container {
            display: flex;
            flex-direction:column;
            justify-content: center;
        }
        
        .company-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--navy-green);
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
            background: var(--gold-green);
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
            color: var(--primary-green) !important;
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
            background: var(--gradient-green);
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
        
        /* Classic Green Buttons */
        .btn-premium {
            background: var(--gradient-green);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(42, 110, 63, 0.2);
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
            box-shadow: 0 8px 25px rgba(42, 110, 63, 0.3);
            color: white;
        }
        
        .btn-premium-outline {
            background: transparent;
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.5px;
        }
        
        .btn-premium-outline:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(42, 110, 63, 0.2);
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
            border: 1px solid rgba(42, 110, 63, 0.08);
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
            background: var(--gradient-green);
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
            color: var(--navy-green);
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
            background: var(--gradient-green);
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
            background: var(--gradient-dark-green);
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
            background: linear-gradient(90deg, var(--gold-green), #b8860b);
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
            color: var(--gold-green);
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
            background: var(--gold-green);
            transform: translateY(-3px);
            color: var(--navy-green);
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
            background: var(--primary-green);
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
            box-shadow: 0 4px 15px rgba(42, 110, 63, 0.2);
            font-size: 1.2rem;
        }
        
        .scroll-top.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .scroll-top:hover {
            background: var(--secondary-green);
            transform: translateY(-5px);
        }
        
        /* ============================
           CART IN NAVIGATION - PREMIUM STYLE
           ============================ */
        
        /* Cart container in navbar */
        .navbar-cart-container {
            position: relative;
            margin-left: 1rem;
        }
        
        .navbar-cart-btn {
            background: transparent;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            padding: 0;
        }
        
        .navbar-cart-btn:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 110, 63, 0.25);
            border-color: var(--secondary-green);
        }
        
        .navbar-cart-btn:active {
            transform: translateY(0);
        }
        
        /* Cart badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--gradient-green);
            color: white;
            font-weight: 700;
            font-size: 0.7rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(42, 110, 63, 0.3);
            border: 2px solid white;
            animation: pulse-green 2s infinite;
            font-family: 'Inter', sans-serif;
        }
        
        @keyframes pulse-green {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Cart total amount */
        .cart-total-amount {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary-green);
            margin-left: 10px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .cart-total-amount .currency {
            color: var(--text-light);
            font-size: 0.8rem;
        }
        
        /* Empty cart state */
        .cart-empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .cart-empty-state i {
            font-size: 4rem;
            color: #d1fae5;
            margin-bottom: 1.5rem;
            opacity: 0.6;
        }
        
        .cart-empty-state h5 {
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        .cart-empty-state p {
            color: var(--text-light);
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Cart modal styles */
        .cart-modal-header {
            background: var(--gradient-dark-green);
            border-bottom: 3px solid var(--gold-green);
            position: relative;
            overflow: hidden;
        }
        
        .cart-modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-green), transparent 70%);
        }
        
        .cart-modal-title {
            color: white;
            font-weight: 600;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-modal-title i {
            color: var(--gold-green);
        }
        
        .cart-item-count {
            background: rgba(255, 255, 255, 0.2);
            color: var(--gold-green);
            font-size: 0.8rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .cart-modal-body {
            max-height: 400px;
            overflow-y: auto;
            padding: 0 !important;
        }
        
        .cart-modal-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .cart-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .cart-modal-body::-webkit-scrollbar-thumb {
            background: var(--light-green);
            border-radius: 3px;
        }
        
        .cart-modal-body::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-green);
        }
        
        /* Cart items list */
        .cart-items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(42, 110, 63, 0.08);
            transition: all 0.3s ease;
            background: white;
        }
        
        .cart-item:hover {
            background: #f8fafc;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            border: 1px solid rgba(42, 110, 63, 0.1);
            flex-shrink: 0;
        }
        
        .cart-item-image i {
            font-size: 1.5rem;
            color: var(--primary-green);
            opacity: 0.8;
        }
        
        .cart-item-details {
            flex: 1;
            min-width: 0;
        }
        
        .cart-item-name {
            font-weight: 600;
            color: var(--navy-green);
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .cart-item-unit {
            font-size: 0.8rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .cart-item-price {
            font-weight: 700;
            color: var(--primary-green);
            font-size: 1rem;
            white-space: nowrap;
            margin-left: 1rem;
        }
        
        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .qty-btn {
            width: 28px;
            height: 28px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-dark);
            font-size: 0.9rem;
            padding: 0;
        }
        
        .qty-btn:hover {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }
        
        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 0.25rem;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }
        
        .cart-item-remove {
            color: #ef4444;
            background: transparent;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-left: 0.5rem;
        }
        
        .cart-item-remove:hover {
            background: #fee2e2;
            transform: rotate(90deg);
        }
        
        /* Cart summary */
        .cart-summary {
            background: #f8fafc;
            border-top: 1px solid rgba(42, 110, 63, 0.1);
            padding: 1.5rem;
        }
        
        .cart-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            font-family: 'Inter', sans-serif;
        }
        
        .cart-summary-row:last-child {
            margin-bottom: 0;
        }
        
        .cart-summary-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .cart-summary-value {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .cart-total-row {
            border-top: 2px dashed rgba(42, 110, 63, 0.2);
            padding-top: 1rem;
            margin-top: 1rem;
        }
        
        .cart-total-label {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--navy-green);
        }
        
        .cart-total-value {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--primary-green);
            font-family: 'Playfair Display', serif;
        }
        
        /* Cart modal footer */
        .cart-modal-footer {
            background: white;
            border-top: 1px solid rgba(42, 110, 63, 0.1);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-actions-left {
            display: flex;
            gap: 0.5rem;
        }
        
        .cart-actions-right {
            display: flex;
            gap: 0.75rem;
        }
        
        .cart-btn-clear {
            background: transparent;
            border: 1px solid #dc2626;
            color: #dc2626;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .cart-btn-clear:hover {
            background: #dc2626;
            color: white;
        }
        
        .cart-btn-close {
            background: transparent;
            border: 1px solid var(--text-light);
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .cart-btn-close:hover {
            background: var(--text-light);
            color: white;
        }
        
        .cart-btn-checkout {
            background: var(--gradient-green);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(42, 110, 63, 0.2);
        }
        
        .cart-btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(42, 110, 63, 0.3);
        }
        
        .cart-btn-checkout:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
        
        /* Cart notification */
        .cart-notification {
            position: fixed;
            top: 90px;
            right: 20px;
            background: white;
            border-left: 4px solid var(--gold-green);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 1050;
            transform: translateX(120%);
            transition: transform 0.3s ease;
            max-width: 350px;
        }
        
        .cart-notification.show {
            transform: translateX(0);
        }
        
        .cart-notification-icon {
            color: var(--gold-green);
            font-size: 1.5rem;
        }
        
        .cart-notification-content {
            flex: 1;
        }
        
        .cart-notification-title {
            font-weight: 600;
            color: var(--navy-green);
            margin-bottom: 0.25rem;
        }
        
        .cart-notification-message {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        /* Responsive cart */
        @media (max-width: 768px) {
            .navbar-cart-container {
                margin-left: 0.5rem;
            }
            
            .navbar-cart-btn {
                width: 40px;
                height: 40px;
            }
            
            .cart-total-amount {
                display: none;
            }
            
            .cart-modal {
                max-width: 95%;
                margin: 0.5rem auto;
            }
            
            .cart-item {
                padding: 0.75rem 1rem;
            }
            
            .cart-item-image {
                width: 50px;
                height: 50px;
            }
            
            .cart-modal-footer {
                flex-direction: column;
                gap: 1rem;
            }
            
            .cart-actions-left,
            .cart-actions-right {
                width: 100%;
            }
            
            .cart-btn-clear,
            .cart-btn-close,
            .cart-btn-checkout {
                flex: 1;
                text-align: center;
            }
        }
        
        @media (max-width: 576px) {
            .cart-notification {
                left: 10px;
                right: 10px;
                max-width: none;
            }
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
                <!-- Navigation Menu -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    
                    <!-- Products Dropdown - Visible to Everyone -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Products
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products') }}">All Products</a></li>
                            <li><a class="dropdown-item" href="{{ route('categories.poultry') }}">Poultry Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('categories.dairy') }}">Dairy Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('categories.swine') }}">Swine Feeds</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('categories.pet-feeds') }}">Pet Feeds</a></li>
                            <li><a class="dropdown-item" href="{{ route('categories.by-products') }}">Raw materials</a></li>
                        </ul>
                    </li>
                    
                    <!-- Other Public Links -->
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
                        <!-- Show user menu for logged in users -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('checkout.orders') }}">
                                    <i class="bi bi-bag-check me-2"></i>My Orders
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
                        <!-- Show minimal login option for guests -->
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                    
                    <!-- Cart button - shows for both guests and authenticated users -->
                    <li class="nav-item">
                        <div class="navbar-cart-container">
                            <button class="navbar-cart-btn" data-bs-toggle="modal" data-bs-target="#cartModal">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </button>
                            @if($cartCount > 0)
                                <span class="cart-total-amount d-none d-lg-inline">
                                    <span class="currency">KSh</span>
                                    {{ number_format($cartTotal) }}
                                </span>
                            @endif
                        </div>
                    </li>
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
                                 style="border-color: var(--gold-green); filter: brightness(1.1);">
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
                        <li class="mb-2"><a href="{{ route('products') }}">Products</a></li>
                        <li class="mb-2"><a href="/about">About Us</a></li>
                        <li class="mb-2"><a href="/contact">Contact</a></li>
                        <li class="mb-2"><a href="/reviews">Reviews</a></li>
                        {{-- <li class="mb-2"><a href="{{ route('pos.sell') }}">POS System</a></li> --}}
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-4">Categories</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('categories.poultry') }}">Poultry Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('categories.dairy') }}">Dairy Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('categories.swine') }}">Swine Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('categories.pet-feeds') }}">Pet Feeds</a></li>
                        <li class="mb-2"><a href="{{ route('categories.by-products') }}">Raw materials</a></li>
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

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header cart-modal-header">
                    <h5 class="modal-title cart-modal-title" id="cartModalLabel">
                        <i class="bi bi-cart3"></i>
                        Shopping Cart
                        @if($cartCount > 0)
                            <span class="cart-item-count">{{ $cartCount }} items</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Modal Body -->
                <div class="modal-body cart-modal-body">
                    @if($cartCount > 0)
                        <ul class="cart-items-list" id="cartItemsList">
                            @foreach($cartItems as $id => $item)
                                @php
                                    $lineTotal = ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                    $itemId = $id; // Use the actual array key as ID
                                @endphp
                                <li class="cart-item" id="cartItem-{{ $itemId }}">
                                    <div class="cart-item-image">
                                        @if(isset($item['image']) && $item['image'])
                                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <i class="bi bi-box"></i>
                                        @endif
                                    </div>
                                    <div class="cart-item-details">
                                        <div class="cart-item-name">{{ $item['name'] ?? 'Product' }}</div>
                                        <div class="cart-item-unit">{{ strtoupper($item['unit'] ?? 'UNIT') }}</div>
                                        <div class="cart-item-qty">
                                            <button type="button" class="qty-btn decrement-btn" 
                                                    data-id="{{ $itemId }}"
                                                    data-index="{{ $loop->index }}"
                                                    {{ ($item['quantity'] ?? 1) <= 1 ? 'disabled' : '' }}>
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" class="qty-input" id="qty-{{ $itemId }}" 
                                                   value="{{ $item['quantity'] ?? 1 }}" readonly>
                                            <button type="button" class="qty-btn increment-btn" 
                                                    data-id="{{ $itemId }}"
                                                    data-index="{{ $loop->index }}">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="cart-item-price" id="price-{{ $itemId }}">
                                        KSh {{ number_format($lineTotal) }}
                                    </div>
                                    <button type="button" class="cart-item-remove remove-btn" 
                                            title="Remove item"
                                            data-id="{{ $itemId }}"
                                            data-index="{{ $loop->index }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Empty Cart State -->
                        <div class="cart-empty-state">
                            <i class="bi bi-cart-x"></i>
                            <h5>Your cart is empty</h5>
                            <p>Add products to get started</p>
                            <a href="{{ route('products') }}" class="btn btn-premium-outline mt-3">
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Cart Summary (Only show if cart has items) -->
                @if($cartCount > 0)
                    <div class="cart-summary">
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">Subtotal</span>
                            <span class="cart-summary-value" id="cartSubtotal">KSh {{ number_format($cartTotal) }}</span>
                        </div>
                        @php
                            $vatRate = 16;
                            $vat = round(($cartTotal * $vatRate) / 100);
                            $grandTotal = $cartTotal + $vat;
                        @endphp
                        <div class="cart-summary-row">
                            <span class="cart-summary-label">VAT ({{ $vatRate }}%)</span>
                            <span class="cart-summary-value" id="cartVat">KSh {{ number_format($vat) }}</span>
                        </div>
                        <div class="cart-summary-row cart-total-row">
                            <span class="cart-summary-label cart-total-label">Total Amount</span>
                            <span class="cart-summary-value cart-total-value" id="cartGrandTotal">KSh {{ number_format($grandTotal) }}</span>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="cart-modal-footer">
                        <div class="cart-actions-left">
                            <button type="button" class="cart-btn-clear" id="clearCartBtn">
                                <i class="bi bi-trash me-1"></i>Clear Cart
                            </button>
                            <a href="{{ route('sproducts') }}" class="cart-btn-close" data-bs-dismiss="modal">
                                Continue Shopping
                            </a>
                        </div>
                        <div class="cart-actions-right">
                            <a href="{{ route('checkout') }}" class="cart-btn-checkout">
                                <i class="bi bi-credit-card me-1"></i>Checkout Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Cart Notification -->
    <div class="cart-notification" id="cartNotification">
        <div class="cart-notification-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="cart-notification-content">
            <div class="cart-notification-title" id="cartNotificationTitle">Item Added</div>
            <div class="cart-notification-message" id="cartNotificationMessage">Product added to cart successfully</div>
        </div>
        <button type="button" class="btn-close" onclick="hideCartNotification()"></button>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Notification function
        function showNotification(message, type = 'success') {
            // Simple alert for now - you can enhance this later
            if (type === 'success') {
                alert('✓ ' + message);
            } else {
                alert('✗ ' + message);
            }
        }
        
        // Update cart badge with fallback
        function updateCartBadge() {
            const cartBadge = document.querySelector('.cart-badge');
            const cartTotalSpan = document.querySelector('.cart-total-amount');
            
            // Make AJAX call to get cart count
            fetch('/cart/count', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (cartBadge) {
                        if (data.count > 0) {
                            cartBadge.textContent = data.count;
                            cartBadge.style.display = 'flex';
                        } else {
                            cartBadge.style.display = 'none';
                        }
                    }
                    
                    if (cartTotalSpan) {
                        if (data.total > 0) {
                            cartTotalSpan.innerHTML = `<span class="currency">KSh</span> ${data.total.toLocaleString()}`;
                            cartTotalSpan.style.display = 'inline';
                        } else {
                            cartTotalSpan.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error updating cart badge:', error);
            });
        }
        
        // Handle increment button click
        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                const qtyInput = document.getElementById('qty-' + id);
                
                if (!qtyInput) return;
                
                // Show loading
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                this.disabled = true;
                
                // Make AJAX request
                fetch('/cart/increment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: id,
                        index: index
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update quantity input
                        qtyInput.value = data.quantity;
                        
                        // Update price display
                        const priceEl = document.getElementById('price-' + id);
                        if (priceEl && data.item_total) {
                            priceEl.textContent = 'KSh ' + data.item_total.toLocaleString();
                        }
                        
                        // Update totals in summary
                        updateCartTotals();
                        
                        // Update cart badge
                        updateCartBadge();
                        
                        // Enable decrement button
                        const decrementBtn = document.querySelector('.decrement-btn[data-id="' + id + '"]');
                        if (decrementBtn) {
                            decrementBtn.disabled = false;
                        }
                        
                        showNotification('Quantity increased to ' + data.quantity);
                    } else {
                        showNotification(data.message || 'Error increasing quantity', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Network error. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                });
            });
        });
        
        // Handle decrement button click
        document.querySelectorAll('.decrement-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (this.disabled) return;
                
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                const qtyInput = document.getElementById('qty-' + id);
                
                if (!qtyInput) return;
                
                const currentQty = parseInt(qtyInput.value) || 1;
                
                if (currentQty <= 1) {
                    // Remove item instead of decrementing
                    if (confirm('Remove this item from cart?')) {
                        removeItem(id, index);
                    }
                    return;
                }
                
                // Show loading
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                this.disabled = true;
                
                // Make AJAX request
                fetch('/cart/decrement', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: id,
                        index: index
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.removed) {
                            // Item was removed
                            const itemEl = document.getElementById('cartItem-' + id);
                            if (itemEl) {
                                itemEl.remove();
                                
                                // Check if cart is empty
                                const items = document.querySelectorAll('.cart-item');
                                if (items.length === 0) {
                                    location.reload(); // Reload to show empty cart
                                }
                            }
                        } else {
                            // Quantity was decreased
                            qtyInput.value = data.quantity;
                            
                            // Update price display
                            const priceEl = document.getElementById('price-' + id);
                            if (priceEl && data.item_total) {
                                priceEl.textContent = 'KSh ' + data.item_total.toLocaleString();
                            }
                            
                            // Disable button if quantity is 1
                            if (data.quantity <= 1) {
                                this.disabled = true;
                            }
                        }
                        
                        // Update totals in summary
                        updateCartTotals();
                        
                        // Update cart badge
                        updateCartBadge();
                        
                        showNotification(data.message);
                    } else {
                        showNotification(data.message || 'Error decreasing quantity', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Network error. Please try again.', 'error');
                })
                .finally(() => {
                    // Restore button if not disabled
                    if (!this.disabled) {
                        this.innerHTML = originalHTML;
                    }
                });
            });
        });
        
        // Handle remove button click
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const id = this.getAttribute('data-id');
                const index = this.getAttribute('data-index');
                
                if (confirm('Are you sure you want to remove this item?')) {
                    removeItem(id, index);
                }
            });
        });
        
        // Remove item function
        function removeItem(id, index) {
            // Show loading
            const button = document.querySelector('.remove-btn[data-id="' + id + '"]');
            const originalHTML = button ? button.innerHTML : '';
            
            if (button) {
                button.innerHTML = '<i class="bi bi-hourglass-split"></i>';
                button.disabled = true;
            }
            
            // Make AJAX request
            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    id: id,
                    index: index
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item from DOM
                    const itemEl = document.getElementById('cartItem-' + id);
                    if (itemEl) {
                        itemEl.remove();
                        
                        // Check if cart is empty
                        const items = document.querySelectorAll('.cart-item');
                        if (items.length === 0) {
                            location.reload(); // Reload to show empty cart
                        }
                    }
                    
                    // Update totals
                    updateCartTotals();
                    
                    // Update cart badge
                    updateCartBadge();
                    
                    showNotification('Item removed from cart');
                } else {
                    showNotification(data.message || 'Error removing item', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error. Please try again.', 'error');
            })
            .finally(() => {
                if (button) {
                    button.innerHTML = originalHTML;
                    button.disabled = false;
                }
            });
        }
        
        // Update cart totals function
        function updateCartTotals() {
            let subtotal = 0;
            
            // Calculate subtotal from all items
            document.querySelectorAll('.cart-item-price').forEach(priceEl => {
                const priceText = priceEl.textContent;
                const priceMatch = priceText.match(/(\d+[\d,.]*\d+)/);
                if (priceMatch) {
                    const price = parseFloat(priceMatch[1].replace(/,/g, ''));
                    subtotal += price;
                }
            });
            
            // Calculate VAT (16%)
            const vat = Math.round(subtotal * 0.16);
            const total = subtotal + vat;
            
            // Update summary
            const subtotalEl = document.getElementById('cartSubtotal');
            const vatEl = document.getElementById('cartVat');
            const totalEl = document.getElementById('cartGrandTotal');
            
            if (subtotalEl) subtotalEl.textContent = 'KSh ' + subtotal.toLocaleString();
            if (vatEl) vatEl.textContent = 'KSh ' + vat.toLocaleString();
            if (totalEl) totalEl.textContent = 'KSh ' + total.toLocaleString();
        }
        
        // Handle clear cart button
        const clearCartBtn = document.getElementById('clearCartBtn');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Are you sure you want to clear the entire cart?')) {
                    fetch('/cart/clear', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload page
                        } else {
                            showNotification(data.message || 'Error clearing cart', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Network error. Please try again.', 'error');
                    });
                }
            });
        }
        
        // Initialize cart badge
        updateCartBadge();
        
        // Update cart when modal is shown
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            cartModal.addEventListener('shown.bs.modal', function() {
                updateCartBadge();
            });
        }
    });
    </script>
</body>
</html>