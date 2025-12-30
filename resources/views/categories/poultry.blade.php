@extends('layouts.shop')

@section('title', 'Poultry Feeds')

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
        background: linear-gradient(135deg, #dc2626, #f59e0b, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .section-divider {
        height: 5px;
        width: 150px;
        background: linear-gradient(135deg, #dc2626, #f59e0b, #2563eb);
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
        background: linear-gradient(135deg, #fef3c7, #fef2f2, #dbeafe);
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
        background: linear-gradient(90deg, #dc2626, #f59e0b, #2563eb, #dc2626);
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

    /* ====== CUTE POULTRY BADGES ====== */
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

    .feed-badge.broiler {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        box-shadow: 0 10px 30px rgba(220,38,38,0.6);
    }

    .feed-badge.layer {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        box-shadow: 0 10px 30px rgba(37,99,235,0.6);
    }

    .feed-badge.premium {
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
        background: linear-gradient(135deg, #dc2626, #f59e0b, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 25px 0 20px;
        text-shadow: 0 3px 15px rgba(220,38,38,0.4);
    }

    /* ====== TABLE ENHANCEMENT ====== */
    .table tbody tr:hover {
        background: linear-gradient(135deg, #fef3c7, #fef2f2);
        transform: scale(1.01);
        box-shadow: 0 5px 20px rgba(220,38,38,0.15);
    }

    .table th {
        background: linear-gradient(135deg, #dc2626, #f59e0b) !important;
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

<div class="container py-8" style="background: linear-gradient(135deg, #fef3c7 0%, #fef2f2 50%, #dbeafe 100%); border-radius: 35px; box-shadow: 0 25px 80px rgba(0,0,0,0.15);">

    <h2 class="text-center product-title mb-6">🐔 Poultry Feeds</h2>
    <div class="section-divider"></div>

    <!-- POULTRY COMPARISON TABLE -->
    <div class="bg-white/90 border-0 rounded-4xl shadow-2xl p-8 mb-10 backdrop-blur-xl">
        <h4 class="fw-bold mb-6 text-center fs-2" style="background: linear-gradient(135deg, #dc2626, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Understanding Poultry Feed Stages
        </h4>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-xl rounded-3xl overflow-hidden">
                <thead style="background: linear-gradient(135deg, #dc2626, #f59e0b);">
                    <tr>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Feed Type</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Target Bird</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Protein</th>
                        <th class="py-5 px-4 text-white fw-bold fs-6 border-0">Key Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Chick Starter / Mash</td>
                        <td class="py-5 px-4">Layer Chicks (0–6/8 weeks)</td>
                        <td class="py-5 px-4 fw-bold text-success fs-5">18–22%</td>
                        <td class="py-5 px-4">Rapid early growth, organ development</td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
                        <td class="py-5 px-4 fw-bold fs-5 text-danger">Broiler Starter</td>
                        <td class="py-5 px-4">Broiler Chicks (0–3/4 weeks)</td>
                        <td class="py-5 px-4 fw-bold text-danger fs-5">22–24%</td>
                        <td class="py-5 px-4">Fast muscle growth for meat production</td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5">Growers Mash</td>
                        <td class="py-5 px-4">Pullets (6/8–18 weeks)</td>
                        <td class="py-5 px-4 fw-bold fs-5">14–18%</td>
                        <td class="py-5 px-4">Steady growth without excess fat</td>
                    </tr>
                    <tr style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                        <td class="py-5 px-4 fw-bold fs-5 text-primary">Layer Economy</td>
                        <td class="py-5 px-4">Laying Hens (18+ weeks)</td>
                        <td class="py-5 px-4 fw-bold text-primary fs-5">~16%</td>
                        <td class="py-5 px-4">Cost-effective egg production</td>
                    </tr>
                    <tr class="border-bottom border-light">
                        <td class="py-5 px-4 fw-bold fs-5 text-warning">Superlayers ⭐</td>
                        <td class="py-5 px-4">Commercial Layers</td>
                        <td class="py-5 px-4 fw-bold text-warning fs-5">16–18%</td>
                        <td class="py-5 px-4">Maximum egg size & shell strength</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- FULL IMAGE POULTRY PRODUCTS -->
    <div class="product-grid">
        
        <!-- CHICK STARTER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge">🐣 Chick Starter</span>
                <img src="{{ asset('images/chick start.jpeg') }}" class="product-img" alt="Chick Starter" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Chick Starter / Mash</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Supports early growth and strong immunity for layer chicks (0-8 weeks).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>High protein (18-22%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Low calcium formula</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Easy to digest mash</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 2,500</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="7">
                    <input type="hidden" name="name" value="Chick Starter Mash">
                    <input type="hidden" name="price" value="2500">
                    <input type="hidden" name="image" value="images/chick start.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- BROILER STARTER -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge broiler">🐔 Broiler Starter</span>
                <img src="{{ asset('images/chickmash.jpeg') }}" class="product-img" alt="Broiler Starter" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Broiler Starter</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Rapid muscle and body mass development for meat production (0-4 weeks).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Very high protein (22-24%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>High energy formula</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-danger me-3 fs-5"></i>Fast growth guaranteed</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 1,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="8">
                    <input type="hidden" name="name" value="Broiler Starter">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/chickmash.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- GROWERS MASH -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge">🌱 Growers Mash</span>
                <img src="{{ asset('images/growers.jpeg') }}" class="product-img" alt="Growers Mash" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Growers Mash</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Prepares pullets for healthy laying with controlled weight gain (8-18 weeks).</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Balanced nutrition (14-18%)</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Controls body weight</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-success me-3 fs-5"></i>Strong skeletal frame</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 1,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="9">
                    <input type="hidden" name="name" value="Growers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/growers.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- LAYERS MASH -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge layer">🥚 Layers Mash</span>
                <img src="{{ asset('images/layers.jpeg') }}" class="product-img" alt="Layers Mash" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Layers Mash</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Consistent egg production with strong shells for commercial layers.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>High calcium content</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Good egg size</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-primary me-3 fs-5"></i>Cost effective production</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 1,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="10">
                    <input type="hidden" name="name" value="Layers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/layers.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- SUPERLAYERS -->
        <div class="product-card">
            <div class="position-relative overflow-hidden">
                <span class="feed-badge premium">⭐ Superlayers</span>
                <img src="{{ asset('images/slayers.jpeg') }}" class="product-img" alt="Superlayers Mash" loading="lazy">
            </div>
            <div class="p-6 position-relative">
                <h5 class="fw-bold mb-4 fs-4 lh-base">Superlayers Mash</h5>
                <p class="text-muted mb-4 fs-6 lh-lg">Premium feed for maximum egg yield and peak performance.</p>
                <ul class="small mb-5 ps-0 fs-6">
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>High-quality protein</li>
                    <li class="mb-2 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Superior shell strength</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i>Peak egg production</li>
                </ul>
                <h6 class="price-tag mb-5">Ksh 1,800</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="11">
                    <input type="hidden" name="name" value="Superlayers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/slayers.jpeg">
                    <button type="submit" class="btn btn-buy w-100">
                        <i class="fas fa-shopping-cart me-3"></i>Add to Cart
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
