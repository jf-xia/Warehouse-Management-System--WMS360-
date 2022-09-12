<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_endpoints', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('endpoint');
            $table->string('endpoint_shortcode');
            $table->string('url');
            $table->string('region');
            $table->timestamps();
            $table->softDeletes();
        });
        \App\amazon\AmazonEndpoint::insert([
            ['endpoint' => 'North America', 'endpoint_shortcode' => 'NA','url' => 'https://sellingpartnerapi-na.amazon.com','region' => 'us-east-1','created_at' => now(), 'updated_at' => now()],
            ['endpoint' => 'Europe', 'endpoint_shortcode' => 'EU','url' => 'https://sellingpartnerapi-eu.amazon.com','region' => 'eu-west-1','created_at' => now(), 'updated_at' => now()],
            ['endpoint' => 'Far East', 'endpoint_shortcode' => 'FE','url' => 'https://sellingpartnerapi-fe.amazon.com','region' => 'us-west-2','created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_endpoints');
    }
}
