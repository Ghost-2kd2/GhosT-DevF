<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->integer('product_cat_id');
            $table->integer('product_subCat_id');
            $table->integer('product_Tertiary_id');
            $table->integer('mobile_number');
            $table->integer('customer_name');
            $table->string('product_name')->nullable();

            $table->string('product_quantity')->nullable();
            $table->integer('product_cost_per_unit')->nullable();
            $table->integer('product_offer');
            $table->integer('cgst');
            $table->integer('sgst');
            $table->integer('total_cost');
            $table->integer('payment_mode');
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
        Schema::dropIfExists('orders');
    }
}