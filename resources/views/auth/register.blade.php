@extends('layouts.app')

@section('title', 'Sign Up - Premium Farming Feeds')

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
        max-width: 600px;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
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

    .password-strength {
        height: 4px;
        background-color: #e5e7eb;
        border-radius: 2px;
        margin-top: 0.5rem;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        transition: all 0.3s ease;
    }

    .password-strength-bar.weak {
        width: 33%;
        background-color: #ef4444;
    }

    .password-strength-bar.medium {
        width: 66%;
        background-color: #f59e0b;
    }

    .password-strength-bar.strong {
        width: 100%;
        background-color: #10b981;
    }

    .terms-checkbox {
        display: flex;
        align-items: start;
        gap: 0.7rem;
        margin-bottom: 1.5rem;
    }

    .terms-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--primary-green);
        margin-top: 2px;
        flex-shrink: 0;
    }

    .terms-checkbox label {
        font-size: 0.9rem;
        color: var(--text-dark);
        cursor: pointer;
        margin: 0;
        line-height: 1.6;
    }

    .terms-checkbox label a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 600;
    }

    .terms-checkbox label a:hover {
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

    .btn-auth:disabled {
        opacity: 0.6;
        cursor: not-allowed;
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

    @media (max-width: 576px) {
        .auth-card {
            padding: 2rem 1.5rem;
        }

        .auth-header h1 {
            font-size: 1.75rem;
        }

        .form-row {
            grid-template-columns: 1fr;
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
                    <h1>Create Account</h1>
                    <p>Join us for premium livestock feeds</p>
                </div>

                @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}" id="registerForm">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                class="form-control-custom" 
                                placeholder="John"
                                required
                                value="{{ old('first_name') }}"
                            >
                            @error('first_name')
                            <small style="color: #c33; margin-top: 0.5rem; display: block;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                class="form-control-custom" 
                                placeholder="Doe"
                                required
                                value="{{ old('last_name') }}"
                            >
                            @error('last_name')
                            <small style="color: #c33; margin-top: 0.5rem; display: block;">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

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
                        <label for="phone" class="form-label">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            class="form-control-custom" 
                            placeholder="+254 700 000 000"
                            required
                            value="{{ old('phone') }}"
                        >
                        @error('phone')
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
                                placeholder="Create a strong password"
                                required
                                onkeyup="checkPasswordStrength()"
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="bi bi-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        <small style="color: var(--text-muted); margin-top: 0.5rem; display: block;">
                            Use 8+ characters with mix of letters, numbers & symbols
                        </small>
                        @error('password')
                        <small style="color: #c33; margin-top: 0.5rem; display: block;">{{ $message }}</small>
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
                                placeholder="Re-enter your password"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="bi bi-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the <a href="{{ url('/terms') }}" target="_blank">Terms of Service</a> 
                            and <a href="{{ url('/privacy') }}" target="_blank">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-auth">
                        Create Account
                    </button>
                </form>

                <div class="auth-footer">
                    <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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

    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('strengthBar');
        
        // Remove all classes
        strengthBar.classList.remove('weak', 'medium', 'strong');
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            return;
        }
        
        let strength = 0;
        
        // Check password length
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Check for lowercase and uppercase
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        
        // Check for numbers
        if (/\d/.test(password)) strength++;
        
        // Check for special characters
        if (/[^a-zA-Z\d]/.test(password)) strength++;
        
        // Set strength class
        if (strength <= 2) {
            strengthBar.classList.add('weak');
        } else if (strength <= 4) {
            strengthBar.classList.add('medium');
        } else {
            strengthBar.classList.add('strong');
        }
    }

    // Form validation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long!');
            return false;
        }
    });
</script>
@endpush