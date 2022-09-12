<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShelveErrorToInvoiceProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_product_variation', function (Blueprint $table) {
            $table->tinyInteger('shelve_error')->after('total_price')->default(0)->comment('0=not error, 1=error');
            $table->text('error_shelve_details')->after('shelve_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_product_variation', function (Blueprint $table) {
            //
        });
    }
}
