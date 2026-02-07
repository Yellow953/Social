@extends('layouts.dashboard')

@section('title', $media->original_filename . ' | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('academique') }}">Académique</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materials.show', $material) }}">{{ Str::limit($material->title, 30) }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($media->original_filename, 30) }}</li>
@endsection

@section('content')
@php
    $watermarkType = $material->watermark_type ?? 'full';
    $showLogo = in_array($watermarkType, ['full', 'logo_only']);
    $showUsername = in_array($watermarkType, ['full', 'username_only']);
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('materials.show', $material) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Material
                </a>
            </div>

            <!-- Media Viewer Card -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-{{ $media->type === 'pdf' ? 'file-pdf' : ($media->type === 'video' ? 'video' : 'image') }} me-2 text-{{ $media->type === 'pdf' ? 'danger' : ($media->type === 'video' ? 'primary' : 'success') }}"></i>
                            {{ $media->original_filename }}
                        </h5>
                        <small class="text-muted">{{ $media->formatted_file_size }}</small>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="media-container" data-media-type="{{ $media->type }}" data-media-id="{{ $media->id }}">
                        @if($media->type === 'pdf')
                            <div id="pdf-viewer-container-{{ $media->id }}" class="pdf-viewer-container" data-pdf-logo-url="{{ asset('assets/images/logo-transparent.png') }}" data-watermark-type="{{ $watermarkType }}" style="position: relative; width: 100%; min-height: 80vh; border: 1px solid #ddd; background: #f5f5f5; overflow: auto;">
                                @if($showUsername)
                                <div id="pdf-watermark-{{ $media->id }}" class="pdf-watermark-overlay media-watermark-pdf-wrap">
                                    <div class="media-username-pattern media-username-pattern-pdf">
                                        @for($i = 0; $i < 80; $i++)
                                            <span class="media-username-pattern-item">{{ strtoupper(auth()->user()->name) }}</span>
                                        @endfor
                                    </div>
                                </div>
                                @endif
                                <div id="pdf-pages-{{ $media->id }}" class="pdf-pages" style="padding: 20px; position: relative; z-index: 1;"></div>
                                <div id="pdf-loading-{{ $media->id }}" class="text-center py-5 text-muted" style="position: relative; z-index: 60;">
                                    <div class="spinner-border mb-2" role="status"></div>
                                    <p class="mb-0">Loading document...</p>
                                </div>
                            </div>
                            <input type="hidden" id="pdf-view-url-{{ $media->id }}" value="{{ route('media.view', $media) }}">
                        @elseif($media->type === 'image')
                            <div class="image-viewer-container" style="position: relative; width: 100%; text-align: center; background: #f5f5f5; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ route('media.view', $media) }}" 
                                     alt="{{ $media->original_filename }}"
                                     class="img-fluid"
                                     style="max-width: 100%; max-height: 80vh; height: auto;"
                                     oncontextmenu="return false;"
                                     onselectstart="return false;"
                                     draggable="false">
                                @if($showLogo)
                                <div class="watermark-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('assets/images/logo-transparent.png') }}" 
                                         alt="Watermark" 
                                         class="media-watermark-logo">
                                </div>
                                @endif
                                @if($showUsername)
                                <div class="media-username-pattern media-username-pattern-image">
                                    @for($i = 0; $i < 16; $i++)
                                        <span class="media-username-pattern-item">{{ strtoupper(auth()->user()->name) }}</span>
                                    @endfor
                                </div>
                                @endif
                            </div>
                        @elseif($media->type === 'video')
                            <div class="video-viewer-container">
                                <div class="video-wrapper">
                                    <video id="media-video-{{ $media->id }}" 
                                           class="media-video-player"
                                           controls
                                           controlsList="nodownload"
                                           oncontextmenu="return false;">
                                        <source src="{{ route('media.stream', $media) }}" type="{{ $media->mime_type ?? 'video/mp4' }}">
                                        Your browser does not support the video tag.
                                    </video>
                                    @if($showLogo)
                                    <div class="watermark-overlay video-watermark-overlay">
                                        <img src="{{ asset('assets/images/logo-transparent.png') }}" 
                                             alt="Watermark" 
                                             class="media-watermark-logo">
                                    </div>
                                    @endif
                                    @if($showUsername)
                                    <div class="media-username-pattern media-username-pattern-video">
                                        @for($i = 0; $i < 16; $i++)
                                            <span class="media-username-pattern-item">{{ strtoupper(auth()->user()->name) }}</span>
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Prevent text selection and right-click */
    .media-container {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
    }

    /* Prevent screenshot attempts (limited effectiveness) */
    @media print {
        .media-container {
            display: none !important;
        }
    }

    /* Disable drag and drop */
    .media-container img,
    .media-container video,
    .media-container iframe,
    .media-container canvas {
        -webkit-user-drag: none;
        -khtml-user-drag: none;
        -moz-user-drag: none;
        -o-user-drag: none;
        user-drag: none;
    }

    .watermark-overlay,
    .pdf-watermark-overlay {
        pointer-events: none !important;
    }

    /* Bigger transparent logo on top (no server burn) */
    .media-watermark-logo {
        width: 480px;
        max-width: 65vw;
        opacity: 0.4;
        pointer-events: none;
    }

    /* Repeating username watermark: multiple times, oblique, across the screen */
    .media-username-pattern {
        position: absolute;
        inset: 0;
        pointer-events: none;
        z-index: 11;
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(8, 1fr);
        gap: 0;
        align-items: center;
        justify-items: center;
        overflow: hidden;
    }
    /* PDF: watermark scrolls with document, covers all pages */
    .media-watermark-pdf-wrap {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        pointer-events: none;
        z-index: 50;
    }
    .media-watermark-pdf-wrap .media-username-pattern-pdf {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(40, 1fr);
        min-height: 100%;
    }
    /* Logo once per PDF page (added by JS in each page wrapper) */
    .pdf-page-wrapper {
        position: relative;
        margin-left: auto;
        margin-right: auto;
        max-width: 100%;
        text-align: center;
    }
    .pdf-page-wrapper canvas {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .pdf-page-logo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 2;
    }
    .pdf-page-logo-overlay .media-watermark-logo {
        max-width: 70%;
        width: 520px;
        opacity: 0.4;
    }
    .media-username-pattern-item {
        font-style: oblique;
        font-weight: bold;
        font-size: 1.75rem;
        white-space: nowrap;
        opacity: 0.18;
        transform: rotate(-28deg);
        color: #5c5c5c;
    }
    .media-username-pattern-pdf .media-username-pattern-item {
        opacity: 0.22;
        font-size: 1.6rem;
    }
    .media-username-pattern-image .media-username-pattern-item {
        color: #5c5c5c;
        opacity: 0.2;
    }
    .media-username-pattern-video .media-username-pattern-item {
        color: rgba(255, 255, 255, 0.85);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        opacity: 0.22;
    }

    .pdf-viewer-container {
        position: relative;
    }
    .pdf-pages {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    /* Video: no fixed ratio — size to video’s aspect ratio, no extra empty space */
    .video-viewer-container {
        position: relative;
        width: 100%;
        background: #000;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .video-viewer-container .video-wrapper {
        position: relative;
        width: fit-content;
        max-width: 100%;
        max-height: 85vh;
        display: inline-flex;
        justify-content: center;
        align-items: center;
    }
    .video-viewer-container .media-video-player {
        display: block;
        max-width: 100%;
        max-height: 85vh;
        width: auto;
        height: auto;
        vertical-align: middle;
    }
    .video-viewer-container .video-watermark-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .video-viewer-container .media-username-pattern-video {
        position: absolute;
        inset: 0;
    }
</style>
@endpush

@if($media->type === 'pdf')
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    (function() {
        var mediaId = {{ $media->id }};
        var viewUrl = document.getElementById('pdf-view-url-' + mediaId).value;
        var container = document.getElementById('pdf-pages-' + mediaId);
        var loadingEl = document.getElementById('pdf-loading-' + mediaId);
        var viewerEl = document.getElementById('pdf-viewer-container-' + mediaId);

        function sizePdfWatermark() {
            if (!viewerEl || !container) return;
            var watermarkEl = document.getElementById('pdf-watermark-' + mediaId);
            if (watermarkEl) watermarkEl.style.height = container.offsetHeight + 'px';
        }

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        var watermarkType = (viewerEl && viewerEl.getAttribute('data-watermark-type')) || 'full';
        var showLogoOnPdf = (watermarkType === 'full' || watermarkType === 'logo_only');

        fetch(viewUrl, {
            headers: { 'X-PDF-Viewer-Request': '1' },
            credentials: 'same-origin'
        }).then(function(res) {
            if (!res.ok) throw new Error('Failed to load PDF');
            return res.arrayBuffer();
        }).then(function(arrayBuffer) {
            return pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        }).then(function(pdf) {
            loadingEl.style.display = 'none';
            var totalPages = pdf.numPages;
            var logoUrl = (viewerEl && viewerEl.getAttribute('data-pdf-logo-url')) || '';
            function renderPage(num) {
                return pdf.getPage(num).then(function(page) {
                    var scale = 1.5;
                    var viewport = page.getViewport({ scale: scale });
                    var wrapper = document.createElement('div');
                    wrapper.className = 'pdf-page-wrapper mb-4';
                    wrapper.style.textAlign = 'center';
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    canvas.style.maxWidth = '100%';
                    canvas.style.height = 'auto';
                    wrapper.appendChild(canvas);
                    if (logoUrl && showLogoOnPdf) {
                        var logoOverlay = document.createElement('div');
                        logoOverlay.className = 'pdf-page-logo-overlay';
                        var logoImg = document.createElement('img');
                        logoImg.src = logoUrl;
                        logoImg.alt = 'Watermark';
                        logoImg.className = 'media-watermark-logo';
                        logoOverlay.appendChild(logoImg);
                        wrapper.appendChild(logoOverlay);
                    }
                    container.appendChild(wrapper);
                    return page.render({ canvasContext: ctx, viewport: viewport }).promise;
                });
            }
            var chain = renderPage(1);
            for (var i = 2; i <= totalPages; i++) {
                (function(n) {
                    chain = chain.then(function() { return renderPage(n); });
                })(i);
            }
            return chain.then(function() {
                sizePdfWatermark();
            });
        }).catch(function(err) {
            loadingEl.innerHTML = '<p class="text-danger">Unable to load the document. You may need to refresh the page.</p>';
            console.error(err);
        });
    })();
</script>
@endpush
@endif

@push('scripts')
<script>
    // Prevent right-click, text selection, and common screenshot shortcuts
    document.addEventListener('contextmenu', function(e) {
        if (e.target.closest('.media-container')) {
            e.preventDefault();
            return false;
        }
    });

    document.addEventListener('keydown', function(e) {
        // Disable Print Screen, F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        if (e.key === 'PrintScreen' || 
            e.key === 'F12' || 
            (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
            (e.ctrlKey && e.key === 'U') ||
            (e.ctrlKey && e.key === 'S')) {
            if (document.querySelector('.media-container')) {
                e.preventDefault();
                alert('Screenshots and downloads are disabled for protected content.');
                return false;
            }
        }
    });

    // Disable text selection
    document.addEventListener('selectstart', function(e) {
        if (e.target.closest('.media-container')) {
            e.preventDefault();
            return false;
        }
    });

    // Disable video download for media videos
    document.querySelectorAll('[id^="media-video-"]').forEach(video => {
        video.addEventListener('loadedmetadata', function() {
            // Remove download attribute if browser adds it
            this.removeAttribute('download');
        });
    });
</script>
@endpush
@endsection
