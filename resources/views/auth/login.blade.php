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

                        <!-- Company Name & Welcome Message -->
                        <h2 class="text-center fw-bold mb-2" style="color: #1a1a1a; font-size: 24px;">
                            Premium Farming Feeds
                        </h2>
                        <p class="text-center text-muted mb-4" style="font-size: 14px;">
                            Welcome Back!<br>
                            Quality animal feeds for healthier livestock
                        </p>

                        <!-- Company Tagline -->
                        <div class="text-center mb-4" style="color: #2d6e4f; font-size: 13px; font-weight: 500;">
                            <i class="bi bi-star-fill me-1"></i>
                            Trusted by Farmers Nationwide
                            <i class="bi bi-star-fill ms-1"></i>
                        </div>

                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach($errors->all() as $error)
                                <small>{{ $error }}</small><br>
                            @endforeach
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

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <small>{{ session('success') }}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold" style="color: #1a1a1a; font-size: 14px;">
                                    <i class="bi bi-envelope me-1"></i> Email Address
                                </label>
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="you@example.com"
                                    value="{{ old('email') }}"
                                    required 
                                    autofocus
                                    style="padding: 12px 16px; border-radius: 8px; border: 1px solid #e0e0e0; background-color: #fafafa;">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" style="color: #1a1a1a; font-size: 14px;">
                                    <i class="bi bi-lock me-1"></i> Password
                                </label>
                                <div class="input-group">
                                    <input 
                                        type="password" 
                                        id="password"
                                        name="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="••••••••"
                                        required
                                        style="padding: 12px 16px; border-radius: 8px 0 0 8px; border: 1px solid #e0e0e0; background-color: #fafafa; border-right: none;">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 8px 8px 0; border: 1px solid #e0e0e0; border-left: none; background-color: #fafafa;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="cursor: pointer;">
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
                                class="btn btn-lg w-100 fw-semibold text-white d-flex align-items-center justify-content-center"
                                style="padding: 14px; border-radius: 8px; background-color: #2d6e4f; border: none; gap: 8px;">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Sign In
                            </button>
                        </form>
                        
                        <!-- Divider -->
                        <div class="position-relative my-4">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle px-2" style="background: white; font-size: 12px; color: #6b6b6b;">
                                OR
                            </span>
                        </div>
                        
                        <!-- Sign Up Link -->
                        <div class="text-center mt-4">
                            <p class="mb-2" style="color: #6b6b6b; font-size: 14px;">
                                New to Premium Farming Feeds?
                            </p>
                            <a href="{{ route('register') }}" class="btn btn-outline-success w-100" style="border-radius: 8px; border-color: #2d6e4f; color: #2d6e4f; font-weight: 500;">
                                Create Account
                            </a>
                        </div>

                        <!-- Company Footer -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">
                                <i class="bi bi-shield-check me-1"></i>
                                Secure Login • Premium Farming Feeds © {{ date('Y') }}
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
    .auth-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        border: 3px solid #2d6e4f;
        border-radius: 50%;
        padding: 5px;
        background: white;
        box-shadow: 0 4px 12px rgba(45, 110, 79, 0.1);
    }

    .auth-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Input focus styles */
    .form-control:focus {
        border-color: #2d6e4f !important;
        box-shadow: 0 0 0 0.2rem rgba(45, 110, 79, 0.15) !important;
        background-color: #fff !important;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }

    /* Button hover effect */
    .btn:hover {
        background-color: #245a3f !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(45, 110, 79, 0.2);
        transition: all 0.2s ease;
    }

    .btn-outline-success:hover {
        background-color: #2d6e4f !important;
        color: white !important;
    }

    /* Card shadow on hover */
    .card {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
        transition: all 0.3s ease;
        border: 1px solid rgba(45, 110, 79, 0.1) !important;
    }

    .card:hover {
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12) !important;
        transform: translateY(-2px);
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

    /* Alert styling */
    .alert {
        border: none;
        border-radius: 8px;
    }

    /* Company tagline animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .text-center i.bi-star-fill {
        animation: pulse 2s infinite;
        color: #ffc107;
    }
</style>

<script>
    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    // Auto-remove alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Form submission loading state
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Signing In...';
        submitBtn.disabled = true;
    });
</script>
@endsection