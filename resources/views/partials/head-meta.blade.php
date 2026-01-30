{{-- Favicon and default SEO meta for all pages (include after charset/viewport) --}}
<meta name="robots" content="index, follow">

{{-- Favicon: use logo as favicon for brand consistency --}}
<link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}" sizes="16x16">
<link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

@hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
@else
    <meta name="description" content="ESIB SOCIAL - Your comprehensive learning platform for social sciences. Access courses, sessions, and materials organized by subject.">
@endif

@hasSection('canonical')
    <link rel="canonical" href="@yield('canonical')">
@endif

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="ESIB SOCIAL">
@hasSection('og_title')
    <meta property="og:title" content="@yield('og_title')">
@endif
@hasSection('meta_description')
    <meta property="og:description" content="@yield('meta_description')">
@endif
<meta property="og:image" content="{{ url(asset('assets/images/logo.png')) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
