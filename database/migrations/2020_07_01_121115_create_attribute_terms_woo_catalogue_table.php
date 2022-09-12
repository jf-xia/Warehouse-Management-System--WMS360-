<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTermsWooCatalogueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_terms_woo_catalogue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_draft_id');
            $table->unsignedBigInteger('attribute_term_id');
            $table->unsignedBigInteger('attribute_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_draft_id')->references('id')->on('woocom_master_products');
            $table->foreign('attribute_term_id')->references('id')->on('attribute_terms');
            $table->foreign('attribute_id')->references('id')->on('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_terms_woo_catalogue');
    }
}
