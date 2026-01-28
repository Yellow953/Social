@extends('layouts.dashboard')

@section('title', 'Users - Admin - Social Plus')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;"><i class="fas fa-users me-2" style="color: #3b82f6;"></i>Users Management</h2>
            <p class="text-muted mb-0">Manage all platform users</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add User
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

    <!-- Users Table -->
    <div class="card border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #3b82f6 !important;">
        <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">All Users</h5>
            <div class="d-flex align-items-center">
                <label class="me-2 mb-0 small text-muted">Search:</label>
                <input type="search" id="usersTableSearch" class="form-control form-control-sm" placeholder="Search users..." style="width: 220px;">
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Study Year</th>
                            <th>Subscription</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="table-row-hover">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                                        <span class="text-white fw-bold" style="font-size: 0.9rem;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold" style="color: #1e3a8a;">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="color: #5c5c5c;">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span style="color: #5c5c5c;">{{ $user->phone ?? '-' }}</span>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.4rem 0.8rem; font-weight: 500;">Admin</span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 0.4rem 0.8rem; font-weight: 500;">User</span>
                                @endif
                            </td>
                            <td>
                                @if($user->study_year)
                                    <span class="badge bg-info" style="padding: 0.4rem 0.8rem; font-weight: 500;">{{ $user->study_year }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $activeSubscription = $user->activeSubscription();
                                @endphp
                                @if($activeSubscription)
                                    <span class="badge bg-success" style="padding: 0.4rem 0.8rem; font-weight: 500;">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                        @if($activeSubscription->expires_at)
                                            <br><small style="font-size: 0.7rem;">Until {{ $activeSubscription->expires_at->format('M Y') }}</small>
                                        @else
                                            <br><small style="font-size: 0.7rem;">No expiration</small>
                                        @endif
                                    </span>
                                @else
                                    <span class="badge bg-secondary" style="padding: 0.4rem 0.8rem; font-weight: 500;">
                                        <i class="fas fa-times-circle me-1"></i>No Subscription
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span style="color: #5c5c5c;">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    @if(!$user->activeSubscription() && $user->role !== 'admin')
                                        <button type="button" 
                                                class="btn btn-sm btn-success quick-subscription-btn shadow-sm" 
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                title="Create 1 Year Subscription"
                                                style="border-radius: 8px;">
                                            <i class="fas fa-gift me-1"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary shadow-sm" title="Edit" style="border-radius: 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline form-delete" data-confirm="Are you sure you want to delete this user?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete" style="border-radius: 8px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    /* Improved DataTable Styling */
    #usersTable {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    #usersTable tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    
    #usersTable tbody tr.table-row-hover:hover {
        background-color: #f8fafc !important;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    #usersTable tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border: none;
    }
    
    #usersTable thead th {
        padding: 1rem 0.75rem;
        border: none;
    }
    
    #usersTable thead th {
        background: #f8f9fa !important;
        color: #212529 !important;
        font-weight: 600;
    }

    /* DataTables Custom Styling */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.5rem;
        margin: 0 2px;
        padding: 0.5rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%) !important;
        color: white !important;
        border: none;
    }
    
    .dataTables_wrapper .dataTables_info {
        color: #6b7280;
        padding-top: 1rem;
    }
    
    /* Quick Subscription Button */
    .quick-subscription-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .quick-subscription-btn:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .quick-subscription-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: false,
            order: [[7, 'desc']],
            language: {
                search: "Search users:",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "No users found",
                infoFiltered: "(filtered from _MAX_ total users)",
                zeroRecords: "No matching users found"
            },
            dom: 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: 7 }
            ],
            drawCallback: function() {
                attachQuickSubscriptionHandlers();
            }
        });
        var table = $('#usersTable').DataTable();
        $('#usersTableSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
        
        function doQuickSubscription(btn, userId) {
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin"></i>');
            $.ajax({
                url: '/admin/users/' + userId + '/quick-subscription',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    if (response.success) {
                        var alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-check-circle me-2"></i>' + response.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                        $('.container-fluid').prepend(alert);
                        setTimeout(function() { location.reload(); }, 1000);
                    }
                },
                error: function(xhr) {
                    var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred. Please try again.';
                    var alert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="fas fa-exclamation-circle me-2"></i>' + message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>');
                    $('.container-fluid').prepend(alert);
                    btn.prop('disabled', false);
                    btn.html('<i class="fas fa-gift me-1"></i>');
                }
            });
        }
        
        function attachQuickSubscriptionHandlers() {
            $('.quick-subscription-btn').off('click').on('click', function() {
                var btn = $(this);
                var userId = btn.data('user-id');
                var userName = btn.data('user-name');
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Create subscription?',
                        text: 'Create a free 1-year subscription for ' + userName + '?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, create it'
                    }).then(function(result) {
                        if (result.isConfirmed) doQuickSubscription(btn, userId);
                    });
                } else {
                    if (confirm('Create a free 1-year subscription for ' + userName + '?')) doQuickSubscription(btn, userId);
                }
            });
        }
        
        // Initial attachment
        attachQuickSubscriptionHandlers();
    });
</script>
@endpush
@endsection
