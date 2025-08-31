    <!-- Footer Start -->
    <div class="container-fluid mt-5 pt-5"
        style="background: url('{{ asset('public/web/img/fotter.jpg') }}') no-repeat center center/cover;">
        <div class="row px-xl-5 pt-5 text-white">
            <div class="col-lg-8 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <img class="mb-4 display-5 font-weight-semi-bold"
                        src="{{ App\Helpers\Image::getMediaUrl(App\Models\Setting::first(), 'logo') }}"
                        alt="{{ setting('name') ?? '' }}" height="70" width="170">
                </a>
                @if (setting('address'))
                    <p class="mb-2"><i
                            class="fa fa-map-marker-alt text-primary mr-3"></i>{{ setting('address') ?? '' }}</p>
                @endif
                @if (setting('email'))
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ setting('email') ?? '' }}</p>
                @endif
                @if (setting('phone'))
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ setting('phone') ?? '' }}</p>
                @endif
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <h5 class="font-weight-bold text-white mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="{{ route('home') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-white mb-2" href="{{ route('products') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Shop</a>
                            <a class="text-white" href="{{ route('contact') }}"><i
                                    class="fa fa-angle-right mr-2"></i>Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-xl-5 py-4 text-white">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left">
                    <a class="text-white font-weight-semi-bold"
                        href="{{ route('home') }}">{{ setting('copyrights') ?? '' }}</a>. Powered
                    by
                    <a class="text-white font-weight-semi-bold" href="https://viral-monkeys.com">Viral Monkeys</a><br>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
