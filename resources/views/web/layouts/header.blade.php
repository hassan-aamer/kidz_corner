<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row py-2 px-xl-5" style="background-color:#C73B65;">
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
        <div class="col-lg-6 col-12">
            <form action="{{ route('products.search') }}" method="GET" style="width:100%;">
                <div
                    style="display:flex; align-items:center; background:#fff; border:2px solid #C73B65; border-radius:30px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05); transition:all 0.3s ease;">

                    <!-- Input -->
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Find your favorite product..."
                        style="flex:1; border:none; outline:none; padding:12px 18px; font-size:15px; color:#333; font-family:inherit;">

                    <!-- Button -->
                    <button type="submit"
                        style="background:#C73B65; border:none; color:#fff; padding:20px 20px; cursor:pointer; transition:all 0.3s ease; display:flex; align-items:center; justify-content:center;border-radius: 50%;padding: 10px 12px; margin-right: 8px;">
                        <i class="fa fa-search" style="font-size:16px;"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-3 col-6 text-right cart-fixed">
            <a href="{{ route('cart.index') }}" class="cart-float-btn">
                <i class="fas fa-shopping-cart"></i>
                @if (cartItemCount())
                    <span class="cart-badge">{{ cartItemCount() }}</span>
                @endif
            </a>
        </div>

    </div>
</div>
<!-- Topbar End -->