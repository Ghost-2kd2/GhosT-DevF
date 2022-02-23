<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_description');
            $table->string('plant_id');
            // $table->string('product_type')->nullable();
            $table->integer('product_cat_id')->nullable();
            $table->integer('product_subCat_id')->nullable();
            $table->integer('product_tertiary_id')->nullable();
            $table->integer('product_quantity');
            $table->string('product_purchase_price')->nullable();
            // $table->string('product_margin_price')->nullable();
            // $table->string('product_base_price')->nullable();
            $table->string('product_profit')->nullable();
            $table->string('product_offer')->nullable();
            $table->string('product_customer_price');
            // $table->string('product_images')->nullable();
            // $table->tinyInteger('product_stock')->nullable();
            // $table->integer('product_popularity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}