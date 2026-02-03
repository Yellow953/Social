@extends('layouts.dashboard')

@section('title', 'Edit Material | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.materials.index') }}">Materials</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-edit me-2" style="color: #ec682a;"></i>Edit Material</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.materials.update', $material) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">Material Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $material->title) }}"
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
                                          placeholder="Material description...">{{ old('description', $material->description) }}</textarea>
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
                                        <option value="{{ $course->id }}" {{ old('course_id', $material->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }} ({{ $course->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="">Select type</option>
                                    <option value="cours" {{ old('type', $material->type) == 'cours' ? 'selected' : '' }}>Cours</option>
                                    <option value="tp" {{ old('type', $material->type) == 'tp' ? 'selected' : '' }}>TP</option>
                                    <option value="video_recording" {{ old('type', $material->type) == 'video_recording' ? 'selected' : '' }}>Video recording</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Is Locked -->
                            <div class="col-md-12 mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('is_locked') is-invalid @enderror"
                                           type="checkbox"
                                           id="is_locked"
                                           name="is_locked"
                                           value="1"
                                           {{ old('is_locked', $material->is_locked) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_locked">
                                        <strong>Locked Material</strong> (Requires subscription to access)
                                    </label>
                                    @error('is_locked')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Existing Media -->
                            @if($material->media->count() > 0)
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold mb-3">Existing Media Files</label>
                                <div class="row g-3" id="existing-media-list">
                                    @foreach($material->media as $media)
                                    <div class="col-md-4">
                                        <div class="card border shadow-sm">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-{{ $media->type === 'pdf' ? 'file-pdf text-danger' : ($media->type === 'video' ? 'file-video text-primary' : 'file-image text-success') }} fa-2x me-2"></i>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0 text-truncate" style="max-width: 200px;" title="{{ $media->original_filename }}">{{ $media->original_filename }}</h6>
                                                        <small class="text-muted">{{ $media->formatted_file_size }}</small>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="delete_media[]" value="{{ $media->id }}" id="delete_media_{{ $media->id }}">
                                                    <label class="form-check-label text-danger" for="delete_media_{{ $media->id }}">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Media Files -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold mb-3">Add More Media Files</label>
                                <div id="media-dropzone" class="dropzone-modern">
                                    <div class="dz-message">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #ec682a;"></i>
                                        <h5 class="mb-2">Drop files here or click to upload</h5>
                                        <p class="text-muted mb-0">Supported: PDF, Video (MP4, WebM, OGG, MOV, AVI), Images (JPG, PNG, GIF, WEBP)</p>
                                    </div>
                                </div>
                                <div id="media-preview" class="mt-3"></div>
                                @error('media')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Material
                            </button>
                            <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
@vite(['resources/js/dropzone-init.js'])
<style>
    .dropzone-modern {
        border: 2px dashed #ec682a !important;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .dropzone-modern:hover {
        border-color: #d45a20 !important;
        background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
    }

    .dropzone-modern.dz-drag-hover {
        border-color: #1d4ed8 !important;
        background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
    }

    .dropzone-modern .dz-message {
        margin: 0;
        cursor: pointer;
    }
    
    .dropzone-modern {
        cursor: pointer;
    }

    .dropzone-modern .dz-preview {
        margin: 10px;
        display: inline-block;
        vertical-align: top;
    }

    .dropzone-modern .dz-preview .dz-image {
        border-radius: 8px;
        overflow: hidden;
    }

    .dropzone-modern .dz-preview .dz-details {
        background: white;
        border-radius: 8px;
        padding: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .dropzone-modern .dz-preview .dz-filename {
        font-weight: 600;
        color: #c2410c;
    }

    .dropzone-modern .dz-preview .dz-size {
        color: #6b7280;
        font-size: 0.875rem;
    }

    .dropzone-modern .dz-preview .dz-progress {
        border-radius: 4px;
        height: 6px;
        background: #e5e7eb;
        margin-top: 8px;
    }

    .dropzone-modern .dz-preview .dz-progress .dz-upload {
        background: linear-gradient(90deg, #ec682a 0%, #c2410c 100%);
        border-radius: 4px;
    }

    .dropzone-modern .dz-preview .dz-error-message {
        background: #ef4444;
        color: white;
        border-radius: 4px;
        padding: 8px;
        margin-top: 8px;
        font-size: 0.875rem;
    }

    .dropzone-modern .dz-preview .dz-success-mark,
    .dropzone-modern .dz-preview .dz-error-mark {
        display: none;
    }
</style>
@endpush

@push('scripts')
@vite(['resources/js/dropzone-init.js'])
<script>
    // Wait for DOM and Dropzone to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Disable auto-discover to prevent conflicts
        if (typeof Dropzone !== 'undefined') {
            Dropzone.autoDiscover = false;

    // Initialize Dropzone
    const mediaDropzone = new Dropzone("#media-dropzone", {
        url: "{{ route('admin.materials.update', $material) }}",
        paramName: "media",
        maxFilesize: 500, // 500 MB
        acceptedFiles: ".pdf,.mp4,.webm,.ogg,.mov,.avi,.jpg,.jpeg,.png,.gif,.webp",
        addRemoveLinks: true,
        clickable: true, // Explicitly enable clicking
        dictDefaultMessage: "",
        dictRemoveFile: '<i class="fas fa-times"></i> Remove',
        dictCancelUpload: '<i class="fas fa-times-circle"></i> Cancel',
        dictUploadCanceled: "Upload canceled",
        dictInvalidFileType: "Invalid file type",
        dictFileTooBig: "File is too big (@{{filesize}}MB). Max filesize: @{{maxFilesize}}MB",
        parallelUploads: 5,
        uploadMultiple: true,
        autoProcessQueue: false, // We'll process on form submit
        previewTemplate: `
            <div class="dz-preview dz-file-preview">
                <div class="dz-image">
                    <img data-dz-thumbnail />
                </div>
                <div class="dz-details">
                    <div class="dz-filename"><span data-dz-name></span></div>
                    <div class="dz-size" data-dz-size></div>
                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span></div>
                </div>
                <div class="dz-remove" data-dz-remove>
                    <i class="fas fa-times"></i>
                </div>
            </div>
        `,
        init: function() {
            const dropzone = this;
            const form = document.querySelector('form');

            // Always intercept form submission to include Dropzone files
            if (!form) {
                return;
            }

            form.addEventListener('submit', function(e) {
                // Get files from Dropzone
                const files = dropzone.getAcceptedFiles();
                
                if (files.length > 0) {
                    // Prevent default form submission
                    e.preventDefault();
                    e.stopPropagation();

                    // Create FormData from the form
                    const formData = new FormData(form);

                    // Add all Dropzone files to FormData
                    files.forEach((file, index) => {
                        formData.append('media[]', file);
                    });

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                                     form.querySelector('input[name="_token"]')?.value;

                    if (!csrfToken) {
                        return;
                    }

                    // Submit via fetch
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            return response.text().then(html => {
                                document.open();
                                document.write(html);
                                document.close();
                            });
                        }
                    });
                }
            });
        }
    });

    // Custom file type icons
    mediaDropzone.on("addedfile", function(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        let icon = 'fa-file';
        
        if (['pdf'].includes(ext)) icon = 'fa-file-pdf text-danger';
        else if (['mp4', 'webm', 'ogg', 'mov', 'avi'].includes(ext)) icon = 'fa-file-video text-primary';
        else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) icon = 'fa-file-image text-success';
        
        file.previewElement.querySelector('.dz-image').innerHTML = `<i class="fas ${icon} fa-4x" style="padding: 20px;"></i>`;
    });
        }
    });
</script>
@endpush
@endsection
