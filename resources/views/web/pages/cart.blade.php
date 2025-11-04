@extends('web.layouts.app')
@section('title', __('attributes.cart'))
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
      <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
      <div class="d-inline-flex">
        <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
        <p class="m-0 px-2">-</p>
        <p class="m-0">Shopping Cart</p>
      </div>
    </div>
  </div> --}}
  <!-- Page Header End -->


  <!-- Cart Start -->
  <div class="container-fluid pt-5">

    <div class="mb-4">
      <h2 class="px-lg-5 px-3" style="font-weight: bold; text-align: left; margin-bottom: 0;">🛒 Shopping Cart</h2>
    </div>

    <div class="row px-xl-5">
      @if ($cart->items->count())
        <!-- جدول المنتجات -->
        <div class="col-lg-8 table-responsive mb-5">
          <table class="table text-center mb-0"
            style="border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
            <thead style="background:#C73B65; color:#fff;">
              <tr>
                <th>Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody class="align-middle">
              @foreach ($cart->items as $item)
                <tr style="border-bottom:1px solid #eee;">
                  <td class="align-middle">
                    <img src="{{ App\Helpers\Image::getMediaUrl($item->product, 'products') }}" alt=""
                      style="width:60px; border-radius:8px;" loading="lazy">
                  </td>
                  <td class="align-middle" style="font-weight:600; color:#333;">
                    EGP {{ $item->product->price ?? '' }}
                  </td>
                  <td class="align-middle">
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex justify-content-center">
                      @csrf
                      @method('PATCH')
                      <div class="input-group" style="width:120px;">
                        <button type="submit" name="action" value="decrement"
                          style="background:#C73B65; color:#fff; border:none; padding:6px 10px; border-radius:6px 0 0 6px;">
                          <i class="fa fa-minus"></i>
                        </button>
                        <input type="text" class="form-control text-center" value="{{ $item->quantity }}" readonly
                          style="border:1px solid #ddd; font-weight:600;">
                        <button type="submit" name="action" value="increment"
                          style="background:#C73B65; color:#fff; border:none; padding:6px 10px; border-radius:0 6px 6px 0;">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </form>
                  </td>
                  <td class="align-middle" style="font-weight:600; color:#C73B65;">
                    EGP {{ $item->product->price * $item->quantity ?? '' }}
                  </td>
                  <td class="align-middle">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        style="background:#ff4d4d; color:#fff; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;">
                        <i class="fa fa-times"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- ملخص الكارت -->
        <div class="col-lg-4">
          <div class="card mb-5" style="border:none; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
            <div class="card-header"
              style="background:#C73B65; color:#fff; border-radius:12px 12px 0 0; text-align:center;">
              <h4 style="margin:0; font-weight:700;">Cart Summary</h4>
            </div>
            <div class="card-body" style="padding:20px;">
              <div class="d-flex justify-content-between mb-3">
                <h5 style="font-weight:600;">Total</h5>
                <h5 style="font-weight:700; color:#C73B65;">EGP {{ $total ?? 0 }}</h5>
              </div>
              <a href="{{ route('order') }}"
                style="display:block; text-align:center; background:#C73B65; color:#fff; font-weight:700; padding:12px; border-radius:8px; text-decoration:none; transition:0.3s;">
                Proceed To Checkout
              </a>
            </div>
          </div>
        </div>
      @else
        <div class="col-12 d-flex justify-content-center align-items-center">
          <img src="{{ asset('empty-folder.png') }}" alt="not found" width="300" height="300" loading="lazy">
        </div>
      @endif
    </div>
  </div>
  <!-- Cart End -->

@endsection
@section('js')
  <script>
    document.querySelectorAll('.btn-plus').forEach(btn => {
      btn.addEventListener('click', function () {
        let input = this.closest('.input-group').querySelector('input[name="quantity"]');
        input.value = parseInt(input.value) + 1;
        this.closest('form').submit();
      });
    });

    document.querySelectorAll('.btn-minus').forEach(btn => {
      btn.addEventListener('click', function () {
        let input = this.closest('.input-group').querySelector('input[name="quantity"]');
        if (parseInt(input.value) > 1) {
          input.value = parseInt(input.value) - 1;
          this.closest('form').submit();
        }
      });
    });
  </script>


  <script>
    fbq('track', 'AddToCart', {
      value: {{ $total ?? 0 }},
      currency: 'EGP'
    });
  </script>




@endsection