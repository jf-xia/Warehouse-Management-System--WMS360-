<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_order_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('return_order_id');
            $table->unsignedBigInteger('variation_id');
            $table->string('product_name');
            $table->integer('return_product_quantity');
            $table->float('price');
            $table->tinyInteger('status')->nullable()->comment('0=Not in invoice,1=In invoice');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('return_order_id')->references('id')->on('return_orders');
            $table->foreign('variation_id')->references('id')->on('product_variation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_order_products');
    }
}
