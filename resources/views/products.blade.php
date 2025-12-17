@extends('layouts.app')

@section('title', 'Our Products - Premium Farming Feeds')

@push('styles')
<style>
    .products-hero {
        background: linear-gradient(rgba(45, 95, 78, 0.9), rgba(30, 68, 54, 0.9)),
                    url('https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=2000') center/cover;
        padding: 8rem 0 4rem;
        color: white;
        text-align: center;
    }

    .products-hero h1 {
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .products-hero p {
        font-size: 1.3rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .products-main {
        padding: 4rem 0;
        background-color: var(--light-bg);
    }

    .filters-sidebar {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        position: sticky;
        top: 100px;
    }

    .filters-sidebar h3 {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
    }

    .filter-group {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .filter-group h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .filter-option {
        margin-bottom: 0.8rem;
    }

    .filter-option label {
        display: flex;
        align-items: center;
        cursor: pointer;
        color: var(--text-dark);
    }

    .filter-option input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: var(--primary-green);
    }

    .price-range {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .price-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .products-count {
        color: var(--text-muted);
    }

    .sort-dropdown {
        padding: 0.8rem 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        font-weight: 500;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 2px solid transparent;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        border-color: var(--accent-orange);
    }

    .product-image-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
        background-color: #f5f5f5;
        flex-shrink: 0;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: all 0.5s ease;
        display: block;
    }

    .product-card:hover .product-image {
        transform: scale(1.1);
    }

    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        gap: 0.5rem;
        z-index: 2;
    }

    .badge-premium {
        background-color: var(--primary-green);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .badge-sale {
        background-color: #dc3545;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .product-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-category {
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        color: var(--text-dark);
        line-height: 1.4;
        min-height: 2.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .stars {
        color: #fbbf24;
        display: flex;
        gap: 2px;
        font-size: 0.9rem;
    }

    .rating-text {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .product-footer {
        margin-top: auto;
    }

    .product-price {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        margin-bottom: 1rem;
    }

    .price-wrapper {
        display: flex;
        align-items: baseline;
        gap: 0.5rem;
    }

    .price-current {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-green);
        line-height: 1;
    }

    .price-old {
        font-size: 0.95rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }

    .price-unit {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-add-cart {
        flex: 1;
        padding: 0.8rem 1rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45, 95, 78, 0.3);
    }

    .btn-add-cart.added {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .btn-wishlist {
        width: 45px;
        height: 45px;
        background-color: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .btn-wishlist:hover {
        border-color: #ef4444;
        color: #ef4444;
        background-color: #fee;
    }

    .btn-wishlist.active {
        border-color: #ef4444;
        color: white;
        background-color: #ef4444;
    }

    .btn-wishlist i {
        transition: transform 0.3s ease;
    }

    .btn-wishlist:hover i {
        transform: scale(1.2);
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.8rem;
        padding: 0.5rem;
        background-color: var(--light-bg);
        border-radius: 8px;
    }

    .quantity-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-left: auto;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        color: var(--primary-green);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .qty-btn:hover {
        background-color: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }

    .qty-input {
        width: 45px;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 0.3rem;
        font-weight: 600;
        background-color: white;
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        top: 100px;
        right: 20px;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 1rem;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        min-width: 300px;
    }

    .toast-notification.success {
        border-left: 4px solid #10b981;
    }

    .toast-notification.error {
        border-left: 4px solid #ef4444;
    }

    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .toast-notification.success .toast-icon {
        background-color: #d1fae5;
        color: #10b981;
    }

    .toast-notification.error .toast-icon {
        background-color: #fee;
        color: #ef4444;
    }

    .toast-content h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.3rem 0;
        color: var(--text-dark);
    }

    .toast-content p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
    }

    .toast-close {
        margin-left: auto;
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 1.3rem;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    .load-more-btn {
        background-color: var(--primary-green);
        color: white;
        padding: 1rem 3rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        margin: 3rem auto;
        display: block;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .load-more-btn:hover {
        background-color: var(--primary-green-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(45, 95, 78, 0.3);
    }

    @media (max-width: 992px) {
        .filters-sidebar {
            position: static;
            margin-bottom: 2rem;
        }

        .products-hero h1 {
            font-size: 3rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .product-image-wrapper {
            height: 220px;
        }

        .products-grid {
            grid-template-columns: 1fr;
        }

        .products-hero h1 {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Products Hero -->
<section class="products-hero">
    <div class="container">
        <h1>Our Premium Products</h1>
        <p>Quality livestock feeds for poultry, pigs, and cattle - formulated for maximum growth and production</p>
    </div>
</section>

<!-- Products Main Section -->
<section class="products-main">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filters-sidebar">
                    <h3><i class="bi bi-funnel"></i> Filters</h3>
                    
                    <!-- Animal Type Filter -->
                    <div class="filter-group">
                        <h4>Animal Type</h4>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="poultry" checked>
                                Poultry Feeds
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="pigs">
                                Pig Feeds
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="cattle">
                                Cattle Feeds
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="concentrates">
                                Concentrates
                            </label>
                        </div>
                    </div>

                    <!-- Growth Stage Filter -->
                    <div class="filter-group">
                        <h4>Growth Stage</h4>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="starter">
                                Starter
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="grower">
                                Grower
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="finisher">
                                Finisher
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="layers">
                                Layers/Lactator
                            </label>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="filter-group">
                        <h4>Price Range (KES)</h4>
                        <div class="price-range">
                            <input type="number" class="price-input" placeholder="Min" min="0" value="2000">
                            <span>-</span>
                            <input type="number" class="price-input" placeholder="Max" min="0" value="5000">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-group">
                        <h4>Rating</h4>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="5">
                                <span class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </span>
                            </label>
                        </div>
                        <div class="filter-option">
                            <label>
                                <input type="checkbox" value="4">
                                <span class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </span>
                                & up
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="products-header">
                    <p class="products-count">Showing <strong>16</strong> products</p>
                    <select class="sort-dropdown">
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Best Rating</option>
                    </select>
                </div>

                <div class="products-grid">
                    @php
                        $allProducts = [
                            [
                                'name' => 'Kienyeji Premium Mash',
                                'category' => 'POULTRY',
                                'price' => 3200,
                                'old_price' => 3500,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.9,
                                'reviews' => 156,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => true,
                            ],
                            [
                                'name' => 'Chick Starter Crumbs',
                                'category' => 'POULTRY',
                                'price' => 3300,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 203,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Broiler Finisher Pellets',
                                'category' => 'POULTRY',
                                'price' => 3400,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 189,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Layers Mash Premium',
                                'category' => 'POULTRY',
                                'price' => 3100,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.9,
                                'reviews' => 267,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Growers Mash',
                                'category' => 'POULTRY',
                                'price' => 3250,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.7,
                                'reviews' => 145,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Golden Yolk Layers',
                                'category' => 'POULTRY',
                                'price' => 3150,
                                'old_price' => 3400,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 198,
                                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => true,
                            ],
                            [
                                'name' => 'Sow & Weaner Premium',
                                'category' => 'PIGS',
                                'price' => 3800,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.9,
                                'reviews' => 98,
                                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Pig Starter Feed',
                                'category' => 'PIGS',
                                'price' => 3700,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 112,
                                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Pig Grower Pellets',
                                'category' => 'PIGS',
                                'price' => 3650,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.7,
                                'reviews' => 87,
                                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Pig Finisher Feed',
                                'category' => 'PIGS',
                                'price' => 3500,
                                'old_price' => 3750,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 134,
                                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => true,
                            ],
                            [
                                'name' => 'Lactator Pig Feed',
                                'category' => 'PIGS',
                                'price' => 3900,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.9,
                                'reviews' => 76,
                                'image' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Dairy Meal Concentrate',
                                'category' => 'CATTLE',
                                'price' => 3600,
                                'old_price' => 3900,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.7,
                                'reviews' => 142,
                                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => true,
                            ],
                            [
                                'name' => 'Beef Fattener Pellets',
                                'category' => 'CATTLE',
                                'price' => 3450,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.6,
                                'reviews' => 95,
                                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Calf Starter Meal',
                                'category' => 'CATTLE',
                                'price' => 3550,
                                'old_price' => null,
                                'unit' => 'per 70kg bag',
                                'rating' => 4.8,
                                'reviews' => 118,
                                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'Beef Mineral Mix',
                                'category' => 'CATTLE',
                                'price' => 2800,
                                'old_price' => null,
                                'unit' => 'per 50kg bag',
                                'rating' => 4.7,
                                'reviews' => 89,
                                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                            [
                                'name' => 'High Protein Concentrate',
                                'category' => 'CONCENTRATES',
                                'price' => 4200,
                                'old_price' => null,
                                'unit' => 'per 50kg bag',
                                'rating' => 4.9,
                                'reviews' => 156,
                                'image' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=1000',
                                'is_premium' => true,
                                'is_sale' => false,
                            ],
                        ];
                    @endphp

                    @foreach($allProducts as $product)
                    <div class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image" width="280" height="280">
                            
                            <div class="product-badges">
                                @if($product['is_premium'])
                                <span class="badge-premium">
                                    <i class="bi bi-star-fill"></i> Premium
                                </span>
                                @endif
                                @if($product['is_sale'])
                                <span class="badge-sale">Sale</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="product-content">
                            <div class="product-category">{{ $product['category'] }}</div>
                            <h3 class="product-name">{{ $product['name'] }}</h3>
                            
                            <div class="product-rating">
                                <div class="stars">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($product['rating']))
                                            <i class="bi bi-star-fill"></i>
                                        @elseif($i < $product['rating'])
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text">({{ $product['reviews'] }})</span>
                            </div>
                            
                            <div class="product-footer">
                                <div class="product-price">
                                    <div class="price-wrapper">
                                        <span class="price-current">KES {{ number_format($product['price']) }}</span>
                                        @if($product['old_price'])
                                        <span class="price-old">KES {{ number_format($product['old_price']) }}</span>
                                        @endif
                                    </div>
                                    <span class="price-unit">{{ $product['unit'] }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="product-actions">
                                    <button class="btn-add-cart" onclick="addToCart('{{ $product['name'] }}', {{ $product['price'] }}, '{{ $product['image'] }}', '{{ $product['unit'] }}', this)">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>Add to Cart</span>
                                    </button>
                                    <button class="btn-wishlist" onclick="toggleWishlist(this, '{{ $product['name'] }}')">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="load-more-btn">Load More Products</button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Quantity Controls
    function incrementQty(btn) {
        const input = btn.parentElement.querySelector('.qty-input');
        let value = parseInt(input.value);
        if (value < 99) {
            input.value = value + 1;
        }
    }

    function decrementQty(btn) {
        const input = btn.parentElement.querySelector('.qty-input');
        let value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
    }

    // Add to Cart Function
    function addToCart(productName, price, image, unit, button) {
        // Get quantity
        const qtyInput = button.closest('.product-footer').querySelector('.qty-input');
        const quantity = parseInt(qtyInput.value);

        // Get cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if product already exists
        const existingIndex = cart.findIndex(item => item.name === productName);

        if (existingIndex > -1) {
            // Update quantity
            cart[existingIndex].quantity += quantity;
        } else {
            // Add new product
            cart.push({
                name: productName,
                price: price,
                image: image,
                unit: unit,
                quantity: quantity,
                category: button.closest('.product-card').querySelector('.product-category').textContent
            });
        }

        // Save to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Update button state
        const icon = button.querySelector('i');
        const text = button.querySelector('span');
        icon.className = 'bi bi-check-circle';
        text.textContent = 'Added';
        button.classList.add('added');

        // Show toast notification
        showToast('Success!', `${quantity} x ${productName} added to cart`, 'success');

        // Reset button after 2 seconds
        setTimeout(() => {
            icon.className = 'bi bi-cart-plus';
            text.textContent = 'Add to Cart';
            button.classList.remove('added');
            qtyInput.value = 1;
        }, 2000);

        // Update cart count in navbar (if you have one)
        updateCartCount();
    }

    // Toggle Wishlist
    function toggleWishlist(button, productName) {
        const isActive = button.classList.contains('active');
        const icon = button.querySelector('i');

        // Get wishlist from localStorage
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

        if (isActive) {
            // Remove from wishlist
            wishlist = wishlist.filter(item => item !== productName);
            button.classList.remove('active');
            icon.className = 'bi bi-heart';
            showToast('Removed', `${productName} removed from wishlist`, 'error');
        } else {
            // Add to wishlist
            if (!wishlist.includes(productName)) {
                wishlist.push(productName);
            }
            button.classList.add('active');
            icon.className = 'bi bi-heart-fill';
            showToast('Added to Wishlist', `${productName} added to your wishlist`, 'success');
        }

        // Save to localStorage
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
    }

    // Show Toast Notification
    function showToast(title, message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'}"></i>
            </div>
            <div class="toast-content">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Update Cart Count (if you have a cart icon in navbar)
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        // Update cart badge if it exists
        const cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            cartBadge.textContent = totalItems;
        }
    }

    // Load wishlist state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        
        // Mark wishlist items
        document.querySelectorAll('.product-name').forEach(nameEl => {
            const productName = nameEl.textContent.trim();
            if (wishlist.includes(productName)) {
                const card = nameEl.closest('.product-card');
                const wishlistBtn = card.querySelector('.btn-wishlist');
                if (wishlistBtn) {
                    wishlistBtn.classList.add('active');
                    wishlistBtn.querySelector('i').className = 'bi bi-heart-fill';
                }
            }
        });

        // Update cart count on load
        updateCartCount();
    });

    // Filter and sorting functionality
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log('Filter changed:', this.value, this.checked);
            // Add your filter logic here
        });
    });

    document.querySelector('.sort-dropdown').addEventListener('change', function() {
        console.log('Sort changed:', this.value);
        // Add your sorting logic here
    });

    document.querySelector('.load-more-btn').addEventListener('click', function() {
        console.log('Load more clicked');
        // Add your load more logic here
    });
</script>
@endpush