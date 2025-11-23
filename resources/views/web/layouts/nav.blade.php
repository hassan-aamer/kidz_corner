<nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 d-none d-lg-flex">
    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
            alt="{{ setting('name') ?? '' }}" height="70" width="170">
    </a>

    <div class="justify-content-between">
        <div class="navbar-nav mr-auto py-0" style="font-weight: bold;">
            <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
            <a href="{{ route('products') }}" class="nav-item nav-link">Shop</a>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
        </div>
    </div>
</nav>

<!-- ===== MOBILE NAVBAR ===== -->
<div class="mobile-header d-lg-none d-flex justify-content-between align-items-center px-3 py-2">
    <a href="{{ route('home') }}">
        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}" class="logo"
            style="max-height: 50px; width: auto;">
    </a>

    <div class="d-flex align-items-center" style="gap: 15px;">
        <a href="{{ route('home') }}" class="text-dark text-decoration-none font-weight-bold"
            style="font-size: 14px;">Home</a>
        <a href="{{ route('products') }}" class="text-dark text-decoration-none font-weight-bold"
            style="font-size: 14px;">Shop</a>
        <a href="{{ route('contact') }}" class="text-dark text-decoration-none font-weight-bold"
            style="font-size: 14px;">Contact</a>
    </div>
</div>