<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountInfoToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->string('address_line_1')->after('status')->nullable();
            $table->string('address_line_2')->after('status')->nullable();
            $table->string('address_line_3')->after('status')->nullable();
            $table->string('country')->after('status')->nullable();
            $table->string('city')->after('status')->nullable();
            $table->string('post_code')->after('status')->nullable();
            $table->string('phone_no')->after('status')->unique()->nullable();
            $table->string('reg_no')->after('status')->unique()->nullable();
            $table->string('email')->after('status')->unique()->nullable();
            $table->string('vat')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
}
