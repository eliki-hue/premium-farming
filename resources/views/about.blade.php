@extends('layouts.app')

@section('title', 'About Premium Farming Feeds')

@push('styles')
<style>
    /* Hero Section - Updated with new background */
    .about-hero {
        background: url('/images/abt1.jpeg') center/cover;
        background-attachment: fixed;
        padding: 18rem 0 5rem;
        background-color: rgb(250, 242, 242);
        color: rgb(9, 9, 9);
        text-align: center;
        position: relative;
        font: 1000
    }
    
    /* Subtle overlay for text readability */
    .about-hero::before {
        content: '';
        position: absolute;
        top:5;
        left: 10;
        right:10;
        bottom: 10;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }
    
    .about-hero .container {
        position: relative;
        z-index: 2;
    }

    .about-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        animation: fadeInDown 1s ease;
    }

    .about-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
        font-weight: 300;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        animation: fadeInUp 1s ease 0.3s both;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Vision & Mission Section */
    .vision-mission-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .vm-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        height: 100%;
        border-top: 5px solid #2a6e3f;
    }

    .vm-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }

    .vm-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2a6e3f, #1e522e);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 2.5rem;
    }

    .vm-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1e522e;
        text-align: center;
    }

    .vm-card p {
        color: #4a5568;
        line-height: 1.8;
        font-size: 1.1rem;
    }

    /* Gallery CTA Section */
    .gallery-cta-section {
        padding: 5rem 0;
        background: linear-gradient(135deg, #2a6e3f 0%, #1e522e 100%);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .gallery-cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 20s ease-in-out infinite;
    }

    .gallery-cta-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(251,191,36,0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: float 25s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(2%, 2%) rotate(120deg); }
        66% { transform: translate(-2%, -2%) rotate(240deg); }
    }

    .gallery-cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .gallery-cta-content h2 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .gallery-cta-content p {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto 2rem;
        opacity: 0.95;
    }

    .gallery-preview {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }

    .preview-image {
        width: 100px;
        height: 100px;
        border-radius: 15px;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .preview-image:hover {
        transform: scale(1.1) rotate(3deg);
        border-color: #fbbf24;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }

    .gallery-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        background: white;
        color: #2a6e3f;
        padding: 1.2rem 3rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        border: 2px solid transparent;
    }

    .gallery-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        background: #fbbf24;
        color: #1e522e;
        border-color: white;
    }

    .gallery-cta-btn i {
        transition: transform 0.3s ease;
        font-size: 1.3rem;
    }

    .gallery-cta-btn:hover i {
        transform: translateX(5px);
    }

    /* Lightbox Modal */
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
        max-width: 1200px;
        margin: auto;
        text-align: center;
    }

    .lightbox-image {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 10px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .lightbox-caption {
        color: white;
        margin-top: 1rem;
        font-size: 1.2rem;
    }

    .lightbox-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        color: white;
        font-size: 3rem;
        cursor: pointer;
        transition: transform 0.3s ease;
        z-index: 10000;
    }

    .lightbox-close:hover {
        transform: rotate(90deg);
        color: #fbbf24;
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 3rem;
        cursor: pointer;
        padding: 1rem;
        transition: all 0.3s ease;
        background: rgba(42,110,63,0.3);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-nav:hover {
        background: #2a6e3f;
        transform: translateY(-50%) scale(1.1);
    }

    .lightbox-prev {
        left: 2rem;
    }

    .lightbox-next {
        right: 2rem;
    }

    /* Transport & Delivery Section */
    .transport-section {
        padding: 6rem 0;
        background: white;
    }

    .transport-header {
        text-align: center;
        margin-bottom: 4rem;
    }

    .transport-header h2 {
        font-size: 2.8rem;
        font-weight: 800;
        color: #1e522e;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .transport-header h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #2a6e3f, #fbbf24, #2a6e3f);
        border-radius: 2px;
    }

    .transport-header p {
        color: #718096;
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
    }

    .transport-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        background: white;
        height: 100%;
    }

    .transport-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .transport-image {
        height: 250px;
        overflow: hidden;
    }

    .transport-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .transport-card:hover .transport-image img {
        transform: scale(1.05);
    }

    .transport-content {
        padding: 2rem;
    }

    .transport-content h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2a6e3f;
        margin-bottom: 1rem;
    }

    .transport-content p {
        color: #4a5568;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .transport-features {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .transport-badge {
        background: rgba(42, 110, 63, 0.1);
        color: #2a6e3f;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Story Section */
    .story-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .story-content {
        display: flex;
        align-items: center;
        gap: 4rem;
        margin-bottom: 4rem;
    }

    .story-content:nth-child(even) {
        flex-direction: row-reverse;
    }

    .story-image {
        flex: 1;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .story-image img {
        width: 100%;
        height: 500px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .story-image:hover img {
        transform: scale(1.05);
    }

    .story-text {
        flex: 1;
    }

    .story-text h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        color: #1e522e;
        position: relative;
        display: inline-block;
    }

    .story-text h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: #fbbf24;
        border-radius: 2px;
    }

    .story-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4a5568;
        margin-bottom: 1rem;
    }

    /* Values Section */
    .values-section {
        padding: 6rem 0;
        background: white;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .value-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: #2a6e3f;
    }

    .value-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2a6e3f, #38a169);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
    }

    .value-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #1e522e;
    }

    .value-card p {
        color: #718096;
        line-height: 1.7;
        font-size: 1rem;
    }

    /* Team Section - UPDATED with proper image display */
    .team-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
    }

    .team-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><path d="M20 50 Q 40 30, 60 50 T 100 50" stroke="%232a6e3f" fill="none" stroke-width="2"/></svg>');
        background-size: 50px 50px;
        pointer-events: none;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
        position: relative;
        z-index: 1;
    }

    .team-member {
        text-align: center;
        transition: all 0.3s ease;
        background: white;
        padding: 2rem 2rem 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 2px solid transparent;
    }

    .team-member:hover {
        transform: translateY(-10px);
        border-color: #2a6e3f;
        box-shadow: 0 20px 40px rgba(42,110,63,0.15);
    }

    .team-photo-container {
        width: 220px;
        height: 220px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s ease;
    }

    /* Individual photo adjustments - UPDATED for new images */
    .team-member:nth-child(1) .team-photo {
        object-fit: cover;
        object-position: center 30%;
    }

    .team-member:nth-child(2) .team-photo {
        object-fit: cover;
        object-position: center 40%;
    }

    .team-member:nth-child(3) .team-photo {
        object-fit: contain; /* This ensures the FULL image is visible without cropping */
        object-position: center;
        background-color: #f0f0f0; /* Light background for contain mode */
        padding: 10px; /* Add some padding around the image */
    }

    .team-member:hover .team-photo {
        transform: scale(1.05);
    }

    .team-member:hover .team-photo-container {
        border-color: #2a6e3f;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .team-member h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #1e522e;
        font-weight: 700;
    }

    .team-role {
        color: #2a6e3f;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
        display: inline-block;
        padding: 0.4rem 1.2rem;
        background: rgba(42,110,63,0.1);
        border-radius: 50px;
    }

    .team-bio {
        color: #4a5568;
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 280px;
        margin: 0 auto;
        padding: 0 0.5rem;
    }

    /* Branches Section */
    .branches-section {
        padding: 6rem 0;
        background: white;
    }

    .branch-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
        text-align: center;
        height: 100%;
    }

    .branch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        border-color: #2a6e3f;
    }

    .branch-icon {
        font-size: 3rem;
        color: #2a6e3f;
        margin-bottom: 1.5rem;
    }

    .branch-card h3 {
        font-size: 1.5rem;
        color: #1e522e;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .branch-card p {
        color: #718096;
        line-height: 1.7;
        margin-bottom: 0.5rem;
    }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #2a6e3f 0%, #1e522e 100%);
        padding: 6rem 0;
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 3rem;
        text-align: center;
    }

    .stat-item {
        padding: 2rem;
        background: rgba(255,255,255,0.1);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255,255,255,0.2);
        transition: transform 0.3s ease;
    }

    .stat-item:hover {
        transform: scale(1.05);
        background: rgba(255,255,255,0.15);
    }

    .stat-item h2 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #fbbf24;
    }

    .stat-item p {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .stat-item small {
        display: block;
        margin-top: 0.5rem;
        opacity: 0.8;
        font-size: 0.9rem;
    }

    /* Gallery Button */
    .gallery-btn-container {
        text-align: center;
        margin-top: 4rem;
        position: relative;
        z-index: 1;
    }

    .gallery-btn {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #2a6e3f, #1e522e);
        color: white;
        padding: 1.2rem 3rem;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(42,110,63,0.3);
        border: 2px solid transparent;
    }

    .gallery-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(42,110,63,0.4);
        background: white;
        color: #2a6e3f;
        border-color: #2a6e3f;
    }

    .gallery-btn i {
        transition: transform 0.3s ease;
    }

    .gallery-btn:hover i {
        transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .about-hero h1 {
            font-size: 2.8rem;
        }

        .about-hero p {
            font-size: 1.1rem;
        }

        .story-content {
            flex-direction: column !important;
            gap: 2rem;
        }

        .story-image img {
            height: 300px;
        }

        .story-text h2 {
            font-size: 2rem;
        }

        .transport-header h2 {
            font-size: 2.2rem;
        }

        .gallery-cta-content h2 {
            font-size: 2.2rem;
        }

        .stat-item h2 {
            font-size: 2.8rem;
        }
        
        .team-photo-container {
            width: 200px;
            height: 200px;
        }

        .lightbox-prev {
            left: 1rem;
        }

        .lightbox-next {
            right: 1rem;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 6rem 0 4rem;
        }

        .vm-card {
            padding: 2rem;
        }

        .transport-image {
            height: 200px;
        }
        
        .team-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .team-photo-container {
            width: 200px;
            height: 200px;
        }

        .team-member {
            padding: 1.5rem 1rem 2rem;
        }

        .team-bio {
            max-width: 250px;
        }

        .gallery-preview {
            gap: 0.5rem;
        }

        .preview-image {
            width: 70px;
            height: 70px;
        }

        .gallery-cta-btn {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .lightbox-nav {
            font-size: 2rem;
            width: 40px;
            height: 40px;
        }
    }

    @media (max-width: 480px) {
        .preview-image {
            width: 50px;
            height: 50px;
        }
        
        .team-photo-container {
            width: 180px;
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section - Updated with new background -->
<section class="about-hero">
    <div class="container">
        {{-- <h1>Premium Farming Feeds</h1> --}}
        {{-- <p style= "font- ">
            Since 2020, we've been providing quality animal feeds to farmers across Kenya. 
            Our commitment to excellence and customer satisfaction has made us the trusted choice 
            for livestock nutrition.
        </p> --}}
    </div>
</section>


<!-- Vision & Mission Section -->
<section class="vision-mission-section">
    <div class="container">
        <div class="row g-4">
<div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        Ensuring access to affordable and consistent high quality agricultural solutions
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                      To be the Leading Company in the agricultural sector by providing sustainable, high quality and cost-effective solutions.
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Transport & Delivery Section - Commented out as in original -->
{{-- <section class="transport-section">
    <div class="container">
        <div class="transport-header">
            <h2>Our Delivery Services</h2>
            <p>We ensure your feeds reach your farm safely and on time</p>
            <div class="alert alert-warning mt-3 d-inline-flex align-items-center">
                <i class="bi bi-truck me-2"></i>
                <div>
                    <strong>Delivery Schedule:</strong> Monday to Saturday, 8:00 AM - 6:00 PM
                    <br>
                    <small>Orders placed after 3:00 PM are delivered the next business day</small>
                </div>
            </div>
        </div> --}}

        <div class="row g-4">
            {{-- <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/trsnp2.jpeg') }}" alt="Our Delivery Truck" 
                             onerror="this.src='https://images.unsplash.com/photo-1560472354-b33ff0c44a43?q=80&w=2000'">
                    </div>
                    <div class="transport-content">
                        <h4>Farm Delivery</h4>
                        <p>We deliver directly to your farm with our specialized feed delivery trucks.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Mon-Sat</span>
                            <span class="transport-badge">8 AM - 6 PM</span>
                            <span class="transport-badge">Tracked</span>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/trns1.jpeg') }}" alt="Our Warehouse" 
                             onerror="this.src='https://images.unsplash.com/photo-1589923186741-7d1d6ccee3c3?q=80&w=2070'">
                    </div>
                    <div class="transport-content">
                        <h4>Pickup Stations</h4>
                        <p>Collect your feeds from our conveniently located branches.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Self-Service</span>
                            <span class="transport-badge">Loading Help</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/delivery.jpeg') }}" alt="Bulk Orders" 
                             onerror="this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2000'">
                    </div>
                    <div class="transport-content">
                        <h4>Bulk Orders</h4>
                        <p>Special arrangements for large-scale farmers and cooperatives.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Bulk Discounts</span>
                            <span class="transport-badge">Flexible Terms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Story Section -->
<section class="story-section">
    <div class="container">
        <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/counter3.jpeg') }}" alt="Our Beginning" 
                     onerror="this.src='https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=2000'">
            </div>
            <div class="story-text">
                <h2>Our Beginning</h2>
                <p>
                    In 2020, Premium Farming Feeds started as a small feed mill in Turitu, Kiambu County. 
                    What began as a modest operation serving local farmers has grown into one of Kenya's 
                    most trusted animal feed suppliers.
                </p>
                <p>
                    Our founder, Paul Mbua, started with a simple vision: to provide farmers with 
                    affordable, high-quality feeds that would transform livestock farming in Kenya.
                </p>
            </div>
        </div>

        <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/abt2.jpeg') }}" alt="Growth & Expansion" 
                     onerror="this.src='https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=2000'">
            </div>
            <div class="story-text">
                <h2>Growth & Expansion</h2>
                <p>
                    Through consistent quality and excellent customer service, we expanded to three 
                    branches across Kiambu County, and later added a fully stocked agrovet — so farmers 
                    can access quality feeds, animal health products, and expert advice all under one roof. 
                    Today, we serve thousands of farmers from small-scale homesteads to large commercial farms.
                </p>
                <p>
                    Our commitment to quality has remained unchanged — every bag of feed is produced 
                    with the same care and attention to detail as our very first batch.
                </p>
            </div>
        </div>

        {{-- <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/kiy.jpeg') }}" alt="Our Operations" 
                     onerror="this.src='https://images.unsplash.com/photo-1592595896616-c37162298647?q=80&w=2070'">
            </div>
            <div class="story-text">
                <h2>Modern Operations</h2>
                <p>
                    Today, Premium Farming Feeds operates with state-of-the-art equipment and 
                    follows strict quality control measures. Our feed formulation is backed by 
                    nutritional science and local farming expertise.
                </p>
                <p>
                    Our team conducts regular farm visits to understand our customers' needs 
                    and provide personalized feeding solutions.
                </p>
            </div>
        </div> --}}
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-dark mb-3">Our Core Values</h2>
            <p class="lead text-muted">The principles that guide everything we do</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-award-fill"></i>
                </div>
                <h3>Quality Excellence</h3>
                <p>We never compromise on quality. Every product undergoes rigorous testing.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3>Farmer Success</h3>
                <p>Your success is our success. We provide technical support and advice.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Integrity</h3>
                <p>We conduct business with honesty and transparency.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h3>Reliability</h3>
                <p>Consistent product quality and reliable delivery services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Branches Section -->
<section class="branches-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-dark mb-3">Our Branches</h2>
            <p class="lead text-muted">Visit us at any of our convenient locations</p>
            <div class="alert alert-info d-inline-flex align-items-center mt-3">
                <i class="bi bi-info-circle me-2"></i>
                <div>
                    <strong>Operating Hours:</strong> Monday to Saturday, 8:00 AM - 6:00 PM
                    <br>
                    <small class="text-muted">Closed on Sundays </small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h3>Turitu Branch</h3>
                    <p class="text-muted">Main Branch & Headquarters</p>
                    <div class="branch-details">
                        <p><i class="bi bi-geo-alt me-2"></i> Along Kiambu-Kanunga Road</p>
                        <p><i class="bi bi-clock me-2"></i> Mon-Sat: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3>Githiga Branch</h3>
                    <p class="text-muted">Processing Plant</p>
                    <div class="branch-details">
                        <p><i class="bi bi-geo-alt me-2"></i> Githiga Shopping Center</p>
                        <p><i class="bi bi-clock me-2"></i> Mon-Sat: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="branch-card">
                    <div class="branch-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3>Ikinu Branch</h3>
                    <p class="text-muted">Latest Expansion</p>
                    <div class="branch-details">
                        <p><i class="bi bi-geo-alt me-2"></i> Ikinu Town Center</p>
                        <p><i class="bi bi-clock me-2"></i> Mon-Sat: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery CTA Section -->
<section class="gallery-cta-section">
    <div class="container">
        <div class="gallery-cta-content">
            <h2>Explore Our Visual Journey</h2>
            <p>Take a tour through our facilities, meet our team, and see our products in action through our dedicated gallery page.</p>
            
            <!-- Preview Images -->
            <div class="gallery-preview">
                <img src="{{ asset('images/comp.jpeg') }}" alt="Facility Preview" class="preview-image" onclick="window.location.href='{{ route('gallery') }}#facility'">
                <img src="{{ asset('images/boss1.jpeg') }}" alt="Team Preview" class="preview-image" onclick="window.location.href='{{ route('gallery') }}#team'">
                <img src="{{ asset('images/trns.jpeg') }}" alt="Delivery Preview" class="preview-image" onclick="window.location.href='{{ route('gallery') }}#delivery'">
                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2000" alt="Products Preview" class="preview-image" onclick="window.location.href='{{ route('gallery') }}#products'">
                <img src="{{ asset('images/kiy.jpeg') }}" alt="Warehouse Preview" class="preview-image" onclick="window.location.href='{{ route('gallery') }}#facility'">
            </div>

            <a href="{{ route('gallery') }}" class="gallery-cta-btn">
                <span>View Full Gallery</span>
                <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        </div>
    </div>
</section>

<!-- Team Section (Leadership) - UPDATED with new images and proper display -->
<section class="team-section" id="leadership">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-dark mb-3">Meet Our Leadership</h2>
            <p class="lead text-muted">The dedicated team behind Premium Farming Feeds</p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/boss1.jpeg') }}" alt="Paul Mbua" class="team-photo" onerror="this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=2000'">
                </div>
                <h3>Paul Mbua</h3>
                <p class="team-role">Founder & CEO</p>
                <p class="team-bio">
                    20+ years in livestock nutrition. Leads our research and development initiatives.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/md boss.jpeg') }}" alt="Joyce Mbua" class="team-photo" onerror="this.src='https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=2000'">
                </div>
                <h3>Joyce Mbua</h3>
                <p class="team-role">Operations Director</p>
                <p class="team-bio">
                    Ensures seamless operations across all branches and maintains quality standards.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/naomi1.jpeg') }}" alt="Naomi" class="team-photo" onerror="this.src='https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=2000'">
                </div>
                <h3>Naomi</h3>
                <p class="team-role">General Manager</p>
                <p class="team-bio">
                    Manages daily operations and customer relations in all branches.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h2>4+</h2>
                <p>Years of Excellence</p>
                <small>Since 2020</small>
            </div>
            <div class="stat-item">
                <h2>3</h2>
                <p>Branches</p>
                <small>Serving Kiambu County</small>
            </div>
            <div class="stat-item">
                <h2>10k+</h2>
                <p>Happy Farmers</p>
                <small>And growing daily</small>
            </div>
            <div class="stat-item">
                <h2>54</h2>
                <p>Weekly Hours</p>
                <small>Mon-Sat, 8AM-6PM</small>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Lightbox variables
    let currentImageIndex = 0;
    const images = [];
    const captions = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Collect all gallery images if they exist
        document.querySelectorAll('.gallery-item').forEach((item, index) => {
            const img = item.querySelector('img');
            const overlay = item.querySelector('.gallery-overlay');
            const badge = item.querySelector('.gallery-badge');
            
            if (img) {
                images.push(img.src);
                captions.push({
                    title: overlay ? overlay.querySelector('h4').textContent : 'Premium Farming Feeds',
                    description: overlay ? overlay.querySelector('p').textContent : '',
                    category: badge ? badge.textContent : ''
                });

                // Add click event to each gallery item
                item.addEventListener('click', () => {
                    currentImageIndex = index;
                    openLightbox(img.src, captions[index]);
                });
            }
        });

        // Lightbox functions
        window.openLightbox = function(src, caption) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.querySelector('.lightbox-caption');

            lightboxImg.src = src;
            lightboxCaption.innerHTML = `<strong>${caption.title}</strong> - ${caption.description} <span style="color: #fbbf24;">(${caption.category})</span>`;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        window.closeLightbox = function() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        window.changeImage = function(direction) {
            if (images.length === 0) return;
            
            currentImageIndex += direction;
            
            if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            } else if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            }

            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxCaption = document.querySelector('.lightbox-caption');
            
            lightboxImg.src = images[currentImageIndex];
            lightboxCaption.innerHTML = `<strong>${captions[currentImageIndex].title}</strong> - ${captions[currentImageIndex].description} <span style="color: #fbbf24;">(${captions[currentImageIndex].category})</span>`;
        }

        // Close lightbox with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                changeImage(-1);
            } else if (e.key === 'ArrowRight') {
                changeImage(1);
            }
        });

        // Close lightbox when clicking outside the image
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Preview image click handlers
        document.querySelectorAll('.preview-image').forEach(img => {
            img.addEventListener('click', function() {
                const onclickAttr = this.getAttribute('onclick');
                if (onclickAttr) {
                    const match = onclickAttr.match(/'([^']+)'/);
                    if (match && match[1]) {
                        window.location.href = match[1];
                    }
                }
            });
        });
    });
</script>
@endpush