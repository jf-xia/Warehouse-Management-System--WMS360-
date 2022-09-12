<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('product_draft_id');
            $table->text('image')->nullable();
            $table->longText('attribute')->nullable();
            $table->string('sku');
            $table->integer('actual_quantity')->default(0);
            $table->string('ean_no')->nullable();
            $table->float('cost_price')->nullable();
            $table->longText('barcode')->nullable();
            $table->float('regular_price');
            $table->float('sale_price');
            $table->string('product_code')->nullable();
            $table->string('color_code')->nullable();
            $table->integer('low_quantity')->nullable();
            $table->boolean('notification_status')->default(0)->comment('true= on, false = off');
            $table->boolean('manage_stock')->default(0)->comment('true= on, false = off');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_draft_id')->references('id')->on('product_drafts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation');
    }
}
