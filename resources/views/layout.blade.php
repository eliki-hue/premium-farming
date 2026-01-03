@extends('layouts.app')

@section('title', 'All Products | Premium Farming Feeds')

@section('content')

<div class="min-h-screen pt-24">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="hero-title mb-4 animate__animated animate__fadeInDown">
                        Our Premium Product Range
                    </h1>
                    <p class="hero-subtitle mb-5 animate__animated animate__fadeInUp animate__delay-1s">
                        Discover our complete collection of scientifically formulated feeds for all livestock types
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- PIG FEEDS -->
    <section id="pig-feeds" class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>🐖 Pig Feeds</h2>
                <p>Complete nutrition for profitable pig farming</p>
            </div>

            <div class="row g-4">
                @php
                $pigFeeds = [
                    ['id'=>101,'name'=>'Pig Starter Pellets','price'=>3200,'image'=>'images/piggrower.jpeg','desc'=>'Supports early growth and strong immunity for piglets. High protein formula with essential vitamins, amino acids, and probiotics for optimal health and disease resistance.','specs'=>['protein'=>'18-22%','weight'=>'10-25kg','stage'=>'Starter']],
                    ['id'=>102,'name'=>'Pig Grower Mash','price'=>2950,'image'=>'images/spig grower.jpeg','desc'=>'Balanced nutrition for rapid weight gain and muscle development. Contains optimal energy levels and digestible proteins for efficient feed conversion.','specs'=>['protein'=>'16-18%','weight'=>'25-60kg','stage'=>'Grower']],
                    ['id'=>103,'name'=>'Sow & Weaner Feed','price'=>3100,'image'=>'images/sowwen.jpeg','desc'=>'Enhances sow fertility, milk production and healthy piglet development. Fortified with calcium, phosphorus, and vitamins for reproductive health.','specs'=>['protein'=>'16-18%','weight'=>'Breeding','stage'=>'Reproduction']],
                    ['id'=>104,'name'=>'Pig Fattener','price'=>2850,'image'=>'images/pfter.jpeg','desc'=>'Maximum weight gain formula for premium meat quality and finish. Optimized for marbling and lean meat percentage with energy-rich ingredients.','specs'=>['protein'=>'14-16%','weight'=>'60kg+','stage'=>'Finisher']]
                ];
                @endphp

                @foreach($pigFeeds as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image-full">
                            <span class="product-badge pig">{{ $product['specs']['stage'] }}</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">{{ $product['name'] }}</h4>
                            <div class="product-description-container mb-3">
                                <p class="product-description mb-0">
                                    {{ Str::limit($product['desc'], 80) }}
                                    @if(strlen($product['desc']) > 80)
                                        <span class="collapse" id="desc-{{ $product['id'] }}">
                                            {{ substr($product['desc'], 80) }}
                                        </span>
                                        <a href="#desc-{{ $product['id'] }}" 
                                           class="read-more-link" 
                                           data-bs-toggle="collapse"
                                           data-bs-target="#desc-{{ $product['id'] }}"
                                           aria-expanded="false"
                                           aria-controls="desc-{{ $product['id'] }}">
                                            <span class="show-more">... See More</span>
                                            <span class="show-less d-none">... See Less</span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">{{ $product['specs']['protein'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Target Weight:</span>
                                    <span class="fw-bold">{{ $product['specs']['weight'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="price-tag">Ksh {{ number_format($product['price']) }}</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- POULTRY FEEDS -->
    <section id="poultry-feeds" class="section">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>🐔 Poultry Feeds</h2>
                <p>Optimal nutrition for growth and egg production</p>
            </div>

            <div class="row g-4">
                @php
                $poultryFeeds = [
                    ['id'=>301,'name'=>'Chick Starter','price'=>2500,'image'=>'images/chick start.jpeg','desc'=>'High protein starter feed for maximum early chick growth and immunity. Contains essential nutrients for digestive system development and disease resistance.','specs'=>['protein'=>'18-22%','type'=>'Starter','age'=>'0-8 weeks']],
                    ['id'=>302,'name'=>'Broiler Starter','price'=>2800,'image'=>'images/chickmash.jpeg','desc'=>'Very high protein for fast muscle growth in meat birds. Optimized for rapid weight gain with balanced amino acids and energy.','specs'=>['protein'=>'22-24%','type'=>'Broiler','age'=>'0-4 weeks']],
                    ['id'=>303,'name'=>'Growers Mash','price'=>2300,'image'=>'images/growers.jpeg','desc'=>'Balanced grower formula for steady weight gain and feathering. Supports skeletal development and prepares birds for laying phase.','specs'=>['protein'=>'14-18%','type'=>'Grower','age'=>'8-18 weeks']],
                    ['id'=>304,'name'=>'Layers Mash','price'=>2400,'image'=>'images/layers.jpeg','desc'=>'Calcium-rich formula for superior egg production and shell quality. Contains optimal levels of vitamins and minerals for egg formation.','specs'=>['protein'=>'~16%','type'=>'Layer','age'=>'18+ weeks']],
                    ['id'=>305,'name'=>'Super Layers','price'=>2600,'image'=>'images/slayers.jpeg','desc'=>'Premium layers feed for maximum egg production and bird health. Enhanced with probiotics and omega-3 for better egg quality.','specs'=>['protein'=>'16-18%','type'=>'Premium','age'=>'Peak lay']]
                ];
                @endphp

                @foreach($poultryFeeds as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image-full">
                            <span class="product-badge poultry">{{ $product['specs']['type'] }}</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">{{ $product['name'] }}</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-clock me-2"></i>{{ $product['specs']['age'] }}</small>
                            </p>
                            <div class="product-description-container mb-3">
                                <p class="product-description mb-0">
                                    {{ Str::limit($product['desc'], 80) }}
                                    @if(strlen($product['desc']) > 80)
                                        <span class="collapse" id="desc-{{ $product['id'] }}">
                                            {{ substr($product['desc'], 80) }}
                                        </span>
                                        <a href="#desc-{{ $product['id'] }}" 
                                           class="read-more-link" 
                                           data-bs-toggle="collapse"
                                           data-bs-target="#desc-{{ $product['id'] }}"
                                           aria-expanded="false"
                                           aria-controls="desc-{{ $product['id'] }}">
                                            <span class="show-more">... See More</span>
                                            <span class="show-less d-none">... See Less</span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">{{ $product['specs']['protein'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Type:</span>
                                    <span class="fw-bold">{{ $product['specs']['type'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="price-tag">Ksh {{ number_format($product['price']) }}</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PET FEEDS -->
    <section id="pet-feeds" class="section bg-light">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>🐶 Pet Feeds</h2>
                <p>Complete nutrition for your beloved pets</p>
            </div>

            <div class="row g-4">
                @php
                $petFeeds = [
                    ['id'=>201,'name'=>'Dog Meal','price'=>2800,'image'=>'images/dogm.jpeg','desc'=>'Complete balanced nutrition with essential vitamins for all dog breeds. Supports healthy skin, coat, and digestive system with natural ingredients.','specs'=>['protein'=>'Balanced','type'=>'Dogs','size'=>'All sizes']],
                    ['id'=>202,'name'=>'Rabbit Pellets','price'=>2200,'image'=>'images/rabit1.jpeg','desc'=>'High fiber pellets for optimal digestion and healthy rabbit growth. Contains timothy hay base with added vitamins for dental health.','specs'=>['protein'=>'Moderate','type'=>'Rabbits','size'=>'All ages']],
                    ['id'=>203,'name'=>'Calf Pellets','price'=>3500,'image'=>'images/cpellets.jpeg','desc'=>'High-protein formula for healthy growth and strong immunity in calves. Supports rumen development and early weaning success.','specs'=>['protein'=>'High','type'=>'Calves','age'=>'0-6 months']]
                ];
                @endphp

                @foreach($petFeeds as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image-full">
                            <span class="product-badge pet">{{ $product['specs']['type'] }}</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">{{ $product['name'] }}</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-tag me-2"></i>{{ $product['specs']['type'] }}</small>
                            </p>
                            <div class="product-description-container mb-3">
                                <p class="product-description mb-0">
                                    {{ Str::limit($product['desc'], 80) }}
                                    @if(strlen($product['desc']) > 80)
                                        <span class="collapse" id="desc-{{ $product['id'] }}">
                                            {{ substr($product['desc'], 80) }}
                                        </span>
                                        <a href="#desc-{{ $product['id'] }}" 
                                           class="read-more-link" 
                                           data-bs-toggle="collapse"
                                           data-bs-target="#desc-{{ $product['id'] }}"
                                           aria-expanded="false"
                                           aria-controls="desc-{{ $product['id'] }}">
                                            <span class="show-more">... See More</span>
                                            <span class="show-less d-none">... See Less</span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">{{ $product['specs']['protein'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>For:</span>
                                    <span class="fw-bold">{{ $product['specs']['type'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="price-tag">Ksh {{ number_format($product['price']) }}</span>
                                    <small class="text-muted d-block">per bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- BY-PRODUCTS -->
    <section id="by-products" class="section">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>🌾 By-Products</h2>
                <p>High-quality supplements for complete livestock nutrition</p>
            </div>

            <div class="row g-4">
                @php
                $byProducts = [
                    ['id'=>401,'name'=>'Wheat Bran','price'=>1300,'image'=>'images/bran.jpg','desc'=>'High fiber bulk feed supplement for ruminants and poultry. Excellent for digestive health and rumen function in cattle and goats.','specs'=>['protein'=>'15-17%','type'=>'Fiber','use'=>'Ruminants']],
                    ['id'=>402,'name'=>'Wheat Pollard','price'=>1500,'image'=>'images/pollard.jpg','desc'=>'Energy and protein-rich supplement for all livestock. Ideal for mixing with other feeds to improve nutritional value.','specs'=>['protein'=>'16-18%','type'=>'Energy','use'=>'All livestock']],
                    ['id'=>403,'name'=>'Maize Germ','price'=>1400,'image'=>'images/maize.jpeg','desc'=>'High-energy maize by-product for cost-effective feeding. Rich in oils and proteins for improved weight gain.','specs'=>['protein'=>'18-22%','type'=>'Energy','use'=>'Poultry/Swine']]
                ];
                @endphp

                @foreach($byProducts as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="product-card premium-card animate-on-scroll">
                        <div class="product-image-container">
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image-full">
                            <span class="product-badge byproduct">{{ $product['specs']['type'] }}</span>
                        </div>
                        <div class="product-content">
                            <h4 class="fw-bold mb-2">{{ $product['name'] }}</h4>
                            <p class="text-muted mb-2">
                                <small><i class="bi bi-arrow-right-circle me-2"></i>{{ $product['specs']['use'] }}</small>
                            </p>
                            <div class="product-description-container mb-3">
                                <p class="product-description mb-0">
                                    {{ Str::limit($product['desc'], 80) }}
                                    @if(strlen($product['desc']) > 80)
                                        <span class="collapse" id="desc-{{ $product['id'] }}">
                                            {{ substr($product['desc'], 80) }}
                                        </span>
                                        <a href="#desc-{{ $product['id'] }}" 
                                           class="read-more-link" 
                                           data-bs-toggle="collapse"
                                           data-bs-target="#desc-{{ $product['id'] }}"
                                           aria-expanded="false"
                                           aria-controls="desc-{{ $product['id'] }}">
                                            <span class="show-more">... See More</span>
                                            <span class="show-less d-none">... See Less</span>
                                        </a>
                                    @endif
                                </p>
                            </div>
                            <div class="product-specs mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Protein:</span>
                                    <span class="fw-bold text-primary">{{ $product['specs']['protein'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Type:</span>
                                    <span class="fw-bold">{{ $product['specs']['type'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <span class="price-tag">Ksh {{ number_format($product['price']) }}</span>
                                    <small class="text-muted d-block">per 50kg bag</small>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST" class="mb-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                                    <button type="submit" class="btn btn-premium">
                                        <i class="bi bi-cart-plus me-2"></i> Add
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-on-scroll text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="cta-title mb-4">Get Your Premium Feeds Today!</h2>
                        <p class="cta-text mb-5 fs-5">
                            Select your products, proceed to secure checkout, and enjoy fast delivery to your farm.
                        </p>
                        
                        <div class="d-grid gap-3 d-md-flex justify-content-center">
                            <!-- If user has items in cart -->
                            @php
                                $cartItems = session('cart', []);
                                $cartCount = count($cartItems);
                            @endphp
                            
                            @if($cartCount > 0)
                                <a href="{{ route('checkout') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold me-md-3">
                                    <i class="bi bi-lock-fill me-2"></i>
                                    Secure Checkout ({{ $cartCount }} items)
                                </a>
                                <a href="{{ route('cart.view') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                                    <i class="bi bi-cart me-2"></i>
                                    View Cart
                                </a>
                            @else
                                <!-- If cart is empty -->
                                <a href="{{ route('checkout') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold me-md-3">
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    Go to Payment
                                </a>
                                <a href="#pig-feeds" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                                    <i class="bi bi-search me-2"></i>
                                    Browse Products
                                </a>
                            @endif
                        </div>
                        
                        <!-- Trust indicators -->
                        <div class="mt-5 pt-4">
                            <div class="row justify-content-center g-4">
                                <div class="col-auto">
                                    <div class="d-flex align-items-center text-light">
                                        <i class="bi bi-shield-check fs-4 me-2"></i>
                                        <span>Secure Payment</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center text-light">
                                        <i class="bi bi-truck fs-4 me-2"></i>
                                        <span>Farm Delivery</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex align-items-center text-light">
                                        <i class="bi bi-headset fs-4 me-2"></i>
                                        <span>Expert Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-section {
        min-height: 70vh;
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef') center/cover;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto 2.5rem;
        font-weight: 300;
    }
    
    /* Product Card Styles - FULL VISIBLE IMAGES */
    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }
    
    /* FULL VISIBLE IMAGE CONTAINER */
    .product-image-container {
        position: relative;
        height: 300px;
        width: 100%;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }
    
    .product-image-full {
        width: 100%;
        height: 100%;
        object-fit: contain !important; /* Show full image without cropping */
        object-position: center center;
        padding: 25px;
        transition: all 0.5s ease;
    }
    
    .product-card:hover .product-image-full {
        transform: scale(1.05);
        padding: 20px;
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        color: white;
        z-index: 2;
    }
    
    .product-badge.pig {
        background: linear-gradient(135deg, #8b4513, #dc2626);
    }
    
    .product-badge.poultry {
        background: linear-gradient(135deg, #dc2626, #f59e0b);
    }
    
    .product-badge.pet {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
    }
    
    .product-badge.byproduct {
        background: linear-gradient(135deg, #047857, #065f46);
    }
    
    .product-content {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-description-container {
        flex-grow: 1;
        margin-bottom: 1.5rem;
    }
    
    .product-description {
        line-height: 1.6;
        color: #4a5568;
    }
    
    /* Read More/Less Styles */
    .read-more-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: inline-block;
        margin-left: 4px;
        transition: all 0.3s ease;
    }
    
    .read-more-link:hover {
        text-decoration: underline;
        color: #2d4a3e;
    }
    
    .show-more, .show-less {
        display: inline;
    }
    
    .collapse.show + .read-more-link .show-more {
        display: none;
    }
    
    .collapse.show + .read-more-link .show-less {
        display: inline;
    }
    
    .collapse:not(.show) + .read-more-link .show-more {
        display: inline;
    }
    
    .collapse:not(.show) + .read-more-link .show-less {
        display: none;
    }
    
    .price-tag {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .product-specs {
        background: rgba(42, 110, 63, 0.05);
        padding: 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    
    /* Make buttons align at bottom */
    .mt-auto {
        margin-top: auto;
    }
    
    /* CTA Section Styles */
    .cta-section {
        background: linear-gradient(135deg, #2a6e3f 0%, #1e522e 100%);
        padding: 100px 0;
        margin-top: 50px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1589923186741-7d1d6ccee3c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        opacity: 0.1;
        z-index: 0;
    }
    
    .cta-content {
        position: relative;
        z-index: 1;
    }
    
    .cta-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .cta-text {
        font-size: 1.25rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto 2.5rem;
        font-weight: 300;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
    }
    
    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .product-image-container {
            height: 280px;
        }
    }
    
    @media (max-width: 992px) {
        .product-image-container {
            height: 250px;
        }
        
        .product-image-full {
            padding: 20px;
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .product-image-container {
            height: 220px;
        }
        
        .product-content {
            padding: 1.25rem;
        }
        
        .price-tag {
            font-size: 1.5rem;
        }
        
        .read-more-link {
            font-size: 0.85rem;
        }
        
        /* CTA responsive */
        .cta-section {
            padding: 60px 0;
        }
        
        .cta-title {
            font-size: 2.2rem;
        }
        
        .cta-text {
            font-size: 1.1rem;
        }
        
        .btn-lg {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .d-flex {
            flex-direction: column;
            gap: 15px;
        }
    }
    
    @media (max-width: 576px) {
        .product-image-container {
            height: 200px;
        }
        
        .product-image-full {
            padding: 15px;
        }
    }
</style>

<!-- JavaScript for Read More/Less -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Bootstrap collapse events for read more/less
    const readMoreLinks = document.querySelectorAll('.read-more-link');
    
    readMoreLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Bootstrap handles the collapse, we just need to update text
            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Update aria-expanded attribute
            this.setAttribute('aria-expanded', !isExpanded);
        });
    });
    
    // Initialize tooltips if you have any
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection