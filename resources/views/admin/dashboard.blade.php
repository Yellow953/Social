@extends('layouts.dashboard')

@section('title', 'Admin Dashboard | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Overview</li>
@endsection

@section('content')
<div class="d-flex flex-column gap-4">
    <!-- Welcome Section -->
    <div class="card border-0 shadow-sm text-white overflow-hidden" style="background: #1a2744; position: relative;">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="card-title fw-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                    <p class="card-text mb-0 opacity-90">Here's what's happening with your platform today.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <div class="position-relative" style="width: 120px; height: 120px; margin-left: auto;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 120px; height: 120px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <span class="text-white fw-bold" style="font-size: 3rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row g-4">
        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-book fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Courses</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ number_format($totalCourses) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-play-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Total Sessions</h6>
                            <h3 class="fw-bold mb-0" style="color: #c2410c; font-size: 1.75rem;">{{ number_format($totalSessions) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Growth Chart -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">User Growth (Last 30 Days)</h5>
            <span class="text-muted small">New registrations</span>
        </div>
        <div class="card-body p-4">
            <canvas id="userGrowthChart" height="80"></canvas>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Quick Actions</h5>
            <span class="text-muted small">Frequently used features</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none action-card-link">
                        <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md me-3 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                        <i class="fas fa-users fa-lg text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">Manage Users</h6>
                                        <p class="text-muted small mb-0">View and manage user accounts</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('admin.courses.index') }}" class="text-decoration-none action-card-link">
                        <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-xl p-3 shadow-md me-3 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                        <i class="fas fa-book fa-lg text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">Manage Courses</h6>
                                        <p class="text-muted small mb-0">Organize courses by subject and year</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ route('admin.analytics') }}" class="text-decoration-none action-card-link">
                        <div class="card border-0 shadow-md h-100 action-card" style="background: white; transition: all 0.3s ease;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-xl p-3 shadow-md me-3 flex-shrink-0" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                        <i class="fas fa-chart-line fa-lg text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-bold text-dark">View Analytics</h6>
                                        <p class="text-muted small mb-0">Access data logs and session history</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Recent Activity</h5>
            <a href="{{ route('admin.access-logs') }}" class="text-decoration-none small fw-semibold" style="color: #3b82f6;">View all <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="card-body p-4">
            @if($recentActivity->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">User</th>
                                <th class="border-0">Session</th>
                                <th class="border-0">Course</th>
                                <th class="border-0">Duration</th>
                                <th class="border-0">Accessed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentActivity as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                                                <span class="text-white small fw-bold">{{ substr($activity->user->name, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $activity->user->name }}</div>
                                                <small class="text-muted">{{ $activity->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $activity->videoSession?->title ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $activity->videoSession?->course?->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $activity->formatted_duration }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $activity->accessed_at->format('M d, Y H:i') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted fw-medium mb-1">No recent activity</p>
                    <p class="text-muted small">Activity will appear here as users interact with the platform</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('userGrowthChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($growthLabels),
                    datasets: [{
                        label: 'New Users',
                        data: @json($growthData),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 14,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
