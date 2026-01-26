@extends('layouts.auth')

@section('title', '503 - Service Unavailable | Social Plus')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%); overflow: hidden;">
    <!-- Orange Bubbles -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.4;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: #ec682a; border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: #ec682a; border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 20%; left: 20%; width: 100px; height: 100px; background: #ec682a; border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 30%; right: 30%; width: 120px; height: 120px; background: #ec682a; border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 40%; right: 10%; width: 80px; height: 80px; background: #ec682a; border-radius: 50%; animation: float 5s ease-in-out infinite;"></div>
    </div>
    
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            25% { transform: translateY(-20px) translateX(10px); }
            50% { transform: translateY(-10px) translateX(-10px); }
            75% { transform: translateY(-30px) translateX(5px); }
        }
    </style>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg bg-white">
                    <div class="card-body p-5 text-center">
                        <!-- Icon -->
                        <div class="mb-4">
                            <i class="fas fa-tools" style="font-size: 5rem; color: #ec682a;"></i>
                        </div>
                        
                        <!-- Error Code -->
                        <h1 class="display-1 fw-bold mb-3" style="color: #ec682a;">503</h1>
                        
                        <!-- Title -->
                        <h2 class="fw-bold mb-3" style="color: #5c5c5c;">Service Unavailable</h2>
                        
                        <!-- Message -->
                        <p class="text-muted mb-4 lead">We're currently performing maintenance. We'll be back online shortly. Thank you for your patience.</p>
                        
                        <!-- Actions -->
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Go Back
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn btn-lg text-white fw-semibold" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                    <i class="fas fa-home me-2"></i>Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-lg text-white fw-semibold" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
