<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Social Plus</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-light">
    <div class="d-flex vh-100 overflow-hidden">
        <!-- Sidebar -->
        <aside class="admin-sidebar w-25 d-flex flex-column border-end">
            <!-- Logo -->
            <div class="p-4 border-bottom bg-white">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient rounded-3 p-2 me-3" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
                        <i class="bi bi-book text-white fs-5"></i>
                    </div>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                            <h5 class="mb-0 fw-bold text-dark">Social Plus</h5>
                        </a>
                        <span class="badge bg-danger ms-1" style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%) !important;">ADMIN</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-grow-1 p-3 overflow-auto">
                <ul class="nav nav-pills flex-column gap-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : 'text-dark' }}">
                            <i class="bi bi-house-door me-3"></i>
                            <span class="fw-semibold">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center justify-content-between text-dark">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people me-3"></i>
                                <span class="fw-semibold">Users</span>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\User::count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center text-dark">
                            <i class="bi bi-book me-3"></i>
                            <span class="fw-semibold">Courses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center text-dark">
                            <i class="bi bi-file-earmark-text me-3"></i>
                            <span class="fw-semibold">Sessions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center text-dark">
                            <i class="bi bi-graph-up me-3"></i>
                            <span class="fw-semibold">Analytics & Logs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link d-flex align-items-center text-dark">
                            <i class="bi bi-gear me-3"></i>
                            <span class="fw-semibold">Settings</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Section -->
            <div class="border-top p-4 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white fw-bold me-3"
                         style="width: 48px; height: 48px; background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-bold text-dark small">{{ auth()->user()->name }}</p>
                        <p class="mb-0 text-muted small">Administrator</p>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('dashboard') }}"
                       class="btn btn-outline-secondary btn-sm flex-grow-1">
                        <i class="bi bi-globe me-1"></i>Frontend
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn btn-sm w-100 text-white"
                                style="background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex flex-column overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-bottom shadow-sm">
                <div class="d-flex align-items-center justify-content-between px-4 py-3">
                    <div class="d-flex align-items-center gap-3">
                        <h4 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard')</h4>
                        <span class="badge bg-light text-dark border">{{ now()->format('M j, Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <!-- Search -->
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Search...">
                        </div>
                        <!-- Notifications -->
                        <button class="btn btn-light position-relative">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-grow-1 overflow-auto p-4 bg-light">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
