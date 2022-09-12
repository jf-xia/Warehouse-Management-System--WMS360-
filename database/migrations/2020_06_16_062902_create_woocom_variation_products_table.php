<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoocomVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woocom_variation_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('woocom_master_product_id');
            $table->unsignedBigInteger('woocom_variation_id');
            $table->string('image')->nullable();
            $table->longText('attribute')->nullable();
            $table->string('sku');
            $table->integer('actual_quantity')->default(0);
            $table->string('ean_no')->nullable();
            $table->float('cost_price')->nullable();
            $table->longText('barcode')->nullable();
            $table->float('regular_price');
            $table->float('sale_price');
            $table->string('product_code')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('low_quantity')->nullable();
            $table->boolean('notification_status')->default(0)->comment('true= on, false = off');
            $table->boolean('manage_stock')->default(0)->comment('true= on, false = off');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('woocom_master_product_id')->references('id')->on('woocom_master_products');
            $table->foreign('woocom_variation_id')->references('id')->on('product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('woocom_variation_products');
    }
}
