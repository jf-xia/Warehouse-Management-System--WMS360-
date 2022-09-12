<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailableQuantityChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_quantity_change_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('modified_by');
            $table->unsignedBigInteger('variation_id');
            $table->integer('previous_quantity');
            $table->integer('updated_quantity');
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('modified_by')->references('id')->on('users');
            // $table->foreign('variation_id')->references('id')->on('product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_quantity_change_logs');
    }
}
