<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileIdProfileStatusToEbayMasterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use \App\Traits\CustomMigration;
    public function up()
    {
        Schema::table('ebay_master_products', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id')->nullable();
            $table->string('profile_status')->default(1);

            $table->foreign('profile_id')->references('id')->on('ebay_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->forceDeleteColumn('profile_id','ebay_master_products');
        $this->forceDeleteColumn('profile_status','ebay_master_products');
    }
}
