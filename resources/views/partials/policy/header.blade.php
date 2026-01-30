{{-- Inner card header for policy pages: logo, title, last updated --}}
<div class="text-center mb-5">
    <img src="{{ asset('assets/images/logo.png') }}" alt="ESIB Social" class="d-block mx-auto mb-3" style="max-height: 56px; width: auto; object-fit: contain;">
    <h1 class="fw-bold mb-2" style="color: #5c5c5c;">{{ $title ?? 'Policy' }}</h1>
    @if(isset($lastUpdated) && $lastUpdated)
        <p class="text-muted small mb-0">Last updated: {{ $lastUpdated }}</p>
    @else
        <p class="text-muted small mb-0">Last updated: {{ now()->format('F j, Y') }}</p>
    @endif
</div>
