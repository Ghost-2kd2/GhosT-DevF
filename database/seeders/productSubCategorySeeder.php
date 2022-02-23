<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\productSubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Faker\Generator as Faker;


class productSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        productSubCategory::factory()->times(25)->create();
       // DB::table('product_sub_categories')->factory()->times(25)->create();
    }
}