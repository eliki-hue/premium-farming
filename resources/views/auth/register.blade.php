
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

                @if(session('success'))
                <div class="alert alert-success">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('proxy.signup') }}">
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

<style>
    .auth-section {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, #f8f9fa 0%, white 100%);
        padding: 3rem 0;
    }

    .auth-container {
        max-width: 480px;
        margin: 0 auto;
    }

    .auth-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(45, 110, 79, 0.1);
        transition: all 0.3s ease;
    }

    .auth-card:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        width: 90px;
        height: 90px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        border: 3px solid #2d6e4f;
        padding: 5px;
        box-shadow: 0 6px 20px rgba(45, 110, 79, 0.15);
        overflow: hidden;
    }

    .auth-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .auth-header h1 {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 0.4rem;
        background: linear-gradient(135deg, #2d6e4f 0%, #245a3f 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .company-tagline {
        color: #6b6b6b;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .welcome-message {
        color: #2d6e4f;
        font-size: 0.85rem;
        font-weight: 600;
        background: rgba(45, 110, 79, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        display: inline-block;
        margin-top: 0.5rem;
    }

    .benefits-box {
        background: linear-gradient(135deg, #f8fff9 0%, #f0f9f3 100%);
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid rgba(45, 110, 79, 0.1);
    }

    .benefit-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem;
        border-radius: 6px;
        background: white;
        transition: all 0.2s ease;
    }

    .benefit-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .benefit-item i {
        color: #2d6e4f;
        font-size: 1.1rem;
    }

    .benefit-item span {
        font-size: 0.8rem;
        font-weight: 600;
        color: #1a1a1a;
    }

    .form-group {
        margin-bottom: 1.3rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #1a1a1a;
        font-size: 0.9rem;
    }

    .form-control-custom {
        width: 100%;
        padding: 0.85rem 1rem;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: #fafafa;
        font-family: inherit;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: #2d6e4f;
        box-shadow: 0 0 0 3px rgba(45, 110, 79, 0.1);
        background-color: white;
    }

    .form-control-custom.is-invalid {
        border-color: #dc3545;
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6b6b6b;
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.2s ease;
        padding: 0;
    }

    .password-toggle:hover {
        color: #2d6e4f;
    }

    .error-message {
        color: #dc3545;
        margin-top: 0.4rem;
        display: block;
        font-size: 0.85rem;
    }

    .password-strength, .password-match {
        font-size: 0.8rem;
        font-weight: 500;
    }

    .btn-auth {
        width: 100%;
        padding: 0.95rem;
        background: linear-gradient(135deg, #2d6e4f 0%, #245a3f 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
        letter-spacing: 0.3px;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 110, 79, 0.3);
    }

    .btn-auth:active {
        transform: translateY(0);
    }

    .btn-auth:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .auth-footer p {
        color: #6b6b6b;
        margin: 0;
        font-size: 0.9rem;
    }

    .login-link {
        color: #2d6e4f;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .login-link:hover {
        color: #245a3f;
        text-decoration: underline;
    }

    .company-footer {
        font-size: 0.8rem;
    }

    .alert {
        padding: 0.9rem;
        border-radius: 8px;
        margin-bottom: 1.3rem;
        border: none;
        font-size: 0.9rem;
    }

    .alert-danger {
        background-color: #fee;
        color: #c33;
    }

    .alert-success {
        background-color: #efe;
        color: #3c3;
    }

    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.5rem;
        }

        .auth-header h1 {
            font-size: 1.5rem;
        }
        
        .btn-auth {
            padding: 0.85rem;
        }

        .auth-logo {
            width: 70px;
            height: 70px;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .auth-card {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }

    function togglePasswordConfirm() {
        const passwordInput = document.getElementById('password_confirmation');
        const toggleIcon = document.getElementById('toggleIconConfirm');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }

    // Password strength checker
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthDiv = document.getElementById('passwordStrength');
        
        let strength = 0;
        let message = '';
        let color = '';
        
        if (password.length === 0) {
            message = '';
            color = 'transparent';
        } else if (password.length < 6) {
            message = '❌ Too short (min 6 characters)';
            color = '#dc3545';
        } else if (password.length < 8) {
            message = '⚠️ Fair';
            color = '#fd7e14';
        } else {
            // Check for complexity
            const hasUpper = /[A-Z]/.test(password);
            const hasLower = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);
            
            const complexity = [hasUpper, hasLower, hasNumbers, hasSpecial].filter(Boolean).length;
            
            if (complexity >= 3 && password.length >= 10) {
                message = '✅ Strong';
                color = '#28a745';
            } else if (complexity >= 2) {
                message = '👍 Good';
                color = '#2d6e4f';
            } else {
                message = '⚠️ Fair';
                color = '#fd7e14';
            }
        }
        
        strengthDiv.textContent = message;
        strengthDiv.style.color = color;
        strengthDiv.style.fontWeight = '600';
    });

    // Password confirmation check
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPassword.length === 0) {
            matchDiv.textContent = '';
        } else if (password === confirmPassword) {
            matchDiv.textContent = '✅ Passwords match';
            matchDiv.style.color = '#28a745';
            this.style.borderColor = '#28a745';
        } else {
            matchDiv.textContent = '❌ Passwords do not match';
            matchDiv.style.color = '#dc3545';
            this.style.borderColor = '#dc3545';
        }
        matchDiv.style.fontWeight = '600';
    });

    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Creating Account...';
        submitBtn.disabled = true;
    });

    // Auto-remove alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Real-time username availability (simulated)
    document.getElementById('username').addEventListener('blur', function() {
        const username = this.value;
        if (username.length >= 3) {
            // In a real app, you would make an AJAX call here
            this.style.borderColor = '#2d6e4f';
        }
    });
</script>
@endsection
