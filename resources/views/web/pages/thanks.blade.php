@extends('web.layouts.app')
@section('title', __('attributes.thanks'))
@section('css')


@endsection
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

    <!-- محتوى الشكر -->
    <div class="container" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 15px;padding-top: 20px;">
        <div class="thank-you-content"
            style="max-width: 800px; margin: 0 auto 60px; background: white; border-radius: 15px; padding: 40px;  text-align: center;">
            <div class="success-icon" style="font-size: 5rem; color: #28a745; margin-bottom: 20px;">✓</div>
            <h2 style="color: #2c3e50; margin-bottom: 20px; font-size: 1.8rem;">Your order has been successfully confirmed!</h2>
            <p style="color: #555; margin-bottom: 25px; font-size: 1.1rem;">Thank you for your trust in us. Your order has been received </p>

            <div class="order-details"
                style="background: #f8f9fa; border-radius: 10px; padding: 25px; margin: 30px 0; text-align: left;">
                <h3 style="color: #2c3e50; margin-bottom: 15px; border-bottom: 1px solid #eaeaea; padding-bottom: 10px;">
                     {{ __('attributes.order_details') }}</h3>
                <div class="order-info" style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                    <div
                        style="flex: 1; min-width: 200px; margin: 10px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <h4 style="color: #C73B65; margin-bottom: 8px; font-size: 1rem;"> Order number</h4>
                        <p style="margin: 0; font-weight: 600; color: #333;">#{{ $order->id ?? '' }}</p>
                    </div>
                    <div
                        style="flex: 1; min-width: 200px; margin: 10px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <h4 style="color: #C73B65; margin-bottom: 8px; font-size: 1rem;">Order date</h4>
                        <p style="margin: 0; font-weight: 600; color: #333;">{{ $order->created_at->format('d F Y') ?? '' }}</p>
                    </div>
                    <div
                        style="flex: 1; min-width: 200px; margin: 10px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <h4 style="color: #C73B65; margin-bottom: 8px; font-size: 1rem;">Total amount</h4>
                        <p style="margin: 0; font-weight: 600; color: #333;">EGP {{ $order->total ?? 0 }} <p>
                    </div>
                    <div
                        style="flex: 1; min-width: 200px; margin: 10px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                        <h4 style="color: #C73B65; margin-bottom: 8px; font-size: 1rem;">Payment method</h4>
                        <p style="margin: 0; font-weight: 600; color: #333;"> {{ $order->payment_method ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- <p style="color: #555; margin-bottom: 25px; font-size: 1.1rem;">سيتم إرسال رسالة تأكيد إلى بريدك الإلكتروني
                المسجل مع تفاصيل الطلب ورقم التتبع.</p> --}}

            <div class="action-buttons"
                style="display: flex; justify-content: center; gap: 15px; margin-top: 30px; flex-wrap: wrap;">

                <a href="{{ route('products') }}" class="btn btn-outline"
                    style="padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; display: inline-block; border: none; cursor: pointer; font-size: 1rem; background-color: transparent; color: #C73B65; border: 2px solid #C73B65;">Continue shopping</a>
            </div>
        </div>
    </div>

    <style>
        /* إضافة تأثيرات Hover */
        .btn-primary:hover {
            background-color: #C73B65 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(199, 59, 101, 0.3) !important;
        }

        .btn-outline:hover {
            background-color: #C73B65 !important;
            color: white !important;
            transform: translateY(-2px);
        }

        /* التجاوب مع الشاشات المختلفة */
        @media (max-width: 768px) {
            .thank-you-content {
                padding: 25px !important;
            }

            .order-info {
                flex-direction: column !important;
            }

            .action-buttons {
                flex-direction: column !important;
                align-items: center !important;
            }

            .btn {
                width: 100% !important;
                max-width: 300px !important;
            }
        }
    </style>


@endsection
@section('js')
{{-- <script>
// ✅ Facebook Pixel Purchase Event
fbq('track', 'Purchase', {
  value: {{ $order->total ?? 0 }},
  currency: 'EGP',
  content_type: 'product',
  contents: [
    @foreach($order->items as $item)
    {
      id: '{{ $item->product_id }}',
      name: '{{ $item->product->name }}',
      quantity: {{ $item->quantity }},
      item_price: {{ $item->price }}
    },
    @endforeach
  ],
  order_id: '{{ $order->id }}'
});

// ✅ Google Tag Manager Purchase Event
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
  event: 'purchase',
  value: {{ $order->total ?? 0 }},
  currency: 'EGP',
  order_id: '{{ $order->id }}',
  items: [
    @foreach($order->items as $item)
    {
      item_id: '{{ $item->product_id }}',
      item_name: '{{ $item->product->name }}',
      price: {{ $item->price }},
      quantity: {{ $item->quantity }}
    },
    @endforeach
  ]
});
</script> --}}

<script>
window.addEventListener('load', function () {

  // ===== Debug Info =====
  console.log('💰 Purchase event loaded | order total =', {{ $order->total ?? 0 }}, '| order ID = {{ $order->id }}');

  var orderTotal = Number({{ $order->total ?? 0 }});
  var orderId = '{{ $order->id }}';
  var purchaseFlagKey = 'cc_purchase_sent_' + orderId;

  // ✅ منع التكرار (لتفادي إرسال الحدث مرتين)
  if (sessionStorage.getItem(purchaseFlagKey)) {
    console.log('⚠️ Purchase event already sent for order:', orderId);
    return;
  }

  // ✅ تحقق من وجود قيمة
  if (!orderTotal || orderTotal <= 0) {
    console.warn('⚠️ Purchase event skipped — total is zero or undefined.');
    return;
  }

  // ✅ Facebook Pixel
  if (typeof fbq === 'function') {
    try {
      fbq('track', 'Purchase', {
        value: orderTotal,
        currency: 'EGP',
        content_type: 'product',
        contents: [
          @foreach($order->items as $item)
          {
            id: '{{ $item->product_id }}',
            name: {!! json_encode($item->product->name ?? $item->product->title ?? '') !!},
            quantity: {{ $item->quantity }},
            item_price: {{ $item->price ?? 0 }}
          },
          @endforeach
        ],
        order_id: orderId
      });
      console.log('✅ fbq Purchase event fired:', orderId, orderTotal);
    } catch (e) {
      console.error('❌ fbq Purchase error:', e);
    }
  } else {
    console.error('❌ fbq is not defined — ensure Meta Pixel base code is loaded before this script.');
  }

  // ✅ Google Tag Manager
  try {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      event: 'purchase',
      value: orderTotal,
      currency: 'EGP',
      transaction_id: orderId,
      items: [
        @foreach($order->items as $item)
        {
          item_id: '{{ $item->product_id }}',
          item_name: {!! json_encode($item->product->name ?? $item->product->title ?? '') !!},
          price: {{ $item->price ?? 0 }},
          quantity: {{ $item->quantity }}
        },
        @endforeach
      ]
    });
    console.log('✅ GTM purchase event pushed to dataLayer:', orderId);
  } catch (e) {
    console.error('❌ dataLayer push error:', e);
  }

  // ✅ منع التكرار في نفس الجلسة
  sessionStorage.setItem(purchaseFlagKey, '1');
});
</script>


@endsection

