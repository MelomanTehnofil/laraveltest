<?php

use Illuminate\Database\Seeder;

/**
 * Class CategoryGoodsTableSeeder
 */
class CategoryGoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 1)->make()->each(function ($categories) {
            $categories->all()->each(function ($node) {
                if ($node->isLeaf()) {
                    $goods_list =  App\Goods::select()->take(20)->get()->random(rand(5, 20));
                    foreach ($goods_list as $product) {
                        $node->goods()->save($product);
                    }
                }
            });
        });
    }
}
