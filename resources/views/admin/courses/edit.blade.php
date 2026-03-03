@extends('layouts.dashboard')

@section('title', 'Edit Course | ESIB SOCIAL Admin')

@section('breadcrumb')
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
                            <div class="col-md-4 mb-3">
                                <label for="major" class="form-label fw-bold">Major / Speciality <span class="text-danger">*</span></label>
                                <select class="form-control @error('major') is-invalid @enderror"
                                        id="major"
                                        name="major" required>
                                    <option value="">Select major</option>
                                    @foreach(config('majors') as $major)
                                        <option value="{{ $major }}" {{ old('major', $course->major) == $major ? 'selected' : '' }}>{{ $major }}</option>
                                    @endforeach
                                </select>
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year -->
                            <div class="col-md-4 mb-3">
                                <label for="year" class="form-label fw-bold">Year <span class="text-danger">*</span></label>
                                <select class="form-control @error('year') is-invalid @enderror"
                                        id="year"
                                        name="year">
                                    <option value="">Select year</option>
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

                            <!-- Semester -->
                            <div class="col-md-4 mb-3">
                                <label for="semester" class="form-label fw-bold">Semester <span class="text-danger">*</span></label>
                                <select class="form-control @error('semester') is-invalid @enderror"
                                        id="semester"
                                        name="semester"
                                        required>
                                    <option value="">Select semester</option>
                                    <option value="1" {{ old('semester', $course->semester) == '1' ? 'selected' : '' }}>Semester 1</option>
                                    <option value="2" {{ old('semester', $course->semester) == '2' ? 'selected' : '' }}>Semester 2</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2 justify-content-between">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Course
                                </button>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteCourseModal">
                                <i class="fas fa-trash me-2"></i>Delete Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Materials Preview Card -->
        <div class="col-md-8 mt-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;">
                        <i class="fas fa-folder-open me-2" style="color: #ec682a;"></i>Materials
                        <span class="badge ms-2" style="background: #ec682a; font-size: 0.75rem;">{{ $course->materials->count() }}</span>
                    </h5>
                    <a href="{{ route('admin.materials.create') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-plus me-1"></i>Add Material
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($course->materials->isEmpty())
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block" style="color: #d1d5db;"></i>
                            No materials yet for this course.
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($course->materials as $material)
                                <li class="list-group-item d-flex align-items-center justify-content-between px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            @php
                                                $icon = match($material->type) {
                                                    'video_recording' => 'fa-video',
                                                    'tp'              => 'fa-flask',
                                                    default           => 'fa-file-alt',
                                                };
                                            @endphp
                                            <i class="fas {{ $icon }}" style="color: #ec682a;"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $material->title }}</div>
                                            <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">{{ str_replace('_', ' ', $material->type) }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($material->is_locked)
                                            <span class="badge bg-warning text-dark" style="font-size: 0.7rem;"><i class="fas fa-lock me-1"></i>Locked</span>
                                        @endif
                                        <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteMaterialModal"
                                                data-material-id="{{ $material->id }}"
                                                data-material-title="{{ $material->title }}"
                                                data-delete-url="{{ route('admin.materials.destroy', $material) }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Material Modal -->
<div class="modal fade" id="deleteMaterialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Material
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="mb-0">Are you sure you want to delete <strong id="deleteMaterialTitle"></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteMaterialForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('deleteMaterialModal').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('deleteMaterialTitle').textContent = btn.dataset.materialTitle;
    document.getElementById('deleteMaterialForm').action = btn.dataset.deleteUrl;
});
</script>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="deleteCourseModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Delete Course
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <p class="mb-1">Are you sure you want to delete <strong>{{ $course->name }}</strong>?</p>
                @if($course->materials->isNotEmpty())
                    <div class="alert alert-warning py-2 mt-3 mb-0" style="font-size: 0.875rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        This course has <strong>{{ $course->materials->count() }}</strong> material(s). You must delete or reassign them first.
                    </div>
                @else
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                @endif
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                @if($course->materials->isEmpty())
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Yes, Delete
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-danger" disabled>
                        <i class="fas fa-trash me-2"></i>Yes, Delete
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
