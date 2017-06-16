<?php

namespace App\Providers;

use App\Goods;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FkProductService', 'App\Http\Services\FakerProductService');
        $this->app->bind('FkCategoryProductService', 'App\Http\Services\FakerCategoryProductService');
        $this->app->bind('App\Http\Services\GoodServiceStorage', 'App\Http\Services\GoodService');
        $this->app->singleton(Goods::class, function ($app) {
            $goods = new Goods();
            $goods->setgoodService($app->make('App\Http\Services\GoodServiceStorage'));
            return $goods;
        });
    }
}
