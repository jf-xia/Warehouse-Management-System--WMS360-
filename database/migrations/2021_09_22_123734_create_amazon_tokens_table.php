<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('application_id');
            $table->longText('refresh_token')->comment('Expire: Lifetime');
            $table->longText('access_token')->nullable()->comment('Expire: 1 hours');
            $table->string('token_type')->nullable();
            $table->dateTime('expire_in');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('application_id')->references('id')->on('amazon_account_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_tokens');
    }
}
