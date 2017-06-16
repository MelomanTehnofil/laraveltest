<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function ($router) {
    
    Route::get('goods/{id}', 'GoodsController@goods');       //Перечень товаров в категории (метод контроллера goods)
    Route::get('goodsall', 'GoodsController@goodsList');     //Список товаров (метод контроллера goodsList)
    Route::get('good/{id}', 'GoodsController@good');        //Информация о товаре (метод контроллера good)
    Route::post('creategood', 'GoodsController@store');     //Сохранение нового товара (метод контроллера store)
    Route::get('deletegood/{id}', 'GoodsController@delete');//Удаление товара (метод контроллера delete)
    Route::put('updategood/{id}', 'GoodsController@update');//Обновление товара (метод контроллера update)
    
    Route::get('categories', 'CategoriesController@index'); //Возвращает иерархию категорий (метод контроллера index)
    Route::get('category/{id}', 'CategoriesController@category'); //Возвращает категорию (метод контроллера category)
    Route::get('deletecategory/{id}', 'CategoriesController@delete'); //Удаляет категорию (метод контроллера delete)
    Route::get('delgoodiscat/{id}/{idcat}', 'CategoriesController@deleterelation');//Удалят товар из категории (метод
    // контроллера deleterelation)
    Route::put('updatecategory/{id}', 'CategoriesController@update'); //Обновляет категорию (метод контроллера update)
    Route::put('createcategory/{id}', 'CategoriesController@store'); //Сохраняет категорию (метод контроллера store)
    Route::post('movegood', 'CategoriesController@move'); //Добавляет товар в категорию (метод контроллера move)
});
