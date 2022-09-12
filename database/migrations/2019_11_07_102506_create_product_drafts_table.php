<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_drafts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->Integer('modifier_id')->nullable();
            $table->string('name');
            $table->string('type');
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->float('regular_price')->nullable();
            $table->longText('sale_price')->nullable();
            $table->float('cost_price')->nullable();
            $table->string('product_code')->nullable();
            $table->longText('attribute')->nullable();
            $table->string('color_code')->nullable();
            $table->longText('low_quantity')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('product_drafts');
    }
}
