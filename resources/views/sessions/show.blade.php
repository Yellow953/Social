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
            <!-- Session Details -->
            <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
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
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if($session->media && $session->media->count() > 0)
            <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-file me-2 text-primary"></i>Session Media</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($session->media as $media)
                            <div class="col-md-4 col-sm-6">
                                <a href="{{ route('media.detail', $media) }}" class="text-decoration-none">
                                    <div class="card border shadow-sm h-100 media-card" style="transition: all 0.3s ease; cursor: pointer;">
                                        <div class="card-body text-center p-4">
                                            <div class="mb-3">
                                                @if($media->type === 'pdf')
                                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                                @elseif($media->type === 'video')
                                                    <i class="fas fa-file-video fa-4x text-primary"></i>
                                                @else
                                                    <i class="fas fa-file-image fa-4x text-success"></i>
                                                @endif
                                            </div>
                                            <h6 class="mb-2 text-dark text-truncate" style="max-width: 100%;" title="{{ $media->original_filename }}">
                                                {{ $media->original_filename }}
                                            </h6>
                                            <small class="text-muted">{{ $media->formatted_file_size }}</small>
                                            <div class="mt-3">
                                                <span class="badge bg-{{ $media->type === 'pdf' ? 'danger' : ($media->type === 'video' ? 'primary' : 'success') }}">
                                                    {{ ucfirst($media->type) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <!-- No Media Message -->
            <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-file text-muted mb-3" style="font-size: 3rem;"></i>
                    <h6 class="text-muted">No media files available for this session</h6>
                </div>
            </div>
            @endif
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

@push('styles')
<style>
    .media-card {
        transition: all 0.3s ease;
    }
    
    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
        border-color: #3b82f6 !important;
    }
</style>
@endpush
@endsection
