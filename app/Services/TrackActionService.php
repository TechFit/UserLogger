<?php

namespace App\Services;

use App\Services\SlowStorage\SlowStorageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Mockery\Exception;

/**
 * Class TrackActionService
 * @package App\Services
 */
class TrackActionService
{
    public function make(string $source_label, SlowStorageService $slowStorageService): bool
    {
        $track_object = [];

        $track_object['id'] = 1;

        $track_object['id_user'] = Auth::guard('api')->user()['id'];

        $track_object['source_label'] = $source_label;

        $track_object['date_created'] = date('Y-m-d H:i:s');

        return $this->handleSave($track_object, $slowStorageService);
    }

    private function handleSave(array $track_object, SlowStorageService $slowStorageService): bool
    {
        $file_name = $track_object['id_user'];

        $file_path = storage_path(env("TRACK_PATH")) . '/' . $file_name . '.json';

        if (!$slowStorageService->exists($file_path)) {
            $slowStorageService->store($file_path, json_encode([$track_object]));
            return true;
        }

        $file = $slowStorageService->load($file_path);

        $file = json_decode($file);

        $newData = new \stdClass();

        if (!empty($file)) {
            $newData->id = end($file)->id + 1;
        } else {
            $newData->id = $track_object['id'];
        }

        $newData->id_user = $track_object['id_user'];
        $newData->source_label = $track_object['source_label'];
        $newData->date_created = $track_object['date_created'];

        $file[] = $newData;

        $slowStorageService->store($file_path, json_encode($file));

        return true;
    }
}
