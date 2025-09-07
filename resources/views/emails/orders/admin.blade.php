@component('mail::message')
    New Order Notification

    Hello Admin,

    A new order has been placed with the following details:

    Customer Information
    Name: {{ $order->full_name }}
    Phone: {{ $order->phone }}
    @if ($order->another_phone)
        Alternate Phone: {{ $order->another_phone }}
    @endif
    @if ($order->email)
        Email: {{ $order->email ?? '-' }}
    @endif
    Address: {{ $order->address }}
    City: {{ $order->city->title ?? '-' }}
    Area: {{ $order->area->title ?? '-' }}

    Order Details
    @foreach ($order->items as $item)
        Product: {{ $item->product->title ?? 'N/A' }}
        Quantity: {{ $item->quantity }} × {{ number_format($item->price, 2) }} EGP
    @endforeach

    Summary
    Shipping: {{ number_format($order->shipping_price, 2) }} EGP
    Total: {{ number_format($order->total, 2) }} EGP

    Order Status
    Payment Method: {{ ucfirst($order->payment_method) }}
    Payment Status: {{ ucfirst($order->payment_status) }}
    Status: {{ ucfirst($order->status) }}

    Thank you,
    {{ config('app.name') }}
@endcomponent
