@extends('layouts.auth')

@section('title', 'Register | ESIB SOCIAL')

@section('content')
<div class="min-vh-100 d-flex align-items-center py-5 position-relative" style="background: linear-gradient(135deg, #1a2744 0%, #243b5c 50%, #1e3a5f 100%); overflow: hidden;">
    <!-- Orange Bubbles -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.5;">
        <div class="position-absolute" style="top: 5%; left: 5%; width: 250px; height: 250px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 50%; right: 10%; width: 180px; height: 180px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 8s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 15%; left: 15%; width: 120px; height: 120px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 7s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 30%; right: 30%; width: 140px; height: 140px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 9s ease-in-out infinite;"></div>
        <div class="position-absolute" style="bottom: 40%; right: 5%; width: 90px; height: 90px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 5s ease-in-out infinite;"></div>
        <div class="position-absolute" style="top: 70%; left: 30%; width: 110px; height: 110px; background: rgba(236,104,42,0.4); border-radius: 50%; animation: float 6.5s ease-in-out infinite;"></div>
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
                            <h3 class="fw-bold mb-1" style="color: #5c5c5c;">Create Account</h3>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <input type="text"
                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Full Name"
                                       required
                                       autocomplete="name"
                                       autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email (Outlook only) -->
                            <div class="mb-3">
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Email (e.g. name@outlook.com)"
                                       required
                                       autocomplete="email">
                                <div class="form-text small mx-2">Only Outlook addresses are accepted (e.g. name@outlook.com).</div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <input type="tel"
                                       class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="Phone Number"
                                       required
                                       autocomplete="tel">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Study Year -->
                            <div class="mb-3">
                                <select class="form-control form-control-lg @error('study_year') is-invalid @enderror"
                                        id="study_year"
                                        name="study_year"
                                        required>
                                    <option value="">Select Study Year</option>
                                    <option value="Sup" {{ old('study_year') == 'Sup' ? 'selected' : '' }}>Sup</option>
                                    <option value="Spé" {{ old('study_year') == 'Spé' ? 'selected' : '' }}>Spé</option>
                                    <option value="1e" {{ old('study_year') == '1e' ? 'selected' : '' }}>1e</option>
                                    <option value="2e" {{ old('study_year') == '2e' ? 'selected' : '' }}>2e</option>
                                    <option value="3e" {{ old('study_year') == '3e' ? 'selected' : '' }}>3e</option>
                                </select>
                                @error('study_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Major -->
                            <div class="mb-3">
                                <select class="form-control form-control-lg @error('major') is-invalid @enderror"
                                        id="major"
                                        name="major"
                                        required>
                                    <option value="">Select your major</option>
                                    @foreach(config('majors') as $major)
                                        <option value="{{ $major }}" {{ old('major') == $major ? 'selected' : '' }}>{{ $major }}</option>
                                    @endforeach
                                </select>
                                @error('major')
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

                            <!-- Terms & Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label text-muted small" for="terms">
                                        I agree to the <a href="{{ route('terms') }}" target="_blank" class="text-decoration-none" style="color: #ec682a;">Terms</a> and <a href="{{ route('privacy') }}" target="_blank" class="text-decoration-none" style="color: #ec682a;">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100 btn-lg text-white fw-semibold py-2 mb-3"
                                    style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%); border: none;">
                                Create Account
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <span class="text-muted small">Already have an account? </span>
                                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold small" style="color: #ec682a;">Sign In</a>
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
