<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_product_variation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('shelver_user_id')->nullable();
            $table->integer('quantity');
            $table->integer('shelved_quantity')->default(0);
            $table->float('price');
            $table->boolean('shelving_status')->default(0)->comment(' pending = 0, shelved = 1');
            $table->boolean('product_type')->comment('non defected =1, defected = 0	');
            $table->float('total_price');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('product_variation_id')->references('id')->on('product_variation');
            $table->foreign('shelver_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_product_variation');
    }
}
