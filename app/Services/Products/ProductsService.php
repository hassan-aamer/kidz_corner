<?php

namespace App\Services\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Interfaces\CRUDRepositoryInterface;
use App\Jobs\UploadProductImages;
use Illuminate\Support\Facades\Bus;
use App\Models\Product;
use WebPConvert\WebPConvert;

class ProductsService
{
    private $model;
    private CRUDRepositoryInterface $itemRepository;
    public function __construct(CRUDRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->model = new Product();
    }
    public function index($request = null)
    {
        if ($request) {
            $data = $request->all();
            return $this->itemRepository->getPaginateItems($this->model, $data);
        }
        return $this->itemRepository->getPaginateItems($this->model);
    }
    public function getAllItems($request = null)
    {
        return $this->itemRepository->getAllItems($this->model);
    }

    public function show(int $id)
    {
        return $this->itemRepository->getItemById($this->model, $id);
    }
    public function store(array $request)
    {
        try {
            DB::beginTransaction();

            $products = $this->itemRepository->createItem($this->model, $request);

            if (isset($request['image']) && $request['image']) {
                $media = $products->addMediaFromRequest('image')->toMediaCollection('products');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }
            // if (isset($request['images']) && $request['images']) {
            //     // $products->clearMediaCollection('product_collection');
            //     foreach ((array) $request['images'] as $file) {
            //         $products->addMedia($file)->toMediaCollection('product_collection');
            //     }
            // }
            if (isset($request['images']) && $request['images']) {
                Bus::dispatch(new UploadProductImages($products, $request['images']));
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function edit($id)
    {
        return $this->itemRepository->getItemById($this->model, $id);
    }
    public function update(array $request, int $id)
    {
        try {

            DB::beginTransaction();

            $products = $this->itemRepository->getItemById($this->model, $id);
            $this->itemRepository->updateItem($this->model, $id, $request);

            if (isset($request['image']) && $request['image']) {
                $products->clearMediaCollection('products');
                $media = $products->addMediaFromRequest('image')->toMediaCollection('products');


                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }

            if (isset($request['images']) && $request['images']) {
                Bus::dispatch(new UploadProductImages($products, $request['images']));
            }

            Cache::forget("product_{$id}");

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function destroy(int $id)
    {
        return $this->itemRepository->deleteItem($this->model, $id);
    }
    function changeStatus($request)
    {
        if ($item = $this->itemRepository->getItemById($this->model, $request->id)) {
            $active = !$item->active;
            $this->itemRepository->updateItem($this->model, $item->id, ['active' => $active]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
