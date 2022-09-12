<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnbuyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onbuy_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->integer('brand')->nullable();
            $table->longText('category_ids');
            $table->integer('last_category_id');
            $table->longText('summery_points');
            $table->longText('master_product_data');
            $table->longText('features');
            $table->longText('technical_details');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onbuy_profiles');
    }
}
