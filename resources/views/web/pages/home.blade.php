@extends('web.layouts.app')
@section('title', __('attributes.home'))
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

@endsection
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row  px-xl-5">
            <div class="col-lg-12">
                @include('web.layouts.nav')
                <div id="header-carousel" class="carousel slide" data-ride="carousel" data-interval="1500">
                    <div class="carousel-inner"
                        style="border-radius: 16px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.08); transition: 0.3s ease;">
                        @foreach ($result['banners'] as $key => $banner)
                            <div class="carousel-item  {{ $key == 0 ? 'active' : '' }}" style="height: 410px;">
                                <img class="img-fluid w-100" src="{{ App\Helpers\Image::getMediaUrl($banner, 'banners') }}"
                                    alt="{{ $banner->title ?? 'Banner' }}" loading="lazy" style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h3 class="display-5 text-white font-weight-semi-bold mb-4">
                                            {{ $banner->title ?? '' }}
                                        </h3>
                                        <a href="" class="btn btn-light py-2 px-3" style="border-radius: 16px;">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;border-radius: 50%;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;border-radius: 50%;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


    @foreach ($result['categories']->sortBy('position') as $category)
        <div class="container-fluid pt-5">
            <div class="mb-4">
                <div class="text-center mb-4">
                    <h2 class="section-title px-5"><span class="px-2">{{ $category->title ?? '' }}</span></h2>
                </div>

                <!-- سلايدر المنتجات -->
                <div id="carousel-{{ $category->id }}" class="owl-carousel owl-theme px-xl-5">
                    @foreach ($category->products->sortBy('position') as $products)
                        <div class="item">
                            <div class="card border-0 mb-4"
                                style="border-radius:16px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.08); transition:transform 0.3s ease;">

                                <!-- صورة المنتج -->
                                <a
                                    href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}">
                                    <div class="position-relative" style="height:300px; overflow:hidden;">
                                        <img class="img-fluid lazyload"
                                            src="{{ App\Helpers\Image::getMediaUrl($products, 'products') }}"
                                            alt="{{ $products->title ?? '' }}" loading="lazy"
                                            style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;">
                                        @if ($products->sold_out == 1)
                                            <span
                                                style="position:absolute; top:12px; left:12px; background:#dc3545; color:#fff; font-size:13px; padding:4px 10px; border-radius:12px; font-weight:600;">
                                                Sold Out
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                <!-- تفاصيل المنتج -->
                                <div class="card-body text-center" style="padding:16px;">
                                    <h6
                                        style="font-size:16px; font-weight:600; color:#333; margin-bottom:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ strtoupper($products->title ?? '') }}
                                    </h6>
                                    <div style="display:flex; justify-content:center; align-items:center; gap:8px;">
                                        <h6 style="color:#C73B65; font-weight:700; margin:0;">EGP {{ $products->price ?? '' }}</h6>
                                        @if($products->old_price)
                                            <h6 style="color:#999; font-size:14px; margin:0; text-decoration:line-through;">
                                                EGP {{ $products->old_price ?? '' }}
                                            </h6>
                                        @endif
                                    </div>
                                </div>

                                <!-- الأزرار -->
                                <div class="card-footer d-flex justify-content-between align-items-center"
                                    style="background:#f9f9f9; border-top:1px solid #eee; padding:12px 16px;">
                                    <a href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}"
                                        style="font-size:14px; font-weight:600; color:#333; text-decoration:none; display:flex; align-items:center; transition:color 0.3s ease;">
                                        <i class="fas fa-eye" style="color:#C73B65; margin-right:6px;"></i> Details
                                    </a>
                                    <form action="{{ route('cart.add', $products->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit"
                                            style="background:#C73B65; color:#fff; border:none; padding:6px 14px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:background 0.3s ease;">
                                            <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach



    {{-- <div class="container-fluid pt-5">
        <div class="mb-4">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Products</span></h2>
            </div>

            <!-- سلايدر المنتجات -->
            <div class="owl-carousel owl-theme px-xl-5">
                @foreach ($result['products']->sortBy('position') as $products)
                <div class="item">
                    <div class="card border-0 mb-4"
                        style="border-radius:16px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.08); transition:transform 0.3s ease;">

                        <!-- صورة المنتج -->
                        <a
                            href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}">
                            <div class="position-relative" style="height:300px; overflow:hidden;">
                                <img class="img-fluid lazyload"
                                    src="{{ App\Helpers\Image::getMediaUrl($products, 'products') }}"
                                    alt="{{ $products->title ?? '' }}" loading="lazy"
                                    style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s ease;">
                                @if ($products->sold_out == 1)
                                <span
                                    style="position:absolute; top:12px; left:12px; background:#dc3545; color:#fff; font-size:13px; padding:4px 10px; border-radius:12px; font-weight:600;">
                                    Sold Out
                                </span>
                                @endif
                            </div>
                        </a>

                        <!-- تفاصيل المنتج -->
                        <div class="card-body text-center" style="padding:16px;">
                            <h6
                                style="font-size:16px; font-weight:600; color:#333; margin-bottom:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ strtoupper($products->title ?? '') }}
                            </h6>
                            <div style="display:flex; justify-content:center; align-items:center; gap:8px;">
                                <h6 style="color:#C73B65; font-weight:700; margin:0;">EGP {{ $products->price ?? '' }}</h6>
                                @if($products->old_price)
                                <h6 style="color:#999; font-size:14px; margin:0; text-decoration:line-through;">
                                    EGP {{ $products->old_price ?? '' }}
                                </h6>
                                @endif
                            </div>
                        </div>

                        <!-- الأزرار -->
                        <div class="card-footer d-flex justify-content-between align-items-center"
                            style="background:#f9f9f9; border-top:1px solid #eee; padding:12px 16px;">
                            <a href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}"
                                style="font-size:14px; font-weight:600; color:#333; text-decoration:none; display:flex; align-items:center; transition:color 0.3s ease;">
                                <i class="fas fa-eye" style="color:#C73B65; margin-right:6px;"></i> Details
                            </a>
                            <form action="{{ route('cart.add', $products->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    style="background:#C73B65; color:#fff; border:none; padding:6px 14px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:background 0.3s ease;">
                                    <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div> --}}



