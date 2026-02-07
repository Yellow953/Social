@extends('layouts.dashboard')

@section('title', 'Edit Course | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-edit me-2" style="color: #ec682a;"></i>Edit Course</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.courses.update', $course) }}">
                        @csrf
                        @method('PUT')

                        <!-- Course Code -->
                        <div class="mb-3">
                            <label for="code" class="form-label fw-bold">Course Code <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('code') is-invalid @enderror"
                                   id="code"
                                   name="code"
                                   value="{{ old('code', $course->code) }}"
                                   placeholder="e.g., SOC101"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Unique identifier for the course</small>
                        </div>

                        <!-- Course Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Course Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $course->name) }}"
                                   placeholder="e.g., Introduction to Social Sciences"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Course description...">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Major -->
                            <div class="col-md-6 mb-3">
                                <label for="major" class="form-label fw-bold">Major / Speciality</label>
                                <select class="form-control @error('major') is-invalid @enderror"
                                        id="major"
                                        name="major">
                                    <option value="">Select major (optional)</option>
                                    @foreach(config('majors') as $major)
                                        <option value="{{ $major }}" {{ old('major', $course->major) == $major ? 'selected' : '' }}>{{ $major }}</option>
                                    @endforeach
                                </select>
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label fw-bold">Year</label>
                                <select class="form-control @error('year') is-invalid @enderror"
                                        id="year"
                                        name="year">
                                    <option value="">Select year (optional)</option>
                                    <option value="Sup" {{ old('year', $course->year) == 'Sup' ? 'selected' : '' }}>Sup</option>
                                    <option value="Spé" {{ old('year', $course->year) == 'Spé' ? 'selected' : '' }}>Spé</option>
                                    <option value="1e" {{ old('year', $course->year) == '1e' ? 'selected' : '' }}>1e</option>
                                    <option value="2e" {{ old('year', $course->year) == '2e' ? 'selected' : '' }}>2e</option>
                                    <option value="3e" {{ old('year', $course->year) == '3e' ? 'selected' : '' }}>3e</option>
                                </select>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Course
                            </button>
                            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
