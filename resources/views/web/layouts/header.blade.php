    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="{{ route('contact') }}">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    @if (setting('facebook'))
                        <a class="text-dark px-2" href="{{ setting('facebook') ?? '' }}">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if (setting('twitter'))
                        <a class="text-dark px-2" href="{{ setting('twitter') ?? '' }}">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if (setting('linkedIn'))
                        <a class="text-dark px-2" href="{{ setting('linkedIn') ?? '' }}">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                    @if (setting('instagram'))
                        <a class="text-dark px-2" href="{{ setting('instagram') ?? '' }}">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if (setting('youtube'))
                        <a class="text-dark pl-2" href="{{ setting('youtube') ?? '' }}">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <img src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
                        alt="{{ setting('name') ?? '' }}" height="70" width="170">
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="{{ route('products.search') }}" method="GET">
                    {{-- @csrf --}}
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ request('search') }}" name="search"
                            placeholder="Search for products">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="{{ route('cart.index') }}" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    @if (cartItemCount())
                        <span class="badge">{{ cartItemCount() }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
