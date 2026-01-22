<!-- Sidebar -->
<aside class="sidebar position-fixed" id="sidebar">
    <div class="sidebar-content p-4">
        <!-- Logo -->
        <div class="logo-container d-flex align-items-center justify-content-between mb-4 position-relative">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="text-decoration-none d-flex align-items-center logo-link">
                <div class="bg-gradient-to-br from-[#ec682a] to-[#d45a20] rounded-xl d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                    <i class="fas fa-book text-white"></i>
                </div>
                <div class="logo-text-container ms-2">
                    <span class="logo-text fw-bold text-[#5c5c5c] d-block" id="logo-text">Social Plus</span>
                    @if(auth()->user()->isAdmin())
                        <span class="admin-badge badge bg-danger ms-1 d-inline-block" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%) !important; font-size: 0.65rem;">ADMIN</span>
                    @endif
                </div>
            </a>
            <button class="btn btn-sm text-[#5c5c5c] d-none d-md-block sidebar-toggle-btn" id="sidebar-toggle" title="Toggle Sidebar">
                <i class="fas fa-chevron-left" id="toggle-icon"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="mt-4">
            @if(auth()->user()->isAdmin())
                <!-- Admin Navigation -->
                <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-dashboard">Dashboard</span>
                </a>
                <a href="{{ route('admin.users') }}" data-tooltip="Users" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <i class="fas fa-users fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-users">Users</span>
                </a>
                <a href="{{ route('courses') }}" data-tooltip="Courses" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('courses*') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-lg me-3"></i>
                    <span class="nav-text" id="nav-courses">Courses</span>
                </a>
                <a href="{{ route('sessions') }}" data-tooltip="Sessions" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('sessions*') ? 'active' : '' }}">
                    <i class="fas fa-play-circle fa-lg me-3"></i>
                    <span class="nav-text" id="nav-sessions">Sessions</span>
                </a>
                <a href="{{ route('admin.analytics') }}" data-tooltip="Analytics" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line fa-lg me-3"></i>
                    <span class="nav-text" id="nav-admin-analytics">Analytics</span>
                </a>
                <a href="{{ route('notifications') }}" data-tooltip="Notifications" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('notifications*') ? 'active' : '' }}">
                    <i class="fas fa-bell fa-lg me-3"></i>
                    <span class="nav-text" id="nav-notifications">Notifications</span>
                </a>
                <a href="{{ route('profile') }}" data-tooltip="Profile" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user fa-lg me-3"></i>
                    <span class="nav-text" id="nav-profile">Profile</span>
                </a>
                <a href="{{ route('settings') }}" data-tooltip="Settings" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog fa-lg me-3"></i>
                    <span class="nav-text" id="nav-settings">Settings</span>
                </a>
            @else
                <!-- Regular User Navigation -->
                <a href="{{ route('dashboard') }}" data-tooltip="Dashboard" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('dashboard') && !request()->is('admin/*') ? 'active' : '' }}">
                    <i class="fas fa-home fa-lg me-3"></i>
                    <span class="nav-text" id="nav-dashboard">Dashboard</span>
                </a>
                <a href="{{ route('courses') }}" data-tooltip="Courses" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('courses*') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-lg me-3"></i>
                    <span class="nav-text" id="nav-courses">Courses</span>
                </a>
                <a href="{{ route('sessions') }}" data-tooltip="Sessions" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('sessions*') ? 'active' : '' }}">
                    <i class="fas fa-play-circle fa-lg me-3"></i>
                    <span class="nav-text" id="nav-sessions">Sessions</span>
                </a>
                <a href="{{ route('calculator') }}" data-tooltip="Calculator" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('calculator*') ? 'active' : '' }}">
                    <i class="fas fa-calculator fa-lg me-3"></i>
                    <span class="nav-text" id="nav-calculator">Calculator</span>
                </a>
                <a href="{{ route('notifications') }}" data-tooltip="Notifications" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('notifications*') ? 'active' : '' }}">
                    <i class="fas fa-bell fa-lg me-3"></i>
                    <span class="nav-text" id="nav-notifications">Notifications</span>
                </a>
                <a href="{{ route('profile') }}" data-tooltip="Profile" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('profile*') ? 'active' : '' }}">
                    <i class="fas fa-user fa-lg me-3"></i>
                    <span class="nav-text" id="nav-profile">Profile</span>
                </a>
                <a href="{{ route('settings') }}" data-tooltip="Settings" class="sidebar-item d-flex align-items-center px-3 py-3 mb-2 rounded text-decoration-none text-[#5c5c5c] {{ request()->is('settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog fa-lg me-3"></i>
                    <span class="nav-text" id="nav-settings">Settings</span>
                </a>
            @endif
        </nav>
    </div>
</aside>
