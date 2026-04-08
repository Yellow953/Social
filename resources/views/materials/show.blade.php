@extends('layouts.dashboard')

@section('title', $material->title . ' | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('academique') }}">Académique</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($material->title, 30) }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- Material Details -->
            <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3">{{ $material->title }}</h3>
                    @if($material->description)
                        <p class="text-muted">{{ $material->description }}</p>
                    @endif
                    <div class="d-flex gap-4 text-muted">
                        <div>
                            <i class="fas fa-book me-2"></i>
                            <strong>Course:</strong> {{ $material->course->name }}
                        </div>
                        <div>
                            <i class="fas fa-tag me-2"></i>
                            <strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $material->type)) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Files (loaded dynamically) -->
            <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file me-2 text-primary"></i>Material Media</h5>
                    <div id="sort-controls" class="d-none d-flex align-items-center gap-2">
                        <span class="text-muted small">Sort by:</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary sort-btn active" data-sort="order" data-dir="asc">Default</button>
                            <button type="button" class="btn btn-outline-secondary sort-btn" data-sort="name" data-dir="asc">Name <i class="fas fa-sort-alpha-down ms-1"></i></button>
                            <button type="button" class="btn btn-outline-secondary sort-btn" data-sort="type" data-dir="asc">Type</button>
                            <button type="button" class="btn btn-outline-secondary sort-btn" data-sort="size" data-dir="desc">Size <i class="fas fa-sort-amount-down ms-1"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="media-loading" class="text-center py-5 text-muted">
                        <div class="spinner-border mb-2" role="status"></div>
                        <p class="mb-0">Loading media...</p>
                    </div>
                    <div id="media-list-wrap" class="row g-3 d-none"></div>
                    <div id="media-empty" class="text-center py-4 text-muted d-none">
                        <i class="fas fa-file mb-2" style="font-size: 2.5rem;"></i>
                        <p class="mb-0">No media files available for this material</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .media-card {
        transition: all 0.3s ease;
    }

    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
        border-color: #ec682a !important;
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    const mediaApiUrl = @json(route('materials.media', $material));
    const loadingEl = document.getElementById('media-loading');
    const listWrap = document.getElementById('media-list-wrap');
    const emptyEl = document.getElementById('media-empty');
    const sortControls = document.getElementById('sort-controls');
    const subscriptionUrl = @json(route('subscriptions.index'));

    let allMedia = [];
    let currentSort = 'order';
    let currentDir = { order: 'asc', name: 'asc', type: 'asc', size: 'desc' };

    const typeOrder = { pdf: 0, video: 1, image: 2 };

    function escapeHtml(s) {
        const div = document.createElement('div');
        div.textContent = s;
        return div.innerHTML;
    }

    function typeIcon(type) {
        if (type === 'pdf') return '<i class="fas fa-file-pdf fa-4x text-danger"></i>';
        if (type === 'video') return '<i class="fas fa-file-video fa-4x text-primary"></i>';
        return '<i class="fas fa-file-image fa-4x text-success"></i>';
    }

    function typeBadgeClass(type) {
        if (type === 'pdf') return 'danger';
        if (type === 'video') return 'primary';
        return 'success';
    }

    function renderCard(m) {
        var col = document.createElement('div');
        col.className = 'col-md-4 col-sm-6';
        var href = m.can_access ? m.detail_url : subscriptionUrl;
        var lockBadge = !m.can_access
            ? '<span class="badge bg-warning text-dark mt-2 mx-1"><i class="fas fa-lock me-1"></i>Subscription required</span>'
            : (m.is_locked ? '<span class="badge bg-secondary mt-2"><i class="fas fa-lock me-1"></i>Protected</span>' : '');
        col.innerHTML = '<a href="' + escapeHtml(href) + '" class="text-decoration-none">' +
            '<div class="card border shadow-sm h-100 media-card" style="transition: all 0.3s ease; cursor: pointer;">' +
            '<div class="card-body text-center p-4">' +
            '<div class="mb-3">' + typeIcon(m.type) + '</div>' +
            '<h6 class="mb-2 text-dark text-truncate" style="max-width: 100%;" title="' + escapeHtml(m.original_filename) + '">' + escapeHtml(m.original_filename) + '</h6>' +
            '<small class="text-muted">' + escapeHtml(m.formatted_file_size || '') + '</small>' +
            '<div class="mt-3"><span class="badge bg-' + typeBadgeClass(m.type) + ' mx-1">' + escapeHtml((m.type || '').charAt(0).toUpperCase() + (m.type || '').slice(1)) + '</span>' + lockBadge + '</div>' +
            '</div></div></a>';
        return col;
    }

    function sortedMedia() {
        const key = currentSort;
        const dir = currentDir[key] === 'asc' ? 1 : -1;
        return [...allMedia].sort(function(a, b) {
            if (key === 'name') return dir * a.original_filename.localeCompare(b.original_filename);
            if (key === 'type') return dir * ((typeOrder[a.type] ?? 9) - (typeOrder[b.type] ?? 9));
            if (key === 'size') return dir * ((a.file_size || 0) - (b.file_size || 0));
            return dir * (a._index - b._index); // 'order' = original server order
        });
    }

    function renderAll() {
        listWrap.innerHTML = '';
        sortedMedia().forEach(function(m) {
            listWrap.appendChild(renderCard(m));
        });
    }

    // Sort button click handler
    document.querySelectorAll('.sort-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const sort = this.dataset.sort;
            if (currentSort === sort) {
                // Toggle direction
                currentDir[sort] = currentDir[sort] === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort = sort;
            }
            // Update button states and icons
            document.querySelectorAll('.sort-btn').forEach(function(b) {
                b.classList.remove('active');
                // Reset direction icons
                const s = b.dataset.sort;
                if (s === 'name') b.innerHTML = 'Name <i class="fas fa-sort-alpha-' + (currentSort === 'name' && currentDir.name === 'desc' ? 'up' : 'down') + ' ms-1"></i>';
                if (s === 'size') b.innerHTML = 'Size <i class="fas fa-sort-amount-' + (currentSort === 'size' && currentDir.size === 'asc' ? 'up' : 'down') + ' ms-1"></i>';
            });
            this.classList.add('active');
            renderAll();
        });
    });

    fetch(mediaApiUrl, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        credentials: 'same-origin'
    })
        .then(r => r.json())
        .then(data => {
            loadingEl.classList.add('d-none');
            var media = data.media || [];
            if (media.length === 0) {
                emptyEl.classList.remove('d-none');
                return;
            }
            // Tag each item with its original index for "Default" sort
            allMedia = media.map(function(m, i) { return Object.assign({ _index: i }, m); });
            listWrap.classList.remove('d-none');
            if (media.length > 1) sortControls.classList.remove('d-none');
            renderAll();
        })
        .catch(function() {
            loadingEl.classList.add('d-none');
            emptyEl.classList.remove('d-none');
            emptyEl.querySelector('p').textContent = 'Unable to load media. Please refresh the page.';
        });
})();
</script>
@endpush
@endsection
