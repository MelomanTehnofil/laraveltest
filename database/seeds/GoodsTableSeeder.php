<?php

use Illuminate\Database\Seeder;

/**
 * Class GoodsTableSeeder
 */
class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Goods::class, 20)->create();
    }
}
