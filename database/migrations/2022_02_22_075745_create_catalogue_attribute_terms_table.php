<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogueAttributeTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogue_attribute_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('catalogue_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('attribute_term_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('catalogue_id')->references('id')->on('product_drafts');
            $table->foreign('attribute_id')->references('id')->on('item_attribute_terms');
            $table->foreign('attribute_term_id')->references('id')->on('item_attribute_term_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogue_attribute_terms');
    }
}
