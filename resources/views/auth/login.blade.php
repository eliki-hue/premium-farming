@extends('layouts.app')

@section('title', 'Login - Premium Farming Feeds')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background-color: #f5f5f0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <!-- Login Card -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body p-5">
                        
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <div class="auth-logo">
                                <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds" class="rounded-circle">
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-center fw-bold mb-2" style="color: #1a1a1a; font-size: 24px;">
                            Premium Farming Feeds
                        </h2>
                        <p class="text-center text-muted mb-4" style="font-size: 14px;">
                            Welcome Back
                        </p>

                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small>Invalid email or password</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Success Messages -->
                        @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <small>{{ session('status') }}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="mb-3">
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
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" style="color: #1a1a1a; font-size: 14px;">
                                    Password
                                </label>
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    class="form-control" 
                                    placeholder="••••••••"
                                    required
                                    style="padding: 12px 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: #fafafa;">
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" style="cursor: pointer;">
                                    <label class="form-check-label" for="remember" style="font-size: 14px; cursor: pointer; color: #6b6b6b;">
                                        Remember me
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #2d6e4f; font-size: 14px; font-weight: 500;">
                                    Forgot Password?
                                </a>
                            </div>
                            
                            <!-- Sign In Button -->
                            <button 
                                type="submit" 
                                class="btn btn-lg w-100 fw-semibold text-white"
                                style="padding: 14px; border-radius: 8px; background-color: #2d6e4f; border: none;">
                                Sign In
                            </button>
                        </form>
                        
                        <!-- Sign Up Link -->
                        <div class="text-center mt-4">
                            <p class="mb-0" style="color: #6b6b6b; font-size: 14px;">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #2d6e4f;">
                                    Sign up
                                </a>
                            </p>
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
        text-decoration: underline !important;
    }

    /* Checkbox styling */
    .form-check-input:checked {
        background-color: #2d6e4f;
        border-color: #2d6e4f;
    }

    .form-check-input:focus {
        border-color: #2d6e4f;
        box-shadow: 0 0 0 0.2rem rgba(45, 110, 79, 0.15);
    }
</style>
@endsection