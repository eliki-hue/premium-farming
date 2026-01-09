@extends('layouts.app')

@section('title', 'Login - Premium Farming Feeds')

@push('styles')
<style>
    .auth-section {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, var(--light-bg) 0%, white 100%);
        padding: 4rem 0;
    }

    .auth-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .auth-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(45, 95, 78, 0.1);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .auth-logo {
        width: 80px;
        height: 80px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 3px solid var(--accent-orange);
        overflow: hidden;
    }

    .auth-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .auth-logo i {
        color: var(--primary-green);
        font-size: 2.5rem;
    }

    .auth-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .auth-header p {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .form-control-custom {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(45, 95, 78, 0.1);
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: var(--primary-green);
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary-green);
    }

    .remember-me label {
        font-size: 0.9rem;
        color: var(--text-dark);
        cursor: pointer;
        margin: 0;
    }

    .forgot-link {
        color: var(--primary-green);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: var(--accent-orange);
    }

    /* ENHANCED LOGIN BUTTON - MATCHES SIGNUP */
    .btn-auth {
        width: 100%;
        padding: 1.1rem;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s ease;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    }

    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
    }

    .btn-auth:active {
        transform: translateY(-1px);
    }

    .btn-auth:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* Add a subtle shine effect */
    .btn-auth::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(
            to right,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.1) 50%,
            rgba(255, 255, 255, 0) 100%
        );
        transform: rotate(30deg);
        transition: transform 0.6s;
    }

    .btn-auth:hover::after {
        transform: rotate(30deg) translate(20%, 20%);
    }

    /* Add a subtle pulse animation for attention */
    @keyframes subtlePulse {
        0% { box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3); }
        50% { box-shadow: 0 8px 30px rgba(40, 167, 69, 0.5); }
        100% { box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3); }
    }

    .btn-auth {
        animation: subtlePulse 3s infinite;
    }

    /* Add a key icon for login */
    .btn-auth::before {
        content: '🔑';
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.3rem;
        opacity: 0.8;
    }

    /* Benefits section */
    .login-benefits {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, rgba(32, 201, 151, 0.05) 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border-left: 4px solid #28a745;
    }

    .login-benefits h5 {
        color: #28a745;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .login-benefits ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .login-benefits li {
        display: flex;
        align-items: center;
        margin-bottom: 0.7rem;
        color: var(--text-dark);
    }

    .login-benefits li i {
        color: #28a745;
        margin-right: 0.8rem;
        font-size: 1.1rem;
    }

    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .auth-footer p {
        color: var(--text-muted);
        margin: 0;
        font-size: 1rem;
    }

    .auth-footer a {
        color: #28a745;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s ease;
        font-size: 1.05rem;
    }

    .auth-footer a:hover {
        color: var(--accent-orange);
        text-decoration: underline;
    }

    .alert {
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        border: 1px solid;
    }

    .alert-error {
        background-color: #fee;
        border-color: #fcc;
        color: #c33;
    }

    .alert-success {
        background-color: #efe;
        border-color: #cfc;
        color: #3c3;
    }

    /* Call to Action text */
    .cta-text {
        text-align: center;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding: 0.8rem;
        background: rgba(40, 167, 69, 0.08);
        border-radius: 8px;
    }

    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.5rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
        }
        
        .btn-auth {
            padding: 1rem;
            font-size: 1.1rem;
        }
        
        .btn-auth::before {
            left: 1rem;
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="auth-logo">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Premium Farming Feeds">
                    </div>
                    <h1>Welcome Back</h1>
                    <p>Login to access your account</p>
                </div>

                @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Benefits section -->
                <div class="login-benefits">
                    <h5><i class="bi bi-stars me-2"></i>Benefits of Logging In:</h5>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> Access your shopping cart</li>
                        <li><i class="bi bi-check-circle"></i> Track your orders & delivery</li>
                        <li><i class="bi bi-check-circle"></i> View order history</li>
                        <li><i class="bi bi-check-circle"></i> Manage your profile</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control-custom" 
                            placeholder="you@example.com"
                            required
                            value="{{ old('email') }}"
                        >
                        @error('email')
                        <small style="color: #c33; margin-top: 0.5rem; display: block;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control-custom" 
                                placeholder="Enter your password"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <small style="color: #c33; margin-top: 0.5rem; display: block;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>

                    <!-- Call to Action text -->
                    <div class="cta-text">
                        🔑 Access your account now!
                    </div>

                    <!-- Enhanced Login Button -->
                    <button type="submit" class="btn-auth">
                        LOGIN TO YOUR ACCOUNT
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
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

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-auth');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Logging in...';
        submitBtn.disabled = true;
        
        // Allow form to submit naturally
        return true;
    });
</script>
@endpush