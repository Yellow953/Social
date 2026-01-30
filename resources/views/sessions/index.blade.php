@extends('layouts.dashboard')

@section('title', 'Sessions | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Sessions</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-play-circle me-2" style="color: #ec682a;"></i>Sessions</h2>
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(!auth()->user()->isAdmin() && !auth()->user()->hasActiveSubscription())
        <div class="alert alert-warning mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-lock me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold">Subscription Required</h6>
                    <p class="mb-0">You need an active SOCIALPLUS subscription to access locked sessions. <a href="{{ route('subscriptions.create') }}" class="alert-link">Subscribe now</a> and wait for admin approval.</p>
                </div>
            </div>
        </div>
    @endif

    @if($groupedSessions->isEmpty())
        <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
            <div class="card-body text-center py-5 p-4">
                <i class="fas fa-video text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">No sessions available</h5>
                <p class="text-muted">Sessions will appear here once they are added to the platform.</p>
            </div>
        </div>
    @else
        @foreach($groupedSessions as $groupName => $sessions)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-book me-2 text-primary"></i>{{ $groupName }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0">Session</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Date</th>
                                    <th class="border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-purple-50 rounded p-2 me-3">
                                                <i class="fas fa-video text-purple-600"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $session->title }}</h6>
                                                @if($session->description)
                                                    <small class="text-muted">{{ Str::limit($session->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($session->is_locked)
                                            @if(auth()->user()->isAdmin() || auth()->user()->hasActiveSubscription())
                                                <span class="badge bg-warning">Locked (Accessible)</span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-lock me-1"></i>Locked
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-success">Available</span>
                                        @endif
                                    </td>
                                    <td>{{ $session->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            @if($session->canBeAccessedBy(auth()->user()))
                                                <a href="{{ route('sessions.show', $session) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-play me-1"></i>Watch
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled title="Subscription required">
                                                    <i class="fas fa-lock me-1"></i>Locked
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .bg-purple-50 { background-color: #f5f3ff; }
    .text-purple-600 { color: #9333ea; }
</style>
@endsection
