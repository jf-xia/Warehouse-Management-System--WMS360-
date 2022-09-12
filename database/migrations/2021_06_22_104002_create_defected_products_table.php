<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defected_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variation_id');
            $table->integer('defected_product');
            $table->unsignedBigInteger('defect_reason_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('variation_id')->references('id')->on('product_variation');
            // $table->foreign('defect_reason_id')->references('id')->on('defected_product_reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defected_products');
    }
}
