@extends('layouts.app')

@section('title', 'About Premium Farming Feeds')

@push('styles')
<style>
    /* Hero Section */
    .about-hero {
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070') center/cover;
        padding: 8rem 0 5rem;
        color: white;
        text-align: center;
        position: relative;
    }

    .about-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .about-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
        font-weight: 300;
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

    /* Team Section - FIXED FOR ALL IMAGES */
    .team-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .team-member {
        text-align: center;
        transition: all 0.3s ease;
    }

    .team-member:hover {
        transform: translateY(-10px);
    }

    /* Improved image handling for all team members */
    .team-photo-container {
        width: 240px;
        height: 240px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        background: #f8fafc;
    }

    .team-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center; /* Default center positioning */
        transition: all 0.5s ease;
    }

    /* Specific styling for each team member's photo */
    .team-member:nth-child(1) .team-photo {
        object-position: center center; /* Paul - center */
    }

    .team-member:nth-child(2) .team-photo {
        object-position: center center; /* Joyce - center */
    }

    .team-member:nth-child(3) .team-photo {
        object-position: center 25%; /* Naomi - focus on face */
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
        font-size: 1.1rem;
    }

    .team-bio {
        color: #718096;
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 300px;
        margin: 0 auto;
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

    /* Responsive */
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

        .stat-item h2 {
            font-size: 2.8rem;
        }
        
        /* Responsive team photos */
        .team-photo-container {
            width: 200px;
            height: 200px;
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
        
        .team-photo-container {
            width: 180px;
            height: 180px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <h1>Premium Farming Feeds</h1>
        <p>
            Since 2020, we've been providing quality animal feeds to farmers across Kenya. 
            Our commitment to excellence and customer satisfaction has made us the trusted choice 
            for livestock nutrition.
        </p>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="vision-mission-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        To be East Africa's leading provider of premium animal feeds, empowering farmers 
                        to achieve maximum productivity through scientifically formulated nutrition solutions 
                        that enhance livestock health and profitability.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        To provide farmers with high-quality, affordable, and scientifically balanced animal 
                        feeds that optimize livestock growth and productivity. We are committed to 
                        sustainable farming practices, farmer education, and exceptional customer service.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Transport & Delivery Section - UPDATED WITH LOCAL IMAGES -->
<section class="transport-section">
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
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/trsnp2.jpeg') }}" alt="Our Delivery Truck" 
                             onerror="this.src='https://images.unsplash.com/photo-1560472354-b33ff0c44a43?q=80&w=2000'">
                    </div>
                    <div class="transport-content">
                        <h4>Farm Delivery</h4>
                        <p>We deliver directly to your farm with our specialized feed delivery trucks. Delivery available Monday to Saturday, 8:00 AM - 6:00 PM.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Mon-Sat Delivery</span>
                            <span class="transport-badge">8 AM - 6 PM</span>
                            <span class="transport-badge">Tracked</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/trns1.jpeg') }}" alt="Our Warehouse" 
                             onerror="this.src='https://images.unsplash.com/photo-1589923186741-7d1d6ccee3c3?q=80&w=2070'">
                    </div>
                    <div class="transport-content">
                        <h4>Pickup Stations</h4>
                        <p>Collect your feeds from our conveniently located branches. Available Monday to Saturday, 8:00 AM - 6:00 PM.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Self-Service</span>
                            <span class="transport-badge">Mon-Sat 8-6</span>
                            <span class="transport-badge">Loading Help</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="transport-card">
                    <div class="transport-image">
                        <img src="{{ asset('images/trns.jpeg') }}" alt="Bulk Orders" 
                             onerror="this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2000'">
                    </div>
                    <div class="transport-content">
                        <h4>Bulk Orders</h4>
                        <p>Special arrangements for large-scale farmers and cooperatives. Scheduled deliveries Monday to Saturday.</p>
                        <div class="transport-features">
                            <span class="transport-badge">Bulk Discounts</span>
                            <span class="transport-badge">Scheduled Delivery</span>
                            <span class="transport-badge">Flexible Terms</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section - UPDATED WITH LOCAL IMAGES -->
<section class="story-section">
    <div class="container">
        <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/comp1.jpeg') }}" alt="Our Beginning - Premium Farming Feeds" 
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
                <p>
                    Starting with just one delivery truck and a small warehouse, we focused on 
                    quality over quantity, building relationships with local farmers who became 
                    our first loyal customers.
                </p>
            </div>
        </div>

        <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/comp.jpeg') }}" alt="Growth & Expansion - Premium Farming Feeds" 
                     onerror="this.src='https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=2000'">
            </div>
            <div class="story-text">
                <h2>Growth & Expansion</h2>
                <p>
                    Through consistent quality and excellent customer service, we expanded to three 
                    branches across Kiambu County. Today, we serve thousands of farmers from small-scale 
                    homesteads to large commercial farms.
                </p>
                <p>
                    Our commitment to quality has remained unchanged - every bag of feed is produced 
                    with the same care and attention to detail as our very first batch.
                </p>
                <p>
                    We've invested in modern equipment, expanded our delivery fleet, and trained 
                    our staff to provide expert advice to farmers. Our growth is a testament to 
                    the trust farmers have placed in our products and services.
                </p>
            </div>
        </div>

        <!-- Additional Story Section - Our Operations -->
        <div class="story-content">
            <div class="story-image">
                <img src="{{ asset('images/kiy.jpeg') }}" alt="Our Operations - Premium Farming Feeds" 
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
                    We work closely with veterinary experts and agricultural researchers to 
                    ensure our feeds meet the highest nutritional standards for different 
                    livestock types and growth stages.
                </p>
                <p>
                    Our team conducts regular farm visits to understand our customers' needs 
                    and provide personalized feeding solutions for optimal livestock health 
                    and productivity.
                </p>
            </div>
        </div>
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
                <h3>Excellence</h3>
                <p>We never compromise on quality. Every product undergoes rigorous testing to ensure it meets our high standards.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3>Farmer Success</h3>
                <p>Your success is our success. We provide technical support and advice to help you maximize your farm's potential.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Integrity</h3>
                <p>We conduct business with honesty and transparency. What we promise is what we deliver.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h3>Reliability</h3>
                <p>Consistent product quality and reliable delivery services you can depend on.</p>
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
                    <small class="text-muted">Closed on Sundays and Public Holidays</small>
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
                        <p><i class="bi bi-geo-alt me-2"></i> Along Thika-Gatundu Road</p>
                        <p><i class="bi bi-clock me-2"></i> <strong>Mon-Sat:</strong> 8:00 AM - 6:00 PM</p>
                        <p><i class="bi bi-calendar-x me-2"></i> <strong>Sun:</strong> Closed</p>
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
                        <p><i class="bi bi-clock me-2"></i> <strong>Mon-Sat:</strong> 8:00 AM - 6:00 PM</p>
                        <p><i class="bi bi-calendar-x me-2"></i> <strong>Sun:</strong> Closed</p>
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
                        <p><i class="bi bi-clock me-2"></i> <strong>Mon-Sat:</strong> 8:00 AM - 6:00 PM</p>
                        <p><i class="bi bi-calendar-x me-2"></i> <strong>Sun:</strong> Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-dark mb-3">Meet Our Leadership</h2>
            <p class="lead text-muted">The dedicated team behind Premium Farming Feeds</p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/boss.jpeg') }}" alt="Paul Mbua" class="team-photo">
                </div>
                <h3>Paul Mbua</h3>
                <p class="team-role">Founder & CEO</p>
                <p class="team-bio">
                    20+ years in livestock nutrition. Leads our research and development initiatives.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/md boss.jpeg') }}" alt="Joyce Mbua" class="team-photo">
                </div>
                <h3>Joyce Mbua</h3>
                <p class="team-role">Operations Director</p>
                <p class="team-bio">
                    Ensures seamless operations across all branches and maintains quality standards.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/manager.jpeg') }}" alt="Naomi" class="team-photo">
                </div>
                <h3>Naomi</h3>
                <p class="team-role">Branch Manager</p>
                <p class="team-bio">
                    Manages daily operations and customer relations at our Turitu branch.
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
            </div>
            <div class="stat-item">
                <h2>3</h2>
                <p>Branches</p>
            </div>
            <div class="stat-item">
                <h2>10k+</h2>
                <p>Happy Farmers</p>
            </div>
            <div class="stat-item">
                <h2>54</h2>
                <p>Weekly Hours</p>
                <small>Mon-Sat, 8AM-6PM</small>
            </div>
        </div>
    </div>
</section>
@endsection