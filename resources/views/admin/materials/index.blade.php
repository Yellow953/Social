@extends('layouts.dashboard')

@section('title', 'Materials Management | ESIB SOCIAL Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Materials</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-play-circle me-2" style="color: #ec682a;"></i>Materials Management</h2>
            <p class="text-muted mb-0">Manage all materials (cours, TP, video recording) in the platform</p>
        </div>
        <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Material
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Materials Table -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">All Materials</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Title</th>
                            <th class="border-0">Course</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Created</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $material->title }}</strong>
                                    @if($material->description)
                                        <br><small class="text-muted">{{ Str::limit($material->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $material->course->name }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $material->type)) }}</span></td>
                            <td>
                                <span class="material-lock-badge badge {{ $material->is_locked ? 'bg-warning' : 'bg-success' }}" data-material-id="{{ $material->id }}">
                                    {{ $material->is_locked ? 'Locked' : 'Available' }}
                                </span>
                                <button type="button"
                                        class="btn btn-sm btn-outline-{{ $material->is_locked ? 'success' : 'warning' }} ms-1 material-lock-toggle"
                                        title="{{ $material->is_locked ? 'Unlock' : 'Lock' }}"
                                        data-material-id="{{ $material->id }}"
                                        style="border-radius: 8px;">
                                    <i class="fas fa-{{ $material->is_locked ? 'lock-open' : 'lock' }}"></i>
                                </button>
                            </td>
                            <td>{{ $material->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit" style="border-radius: 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this material?">
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
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-play-circle text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No materials found</h5>
                                <a href="{{ route('admin.materials.create') }}" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus me-2"></i>Create First Material
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($materials->hasPages())
            <div class="card-footer bg-white border-top px-4 py-3">
                {{ $materials->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.material-lock-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-material-id');
            var row = this.closest('tr');
            var badge = row.querySelector('.material-lock-badge');
            var icon = this.querySelector('i');
            if (!id || !badge) return;
            var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('{{ url('admin/materials') }}/' + id + '/toggle-lock', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data.is_locked) {
                    badge.className = 'material-lock-badge badge bg-warning';
                    badge.textContent = 'Locked';
                    btn.className = 'btn btn-sm btn-outline-success ms-1 material-lock-toggle';
                    btn.title = 'Unlock';
                    icon.className = 'fas fa-lock-open';
                } else {
                    badge.className = 'material-lock-badge badge bg-success';
                    badge.textContent = 'Available';
                    btn.className = 'btn btn-sm btn-outline-warning ms-1 material-lock-toggle';
                    btn.title = 'Lock';
                    icon.className = 'fas fa-lock';
                }
            })
            .catch(function() { alert('Failed to update lock status'); });
        });
    });
});
</script>
@endpush
@endsection
