<?php

namespace App\Services\Home;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomePageService
{
    /**
     * Default number of products to load per category
     */
    protected const DEFAULT_PRODUCTS_PER_CATEGORY = 10;

    /**
     * Default number of categories to display
     */
    protected const DEFAULT_CATEGORIES_LIMIT = 6;

    /**
     * Cache duration in seconds (6 hours)
     */
    protected const CACHE_DURATION = 60 * 60 * 6;

    /**
     * Get all data needed for home page
     */
    public function getHomePageData(array $options = []): array
    {
        $productsPerCategory = $options['productsPerCategory'] ?? self::DEFAULT_PRODUCTS_PER_CATEGORY;
        $categoriesLimit = $options['categoriesLimit'] ?? self::DEFAULT_CATEGORIES_LIMIT;

        return [
            'banners' => $this->getBanners(),
            'categories' => $this->getCategoriesWithProducts($categoriesLimit, $productsPerCategory),
        ];
    }

    /**
     * Get active banners for carousel
     */
    protected function getBanners(): Collection
    {
        return Cache::remember('home_banners', self::CACHE_DURATION, function () {
            return Banner::query()
                ->publish()
                ->ordered()
                ->with('media')
                ->get();
        });
    }

    /**
     * Get categories with limited products for home page display
     *
     * @param  int  $categoriesLimit  Number of categories to fetch
     * @param  int  $productsLimit  Number of products per category
     */
    protected function getCategoriesWithProducts(int $categoriesLimit, int $productsLimit): Collection
    {
        $cacheKey = "home_categories_{$categoriesLimit}_{$productsLimit}";

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($categoriesLimit, $productsLimit) {
            return Category::query()
                ->publish()
                ->ordered()
                ->with('media')
                ->withCount(['products' => function ($query) {
                    $query->publish();
                }])
                ->having('products_count', '>', 0) // Only categories with products
                ->take($categoriesLimit)
                ->get()
                ->map(function ($category) use ($productsLimit) {
                    // Load products separately with limit to avoid N+1 and memory issues
                    $category->setRelation(
                        'products',
                        $category->products()
                            ->publish()
                            ->ordered()
                            ->with('media')
                            ->take($productsLimit)
                            ->get()
                    );

                    return $category;
                });
        });
    }

    /**
     * Clear home page cache
     * Call this when banners, categories, or products are updated
     */
    public static function clearCache(): void
    {
        Cache::forget('home_banners');

        // Clear all possible category cache keys
        for ($categories = 1; $categories <= 20; $categories++) {
            for ($products = 1; $products <= 50; $products++) {
                Cache::forget("home_categories_{$categories}_{$products}");
            }
        }
    }
}
