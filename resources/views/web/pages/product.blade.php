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
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Product Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Product Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            @if ($result['product']->getMedia('product_collection')->count())
                <div class="col-lg-5 pb-5">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">

                        {{-- Indicators --}}
                        <ol class="carousel-indicators">
                            @foreach ($result['product']->getMedia('product_collection') as $key => $media)
                                <li data-target="#product-carousel" data-slide-to="{{ $key }}"
                                    class="{{ $key === 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>

                        {{-- Images --}}
                        <div class="carousel-inner border">
                            @foreach ($result['product']->getMedia('product_collection') as $key => $media)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img class="w-100 h-100" src="{{ $media->getUrl() }}" alt="Product Image" loading="lazy"  width="300" height="300">
                                </div>
                            @endforeach
                        </div>

                        {{-- Controls --}}
                        <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="col-lg-5 pb-5">
                    <div id="product-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner border">
                            <div class="carousel-item active">
                                <img class="w-100 h-100" src="{{ App\Helpers\Image::getMediaUrl($result['product'], 'products') }}" alt="Image"  loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $result['product']->title ?? '' }}</h3>
                <h3 class="font-weight-semi-bold mb-4">EGP {{ $result['product']->price ?? '' }}</h3>
                <p class="mb-4">{{ $result['product']->description ?? '' }}</p>

                <div class="d-flex align-items-center mb-4 pt-2">
                    <form action="{{ route('cart.add', $result['product']->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </form>
                </div>
                {{-- <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    @if ($result['relatedProducts']->count())
        <!-- Products Start -->
        <div class="container-fluid py-5">
            {{-- <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
            </div> --}}
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        @foreach ($result['relatedProducts'] as $products)
                            <div class="card product-item border-0">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100"
                                        src="{{ App\Helpers\Image::getMediaUrl($products, 'products') }}"
                                        alt="{{ $products->title ?? '' }}"  loading="lazy">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    {{-- <h6 class="text-truncate mb-3">{{ $products->title ?? '' }}</h6> --}}
                                    <div class="d-flex justify-content-center">
                                        <h6>EGP {{ $products->price ?? '0.00' }}</h6>
                                        <h6 class="text-muted ml-2"><del>EGP {{ $products->old_price ?? '0.00' }}</del>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="{{ route('product.details', $products->id) }}"
                                        class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View
                                        Detail</a>
                                    <form action="{{ route('cart.add', $products->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm text-dark p-0">
                                            <i class="fas fa-shopping-cart text-primary mr-1"></i>
                                            Add To Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Products End -->
    @endif



@endsection
