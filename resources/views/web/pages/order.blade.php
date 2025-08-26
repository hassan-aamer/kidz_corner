@extends('web.layouts.app')
@section('title', __('attributes.order'))
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form action="{{ route('order.checkout') }}" method="post">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Full Name</label>
                                <input class="form-control" type="text" required name="full_name" placeholder="John Doe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" required name="email"
                                    placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" required name="phone"
                                    placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <select class="custom-select" name="city_id" id="citySelect" required>
                                    <option value="" disabled selected>Select City</option>
                                    @foreach ($cities->where('parent_id', null) as $city)
                                        <!-- المدن فقط -->
                                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Area</label>
                                <select class="custom-select" name="area_id" id="areaSelect" required>
                                    <option value="" disabled selected>Select Area</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label>Address</label>
                                <textarea rows="4" class="form-control" type="text" name="address" placeholder="123 Street"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            @foreach ($cart->items as $item)
                                <div class="d-flex justify-content-between">
                                    <p>{{ $item->product->title ?? '' }}</p>
                                    <p>EGP {{ $item->product->price ?? '' }}</p>
                                </div>
                            @endforeach
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium" id="shippingPrice">EGP 0</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">EGP {{ $total }}</h5>
                                <input type="hidden" name="total" value="{{ $total }}">
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="cash" name="payment_method"
                                        id="directcheck" required>
                                    <label class="custom-control-label" for="directcheck">Cash on delivery</label>
                                </div>
                            </div>
                            <div class="">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_method"
                                        value="instapay" id="banktransfer">
                                    <label class="custom-control-label" for="banktransfer">Insta Pay</label>
                                </div>
                            </div>
                            {{-- <div class="">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment_method" value="visa"
                                        id="banktransfer">
                                    <label class="custom-control-label" for="banktransfer">Visa</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit"
                                class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                                Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->

@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var locale = "{{ app()->getLocale() }}";

            $('#citySelect').on('change', function() {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: '/get-areas/' + cityId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#areaSelect').empty();
                            $('#areaSelect').append(
                                '<option value="" disabled selected>Select Area</option>');
                            $.each(data, function(key, value) {
                                var areaTitle = value.title[locale] || value.title[
                                'en'];
                                $('#areaSelect').append('<option value="' + value.id +
                                    '" data-shipping="' + value.shipping_price +
                                    '">' + areaTitle + '</option>');
                            });
                        }
                    });

                    $.ajax({
                        url: '{{ route('getCityShipping') }}',
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        success: function(response) {
                            $('#shippingPrice').text('EGP ' + response.shipping_price);
                        },
                        error: function() {
                            $('#shippingPrice').text('EGP 0');
                        }
                    });
                } else {
                    $('#areaSelect').empty();
                    $('#shippingPrice').text('EGP 0');
                }
            });

            $('#areaSelect').on('change', function() {
                var shipping = $(this).find(':selected').data('shipping') || 0;
                $('#shippingPrice').text('EGP ' + shipping);
            });
        });
    </script>

@endsection
