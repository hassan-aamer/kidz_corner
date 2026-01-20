@extends('web.layouts.app')
@section('title', __('attributes.home'))
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <style>
        .header-carousel {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s ease;
        }

        .carousel-item-custom {
            width: 100%;
            height: 410px;
        }

        .carousel-caption-custom {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .carousel-caption-inner {
            max-width: 700px;
            text-align: center;
        }

        .banner-title {
            color: #C73B65;
        }

        .shop-now-btn {
            border-radius: 16px;
            color: #1D9DB1;
            font-weight: 600;
        }

        .carousel-control-custom {
            width: auto;
            height: auto;
            display: flex;
            align-items: center;
        }

        .carousel-control-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-title {
            font-weight: bold;
            text-align: left;
            margin-bottom: 0;
            color: #1D9DB1;
        }

        .product-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .product-image-container {
            height: 300px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .sold-out-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #1D9BAE;
            color: #fff;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
        }

        .discount-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #dc3545;
            color: #fff;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 600;
        }

        .product-body {
            padding: 16px;
            text-align: center;
        }

        .product-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .current-price {
            color: #C73B65;
            font-weight: 700;
            margin: 0;
        }

        .old-price {
            color: #1D9DB1;
            font-size: 14px;
            margin: 0;
            text-decoration: line-through;
        }

        .product-footer {
            background: #C73B65;
            border-top: 1px solid #eee;
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-details {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .view-details i {
            color: #fff;
            margin-right: 6px;
        }

        .add-to-cart-btn {
            background: #1D9DB1;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .add-to-cart-btn i {
            margin-right: 6px;
        }

        @media (max-width: 768px) {
            .carousel-item-custom {
                height: 280px !important;
            }

            .product-image-container {
                height: 150px;
            }
        }
    </style>
@endsection
@section('content')

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                @include('web.layouts.nav')

                <div id="header-carousel" class="carousel slide header-carousel" data-ride="carousel" data-interval="2000">
                    <div class="carousel-inner">
                        @foreach ($result['banners'] as $key => $banner)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }} carousel-item-custom">
                                <img class="img-fluid w-100" src="{{ App\Helpers\Image::getMediaUrl($banner, 'banners') }}"
                                    alt="{{ $banner->title ?? 'Banner' }}" loading="lazy">

                                <div class="carousel-caption carousel-caption-custom">
                                    <div class="carousel-caption-inner p-3">
                                        <h3 class="display-5 font-weight-semi-bold mb-4 banner-title">
                                            {{ $banner->title ?? '' }}
                                        </h3>
                                        <a href="{{ route('products') }}" class="btn btn-light py-2 px-3 shop-now-btn">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a class="carousel-control-prev carousel-control-custom" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark carousel-control-btn">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>

                    <a class="carousel-control-next carousel-control-custom" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark carousel-control-btn">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar End -->


    @foreach ($result['categories']->sortBy('position') as $category)
        @include('web.components.category-products-slider', ['category' => $category, 'index' => $loop->index])
    @endforeach




@endsection
@section('js')
    {{-- jQuery and OwlCarousel are already loaded in js.blade.php --}}
    <script>
        $(document).ready(function () {
            /**
             * Smart Carousel Initialization
             * Dynamically adjusts loop behavior based on item count vs visible items
             */

            // Get responsive item counts
            function getResponsiveItemCount(width) {
                if (width >= 1200) return 5;
                if (width >= 992) return 4;
                if (width >= 576) return 3;
                return 2;
            }

            // Initialize each carousel with smart options
            $(".product-carousel").each(function () {
                const $carousel = $(this);
                const itemCount = parseInt($carousel.data('items-count')) || $carousel.find('.item').length;
                const visibleItems = getResponsiveItemCount($(window).width());

                // Only enable loop if we have more items than visible
                const shouldLoop = itemCount > visibleItems;

                const options = {
                    loop: shouldLoop,
                    rewind: !shouldLoop, // Use rewind for smooth experience when loop is disabled
                    margin: 20,
                    nav: itemCount > visibleItems, // Show nav only when there are more items
                    navText: [
                        '<i class="fas fa-chevron-left"></i>',
                        '<i class="fas fa-chevron-right"></i>'
                    ],
                    dots: true,
                    autoplay: shouldLoop, // Only autoplay if looping
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    smartSpeed: 500,
                    responsive: {
                        0: {
                            items: Math.min(2, itemCount),
                            nav: false
                        },
                        576: {
                            items: Math.min(3, itemCount),
                            nav: itemCount > 3
                        },
                        992: {
                            items: Math.min(4, itemCount),
                            nav: itemCount > 4
                        },
                        1200: {
                            items: Math.min(5, itemCount),
                            nav: itemCount > 5
                        }
                    },
                    onInitialized: function () {
                        // Add loaded class for CSS transitions
                        $carousel.addClass('carousel-loaded');
                    }
                };

                $carousel.owlCarousel(options);
            });

            // Handle window resize for responsive adjustments
            let resizeTimeout;
            $(window).on('resize', function () {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function () {
                    $(".product-carousel").each(function () {
                        const $carousel = $(this);
                        // Trigger refresh on resize
                        $carousel.trigger('refresh.owl.carousel');
                    });
                }, 250);
            });
        });
    </script>
@endsection