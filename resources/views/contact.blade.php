@extends('layouts.app')

@section('title', 'Contact Us | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Contact Hero -->
    <section class="contact-hero" style="
        background: url('{{ asset('images/conta.jpeg') }}') center/cover no-repeat;
        background-attachment: fixed;
        padding: 6rem 0 4rem;
        color: white;
        position: relative;
    ">
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.5);"></div>
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown" 
                        style="font-family: 'Cormorant Garamond', serif;">
                        Contact Us
                    </h1>
                    <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s">
                        We're here to help with all your farming needs
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Reach Us Section - Modern Styled -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);" id="contactInfo">
        <div class="container">
            <div class="text-center mb-5">
                <div class="d-inline-block mb-3">
                    <div style="width: 60px; height: 3px; background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); margin: 0 auto;"></div>
                </div>
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                    How to Reach Us
                </h2>
                <p class="text-muted">Multiple channels for your convenience</p>
            </div>
            
            <!-- Top Row: Contact Details + Branches -->
            <div class="row g-4 mb-4">
                <!-- Contact Details Card -->
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <div class="icon-wrapper me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-telephone text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--navy-green); font-size: 1.3rem;">Contact Details</h3>
                                    <small class="text-muted">Reach out to us directly</small>
                                </div>
                            </div>
                            
                            <!-- Phone Numbers -->
                            <div class="mb-4">
                                <h5 class="text-green mb-3 fw-bold"><i class="bi bi-telephone-fill me-2"></i>Phone Numbers</h5>
                                @foreach([
                                    ['number' => '0700 680 017', 'label' => 'Customer Service', 'icon' => 'bi-headset'],
                                    ['number' => '0708 488 688', 'label' => 'Sales & Orders', 'icon' => 'bi-cart'],
                                    ['number' => '0711 633 900', 'label' => 'Technical Support', 'icon' => 'bi-tools']
                                ] as $contact)
                                <div class="contact-item d-flex align-items-center mb-3 p-3 bg-white rounded-3 shadow-sm">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(56, 161, 105, 0.15);">
                                            <i class="bi {{ $contact['icon'] }} text-green fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold fs-5 mb-1 text-dark">{{ $contact['number'] }}</div>
                                        <div class="text-muted small">{{ $contact['label'] }}</div>
                                    </div>
                                    <div>
                                        <a href="tel:+254{{ str_replace(' ', '', substr($contact['number'], 1)) }}" class="btn-call">
                                            <i class="bi bi-telephone-outbound-fill fs-5" style="color: var(--primary-green);"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Service Hours -->
                            <div>
                                <h5 class="text-green mb-3 fw-bold"><i class="bi bi-clock-history me-2"></i>Service Hours</h5>
                                <div class="row g-2">
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                            <div class="me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(56, 161, 105, 0.15);">
                                                    <i class="bi bi-telephone text-green"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Phone Support</div>
                                                <small class="text-muted">Monday - Saturday: 8:00 AM - 6:00 PM</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                            <div class="me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(56, 161, 105, 0.15);">
                                                    <i class="bi bi-envelope text-green"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Email Support</div>
                                                <small class="text-muted">Response within 24 hours</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                                            <div class="me-3">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(56, 161, 105, 0.15);">
                                                    <i class="bi bi-truck text-green"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Delivery Service</div>
                                                <small class="text-muted">Monday - Saturday: 8:00 AM - 6:00 PM</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branches Card -->
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <div class="icon-wrapper me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-shop-window text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--navy-green); font-size: 1.3rem;">Our Branches</h3>
                                    <small class="text-muted">Visit us at any location</small>
                                </div>
                            </div>
                            
                            @foreach([
                                ['name' => 'Turitu Branch', 'address' => 'Along Thika-Gatundu Road', 'description' => 'Main Headquarters', 'icon' => 'bi-building'],
                                ['name' => 'Githiga Branch', 'address' => 'Githiga Shopping Center', 'description' => 'Processing Plant', 'icon' => 'bi-factory'],
                                ['name' => 'Ikinu Branch', 'address' => 'Ikinu Town Center', 'description' => 'Latest Branch', 'icon' => 'bi-shop']
                            ] as $branch)
                            <div class="branch-item mb-4 p-3 bg-white rounded-3 shadow-sm">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(56, 161, 105, 0.15);">
                                            <i class="bi {{ $branch['icon'] }} text-green fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="text-green mb-1 fw-bold">{{ $branch['name'] }}</h5>
                                        <p class="text-muted small mb-2">{{ $branch['description'] }}</p>
                                        <p class="mb-2"><i class="bi bi-geo-alt-fill text-green me-2"></i>{{ $branch['address'] }}</p>
                                        <div class="hours-badge d-inline-block px-3 py-1 rounded-pill" style="background: rgba(56, 161, 105, 0.1); color: var(--secondary-green);">
                                            <i class="bi bi-clock me-1"></i> Open: 8AM - 6PM
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="alert mt-3 p-3 rounded-3 d-flex align-items-center" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b;">
                                <i class="bi bi-info-circle-fill fs-4 text-warning me-3"></i>
                                <div class="small"><strong>Note:</strong> All branches are closed on Sundays</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row: Send Message + Payment Details -->
            <div class="row g-4">
                <!-- Send Message Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg premium-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <div class="icon-wrapper me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-chat-left-text text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--navy-green); font-size: 1.3rem;">Send Message</h3>
                                    <small class="text-muted">We'll get back to you shortly</small>
                                </div>
                            </div>
                            
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-exclamation-circle-fill fs-4 me-2"></i>
                                    <div><strong>Please fix errors:</strong>
                                        <ul class="mb-0 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form action="{{ route('contact.send') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customer_name" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-person me-1"></i>Your Name *
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_phone" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-phone me-1"></i>Phone Number *
                                        </label>
                                        <input type="tel" class="form-control form-control-lg" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_email" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-envelope me-1"></i>Email Address
                                        </label>
                                        <input type="email" class="form-control form-control-lg" id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="customer_location" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-geo-alt me-1"></i>Location
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="customer_location" name="customer_location" value="{{ old('customer_location') }}" placeholder="e.g., Kiambu">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="farm_type" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-tree me-1"></i>Farm Type
                                        </label>
                                        <select class="form-select form-select-lg" id="farm_type" name="farm_type">
                                            <option value="">Select Farm Type</option>
                                            <option value="Dairy" {{ old('farm_type') == 'Dairy' ? 'selected' : '' }}>🐄 Dairy Farming</option>
                                            <option value="Poultry" {{ old('farm_type') == 'Poultry' ? 'selected' : '' }}>🐔 Poultry Farming</option>
                                            <option value="Pig" {{ old('farm_type') == 'Pig' ? 'selected' : '' }}>🐷 Pig Farming</option>
                                            <option value="Cattle" {{ old('farm_type') == 'Cattle' ? 'selected' : '' }}>🐂 Cattle Rearing</option>
                                            <option value="Goat" {{ old('farm_type') == 'Goat' ? 'selected' : '' }}>🐐 Goat Farming</option>
                                            <option value="Rabbit" {{ old('farm_type') == 'Rabbit' ? 'selected' : '' }}>🐇 Rabbit Farming</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="rating" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-star me-1"></i>Rating
                                        </label>
                                        <select class="form-select form-select-lg" id="rating" name="rating">
                                            <option value="5">★★★★★ (5/5) - Excellent</option>
                                            <option value="4">★★★★☆ (4/5) - Very Good</option>
                                            <option value="3">★★★☆☆ (3/5) - Good</option>
                                            <option value="2">★★☆☆☆ (2/5) - Fair</option>
                                            <option value="1">★☆☆☆☆ (1/5) - Poor</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="review" class="form-label fw-bold" style="color: var(--navy-green);">
                                            <i class="bi bi-chat-left-text me-1"></i>Your Message / Review *
                                        </label>
                                        <textarea class="form-control" id="review" name="review" rows="4" placeholder="Share your experience or ask a question..." required>{{ old('review') }}</textarea>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="submit" class="btn w-100 btn-send">
                                            <i class="bi bi-send-fill me-2"></i> Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="mt-4 text-center">
                                <div class="alert p-3 rounded-3 d-flex align-items-center justify-content-center" style="background: rgba(14, 165, 233, 0.1);">
                                    <i class="bi bi-lightning-charge-fill text-primary fs-4 me-2"></i>
                                    <div><span class="fw-bold">Fast Response:</span> <span class="text-muted">We respond within 24 hours</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Card -->
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                                <div class="icon-wrapper me-3" style="width: 55px; height: 55px; background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-credit-card text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0" style="color: var(--navy-green); font-size: 1.3rem;">Payment Details</h3>
                                    <small class="text-muted">Secure M-Pesa payments</small>
                                </div>
                            </div>
                            
                            <div class="payment-card p-4 rounded-3 text-center mb-4" style="background: linear-gradient(135deg, #f8f9fa, #fff); border: 1px solid rgba(56, 161, 105, 0.2);">
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 70px; height: 70px; background: rgba(56, 161, 105, 0.15);">
                                            <i class="bi bi-phone text-green fs-1"></i>
                                        </div>
                                        <div class="fw-bold text-muted small text-uppercase">PAYBILL</div>
                                        <div class="display-6 fw-bold text-green">400200</div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 70px; height: 70px; background: rgba(56, 161, 105, 0.15);">
                                            <i class="bi bi-hash text-green fs-1"></i>
                                        </div>
                                        <div class="fw-bold text-muted small text-uppercase">ACCOUNT</div>
                                        <div class="display-6 fw-bold text-green">4003901</div>
                                    </div>
                                </div>
                                <div class="text-center mt-2">
                                    <div class="fw-bold fs-6" style="color: var(--navy-green);">Premium Farming Feeds Ltd</div>
                                    <small class="text-muted">All payments are securely processed via M-Pesa</small>
                                </div>
                            </div>
                            
                            <!-- Payment Instructions -->
                            <div>
                                <h5 class="text-green mb-3 fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Payment Instructions</h5>
                                <div class="instruction-item d-flex align-items-start mb-2 p-2 rounded">
                                    <i class="bi bi-1-circle-fill text-green fs-5 me-2"></i>
                                    <small>Go to M-Pesa menu on your phone</small>
                                </div>
                                <div class="instruction-item d-flex align-items-start mb-2 p-2 rounded">
                                    <i class="bi bi-2-circle-fill text-green fs-5 me-2"></i>
                                    <small>Select <strong>"Pay Bill"</strong> option</small>
                                </div>
                                <div class="instruction-item d-flex align-items-start mb-2 p-2 rounded">
                                    <i class="bi bi-3-circle-fill text-green fs-5 me-2"></i>
                                    <small>Enter Business No: <strong class="text-green">400200</strong></small>
                                </div>
                                <div class="instruction-item d-flex align-items-start mb-2 p-2 rounded">
                                    <i class="bi bi-4-circle-fill text-green fs-5 me-2"></i>
                                    <small>Enter Account No: <strong class="text-green">4003901</strong></small>
                                </div>
                                <div class="instruction-item d-flex align-items-start mb-2 p-2 rounded">
                                    <i class="bi bi-5-circle-fill text-green fs-5 me-2"></i>
                                    <small>Enter amount and complete transaction</small>
                                </div>
                                <div class="instruction-item d-flex align-items-start p-2 rounded">
                                    <i class="bi bi-6-circle-fill text-green fs-5 me-2"></i>
                                    <small>You'll receive confirmation via SMS</small>
                                </div>
                            </div>
                            
                            <!-- Security Badge -->
                            <div class="mt-4 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="bi bi-shield-lock-fill text-success fs-4"></i>
                                    <small class="text-muted">100% Secure Transactions</small>
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #1a4d2a, #0d2e1a); color: white;">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif;">Need Help With Your Farm?</h2>
            <p class="lead mb-4 opacity-75">Contact us today for expert advice and premium feeds</p>
            <a href="tel:+254786571173" class="btn btn-cta">
                <i class="bi bi-telephone-outbound-fill me-2"></i> Call Now: 0700 680 017
            </a>
        </div>
    </section>
</div>

<style>
    .contact-hero {
        position: relative;
        overflow: hidden;
    }
    
    .premium-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(42, 110, 63, 0.1);
        height: 100%;
        background: white;
    }
    
    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    
    .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    .premium-card:hover .icon-wrapper {
        transform: scale(1.05);
    }
    
    .contact-item, .branch-item {
        transition: all 0.3s ease;
    }
    
    .contact-item:hover, .branch-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    
    .btn-call {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        background: rgba(56, 161, 105, 0.1);
    }
    
    .btn-call:hover {
        background: var(--primary-green);
        transform: scale(1.1);
    }
    
    .btn-call:hover i {
        color: white !important;
    }
    
    .btn-send {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        padding: 12px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(56, 161, 105, 0.3);
        color: white;
    }
    
    .btn-cta {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        color: white;
    }
    
    .instruction-item {
        transition: all 0.3s ease;
    }
    
    .instruction-item:hover {
        background: rgba(56, 161, 105, 0.05);
        transform: translateX(5px);
    }
    
    .form-control, .form-select {
        border: 1px solid rgba(42, 110, 63, 0.2);
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(56, 161, 105, 0.25);
    }
    
    .text-green {
        color: var(--primary-green) !important;
    }
    
    @media (max-width: 768px) {
        .contact-hero {
            padding: 4rem 0 3rem;
        }
        .display-4 {
            font-size: 2rem;
        }
        .display-5 {
            font-size: 1.8rem;
        }
        .contact-item, .branch-item {
            flex-wrap: wrap;
            text-align: center;
            justify-content: center;
        }
    }
</style>

<script>
(function(){
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
@endsection