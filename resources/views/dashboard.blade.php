@extends('layouts.dashboard')

@section('title', 'Dashboard - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
        <div class="card-body p-4 text-white">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90">Here's an overview of your learning progress and activities.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 100px; height: 100px; backdrop-filter: blur(10px);">
                        <i class="fas fa-graduation-cap fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-blue-50 rounded p-3">
                            <i class="fas fa-book-open fa-2x text-blue-600"></i>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <h3 class="fw-bold mb-1">24</h3>
                    <p class="text-muted mb-0 small">Active Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-purple-50 rounded p-3">
                            <i class="fas fa-play-circle fa-2x text-purple-600"></i>
                        </div>
                        <span class="badge bg-info">New</span>
                    </div>
                    <h3 class="fw-bold mb-1">12</h3>
                    <p class="text-muted mb-0 small">Sessions Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-green-50 rounded p-3">
                            <i class="fas fa-clock fa-2x text-green-600"></i>
                        </div>
                        <span class="badge bg-warning">This Week</span>
                    </div>
                    <h3 class="fw-bold mb-1">8.5h</h3>
                    <p class="text-muted mb-0 small">Study Time</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-orange-50 rounded p-3">
                            <i class="fas fa-trophy fa-2x text-orange-600"></i>
                        </div>
                        <span class="badge bg-danger">Achievement</span>
                    </div>
                    <h3 class="fw-bold mb-1">85%</h3>
                    <p class="text-muted mb-0 small">Progress</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card border h-100 hover-shadow">
                                    <div class="card-body text-center">
                                        <i class="fas fa-book-open fa-3x text-primary mb-3"></i>
                                        <h6 class="fw-bold mb-1">Browse Courses</h6>
                                        <p class="text-muted small mb-0">Explore available courses</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card border h-100 hover-shadow">
                                    <div class="card-body text-center">
                                        <i class="fas fa-play-circle fa-3x text-purple-600 mb-3"></i>
                                        <h6 class="fw-bold mb-1">View Sessions</h6>
                                        <p class="text-muted small mb-0">Access your sessions</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card border h-100 hover-shadow">
                                    <div class="card-body text-center">
                                        <i class="fas fa-calculator fa-3x text-green-600 mb-3"></i>
                                        <h6 class="fw-bold mb-1">Calculator</h6>
                                        <p class="text-muted small mb-0">Use built-in calculator</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card border h-100 hover-shadow">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-edit fa-3x text-info mb-3"></i>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-check text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">Completed Session</h6>
                            <p class="text-muted small mb-0">Introduction to Sociology</p>
                            <span class="text-muted small">2 hours ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-book text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">New Course Added</h6>
                            <p class="text-muted small mb-0">Social Psychology</p>
                            <span class="text-muted small">5 hours ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-bell text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 small fw-bold">New Notification</h6>
                            <p class="text-muted small mb-0">Assignment due soon</p>
                            <span class="text-muted small">1 day ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-trophy text-info"></i>
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

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    .bg-blue-50 { background-color: #eff6ff; }
    .bg-purple-50 { background-color: #f5f3ff; }
    .bg-green-50 { background-color: #f0fdf4; }
    .bg-orange-50 { background-color: #fff7ed; }
    .text-blue-600 { color: #2563eb; }
    .text-purple-600 { color: #9333ea; }
    .text-green-600 { color: #16a34a; }
    .text-orange-600 { color: #ea580c; }
</style>
@endsection
