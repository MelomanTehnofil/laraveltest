<?php

namespace App\Http\Services;

use Faker\Provider\Base;

/**
 * Class FakerCategoryProductService
 * @package App\Http\Services
 */
class FakerCategoryProductService extends Base
{
    protected static $formats = [
        '{{categories}}',
    ];

    protected static $categories = [
                             ['id' => 1, 'name' => 'Номенклатура','children' => [
                                        ['id' => 2, 'name' => 'Поставщик Ланит','children'=>[
                                                ['id' => 3, 'name' => 'Запчасти'],
                                        ]],
                                        ['id' => 4, 'name' => 'Поставщик OSC', 'children' => [
                                                    ['id' => 5, 'name' => 'Склад транзит'],
                                                    ['id' => 6, 'name' => 'Склад наличие'],
                                        ]],
                             ]],
                      ];

    /**
     * Метод возвращает иерархию категорий
     *
     * @return mixed
     */
    public static function category()
    {
        return static::randomElement(static::$categories);
    }
}
