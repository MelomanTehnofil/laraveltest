<?php

namespace App\Http\Services;

use Storage;

/**
 * Класс реализует интерфейс GoodServiceStorage
 *
 * Class GoodService
 * @package App\Http\Services
 */
class GoodService implements GoodServiceStorage
{

    /**
     * Метод сохраняет фотографию
     *
     * @param $request
     * @param $good
     */
    public function uploadPhoto($request, $good)
    {
        $fileName = str_random(30);
        $extension = $request->photo->extension();
        $fullFileName = "{$fileName}.{$extension}";

        if ($request->photo->storeAs('public/photos', $fullFileName)) {
            $good->photo = $fullFileName;
        }
    }

    /**
     * Метод удаляет фотографию
     *
     * @param $good
     */
    public function deleteCurrentPhoto($good)
    {
        $currentPhoto = $good->photo;

        if ($currentPhoto) {
            $file = "public/photos/{$currentPhoto}";

            if (Storage::exists($file)) {
                Storage::delete($file);
            }
        }
    }
}
