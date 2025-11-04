<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        )
    {
        $this->categoryService = $categoryService;
        $this->bannersService   = $bannersService;
    }
    public function index(Request $request)
    {
        $result = [
            'banners'           => $this->bannersService->index($request),
            'categories'        => Cache::remember('home_categories', now()->addHours(3), function () {
            return $this->categoryService->index()->where('active', 1)->take(6);
        }),

        ];
        return view('web.pages.home', compact('result'));
    }
}
