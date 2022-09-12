<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_product_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('marketplace_id');
            $table->string('product_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('marketplace_id')->references('id')->on('amazon_market_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_product_types');
    }
}
