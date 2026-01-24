@extends('layouts.dashboard')

@section('title', 'Create Session - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.sessions.index') }}">Sessions</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-plus me-2"></i>Create New Session</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.sessions.store') }}">
                        @csrf

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">Session Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       placeholder="e.g., Introduction to Social Sciences"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Session description...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Course -->
                            <div class="col-md-6 mb-3">
                                <label for="course_id" class="form-label fw-bold">Course <span class="text-danger">*</span></label>
                                <select class="form-control @error('course_id') is-invalid @enderror"
                                        id="course_id"
                                        name="course_id"
                                        required>
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="col-md-3 mb-3">
                                <label for="year" class="form-label fw-bold">Study Year <span class="text-danger">*</span></label>
                                <select class="form-control @error('year') is-invalid @enderror"
                                        id="year"
                                        name="year"
                                        required>
                                    <option value="">Select year</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>Year {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div class="col-md-3 mb-3">
                                <label for="order" class="form-label fw-bold">Order</label>
                                <input type="number"
                                       class="form-control @error('order') is-invalid @enderror"
                                       id="order"
                                       name="order"
                                       value="{{ old('order', 0) }}"
                                       min="0"
                                       placeholder="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Display order within course/year</small>
                            </div>

                            <!-- Video URL -->
                            <div class="col-md-8 mb-3">
                                <label for="video_url" class="form-label fw-bold">Video URL <span class="text-danger">*</span></label>
                                <input type="url"
                                       class="form-control @error('video_url') is-invalid @enderror"
                                       id="video_url"
                                       name="video_url"
                                       value="{{ old('video_url') }}"
                                       placeholder="https://example.com/video.mp4"
                                       required>
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="col-md-4 mb-3">
                                <label for="duration" class="form-label fw-bold">Duration (seconds)</label>
                                <input type="number"
                                       class="form-control @error('duration') is-invalid @enderror"
                                       id="duration"
                                       name="duration"
                                       value="{{ old('duration') }}"
                                       min="0"
                                       placeholder="3600">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Duration in seconds</small>
                            </div>

                            <!-- Is Locked -->
                            <div class="col-md-12 mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_locked') is-invalid @enderror"
                                           type="checkbox"
                                           id="is_locked"
                                           name="is_locked"
                                           value="1"
                                           {{ old('is_locked', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_locked">
                                        <strong>Locked Session</strong> (Requires subscription to access)
                                    </label>
                                    @error('is_locked')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Session
                            </button>
                            <a href="{{ route('admin.sessions.index') }}" class="btn btn-outline-secondary">
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
