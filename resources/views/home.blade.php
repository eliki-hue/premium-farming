@extends('layouts.app', ['mode' => 'pos'])

@section('title', 'Premium Farming Feeds - POS Dashboard')

@push('styles')
<style>
.hero {
    background: linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)),
                url('https://images.unsplash.com/photo-1500382017468-9049fed747ef') center/cover;
    min-height: 85vh;
    display: flex;
    align-items: center;
    color: #fff;
}
.hero h1 { font-size: 3.5rem; font-weight: 800; }
.section { padding: 5rem 0; }
.card-soft {
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    transition: .3s;
}
.card-soft:hover { transform: translateY(-6px); }
.price { font-size: 1.6rem; font-weight: 700; color: #2563eb; }
.badge-premium {
    background: #16a34a;
    color: #fff;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: .75rem;
}

/* POS Sidebar Styles */
.sidebar-nav {
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    width: 280px;
    overflow-y: auto;
    z-index: 1000;
}
.nav-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    margin: 4px 16px;
    border-radius: 12px;
    transition: all 0.2s;
    text-decoration: none;
    color: #64748b;
    font-weight: 500;
}
.nav-item:hover {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    transform: translateX(4px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
}
.nav-item i { 
    width: 40px; 
    height: 40px; 
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    font-size: 16px;
}
.pos-header {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 24px 20px;
    margin-bottom: 24px;
}
.stats-card {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    border-radius: 16px;
    padding: 20px;
    margin: 24px 16px;
}
.main-content {
    margin-left: 280px;
    padding: 24px;
}
@media (max-width: 768px) {
    .sidebar-nav { transform: translateX(-100%); }
    .main-content { margin-left: 0; }
}
</style>
@endpush

@section('content')
<div class="flex min-h-screen">
    <!-- CLASSIC POS SIDEBAR -->
    <nav class="sidebar-nav px-4 py-6 space-y-2">
        <!-- POS Header -->
        <div class="pos-header rounded-2xl shadow-2xl">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-cash-register text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-xl">POS Dashboard</h3>
                </div>
            </div>
        </div>

        <!-- Main POS Menu -->
        <div class="space-y-1">
            <a href="{{ route('pos.sell') }}" class="nav-item group">
                <div class="bg-emerald-100 group-hover:bg-white text-emerald-600 group-hover:text-emerald-500">
                    <i class="fas fa-cash-register"></i>
                </div>
                <span>Quick POS Sale</span>
            </a>

            <a href="{{ route('pos.categories') }}" class="nav-item group">
                <div class="bg-blue-100 group-hover:bg-white text-blue-600 group-hover:text-blue-500">
                    <i class="fas fa-th-large"></i>
                </div>
                <span>Categories</span>
            </a>

            {{-- ✅ FIXED: Uses shop.products route --}}
            <a href="{{ route('shop.products') }}" class="nav-item group">
                <div class="bg-indigo-100 group-hover:bg-white text-indigo-600 group-hover:text-indigo-500">
                    <i class="fas fa-boxes"></i>
                </div>
                <span>Products</span>
            </a>

            <a href="{{ route('pos.stores') }}" class="nav-item group">
                <div class="bg-purple-100 group-hover:bg-white text-purple-600 group-hover:text-purple-500">
                    <i class="fas fa-store"></i>
                </div>
                <span>Stores</span>
            </a>

            <a href="{{ route('pos.goods-received') }}" class="nav-item group">
                <div class="bg-orange-100 group-hover:bg-white text-orange-600 group-hover:text-orange-500">
                    <i class="fas fa-truck"></i>
                </div>
                <span>Goods Received</span>
            </a>

            <a href="{{ route('pos.update-prices') }}" class="nav-item group">
                <div class="bg-amber-100 group-hover:bg-white text-amber-600 group-hover:text-amber-500">
                    <i class="fas fa-tags"></i>
                </div>
                <span>Update Prices</span>
            </a>
        </div>

        <!-- Divider -->
        <div class="my-6">
            <hr class="border-gray-200">
        </div>

        <!-- Quick Stats -->
        <div class="stats-card">
            <div class="text-xs text-gray-500 uppercase font-bold tracking-wide mb-2">Today Sales</div>
            <div class="text-3xl font-bold text-emerald-600">KSh 45,230</div>
            <div class="text-sm text-gray-500 flex items-center gap-2">
                <i class="fas fa-receipt"></i>
                23 transactions
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-content flex-1">
        <!-- HERO -->
        <section class="hero mb-12 rounded-3xl overflow-hidden">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl">
                    <h1 class="mb-8 leading-tight">Quality Feeds,<br>Maximum Production</h1>
                    <p class="lead text-xl mb-8 opacity-90">Trusted livestock nutrition for poultry, dairy and pig farmers across Kenya.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('pos.sell') }}" class="btn btn-warning btn-lg px-8 py-4 font-bold shadow-xl hover:shadow-2xl">
                            Start POS Sale
                        </a>
                        {{-- ✅ FIXED: Uses shop.products route --}}
                        <a href="{{ route('shop.products') }}" class="btn btn-outline-light btn-lg px-8 py-4 font-bold border-2 hover:bg-white hover:text-gray-900">
                            Browse Products
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="section">
            <div class="container mx-auto">
                <div class="row g-5">
                    @php
                    $features = [
                        ['icon' => 'award', 'title' => 'Premium Quality', 'description' => 'Scientifically formulated feeds for maximum livestock performance.'],
                        ['icon' => 'leaf', 'title' => 'Natural Ingredients', 'description' => 'Made from high-quality grains and trusted raw materials.'],
                        ['icon' => 'truck', 'title' => 'Reliable Supply', 'description' => 'Consistent availability for farmers and agro-vets.'],
                        ['icon' => 'people', 'title' => 'Farmer Trusted', 'description' => 'Trusted by 5000+ farmers across Kenya.'],
                    ];
                    @endphp
                    @foreach($features as $feature)
                    <div class="col-lg-3 col-md-6">
                        <div class="card-soft text-center h-100">
                            <div class="bg-gradient-to-br from-emerald-100 to-green-100 w-20 h-20 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                                <i class="bi bi-{{ $feature['icon'] }} text-2xl text-emerald-600"></i>
                            </div>
                            <h5 class="fw-bold text-xl mb-3">{{ $feature['title'] }}</h5>
                            <p class="text-muted lead">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CATEGORIES - ✅ PERFECTLY MATCHES YOUR ROUTES -->
        <section class="section bg-gradient-to-b from-gray-50 to-white">
            <div class="container mx-auto">
                <h2 class="text-center fw-bold text-4xl mb-12 text-gray-800">Shop by Category</h2>
                <div class="row g-5">
                    @php
                    $categories = [
                        ['name' => 'Poultry Feeds', 'route' => 'category.poultry', 'icon' => '🐔', 'description' => 'Broiler, layers & kienyeji feeds'],
                        ['name' => 'Dairy Feeds', 'route' => 'category.dairy', 'icon' => '🐄', 'description' => 'Feeds for higher milk production'],
                        ['name' => 'Swine Feeds', 'route' => 'category.swine', 'icon' => '🐖', 'description' => 'Grower, finisher & sow feeds'],
                        ['name' => 'Pet Feeds', 'route' => 'category.pet-feeds', 'icon' => '🐶', 'description' => 'Dog, cat & rabbit nutrition'],
                        ['name' => 'By-products', 'route' => 'category.by-products', 'icon' => '🌾', 'description' => 'Maize germ, wheat bran & supplements'],
                        ['name' => 'Goat Feeds', 'route' => 'category.goat-feeds', 'icon' => '🐐', 'description' => 'Dairy & meat goat feeds'],
                    ];
                    @endphp
                    @foreach($categories as $cat)
                    <div class="col-lg-2 col-md-3 col-sm-6">
                        <a href="{{ route($cat['route']) }}" class="card-soft text-center h-100 hover:shadow-2xl transition-all duration-300">
                            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 text-white w-20 h-20 rounded-2xl mx-auto mb-6 flex items-center justify-center text-3xl shadow-xl">
                                {{ $cat['icon'] }}
                            </div>
                            <h5 class="fw-bold text-xl mb-3 text-gray-800">{{ $cat['name'] }}</h5>
                            <p class="text-gray-600">{{ $cat['description'] }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- FEATURED PRODUCTS -->
        <section class="section">
            <div class="container mx-auto">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="fw-bold text-4xl text-gray-800">Featured Products</h2>
                    {{-- ✅ FIXED: Uses shop.products route --}}
                    <a href="{{ route('shop.products') }}" class="btn btn-outline-primary btn-lg">View All Products</a>
                </div>
                <div class="row g-5">
                    @php
                    $featuredProducts = [
                        [
                            'name' => 'Kienyeji Mash', 'category' => 'Poultry', 'price' => 3200, 'old_price' => null,
                            'unit' => '50kg bag', 'rating' => 4.5, 'reviews' => 120, 'image' => 'kienyeji',
                            'is_premium' => true, 'is_sale' => false
                        ],
                        [
                            'name' => 'Dairy Meal', 'category' => 'Dairy', 'price' => 3450, 'old_price' => 3700,
                            'unit' => '50kg bag', 'rating' => 4.8, 'reviews' => 98, 'image' => 'dairy',
                            'is_premium' => true, 'is_sale' => true
                        ],
                        [
                            'name' => 'Pig Grower', 'category' => 'Swine', 'price' => 3300, 'old_price' => null,
                            'unit' => '50kg bag', 'rating' => 4.3, 'reviews' => 64, 'image' => 'pig',
                            'is_premium' => false, 'is_sale' => false
                        ],
                        [
                            'name' => 'Maize Germ', 'category' => 'By-products', 'price' => 90, 'old_price' => null,
                            'unit' => 'per kg', 'rating' => 4.6, 'reviews' => 210, 'image' => 'maize',
                            'is_premium' => false, 'is_sale' => false
                        ],
                    ];
                    @endphp
                    @foreach($featuredProducts as $p)
                    <div class="col-lg-3 col-md-6">
                        <div class="card-soft h-100 position-relative overflow-hidden">
                            @if($p['is_premium'])
                            <span class="badge-premium position-absolute" style="top: 16px; right: 16px; z-index: 2;">Premium</span>
                            @endif
                            <div class="text-center mb-4">
                                <div class="bg-gradient-to-br from-gray-100 to-gray-200 w-24 h-24 rounded-2xl mx-auto flex items-center justify-center text-3xl mb-3">
                                    🐔
                                </div>
                            </div>
                            <h5 class="fw-bold mb-3 text-xl">{{ $p['name'] }}</h5>
                            <p class="text-muted mb-3">{{ $p['category'] }}</p>
                            <div class="price mb-2">KES {{ number_format($p['price']) }}</div>
                            @if($p['old_price'])
                            <small class="text-muted text-decoration-line-through d-block mb-2">
                                KES {{ number_format($p['old_price']) }}
                            </small>
                            @endif
                            <div class="text-muted mb-4">{{ $p['unit'] }}</div>
                            <div class="d-flex align-items-center text-warning mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $p['rating'] ? 'text-warning' : 'far fa-star text-muted' }}"></i>
                                @endfor
                                <span class="ms-2 text-muted small">({{ $p['reviews'] }} reviews)</span>
                            </div>
                            <a href="{{ route('pos.sell') }}" class="btn btn-success w-100 fw-bold">Add to Sale</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="section text-white py-20" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%)">
            <div class="container mx-auto text-center">
                <h2 class="fw-bold text-4xl mb-6">Grow Faster. Produce More.</h2>
                <p class="lead text-xl mb-8 opacity-90">Join thousands of farmers using Premium Farming Feeds for better results.</p>
                <div class="d-flex flex-wrap justify-content-center gap-4">
                    <a href="{{ route('pos.sell') }}" class="btn btn-light btn-lg px-8 py-4 fw-bold shadow-xl">Start Selling Now</a>
                    <a href="/contact" class="btn btn-outline-light btn-lg px-8 py-4 fw-bold border-2">Contact Us</a>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
