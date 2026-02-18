@extends('layouts.auth')

@section('title', 'Verify Email | ESIB SOCIAL')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1a2744 0%, #243b5c 50%, #1e3a5f 100%); overflow: hidden;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.5;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 20%; left: 20%; width: 100px; height: 100px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 30%; right: 30%; width: 120px; height: 120px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
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
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg bg-white">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="ESIB Social" class="d-block mx-auto mb-3" style="max-height: 64px; width: auto; object-fit: contain;">
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Verify Your Email</h3>
                            <p class="text-muted small mb-0">We've sent a verification link to your email address</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <p class="text-muted text-center mb-4">
                            Please check your inbox and click the verification link in the email we sent you. You can then access your account.
                        </p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                            </button>
                        </form>

                        <div class="text-center">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: #ec682a;">
                                    <i class="fas fa-sign-out-alt me-1"></i>Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
