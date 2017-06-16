<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;

/**
 * Class GoodsController
 * @package App\Http\Controllers
 */
class GoodsController extends Controller
{
    private $goods;

    /**
     * GoodsController constructor.
     * @param Goods $goods
     */
    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }

    /**
     * Метод сохраняет новый товар
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->goods->saveGood($request);
    }

    /**
     * Метод получает список всех товаров
     *
     * @param Request $request
     * @return mixed
     */
    public function goodsList(Request $request)
    {
        return $this->goods->getAllList($request->get('query'), $request->get('per_page'));
    }

    /**
     * Метод получает список товаров из категории '$category_id'
     *
     * @param Request $request
     * @param $category_id
     * @return mixed
     */
    public function goods(Request $request, $category_id)
    {
        return $this->goods->getIsCategory($category_id, $request->get('query'), $request->get('per_page'));
    }

    /**
     * Метод получает товар по идентификатору
     *
     * @param $id
     * @return mixed
     */
    public function good($id)
    {
        return $this->goods->find($id);
    }

    /**
     * Метод обновляет товар
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        return $this->goods->updateGood($id, $request);
    }

    /**
     * Метод удаляет товар
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->goods->deleteGood($id);
    }
}
