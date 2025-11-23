<!-- ✅ 1. jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ✅ 2. Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

<!-- ✅ 3. jqBootstrapValidation (قبل contact.js) -->
<script src="{{ asset('web/mail/jqBootstrapValidation.min.js') }}"></script>

<!-- ✅ 4. contact.js (بعدها مباشرة) -->
<script src="{{ asset('web/mail/contact.js') }}"></script>

<!-- ✅ 5. باقي مكتباتك -->
<script src="{{ asset('web/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('web/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('web/js/main.js') }}"></script>

@include('admin.layouts.sweetalert')
@yield('js')

{{--
<script>
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
            e.preventDefault();
        }
    });
</script> --}}