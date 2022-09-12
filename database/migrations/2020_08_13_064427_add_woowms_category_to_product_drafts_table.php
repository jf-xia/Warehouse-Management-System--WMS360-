<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWoowmsCategoryToProductDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use \App\Traits\CustomMigration;
    public function up()
    {
        Schema::table('product_drafts', function (Blueprint $table) {
            $table->unsignedBigInteger('woowms_category')->after('modifier_id')->nullable();
            $table->unsignedBigInteger('condition')->after('woowms_category')->nullable();
            $table->string('sku_short_code')->after('color_code')->nullable();
            $table->string('color')->after('product_code')->nullable();
            $table->foreign('woowms_category','product_drafts_woowms_category_foreign')->references('id')->on('woowms_categories');
            $table->foreign('condition')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->forceDeleteColumn('woowms_category','product_drafts');
        $this->forceDeleteColumn('condition','product_drafts');
        $this->forceDeleteColumn('sku_short_code','product_drafts');
        $this->forceDeleteColumn('color','product_drafts');
    }
}
