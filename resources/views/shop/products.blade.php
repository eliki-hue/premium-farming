@extends('layouts.app')

@section('title', 'All Products | Premium Farming Feeds')

@php
    // Get user from session
    $django_user = session('django_user');
    $django_token = session('django_token');
@endphp

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
                            
                            @if(!$django_user)
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endif
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
                                
                                @if($django_user)
                                <button type="button" class="btn btn-premium add-to-cart-btn" 
                                        data-id="{{ $product['id'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-price="{{ $product['price'] }}"
                                        data-image="{{ $product['image'] }}">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @else
                                <!-- Sign Up Button for Guests -->
                                <a href="{{ route('register') }}" class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- POULTRY FEEDS Section -->
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
                            
                            @if(!$django_user)
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endif
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
                                
                                @if($django_user)
                                <button type="button" class="btn btn-premium add-to-cart-btn" 
                                        data-id="{{ $product['id'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-price="{{ $product['price'] }}"
                                        data-image="{{ $product['image'] }}">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @else
                                <a href="{{ route('register') }}" class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PET FEEDS Section -->
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
                            
                            @if(!$django_user)
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endif
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
                                
                                @if($django_user)
                                <button type="button" class="btn btn-premium add-to-cart-btn" 
                                        data-id="{{ $product['id'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-price="{{ $product['price'] }}"
                                        data-image="{{ $product['image'] }}">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @else
                                <a href="{{ route('register') }}" class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- BY-PRODUCTS Section -->
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
                            
                            @if(!$django_user)
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endif
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
                                
                                @if($django_user)
                                <button type="button" class="btn btn-premium add-to-cart-btn" 
                                        data-id="{{ $product['id'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-price="{{ $product['price'] }}"
                                        data-image="{{ $product['image'] }}">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @else
                                <a href="{{ route('register') }}" class="btn btn-premium">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </a>
                                @endif
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
                            @if($django_user)
                                <a href="{{ route('cart.view') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold me-md-3">
                                    <i class="bi bi-cart me-2"></i>
                                    View Cart
                                </a>
                                <a href="#pig-feeds" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Continue Shopping
                                </a>
                            @else
                                <!-- For guests -->
                                <a href="{{ route('register') }}" class="btn btn-premium btn-lg me-2">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Sign Up to Shop
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Log In
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

<!-- Alert div for notifications -->
<div id="notificationAlert" class="alert alert-dismissible fade" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px; opacity: 0; transform: translateX(100%); transition: all 0.3s ease;">
    <div class="d-flex">
        <div id="alertIcon" class="me-2"></div>
        <div>
            <h6 class="alert-heading mb-1" id="alertTitle"></h6>
            <p class="mb-0 small" id="alertMessage"></p>
        </div>
        <button type="button" class="btn-close ms-auto" onclick="hideAlert()"></button>
    </div>
</div>

<style>
    /* Add to existing styles */
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
    
    /* Sign Up Overlay Styles */
    .signup-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .product-image-container:hover .signup-overlay {
        opacity: 1;
    }
    
    .overlay-content {
        text-align: center;
        color: white;
        padding: 20px;
    }
    
    .overlay-content i {
        font-size: 2.5rem;
        color: #fff;
        margin-bottom: 10px;
    }
    
    .overlay-content h6 {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .overlay-content .btn {
        font-size: 0.8rem;
        padding: 5px 15px;
    }
    
    /* Existing styles remain the same */
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
    
    .product-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        border-radius: 20px;
        overflow: hidden;
        background: white;
        box-shadow: var(--shadow-soft);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }
    
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
        object-fit: contain !important;
        object-position: center center;
        padding: 25px;
        transition: all 0.5s ease;
    }
    
    .product-card:hover .product-image-full {
        transform: scale(1.05);
        padding: 20px;
    }
    
    .alert.show {
        opacity: 1;
        transform: translateX(0);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .signup-overlay .overlay-content {
            padding: 10px;
        }
        
        .overlay-content i {
            font-size: 1.5rem;
        }
        
        .overlay-content h6 {
            font-size: 0.9rem;
        }
        
        #notificationAlert {
            left: 20px;
            right: 20px;
            max-width: calc(100% - 40px);
        }
    }
