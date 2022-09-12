<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonMasterCataloguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_master_catalogues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('master_product_id');
            $table->unsignedBigInteger('application_id');
            $table->string('title');
            $table->string('master_asin');
            $table->longText('description')->nullable();
            $table->longText('images')->nullable();
            $table->unsignedBigInteger('product_type');
            $table->unsignedBigInteger('condition_id');
            $table->integer('category_id')->nullable();
            $table->string('fulfilment_type');
            $table->double('sale_price',8,2);
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('modifier_id');
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('master_product_id')->references('id')->on('product_drafts');
            $table->foreign('application_id')->references('id')->on('amazon_account_applications');
            $table->foreign('product_type')->references('id')->on('amazon_product_types');
            $table->foreign('condition_id')->references('id')->on('amazon_conditions');
            //$table->foreign('creator_id')->references('id')->on('users');
            //$table->foreign('modifier_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_master_catalogues');
    }
}
