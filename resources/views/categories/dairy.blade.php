@extends('layouts.shop')

@section('title', 'Products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, li, label {
        color: #000 !important;
    }

    /* ====== HEADINGS ====== */
    .product-title {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .section-divider {
        height: 3px;
        width: 90px;
        background: linear-gradient(to right, #065f46, #a7f3d0);
        margin: 18px auto 35px;
        border-radius: 20px;
    }

    /* ====== TABLE ====== */
    .table tbody tr:hover {
        background-color: #ecfdf5;
        transition: .25s ease;
    }

    /* ====== PRODUCTS SCROLL ====== */
    .scroll-container {
        display: flex;
        gap: 25px;
        overflow-x: auto;
        padding-bottom: 25px;
        scroll-behavior: smooth;
    }

    .scroll-container::-webkit-scrollbar {
        height: 8px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 20px;
    }

    /* ====== PRODUCT CARD ====== */
    .product-card {
        min-width: 320px;
        max-width: 320px;
        border-radius: 14px;
        border: 1px solid #d1d5db;
        background: #fff;
        transition: all .3s ease;
        flex-shrink: 0;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 35px rgba(6,95,70,.25);
        border-color: #065f46;
    }

    .product-img {
        height: 240px;
        object-fit: cover;
        width: 100%;
    }

    /* ====== BADGES ====== */
    .feed-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #065f46;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,.2);
    }

    .feed-badge.highlight {
        background: #f59e0b;
        color: #000;
    }

    /* ====== BUTTON ====== */
    .btn-buy {
        background: linear-gradient(135deg, #065f46, #047857);
        font-weight: 700;
        color: #fff !important;
        padding: 12px 0;
        border-radius: 10px;
        transition: all .3s ease;
    }

    .btn-buy:hover {
        transform: scale(1.04);
        box-shadow: 0 10px 25px rgba(6,95,70,.35);
    }

    ul li {
        list-style: none;
        margin-bottom: 6px;
    }

    /* ul li::before {
        content: "🌱 ";
    } */
</style>

<div class="container py-5" style="background:#f8fafc;border-radius:18px;">

    <h2 class="text-center product-title">Our Products</h2>
    <div class="section-divider"></div>

    {{-- ========================= --}}
    {{-- DAIRY FEED EXPLANATION --}}
    {{-- ========================= --}}
    <div class="bg-white border rounded-lg shadow-sm p-4 mb-5">

        <h4 class="fw-bold mb-3 text-center">Understanding Our Dairy Feed Options</h4>

        <p class="mb-3">
            <strong>Dairy Meal Standard</strong>, <strong>Dairy High Yield</strong>, and 
            <strong>Dairy Plus (MaxPro Plus)</strong> are specially formulated feeds designed 
            for different milk production levels. The main difference is their 
            <strong>protein content, energy levels, and added nutritional boosters</strong>.
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark align-middle shadow text-center">

                <thead class="table-dark">
                    <tr>
                        <th class="border border-dark">Feed Type</th>
                        <th class="border border-dark">Target Production</th>
                        <th class="border border-dark">Crude Protein</th>
                        <th class="border border-dark">Energy Level</th>
                        <th class="border border-dark">Special Benefits</th>
                        <th class="border border-dark">Category</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="border border-dark fw-bold">Dairy Meal Standard</td>
                        <td class="border border-dark">7–10 L / Day</td>
                        <td class="border border-dark">15–16%</td>
                        <td class="border border-dark">Balanced</td>
                        <td class="border border-dark">Affordable daily feed</td>
                        <td class="border border-dark">
                            <span class="badge bg-secondary px-3 py-2">Standard Feed</span>
                        </td>
                    </tr>

                    <tr class="table-warning">
                        <td class="border border-dark fw-bold">High Yield Dairy Plus ⭐</td>
                        <td class="border border-dark">10–20+ L / Day</td>
                        <td class="border border-dark">18%+</td>
                        <td class="border border-dark">High Energy</td>
                        <td class="border border-dark">Boosts peak production</td>
                        <td class="border border-dark">
                            <span class="badge bg-warning text-dark px-3 py-2">
                                Best for High Yield
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="border border-dark fw-bold">Dairy Plus / MaxPro</td>
                        <td class="border border-dark">Maximum Yield</td>
                        <td class="border border-dark">Up to 19.5%</td>
                        <td class="border border-dark">Very High</td>
                        <td class="border border-dark">Fertility & fast recovery</td>
                        <td class="border border-dark">
                            <span class="badge bg-success px-3 py-2">Premium Feed</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- PRODUCTS --}}
    {{-- ========================= --}}
    <div class="scroll-container">

        {{-- Product 1 --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge highlight">⭐Dairyplus High Yield</span>
                <img src="{{ asset('images/dairyhigh.jpeg') }}" class="product-img">
            </div>

            <div class="p-3">
                <h5 class="fw-bold">High Yield Dairy Meal</h5>
                <p>Designed for cows producing high volumes of milk.</p>

                <ul class="small">
                    <li>Boosts milk output</li>
                    <li>High protein & energy</li>
                    <li>Trusted by farmers</li>
                </ul>

                <h6 class="fw-bold mb-3">Ksh 2,500</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="name" value="High Yield Dairy Meal">
                    <input type="hidden" name="price" value="2500">
                    <input type="hidden" name="image" value="images/dairyhigh.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div>

        {{-- Product 2 --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge">Dairymeal High Yield</span>
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">
            </div>

            <div class="p-3">
                <h5 class="fw-bold">Layers Mash</h5>
                <p>Improves egg production and shell quality.</p>

                <ul class="small">
                    <li>Balanced nutrients</li>
                    <li>Healthy layers</li>
                    <li>Cost effective</li>
                </ul>

                <h6 class="fw-bold mb-3">Ksh 1,800</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="2">
                    <input type="hidden" name="name" value="Layers Mash">
                    <input type="hidden" name="price" value="1800">
                    <input type="hidden" name="image" value="images/kienyeji.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div>

        {{-- Product 3 --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge">Standard Feed</span>
                <img src="{{ asset('images/dairy.jpeg') }}" class="product-img">
            </div>

            <div class="p-3">
                <h5 class="fw-bold">Dairy Meal Standard</h5>
                <p>Ideal for everyday dairy maintenance.</p>

                <ul class="small">
                    <li>Affordable</li>
                    <li>Balanced nutrition</li>
                    <li>Easy digestion</li>
                </ul>

                <h6 class="fw-bold mb-3">Ksh 2,450</h6>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="3">
                    <input type="hidden" name="name" value="Dairy Meal Standard">
                    <input type="hidden" name="price" value="2450">
                    <input type="hidden" name="image" value="images/dairy.jpeg">

                    <button class="btn btn-buy w-100">Add to Cart</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
