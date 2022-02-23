<?php

namespace Database\Factories;

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->name,
            'product_description' => $this->faker->text,
            'plant_id' => $this->faker->randomDigit(1, 5),
            'product_Tertiary_id' => $this->faker->randomDigit(1, 50),
            'product_cat_id' => $this->faker->randomDigit(1, 50),
            'product_subCat_id' => $this->faker->randomDigit(1, 50),
            'product_purchase_price' => $this->faker->randomDigit(500, 1000),
            'product_quantity' => $this->faker->randomDigit(1000, 5000),
            'product_profit' => $this->faker->randomDigit(1000, 5000),
            'product_offer' => $this->faker->randomDigit(100, 1000),
            'product_customer_price' => $this->faker->randomDigit(1000, 5000),
            // 'product_images' => $this->faker->text,
            // 'created_by' => $this->faker->name,
            // 'product_stock' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}