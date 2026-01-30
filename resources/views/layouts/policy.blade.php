@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    {{-- Policy page header --}}
    <header class="bg-white shadow-sm sticky-top">
        <div class="container py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none text-dark">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="ESIB Social" class="me-2" style="height: 36px; width: auto; object-fit: contain;">
                    <span class="fw-bold">ESIB SOCIAL</span>
                </a>
                <nav class="d-flex flex-wrap align-items-center gap-2 gap-md-4">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted small fw-medium hover-primary">Home</a>
                    <a href="{{ route('privacy') }}" class="text-decoration-none small fw-medium {{ request()->routeIs('privacy') ? 'text-decoration-underline' : 'text-muted' }}" style="{{ request()->routeIs('privacy') ? 'color: #ec682a !important;' : '' }}">Privacy</a>
                    <a href="{{ route('terms') }}" class="text-decoration-none small fw-medium {{ request()->routeIs('terms') ? 'text-decoration-underline' : 'text-muted' }}" style="{{ request()->routeIs('terms') ? 'color: #ec682a !important;' : '' }}">Terms</a>
                    <a href="{{ route('cookie-policy') }}" class="text-decoration-none small fw-medium {{ request()->routeIs('cookie-policy') ? 'text-decoration-underline' : 'text-muted' }}" style="{{ request()->routeIs('cookie-policy') ? 'color: #ec682a !important;' : '' }}">Cookies</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container py-5">
        @yield('policy')
    </main>
</div>
@endsection
