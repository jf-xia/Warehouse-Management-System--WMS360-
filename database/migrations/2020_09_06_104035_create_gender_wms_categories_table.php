<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenderWmsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gender_wms_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('wms_category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('wms_category_id')->references('id')->on('woowms_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gender_wms_categories');
    }
}
