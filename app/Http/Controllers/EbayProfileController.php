<?php

namespace App\Http\Controllers;

use App\Country;
use App\EbayAccount;
use App\EbayMasterProduct;
use App\EbayPaypalAccount;
use App\EbayProfile;
use App\EbaySites;
use App\EbayTemplate;
use App\PaymentPolicy;
use App\ReturnPolicy;
use App\ShipmentPolicy;
use App\Traits\Ebay;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\StringConverter;
use App\EbayMigration;
use Illuminate\Support\Facades\Session;

class EbayProfileController extends Controller
{
    use Ebay;
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('max_execution_time', '300');
        $this->stringConverter = new StringConverter();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = EbayProfile::paginate(50);
        $total_ebay_profile = EbayProfile::count();
        $all_decode_EbayProfile = json_decode(json_encode($results));
        return view('ebay.profile.index' ,compact('results', 'total_ebay_profile', 'all_decode_EbayProfile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();
        return view('ebay.profile.create',compact('accounts','sites'));
    }

    public function getAccountSiteData(Request $request){

        $account_result = EbayAccount::where('id',$request->account_id)->with('developerAccount')->get();
        $return_policies = ReturnPolicy::where('account_id',$request->account_id)->where('site_id' , $request->site_id)->get()->all();
        $shipment_policies = ShipmentPolicy::where('account_id',$request->account_id)->where('site_id' , $request->site_id)->get()->all();
        $payment_policies = PaymentPolicy::where('account_id',$request->account_id)->where('site_id' , $request->site_id)->get()->all();
        $paypal_accounts = EbayPaypalAccount::where('account_id',$request->account_id)->where('site_id' , $request->site_id)->get()->all();
        $countries = Country::get()->all();

        $templates = EbayTemplate::get()->all();
        $currency = DB::table('ebay_currency')->where('site_id',$request->site_id)->get();



//        return $paypal_accounts;
        $clientID  = $account_result[0]->developerAccount->client_id;
        $clientSecret  = $account_result[0]->developerAccount->client_secret;
//dd($token_result->authorization_token);
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $account_result[0]->refresh_token,
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
        //dd($response);
        /// ////////////////////////////// end
        session(['access_token' => $response['access_token']]);

        $categories = $this->getCategoryWithOutParent($request->site_id);
//        return $categories;
//        return $categories[0]["category"][0]["pivot"]["CategoryName"];
//        exit();




////        get store data starts
//        $url = 'https://api.ebay.com/ws/api.dll';
//        $headers = [
//            'X-EBAY-API-SITEID:'.$request->site_id,
//            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
//            'X-EBAY-API-CALL-NAME:GetStore',
//            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
//        ];
//
//        $body = '<GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">
//                 <ErrorLanguage>en_US</ErrorLanguage>
//                 <WarningLevel>High</WarningLevel>
//                </GetStoreRequest>';
//        try{
//            $shop_categories = $this->curl($url,$headers,$body,'POST');
//            $shop_categories =simplexml_load_string($categories);
//            $shop_categories = json_decode(json_encode($categories),true);
//
////            $categories = $categories['CategoryArray']['Category'][0];
////            echo "<pre>";
////            print_r(json_decode(json_encode($shop_categories),true));
////            exit();
//
//        }catch (Exception $exception){
//            echo $exception;
//        }
////        get store data ends
        $account_result = $account_result[0];
        $account_site_view = view('ebay.profile.account_site',compact('categories','return_policies',
            'shipment_policies','payment_policies','currency','paypal_accounts','templates','countries','account_result'));
        return $account_site_view;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         echo "<pre>";
//         print_r($request->all());
//         exit();
        $condition ='';
        $category = null;
        $category2 = null;
        if (isset($request->child_cat[1])){
            if(count($request->child_cat) > 1){
                foreach ($request->child_cat as $category_request){
                    $category_array = $this->stringConverter->separateStringToArray($category_request);
                    $category .= '>'.$category_array[1];
                }
            }else{
                foreach(explode(':',explode('/',$request->child_cat[1])[1]) as $cat){
                    $category .= '>'.$cat;
                }
            }
        }
        if (isset($request->child_cat2[1])){
            foreach ($request->child_cat2 as $category_request){
                $category2_array = $this->stringConverter->separateStringToArray($category_request);
                $category2 .= '>'.$category2_array[1];
            }
        }


        if ($request->store_id != null && $request->store2_id != null){
            $store_one = $this->stringConverter->separateStringToArray($request->store_id);
            $store_two = $this->stringConverter->separateStringToArray($request->store2_id);
        }else{
            $store_one = null;
            $store_two = null;
        }
//        echo "<pre>";
//        print_r($store_one);
//        print_r("***************");
//        print_r($store_two);
//        exit();
        if ($request->condition_id){
            $condition = $this->stringConverter->separateStringToArray($request->condition_id);
        }

        $item_specifics = \Opis\Closure\serialize($request->item_specific);

        $result = EbayProfile::create(['account_id' => $request->account_id,'site_id' => $request->site_id,'profile_name' => $request->profile_name,'profile_description' => $request->profile_description,'product_type' => $request->product_type,'start_price' => $request->start_price,'condition_id' => $condition[0] ?? NULL,'condition_name' => $condition[1] ?? NULL,'condition_description' => $request->condition_description ?? NULL,
            'category_id' => $request->last_cat_id,'sub_category_id' => $request->last_cat2_id,'store_id' => $store_one[0] ?? null,'store_name' => $store_one[1] ?? null,'store2_id' => $store_two[0] ?? null,'store2_name' => $store_two[1] ?? null,'duration' => $request->duration,'location' => $request->location,'country' => $request->country,'post_code' => $request->post_code,'item_specifics' => $item_specifics,'shipping_id' => $request->shipping_id,'return_id' => $request->return_id,'payment_id' => $request->payment_id,
            'template_id' => $request->template_id,'currency' => $request->currency,'product_type'=>'FixedPriceItem','paypal' => $request->paypal ?? null,'category_name' => isset($category) ? $category : $request->current_category,'sub_category_name' => $category2,'galleryPlus' => $request->galleryPlus,'eps' => $request->eps ?? '']);

        return redirect('ebay-profile')->with('success','successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function duplicateProfile($id){
        $result = EbayProfile::find($id);
        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();
        $account_result = EbayAccount::where('id',$result->account_id)->with('developerAccount')->get();
        $return_policies = ReturnPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $shipment_policies = ShipmentPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $payment_policies = PaymentPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $paypal_accounts = EbayPaypalAccount::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $templates = EbayTemplate::get()->all();
        $countries = Country::get()->all();
        $currency = DB::table('ebay_currency')->where('site_id',$result->site_id)->get();
        $item_specific_results = \Opis\Closure\unserialize($result->item_specifics);


//        return $paypal_accounts;
        $clientID  = $account_result[0]->developerAccount->client_id;
        $clientSecret  = $account_result[0]->developerAccount->client_secret;
//dd($token_result->authorization_token);
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $account_result[0]->refresh_token,
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
        //dd($response);
        /// ////////////////////////////// end
        session(['access_token' => $response['access_token']]);




//    get category start

        try{
            $categories = $this->getCategoryWithOutParent($result->site_id);

//            $categories = $categories['CategoryArray']['Category'][0];
//            echo "<pre>";
//            print_r(json_decode(json_encode($categories),true));
//            exit();

        }catch (Exception $exception){
            echo $exception;
        }
//        categories ends

        //        get store data starts
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetStore',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
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

//        item specifics start
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategorySpecifics',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                              <WarningLevel>High</WarningLevel>
                              <CategorySpecific>
                                   <!--Enter the CategoryID for which you want the Specifics-->
                                <CategoryID>'.$result->category_id.'</CategoryID>
                              </CategorySpecific>
                            </GetCategorySpecificsRequest>';

        $item_specifics = $this->curl($url,$headers,$body,'POST');
        $item_specifics =simplexml_load_string($item_specifics);
        $item_specifics = json_decode(json_encode($item_specifics),true);
//        item specifics ends

        //                get condition data start
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
        ];

        $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$result->category_id.'</CategoryID>
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
        return view('ebay.profile.duplicate_profile',compact('accounts','sites','result','categories','return_policies',
            'shipment_policies','payment_policies','currency','paypal_accounts','templates','item_specifics','conditions',
            'item_specific_results','shop_categories','countries'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $result = EbayProfile::find($id);
        $accounts = EbayAccount::get()->all();
        $sites = EbaySites::get()->all();
        $account_result = EbayAccount::where('id',$result->account_id)->with('developerAccount')->get();
        $return_policies = ReturnPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $shipment_policies = ShipmentPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $payment_policies = PaymentPolicy::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $paypal_accounts = EbayPaypalAccount::where('account_id',$result->account_id)->where('site_id' , $result->site_id)->get()->all();
        $templates = EbayTemplate::get()->all();
        $countries = Country::get()->all();
        $currency = DB::table('ebay_currency')->where('site_id',$result->site_id)->get();
        $item_specific_results = \Opis\Closure\unserialize($result->item_specifics);



//        return $paypal_accounts;
        $clientID  = $account_result[0]->developerAccount->client_id;
        $clientSecret  = $account_result[0]->developerAccount->client_secret;
//dd($token_result->authorization_token);
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $account_result[0]->refresh_token,
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
        //dd($response);
        /// ////////////////////////////// end
        session(['access_token' => $response['access_token']]);




//    get category start
        try{
            $categories = $this->getCategoryWithOutParent($result->site_id);

        }catch (Exception $exception){
            echo $exception;
        }
//        categories ends

        //        get store data starts
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetStore',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
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

//        item specifics start
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategorySpecifics',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                              <WarningLevel>High</WarningLevel>
                              <CategorySpecific>
                                   <!--Enter the CategoryID for which you want the Specifics-->
                                <CategoryID>'.$result->category_id.'</CategoryID>
                              </CategorySpecific>
                            </GetCategorySpecificsRequest>';

        $item_specifics = $this->curl($url,$headers,$body,'POST');
        $item_specifics =simplexml_load_string($item_specifics);
        $item_specifics = json_decode(json_encode($item_specifics),true);
//        item specifics ends

//        echo "<pre>";
//        if($item_specifics != ''){
//            print_r($item_specifics);
//
//        }else{
//            echo 'else';
//            print_r($item_specifics);
//        };
//        exit();

        //                get condition data start
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
            'X-EBAY-API-IAF-TOKEN:'.session('access_token'),
        ];

        $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$result->category_id.'</CategoryID>
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
        return view('ebay.profile.edit_profile',compact('accounts','sites','result','categories','return_policies',
            'shipment_policies','payment_policies','currency','paypal_accounts','templates','item_specifics','conditions',
            'item_specific_results','shop_categories','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return $request->all();
        $condition = '';
        $category = null;
        $category2 = null;
        $tracker_array = array();
        if (isset($request->child_cat[1])){
            foreach ($request->child_cat as $category_request){
                $category_array =$this->stringConverter->separateStringToArray($category_request);// explode('/',$category_request);
                $category .= '>'.$category_array[1];
            }
        }
        if (isset($request->child_cat2[1])){
            foreach ($request->child_cat2 as $category_request){
                $category2_array =$this->stringConverter->separateStringToArray($category_request);// explode('/',$category_request);
                $category2 .= '>'.$category2_array[1];
            }
        }

        if ($request->store_id != null && $request->store2_id != null){
            $store_one =$this->stringConverter->separateStringToArray($request->store_id);// explode("/",$request->store_id);
            $store_two =$this->stringConverter->separateStringToArray($request->store2_id);// explode("/",$request->store2_id);
        }else{
            $store_one = null;
            $store_two = null;
        }

        if ($request->condition_id){
            $condition = $this->stringConverter->separateStringToArray($request->condition_id);
        }

        $item_specifics = \Opis\Closure\serialize($request->item_specific);

        $profile_result = EbayProfile::find($id);
        $counter = 0;
        if ($request->revise_flag == 1){
            $condition_array = $this->stringConverter->separateStringToArray($request->condition_id);

            $condition_id = $condition_array[0];

            if ($profile_result->condition_id == $condition_id){
                $tracker_array["condition_id"] = 0;
            }else{
                $tracker_array["condition_id"] = 1;
                $counter++;
            }
            if ($profile_result->condition_description == $request->condition_description){
                $tracker_array["condition_description"] = 0;
            }else{
                $tracker_array["condition_description"] = 1;
                $counter++;
            }
            if ($profile_result->category_id == $request->last_cat_id){
                $tracker_array["category_id"] = 0;
                $tracker_array["category_name"] = 0;
            }else{
                $tracker_array["category_id"] = 1;
                $tracker_array["category_name"] = 1;
                $counter++;
            }
            if ($profile_result->store_id == $store_one[0]){
                $tracker_array["store_id"] = 0;
            }else{
                $tracker_array["store_id"] = 1;
                $counter++;
            }
            if ($profile_result->store_name == $store_one[1]){
                $tracker_array["store_name"] = 0;
            }else{
                $tracker_array["store_name"] = 1;
                $counter++;
            }
            if ($profile_result->store2_id == $store_two[0]){
                $tracker_array["store2_id"] = 0;
            }else{
                $tracker_array["store2_id"] = 1;
                $counter++;
            }
            if ($profile_result->store2_name == $store_two[1]){
                $tracker_array["store2_name"] = 0;
            }else{
                $tracker_array["store2_name"] = 1;
                $counter++;
            }
            if ($profile_result->duration == $request->duration){
                $tracker_array["duration"] = 0;
            }else{
                $tracker_array["duration"] = 1;
                $counter++;
            }
            if ($profile_result->location == $request->location){
                $tracker_array["location"] = 0;
            }else{
                $tracker_array["location"] = 1;
                $counter++;
            }
            if ($profile_result->country == $request->country){
                $tracker_array["country"] = 0;
            }else{
                $tracker_array["country"] = 1;
                $counter++;
            }
            if ($profile_result->post_code == $request->post_code){
                $tracker_array["post_code"] = 0;
            }else{
                $tracker_array["post_code"] = 1;
                $counter++;
            }
            if ($profile_result->shipping_id == $request->shipping_id){
                $tracker_array["shipping_id"] = 0;
            }else{
                $tracker_array["shipping_id"] = 1;
                $counter++;
            }
            if ($profile_result->return_id == $request->return_id){
                $tracker_array["return_id"] = 0;
            }else{
                $tracker_array["return_id"] = 1;
                $counter++;
            }
            if ($profile_result->payment_id == $request->payment_id){
                $tracker_array["payment_id"] = 0;
            }else{
                $tracker_array["payment_id"] = 1;
                $counter++;
            }
            if ($profile_result->template_id == $request->template_id){
                $tracker_array["template_id"] = 0;
            }else{
                $tracker_array["template_id"] = 1;
                $counter++;
            }
            if ($profile_result->currency == $request->currency){
                $tracker_array["currency"] = 0;
            }else{
                $tracker_array["currency"] = 1;
                $counter++;
            }
            if ($profile_result->paypal == $request->paypal){
                $tracker_array["paypal"] = 0;
            }else{
                $tracker_array["paypal"] = 1;
                $counter++;
            }
            if ($profile_result->eps == $request->eps){
                $tracker_array["eps"] = 0;
            }else{
                $tracker_array["eps"] = 1;
                $counter++;
            }
            if($item_specifics == $profile_result->item_specifics){
                $tracker_array["item_specifics"] = 0;
            }else{
                $tracker_array["item_specifics"] = 1;
                $counter++;
            }


            if ($counter > 0) {

                $master_product_update = EbayMasterProduct::where('profile_id' , $id)->update(['profile_status' => \Opis\Closure\serialize($tracker_array)]);
            }else{
                $master_product_update = EbayMasterProduct::where('profile_id' , $id)->update(['profile_status' => null]);
            }

        }

        $result = EbayProfile::find($id)->update(['account_id' => $request->account_id,'site_id' => $request->site_id,'profile_name' => $request->profile_name,'profile_description' => $request->profile_description,'product_type' => $request->product_type,'start_price' => $request->start_price,'condition_id' => $condition[0] ?? NULL,'condition_name' => $condition[1] ?? NULL,'condition_description' => $request->condition_description ?? NULL,
            'category_id' => $request->last_cat_id,'sub_category_id' => $request->last_cat2_id,'category_name' => isset($category) ? $category : $request->current_category,'sub_category_name' => isset($category2) ? $category2 : $request->current_category2,'store_id' => $store_one[0] ?? null,'store_name' => $store_one[1] ?? null,'store2_id' => $store_two[0] ?? null,'store2_name' => $store_two[1] ?? null,'duration' => $request->duration,'location' => $request->location,'country' => $request->country,'post_code' => $request->post_code,'item_specifics' => $item_specifics,'shipping_id' => $request->shipping_id,'return_id' => $request->return_id,'payment_id' => $request->payment_id,
            'template_id' => $request->template_id,'currency' => $request->currency,'paypal' => $request->paypal ?? null,'galleryPlus' => $request->galleryPlus,'eps' => $request->eps ?? '']);
//        if ($item_specifics == $profile_result->item_specifics){
//
//        }


        return redirect('ebay-profile')->with('success','successfully update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        EbayProfile::destroy($id);
        return redirect('ebay-profile')->with('success','successfully deleted');
    }


    /*
       * Function : ebayProfileNameSearch
       * Route Type : {route_name}/profile/search
       * Method Type : post
       * Creator : Solaiman
       * Description : This function is used for ebay profile name search
       * Modified Date : 04-01-2021
       */

    public function ebayProfileNameSearch(Request $request){

        $ebay_profile_search_value = $request->search_value;
        $results = EbayProfile::where('profile_name','LIKE', '%'. $ebay_profile_search_value.'%')
                                ->paginate(50);

        $total_ebay_profile = EbayProfile::count();
        $all_decode_EbayProfile = json_decode(json_encode($results));
//        echo '<pre>';
//        print_r($all_decode_EbayProfile);
//        exit();
        return view('ebay.profile.index' ,compact('results', 'total_ebay_profile', 'all_decode_EbayProfile', 'ebay_profile_search_value'));

    }

    public function createEbayProfile($siteId, $accountId, $categoryId){
        try{
            $siteInfo = EbaySites::find($siteId);
            $categoryInfo = EbayMigration::where('category_id',$categoryId)->first();
            $account_result = EbayAccount::where('id',$accountId)->with('developerAccount')->first();
            $return_policies = ReturnPolicy::where('account_id',$accountId)->where('site_id' , $siteId)->get()->all();
            $shipment_policies = ShipmentPolicy::where('account_id',$accountId)->where('site_id' , $siteId)->get()->all();
            $payment_policies = PaymentPolicy::where('account_id',$accountId)->where('site_id' , $siteId)->get()->all();
            $paypal_accounts = EbayPaypalAccount::where('account_id',$accountId)->where('site_id' , $siteId)->get()->all();
            $countries = Country::get()->all();
            $templates = EbayTemplate::get()->all();
            $currency = DB::table('ebay_currency')->where('site_id',$siteId)->get();
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
            session(['access_token' => $response['access_token']]);
            $token = $response['access_token'];
            try{
                $categories = $this->getCategoryWithOutParent($siteId);
            }catch (Exception $exception){
                echo $exception;
            }
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:' . $siteId,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategorySpecifics',
                'X-EBAY-API-IAF-TOKEN:' . $token,
            ];
            $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                              <WarningLevel>High</WarningLevel>
                              <CategorySpecific>
                                   <!--Enter the CategoryID for which you want the Specifics-->
                                <CategoryID>' . $categoryId . '</CategoryID>
                              </CategorySpecific>
                            </GetCategorySpecificsRequest>';

            $item_specifics = $this->curl($url, $headers, $body, 'POST');
            $item_specifics = simplexml_load_string($item_specifics);
            $item_specifics = json_decode(json_encode($item_specifics), true);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$siteId,
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
            }catch (Exception $exception){
                echo $exception;
            }
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$siteId,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetCategoryFeatures',
                'X-EBAY-API-IAF-TOKEN:'.$token,
            ];
            $body = '?xml version="1.0" encoding="utf-8"?>
                        <GetCategoryFeaturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <DetailLevel>ReturnAll</DetailLevel>
                          <CategoryID>'.$categoryId.'</CategoryID>
                         <FeatureID>ConditionValues</FeatureID>
                        </GetCategoryFeaturesRequest>';
            try{
                $conditions = $this->curl($url,$headers,$body,'POST');
                $conditions =simplexml_load_string($conditions);
                $conditions = json_decode(json_encode($conditions),true);

            }catch (Exception $exception){
                echo $exception;
            }
            $view = view('ebay.profile.create_profile_from_migration',compact('siteInfo','account_result','categoryInfo','categories','return_policies',
            'shipment_policies','payment_policies','currency','paypal_accounts','templates','countries','item_specifics','shop_categories','conditions'));
            return view('master',compact('view'));
        }catch(\Exception $exception){
            return back()->with('success','Something Went Wrong');
        }
    }

    public function ebayMigrationProfileCount(Request $request){
        try{
            $category_count_id = $this->creatableProfile();
            $accountArr = [];
            $categoryArr = [];
            if(is_array($request->product_arr) && count($request->product_arr) > 0){
                foreach($request->product_arr as $arr){
                    $explodeData = explode('/',$arr);
                    $accountArr[] = $explodeData[0];
                    $categoryArr[] = $explodeData[1];
                    $conditionArr[] = $explodeData[2];
                    $migrationInfo = EbayMigration::select('id')->where('account_id',$explodeData[0])
                                    ->where('category_id',$explodeData[1])
                                    ->where('condition_id',$explodeData[2])->first();
                    $searchIds[] = $migrationInfo->id;
                }
                $profile_count = EbayMigration::whereNotIn('id',$category_count_id)->whereIn('id',$searchIds)->whereIn('account_id',$accountArr)->whereIn('category_id',$categoryArr)->whereIn('condition_id',$conditionArr)->groupBy('account_id')->groupBy('category_id')->groupBy('condition_id')->get()->count();
            }else{
                $profile_count = EbayMigration::whereNotIn('id',$category_count_id)->groupBy('account_id')->groupBy('category_id')->groupBy('condition_id')->get()->count();
            }
            return response()->json(['type' => 'success','msg' => 'Successfully done','profile_count' => $profile_count]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function creatableProfile(){
        $profile_count = EbayProfile::select('account_id','condition_id','category_id')->groupBy('account_id')->groupBy('category_id')->groupBy('condition_id')->get();
        $creatableProfile = [];
        $temp = null;
        $migration_count_id = [];

        if(($profile_count != null) && count($profile_count) > 0){
            foreach($profile_count as $profile){
                $creatableProfile[] = [
                    'account_id' => $profile->account_id,
                    'condition_id' => $profile->condition_id,
                    'category_id' => $profile->category_id
                ];

            }
            foreach($creatableProfile as $profile){
                $tt = EbayMigration::where('condition_id',$profile['condition_id'])->where('category_id',$profile['category_id'])
                ->where('condition_id',$profile['condition_id'])->pluck('id')->toArray();
                foreach($tt as $t){
                    $migration_count_id[] = $t;
                }
            }
        }
        return $migration_count_id;
    }



}
