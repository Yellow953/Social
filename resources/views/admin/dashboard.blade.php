@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Section -->
    <div class="card border-0 shadow-sm text-white overflow-hidden" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90">Here's what's happening with your platform today.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 120px; height: 120px; backdrop-filter: blur(10px);">
                        <i class="bi bi-graph-up-arrow fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-gradient rounded-3 p-3">
                            <i class="bi bi-people fs-4 text-white"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">+12%</span>
                    </div>
                    <h6 class="text-muted text-uppercase small fw-semibold mb-2">Total Users</h6>
                    <h3 class="fw-bold mb-1">{{ \App\Models\User::count() }}</h3>
                    <p class="text-muted small mb-0">Active members</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-gradient rounded-3 p-3">
                            <i class="bi bi-book fs-4 text-white"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">New</span>
                    </div>
                    <h6 class="text-muted text-uppercase small fw-semibold mb-2">Courses</h6>
                    <h3 class="fw-bold mb-1">0</h3>
                    <p class="text-muted small mb-0">Available courses</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-gradient rounded-3 p-3">
                            <i class="bi bi-file-earmark-text fs-4 text-white"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info">Active</span>
                    </div>
                    <h6 class="text-muted text-uppercase small fw-semibold mb-2">Sessions</h6>
                    <h3 class="fw-bold mb-1">0</h3>
                    <p class="text-muted small mb-0">Ongoing sessions</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 p-3" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
                            <i class="bi bi-activity fs-4 text-white"></i>
                        </div>
                        <span class="badge" style="background: rgba(236, 104, 42, 0.1); color: #ec682a;">Live</span>
                    </div>
                    <h6 class="text-muted text-uppercase small fw-semibold mb-2">Active Sessions</h6>
                    <h3 class="fw-bold mb-1">0</h3>
                    <p class="text-muted small mb-0">Real-time activity</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold">Quick Actions</h5>
            <span class="text-muted small">Frequently used features</span>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card action-card border h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-gradient rounded-3 p-3 me-3">
                                        <i class="bi bi-people fs-5 text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">Manage Users</h6>
                                        <p class="text-muted small mb-0">View and manage user accounts</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card action-card border h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success bg-gradient rounded-3 p-3 me-3">
                                        <i class="bi bi-book fs-5 text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">Manage Courses</h6>
                                        <p class="text-muted small mb-0">Organize courses by subject and year</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="#" class="text-decoration-none">
                        <div class="card action-card border h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-info bg-gradient rounded-3 p-3 me-3">
                                        <i class="bi bi-graph-up fs-5 text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">View Analytics</h6>
                                        <p class="text-muted small mb-0">Access data logs and session history</p>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold">Recent Activity</h5>
            <a href="#" class="text-decoration-none small fw-semibold" style="color: #ec682a;">View all <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="card-body">
            <div class="text-center py-5">
                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 80px; height: 80px;">
                    <i class="bi bi-clipboard-data fs-1 text-muted"></i>
                </div>
                <p class="text-muted fw-medium mb-1">No recent activity</p>
                <p class="text-muted small">Activity will appear here as users interact with the platform</p>
            </div>
        </div>
    </div>
</div>
@endsection
