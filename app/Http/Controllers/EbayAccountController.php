<?php

namespace App\Http\Controllers;


use App\Client;
use App\Console\Commands\TestCommand;
use App\Country;
use App\DeveloperAccount;
use App\EbayAccountSite;
use App\EbayMasterProduct;
use App\EbayProfile;
use App\EbaySites;
use App\EbayVariationProduct;
use App\PaymentPolicy;
use App\ProductDraft;
use App\EbayAccount;
use App\ReturnPolicy;
use App\ShipmentPolicy;
use Carbon\Carbon;
use ClouSale\AmazonSellingPartnerAPI\Api\ProductPricingApi;
use Facade\FlareClient\View;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
require_once './vendor/autoload.php';
use SellingPartnerApi\Api;
use SellingPartnerApi\Configuration;
use SellingPartnerApi\Endpoint;
use SellingPartnerApi\Model\FbaInventory\InventoryDetails;
use SellingPartnerApi\Model\ProductPricing\Price;
use SellingPartnerApi\Model\SmallAndLight\FBAItem;
use App\Channel;

class EbayAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('max_execution_time', '300');
//        $clientID = 'Mahfuzhu-warehous-PRD-b2eb49443-8e2b8238';
//        $clientSecret = 'PRD-2eb494438182-53e2-4200-9cb6-6457';
//        $ruName = 'Mahfuzhur_Rahma-Mahfuzhu-wareho-uyhilcaf';
//        $token_result = EbayAccount::where(['client_id' => $clientID, 'client_secret' => $clientSecret])->get()->first();
////dd($token_result->authorization_token);
//        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
//        $headers = [
//            'Content-Type: application/x-www-form-urlencoded',
//            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),
//
//        ];
//
//        $body = http_build_query([
//            'grant_type'   => 'refresh_token',
//            'refresh_token' => $token_result->refresh_token,
//            'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',
//
//        ]);
//
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL            => $url,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_CUSTOMREQUEST  => 'POST',
//            CURLOPT_POSTFIELDS     => $body,
//            CURLOPT_HTTPHEADER     => $headers
//        ));
//
//        $response = curl_exec($curl);
//
//        $err = curl_error($curl);
//
//        curl_close($curl);
//        $response = json_decode($response, true);
//        //dd($response);
//        /// ////////////////////////////// end
//        session(['access_token' => $response['access_token']]);
    }

    public function amazon(Request $request){

        // return \Carbon\Carbon::now()->format("Ymd\THis\Z");
        // return $request;
        // $url = 'https://api.amazon.com/auth/o2/token?grant_type=authorization_code&code='.$request->spapi_oauth_code.'&client_id=amzn1.application-oa2-client.eb953824c6714bf8b9e4e8938274f7c0&client_secret=ac0e2f00d38c60c1612173cfcff7d8d831a583f326aa4dd23f3effc88802a7ad&redirect_uri=https://woowms.com/admin/amazon-authorization';
        $url = 'https://api.amazon.com/auth/o2/token';

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $body = http_build_query([
            'grant_type'   => 'authorization_code',
            'code'         => $request->spapi_oauth_code,
            'redirect_uri' => 'https://woowms.com/admin/amazon-authorization',
            'client_id' => 'amzn1.application-oa2-client.eb953824c6714bf8b9e4e8938274f7c0',
            'client_secret' => 'ac0e2f00d38c60c1612173cfcff7d8d831a583f326aa4dd23f3effc88802a7ad',
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);


        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        $config = new Configuration([
            "lwaClientId" => "amzn1.application-oa2-client.eb953824c6714bf8b9e4e8938274f7c0",
            "lwaClientSecret" => "ac0e2f00d38c60c1612173cfcff7d8d831a583f326aa4dd23f3effc88802a7ad",
            "lwaRefreshToken" => $response['refresh_token'],
            "awsAccessKeyId" => "AKIAUBRGYVBSZBRHX4LU",
            "awsSecretAccessKey" => "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",
            // If you're not working in the North American marketplace, change
            // this to another endpoint from lib/Endpoint.php
            "endpoint" => Endpoint::EU_SANDBOX,
            "roleArn" => "arn:aws:iam::278180440165:role/mahfuzhur_role3",
        ]);

        $api = new Api\VendorDirectFulfillmentInventoryApi($config);
        $marketplace_ids = array('A1F83G8C2ARO7P');
        $body = [
            'inventory'  => '',
        ];
        try {
            $result = $api->submitInventoryUpdate('1',$body);
            echo "<pre>";
            print_r($result);
        }catch (Exception $e) {
            echo 'Exception when calling SellersApi->getMarketplaceParticipations: ', $e->getMessage(), PHP_EOL;
        }
        exit();
        // return $response['access_token'];
//        // signature
//        // Configuration values
//        $host					= 'sellingpartnerapi-eu.amazon.com';
//        $accessKey	 			= 'AKIAUBRGYVBSZBRHX4LU';
//        $secretKey 				= '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';
//        $region 				= 'eu-west-1';
//        $service 				= 'execute-api';
//
//        /**
//         * You should modify the script
//         * for
//         *	1. full request url
//         *	2. uri for AWS signature
//         *	3. request method GET / POST / PUT
//         * 	4. actual data of the request
//         * and call the above functions
//         */
//        $requestUrl	= 'https://sellingpartnerapi-eu.amazon.com/catalog/v0/items?marketplace=A1F83G8C2ARO7P';
//        $uri = '/catalog/v0/items?marketplace=A1F83G8C2ARO7P';
//        $httpRequestMethod = 'GET';
//
//        $data = json_encode(array());
//
//        $signature = calcualteAwsSignatureAndReturnHeaders($host, $uri, $requestUrl,
//            $accessKey, $secretKey, $region, $service,
//            $httpRequestMethod, $data, TRUE);
//
//        $result = callToAPI($requestUrl, $httpRequestMethod, $signature, $data, TRUE);
//
//        print_r($result);
//        exit();

        // start
        $url = 'https://sellingpartnerapi-eu.amazon.com/catalog/v0/items?marketplace=A1F83G8C2ARO7P';

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            $signature[0],
            'x-amz-access-token:'.$response['access_token'],
            'x-amz-date:'.\Carbon\Carbon::now()->format("Ymd\THis\Z"),
            'user-agent:'. 'wms_mahfuzh/2.0 (Language=php)'

        ];

        $body = http_build_query([

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);


        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        dd($response);
    }

    public function authorrizationPage(){
//        echo 'test';
//        exit();
        return \view('authorization');
    }



    public function saveAuthorization(Request $request){
        $data = array();
        $data['account_id'] = $request->account_id;
        $data['site_id'] = $request->site_id;

        $update_client = Client::find(1);
        $update_client->ebay_auth_data = serialize($data);
        $update_client->save();
        $str= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $str = explode("save-authorization",$str);
        $_COOKIE['url'] = $str[0];
//        print_r($_COOKIE['url']);
//        exit();
    }

    public function updateAuthorization(Request $request,$type){
        $authCode = $request->token;
        $account_id = $request->account_id;
        $result = EbayAccount::where('id',$account_id)->with('developerAccount')->get();

//        return $result[0]->developerAccount;
//        echo "<pre>";
//        print_r( $result[0]);
//        exit();
        //dd($authCode);
        $clientID = $result[0]->developerAccount->client_id;
        $clientSecret = $result[0]->developerAccount->client_secret;
        $ruName = $result[0]->developerAccount->redirect_url_name;
        //$token_result = EbayAccount::where(['client_id' => $clientID, 'client_secret' => $clientSecret])->get()->first();

//        if(1==1){
//            $clientID = 'Mahfuzhu-warehous-PRD-b2eb49443-8e2b8238';
//            $clientSecret = 'PRD-2eb494438182-53e2-4200-9cb6-6457';
//            $ruName = 'Mahfuzhur_Rahma-Mahfuzhu-wareho-uyhilcaf';
        ///////////////////////////////// start
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'authorization_code',
            'code'         => $authCode,
            'redirect_uri' => $ruName,

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);


        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);


        /// ////////////////////////////// end
