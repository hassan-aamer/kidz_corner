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
    public function index()
    {
        Cache::forget('products');
        $result = [
            'categories_search' => $this->categoryService->index()->where('active', 1)->take(10),
            'products' => Cache::remember('products', now()->addHours(6), function () {
                return Product::where('active', 1)->orderByDesc('id')->paginate(12);
            }),
        ];
        return view('web.pages.shop', compact( 'result'));
    }

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
            'categories_search' => $this->categoryService->index()->where('active', 1)->take(10),
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ];
        return view('web.pages.product', compact('result'));
    }
}
