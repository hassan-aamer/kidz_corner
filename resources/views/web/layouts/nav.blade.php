                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
                            alt="{{ setting('name') ?? '' }}" height="70" width="170">
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}"
                                class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}" style="font-weight: bold;">Home</a>
                            <a href="{{ route('products') }}"
                                class="nav-item nav-link {{ request()->routeIs('products') ? 'active' : '' }}" style="font-weight: bold;">Shop</a>
                            <a href="{{ route('contact') }}"
                                class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" style="font-weight: bold;">Contact</a>
                        </div>
                    </div>
                </nav>
