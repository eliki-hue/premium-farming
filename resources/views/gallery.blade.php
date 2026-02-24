@extends('layouts.app')

@section('title', 'Our Gallery - Premium Farming Feeds')

@push('styles')
<style>
    /* Gallery Hero Section - Classic Style */
    .gallery-hero {
        background: linear-gradient(rgba(42, 110, 63, 0.85), rgba(30, 82, 46, 0.85)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070') center/cover;
        padding: 8rem 0 5rem;
        color: white;
        text-align: center;
        position: relative;
        margin-bottom: 2rem;
    }

    .gallery-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        letter-spacing: 1px;
    }

    .gallery-hero p {
        font-size: 1.2rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.8;
        font-weight: 300;
    }

    .breadcrumb-custom {
        background: rgba(255,255,255,0.15);
        display: inline-block;
        padding: 0.8rem 2rem;
        border-radius: 40px;
        margin-top: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }

    .breadcrumb-custom a {
        color: white;
        text-decoration: none;
        opacity: 0.9;
        transition: opacity 0.3s ease;
    }

    .breadcrumb-custom a:hover {
        opacity: 1;
    }

    .breadcrumb-custom span {
        color: #fbbf24;
        font-weight: 600;
    }

    /* Main Gallery Section - Classic Design */
    .main-gallery-section {
        padding: 4rem 0 6rem;
        background: #f9fafc;
        position: relative;
    }

    /* Gallery Header */
    .gallery-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .gallery-header h2 {
        font-size: 2.5rem;
        font-weight: 600;
        color: #1e522e;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .gallery-header h2:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #2a6e3f;
        border-radius: 2px;
    }

    .gallery-header p {
        color: #5a6a7a;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Gallery Stats - Minimal */
    .gallery-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin: 2rem 0 3rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        padding: 0 1rem;
    }

    .stat-item .number {
        font-size: 2rem;
        font-weight: 700;
        color: #2a6e3f;
        line-height: 1.2;
    }

    .stat-item .label {
        font-size: 0.9rem;
        color: #6b7a8a;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Gallery Filter - Classic Tabs */
    .gallery-filter-wrapper {
        margin-bottom: 3rem;
    }

    .gallery-filter {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        max-width: 900px;
        margin: 0 auto;
        padding: 0.5rem;
        background: white;
        border-radius: 50px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .filter-btn {
        padding: 0.8rem 2rem;
        border: none;
        background: transparent;
        color: #4a5568;
        font-weight: 500;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        color: #2a6e3f;
        background: rgba(42,110,63,0.05);
    }

    .filter-btn.active {
        background: #2a6e3f;
        color: white;
        box-shadow: 0 5px 15px rgba(42,110,63,0.2);
    }

    /* Gallery Grid - Classic Card Layout */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    /* Gallery Card - Classic Design */
    .gallery-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid #edf2f7;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: #cbd5e0;
    }

    /* Card Image Container - FIXED consistent size */
    .gallery-card-image {
        position: relative;
        width: 100%;
        height: 220px; /* Fixed height for all images */
        overflow: hidden;
        background: #f7fafc;
        cursor: pointer;
    }

    /* Image styling - FIXED to prevent cutting people */
    .gallery-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    /* Special handling for person photos - FIXED */
    .gallery-card[data-category="team"] .gallery-card-image img {
        object-fit: cover;
        object-position: center 30%; /* Focus on face area */
    }

    /* Individual team member adjustments */
    .gallery-card[data-category="team"]:nth-of-type(1) .gallery-card-image img {
        object-position: center 25%; /* Paul - focus on face */
    }

    .gallery-card[data-category="team"]:nth-of-type(2) .gallery-card-image img {
        object-position: center 35%; /* Joyce - focus on face */
    }

    .gallery-card[data-category="team"]:nth-of-type(3) .gallery-card-image img {
        object-position: center 30%; /* Naomi - focus on face */
    }

    .gallery-card:hover .gallery-card-image img {
        transform: scale(1.05);
    }

    /* Card Badge - Classic */
    .gallery-card-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(42, 110, 63, 0.9);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.2);
        z-index: 2;
    }

    /* Card Content - Classic */
    .gallery-card-content {
        padding: 1.5rem;
    }

    .gallery-card-content h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .gallery-card-content p {
        font-size: 0.9rem;
        color: #5a6a7a;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    /* Card Meta - Classic */
    .gallery-card-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid #edf2f7;
    }

    .gallery-card-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        color: #718096;
    }

    .gallery-card-meta i {
        color: #2a6e3f;
        font-size: 0.85rem;
    }

    /* View Button - Classic */
    .gallery-card-btn {
        background: transparent;
        border: 1px solid #2a6e3f;
        color: #2a6e3f;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: fit-content;
        margin-top: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .gallery-card-btn:hover {
        background: #2a6e3f;
        color: white;
    }

    .gallery-card-btn i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .gallery-card-btn:hover i {
        transform: translateX(3px);
    }

    /* Quick View Overlay - Subtle */
    .quick-view-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card-image:hover .quick-view-overlay {
        opacity: 1;
    }

    .quick-view-btn {
        background: white;
        color: #2a6e3f;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.85rem;
        cursor: pointer;
        transform: translateY(10px);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .gallery-card-image:hover .quick-view-btn {
        transform: translateY(0);
    }

    .quick-view-btn:hover {
        background: #2a6e3f;
        color: white;
    }

    /* Load More Button - Classic */
    .load-more-container {
        text-align: center;
        margin-top: 4rem;
    }

    .load-more-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        background: white;
        color: #2a6e3f;
        padding: 1rem 2.5rem;
        border: 2px solid #2a6e3f;
        border-radius: 40px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(42,110,63,0.1);
    }

    .load-more-btn:hover {
        background: #2a6e3f;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(42,110,63,0.2);
    }

    /* Category Spotlight - Classic */
    .category-spotlight {
        margin: 3rem 0;
        padding: 3rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #edf2f7;
    }

    .spotlight-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .spotlight-text h3 {
        font-size: 1.8rem;
        font-weight: 600;
        color: #1e522e;
        margin-bottom: 0.5rem;
    }

    .spotlight-text p {
        font-size: 1rem;
        color: #5a6a7a;
        max-width: 500px;
    }

    .spotlight-btn {
        background: #2a6e3f;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 2px solid transparent;
    }

    .spotlight-btn:hover {
        background: #1e522e;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(42,110,63,0.2);
    }

    .spotlight-btn.outline {
        background: transparent;
        border: 2px solid #2a6e3f;
        color: #2a6e3f;
    }

    .spotlight-btn.outline:hover {
        background: #2a6e3f;
        color: white;
    }

    /* Lightbox Modal - Classic */
    .lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.95);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .lightbox-modal.active {
        display: flex;
        opacity: 1;
    }

    .lightbox-content {
        position: relative;
        width: 90%;
        max-width: 1000px;
        margin: auto;
        text-align: center;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 8px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .lightbox-caption {
        color: white;
        margin-top: 1rem;
        font-size: 1rem;
    }

    .lightbox-caption strong {
        color: #fbbf24;
        font-weight: 600;
    }

    .lightbox-close {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        color: white;
        font-size: 2.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.3);
        border-radius: 50%;
        z-index: 10000;
    }

    .lightbox-close:hover {
        transform: rotate(90deg);
        background: rgba(42,110,63,0.5);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 2rem;
        cursor: pointer;
        padding: 1rem;
        transition: all 0.3s ease;
        background: rgba(0,0,0,0.3);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-nav:hover {
        background: #2a6e3f;
    }

    .lightbox-prev {
        left: 1rem;
    }

    .lightbox-next {
        right: 1rem;
    }

    .lightbox-counter {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        color: white;
        background: rgba(0,0,0,0.5);
        padding: 0.3rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
    }

    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: #2a6e3f;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 100;
        border: 2px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .back-to-top.show {
        opacity: 1;
        visibility: visible;
    }

    .back-to-top:hover {
        background: #1e522e;
        transform: translateY(-3px);
    }

    /* No Results Message */
    .no-results {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 12px;
        grid-column: 1 / -1;
        color: #5a6a7a;
        font-size: 1rem;
        border: 1px solid #edf2f7;
    }

    .no-results i {
        font-size: 2.5rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .gallery-hero h1 {
            font-size: 2.8rem;
        }

        .gallery-header h2 {
            font-size: 2.2rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .gallery-card-image {
            height: 200px;
        }
    }

    @media (max-width: 768px) {
        .gallery-hero {
            padding: 6rem 0 4rem;
        }

        .gallery-hero h1 {
            font-size: 2.2rem;
        }

        .gallery-hero p {
            font-size: 1rem;
        }

        .gallery-filter {
            border-radius: 30px;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }

        .stat-item .number {
            font-size: 1.5rem;
        }

        .stat-item .label {
            font-size: 0.8rem;
        }

        .spotlight-content {
            flex-direction: column;
            text-align: center;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .gallery-filter {
            flex-direction: column;
            border-radius: 20px;
        }

        .filter-btn {
            width: 100%;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-card-image {
            height: 220px;
        }
    }
</style>
@endpush

@section('content')
<!-- Gallery Hero Section -->
<section class="gallery-hero">
    <div class="container">
        <h1>Our Gallery</h1>
        <p>Explore the visual journey of Premium Farming Feeds - from our facilities to our team, products, and delivery services</p>
        <div class="breadcrumb-custom">
            <a href="{{ url('/') }}">Home</a> <i class="bi bi-chevron-right mx-2"></i> 
            <a href="{{ route('about') }}">About</a> <i class="bi bi-chevron-right mx-2"></i> 
            <span>Gallery</span>
        </div>
    </div>
</section>

<!-- Main Gallery Section -->
<section class="main-gallery-section">
    <div class="container">
        <!-- Gallery Stats -->
        <div class="gallery-stats">
            <div class="stat-item">
                <div class="number">50+</div>
                <div class="label">Photos</div>
            </div>
            <div class="stat-item">
                <div class="number">5</div>
                <div class="label">Categories</div>
            </div>
            <div class="stat-item">
                <div class="number">2020</div>
                <div class="label">Founded</div>
            </div>
        </div>

        <!-- Gallery Header -->
        <div class="gallery-header">
            <h2>Moments & Milestones</h2>
            <p>Capturing the essence of Premium Farming Feeds through elegant visuals</p>
        </div>

        <!-- Gallery Filter -->
        <div class="gallery-filter-wrapper">
            <div class="gallery-filter">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="facility">Facility</button>
                <button class="filter-btn" data-filter="products">Products</button>
                <button class="filter-btn" data-filter="delivery">Delivery</button>
                <button class="filter-btn" data-filter="team">Team</button>
                <button class="filter-btn" data-filter="events">Events</button>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid-container">
            <div class="gallery-grid" id="galleryGrid">
                <!-- Facility Images -->
                <div class="gallery-card" data-category="facility">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/comp.jpeg') }}" alt="Main Facility" onerror="this.src='https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=2000'">
                        <span class="gallery-card-badge">Facility</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(0)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Main Processing Facility</h4>
                        <p>State-of-the-art feed processing plant in Turitu</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-calendar3"></i> 2024</span>
                            <span><i class="bi bi-geo-alt"></i> Turitu</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(0)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="facility">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/space.jpeg') }}" alt="Warehouse" onerror="this.src='https://images.unsplash.com/photo-1592595896616-c37162298647?q=80&w=2070'">
                        <span class="gallery-card-badge">Facility</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(1)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Climate-Controlled Warehouse</h4>
                        <p>Modern storage ensuring feed freshness</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-calendar3"></i> 2024</span>
                            <span><i class="bi bi-thermometer-half"></i> Climate Controlled</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(1)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="facility">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/comp.jpeg') }}" alt="Production Line" onerror="this.src='https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=2000'">
                        <span class="gallery-card-badge">Facility</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(2)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Automated Production Line</h4>
                        <p>Advanced machinery for consistent quality</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-calendar3"></i> 2024</span>
                            <span><i class="bi bi-gear"></i> Automated</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(2)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Products Images -->
                <div class="gallery-card" data-category="products">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/superlayers.jpeg') }}" alt="Poultry Feed">
                        <span class="gallery-card-badge">Products</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(3)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Premium Poultry Feed</h4>
                        <p>For optimal growth and egg production</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-egg"></i> Layers</span>
                            <span><i class="bi bi-basket"></i> 50kg</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(3)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="products">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/dairyhigh2.jpeg') }}" alt="Dairy Feed">
                        <span class="gallery-card-badge">Products</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(4)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>High-Protein Dairy Meal</h4>
                        <p>For maximum milk production</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-cup"></i> High Protein</span>
                            <span><i class="bi bi-basket"></i> 70kg</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(4)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="products">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/comp1.jpeg') }}" alt="Pig Feed">
                        <span class="gallery-card-badge">Products</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(5)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Pig Feeds</h4>
                        <p>Balanced nutrition for healthy growth</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-flower1"></i> Grower</span>
                            <span><i class="bi bi-flower2"></i> Finisher</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(5)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Delivery Images -->
                <div class="gallery-card" data-category="delivery">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/trns.jpeg') }}" alt="Delivery Fleet" onerror="this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2000'">
                        <span class="gallery-card-badge">Delivery</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(6)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Modern Delivery Fleet</h4>
                        <p>Specialized trucks serving farmers</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-truck"></i> 5 Trucks</span>
                            <span><i class="bi bi-map"></i> Daily Routes</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(6)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="delivery">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/delivery.jpeg') }}" alt="Loading Operations" onerror="this.src='https://images.unsplash.com/photo-1589923186741-7d1d6ccee3c3?q=80&w=2070'">
                        <span class="gallery-card-badge">Delivery</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(7)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Efficient Loading</h4>
                        <p>Quick and careful loading process</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-clock"></i> 24/7 Ops</span>
                            <span><i class="bi bi-box"></i> 1000+ bags/day</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(7)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="delivery">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/trsnp2.jpeg') }}" alt="Farm Delivery" onerror="this.src='https://images.unsplash.com/photo-1560472354-b33ff0c44a43?q=80&w=2000'">
                        <span class="gallery-card-badge">Delivery</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(8)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Farm Gate Delivery</h4>
                        <p>Direct delivery to farmers' premises</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-house"></i> Doorstep</span>
                            <span><i class="bi bi-map"></i> All Routes</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(8)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Team Images - FIXED person photos -->
                <div class="gallery-card" data-category="team">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/boss.jpeg') }}" alt="Paul Mbua" onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=2000'">
                        <span class="gallery-card-badge">Leadership</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(9)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Paul Mbua - Founder & CEO</h4>
                        <p>20+ years in livestock nutrition</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-award"></i> Founder</span>
                            <span><i class="bi bi-star"></i> Visionary</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(9)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="team">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/md boss.jpeg') }}" alt="Joyce Mbua" onerror="this.src='https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=2000'">
                        <span class="gallery-card-badge">Leadership</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(10)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Joyce Mbua - Operations Director</h4>
                        <p>Ensuring operational excellence</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-gear"></i> Operations</span>
                            <span><i class="bi bi-diagram-3"></i> Strategy</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(10)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="team">
                    <div class="gallery-card-image">
                        <img src="{{ asset('images/manager.jpeg') }}" alt="Naomi" onerror="this.src='https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=2000'">
                        <span class="gallery-card-badge">Management</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(11)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Naomi - Branch Manager</h4>
                        <p>Customer service & branch operations</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-people"></i> Customer Service</span>
                            <span><i class="bi bi-shop"></i> Branch Ops</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(11)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Events Images -->
                <div class="gallery-card" data-category="events">
                    <div class="gallery-card-image">
                        <img src="https://images.unsplash.com/photo-1593113598335-cb59a9c7e2e4?q=80&w=2000" alt="Farmers Training">
                        <span class="gallery-card-badge">Events</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(12)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Farmers Training Session</h4>
                        <p>Educating on best feeding practices</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-calendar"></i> March 2024</span>
                            <span><i class="bi bi-people"></i> 50+ Farmers</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(12)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="events">
                    <div class="gallery-card-image">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2000" alt="Agricultural Show">
                        <span class="gallery-card-badge">Events</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(13)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Agricultural Show 2024</h4>
                        <p>Showcasing our products</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-trophy"></i> Best Exhibitor</span>
                            <span><i class="bi bi-calendar"></i> June 2024</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(13)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="gallery-card" data-category="events">
                    <div class="gallery-card-image">
                        <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?q=80&w=2000" alt="Team Building">
                        <span class="gallery-card-badge">Events</span>
                        <div class="quick-view-overlay">
                            <button class="quick-view-btn" onclick="openLightboxFromCard(14)">
                                <i class="bi bi-eye"></i> Quick View
                            </button>
                        </div>
                    </div>
                    <div class="gallery-card-content">
                        <h4>Team Building Day</h4>
                        <p>Bonding and planning</p>
                        <div class="gallery-card-meta">
                            <span><i class="bi bi-emoji-smile"></i> Team Spirit</span>
                            <span><i class="bi bi-calendar"></i> 2024</span>
                        </div>
                        <button class="gallery-card-btn" onclick="openLightboxFromCard(14)">
                            View <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- No Results Message -->
            <div class="no-results" id="noResults" style="display: none;">
                <i class="bi bi-images"></i>
                <p>No images found in this category</p>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="load-more-container">
            <button class="load-more-btn" id="loadMoreBtn">
                <span>Load More</span>
                <i class="bi bi-arrow-down"></i>
            </button>
        </div>
    </div>
</section>

<!-- Category Spotlight -->
<section class="category-spotlight">
    <div class="container">
        <div class="spotlight-content">
            <div class="spotlight-text">
                <h3>Want to see more?</h3>
                <p>Visit our facilities or check out our complete product catalog</p>
            </div>
            <div>
                <a href="{{ route('products') }}" class="spotlight-btn">
                    <i class="bi bi-box"></i> View Products
                </a>
                <a href="{{ route('contact') }}" class="spotlight-btn outline ms-2">
                    <i class="bi bi-calendar"></i> Schedule Visit
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <span class="lightbox-nav lightbox-prev" onclick="changeImage(-1)">&#10094;</span>
    <span class="lightbox-nav lightbox-next" onclick="changeImage(1)">&#10095;</span>
    <div class="lightbox-content">
        <img class="lightbox-image" id="lightbox-img" src="" alt="">
        <div class="lightbox-caption" id="lightbox-caption"></div>
        <div class="lightbox-counter" id="lightbox-counter"></div>
    </div>
</div>

<!-- Back to Top Button -->
<div class="back-to-top" id="backToTop">
    <i class="bi bi-arrow-up"></i>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all gallery cards
        const galleryCards = document.querySelectorAll('.gallery-card');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const noResults = document.getElementById('noResults');
        
        let visibleItems = 9; // Number of initially visible items
        let currentFilter = 'all';

        // Hide cards beyond visible count initially
        galleryCards.forEach((card, index) => {
            if (index >= visibleItems) {
                card.style.display = 'none';
            }
        });

        // Filter function
        function filterGallery(filterValue) {
            currentFilter = filterValue;
            let visibleCount = 0;
            let hasVisibleItems = false;
            
            galleryCards.forEach((card, index) => {
                const category = card.getAttribute('data-category');
                
                if (filterValue === 'all' || category === filterValue) {
                    if (visibleCount < visibleItems) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                        visibleCount++;
                        hasVisibleItems = true;
                    } else {
                        card.style.display = 'none';
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (hasVisibleItems) {
                noResults.style.display = 'none';
            } else {
                noResults.style.display = 'block';
            }

            // Update load more button visibility
            const totalInCategory = filterValue === 'all' ? 
                galleryCards.length : 
                document.querySelectorAll(`.gallery-card[data-category="${filterValue}"]`).length;
            
            loadMoreBtn.style.display = visibleCount < totalInCategory ? 'inline-flex' : 'none';
        }

        // Filter button click handlers
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filterValue = button.getAttribute('data-filter');
                filterGallery(filterValue);
            });
        });

        // Load More functionality
        loadMoreBtn.addEventListener('click', function() {
            visibleItems += 6; // Load 6 more items
            filterGallery(currentFilter);
        });

        // Lightbox variables
        let currentImageIndex = 0;
        const images = [];
        const captions = [];

        // Collect all gallery card images
        galleryCards.forEach((card, index) => {
            const img = card.querySelector('.gallery-card-image img');
            const title = card.querySelector('h4').textContent;
            const description = card.querySelector('p').textContent;
            const badge = card.querySelector('.gallery-card-badge').textContent;
            
            images.push(img.src);
            captions.push({
                title: title,
                description: description,
                category: badge
            });
        });

        // Lightbox functions
        window.openLightboxFromCard = function(index) {
            currentImageIndex = index;
            openLightbox(images[index], captions[index], index + 1, images.length);
        }

        window.openLightbox = function(src, caption, current, total) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.querySelector('.lightbox-caption');
            const lightboxCounter = document.getElementById('lightbox-counter');

            lightboxImg.src = src;
            lightboxCaption.innerHTML = `<strong>${caption.title}</strong> - ${caption.description} <span style="color: #fbbf24;">(${caption.category})</span>`;
            lightboxCounter.textContent = `${current} of ${total}`;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        window.closeLightbox = function() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.changeImage = function(direction) {
            currentImageIndex += direction;
            
            if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            } else if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            }

            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.querySelector('.lightbox-caption');
            const lightboxCounter = document.getElementById('lightbox-counter');
            
            lightboxImg.src = images[currentImageIndex];
            lightboxCaption.innerHTML = `<strong>${captions[currentImageIndex].title}</strong> - ${captions[currentImageIndex].description} <span style="color: #fbbf24;">(${captions[currentImageIndex].category})</span>`;
            lightboxCounter.textContent = `${currentImageIndex + 1} of ${images.length}`;
        }

        // Add click event to card images for lightbox
        document.querySelectorAll('.gallery-card-image').forEach((imageContainer, index) => {
            imageContainer.addEventListener('click', (e) => {
                // Don't trigger if clicking on the quick view button
                if (!e.target.classList.contains('quick-view-btn')) {
                    currentImageIndex = index;
                    openLightbox(images[index], captions[index], index + 1, images.length);
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    changeImage(-1);
                } else if (e.key === 'ArrowRight') {
                    changeImage(1);
                }
            }
        });

        // Close lightbox when clicking outside
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush