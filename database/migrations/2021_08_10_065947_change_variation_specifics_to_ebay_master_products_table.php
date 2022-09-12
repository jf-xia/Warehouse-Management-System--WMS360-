<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVariationSpecificsToEbayMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ebay_master_products', function (Blueprint $table) {
            $table->string('variation_specifics')->nullable()->change();
            $table->string('variation_images')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ebay_master_products', function (Blueprint $table) {
            //
        });
    }
}
