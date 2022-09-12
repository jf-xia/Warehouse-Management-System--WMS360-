<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('site_id');
            $table->unsignedBigInteger('account_id');
            $table->string('return_id');
            $table->string('return_name');
            $table->string('return_description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('site_id')->references('id')->on('ebay_sites');
            $table->foreign('account_id')->references('id')->on('ebay_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_policies');
    }
}
