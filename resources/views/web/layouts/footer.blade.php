<!-- Subscribe Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center  pb-2">
                <h5 style="font-weight: bold;color:#C73B65;">{{__('attributes.subscription')}}</h5>
            </div>
            <form action="{{ route('subscription') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="email" class="form-control border-white p-4" placeholder="Email Goes Here"
                        style="box-shadow: 0 12px 28px rgba(0,0,0,0.12);border-radius: 16px 0 0 16px;">
                    <div class="input-group-append">
                        <button type="submit" style="background-color:#C73B65; color:#fff; border:none; 
           box-shadow:0 12px 28px rgba(0,0,0,0.12);
           border-radius:0 16px 16px 0; padding:0 24px; font-weight:600;">
                            {{ __('attributes.submit') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Subscribe End -->

<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark">
    <div class="row px-xl-5 pt-5" style="background-color: #FFFFFF;">
        {{-- <div class="col-lg-3 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <img class="mb-4 display-5 font-weight-semi-bold"
                    src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
                    alt="{{ setting('name') ?? '' }}" height="70" width="70" style="border-radius: 50%;">
            </a>
        </div> --}}
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            @if (setting('address'))
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ setting('address') ?? '' }}</p>
            @endif
            @if (setting('email'))
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ setting('email') ?? '' }}</p>
            @endif
            @if (setting('phone'))
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ setting('phone') ?? '' }}</p>
            @endif
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                class="fa fa-angle-right mr-2"></i>{{__('attributes.home')}}</a>
                        <a class="text-dark mb-2" href="{{ route('products') }}"><i
                                class="fa fa-angle-right mr-2"></i>{{__('attributes.shop')}}</a>
                        <a class="text-dark" href="{{ route('contact') }}"><i
                                class="fa fa-angle-right mr-2"></i>{{__('attributes.contuct')}}</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">{{__('attributes.social_links')}}</h5>
                    <div class="mt-3">
                        @if (setting('facebook'))
                            <a class="text-dark px-2" href="{{ setting('facebook') ?? '' }}">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        {{-- @if (setting('twitter'))
                        <a class="text-dark px-2" href="{{ setting('twitter') ?? '' }}">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif --}}
                        {{-- @if (setting('linkedIn'))
                        <a class="text-dark px-2" href="{{ setting('linkedIn') ?? '' }}">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif --}}
                        @if (setting('instagram'))
                            <a class="text-dark px-2" href="{{ setting('instagram') ?? '' }}">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        {{-- @if (setting('youtube'))
                        <a class="text-dark pl-2" href="{{ setting('youtube') ?? '' }}">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif --}}
                        @if (setting('tiktok'))
                            <a class="text-dark pl-2" href="{{ setting('tiktok') ?? '' }}">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-6 py-4" style="background-color: #FFFFFF;">
        <div class="col-md-12 px-xl-0">
            <p class="mb-0 text-center text-md-start text-dark">
                &copy;
                <a class="text-dark fw-semibold text-decoration-none" href="{{ env('APP_URL') }}">
                    {{ setting('copyrights') }}
                </a>
                <span class="d-block d-md-inline">
                    | Powered by
                    <a class="text-dark fw-semibold text-decoration-none" href="https://wa.me/201129730475" style="font-weight: bold;">
                        Hassan Mohamed
                    </a>
                </span>
            </p>
        </div>
    </div>


</div>
<!-- Footer End -->


{{-- cart --}}
<div class="col-lg-3 col-6 text-right cart-fixed">
    <a href="{{ route('cart.index') }}" class="cart-float-btn">
        <i class="fas fa-shopping-cart"></i>
        @if (cartItemCount())
            <span id="pendingCart" class="cart-badge">{{ cartItemCount() }}</span>
        @endif
    </a>
</div>