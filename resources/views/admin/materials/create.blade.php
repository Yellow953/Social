@extends('layouts.dashboard')

@section('title', 'Create Material | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.materials.index') }}">Materials</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-plus me-2" style="color: #ec682a;"></i>Create New Material</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label fw-bold">Material Title <span class="text-danger">*</span></label>
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
                                          placeholder="Material description...">{{ old('description') }}</textarea>
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

                            <!-- Type -->
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label fw-bold">Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="">Select type</option>
                                    <option value="cours" {{ old('type') == 'cours' ? 'selected' : '' }}>Cours</option>
                                    <option value="tp" {{ old('type') == 'tp' ? 'selected' : '' }}>TP</option>
                                    <option value="video_recording" {{ old('type') == 'video_recording' ? 'selected' : '' }}>Video recording</option>
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
                                           {{ old('is_locked', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_locked">
                                        <strong>Locked Material</strong> (Requires subscription to access)
                                    </label>
                                    @error('is_locked')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Media Files -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold mb-3">Material Media Files</label>
                                <div id="media-dropzone" class="dropzone-modern">
                                    <div class="dz-message">
                                        <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #ec682a;"></i>
                                        <h5 class="mb-2">Drop files here or click to upload</h5>
                                        <p class="text-muted mb-0">Supported: PDF, Video (MP4, WebM, OGG, MOV, AVI), Images (JPG, PNG, GIF, WEBP)</p>
                                    </div>
                                </div>
                                <div id="media-preview" class="mt-3 row g-3"></div>
                                <input type="hidden" name="media_files" id="media-files-input">
                                @error('media')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Material
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.2/dist/dropzone.css" />
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

    #media-preview {
        min-height: 100px;
    }

    #media-preview .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    #media-preview .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }

    .dropzone-modern .dz-preview {
        margin: 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Disable auto-discover
    Dropzone.autoDiscover = false;

    // Store files to be submitted with form
    const filesToSubmit = [];

    // Initialize Dropzone
    const mediaDropzone = new Dropzone("#media-dropzone", {
        url: "#", // We won't use this URL, files will be submitted with form
        paramName: "media",
        maxFilesize: 500, // 500 MB
        acceptedFiles: ".pdf,.mp4,.webm,.ogg,.mov,.avi,.jpg,.jpeg,.png,.gif,.webp",
        addRemoveLinks: true,
        clickable: true,
        dictDefaultMessage: "",
        dictRemoveFile: '<i class="fas fa-times"></i> Remove',
        dictCancelUpload: '<i class="fas fa-times-circle"></i> Cancel',
        dictUploadCanceled: "Upload canceled",
        dictInvalidFileType: "Invalid file type",
        dictFileTooBig: "File is too big (@{{filesize}}MB). Max filesize: @{{maxFilesize}}MB",
        parallelUploads: 10,
        uploadMultiple: false,
        autoProcessQueue: false, // Don't auto-upload, we'll submit with form
        previewTemplate: `
            <div class="col-md-3 mb-3">
                <div class="card border shadow-sm h-100">
                    <div class="card-body p-3 text-center">
                        <div class="dz-image mb-2" style="min-height: 80px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file fa-3x text-muted"></i>
                        </div>
                        <div class="dz-details">
                            <div class="dz-filename small text-truncate mb-1" style="max-width: 100%;" title=""><span data-dz-name></span></div>
                            <div class="dz-size small text-muted mb-2" data-dz-size></div>
                            <div class="dz-progress" style="display: none;">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" data-dz-uploadprogress></div>
                                </div>
                            </div>
                            <div class="dz-error-message text-danger small mt-2" style="display: none;"><span data-dz-errormessage></span></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-2 dz-remove" data-dz-remove>
                            <i class="fas fa-times me-1"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        `,
        init: function() {
            const dropzone = this;
            const form = document.querySelector('form[action="{{ route('admin.materials.store') }}"]');
            const previewContainer = document.getElementById('media-preview');

            // Move previews to custom container
            dropzone.on('addedfile', function(file) {
                // Set custom icon based on file type
                const ext = file.name.split('.').pop().toLowerCase();
                let iconClass = 'fa-file text-secondary';
                let iconColor = '';
                
                if (ext === 'pdf') {
                    iconClass = 'fa-file-pdf';
                    iconColor = 'text-danger';
                } else if (['mp4', 'webm', 'ogg', 'mov', 'avi'].includes(ext)) {
                    iconClass = 'fa-file-video';
                    iconColor = 'text-primary';
                } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    iconClass = 'fa-file-image';
                    iconColor = 'text-success';
                }
                
                // Update icon in preview
                setTimeout(() => {
                    const previewElement = file.previewElement;
                    if (previewElement) {
                        const imageContainer = previewElement.querySelector('.dz-image');
                        if (imageContainer) {
                            imageContainer.innerHTML = `<i class="fas ${iconClass} fa-3x ${iconColor}"></i>`;
                        }
                    }
                }, 10);

                // Store file for form submission
                filesToSubmit.push(file);
                
                // Move preview to custom container
                if (previewContainer && file.previewElement) {
                    previewContainer.appendChild(file.previewElement);
                }
            });

            // Handle file removal
            dropzone.on('removedfile', function(file) {
                // Remove from files array
                const index = filesToSubmit.indexOf(file);
                if (index > -1) {
                    filesToSubmit.splice(index, 1);
                }
            });

            // Handle errors
            dropzone.on('error', function(file, errorMessage) {
                console.error('Dropzone error:', file.name, errorMessage);
                // Remove from files array on error
                const index = filesToSubmit.indexOf(file);
                if (index > -1) {
                    filesToSubmit.splice(index, 1);
                }
            });

            // Intercept form submission
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Add files to form data
                    if (filesToSubmit.length > 0) {
                        // Create a new FormData from the form
                        const formData = new FormData(form);
                        
                        // Add all files
                        filesToSubmit.forEach((file) => {
                            formData.append('media[]', file);
                        });

                        // Prevent default submission
                        e.preventDefault();
                        e.stopPropagation();

                        // Disable submit button
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Session...';
                        }

                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || 
                                         form.querySelector('input[name="_token"]')?.value;

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
                            } else if (response.ok) {
                                return response.text().then(html => {
                                    // If response contains HTML (validation errors), update page
                                    document.open();
                                    document.write(html);
                                    document.close();
                                });
                            } else {
                                throw new Error('Server error: ' + response.status);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Create Session';
                            }
                        });
                    }
                    // If no files, let form submit normally
                });
            }
        }
    });
});
</script>
@endpush
@endsection
