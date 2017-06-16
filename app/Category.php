<?php

namespace App;

use Baum\Node;

/**
 * Class Category
 * @package App
 */
class Category extends Node
{
    protected $table = 'categories';

    /**
     * Метод получает товары принадлежащшие категории
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany('App\Goods', 'goods_categories_relate');
    }

    /**
     * Метод сохраняет новую категорию
     *
     * @param $id
     * @param $name
     * @return mixed
     */
    public static function store($id, $name)
    {
        $node = Category::where('id', '=', $id)->first();
        $children = $node->children()->create(['name' => $name]);
        $node->save();
        return $children;
    }

    /**
     * Метод получает категорию
     *
     * @param $id
     * @return mixed
     */
    public static function get($id)
    {
        return Category::where('id', '=', $id)->first();
    }

    /**
     * Метод обновляет название категории
     *
     * @param $id
     * @param $name
     */
    public static function rename($id, $name)
    {
        $node = Category::where('id', '=', $id)->first();
        $node->name = $name;
        $node->save();
    }

    /**
     * Метод устанавливает отношение между перечем товаров в '$goods' и категорией
     *
     * @param $id
     * @param array $goods
     */
    public static function addGoods($id, $goods = [])
    {
        $node = Category::where('id', '=', $id)->first();
        $node->goods()->attach($goods);
    }

    /**
     * Метод удаляет отношение между товаром '$id' и категорией
     *
     * @param $id
     * @param $idcat
     */
    public static function removeGoods($id, $idcat)
    {
        $node = Category::where('id', '=', $idcat)->first();
        $node->goods()->detach([$id]);
    }

    /**
     * Метод удаляет категорию
     *
     * @param $id
     */
    public static function trash($id)
    {
        $node = Category::where('id', '=', $id)->first();
        $node->goods()->detach();
        $node->delete();
    }
}