</style>

<script>
// Alert functions
function showAlert(title, message, type = 'success') {
    const alert = document.getElementById('notificationAlert');
    const alertTitle = document.getElementById('alertTitle');
    const alertMessage = document.getElementById('alertMessage');
    const alertIcon = document.getElementById('alertIcon');
    
    if (!alert || !alertTitle || !alertMessage) return;
    
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alertTitle.textContent = title;
    alertMessage.textContent = message;
    
    // Set icon based on type
    if (type === 'success') {
        alertIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success fs-5"></i>';
    } else if (type === 'error') {
        alertIcon.innerHTML = '<i class="bi bi-x-circle-fill text-danger fs-5"></i>';
    } else if (type === 'warning') {
        alertIcon.innerHTML = '<i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>';
    } else {
        alertIcon.innerHTML = '<i class="bi bi-info-circle-fill text-info fs-5"></i>';
    }
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        hideAlert();
    }, 5000);
}

function hideAlert() {
    const alert = document.getElementById('notificationAlert');
    if (alert) {
        alert.classList.remove('show');
        setTimeout(() => {
            alert.className = 'alert alert-dismissible fade';
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // CSRF token for Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const djangoToken = "{{ $django_token ?? '' }}";
    const djangoApiUrl = "{{ config('services.django_api.url', 'http://127.0.0.1:8000') }}";
    
    // Check if user is logged in
    const isLoggedIn = djangoToken && djangoToken.length > 10; // Token should be reasonably long
    
    console.log('User logged in:', isLoggedIn, 'Token length:', djangoToken?.length);
    
    // Handle Add to Cart button clicks for logged in users
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!isLoggedIn) {
                showAlert('Authentication Required', 'Please login to add items to cart.', 'warning');
                // Redirect to login page
                window.location.href = "{{ route('login') }}";
                return;
            }
            
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = this.getAttribute('data-price');
            const productImage = this.getAttribute('data-image');
            
            // Show loading
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split"></i>';
            this.disabled = true;
            
            try {
                // Direct API call to Django for cart
                const response = await fetch(`${djangoApiUrl}/cart/items/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${djangoToken}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: 1
                    })
                });
                
                if (response.ok) {
                    const data = await response.json();
                    showAlert('Success', `${productName} added to cart!`, 'success');
                    updateCartBadge();
                } else if (response.status === 401) {
                    showAlert('Session Expired', 'Please login again.', 'warning');
                    // Redirect to logout to clear session
                    setTimeout(() => {
                        window.location.href = '{{ route("logout") }}';
                    }, 1500);
                } else {
                    const data = await response.json();
                    showAlert('Error', data.detail || data.message || 'Failed to add to cart', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error', 'Network error. Please try again.', 'error');
            } finally {
                // Restore button
                this.innerHTML = originalHTML;
                this.disabled = false;
            }
        });
    });
    
    // Update cart badge
    async function updateCartBadge() {
        const cartBadge = document.querySelector('.cart-badge');
        if (!cartBadge || !isLoggedIn) {
            if (cartBadge) cartBadge.style.display = 'none';
            return;
        }
        
        try {
            const response = await fetch(`${djangoApiUrl}/cart/`, {
                headers: {
                    'Authorization': `Bearer ${djangoToken}`,
                    'Accept': 'application/json'
                }
            });
            
            if (response.ok) {
                const cart = await response.json();
                const itemCount = cart.items ? cart.items.length : 0;
                
                if (itemCount > 0) {
                    cartBadge.textContent = itemCount;
                    cartBadge.style.display = 'flex';
                } else {
                    cartBadge.style.display = 'none';
                }
            } else if (response.status === 401) {
                cartBadge.style.display = 'none';
            }
        } catch (error) {
            console.error('Error updating cart badge:', error);
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) cartBadge.style.display = 'none';
        }
    }
    
    // Initial cart badge update
    updateCartBadge();
    
    // Debug: Check authentication state
    console.log('Auth Debug:', {
        hasToken: !!djangoToken,
        tokenLength: djangoToken?.length,
        apiUrl: djangoApiUrl,
        isLoggedIn: isLoggedIn
    });
});
</script>

@endsection