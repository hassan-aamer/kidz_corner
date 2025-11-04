<nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-5 bg-light"
    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <div class="navbar-nav w-100">
        @foreach (App\Models\Category::with('products')->where('active', 1)->get()->sortBy('position')->take(10) as $categories_search)
            <a href="{{ route('products.category', $categories_search->id) }}" 
               class="nav-item nav-link d-flex justify-content-between align-items-center" style="font-weight: bold;">
                <span>{{ $categories_search->title ?? '' }}</span>
                <span class="badge bg-secondary rounded-pill">
                    {{ $categories_search->products->count() ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>
</nav>
