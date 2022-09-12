<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('redirect_url_name');
            $table->longText('sign_in_link');
            $table->timestamps();
        });
        \App\DeveloperAccount::create([
          'client_id' => 'Combosof-Warehous-PRD-26e4c7d7e-de5c57b8',
               'client_secret' => 'PRD-6e4c7d7e009e-50cb-4366-9268-14fc','redirect_url_name' => 'Combosoft_Limit-Combosof-Wareho-ditufww',
               'sign_in_link' => 'https://auth.ebay.com/oauth2/authorize?client_id=Combosof-Warehous-PRD-26e4c7d7e-de5c57b8&response_type=code&redirect_uri=Combosoft_Limit-Combosof-Wareho-ditufww&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('developer_accounts');
    }
}
