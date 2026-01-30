<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard | ESIB SOCIAL')</title>
    @include('partials.head-meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <!-- Dashboard Styles -->
    @include('partials.dashboard.styles')

    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="d-flex">
        <!-- Sidebar -->
        @include('partials.dashboard.sidebar')

        <!-- Main Content -->
        <div class="main-content flex-grow-1" id="main-content">
            <!-- Header -->
            @include('partials.dashboard.header')

            <!-- Page Content -->
            <main class="p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Dashboard Scripts -->
    @include('partials.dashboard.scripts')

    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>
