<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnbuyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onbuy_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->primary();
            $table->string('name');
            $table->string('category_tree');
            $table->integer('category_type_id');
            $table->string('category_type');
            $table->integer('parent_id');
            $table->integer('lvl');
            $table->boolean('product_code_required');
            $table->boolean('can_list_in');
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
        Schema::dropIfExists('onbuy_categories');
    }
}
