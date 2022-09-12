<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id')->nullable()->unique();
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_no')->nullable()->unique();
            $table->string('card_no')->nullable();
            $table->longText('image')->nullable();
            $table->longText('address')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('role')->comment('Admin=1,Manager=2,Picker=3,Shelver=4,Packer=5,Receiver=6');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // \App\User::Create(['employee_id'=>'001','name'=>'Admin','last_name'=> 'User','email'=>'support@combosoft.co.uk','phone_no'=>'+443301139666','role'=>'1,2,3,4,5,6',
        //     'image'=>'wms_logo.png','password'=>'$2y$10$0SLaD8.NIx4V.i9/jXtFMenH3U1KTwXs451fAgpnXwkY436eOoUaG']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
