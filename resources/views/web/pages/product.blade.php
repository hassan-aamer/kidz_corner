@extends('web.layouts.app')
@section('title', __('attributes.product_details'))
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                @include('web.components.category-dropdown')
            </div>
            <div class="col-lg-9">
                @include('web.layouts.nav')
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    {{-- <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Product Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Product Detail</p>
            </div>
        </div>
    </div> --}}
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        {{-- <div class="mb-4">
            <h2 class="px-lg-5 px-3" style="font-weight: bold; text-align: left; margin-bottom: 0;">Product details</h2>
        </div> --}}
        <div class="row px-xl-5">

            <!-- صور المنتج -->
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide shadow-sm rounded" data-ride="carousel"
                    data-interval="3000" style="border-radius:16px; overflow:hidden;">

                    <!-- Indicators -->
                    @if ($result['product']->getMedia('product_collection')->count())
                        <ol class="carousel-indicators" style="bottom:-40px;">
                            @foreach ($result['product']->getMedia('product_collection') as $key => $media)
                                <li data-target="#product-carousel" data-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }}"
                                    style="width:10px; height:10px; border-radius:50%; background:#C73B65;"></li>
                            @endforeach
                        </ol>

                        <div class="carousel-inner">
                            @foreach ($result['product']->getMedia('product_collection') as $key => $media)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ $media->getUrl() }}" alt="Product Image" loading="lazy"
                                        style="height:400px; object-fit:cover;">
                                    @if($result['product']->old_price && $result['product']->old_price > $result['product']->price)
                                        @php
                                            $discount = round((($result['product']->old_price - $result['product']->price) / $result['product']->old_price) * 100);
                                        @endphp
                                        <span
                                            style="position:absolute; top:12px; right:12px; background:#dc3545; color:#fff; font-size:13px; padding:4px 10px; border-radius:12px; font-weight:600; z-index: 10;">
                                            - {{ $discount }}%
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100"
                                    src="{{ App\Helpers\Image::getMediaUrl($result['product'], 'products') }}" alt="Image"
                                    loading="lazy" style="height:400px; object-fit:cover;">
                                @if($result['product']->old_price && $result['product']->old_price > $result['product']->price)
                                    @php
                                        $discount = round((($result['product']->old_price - $result['product']->price) / $result['product']->old_price) * 100);
                                    @endphp
                                    <span
                                        style="position:absolute; top:12px; right:12px; background:#dc3545; color:#fff; font-size:13px; padding:4px 10px; border-radius:12px; font-weight:600; z-index: 10;">
                                        - {{ $discount }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                        <i class="fa fa-angle-left" style="font-size:28px; color:#C73B65;"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                        <i class="fa fa-angle-right" style="font-size:28px; color:#C73B65;"></i>
                    </a>
                </div>
            </div>

            <!-- تفاصيل المنتج -->
            <div class="col-lg-7 pb-5">
                <h2 style="font-weight:700; color:#333; margin-bottom:15px;">
                    {{ $result['product']->title ?? '' }}
                </h2>
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                    <h3 style="font-weight:700; color:#C73B65; margin:0;">
                        {{ $result['product']->price ?? '' }}
                    </h3>
                    @if($result['product']->old_price && $result['product']->old_price > $result['product']->price)
                        <h4 style="color:#1D9DB1; font-size:18px; margin:0; text-decoration:line-through;">
                            {{ $result['product']->old_price ?? '' }}
                        </h4>
                    @endif
                </div>

                <!-- Countdown Timer -->
                <div class="mb-4">
                    <div
                        style="background-color: #b11d1d; color: white; padding: 5px 15px; display: inline-block; font-weight: bold; font-size: 1.2rem; margin-bottom: 15px;">
                        The offer ends during
                    </div>
                    <div id="countdown" style="display: flex; gap: 15px; font-family: 'Arial', sans-serif; direction: ltr;">
                        <div class="text-center">
                            <div id="days" style="font-size: 2.5rem; font-weight: bold; line-height: 1;">00</div>
                            <div style="font-size: 0.8rem; color: #666; text-transform: uppercase;">DAYS</div>
                        </div>
                        <div style="font-size: 2.5rem; font-weight: bold; line-height: 1;">:</div>
                        <div class="text-center">
                            <div id="hours" style="font-size: 2.5rem; font-weight: bold; line-height: 1;">23</div>
                            <div style="font-size: 0.8rem; color: #666; text-transform: uppercase;">HRS</div>
                        </div>
                        <div style="font-size: 2.5rem; font-weight: bold; line-height: 1;">:</div>
                        <div class="text-center">
                            <div id="minutes" style="font-size: 2.5rem; font-weight: bold; line-height: 1;">59</div>
                            <div style="font-size: 0.8rem; color: #666; text-transform: uppercase;">MINS</div>
                        </div>
                        <div style="font-size: 2.5rem; font-weight: bold; line-height: 1;">:</div>
                        <div class="text-center">
                            <div id="seconds" style="font-size: 2.5rem; font-weight: bold; line-height: 1;">06</div>
                            <div style="font-size: 0.8rem; color: #666; text-transform: uppercase;">SECS</div>
                        </div>
                    </div>
                </div>

                <script>
                    // Set the date we're counting down to (24 hours from now for static demo)
                    // For a truly static 24h loop that resets daily, we can target the next midnight or just a fixed duration.
                    // The user asked for "counts on 24 hours", let's make it count down from 23:59:59 visually.

                    window.onload = function () {
                        var duration = 12 * 60 * 60; // 12 hours in seconds
                        var displayDays = document.querySelector('#days');
                        var displayHours = document.querySelector('#hours');
                        var displayMinutes = document.querySelector('#minutes');
                        var displaySeconds = document.querySelector('#seconds');

                        // Check if there's a stored timestamp
                        var storedTime = localStorage.getItem('countdown_end_time');
                        var now = new Date().getTime();
                        var remainingTime;

                        if (storedTime && now < storedTime) {
                            // Calculate remaining seconds
                            remainingTime = Math.floor((storedTime - now) / 1000);
                        } else {
                            // Set new end time
                            var endTime = now + (duration * 1000);
                            localStorage.setItem('countdown_end_time', endTime);
                            remainingTime = duration;
                        }

                        startTimer(remainingTime, displayDays, displayHours, displayMinutes, displaySeconds);
                    };

                    function startTimer(duration, displayDays, displayHours, displayMinutes, displaySeconds) {
                        var timer = duration, days, hours, minutes, seconds;

                        // Update the timer immediately to avoid delay
                        updateDisplay(timer);

                        var interval = setInterval(function () {
                            if (--timer < 0) {
                                // Timer expired, reset
                                var now = new Date().getTime();
                                var newDuration = 12 * 60 * 60;
                                var endTime = now + (newDuration * 1000);
                                localStorage.setItem('countdown_end_time', endTime);
                                timer = newDuration;
                            }
                            updateDisplay(timer);
                        }, 1000);

                        function updateDisplay(t) {
                            days = Math.floor(t / (24 * 60 * 60));
                            var remainingSeconds = t % (24 * 60 * 60);
                            hours = Math.floor(remainingSeconds / (60 * 60));
                            remainingSeconds %= (60 * 60);
                            minutes = Math.floor(remainingSeconds / 60);
                            seconds = remainingSeconds % 60;

                            displayDays.textContent = days < 10 ? "0" + days : days;
                            displayHours.textContent = hours < 10 ? "0" + hours : hours;
                            displayMinutes.textContent = minutes < 10 ? "0" + minutes : minutes;
                            displaySeconds.textContent = seconds < 10 ? "0" + seconds : seconds;
                        }
                    }
                </script>
                <p style="color:#555; line-height:1.6; margin-bottom:25px;">
                    {{ $result['product']->description ?? '' }}
                </p>

                <!-- زر الإضافة للسلة -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <form action="{{ route('cart.add', $result['product']->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                            style="background:#C73B65; color:#fff; border:none; padding:12px 24px; border-radius:8px; font-weight:600; transition:0.3s;">
                            <i class="fa fa-shopping-cart mr-2"></i> Add To Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


@endsection
@section('js')
    <script>
        fbq('track', 'ViewContent', {
            content_ids: ['{{ $result['product']->id }}'],
            content_name: '{{ $result['product']->title }}'],
            value: {{ $result['product']->price ?? 0 }},
            currency: 'EGP'
        });
    </script>
@endsection