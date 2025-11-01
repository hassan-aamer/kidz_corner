<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4" style="height: 450px;">
        <a href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}">
            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 350px;">
                <img class="img-fluid lazyload"
                    src="{{ App\Helpers\Image::getMediaUrl($products, 'products') }}"
                    alt="{{ $products->title ?? '' }}"
                    loading="lazy"
                    style="width: 100%; height: 100%; object-fit: cover;">

                @if ($products->sold_out == 1)
                    <span class="badge badge-danger position-absolute"
                        style="top:10px; left:10px; font-size:14px; background:#dc3545;">
                        Sold Out
                    </span>
                @endif
            </div>
        </a>

        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3" style="height: 130px;">
            <h6 class="text-truncate mb-3">{{ strtoupper($products->title ?? '') }}</h6>
            <div class="d-flex justify-content-center">
                <h6>EGP {{ $products->price ?? '' }}</h6>
                <h6 class="text-muted ml-2"><del>EGP {{ $products->old_price ?? '' }}</del></h6>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between bg-light border" style="height: 70px;">
            <a href="{{ route('product.details', ['id' => $products->id, 'title' => Str::slug($products->title)]) }}"
                class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
            <form action="{{ route('cart.add', $products->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-sm text-dark p-0">
                    <i class="fas fa-shopping-cart text-primary mr-1"></i>
                    Add To Cart
                </button>
            </form>
        </div>
    </div>
</div>