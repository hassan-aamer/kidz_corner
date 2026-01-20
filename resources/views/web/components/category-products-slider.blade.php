{{-- Category Products Slider Component --}}
@props(['category', 'index' => 0])

@if($category->products->isNotEmpty())
    <div class="container-fluid category-section" data-category-id="{{ $category->id }}">
        <div class="mb-2">
            {{-- Category Header --}}
            <div class="d-flex justify-content-between align-items-center mb-2 px-lg-5 px-3">
                <h2 class="category-title">
                    {{ $category->title ?? '' }}
                </h2>
                <a href="{{ route('products.category', $category->id) }}"
                    class="text-primary font-weight-bold text-decoration-none see-more-link">
                    See More
                </a>
            </div>

            {{-- Product Slider --}}
            <div id="carousel-{{ $category->id }}" class="owl-carousel owl-theme px-xl-5 product-carousel"
                data-items-count="{{ $category->products->count() }}" data-category-index="{{ $index }}">

                @foreach ($category->products as $product)
                    @include('web.components.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </div>
@endif