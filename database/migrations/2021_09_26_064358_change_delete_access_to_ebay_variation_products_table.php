<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDeleteAccessToEbayVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ebay_variation_products', function (Blueprint $table) {
            //
            $table->dropForeign('ebay_variation_products_ebay_master_product_id_foreign');
            $table->foreign('ebay_master_product_id')->references('id')->on('ebay_master_products')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ebay_variation_products', function (Blueprint $table) {
            //
        });
    }
}
