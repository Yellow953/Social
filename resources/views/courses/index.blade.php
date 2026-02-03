@extends('layouts.dashboard')

@section('title', 'Courses | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Courses</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>Courses</h2>
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
                <a href="{{ route('admin.courses.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Add Course
                </a>
            @endif
            <button type="button" class="btn btn-primary" id="coursesFilterToggle" aria-expanded="false">
                <i class="fas fa-filter me-2"></i>Filter
            </button>
        </div>
    </div>

    <!-- Search / Filter Bar (toggleable) -->
    <div class="card border-0 shadow-lg overflow-hidden mb-4" id="coursesFilterCard" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important; display: none;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('courses') }}">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search courses by name, code or description...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('courses') }}" class="btn btn-outline-danger" type="button">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('coursesFilterToggle').addEventListener('click', function() {
            var card = document.getElementById('coursesFilterCard');
            var open = card.style.display !== 'none';
            card.style.display = open ? 'none' : 'block';
            this.setAttribute('aria-expanded', !open);
        });
        @if(request('search'))
        document.getElementById('coursesFilterCard').style.display = 'block';
        document.getElementById('coursesFilterToggle').setAttribute('aria-expanded', 'true');
        @endif
    </script>

    <!-- Courses Grid -->
    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-lg h-100 course-card overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-gradient-to-br from-[#ec682a] to-[#c2410c] rounded-xl p-3 shadow-md" style="background: linear-gradient(135deg, #ec682a 0%, #c2410c 100%);">
                            <i class="fas fa-book fa-lg text-white"></i>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <h5 class="fw-bold mb-2" style="color: #c2410c;">{{ $course->name }}</h5>
                    <p class="text-muted small mb-2">
                        <strong>Code:</strong> {{ $course->code }}
                    </p>
                    @if($course->description)
                        <p class="text-muted small mb-3">{{ Str::limit($course->description, 80) }}</p>
                    @endif
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <small class="text-muted d-block">Materials</small>
                            <span class="fw-bold" style="color: #c2410c;">{{ $course->materials_count }}</span>
                        </div>
                        <span class="badge bg-info">{{ $course->materials_count }} {{ Str::plural('Material', $course->materials_count) }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('materials') }}?course={{ $course->id }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-play me-1"></i>View Materials
                            </a>
                            <a href="{{ route('courses') }}?course={{ $course->id }}" class="btn btn-outline-secondary btn-sm" title="View Details">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        @else
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this course?">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
                <div class="card-body text-center py-5">
                    <i class="fas fa-book text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No courses found</h5>
                    <p class="text-muted small">
                        @if(request('search'))
                            No courses match your search criteria.
                        @else
                            There are no courses available at the moment.
                        @endif
                    </p>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Create First Course
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <nav aria-label="Page navigation" class="mt-4">
        {{ $courses->withQueryString()->links() }}
    </nav>
    @endif
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
