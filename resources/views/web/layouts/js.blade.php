    <!-- Vendor JS Files -->
    <script src="{{ asset('web/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('web/vendor/php-email-form/validate.js') }}" defer></script>
    <script src="{{ asset('web/vendor/aos/aos.js') }}" defer></script>
    <script src="{{ asset('web/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('web/vendor/glightbox/js/glightbox.min.js') }}" defer></script>
    <script src="{{ asset('web/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}" defer></script>
    <script src="{{ asset('web/vendor/isotope-layout/isotope.pkgd.min.js') }}" defer></script>
    <script src="{{ asset('web/vendor/purecounter/purecounter_vanilla.js') }}" defer></script>
    @include('admin.layouts.sweetalert')
    <!-- Main JS File -->
    <script src="{{ asset('web/js/main.js') }}" defer></script>
    @yield('js')

    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
            }
        });
    </script>
