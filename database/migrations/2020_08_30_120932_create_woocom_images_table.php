<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoocomImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woocom_images', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedBigInteger('woo_master_catalogue_id')->nullable();
            $table->longText('image_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('woo_master_catalogue_id')->references('id')->on('woocom_master_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('woocom_images');
    }
}
