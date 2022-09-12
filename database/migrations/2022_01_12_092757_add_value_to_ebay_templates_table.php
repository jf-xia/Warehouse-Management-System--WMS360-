<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueToEbayTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('ebay_templates')->insert([
            ["template_name" => "Default Template","template_html" => '<p>{!! $description !!}</p>',"template_file_name" => "1619445120.blade.php"]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ebay_templates', function (Blueprint $table) {
            //
        });
    }
}
