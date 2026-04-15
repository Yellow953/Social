@extends('layouts.dashboard')

@section('title', 'Dashboard | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="d-flex flex-column gap-3 gap-md-4">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg text-white overflow-hidden" style="background: #1a2744; position: relative;">
        <div class="card-body p-3 p-md-4">
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-8 order-2 order-md-1">
                    <h2 class="card-title fw-bold mb-1 mb-md-2 fs-5 fs-md-4">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90 small mb-md-0">Here's an overview of your learning progress and activities.</p>
                </div>
                <div class="col-12 col-md-4 order-1 order-md-2 text-center text-md-end">
                    <div class="d-inline-block welcome-avatar-wrap">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-lg welcome-avatar-circle" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <span class="text-white fw-bold welcome-avatar-initials">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    {{-- <div class="row g-3 g-md-4">
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="rounded-xl p-2 p-md-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-book-open text-white fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-0 mb-md-1" style="letter-spacing: 0.5px; font-size: 0.65rem;">Active Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.35rem;">{{ $activeCourses }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="rounded-xl p-2 p-md-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-play-circle text-white fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-0 mb-md-1" style="letter-spacing: 0.5px; font-size: 0.65rem;">Sessions Done</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.35rem;">{{ $sessionsCompleted }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="rounded-xl p-2 p-md-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-clock text-white fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-0 mb-md-1" style="letter-spacing: 0.5px; font-size: 0.65rem;">Study Time</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.35rem;">{{ $studyTimeFormatted }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="rounded-xl p-2 p-md-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-trophy text-white fa-lg"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-0 mb-md-1" style="letter-spacing: 0.5px; font-size: 0.65rem;">Progress</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.35rem;">85%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Slideshow + Quick Actions -->
    <div class="row g-3 g-md-4">
        @if($slides->isNotEmpty())
        <!-- Slideshow -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-lg overflow-hidden h-100" style="border-left: 4px solid #ec682a !important;">
                <div id="dashboardCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner h-100">
                        @foreach($slides as $i => $slide)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }} h-100">
                            <img src="{{ asset('storage/' . $slide->image_path) }}"
                                 class="d-block w-100"
                                 alt="{{ $slide->title ?? 'Slide ' . ($i+1) }}"
                                 style="height: 320px; object-fit: contain; background: #ffffff;">
                            @if($slide->title || $slide->description)
                            <div class="carousel-caption d-flex flex-column justify-content-end pb-3"
                                 style="background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 100%); inset: 0; height: 100%;">
                                @if($slide->title)
                                    <h6 class="fw-bold mb-1" style="text-shadow: 0 2px 6px rgba(0,0,0,0.6);">{{ $slide->title }}</h6>
                                @endif
                                @if($slide->description)
                                    <p class="mb-0 small opacity-90" style="text-shadow: 0 1px 4px rgba(0,0,0,0.6);">{{ $slide->description }}</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @if($slides->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <div class="carousel-indicators" style="bottom: 8px;">
                        @foreach($slides as $i => $slide)
                        <button type="button" data-bs-target="#dashboardCarousel" data-bs-slide-to="{{ $i }}"
                                class="{{ $i === 0 ? 'active' : '' }}"
                                style="background-color: #ec682a; width: 8px; height: 8px; border-radius: 50%; border: none;"></button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
        @else
        <div class="col-12">
        @endif
            <!-- Quick Actions -->
            <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center py-2 py-md-3 px-3 px-md-4">
                    <h5 class="mb-0 fw-bold small" style="color: #c2410c;"><i class="fas fa-bolt me-2" style="color: #ec682a;"></i>Quick Actions</h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    <div class="row g-2 g-md-3">
                        <div class="col-6">
                            <a href="{{ route('academique') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-3">
                                        <div class="rounded-xl p-2 shadow-md d-inline-flex mb-2" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-graduation-cap fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 small">Académique</h6>
                                        <p class="text-muted small mb-0 d-none d-md-block">Année → Cours → Matériel</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('calculator') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-3">
                                        <div class="rounded-xl p-2 shadow-md d-inline-flex mb-2" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-calculator fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 small">Calculatrice</h6>
                                        <p class="text-muted small mb-0 d-none d-md-block">Outil de calcul des notes</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-3">
                                        <div class="rounded-xl p-2 shadow-md d-inline-flex mb-2" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-user-edit fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-0 small">Edit Profile</h6>
                                        <p class="text-muted small mb-0 d-none d-md-block">Update your information</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity + Recent Courses -->
    <div class="row g-3 g-md-4">
        <!-- Recent Activity -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center py-2 py-md-3 px-3 px-md-4">
                    <h5 class="mb-0 fw-bold small" style="color: #c2410c;"><i class="fas fa-history me-2" style="color: #ec682a;"></i>Recent Activity</h5>
                </div>
                <div class="card-body p-3 p-md-4" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentActivity as $activity)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <div class="rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                <i class="fas fa-{{ $activity['icon'] }} text-white small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small fw-bold">{{ $activity['title'] }}</h6>
                                <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                                @if(isset($activity['course']))
                                    <p class="text-muted small mb-0"><i class="fas fa-book me-1"></i>{{ $activity['course'] }}</p>
                                @endif
                                <span class="text-muted small">{{ $activity['time'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-history text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted small mb-0">No recent activity</p>
                            <p class="text-muted small">Start watching sessions to see your activity here</p>
                        </div>
                    @endforelse

                    @if($recentNotifications->count() > 0)
                        <div class="mt-3 pt-3 border-top">
                            <h6 class="small fw-bold mb-2" style="color: #c2410c;">Notifications</h6>
                            @foreach($recentNotifications as $notification)
                                <div class="d-flex align-items-start {{ !$loop->last ? 'mb-2' : '' }}">
                                    <div class="rounded-circle p-2 me-2 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                        <i class="fas fa-{{ $notification['icon'] }} text-white" style="font-size: 0.7rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 small fw-bold">{{ $notification['title'] }}</h6>
                                        <p class="text-muted small mb-0">{{ $notification['message'] }}</p>
                                        <span class="text-muted small">{{ $notification['time'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-2 py-md-3 px-3 px-md-4">
                    <h5 class="mb-0 fw-bold small" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>Recent Courses</h5>
                    <a href="{{ route('academique') }}" class="btn btn-sm text-decoration-none fw-semibold" style="color: #ec682a;">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-3 p-md-4">
                    @if($recentCourses->count() > 0)
                    <div class="row g-2 g-md-3">
                        @foreach($recentCourses as $course)
                        <div class="col-12 col-md-6">
                            <a href="{{ route('academique') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-shadow">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="rounded p-2 me-2 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                                <i class="fas fa-book text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1 small" style="color: #c2410c;">{{ $course->name }}</h6>
                                                <p class="text-muted small mb-0">{{ $course->code }}</p>
                                                @if($course->description)
                                                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">{{ Str::limit($course->description, 60) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book-open text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted small mb-0">No courses accessed yet</p>
                            <a href="{{ route('academique') }}" class="btn btn-sm mt-2" style="color: #ec682a;">Browse Courses</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .welcome-avatar-wrap { width: 72px; height: 72px; }
    .welcome-avatar-circle { width: 100%; height: 100%; }
    .welcome-avatar-initials { font-size: 1.75rem; }
    @media (min-width: 768px) {
        .welcome-avatar-wrap { width: 100px; height: 100px; margin-left: auto; }
        .welcome-avatar-initials { font-size: 2.5rem; }
    }
</style>
@endpush
@endsection
