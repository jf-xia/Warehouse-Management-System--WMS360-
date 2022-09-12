<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIndexToItemAttributeTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_attribute_terms', function (Blueprint $table) {
            $table->dropUnique('item_attribute_terms_item_attribute_term_unique');
            $table->dropUnique('item_attribute_terms_item_attribute_term_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_attribute_terms', function (Blueprint $table) {
            //
        });
    }
}
