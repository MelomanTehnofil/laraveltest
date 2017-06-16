<?php

namespace App;

use App\Http\Services\GoodService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Goods
 * @package App
 */
class Goods extends Model
{
    protected $fillable = ['name','photo','description'];
    private $goodService;

    /**
     * Метод инициализирует сервис для сохранения фотографий
     *
     * @param $goodService
     */
    public function setgoodService(GoodService $goodService)
    {
        $this->goodService = $goodService;
    }

    /**
     * Метод сохраняет новый товар
     *
     * @param $request
     * @return mixed
     */
    public function saveGood($request)
    {

        $this->name = $request->name;

        $this->description = $request->description;

        if ($request->hasFile('photo')) {
            $this->goodService->uploadPhoto($request, $this);
        }

        $this->save();

        if (isset($request->category_id)) {
            $this->categories()->attach($request->category_id);
        }

        return $this;
    }

    /**
     * Метод обновляет товар
     *
     * @param $id
     * @param $request
     * @return mixed
     */
    public function updateGood($id, $request)
    {
        $goods = Goods::findOrFail($id);
        $goods->name = $request->name;
        $goods->description = $request->description;
        if ($request->hasFile('photo')) {
            $this->goodService->deleteCurrentPhoto($goods);
            $this->goodService->uploadPhoto($request, $goods);
        }

        $goods->save();
        return $goods;
    }

    /**
     * Метод удаляет товар включая его связи и фотографии
     *
     * @param $id
     * @return mixed
     */
    public function deleteGood($id)
    {
        $good = Goods::findOrFail($id);
        $this->goodService->deleteCurrentPhoto($good);
        $good->categories()->detach();
        $good->delete();
        return $good->id;
    }

    /**
     * Метод получает категорию к которой принадлежит товар
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'goods_categories_relate');
    }

    /**
     * Метод получает перечень всех товаров или искомый товар '$query'
     *
     * @param $query
     * @param $per_page
     * @return mixed
     */
    public static function getAllList($query, $per_page)
    {
        return Goods::select(['id','name'])
                            ->where('name', 'like', '%' . $query .'%')->paginate($per_page);
    }

    /**
     * Метод получает товары из категории
     *
     * @param $category_id
     * @param $query
     * @param $per_page
     * @return mixed
     */
    public static function getIsCategory($category_id, $query, $per_page)
    {
        return Goods::select(['id','name','photo','description','goods_categories_relate.category_id'])
                            ->leftJoin('goods_categories_relate', 'goods_categories_relate.goods_id', '=', 'goods.id')
                            ->where('goods_categories_relate.category_id', '=', $category_id)
                            ->where('name', 'like', '%' . $query .'%')->paginate($per_page);
    }
}
