<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('sku_no')->default('1');
            $table->tinyInteger('variation_id')->default('1');
            $table->tinyInteger('ean_no')->default('1');
            $table->tinyInteger('attribute')->default('1');
            $table->integer('default_vat')->nullable();
            $table->text('invoice_notice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_settings');
    }
}
