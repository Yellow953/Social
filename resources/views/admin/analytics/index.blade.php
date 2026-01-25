@extends('layouts.dashboard')

@section('title', 'Analytics - Admin - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Analytics</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-chart-line me-2" style="color: #3b82f6;"></i>Analytics</h2>
            <p class="text-muted mb-0">Platform statistics and insights</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-secondary active">Last 7 Days</button>
            <button class="btn btn-outline-secondary">Last 30 Days</button>
            <button class="btn btn-outline-secondary">Last Year</button>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Users</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">1,234</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-book fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">156</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-play-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Sessions Completed</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">2,456</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Study Time</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">1,234h</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">User Growth</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="userGrowthChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">User Distribution</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="userDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Stats -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Top Courses</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">Course {{ $i }}</h6>
                                    <div class="progress" style="height: 6px; width: 200px;">
                                        <div class="progress-bar bg-primary" style="width: {{ rand(60, 95) }}%"></div>
                                    </div>
                                </div>
                                <span class="badge bg-primary">{{ rand(50, 200) }} users</span>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @for($i = 1; $i <= 5; $i++)
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user-plus text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small fw-bold">New User Registered</h6>
                                    <p class="text-muted small mb-0">User {{ $i }} joined the platform</p>
                                    <small class="text-muted">{{ now()->subHours(rand(1, 24))->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth Chart
    const ctx1 = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Users',
                data: [800, 950, 1100, 1200, 1300, 1400],
                borderColor: '#ec682a',
                backgroundColor: 'rgba(236, 104, 42, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // User Distribution Chart
    const ctx2 = document.getElementById('userDistributionChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive', 'New'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: ['#ec682a', '#5c5c5c', '#28a745']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
</script>
@endsection
