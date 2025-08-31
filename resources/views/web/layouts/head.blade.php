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

