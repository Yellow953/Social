@extends('layouts.dashboard')

@section('title', 'Request Subscription - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
    <li class="breadcrumb-item active" aria-current="page">Request Subscription</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-credit-card me-2"></i>Request SOCIALPLUS Subscription</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> Your subscription request will be reviewed by an administrator. You will be notified once your request is approved or rejected.
                    </div>

                    <form method="POST" action="{{ route('subscriptions.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Subscription Type</label>
                            <input type="text" class="form-control" value="SOCIALPLUS" disabled>
                            <small class="text-muted">This subscription allows you to access all locked sessions on the platform.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Your Information</label>
                            <div class="card bg-light p-3">
                                <p class="mb-1"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                <p class="mb-1"><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                                <p class="mb-0"><strong>Study Year:</strong> {{ auth()->user()->study_year ?? 'Not set' }}</p>
                                <p class="mb-0"><strong>Major:</strong> {{ auth()->user()->major ?? 'Not set' }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Submit Request
                            </button>
                            <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
