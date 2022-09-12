<?php

namespace App\Http\Controllers;

use App\Country;
use App\DeveloperAccount;
use App\EbaySites;
use App\EbayAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\amazon\AmazonAccount;
use App\amazon\AmazonMarketPlace;

class IntegrationController extends Controller
{
    public function index($step){
        $status = array();
        $sites = EbaySites::get()->all();
        $developer_accounts = DeveloperAccount::get()->all();
        $countries = Country::get()->all();


        $account_lists = EbayAccount::with(['sites','developerAccount'])->get();
        foreach ($account_lists as $account_list){
//            $clientID  = $account_list->developerAccount->client_id;
//            $clientSecret  = $account_list->developerAccount->client_secret;
//
////dd($token_result->authorization_token);
//            $url = 'https://api.ebay.com/identity/v1/oauth2/token';
//            $headers = [
//                'Content-Type: application/x-www-form-urlencoded',
//                'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),
//
//            ];
//
//            $body = http_build_query([
//                'grant_type'   => 'refresh_token',
//                'refresh_token' => $account_list->refresh_token,
//                'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',
//
//            ]);
//
//            $curl = curl_init();
//
//            curl_setopt_array($curl, array(
//                CURLOPT_URL            => $url,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_CUSTOMREQUEST  => 'POST',
//                CURLOPT_POSTFIELDS     => $body,
//                CURLOPT_HTTPHEADER     => $headers
//            ));
//
//            $response = curl_exec($curl);
//
//            $err = curl_error($curl);
//
//            curl_close($curl);
//            $response = json_decode($response, true);
            if (isset($response['access_token'])){
                $status[$account_list->id] = 1;
            }else{
                $status[$account_list->id] = 0;
            }
//            echo "<pre>";
//            print_r($response['access_token']);
//            exit();
        }
        $allAccounts = AmazonAccount::where('account_status',1)->get();;
        $allMarketPlaces = AmazonMarketPlace::all();
        $content = view('integration.index',compact('account_lists', 'sites', 'developer_accounts','status','countries','step','allAccounts','allMarketPlaces'));
        return view('master',compact('content'));
    }
}
