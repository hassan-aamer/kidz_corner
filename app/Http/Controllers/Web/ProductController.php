<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Services\Products\ProductsService;
use App\Services\Categories\CategoryService;
use App\Http\Requests\Search\SearchRequest;

class ProductController extends Controller
{
    protected ProductsService $service;
    protected CategoryService $categoryService;

    public function __construct(ProductsService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    /**
     * Show all products with pagination.
     */
    public function index(Request $request)
    {
        $page = max(1, (int) $request->get('page', 1));
        $cacheKey = "products_page_{$page}";

        $products = Cache::remember($cacheKey, 60 * 60 * 3, function () {
            return Product::with('media')
                ->publish()
                ->recent()
                ->paginate(12);
        });

        // Ensure pagination URLs work correctly
        $products->withPath(route('products'));

        $result = [
            'products' => $products,
        ];

        return view('web.pages.shop', compact('result'));
    }

    /**
     * Filter products by category.
     * Validates category ID to prevent injection.
     */
    public function indexByCategory(Request $request, $categoryId)
    {
        // Validate categoryId is a positive integer
        $categoryId = (int) $categoryId;
        if ($categoryId <= 0) {
            abort(404);
        }

        $page = max(1, (int) $request->get('page', 1));
        $cacheKey = "products_category_{$categoryId}_page_{$page}";

        $products = Cache::remember($cacheKey, 60 * 60 * 3, function () use ($categoryId) {
            return Product::with('media')
                ->where('category_id', $categoryId)
                ->publish()
                ->recent()
                ->paginate(12);
        });

        // Ensure pagination URLs work correctly
        $products->withPath(route('products.category', $categoryId));

        $result = [
            'products' => $products,
        ];

        return view('web.pages.shop', compact('result'));
    }

    /**
     * Search products by title or description.
     * Uses SearchRequest for strict input validation.
     * Note: Search results are cached for 1 hour to balance freshness and performance.
     */
    public function indexBySearch(SearchRequest $request)
    {
        $search = $request->getSearchTerm();
        $page = $request->getPage();

        // If search is empty, redirect to products page
        if (empty($search)) {
            return redirect()->route('products');
        }

        // Use md5 hash for search term to avoid cache key issues with special characters
        $searchHash = md5($search);
        $cacheKey = "products_search_{$searchHash}_page_{$page}";

        $products = Cache::remember($cacheKey, 60 * 60, function () use ($search) {
            return Product::with('media')
                ->publish()
                ->where(function ($query) use ($search) {
                    // Use parameter binding (already done by Eloquent) for extra safety
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
                ->recent()
                ->paginate(12);
        });

        // Ensure pagination URLs work correctly
        $products->appends(['search' => $search]);

        $result = [
            'products' => $products,
        ];

        return view('web.pages.shop', compact('result'));
    }

    /**
     * Show single product with related products.
     * Validates product ID to prevent injection.
     */
    public function show($id)
    {
        // Validate ID is a positive integer
        $id = (int) $id;
        if ($id <= 0) {
            abort(404);
        }

        $product = Cache::remember("product_{$id}", 60 * 60 * 3, function () use ($id) {
            return Product::with(['category', 'media'])
                ->publish()
                ->findOrFail($id);
        });

        $relatedProducts = Cache::remember("product_{$id}_related", 60 * 60 * 3, function () use ($product, $id) {
            return Product::with('media')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $id)
                ->publish()
                ->inRandomOrder()
                ->take(12)
                ->get();
        });

        $result = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];

        return view('web.pages.product', compact('result'));
    }
}

