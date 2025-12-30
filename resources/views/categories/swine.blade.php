@extends('layouts.shop')

@section('title', 'Pig Feeds')

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
        background: linear-gradient(135deg, #8b4513, #dc2626, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .section-divider {
        height: 5px;
        width: 150px;
        background: linear-gradient(135deg, #8b4513, #dc2626, #f59e0b);
        margin: 25px auto 50px;
        border-radius: 30px;
        box-shadow: 0 4px 20px rgba(139,69,19,0.4);
    }

    /* ====== FULL IMAGE - NO CROPPING PERFECT ====== */
    .product-img {
        height: 380px !important;
        width: 100%;
        object-fit: contain !important;
        object-position: center top;
        background: linear-gradient(135deg, #fdf4f4, #fef3c7, #fee2e2);
        padding: 30px 20px;
        border-radius: 28px 28px 0 0;
        transition: all .5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 4px 25px rgba(0,0,0,0.08);
        border-bottom: 4px solid rgba(139,69,19,0.1);
    }

    .product-card:hover .product-img {
        transform: scale(1.02);
        padding: 25px 15px;
        filter: brightness(1.08) contrast(1.06) saturate(1.08);
        box-shadow: inset 0 2px 20px rgba(139,69,19,0.15), 0 20px 45px rgba(139,69,19,0.35);
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
        background: linear-gradient(90deg, #8b4513, #dc2626, #f59e0b, #8b4513);
        z-index: 2;
    }

    .product-card:hover {
        transform: translateY(-20px) scale(1.025);
        box-shadow: 0 40px 80px rgba(139,69,19,0.4);
        border: 2px solid rgba(139,69,19,0.25);
    }

    /* ====== PERFECT GRID ====== */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
        gap: 35px;
        margin-top: 30px;
    }

    /* ====== CUTE PIG BADGES ====== */
    .feed-badge {
        position: absolute;
        top: 25px;
        left: 25px;
        font-size: 13px;
        font-weight: 900;
        padding: 12px 18px;
        border-radius: 35px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        backdrop-filter: blur(25px);
        border: 2px solid rgba(255,255,255,0.5);
        z-index: 4;
        animation: float 3s ease-in-out infinite;
    }

    .feed-badge.starter {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        box-shadow: 0 10px 30px rgba(220,38,38,0.6);
    }

    .feed-badge.grower {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        box-shadow: 0 10px 30px rgba(37,99,235,0.6);
    }

    .feed-badge.finisher {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        box-shadow: 0 10px 30px rgba(245,158,11,0.6);
        animation: pulse 2s infinite;
    }

    .feed-badge.sow {
        background: linear-gradient(135deg, #047857, #065f46);
        color: #fff;
        box-shadow: 0 10px 30px rgba(4,120,87,0.6);
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    /* ====== PROFESSIONAL BUTTONS ====== */
    .btn-buy {
        background: linear-gradient(135deg, #8b4513 0%, #dc2626 50%, #a52a2a 100%);
        font-weight: 900;
        color: #fff !important;
        padding: 18px 0;
        border-radius: 25px;
        border: none;
        font-size: 17px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all .4s ease;
        box-shadow: 0 10px 30px rgba(139,69,19,0.45);
        position: relative;
        overflow: hidden;
        margin-top: 20px;
        z-index: 3;
    }

    .btn-buy:hover {
        transform: translateY(-4px) scale(1.07);
        box-shadow: 0 20px 50px rgba(139,69,19,0.6);
    }

    /* ====== GLOWING PRICE ====== */
    .price-tag {
        font-size: 32px !important;
        font-weight: 950 !important;
        background: linear-gradient(135deg, #8b4513, #dc2626, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 25px 0 20px;
        text-shadow: 0 3px 15px rgba(139,69,19,0.4);
    }

    /* ====== TABLE ENHANCEMENT ====== */
    .table tbody tr:hover {
        background: linear-gradient(135deg, #fdf4f4, #fee2e2);
        transform: scale(1.01);
        box-shadow: 0 5px 20px rgba(139,69,19,0.15);
    }

    .table th {
        background: linear-gradient(135deg, #8b4513, #dc2626) !important;
        color: #fff !important;
        font-weight: 800 !important;
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 768px) {
        .product-card { min-width: 360px !important; max-width: 360px !important; }
        .product-img { height: 320px !important; padding: 25px 15px !important; }
        .product-grid { grid-template-columns: 1fr; gap: 25px; }
    }

    @media (max-width: 480px) {
        .product-card { min-width: 320px !important; max-width: 320px !important; }
        .product-img { height: 280px !important; padding: 20px 12px !important; }
    }
</style>

<div class="container py-8" style="background: linear-gradient(135deg, #fdf4f4 0%, #fee2e2 50%, #fef3c7 100%); border-radius: 35px; box-shadow: 0 25px 80px rgba(0,0,0,0.15);">

    <h2 class="text-center product-title mb-6">🐖 Pig Feeds</h2>
    <div class="section-divider"></div>

    <!-- PIG COMPARISON TABLE -->
    <div class="bg-white/90 border-0 rounded-4xl shadow-2xl p-8 mb-10 backdrop-blur-xl">
        <h4 class="fw-bold mb-6 text-center fs-2" style="background: linear-gradient(135deg, #8b4513, #dc2626); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Understanding Pig Feed Stages
        </h4>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-xl rounded-3xl overflow-hidden">
                <thead style="background: linear-gradient(135deg, #8b4513, #dc2626);">
                    <tr>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Feed Type</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Target Age/Weight</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Crude Protein</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Primary Goal</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Key Content</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                        <td class="py-5 px-4 fw-bold fs-5 text-danger">Pig Starter / Weaner</td>
                        <td class="py-5 px-4">Piglets 3–10 weeks (10–25 kg)</td>
                        <td class="py-5 px-4 fw-bold text-danger fs-5">18–22%</td>
                        <td class="py-5 px-4">Rapid early growth, smooth weaning</td>
                        <td class="py-5 px-4">Milk products, fishmeal, lysine</td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Pig Grower</td>
                        <td class="py-5 px-4">8–16 weeks (25–60 kg)</td>
                        <td class="py-5 px-4 fw-bold text-primary fs-5">16–18%</td>
                        <td class="py-5 px-4">Steady muscle & weight gain</td>
                        <td class="py-5 px-4">Maize, soybean, groundnut cake</td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        <td class="py-5 px-4 fw-bold fs-5 text-warning">Pig Fattener / Finisher</td>
                        <td class="py-5 px-4">16–20+ weeks (60 kg to market)</td>
                        <td class="py-5 px-4 fw-bold text-warning fs-5">14–16%</td>
                        <td class="py-5 px-4">Maximize final weight & meat quality</td>
                        <td class="py-5 px-4">High energy, controlled fiber</td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5 text-success">Sow and Weaner</td>
                        <td class="py-5 px-4">Sows, breeding gilts, boars</td>
                        <td class="py-5 px-4 fw-bold text-success fs-5">16–18%</td>
                        <td class="py-5 px-4">Support milk production & reproduction</td>
                        <td class="py-5 px-4">Fortified vitamins & minerals</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FULL IMAGE PIG PRODUCTS -->
    <div class="product-grid">
        
        <!-- PIG STARTER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge starter">🐷 Starter</span>
                <img src="{{ asset('images/piggrower.jpeg') }}" class="product-img" alt="Pig Starter Pellets" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Pig Starter Pellets</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Supports early growth and smooth weaning for piglets (3-10 weeks, 10-25kg).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>High protein (18-22%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Highly digestible pellets</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Smooth weaning transition</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,500</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="12">
                    <input type="hidden" name="name" value="Pig Starter Pellets">
                    <input type="hidden" name="price" value="2500">
                    <input type="hidden" name="image" value="images/piggrower.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- PIG GROWER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge grower">🐖 Grower</span>
                <img src="{{ asset('images/spig grower.jpeg') }}" class="product-img" alt="Pig Growers" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Pig Growers</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Optimizes muscle development and steady weight gain (8-16 weeks, 25-60kg).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Moderate protein (16-18%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Balanced energy formula</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Steady muscle growth</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,450</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="13">
                    <input type="hidden" name="name" value="Pig Growers">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/spig grower.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- SOW & WEANER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge sow">🐷 Sow & Weaner</span>
                <img src="{{ asset('images/sowwen.jpeg') }}" class="product-img" alt="Sow and Weaner Feed" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Sow and Weaner Feed</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Supports reproduction, milk production for sows, gilts and boars.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>High protein (16-18%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Fortified vitamins & minerals</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Reproduction support</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,450</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="14">
                    <input type="hidden" name="name" value="Sow and Weaner Feed">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/sowwen.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- PIG FATENER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge finisher">⭐ Finisher</span>
                <img src="{{ asset('images/pfter.jpeg') }}" class="product-img" alt="Pig Fattener" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Pig Fattener</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Maximizes weight gain and meat quality before market (60kg+).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Lower protein (14-16%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>High energy formula</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Superior meat quality</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,450</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="15">
                    <input type="hidden" name="name" value="Pig Fattener">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/pfter.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