@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
$(document).ready(function () {

    // نجلب كل العناصر اللي ID بتاعها بيبدأ بـ carousel-
    $("[id^='carousel-']").each(function (index) {
        let slider = $(this);
        let sliderIndex = index + 1; // يبدأ من 1 بدل 0

        // إعدادات مختلفة لكل سلايدر
        let options = {};

        switch (sliderIndex) {
            case 1:
                options = {
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    responsive: {
                        0: { items: 2 },
                        576: { items: 2 },
                        992: { items: 3 },
                        1200: { items: 4 }
                    }
                };
                break;

            case 2:
                options = {
                    loop: true,
                    margin: 10,
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    responsive: {
                        0: { items: 1 },
                        576: { items: 2 },
                        992: { items: 3 },
                        1200: { items: 5 }
                    }
                };
                break;

            case 3:
                options = {
                    loop: false,
                    margin: 30,
                    nav: true,
                    dots: true,
                    autoplay: false,
                    responsive: {
                        0: { items: 2 },
                        576: { items: 3 },
                        992: { items: 4 },
                        1200: { items: 6 }
                    }
                };
                break;

            default:
                // أي سلايدر بعد الثالث ياخذ إعدادات افتراضية
                options = {
                    loop: true,
                    margin: 15,
                    nav: true,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 2500,
                    responsive: {
                        0: { items: 2 },
                        576: { items: 3 },
                        992: { items: 4 },
                        1200: { items: 5 }
                    }
                };
                break;
        }

        // تفعيل السلايدر
        slider.owlCarousel(options);
    });
});
</script>
@endsection

