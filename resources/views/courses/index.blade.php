@extends('layouts.dashboard')

@section('title', 'Courses - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Courses</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-book-open me-2" style="color: #3b82f6;"></i>Courses</h2>
            <p class="text-muted mb-0">
                @if(auth()->user()->isAdmin())
                    Manage and organize courses by subject and year
                @else
                    Browse and access your courses organized by subject
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->user()->isAdmin())
                <button class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Add Course
                </button>
            @endif
            <button class="btn btn-primary">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card border-0 shadow-lg overflow-hidden mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
        <div class="card-body p-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Search courses...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4">
        @for($i = 1; $i <= 9; $i++)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 course-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-book fa-lg text-white"></i>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <h5 class="fw-bold mb-2">Course Title {{ $i }}</h5>
                    <p class="text-muted small mb-3">Subject: Sociology</p>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <small class="text-muted d-block">Progress</small>
                            <div class="progress" style="height: 6px; width: 100px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ rand(20, 90) }}%"></div>
                            </div>
                        </div>
                        <span class="badge bg-info">{{ rand(5, 20) }} Sessions</span>
                    </div>
                    <div class="d-flex gap-2">
                        @if(!auth()->user()->isAdmin())
                            <a href="#" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-play me-1"></i>Continue
                            </a>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        @else
                            <a href="#" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

<style>
    .course-card {
        transition: all 0.3s ease;
    }
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
