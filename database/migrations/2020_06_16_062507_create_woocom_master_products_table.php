<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoocomMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woocom_master_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('master_catalogue_id');
            $table->unsignedBigInteger('modifier_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->string('name');
            $table->string('type');
            $table->longText('description');
            $table->longText('short_description')->nullable();
            $table->longText('images')->nullable();
            $table->float('regular_price')->nullable();
            $table->longText('sale_price')->nullable();
            $table->float('cost_price')->nullable();
            $table->string('product_code')->nullable();
            $table->string('color_code')->nullable();
            $table->longText('attribute')->nullable();
            $table->longText('low_quantity')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('master_catalogue_id')->references('id')->on('product_drafts');
            $table->foreign('modifier_id')->references('id')->on('users');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('gender_id')->references('id')->on('genders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('woocom_master_products');
    }
}
