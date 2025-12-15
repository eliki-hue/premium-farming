@extends('layouts.shop')

@section('title', 'Pet Feeds')

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

    .feed-badge.calf { background: #dc2626; }
    .feed-badge.dog { background: #2563eb; }
    .feed-badge.rabbit { background: #f59e0b; color: #000; }

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
        content: "🐾 ";
    } */
</style>

<div class="container py-5" style="background:#f8fafc;border-radius:18px;">

    <h2 class="text-center product-title">Pet Feeds</h2>
    <div class="section-divider"></div>

    {{-- FEED EXPLANATION --}}
    <div class="bg-white border rounded-lg shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-3">Overview of Pet Feeds</h4>
        <p class="mb-3">
            Our pet feeds are formulated to meet the nutritional needs of calves, dogs, and rabbits. Each feed type provides targeted protein, energy, and vitamins to support growth, health, and overall well-being.
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark align-middle shadow text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="border border-dark">Feed Type</th>
                        <th class="border border-dark">Target Animal</th>
                        <th class="border border-dark">Protein / Energy</th>
                        <th class="border border-dark">Primary Goal</th>
                        <th class="border border-dark">Key Features</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-danger">
                        <td class="fw-bold border border-dark">Calf Pellets</td>
                        <td class="border border-dark">Young calves (0–6 months)</td>
                        <td class="border border-dark">High protein, moderate energy</td>
                        <td class="border border-dark">Supports healthy growth & immune system</td>
                        <td class="border border-dark">Easily digestible, enriched with vitamins & minerals</td>
                    </tr>
                    <tr class="table-primary">
                        <td class="fw-bold border border-dark">Dog Meal</td>
                        <td class="border border-dark">All breeds, puppies & adult dogs</td>
                        <td class="border border-dark">Balanced protein & fats</td>
                        <td class="border border-dark">Supports growth, coat health, and energy levels</td>
                        <td class="border border-dark">Contains essential amino acids & vitamins</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="fw-bold border border-dark">Rabbit Pellets</td>
                        <td class="border border-dark">Rabbits (all ages)</td>
                        <td class="border border-dark">Moderate protein, high fiber</td>
                        <td class="border border-dark">Supports gut health & steady growth</td>
                        <td class="border border-dark">Contains essential fiber and minerals</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- FEED PRODUCTS GRID --}}
    <div class="product-grid">

        {{-- Calf Pellets --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge calf">Calf</span>
                <img src="{{ asset('images/calf_pellets.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Calf Pellets</h5>
                <p>Supports healthy growth, strong bones, and immunity in young calves.</p>
                <ul class="small">
                    <li>High protein</li>
                    <li>Vitamins & minerals</li>
                    <li>Easily digestible</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 3,500</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Dog Meal --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge dog">Dog</span>
                <img src="{{ asset('images/dog_meal.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Dog Meal</h5>
                <p>Balanced nutrition for puppies and adult dogs to support growth and coat health.</p>
                <ul class="small">
                    <li>High-quality protein</li>
                    <li>Balanced fats</li>
                    <li>Essential vitamins & minerals</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,800</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Rabbit Pellets --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge rabbit">Rabbit</span>
                <img src="{{ asset('images/rabbit_pellets.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Rabbit Pellets</h5>
                <p>High-fiber feed supporting gut health and steady growth in rabbits.</p>
                <ul class="small">
                    <li>Moderate protein</li>
                    <li>Rich in fiber</li>
                    <li>Contains essential minerals</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,200</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

    </div>

</div>

@endsection
