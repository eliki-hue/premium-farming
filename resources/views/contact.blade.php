@extends('layouts.app')

@section('title', 'Contact Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">
    <!-- Contact Hero -->
    <section class="contact-hero" style="
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070') center/cover;
        padding: 6rem 0;
        color: white;
        text-align: center;
    ">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
            <p class="lead mb-0">We're here to help you grow your farm successfully</p>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Branch Information -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <i class="bi bi-shop text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="card-title mb-3">Our Branches</h3>
                            <div class="text-start">
                                <div class="mb-3">
                                    <h5 class="text-primary mb-1">🏪 Turitu Branch</h5>
                                    <p class="mb-1 text-muted">Main Branch & Headquarters</p>
                                    <p class="mb-1">Along Thika-Gatundu Road</p>
                                    <p><strong>Hours:</strong> 8:00 AM - 6:00 PM (Mon-Sat)</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h5 class="text-primary mb-1">🏪 Githiga Branch</h5>
                                    <p class="mb-1 text-muted">Processing Plant</p>
                                    <p class="mb-1">Githiga Shopping Center</p>
                                    <p><strong>Hours:</strong> 8:00 AM - 6:00 PM (Mon-Sat)</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h5 class="text-primary mb-1">🏪 Ikinu Branch</h5>
                                    <p class="mb-1 text-muted">Latest Expansion</p>
                                    <p class="mb-1">Ikinu Town Center</p>
                                    <p><strong>Hours:</strong> 8:00 AM - 6:00 PM (Mon-Sat)</p>
                                </div>
                                
                                <div class="alert alert-warning mt-3 p-2">
                                    <small><i class="bi bi-info-circle me-1"></i> <strong>Note:</strong> All branches closed on Sundays</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <i class="bi bi-clock text-warning" style="font-size: 3rem;"></i>
                            </div>
                            <h3 class="card-title mb-3">Operating Hours</h3>
                            
                            <!-- Operating Hours Box -->
                            <div class="alert alert-info text-start mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-info-circle me-2 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-2">All Branches:</h6>
                                        <div class="mb-2">
                                            <strong>Monday - Saturday</strong><br>
                                            8:00 AM - 6:00 PM
                                        </div>
                                        <div class="mb-0">
                                            <strong>Sunday</strong><br>
                                            Closed
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-start">
                                <div class="mb-4">
                                    <h5 class="text-success mb-2">📞 Phone Numbers</h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-phone me-2 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold">0786 571 173</p>
                                            <small class="text-muted">Customer Service</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-phone me-2 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold">0708 488 688</p>
                                            <small class="text-muted">Sales & Orders</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-phone me-2 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold">0711 633 900</p>
                                            <small class="text-muted">Technical Support</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Operating Hours Info -->
                                <div class="mb-4">
                                    <h5 class="text-success mb-2">⏰ Service Hours</h5>
                                    <div class="small">
                                        <p class="mb-1"><strong>Phone Support:</strong> Mon-Sat, 8AM-6PM</p>
                                        <p class="mb-1"><strong>Email Support:</strong> 24/7 (Response within 24hrs)</p>
                                        <p class="mb-1"><strong>Delivery Services:</strong> Mon-Sat, 8AM-6PM</p>
                                        <p class="mb-0"><strong>Online Orders:</strong> Available 24/7</p>
                                    </div>
                                </div>

                                <div>
                                    <h5 class="text-success mb-2">🏦 Payment Details</h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-bank me-2 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold">Paybill: 247247</p>
                                            <small class="text-muted">M-Pesa Payment</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-hash me-2 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-bold">Account: 470470</p>
                                            <small class="text-muted">Premium Farming Feeds</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title mb-4 text-center">Send Us a Message</h3>
                            <form action="{{ route('contact.send') }}" method="POST">
                                @csrf
                                
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-3">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif
                                
                                @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mb-3">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif
                                
                                @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-3">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone') }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <select class="form-control" id="subject" name="subject" required>
                                        <option value="">Select Subject</option>
                                        <option value="product_inquiry" {{ old('subject') == 'product_inquiry' ? 'selected' : '' }}>Product Inquiry</option>
                                        <option value="order_status" {{ old('subject') == 'order_status' ? 'selected' : '' }}>Order Status</option>
                                        <option value="delivery_issue" {{ old('subject') == 'delivery_issue' ? 'selected' : '' }}>Delivery Issue</option>
                                        <option value="technical_support" {{ old('subject') == 'technical_support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" 
                                              required>{{ old('message') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-send me-2"></i> Send Message
                                </button>
                            </form>
                            
                            <div class="mt-4 text-center">
                                <p class="text-muted small">
                                    <i class="bi bi-clock me-1"></i>
                                    We respond within 24 hours
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3">Find Us</h2>
                <p class="text-muted">Visit any of our conveniently located branches</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">📍 Turitu Branch</h5>
                            <p class="card-text">Along Thika-Gatundu Road, opposite Turitu Market</p>
                            <div class="branch-hours mb-3 p-2 bg-light rounded">
                                <small><strong>Hours:</strong> Monday-Saturday, 8:00 AM - 6:00 PM</small><br>
                                <small><strong>Closed:</strong> Sunday & Public Holidays</small>
                            </div>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.032018745386!2d36.893577614458355!3d-1.090570099199527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f407c5f2e8b0f%3A0x9f9d3b5b5b5b5b5b!2sTuritu%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske" 
                                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">📍 Githiga Branch</h5>
                            <p class="card-text">Githiga Shopping Center, next to Githiga Police Station</p>
                            <div class="branch-hours mb-3 p-2 bg-light rounded">
                                <small><strong>Hours:</strong> Monday-Saturday, 8:00 AM - 6:00 PM</small><br>
                                <small><strong>Closed:</strong> Sunday & Public Holidays</small>
                            </div>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.129218754389!2d36.839268414458355!3d-1.0674640992121215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3b5b5b5b5b5b%3A0x9f9d3b5b5b5b5b5b!2sGithiga%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske" 
                                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">📍 Ikinu Branch</h5>
                            <p class="card-text">Ikinu Town Center, next to Ikinu Market</p>
                            <div class="branch-hours mb-3 p-2 bg-light rounded">
                                <small><strong>Hours:</strong> Monday-Saturday, 8:00 AM - 6:00 PM</small><br>
                                <small><strong>Closed:</strong> Sunday & Public Holidays</small>
                            </div>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.0747321272835!2d36.876447714458355!3d-1.0789991992059185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3b5b5b5b5b5b%3A0x9f9d3b5b5b5b5b5b!2sIkinu%2C%20Kenya!5e0!3m2!1sen!2ske!4v1648035456782!5m2!1sen!2ske" 
                                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 class="display-6 fw-bold mb-2">What Farmers Say</h2>
                    <p class="text-muted">Read reviews from our satisfied customers</p>
                </div>
                <div>
                    <!-- ADD THIS BUTTON TO GO TO REVIEWS PAGE -->
<a href="{{ route('reviews') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-chat-left-text me-2"></i> Write a Review
                    </a>
                </div>
            </div>
            
            <!-- Static Dummy Reviews -->
            <div class="row g-4">
                <!-- Review 1 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <span class="text-white fw-bold">J</span>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">James Kariuki</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>Dairy Farmer, Kiambu
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            
                            <p class="card-text">"The dairy meal increased my milk production by 30%. The delivery was on time and the customer service is excellent!"</p>
                            
                            <div class="mt-3">
                                <span class="badge bg-success">Dairy Farming</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Review 2 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <span class="text-white fw-bold">M</span>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">Mary Wanjiku</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>Poultry Farmer, Nairobi
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            
                            <p class="card-text">"My broilers gained weight faster with Premium feeds. The technical advice from their team helped me reduce mortality rates."</p>
                            
                            <div class="mt-3">
                                <span class="badge bg-warning text-dark">Poultry Farming</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Review 3 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <span class="text-white fw-bold">P</span>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">Peter Maina</h5>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>Pig Farmer, Thika
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-half text-warning"></i>
                            </div>
                            
                            <p class="card-text">"Quality feeds at affordable prices. The delivery service to my farm is reliable even during rainy seasons."</p>
                            
                            <div class="mt-3">
                                <span class="badge bg-danger">Pig Farming</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ADD THIS TEXT CENTERED WITH BUTTON -->
            <div class="text-center mt-5">
                <a href="{{ route('reviews') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-chat-left-text me-2"></i> View All Reviews & Add Your Own
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="text-muted">Quick answers to common questions</p>
            </div>
            
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            What are your operating hours?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            All our branches are open <strong>Monday to Saturday, 8:00 AM - 6:00 PM</strong>. 
                            We are closed on Sundays and public holidays. Online orders can be placed 24/7.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            What are your delivery hours?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We deliver <strong>Monday to Saturday, 8:00 AM - 6:00 PM</strong>. 
                            Orders placed after 3:00 PM are delivered the next business day.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Do you open on Sundays?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No, all our branches are <strong>closed on Sundays</strong> and public holidays. 
                            This allows our team to rest and prepare for the coming week.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            What payment methods do you accept?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            We accept M-Pesa (Paybill: 247247, Account: 470470), cash on delivery, and bank transfers.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Do you offer bulk discounts?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes, we offer special discounts for orders above 50 bags. 
                            Contact our sales team during business hours for customized pricing.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .contact-hero {
        background-size: cover;
        background-position: center;
    }
    
    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(42, 110, 63, 0.1);
        color: #2a6e3f;
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(42, 110, 63, 0.25);
    }
    
    .branch-hours {
        background: linear-gradient(135deg, #fff8e1, #fff3cd);
        border-left: 4px solid #f57c00;
    }

    .operating-hours-box {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        border-radius: 10px;
        padding: 15px;
        margin: 15px 0;
    }

    .business-hours {
        font-size: 0.9rem;
    }

    .business-hours strong {
        color: #2a6e3f;
    }

    .closed-day {
        color: #dc3545;
        font-weight: bold;
    }
</style>
@endsection