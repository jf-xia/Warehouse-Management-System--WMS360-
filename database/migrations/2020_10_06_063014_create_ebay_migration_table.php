<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbayMigrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_migration', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id')->nullable();
            $table->string('site_id')->nullable();
            $table->string('sku')->nullable();
            $table->longText('imgae')->nullable();
            $table->longText('title')->nullable();
            $table->string('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->string('item_id')->nullable();
            $table->longText('url')->nullable();
            $table->string('status')->default(0);
            $table->longText('message')->nullable();
            $table->string('page_number')->nullable();
            $table->string('Item_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_migration');
    }
}
