<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ESIB SOCIAL - Learning Platform for Social Sciences</title>
        <meta name="robots" content="index, follow">
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="32x32">
        <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="16x16">
        <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
        <meta name="description" content="ESIB SOCIAL - Your comprehensive learning platform for social sciences. Access courses, materials, and materials organized by subject.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="antialiased bg-light">
        <div id="welcome-root"></div>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
