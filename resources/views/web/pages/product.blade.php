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
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100"
                                    src="{{ App\Helpers\Image::getMediaUrl($result['product'], 'products') }}" alt="Image"
                                    loading="lazy" style="height:400px; object-fit:cover;">
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
                <h3 style="font-weight:700; color:#C73B65; margin-bottom:20px;">
                    EGP {{ $result['product']->price ?? '' }}
                </h3>
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