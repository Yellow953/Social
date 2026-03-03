@extends('layouts.dashboard')

@section('title', 'Courses Management | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Courses</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-book-open me-2" style="color: #ec682a;"></i>Courses Management</h2>
            <p class="text-muted mb-0">Manage all courses in the platform</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Course
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.courses.index') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or code…" value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-2">
                    <select name="major" class="form-select">
                        <option value="">All Majors</option>
                        @foreach($majors as $major)
                            <option value="{{ $major }}" {{ ($filters['major'] ?? '') === $major ? 'selected' : '' }}>{{ $major }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="year" class="form-select">
                        <option value="">All Years</option>
                        @foreach(['Sup', 'Spé', '1e', '2e', '3e'] as $y)
                            <option value="{{ $y }}" {{ ($filters['year'] ?? '') === $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="semester" class="form-select">
                        <option value="">All Semesters</option>
                        <option value="1" {{ ($filters['semester'] ?? '') === '1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ ($filters['semester'] ?? '') === '2' ? 'selected' : '' }}>Semester 2</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    @if(array_filter($filters ?? []))
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary" title="Clear filters">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">All Courses</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Code</th>
                            <th class="border-0">Name</th>
                            <th class="border-0">Year</th>
                            <th class="border-0">Semester</th>
                            <th class="border-0">Description</th>
                            <th class="border-0">Materials</th>
                            <th class="border-0">Created</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                        <tr>
                            <td><strong>{{ $course->code }}</strong></td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->year ?? '—' }}</td>
                            <td>{{ $course->semester ? 'Semester ' . $course->semester : '—' }}</td>
                            <td>
                                @if($course->description)
                                    {{ Str::limit($course->description, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $course->materials_count }}</span>
                            </td>
                            <td>{{ $course->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <form method="POST" action="{{ route('admin.courses.duplicate', $course) }}" class="d-inline form-duplicate" data-confirm="Duplicate this course and all its materials?">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info shadow-sm" title="Duplicate" style="border-radius: 8px;">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit" style="border-radius: 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this course?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete" style="border-radius: 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-book-open text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No courses found</h5>
                                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Create First Course
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($courses->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
