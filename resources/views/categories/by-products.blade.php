@extends('layouts.shop')

@section('title', 'Feed By-products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, li, label {
        color: #000 !important;
    }

    .product-title {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .section-divider {
        height: 3px;
        width: 100px;
        background: linear-gradient(to right, #065f46, #a7f3d0);
        margin: 15px auto 35px;
        border-radius: 20px;
    }

    /* ===== TABLE ===== */
    .table tbody tr {
        vertical-align: middle;
    }

    .table td, .table th {
        padding: 15px 12px;
        line-height: 1.5;
        border-right: 1px solid #6b7280;
    }

    .table th {
        font-size: 16px;
        letter-spacing: 0.5px;
    }

    .table td:last-child {
        border-right: 0;
    }

    .table tbody tr td {
        border-bottom: 1px solid #6b7280;
    }

    .table tbody tr:hover {
        background: #f0fdf4;
        transition: .25s ease;
    }

    /* ===== PRODUCT GRID ===== */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    .product-card {
        border-radius: 14px;
        border: 1px solid #d1d5db;
        background: #fff;
        transition: all .3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(6,95,70,.25);
        border-color: #065f46;
    }

    .product-img {
        height: 240px;
        object-fit: cover;
        width: 100%;
    }

    /* ===== BADGES ===== */
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
    }

    .feed-badge.bran { background: #dc2626; }
    .feed-badge.pollard { background: #2563eb; }
    .feed-badge.germ { background: #f59e0b; color: #000; }

    /* ===== BUTTON ===== */
    .btn-buy {
        background: linear-gradient(135deg, #065f46, #047857);
        font-weight: 700;
        color: #fff !important;
        padding: 12px 0;
        border-radius: 10px;
        transition: all .3s ease;
    }

    .btn-buy:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(6,95,70,.35);
    }

    ul li {
        list-style: none;
        margin-bottom: 6px;
    }

    /* ul li::before {
        content: "🌾 ";
    } */
</style>

<div class="container py-5" style="background:#f8fafc;border-radius:18px;">

    <h2 class="text-center product-title">Feed By-products</h2>
    <div class="section-divider"></div>

    {{-- FEED EXPLANATION --}}
    <div class="bg-white border rounded-lg shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-3">Overview of Feed By-products</h4>
        <p class="mb-3">
            Wheat bran, pollard, and maize germ are feed by-products differing in origin and nutrient profile.
            Bran is high in fiber, Germ is nutrient-dense in fats, protein & vitamins, and Pollard offers a balanced energy/protein source.
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark align-middle shadow text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="border border-dark">Feed Type</th>
                        <th class="border border-dark">Origin</th>
                        <th class="border border-dark">Content</th>
                        <th class="border border-dark">Use</th>
                        <th class="border border-dark">Key Differences</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-danger">
                        <td class="fw-bold border border-dark">Wheat Bran</td>
                        <td class="border border-dark">Outer layer of wheat kernel</td>
                        <td class="border border-dark">High fiber, phosphorus, B vitamins, antioxidants, some protein/energy</td>
                        <td class="border border-dark">Ruminants, gut health, bulk fiber source</td>
                        <td class="border border-dark">Highest fiber; low energy/fats</td>
                    </tr>
                    <tr class="table-primary">
                        <td class="fw-bold border border-dark">Wheat Pollard</td>
                        <td class="border border-dark">Blend of bran, endosperm, germ</td>
                        <td class="border border-dark">More digestible, 14-16% protein, balanced energy</td>
                        <td class="border border-dark">Poultry & pigs; energy/protein boost</td>
                        <td class="border border-dark">Balanced protein & energy; more digestible than bran</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="fw-bold border border-dark">Maize Germ</td>
                        <td class="border border-dark">Embryo of maize kernel</td>
                        <td class="border border-dark">Rich in fats, protein, vitamins, minerals, energy</td>
                        <td class="border border-dark">High-yield dairy, poultry; energy/fat booster</td>
                        <td class="border border-dark">Highest energy (fats); concentrated nutrients</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- FEED PRODUCTS GRID --}}
    <div class="product-grid">

        {{-- Wheat Bran --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge bran">Bran</span>
                <img src="{{ asset('images/bran.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Wheat Bran</h5>
                <p>Bulk fiber source for ruminants, promotes gut health.</p>
                <ul class="small">
                    <li>High fiber</li>
                    <li>Moderate protein</li>
                    <li>Supports digestion</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,200</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Wheat Pollard --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge pollard">Pollard</span>
                <img src="{{ asset('images/pollard.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Wheat Pollard</h5>
                <p>Balanced energy and protein for poultry and pigs.</p>
                <ul class="small">
                    <li>More digestible than bran</li>
                    <li>Higher protein & energy</li>
                    <li>Pellet/mash form</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,500</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Maize Germ --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge germ">Germ</span>
                <img src="{{ asset('images/maize_germ.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Maize Germ</h5>
                <p>High-energy feed boosting fat content for dairy & poultry.</p>
                <ul class="small">
                    <li>Rich in fats & protein</li>
                    <li>Vitamins & minerals</li>
                    <li>Energy-dense feed</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,000</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

    </div>

</div>

@endsection
