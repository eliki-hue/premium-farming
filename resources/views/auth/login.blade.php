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

    .btn-auth {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(45, 95, 78, 0.3);
    }

    .divider {
        text-align: center;
        margin: 2rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background-color: #e5e7eb;
    }

    .divider span {
        background-color: white;
        padding: 0 1rem;
        color: var(--text-muted);
        position: relative;
        z-index: 1;
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
    }

    .auth-footer a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-footer a:hover {
        color: var(--accent-orange);
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

    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.5rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
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

                <!-- Error/Success Messages -->
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
{{-- <!-- <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a> --> --}}
                    </div>

                    <button type="submit" class="btn-auth">
                        Login to Account
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="/register">Sign up here</a></p>
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
</script>
@endpush