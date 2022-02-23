<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\productCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;


class productCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       productCategory::factory()->times(25)->create();
    //   DB::table('product_categories')->factory()->times(25)->create();
    }
}