<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('client_id');
            $table->string('client_name');
            $table->text('url');
            $table->text('logo_url');
            $table->timestamps();
            $table->softDeletes();
        });

        // \App\Client::Create(['client_id'=>'1006','client_name'=>'wms-1006','url' => 'https://woowms.com/wms-1006/api']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
