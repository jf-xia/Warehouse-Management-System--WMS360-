<?php

namespace App\Http\Controllers;

use App\EbayAccount;
use App\EbayMasterProduct;
use App\EbayMigration;
use App\EbaySites;
use App\PaymentPolicy;
use App\ReturnPolicy;
use App\ShipmentPolicy;
use App\Traits\Ebay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\DeveloperAccount;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class EbayAccountSyncController extends Controller
{
    use Ebay;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function authorizeEbay($id,$type){

//        set_time_limit(5000);

//        return $response;
        $this->account_result = EbayAccount::with('developerAccount')->find($id);
        $this->ebay_access_token = $this->getEbayToken($id,$this->getEbaySessionKey($id));
        $this->syncReturnPolicy();
        $this->syncPaymentPolicy();
        $this->syncShipmentPolicy();
        if ($type == 'old'){
            $this->syncEbayItemId();
            return redirect('ebay-account-list')->with('success','account synced successfully');
        }elseif ($type == 'new'){

            return $this->getPageNumber($id);
        }

    }
    public function getPolicy($id){
        $return_policy = ReturnPolicy::where('account_id',$id)->get();
        $shipment_policy = ShipmentPolicy::where('account_id',$id)->get();
        $payment_policy = PaymentPolicy::where('account_id',$id)->get();
        return response()->json(['return_policy'=>$return_policy, 'shipment_policy' => $shipment_policy,'payment_policy'=> $payment_policy]);
    }
    public function campaignMigration($id){

        $account_result = EbayAccount::with('developerAccount','sites')->find($id);
//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($ebay_master_product->campaign_data));
//        exit();
        $clientID  = $account_result->developerAccount->client_id;
        $clientSecret  = $account_result->developerAccount->client_secret;

        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $account_result->refresh_token,
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
        $ebay_access_token =  $response['access_token'];
        $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign?campaign_status=RUNNING';
        $headers = [
            'Authorization:Bearer '.$ebay_access_token,
            'Accept:application/json',
            'Content-Type:application/json'
        ];

        $body = '';
        $result = $this->curl($url,$headers,$body,'GET');
        $result = \GuzzleHttp\json_decode($result);
        foreach ($result->campaigns as $campaign){

            $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/'.$campaign->campaignId.'/ad';
            $headers = [
                'Authorization:Bearer '.$ebay_access_token,
                'Accept:application/json',
                'Content-Type:application/json'
            ];

            $body = '';
            $campaign_result = $this->curl($url,$headers,$body,'GET');
            $campaign_result = \GuzzleHttp\json_decode($campaign_result);
//            Log::info(json_encode($campaign_result));
//            echo "<pre>";
//            print_r($campaign_result);
//            exit();
            foreach ($campaign_result->ads as $ad){
                $ebay_master_product = EbayMasterProduct::where('item_id',$ad->listingId)->get()->first();
                if ($ebay_master_product){
                    $sites = EbaySites::find($ebay_master_product->site_id);
//                        echo "<pre>";
//            print_r($sites->global_id);
//            exit();
                    $url = 'https://api.ebay.com/sell/recommendation/v1/find?filter=recommendationTypes:{AD}&offset=0&limit=25';
                    $headers = [
                        'Authorization:Bearer ' . $ebay_access_token,
                        'Accept:application/json',
                        'Content-Type:application/json',
                        'X-EBAY-C-MARKETPLACE-ID:'.$sites->global_id
                    ];

                    $body = '{
                    "listingIds": [
                        "' . $ad->listingId . '"
                     ]
                    }';
                    $campaign_suggested = $this->curl($url, $headers, $body, 'POST');
                    $campaign_suggested = \GuzzleHttp\json_decode($campaign_suggested);
//                                        echo "<pre>";
//            print_r($campaign_suggested->listingRecommendations[0]->marketing->ad->bidPercentages[1]->value);
//            exit();
                    $campaign_array = [
                        "campaignId" => $campaign->campaignId ?? '',
                        "adId" => $ad->adId ?? '',
                        "bidPercentage" => $ad->bidPercentage ?? 0.0,
                        "suggestedRate" => $campaign_suggested->listingRecommendations[0]->marketing->ad->bidPercentages[1]->value ?? ''
                    ];
                    EbayMasterProduct::where('item_id', $ad->listingId)->update(['campaign_data' => \Opis\Closure\serialize($campaign_array),'campaign_status' => 1]);
                }
            }


        }

//        echo "<pre>";
//        print_r($result);
//        exit();

    }
    public function syncReturnPolicy(){

        foreach ($this->account_result->sites as $site){
            $return_policy = ReturnPolicy::where('account_id',$this->account_result->id)->where('site_id',$site->id)->forceDelete();
        }
        foreach ($this->account_result->sites as $site){
            $url = 'https://api.ebay.com/sell/account/v1/return_policy?marketplace_id='.$site->global_id;
            $headers = [
                'Authorization:Bearer '.$this->ebay_access_token,
                'Accept:application/json',
                'Content-Type:application/json'
            ];

            $body = '';
            $return_policy = $this->curl($url,$headers,$body,'GET');
            $return_policy = \GuzzleHttp\json_decode($return_policy);

            foreach ($return_policy->returnPolicies as $returnPolicy){
//                ReturnPolicy::where('account_id',)

                    ReturnPolicy::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'return_id' => $returnPolicy->returnPolicyId,
                        'return_name' => $returnPolicy->name,'return_description' => isset($returnPolicy->description) ? $returnPolicy->description : '']);

            }


        }

    }

    public function getPageNumber($id){
        $account_result = EbayAccount::with('developerAccount','sites')->find($id);

        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$account_result->sites()->first()->id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetMyeBaySelling',
            'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <ActiveList>
                        <Sort>TimeLeft</Sort>
                        <Pagination>
                          <EntriesPerPage>30</EntriesPerPage>
                          <PageNumber>1</PageNumber>
                        </Pagination>
                      </ActiveList>
                    </GetMyeBaySellingRequest>';
        $item_details = $this->curl($url,$headers,$body,'POST');
        $item_details =simplexml_load_string($item_details);
        $item_details = json_decode(json_encode($item_details),true);
        if (!isset($item_details["ActiveList"]["PaginationResult"]["TotalNumberOfPages"])){
            return redirect('ebay-account-list')->with('success','account synced successfully');
        }
//        return $item_details;
        $page = $item_details["ActiveList"]["PaginationResult"]["TotalNumberOfPages"];
        $totalItem = $item_details["ActiveList"]["PaginationResult"]["TotalNumberOfEntries"];
        return response()->json(["pageNumber" => $page,"totalItem" => $totalItem]);
    }

    public function getItem($id,$page_number){

        $this->ebay_access_token= $this->getEbayToken($id,$this->getEbaySessionKey($id));
        $account_result = EbayAccount::with('developerAccount','sites')->find($id);
        $site_id = $account_result->sites()->first()->id;
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetMyeBaySelling',
            'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <ActiveList>
                        <Sort>TimeLeft</Sort>
                        <Pagination>
                          <EntriesPerPage>30</EntriesPerPage>
                          <PageNumber>'.$page_number.'</PageNumber>
                        </Pagination>
                      </ActiveList>
                    </GetMyeBaySellingRequest>';
        $item_details = $this->curl($url,$headers,$body,'POST');
        $item_details =simplexml_load_string($item_details);
        $item_details = json_decode(json_encode($item_details),true);

        if (!isset($item_details["ActiveList"]["ItemArray"]["Item"]["ItemID"]) && is_array($item_details["ActiveList"]["ItemArray"]["Item"])){
            foreach ($item_details["ActiveList"]["ItemArray"]["Item"] as $index => $item){

                if (isset($item["ItemID"])){
                    $existCatalogueItemId = EbayMigration::where('item_id',$item["ItemID"])->first();
                    if(!$existCatalogueItemId){
                        $item_category_details =$this->getItemDetails($item["ItemID"],$site_id);

                                                EbayMigration::create(['site_id' => $site_id,'account_id' => $account_result->id,'item_id' => $item["ItemID"],
                            'imgae' => $item_category_details["PictureDetails"]["GalleryURL"] ?? null,'title' => $item["Title"],'category_id'=>$item_category_details["Item"]["PrimaryCategory"]["CategoryID"] ?? null,
                            'category_name' => $item_category_details["Item"]["PrimaryCategory"]["CategoryName"] ?? null,
                            'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $page_number,'item_number' => $index,'condition_id' => $item_category_details["Item"]["ConditionID"] ?? null,'condition_name' => $item_category_details["Item"]["ConditionDisplayName"] ?? null]);
//                                    dd($item_category_details);
                    }
                }


            }
            return count($item_details["ActiveList"]["ItemArray"]["Item"]);
        }
        elseif(isset($item_details["ActiveList"]["ItemArray"]["Item"]["ItemID"])){
            $existCatalogueItemId = EbayMigration::where('item_id',$item_details["ActiveList"]["ItemArray"]["Item"]["ItemID"])->first();
            if(!$existCatalogueItemId){
                $item_category_details =$this->getItemDetails($item_details["ActiveList"]["ItemArray"]["Item"]["ItemID"],$site_id);
                EbayMigration::create(['site_id' => $site_id,'account_id' => $account_result->id,'item_id' => $item_details["ActiveList"]["ItemArray"]["Item"]["ItemID"],
                    'imgae' => $item_category_details["PictureDetails"]["GalleryURL"] ?? null,'title' => $item_details["ActiveList"]["ItemArray"]["Item"]["Title"],'category_id'=>$item_category_details["Item"]["PrimaryCategory"]["CategoryID"] ?? null,
                    'category_name' => $item_category_details["Item"]["PrimaryCategory"]["CategoryName"] ?? null,
                    'status' => 0, 'url' =>  $item_details["ActiveList"]["ItemArray"]["Item"]["ListingDetails"]["ViewItemURL"],'page_number' => $page_number,'item_number' => null,'condition_id' => $item_category_details["Item"]["ConditionID"] ?? null,'condition_name' => $item_category_details["Item"]["ConditionDisplayName"] ?? null]);
            }

            return 1;
        }

    }

    public function getItemDetails($item_id,$site_id){
        $ebay_find_result = EbayMigration::where('item_id',$item_id)->get()->first();
        if ($ebay_find_result == null){

            try{
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                    <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                        <ErrorLanguage>en_US</ErrorLanguage>
                                        <WarningLevel>High</WarningLevel>
                                        <!--Enter an ItemID-->
                                    <ItemID>'.$item_id.'</ItemID>
                                    </GetItemRequest>';
                $item_category_details = $this->curl($url,$headers,$body,'POST');
                $item_category_details =simplexml_load_string($item_category_details);
                $item_category_details = json_decode(json_encode($item_category_details),true);
                return $item_category_details;
//                                echo "<pre>";
//                                print_r($item_category_details);
//                                exit();
//                                $item["PictureDetails"]["GalleryURL"] ?? null
//                        EbayMigration::create(['site_id' => $site_id,'account_id' => $account_result->id,'item_id' => $item["ItemID"],
//                            'imgae' => $item_category_details["PictureDetails"]["GalleryURL"] ?? null,'title' => $item["Title"],'category_id'=>isset($item_category_details["Item"]["PrimaryCategory"]["CategoryID"]) ? $item_category_details["Item"]["PrimaryCategory"]["CategoryID"] : null,
//                            'category_name' => isset($item_category_details["Item"]["PrimaryCategory"]["CategoryName"]) ? $item_category_details["Item"]["PrimaryCategory"]["CategoryName"] : null,
//                            'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $page_number,'item_number' => $index,'condition_id' => isset($item_category_details["Item"]["ConditionID"]) ? $item_category_details["Item"]["ConditionID"] : null,'condition_name' => isset($item_category_details["Item"]["ConditionDisplayName"]) ? $item_category_details["Item"]["ConditionDisplayName"] : null]);
//                                    dd($item_category_details);

            }catch (Exception $ex){
                return $ex;
            }

        }
    }

    public function syncEbayItemId(){
        set_time_limit(5000);
        foreach ($this->account_result->sites as $site){

            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$site->id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetMyeBaySelling',
                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <ActiveList>
                        <Sort>TimeLeft</Sort>
                        <Pagination>
                          <EntriesPerPage>100</EntriesPerPage>
                          <PageNumber>1</PageNumber>
                        </Pagination>
                      </ActiveList>
                    </GetMyeBaySellingRequest>';
            $item_details = $this->curl($url,$headers,$body,'POST');
            $item_details =simplexml_load_string($item_details);
            $item_details = json_decode(json_encode($item_details),true);
            if (!isset($item_details["ActiveList"]["PaginationResult"]["TotalNumberOfPages"])){
                return redirect('ebay-account-list')->with('success','account synced successfully');
            }
            $page = $item_details["ActiveList"]["PaginationResult"]["TotalNumberOfPages"];


//            echo "<pre>";
//            print_r($item_details["ActiveList"]["ItemArray"]["Item"]);
//            exit();
            $ebay_migration_result = EbayMigration::orderBy('created_at','desc')->get()->first();

//            echo "<pre>";
//           print_r($ebay_migration_result);
//           exit();
            if ($ebay_migration_result != null){
                $counter = $ebay_migration_result->page_number;

            }else{
                $counter = 1;

            }

            while (true){
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$site->id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetMyeBaySelling',
                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <ActiveList>
                        <Sort>TimeLeft</Sort>
                        <Pagination>
                          <EntriesPerPage>100</EntriesPerPage>
                          <PageNumber>'.$counter.'</PageNumber>
                        </Pagination>
                      </ActiveList>
                    </GetMyeBaySellingRequest>';
                $item_details = $this->curl($url,$headers,$body,'POST');
                $item_details =simplexml_load_string($item_details);
                $item_details = json_decode(json_encode($item_details),true);
//                echo "<pre>";
//                print_r($item_details["ActiveList"]["ItemArray"]["Item"][1]);
//                echo $counter;
//                exit();
                foreach ($item_details["ActiveList"]["ItemArray"]["Item"] as $index => $item){
                    $existCatalogueItemId = EbayMasterProduct::where('item_id',$item["ItemID"])->first();
                    if(!$existCatalogueItemId){
                        $ebay_find_result = EbayMigration::where('item_id',$item["ItemID"])->get()->first();
                        if ($ebay_find_result == null){

                            try{
                                $url = 'https://api.ebay.com/ws/api.dll';
                                $headers = [
                                    'X-EBAY-API-SITEID:'.$site->id,
                                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                    'X-EBAY-API-CALL-NAME:GetItem',
                                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
                                ];
                                $body = '<?xml version="1.0" encoding="utf-8"?>
                                    <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                        <ErrorLanguage>en_US</ErrorLanguage>
                                        <WarningLevel>High</WarningLevel>
                                        <!--Enter an ItemID-->
                                    <ItemID>'.$item["ItemID"].'</ItemID>
                                    </GetItemRequest>';
                                $item_category_details = $this->curl($url,$headers,$body,'POST');
                                $item_category_details =simplexml_load_string($item_category_details);
                                $item_category_details = json_decode(json_encode($item_category_details),true);

//                                echo "<pre>";
//                                print_r($item_category_details);
//                                exit();
//                                $item["PictureDetails"]["GalleryURL"] ?? null
                                EbayMigration::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'item_id' => $item["ItemID"],
                                    'imgae' => $item_category_details["PictureDetails"]["GalleryURL"] ?? null,'title' => $item["Title"],'category_id'=>isset($item_category_details["Item"]["PrimaryCategory"]["CategoryID"]) ? $item_category_details["Item"]["PrimaryCategory"]["CategoryID"] : null,
                                    'category_name' => isset($item_category_details["Item"]["PrimaryCategory"]["CategoryName"]) ? $item_category_details["Item"]["PrimaryCategory"]["CategoryName"] : null,
                                    'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $counter,'item_number' => $index,'condition_id' => isset($item_category_details["Item"]["ConditionID"]) ? $item_category_details["Item"]["ConditionID"] : null,'condition_name' => isset($item_category_details["Item"]["ConditionDisplayName"]) ? $item_category_details["Item"]["ConditionDisplayName"] : null]);
//                                    dd($item_category_details);

                            }catch (Exception $ex){

                            }

                        }
                    }

                }
                $counter++;

                if ($page < $counter){
                    break;
                }
            }

        }
    }
    public function setDefaultPolicy(Request $request){
        $policy = array();
        $policy['return_policy'] = $request->return_policy;
        $policy['shipment_policy'] = $request->shipment_policy;
        $policy['payment_policy'] = $request->payment_policy;
        $ebay_account = EbayAccount::where(['id'=> $request->account_id])->update(['default_policy'=>\Opis\Closure\serialize($policy)]);

        return $ebay_account;

    }
    public function syncPaymentPolicy(){

        foreach ($this->account_result->sites as $site){
            $payment_policy = PaymentPolicy::where('account_id',$this->account_result->id)->where('site_id',$site->id)->forceDelete();
        }

        foreach ($this->account_result->sites as $site){

            $url = 'https://api.ebay.com/sell/account/v1/payment_policy?marketplace_id='.$site->global_id;
            $headers = [
                'Authorization:Bearer '.$this->ebay_access_token,
                'Accept:application/json',
                'Content-Type:application/json'
            ];

            $body = '';
            $payment_policy = $this->curl($url,$headers,$body,'GET');
            $payment_policy = \GuzzleHttp\json_decode($payment_policy);

            foreach ($payment_policy->paymentPolicies as $paymentPolicy){

                    PaymentPolicy::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'payment_id' => $paymentPolicy->paymentPolicyId,
                        'payment_name' => $paymentPolicy->name,'payment_description' => isset($paymentPolicy->description) ? $paymentPolicy->description : '']);

            }


        }

    }

    public function syncShipmentPolicy(){

        foreach ($this->account_result->sites as $site){
            $shipment_policy = ShipmentPolicy::where('account_id',$this->account_result->id)->where('site_id',$site->id)->forceDelete();
        }

        foreach ($this->account_result->sites as $site){

            $url = 'https://api.ebay.com/sell/account/v1/fulfillment_policy?marketplace_id='.$site->global_id;
            $headers = [
                'Authorization:Bearer '.$this->ebay_access_token,
                'Accept:application/json',
                'Content-Type:application/json'
            ];

            $body = '';
            $shipment_policy = $this->curl($url,$headers,$body,'GET');
            $shipment_policy = \GuzzleHttp\json_decode($shipment_policy);

            foreach ($shipment_policy->fulfillmentPolicies as $shipmentPolicy){

                    ShipmentPolicy::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'shipment_id' => $shipmentPolicy->fulfillmentPolicyId,
                        'shipment_name' => $shipmentPolicy->name,'shipment_description' => isset($shipmentPolicy->description) ? $shipmentPolicy->description : '']);

            }


        }

    }


}
