<?php

namespace App\Services\Settings;

use App\Interfaces\CRUDRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use WebPConvert\WebPConvert;

class SettingsService
{
    private $model;
    private CRUDRepositoryInterface $itemRepository;
    public function __construct(CRUDRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->model = new Setting();
    }
    public function edit()
    {
        return $this->model->first();
    }
    public function update(array $request, int $id)
    {
        try {

            DB::beginTransaction();

            $settings = $this->itemRepository->getItemById($this->model, $id);
            $this->itemRepository->updateItem($this->model, $id, $request);

            if (isset($request['image']) && $request['image']) {
                $settings->clearMediaCollection('about');
                $media = $settings->addMediaFromRequest('image')->toMediaCollection('about');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }
            if (isset($request['baner']) && $request['baner']) {
                $settings->clearMediaCollection('baners');
                $media = $settings->addMediaFromRequest('baner')->toMediaCollection('baners');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }
            if (isset($request['callToAction']) && $request['callToAction']) {
                $settings->clearMediaCollection('callToActions');
                $media = $settings->addMediaFromRequest('callToAction')->toMediaCollection('callToActions');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }
            if (isset($request['review']) && $request['review']) {
                $settings->clearMediaCollection('reviews');
                $media = $settings->addMediaFromRequest('review')->toMediaCollection('reviews');

                $sourcePath = $media->getPath();

                $webpPath = pathinfo($sourcePath, PATHINFO_DIRNAME) . '/' .
                    pathinfo($sourcePath, PATHINFO_FILENAME) . '.webp';

                WebPConvert::convert($sourcePath, $webpPath);
            }
            if (isset($request['logo']) && $request['logo']) {
                $settings->clearMediaCollection('logo');
                $media = $settings->addMediaFromRequest('logo')->toMediaCollection('logo');

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
}
