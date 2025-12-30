@extends('layouts.shop')

@section('title', 'Products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, li, label {
        color: #000 !important;
    }

    /* ====== HEADINGS ====== */
    .product-title {
        font-size: 36px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        background: linear-gradient(135deg, #065f46, #047857);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .section-divider {
        height: 5px;
        width: 150px;
        background: linear-gradient(135deg, #065f46, #a7f3d0);
        margin: 25px auto 50px;
        border-radius: 30px;
        box-shadow: 0 4px 20px rgba(6,95,70,0.4);
    }

    /* ====== FULL IMAGE - NO CROPPING PERFECT ====== */
    .product-img {
        height: 380px !important;  /* MAX HEIGHT */
        width: 100%;
        object-fit: contain !important;  /* SHOWS FULL IMAGE */
        object-position: center top;     /* DETAILS FIRST */
        background: linear-gradient(135deg, #f0fdf4, #dcfce7, #f0fdf4); /* Farm BG */
        padding: 30px 20px;             /* BREATHING ROOM */
        border-radius: 28px 28px 0 0;
        transition: all .5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 4px 25px rgba(0,0,0,0.08);
        border-bottom: 4px solid rgba(6,95,70,0.1);
    }

    .product-card:hover .product-img {
        transform: scale(1.02);
        padding: 25px 15px;
        filter: brightness(1.08) contrast(1.06) saturate(1.08);
        box-shadow: inset 0 2px 20px rgba(6,95,70,0.15), 0 20px 45px rgba(6,95,70,0.35);
    }

    /* ====== WIDE PRODUCT CARDS ====== */
    .product-card {
        min-width: 420px !important;
        max-width: 420px !important;
        border-radius: 30px;
        border: none;
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 50%, #f1f5f9 100%);
        transition: all .5s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        backdrop-filter: blur(20px);
        position: relative;
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #065f46, #047857, #10b981, #065f46);
        z-index: 2;
    }

    .product-card:hover {
        transform: translateY(-20px) scale(1.025);
        box-shadow: 0 40px 80px rgba(6,95,70,0.4);
        border: 2px solid rgba(6,95,70,0.25);
    }

    /* ====== PERFECT SCROLL ====== */
    .scroll-container {
        display: flex;
        gap: 35px;
        overflow-x: auto;
        padding: 30px 0 50px;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
    }

    .scroll-container::-webkit-scrollbar {
        height: 14px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #065f46, #047857);
        border-radius: 20px;
        border: 4px solid #f8fafc;
        box-shadow: inset 0 2px 6px rgba(0,0,0,0.15);
    }

    /* ====== CUTE BADGES ====== */
    .feed-badge {
        position: absolute;
        top: 25px;
        left: 25px;
        background: linear-gradient(135deg, #065f46, #047857);
        color: #fff;
        font-size: 13px;
        font-weight: 900;
        padding: 12px 18px;
        border-radius: 35px;
        box-shadow: 0 10px 30px rgba(6,95,70,0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
        backdrop-filter: blur(25px);
        border: 2px solid rgba(255,255,255,0.4);
        z-index: 4;
        animation: float 3s ease-in-out infinite;
    }

    .feed-badge.highlight {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        box-shadow: 0 10px 30px rgba(245,158,11,0.6);
        animation: pulse 2s infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(245,158,11,0.6); }
        50% { transform: scale(1.08); box-shadow: 0 15px 40px rgba(245,158,11,0.8); }
    }

    /* ====== PROFESSIONAL BUTTONS ====== */
    .btn-buy {
        background: linear-gradient(135deg, #065f46 0%, #047857 50%, #10b981 100%);
        font-weight: 900;
        color: #fff !important;
        padding: 18px 0;
        border-radius: 25px;
        border: none;
        font-size: 17px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all .4s ease;
        box-shadow: 0 10px 30px rgba(6,95,70,0.45);
        position: relative;
        overflow: hidden;
        margin-top: 20px;
        z-index: 3;
    }

    .btn-buy::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left .6s;
    }

    .btn-buy:hover::before {
        left: 100%;
    }

    .btn-buy:hover {
        transform: translateY(-4px) scale(1.07);
        box-shadow: 0 20px 50px rgba(6,95,70,0.6);
    }

    /* ====== GLOWING PRICE ====== */
    .price-tag {
        font-size: 32px !important;
        font-weight: 950 !important;
        background: linear-gradient(135deg, #065f46, #047857, #10b981);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 25px 0 20px;
        text-shadow: 0 3px 15px rgba(6,95,70,0.4);
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 768px) {
        .product-card { min-width: 360px !important; max-width: 360px !important; }
        .product-img { height: 320px !important; padding: 25px 15px !important; }
        .scroll-container { gap: 25px; padding: 25px 0 40px; }
    }

    @media (max-width: 480px) {
        .product-card { min-width: 320px !important; max-width: 320px !important; }
        .product-img { height: 280px !important; padding: 20px 12px !important; }
    }
</style>

<div class="container py-8" style="background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 50%, #f0fdf4 100%); border-radius: 35px; box-shadow: 0 25px 80px rgba(0,0,0,0.15);">

    <h2 class="text-center product-title mb-6">🐄 Our Premium Products</h2>
    <div class="section-divider"></div>

    <!-- DAIRY COMPARISON TABLE -->
    <div class="bg-white/90 border-0 rounded-4xl shadow-2xl p-8 mb-10 backdrop-blur-xl">
        <h4 class="fw-bold mb-6 text-center fs-2" style="background: linear-gradient(135deg, #065f46, #047857); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Understanding Our Dairy Feed Range
        </h4>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-xl rounded-3xl overflow-hidden">
                <thead style="background: linear-gradient(135deg, #065f46, #047857);">
                    <tr>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Feed Type</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Target Production</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Crude Protein</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Energy Level</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Special Benefits</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Dairy Meal Standard</td>
                        <td class="py-5 px-4">7–10 L / Day</td>
                        <td class="py-5 px-4 fw-bold text-success fs-5">15–16%</td>
                        <td class="py-5 px-4">Balanced</td>
                        <td class="py-5 px-4">Affordable daily feed</td>
                        <td class="py-5 px-4"><span class="badge bg-secondary px-4 py-3 fs-6 fw-bold">Standard</span></td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        <td class="py-5 px-4 fw-bold fs-5 text-warning">High Yield Dairy Plus ⭐</td>
                        <td class="py-5 px-4">10–20+ L / Day</td>
                        <td class="py-5 px-4 fw-bold text-warning fs-5">18%+</td>
                        <td class="py-5 px-4 fw-bold text-warning">High Energy</td>
                        <td class="py-5 px-4">Boosts peak production</td>
                        <td class="py-5 px-4"><span class="badge bg-warning text-dark px-4 py-3 fs-6 fw-bold">High Yield</span></td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Dairy Plus / MaxPro</td>
                        <td class="py-5 px-4">Maximum Yield</td>
                        <td class="py-5 px-4 fw-bold text-success fs-5">Up to 19.5%</td>
                        <td class="py-5 px-4 fw-bold text-success">Very High</td>
                        <td class="py-5 px-4">Fertility & fast recovery</td>
                        <td class="py-5 px-4"><span class="badge bg-success px-4 py-3 fs-6 fw-bold">Premium</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FULL IMAGE PRODUCTS -->
    <div class="scroll-container">
        
        <!-- PRODUCT 1 -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge highlight">⭐ Dairyplus High Yield</span>
                <img src="{{ asset('images/sdairy.jpeg') }}" class="product-img" alt="High Yield Dairy Meal" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">High Yield Dairy Meal</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Designed for cows producing high volumes of milk daily with maximum efficiency.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Boosts milk output significantly</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>High protein & energy formula</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Trusted by 5000+ farmers</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,500</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="name" value="High Yield Dairy Meal">
                    <input type="hidden" name="price" value="2500">
                    <input type="hidden" name="image" value="images/sdairy.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- PRODUCT 2 -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge">Layers Mash</span>
                <img src="{{ asset('images/dairyh.jpeg') }}" class="product-img" alt="Layers Mash" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Layers Mash</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Improves egg production and shell quality for healthy layers.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Perfectly balanced nutrients</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Promotes healthy layers</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Most cost effective solution</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 1,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="2">
                    <input type="hidden" name="name" value="Layers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/dairyh.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- PRODUCT 3 -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge">Standard Feed</span>
                <img src="{{ asset('images/darym.jpeg') }}" class="product-img" alt="Dairy Meal Standard" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Dairy Meal Standard</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Ideal for everyday dairy maintenance and consistent production.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Affordable pricing</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Perfectly balanced nutrition</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Easy digestion formula</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,450</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="3">
                    <input type="hidden" name="name" value="Dairy Meal Standard">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/darym.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
