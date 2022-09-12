<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOnbuyAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onbuy_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('consumer_key');
            $table->text('secret_key');
            $table->unsignedBigInteger('creator');
            $table->unsignedBigInteger('modifier')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator')->references('id')->on('users');
            $table->foreign('modifier')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onbuy_accounts');
    }
}
