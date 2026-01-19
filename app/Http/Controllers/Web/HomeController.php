<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use App\Services\Banners\BannersService;
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
            'banners' => Cache::remember('home_banners', 60 * 60 * 6, function () use ($request) {
                return $this->bannersService->index($request);
            }),
            'categories' => Cache::remember('home_categories', 60 * 60 * 6, function () {
                return Category::with([
                        'media',
                        'products' => function ($query) {
                            $query->publish()
                                ->ordered()
                                ->with('media');
                        }
                    ])
                    ->publish()
                    ->take(6)
                    ->get();
            }),
        ];

        return view('web.pages.home', compact('result'));
    }
}
