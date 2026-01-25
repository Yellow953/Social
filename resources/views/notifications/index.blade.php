@extends('layouts.dashboard')

@section('title', 'Notifications - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-bell me-2" style="color: #3b82f6;"></i>Notifications</h2>
            <p class="text-muted mb-0">Stay updated with your latest activities</p>
        </div>
        <button class="btn btn-outline-secondary">
            <i class="fas fa-check-double me-2"></i>Mark all as read
        </button>
    </div>

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fas fa-list me-1"></i>All
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-circle me-1 text-primary"></i>Unread
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-book me-1 text-info"></i>Courses
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-bullhorn me-1 text-warning"></i>Announcements
            </a>
        </li>
    </ul>

    <!-- Notifications List -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">All Notifications</h5>
        </div>
        <div class="card-body p-0">
            @for($i = 1; $i <= 10; $i++)
            <div class="border-bottom p-3 notification-item {{ $i <= 3 ? 'bg-light' : '' }}">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        @if($i % 4 == 1)
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-book text-primary"></i>
                            </div>
                        @elseif($i % 4 == 2)
                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        @elseif($i % 4 == 3)
                            <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-bullhorn text-warning"></i>
                            </div>
                        @else
                            <div class="bg-info bg-opacity-10 rounded-circle p-2">
                                <i class="fas fa-info-circle text-info"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div>
                                <h6 class="mb-0 fw-bold">
                                    @if($i % 4 == 1)
                                        New Course Available
                                    @elseif($i % 4 == 2)
                                        Session Completed
                                    @elseif($i % 4 == 3)
                                        Important Announcement
                                    @else
                                        System Update
                                    @endif
                                </h6>
                                <p class="text-muted small mb-0">
                                    @if($i % 4 == 1)
                                        A new course "{{ ['Social Psychology', 'Cultural Studies', 'Research Methods'][$i % 3] }}" has been added to your available courses.
                                    @elseif($i % 4 == 2)
                                        You have successfully completed "Session {{ $i }}" in Course {{ rand(1, 5) }}.
                                    @elseif($i % 4 == 3)
                                        There will be a maintenance window scheduled for tomorrow at 2 AM.
                                    @else
                                        New features have been added to the platform. Check them out!
                                    @endif
                                </p>
                            </div>
                            @if($i <= 3)
                            <span class="badge bg-primary">New</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>{{ now()->subHours(rand(1, 48))->diffForHumans() }}
                            </small>
                            <div>
                                <button class="btn btn-sm btn-link text-primary p-0 me-2">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-link text-danger p-0">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
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
