@component('mail::message')
    Thank you, {{ $order->full_name }}

    Your order has been successfully received
    Order Number: {{ $order->id }}

    Order Summary
    Total: {{ number_format($order->total, 2) }} EGP
    Payment Method: {{ ucfirst($order->payment_method) }}
    Status: {{ ucfirst($order->status) }}

    We will contact you shortly to arrange delivery

    Thank you for choosing us
    {{ config('app.name') }}
@endcomponent
