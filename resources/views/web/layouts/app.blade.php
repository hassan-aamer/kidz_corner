<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.layouts.head')
</head>

<body style="font-family: 'Cairo', sans-serif">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MNPQV6BV"
        height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
    @include('web.layouts.js')
</body>





</html>