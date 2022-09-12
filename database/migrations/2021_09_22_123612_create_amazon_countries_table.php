<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country');
            $table->string('country_shortcode');
            $table->timestamps();
            $table->softDeletes();
        });
        \App\amazon\AmazonCountry::insert([
            ['country' => 'Afghanistan', 'country_shortcode' => 'AF','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Aland Islands', 'country_shortcode' => 'AX','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Albania', 'country_shortcode' => 'AL','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Algeria', 'country_shortcode' => 'DZ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'American Samoa', 'country_shortcode' => 'AS','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Andorra', 'country_shortcode' => 'AD','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Angola', 'country_shortcode' => 'AO','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Anguilla', 'country_shortcode' => 'AI','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Antarctica', 'country_shortcode' => 'AQ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Antigua and Barbuda', 'country_shortcode' => 'AG','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Argentina', 'country_shortcode' => 'AR','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Armenia', 'country_shortcode' => 'AM','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Aruba', 'country_shortcode' => 'AW','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Ascension Island', 'country_shortcode' => 'AC','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Australia', 'country_shortcode' => 'AU','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Austria', 'country_shortcode' => 'AT','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Azerbaijan', 'country_shortcode' => 'AZ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bahamas', 'country_shortcode' => 'BS','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bahrain', 'country_shortcode' => 'BH','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bangladesh', 'country_shortcode' => 'BD','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Barbados', 'country_shortcode' => 'BB','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Belarus', 'country_shortcode' => 'BY','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Belgium', 'country_shortcode' => 'BE','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Belize', 'country_shortcode' => 'BZ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Benin', 'country_shortcode' => 'BJ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bermuda', 'country_shortcode' => 'BM','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bermuda', 'country_shortcode' => 'BT','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bermuda', 'country_shortcode' => 'BO','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bonaire, Saint Eustatius and Saba', 'country_shortcode' => 'BQ','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bosnia and Herzegovina', 'country_shortcode' => 'BA','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Botswana', 'country_shortcode' => 'BW','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bouvet Island', 'country_shortcode' => 'BV','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Brazil', 'country_shortcode' => 'BR','created_at' => now(), 'updated_at' => now()],
            ['country' => 'British Indian Ocean Territory', 'country_shortcode' => 'IO','created_at' => now(), 'updated_at' => now()],
            ['country' => 'British Virgin Islands', 'country_shortcode' => 'VG','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Brunei Darussalam', 'country_shortcode' => 'BN','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Bulgaria', 'country_shortcode' => 'BG','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Burkina Faso', 'country_shortcode' => 'BF','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Burundi', 'country_shortcode' => 'BI','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Cambodia', 'country_shortcode' => 'KH','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Cameroon', 'country_shortcode' => 'CM','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Canada', 'country_shortcode' => 'CA','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Canary Islands', 'country_shortcode' => 'IC','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Cape Verde', 'country_shortcode' => 'CV','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Cayman Islands', 'country_shortcode' => 'KY','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Central African Republic', 'country_shortcode' => 'CF','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Chad', 'country_shortcode' => 'TD','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Chile', 'country_shortcode' => 'CL','created_at' => now(), 'updated_at' => now()],
            ['country' => 'China', 'country_shortcode' => 'CN','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Christmas Island', 'country_shortcode' => 'CX','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Cocos (Keeling) Islands', 'country_shortcode' => 'CC','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Colombia', 'country_shortcode' => 'CO','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Comoros', 'country_shortcode' => 'KM','created_at' => now(), 'updated_at' => now()],
            ['country' => 'Congo', 'country_shortcode' => 'CG','created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_countries');
    }
}
