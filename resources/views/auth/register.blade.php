@extends('layouts.app')

@section('title', 'Sign Up - Premium Farming Feeds')

@push('styles')
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
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        width: 70px;
        height: 70px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        border: 2px solid #2d6e4f;
        overflow: hidden;
    }

    .auth-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .auth-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.4rem;
    }

    .auth-header p {
        color: #6b6b6b;
        font-size: 0.95rem;
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

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .remember-me input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #2d6e4f;
    }

    .remember-me label {
        font-size: 0.85rem;
        color: #1a1a1a;
        cursor: pointer;
        margin: 0;
    }

    .forgot-link {
        color: #2d6e4f;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .forgot-link:hover {
        color: #245a3f;
        text-decoration: underline;
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

    .auth-footer a {
        color: #2d6e4f;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .auth-footer a:hover {
        color: #245a3f;
        text-decoration: underline;
    }

    .alert {
        padding: 0.9rem;
        border-radius: 8px;
        margin-bottom: 1.3rem;
        border: 1px solid;
        font-size: 0.9rem;
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
                    <h1>Create Your Account</h1>
                    <p>Sign up to get started with Premium Farming Feeds</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-control-custom" 
                            placeholder="johndoe"
                            required
                            autofocus
                            value="{{ old('username') }}"
                        >
                        @error('username')
                        <small style="color: #c33; margin-top: 0.4rem; display: block; font-size: 0.85rem;">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
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
                        <small style="color: #c33; margin-top: 0.4rem; display: block; font-size: 0.85rem;">{{ $message }}</small>
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
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <small style="color: #c33; margin-top: 0.4rem; display: block; font-size: 0.85rem;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-control-custom" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePasswordConfirm()">
                                <i class="bi bi-eye" id="toggleIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth">
                        Create Account
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
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

    // Form submission handling
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('.btn-auth');
        submitBtn.innerHTML = 'Creating account...';
        submitBtn.disabled = true;
    });
</script>
@endpush