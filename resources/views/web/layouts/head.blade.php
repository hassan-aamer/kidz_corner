<meta charset="utf-8">
<title>@yield('title') | {{ setting('name') }}</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Free HTML Templates" name="keywords">
<meta content="Free HTML Templates" name="description">
{{-- <meta name="facebook-domain-verification" content="f1ij5g3bqbw4fddgrwruk5yyubex56" /> --}}
<link rel="canonical" href="{{ url()->current() }}">
{{-- <script type="application/ld+json">
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
    </script> --}}

@include('web.layouts.css')
@yield('css')

<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1380345543791870');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1380345543791870&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->


<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "u1dnbfdgc3");
</script>