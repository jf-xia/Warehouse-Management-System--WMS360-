<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_name');
            $table->timestamps();
            $table->softDeletes();
        });

        \App\Role::insert([
            ["id" => "1","role_name" => "Admin"],
            ["id" => "2","role_name" => "Manager"],
            ["id" => "3","role_name" => "Picker"],
            ["id" => "4","role_name" => "Shelver"],
            ["id" => "5","role_name" => "Packer"],
            ["id" => "6","role_name" => "Receiver"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
