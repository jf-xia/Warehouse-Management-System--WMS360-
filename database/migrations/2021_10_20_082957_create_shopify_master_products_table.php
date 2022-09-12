<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopifyMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopify_master_products', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->unsignedBigInteger('account_id');
             $table->unsignedBigInteger('master_catalogue_id');
             $table->unsignedBigInteger('shopify_product_id');
             $table->text('title');
             $table->text('description');
             $table->string('vendor')->nullable();
             $table->string('product_type')->nullable();
             $table->text('attribute')->nullable();
             $table->text('image')->nullable();
             $table->text('tags')->nullable();
             $table->double('regular_price')->nullable();
             $table->double('sale_price')->nullable();
             $table->double('rrp')->nullable();
             $table->string('status');
             $table->unsignedBigInteger('creator_id');
             $table->unsignedBigInteger('modifier_id');
             $table->foreign('account_id')->references('id')->on('shopify_accounts');
//             $table->foreign('master_catalogue_id')->references('id')->on('product_drafts');
//             $table->foreign('creator_id')->references('id')->on('users');
//             $table->foreign('modifier_id')->references('id')->on('users');
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
        Schema::dropIfExists('shopify_master_products');
    }
}
