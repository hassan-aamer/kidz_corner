                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                        {{-- <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">{{ setting('name') ?? '' }}</span>{{ setting('title') ?? '' }}
                        </h1> --}}
                        <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
                            alt="{{ setting('name') ?? '' }}" height="70" width="170">
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}"
                                class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('products') }}"
                                class="nav-item nav-link {{ request()->routeIs('products') ? 'active' : '' }}">Shop</a>
                            <a href="{{ route('contact') }}"
                                class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                        </div>
                        {{-- <div class="navbar-nav ml-auto py-0">
                            <a href="" class="nav-item nav-link">Login</a>
                            <a href="" class="nav-item nav-link">Register</a>
                        </div> --}}
                    </div>
                </nav>
