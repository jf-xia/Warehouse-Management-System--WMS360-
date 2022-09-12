<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('order_number')->unique()->nullable();
            $table->string('status')->nullable();
            $table->string('created_via')->nullable();
            $table->string('currency')->nullable();
            $table->double('total_price')->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_zip_code')->nullable();
            $table->string('customer_state')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->longText('shipping')->nullable();
            $table->string('shipping_post_code')->nullable();
            $table->longText('shipping_method')->nullable();
            $table->string('ebay_order_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->UnsignedBigInteger('picker_id')->nullable();
            $table->UnsignedBigInteger('assigner_id')->nullable();
            $table->UnsignedBigInteger('packer_id')->nullable();
            $table->timestamp('date_created')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->timestamp('date_cancelled')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('picker_id')->references('id')->on('users');
            $table->foreign('assigner_id')->references('id')->on('users');
            $table->foreign('packer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
