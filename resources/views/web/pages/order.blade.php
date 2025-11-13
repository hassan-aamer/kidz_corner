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

<!-- Checkout Start -->
<div class="container-fluid pt-2">
    <form action="{{ route('order.checkout') }}" method="post">
        @csrf
        <div class="row px-xl-5">

            <!-- بيانات الشحن -->
            <div class="col-lg-8">
                <div class="mb-4 p-4"
                    style="background:#fff; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <h4 style="font-weight:700; margin-bottom:20px; color:#333;">🚚 Shipping Address</h4>
                    <div class="row">

                        <div class="col-md-4 form-group">
                            {{-- <label style="font-weight:600;">Full Name</label> --}}
                            <input class="form-control" autocomplete="full_name" type="text" required name="full_name" placeholder="Full Name"
                                style="border-radius:8px; border:1px solid #ddd; padding:12px;">
                        </div>

                        <div class="col-md-4 form-group">
                            {{-- <label style="font-weight:600;">E-mail (optional)</label> --}}
                            <input class="form-control" autocomplete="email" type="email" name="email" placeholder="E-mail (optional)"
                                style="border-radius:8px; border:1px solid #ddd; padding:12px;">
                        </div>

                        <div class="col-md-4 form-group">
                            {{-- <label style="font-weight:600;">Phone</label> --}}
                            <input class="form-control" autocomplete="phone" type="text" required name="phone" placeholder="Phone"
                                style="border-radius:8px; border:1px solid #ddd; padding:12px;">
                        </div>

                        {{-- <div class="col-md-6 form-group">
                            <label style="font-weight:600;">Another phone (optional)</label>
                            <input class="form-control" type="text" name="another_phone" placeholder="+123 456 789"
                                style="border-radius:8px; border:1px solid #ddd; padding:12px;">
                        </div> --}}

                        {{-- <div class="col-md-6 form-group">
                            <select class="custom-select" name="city_id" id="citySelect" required
                                style="border-radius:8px; border:1px solid #ddd;">
                                <option value="" disabled selected>Select City</option>
                                @foreach ($cities->where('parent_id', null) as $city)
                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- <div class="col-md-6 form-group">
                            <select class="custom-select" name="area_id" id="areaSelect" required
                                style="border-radius:8px; border:1px solid #ddd;">
                                <option value="" disabled selected>Select Area</option>
                            </select>
                        </div> --}}

                        <div class="col-md-12 form-group">
                            {{-- <label style="font-weight:600;">Address</label> --}}
                            <textarea rows="2" autocomplete="address" class="form-control" name="address" placeholder="Full Address: ( Country ,City ,1 Street )"
                                style="border-radius:8px; border:1px solid #ddd; padding:12px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ملخص الطلب والدفع -->
            <div class="col-lg-4">

                <!-- ملخص الطلب -->
                <div class="card mb-4" style="border:none; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <div class="card-header"
                        style="background:#C73B65; color:#fff; border-radius:16px 16px 0 0; text-align:center;">
                        <h4 style="margin:0; font-weight:700;">Total Order </h4>
                    </div>
                    <div class="card-body">
                        <h5 style="font-weight:600; margin-bottom:15px;">Products</h5>
                        @foreach ($cart->items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <img src="{{ App\Helpers\Image::getMediaUrl($item->product, 'products') }}" alt=""
                                    style="width:50px; border-radius:8px;" loading="lazy">
                                <p style="margin:0; font-weight:600; color:#333;"> {{ $item->product->price ?? '' }} EGP</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <h6 style="font-weight:600;">Subtotal</h6>
                            <h6 id="subtotalInput" style="font-weight:700; color:#C73B65;"> {{ $total }} EGP</h6>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <h6 style="font-weight:600;">Free Shipping</h6>
                            <h6 style="font-weight:700; color:#C73B65;"><del> 80 EGP</del></h6>
                            {{-- <h6 id="shippingPrice" style="font-weight:700; color:#C73B65;">0 EGP</h6> --}}
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h5 style="font-weight:700;">Grand Total</h5>
                            <h5 id="totalPrice" style="font-weight:700; color:#C73B65;"> {{ $total }} EGP</h5>
                        </div>
                        <!-- input hidden يرسل القيمة إلى قاعدة البيانات -->
                        <input type="hidden" id="totalInput" name="total" value="{{ $total }}">
                    </div>
                </div>

                <!-- الدفع -->
                <div class="card mb-4" style="border:none; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                    <div class="card-header"
                        style="background:#C73B65; color:#fff; border-radius:16px 16px 0 0; text-align:center;">
                        <h4 style="margin:0; font-weight:700;">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" class="custom-control-input" value="cash" name="payment_method"
                                id="cash" required>
                            <label class="custom-control-label" for="cash">Cash on delivery</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_method" value="instapay"
                                id="instapay">
                            <label class="custom-control-label" for="instapay">Insta Pay</label>
                        </div>
                        <div id="instapayBox" class="mt-3 p-3 border rounded bg-light"
                            style="border-color:#d72864 !important; display:none;">
                            <strong class="text-dark">Payment Instructions:</strong><br>
                            <span class="text-muted small" style="font-style:italic;">
                                • Transfer the total order amount to: <b>0109 2476133</b><br>
                                • After payment, send a screenshot via WhatsApp to the same number.
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit"
                            style="background:blue; color:#fff; border:none; border-radius:8px; padding:14px; font-weight:700; width:100%; transition:0.3s;">
                            Place Order
                        </button>
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
    $(document).ready(function () {
        var locale = "{{ app()->getLocale() }}";

        function updateTotal() {
            let subtotalText = $('#subtotalInput').text().replace('EGP', '').trim();
            let subtotal = parseFloat(subtotalText) || 0;
            let shippingText = $('#shippingPrice').text().replace('EGP', '').trim();
            let shipping = parseFloat(shippingText) || 0;
            let total = subtotal + shipping;

            $('#totalPrice').text(total + ' EGP ');
            $('#totalInput').val(total);
        }

        $('#citySelect').on('change', function () {
            var cityId = $(this).val();
            if (cityId) {
                $.ajax({
                    url: '/get-areas/' + cityId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#areaSelect').empty();
                        $('#areaSelect').append('<option value="" disabled selected>Select Area</option>');
                        $.each(data, function (key, value) {
                            var areaTitle = value.title[locale] || value.title['en'];
                            $('#areaSelect').append('<option value="' + value.id +
                                '" data-shipping="' + value.shipping_price + '">' +
                                areaTitle + '</option>');
                        });
                    }
                });

                $.ajax({
                    url: '{{ route('getCityShipping') }}',
                    type: 'GET',
                    data: { city_id: cityId },
                    success: function (response) {
                        $('#shippingPrice').text('EGP ' + response.shipping_price);
                        updateTotal();
                    },
                    error: function () {
                        $('#shippingPrice').text('EGP 0');
                        updateTotal();
                    }
                });
            } else {
                $('#areaSelect').empty();
                $('#shippingPrice').text('EGP 0');
                updateTotal();
            }
        });

        $('#areaSelect').on('change', function () {
            var shipping = $(this).find(':selected').data('shipping') || 0;
            $('#shippingPrice').text('EGP ' + shipping);
            updateTotal();
        });

        $('input[name="payment_method"]').on('change', function () {
            if ($(this).val() === 'instapay') {
                $('#instapayBox').show();
            } else {
                $('#instapayBox').hide();
            }
        });

        updateTotal();
    });
</script>

<script>
    fbq('track', 'InitiateCheckout', {
        value: {{ $total ?? 0 }},
        currency: 'EGP'
    });
</script>
@endsection
