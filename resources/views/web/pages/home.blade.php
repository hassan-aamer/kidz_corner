@extends('web.layouts.app')
@section('title', __('attributes.home'))
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100">
                        @foreach (App\Models\Category::where('active', 1)->get()->sortBy('position')->take(10) as $categories_search)
                            <a href="{{ route('products.category', $categories_search->id) }}" class="nav-item nav-link">
                                {{ $categories_search->title ?? '' }}
                            </a>
                        @endforeach
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                @include('web.layouts.nav')
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($result['banners'] as $key => $banner)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="height: 410px;">
                                <img class="img-fluid" src="{{ App\Helpers\Image::getMediaUrl($banner, 'banners') }}"
                                    alt="{{ $banner->title ?? 'Banner' }}" loading="lazy">

                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">
                                            {{ $banner->title ?? '' }}
                                        </h3>
                                        <a href="{{ route('products') }}" class="btn btn-light py-2 px-3">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    @if ($result['categories']->count())
        <!-- Categories Start -->
        <div class="container-fluid pt-5">
            <div class="row px-xl-5 pb-3">
                @foreach ($result['categories']->sortBy('position') as $categories)
                    @include('web.components.category-item')
                @endforeach
            </div>
        </div>
        <!-- Categories End -->
    @endif

    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo
                        labore labore.</p>
                </div>
                <form action="{{ route('subscription') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="email" class="form-control border-white p-4"
                            placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Subscribe End -->

    @if ($result['products']->count())
        <!-- Products Start -->
        <div class="container-fluid pt-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
            </div>
            <div class="row px-xl-5 pb-3">
                @foreach ($result['products']->sortBy('position') as $products)
                    @include('web.components.product-item')
                @endforeach
            </div>
        </div>
        <!-- Products End -->
    @endif

    @if ($result['sliders']->count())
        <!-- Vendor Start -->
        <div class="container-fluid py-5">
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel vendor-carousel">
                        @foreach ($result['sliders']->sortBy('position') as $sliders)
                            @include('web.components.slider-item')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Vendor End -->
    @endif

@endsection
