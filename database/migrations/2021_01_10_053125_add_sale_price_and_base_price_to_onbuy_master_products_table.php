<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSalePriceAndBasePriceToOnbuyMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onbuy_master_products', function (Blueprint $table) {
            $table->float('sale_price')->after('rrp')->nullable();
            $table->float('base_price')->after('sale_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onbuy_master_products', function (Blueprint $table) {
            //
        });
    }
}
