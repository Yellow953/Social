<!-- Header -->
<header class="bg-white shadow-sm sticky-top" style="z-index: 100;">
    <div class="d-flex align-items-center justify-content-between px-4 py-3">
        <div class="d-flex align-items-center">
            <button class="btn btn-sm text-[#5c5c5c] d-md-none me-3" id="mobile-sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    @if(auth()->user()->isAdmin())
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-[#5c5c5c]">Admin Dashboard</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none text-[#5c5c5c]">Dashboard</a></li>
                    @endif
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @endif
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <!-- Notifications -->
            <a href="{{ route('notifications.index') }}" class="btn btn-sm position-relative text-[#5c5c5c] text-decoration-none">
                <i class="fas fa-bell"></i>
                @if(auth()->user()->unreadNotificationsCount() > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    {{ auth()->user()->unreadNotificationsCount() }}
                </span>
                @endif
            </a>
            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn btn-sm d-flex align-items-center text-[#5c5c5c] dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                    <div class="bg-gradient-to-br from-[#1e3a8a] to-[#3b82f6] rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <span class="text-white fw-bold small">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
