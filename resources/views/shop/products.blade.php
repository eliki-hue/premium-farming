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
                    
                    <!-- Sign Up Notice -->
                    {{-- @guest
                    <div class="alert alert-info alert-dismissible fade show mb-4 mx-auto" style="max-width: 600px;" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Sign up required!</strong> You need to create an account to add items to cart and make purchases.
                        <a href="{{ route('register') }}" class="alert-link ms-1">Sign up here</a> or 
                        <a href="{{ route('login') }}" class="alert-link">log in</a> if you already have an account.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endguest --}}
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
                            
                            @guest
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endguest
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
                                
                                @auth
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
                                @else
                                <!-- Sign Up Button for Guests -->
                                <button type="button" class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#signupModal">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @endauth
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
                            
                            @guest
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endguest
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
                                
                                @auth
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
                                @else
                                <button type="button" class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#signupModal">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @endauth
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
                            
                            @guest
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endguest
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
                                
                                @auth
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
                                @else
                                <button type="button" class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#signupModal">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @endauth
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
                            
                            @guest
                            <div class="signup-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-lock fs-1 mb-3"></i>
                                    <h6 class="mb-2">Sign Up Required</h6>
                                    <p class="small mb-3">Create an account to add to cart</p>
                                    <a href="{{ route('register') }}" class="btn btn-sm btn-light">Sign Up Free</a>
                                </div>
                            </div>
                            @endguest
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
                                
                                @auth
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
                                @else
                                <button type="button" class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#signupModal">
                                    <i class="bi bi-cart-plus me-2"></i> Add
                                </button>
                                @endauth
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
                            @auth
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
                                    <a href="#pig-feeds" class="btn btn-success btn-lg px-5 py-3 fw-bold me-md-3">
                                        <i class="bi bi-cart-plus me-2"></i>
                                        Browse Products
                                    </a>
                                @endif
                            @else
                                <!-- For guests -->
                                <a href="{{ route('register') }}" class="btn btn-success btn-lg px-5 py-3 fw-bold me-md-3">
                                    <i class="bi bi-person-plus me-2"></i>
                                    Sign Up to Shop
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Log In
                                </a>
                            @endauth
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

<!-- Sign Up Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-premium text-white">
                <h5 class="modal-title" id="signupModalLabel">
                    <i class="bi bi-lock me-2"></i>Sign Up Required
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-cart-plus display-1 text-premium mb-3"></i>
                    <h4>Create Your Account</h4>
                    <p class="text-muted">You need to sign up to add items to your cart and make purchases</p>
                </div>
                
                <div class="benefits mb-4">
                    <h6 class="mb-3">Benefits of signing up:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Add products to cart</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Save favorite products</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Track your orders</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Faster checkout</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Exclusive offers</li>
                    </ul>
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('register') }}" class="btn btn-premium btn-lg">
                        <i class="bi bi-person-plus me-2"></i> Sign Up Now
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        Already have an account? Log In
                    </a>
                </div>
            </div>
        </div>
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
    
    /* Disabled button style for guests */
    .btn-premium:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    /* Modal styles */
    .modal-header.bg-premium {
        background: linear-gradient(135deg, #2a6e3f 0%, #1e522e 100%);
    }
    
    .benefits {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border-left: 4px solid #2a6e3f;
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
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Add to Cart button clicks for guests
    const guestAddButtons = document.querySelectorAll('.btn-premium[data-bs-toggle="modal"]');
    
    guestAddButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get product name from the nearest product card
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('h4').textContent;
            
            // Update modal content with product info
            const modalBody = document.querySelector('#signupModal .modal-body');
            const originalContent = modalBody.innerHTML;
            
            modalBody.innerHTML = `
                <div class="text-center mb-4">
                    <i class="bi bi-cart-plus display-1 text-premium mb-3"></i>
                    <h4>Sign Up to Add "${productName}"</h4>
                    <p class="text-muted">Create an account to add this item to your cart</p>
                </div>
                
                <div class="benefits mb-4">
                    <h6 class="mb-3">Get started in seconds:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Add products to cart</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Save favorite products</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Track your orders</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Faster checkout</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Exclusive offers</li>
                    </ul>
                </div>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('register') }}" class="btn btn-premium btn-lg">
                        <i class="bi bi-person-plus me-2"></i> Sign Up Free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                        Already have an account? Log In
                    </a>
                </div>
            `;
        });
    });
    
    // Reset modal content when modal is hidden
    document.getElementById('signupModal').addEventListener('hidden.bs.modal', function () {
        const modalBody = document.querySelector('#signupModal .modal-body');
        modalBody.innerHTML = `
            <div class="text-center mb-4">
                <i class="bi bi-cart-plus display-1 text-premium mb-3"></i>
                <h4>Create Your Account</h4>
                <p class="text-muted">You need to sign up to add items to your cart and make purchases</p>
            </div>
            
            <div class="benefits mb-4">
                <h6 class="mb-3">Benefits of signing up:</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Add products to cart</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Save favorite products</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Track your orders</li>
                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i> Faster checkout</li>
                    <li><i class="bi bi-check-circle text-success me-2"></i> Exclusive offers</li>
                </ul>
            </div>
            
            <div class="d-grid gap-2">
                <a href="{{ route('register') }}" class="btn btn-premium btn-lg">
                    <i class="bi bi-person-plus me-2"></i> Sign Up Now
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                    Already have an account? Log In
                </a>
            </div>
        `;
    });
});
</script>

@endsection