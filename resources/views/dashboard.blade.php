@extends('layouts.dashboard')

@section('title', 'Dashboard - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-lg text-white overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%); position: relative;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90">Here's an overview of your learning progress and activities.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="position-relative" style="width: 100px; height: 100px; margin-left: auto;">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&crop=faces" 
                             alt="Profile" 
                             class="rounded-circle"
                             style="width: 100px; height: 100px; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-book-open fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Active Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">24</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-play-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Sessions Completed</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">12</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Study Time</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">8.5h</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-trophy fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Progress</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">85%</h3>
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
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;"><i class="fas fa-bolt me-2" style="color: #3b82f6;"></i>Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('courses') }}" class="text-decoration-none action-card-link">
                                <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                                    <div class="card-body text-center p-4">
                                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
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
                                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
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
                                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
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
                                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md d-inline-flex mb-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
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
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;"><i class="fas fa-history me-2" style="color: #3b82f6;"></i>Recent Activity</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-check text-white small"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">Completed Session</h6>
                            <p class="text-muted small mb-0">Introduction to Sociology</p>
                            <span class="text-muted small">2 hours ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-book text-white small"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">New Course Added</h6>
                            <p class="text-muted small mb-0">Social Psychology</p>
                            <span class="text-muted small">5 hours ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-bell text-white small"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">New Notification</h6>
                            <p class="text-muted small mb-0">Assignment due soon</p>
                            <span class="text-muted small">1 day ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-circle p-2 me-3 flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-trophy text-white small"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">Achievement Unlocked</h6>
                            <p class="text-muted small mb-0">10 Sessions Completed</p>
                            <span class="text-muted small">2 days ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
