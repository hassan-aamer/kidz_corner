<nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 d-none d-lg-flex">
    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
            alt="{{ setting('name') ?? '' }}" height="70" width="170">
    </a>

    <div class="justify-content-between">
        <div class="navbar-nav mr-auto py-0"  style="font-weight: bold;">
            <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
            <a href="{{ route('products') }}" class="nav-item nav-link">Shop</a>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact</a>
        </div>
    </div>
</nav>

<!-- ===== MOBILE NAVBAR ===== -->
<div class="mobile-header d-lg-none">
    <a href="{{ route('home') }}">
        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}" class="logo">
    </a>

    <i class="fa fa-bars menu-icon" id="openMenu"></i>
</div>

<!-- ===== SIDE MENU ===== -->
<div class="side-menu" id="sideMenu">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('products') }}">Shop</a>
    <a href="{{ route('contact') }}">Contact</a>
</div>

<!-- ===== OVERLAY ===== -->
<div class="menu-overlay" id="menuOverlay"></div>
