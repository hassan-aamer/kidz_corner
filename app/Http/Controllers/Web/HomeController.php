<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Home\HomePageService;

class HomeController extends Controller
{
    protected HomePageService $homePageService;

    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }

    public function index(Request $request)
    {
        $result = $this->homePageService->getHomePageData([
            'productsPerCategory' => 10,
            'categoriesLimit' => 6,
        ]);

        return view('web.pages.home', compact('result'));
    }
}

