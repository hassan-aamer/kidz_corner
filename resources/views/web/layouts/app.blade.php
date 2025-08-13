<!DOCTYPE html>
<html lang="en">

<head>
@include('web.layouts.head')
</head>

<body>
    @include('web.layouts.header')
    @yield('content')
    @include('web.layouts.footer')
    @include('web.layouts.js')
</body>

</html>
