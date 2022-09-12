<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_variations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shopify_master_product_id');
            $table->unsignedBigInteger('master_variation_id');
            $table->text('image')->nullable();
            $table->text('attribute')->nullable();
            $table->string('sku');
            $table->integer('quantity')->default(0);
            $table->double('regular_price')->nullable();
            $table->double('sale_price')->nullable();
            $table->double('rrp')->nullable();
            $table->bigInteger('shopify_variant_it');
            $table->string('fulfillment_service')->nullable();
            $table->string('inventory_management')->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->bigInteger('inventory_item_id')->nullable();
//            $table->foreign('shopify_master_product_id')->references('id')->on('shopify_master_products');
//            $table->foreign('master_variation_id')->references('id')->on('product_variation');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopify_variations');
    }
}
