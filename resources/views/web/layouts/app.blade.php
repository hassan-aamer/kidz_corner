<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.layouts.head')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5P278XRM" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
    @include('web.layouts.js')
</body>

</html>
