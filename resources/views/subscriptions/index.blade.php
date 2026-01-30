@extends('layouts.dashboard')

@section('title', 'My Subscriptions | ESIB SOCIAL')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #c2410c;"><i class="fas fa-credit-card me-2" style="color: #ec682a;"></i>My Subscriptions</h2>
            <p class="text-muted mb-0">Manage your SOCIALPLUS subscription</p>
        </div>
        @if(!$activeSubscription)
            <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Request Subscription
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Active Subscription Card -->
    @if($activeSubscription)
        <div class="card border-0 shadow-lg mb-4 overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>Active Subscription
                        </h5>
                        <p class="text-muted mb-1">
                            <strong>Type:</strong> {{ $activeSubscription->subscription_type }}
                        </p>
                        <p class="text-muted mb-1">
                            <strong>Approved:</strong> {{ $activeSubscription->approved_at->format('M d, Y') }}
                        </p>
                        @if($activeSubscription->expires_at)
                            <p class="text-muted mb-0">
                                <strong>Expires:</strong> {{ $activeSubscription->expires_at->format('M d, Y') }}
                            </p>
                        @else
                            <p class="text-muted mb-0">
                                <strong>Status:</strong> <span class="badge bg-success">No Expiration</span>
                            </p>
                        @endif
                    </div>
                    <div class="text-end">
                        <span class="badge bg-success fs-6 px-3 py-2">Active</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Subscription History -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #ec682a !important;">
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #c2410c;">Subscription History</h5>
        </div>
        <div class="card-body p-0">
            @if($subscriptions->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-credit-card text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No subscription history</h5>
                    <p class="text-muted">You haven't requested any subscriptions yet.</p>
                    <a href="{{ route('subscriptions.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Request Subscription
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0">Type</th>
                                <th class="border-0">Status</th>
                                <th class="border-0">Requested</th>
                                <th class="border-0">Approved/Rejected</th>
                                <th class="border-0">Expires</th>
                                <th class="border-0">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                            <tr>
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
                                <td>
                                    @if($subscription->rejection_reason)
                                        <small class="text-danger">{{ Str::limit($subscription->rejection_reason, 50) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
