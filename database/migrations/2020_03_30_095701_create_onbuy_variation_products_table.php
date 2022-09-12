<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnbuyVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onbuy_variation_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('sku');
            $table->string('master_product_id');
            $table->string('queue_id');
            $table->string('update_queue_id')->nullable();
            $table->string('opc');
            $table->string('ean_no')->nullable();
            $table->string('attribute1_name')->nullable();
            $table->string('attribute1_value')->nullable();
            $table->string('attribute2_name')->nullable();
            $table->string('attribute2_value')->nullable();
            $table->string('name');
            $table->string('group_sku')->nullable();
            $table->float('price');
            $table->integer('stock')->nullable();
            $table->longText('technical_detail')->nullable();
            $table->integer('product_listing_id')->nullable();
            $table->integer('product_listing_condition_id')->nullable();
            $table->string('condition');
            $table->string('product_encoded_id')->nullable();
            $table->float('delivery_weight')->nullable();
            $table->integer('delivery_template_id')->nullable();
            $table->float('boost_marketing_commission')->nullable();
            $table->string('low_quantity')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('opc')->references('opc')->on('onbuy_master_product');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onbuy_variation_products');
    }
}
