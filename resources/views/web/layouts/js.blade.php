<!-- ✅ أولاً: jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<!-- ✅ ثانياً: Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

<!-- ✅ ثالثاً: مكتبات أخرى تعتمد على jQuery -->
<script src="{{ asset('web/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('web/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js"></script>

<!-- ✅ Contact & Validation -->
<script src="{{ asset('web/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('web/mail/contact.js') }}"></script>

<!-- ✅ سكربتات المشروع -->
<script src="{{ asset('web/js/main.js') }}"></script>

@include('admin.layouts.sweetalert')
@yield('js')


    {{-- <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
                e.preventDefault();
            }
        });
    </script> --}}
