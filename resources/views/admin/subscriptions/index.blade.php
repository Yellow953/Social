@extends('layouts.dashboard')

@section('title', 'Subscriptions Management - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-credit-card me-2" style="color: #3b82f6;"></i>Subscriptions Management</h2>
            <p class="text-muted mb-0">Review and manage user subscription requests</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Pending</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-check-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Approved</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">{{ $stats['approved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-lg h-100 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);">
                            <i class="fas fa-times-circle fa-lg text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1" style="letter-spacing: 0.5px; font-size: 0.7rem;">Rejected</h6>
                            <h3 class="fw-bold mb-0" style="color: #1e3a8a; font-size: 1.75rem;">{{ $stats['rejected'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">All Subscriptions</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">User</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Status</th>
                            <th class="border-0">Requested</th>
                            <th class="border-0">Approved/Rejected</th>
                            <th class="border-0">Expires</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                        <tr>
                            <td>
                                <div>
                                    <strong>{{ $subscription->user->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $subscription->user->email }}</small>
                                </div>
                            </td>
                            <td>{{ $subscription->subscription_type }}</td>
                            <td>
                                @if($subscription->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($subscription->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($subscription->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($subscription->status) }}</span>
                                @endif
                            </td>
                            <td>{{ $subscription->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($subscription->approved_at)
                                    {{ $subscription->approved_at->format('M d, Y') }}
                                    @if($subscription->approver)
                                        <br><small class="text-muted">by {{ $subscription->approver->name }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($subscription->expires_at)
                                    {{ $subscription->expires_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">No expiration</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($subscription->status === 'pending')
                                    <div class="btn-group">
                                        <form method="POST" action="{{ route('admin.subscriptions.approve', $subscription) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this subscription?')">
                                                <i class="fas fa-check me-1"></i>Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $subscription->id }}">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </button>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $subscription->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Subscription</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="{{ route('admin.subscriptions.reject', $subscription) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Rejection Reason</label>
                                                            <textarea class="form-control" name="rejection_reason" rows="3" required placeholder="Please provide a reason for rejection..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Reject Subscription</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-credit-card text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No subscriptions found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subscriptions->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $subscriptions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
