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
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XCK506JV60"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-XCK506JV60');
    </script>
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "t1vavz97f0");
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5P278XRM');
    </script>
    <!-- End Google Tag Manager -->
