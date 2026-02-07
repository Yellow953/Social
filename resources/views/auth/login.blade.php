@extends('layouts.auth')

@section('title', 'Login | ESIB SOCIAL')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1a2744 0%, #243b5c 50%, #1e3a5f 100%); overflow: hidden;">
    <!-- Orange Bubbles -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.5;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 20%; left: 20%; width: 100px; height: 100px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 30%; right: 30%; width: 120px; height: 120px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 40%; right: 10%; width: 80px; height: 80px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 5s ease-in-out infinite;"></div>
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
                            <img src="{{ asset('assets/images/logo.png') }}" alt="ESIB Social" class="d-block mx-auto mb-3" style="max-height: 64px; width: auto; object-fit: contain;">
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Welcome Back</h3>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
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

                            <!-- Password -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Password"
                                           required
                                           autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label text-muted small" for="remember">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color: #ec682a;">Forgot password?</a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                Sign In
                            </button>

                            <!-- Register Link -->
                            <div class="text-center">
                                <span class="text-muted small">Don't have an account? </span>
                                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold small" style="color: #ec682a;">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
</script>
@endsection
