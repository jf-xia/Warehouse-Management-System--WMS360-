<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRrpAndNotAttributeToWoocomMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('woocom_master_products', function (Blueprint $table) {
            $table->double('rrp')->after('sale_price')->nullable();
            $table->longText('not_attribute')->after('attribute')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('woocom_master_products', function (Blueprint $table) {
            //
        });
    }
}
