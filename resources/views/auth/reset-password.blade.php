@extends('layouts.auth')

@section('title', 'Reset Password | ESIB SOCIAL')

@section('content')
<div class="min-vh-100 d-flex align-items-center position-relative" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%); overflow: hidden;">
    <!-- Orange Bubbles -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.4;">
        <div class="position-absolute" style="top: 10%; left: 10%; width: 200px; height: 200px; background: #ec682a; border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 60%; right: 15%; width: 150px; height: 150px; background: #ec682a; border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 25%; left: 20%; width: 130px; height: 130px; background: #ec682a; border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 40%; right: 30%; width: 110px; height: 110px; background: #ec682a; border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
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
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Reset Password</h3>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email -->
                            <div class="mb-3">
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
                                       placeholder="Email"
                                       required
                                       autocomplete="email"
                                       readonly>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="New Password"
                                           required
                                           autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control form-control-lg"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           placeholder="Confirm Password"
                                           required
                                           autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                                        <i class="bi bi-eye" id="togglePasswordConfirmationIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                Reset Password
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

<script>
    function setupPasswordToggle(toggleId, inputId, iconId) {
        const toggle = document.getElementById(toggleId);
        if (toggle) {
            toggle.addEventListener('click', function() {
                const passwordInput = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

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
        }
    }

    setupPasswordToggle('togglePassword', 'password', 'togglePasswordIcon');
    setupPasswordToggle('togglePasswordConfirmation', 'password_confirmation', 'togglePasswordConfirmationIcon');
</script>
@endsection
