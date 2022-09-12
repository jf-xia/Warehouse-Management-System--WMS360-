<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbayMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_master_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('master_product_id');
            $table->unsignedBigInteger('site_id');

            $table->string('title');
            $table->string('item_id');


            $table->longText('item_description');
            $table->longText('variation_specifics');
            $table->longText('master_images');
            $table->longText('variation_images')->nullable();
            $table->string('product_type');
            $table->string('dispatch_time');
            $table->float('start_price');
            $table->string('condition_id');
            $table->string('condition_name')->nullable();
            $table->string('condition_description')->nullable();
            $table->string('category_id');
            $table->string('category_name')->nullable();
            $table->string('store_id')->nullable();
            $table->string('store2_id')->nullable();
            $table->string('store_name')->nullable();
            $table->string('store2_name')->nullable();
            $table->string('duration');
            $table->string('location');
            $table->string('country');
            $table->string('post_code');
            $table->longText('item_specifics');
            $table->string('shipping_id');
            $table->string('return_id')->nullable();
            $table->string('payment_id');
            $table->string('currency');
            $table->string('paypal')->nullable();
            $table->string('change_status')->nullable();
            $table->longText('change_message')->nullable();
            $table->string('image_attribute');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('ebay_accounts');
            $table->foreign('master_product_id')->references('id')->on('product_drafts');
            $table->foreign('site_id')->references('id')->on('ebay_sites');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_master_products');
    }
}
