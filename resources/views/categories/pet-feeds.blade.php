@extends('layouts.shop')

@section('title', 'Pet Feeds')

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
        background: linear-gradient(135deg, #dc2626, #2563eb, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .section-divider {
        height: 5px;
        width: 150px;
        background: linear-gradient(135deg, #dc2626, #2563eb, #f59e0b);
        margin: 25px auto 50px;
        border-radius: 30px;
        box-shadow: 0 4px 20px rgba(220,38,38,0.4);
    }

    /* ====== FULL IMAGE - NO CROPPING PERFECT ====== */
    .product-img {
        height: 380px !important;
        width: 100%;
        object-fit: contain !important;
        object-position: center top;
        background: linear-gradient(135deg, #fef2f2, #dbeafe, #fef3c7);
        padding: 30px 20px;
        border-radius: 28px 28px 0 0;
        transition: all .5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: inset 0 4px 25px rgba(0,0,0,0.08);
        border-bottom: 4px solid rgba(220,38,38,0.1);
    }

    .product-card:hover .product-img {
        transform: scale(1.02);
        padding: 25px 15px;
        filter: brightness(1.08) contrast(1.06) saturate(1.08);
        box-shadow: inset 0 2px 20px rgba(220,38,38,0.15), 0 20px 45px rgba(220,38,38,0.35);
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
        background: linear-gradient(90deg, #dc2626, #2563eb, #f59e0b, #dc2626);
        z-index: 2;
    }

    .product-card:hover {
        transform: translateY(-20px) scale(1.025);
        box-shadow: 0 40px 80px rgba(220,38,38,0.4);
        border: 2px solid rgba(220,38,38,0.25);
    }

    /* ====== PERFECT GRID ====== */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
        gap: 35px;
        margin-top: 30px;
    }

    /* ====== CUTE BADGES ====== */
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

    .feed-badge.calf {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        box-shadow: 0 10px 30px rgba(220,38,38,0.6);
    }

    .feed-badge.dog {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        box-shadow: 0 10px 30px rgba(37,99,235,0.6);
    }

    .feed-badge.rabbit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        box-shadow: 0 10px 30px rgba(245,158,11,0.6);
        animation: pulse 2s infinite;
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
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #ef4444 100%);
        font-weight: 900;
        color: #fff !important;
        padding: 18px 0;
        border-radius: 25px;
        border: none;
        font-size: 17px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        transition: all .4s ease;
        box-shadow: 0 10px 30px rgba(220,38,38,0.45);
        position: relative;
        overflow: hidden;
        margin-top: 20px;
        z-index: 3;
    }

    .btn-buy:hover {
        transform: translateY(-4px) scale(1.07);
        box-shadow: 0 20px 50px rgba(220,38,38,0.6);
    }

    /* ====== GLOWING PRICE ====== */
    .price-tag {
        font-size: 32px !important;
        font-weight: 950 !important;
        background: linear-gradient(135deg, #dc2626, #2563eb, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 25px 0 20px;
        text-shadow: 0 3px 15px rgba(220,38,38,0.4);
    }

    /* ====== TABLE ENHANCEMENT ====== */
    .table tbody tr:hover {
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        transform: scale(1.01);
        box-shadow: 0 5px 20px rgba(220,38,38,0.15);
    }

    .table th {
        background: linear-gradient(135deg, #dc2626, #2563eb) !important;
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

<div class="container py-8" style="background: linear-gradient(135deg, #fef2f2 0%, #dbeafe 50%, #fef3c7 100%); border-radius: 35px; box-shadow: 0 25px 80px rgba(0,0,0,0.15);">

    <h2 class="text-center product-title mb-6">🐶 Pet Feeds</h2>
    <div class="section-divider"></div>

    <!-- PET FEED COMPARISON TABLE -->
    <div class="bg-white/90 border-0 rounded-4xl shadow-2xl p-8 mb-10 backdrop-blur-xl">
        <h4 class="fw-bold mb-6 text-center fs-2" style="background: linear-gradient(135deg, #dc2626, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            🐰 Overview of Pet Feeds
        </h4>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-xl rounded-3xl overflow-hidden">
                <thead style="background: linear-gradient(135deg, #dc2626, #2563eb);">
                    <tr>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Feed Type</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Target Animal</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Protein / Energy</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Primary Goal</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Key Features</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Calf Pellets</td>
                        <td class="py-5 px-4">Young calves (0–6 months)</td>
                        <td class="py-5 px-4 fw-bold text-danger fs-5">High protein, moderate energy</td>
                        <td class="py-5 px-4">Supports healthy growth & immune system</td>
                        <td class="py-5 px-4">Easily digestible, enriched with vitamins & minerals</td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                        <td class="py-5 px-4 fw-bold fs-5 text-primary">Dog Meal</td>
                        <td class="py-5 px-4">All breeds, puppies & adult dogs</td>
                        <td class="py-5 px-4 fw-bold text-primary fs-5">Balanced protein & fats</td>
                        <td class="py-5 px-4">Supports growth, coat health, and energy levels</td>
                        <td class="py-5 px-4">Contains essential amino acids & vitamins</td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Rabbit Pellets</td>
                        <td class="py-5 px-4">Rabbits (all ages)</td>
                        <td class="py-5 px-4 fw-bold text-warning fs-5">Moderate protein, high fiber</td>
                        <td class="py-5 px-4">Supports gut health & steady growth</td>
                        <td class="py-5 px-4">Contains essential fiber and minerals</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FULL IMAGE PET PRODUCTS -->
    <div class="product-grid">
        
        <!-- CALF PELLETS -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge calf">🐮 Calf Pellets</span>
                <img src="{{ asset('images/cpellets.jpeg') }}" class="product-img" alt="Calf Pellets" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Calf Pellets</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Supports healthy growth, strong bones, and immunity in young calves (0-6 months).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>High protein formula</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Vitamins & minerals enriched</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Easily digestible pellets</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 3,500</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="4">
                    <input type="hidden" name="name" value="Calf Pellets">
                    <input type="hidden" name="price" value="3500">
                    <input type="hidden" name="image" value="images/cpellets.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- DOG MEAL -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge dog">🐕 Dog Meal</span>
                <img src="{{ asset('images/dogm.jpeg') }}" class="product-img" alt="Dog Meal" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Dog Meal</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Balanced nutrition for puppies and adult dogs to support growth and coat health.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>High-quality protein</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Balanced essential fats</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Complete vitamin complex</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="5">
                    <input type="hidden" name="name" value="Dog Meal">
                    <input type="hidden" name="price" value="2800">
                    <input type="hidden" name="image" value="images/dogm.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- RABBIT PELLETS -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge rabbit">🐰 Rabbit Pellets</span>
                <img src="{{ asset('images/rabit1.jpeg') }}" class="product-img" alt="Rabbit Pellets" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Rabbit Pellets</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">High-fiber feed supporting gut health and steady growth in rabbits of all ages.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Moderate protein balance</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Rich in essential fiber</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Complete mineral profile</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,200</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="6">
                    <input type="hidden" name="name" value="Rabbit Pellets">
                    <input type="hidden" name="price" value="2200">
                    <input type="hidden" name="image" value="images/rabit1.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
