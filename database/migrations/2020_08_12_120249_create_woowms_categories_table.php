<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoowmsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use \App\Traits\CustomMigration;
    public function up()
    {
        Schema::create('woowms_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_name');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->forceDeleteTable('woowms_categories');
    }
}
