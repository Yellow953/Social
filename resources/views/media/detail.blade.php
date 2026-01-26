@extends('layouts.dashboard')

@section('title', $media->original_filename . ' - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sessions') }}">Sessions</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sessions.show', $session) }}">{{ Str::limit($session->title, 30) }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($media->original_filename, 30) }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('sessions.show', $session) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Session
                </a>
            </div>

            <!-- Media Viewer Card -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
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
                            <div class="pdf-viewer-container" style="position: relative; width: 100%; min-height: 80vh; border: 1px solid #ddd; background: #f5f5f5;">
                                <iframe id="pdf-viewer-{{ $media->id }}" 
                                        src="{{ route('media.view', $media) }}" 
                                        style="width: 100%; height: 80vh; border: none;"
                                        oncontextmenu="return false;"
                                        onselectstart="return false;">
                                </iframe>
                                <div class="watermark-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10;">
                                    <img src="{{ asset('assets/images/logo-transparent.png') }}" 
                                         alt="Watermark" 
                                         style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 200px; opacity: 0.3; pointer-events: none;">
                                    <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); color: rgba(92, 92, 92, 0.5); font-size: 24px; font-weight: bold; pointer-events: none;">
                                        {{ strtoupper(auth()->user()->name) }}
                                    </div>
                                </div>
                            </div>
                        @elseif($media->type === 'image')
                            <div class="image-viewer-container" style="position: relative; width: 100%; text-align: center; background: #f5f5f5; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ route('media.view', $media) }}" 
                                     alt="{{ $media->original_filename }}"
                                     class="img-fluid"
                                     style="max-width: 100%; max-height: 80vh; height: auto;"
                                     oncontextmenu="return false;"
                                     onselectstart="return false;"
                                     draggable="false">
                                <div class="watermark-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('assets/images/logo-transparent.png') }}" 
                                         alt="Watermark" 
                                         style="width: 200px; opacity: 0.3; pointer-events: none;">
                                </div>
                                <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); color: rgba(92, 92, 92, 0.5); font-size: 24px; font-weight: bold; pointer-events: none; z-index: 11;">
                                    {{ strtoupper(auth()->user()->name) }}
                                </div>
                            </div>
                        @elseif($media->type === 'video')
                            <div class="video-viewer-container" style="position: relative; width: 100%; background: #000;">
                                <div class="ratio ratio-16x9">
                                    <video id="media-video-{{ $media->id }}" 
                                           class="w-100" 
                                           controls
                                           controlsList="nodownload"
                                           oncontextmenu="return false;"
                                           style="position: relative;">
                                        <source src="{{ route('media.stream', $media) }}" type="{{ $media->mime_type ?? 'video/mp4' }}">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="watermark-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 10; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ asset('assets/images/logo-transparent.png') }}" 
                                             alt="Watermark" 
                                             style="width: 200px; opacity: 0.4; pointer-events: none;">
                                    </div>
                                    <div style="position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); color: rgba(255, 255, 255, 0.7); font-size: 20px; font-weight: bold; pointer-events: none; text-shadow: 2px 2px 4px rgba(0,0,0,0.8); z-index: 11;">
                                        {{ strtoupper(auth()->user()->name) }}
                                    </div>
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
    .media-container iframe {
        -webkit-user-drag: none;
        -khtml-user-drag: none;
        -moz-user-drag: none;
        -o-user-drag: none;
        user-drag: none;
    }

    .watermark-overlay {
        pointer-events: none !important;
    }
</style>
@endpush

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
