<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEbaySitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ebay_sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('global_id');
            $table->timestamps();
        });
        \App\EbaySites::insert([

            ['id' => 2, 'name' => 'CA', 'global_id' => 'EBAY-ENCA'],
            ['id' => 3, 'name' => 'UK', 'global_id' => 'EBAY-GB'],
            ['id' => 15, 'name' => 'AU', 'global_id' => 'EBAY-AU'],
            ['id' => 16, 'name' => 'AT', 'global_id' => 'EBAY-AT'],
            ['id' => 23, 'name' => 'BEFR', 'global_id' => 'EBAY-FRBE'],
            ['id' => 71, 'name' => 'FR', 'global_id' => 'EBAY-FR'],
            ['id' => 77, 'name' => 'DE', 'global_id' => 'EBAY-DE'],
            ['id' => 101, 'name' => 'IT', 'global_id' => 'EBAY-IT'],
            ['id' => 123, 'name' => 'BENL', 'global_id' => 'EBAY-NLBE'],
            ['id' => 146, 'name' => 'NL', 'global_id' => 'EBAY-NL'],
            ['id' => 186, 'name' => 'ES', 'global_id' => 'EBAY-ES'],
            ['id' => 193, 'name' => 'CH', 'global_id' => 'EBAY-CH'],
            ['id' => 201, 'name' => 'HK', 'global_id' => 'EBAY-HK'],
            ['id' => 203, 'name' => 'IN', 'global_id' => 'EBAY-IN'],
            ['id' => 205, 'name' => 'IE', 'global_id' => 'EBAY-IE'],
            ['id' => 207, 'name' => 'MY', 'global_id' => 'EBAY-MY'],
            ['id' => 210, 'name' => 'CAFR', 'global_id' => 'EBAY-FRCA'],
            ['id' => 211, 'name' => 'PH', 'global_id' => 'EBAY-PH'],
            ['id' => 212, 'name' => 'PL', 'global_id' => 'EBAY-PL'],
            ['id' => 215, 'name' => 'RU', 'global_id' => ''],
            ['id' => 216, 'name' => 'SG', 'global_id' => 'EBAY-SG'],
            ['id' => 0, 'name' => 'US', 'global_id' => 'EBAY-US']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_sites');
    }
}
