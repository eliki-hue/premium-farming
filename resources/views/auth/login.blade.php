@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Simple Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white text-center py-3">
                    <h4 class="mb-0">Login to Your Account</h4>
                </div>
                
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        Invalid email or password
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        
                        <!-- Password -->
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        
                        <!-- VISIBLE LOGIN BUTTON -->
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            LOGIN
                        </button>
                    </form>
                    
                    <!-- Sign up link -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="mb-0">New user? 
                            <a href="{{ route('register') }}" class="text-success fw-bold">Create account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection