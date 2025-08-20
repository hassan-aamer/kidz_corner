<?php

namespace App\Services\Banners;

use App\Models\Banner;
use WebPConvert\WebPConvert;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CRUDRepositoryInterface;

class BannersService
{
    private $model;
    private CRUDRepositoryInterface $itemRepository;
    public function __construct(CRUDRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->model = new Banner();
    }
    public function index($request)
    {
        $data = $request->all();
        return $this->itemRepository->getPaginateItems($this->model, $data);
    }
    public function show(int $id)
    {
        return $this->itemRepository->getItemById($this->model, $id);
    }
    public function store(array $request)
    {
        try {
            DB::beginTransaction();

            $banners = $this->itemRepository->createItem($this->model, $request);

            if (isset($request['image']) && $request['image']) {
                $media = $banners->addMediaFromRequest('image')->toMediaCollection('banners');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
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

            $banners = $this->itemRepository->getItemById($this->model, $id);
            $this->itemRepository->updateItem($this->model, $id, $request);

            if (isset($request['image']) && $request['image']) {
                $banners->clearMediaCollection('banners');
                $media = $banners->addMediaFromRequest('image')->toMediaCollection('banners');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }

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
