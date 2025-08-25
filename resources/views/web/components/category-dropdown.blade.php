<nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
    id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
    <div class="navbar-nav w-100">
        @foreach (App\Models\Category::where('active', 1)->get()->sortBy('position')->take(10) as $categories_search)
            <a href="{{ route('products.category', $categories_search->id) }}" class="nav-item nav-link">
                {{ $categories_search->title ?? '' }}
            </a>
        @endforeach
    </div>
</nav>
