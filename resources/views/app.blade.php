<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>ESIB SOCIAL - Learning Platform for Social Sciences</title>

        {{-- Favicon and SEO meta --}}
        <meta name="robots" content="index, follow">
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="16x16">
        <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
        <meta name="description" content="ESIB SOCIAL - Your comprehensive learning platform for social sciences. Access courses, sessions, and materials organized by subject.">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="ESIB SOCIAL">
        <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
        @inertiaHead
    </head>
    <body class="antialiased bg-light">
        @inertia
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
