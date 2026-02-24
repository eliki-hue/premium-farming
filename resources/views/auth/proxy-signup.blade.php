@extends('layouts.app')

@section('title', 'Sign Up - Premium Farming Feeds')

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <!-- Company Header -->
                <div class="auth-header">
                    <div class="auth-logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds">
                    </div>
                    <h1>Premium Farming Feeds</h1>
                    <p class="company-tagline">Join our community of successful farmers</p>
                    <div class="welcome-message">
                        <i class="bi bi-arrow-right-circle-fill me-1"></i>
                        Create your account to access premium feeds & expert advice
                        <i class="bi bi-arrow-left-circle-fill ms-1"></i>
                    </div>
                </div>

                <!-- Company Benefits -->
                <div class="benefits-box mb-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="benefit-item">
                                <i class="bi bi-truck"></i>
                                <span>Free Delivery</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="benefit-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Quality Guarantee</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="benefit-item">
                                <i class="bi bi-headset"></i>
                                <span>Expert Support</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="benefit-item">
                                <i class="bi bi-percent"></i>
                                <span>Member Discounts</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                <div class="alert alert-danger">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <small>{{ $error }}</small><br>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Success --}}
                @if(session('success'))
                <div class="alert alert-success">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
                @endif

                {{-- PROXY SIGNUP FORM --}}
                <form method="POST" action="{{ url('/proxy/signup') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="bi bi-person-circle me-1"></i> Username
                        </label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-control-custom @error('username') is-invalid @enderror" 
                            placeholder="Choose a username"
                            required
                            autofocus
                            value="{{ old('username') }}"
                        >
                        @error('username')
                        <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i> Email Address
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control-custom @error('email') is-invalid @enderror" 
                            placeholder="you@example.com"
                            required
                            value="{{ old('email') }}"
                        >
                        @error('email')
                        <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i> Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control-custom @error('password') is-invalid @enderror" 
                                placeholder="Create a strong password"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <div class="password-strength mt-1" id="passwordStrength"></div>
                        @error('password')
                        <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill me-1"></i> Confirm Password
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control-custom" 
                                placeholder="Re-enter your password"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePasswordConfirm()">
                                <i class="bi bi-eye" id="toggleIconConfirm"></i>
                            </button>
                        </div>
                        <div class="password-match mt-1" id="passwordMatch"></div>
                    </div>

                    <button type="submit" class="btn-auth" id="submitBtn">
                        <i class="bi bi-person-plus me-2"></i>
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="auth-footer">
                    <p>Already have an account? 
                        <a href="/login" class="login-link">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Sign in here
                        </a>
                    </p>
                </div>

                <!-- Company Footer -->
                <div class="company-footer text-center mt-3 pt-3 border-top">
                    <p class="small text-muted mb-0">
                        <i class="bi bi-shield-lock me-1"></i>
                        Your data is securely protected • Premium Farming Feeds © {{ date('Y') }}
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection