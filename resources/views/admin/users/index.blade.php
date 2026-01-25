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
        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">All Users</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="usersTable" class="table table-hover mb-0">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                            <th style="color: white; font-weight: 600; border: none;">User</th>
                            <th style="color: white; font-weight: 600; border: none;">Email</th>
                            <th style="color: white; font-weight: 600; border: none;">Phone</th>
                            <th style="color: white; font-weight: 600; border: none;">Role</th>
                            <th style="color: white; font-weight: 600; border: none;">Study Year</th>
                            <th style="color: white; font-weight: 600; border: none;">Subscription</th>
                            <th style="color: white; font-weight: 600; border: none;">Joined</th>
                            <th style="color: white; font-weight: 600; border: none; text-align: right;">Actions</th>
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
                                <div class="btn-group" role="group">
                                    @if(!$user->activeSubscription() && $user->role !== 'admin')
                                        <button type="button" 
                                                class="btn btn-sm btn-success quick-subscription-btn" 
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                title="Create 1 Year Subscription">
                                            <i class="fas fa-gift"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
        transition: all 0.3s ease;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
        color: white !important;
        border: none;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%);
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
            pageLength: 25,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            order: [[7, 'desc']], // Sort by joined date (column index updated)
            language: {
                search: "Search users:",
                lengthMenu: "Show _MENU_ users",
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                infoEmpty: "No users found",
                infoFiltered: "(filtered from _MAX_ total users)",
                zeroRecords: "No matching users found"
            },
            dom: '<"row mb-3"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: 7 } // Disable sorting on Actions column
            ],
            drawCallback: function() {
                // Re-attach event listeners after table redraw
                attachQuickSubscriptionHandlers();
            }
        });
        
        // Quick subscription handler
        function attachQuickSubscriptionHandlers() {
            $('.quick-subscription-btn').off('click').on('click', function() {
                const btn = $(this);
                const userId = btn.data('user-id');
                const userName = btn.data('user-name');
                
                if (!confirm(`Create a free 1-year subscription for ${userName}?`)) {
                    return;
                }
                
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin"></i>');
                
                $.ajax({
                    url: `/admin/users/${userId}/quick-subscription`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            const alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                '<i class="fas fa-check-circle me-2"></i>' + response.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                '</div>');
                            $('.container-fluid').prepend(alert);
                            
                            // Reload page after 1 second to show updated subscription status
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                        const alert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                            '<i class="fas fa-exclamation-circle me-2"></i>' + message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                            '</div>');
                        $('.container-fluid').prepend(alert);
                        
                        btn.prop('disabled', false);
                        btn.html('<i class="fas fa-gift"></i>');
                    }
                });
            });
        }
        
        // Initial attachment
        attachQuickSubscriptionHandlers();
    });
</script>
@endpush
@endsection
