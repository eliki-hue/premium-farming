@extends('layouts.app')

@section('title', 'Thank You for Your Review - Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24 bg-gray-50">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body py-5 px-4">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        
                        <h1 class="display-6 fw-bold text-dark mb-3">Thank You!</h1>
                        
                        <p class="lead text-muted mb-4">
                            Your review has been submitted successfully. 
                            Our team will review it and publish it within 24 hours.
                        </p>
                        
                        <div class="alert alert-info text-start mb-4">
                            <h5><i class="bi bi-info-circle me-2"></i> What happens next?</h5>
                            <ul class="mb-0">
                                <li>We review all submissions to ensure quality</li>
                                <li>You'll receive an email when your review is published</li>
                                <li>Featured reviews may be highlighted on our homepage</li>
                                <li>Your feedback helps us improve our products</li>
                            </ul>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                            <a href="{{ route('reviews.index') }}" class="btn btn-primary">
                                <i class="bi bi-chat-left-text me-2"></i> View All Reviews
                            </a>
                            <a href="{{ route('products') }}" class="btn btn-outline-primary">
                                <i class="bi bi-cart me-2"></i> Continue Shopping
                            </a>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="bi bi-house me-2"></i> Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection