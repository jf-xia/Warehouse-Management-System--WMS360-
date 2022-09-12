<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbayCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_currency', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->string('currency');
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('ebay_sites');
        });

        DB::table('ebay_currency')->insert([
            ["currency" => "GBP",'site_id' => 3],
            ["currency" => "USD",'site_id' => 0],
            ["currency" => "AUD",'site_id' => 16],
            ["currency" => "EUR",'site_id' => 15],
            ["currency" => "EUR",'site_id' => 23],
            ["currency" => "EUR",'site_id' => 123],
            ["currency" => "USD",'site_id' => 2],
            ["currency" => "USD",'site_id' => 210],
            ["currency" => "EUR",'site_id' => 71],
            ["currency" => "EUR",'site_id' => 77],
            ["currency" => "EUR",'site_id' => 210],
            ["currency" => "EUR",'site_id' => 203],
            ["currency" => "EUR",'site_id' => 205],
            ["currency" => "EUR",'site_id' => 101],
            ["currency" => "MYR",'site_id' => 207],
            ["currency" => "EUR",'site_id' => 146],
            ["currency" => "PHP",'site_id' => 211],
            ["currency" => "PLN",'site_id' => 212],
            ["currency" => "RUB",'site_id' => 215],
            ["currency" => "SGD",'site_id' => 186],
            ["currency" => "EUR",'site_id' => 216],
            ["currency" => "CHF",'site_id' => 193]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_currency');
    }
}
