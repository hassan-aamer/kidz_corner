<!DOCTYPE html>
<html lang="en">

<head>
    @include('web.layouts.head')
</head>

<body style="font-family: 'Cairo', sans-serif">
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
    @include('web.layouts.js')
</body>

</html>
