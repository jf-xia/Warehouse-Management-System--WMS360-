<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('receiver_user_id');
            $table->unsignedBigInteger('return_order_id')->nullable();
            $table->integer('invoice_number')->unique()->nullable();
            $table->float('invoice_total_price');
            $table->timestamp('receive_date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('receiver_user_id')->references('id')->on('users');
            $table->foreign('return_order_id')->references('id')->on('return_orders');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
