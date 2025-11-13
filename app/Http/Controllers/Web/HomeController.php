<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use App\Services\Reviews\ReviewService;
use App\Services\Banners\BannersService;
use App\Services\Sliders\SlidersService;
use App\Services\Features\FeatureService;
use App\Services\Products\ProductsService;
use App\Services\Services\ServicesService;
use App\Services\Categories\CategoryService;

class HomeController extends Controller
{
    protected CategoryService $categoryService;
    protected BannersService $bannersService;

    public function __construct(
        BannersService $bannersService,
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
        $this->bannersService   = $bannersService;
    }
    public function index(Request $request)
    {
        $result = [
            'banners' => Cache::remember('home_banners', now()->addHours(6), function () use ($request) {
                return $this->bannersService->index($request);
            }),
            'categories' => Cache::remember('home_categories', now()->addHours(6), function () {
                return Category::with(['products' => function ($query) {
                    $query->where('active', 1)
                        ->orderBy('position', 'asc')  // ترتيب حسب الحقل position
                        ->take(6);                   // أول 6 منتجات فقط
                }])
                    ->where('active', 1)
                    ->take(6)                             // أول 6 فئات
                    ->get();
            }),



        ];
        return view('web.pages.home', compact('result'));
    }
}
