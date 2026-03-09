@extends('layouts.dashboard')

@section('title', 'Bulk Upload | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.materials.index') }}">Materials</a></li>
    <li class="breadcrumb-item active" aria-current="page">Bulk Upload</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">

            {{-- Step indicator --}}
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="step-pill active" id="pill-1"><span>1</span> Upload files</div>
                <div class="step-arrow"><i class="fas fa-chevron-right text-muted"></i></div>
                <div class="step-pill" id="pill-2"><span>2</span> Assign to materials</div>
                <div class="step-arrow"><i class="fas fa-chevron-right text-muted"></i></div>
                <div class="step-pill" id="pill-3"><span>3</span> Preview &amp; save</div>
            </div>

            {{-- ── Step 1: Upload ─────────────────────────────────────────── --}}
            <div id="step-1">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-left: 4px solid #ec682a !important;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-cloud-upload-alt me-2" style="color: #ec682a;"></i>Step 1 — Upload your files</h5>
                        <small class="text-muted">Files upload immediately. You'll assign them to one or more materials in the next step.</small>
                    </div>
                    <div class="card-body p-4">
                        <div id="media-dropzone" class="dropzone-modern">
                            <div class="dz-message">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: #ec682a;"></i>
                                <h5 class="mb-2">Drop files here or click to upload</h5>
                                <p class="text-muted mb-0">PDF, Video (MP4, WebM, MOV…), Images (JPG, PNG, WEBP…) — max 500 MB each</p>
                            </div>
                        </div>
                        <div id="media-preview" class="mt-3 row g-3"></div>
                    </div>
                    <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3">
                        <a href="{{ route('admin.materials.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Cancel</a>
                        <button id="btn-to-step2" class="btn btn-primary" disabled>
                            Next: Assign to materials <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Step 2: Assign ─────────────────────────────────────────── --}}
            <div id="step-2" style="display:none;">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-left: 4px solid #ec682a !important;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-link me-2" style="color: #ec682a;"></i>Step 2 — Assign files to materials</h5>
                        <small class="text-muted">Each file can be assigned to <strong>multiple materials</strong> — a copy is created for each.</small>
                    </div>
                    <div class="card-body p-4">

                        {{-- Apply-to-all banner --}}
                        <div class="card border bg-light mb-4">
                            <div class="card-body py-3">
                                <p class="fw-bold mb-2 small text-muted text-uppercase">Add this material to all files</p>
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold mb-1">Course</label>
                                        <select id="global-course" class="form-select form-select-sm">
                                            <option value="">— select course —</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }} | {{ $course->code }} | Yr{{ $course->year }} {{ $course->major }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold mb-1">Material</label>
                                        <select id="global-material" class="form-select form-select-sm" disabled>
                                            <option value="">— select material —</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button id="btn-apply-all" class="btn btn-sm btn-outline-primary w-100 mt-3">Add to all files</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Per-file cards --}}
                        <div id="assign-rows"></div>
                    </div>
                    <div class="card-footer bg-white border-top d-flex justify-content-between py-3">
                        <button id="btn-to-step1" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</button>
                        <button id="btn-to-step3" class="btn btn-primary">
                            Next: Preview <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Step 3: Preview & Save ─────────────────────────────────── --}}
            <div id="step-3" style="display:none;">
                <div class="card border-0 shadow-lg overflow-hidden" style="border-left: 4px solid #ec682a !important;">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-check-circle me-2" style="color: #ec682a;"></i>Step 3 — Preview &amp; confirm</h5>
                            <small class="text-muted">Review every assignment before saving. Each line = one file copy created.</small>
                        </div>
                        <div id="preview-summary" class="text-end"></div>
                    </div>
                    <div class="card-body p-4">
                        <div id="preview-errors" class="alert alert-warning d-none mb-4"></div>
                        <div id="preview-cards"></div>
                    </div>
                    <div class="card-footer bg-white border-top d-flex justify-content-between py-3">
                        <button id="btn-to-step2b" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>Back</button>
                        <form id="bulk-form" method="POST" action="{{ route('admin.materials.bulk-assign') }}">
                            @csrf
                            <input type="hidden" name="assignments" id="assignments-input">
                            <button type="submit" id="btn-save" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i>Save all
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.2/dist/dropzone.css" />
<style>
    .step-pill {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 18px; border-radius: 999px;
        background: #f1f5f9; color: #6b7280; font-weight: 600; font-size: .875rem;
        border: 2px solid transparent; transition: all .25s;
    }
    .step-pill span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 24px; height: 24px; border-radius: 50%;
        background: #cbd5e1; color: #fff; font-size: .8rem;
    }
    .step-pill.active { background: #fff3ed; color: #c2410c; border-color: #ec682a; }
    .step-pill.active span { background: #ec682a; }
    .step-pill.done { background: #f0fdf4; color: #166534; border-color: #22c55e; }
    .step-pill.done span { background: #22c55e; }

    .dropzone-modern {
        border: 2px dashed #ec682a !important; border-radius: 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        padding: 40px 20px; text-align: center; transition: all .3s ease;
        min-height: 180px; display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .dropzone-modern:hover { border-color: #d45a20 !important; background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%); }
    .dropzone-modern.dz-drag-hover { border-color: #1d4ed8 !important; background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%); }
    .dropzone-modern .dz-message { margin: 0; cursor: pointer; }
    .dropzone-modern .dz-preview { margin: 0; }
    .dropzone-modern .dz-preview .dz-success-mark,
    .dropzone-modern .dz-preview .dz-error-mark { display: none; }
    #media-preview .card { transition: transform .2s, box-shadow .2s; }
    #media-preview .card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.15) !important; }

    /* file card in step 2 */
    .file-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 16px; overflow: hidden; }
    .file-card-header { background: #f8fafc; border-bottom: 1px solid #e5e7eb; padding: 12px 16px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .file-card-body { padding: 12px 16px; }
    .assignment-row { display: flex; align-items: flex-end; gap: 10px; flex-wrap: wrap; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; }
    .assignment-row:last-child { border-bottom: none; }

    /* preview cards in step 3 */
    .preview-file-card { border: 1px solid #e5e7eb; border-radius: 12px; margin-bottom: 16px; overflow: hidden; }
    .preview-file-card.has-error { border-color: #fbbf24; }
    .preview-file-header { padding: 14px 18px; background: #f8fafc; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .preview-file-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .preview-file-icon.pdf   { background: #fee2e2; color: #dc2626; }
    .preview-file-icon.video { background: #dbeafe; color: #2563eb; }
    .preview-file-icon.image { background: #dcfce7; color: #16a34a; }
    .preview-assignments { padding: 0; }
    .preview-assignment-row { display: flex; align-items: center; gap: 0; padding: 11px 18px; border-top: 1px solid #f1f5f9; flex-wrap: wrap; }
    .preview-assignment-row:hover { background: #fafafa; }
    .preview-assignment-row.error-row { background: #fffbeb; }
    .preview-copy-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 50%; background: #ec682a; color: #fff; font-size: .7rem; font-weight: 700; flex-shrink: 0; margin-right: 14px; }
    .preview-arrow { color: #9ca3af; font-size: .75rem; margin: 0 8px; }
    .preview-course-chip { background: #f1f5f9; color: #475569; border-radius: 6px; padding: 3px 8px; font-size: .78rem; font-weight: 500; }
    .preview-material-chip { background: #fff3ed; color: #c2410c; border-radius: 6px; padding: 3px 8px; font-size: .78rem; font-weight: 600; border: 1px solid #fed7aa; }
    .preview-material-chip.missing { background: #fef9c3; color: #92400e; border-color: #fde68a; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Dropzone.autoDiscover = false;

    /* ── Data ────────────────────────────────────────────────────────── */
    const uploadTempUrl = @json(route('admin.materials.upload-temp'));
    const coursesData   = @json($coursesData);

    const materialMap = {};
    coursesData.forEach(c => {
        c.materials.forEach(m => { materialMap[m.id] = { ...m, courseLabel: c.label, courseId: c.id }; });
    });

    /*
     * files[i] = {
     *   uuid, originalName, type,
     *   displayName, watermarkType, isLocked,
     *   assignments: [ {_courseId, materialId}, ... ]
     * }
     */
    const files = [];

    /* ── Dropzone ────────────────────────────────────────────────────── */
    const previewContainer = document.getElementById('media-preview');
    const btnToStep2       = document.getElementById('btn-to-step2');

    const dz = new Dropzone('#media-dropzone', {
        url: uploadTempUrl,
        paramName: 'file',
        maxFilesize: 500,
        acceptedFiles: '.pdf,.mp4,.webm,.ogg,.mov,.avi,.mkv,.m4v,.jpg,.jpeg,.png,.gif,.webp',
        addRemoveLinks: true,
        clickable: true,
        dictDefaultMessage: '',
        dictRemoveFile: '<i class="fas fa-times"></i> Remove',
        parallelUploads: 3,
        uploadMultiple: false,
        autoProcessQueue: true,
        previewTemplate: `
            <div class="col-md-3 mb-3">
                <div class="card border shadow-sm h-100">
                    <div class="card-body p-3 text-center">
                        <div class="dz-image mb-2" style="min-height:80px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-file fa-3x text-muted"></i></div>
                        <div class="dz-filename small text-truncate mb-1"><span data-dz-name></span></div>
                        <div class="dz-size small text-muted mb-2" data-dz-size></div>
                        <div class="dz-progress mb-1"><div class="progress" style="height:6px;"><div class="progress-bar progress-bar-striped progress-bar-animated" data-dz-uploadprogress style="width:0%;background:linear-gradient(90deg,#ec682a,#c2410c);"></div></div></div>
                        <div class="dz-success small text-success mt-1" style="display:none;"><i class="fas fa-check-circle"></i> Uploaded</div>
                        <div class="dz-error-message text-danger small mt-2" style="display:none;"><span data-dz-errormessage></span></div>
                        <button type="button" class="btn btn-sm btn-danger mt-2 dz-remove" data-dz-remove><i class="fas fa-times me-1"></i> Remove</button>
                    </div>
                </div>
            </div>`,
        init: function () {
            const self = this;

            self.on('addedfile', function (file) {
                const ext = (file.name || '').split('.').pop().toLowerCase();
                let iconClass = 'fa-file text-secondary';
                if (ext === 'pdf') iconClass = 'fa-file-pdf text-danger';
                else if (['mp4','webm','ogg','mov','avi','mkv','m4v'].includes(ext)) iconClass = 'fa-file-video text-primary';
                else if (['jpg','jpeg','png','gif','webp'].includes(ext)) iconClass = 'fa-file-image text-success';
                setTimeout(() => {
                    const img = file.previewElement && file.previewElement.querySelector('.dz-image');
                    if (img) img.innerHTML = `<i class="fas ${iconClass} fa-3x"></i>`;
                }, 10);
                if (previewContainer && file.previewElement) previewContainer.appendChild(file.previewElement);
            });

            self.on('sending', function (file, xhr, formData) {
                const token = document.querySelector('meta[name="csrf-token"]');
                if (token) formData.append('_token', token.getAttribute('content'));
            });

            self.on('uploadprogress', function (file, progress) {
                const bar = file.previewElement && file.previewElement.querySelector('[data-dz-uploadprogress]');
                if (bar) bar.style.width = progress + '%';
            });

            self.on('success', function (file, response) {
                if (!response || !response.id) return;
                file.tempId = response.id;
                files.push({
                    uuid:          response.id,
                    originalName:  response.original_filename || file.name || '',
                    type:          response.type || 'pdf',
                    displayName:   response.original_filename || file.name || '',
                    watermarkType: 'full',
                    isLocked:      true,
                    assignments:   [{ _courseId: '', materialId: null }],
                });
                const prog    = file.previewElement.querySelector('.dz-progress');
                const success = file.previewElement.querySelector('.dz-success');
                if (prog)    prog.style.display    = 'none';
                if (success) success.style.display = 'block';
                updateStep1Btn();
            });

            self.on('removedfile', function (file) {
                if (!file.tempId) return;
                const idx = files.findIndex(f => f.uuid === file.tempId);
                if (idx > -1) files.splice(idx, 1);
                updateStep1Btn();
            });

            self.on('error', function (file, msg) {
                console.error('Upload error:', file.name, msg);
            });
        }
    });

    function updateStep1Btn() {
        const allDone = dz.getUploadingFiles().length === 0 && dz.getQueuedFiles().length === 0;
        btnToStep2.disabled = !(files.length > 0 && allDone);
    }

    /* ── Step navigation ─────────────────────────────────────────────── */
    function showStep(n) {
        [1, 2, 3].forEach(i => {
            document.getElementById('step-' + i).style.display = (i === n) ? '' : 'none';
            const pill = document.getElementById('pill-' + i);
            pill.classList.remove('active', 'done');
            if (i === n) pill.classList.add('active');
            if (i < n)   pill.classList.add('done');
        });
    }

    /* ── Step 2 helpers ──────────────────────────────────────────────── */
    function buildMaterialOptions(courseId, selectedId) {
        const course = coursesData.find(c => c.id == courseId);
        if (!course || !course.materials.length) return '<option value="">— no materials in this course —</option>';
        return '<option value="">— select material —</option>' +
            course.materials.map(m =>
                `<option value="${m.id}" ${m.id == selectedId ? 'selected' : ''}>${escHtml(m.title)}</option>`
            ).join('');
    }

    function fileIconClass(type) {
        if (type === 'video') return 'fa-file-video text-primary';
        if (type === 'image') return 'fa-file-image text-success';
        return 'fa-file-pdf text-danger';
    }

    function renderAssignRows() {
        const container = document.getElementById('assign-rows');
        container.innerHTML = '';

        files.forEach((f, fi) => {
            const card = document.createElement('div');
            card.className = 'file-card';
            card.dataset.fi = fi;

            /* header: icon + name + per-file settings */
            const header = document.createElement('div');
            header.className = 'file-card-header';
            header.innerHTML = `
                <i class="fas ${fileIconClass(f.type)} fa-lg flex-shrink-0"></i>
                <div style="min-width:200px;flex:2;">
                    <label class="form-label small fw-bold mb-1">Display name</label>
                    <input type="text" class="form-control form-control-sm fc-name" value="${escHtml(f.displayName)}" placeholder="File name">
                </div>
                <div style="min-width:140px;flex:1;">
                    <label class="form-label small fw-bold mb-1">Watermark</label>
                    <select class="form-select form-select-sm fc-watermark">
                        <option value="full"          ${f.watermarkType==='full'?'selected':''}>Full</option>
                        <option value="logo_only"     ${f.watermarkType==='logo_only'?'selected':''}>Logo only</option>
                        <option value="username_only" ${f.watermarkType==='username_only'?'selected':''}>Username only</option>
                        <option value="none"          ${f.watermarkType==='none'?'selected':''}>None</option>
                    </select>
                </div>
                <div class="text-center" style="min-width:60px;">
                    <label class="form-label small fw-bold mb-1 d-block">Locked</label>
                    <input type="checkbox" class="form-check-input fc-locked" ${f.isLocked?'checked':''}>
                </div>`;

            header.querySelector('.fc-name').addEventListener('input', e => { files[fi].displayName = e.target.value; });
            header.querySelector('.fc-watermark').addEventListener('change', e => { files[fi].watermarkType = e.target.value; });
            header.querySelector('.fc-locked').addEventListener('change', e => { files[fi].isLocked = e.target.checked; });

            card.appendChild(header);

            /* body: assignment rows */
            const body = document.createElement('div');
            body.className = 'file-card-body';

            const assignLabel = document.createElement('p');
            assignLabel.className = 'small fw-bold text-muted mb-2';
            assignLabel.innerHTML = '<i class="fas fa-link me-1"></i>Assign to materials <span class="text-danger">*</span>';
            body.appendChild(assignLabel);

            const aList = document.createElement('div');
            aList.className = 'assignment-list';
            body.appendChild(aList);

            function renderAssignments() {
                aList.innerHTML = '';
                files[fi].assignments.forEach((a, ai) => {
                    const courseOptions = '<option value="">— select course —</option>' +
                        coursesData.map(c =>
                            `<option value="${c.id}" ${c.id == a._courseId ? 'selected' : ''}>${escHtml(c.label)}</option>`
                        ).join('');

                    const row = document.createElement('div');
                    row.className = 'assignment-row';
                    row.innerHTML = `
                        <div style="min-width:220px;flex:1.5;">
                            <label class="form-label small mb-1">Course</label>
                            <select class="form-select form-select-sm ar-course">${courseOptions}</select>
                        </div>
                        <div style="min-width:220px;flex:1.5;">
                            <label class="form-label small mb-1">Material</label>
                            <select class="form-select form-select-sm ar-material" ${a._courseId ? '' : 'disabled'}>
                                ${a._courseId ? buildMaterialOptions(a._courseId, a.materialId) : '<option value="">— select material —</option>'}
                            </select>
                        </div>
                        <div class="pb-1">
                            <button type="button" class="btn btn-sm btn-outline-danger ar-remove" ${files[fi].assignments.length === 1 ? 'disabled' : ''}>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;

                    const courseSelect   = row.querySelector('.ar-course');
                    const materialSelect = row.querySelector('.ar-material');

                    courseSelect.addEventListener('change', function () {
                        files[fi].assignments[ai]._courseId  = this.value;
                        files[fi].assignments[ai].materialId = null;
                        materialSelect.innerHTML = this.value ? buildMaterialOptions(this.value, null) : '<option value="">— select material —</option>';
                        materialSelect.disabled  = !this.value;
                    });

                    materialSelect.addEventListener('change', function () {
                        files[fi].assignments[ai].materialId = this.value ? parseInt(this.value) : null;
                    });

                    row.querySelector('.ar-remove').addEventListener('click', function () {
                        files[fi].assignments.splice(ai, 1);
                        renderAssignments();
                    });

                    aList.appendChild(row);
                });
            }

            renderAssignments();

            /* "+ Add material" button */
            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'btn btn-sm btn-outline-secondary mt-2';
            addBtn.innerHTML = '<i class="fas fa-plus me-1"></i>Add another material';
            addBtn.addEventListener('click', function () {
                files[fi].assignments.push({ _courseId: '', materialId: null });
                renderAssignments();
            });
            body.appendChild(addBtn);

            card.appendChild(body);
            container.appendChild(card);
        });
    }

    /* Apply-to-all */
    const globalCourse   = document.getElementById('global-course');
    const globalMaterial = document.getElementById('global-material');

    globalCourse.addEventListener('change', function () {
        globalMaterial.innerHTML = this.value
            ? buildMaterialOptions(this.value, null)
            : '<option value="">— select material —</option>';
        globalMaterial.disabled = !this.value;
    });

    document.getElementById('btn-apply-all').addEventListener('click', function () {
        const cid = globalCourse.value;
        const mid = globalMaterial.value ? parseInt(globalMaterial.value) : null;
        if (!cid || !mid) return;
        files.forEach(f => {
            const alreadyAssigned = f.assignments.some(a => a.materialId === mid);
            if (!alreadyAssigned) {
                /* replace the first empty slot, or append */
                const emptyIdx = f.assignments.findIndex(a => !a.materialId);
                if (emptyIdx > -1) {
                    f.assignments[emptyIdx] = { _courseId: cid, materialId: mid };
                } else {
                    f.assignments.push({ _courseId: cid, materialId: mid });
                }
            }
        });
        renderAssignRows();
    });

    /* ── Step 3 ──────────────────────────────────────────────────────── */
    function buildPreview() {
        const container = document.getElementById('preview-cards');
        const errors    = document.getElementById('preview-errors');
        const summary   = document.getElementById('preview-summary');
        container.innerHTML = '';
        errors.classList.add('d-none');
        errors.innerHTML = '';

        const wmLabel = { full: 'Full', logo_only: 'Logo only', username_only: 'Username only', none: 'None' };
        let totalCopies = 0;
        let problems    = 0;

        files.forEach(f => {
            const validAssignments = f.assignments.filter(a => a.materialId);
            const hasError = validAssignments.length === 0;
            if (hasError) problems++;

            totalCopies += validAssignments.length;

            /* card */
            const card = document.createElement('div');
            card.className = 'preview-file-card' + (hasError ? ' has-error' : '');

            /* header */
            const iconType = f.type === 'video' ? 'video' : (f.type === 'image' ? 'image' : 'pdf');
            const iconFa   = f.type === 'video' ? 'fa-file-video' : (f.type === 'image' ? 'fa-file-image' : 'fa-file-pdf');
            const wl       = wmLabel[f.watermarkType] || f.watermarkType;
            const copies   = validAssignments.length;

            card.innerHTML = `
                <div class="preview-file-header">
                    <div class="preview-file-icon ${iconType}"><i class="fas ${iconFa}"></i></div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark small">${escHtml(f.displayName)}</div>
                        <div class="text-muted" style="font-size:.78rem;">${escHtml(f.originalName)}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge rounded-pill" style="background:#f1f5f9;color:#475569;font-weight:500;">
                            <i class="fas fa-droplet me-1" style="color:#ec682a;"></i>${escHtml(wl)}
                        </span>
                        ${f.isLocked
                            ? '<span class="badge rounded-pill bg-danger"><i class="fas fa-lock me-1"></i>Locked</span>'
                            : '<span class="badge rounded-pill bg-success"><i class="fas fa-lock-open me-1"></i>Public</span>'}
                        ${hasError
                            ? '<span class="badge rounded-pill bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>No material assigned</span>'
                            : `<span class="badge rounded-pill" style="background:#fff3ed;color:#c2410c;border:1px solid #fed7aa;">${copies} cop${copies === 1 ? 'y' : 'ies'}</span>`}
                    </div>
                </div>
                <div class="preview-assignments"></div>`;

            const assignContainer = card.querySelector('.preview-assignments');

            if (hasError) {
                assignContainer.innerHTML = `<div class="preview-assignment-row error-row">
                    <span class="text-warning me-2"><i class="fas fa-exclamation-triangle"></i></span>
                    <span class="small text-muted">No material assigned — go back and fix this file.</span>
                </div>`;
            } else {
                validAssignments.forEach((a, ai) => {
                    const mat    = materialMap[a.materialId];
                    const course = mat ? coursesData.find(c => c.id == mat.courseId) : null;

                    const row = document.createElement('div');
                    row.className = 'preview-assignment-row';
                    row.innerHTML = `
                        <span class="preview-copy-badge">${ai + 1}</span>
                        <span class="preview-course-chip me-1">${escHtml(course ? course.label : '—')}</span>
                        <span class="preview-arrow"><i class="fas fa-chevron-right"></i></span>
                        <span class="preview-material-chip">${escHtml(mat ? mat.title : '—')}</span>`;
                    assignContainer.appendChild(row);
                });
            }

            container.appendChild(card);
        });

        /* summary badge */
        summary.innerHTML = totalCopies > 0
            ? `<span class="fw-bold" style="color:#166534;">${totalCopies} file cop${totalCopies===1?'y':'ies'}</span>
               <span class="text-muted small d-block">will be created</span>`
            : '';

        if (problems > 0) {
            errors.classList.remove('d-none');
            errors.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i><strong>${problems} file(s) have no material assigned.</strong> Go back and fix them before saving.`;
        }
        document.getElementById('btn-save').disabled = problems > 0;
    }

    /* ── Navigation wiring ───────────────────────────────────────────── */
    btnToStep2.addEventListener('click', function () { renderAssignRows(); showStep(2); });
    document.getElementById('btn-to-step1').addEventListener('click', () => showStep(1));
    document.getElementById('btn-to-step2b').addEventListener('click', () => { renderAssignRows(); showStep(2); });

    document.getElementById('btn-to-step3').addEventListener('click', function () {
        buildPreview();
        showStep(3);
    });

    document.getElementById('bulk-form').addEventListener('submit', function () {
        /* flatten: one entry per file, with array of material_ids */
        const payload = files.map(f => ({
            uuid:           f.uuid,
            display_name:   f.displayName || f.originalName,
            watermark_type: f.watermarkType,
            is_locked:      f.isLocked,
            material_ids:   f.assignments.map(a => a.materialId).filter(Boolean),
        }));
        document.getElementById('assignments-input').value = JSON.stringify(payload);
    });

    /* ── Helpers ─────────────────────────────────────────────────────── */
    function escHtml(str) {
        return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
});
</script>
@endpush
@endsection
