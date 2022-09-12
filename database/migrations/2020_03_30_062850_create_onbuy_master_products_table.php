<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnbuyMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onbuy_master_products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('opc');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('woo_catalogue_id');
            $table->unsignedBigInteger('master_category_id');
            $table->integer('master_brand_id');
            $table->longText('summary_points')->nullable();
            $table->integer('published');
            $table->string('product_name');
            $table->string('queue_id');
            $table->string('update_queue_id')->nullable();
            $table->longText('description');
            $table->longText('videos')->nullable();
            $table->longText('documents')->nullable();
            $table->longText('default_image')->nullable();
            $table->longText('additional_images')->nullable();
            $table->longText('product_data')->nullable();
            $table->longText('features')->nullable();
            $table->float('rrp')->nullable();
            $table->integer('low_quantity')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('woo_catalogue_id')->references('id')->on('product_drafts');
            $table->foreign('master_brand_id')->references('brand_id')->on('onbuy_brands');
            $table->foreign('master_category_id')->references('category_id')->on('onbuy_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onbuy_master_products');
    }
}