//            session(['access_token' => $response['access_token']]);
//            session(['refresh_token' => $response['refresh_token']]);
        if (isset($response['access_token']) && isset($response['refresh_token'])){
            $channelUpdateStatus = Channel::where('channel_term_slug','ebay')->update(['is_active' => 1]);
            $result = EbayAccount::find($account_id)->update(['authorization_token' => $authCode,'refresh_token'=> $response['refresh_token'],
                'access_token' => $response['access_token'],'expiry_date' => Carbon::now()->addSecond($response['refresh_token_expires_in'])->format('Y-m-d h:i:s')]);
        }

//            $result = EbayAccount::create(['client_id'=> $clientID, 'client_secret' => $clientSecret,'authorization_token' => $authCode,
//                'redirect_url_name' => $ruName,'access_token' => session('access_token'),'refresh_token' => session('refresh_token')]);
//        }else{
//            $url = 'https://api.ebay.com/identity/v1/oauth2/token';
//
//            $headers = [
//                'Content-Type: application/x-www-form-urlencoded',
//                'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),
//
//            ];
//
//            $body = http_build_query([
//                'grant_type'   => 'authorization_code',
//                'code'         => $authCode,
//                'redirect_uri' => $ruName,
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
//            //dd($response['refresh_token']);
//
//            /// ////////////////////////////// end
//            session(['access_token' => $response['access_token']]);
//            session(['refresh_token' => $response['refresh_token']]);
//
//            $result = EbayAccount::find($token_result->id)->update(['authorization_token' => $authCode,'refresh_token'=> session('refresh_token')]);
//        }


        return response()->json($result);
    }

    public function createAuthorization(){
        $sites = EbaySites::get()->all();
        $developer_accounts = DeveloperAccount::get()->all();

        return view('ebay.account.create_account', compact('sites','developer_accounts'));
    }

    public function openAuthorization(Request $request){
//        session(['account_id' => $request->account_id]);
//        session(['site_id' => $request->site_id]);
        $account_id = $request->account_id;
        $site_id = $request->site_id;
        $developer_accounts = DeveloperAccount::get()->all();

        $result = EbayAccount::find($request->account_id);

        return view('ebay.account.show_account',compact('result','developer_accounts','account_id','site_id'));
    }

    public function storeAuthorization(Request $request,$type){
        $path = null;
        $accountExistCheck = EbayAccount::where('account_name',$request->account_name)->where('country',$request->country)->first();
        if($accountExistCheck){
            return response()->json(['type'=>'error','msg'=>'Account Exist']);
        }
        if ($request->hasFile('logo')){
            $logo = $request->logo;
            $filename = rand(100,1000).'.'. $logo->extension();
            $path = asset('uploads/ebay-account-logo').'/'.$filename;
            $logo->move('./uploads/ebay-account-logo/',$filename);
        }
        //$result = EbayAccount::insert(['account_name'=> $request->account_name,'logo' => $path,'developer_id' => $request->developer_id,'feeder_quantity' => $request->feeder_quantity]);
        $ebay_account = EbayAccount::updateOrCreate([
            'account_name' => $request->account_name,'country' => $request->country
        ],['developer_id' => $request->developer_id,'feeder_quantity' => $request->feeder_quantity,'country' => $request->country,
            'location' => $request->location,'post_code' => $request->post_code]);
        $ebay_account = new EbayAccount();
        $ebay_account->account_name = $request->account_name;
        $ebay_account->logo = $path;
        $ebay_account->developer_id = $request->developer_id;
        $ebay_account->feeder_quantity = $request->feeder_quantity;
        $ebay_account->country= $request->country;
        $ebay_account->location= $request->location;
        $ebay_account->post_code= $request->post_code;
        $ebay_account->save();
        $account_site = EbayAccount::find($ebay_account->id);
        $account_site->sites()->attach($request->site_id);
        $developer_id = DeveloperAccount::get()->first();
        if ($type == 'old'){
            return redirect('ebay-account-list')->with('success','account created successfully');
        }elseif ($type == 'new'){
            return ["sign_in_link" =>$developer_id->sign_in_link,"account_id" => $ebay_account->id];
        }

    }

    public function accountList(){
        $status = array();
        $sites = EbaySites::get()->all();
        $developer_accounts = DeveloperAccount::get()->all();
        $countries = Country::get()->all();


        $account_lists = EbayAccount::with(['sites','developerAccount'])->get();
        foreach ($account_lists as $account_list){
            $clientID  = $account_list->developerAccount->client_id;
            $clientSecret  = $account_list->developerAccount->client_secret;

//dd($token_result->authorization_token);
            $url = 'https://api.ebay.com/identity/v1/oauth2/token';
            $headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

            ];

            $body = http_build_query([
                'grant_type'   => 'refresh_token',
                'refresh_token' => $account_list->refresh_token,
                'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',

            ]);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_HTTPHEADER     => $headers
            ));

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);
            $response = json_decode($response, true);
            if (isset($response['access_token'])){
                $status[$account_list->id] = 1;
            }else{
                $status[$account_list->id] = 0;
            }
//            echo "<pre>";
//            print_r($response['access_token']);
//            exit();
        }


//        $result = EbayAccount::with('sites')->get();
        //return $account_lists;

        return view('ebay.account.account_list',compact('account_lists', 'sites', 'developer_accounts','status','countries'));
    }

    public function editAuthorization($id){

        $sites = EbaySites::get()->all();
        $result = EbayAccount::with('sites')->find($id);

        return view('ebay.account.edit_account',compact('sites','result'));
    }
    public function testCommand(Request $request){


//        $this->dispatch(new TestCommand($request));
//        return 'test';
//        Artisan::command('testcommand',function () {
//            $this->info("looping done");
//        });
//        return gettype($request);
        $temp[] = 'test';
        Artisan::call("testcommand:test",['test' => $request]);

    }
    public function deleteEbayAccount(Request $request,$id){
        $account_result = EbayAccount::find($id);


//        return $result;
        if ($request->delete_info == 1){
            $account_result = EbayAccount::find($id);
            $account_result->forceDelete();
//            $result = EbayMasterProduct::select('id')->where('account_id', $id)->get()->pluck('id')->toArray();
//
//            $product_variation = EbayVariationProduct::whereIn('ebay_master_product_id',$result)->forceDelete();
//
//                $master_delete_result = EbayMasterProduct::whereIn('id',$result)->forceDelete();
//
//            $find_result = EbayMasterProduct::select('id')->where('account_id', $id)->first();
//            if (!$find_result){
//                EbayAccountSite::where('account_id',$id)->forceDelete();
//                ReturnPolicy::where('account_id',$id)->forceDelete();
//                PaymentPolicy::where('account_id',$id)->forceDelete();
//                ShipmentPolicy::where('account_id',$id)->forceDelete();
//                EbayProfile::where('account_id',$id)->forceDelete();
//                $account_result->forceDelete($id);
////                $account_result->deleted_at = Carbon::now();
////                $account_result->save();
//            }
        }elseif ($request->delete_info == 2){
            $ebay_account = EbayAccount::with('sites')->find($id);
            $item_ids = EbayMasterProduct::select('item_id')->where('account_id', $id)->get()->pluck('item_id')->toArray();

            $ebay_access_token = $this->ebayAccessToken($account_result->refresh_token);


            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <EndItemsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>';
            foreach ($item_ids as $item_id){
                $body .= '<EndItemRequestContainer>

                            <EndingReason>NotAvailable</EndingReason>
                            <ItemID>'.$item_id.'</ItemID>
                          </EndItemRequestContainer>';


            }
            $body .='</EndItemsRequest>';
            $url = 'https://api.ebay.com/ws/api.dll';

            $headers = [
                'X-EBAY-API-SITEID:'.$ebay_account->sites[0]->id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:EndItems',
                'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

            ];
            $result = $this->curl($url,$headers,$body,'POST');
            $result =simplexml_load_string($result);
            $result = json_decode(json_encode($result),true);

//            if ($result['Ack'] == 'Success'){
//                $ebay_account->
////                $ebay_master_product = EbayMasterProduct::find($ebay_master_product->id);
////
////                $ebay_master_product->variationProducts()->forceDelete();
////                $ebay_master_product->forceDelete($ebay_master_product->id);
////                    return redirect('ebay-master-product-list')->with('success','successfully deleted');
//            }else{
//                $ebay_master_product = EbayMasterProduct::find($id);
//                $ebay_master_product->variationProducts()->forceDelete();
//                $ebay_master_product->forceDelete($id);
////                    return redirect('ebay-master-product-list')->with('success',$result['Errors']['LongMessage']);
//            }
//            $find_result = EbayMasterProduct::select('id')->where('account_id', $id)->first();
            $ebay_account = EbayAccount::find($id);
            if ($ebay_account){
                $ebay_account->forceDelete();
            }

        }
        return redirect('ebay-account-list');

    }
    public function updateEbayAuthorization(Request $request,$id){
        $path = null;

        $result = EbayAccount::find($id);
        $result->account_name = $request->account_name;
        $result->feeder_quantity = $request->feeder_quantity;
        $result->country = $request->country;
        $result->location = $request->location;
        $result->post_code = $request->post_code;
        if ($request->hasFile('logo')){
            $logo = $request->logo;
            $filename = rand(100,1000).'.'. $logo->extension();
            $path = asset('uploads/ebay-account-logo').'/'.$filename;
            $logo->move('./uploads/ebay-account-logo/',$filename);
            $result->logo = $path;
        }
        $result->save();
        //DB::table('ebay_account_site')->where('account_id',$id)->delete();
        EbayAccount::find($id)->sites()->sync($request->site_id);
        return redirect('ebay-account-list')->with('success','updated successfully');
    }

    public function addItem(){

        $result = ProductDraft::with(['ProductVariations','images'])->where('id',71341 )->get();

        //$result = json_encode($result);
//        echo "<pre>";
//        print_r($result[0]['images'][0]->image_url);
//        exit();
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:0',
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategories',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <CategorySiteID>0</CategorySiteID>
                      <DetailLevel>ReturnAll</DetailLevel>
                      <LevelLimit>1</LevelLimit>
                    </GetCategoriesRequest>';
        try{
            $categories = $this->curl($url,$headers,$body,'POST');
            $categories =simplexml_load_string($categories);
            $categories = json_decode(json_encode($categories),true);
            //return $categories;
//            $categories = $categories['CategoryArray']['Category'][0];
//            echo "<pre>";
//            print_r(json_decode(json_encode($categories),true));
//            exit();

        }catch (Exception $exception){
            echo $exception;
        }


        return view('ebay.add_product',compact('result','categories'));
    }
    public function ebayAccessToken($refresh_token){
        $developer_result = DeveloperAccount::get()->first();

        $clientID  = $developer_result->client_id;
        $clientSecret  = $developer_result->client_secret;
//dd($token_result->authorization_token);
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $refresh_token,
            'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        return  $response['access_token'];
    }

    public function getCategory(Request $request){
        $result = EbayMasterProduct::with(['variationProducts'])->find(1);
        $account_result = EbayAccount::find($request->account_id);
        $token = $this->ebayAccessToken($account_result->refresh_token);
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$request->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategories',
            'X-EBAY-API-IAF-TOKEN:'.$token,
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                        <CategoryParent>'.$request->category_id.'</CategoryParent>
                      <CategorySiteID>'.$request->site_id.'</CategorySiteID>
                      <DetailLevel>ReturnAll</DetailLevel>
                      <LevelLimit>'.$request->level.'</LevelLimit>
                    </GetCategoriesRequest>';

        $categories = $this->curl($url,$headers,$body,'POST');
        $categories =simplexml_load_string($categories);
        $categories = json_decode(json_encode($categories),true);

        if ($categories['CategoryCount'] !=1){
            $output = '<div class="col-md-2"></div><div class="col-md-10 m-t-5 controls" id="category-level-'.$request->level.'-group">
                        <select class="form-control category_select" name="child_cat['.$request->level.']" id="child_cat_'.$request->level.'" onchange="myFunction('.$request->level.')">
                        <option value="">Select Category</option>';
            foreach($categories['CategoryArray']['Category'] as $category)
            {
                if ($request->category_id != $category['CategoryID']){
                    $output .= '<option value="'.$category['CategoryID'].'/'.$category['CategoryName'].'">'.$category['CategoryName'].'</option>';
                }
            }
            $output .= '</select></div>';
            return response()->json(['data' => 1,"content" => $output, 'lavel' => $request->level - 1]);
        }else {

            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:' . $request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategorySpecifics',
                'X-EBAY-API-IAF-TOKEN:' . $token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                              <WarningLevel>High</WarningLevel>
                              <CategorySpecific>
                                   <!--Enter the CategoryID for which you want the Specifics-->
                                <CategoryID>' . $request->category_id . '</CategoryID>
                              </CategorySpecific>
                            </GetCategorySpecificsRequest>';

            $item_specifics = $this->curl($url, $headers, $body, 'POST');
            $item_specifics = simplexml_load_string($item_specifics);
            $item_specifics = json_decode(json_encode($item_specifics), true);

//                if(isset($item_specifics['Recommendations']['NameRecommendation'])){
//
//                    foreach($item_specifics['Recommendations']['NameRecommendation'] as $item_specific){
//                        if (isset($item_specific['ValueRecommendation'])){
//                            foreach ($item_specific['ValueRecommendation'] as $recommendation){
//
//                                echo $recommendation['Value'].'*';
//                            }
//                        }else{
//                            echo 'ValueRecommendation';
//                        }
//
//                    }
//
//                }else{
//                    echo 'recommendation';
//                }
//                exit();



            //return $item_specifics['Recommendations']['NameRecommendation']['ValidationRules']['UsageConstraint'];

            //        get store data starts
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetStore',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                        <GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>

                        </GetStoreRequest>';
            try{
                $shop_categories = $this->curl($url,$headers,$body,'POST');
                $shop_categories =simplexml_load_string($shop_categories);
                $shop_categories = json_decode(json_encode($shop_categories),true);

//            $categories = $categories['CategoryArray']['Category'][0];

//                    return $shop_categories['Store']['CustomCategories']['CustomCategory'][0]['CategoryID'];
//                    exit();

            }catch (Exception $exception){
                echo $exception;
            }
//        get store data ends

//                get condition data start
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$request->category_id.'</CategoryID>
                         <FeatureID>ConditionValues</FeatureID>
                        </GetCategoryFeaturesRequest>';
            try{
                $conditions = $this->curl($url,$headers,$body,'POST');
                $conditions =simplexml_load_string($conditions);
                $conditions = json_decode(json_encode($conditions),true);



            }catch (Exception $exception){
                echo $exception;
            }
//                  get condition ends

            //                get condition data start
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$request->category_id.'</CategoryID>
                         <FeatureID>ConditionValues</FeatureID>
                        </GetCategoryFeaturesRequest>';
            try{
                $conditions = $this->curl($url,$headers,$body,'POST');
                $conditions =simplexml_load_string($conditions);
                $conditions = json_decode(json_encode($conditions),true);


//            $categories = $categories['CategoryArray']['Category'][0];

//                    return $shop_categories['Store']['CustomCategories']['CustomCategory'][0]['CategoryID'];
//                    exit();

            }catch (Exception $exception){
                echo $exception;
            }
//                  get condition ends

            $variant_view = view('ebay.item_specifics',compact('item_specifics','shop_categories','conditions'));
            echo $variant_view;
        }
    }
    public function getSubCategory(Request $request){
        $result = EbayMasterProduct::with(['variationProducts'])->find(1);
        $account_result = EbayAccount::find($request->account_id);
        $token = $this->ebayAccessToken($account_result->refresh_token);
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$request->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategories',
            'X-EBAY-API-IAF-TOKEN:'.$token,
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                        <CategoryParent>'.$request->category_id.'</CategoryParent>
                      <CategorySiteID>'.$request->site_id.'</CategorySiteID>
                      <DetailLevel>ReturnAll</DetailLevel>
                      <LevelLimit>'.$request->level.'</LevelLimit>
                    </GetCategoriesRequest>';

        $categories = $this->curl($url,$headers,$body,'POST');
        $categories =simplexml_load_string($categories);
        $categories = json_decode(json_encode($categories),true);


        if ($categories['CategoryCount'] !=1){
            $output = '<div class="col-md-3 empty-div"></div><div class="col-md-9 m-t-5 controls" id="category2-level-'.$request->level.'-group">
                        <select class="form-control category2_select" name="child_cat2['.$request->level.']" id="child_cat2_'.$request->level.'" onchange="myFunction2('.$request->level.')">
                        <option value="">Select Category</option>';
            foreach($categories['CategoryArray']['Category'] as $category)
            {
                if ($request->category_id != $category['CategoryID']){
                    $output .= '<option value="'.$category['CategoryID'].'/'.$category['CategoryName'].'">'.$category['CategoryName'].'</option>';
                }
            }
            $output .= '</select></div>';
            return response()->json(['data' => 1,"content" => $output, 'lavel' => $request->level - 1]);
        }else {
            return $categories['CategoryCount'];
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:' . $request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategorySpecifics',
                'X-EBAY-API-IAF-TOKEN:' . $token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                              <WarningLevel>High</WarningLevel>
                              <CategorySpecific>
                                   <!--Enter the CategoryID for which you want the Specifics-->
                                <CategoryID>' . $request->category_id . '</CategoryID>
                              </CategorySpecific>
                            </GetCategorySpecificsRequest>';

            $item_specifics = $this->curl($url, $headers, $body, 'POST');
            $item_specifics = simplexml_load_string($item_specifics);
            $item_specifics = json_decode(json_encode($item_specifics), true);

//                if(isset($item_specifics['Recommendations']['NameRecommendation'])){
//
//                    foreach($item_specifics['Recommendations']['NameRecommendation'] as $item_specific){
//                        if (isset($item_specific['ValueRecommendation'])){
//                            foreach ($item_specific['ValueRecommendation'] as $recommendation){
//
//                                echo $recommendation['Value'].'*';
//                            }
//                        }else{
//                            echo 'ValueRecommendation';
//                        }
//
//                    }
//
//                }else{
//                    echo 'recommendation';
//                }
//                exit();



            //return $item_specifics['Recommendations']['NameRecommendation']['ValidationRules']['UsageConstraint'];

            //        get store data starts
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetStore',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                        <GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>

                        </GetStoreRequest>';
            try{
                $shop_categories = $this->curl($url,$headers,$body,'POST');
                $shop_categories =simplexml_load_string($shop_categories);
                $shop_categories = json_decode(json_encode($shop_categories),true);

//            $categories = $categories['CategoryArray']['Category'][0];

//                    return $shop_categories['Store']['CustomCategories']['CustomCategory'][0]['CategoryID'];
//                    exit();

            }catch (Exception $exception){
                echo $exception;
            }
//        get store data ends

//                get condition data start
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$request->category_id.'</CategoryID>
                         <FeatureID>ConditionValues</FeatureID>
                        </GetCategoryFeaturesRequest>';
            try{
                $conditions = $this->curl($url,$headers,$body,'POST');
                $conditions =simplexml_load_string($conditions);
                $conditions = json_decode(json_encode($conditions),true);



            }catch (Exception $exception){
                echo $exception;
            }
//                  get condition ends

            //                get condition data start
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$request->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];

            $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$request->category_id.'</CategoryID>
                         <FeatureID>ConditionValues</FeatureID>
                        </GetCategoryFeaturesRequest>';
            try{
                $conditions = $this->curl($url,$headers,$body,'POST');
                $conditions =simplexml_load_string($conditions);
                $conditions = json_decode(json_encode($conditions),true);


//            $categories = $categories['CategoryArray']['Category'][0];

//                    return $shop_categories['Store']['CustomCategories']['CustomCategory'][0]['CategoryID'];
//                    exit();

            }catch (Exception $exception){
                echo $exception;
            }
//                  get condition ends

//            $variant_view = view('ebay.item_specifics',compact('item_specifics','shop_categories','conditions'));
//            echo $variant_view;
        }
    }

    public function curl($url,$header,$body,$method){
        $url = $url;
        $header = $header;
        $body = $body;
        $method = $method;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $header
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }

    public function storeItem(){
        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:3',
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:AddFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),

        ];
        $new_description =  '
        <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Tani-Logics Uk eBay Listing Template</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous" />
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://topbrandoutlet.co.uk/MaxKhan/css/style.css" />
        <link rel="stylesheet" type="text/css" href="https://topbrandoutlet.co.uk/ebay/css/new-style.css" />
    </head>
    <body>
        <div class="header-container">
            <div class="header-top">
                <div class="container" style="color: #fff;">
                    Welcome to Our Official eBay Store
                    <ul class="menu">
                        <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/About-Us.html">About Us</a></li>
                        <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Size-Guide.html">Size Guides</a></li>
                        <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/FAQ.html">FAQ</a></li>
                        <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Returns.html">Returns &amp; Exchanges</a></li>
                        <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Combine-Postage.html">Postage &amp; Combine Postage</a></li>
                    </ul>
                </div>
            </div>
            <div class="header-content">
                <div class="container">
                    <a class="logo-content" href="https://www.ebaystores.co.uk/topbrandoutletltd"> <img src="https://www.topbrandoutlet.co.uk/wp-content/uploads/2019/10/topbrandoutlet-logo.gif" alt="" /></a>
                    <!--Logo Link-->
                    <div class="header-right">
                        <div class="top-left">
                            <a href="https://www.ebaystores.co.uk/topbrandoutletltd"><i class="fas fa-home"></i>Home</a>
                            <a href="https://contact.ebay.co.uk/ws/eBayISAPI.dll?FindAnswers&amp;requested=topbrandoutlet-ltd"><i class="far fa-question-circle"></i>Help</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="main-header">
                    <div class="container">
                        <div id="topcat">
                            <nav>
                                <label id="main-menu" class="toggle" for="drop">Our Menu</label> <input id="drop" type="checkbox" />
                                <ul class="menu">
                                    <li><a href="https://www.ebaystores.co.uk/topbrandoutletltd">Home</a></li>
                                    <li>
                                        <!-- First Tier Drop Down -->
                                        <label class="toggle" for="drop-1">Men\'s</label> <a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Mens-/_i.html?_fsub=24379169016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Men\'s</a>
                                        <input id="drop-1" type="checkbox" />
                                        <ul class="drp">
                                            <li>
                                                <!-- 2nd Tier Drop Down -->
                                                <label class="toggle" for="drop-2">Men\'s</label>
                                                <a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Mens-Clothings-/_i.html?_fsub=21437730016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Mens Clothing</a>
                                                <input id="drop-2" type="checkbox" />
                                                <ul class="drp">
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/T-Shirt-/_i.html?_fsub=28058911016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">T Shirts &amp; Shirts</a></li>
                                                    <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Jeans-/_i.html?_fsub=24344276016&amp;_lns=1&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Jeans</a></li>
                                                    <li>
                                                        <a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Hoodie-Sweatshirts-/_i.html?_fsub=24344307016&amp;_lns=1&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">
                                                            Hoodie &amp; Sweatshirts
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Jackets-Coats-/_i.html?_fsub=27799810016&amp;_lns=1&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Jackets &amp; Coats</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <!-- 2nd Tier Drop Down -->
                                                <label class="toggle" for="drop-2">Men\'s</label>
                                                <a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Mens-Accessories-/_i.html?_fsub=21437729016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Mens Accessories</a>
                                                <input id="drop-2" type="checkbox" />
                                                <ul class="drp">
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Underwear-Socks-/_i.html?_fsub=28068960016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Boxer Shorts</a></li>
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Belts-/_i.html?_fsub=28553819016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Belts</a></li>
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Bags-/_i.html?_fsub=28143743016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Bags</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <!-- First Tier Drop Down -->
                                        <label class="toggle" for="drop-1">Women\'s</label>
                                        <a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Womens-/_i.html?_fsub=24379170016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Women\'s</a> <input id="drop-1" type="checkbox" />
                                        <ul class="drp">
                                            <li>
                                                <!-- 2nd Tier Drop Down -->
                                                <label class="toggle" for="drop-2">Women\'s</label>
                                                <a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Womens-Clothings-/_i.html?_fsub=21437732016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Womens Clothings</a>
                                                <input id="drop-2" type="checkbox" />
                                                <ul class="drp">
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/T-Shirt-Shirts-/_i.html?_fsub=29135225016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">T Shirts &amp; Shirts</a></li>
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Jackets-Coats-/_i.html?_fsub=27799813016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Jackets &amp; Coats</a></li>
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Jeans-/_i.html?_fsub=27799818016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Jeans &amp; Trousers</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <!-- 2nd Tier Drop Down -->
                                                <label class="toggle" for="drop-2">Women\'s</label>
                                                <a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Womens-Accessories-/_i.html?_fsub=21437731016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Womens Accessories</a>
                                                <input id="drop-2" type="checkbox" />
                                                <ul class="drp">
                                                    <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Bags-/_i.html?_fsub=28553822016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Bags</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <!-- Two Tier Drop Down -->
                                        <label class="toggle" for="drop-2">All Brands</label>
                                        <a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/All-Brands-/_i.html?_fsub=21437733016&amp;_lns=1&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Shop By Brands</a>
                                        <input id="drop-2" type="checkbox" />
                                        <ul class="drp">
                                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Diesel-/_i.html?_fsub=21437734016&amp;_lns=1&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Diesel</a></li>
                                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Gant-/_i.html?_fsub=28483612016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Gant</a></li>
                                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Kenzo-/_i.html?_fsub=28483613016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Kenzo</a></li>
                                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Farah-/_i.html?_fsub=24379158016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Farah</a></li>
                                            <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Adidas-/_i.html?_fsub=29127278016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322">Adidas</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/_i.html?_dmd=2&amp;_sid=1696178586&amp;_sop=10">New Arrivals</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Second Promotion-->
        <div class="promotions-sec" style="margin-top: 20px;">
            <div class="container">
                <div class="row">
                    <div id="box1" class="sec-box col-md-4">
                        <div class="secbox-left"><i class="fas fa-envelope"></i></div>
                        <div class="secbox-right">
                            <p class="headingp">
                                <a
                                    href="https://my.ebay.co.uk/ws/eBayISAPI.dll?AcceptSavedSeller&amp;nlchxbox=selectedMailingList_5069746&amp;Signup=Sign+Up&amp;sellerid=topbrandoutlet-ltd&amp;AcceptSavedSeller="
                                    target="_blank"
                                    rel="noopener"
                                >
                                    Subscribe to Newsletter
                                </a>
                            </p>
                            <p>Style , News &amp; an Exclusive Offers</p>
                        </div>
                    </div>
                    <div id="box2" class="sec-box col-md-4">
                        <div class="secbox-left"><i class="fas fa-star"></i></div>
                        <div class="secbox-right">
                            <p class="headingp">
                                <a href="https://my.ebay.co.uk/ws/eBayISAPI.dll?AcceptSavedSeller&amp;nlchxbox=selectedMailingList_5069746&amp;Signup=Sign+Up&amp;sellerid=topbrandoutlet-ltd&amp;AcceptSavedSeller=">
                                    Add Seller to Favorite\'s List
                                </a>
                            </p>
                            <p>Please add us to your Favorite seller</p>
                        </div>
                    </div>
                    <div id="box3" class="sec-box col-md-4">
                        <div class="secbox-left"><i class="fas fa-smile"></i></div>
                        <div class="secbox-right">
                            <p class="headingp"><a href="https://feedback.ebay.co.uk/ws/eBayISAPI.dll?ViewFeedback2&amp;userid=topbrandoutlet-ltd&amp;ftab=AllFeedback">Our Feedback</a></p>
                            <p>We strive for excellence</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container">
                <div class="inner-row">
                    <div class="col-md-12 right-content">
                        <div class="panel-big-1 border-0">
                            <div class="right-content-1">
                                <div class="item-container">
                                    <!-- Start product-view-name-sku -->
                                    <div class="product-view-name-sku">
                                        <!-- start product name -->
                                        <h2 class="product-view-name">session(\'access_token\')</h2>
                                        <!-- end product name -->
                                    </div>
                                    <!-- End product-view-name-sku -->
                                </div>
                            </div>
                            <div class="left-content">
                                <div class="panel panel-default img-gallery">
                                    <div class="image-gallery">
                                        <div class="slider clearfix">
                                            <!--Image Gallery Start-->
                                            <div class="img-details gallery-main-thum"><img src="[[product_main_image_url]]" /></div>
                                            <div class="hallery-thum">
                                                <input id="id2" name="slide_switch" type="radio" value="[[img_url_1]]" /> <label for="id2"> <img src="[[img_url_1]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_1]]" /></div>
                                                <input id="id3" name="slide_switch" type="radio" value="[[img_url_2]]" /> <label for="id3"> <img src="[[img_url_2]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_2]]" /></div>
                                                <input id="id4" name="slide_switch" type="radio" value="[[img_url_3]]" /> <label for="id4"> <img src="[[img_url_3]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_3]]" /></div>
                                                <input id="id5" name="slide_switch" type="radio" value="[[img_url_4]]" /> <label for="id5"> <img src="[[img_url_4]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_4]]" /></div>
                                                <input id="id6" name="slide_switch" type="radio" value="[[img_url_5]]" /> <label for="id6"> <img src="[[img_url_5]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_5]]" /></div>
                                                <input id="id7" name="slide_switch" type="radio" value="[[img_url_6]]" /> <label for="id7"> <img src="[[img_url_6]]" width="100" /> </label>
                                                <div class="img-details"><img src="[[img_url_6]]" /></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Start Product Box Area -->
                                <div class="product-box-holder mt-5 product-box-single">
                                    <div class="container-box">
                                        <div class="panel-title text-center">
                                            <h1>Featured products</h1>
                                        </div>
                                        <div class="row">
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254134682692" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/1.jpg" align="" /></a>
                                            </div>
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254578703254" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/2.jpg" align="" /> </a>
                                            </div>
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254379314878" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/3.jpg" align="" /> </a>
                                            </div>
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254595910764" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/4.jpg" align="" /> </a>
                                            </div>
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254331498898" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/5.jpg" align="" /> </a>
                                            </div>
                                            <div class="product-box mb-5 col-md-4 col-sm-6 col-xs-12">
                                                <a class="display-block" href="https://www.ebay.co.uk/itm/254592679492" target="_blank" rel="noopener"> <img src="https://www.topbrandoutlet.co.uk/featured_products/tbo/6.jpg" align="" /> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Product box area -->
                            </div>
                        </div>
                        <div class="right-content-2">
                            <!--Short Description Body-Start---->
                            <div class="item-container">
                                <div id="desc" class="text-section">
                                    <h1>DESCRIPTION:</h1>
                                    <br />
                                    [[product_content]]
                                </div>
                                <div class="price-box">
                                    <div class="price">
                                        <p>
                                            <b><span style="color: #ff0010; font-size: large;">Fitting Tips from Seller</span></b>
                                        </p>
                                        <div>
                                            If you are not certain about your sizes. Please request for the actual measurement for the item by contacting us. This will allows us to avoid any disappointing situation of returning the item.
                                        </div>
                                        <div>
                                            <span style="color: #ff0010; font-size: large;"><b></b></span>
                                        </div>
                                        <div>
                                            <span style="color: #ff0010; font-size: large;"><b>Disclaimer</b></span>
                                        </div>
                                        <div>
                                            Due to the quality differentiation between different monitors, the picture may not reflect the actual colour of the item. Please pay attention to the measurements or request if not available, as
                                            it may vary depending on the model or manufacturer. Measurements are taken when laid flat and it might be with + - 1 cm error.
                                        </div>
                                        <p>&nbsp;</p>
                                    </div>
                                </div>
                            </div>
                            <!--Promo Text Body-Start---->
                            <div class="item-container">
                                <div id="list-promo" class="text-section">
                                    <!--Top Promo Icons/Text-->
                                    <div class="inn-container">
                                        <div class="box-list">
                                            <div class="box-promo">
                                                <i class="fas fa-shipping-fast"></i>
                                                <p>
                                                    <strong>FAST SHIPPING</strong><br />
                                                    ON TIME &amp; SECURE
                                                </p>
                                            </div>
                                        </div>
                                        <div class="box-list">
                                            <div class="box-promo">
                                                <i class="fas fa-credit-card"></i>
                                                <p>
                                                    <strong> 30 DAYS RETURN</strong><br />
                                                    MONEYBACK GUARANTEE
                                                </p>
                                            </div>
                                        </div>
                                        <div class="box-list">
                                            <div class="box-promo">
                                                <i class="fas fa-award"></i>
                                                <p>
                                                    <strong>AUTHENTICITY GUARANTEE</strong><br />
                                                    QUALITY ITEMS
                                                </p>
                                            </div>
                                        </div>
                                        <div class="box-list">
                                            <div class="box-promo">
                                                <i class="fas fa-user-shield"></i>
                                                <p>
                                                    <strong>ONLINE SUPPORT</strong><br />
                                                    QUICK &amp; RELIABLE
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tabs">
                        <input id="tab1" checked="checked" name="tabs" type="radio" /> <label for="tab1"> Delivery<!--------- Tab 1 Name ---------> </label> <input id="tab2" name="tabs" type="radio" />
                        <label for="tab2"> Returns<!--------- Tab 2 Name ---------> </label> <input id="tab3" name="tabs" type="radio" /> <label for="tab3"> Payments<!--------- Tab 3 Name ---------> </label>
                        <input id="tab4" name="tabs" type="radio" /> <label for="tab4"> About Us<!--------- Tab 4 Name ---------> </label>
                        <div id="tab-content1" class="tab-content">
                            <!---------Tab 1 Content--------->
                            <p>
                                All eligible items are dispatched through Royal Mail within 24 hours of receiving cleared funds. Items are carefully &amp; professionally wrapped, so you receive your item in perfect condition. Items bought
                                over the weekends and Bank Holidays will be dispatched on the 1st postal day.
                            </p>
                            <p>
                                Items should be received within 2-3 working days. In the unlikely event that you do not receive your item within this time, please allow 10 working days for delivery before contacting us, as the Royal Mail do
                                not consider an item lost before that time (15 days for international).
                            </p>
                        </div>
                        <div id="tab-content2" class="tab-content">
                            <!---------Tab 2 Content--------->
                            <p>In the event of Returns, Simply send it back to us within 14 days of receiving it in its original packaging, unused and unworn condition and we will issue a full refund once we receive the item(s).</p>
                            <p>However, please contact us with the details if an exchange is needed and we will be more than happy to do so.</p>
                        </div>
                        <div id="tab-content3" class="tab-content">
                            <!---------Tab 3 Content--------->
                            <p>We currently accept the following payment methods</p>
                            <br />
                            <p>Paypal</p>
                            <p>We do not accept paper cheques or postal orders.</p>
                            <p>Payment must be received within 7 days.</p>
                            <p>To ensure your purchase is protected by the eBay Protection Scheme it will only be delivered to your registered PayPal/ eBay address.</p>
                        </div>
                        <div id="tab-content4" class="tab-content">
                            <!---------Tab 4 Content--------->
                            <p>
                                Our eBay store is a small family-run business, where we still put our customers first. We are always looking for the best suppliers, in order to provide our customers with the highest quality items and best
                                deals to be found on the internet. As much as our customers love our items and service, we\'re always open to suggestions on how to improve things: if there\'s something you think we could be doing better, then
                                don\'t hesitate to let us know
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <!--Footer Start-->
        <section class="footer">
            <div class="container">
                <div class="inner-row">
                    <div id="fbox-1" class="fbox quick-link">
                        <h4>Store Categories</h4>
                        <!--Footer Tab-1-->
                        <ul>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Mens-/_i.html?_fsub=24379169016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322" target="_blank" rel="noopener">Men\'s</a></li>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Womens-/_i.html?_fsub=24379170016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322" target="_blank" rel="noopener">Women\'s</a></li>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Diesel-/_i.html?_fsub=21437734016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322" target="_blank" rel="noopener">Diesel</a></li>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Gant-/_i.html?_fsub=28483612016&amp;_sid=1696178586&amp;_trksid=p4634.c0.m322" target="_blank" rel="noopener">Gant</a></li>
                        </ul>
                    </div>
                    <div id="fbox-2" class="fbox quick-link">
                        <h4>Information Links</h4>
                        <!--Footer Tab-4-->
                        <ul>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/_i.html?_dmd=2&amp;_sid=1696178586&amp;_sop=10" target="_blank" rel="noopener">New Arrivals</a></li>
                            <li><a href="https://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/_i.html?rt=nc&amp;_dmd=2&amp;_sid=1696178586&amp;_trksid=p4634.c0.m14&amp;_sop=1&amp;_sc=1" target="_blank" rel="noopener">Ending Soon</a></li>
                            <li><a href="https://feedback.ebay.co.uk/ws/eBayISAPI.dll?ViewFeedback2&amp;userid=topbrandoutlet-ltd&amp;ftab=AllFeedback&amp;myworld=true&amp;rt=nc" target="_blank" rel="noopener">Feedback</a></li>
                            <li><a href="http://www.ebaystores.co.uk/Top-Brand-Outlet-Ltd/Returns.html" target="_blank" rel="noopener">Returns</a></li>
                        </ul>
                    </div>
                    <div id="fbox-3" class="fbox footer-signup">
                        <h4>Newsletter</h4>
                        <!--Footer Tab-2-->
                        <p>Sign up to our newsletter for special deals</p>
                        <a title="SUBMIT" href="https://my.ebay.co.uk/ws/eBayISAPI.dll?AcceptSavedSeller&amp;sellerid=topbrandoutlet-ltd&amp;ssPageName=STRK:MEFS:ADDSTR&amp;rt=nc" target="_blank" rel="noopener">Subscribe Newsletter</a>
                        <!--Newsletter Link-->
                    </div>
                    <div id="fbox-4" class="fbox">
                        <h4>We Accept</h4>
                        <!--Footer Tab-3-->
                        <p>
                            <img class="img-responsive" src="https://topbrandoutlet.co.uk/MaxKhan/images/payment.png" />
                            <!--Payment Banner-Footer-->
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="copyrights">
                <p class="text-center">Top Brand Outlet Copyright © 2020. All rights reserved.</p>
            </div>
        </section>
    </body>
</html>';
        $value = '<?xml version="1.0" encoding="utf-8"?>
<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<Item>
		<Country>GB</Country>
		<Currency>GBP</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>GTC</ListingDuration>
		<ListingType>FixedPriceItem</ListingType>
		<PaymentMethods>PayPal</PaymentMethods>
		<!--Enter your Paypal email address-->
		<PayPalEmailAddress>Maxkhaninc@gmail.com</PayPalEmailAddress>
		<PostalCode>DA11 9NL</PostalCode>
		<PrimaryCategory>
			<CategoryID>37565</CategoryID>
		</PrimaryCategory>
		<Title>New Ralph Lauren Polo shirt Pink Black Blue Yellow</Title>
		<Description>'.'<![CDATA['.$new_description.']]>'.'</Description>
		<PictureDetails>
			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
		</PictureDetails>

		<ItemSpecifics>
			<NameValueList>
				<Name>Occasion</Name>
				<Value>Casual</Value>
			</NameValueList>
			<NameValueList>
				<Name>Brand</Name>
				<Value>Ralph Lauren</Value>
			</NameValueList>
			<NameValueList>
				<Name>Style</Name>
				<Value>Polo Shirt</Value>
			</NameValueList>
			<NameValueList>
				<Name>Sleeve Style</Name>
				<Value>Short Sleeve</Value>
			</NameValueList>
		</ItemSpecifics>
		<Variations>
			<VariationSpecificsSet>
				<NameValueList>
					<Name>Size</Name>
					<Value>XS</Value>
					<Value>S</Value>
					<Value>M</Value>
					<Value>L</Value>
					<Value>XL</Value>
				</NameValueList>
				<NameValueList>
					<Name>Color</Name>
					<Value>Black</Value>
					<Value>Pink</Value>
					<Value>Yellow</Value>
					<Value>Blue</Value>
				</NameValueList>
			</VariationSpecificsSet>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Pnk_S</SKU>
				<StartPrice>17.99</StartPrice>
				<Quantity>4</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Pink</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Pnk_M</SKU>
				<StartPrice>17.99</StartPrice>
				<Quantity>8</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Pink</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blk_S</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Black</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blk_M</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Black</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blu_S</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Blue</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blu_M</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Blue</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Pictures>
				<VariationSpecificName>Color</VariationSpecificName>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Pink</VariationSpecificValue>
					<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
					<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sb2.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Blue</VariationSpecificValue>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sb2.JPG</PictureURL>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sb3.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Black</VariationSpecificValue>
					<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Yellow</VariationSpecificValue>
					<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d89f_1_sbl.JPG</PictureURL>
				</VariationSpecificPictureSet>
			</Pictures>
		</Variations>
		  <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
		     instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
         For help, see the API Reference for Business Policies:
		     https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->
       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>135899715023</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>91633586023</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>80764845023</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>

	</Item>
</AddFixedPriceItemRequest>';
        // $value = json_encode($value);
//       <SellerProfiles>
//      		<SellerShippingProfile>
//       			 <ShippingProfileID>117257590023</ShippingProfileID>
//    		  	</SellerShippingProfile>
//      		<SellerReturnProfile>
//        			<ReturnProfileID>117257588023</ReturnProfileID>
//      		</SellerReturnProfile>
//      		<SellerPaymentProfile>
//        			<PaymentProfileID>117257589023</PaymentProfileID>
//      		</SellerPaymentProfile>
//       </SellerProfiles>
        // $body = $value;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $value,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            dd( $response);
        }
    }

    public function createEbayProduct(Request $request){
//        echo "<pre>";

        $pictures = '';
        $item_specifics = '';
        $variations ='';
        $attribute = '';
        foreach ($request->image as $image){

            $pictures .='<PictureURL>'.$image.'</PictureURL>';
        }
        if (isset($request->item_specific)){
            foreach ($request->item_specific as $key=>$item_specific){
//            return gettype($key);
                //if ($item_specific !=null){
                $item_specifics .='<NameValueList>
				                    <Name>'.$key.'</Name>
				                    <Value>'.$item_specific.'</Value>
			                      </NameValueList>';
                //}

            }

            $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
        }

        //return $request->productVariation;
        foreach ($request->productVariation as $product_variation){
            $attribute = '';
            if (isset($product_variation['Size'])){
                $attribute .= '<NameValueList>
						<Name>Size</Name>
						<Value>'.$product_variation['Size'].'</Value>
					</NameValueList>';
            }

            if (isset($product_variation['Colour'])){
                $attribute .= '<NameValueList>
						<Name>Colour</Name>
						<Value>'.$product_variation['Colour'].'</Value>
					</NameValueList>';
            }
            if (isset($product_variation['Style'])){
                $attribute .= '<NameValueList>
						<Name>Style</Name>
						<Value>'.$product_variation['Style'].'</Value>
					</NameValueList>';
            }





            $variations .= '<Variation>
				<SKU>'.$product_variation['sku'].'</SKU>
				<StartPrice>'.$product_variation['start_price'].'</StartPrice>
				<Quantity>'.$product_variation['quantity'].'</Quantity>
				<VariationProductListingDetails>
                <EAN>'. $product_variation['ean'] .'</EAN>

                </VariationProductListingDetails>
				<VariationSpecifics>'
                .$attribute.'
				</VariationSpecifics>
			</Variation>';
        }
        //return $item_specifics;

        $body = '<?xml version="1.0" encoding="utf-8"?>
<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<Item>
		<Country>GB</Country>
		<Currency>GBP</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>GTC</ListingDuration>
		<ListingType>FixedPriceItem</ListingType>
		<PaymentMethods>PayPal</PaymentMethods>
		<!--Enter your Paypal email address-->
		<PayPalEmailAddress>Maxkhaninc@gmail.com</PayPalEmailAddress>
		<ConditionID>'.$request->condition.'</ConditionID>
		<PostalCode>DA11 9NL</PostalCode>
		<PrimaryCategory>
			<CategoryID>'.$request->last_cat_id.'</CategoryID>
		</PrimaryCategory>
		<Title>'.$request->name.'</Title>
		<Description>hello</Description>
		<PictureDetails>'. $pictures
//			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
            .'</PictureDetails>


			'.$item_specifics.'

		<Variations>
			<VariationSpecificsSet>
				<NameValueList>
					<Name>Size</Name>
					<Value>W23 L29</Value>
					<Value>W25 L30</Value>
				</NameValueList>
			</VariationSpecificsSet>
			'.$variations.'

		</Variations>
		  <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
		     instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
         For help, see the API Reference for Business Policies:
		     https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->
       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>135899715023</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>91633586023</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>80764845023</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>
	</Item>
</AddFixedPriceItemRequest>';

        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:0',
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:AddFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),

        ];
        $result = $this->curl($url,$headers,$body,'POST');
        $result =simplexml_load_string($result);
        $result = json_decode(json_encode($result),true);
        return $result;
    }

}
