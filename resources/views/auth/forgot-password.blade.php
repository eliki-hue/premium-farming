@extends('layouts.app')

@section('title', 'Forgot Password - Premium Farming Feeds')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f5f5f0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <!-- Forgot Password Card -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-5">
                        
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <div class="auth-logo">
                                <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="rounded-circle">
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-center fw-bold mb-3" style="color: #1a1a1a; font-size: 22px;">
                            Reset Password
                        </h2>
                        <p class="text-center mb-4" style="font-size: 14px; line-height: 1.6; color: #6b6b6b;">
                            Enter your email address and we'll send you a link to reset your password.
                        </p>

                        <!-- Success Messages -->
                        @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <small>{{ session('status') }}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small>{{ $errors->first() }}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Forgot Password Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold" style="color: #1a1a1a; font-size: 14px;">
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    class="form-control" 
                                    placeholder="you@example.com"
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    style="padding: 12px 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: #fafafa;">
                                @error('email')
                                <small class="text-danger d-block mt-2" style="font-size: 13px;">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <button 
                                type="submit" 
                                class="btn btn-lg w-100 fw-semibold text-white mb-3"
                                style="padding: 14px; border-radius: 8px; background-color: #2d6e4f; border: none;">
                                Send Reset Link
                            </button>
                        </form>
                        
                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none d-flex align-items-center justify-content-center" style="color: #6b6b6b; font-size: 14px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Logo styling */
    .auth-logo img {
        width: 64px;
        height: 64px;
        object-fit: cover;
    }

    /* Input focus styles */
    .form-control:focus {
        border-color: #2d6e4f !important;
        box-shadow: 0 0 0 0.2rem rgba(45, 110, 79, 0.15) !important;
        background-color: #fff !important;
    }

    /* Button hover effect */
    .btn:hover {
        background-color: #245a3f !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(45, 110, 79, 0.2);
        transition: all 0.2s ease;
    }

    /* Card shadow on hover */
    .card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
        transition: box-shadow 0.3s ease;
    }

    /* Link hover effect */
    a:hover {
        color: #2d6e4f !important;
        text-decoration: underline !important;
    }
</style>
@endsection