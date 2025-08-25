<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Services\Products\ProductsService;
use App\Services\Categories\CategoryService;

class ProductController extends Controller
{
    protected ProductsService $service;
    protected CategoryService $categoryService;

    public function __construct(ProductsService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    // Show all products
    public function index(Request $request)
    {

        $page = $request->get('page', 1);

        $cacheKey = "products_page_{$page}";

        $result = [
            'products' => Cache::remember($cacheKey, now()->addHours(6), function () {
                return Product::where('active', 1)->orderByDesc('id')->paginate(12);
            }),
        ];

        Cache::forget('products');
        return view('web.pages.shop', compact('result'));
    }


    // Filter by category
    public function indexByCategory(Request $request, $categoryId)
    {

        $page = $request->get('page', 1);
        $cacheKey = "products_category_{$categoryId}_page_{$page}";

        $result = [
            'products' => Cache::remember($cacheKey, now()->addHours(6), function () use ($categoryId) {
                return Product::where('active', 1)
                    ->where('category_id', $categoryId)
                    ->orderByDesc('id')
                    ->paginate(12);
            }),
        ];

        Cache::forget('products');
        return view('web.pages.shop', compact('result'));
    }


    // Search products
    public function indexBySearch(Request $request)
    {

        $search = $request->get('search');
        $page = $request->get('page', 1);

        $cacheKey = "products_search_{$search}_page_{$page}";

        $result = [
            'products' => Cache::remember($cacheKey, now()->addHours(6), function () use ($search) {
                return Product::where('active', 1)
                    ->where(function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    })
                    ->orderByDesc('id')
                    ->paginate(12);
            }),
        ];

        Cache::forget('products');
        return view('web.pages.shop', compact('result'));
    }


    // Show single product
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', 1)
            ->inRandomOrder()
            ->take(12)
            ->get();

        $result = [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];
        return view('web.pages.product', compact('result'));
    }
}
