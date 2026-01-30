<!-- Sidebar -->
<aside class="sidebar position-fixed" id="sidebar">
    <div class="sidebar-content p-4">
        <!-- Logo -->
        <div class="logo-container d-flex align-items-center justify-content-between mb-4 position-relative">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="text-decoration-none d-flex align-items-center logo-link">
                <img src="{{ asset('assets/images/logo-transparent.png') }}" alt="ESIB Social" class="flex-shrink-0" style="width: 40px; height: 40px; object-fit: contain;">
                <div class="logo-text-container ms-2">
                    <span class="logo-text fw-bold text-white d-block" id="logo-text">Social Plus</span>
                    @if(auth()->user()->isAdmin())
                        <span class="admin-badge badge bg-danger ms-1 d-inline-block" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%) !important; font-size: 0.65rem;">ADMIN</span>
                    @endif
                </div>
            </a>
            <button class="btn btn-sm d-none d-md-block sidebar-toggle-btn" id="sidebar-toggle" title="Toggle Sidebar">
                <i class="fas fa-chevron-left" id="toggle-icon"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="mt-4">
            @if(auth()->user()->isAdmin())
                <!-- Admin Navigation -->
                <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-dashboard">Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" data-tooltip="Users" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-users">Users</span>
                </a>
                <a href="{{ route('admin.courses.index') }}" data-tooltip="Courses" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/courses*') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-courses">Courses</span>
                </a>
                <a href="{{ route('admin.sessions.index') }}" data-tooltip="Sessions" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/sessions*') ? 'active' : '' }}">
                    <i class="fas fa-play-circle fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-sessions">Sessions</span>
                </a>
                <a href="{{ route('admin.analytics') }}" data-tooltip="Analytics" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-analytics">Analytics</span>
                </a>
                <a href="{{ route('admin.subscriptions') }}" data-tooltip="Subscriptions" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/subscriptions*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-subscriptions">Subscriptions</span>
                </a>
                <a href="{{ route('admin.access-logs') }}" data-tooltip="Access Logs" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('admin/access-logs*') ? 'active' : '' }}">
                    <i class="fas fa-history fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-access-logs">Access Logs</span>
                </a>
                <a href="{{ route('notifications.index') }}" data-tooltip="Notifications" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('notifications*') ? 'active' : '' }}">
                    <i class="fas fa-bell fa-lg me-3"></i>
                    <span class="nav-text" id="nav-notifications">Notifications</span>
                </a>
                <a href="{{ route('profile') }}" data-tooltip="Profile" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user fa-lg me-3"></i>
                    <span class="nav-text" id="nav-profile">Profile</span>
                </a>
            @else
                <!-- Regular User Navigation -->
                <a href="{{ route('dashboard') }}" data-tooltip="Dashboard" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('dashboard') && !request()->is('admin/*') ? 'active' : '' }}">
                    <i class="fas fa-home fa-lg me-3"></i>
                    <span class="nav-text" id="nav-dashboard">Dashboard</span>
                </a>
                <a href="{{ route('courses') }}" data-tooltip="Courses" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('courses*') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-lg me-3"></i>
                    <span class="nav-text" id="nav-courses">Courses</span>
                </a>
                <a href="{{ route('sessions') }}" data-tooltip="Sessions" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('sessions*') ? 'active' : '' }}">
                    <i class="fas fa-play-circle fa-lg me-3"></i>
                    <span class="nav-text" id="nav-sessions">Sessions</span>
                </a>
                <a href="{{ route('calculator') }}" data-tooltip="Calculator" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('calculator*') ? 'active' : '' }}">
                    <i class="fas fa-calculator fa-lg me-3"></i>
                    <span class="nav-text" id="nav-calculator">Calculator</span>
                </a>
                <a href="{{ route('notifications.index') }}" data-tooltip="Notifications" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('notifications*') ? 'active' : '' }}">
                    <i class="fas fa-bell fa-lg me-3"></i>
                    <span class="nav-text" id="nav-notifications">Notifications</span>
                </a>
                <a href="{{ route('profile') }}" data-tooltip="Profile" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none {{ request()->is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user fa-lg me-3"></i>
                    <span class="nav-text" id="nav-profile">Profile</span>
                </a>
            @endif
        </nav>
    </div>
</aside>
