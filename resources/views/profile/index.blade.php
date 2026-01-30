@extends('layouts.dashboard')

@section('title', 'Profile | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <div class="bg-gradient-to-br from-[#1e3a8a] to-[#3b82f6] rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <span class="text-white fw-bold" style="font-size: 3rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    <hr class="my-4">
                    <div class="text-start">
                        <h6 class="fw-bold mb-3">Account Stats</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Member since</span>
                            <span class="fw-bold">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Courses accessed</span>
                            <span class="fw-bold">{{ $coursesCount ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Sessions completed</span>
                            <span class="fw-bold">{{ $sessionsCount ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-user me-2" style="color: #ec682a;"></i>Personal Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required autocomplete="off">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Phone Number</label>
                                <input type="tel" class="form-control" name="phone" value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-lock me-2" style="color: #ec682a;"></i>Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}" autocomplete="off" id="profile-password-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Current Password</label>
                                <input type="password" class="form-control profile-password-noautofill" name="current_password" required autocomplete="new-password" readonly tabindex="0" data-readonly-remove>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">New Password</label>
                                <input type="password" class="form-control profile-password-noautofill" name="password" required autocomplete="new-password" readonly tabindex="0" data-readonly-remove>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" class="form-control profile-password-noautofill" name="password_confirmation" required autocomplete="new-password" readonly tabindex="0" data-readonly-remove>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary text-white">
                                    <i class="fas fa-key me-2"></i>Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                    <script>
                        (function() {
                            var form = document.getElementById('profile-password-form');
                            if (!form) return;
                            var inputs = form.querySelectorAll('[data-readonly-remove]');
                            function removeReadonly(el) {
                                el.removeAttribute('readonly');
                            }
                            inputs.forEach(function(el) {
                                el.addEventListener('focus', function() { removeReadonly(el); }, { once: true });
                                el.addEventListener('click', function() { removeReadonly(el); }, { once: true });
                            });
                            // Remove readonly after a short delay so browser autofill runs first on readonly fields (and skips them)
                            setTimeout(function() {
                                inputs.forEach(removeReadonly);
                            }, 400);
                        })();
                    </script>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-cog me-2" style="color: #ec682a;"></i>Account Settings</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.two-factor') }}" id="two-factor-form">
                        @csrf
                        <input type="hidden" name="enabled" value="0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Two-Factor Authentication</h6>
                                <p class="text-muted small mb-0">Require a code sent to your email when signing in</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enabled" value="1" id="twoFactorEnabled" {{ auth()->user()->two_factor_enabled ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
