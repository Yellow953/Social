@extends('layouts.dashboard')

@section('title', 'Access Logs - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Access Logs</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-history me-2 text-primary"></i>Session Access Logs</h2>
            <p class="text-muted mb-0">Monitor user session access and watch time</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Total Watch Time</h6>
                    <h3 class="mb-0 fw-bold">
                        @php
                            $hours = floor($totalWatchTime / 3600);
                            $minutes = floor(($totalWatchTime % 3600) / 60);
                        @endphp
                        {{ $hours }}h {{ $minutes }}m
                    </h3>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">Total Log Entries</h6>
                    <h3 class="mb-0 fw-bold">{{ $logs->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.access-logs') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">User</label>
                    <input type="text" class="form-control" name="user_id" value="{{ request('user_id') }}" placeholder="User ID">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Session</label>
                    <input type="text" class="form-control" name="session_id" value="{{ request('session_id') }}" placeholder="Session ID">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 fw-bold">Access Logs</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">User</th>
                            <th class="border-0">Session</th>
                            <th class="border-0">Course</th>
                            <th class="border-0">Accessed At</th>
                            <th class="border-0">Watch Time</th>
                            <th class="border-0">IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $log->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $log->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $log->videoSession->title }}</strong>
                                    <br>
                                    <small class="text-muted">Year {{ $log->videoSession->year }}</small>
                                </div>
                            </td>
                            <td>{{ $log->videoSession->course->name }}</td>
                            <td>{{ $log->accessed_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($log->duration_seconds > 0)
                                    {{ $log->formatted_duration }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $log->ip_address ?? '-' }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-history text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No access logs found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
