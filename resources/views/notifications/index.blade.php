@extends('layouts.dashboard')

@section('title', 'Notifications | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-bell me-2" style="color: #ec682a;"></i>Notifications</h2>
            <p class="text-muted mb-0">Stay updated with your latest activities</p>
        </div>
        <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-check-double me-2"></i>Mark all as read
            </button>
        </form>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link {{ !request('filter') && !request('type') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                <i class="fas fa-list me-1"></i>All
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('filter') === 'unread' ? 'active' : '' }}" href="{{ route('notifications.index', ['filter' => 'unread']) }}">
                <i class="fas fa-circle me-1 text-primary"></i>Unread
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') === 'course' ? 'active' : '' }}" href="{{ route('notifications.index', ['type' => 'course']) }}">
                <i class="fas fa-book me-1 text-info"></i>Courses
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('type') === 'session' ? 'active' : '' }}" href="{{ route('notifications.index', ['type' => 'session']) }}">
                <i class="fas fa-play-circle me-1 text-warning"></i>Materials
            </a>
        </li>
    </ul>

    <!-- Notifications List -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">All Notifications</h5>
        </div>
        <div class="card-body p-0">
            @forelse($notifications as $notification)
            <div class="border-bottom p-4 notification-item {{ !$notification->read ? 'bg-light' : '' }}">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        @if($notification->type === 'course')
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-book text-primary"></i>
                            </div>
                        @elseif($notification->type === 'session')
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-play-circle text-success"></i>
                            </div>
                        @elseif($notification->type === 'subscription')
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-check-circle text-warning"></i>
                            </div>
                        @else
                            <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-info-circle text-info"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    {{ $notification->title }}
                                    @if(!$notification->read)
                                        <span class="badge bg-primary ms-2">New</span>
                                    @endif
                                </h6>
                                <p class="text-muted mb-0">{{ $notification->message }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                            </small>
                            <div class="d-flex gap-2">
                                @if(!$notification->read)
                                    <form method="POST" action="{{ route('notifications.mark-read', $notification) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-primary p-0" title="Mark as read">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="d-inline form-delete" data-confirm="Delete this notification?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-5 text-center">
                <i class="fas fa-bell-slash text-muted mb-3" style="font-size: 3rem;"></i>
                <h5 class="text-muted">No notifications found</h5>
                <p class="text-muted">You're all caught up!</p>
            </div>
            @endforelse
        </div>
        @if($notifications->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<style>
    .notification-item {
        transition: all 0.2s ease;
    }
    .notification-item:hover {
        background-color: #f8f9fa !important;
    }
</style>
@endsection
