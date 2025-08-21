<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // Cache::forget('products');
        $result = [
            'categories_search' => $this->categoryService->index()->where('active', 1)->take(10),
            'products' => Cache::remember('products', now()->addHours(6), function () {
                return $this->service->index(null)->where('active', 1);
            }),
        ];

        return view('web.pages.shop', compact( 'result'));
    }
}
