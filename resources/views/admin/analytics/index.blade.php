@extends('layouts.dashboard')

@section('title', 'Analytics | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Analytics</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-chart-line me-2" style="color: #ec682a;"></i>Analytics</h2>
            <p class="text-muted mb-0">Platform statistics and insights</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.analytics', ['period' => '7']) }}" class="btn btn-outline-secondary {{ $period == '7' ? 'active' : '' }}">Last 7 Days</a>
            <a href="{{ route('admin.analytics', ['period' => '30']) }}" class="btn btn-outline-secondary {{ $period == '30' ? 'active' : '' }}">Last 30 Days</a>
            <a href="{{ route('admin.analytics', ['period' => '365']) }}" class="btn btn-outline-secondary {{ $period == '365' ? 'active' : '' }}">Last Year</a>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-users fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Users</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-book fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">{{ number_format($totalCourses) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-play-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Sessions Completed</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ number_format($sessionsCompleted) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Study Time</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">{{ number_format($totalStudyTimeHours) }}h</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;">User Growth</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="userGrowthChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;">User Distribution</h5>
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
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;">Top Courses</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush">
                        @forelse($topCourses as $course)
                        <div class="list-group-item border-0 px-0 {{ !$loop->last ? 'mb-3' : '' }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ $course->name }}</h6>
                                    <small class="text-muted">{{ $course->code }}</small>
                                    @php
                                        $maxAccesses = $topCourses->max('total_accesses') ?: 1;
                                        $courseAccesses = $course->total_accesses ?? 0;
                                        $percentage = $maxAccesses > 0 ? ($courseAccesses / $maxAccesses) * 100 : 0;
                                    @endphp
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar" style="width: {{ $percentage }}%; background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);"></div>
                                    </div>
                                </div>
                                <span class="badge bg-primary ms-3">{{ number_format($course->total_accesses ?? 0) }} accesses</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-book text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">No course data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                    <h5 class="mb-0 fw-bold" style="color: #c2410c;">Recent Activity</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivity as $activity)
                        <div class="list-group-item border-0 px-0 {{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3 flex-shrink-0">
                                    <i class="fas fa-{{ $activity['icon'] }} text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small fw-bold">{{ $activity['title'] }}</h6>
                                    <p class="text-muted small mb-0">{{ $activity['description'] }}</p>
                                    @if(isset($activity['course']))
                                        <p class="text-muted small mb-1"><i class="fas fa-book me-1"></i>{{ $activity['course'] }}</p>
                                    @endif
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-history text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">No recent activity</p>
                        </div>
                        @endforelse
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
            labels: @json($growthLabels),
            datasets: [{
                label: 'Users',
                data: @json($growthData),
                borderColor: '#ec682a',
                backgroundColor: 'rgba(236, 104, 42, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
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
                data: [{{ $activeUsers }}, {{ $inactiveUsers }}, {{ $newUsers }}],
                backgroundColor: ['#ec682a', '#5c5c5c', '#28a745']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12
                }
            }
        }
    });
</script>
@endsection
