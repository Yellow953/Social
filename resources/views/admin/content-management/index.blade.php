@extends('layouts.dashboard')

@section('title', 'Content Management | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Content Management</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-images me-2" style="color: #ec682a;"></i>Content Management</h2>
            <p class="text-muted mb-0">Manage homepage slideshow images. When added, they replace the default content boxes on the public homepage.</p>
        </div>
        <a href="{{ route('admin.content-management.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Slide
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Homepage Slides</h5>
        </div>
        <div class="card-body p-4">
            @if($slides->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-images text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No slides yet</h5>
                    <p class="text-muted">Add slides to show an image slideshow on the homepage. If there are no slides, the default content boxes are shown.</p>
                    <a href="{{ route('admin.content-management.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add First Slide
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Preview</th>
                                <th class="border-0">Title</th>
                                <th class="border-0">Order</th>
                                <th class="border-0">Created</th>
                                <th class="border-0 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slides as $slide)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $slide->image_path) }}" alt="" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $slide->title ?: '—' }}</strong>
                                    @if($slide->description)
                                        <br><small class="text-muted">{{ Str::limit($slide->description, 40) }}</small>
                                    @endif
                                </td>
                                <td>{{ $slide->order }}</td>
                                <td>{{ $slide->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.content-management.edit', $slide) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit" style="border-radius: 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.content-management.destroy', $slide) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this slide?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete" style="border-radius: 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($slides->hasPages())
                    <div class="card-footer bg-white border-top px-4 py-3">
                        {{ $slides->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
