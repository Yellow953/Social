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
                            <div class="col-md-12 mb-3">
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

                            <!-- Watermark on media -->
                            <div class="col-md-6 mb-4">
                                <label for="watermark_type" class="form-label fw-bold">Watermark on media</label>
                                <select class="form-control @error('watermark_type') is-invalid @enderror"
                                        id="watermark_type"
                                        name="watermark_type">
                                    <option value="full" {{ old('watermark_type', 'full') == 'full' ? 'selected' : '' }}>Full (logo + username)</option>
                                    <option value="logo_only" {{ old('watermark_type') == 'logo_only' ? 'selected' : '' }}>Only logo</option>
                                    <option value="username_only" {{ old('watermark_type') == 'username_only' ? 'selected' : '' }}>Only username</option>
                                    <option value="none" {{ old('watermark_type') == 'none' ? 'selected' : '' }}>No watermark</option>
                                </select>
                                <small class="text-muted">Applied when users view PDF, images, or video.</small>
                                @error('watermark_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <input type="hidden" name="material_temp_uploads" id="material-temp-uploads-input" value="">
                                <input type="hidden" name="material_temp_names" id="material-temp-names-input" value="">
                                <small class="text-muted d-block mt-1">Rename files in the boxes below. Images are compressed (max width 1920px). PDF and video are stored as-is. For large videos, ensure <code>upload_max_filesize</code> and <code>post_max_size</code> in php.ini are sufficient (e.g. 512M).</small>
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
    Dropzone.autoDiscover = false;
    const uploadTempUrl = @json(route('admin.materials.upload-temp'));
    const tempIds = [];
    const tempNames = {};
    const hiddenInput = document.getElementById('material-temp-uploads-input');
    const hiddenNamesInput = document.getElementById('material-temp-names-input');
    const previewContainer = document.getElementById('media-preview');
    function syncTempNames() { hiddenNamesInput.value = JSON.stringify(tempNames); }

    const mediaDropzone = new Dropzone("#media-dropzone", {
        url: uploadTempUrl,
        paramName: "file",
        maxFilesize: 500,
        acceptedFiles: ".pdf,.mp4,.webm,.ogg,.mov,.avi,.mkv,.m4v,.jpg,.jpeg,.png,.gif,.webp",
        addRemoveLinks: true,
        clickable: true,
        dictDefaultMessage: "",
        dictRemoveFile: '<i class="fas fa-times"></i> Remove',
        dictCancelUpload: '<i class="fas fa-times-circle"></i> Cancel',
        parallelUploads: 3,
        uploadMultiple: false,
        autoProcessQueue: true,
        previewTemplate: `
            <div class="col-md-3 mb-3">
                <div class="card border shadow-sm h-100">
                    <div class="card-body p-3 text-center">
                        <div class="dz-image mb-2" style="min-height: 80px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-file fa-3x text-muted"></i></div>
                        <div class="dz-details">
                            <div class="dz-filename small text-truncate mb-1" style="max-width: 100%;" title=""><span data-dz-name></span></div>
                            <div class="dz-size small text-muted mb-2" data-dz-size></div>
                            <div class="dz-progress" style="display: none;"><div class="progress" style="height: 6px;"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" data-dz-uploadprogress style="width: 0%;"></div></div></div>
                            <div class="dz-success small text-success mt-1" style="display: none;"><i class="fas fa-check-circle"></i> Uploaded</div>
                            <div class="dz-rename-wrap mt-2" style="display: none;"><label class="form-label small mb-0">File name</label><input type="text" class="form-control form-control-sm dz-rename-input" placeholder="Rename" data-dz-rename></div>
                            <div class="dz-error-message text-danger small mt-2" style="display: none;"><span data-dz-errormessage></span></div>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-2 dz-remove" data-dz-remove><i class="fas fa-times me-1"></i> Remove</button>
                    </div>
                </div>
            </div>
        `,
        init: function() {
            const dz = this;
            dz.on('addedfile', function(file) {
                var ext = (file.name || '').split('.').pop().toLowerCase();
                var iconClass = 'fa-file text-secondary', iconColor = '';
                if (ext === 'pdf') { iconClass = 'fa-file-pdf'; iconColor = 'text-danger'; }
                else if (['mp4','webm','ogg','mov','avi','mkv','m4v'].includes(ext)) { iconClass = 'fa-file-video'; iconColor = 'text-primary'; }
                else if (['jpg','jpeg','png','gif','webp'].includes(ext)) { iconClass = 'fa-file-image'; iconColor = 'text-success'; }
                setTimeout(function() {
                    var el = file.previewElement;
                    if (el) {
                        var img = el.querySelector('.dz-image');
                        if (img) img.innerHTML = '<i class="fas ' + iconClass + ' fa-3x ' + iconColor + '"></i>';
                    }
                }, 10);
                if (previewContainer && file.previewElement) previewContainer.appendChild(file.previewElement);
            });
            dz.on('sending', function(file, xhr, formData) {
                var prog = file.previewElement.querySelector('.dz-progress');
                var successEl = file.previewElement.querySelector('.dz-success');
                if (prog) prog.style.display = 'block';
                if (successEl) successEl.style.display = 'none';
                var token = document.querySelector('meta[name="csrf-token"]');
                if (token) formData.append('_token', token.getAttribute('content'));
            });
            dz.on('uploadprogress', function(file, progress) {
                var bar = file.previewElement.querySelector('[data-dz-uploadprogress]');
                if (bar) bar.style.width = progress + '%';
            });
            dz.on('success', function(file, response) {
                if (response && response.id) {
                    tempIds.push(response.id);
                    hiddenInput.value = JSON.stringify(tempIds);
                    tempNames[response.id] = response.original_filename || file.name || '';
                    syncTempNames();
                    var renameWrap = file.previewElement.querySelector('.dz-rename-wrap');
                    var renameInput = file.previewElement.querySelector('.dz-rename-input');
                    if (renameWrap && renameInput) {
                        renameWrap.style.display = 'block';
                        renameInput.value = tempNames[response.id];
                        renameInput.addEventListener('input', function() {
                            tempNames[response.id] = this.value.trim() || response.original_filename || file.name || '';
                            syncTempNames();
                        });
                    }
                }
                var prog = file.previewElement.querySelector('.dz-progress');
                var successEl = file.previewElement.querySelector('.dz-success');
                if (prog) prog.style.display = 'none';
                if (successEl) successEl.style.display = 'block';
            });
            dz.on('removedfile', function(file) {
                if (file.tempId) {
                    var i = tempIds.indexOf(file.tempId);
                    if (i > -1) tempIds.splice(i, 1);
                    delete tempNames[file.tempId];
                    hiddenInput.value = JSON.stringify(tempIds);
                    syncTempNames();
                }
            });
            dz.on('error', function(file, msg) {
                if (file.xhr && file.xhr.response) {
                    try { var r = JSON.parse(file.xhr.response); if (r.error) msg = r.error; } catch(e) {}
                }
                console.error('Upload error:', file.name, msg);
            });
            dz.on('complete', function(file) {
                if (file.status === 'success' && file.xhr && file.xhr.response) {
                    try {
                        var r = JSON.parse(file.xhr.response);
                        if (r.id) file.tempId = r.id;
                    } catch(e) {}
                }
            });
        }
    });
});
</script>
@endpush
@endsection
