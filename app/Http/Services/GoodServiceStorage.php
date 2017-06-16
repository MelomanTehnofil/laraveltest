<?php

namespace App\Http\Services;

/**
 * Interface GoodServiceStorage
 * @package App\Http\Services
 */
interface GoodServiceStorage
{

    /**
     * @param $request
     * @param $good
     */
    public function uploadPhoto($request, $good);

    /**
     * @param $good
     */
    public function deleteCurrentPhoto($good);
}
