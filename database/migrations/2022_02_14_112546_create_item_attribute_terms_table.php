<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemAttributeTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_attribute_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_attribute_id');
            $table->string('item_attribute_term')->unique();
            $table->string('item_attribute_term_slug')->unique();
            $table->tinyInteger('is_active');
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
        Schema::dropIfExists('item_attribute_terms');
    }
}
