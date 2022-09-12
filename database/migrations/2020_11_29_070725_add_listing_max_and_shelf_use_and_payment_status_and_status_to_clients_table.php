<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddListingMaxAndShelfUseAndPaymentStatusAndStatusToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('listing_max')->after('logo_url')->default(100);
            $table->tinyInteger('shelf_use')->after('listing_max')->default(1);
            $table->tinyInteger('payment_status')->after('shelf_use')->default(1);
            $table->tinyInteger('status')->after('payment_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
