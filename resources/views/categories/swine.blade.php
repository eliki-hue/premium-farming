@extends('layouts.shop')

@section('title', 'Pig Feeds')

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

    .feed-badge.starter { background: #dc2626; }
    .feed-badge.grower { background: #2563eb; }
    .feed-badge.finisher { background: #f59e0b; color: #000; }
    .feed-badge.sow { background: #047857; }

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
        content: "🐖 ";
    } */
</style>

<div class="container py-5" style="background:#f8fafc;border-radius:18px;">

    <h2 class="text-center product-title">Pig Feeds</h2>
    <div class="section-divider"></div>

    {{-- PIG FEED EXPLANATION --}}
    <div class="bg-white border rounded-lg shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-3">Understanding Pig Feed Options</h4>
        <p class="mb-3">
            Pig feeds are formulated to meet changing nutritional needs at different stages of life. 
            The main differences are in <strong>protein content</strong> and <strong>intended use</strong>.
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark align-middle shadow text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="border border-dark">Feed Type</th>
                        <th class="border border-dark">Target Age/Weight</th>
                        <th class="border border-dark">Crude Protein</th>
                        <th class="border border-dark">Primary Goal</th>
                        <th class="border border-dark">Key Content/Format</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-danger">
                        <td class="fw-bold border border-dark">Pig Starter / Weaner</td>
                        <td class="border border-dark">Piglets 3–10 weeks (10–25 kg)</td>
                        <td class="border border-dark">18–22%</td>
                        <td class="border border-dark">Rapid early growth, smooth weaning transition</td>
                        <td class="border border-dark">Pellets/crumble; milk products, fishmeal, lysine</td>
                    </tr>
                    <tr class="table-primary">
                        <td class="fw-bold border border-dark">Pig Grower</td>
                        <td class="border border-dark">8–16 weeks (25–60 kg)</td>
                        <td class="border border-dark">16–18%</td>
                        <td class="border border-dark">Steady muscle & weight gain</td>
                        <td class="border border-dark">Maize, barley, soybean meal, groundnut cake</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="fw-bold border border-dark">Pig Fattener / Finisher</td>
                        <td class="border border-dark">16–20+ weeks (60 kg to market)</td>
                        <td class="border border-dark">14–16%</td>
                        <td class="border border-dark">Maximize final weight & meat quality</td>
                        <td class="border border-dark">Higher energy, controlled fiber, lower protein</td>
                    </tr>
                    <tr class="table-success">
                        <td class="fw-bold border border-dark">Sow and Weaner</td>
                        <td class="border border-dark">Sows, breeding gilts, boars</td>
                        <td class="border border-dark">16–18%</td>
                        <td class="border border-dark">Support milk production & reproduction</td>
                        <td class="border border-dark">Fortified with vitamins & minerals</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- PIG PRODUCTS GRID --}}
    <div class="product-grid">

        {{-- Pig Starter --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge starter">Starter</span>
                <img src="{{ asset('images/dairyhigh.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Pig Starter Pellets</h5>
                <p>Supports early growth and smooth weaning.</p>
                <ul class="small">
                    <li>High protein</li>
                    <li>Highly digestible</li>
                    <li>Pellet/crumble form</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,500</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Pig Grower --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge grower">Grower</span>
                <img src="{{ asset('images/dairy.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Pig Growers</h5>
                <p>Optimizes muscle and steady weight gain.</p>
                <ul class="small">
                    <li>Moderate protein</li>
                    <li>Balanced energy</li>
                    <li>Pellet or mash</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,450</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Pig Fattener --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge finisher">Finisher</span>
                <img src="{{ asset('images/dairy.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Pig Fattener</h5>
                <p>Maximizes weight and meat quality before market.</p>
                <ul class="small">
                    <li>Lower protein</li>
                    <li>High energy</li>
                    <li>Controlled fiber</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,450</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Sow and Weaner --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge sow">Sow & Weaner</span>
                <img src="{{ asset('images/dairy.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Sow and Weaner Feed</h5>
                <p>Supports reproduction and milk production.</p>
                <ul class="small">
                    <li>High protein</li>
                    <li>Fortified with vitamins & minerals</li>
                    <li>Balanced nutrition</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,450</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

    </div>

</div>

@endsection
