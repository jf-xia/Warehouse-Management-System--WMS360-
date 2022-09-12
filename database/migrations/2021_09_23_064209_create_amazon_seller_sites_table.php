<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonSellerSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_seller_sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('wms_marketplace_pk_id');
            $table->string('marketplace_id');
            $table->string('name');
            $table->string('country_code');
            $table->string('default_currency_code');
            $table->string('default_language_code');
            $table->string('domain_name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')->references('id')->on('amazon_accounts');
            $table->foreign('wms_marketplace_pk_id')->references('id')->on('amazon_market_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_seller_sites');
    }
}
