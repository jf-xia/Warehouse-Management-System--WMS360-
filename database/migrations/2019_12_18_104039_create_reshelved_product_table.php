<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReshelvedProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reshelved_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variation_id');
            $table->unsignedBigInteger('shelf_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('quantity');
            $table->integer('shelved_quantity')->default(0);
            $table->tinyInteger('status')->default('0')->comment('1=shelved, 0=not shelved ');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('variation_id')->references('id')->on('product_variation');
            $table->foreign('shelf_id')->references('id')->on('shelfs');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reshelved_product');
    }
}
