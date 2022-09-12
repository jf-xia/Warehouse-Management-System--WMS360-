<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonMarketPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_market_places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('marketplace');
            $table->unsignedBigInteger('endpoint_id');
            $table->string('marketplace_id');
            $table->text('marketplace_url')->comment('seller central url');
            $table->text('marketplace_logo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('endpoint_id')->references('id')->on('amazon_endpoints');
        });
        \App\amazon\AmazonMarketPlace::insert([
            ['marketplace' => 'Brazil', 'endpoint_id' => 1,'marketplace_id' => 'A2Q3Y263D00KWC','marketplace_url' => 'https://sellercentral.amazon.com.br','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Canada', 'endpoint_id' => 1,'marketplace_id' => 'A2EUQ1WTGCTBG2','marketplace_url' => 'https://sellercentral.amazon.ca','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Mexico', 'endpoint_id' => 1,'marketplace_id' => 'A1AM78C64UM0Y8','marketplace_url' => 'https://sellercentral.amazon.com.mx','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'US', 'endpoint_id' => 1,'marketplace_id' => 'ATVPDKIKX0DER','marketplace_url' => 'https://sellercentral.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'U.A.E.', 'endpoint_id' => 2,'marketplace_id' => 'A2VIGQ35RCS4UG','marketplace_url' => 'https://sellercentral.amazon.ae','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Germany', 'endpoint_id' => 2,'marketplace_id' => 'A1PA6795UKMFR9','marketplace_url' => 'https://sellercentral-europe.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Spain', 'endpoint_id' => 2,'marketplace_id' => 'A1RKKUPIHCS9HS','marketplace_url' => 'https://sellercentral-europe.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'France', 'endpoint_id' => 2,'marketplace_id' => 'A13V1IB3VIYZZH','marketplace_url' => 'https://sellercentral-europe.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'UK', 'endpoint_id' => 2,'marketplace_id' => 'A1F83G8C2ARO7P','marketplace_url' => 'https://sellercentral-europe.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'India', 'endpoint_id' => 2,'marketplace_id' => 'A21TJRUUN4KGV','marketplace_url' => 'https://sellercentral.amazon.in','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Italy', 'endpoint_id' => 2,'marketplace_id' => 'APJ6JRA9NG5V4','marketplace_url' => 'https://sellercentral-europe.amazon.com','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Netherlands', 'endpoint_id' => 2,'marketplace_id' => 'A1805IZSGTT6HS','marketplace_url' => 'https://sellercentral.amazon.nl','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Poland', 'endpoint_id' => 2,'marketplace_id' => 'A1C3SOZRARQ6R3','marketplace_url' => 'https://sellercentral.amazon.pl','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Sweden', 'endpoint_id' => 2,'marketplace_id' => 'A2NODRKZP88ZB9','marketplace_url' => 'https://sellercentral.amazon.se','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Turkey', 'endpoint_id' => 2,'marketplace_id' => 'A33AVAJ2PDY3EV','marketplace_url' => 'https://sellercentral.amazon.com.tr','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Singapore', 'endpoint_id' => 3,'marketplace_id' => 'A19VAU5U5O7RUS','marketplace_url' => 'https://sellercentral.amazon.sg','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Australia', 'endpoint_id' => 3,'marketplace_id' => 'A39IBJ37TRP1C6','marketplace_url' => 'https://sellercentral.amazon.com.au','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()],
            ['marketplace' => 'Japan', 'endpoint_id' => 3,'marketplace_id' => 'A1VC38T7YXB528','marketplace_url' => 'https://sellercentral.amazon.co.jp','marketplace_logo' => NULL,'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_market_places');
    }
}
