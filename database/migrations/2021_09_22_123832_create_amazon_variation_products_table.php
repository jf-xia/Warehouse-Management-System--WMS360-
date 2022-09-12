<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_variation_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('amazon_master_product');
            $table->unsignedBigInteger('master_variation_id');
            $table->text('attribute');
            $table->string('sku');
            $table->string('ean_no');
            $table->string('asin')->nullable();
            $table->integer('quantity');
            $table->double('regular_price',8,2)->nullable();
            $table->double('sale_price',8,2);
            $table->double('rrp',8,2)->nullable();
            $table->tinyInteger('is_master_editable')->default(1)->comment('1=ON,0=OFF');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('amazon_master_product')->references('id')->on('amazon_master_catalogues');
            // $table->foreign('master_variation_id')->references('id')->on('product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_variation_products');
    }
}
