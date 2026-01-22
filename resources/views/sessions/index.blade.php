@extends('layouts.dashboard')

@section('title', 'Sessions - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Sessions</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-play-circle me-2 text-purple-600"></i>Sessions</h2>
            <p class="text-muted mb-0">
                @if(auth()->user()->isAdmin())
                    Manage all platform sessions and access logs
                @else
                    View and manage your learning sessions
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->user()->isAdmin())
                <button class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Add Session
                </button>
            @endif
            <div class="btn-group">
                <button class="btn btn-outline-secondary active">
                    <i class="fas fa-list me-1"></i>List
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-th me-1"></i>Grid
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fas fa-clock me-1"></i>All Sessions
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-play me-1"></i>In Progress
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-check-circle me-1"></i>Completed
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-lock me-1"></i>Locked
            </a>
        </li>
    </ul>

    <!-- Sessions List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Session</th>
                            <th class="border-0">Course</th>
                            <th class="border-0">Duration</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Date</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-purple-50 rounded p-2 me-3">
                                        <i class="fas fa-video text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Session {{ $i }}</h6>
                                        <small class="text-muted">Introduction to Topic</small>
                                    </div>
                                </div>
                            </td>
                            <td>Course {{ rand(1, 5) }}</td>
                            <td>{{ rand(30, 120) }} min</td>
                            <td>
                                @if($i % 3 == 0)
                                    <span class="badge bg-success">Completed</span>
                                @elseif($i % 3 == 1)
                                    <span class="badge bg-warning">In Progress</span>
                                @else
                                    <span class="badge bg-secondary">Locked</span>
                                @endif
                            </td>
                            <td>{{ now()->subDays(rand(1, 30))->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    @if($i % 3 != 2)
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-secondary" disabled>
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple-50 { background-color: #f5f3ff; }
    .text-purple-600 { color: #9333ea; }
</style>
@endsection
