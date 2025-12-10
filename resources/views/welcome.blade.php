@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<!-- Add Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="row g-0 shadow overflow-hidden" style="border-radius: 20px;">
                <!-- Left side illustration panel -->
                <div class="col-md-5 d-none d-md-block" style="background: linear-gradient(135deg, #4361ee, #3a56d4);">
                    <div class="p-5 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-5">
                                <div class="bg-white rounded-circle p-3 d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-clinic-medical text-primary fs-2"></i>
                                </div>
                                <h3 class="fw-bold text-white">ATS Pharmacy</h3>
                                <p class="text-white opacity-75">Management System</p>
                            </div>
                            <div class="bg-white bg-opacity-10 rounded-3 p-4 mb-5">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-quote-left text-primary"></i>
                                    </div>
                                    <h5 class="text-white mb-0 fw-bold">Welcome Back</h5>
                                </div>
                                <p class="text-white opacity-75 mb-0">Sign in to access the pharmacy management dashboard and control your business operations.</p>
                            </div>
                        </div>
                        <div class="text-white opacity-75 small">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-alt me-2"></i>
                                <span>Secure Authentication System</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right side login form -->
                <div class="col-md-7 bg-white">
                    <div class="p-5">
                        <div class="text-center mb-5 d-md-none">
                            <div class="bg-primary rounded-circle p-3 d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clinic-medical text-white fs-2"></i>
                            </div>
                            <h3 class="fw-bold text-primary">ATS Pharmacy</h3>
                            <p class="text-muted">Management System</p>
                        </div>
                        
                        <div class="mb-5">
                            <h3 class="fw-bold mb-1">Sign in</h3>
                            <p class="text-muted">Access your pharmacy management account</p>
                        </div>
                        
                        @if(session('error'))
                            <div class="alert alert-danger d-flex align-items-center border-0 rounded-3 mb-4 bg-danger bg-opacity-10" role="alert">
                                <i class="fas fa-exclamation-circle text-danger me-2"></i>
                                <div class="text-danger">{{ session('error') }}</div>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ url('/login') }}">
                            @csrf
    
                            <div class="mb-4">
                                <label for="identifier" class="form-label fw-semibold">
                                    Email or Phone
                                </label>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-user text-primary"></i>
                                    </span>
                                    <input id="identifier" type="text" class="form-control border-0 py-3 @error('identifier') is-invalid @enderror" 
                                        name="identifier" value="{{ old('identifier') }}" required autofocus 
                                        placeholder="Enter your email or phone">
                                </div>
                                
                                @error('identifier')
                                    <div class="invalid-feedback d-block mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
    
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold mb-0">
                                        Password
                                    </label>
                                </div>
                                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text border-0 bg-light">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control border-0 py-3 @error('password') is-invalid @enderror" 
                                        name="password" required autocomplete="current-password" 
                                        placeholder="Enter your password">
                                </div>
                                
                                @error('password')
                                    <div class="invalid-feedback d-block mt-2">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
    
                            <div class="mb-5 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" 
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
    
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 py-3 rounded-3">
                                Sign In <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection