<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

/**
 * Class CategoriesController
 * @package App\Http\Controllers
 */
class CategoriesController extends Controller
{
    private $category;

    /**
     * CategoriesController constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Метод получает иерархию категорий
     *
     * @return mixed
     */
    public function index()
    {
        return $this->category->all()->toHierarchy();
    }

    /**
     * Метод добавляет новую категорию
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function store(Request $request, $id)
    {
        return $this->category->store($id, $request->get('name'));
    }

    /**
     * Метод получает категорию по индентификатору
     *
     * @param $id
     * @return mixed
     */
    public function category($id)
    {
        return $this->category->get($id);
    }

    /**
     * Метод обновляет название категории
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        $this->category->rename($id, $request->get('name'));
    }

    /**
     * Метод помещает товары 'goods' в категорию 'category'
     *
     * @param Request $request
     */
    public function move(Request $request)
    {
        $this->category->addGoods($request->get('category'), json_decode($request->get('goods')));
    }

    /**
     * Метод удаляет товар из категории
     *
     * @param $id
     * @param $idcat
     * @return mixed
     */
    public function deleterelation($id, $idcat)
    {
        $this->category->removeGoods($id, $idcat);
        return $id;
    }

    /**
     * Метод удаляет категорию
     *
     * @param $id
     */
    public function delete($id)
    {
        $this->category->trash($id);
    }
}
