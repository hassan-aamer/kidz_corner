@extends('web.layouts.app')
@section('title', __('attributes.shop'))
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                    data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0" style="font-weight: bold;">Categories</h6>
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


    <!-- Shop Start -->
    <div class="container-fluid pt-5">

        {{-- <div class="mb-4">
            <h2 class="px-lg-5 px-3" style="font-weight: bold; text-align: left; margin-bottom: 0;">{{ __('attributes.products') }}</h2>
        </div> --}}

        <div class="row px-xl-5">
            <!-- Shop Product Start -->
            <div class="col-lg-12 col-md-12">
                <div class="row pb-3">

                    @if ($result['products']->count())
                        @foreach ($result['products']->sortBy('position') as $products)
                            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                                <div class="card border-0 mb-4"
                                    style="border-radius:16px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease;">

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
                                            style="font-size:16px; font-weight:bold; color:#333; margin-bottom:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ strtoupper($products->title ?? '') }}
                                        </h6>
                                        <div style="display:flex; justify-content:center; align-items:center; gap:8px;">
                                            <h6 style="color:#C73B65; font-weight:700; margin:0;">{{ $products->price ?? '' }}
                                            </h6>
                                            @if($products->old_price)
                                                <h6 style="color:#1D9DB1; font-size:14px; margin:0; text-decoration:line-through;">
                                                    {{ $products->old_price ?? '' }}
                                                </h6>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- الأزرار -->
                                    <div class="card-footer d-flex justify-content-between align-items-center"
                                        style="background:#C73B65; border-top:1px solid #eee; padding:12px 16px;">
                                        <a href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}"
                                            style="font-size:14px; font-weight:600; color:#333; text-decoration:none; display:flex; align-items:center; transition:color 0.3s ease;">
                                            <i class="fas fa-eye" style="color:#fff; margin-right:6px;"></i> 
                                        </a>
                                        <form action="{{ route('cart.add', $products->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit"
                                                style="background:#1D9DB1; color:#fff; border:none; padding:6px 14px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:background 0.3s ease;">
                                                <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('empty-folder.png') }}" alt="not found" width="300" height="300" loading="lazy">
                        </div>
                    @endif

                    <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                            {{ $result['products']->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection