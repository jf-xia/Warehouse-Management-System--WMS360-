<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_conditions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('condition_name');
            $table->string('condition_slug');
            $table->timestamps();
            $table->softDeletes();
        });
        \App\amazon\AmazonCondition::insert([
            ['condition_name' => 'New', 'condition_slug' => 'new_new','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'New - Open Box', 'condition_slug' => 'new_open_box','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'New - OEM', 'condition_slug' => 'new_oem','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Refurbished', 'condition_slug' => 'refurbished_refurbished','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Used - Like New', 'condition_slug' => 'used_like_new','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Used - Very Good', 'condition_slug' => 'used_very_good','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Used - Good', 'condition_slug' => 'used_good','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Used - Acceptable', 'condition_slug' => 'used_acceptable','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Collectible - Like New"', 'condition_slug' => 'collectible_like_new','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Collectible - Very Good', 'condition_slug' => 'collectible_very_good','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Collectible - Good', 'condition_slug' => 'collectible_good','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Collectible - Acceptable', 'condition_slug' => 'collectible_acceptable','created_at' => now(), 'updated_at' => now()],
            ['condition_name' => 'Club', 'condition_slug' => 'club_club','created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_conditions');
    }
}
