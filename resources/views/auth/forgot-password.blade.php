@extends('layouts.auth')

@section('title', 'Forgot Password - Social Plus')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); overflow: hidden;">
    <!-- Decorative Elements -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.1;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: white; border-radius: 50%;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: white; border-radius: 50%;"></div>
    </div>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg bg-white">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <i class="bi bi-key fs-1 mb-3" style="color: #ec682a;"></i>
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Forgot Password?</h3>
                            <p class="text-muted small mb-0">Enter your email to reset your password</p>
                        </div>

                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-4">
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Email"
                                       required
                                       autocomplete="email"
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                Send Reset Link
                            </button>

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
@endsection
