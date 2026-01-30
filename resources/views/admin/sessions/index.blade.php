@extends('layouts.dashboard')

@section('title', 'Sessions Management - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sessions</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-play-circle me-2" style="color: #ec682a;"></i>Sessions Management</h2>
            <p class="text-muted mb-0">Manage all video sessions in the platform</p>
        </div>
        <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Session
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Sessions Table -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">All Sessions</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Title</th>
                            <th class="border-0">Course</th>
                            <th class="border-0">Year</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Order</th>
                            <th class="border-0">Created</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sessions as $session)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $session->title }}</strong>
                                    @if($session->description)
                                        <br><small class="text-muted">{{ Str::limit($session->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $session->course->name }}</td>
                            <td>Year {{ $session->year }}</td>
                            <td>
                                @if($session->is_locked)
                                    <span class="badge bg-warning">Locked</span>
                                @else
                                    <span class="badge bg-success">Available</span>
                                @endif
                            </td>
                            <td>{{ $session->order }}</td>
                            <td>{{ $session->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit" style="border-radius: 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.sessions.destroy', $session) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this session?">
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
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-play-circle text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No sessions found</h5>
                                <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Create First Session
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sessions->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $sessions->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
