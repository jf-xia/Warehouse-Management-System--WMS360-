<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbayProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('site_id');
            $table->string('profile_name');
            $table->longText('profile_description')->nullable();
            $table->string('product_type');
            $table->float('start_price')->nullable();
            $table->string('condition_id')->nullable();
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
            $table->string('return_id');
            $table->string('payment_id');
            $table->string('currency');
            $table->unsignedBigInteger('template_id');
            $table->string('paypal')->nullable();

            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('ebay_accounts');
            $table->foreign('site_id')->references('id')->on('ebay_sites');
            $table->foreign('template_id')->references('id')->on('ebay_templates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_profiles');
    }
}
