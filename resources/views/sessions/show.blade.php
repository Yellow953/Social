@extends('layouts.dashboard')

@section('title', $session->title . ' - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sessions') }}">Sessions</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($session->title, 30) }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- Video Player -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9">
                        <video id="session-video" class="w-100" controls>
                            <source src="{{ $session->video_url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <!-- Session Details -->
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-3">{{ $session->title }}</h3>
                    @if($session->description)
                        <p class="text-muted">{{ $session->description }}</p>
                    @endif
                    <div class="d-flex gap-4 text-muted">
                        <div>
                            <i class="fas fa-book me-2"></i>
                            <strong>Course:</strong> {{ $session->course->name }}
                        </div>
                        <div>
                            <i class="fas fa-calendar me-2"></i>
                            <strong>Year:</strong> {{ $session->year }}
                        </div>
                        @if($session->duration)
                            <div>
                                <i class="fas fa-clock me-2"></i>
                                <strong>Duration:</strong> {{ gmdate('H:i', $session->duration) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Session Info Card -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h6 class="mb-0 fw-bold" style="color: #1e3a8a;">Session Information</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <strong>Course:</strong><br>
                            <span class="text-muted">{{ $session->course->name }}</span>
                        </li>
                        <li class="mb-3">
                            <strong>Study Year:</strong><br>
                            <span class="text-muted">Year {{ $session->year }}</span>
                        </li>
                        @if($session->duration)
                            <li class="mb-3">
                                <strong>Duration:</strong><br>
                                <span class="text-muted">{{ gmdate('H:i', $session->duration) }}</span>
                            </li>
                        @endif
                        <li>
                            <strong>Status:</strong><br>
                            @if($session->is_locked)
                                <span class="badge bg-warning">Locked (Accessible with subscription)</span>
                            @else
                                <span class="badge bg-success">Available</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Watermark Notice -->
            @if($session->is_locked)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <small>This session is protected. Your username will be watermarked on the video.</small>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Track watch time
    const video = document.getElementById('session-video');
    let watchTime = 0;
    let lastUpdate = Date.now();

    // Update watch time every 30 seconds
    setInterval(() => {
        if (!video.paused && !video.ended) {
            watchTime += Math.floor((Date.now() - lastUpdate) / 1000);
            lastUpdate = Date.now();

            // Send update to server every 30 seconds
            if (watchTime % 30 === 0) {
                fetch('{{ route("sessions.watch-time", $session) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        duration_seconds: watchTime
                    })
                });
            }
        }
    }, 1000);

    // Send final watch time when video ends or page unloads
    video.addEventListener('ended', () => {
        sendWatchTime();
    });

    window.addEventListener('beforeunload', () => {
        sendWatchTime();
    });

    function sendWatchTime() {
        if (watchTime > 0) {
            navigator.sendBeacon('{{ route("sessions.watch-time", $session) }}', JSON.stringify({
                duration_seconds: watchTime,
                _token: '{{ csrf_token() }}'
            }));
        }
    }
</script>
@endpush
@endsection
