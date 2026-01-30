@extends('layouts.dashboard')

@section('title', 'Dashboard - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg text-white overflow-hidden" style="background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%); position: relative;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90">Here's an overview of your learning progress and activities.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="position-relative" style="width: 100px; height: 100px; margin-left: auto;">
                        <div class="bg-gradient-to-br from-[#1e3a8a] to-[#3b82f6] rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                             style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold" style="font-size: 2.5rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-book-open fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Active Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ $activeCourses }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-play-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Sessions Completed</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ $sessionsCompleted }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Study Time</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ $studyTimeFormatted }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-trophy fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Progress</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">85%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-bolt me-2" style="color: #ec682a;"></i>Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('courses') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-book-open fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Browse Courses</h6>
                                        <p class="text-muted small mb-0">Explore available courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('sessions') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-play-circle fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">View Sessions</h6>
                                        <p class="text-muted small mb-0">Access your sessions</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('calculator') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-calculator fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Calculator</h6>
                                        <p class="text-muted small mb-0">Use built-in calculator</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('profile') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                            <i class="fas fa-user-edit fa-2x text-white"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Edit Profile</h6>
                                        <p class="text-muted small mb-0">Update your information</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-history me-2" style="color: #ec682a;"></i>Recent Activity</h5>
                </div>
                <div class="card-body p-4">
                    @forelse($recentActivity as $activity)
                        <div class="d-flex align-items-start {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
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
    </div>

    <!-- Recent Courses -->
    @if($recentCourses->count() > 0)
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>Recent Courses</h5>
                    <a href="{{ route('courses') }}" class="btn btn-sm text-decoration-none fw-semibold" style="color: #ec682a;">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($recentCourses as $course)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('courses') }}?course={{ $course->id }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 hover-shadow">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start mb-2">
                                            <div class="rounded p-2 me-2 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                                <i class="fas fa-book text-white small"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1 small" style="color: #c2410c;">{{ $course->name }}</h6>
                                                <p class="text-muted small mb-0">{{ $course->code }}</p>
                                            </div>
                                        </div>
                                        @if($course->description)
                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">{{ Str::limit($course->description, 60) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
