{{-- Product Card Component for Slider --}}
@props(['product'])

<div class="item">
    <div class="card border-0 mb-2 product-card">
        {{-- Product Image --}}
        <a href="{{ route('product.details', ['id' => $product->id, 'title' => Str::slug($product->title) ?? '']) }}">
            <div class="position-relative product-image-container">
                <img class="img-fluid lazyload product-image"
                    src="{{ App\Helpers\Image::getMediaUrl($product, 'products') }}" alt="{{ $product->title ?? '' }}"
                    loading="lazy">

                @if ($product->sold_out == 1)
                    <span class="sold-out-badge">{{ __('attributes.sold_out') }}</span>
                @endif

                @if($product->old_price && $product->old_price > $product->price)
                    @php
                        $discount = round((($product->old_price - $product->price) / $product->old_price) * 100);
                    @endphp
                    <span class="discount-badge">- {{ $discount }}%</span>
                @endif
            </div>
        </a>

        {{-- Product Details --}}
        <div class="card-body product-body">
            <h6 class="product-title">
                {{ strtoupper($product->title ?? '') }}
            </h6>
            <div class="price-container">
                <h6 class="current-price">
                    {{ $product->price ?? '' }}
                </h6>
                @if ($product->old_price)
                    <h6 class="old-price">
                        {{ $product->old_price ?? '' }}
                    </h6>
                @endif
            </div>
        </div>

        {{-- Buttons --}}
        <div class="card-footer product-footer">
            <a href="{{ route('product.details', ['id' => $product->id, 'title' => Str::slug($product->title)]) }}"
                class="view-details">
                <i class="fas fa-eye"></i>
            </a>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" style="background:transparent; border:none; padding:0; cursor:pointer;">
                    <i class="fas fa-shopping-cart" style="color:#fff;"></i>
                </button>
            </form>
        </div>
    </div>
</div>