<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Online Shop' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* 🎨 YOUR EXISTING STYLES - UNTOUCHED */
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ✨ SIDEBAR - UNTOUCHED */
        .sidebar-nav {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 70%, #f1f5f9 100%);
            border-right: 1px solid rgba(148, 163, 184, 0.2);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 300px;
            overflow-y: auto;
            z-index: 1000;
            padding: 0;
            box-shadow: 4px 0 20px rgba(16, 185, 129, 0.08);
        }

        .logo-box { text-align: center; padding: 32px 24px; border-bottom: 1px solid rgba(16, 185, 129, 0.1); background: rgba(16, 185, 129, 0.03); }
        .logo-flat { width: 100px; height: auto; border-radius: 16px; opacity: 0.95; transition: all 0.3s ease; border: 3px solid rgba(255,255,255,0.8); box-shadow: 0 8px 24px rgba(16, 185, 129, 0.15); display: block; margin: 0 auto 16px; }
        .logo-flat:hover { opacity: 1; transform: scale(1.05); box-shadow: 0 12px 32px rgba(16, 185, 129, 0.25); }
        .logo-text { font-weight: 700; font-size: 1.25rem; color: #1e293b; margin: 0; }
        .logo-subtitle { font-size: 0.875rem; color: #64748b; opacity: 0.9; margin: 0; font-weight: 500; }

        .nav-item {
            display: flex; align-items: center; padding: 16px 24px; margin: 8px 20px; border-radius: 16px;
            transition: all 0.3s ease; text-decoration: none; color: #64748b; font-weight: 600; font-size: 15px;
            background: rgba(255,255,255,0.8); border: 1px solid rgba(226, 232, 240, 0.5); position: relative; overflow: hidden;
        }
        .nav-item:hover { background: linear-gradient(135deg, #10b981, #059669) !important; color: white !important; transform: translateX(6px); box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2); border-color: rgba(16, 185, 129, 0.3); }
        .nav-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 18px; font-size: 18px; background: rgba(255,255,255,0.9); box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s ease; flex-shrink: 0; }
        .nav-item:hover .nav-icon { background: rgba(255,255,255,1) !important; transform: scale(1.05); box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25); }

        .nav-section-title { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin: 24px 24px 12px; padding: 8px 12px; background: rgba(16, 185,129, 0.08); border-radius: 8px; border-left: 3px solid #10b981; }
        .category-toggle { background: linear-gradient(135deg, #fef3c7, #fde68a) !important; color: #92400e !important; font-weight: 700 !important; border: 2px solid #f59e0b !important; }
        .category-list { list-style: none; padding: 0; margin: 0; max-height: 0; overflow: hidden; transition: all 0.3s ease; background: rgba(255,255,255,0.9); border-radius: 12px; margin: 8px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        .category-list.active { max-height: 500px; padding: 16px; }
        .category-item { padding: 12px 18px !important; margin: 4px 0 !important; border-radius: 12px !important; font-size: 14px !important; border-left: 4px solid transparent !important; background: rgba(255,255,255,0.9) !important; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .category-item:hover { background: linear-gradient(135deg, #10b981, #059669) !important; color: white !important; transform: translateX(4px) !important; box-shadow: 0 6px 20px rgba(16, 185, 129, 0.2) !important; }

        .cart-btn { background: linear-gradient(135deg, #ef4444, #dc2626) !important; color: white !important; font-weight: 700 !important; margin: 16px 20px !important; border-radius: 20px !important; box-shadow: 0 8px 24px rgba(239, 68, 68, 0.25); animation: cartPulse 2s infinite; position: relative; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #f87171; color: white; border-radius: 50%; width: 24px; height: 24px; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(239,68,68,0.3); border: 2px solid white; animation: bounce 2s infinite; }

        @keyframes cartPulse { 0%, 100% { box-shadow: 0 8px 24px rgba(239, 68, 68, 0.25); } 50% { box-shadow: 0 12px 32px rgba(239, 68, 68, 0.35); } }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-4px); } 60% { transform: translateY(-2px); } }

        /* 🏢 MAIN CONTENT - UNTOUCHED */
        .main-content { margin-left: 300px; padding: 24px; min-height: 100vh; }
        .container { max-width: 1400px; margin: 0 auto; }

        .row { display: flex; flex-wrap: wrap; margin: 0 -12px 24px -12px; }
        .col-12 { width: 100%; padding: 0 12px; }
        .col-6 { width: 50%; padding: 0 12px; }
        .col-4 { width: 33.333%; padding: 0 12px; }
        .col-3 { width: 25%; padding: 0 12px; }

        @media (max-width: 992px) { .col-6 { width: 100%; } .col-4 { width: 50%; } }
        @media (max-width: 768px) { .col-4 { width: 100%; } }

        .content-card { background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); border: 1px solid rgba(226, 232, 240, 0.8); transition: all 0.3s ease; height: 100%; }
        .content-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: translateY(-2px); }
        .content-card-header { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px 24px; border-radius: 12px 12px 0 0; margin: -24px -24px 24px; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2); font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; }

        /* 🔥 PRODUCTS GRID - HORIZONTAL CARDS (KEY CHANGE) */
        .products-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); /* multiple cards per row */
            gap: 24px;
            margin-top: 24px;
        }

        .products-grid .product-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .products-grid .product-card:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.15);
            transform: translateY(-4px);
        }

        .products-grid .product-image {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            margin-bottom: 16px;
            border: 2px solid rgba(226, 232, 240, 0.5);
            flex-shrink: 0;
            object-fit: cover;
        }

        .products-grid .product-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
        .products-grid .product-price { font-size: 1rem; font-weight: 800; color: #10b981; margin-bottom: 8px; }
        .products-grid .product-category { color: #64748b; font-size: 0.875rem; margin-bottom: 8px; }

        .products-grid .product-actions { 
            margin-top: auto;
        }
        .products-grid .btn { 
            padding: 12px 20px; 
            border-radius: 999px; 
            font-weight: 600; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            gap: 8px; 
            transition: all 0.3s ease; 
            border: none; 
            cursor: pointer; 
            width: 100%;
        }
        .products-grid .btn-primary { background: linear-gradient(135deg, #10b981, #059669); color: white; }
        .products-grid .btn-primary:hover { background: linear-gradient(135deg, #059669, #047857); transform: scale(1.02); box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3); }

        @media (max-width: 768px) {
            .products-grid { 
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 0 8px;
            }
        }

        @media (max-width: 1024px) { 
            .sidebar-nav { transform: translateX(-100%); transition: transform 0.3s ease; } 
            .main-content { margin-left: 0; padding: 16px; } 
        }
        @media (max-width: 480px) { 
            .main-content { padding: 12px; } 
            .content-card, .products-grid .product-card { padding: 16px; margin-bottom: 16px; } 
        }
    </style>
</head>

<body>
<div class="flex min-h-screen">
    <!-- ✅ SIDEBAR - 100% UNTOUCHED -->
    <nav class="sidebar-nav">
        <div class="logo-box">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="logo-flat">
            <h5 class="logo-text">Premium Farming Feeds</h5>
            <small class="logo-subtitle">Quality • Nutrition • Growth</small>
        </div>

        <div class="px-8 py-4 border-b border-gray-100">
            <a href="{{ route('dashboard') }}" class="nav-item" style="justify-content: center; margin: 0 16px;">
                <i class="fas fa-tachometer-alt"></i><span>POS Dashboard</span>
            </a>
        </div>

        <div class="px-4">
            <div class="nav-section-title"><i class="fas fa-store me-1"></i>Shop Management</div>
            <a href="{{ route('shop.products') }}" class="nav-item">
                <div class="nav-icon"><i class="fas fa-boxes-stacked"></i></div><span>All Products</span>
            </a>
        </div>

        <div class="px-4">
            <div class="nav-section-title"><i class="fas fa-list-ul me-1"></i>Feed Categories</div>
            <button onclick="toggleCategories(event)" class="nav-item category-toggle" style="justify-content: space-between;">
                <div class="nav-icon"><i class="fas fa-layer-group"></i></div><span>All Categories</span>
                <i class="fas fa-chevron-down w-5 h-5 transition-transform duration-300"></i>
            </button>
            <ul id="categoryList" class="category-list">
                <li><a href="{{ route('category.poultry') }}" class="nav-item category-item"><i class="fas fa-chick me-3"></i>Poultry Feeds</a></li>
                <li><a href="{{ route('category.dairy') }}" class="nav-item category-item"><i class="fas fa-cow me-3"></i>Dairy Feeds</a></li>
                <li><a href="{{ route('category.swine') }}" class="nav-item category-item"><i class="fas fa-piggy-bank me-3"></i>Swine Feeds</a></li>
                <li><a href="{{ route('category.pet-feeds') }}" class="nav-item category-item"><i class="fas fa-paw me-3"></i>Pet Feeds</a></li>
                <li><a href="{{ route('category.by-products') }}" class="nav-item category-item"><i class="fas fa-seedling me-3"></i>By-Products</a></li>
                <li><a href="{{ route('category.goat-feeds') }}" class="nav-item category-item"><i class="fas fa-mountain me-3"></i>Goat Feeds</a></li>
            </ul>
        </div>

        <div class="px-4">
            <a href="{{ route('cart.index') }}" class="nav-item cart-btn" style="position: relative;">
                <div class="nav-icon"><i class="fas fa-shopping-cart"></i></div><span>Shopping Cart</span>
                @if(session('cart') && count(session('cart')) > 0)<span class="cart-badge">{{ count(session('cart')) }}</span>@endif
            </a>
        </div>

        <div class="px-4 pb-8">
            <div class="nav-section-title"><i class="fas fa-cogs me-1"></i>Management</div>
            <a href="{{ route('shop.orders') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-file-invoice-dollar"></i></div><span>Orders</span></a>
            <a href="{{ route('customers.index') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-user-friends"></i></div><span>Customers</span></a>
            <a href="{{ route('shop.reports') }}" class="nav-item"><div class="nav-icon"><i class="fas fa-chart-line"></i></div><span>Reports</span></a>
        </div>
    </nav>

    <!-- ✅ MAIN CONTENT -->
    <main class="main-content">
        <div class="container">
            <!-- PAGE HEADER ROW -->
            <div class="row">
                <div class="col-12">
                    <div class="content-card">
                        <div class="content-card-header">
                            <i class="fas fa-boxes-stacked me-3"></i>
                            {{ $title ?? 'Products' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🔥 PRODUCTS GRID - HORIZONTAL LAYOUT -->
            <div class="products-grid">
                @yield('content')
            </div>
        </div>
    </main>
</div>

<script>
    function toggleCategories(event) {
        event.preventDefault();
        const list = document.getElementById('categoryList');
        const button = event.target.closest('.category-toggle');
        const icon = button.querySelector('.fa-chevron-down');
        list.classList.toggle('active');
        if (icon) icon.style.transform = list.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
</script>
</body>
</html>
