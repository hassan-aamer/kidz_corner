<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Reviews\ReviewService;
use App\Services\Banners\BannersService;
use App\Services\Sliders\SlidersService;
use App\Services\Features\FeatureService;
use App\Services\Products\ProductsService;
use App\Services\Services\ServicesService;
use App\Services\Categories\CategoryService;

class HomeController extends Controller
{
    protected ProductsService $productsService;
    protected ServicesService $servicesService;
    protected SlidersService $slidersService;
    protected CategoryService $categoryService;
    protected FeatureService $featureService;
    protected ReviewService $reviewService;
    protected BannersService $bannersService;

    public function __construct(
        ProductsService $productsService,
        FeatureService $featureService,
        SlidersService $slidersService,
        ServicesService $servicesService,
        ReviewService $reviewService,
        BannersService $bannersService,
        CategoryService $categoryService
        )
    {
        $this->productsService = $productsService;
        $this->servicesService = $servicesService;
        $this->categoryService = $categoryService;
        $this->slidersService  = $slidersService;
        $this->featureService  = $featureService;
        $this->reviewService   = $reviewService;
        $this->bannersService   = $bannersService;
    }
    public function index(Request $request)
    {
        $result = [
            'services'          => $this->servicesService->index()->where('active', 1),
            'reviews'           => $this->reviewService->index()->where('active', 1),
            'products'          => $this->productsService->index($request)->where('active', 1)->take(8),
            'sliders'           => $this->slidersService->index($request)->where('active', 1),
            'banners'           => $this->bannersService->index($request)->where('active', 1),
            'features'          => $this->featureService->index($request)->where('active', 1),
            'categories'        => $this->categoryService->index()->where('active', 1)->take(6),
            'categories_search' => $this->categoryService->index()->where('active', 1)->take(10),
        ];
        // return $result['banners'];
        return view('web.pages.home', compact('result'));
    }
}
