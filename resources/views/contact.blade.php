{{-- contact.blade.php --}}
@extends('layouts.app')

@section('title', 'Contact Us | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Contact Hero -->
    <section class="contact-hero" style="
        background: var(--gradient-dark-green),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070') center/cover;
        padding: 6rem 0 4rem;
        color: white;
        position: relative;
        overflow: hidden;
    ">
        <div class="position-absolute top-0 end-0 w-50 h-100" style="
            background: linear-gradient(45deg, transparent 50%, rgba(212, 175, 55, 0.1) 50%);
        "></div>
        
        <div class="container position-relative z-1">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown" 
                        style="font-family: 'Cormorant Garamond', serif;">
                        Contact Premium Farming Feeds
                    </h1>
                    <p class="lead mb-0 animate__animated animate__fadeInUp animate__delay-1s" 
                       style="font-size: 1.2rem;">
                        Expert agricultural support and premium quality feeds
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5 bg-light" id="contactInfo">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                    How to Reach Us
                </h2>
                <p class="text-muted">
                    Multiple channels for your convenience
                </p>
            </div>
            
            <div class="row g-4">
                <!-- Contact Details -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="icon-wrapper mx-auto mb-3" style="
                                width: 70px;
                                height: 70px;
                                background: var(--gradient-green);
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="bi bi-telephone text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <h3 class="card-title text-center mb-0" style="font-size: 1.3rem; color: var(--navy-green);">
                                Contact Details
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            <!-- Phone Numbers -->
                            <div class="mb-4">
                                <h5 class="text-green mb-3 fw-bold">
                                    <i class="bi bi-telephone me-2"></i>Phone Numbers
                                </h5>
                                @foreach([
                                    ['number' => '0786 571 173', 'label' => 'Customer Service'],
                                    ['number' => '0708 488 688', 'label' => 'Sales & Orders'],
                                    ['number' => '0711 633 900', 'label' => 'Technical Support']
                                ] as $contact)
                                <div class="contact-item d-flex align-items-center mb-3 p-3 border rounded-3">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 45px; height: 45px; background: rgba(56, 161, 105, 0.1); border: 2px solid var(--primary-green);">
                                            <i class="bi bi-telephone text-green"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold fs-5 mb-1 text-dark">{{ $contact['number'] }}</div>
                                        <div class="text-muted small">{{ $contact['label'] }}</div>
                                    </div>
                                    <div>
                                        <a href="tel:+254{{ str_replace(' ', '', substr($contact['number'], 1)) }}" 
                                           class="btn btn-sm" style="background: var(--gradient-green); color: white;">
                                            <i class="bi bi-telephone-outbound"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Payment Details -->
                            <div class="mb-4">
                                <h5 class="text-green mb-3 fw-bold">
                                    <i class="bi bi-credit-card me-2"></i>Payment Details
                                </h5>
                                <div class="payment-card p-3 border rounded-3">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <i class="bi bi-phone text-green fs-3 d-block mb-2"></i>
                                            <div class="fw-bold">Paybill</div>
                                            <div class="fs-4 fw-bold text-green">247247</div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <i class="bi bi-hash text-green fs-3 d-block mb-2"></i>
                                            <div class="fw-bold">Account</div>
                                            <div class="fs-4 fw-bold text-green">470470</div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted">Premium Farming Feeds</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Hours -->
                            <div>
                                <h5 class="text-green mb-3 fw-bold">
                                    <i class="bi bi-clock me-2"></i>Service Hours
                                </h5>
                                <div class="row g-2">
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center p-2 border rounded-2">
                                            <i class="bi bi-telephone text-green me-3"></i>
                                            <div>
                                                <div class="fw-bold">Phone Support</div>
                                                <small class="text-muted">Mon-Sat, 8AM-6PM</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center p-2 border rounded-2">
                                            <i class="bi bi-envelope text-green me-3"></i>
                                            <div>
                                                <div class="fw-bold">Email Support</div>
                                                <small class="text-muted">Response within 24hrs</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-2 border rounded-2">
                                            <i class="bi bi-truck text-green me-3"></i>
                                            <div>
                                                <div class="fw-bold">Delivery</div>
                                                <small class="text-muted">Mon-Sat, 8AM-6PM</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branches -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="icon-wrapper mx-auto mb-3" style="
                                width: 70px;
                                height: 70px;
                                background: var(--gradient-green);
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="bi bi-shop-window text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <h3 class="card-title text-center mb-0" style="font-size: 1.3rem; color: var(--navy-green);">
                                Our Branches
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            @foreach([
                                [
                                    'name' => 'Turitu Branch',
                                    'address' => 'Along Thika-Gatundu Road',
                                    'description' => 'Main Headquarters'
                                ],
                                [
                                    'name' => 'Githiga Branch',
                                    'address' => 'Githiga Shopping Center',
                                    'description' => 'Processing Plant'
                                ],
                                [
                                    'name' => 'Ikinu Branch',
                                    'address' => 'Ikinu Town Center',
                                    'description' => 'Latest Branch'
                                ]
                            ] as $branch)
                            <div class="branch-item mb-4 p-3 border rounded-3">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                             style="width: 45px; height: 45px; border: 2px solid var(--primary-green);">
                                            <i class="bi bi-geo-alt text-green"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="text-green mb-1 fw-bold">{{ $branch['name'] }}</h5>
                                        <p class="text-muted small mb-2">{{ $branch['description'] }}</p>
                                        <p class="mb-2">
                                            <i class="bi bi-geo-alt me-1 text-green"></i>
                                            {{ $branch['address'] }}
                                        </p>
                                        <div class="hours-badge rounded-pill px-3 py-1 d-inline-block" style="background: rgba(56, 161, 105, 0.1); color: var(--secondary-green);">
                                            <i class="bi bi-clock me-1"></i>
                                            <span>8AM-6PM</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="alert alert-warning mt-3 p-3 border-0" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b !important;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle fs-5 text-warning me-3"></i>
                                    <div>
                                        <strong>Note:</strong> Closed on Sundays & Public Holidays
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-lg premium-card">
                        <div class="card-header border-0 bg-transparent pt-4">
                            <div class="icon-wrapper mx-auto mb-3" style="
                                width: 70px;
                                height: 70px;
                                background: var(--gradient-green);
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="bi bi-chat-left-text text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <h3 class="card-title text-center mb-0" style="font-size: 1.3rem; color: var(--navy-green);">
                                Send Message
                            </h3>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('contact.send') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4" style="border-left: 4px solid var(--secondary-green) !important;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill fs-4 me-2" style="color: var(--secondary-green);"></i>
                                        <div>{{ session('success') }}</div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif
                                
                                @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle-fill fs-4 me-2"></i>
                                        <div>
                                            <strong>Please fix errors:</strong>
                                            <ul class="mb-0 mt-1">
                                                @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold" style="color: var(--navy-green);">
                                        <i class="bi bi-person me-1"></i>Your Name *
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" required style="border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold" style="color: var(--navy-green);">
                                        <i class="bi bi-phone me-1"></i>Phone Number *
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone') }}" required style="border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold" style="color: var(--navy-green);">
                                        <i class="bi bi-envelope me-1"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" style="border-color: rgba(42, 110, 63, 0.2);">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-bold" style="color: var(--navy-green);">
                                        <i class="bi bi-tag me-1"></i>Subject *
                                    </label>
                                    <select class="form-select" id="subject" name="subject" required style="border-color: rgba(42, 110, 63, 0.2);">
                                        <option value="">Select Subject</option>
                                        <option value="product_inquiry" {{ old('subject') == 'product_inquiry' ? 'selected' : '' }}>Product Inquiry</option>
                                        <option value="order_status" {{ old('subject') == 'order_status' ? 'selected' : '' }}>Order Status</option>
                                        <option value="technical_support" {{ old('subject') == 'technical_support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-bold" style="color: var(--navy-green);">
                                        <i class="bi bi-chat-left-text me-1"></i>Message *
                                    </label>
                                    <textarea class="form-control" id="message" name="message" 
                                              rows="4" required style="border-color: rgba(42, 110, 63, 0.2);">{{ old('message') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn w-100" style="background: var(--gradient-green); color: white;">
                                    <i class="bi bi-send-fill me-2"></i> Send Message
                                </button>
                            </form>
                            
                            <div class="mt-4 text-center">
                                <div class="alert p-3" style="background: rgba(14, 165, 233, 0.1); border-left: 4px solid #0ea5e9 !important;">
                                    <i class="bi bi-lightning-charge-fill text-green me-2"></i>
                                    <span class="fw-bold">Fast Response:</span>
                                    <span class="text-muted ms-1">We respond within 24 hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5 bg-white" id="mapSection">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                    Find Our Locations
                </h2>
                <p class="text-muted">
                    Visit any of our conveniently located branches
                </p>
            </div>
            
            <div class="row g-4">
                @foreach([
                    [
                        'name' => 'Turitu Branch',
                        'address' => 'Along Thika-Gatundu Road, opposite Turitu Market',
                        'coords' => '!1m18!1m12!1m3!1d3989.032018745386!2d36.893577614458355!3d-1.090570099199527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f407c5f2e8b0f%3A0x9f9d3b5b5b5b5b5b!2sTuritu%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske',
                        'color' => 'green'
                    ],
                    [
                        'name' => 'Githiga Branch',
                        'address' => 'Githiga Shopping Center, next to Githiga Police Station',
                        'coords' => '!1m18!1m12!1m3!1d3989.129218754389!2d36.839268414458355!3d-1.0674640992121215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3b5b5b5b5b5b%3A0x9f9d3b5b5b5b5b5b!2sGithiga%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske',
                        'color' => 'green'
                    ],
                    [
                        'name' => 'Ikinu Branch',
                        'address' => 'Ikinu Town Center, next to Ikinu Market',
                        'coords' => '!1m18!1m12!1m3!1d3989.0747321272835!2d36.876447714458355!3d-1.0789991992059185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3b5b5b5b5b5b%3A0x9f9d3b5b5b5b5b5b!2sIkinu%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske',
                        'color' => 'green'
                    ]
                ] as $branch)
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm premium-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-4">
                                <div class="me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px; background: rgba(56, 161, 105, 0.1); border: 2px solid var(--primary-green);">
                                        <i class="bi bi-geo-alt-fill text-green"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="text-green mb-2 fw-bold">{{ $branch['name'] }}</h5>
                                    <p class="text-muted small">{{ $branch['address'] }}</p>
                                </div>
                            </div>
                            
                            <div class="branch-hours mb-4 p-3 rounded-3 bg-light">
                                <div class="row text-center">
                                    <div class="col-6">
                                        <i class="bi bi-calendar-check text-green d-block fs-4 mb-2"></i>
                                        <div class="small fw-bold">Mon-Sat</div>
                                        <div class="small">8AM-6PM</div>
                                    </div>
                                    <div class="col-6">
                                        <i class="bi bi-calendar-x text-danger d-block fs-4 mb-2"></i>
                                        <div class="small fw-bold">Sunday</div>
                                        <div class="small">Closed</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ratio ratio-16x9 border rounded-3 overflow-hidden mb-3">
                                <iframe src="https://www.google.com/maps/embed?pb={{ $branch['coords'] }}" 
                                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                            
                            <a href="https://maps.google.com/?q={{ urlencode($branch['address']) }}" 
                               target="_blank" class="btn btn-outline-success w-100" style="border-color: var(--primary-green); color: var(--primary-green);">
                                <i class="bi bi-arrow-up-right-square me-2"></i> Get Directions
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif; color: var(--navy-green);">
                    Frequently Asked Questions
                </h2>
                <p class="text-muted">
                    Quick answers to common questions
                </p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach([
                            [
                                'question' => 'What are your operating hours?',
                                'answer' => 'Our branches are open Monday to Saturday, 8:00 AM - 6:00 PM. We are closed on Sundays and public holidays.'
                            ],
                            [
                                'question' => 'What payment methods do you accept?',
                                'answer' => 'We accept M-Pesa (Paybill: 247247, Account: 470470), cash on delivery, and bank transfers.'
                            ],
                            [
                                'question' => 'Do you offer delivery?',
                                'answer' => 'Yes, we deliver Monday to Saturday, 8:00 AM - 6:00 PM within our service areas.'
                            ],
                            [
                                'question' => 'Can I get technical advice for my farm?',
                                'answer' => 'Yes, our technical support team is available to provide expert advice for your farming needs.'
                            ]
                        ] as $index => $faq)
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed px-4 py-3 fw-bold" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}"
                                        style="color: var(--navy-green);">
                                    <i class="bi bi-question-circle text-green me-3"></i>
                                    {{ $faq['question'] }}
                                </button>
                            </h2>
                            <div id="faq{{ $index }}" class="accordion-collapse collapse" 
                                 data-bs-parent="#faqAccordion">
                                <div class="accordion-body px-4 py-3">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5" style="background: var(--gradient-dark-green); color: white;">
        <div class="container">
            <div class="row align-items-center text-center text-lg-start">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h2 class="display-6 fw-bold mb-3" style="font-family: 'Cormorant Garamond', serif;">
                        Need Help With Your Farm?
                    </h2>
                    <p class="lead mb-0 opacity-75">
                        Contact us today for expert advice and premium feeds
                    </p>
                </div>
                <div class="col-lg-4">
                    <a href="tel:+254786571173" class="btn btn-lg w-100" style="background: var(--gradient-green); color: white;">
                        <i class="bi bi-telephone-outbound-fill me-2"></i> Call Now
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .contact-hero {
        position: relative;
        overflow: hidden;
    }
    
    .premium-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(42, 110, 63, 0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .premium-card .card-body {
        flex: 1;
    }
    
    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(42, 110, 63, 0.15) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
        border: none;
        font-weight: 600;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(42, 110, 63, 0.3);
    }
    
    .icon-wrapper {
        transition: all 0.3s ease;
    }
    
    .premium-card:hover .icon-wrapper {
        transform: scale(1.05);
    }
    
    .contact-item {
        transition: all 0.3s ease;
    }
    
    .contact-item:hover {
        transform: translateX(3px);
    }
    
    .branch-item {
        transition: all 0.3s ease;
    }
    
    .branch-item:hover {
        transform: translateY(-2px);
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(56, 161, 105, 0.1);
        color: var(--primary-green);
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(56, 161, 105, 0.25);
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
            font-size: 1.5rem;
        }
        
        .display-6 {
            font-size: 1.3rem;
        }
    }
</style>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endsection