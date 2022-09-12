<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbayVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_variation_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku');
            $table->unsignedBigInteger('ebay_master_product_id');
            $table->unsignedBigInteger('master_variation_id');
            $table->longText('variation_specifics');
            $table->float('start_price');
            $table->float('rrp')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('ean')->nullable();
            $table->string('change_status')->nullable();
            $table->string('change_message')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ebay_master_product_id')->references('id')->on('ebay_master_products');
            $table->foreign('master_variation_id')->references('id')->on('product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_variation_products');
    }
}
