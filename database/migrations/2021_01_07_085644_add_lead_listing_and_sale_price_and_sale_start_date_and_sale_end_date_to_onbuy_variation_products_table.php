<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLeadListingAndSalePriceAndSaleStartDateAndSaleEndDateToOnbuyVariationProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onbuy_variation_products', function (Blueprint $table) {
            $table->tinyInteger('lead_listing')->after('name')->nullable();
            $table->float('sale_price')->after('price')->nullable();
            $table->timestamp('sale_start_date')->after('sale_price')->nullable();
            $table->timestamp('sale_end_date')->after('sale_start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onbuy_variation_products', function (Blueprint $table) {
            //
        });
    }
}
