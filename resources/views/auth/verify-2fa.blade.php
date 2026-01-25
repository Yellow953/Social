@extends('layouts.auth')

@section('title', 'Two-Factor Authentication - Social Plus')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%); overflow: hidden;">
    <!-- Orange Bubbles -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.4;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: #ec682a; border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: #ec682a; border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 20%; left: 20%; width: 100px; height: 100px; background: #ec682a; border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 30%; right: 30%; width: 120px; height: 120px; background: #ec682a; border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
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
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock fs-1 mb-3" style="color: #ec682a;"></i>
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Two-Factor Authentication</h3>
                            <p class="text-muted small mb-0">Enter the 6-digit code sent to your email</p>
                        </div>

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('verify-2fa') }}">
                            @csrf

                            <!-- 2FA Code -->
                            <div class="mb-4">
                                <input type="text"
                                       class="form-control form-control-lg text-center fw-bold fs-4 letter-spacing-2 @error('code') is-invalid @enderror"
                                       id="code"
                                       name="code"
                                       placeholder="000000"
                                       required
                                       autofocus
                                       maxlength="6"
                                       pattern="[0-9]{6}"
                                       style="letter-spacing: 0.5rem;">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                Verify & Continue
                            </button>

                            <!-- Resend Code -->
                            <div class="text-center mb-3">
                                <form method="POST" action="{{ route('resend-2fa') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none p-0" style="color: #ec682a;">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                                    </button>
                                </form>
                            </div>

                            <!-- Back to Login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold small" style="color: #ec682a;">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-format 2FA code input
    document.getElementById('code')?.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 6) {
            this.form.submit();
        }
    });
</script>
@endsection
