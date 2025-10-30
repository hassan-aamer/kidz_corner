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
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            @if ($cart->items->count())
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
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
                                <tr>
                                    <td class="align-middle"><img
                                            src="{{ App\Helpers\Image::getMediaUrl($item->product, 'products') }}"
                                            alt="" style="width: 50px;" loading="lazy">
                                        {{-- {{ $item->product->title ?? '' }} --}}
                                    </td>
                                    <td class="align-middle">EGP {{ $item->product->price ?? '' }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="d-flex justify-content-center">
                                            @csrf
                                            @method('PATCH')

                                            <div class="input-group quantity mx-auto" style="width: 120px;">
                                                <div class="input-group-btn">
                                                    <button type="submit" name="action" value="decrement"
                                                        class="btn btn-sm btn-primary" style="background-color: #d72864;">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>

                                                <input type="text"
                                                    class="form-control form-control-sm bg-secondary text-center"
                                                    value="{{ $item->quantity }}" readonly>

                                                <div class="input-group-btn">
                                                    <button type="submit" name="action" value="increment"
                                                        class="btn btn-sm btn-primary" style="background-color: #d72864;">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="align-middle">EGP {{ $item->product->price * $item->quantity ?? '' }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-primary" style="background-color: #d72864;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                        </div>
                        {{-- <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">EGP 10</h6>
                            </div>
                        </div> --}}
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">EGP {{ $total ?? 0 }}</h5>
                            </div>
                            <a href="{{ route('order') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To
                                Checkout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('empty-folder.png') }}" alt="not found" width="300" height="300"
                        loading="lazy">
                </div>
            @endif

        </div>
    </div>
    <!-- Cart End -->

@endsection
@section('js')
    <script>
        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.closest('.input-group').querySelector('input[name="quantity"]');
                input.value = parseInt(input.value) + 1;
                this.closest('form').submit();
            });
        });

        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.closest('.input-group').querySelector('input[name="quantity"]');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    this.closest('form').submit();
                }
            });
        });
    </script>

{{-- <script>
document.addEventListener('DOMContentLoaded', function () {

  // ====== safety checks & debug ======
  console.log('Cart page: JS loaded. total =', {{ $total ?? 0 }});

  // Prevent duplicate sends on refresh/navigation
  var addToCartFlagKey = 'cc_add_to_cart_sent_{{ optional(auth()->user())->id ?: 'guest' }}';
  if (sessionStorage.getItem(addToCartFlagKey)) {
    console.log('AddToCart: already sent in this session — skipping.');
    return;
  }

  // Make sure cart has items
  var cartTotal = Number({{ $total ?? 0 }});
  if (!cartTotal || cartTotal <= 0) {
    console.warn('AddToCart: total is zero or undefined — skipping event.');
    return;
  }

  // Make sure fbq exists
  if (typeof fbq !== 'undefined') {
    try {
      fbq('track', 'AddToCart', {
        value: cartTotal,
        currency: 'EGP',
        content_type: 'product',
        contents: [
          @foreach($cart->items as $item)
          {
            id: '{{ $item->product_id }}',
            name: {!! json_encode($item->product->name ?? $item->product->title ?? '') !!},
            quantity: {{ $item->quantity }},
            item_price: {{ $item->product->price ?? 0 }}
          },
          @endforeach
        ]
      });
      console.log('AddToCart: fbq track fired', cartTotal);
    } catch (e) {
      console.error('AddToCart: fbq error', e);
    }
  } else {
    console.error('AddToCart: fbq is not defined. Make sure Pixel base code is in layout head.');
  }

  // Push to dataLayer for GTM
  try {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      event: 'add_to_cart',
      value: cartTotal,
      currency: 'EGP',
      items: [
        @foreach($cart->items as $item)
        {
          item_id: '{{ $item->product_id }}',
          item_name: {!! json_encode($item->product->name ?? $item->product->title ?? '') !!},
          price: {{ $item->product->price ?? 0 }},
          quantity: {{ $item->quantity }}
        },
        @endforeach
      ]
    });
    console.log('AddToCart: dataLayer push fired');
  } catch (e) {
    console.error('AddToCart: dataLayer error', e);
  }

  // Mark as sent to avoid duplicates in same session
  sessionStorage.setItem(addToCartFlagKey, '1');

});
</script> --}}
@endsection
