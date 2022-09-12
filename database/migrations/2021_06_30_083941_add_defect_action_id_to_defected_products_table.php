<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefectActionIdToDefectedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defected_products', function (Blueprint $table) {
            $table->unsignedBigInteger('defect_action_id')->after('defect_reason_id')->nullable();
            $table->foreign('defect_action_id')->references('id')->on('defect_product_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defected_products', function (Blueprint $table) {
            //
        });
    }
}
