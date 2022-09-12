<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('channel')->unique();
            $table->string('channel_term_slug')->unique();
            $table->tinyInteger('is_active')->comment('0=Inactive, 1=Active');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('channels')->insert([
            ["channel" => "eBay","channel_term_slug" => "ebay","is_active" => 0,"created_at" => now(),"updated_at" => now()],
            ["channel" => "OnBuy","channel_term_slug" => "onbuy","is_active" => 0,"created_at" => now(),"updated_at" => now()],
            ["channel" => "Woocommerce","channel_term_slug" => "woocommerce","is_active" => 0,"created_at" => now(),"updated_at" => now()],
            ["channel" => "Amazon","channel_term_slug" => "amazon","is_active" => 0,"created_at" => now(),"updated_at" => now()],
            ["channel" => "Shopify","channel_term_slug" => "shopify","is_active" => 0,"created_at" => now(),"updated_at" => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
