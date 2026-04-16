@extends('layouts.dashboard')

@section('title', 'Edit User | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-edit me-2" style="color: #ec682a;"></i>Edit User</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Phone</label>
                                <input type="tel"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                                @if($user->isSuperAdmin())
                                    <input type="text" class="form-control bg-light" value="Super Admin" readonly>
                                    <input type="hidden" name="role" value="super_admin">
                                    <small class="text-muted">Super admin role cannot be changed from the dashboard.</small>
                                @else
                                    <select class="form-control @error('role') is-invalid @enderror"
                                            id="role"
                                            name="role"
                                            required>
                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @endif
                            </div>

                            <!-- Study Year -->
                            <div class="col-md-6 mb-3">
                                <label for="study_year" class="form-label fw-bold">Study Year</label>
                                <select class="form-control @error('study_year') is-invalid @enderror"
                                        id="study_year"
                                        name="study_year">
                                    <option value="">Select Year</option>
                                    <option value="Sup" {{ old('study_year', $user->study_year) == 'Sup' ? 'selected' : '' }}>Sup</option>
                                    <option value="Spé" {{ old('study_year', $user->study_year) == 'Spé' ? 'selected' : '' }}>Spé</option>
                                    <option value="1e" {{ old('study_year', $user->study_year) == '1e' ? 'selected' : '' }}>1e</option>
                                    <option value="2e" {{ old('study_year', $user->study_year) == '2e' ? 'selected' : '' }}>2e</option>
                                    <option value="3e" {{ old('study_year', $user->study_year) == '3e' ? 'selected' : '' }}>3e</option>
                                </select>
                                @error('study_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Major -->
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label fw-bold">Major</label>
                                <select class="form-control @error('major') is-invalid @enderror"
                                        id="major"
                                        name="major">
                                    <option value="">Select major (optional)</option>
                                    @foreach(config('majors') as $major)
                                        <option value="{{ $major }}" {{ old('major', $user->major) == $major ? 'selected' : '' }}>{{ $major }}</option>
                                    @endforeach
                                </select>
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">New Password</label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="Leave blank to keep current password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave blank to keep current password</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="Confirm new password">
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Account Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                       style="width: 3em; height: 1.5em; cursor: pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="is_active" id="is_active_label"
                                       style="color: {{ $user->is_active ? '#059669' : '#dc2626' }};">
                                    {{ old('is_active', $user->is_active) ? 'Active' : 'Disabled' }}
                                </label>
                            </div>
                        </div>

                        <!-- Extra Courses -->
                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Extra Courses <small class="text-muted fw-normal">(assigned on top of year/major courses)</small></label>
                            <input type="text" id="extra-course-search" class="form-control form-control-sm mb-2" placeholder="Search courses...">
                            @php $selectedExtraCourseIds = old('extra_course_ids', $user->extraCourses->pluck('id')->toArray()); @endphp
                            <div class="border rounded p-3" style="max-height: 220px; overflow-y: auto;" id="extra-courses-list">
                                @forelse($courses as $course)
                                    <div class="form-check extra-course-item">
                                        <input class="form-check-input" type="checkbox"
                                               name="extra_course_ids[]"
                                               id="extra_course_{{ $course->id }}"
                                               value="{{ $course->id }}"
                                               {{ in_array($course->id, $selectedExtraCourseIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="extra_course_{{ $course->id }}">
                                            {{ $course->name }} | {{ $course->code }} | {{ implode('/', $course->majors ?? []) }} | {{ implode('/', $course->years ?? []) }} | S{{ implode('/', $course->semesters ?? []) }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted small mb-0">No courses available.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('extra-course-search').addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.extra-course-item').forEach(function(item) {
            item.style.display = item.querySelector('label').textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    document.getElementById('is_active').addEventListener('change', function() {
        var label = document.getElementById('is_active_label');
        if (this.checked) {
            label.textContent = 'Active';
            label.style.color = '#059669';
        } else {
            label.textContent = 'Disabled';
            label.style.color = '#dc2626';
        }
    });
</script>
@endpush

@endsection
