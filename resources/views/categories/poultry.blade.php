@extends('layouts.shop')

@section('title', 'Poultry Feeds')

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

    .feed-badge.broiler {
        background: #dc2626;
    }

    .feed-badge.layer {
        background: #2563eb;
    }

    .feed-badge.premium {
        background: #f59e0b;
        color: #000;
    }

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
        content: "🐔 ";
    } */
</style>

<div class="container py-5" style="background:#f8fafc;border-radius:18px;">
    <h2 class="text-center product-title">Poultry Feeds</h2>
    <div class="section-divider"></div>

    {{-- POULTRY FEED EXPLANATION --}}
    <div class="bg-white border rounded-lg shadow-sm p-4 mb-5">
        <h4 class="fw-bold text-center mb-3">Understanding Our Poultry Feed Options</h4>
        <p class="mb-3">
            Poultry feeds are formulated to meet specific nutritional needs at different
            life stages or production goals (<strong>meat vs eggs</strong>).
            The main differences are in <strong>protein, energy, calcium content</strong>,
            and the <strong>physical form</strong> of the feed.
        </p>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark align-middle shadow text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="border border-dark">Feed Type</th>
                        <th class="border border-dark">Target Bird</th>
                        <th class="border border-dark">Protein</th>
                        <th class="border border-dark">Key Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-dark fw-bold">Chick Starter / Chick Mash</td>
                        <td class="border border-dark">Layer Chicks (0–6/8 weeks)</td>
                        <td class="border border-dark">18–22%</td>
                        <td class="border border-dark">
                            Rapid early growth, organ development, low calcium
                        </td>
                    </tr>
                    <tr class="table-danger">
                        <td class="border border-dark fw-bold">Broiler Starter</td>
                        <td class="border border-dark">Broiler Chicks (0–3/4 weeks)</td>
                        <td class="border border-dark">22–24%</td>
                        <td class="border border-dark">Fast muscle growth for meat production</td>
                    </tr>
                    <tr>
                        <td class="border border-dark fw-bold">Growers Mash</td>
                        <td class="border border-dark">Pullets (6/8–18 weeks)</td>
                        <td class="border border-dark">14–18%</td>
                        <td class="border border-dark">Steady growth without excess fat</td>
                    </tr>
                    <tr>
                        <td class="border border-dark fw-bold">Kienyeji Feed</td>
                        <td class="border border-dark">Indigenous / Dual-purpose</td>
                        <td class="border border-dark">16–18%</td>
                        <td class="border border-dark">Hardy birds, free-range supplementation</td>
                    </tr>
                    <tr class="table-primary">
                        <td class="border border-dark fw-bold">Layer Economy</td>
                        <td class="border border-dark">Laying Hens (18+ weeks)</td>
                        <td class="border border-dark">~16%</td>
                        <td class="border border-dark">Cost-effective egg production, high calcium</td>
                    </tr>
                    <tr class="table-warning">
                        <td class="border border-dark fw-bold">Superlayers ⭐</td>
                        <td class="border border-dark">Commercial Layers</td>
                        <td class="border border-dark">16–18%</td>
                        <td class="border border-dark">Maximum egg size, shell strength & yield</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- POULTRY PRODUCTS GRID --}}
    <div class="product-grid">

        {{-- Chick Starter --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge">Starter</span>
                <img src="{{ asset('images/dairyhigh.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Chick Starter / Mash</h5>
                <p>Supports early growth and strong immunity.</p>
                <ul class="small">
                    <li>High protein</li>
                    <li>Low calcium</li>
                    <li>Easy to digest</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 2,500</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Broiler Starter --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge broiler">Broiler</span>
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Broiler Starter</h5>
                <p>Rapid muscle and body mass development.</p>
                <ul class="small">
                    <li>Very high protein</li>
                    <li>High energy</li>
                    <li>Fast growth</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,800</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Growers --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge">Grower</span>
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Growers Mash</h5>
                <p>Prepares pullets for healthy laying.</p>
                <ul class="small">
                    <li>Balanced nutrition</li>
                    <li>Controls weight</li>
                    <li>Strong frame</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,800</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Layers --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge layer">Layers</span>
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Layers Mash</h5>
                <p>Consistent egg production with strong shells.</p>
                <ul class="small">
                    <li>High calcium</li>
                    <li>Good egg size</li>
                    <li>Cost effective</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,800</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

        {{-- Superlayers --}}
        <div class="product-card">
            <div class="position-relative">
                <span class="feed-badge premium">⭐ Superlayers</span>
                <img src="{{ asset('images/kienyeji.jpeg') }}" class="product-img">
            </div>
            <div class="p-3">
                <h5 class="fw-bold">Superlayers Mash</h5>
                <p>Premium feed for maximum egg yield.</p>
                <ul class="small">
                    <li>High-quality protein</li>
                    <li>Strong shells</li>
                    <li>Peak performance</li>
                </ul>
                <h6 class="fw-bold mb-3">Ksh 1,800</h6>
                <button class="btn btn-buy w-100">Add to Cart</button>
            </div>
        </div>

    </div>
</div>

@endsection
