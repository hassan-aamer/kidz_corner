<meta charset="utf-8">
<title>@yield('title') | {{ setting('name') }}</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Free HTML Templates" name="keywords">
<meta content="Free HTML Templates" name="description">
<link rel="canonical" href="{{ url()->current() }}">
<script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ env('APP_NAME') }}",
        "url": "{{ env('APP_URL') }}",
        "logo": "{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "{{ setting('phone') }}",
            "contactType": "customer service",
            "areaServed": "EG",
            "availableLanguage": ["Arabic","English"]
        },
        "sameAs": [
            "{{ setting('facebook') ?? '' }}",
            "{{ setting('instagram') ?? '' }}",
            "{{ setting('twitter') ?? '' }}"
        ]
        }
    </script>

@include('web.layouts.css')
@yield('css')

<!-- Google Tag Manager -->
{{-- <script>(function (w, d, s, l, i) {
        w[l] = w[l] || []; w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        }); var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-MSR7PB6M');</script> --}}
<!-- End Google Tag Manager -->





<!-- Google Tag Manager -->
<script>
(function(w,d,s,l,i){
  w[l]=w[l]||[];
  w[l].push({'gtm.start': new Date().getTime(), event:'gtm.js'});
  var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s), dl=l!='dataLayer'?'&l='+l:'';
  j.async=true; j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;
  f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSR7PB6M');
</script>
<!-- End Google Tag Manager -->