@extends('layouts.app')

@section('title', 'About Us - GreenHarvest')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(rgba(45, 95, 78, 0.85), rgba(30, 68, 54, 0.85)),
                    url('https://images.unsplash.com/photo-1464226184884-fa280b87c399?q=80&w=2000') center/cover;
        padding: 10rem 0 6rem;
        color: white;
        text-align: center;
    }

    .about-hero h1 {
        font-size: 4.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .about-hero p {
        font-size: 1.4rem;
        opacity: 0.95;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.8;
    }

    .story-section {
        padding: 6rem 0;
        background-color: white;
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
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
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
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--text-dark);
    }

    .story-text p {
        font-size: 1.1rem;
        line-height: 1.9;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .values-section {
        background-color: var(--light-bg);
        padding: 6rem 0;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .value-card {
        background: white;
        padding: 3rem 2rem;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .value-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-orange);
    }

    .value-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--accent-orange) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 3rem;
    }

    .value-card h3 {
        font-size: 1.6rem;
        margin-bottom: 1rem;
        color: var(--text-dark);
    }

    .value-card p {
        color: var(--text-muted);
        line-height: 1.7;
    }

    .team-section {
        padding: 6rem 0;
        background: white;
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

    .team-photo {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1.5rem;
        border: 5px solid var(--light-bg);
        transition: all 0.3s ease;
    }

    .team-member:hover .team-photo {
        border-color: var(--accent-orange);
    }

    .team-member h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .team-role {
        color: var(--accent-orange);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .team-bio {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .stats-section {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
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
        font-size: 4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--accent-orange);
    }

    .stat-item p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    @media (max-width: 992px) {
        .about-hero h1 {
            font-size: 3rem;
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
    }
</style>
@endpush

@section('content')
<!-- About Hero -->
<section class="about-hero">
    <div class="container">
        <h1>Our Story</h1>
        <p>
            For three generations, the GreenHarvest family has been cultivating the finest organic produce, 
            nurturing our land with sustainable practices, and bringing farm-fresh goodness to your table.
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="story-section">
    <div class="container">
        <div class="story-content">
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1200" alt="Our Farm">
            </div>
            <div class="story-text">
                <h2>Where It All Began</h2>
                <p>
                    In 1975, our grandfather purchased 50 acres of fertile land in Green Valley with a simple dream: 
                    to grow the healthiest, most flavorful produce while caring for the earth. What started as a small 
                    family operation has grown into a thriving organic farm that serves thousands of families.
                </p>
                <p>
                    Today, we honor his legacy by maintaining the same commitment to quality, sustainability, and 
                    authenticity that he instilled in us from the very beginning.
                </p>
            </div>
        </div>

        <div class="story-content">
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=1200" alt="Organic Farming">
            </div>
            <div class="story-text">
                <h2>Our Commitment to Organic</h2>
                <p>
                    We believe that the best food comes from healthy soil. That's why we've been certified organic 
                    since 1990, long before it became a trend. We never use synthetic pesticides, herbicides, or 
                    genetically modified seeds.
                </p>
                <p>
                    Instead, we work with nature—using crop rotation, composting, and natural pest management to 
                    create a thriving ecosystem. The result? Produce that's not just good for you, but good for 
                    the planet too.
                </p>
            </div>
        </div>

        <div class="story-content">
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?q=80&w=1200" alt="Farm to Table">
            </div>
            <div class="story-text">
                <h2>From Our Farm to Your Table</h2>
                <p>
                    We've revolutionized the way fresh produce reaches your home. By cutting out the middleman 
                    and delivering directly to you within 24 hours of harvest, we ensure you receive the freshest, 
                    most nutrient-rich food possible.
                </p>
                <p>
                    Every tomato, every egg, every jar of honey is handled with care and delivered with pride. 
                    Because we're not just growing food—we're nourishing families and building community.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2>Our Core Values</h2>
            <p>The principles that guide everything we do</p>
        </div>

        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-heart-fill"></i>
                </div>
                <h3>Quality First</h3>
                <p>
                    We never compromise on quality. Every product is carefully inspected and hand-selected 
                    to meet our rigorous standards.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-globe-americas"></i>
                </div>
                <h3>Sustainability</h3>
                <p>
                    We're committed to regenerative farming practices that improve soil health and 
                    protect our environment for future generations.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3>Community</h3>
                <p>
                    We believe in supporting local communities, fair wages for our workers, and building 
                    lasting relationships with our customers.
                </p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Transparency</h3>
                <p>
                    We're open about our farming methods, practices, and processes. You have the right 
                    to know exactly where your food comes from.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <div class="section-header">
            <h2>Meet Our Team</h2>
            <p>The dedicated people behind Premium Farming</p>
        </div>

        <div class="team-grid">
            <div class="team-member">
                <img src="images/boss.jpeg" alt="Paul Mbua" class="team-photo">
                <h3>PAUL MBUA</h3>
                <p class="team-role">Founder & CEO</p>
                <p class="team-bio">
                    Third-generation farmer with 30 years of experience in organic agriculture and sustainable farming practices.
                </p>
            </div>

            <div class="team-member">
                <img src="images/md boss.jpeg" alt="Joyce Mbua" class="team-photo">
                <h3>JOYCE MBUA</h3>
                <p class="team-role">Founder &  vision lead</p>
                <p class="team-bio">
                    Ensures every product meets our high standards with her expertise in organic certification and food safety.
                </p>
            </div>

            <div class="team-member">
                <img src="images/manager.jpeg" alt="Naomi" class="team-photo">
                <h3>NAOMI</h3>
                <p class="team-role">Branch Manager</p>
                <p class="team-bio">
                    Leads our environmental initiatives and regenerative farming programs to ensure a sustainable future.
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
                <h2>1   0+</h2>
                <p>Years of Excellence</p>
            </div>
            <div class="stat-item">
                <h2>200</h2>
                <p>Acres of Organic Land</p>
            </div>
            <div class="stat-item">
                <h2>10k+</h2>
                <p>Happy Customers</p>
            </div>
            <div class="stat-item">
                <h2>100%</h2>
                <p>Organic Certified</p>
            </div>
        </div>
    </div>
</section>
@endsection