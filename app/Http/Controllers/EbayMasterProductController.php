<?php

namespace App\Http\Controllers;

use App\Client;
use App\Country;
use App\DeveloperAccount;
use App\EbayAccount;
use App\EbayMasterProduct;
use App\EbayPaypalAccount;
use App\EbayProfile;
use App\EbaySites;
use App\EbayTemplate;
use App\EbayVariationProduct;
use App\Http\Controllers\Channel\ChannelFactory;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\OnbuyMasterProduct;
use App\PaymentPolicy;
use App\ProductDraft;
use App\ProductVariation;
use App\ReturnPolicy;
use App\Setting;
use App\ShipmentPolicy;
use App\Traits\ActivityLogs;
use App\Traits\Ebay;
use Carbon\Carbon;
use http\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attribute;
use App\User;
use App\WooWmsCategory;
use DB;
use auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PHPUnit\Util\Exception;
use App\Traits\StringConverter;
use App\WoocommerceAccount;
use App\Traits\ImageUpload;
use App\Traits\ListingLimit;
use File;


class EbayMasterProductController extends Controller
{
    use ActivityLogs;
    use ImageUpload;
    use ListingLimit;
    use Ebay;
    protected $url;
    public function __construct(UrlGenerator $url)
    {
        $this->middleware('auth');
        ini_set('max_execution_time', '300');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
        $this->stringConverter = new StringConverter();
        $this->url = $url;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /*
     * Function : index
     * Route Type : ebay-master-product-list
     * Method Type : GET
     * Parameters : null
     * Creator : Mahfuz
     * Modifier : Solaiman
     * Description : This function is used for eBay Active product list and pagination setting
     * Modified Date : 28-11-2020
     * Modified Content : Pagination setting
     */

    public function index(Request $request)
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay Active | WMS360';
        $pagination = $settingData['pagination'];

        $shelfUse = $this->shelf_use;
        $user_list = User::get();
        $defaultEditAdd = NULL;
        $master_product_list = EbayMasterProduct::where("product_status",'Active')->with('variationProducts')->orderByDesc('id')->paginate($pagination);
        if($request->has('is_clear_filter')){
            $search_result = $master_product_list;
            $view = view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render();
            return response()->json(['html' => $view]);
        }
        $master_decode_product_list = json_decode(json_encode($master_product_list));
    //    echo '<pre>';
    //    print_r(json_decode(json_encode($master_product_list)));
    //    exit();
//        return \Opis\Closure\unserialize($master_product_list[0]->master_images)[0];

        return view('ebay.master_product.master_product_list',compact('master_product_list','master_decode_product_list', 'setting', 'page_title', 'pagination','shelfUse','user_list'));
    }

    // permanent delete function
    public function ebayPermanentDelete(Request $request){

        try{
            $ebayMasterPID = EbayMasterProduct::select('id')->whereIn('id', $request->products)->get()->pluck('id')->toArray();

            // $product_variation = EbayVariationProduct::whereIn('ebay_master_product_id',$ebayMasterPID)->forceDelete();

            $ebay_permanent_delete = EbayMasterProduct::whereIn('id',$ebayMasterPID)->forceDelete();

            return back()->with('success','Successfully Deleted');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    // end product function
    public function ebayEndProductList(Request $request){
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay End Product | WMS360';
        $pagination = $settingData['pagination'];


        $shelfUse = $this->shelf_use;
        $user_list = User::get();

//        $onlySoftDeletedList = EbayMasterProduct::onlyTrashed()->where('product_status', '=', 'Completed')->orderByDesc('id')->paginate($pagination);
        $onlySoftDeletedList = EbayMasterProduct::where('product_status', '=', 'Completed')->orderByDesc('id')->paginate($pagination);
//        $onlySoftDeletedList = EbayMasterProduct::orWhere('product_status', '=', 'Completed')->orWhere('deleted_at','!=',null)->orderByDesc('id')->paginate($pagination);
        $defaultEditAdd = 1;
        if($request->has('is_clear_filter')){
            $search_result = $onlySoftDeletedList;
            $view = view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render();
            return response()->json(['html' => $view]);
        }
        $end_decode_product_list = json_decode(json_encode($onlySoftDeletedList));

        return view('ebay.master_product.end_product_list', compact('onlySoftDeletedList','end_decode_product_list', 'page_title', 'shelfUse','pagination', 'user_list','setting'));
    }



    public function getVariation(Request $request){

        $shelfUse = $this->shelf_use;
        $id = $request->product_draft_id;
        $status = $request->status;

        if ($status == 'ebay_pending'){
            $product_draft = ProductVariation::where('product_draft_id',$id)->get();

            $product_draft = json_decode(json_encode($product_draft));
            return view('ebay.master_product.variation_ajax',compact('product_draft','id','status','id','shelfUse'));
        }else{
            // $product_list = EbayVariationProduct::withCount(['orderProduct' => function($query){
            //     $query->whereHas('order',function($q){
            //         $q->where('created_via','Ebay');
            //     });
            // }])->where('ebay_master_product_id',$id)
            // ->get();

            $product_list = EbayVariationProduct::withCount(['orderProduct' => function($query) use ($id){
                $query->whereHas('order',function($q) use ($id){
                    $q->whereHas('ebayMaster',function($q) use ($id){
                        $q->where('id',$id);
                    })->where('status','!=','cancelled')->where('created_via','Ebay');
                })->doesntHave('returnOrder');
            }])->where('ebay_master_product_id',$id)
            ->get();
            $product_list = json_decode(json_encode($product_list));
//            return $product_list;
            return view('ebay.master_product.variation_ajax',compact('product_list','id','status','shelfUse'));
        }

    }

    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Creator : solaiman
    * Description : This function is used for pagination setting
    * Created Date : 30-11-2020
    */

    public function paginationSetting ($firstKey, $secondKey = NULL) {
        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
        $data['setting'] = null;
        $data['pagination'] = 50;
        if(isset($setting_info)) {
            if($setting_info->setting_attribute != null){
                $data['setting'] = \Opis\Closure\unserialize($setting_info->setting_attribute);
                if(array_key_exists($firstKey,$data['setting'])){
                    if($secondKey != null) {
                        if (array_key_exists($secondKey, $data['setting'][$firstKey])) {
                            $data['pagination'] = $data['setting'][$firstKey][$secondKey]['pagination'] ?? 50;
                        } else {
                            $data['pagination'] = 50;
                        }
                    }else{
                        $data['pagination'] = $data['setting'][$firstKey]['pagination'] ?? 50;
                    }
                }else{
                    $data['pagination'] = 50;
                }
            }else{
                $data['setting'] = null;
                $data['pagination'] = 50;
            }

        }else{
            $data['setting'] = null;
            $data['pagination'] = 50;
        }

        return $data;
    }



    public function masterProductWithErrorMessage()
    {
        $shlefUse = $this->shelf_use;
        $master_product_list = EbayMasterProduct::with('variationProducts')->where('change_message','!=','success')->where('change_message','!=',null)->orderByDesc('id')->paginate(50);
        $master_decode_product_list = json_decode(json_encode($master_product_list));
//        echo '<pre>';
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
//        return \Opis\Closure\unserialize($master_product_list[0]->master_images)[0];

        return view('ebay.master_product.master_product_error_message_list',compact('master_product_list','master_decode_product_list','shlefUse'));

    }


    /*
    * Function : reviseList
    * Route Type : ebay-revise-product-list
    * Method Type : GET
    * Parameters : null
    * Creator : Mahfuz
    * Modifier : Solaiman
    * Description : This function is used for eBay Revise product list and pagination setting
    * Modified Date : 3-12-2020
    * Modified Content : Pagination setting
    */

    public function reviseList(Request $request)
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_revise_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay Revise | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


//        $master_product_list = EbayMasterProduct::where('profile_status',0)->orderByDesc('id')->get()->all();
        $master_product_list = EbayMasterProduct::where('profile_status','!=',null)->where('product_status', "Active")->orderByDesc('id')->paginate($pagination);
//        return \Opis\Closure\unserialize($master_product_list[0]->master_images)[0];
        if($request->has('is_clear_filter')){
            $master_product_list = $master_product_list;
            $view = view('ebay.master_product.revise_list_after_reset', compact('master_product_list'))->render();
            return response()->json(['html' => $view]);
        }
        $all_decode_revise_product = json_decode(json_encode($master_product_list));

        return view('ebay.master_product.revise_product_list',compact('master_product_list', 'all_decode_revise_product', 'setting', 'page_title', 'pagination'));

    }

    public function reviseListColumnSearch(Request $request){
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_revise_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay Revise | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

        $shelfUse = $this->shelf_use;
        $user_list = User::get();

        $column_name = $request->column_name;
        $search_value = $request->search_value;

        $master_product_list = EbayMasterProduct::where('profile_status','!=',null)->orderByDesc('id')
            ->where(function ($query) use ($request, $search_value) {
                if (isset($search_value['item_id']['value'])) {

                    if (isset($search_value['item_id']['opt_out'])) {
                        $query->where('item_id', '!=', $search_value['item_id']['value']);
                    } else {
                        $query->where('item_id', $search_value['item_id']['value']);
                    }
                } if (isset($search_value['master_product_id']['value'])) {

                    if (isset($search_value['master_product_id']['opt_out'])) {
                        $query->where('master_product_id', '!=', $search_value['master_product_id']['value']);
                    } else {
                        $query->where('master_product_id', $search_value['master_product_id']['value']);
                    }
                }if (isset($search_value['title']['value'])) {
                    if(isset($search_value['title']['opt_out'])){
                        $query->where('title','NOT LIKE', "%{$search_value['title']['value']}%");
                    }else{
                        $query->where('title','LIKE', "%{$search_value['title']['value']}%");
                    }
                }
                if (isset($search_value['category']['value'])) {
                    if(isset($search_value['category']['opt_out'])){
                        $query->where('category_id', '!=',  $search_value['category']['value']);
                    }else{
                        $query->where('category_id',$search_value['category']['value']);
                    }
                }
                if (isset($search_value['profile_name']['value'])) {

                    if (isset($search_value['profile_name']['opt_out'])) {
                        $query->where('profile_id', '!=',$search_value['profile_name']['value']);
                    } else {
                        $query->where('profile_id', $search_value['profile_name']['value']);
                    }
                }
                if (isset($search_value['account_name']['value'])) {


                    if (isset($search_value['account_name']['opt_out'])) {
                        $query->where('account_id', '!=',$search_value['account_name']['value']);
                    } else {
                        $query->where('account_id', $search_value['account_name']['value']);
                    }

                }if (isset($search_value['revise_status']['value'])) {

                    if (isset($search_value['revise_status']['opt_out'])) {
                        $query->where('profile_status', '!=',$search_value['revise_status']['value']);
                    } else {
                        $query->where('profile_status', $search_value['revise_status']['value']);
                    }

                }

                // If user submit with empty data then this message will display table's upstairs
                if ($search_value == '') {
                    return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
                }

            })
            ->paginate($pagination)->appends(request()->query());
        $all_decode_revise_product = json_decode(json_encode($master_product_list));

        return view('ebay.master_product.revise_product_list',compact('master_product_list', 'all_decode_revise_product', 'setting','search_value', 'page_title', 'pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ebay_profiles = EbayProfile::get()->all();
        return view('ebay.master_product.create',compact('ebay_profiles'));
    }

    public function createMasterProduct($id, $p_id = NULL, $item_id = NULL)
    {
        // $results = EbayMasterProduct::with(['variationProducts'])->find($p_id);
        // foreach ($results as $result){
        //     if ($results[0]['category_id'] != $result->category_id){
        //         $counter++;
        //         $remove_profile = $result->category_id;
        //     }
        // }

        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
        // dd($listingLimitInfo,$clientListingLimit);
        // dd($listingLimitAllChannelActiveProduct);

        $result = ProductDraft::with(['ProductVariations','images'])->where('id',$id )->get();
        $ebay_profiles = EbayProfile::get()->all();
        $profile_id = null;
        $profile_N = null;
        $same_profile_info = null;
        $results = null;
        if ($p_id != null){
            $results = EbayProfile::find($p_id);
//            $remainDataResult = EbayMasterProduct::onlyTrashed()->where('profile_id',$p_id)->where('product_status', '=', 'Completed')->first();
            $remainDataResult = EbayMasterProduct::where('profile_id',$p_id)->where('product_status', '=', 'Completed')->first();
            // echo '<pre>';
            // print_r($remainDataResult);
            // exit();

            if ($remainDataResult){
                $profile_id = $remainDataResult['profile_id'];
                $profile_result = EbayProfile::where('id', $profile_id)->first();
                $same_profile_info = EbayProfile::where('category_id', $profile_result['category_id'])->where('condition_id', $profile_result['condition_id'])->get()->all();
                $profile_N = $profile_result['profile_name'];
            }
        }

        // echo '<pre>';
        // print_r($same_profile_info['profile_name']);
        // exit();

        return view('ebay.master_product.create',compact('ebay_profiles','same_profile_info','results','result','id','profile_id','profile_N', 'p_id','item_id','listingLimitAllChannelActiveProduct','clientListingLimit','listingLimitInfo'));
    }

    public function getProfile(Request $request){
        $p_id = $request->profile_id;
        $profile_array = $request->profile_array;
        $counter = 0;
        $remove_profile = '';
        $results = EbayProfile::select('category_id')->whereIn('id',$profile_array)->get();

        foreach ($results as $result){
            if ($results[0]['category_id'] != $result->category_id){
                $counter++;
                $remove_profile = $result->category_id;
            }
        }
//        return ['counter'=>$counter,'remove' => $request->profile_id];
        $result = EbayProfile::find($request->profile_id);
        $ebay_access_token = $this->getAuthorizationToken($result->account_id);
         $account_id= $result->account_id;
         $site_id= $result->site_id;
//        category started
        //    get category start
        try{
            $categories = $this->getCategoryWithOutParent($result->site_id);

        }catch (Exception $exception){
            echo $exception;
        }
//        categories ends
//        category end


//        campaign starts
        $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign';
        $headers = [
                'Authorization:Bearer '.$ebay_access_token,
                'Accept:application/json',
                'Content-Type:application/json'
        ];
        $body ='';
        $campaigns = $this->curl($url,$headers,$body,'GET');
        $campaigns = \GuzzleHttp\json_decode($campaigns);

//        campaign ends




        //        get store data starts
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetStore',
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
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

        $store_one = '<div id="shopCatTabId'.$result->id.'" class="tab-pane active shopCategoryContent_'.$result->id.'">';
            if (isset($shop_categories['Store']['CustomCategories']['CustomCategory'])){
                $store_one .= '<div class="row">
                        <div class="col-md-2 d-flex align-items-center">
                            Shop Category 1
                        </div>
                        <div class="col-md-10">';
                        $store_one.= '<select name="store_id['.$result->id.']" class="form-control select2">';
                        if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory'])) {
                            foreach ($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category) {
                                if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory'])) {
                                    foreach ($shop_category['ChildCategory'] as $child_category_1) {
                                        if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory'])) {
                                            foreach ($child_category_1['ChildCategory'] as $child_category_2) {
                                                if (isset($child_category_2['CategoryID'])) {
                                                    if (2 == $child_category_2['CategoryID']) {
                                                        $store_one .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '" selected>' .
                                                            $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                                    } else {
                                                        $store_one .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                                    }
                                                }
                                            }
                                        }
                                        if ($result->store_id == $child_category_1['CategoryID']) {
                                            $store_one .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '" selected>' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';
                                        } else {
                                            $store_one .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';

                                        }
                                    }
                                } else {
                                    if ($result->store_id == $shop_category['CategoryID']) {
                                        $store_one .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '" selected>' . $shop_category['Name'] . '</option>';
                                    } else {
                                        $store_one .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '">' . $shop_category['Name'] . '</option>';
                                    }
                                }
                            }
                        }else{
                            $store_one .= '<option value="' . $shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']. '/' . $shop_categories['Store']['CustomCategories']['CustomCategory']['Name'] . '">' .$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']. '</option>';
                        }
                        $store_one .= '</select>';
                    $store_one .= '</div>';
                $store_one .= '</div>';
                $store_one .= '<div class="row mt-3">
                    <div class="col-md-2 d-flex align-items-center">
                        Shop Category 2
                    </div>
                    <div class="col-md-10">';
                        $store_one.= '<select name="store2_id['.$result->id.']" class="form-control select2">';
                            if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory'])) {
                                foreach ($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category) {
                                    if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory'])) {
                                        foreach ($shop_category['ChildCategory'] as $child_category_1) {
                                            if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory'])) {
                                                foreach ($child_category_1['ChildCategory'] as $child_category_2) {
                                                    if (isset($child_category_2['CategoryID'])) {
                                                        if ($result->store2_id == $child_category_2['CategoryID']) {
                                                            $store_one .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '" selected>' .
                                                                $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                                        } else {
                                                            $store_one .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                                        }
                                                    }
                                                }
                                            }
                                            if ($result->store2_id == $child_category_1['CategoryID']) {
                                                $store_one .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '" selected>' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';
                                            } else {
                                                $store_one .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';

                                            }
                                        }
                                    } else {
                                        if ($result->store2_id == $shop_category['CategoryID']) {
                                            $store_one .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '" selected>' . $shop_category['Name'] . '</option>';
                                        } else {
                                            $store_one .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '">' . $shop_category['Name'] . '</option>';
                                        }
                                    }
                                }
                            }else{
                                $store_one .= '<option value="' . $shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']. '/' . $shop_categories['Store']['CustomCategories']['CustomCategory']['Name'] . '">' .$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']. '</option>';
                            }
                            $store_one .= '</select>';

                        $store_one .= '</div>';
                    $store_one .= '</div>';
                $store_one .= '</div>';
            }else{
                $store_one ='';
            }

        $store_one .= '</div>';


        if (isset($shop_categories['Store']['CustomCategories']['CustomCategory'])){
        $store_two = '<div id="shopCatTabId_2'.$result->id.'" class="tab-pane active">';
            $store_two.= '<select name="store2_id['.$result->id.']" class="form-control select2">';
                if(isset($shop_categories['Store']['CustomCategories']['CustomCategory'][0]) && is_array($shop_categories['Store']['CustomCategories']['CustomCategory'])) {
                    foreach ($shop_categories['Store']['CustomCategories']['CustomCategory'] as $shop_category) {
                        if(isset($shop_category['ChildCategory']) && is_array($shop_category['ChildCategory'])) {
                            foreach ($shop_category['ChildCategory'] as $child_category_1) {
                                if(isset($child_category_1['ChildCategory']) && is_array($child_category_1['ChildCategory'])) {
                                    foreach ($child_category_1['ChildCategory'] as $child_category_2) {
                                        if (isset($child_category_2['CategoryID'])) {
                                            if ($result->store2_id == $child_category_2['CategoryID']) {
                                                $store_two .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '" selected>' .
                                                    $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                            } else {
                                                $store_two .= '<option value="' . $child_category_2['CategoryID'] . '/' . $child_category_2['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '>' . $child_category_2['Name'] . '</option>';
                                            }
                                        }
                                    }
                                }
                                if ($result->store2_id == $child_category_1['CategoryID']) {
                                    $store_two .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '" selected>' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';
                                } else {
                                    $store_two .= '<option value="' . $child_category_1['CategoryID'] . '/' . $child_category_1['Name'] . '">' . $shop_category['Name'] . '>' . $child_category_1['Name'] . '</option>';

                                }
                            }
                        } else {
                            if ($result->store2_id == $shop_category['CategoryID']) {
                                $store_two .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '" selected>' . $shop_category['Name'] . '</option>';
                            } else {
                                $store_two .= '<option value="' . $shop_category['CategoryID'] . '/' . $shop_category['Name'] . '">' . $shop_category['Name'] . '</option>';
                            }
                        }
                    }
                }else{
                    $store_two .= '<option value="' . $shop_categories['Store']['CustomCategories']['CustomCategory']['CategoryID']. '/' . $shop_categories['Store']['CustomCategories']['CustomCategory']['Name'] . '">' .$shop_categories['Store']['CustomCategories']['CustomCategory']['Name']. '</option>';
                }
                $store_two .= '</select>';
            $store_two .= '</div>';
        }else{
            $store_two = '';
        }
        $ebay_account_result = EbayAccount::find($result->account_id);
        $feeder_quantity = $ebay_account_result->feeder_quantity;
        $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$request->product_id )->get();
//        echo "<pre>";
//        print_r(unserialize($product_result[0]['ProductVariations'][0]['image_attribute']));
//        foreach (unserialize($product_result[0]['ProductVariations'][0]['image_attribute']) as $key => $index){
//            echo $key;
//        }
//        exit();
        if ($request->counter > 1){
            return ['profile' => $result, 'product_result' =>$product_result,'counter'=>$counter,'remove' => $request->profile_id,'feeder_quantity' => $feeder_quantity,'store_one' => $store_one,'store_two' => $store_two,'campaigns' => $campaigns];
        }

        $profile_id = $request->profile_id;
        $id = $request->product_id;
        //$ebay_access_token = $this->getAuthorizationToken($result->account_id);
//        $account_result = EbayAccount::where('id',$result->account_id)->with('developerAccount')->get()->first();


//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($product_result[0]->ProductVariations[0]->attribute));
//        exit();
//        $template_id = $result->template_id;
//        $template_result =  EbayTemplate::find($result->template_id);
//        $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
//        $template_result = view('ebay.all_templates.'.$template_name,compact('product_result'));
        $item_specific_results = \Opis\Closure\unserialize($result->item_specifics);

//        $clientID  = $account_result->developerAccount->client_id;
//        $clientSecret  = $account_result->developerAccount->client_secret;
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
//            'refresh_token' => $account_result->refresh_token,
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

        $item_specific_results = $this->getItemSpecifics($result->category_id,$ebay_access_token);

        //        item specifics start
//        echo "<pre>";
//        echo "********************";
//        print_r($item_specifics);
        echo "<pre>";
        echo "********************";
        print_r($item_specific_results);
        exit();

//        item specifics ends

        //        get store data starts
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetStore',
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
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

        $remainDataResult = EbayMasterProduct::onlyTrashed()->where('master_product_id',$request->product_id)->first();
//        dd($remainDataResult);
        if ($remainDataResult){
            $item_specific_results = \Opis\Closure\unserialize($remainDataResult['item_specifics']);
        }
//                echo "<pre>";
//        echo "********************";
//        print_r($item_specifics);
//        echo "<pre>";
//        echo "********************";
//        print_r($item_specific_results);
//        exit();
        $ebayEndProduct = false;
        $ebayMasterImages = [];
        if(isset($request->ebay_item_id) && ($request->ebay_item_id != null)){
            $ebayEndProduct = true;
            $ebayMasterInfo = EbayMasterProduct::where('item_id',$request->ebay_item_id)->first();
            $ebayMasterImages = unserialize($ebayMasterInfo->master_images);
        }
        $profile_data = view('ebay.master_product.profile_data',compact('result','item_specifics','item_specific_results','product_result','shop_categories','id','profile_id','feeder_quantity','campaigns','categories','account_id','site_id','p_id','ebayEndProduct','ebayMasterImages'));
        return $profile_data;
    }
    public function checkTemplate(Request $request,$template_id,$id){
        $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$id )->get();

//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($product_result[0]->ProductVariations[0]->attribute));
//        exit();
        $template_id = $template_id;
        $template_result =  EbayTemplate::find($template_id);
        $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
        return view('ebay.all_templates.'.$template_name,compact('product_result'));
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


    public function verifyEbayProduct(Request $request,$profileId = null){

        if ($profileId != null){
            $values = array();
            parse_str($request->form_data, $values);
//        foreach ($values["profile as $profile){
//            echo $profile;
//        }

//        exit();

            $pictures = '';
            $item_specifics = '';
            $variations ='';
            $attribute = '';
            $name_value = '';
            $image_variation = '';
            $ean = '';
            $subcategory= '';
            $fees = array();
            $full_variation = '';
            $start_price ='';
            if ($values["type"] == 'variable'){
                $start_price = '';
            }elseif(isset($values["start_price"])){
                $start_price = '<StartPrice>'.$values["start_price"].'</StartPrice>';
            }
            $image_array = [];
            $newProfileImageArr = $values["newUploadImage"];
            if(isset($values["newUploadImage"]) && count($values["newUploadImage"]) > 0){
                foreach($values["newUploadImage"] as $profileId => $images){
                    $folderPath = 'uploads/product-images/';
                    if(isset($newProfileImageArr[$profileId])){
                        foreach($images as $imageName => $imageContent){
                            if(isset(explode(".", $imageName)[1])){

                                $updatedImageName = $this->base64ToImage($request->id, $imageName, $imageContent, $folderPath);
                                $imagePath = asset($folderPath.$updatedImageName);
                                $info = pathinfo($imagePath);
                                $image_name =  basename($imagePath,'.'.$info['extension']);
                                $ext = explode(".", $imagePath);
                                $image_type = end($ext);
                                if($image_type == "webp"){
                                    $ext = str_replace("webp","jpg",$image_type);
                                    $name_str = $image_name . '.' . $ext;
                                    $imagePath = $name_str;
                                }

                                $image_array[$profileId][] = str_replace(' ','-',$imagePath);
                            }else{
                                $info = pathinfo($imageContent);
                                $image_name =  basename($imageContent,'.'.$info['extension']);
                                $ext = explode(".", $imageContent);
                                $image_type = end($ext);
                                if($image_type == "webp"){
                                    $ext = str_replace("webp","jpg",$image_type);
                                    $name_str = $image_name . '.' . $ext;
                                    $imageContent = asset($folderPath.$name_str);
                                }
                                $image_array[$profileId][] = str_replace(' ','-',$imageContent);



                            }

                            // $imageName = $image->getClientOriginalName();
                            // $key = array_search($imageName,$newProfileImageArr[$profileId]);
                            // if($key !== FALSE){
                            //     $ImageArr[] = $imageName;
                            //     $name = $request->product_id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                            //     $name .= str_replace(['&',' '],'-',$imageName);
                            //     $image->move('uploads/product-images/', $name);
                            //     $image_url = asset('uploads/product-images/' . $name);
                            //     $newProfileImageArr[$profileId][$key] = $image_url;
                            // }
                        }



                        // if($request->newUploadImage != null){
                        //     foreach($request->newUploadImage as $imageName => $imageContent){
                        //         if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                        //             $updatedImageName = $this->base64ToImage($id, $imageName, $imageContent, $folderPath);
                        //             $image_array[] = asset($folderPath.$updatedImageName);
                        //         }else{
                        //             $image_array[] = $imageContent;
                        //         }
                        //     }
                        // }





                        // else{
                        //     $newProfileImageArr[$profileId][$key] = 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482953.jpg';
                        // }

                        // foreach($request->newUploadImage as $imageName => $imageContent){
                        //     if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                        //         $updatedImageName = $this->base64ToImage($productDraft->id, $imageName, $imageContent, $folderPath);
                        //         $image_array[] = asset($folderPath.$updatedImageName);
                        //     }else{
                        //         $image_array[] = $imageContent;
                        //     }
                        // }
                    }
                }
            }


            $values['image'] = $image_array;

//        $template_result = 'this is a test product';

            if (isset($values["item_specific"])){
                foreach ($values["item_specific"] as $key=>$item_specific){
//            return gettype($key);
                    //if ($item_specific !=null){
                    $item_specifics .='<NameValueList>
				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
			                      </NameValueList>';
                    //}

                }

                $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
            }

            $variation_specifics = array();
            $master_product_find_result = ProductDraft::where('id' , $values["product_id"])->first();
            if ($request->type == 'variable'){
                foreach ($values["productVariation"] as $product_variation){
                    foreach (\Opis\Closure\unserialize($master_product_find_result->attribute) as $attribute_id => $attribute_array){

                        foreach ($attribute_array as $attribute_name => $terms_array){
//                echo "<pre>";
//                print_r($terms);
//                exit();
                            foreach ($terms_array as $terms){
                                $variation_specifics[$attribute_name][] =$terms["attribute_term_name"];
                                $variation_image[$attribute_name][$terms["attribute_term_name"]][] = $product_variation['image'];
                            }

                        }

                    }
                }
            }



            $item_specific =\Opis\Closure\serialize($values["item_specific"]);
            if ($request->type == 'variable'){
                $variation_specifics =\Opis\Closure\serialize($variation_specifics);
                $variation_image = \Opis\Closure\serialize($variation_image);
            }

            if ($values["condition_id"]){
                $condition = $this->stringConverter->separateStringToArray($values["condition_id"]);

            }

            if ($values["last_cat2_id"] != ""){
                $subcategory = '<SecondaryCategory>
                              <CategoryID>'.$values["last_cat2_id"].'</CategoryID>
                            </SecondaryCategory>';
            }else{
                $subcategory = '';
            }

            foreach ($values["profile"] as $profile){

                $pictures ='';
                $profile_info = EbayProfile::find($profile);
                $tracker_array = array();
                $tracker_array['title_flag'] = $values["title_flag"][$profile] ?? 0;
                $tracker_array['description_flag'] = $values["description_flag"][$profile] ?? 0;
                $tracker_array['image_flag'] = $values["image_flag"][$profile] ?? 0;
                $tracker_array['feeder_flag'] = $values["custom_feeder_flag"][$profile] ?? 0;

                $name = $values["name"][$profile];
                $description = $values["description"][$profile];
                $images = $values["image"][$profile];
                if ($values["type"] == 'variable') {
                    $full_variation = $this->getFullVariation($values["productVariation"], $values["custom_feeder_quantity"][$profile] ?? 0, $values["custom_feeder_flag"][$profile] ?? 0, $values["attribute"], null, null);
                }
//          $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$request->product_id )->get();
                $template_result =  EbayTemplate::find($profile_info->template_id);
                $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
                $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));

                $ebay_access_token = $this->getAuthorizationToken($profile_info->account_id);


//            if (isset($profile_info->store_id)){
//                $store_one = $profile_info->store_id;
//                //$store_one = explode("/", $store_one);
//                //(int)$store = $store_one[0];
//                $final_store='<StoreCategoryID>'.$store_one.'</StoreCategoryID>';
//
//            }else{
//                $final_store='';
//            }
//            if ($profile_info->store2_id != null){
//                $store_two = $profile_info->store2_id;
//                //$store_two = explode("/", $store_two);
//                //(int)$store2 = $store_two[0];
//                $final_store2='<StoreCategory2ID>'.$store_two.'</StoreCategory2ID>';
//            }else{
//                $final_store2= '';
//            }
                if (isset($values["store_id"][$profile])){
                    $store_one = $this->stringConverter->separateStringToArray($values["store_id"][$profile]);
                    (int)$store = $store_one[0];
                    $final_store='<StoreCategoryID>'.$store.'</StoreCategoryID>';

                }else{
                    $final_store='';
                }
                if (isset($values["store2_id"][$profile])){
                    $store_two =$this->stringConverter->separateStringToArray($values["store2_id"][$profile]);
                    (int)$store2 = $store_two[0];
                    $final_store2='<StoreCategory2ID>'.$store2.'</StoreCategory2ID>';
                }else{
                    $final_store2= '';
                }

                if(isset($values["image"][$profile])){
                    foreach ($values["image"][$profile] as $image){

                        $pictures .='<PictureURL>'.'<![CDATA['.$image.']]>'.'</PictureURL>';
                    }
                }else{
                    $pictures .='<PictureURL>'.'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482930.jpg'.'</PictureURL>';
                }
                if (isset($values["galleryPlus"][$profile])){
                    $galleryPlus = '<GalleryType>Plus</GalleryType>';
                }else{
                    $galleryPlus = '';
                }


                $body = '<?xml version="1.0" encoding="utf-8"?>
<VerifyAddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<Item>
		<Country>'.$profile_info->country.'</Country>
		<Currency>'.$profile_info->currency.'</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>'.$profile_info->duration.'</ListingDuration>
		<ListingType>FixedPriceItem</ListingType>
		<CrossBorderTrade>'.$values["cross_border_trade"][$profile].'</CrossBorderTrade>
		<ConditionID>'.$condition[0].'</ConditionID>
		'.$start_price.'
		<ConditionDescription>'.$profile_info->condition_description.'</ConditionDescription>
		<PostalCode>'.$profile_info->post_code.'</PostalCode>
		<PrimaryCategory>
			<CategoryID>'.$profile_info->category_id.'</CategoryID>
		</PrimaryCategory>'.$subcategory.'
		<Title>'.'<![CDATA['.$values["name"][$profile].']]>'.'</Title>
		<SubTitle>'.'<![CDATA['.$values["subtitle"][$profile].']]>'.'</SubTitle>
		<Description>'.'<![CDATA['.$template_result.']]>'.'</Description>
		<PictureDetails>'.$galleryPlus. $pictures
//			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
                    .'</PictureDetails>


			'.$item_specifics.'
         <Storefront>
         '.$final_store.$final_store2.'


        </Storefront>
        '.$full_variation.'

		  <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
		     instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
         For help, see the API Reference for Business Policies:
		     https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->

       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>'.$profile_info->shipping_id.'</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>'.$profile_info->return_id.'</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>'.$profile_info->payment_id.'</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>
	</Item>
</VerifyAddFixedPriceItemRequest>';
// return $body;
                //$logInsertData = $this->paramToArray(url()->full(),'Create Ebay product','Ebay',$profile_info->account_id,$body,null,Auth::user()->name,null,null, \Illuminate\Support\Carbon::now(),);
                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$profile_info->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:VerifyAddFixedPriceItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];

                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);


                if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success'){
                    $fees[$profile]=[ $result["Fees"]["Fee"]];

                }else{
                    return response()->json(["message" => $result['Errors']]);
                }

            }

            return  response()->json(["fees"=> $fees,"profile_id" => $profileId]);

            return redirect('ebay-master-product-list')->with('success','successfully added');
        }else{

            $values = array();
            parse_str($request->form_data, $values);

            $start_price ='';
            if ($values["type"] == 'variable'){
                $start_price = '';
            }elseif(isset($values["start_price"])){
                $start_price = '<StartPrice>'.$values["start_price"].'</StartPrice>';
            }
            $newProfileImageArr = $values["image"] ?? null;
            if(isset($values["uploadImage"]) && count($values["uploadImage"]) > 0){
                foreach($values["uploadImage"] as $image){
                    $imageName = $image->getClientOriginalName();
                    $key = array_search($imageName,$newProfileImageArr);
                    if($key !== FALSE){
                        $ImageArr[] = $imageName;
                        $name = $values["product_id"].'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                        $name .= str_replace(['&',' '],'-',$imageName);
                        $image->move('uploads/product-images/', $name);
                        $image_url = asset('uploads/product-images/' . $name);
                        $newProfileImageArr[$key] = $image_url;
                    }
                    // else{
                    //     $newProfileImageArr[$key] = 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482953.jpg';
                    // }
                }
            }
            if(isset($values["newUploadImage"]) && count($values["newUploadImage"]) > 0) {
                foreach($values["newUploadImage"] as $key => $image){
                    $newProfileImageArr[$key] = $image;
                }
            }

            $values['image'] = $newProfileImageArr;
            $result = EbayMasterProduct::with(['variationProducts'])->find($values['product_id']);

            $ebay_access_token = $this->getAuthorizationToken($result->account_id);
            $ean = '';
            $pictures = '';
            $item_specifics = '';
            $variations ='';
            $attribute = '';
            $name_value = '';
            $image_variation = '';
            $condition = '';
            $tracker_array['title_flag'] = $values["title_flag"] ?? 0;
            $tracker_array['description_flag'] = $values["description_flag"] ?? 0;
            $tracker_array['image_flag'] = $values["image_flag"] ?? 0;
            $tracker_array['feeder_flag'] = $values["custom_feeder_flag"] ?? 0;
            if (isset($values["store_id"])){
                $store_one = $this->stringConverter->separateStringToArray($values["store2_id"]);
                (int)$store = $store_one[0];
                $final_store='<StoreCategoryID>'.$store.'</StoreCategoryID>';

            }else{
                $final_store='';
            }
            if ($values["store2_id"] != null){
                $store_two = $this->stringConverter->separateStringToArray($values["store2_id"]);

                (int)$store2 = $store_two[0];
                $final_store2='<StoreCategory2ID>'.$store2.'</StoreCategory2ID>';
            }else{
                $final_store2= '';
            }

            if (isset($values["condition_id"])){
                $condition = $this->stringConverter->separateStringToArray($values["condition_id"]);

            }

            $category = null;
            if (isset($product_variation['ean'])){
                $ean = $product_variation['ean'];
            }else{
                $ean = 'Does not apply';
            }
            if (isset($values["child_cat"][1])){
                foreach ($values["child_cat"] as $category_request){
                    $category_array = $this->stringConverter->separateStringToArray($category_request);
                    $category .= '>'.$category_array[1];
                }
            }

            if(isset($values["image"])){
                foreach ($values["image"] as $image){

                    $pictures .='<PictureURL>'.'<![CDATA['.$image.']]>'.'</PictureURL>';
                }
            }

            $name = $values["name"];
            $description = $values["description"];
            $images = $values["image"];
            $quantity = "";
            $galleryPlus = "";
            $subcategory = "";
            $profile_result =  EbayProfile::find($values["profile_id"]);
            $template_result =  EbayTemplate::find($profile_result->template_id);
            $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
            $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));

            if (isset($values["galleryPlus"])){
                $galleryPlus = '<GalleryType>Plus</GalleryType>';
            }else{
                $galleryPlus = '';
            }

            if ($values["last_cat2_id"] != ""){
                $subcategory = '<SecondaryCategory>
                              <CategoryID>'.$values["last_cat2_id"].'</CategoryID>
                            </SecondaryCategory>';
            }else{
                $subcategory = '';
            }

            if (isset($values["item_specific"])){
                foreach ($values["item_specific"] as $key=>$item_specific){
                    $counter = 0;
                    foreach(unserialize($result->variationProducts[0]->variation_specifics) as $name => $value){
                        if($name == $key){

                            $counter++;
                        }
                    }

                    if($counter == 0){
                        $item_specifics .='<NameValueList>
				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
			                      </NameValueList>';
                    }
//            return gettype($key);
                    //if ($item_specific !=null){

                    //}

                }

                $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
            }
            // echo "<pre>";
            // print_r($item_specifics);
            // exit();
            $variation = '';
            if($values['type'] == 'variable'){
                foreach ($values["productVariation"] as $index => $product_variation){
                    $variation = null;
                    $quantity = $product_variation['quantity'];
                    if(isset($values["custom_feeder_flag"])){
                        if ($values["custom_feeder_flag"]){
                            //$quantity = $request->custom_feeder_quantity;

                            $product = EbayVariationProduct::with('masterProduct')->where('id',$product_variation["ebay_variation_id"])->get()->first();
                            if ($quantity >= $values["custom_feeder_quantity"]){
                                $quantity = $values["custom_feeder_quantity"];
                            }else{
                                $quantity = $product_variation['quantity'];
                            }

                        }
                    }else{
                        $quantity = $product_variation['quantity'];
                    }
                    $attribute = '';
                    foreach ($product_variation["attribute"] as $key => $value){
                        $attribute .= '<NameValueList>
						<Name>'.'<![CDATA['.$key.']]>'.'</Name>
						<Value>'.'<![CDATA['.$value.']]>'.'</Value>
					</NameValueList>';
                    }


                    $variations .= '<Variation>
                 <DiscountPriceInfo>
                  <OriginalRetailPrice>'.$product_variation['rrp'].'</OriginalRetailPrice>
                </DiscountPriceInfo>
				<SKU>'.'<![CDATA['.$product_variation['sku'].']]>'.'</SKU>
				<StartPrice>'.$product_variation['start_price'].'</StartPrice>
				<Quantity>'.$quantity.'</Quantity>
				<VariationProductListingDetails>
                <EAN>'. $ean .'</EAN>

                </VariationProductListingDetails>
                <VariationSpecifics>'.$attribute.'</VariationSpecifics>
			</Variation>';
                }
                //return $request->productVariation;

                //return $request->attribute['Size'][0];
                $name_value = $this->getNameValue($values["attribute"]);
                $variation = '<Variations>'.'<VariationSpecificsSet>'.$name_value.'</VariationSpecificsSet>'

                    .$variations.'

		</Variations>';
            }



            //return $item_specifics;

            $body = '<?xml version="1.0" encoding="utf-8"?>
<VerifyAddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
  <Item>

		<Country>'.$values["country"].'</Country>
		<Currency>'.$values["currency"].'</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>'.$values["duration"].'</ListingDuration>
        <CrossBorderTrade>'.$values["cross_border_trade"].'</CrossBorderTrade>
		<!--Enter your Paypal email address-->

		<ConditionID>'.$condition[0].'</ConditionID>
		<PostalCode>'.$values["post_code"].'</PostalCode>
		<PrimaryCategory>
			<CategoryID>'.$values["last_cat_id"].'</CategoryID>
		</PrimaryCategory>'.$subcategory.'
		<Title>'.'<![CDATA['.$values["name"].']]>'.'</Title>
		<SubTitle>'.'<![CDATA['.$values["subtitle"].']]>'.'</SubTitle>
		'.$start_price.'
		<Description>'.'<![CDATA['.$template_result.']]>'.'</Description>
		<PictureDetails>'.$galleryPlus. $pictures
//			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
                .'</PictureDetails>

			'.$item_specifics.'
         <Storefront>
         '.$final_store.$final_store2.'


        </Storefront>

        '.$variation.'



       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>'.$values["shipping_id"].'</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>'.$values["return_id"].'</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>'.$values["payment_id"].'</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>

	</Item>
</VerifyAddFixedPriceItemRequest>';

            $url = 'https://api.ebay.com/ws/api.dll';

            $headers = [
                'X-EBAY-API-SITEID:'.$values["site_id"],
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:VerifyAddFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

            ];

                $result = $this->curl($url,$headers,$body,'POST');
            $result =simplexml_load_string($result);
            $result = json_decode(json_encode($result),true);
            // return $result;
            if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success'){
//                $fees[$profile]=[ $result["Fees"]["Fee"]];
                $fees=[ $result["Fees"]["Fee"]];
                return  response()->json(["fees"=> $fees,"profile_id" => $profileId]);

            }else{
                return response()->json(["message" => $result['Errors']]);
            }



            return redirect('ebay-master-product-list')->with('success','successfully added');
        }



//        return $request->productVariation[0]["attribute"][0]["attribute_name"];


    }

//    public function WebCheck(){
//        $url = 'https://api-ap2.pusher.com/apps/1292300/events?body_md5=2c99321eeba901356c4c7998da9be9e0&auth_version=1.0&auth_key=c8425e2ceaf4d34a38d2&auth_timestamp=1636019534&auth_signature=cdd6b61ff25805e46ddee56b6a90db67c8844ea38c79874c86abc1dc5a09c859&';
//        $body = '{"data":"{"message":"hello world"}","name":"my-event","channel":"my-channel"}';
//        $headers = [
//            'Content-Type: application/json'
//        ];
//
////                            echo "<pre>";
////                print_r($store2);
////            echo "<pre>";
////                print_r($body);
////                exit();
////            return $body;
//        $result = $this->curl($url,$headers,$body,'POST');
//        return $result;
//    }

    public function createEbayProduct(Request $request){

//        return $request->cross_border_trade;
//        return \response()->json(isset($request->private_listing));
//        echo $request['p_id'];
//        echo "<pre>";
//        print_r($request->all());
//        exit();
        $ebay_master_product_id = ProductDraft::where('id' , $request->product_id)->first();
//        $ebay_master_product_id = EbayMasterProduct::where('id' , 7502)->first();

        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

        // $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
        // $clientListingLimit = $this->ClientListingLimit();

        //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

//        echo "<pre>";
////        print_r(\Opis\Closure\unserialize($variation_images[0]->image_attribute));
////        foreach (\Opis\Closure\unserialize($variation_images[0]->image_attribute) as $key => $value){
////            print_r($value);
////        }
//        print_r(\Opis\Closure\unserialize($ebay_master_product_id->variation_images));
//        exit();
        $this->ebay_variation_images = array();
        $variation_images = null;
        if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
            return redirect('create-ebay-product/'.$ebay_master_product_id->id);
        }else{
            $image_array = [];
            $newProfileImageArr = $request->newUploadImage;
            if(isset($request->newUploadImage) && count($request->newUploadImage) > 0){
                foreach($request->newUploadImage as $profileId => $images){
                    $folderPath = 'uploads/product-images/';
                    if(isset($newProfileImageArr[$profileId])){
                        foreach($images as $imageName => $imageContent){
                            if(isset(explode(".", $imageName)[1])){

                                $updatedImageName = $this->base64ToImage($request->id, $imageName, $imageContent, $folderPath);
                                $imagePath = asset($folderPath.$updatedImageName);
                                $info = pathinfo($imagePath);
                                $image_name =  basename($imagePath,'.'.$info['extension']);
                                $ext = explode(".", $imagePath);
                                $image_type = end($ext);
                                if($image_type == "webp"){
                                    $ext = str_replace("webp","jpg",$image_type);
                                    $name_str = $image_name . '.' . $ext;
                                    $imagePath = $name_str;
                                }

                                    $image_array[$profileId][] = str_replace(' ','-',$imagePath);
                            }else{
                                $info = pathinfo($imageContent);
                                $image_name =  basename($imageContent,'.'.$info['extension']);
                                $ext = explode(".", $imageContent);
                                $image_type = end($ext);
                                if($image_type == "webp"){
                                    $ext = str_replace("webp","jpg",$image_type);
                                    $name_str = $image_name . '.' . $ext;
                                    $imageContent = asset($folderPath.$name_str);
                                }
                                $image_array[$profileId][] = str_replace(' ','-',$imageContent);



                            }

                            // $imageName = $image->getClientOriginalName();
                            // $key = array_search($imageName,$newProfileImageArr[$profileId]);
                            // if($key !== FALSE){
                            //     $ImageArr[] = $imageName;
                            //     $name = $request->product_id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                            //     $name .= str_replace(['&',' '],'-',$imageName);
                            //     $image->move('uploads/product-images/', $name);
                            //     $image_url = asset('uploads/product-images/' . $name);
                            //     $newProfileImageArr[$profileId][$key] = $image_url;
                            // }
                        }



                            // if($request->newUploadImage != null){
                            //     foreach($request->newUploadImage as $imageName => $imageContent){
                            //         if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                            //             $updatedImageName = $this->base64ToImage($id, $imageName, $imageContent, $folderPath);
                            //             $image_array[] = asset($folderPath.$updatedImageName);
                            //         }else{
                            //             $image_array[] = $imageContent;
                            //         }
                            //     }
                            // }





                            // else{
                            //     $newProfileImageArr[$profileId][$key] = 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482953.jpg';
                            // }

                            // foreach($request->newUploadImage as $imageName => $imageContent){
                            //     if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                            //         $updatedImageName = $this->base64ToImage($productDraft->id, $imageName, $imageContent, $folderPath);
                            //         $image_array[] = asset($folderPath.$updatedImageName);
                            //     }else{
                            //         $image_array[] = $imageContent;
                            //     }
                            // }
                    }
                }
            }

            $request['image'] = $image_array;
            // echo '<pre>';
            // print_r($request['image']);
            // exit();

    //        foreach ($request->profile as $profile){
    //            echo $profile;
    //        }
    //        exit();


        //    echo "<pre>";
        //    print_r($request->all());
        //    exit();


            $pictures = '';
            $item_specifics = '';
            $variations ='';
            $attribute = '';
            $name_value = '';
            $image_variation = '';
            $ean = '';
            $galleryPlus = '';
            $subcategory = '';
            $category2 = null;
            $eps = '';
            $full_variation = null;

    //        $template_result = 'this is a test product';

            if (isset($request->child_cat2[1])){
                foreach ($request->child_cat2 as $category_request){
                    $category2_array =$this->stringConverter->separateStringToArray($category_request);// explode('/',$category_request);
                    $category2 .= '>'.$category2_array[1];
                }
            }

            if (isset($request->item_specific)){
                foreach ($request->item_specific as $key=>$item_specific){
    //            return gettype($key);
                    //if ($item_specific !=null){
                    $item_specifics .='<NameValueList>
                                        <Name>'.'<![CDATA['.$key.']]>'.'</Name>
                                        <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
                                      </NameValueList>';
                    //}

                }

                $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
            }

            $variation_specifics = array();
            $master_product_find_result = ProductDraft::where('id' , $request->product_id)->first();
            if ($request->type == 'variable'){
                $variation_images = DB::table('product_variation')->where('product_draft_id',$request->product_id)->select('variation_images','image_attribute')->groupBy('image_attribute')
                    ->get();
//                foreach ($request->productVariation as $product_variation){
//                    foreach (\Opis\Closure\unserialize($master_product_find_result->attribute) as $attribute_id => $attribute_array){
//
//                        foreach ($attribute_array as $attribute_name => $terms_array){
//    //                echo "<pre>";
//    //                print_r($terms);
//    //                exit();
//                            foreach ($terms_array as $terms){
//                                $variation_specifics[$attribute_name][] =$terms["attribute_term_name"];
//                                $variation_image[$attribute_name][$terms["attribute_term_name"]][] = $product_variation['image'];
//                            }
//
//                        }
//
//                    }
//                }
            }


            $item_specific =\Opis\Closure\serialize($request->item_specific);
            $start_price = '<StartPrice>'.$request->start_price.'</StartPrice>';
            if ($request->type == 'variable'){
                $variation_specifics =\Opis\Closure\serialize($variation_specifics);
                $start_price = '';
            }

            if ($request->condition_id){
                $condition = $this->stringConverter->separateStringToArray($request->condition_id);

            }
            if (isset($request->last_cat2_id)){
                $subcategory = '<SecondaryCategory>
          <CategoryID>'.$request->last_cat2_id.'</CategoryID>
        </SecondaryCategory>';
            }else{
                $subcategory = '';
            }

            if ($request->eps == 'Vendor'){
                $eps = '<PictureDetailsType>Vendor</PictureDetailsType>';
            }else{
                $eps = '';
            }


            foreach ($request->profile as $profile){
                $pictures ='';
                $profile_info = EbayProfile::find($profile);
                $tracker_array = array();
                $tracker_array['title_flag'] = $request->title_flag[$profile] ?? 0;
                $tracker_array['description_flag'] = $request->description_flag[$profile] ?? 0;
                $tracker_array['image_flag'] = $request->image_flag[$profile] ?? 0;
                $tracker_array['feeder_flag'] = $request->custom_feeder_flag[$profile] ?? 0;

                $name = $request->name[$profile];
                $description = $request->description[$profile];
                $images = $request->image[$profile];
                if ($request->type == 'variable'){
                    $full_variation = $this->getFullVariation($request->productVariation,$request->custom_feeder_quantity[$profile] ?? 0,$request->custom_feeder_flag[$profile] ?? 0,$request->attribute,$request->image_attribute,$request->product_id);

                }else{
                    $ean = $request->productVariation[0]['ean'] ?? 'Does not apply';
                    $full_variation = '<ProductListingDetails><EAN>'.$ean.'</EAN></ProductListingDetails><SKU>'.'<![CDATA['.$request->productVariation[0]['sku'].']]>'.'</SKU>';
                }

    //          $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$request->product_id )->get();
                $template_result =  EbayTemplate::find($profile_info->template_id);
                $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
                $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));

                $ebay_access_token = $this->getAuthorizationToken($profile_info->account_id);


    //            if (isset($profile_info->store_id)){
    //                $store_one = $profile_info->store_id;
    //                //$store_one = explode("/", $store_one);
    //                //(int)$store = $store_one[0];
    //                $final_store='<StoreCategoryID>'.$store_one.'</StoreCategoryID>';
    //
    //            }else{
    //                $final_store='';
    //            }
    //            if ($profile_info->store2_id != null){
    //                $store_two = $profile_info->store2_id;
    //                //$store_two = explode("/", $store_two);
    //                //(int)$store2 = $store_two[0];
    //                $final_store2='<StoreCategory2ID>'.$store_two.'</StoreCategory2ID>';
    //            }else{
    //                $final_store2= '';
    //            }
                if (isset($request->store_id[$profile])){
                    $store_one = $this->stringConverter->separateStringToArray($request->store_id[$profile]);
                    (int)$store = $store_one[0];
                    $final_store='<StoreCategoryID>'.$store.'</StoreCategoryID>';

                }else{
                    $final_store='';
                }
                if (isset($request->store2_id[$profile])){
                    $store_two =$this->stringConverter->separateStringToArray($request->store2_id[$profile]);
                    (int)$store2 = $store_two[0];
                    $final_store2='<StoreCategory2ID>'.$store2.'</StoreCategory2ID>';
                }else{
                    $final_store2= '';
                }

                if(isset($request->image[$profile])){
                    foreach ($request->image[$profile] as $image){

                        $pictures .='<PictureURL>'.'<![CDATA['.$image.']]>'.'</PictureURL>';
                    }
                }else{
                    $pictures .='<PictureURL>'.'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482930.jpg'.'</PictureURL>';
                }
                if (isset($request->galleryPlus[$profile])){
                    $galleryPlus = '<GalleryType>Plus</GalleryType>';
                }else{
                    $galleryPlus = '';
                }

                if($request->condition_id == 1000){
                    $condition_des = '';
                }else{
                        $condition_des = $request->condition_description;
                }

                // echo $condition_des;
                // exit();


                $body = '<?xml version="1.0" encoding="utf-8"?>
    <AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
        <Item>
            <Country>'.$profile_info->country.'</Country>
            <Currency>'.$profile_info->currency.'</Currency>
            <DispatchTimeMax>3</DispatchTimeMax>
            <ListingDuration>'.$profile_info->duration.'</ListingDuration>
            <ListingType>FixedPriceItem</ListingType>
            <ConditionID>'.$condition[0].'</ConditionID>
            <ConditionDescription>'.$condition_des.'</ConditionDescription>
            <CrossBorderTrade>'.$request->cross_border_trade[$profile].'</CrossBorderTrade>
            <PostalCode>'.$profile_info->post_code.'</PostalCode>
            <PrivateListing>'.(isset($request->private_listing[$profile]) ? "true" : "false").'</PrivateListing>
            <PrimaryCategory>
                <CategoryID>'.$profile_info->category_id.'</CategoryID>
            </PrimaryCategory>
            '.$subcategory.'
            <Title>'.'<![CDATA['.$request->name[$profile].']]>'.'</Title>
            <SubTitle>'.'<![CDATA['.$request->subtitle[$profile].']]>'.'</SubTitle>
            <Description>'.'<![CDATA['.$template_result.']]>'.'</Description>
            '.$start_price.'
            <PictureDetails>'.$galleryPlus. $pictures
    //			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
    //			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
    //			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
                    .$eps.'</PictureDetails>


                '.$item_specifics.'
             <Storefront>
             '.$final_store.$final_store2.'


            </Storefront>
            '.$full_variation.'

              <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
                 instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
             For help, see the API Reference for Business Policies:
                 https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->

           <SellerProfiles>
                  <SellerShippingProfile>
                        <ShippingProfileID>'.$profile_info->shipping_id.'</ShippingProfileID>
                      </SellerShippingProfile>
                  <SellerReturnProfile>
                        <ReturnProfileID>'.$profile_info->return_id.'</ReturnProfileID>
                  </SellerReturnProfile>
                  <SellerPaymentProfile>
                        <PaymentProfileID>'.$profile_info->payment_id.'</PaymentProfileID>
                  </SellerPaymentProfile>
           </SellerProfiles>
        </Item>
    </AddFixedPriceItemRequest>';
    // return $body;
                //$logInsertData = $this->paramToArray(url()->full(),'Create Ebay product','Ebay',$profile_info->account_id,$body,null,Auth::user()->name,null,null, \Illuminate\Support\Carbon::now(),);
                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$profile_info->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:AddFixedPriceItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];

    //                            echo "<pre>";
    //                print_r($store2);
//                echo "<pre>";
//                    print_r($body);
//                    exit();
    //            return $body;
                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);

//                echo "<pre>";
//                    print_r($result["Fees"]["Fee"][14]["Fee"]);
//                    exit();
                if (isset($result['ItemID'])){
                    $campaign_array = array();
                    //$updateResponse = $this->updateResponse('response_data',$result);
    //                if (1==1){
    //                sleep(15);
    //                //        campaign starts
    //                $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/'.$request->campaign_id.'/bulk_create_ads_by_listing_id';
    //                $headers = [
    //                    'Authorization:Bearer '.$ebay_access_token,
    //                    'Accept:application/json',
    //                    'Content-Type:application/json'
    //                ];
    //                $body ='{
    //                            "requests": [
    //                                {
    //                                    "bidPercentage": "'.$request->bid_rate.'",
    //                                    "listingId": "'.(string)$result['ItemID'].'"
    //                                }
    //                            ]
    //                        }';
    //                $campaigns = $this->curl($url,$headers,$body,'POST');
    //                $campaigns = \GuzzleHttp\json_decode($campaigns);

                    $campaign_array = array();
                    if(isset($request->campaign_id[$profile]) && isset($request->bid_rate[$profile])){
                        $campaign_array = [
                            "campaignId" =>$request->campaign_id[$profile],
                            "bidPercentage" => $request->bid_rate[$profile]
                        ];
                    }

    //        campaign ends
                    if (isset($request->image[$profile])){
                        $mater_images = \Opis\Closure\serialize($request->image[$profile]);
                    }else{
                        $mater_images = '';
                    }
    //                echo "<pre>";
    //                print_r($campaign_array);
    //                exit();
                    $ebayMasterPID = EbayMasterProduct::onlyTrashed()->where('master_product_id', $request->product_id)->first();
                    if($ebayMasterPID){
                        $ebay_permanent_delete = EbayMasterProduct::onlyTrashed()->where('id',$ebayMasterPID['id'])->forceDelete();
                    }
                    $master_product_result = EbayMasterProduct::create(['item_id' => $result['ItemID'] ,'account_id' => $profile_info->account_id,'master_product_id' => $request->product_id,'site_id' => $profile_info->site_id ?? null, 'creator_id' => Auth::user()->id ?? null,'campaign_status' => isset($request->campaign_checkbox) ? 0 : 1,'campaign_data'=> isset($request->campaign_checkbox) ? \Opis\Closure\serialize($campaign_array) : '',
                        'title' => $request->name[$profile],'description' =>$request->description[$profile],'item_description' => $template_result,'variation_specifics' => is_array($variation_specifics) ?  null : $variation_specifics,'master_images' => $mater_images,'variation_images' => \Opis\Closure\serialize($this->ebay_variation_images) ?? null,'dispatch_time' => 3,
                        'product_type' => 'FixedPrice','product_status' => 'Active','start_price' => $request->start_price ?? 0.0,'condition_id' => $condition[0] ?? '','condition_name' => $condition[1] ?? '','condition_description' => $condition_des ?? '', 'category_id' => $profile_info->category_id, 'sub_category_id' => $request->last_cat2_id,'category_name' => $profile_info->category_name,'sub_category_name' => isset($category2) ? $category2 : $request->sub_category_name,'store_id' => $store ?? null,
                        'store_name' => $store_one[1] ?? null,'store2_id' => $store2 ?? null,'currency' => $profile_info->currency,'store2_name' => $store_two[1] ?? null,'duration' => $profile_info->duration,'location' => $profile_info->location,'country' => $profile_info->country,'post_code' => $profile_info->post_code,"cross_border_trade" => $request->cross_border_trade[$profile] ?? null,
                        'item_specifics' => $item_specific,'shipping_id' => $profile_info->shipping_id,'return_id' => $profile_info->return_id,'payment_id' => $profile_info->payment_id,'image_attribute'=>$request->image_attribute ?? '','profile_id' => $profile,'draft_status' => \Opis\Closure\serialize($tracker_array),'custom_feeder_quantity'=>$request->custom_feeder_quantity[$profile],'campaign' => $campaign_array,'subtitle' => $request->subtitle[$profile] ?? '', "galleryPlus" => $request->galleryPlus[$profile] ?? 0,'eps' => $request->eps ?? '','type' => $request->type,'private_listing' => isset($request->private_listing[$profile]) ? 1 : 0,'fees' => serialize($result["Fees"]["Fee"][14]) ?? null]);


                        foreach ($request->productVariation as $key => $product_variation){
                            $variation_specifics = null;
                            if($request->type == 'variable'){
                                foreach ($product_variation["attribute"] as $attribute){

                                    $variation_specifics[$attribute["attribute_name"]] =$attribute["terms_name"];
                                }
                            }

                            $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                            $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $master_product_result->id,'master_variation_id' => $product_variation['variation_id'],
                                'sku' => $product_variation['sku'],'variation_specifics' => $variation_specifics, 'start_price' => $product_variation['start_price'],'rrp'=> $product_variation['rrp'],'quantity' => $product_variation['quantity'],
                                'ean' => $product_variation['ean']]);
                        }



                }else{
                    return $result;//redirect('ebay-master-product-list')->with('error',$result['Errors']['LongMessage']);
                }
            }

            return redirect('ebay-master-product-list')->with('success','successfully added');


    //        return $request->productVariation[0]["attribute"][0]["attribute_name"];
        }
    }
    public function checkCampaign(){
        $products = EbayMasterProduct::where('campaign_status',0)->get();

        foreach ($products as $product){
            if ($product->campaign_data != null){

                    try{
                        $ebay_access_token = $this->getAuthorizationToken($product->account_id);
                        $campaigns_array = \Opis\Closure\unserialize($product->campaign_data);
//                        echo "<pre>";
//                        print_r($campaigns_array);
//                        exit();
                        if (isset($campaigns_array["campaignId"]) && isset($campaigns_array["bidPercentage"])) {
                            //                //        campaign starts
                            $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/' . $campaigns_array["campaignId"] . '/bulk_create_ads_by_listing_id';
                            $headers = [
                                'Authorization:Bearer ' . $ebay_access_token,
                                'Accept:application/json',
                                'Content-Type:application/json'
                            ];
                            $body = '{
                            "requests": [
                                {
                                    "bidPercentage": "' . $campaigns_array["bidPercentage"] . '",
                                    "listingId": "' . (string)$product->item_id . '"
                                }
                            ]
                        }';

                            $campaigns = $this->curl($url, $headers, $body, 'POST');
                            $campaigns = \GuzzleHttp\json_decode($campaigns);


                            $campaigns = $this->curl($url, $headers, $body, 'POST');
                            $campaigns = \GuzzleHttp\json_decode($campaigns);
                            if(isset($campaigns->responses[0]->adId) && isset($campaigns_array["href"])){
                                $campaigns_array["adId"] = $campaigns->responses[0]->adId;
                                $campaigns_array["href"] = $campaigns->responses[0]->href;
                            }
                            // echo "<pre>";
                            // print_r($campaigns->responses[0]->adId);

                            // exit();

                            if(isset($campaigns->responses[0]->statusCode)){
                                if ($campaigns->responses[0]->statusCode == '201') {
                                    EbayMasterProduct::where('item_id', $product->item_id)->update(['campaign_status' => 1,'campaign_data' => serialize($campaigns_array)]);
                                }
                            }else{
                                EbayMasterProduct::where('item_id', $product->item_id)->update(['campaign_status' => 1,'campaign_data' => serialize($campaigns_array)]);
                            }
                        }
                    }catch (Exception $exception){
                        continue;
                    }


            }

//            campaigns ends
        }

    }
    public function getFullVariation($variations,$quantity,$flag,$attributes,$image_attributes,$product_draft_id){
        $variations = $this->getProductVariation($variations,$quantity,$flag);
        $name_value = $this->getNameValue($attributes);
        $image_variation = $this->getImageVariation($image_attributes,$product_draft_id);
        $full_variation = '<Variations>
			<VariationSpecificsSet>
				'.$name_value.'
			</VariationSpecificsSet>
			'.$variations.$image_variation.'

		</Variations>';
        return $full_variation;
    }
    public function getNameValue($attributes){

        $name_value = '';
        $name_value_array = array();
        foreach ($attributes as $key => $values){
            $name_value .='<NameValueList>
                            <Name>'.$key.'</Name>';
            foreach ($values as $value){
                if (!in_array($value, $name_value_array))
                {
                    array_push($name_value_array, (string)$value);
                    $name_value .=  '<Value>'.$value.'</Value>';
                }
            }
            $name_value .= '</NameValueList>';
        }

        return $name_value;
    }
    public function getImageVariation($image_attributes,$product_draft_id){
        $counter = 0;
        $image_variation = '';
        $image_variation_array = array();
        $variation_image = ProductVariation::where('product_draft_id',$product_draft_id)->select('variation_images','image_attribute')->groupBy('image_attribute')
            ->get();
        $base_url = $this->url->to('/').'/';
        if ($image_attributes != null && isset($variation_image)){
            $image_variation.='<Pictures>
				<VariationSpecificName>'.$image_attributes.'</VariationSpecificName>';

            foreach ($variation_image as $value){

                if($value->variation_images != null){
                    $variation_images = \Opis\Closure\unserialize($value->variation_images);
                    foreach (\Opis\Closure\unserialize($value->image_attribute) as $terms){
                        $image_variation.=  '<VariationSpecificPictureSet>
    					<VariationSpecificValue>'.'<![CDATA['.$terms.']]>'.'</VariationSpecificValue>';
                    }

                    if(is_array($variation_images) && count($variation_images) > 0){
                        foreach ($variation_images as $image_url){
                            $image_variation_array[$terms][] =$image_url;
                            $image_variation.='<PictureURL>'.$base_url.$image_url.'</PictureURL>';
                        }
                    }
                    $image_variation.='</VariationSpecificPictureSet>';
                }

            }
            $this->ebay_variation_images[$image_attributes]=$image_variation_array;
            $image_variation .= '</Pictures>';

//            foreach ($variation_image as $key1 => $value1){
//
//                if ($key1 == $image_attributes){
//
//                    foreach ($value1 as $key2 => $value2){
//
//                        $image_variation.=  '<VariationSpecificPictureSet>
//					<VariationSpecificValue>'.'<![CDATA['.$key2.']]>'.'</VariationSpecificValue>';
//
//                        foreach ($value2 as $value3){
//                            if(isset($value3)){
//                                $counter++;
//                            }
//                            if (!in_array($value2, $image_variation_array))
//                            {
//                                array_push($image_variation_array, $key2);
//                                $image_variation.='<PictureURL>'.$value3.'</PictureURL>';
//                            }
//                            break;
//                        }
//
//                        $image_variation.='</VariationSpecificPictureSet>';
//                    }
//                }
//
//            }


//            $image_variation .= '</Pictures>';
        }


//        if($counter == 0){
//            $image_variation = '';
//        }
        return $image_variation;
    }

    public function getProductVariation($productVariations,$feeder_quantity,$flag){
        $variations='';
        $quantity=0;
        foreach ($productVariations as $product_variation){
            if ($flag){
                $ebay = new CheckQuantity();
                $available_quantity = $ebay->getShelfQuantity($product_variation["variation_id"]);
                if ($available_quantity >= $feeder_quantity){
                    $quantity = $feeder_quantity;
                }else{
                    $quantity = $available_quantity;
                }

            }else{
                $quantity = $product_variation['quantity'];
            }
            $attribute = '';

            foreach ($product_variation["attribute"] as $product_variation_attribute){
                $attribute .= '<NameValueList>
						<Name>'.'<![CDATA['.$product_variation_attribute["attribute_name"].']]>'.'</Name>
						<Value>'.'<![CDATA['.$product_variation_attribute["terms_name"].']]>'.'</Value>
					</NameValueList>';
            }
            if (isset($product_variation['ean'])){
                $ean = $product_variation['ean'];
            }else{
                $ean = 'Does not apply';
            }
            $variations .= '<Variation>
                <DiscountPriceInfo>
                  <OriginalRetailPrice>'.$product_variation['rrp'].'</OriginalRetailPrice>

                </DiscountPriceInfo>
				<SKU>'.'<![CDATA['.$product_variation['sku'].']]>'.'</SKU>
				<StartPrice>'.$product_variation['start_price'].'</StartPrice>
				<Quantity>'.$quantity.'</Quantity>
				<VariationProductListingDetails>
                <EAN>'. $ean .'</EAN>

                </VariationProductListingDetails>
				<VariationSpecifics>'
                .$attribute.'
				</VariationSpecifics>
			</Variation>';
        }
        return $variations;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shelfUse = $this->shelf_use;
        $single_master_product_details = EbayMasterProduct::with(['variationProducts'])->find($id);
        return view('ebay.master_product.master_product_details',compact('single_master_product_details','shelfUse'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = EbayMasterProduct::with(['variationProducts'])->find($id);

        $ebay_access_token = $this->getAuthorizationToken($result->account_id);

        $account_result = EbayAccount::get()->all();

        $return_policies = ReturnPolicy::where('account_id',$result->account_id)->get()->all();

        $shipment_policies = ShipmentPolicy::where('account_id',$result->account_id)->get()->all();

        $payment_policies = PaymentPolicy::where('account_id',$result->account_id)->get()->all();

        $paypal_accounts = EbayPaypalAccount::where('account_id',$result->account_id)->get()->all();

        $currency = DB::table('ebay_currency')->get();

        $countries = Country::get()->all();

        $item_specific_results = \Opis\Closure\unserialize($result->item_specifics);

//        echo "<pre>";
//        print_r($item_specific_results);
//        exit();
        $master_images = \Opis\Closure\unserialize($result->master_images);
        $variation_specifics = null;
        if ($result->type == 'variable'){
            $variation_specifics = \Opis\Closure\unserialize($result->variation_specifics);
        }

//        echo "<pre>";
//        print_r($result->account_id);
//        print_r($return_policies);
//        print_r($result->return_id);
//
//        exit();


//        session start
//        $clientID  = $account_result[0]->developerAccount->client_id;
//        $clientSecret  = $account_result[0]->developerAccount->client_secret;
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
//            'refresh_token' => $account_result[0]->refresh_token,
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
//        session ends

        //        campaign starts
        $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign';
        $headers = [
            'Authorization:Bearer '.$ebay_access_token,
            'Accept:application/json',
            'Content-Type:application/json'
        ];
        $body ='';
        $campaigns = $this->curl($url,$headers,$body,'GET');
        $campaigns = \GuzzleHttp\json_decode($campaigns);

//        campaign ends

//        start suggested rate
        $sites = EbaySites::find($result->site_id);

        $url = 'https://api.ebay.com/sell/recommendation/v1/find?filter=recommendationTypes:{AD}&offset=0&limit=25';
        $headers = [
            'Authorization:Bearer ' . $ebay_access_token,
            'Accept:application/json',
            'Content-Type:application/json',
            'X-EBAY-C-MARKETPLACE-ID:'.$sites->global_id
        ];

        $body = '{
                    "listingIds": [
                        "'.$result->item_id.'"
                     ]
                    }';

        $campaign_suggested = $this->curl($url, $headers, $body, 'POST');
        $campaign_suggested = \GuzzleHttp\json_decode($campaign_suggested);
        $suggested_rate = $campaign_suggested->listingRecommendations[0]->marketing->ad->bidPercentages[1]->value ?? '';
//        end suggested rate
//        echo "<pre>";
//        print_r($campaign_suggested->listingRecommendations[0]->marketing->ad->bidPercentages[1]->value);
//        exit();
//        $url = Session::get('middleman').'api/get-category';
//        $headers = [];
//        $body =http_build_query(["site_id" => 2,"LevelLimit" => 1]) ;
//        $categories = $this->curl($url,$headers,$body,'POST');
//        $categories = json_decode($categories,true);
////        print_r(Session::get('middleman'));
////        exit();
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
//        get Category ends

        //        get store data starts
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:GetStore',
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
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
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
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
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
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

        return view('ebay.master_product.edit_master_product',compact('result','item_specifics','categories',
            'item_specific_results','return_policies','shipment_policies','payment_policies','paypal_accounts','suggested_rate',
            'currency','shop_categories','conditions','master_images','variation_specifics','countries','campaigns'));
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
//        return $request->suggested_rate;
//        echo "<pre>";
//        print_r($request->all());
//        print_r(isset($request->private_listing) ? 1 : 0);
//        exit();
        $image_array = [];
        $newProfileImageArr = $request->image;
        if(isset($request->newUploadImage) && count($request->newUploadImage) > 0){
            $folderPath = 'uploads/product-images/';
            if($request->newUploadImage != null){
                foreach($request->newUploadImage as $imageName => $imageContent){
                    if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){

                        $info = pathinfo($imageName);
                        $image_name =  basename($imageName,'.'.$info['extension']);
                        $ext = explode(".", $imageName);
                        $image_type = end($ext);
                        if($image_type == "webp"){
                            $ext = str_replace("webp","jpg",$image_type);
                            $name_str = $image_name . '.' . $ext;
                            $imageName = $name_str;
                        }

                        $updatedImageName = $this->base64ToImage($id, $imageName, $imageContent, $folderPath);
                        $image_array[] = asset($folderPath.$updatedImageName);
                    }else{
                        $image_array[] = $imageContent;
                    }
                }
            }
            // foreach($request->uploadImage as $image){
            //     $imageName = $image->getClientOriginalName();
            //     $key = array_search($imageName,$newProfileImageArr);
            //     if($key !== FALSE){
            //         $ImageArr[] = $imageName;
            //         $name = $id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
            //         $name .= str_replace(['&',' '],'-',$imageName);
            //         $image->move('uploads/product-images/', $name);
            //         $image_url = asset('uploads/product-images/' . $name);
            //         $newProfileImageArr[$key] = $image_url;
            //     }
            //     // else{
            //     //     $newProfileImageArr[$key] = 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482953.jpg';
            //     // }
            // }
        }
        // $regex = '|^https|';
        // $newImageArr = preg_grep($regex, $requestImageArr,PREG_GREP_INVERT);
        // $newProfileImageArr = array_diff_key($requestImageArr,$newImageArr);
        $request['image'] = $image_array;

        $result = EbayMasterProduct::with(['variationProducts'])->find($id);
        $campaign_result = $result;
//        echo "<pre>";
//        print_r($result);
//        exit();
        $ebay_access_token = $this->getAuthorizationToken($result->account_id);
        $ean = '';
        $pictures = '';
        $item_specifics = '';
        $variations ='';
        $category2 = '';
        $condition = '';
        $tracker_array['title_flag'] = $request->title_flag ?? 0;
        $tracker_array['description_flag'] = $request->description_flag ?? 0;
        $tracker_array['image_flag'] = $request->image_flag ?? 0;
        $tracker_array['feeder_flag'] = $request->custom_feeder_flag ?? 0;
        $fees = null;

        if (isset($request->store_id)){
            $store_one = $this->stringConverter->separateStringToArray($request->store_id);
            (int)$store = $store_one[0];
            $final_store='<StoreCategoryID>'.$store.'</StoreCategoryID>';

        }else{
            $final_store='';
        }
        if (isset($request->store2_id)){
            $store_two = $this->stringConverter->separateStringToArray($request->store2_id);

            (int)$store2 = $store_two[0];
            $final_store2='<StoreCategory2ID>'.$store2.'</StoreCategory2ID>';
        }else{
            $final_store2= '';
        }

        if (isset($request->condition_id)){
            $condition = $this->stringConverter->separateStringToArray($request->condition_id);

        }
        if ($request->eps == 'Vendor'){
            $eps = '<PictureDetailsType>Vendor</PictureDetailsType>';
        }else{
            $eps = '';
        }


//        $store_one = $request->store_id;
//        $store_two = $request->store2_id;
//        $store_one = explode("/", $store_one);
//        $store_two = explode("/", $store_two);
        if (isset($request->last_cat2_id)){
            $subcategory = '<SecondaryCategory>
      <CategoryID>'.$request->last_cat2_id.'</CategoryID>
    </SecondaryCategory>';
        }else{
            $subcategory = '';
        }

        $category = null;
        if (isset($product_variation['ean'])){
            $ean = $product_variation['ean'];
        }else{
            $ean = 'Does not apply';
        }
        if (isset($request->child_cat[1])){
            foreach ($request->child_cat as $category_request){
                $category_array = $this->stringConverter->separateStringToArray($category_request);
                $category .= '>'.$category_array[1];
            }
        }
        if (isset($request->child_cat2[1])){
            foreach ($request->child_cat2 as $category_request){
                $category2_array = $this->stringConverter->separateStringToArray($category_request);
                $category2 .= '>'.$category2_array[1];
            }
        }

//        $clientID  = $account_result[0]->developerAccount->client_id;
//        $clientSecret  = $account_result[0]->developerAccount->client_secret;
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
//            'refresh_token' => $account_result[0]->refresh_token,
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
//        echo '*****'. $store.'*********'.$store2;
//        24686732014;
//        23904411014;
//        exit();
        if(isset($request->image)){
            foreach ($request->image as $image){

                $pictures .='<PictureURL>'.'<![CDATA['.$image.']]>'.'</PictureURL>';
            }
        }

        $name = $request->name;
        $description = $request->description;
        $images = $request->image;
        $quantity = "";
        $profile_result =  EbayProfile::find($result->profile_id);
        $template_result =  EbayTemplate::find($profile_result->template_id);
        $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
        $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));



        if (isset($request->item_specific)){
            foreach ($request->item_specific as $key=>$item_specific){
                $counter = 0;
                if ($result->type == 'variable'){
                    foreach(\Opis\Closure\unserialize($result->variationProducts[0]->variation_specifics) as $name => $value){
                        if($name == $key){

                            $counter++;
                        }
                    }
                }


                if($counter == 0){
                    $item_specifics .='<NameValueList>
				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
			                      </NameValueList>';
                }
//            return gettype($key);
                //if ($item_specific !=null){

                //}

            }

            $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
        }

//         echo "<pre>";
//         print_r($item_specifics);
//         exit();


        foreach ($request->productVariation as $product_variation){
            $quantity = $product_variation['quantity'];
            if(isset($request->custom_feeder_flag)){
                if ($request->custom_feeder_flag){
                    //$quantity = $request->custom_feeder_quantity;

                    $product = EbayVariationProduct::with('masterProduct')->where('id',$product_variation["ebay_variation_id"])->get()->first();
                    if ($quantity >= $request->custom_feeder_quantity){
                        $quantity = $request->custom_feeder_quantity;
                    }else{
                        $quantity = $product_variation['quantity'];
                    }

                }
            }else{
                $quantity = $product_variation['quantity'];
            }



//            $attribute = '';
//            foreach ($product_variation["attribute"] as $attribute_value){
//                $attribute .= '<NameValueList>
//						<Name>'.$attribute_value["attribute_name"].'</Name>
//						<Value>'.$attribute_value["terms_name"].'</Value>
//					</NameValueList>';
//            }

//            foreach ($product_variation["attribute"] as $product_variation_attribute){
//                $attribute .= '<NameValueList>
//						<Name>'.$product_variation_attribute["attribute_name"].'</Name>
//						<Value>'.$product_variation_attribute["terms_name"].'</Value>
//					</NameValueList>';
//            }

//            if (isset($product_variation[Attribute::find(5)->attribute_name])){
//                $attribute .= '<NameValueList>
//						<Name>'.Attribute::find(5)->attribute_name.'</Name>
//						<Value>'.$product_variation[Attribute::find(5)->attribute_name].'</Value>
//					</NameValueList>';
//            }
//
//            if (isset($product_variation[Attribute::find(6)->attribute_name])){
//                $attribute .= '<NameValueList>
//						<Name>'.Attribute::find(6)->attribute_name.'</Name>
//						<Value>'.$product_variation[Attribute::find(6)->attribute_name].'</Value>
//					</NameValueList>';
//            }
//            if (isset($product_variation[Attribute::find(7)->attribute_name])){
//                $attribute .= '<NameValueList>
//						<Name>'.Attribute::find(7)->attribute_name.'</Name>
//						<Value>'.$product_variation[Attribute::find(7)->attribute_name].'</Value>
//					</NameValueList>';
//            }

//            <Quantity>'.$quantity.'</Quantity>
            $variations .= '<Variation>
                 <DiscountPriceInfo>
                  <OriginalRetailPrice>'.$product_variation['rrp'].'</OriginalRetailPrice>
                </DiscountPriceInfo>
				<SKU>'.'<![CDATA['.$product_variation['sku'].']]>'.'</SKU>
				<StartPrice>'.$product_variation['start_price'].'</StartPrice>

				<VariationProductListingDetails>
                <EAN>'. $ean .'</EAN>

                </VariationProductListingDetails>

			</Variation>';
        }
        $all_variation = null;
        if ($request->type == 'variable'){
            $all_variation = '<Variations>

			'.$variations.'

		</Variations>';
        }
        $simple_quantity = null;
        $start_price = null;
        if ($request->type == 'simple'){
            $simple_quantity = '<Quantity>'.$quantity.'</Quantity>';
            $start_price = '<StartPrice>'.$request->start_price.'</StartPrice>';
        }

        //return $request->productVariation;

        //return $request->attribute['Size'][0];


//        return $simple_quantity;
        if($request->condition_id == 1000){
            $condition_des = '';
        }else{
                $condition_des = $request->condition_description;
        }

        $body = '<?xml version="1.0" encoding="utf-8"?>
<ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
  <Item>
  <ItemID>'.$request->item_id.'</ItemID>
		<Country>'.$request->country.'</Country>
		<Currency>'.$request->currency.'</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>'.$request->duration.'</ListingDuration>

		<!--Enter your Paypal email address-->

		<ConditionID>'.$condition[0].'</ConditionID>
		<CrossBorderTrade>'.$request->cross_border_trade.'</CrossBorderTrade>
        <ConditionDescription>'.$condition_des.'</ConditionDescription>
		<PostalCode>'.$request->post_code.'</PostalCode>
		<PrivateListing>'.(isset($request->private_listing) ? "true" : "false").'</PrivateListing>
		<PrimaryCategory>
			<CategoryID>'.$request->last_cat_id.'</CategoryID>
		</PrimaryCategory>
		'.$start_price.'
		<Title>'.'<![CDATA['.$request->name.']]>'.'</Title>
		<SubTitle>'.'<![CDATA['.$request->subtitle.']]>'.'</SubTitle>
		<Description>'.'<![CDATA['.$template_result.']]>'.'</Description>
		'.$simple_quantity.'
		<PictureDetails>'. $pictures
//			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
            .$eps.'</PictureDetails>


			'.$item_specifics.'
         <Storefront>
         '.$final_store.$final_store2.'
        </Storefront>



			'.$all_variation.'




       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>'.$request->shipping_id.'</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>'.$request->return_id.'</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>'.$request->payment_id.'</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>

	</Item>
</ReviseFixedPriceItemRequest>';

        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:'.$request->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

        ];
//        return $body;
        $result = $this->curl($url,$headers,$body,'POST');
        $result =simplexml_load_string($result);
        $result = json_decode(json_encode($result),true);

        if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success'){

            if (isset($request->campaign_checkbox)){
                $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/'.$request->campaign_id.'/bulk_create_ads_by_listing_id';
                $headers = [
                    'Authorization:Bearer '.$ebay_access_token,
                    'Accept:application/json',
                    'Content-Type:application/json'
                ];
                $body ='{
                            "requests": [
                                {
                                    "bidPercentage": "'.$request->bid_rate.'",
                                    "listingId": "'.(string)$request->item_id.'"
                                }
                            ]
                        }';

                $campaigns = $this->curl($url,$headers,$body,'POST');
                $campaigns = \GuzzleHttp\json_decode($campaigns);


                if(isset($campaigns->responses[0]->statusCode)){
                    if ($campaigns->responses[0]->statusCode == '201') {
                        $campaigns_array = array();
                        $campaigns_array["campaignId"] = $request->campaign_id;
                        $campaigns_array["bidPercentage"] = $request->bid_rate;
                        $campaigns_array["suggestedRate"] = $request->suggested_rate ?? 0.0;
                        $campaigns_array["adId"] = $campaigns->responses[0]->adId;
                        $campaigns_array["href"] = $campaigns->responses[0]->href;

                        EbayMasterProduct::where('item_id', $request->item_id)->update(['campaign_status' => 1,'campaign_data' => serialize($campaigns_array)]);
                    }
                }

            }else{
//                echo "<pre>";
//                print_r(unserialize($result["campaign_data"])["campaignId"]);
//                exit();
                if ($campaign_result["campaign_data"] != null && $campaign_result["campaign_data"] != ""){
                    if (isset(unserialize($campaign_result["campaign_data"])["campaignId"])){
                        $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/'.unserialize($campaign_result["campaign_data"])["campaignId"].'/ad/'.unserialize($campaign_result["campaign_data"])["adId"];
                        $headers = [
                            'Authorization:Bearer '.$ebay_access_token,
                            'Accept:application/json',
                            'Content-Type:application/json'
                        ];
                        $body ='';

                        $campaigns = $this->curl($url,$headers,$body,'DELETE');


                        if($campaigns==null){
                            EbayMasterProduct::where('item_id', $request->item_id)->update(['campaign_status' => 1,'campaign_data' => null]);
                        }else{
                            $campaigns = \GuzzleHttp\json_decode($campaigns);
                            return $campaigns;
                        }
                    }

                }

            }
            $product = EbayMasterProduct::with(['variationProducts'])->find($id);
            // $campaign_array = array();
            // if (isset($product->campaign_data)){
            //     $campaign_array = \Opis\Closure\unserialize($product->campaign_data);
            //     $campaign_array['campaignId'] = $request->campaign_id;
            //     $campaign_array['bidPercentage'] = $request->bid_rate;
            // }

            $item_specific =\Opis\Closure\serialize($request->item_specific);
            if (isset($request->total_fees)){
                $fees=[
                    "Fee" => $request->total_fees
                ] ;
            }
            $master_product_result = EbayMasterProduct::where('item_id', $result['ItemID'])->update(['account_id' => $request->account_id,'site_id' => $request->site_id, 'modifier_id' => Auth::user()->id,
                'title' => $request->name,'description' => $request->description,'item_description' => $request->description,'dispatch_time' => 3,"cross_border_trade" => $request->cross_border_trade ?? null,
                'product_type' => 'FixedPrice','start_price' => $request->start_price ?? 0.0,'condition_id' => $condition[0] ?? NULL,'condition_name' => $condition[1] ?? NULL,'category_name' => isset($category) ? $category : $request->current_category,'sub_category_name' => isset($category2) ? $category2 : $request->current_sub_category,'condition_description' => $condition_des ?? NULL, 'category_id' => $request->last_cat_id, 'sub_category_id' => $request->last_cat2_id ?? '','store_id' => $store ?? null,
                'store_name' => $store_one[1] ?? null,'store2_id' => $store2 ?? null,'currency' => $request->currency,'store2_name' => $store_two[1] ?? null,'duration' => $request->duration,'location' => $request->location,'country' => $request->country,'post_code' => $request->post_code,
                'master_images' => \Opis\Closure\serialize($image_array),'item_specifics' => $item_specific,'shipping_id' => $request->shipping_id,'return_id' => $request->return_id,'payment_id' => $request->payment_id,'custom_feeder_quantity' => $request->custom_feeder_quantity,'paypal' => $request->paypal ?? null,'draft_status' => \Opis\Closure\serialize($tracker_array),'eps' => $request->eps ?? '','type' => isset($request->type) ? $request->type : 'variable','private_listing' => isset($request->private_listing) ? 1 : 0,'fees' => serialize($fees) ?? null]);

        }else{
            return $result;
        }

        return redirect('ebay-master-product-list')->with('success','successfully edited');
    }
    public function relistEndItem(Request $request){

        foreach ($request->products as $product){
            try{
                $ebay = EbayMasterProduct::with(['variationProducts'])->find($product);


                $ebay_access_token = $this->getAuthorizationToken($ebay->account_id);
                $body = '<?xml version="1.0" encoding="utf-8"?>
                        <RelistItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <Item>
                          <ItemID>'.$ebay->item_id.'</ItemID>

                            </Item>
                        </RelistItemRequest>';

                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$ebay->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:RelistItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];

                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);
                if (isset($result["ItemID"])){
                    $ebay->item_id = $result["ItemID"];
                    $ebay->product_status = "Completed";
                    $ebay->save();
                }
            }catch (\PHPUnit\Exception $exception){
                continue;
            }

        }
        return redirect('ebay-master-product-list');

    }
    public function deleteVariation($id,$sku){
        $result = EbayMasterProduct::with(['variationProducts'])->find($id);
        $this->deleteEbayVariation($sku);

        $account_result = EbayAccount::find($result->account_id);

        $this->ebayAccessToken($account_result->refresh_token);
        $url = 'https://api.ebay.com/ws/api.dll';
        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
        ];

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$result->item_id.'</ItemID>
                        <Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                          <Delete>true</Delete>
                            <SKU>'.$sku.'</SKU>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

        $update_ebay_product = $this->curl($url,$headers,$body,'POST');
//        echo "<pre>";
//        print_r($result->variationProducts);
//        exit();
        $result = EbayVariationProduct::where('sku' , $sku)->where('ebay_master_product_id',$id)->update(['deleted_at' => Carbon::now()]);

        return back()->with('success','Successfully Deleted');

    }
    public function variationEdit($id){

        $result = EbayVariationProduct::with('masterProduct')->find($id);
        $variations = \Opis\Closure\unserialize($result->variation_specifics);
        $item_id = $result->masterProduct->item_id;
        $account_id = $result->masterProduct->account_id;
        $site_id = $result->masterProduct->site_id;
//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($result->masterProduct->variation_images));
//        exit();
        return view('ebay.master_product.ebay_variation_edit',compact('result','variations','item_id','account_id','site_id'));
    }
    public function variationUpdate(Request $request,$id){

        $variations = '';
        $account_result = EbayAccount::find($request->account_id);

         $this->ebayAccessToken($account_result->refresh_token);
        $variations .= '<Variation>
                 <DiscountPriceInfo>
                  <OriginalRetailPrice>'.$request->rrp.'</OriginalRetailPrice>
                </DiscountPriceInfo>
                <SKU>'.$request->sku.'</SKU>
				<StartPrice>'.$request->start_price.'</StartPrice>
			</Variation>';
        $body = '<?xml version="1.0" encoding="utf-8"?>
<ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
  <Item>
  <ItemID>'.$request->item_id.'</ItemID>


        <Variations>

			'.$variations.'

		</Variations>

	</Item>
</ReviseFixedPriceItemRequest>';

        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:'.$request->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,

        ];

        $result = $this->curl($url,$headers,$body,'POST');
        $result =simplexml_load_string($result);
        $result = json_decode(json_encode($result),true);

        if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success'){

            $product_variation = EbayVariationProduct::where('id', $id)->update(['rrp' => $request->rrp,'start_price' => $request->start_price]);

//            if($master_product_result != null){
//                foreach ($request->productVariation as $key => $product_variation){
//                    $variation_specifics = null;
//                    foreach ($product_variation as $attribute){
//
//                        $variation_specifics[$attribute["attribute_name"]] =$product_variation[$attribute["attribute_name"]];
//                    }
//                }
//            }
        }else{
            return redirect('ebay-master-product-list')->with('error',$result['Errors']['LongMessage']);
        }
        return redirect('ebay-master-product-list');
    }

    public function reviseProduct(Request $request){
        foreach ($request->products as $product){
            try{
                $revise_body = '';
                $description ='';
                $master_product_result = EbayMasterProduct::find($product);


                $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$master_product_result->master_product_id )->get();
                $profile_result = EbayProfile::find($master_product_result->profile_id);
                $ebay_access_token = $this->getAuthorizationToken($master_product_result->account_id);
                $template_result =  EbayTemplate::find($profile_result->template_id);

                $name = $master_product_result->title;
                if ($master_product_result->description == null){
                    $description = $product_result[0]->description;
                }else{
                    $description = $master_product_result->description;
                }

                $images = \Opis\Closure\unserialize($master_product_result->master_images);

                $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));

                $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));


                $item_specifics = '';

                $profile_item_specific = \Opis\Closure\unserialize($profile_result->item_specifics);
                $master_product_item_specific = \Opis\Closure\unserialize($master_product_result->item_specifics);
                foreach ($master_product_item_specific as $key => $value){

                    if ($master_product_item_specific[$key] == ''){
                        $master_product_item_specific[$key] = $profile_item_specific[$key] ?? '';
                    }

                }

                $item_specifics_array = array();
                if (isset($master_product_item_specific)){
                    foreach ($master_product_item_specific as $key=>$item_specific){
//            return gettype($key);
                        //if ($item_specific !=null){
                        $item_specifics .='<NameValueList>
				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
			                      </NameValueList>';
                        //}
                        $item_specifics_array[$key] =
                             $item_specific;

                    }

                    //$item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
                }
//            '.$item_specifics.'
//                echo "<pre>";
//                print_r($item_specifics_array);
//                exit();

                if ($master_product_result->profile_status != null){
                    $tracker_array =\Opis\Closure\unserialize($master_product_result->profile_status);
                    if (isset($tracker_array['category_id'])){
                        if ($tracker_array['item_specifics'] == 1){
                            $revise_body .='<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
                            $master_product_result->item_specifics = \Opis\Closure\serialize($item_specifics_array);
                        }
                        if ($tracker_array['country'] == 1){
                            $revise_body .='<Country>'.$profile_result->country.'</Country>';
                            $master_product_result->country = $profile_result->country;
                        }
                        if ($tracker_array['currency'] == 1){
                            $revise_body .='<Currency>'.$profile_result->currency.'</Currency>';
                            $master_product_result->currency = $profile_result->currency;
                        }
                        if ($tracker_array['duration'] == 1){
                            $revise_body .='<ListingDuration>'.$profile_result->duration.'</ListingDuration>';
                            $master_product_result->duration = $profile_result->duration;
                        }
                        if ($tracker_array['paypal'] == 1){
                            $revise_body .='<PayPalEmailAddress>'.$profile_result->paypal.'</PayPalEmailAddress>';
                            $master_product_result->paypal = $profile_result->paypal;
                        }
                        if ($tracker_array['condition_id'] == 1){
                            $revise_body .='<ConditionID>'.$profile_result->condition_id.'</ConditionID>';
                            $master_product_result->condition_id = $profile_result->condition_id;
                        }
                        if(isset($tracker_array['eps'])){
                            if ($tracker_array['eps'] == 1){

                                $revise_body .='<PictureDetails><PictureDetailsType>'.$profile_result->eps.'</PictureDetailsType></PictureDetails>';
                                $master_product_result->eps = $profile_result->eps;
                            }
                        }

                        if ($tracker_array['post_code'] == 1){
                            $revise_body .='<PostalCode>'.$profile_result->post_code.'</PostalCode>';
                            $master_product_result->post_code = $profile_result->post_code;
                        }
                        if ($tracker_array['category_id'] == 1){
                            $revise_body .='<PrimaryCategory>
			                            <CategoryID>'.$profile_result->category_id.'</CategoryID>
		                            </PrimaryCategory>';
                            $master_product_result->category_id = $profile_result->category_id;
                        }
                        if ($tracker_array['template_id'] == 1){
                            $revise_body .='<Description>'.'<![CDATA['.$template_result.']]>'.'</Description>';
                            $master_product_result->item_description = $template_result;
                            $master_product_result->description = $description;
                        }
                        if (isset($profile_result->store_id)){
                            if ($tracker_array['store_id'] == 1 || $tracker_array['store2_id'] == 1){
                                $revise_body .='<Storefront>';
                                if ($tracker_array['store_id'] == 1){
                                    $revise_body .='<StoreCategoryID>'.$profile_result->store_id.'</StoreCategoryID>';
                                    $master_product_result->store_id = $profile_result->store_id;
                                    $master_product_result->store_name = $profile_result->store_name;
                                }
                                if ($tracker_array['store2_id'] == 1){
                                    $revise_body .='<StoreCategory2ID>'.$profile_result->store2_id.'</StoreCategory2ID>';
                                    $master_product_result->store2_id = $profile_result->store2_id;
                                    $master_product_result->store2_name = $profile_result->store2_name;
                                }
                                $revise_body .='</Storefront>';
                            }
                        }


                        if ($tracker_array['return_id'] == 1 || $tracker_array['payment_id'] == 1 || $tracker_array['shipping_id'] == 1 ){
                            $revise_body .='<SellerProfiles>';
                            if ($tracker_array['return_id'] == 1){
                                $revise_body .='<SellerReturnProfile>
        			                        <ReturnProfileID>'.$profile_result->return_id.'</ReturnProfileID>
      		                            </SellerReturnProfile>';
                                $master_product_result->return_id = $profile_result->return_id;
                            }
                            if ($tracker_array['shipping_id'] == 1){
                                $revise_body .='<SellerShippingProfile>
       			                            <ShippingProfileID>'.$profile_result->shipping_id.'</ShippingProfileID>
    		  	                        </SellerShippingProfile>';
                                $master_product_result->shipping_id = $profile_result->shipping_id;
                            }
                            if ($tracker_array['payment_id'] == 1){
                                $revise_body .='<SellerPaymentProfile>
        			                        <PaymentProfileID>'.$profile_result->payment_id.'</PaymentProfileID>
      		                            </SellerPaymentProfile>';
                                $master_product_result->payment_id = $profile_result->payment_id;
                            }
                            $revise_body .='</SellerProfiles>';
                        }
                    }

                }

                $body = '<?xml version="1.0" encoding="utf-8"?>
<ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
    <Item>
        <ItemID>'.$master_product_result->item_id.'</ItemID>

		'.$revise_body.'

	</Item>
</ReviseFixedPriceItemRequest>';
                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$profile_result->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];
                $result = $this->curl($url,$headers,$body,'POST');

                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);


                if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success'){

                    $master_product_item_specific = \Opis\Closure\serialize($master_product_item_specific);
                    $master_product_result->profile_status = null;
                    $master_product_result->save();
//                $master_product_result = EbayMasterProduct::where('item_id', $result['ItemID'])->update(['account_id' => $profile_result->account_id,'site_id' => $profile_result->site_id,
//                    'item_description' => $template_result,'dispatch_time' => 3,
//                    'product_type' => 'FixedPrice','condition_id' => $profile_result->condition_id,'category_name' => $profile_result->category_name,'condition_description' => '', 'category_id' => $profile_result->category_id,'store_id' => $profile_result->store_id,
//                    'store_name' => $profile_result->store_name,'store2_id' => $profile_result->store2_id,'currency' => $profile_result->currency,'store2_name' => $profile_result->store2_name,'duration' => $profile_result->duration,'location' => $profile_result->location,'country' => $profile_result->country,'post_code' => $profile_result->post_code,
//                    'shipping_id' => $profile_result->shipping_id,'return_id' => $profile_result->return_id,'payment_id' => $profile_result->return_id,'paypal' => $profile_result->paypal,'profile_status' => 1]);


                }elseif ($result['ShortMessage'] == "Auction ended."){
                    $master_product_result->product_status = "Completed";
                    $master_product_result->save();
                }else{
                    continue;
                }
            }catch (Exception $exception){
                continue;
            }

        }



        return redirect('ebay-master-product-list')->with('success','successfully revised');


    }
    public function checkSingleEndedProduct(Request $request,$type = null){
//        echo "<pre>";
//        print_r($request->all());
//        exit();
        foreach ($request->products as $product){
            try {
                $ebay_master_product = EbayMasterProduct::find($product);
                $temp_account_id = null;

                $ebay_access_token = $this->getAuthorizationToken($ebay_master_product->account_id);


                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$ebay_master_product->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->
                                  <ItemID>'.$ebay_master_product->item_id.'</ItemID>
                                </GetItemRequest>';
                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);
//                return $result;

                if (isset($result["Item"]["SellingStatus"]["ListingStatus"])){
                    $result = EbayMasterProduct::where('item_id',$ebay_master_product->item_id)->update(['product_status'=>$result["Item"]["SellingStatus"]["ListingStatus"]]);
                }elseif($result["Errors"]["ShortMessage"] == "Item cannot be accessed."){
                    $result = EbayMasterProduct::where('item_id',$ebay_master_product->item_id)->update(['product_status'=> "Completed"]);
                }


            }catch (\Mockery\Exception $exception){
                continue;
            }
        }
        if ($type == "page"){
            return redirect('ebay-master-product-list');
        }else{
            return 1;
        }

//        return redirect('ebay-master-product-list');


    }
    public function checkEndedProduct(){
        set_time_limit(5000);
        $ebay_master_products = EbayMasterProduct::select('item_id','account_id','site_id')->orderBy('account_id')->get();
        $temp_account_id = null;
        foreach ($ebay_master_products as $index => $item){

            if ($item->account_id != $temp_account_id){
                $temp_session = $item->account_id;
                $ebay_access_token = $this->getAuthorizationToken($item->account_id);
            }

            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$item->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:GetItem',
                'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,
            ];
            $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->
                                  <ItemID>'.$item->item_id.'</ItemID>
                                </GetItemRequest>';
            $item_category_details = $this->curl($url,$headers,$body,'POST');
            $item_category_details =simplexml_load_string($item_category_details);
            $item_category_details = json_decode(json_encode($item_category_details),true);
            if (isset($item_category_details["Item"]["SellingStatus"]["ListingStatus"])){
                $result = EbayMasterProduct::where('item_id',$item->item_id)->update(['product_status'=>$item_category_details["Item"]["SellingStatus"]["ListingStatus"]]);
            }

        }


    }

    public function endListing(){
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay Active | WMS360';
        $pagination = $settingData['pagination'];

        $shelfUse = $this->shelf_use;
        $user_list = User::get();

        $master_product_list = EbayMasterProduct::where('product_status','completed')->with('variationProducts')->orderByDesc('id')->paginate($pagination);
        $master_decode_product_list = json_decode(json_encode($master_product_list));
        //    echo '<pre>';
        //    print_r(json_decode(json_encode($master_product_list)));
        //    exit();
//        return \Opis\Closure\unserialize($master_product_list[0]->master_images)[0];

        return view('ebay.master_product.master_product_list',compact('master_product_list','master_decode_product_list', 'setting', 'page_title', 'pagination','shelfUse','user_list'));
    }


    public function deleteEbayVariation($sku){


        $sku = $sku;

        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();

        foreach ($ebay_product_find as $product){
            $account_result = EbayAccount::find($product->masterProduct->account_id);

             $this->ebayAccessToken($account_result->refresh_token);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$product->masterProduct->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$product->masterProduct->item_id.'</ItemID>
                        <Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                          <Delete>true</Delete>
                            <SKU>'.$sku.'</SKU>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

            $update_ebay_product = $this->curl($url,$headers,$body,'POST');

        }

//        $update_ebay_product =simplexml_load_string($update_ebay_product);
//        $update_ebay_product = json_decode(json_encode($update_ebay_product),true);
//        echo $itemId.'****'.$sku.'*****'.$quantity.'********'.$siteId;
//        exit();


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

        $this->ebay_update_access_token =  $response['access_token'];
    }



    /*
    * Function : pendingListing
    * Route Type : ebay-pending-list
    * Method Type : GET
    * Parametes : null
    * creator : Mahfuz
    * Modifier : Solaiman
    * Description : This function is used for displaying eBay Pending Product List and pagination
    * Modified Date : 3-12-2020
    * Modified Content : Screen option table column hide show and pagination
    */

    public function pendingListing(Request $request)
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('ebay', 'ebay_pending_product');
        $setting = $settingData['setting'];
        $page_title = 'eBay Pending | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

        $shelfUse = Client::first()->shelf_use;
        $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
        $total_catalogue = ProductDraft::whereHas('ProductVariations', function($query){
            $query->havingRaw('sum(actual_quantity) > 0');
        })->with(['ProductVariations' => function ($query) {
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        },'all_category', 'WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info'])
            ->withCount('ProductVariations')
            ->where('status','publish')
            ->whereNotIn('id',$exist_ebay_catalogue)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->paginate($pagination);
            if($request->has('is_clear_filter')){
                $search_result = $total_catalogue;
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
                $woocommerceSiteUrl = WoocommerceAccount::first();
                $view = view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render();
                return response()->json(['html' => $view]);
            }

        $users = User::orderBy('name', 'ASC')->get();
        $total_catalogue_info = json_decode(json_encode($total_catalogue));
        $total_catalogue_count = ProductDraft::whereNotIn('id',$exist_ebay_catalogue)->count();
//        echo "<pre>";
//        print_r($total_catalogue);
//        exit();

        //return view('ebay.master_product.pending_catalogue_listing',compact('total_catalogue','total_catalogue_info','total_catalogue_count'));
        return view('ebay.master_product.pending_list',compact('total_catalogue','total_catalogue_info','total_catalogue_count', 'shelfUse','setting', 'page_title', 'pagination','users'));
    }

    public function endProduct(Request $request){
        if ($request->account_id != ''){
            $ebay_access_token = $this->getAuthorizationToken($request->account_id);
            foreach ($request->products as $product){
                $result = EbayMasterProduct::with(['variationProducts'])->find($product);


                $body = '<?xml version="1.0" encoding="utf-8"?>
                    <EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                        <!-- Enter the ItemID you wantto end-->
                      <ItemID>'.$result->item_id.'</ItemID>
                      <EndingReason>NotAvailable</EndingReason>
                    </EndFixedPriceItemRequest>';

                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$result->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:EndFixedPriceItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];
                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);

                if ($result['Ack'] == 'Success' || $result['Ack'] == 'Warning'){
                    $ebay_master_product = EbayMasterProduct::find($product);
                    $ebay_master_product->product_status = "Completed";
                    $ebay_master_product->save();
//                    $ebay_master_product->variationProducts()->delete();
//                    EbayMasterProduct::destroy($product);
//                    return redirect('ebay-master-product-list')->with('success','successfully deleted');
                }
            }
        }elseif($request->account_id == ''){
            foreach ($request->products as $product){
                $result = EbayMasterProduct::with(['variationProducts'])->find($product);
                $ebay_access_token = $this->getAuthorizationToken($result->account_id);

                $body = '<?xml version="1.0" encoding="utf-8"?>
                    <EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                        <!-- Enter the ItemID you wantto end-->
                      <ItemID>'.$result->item_id.'</ItemID>
                      <EndingReason>NotAvailable</EndingReason>
                    </EndFixedPriceItemRequest>';

                $url = 'https://api.ebay.com/ws/api.dll';

                $headers = [
                    'X-EBAY-API-SITEID:'.$result->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:EndFixedPriceItem',
                    'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

                ];
                $result = $this->curl($url,$headers,$body,'POST');
                $result =simplexml_load_string($result);
                $result = json_decode(json_encode($result),true);

                if ($result['Ack'] == 'Success' || $result['Ack'] == 'Warning'){
                    $ebay_master_product = EbayMasterProduct::find($product);
                    $ebay_master_product->product_status = "Completed";
                    $ebay_master_product->save();
//                    $ebay_master_product->variationProducts()->delete();
//                    EbayMasterProduct::destroy($product);
//                    return redirect('ebay-master-product-list')->with('success','successfully deleted');
                }
            }
        }
    }
    public function QuantitySync(Request $request){
        if ($request->account_id == ''){
            $check_quantity = new CheckQuantity();
            foreach ($request->products as $product){
                try {
                    $master_product = EbayMasterProduct::with('variationProducts')->find($product);
                    if (isset($master_product->variationProducts)){
                        foreach ($master_product->variationProducts as $variation){
                            $check_quantity->checkQuantity($variation->sku,null,null,'Sync Quantity From Ebay');
                        }
                    }
                }catch (\Mockery\Exception $exception){
                    continue;
                }

            }
        }elseif($request->account_id != ''){
            $check_quantity = new CheckQuantity();
            foreach ($request->products as $product){
                try {
                    $master_product = EbayMasterProduct::with('variationProducts')->find($product);
                    if (isset($master_product->variationProducts)){
                        foreach ($master_product->variationProducts as $variation){
                            $check_quantity->checkQuantity($variation->sku,null,null,'Sync Quantity From Ebay',$request->account_id);
                        }
                    }
                }catch (\Mockery\Exception $exception){
                    continue;
                }

            }
        }

        return redirect('ebay-master-product-list');
    }

    public function getAuthorizationToken($id){
        $account_result = EbayAccount::where('id',$id)->with('developerAccount')->get()->first();

        $clientID  = $account_result->developerAccount->client_id;
        $clientSecret  = $account_result->developerAccount->client_secret;

//dd($token_result->authorization_token);
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
        //dd($response);
        /// ////////////////////////////// end

        return $response['access_token'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$itemId)
    {

        $result = EbayMasterProduct::with(['variationProducts'])->find($id);
        $ebay_access_token = $this->getAuthorizationToken($result->account_id);

        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                        <!-- Enter the ItemID you wantto end-->
                      <ItemID>'.$itemId.'</ItemID>
                      <EndingReason>NotAvailable</EndingReason>
                    </EndFixedPriceItemRequest>';

        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:'.$result->site_id,
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:EndFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

        ];
        $result = $this->curl($url,$headers,$body,'POST');
        $result =simplexml_load_string($result);
        $result = json_decode(json_encode($result),true);

        if ($result['Ack'] == 'Success'){
            $ebay_master_product = EbayMasterProduct::find($id);
            $ebay_master_product->product_status = "Completed";
            //$ebay_master_product->save();
            //$ebay_master_product->variationProducts()->delete();
            //EbayMasterProduct::destroy($id);
            return redirect('ebay-master-product-list')->with('success','successfully deleted');
        }else{
            $ebay_master_product = EbayMasterProduct::find($id);
            $ebay_master_product->product_status = "Completed";
            $ebay_master_product->save();
            //$ebay_master_product->variationProducts()->delete();
            //EbayMasterProduct::destroy($id);
            return redirect('ebay-master-product-list')->with('success',$result['Errors']['LongMessage']);
        }

    }

    public function productCSV(Request $request){

//        try{
            $csvData = $this->csvToArray($request->csvFile);
//                    echo "<pre>";
//            print_r($csvData[0]['Variation details']);
//            exit();
            $dt = Carbon::now();
//        echo $dt->toDateString();

            $filename = $dt->timestamp.".csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('Item ID' ,'SKU','eBay Quantity','WMS Quantity','Feeder Quantity','Feeder Flag','Remarks','eBay Variation Qty','WMS Variation Qty'));
//            echo "<pre>";
//            print_r($csvData);
//            exit();
            $sku_counter = 0;
            $item_id_temp = null;
            $wms_quantity = 0;
            foreach ($csvData as $index => $product){
//                echo "<pre>";
//                print_r(isset($product['Custom label (SKU)']));
//                exit();
                $feeder_quantity = '';
                $feeder_flag = null;
                $ebay_master_id = EbayMasterProduct::with('variationProducts')->where('item_id',(integer)$product['Item number'])->get()->first();

                if (isset($ebay_master_id->id)){

                    if (isset($ebay_master_id->draft_status)){
                        if (isset(\Opis\Closure\unserialize($ebay_master_id->draft_status)['feeder_flag'])){
                            $feeder_quantity = $ebay_master_id->custom_feeder_quantity ?? '';
                            $feeder_flag = \Opis\Closure\unserialize($ebay_master_id->draft_status)['feeder_flag'];
                        }
                    }
                    if ($ebay_master_id->item_id != $product['Item number'] && $index != 0){
                        if ($wms_quantity != $sku_counter){
                            fputcsv($handle, array($ebay_master_id->item_id,'', '','','','','Variation Miss Matched',$sku_counter,$wms_quantity));
                        }

                    }
                    if ($product['Custom label (SKU)'] == ''){
                        $item_id_temp = $product['Item number'];
                        $wms_quantity = $ebay_master_id->variationProducts->count();
//                        fputcsv($handle, array($product['Item number'],'', '','','','Variation Miss Matched',$sku_counter,''));
                        $sku_counter = 0;
                    }
                    if ($product['Custom label (SKU)'] != ''){
                        $sku_counter++;
                    }

                    $product_variation = ProductVariation::where('product_draft_id',$ebay_master_id->master_product_id)->where('sku',$product['Custom label (SKU)'])->get()->first();
                    if (isset($product_variation->id)){
                        if ($product['Available quantity'] != $product_variation->actual_quantity){
                            if ($ebay_master_id->custom_feeder_quantity != $product['Available quantity'] && $ebay_master_id->custom_feeder_quantity <= $product_variation->actual_quantity){
                                if ($product['Available quantity'] < $product_variation->actual_quantity){
                                    fputcsv($handle, array($product['Item number'],$product['Custom label (SKU)'], $product['Available quantity'],$product_variation->actual_quantity,$feeder_quantity,$feeder_flag,'eBay QTY < WMS QTY'));
                                }elseif ($product['Available quantity'] > $product_variation->quantity){
                                    fputcsv($handle, array($product['Item number'],$product['Custom label (SKU)'], $product['Available quantity'],$product_variation->actual_quantity,$feeder_quantity,$feeder_flag,'eBay QTY > WMS QTY'));
                                }
                            }

                        }
                    }elseif($product['Custom label (SKU)'] != ''){
                        fputcsv($handle, array($product['Item number'],$product['Custom label (SKU)'], $product['Available quantity'],'',$feeder_quantity,$feeder_flag,'SKU Not Found'));
                    }
                }else{
                    fputcsv($handle, array($product['Item number'],$product['Custom label (SKU)'], $product['Available quantity'],'',$feeder_quantity,$feeder_flag,'Item ID Not Found'));
                }


            }
            fclose($handle);
//            File::delete(base_path($filename));
            return \response()->json($filename);

//        }catch(\Exception $exception){
//            return response()->json(['type' => 'error', 'msg' => 'Something went wrong. Please try again']);
//        }
    }
    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 10000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function _bayMasterProductSearch(Request $request){
        $search_field = ['master_product_id','title','item_id','category_name'];
        $master_product_list = EbayMasterProduct::with('variationProducts')->where(function($query) use ($search_field, $request){
            for ($i = 0; $i < count($search_field); $i++) {
                $query->orWhere($search_field[$i],'LIKE','%'.$request->name.'%');
            }
        })->orderByDesc('id')->get();
        $defaultEditAdd = NULL;
        if(count($master_product_list) > 0){
            $content = view('ebay.master_product.search_master_product', compact('master_product_list', 'defaultEditAdd'))->render();
            return response()->json(['content' => $content, 'total_row' => $master_product_list->count()]);
        }else{
            return response()->json(['content' => 'error']);
        }
    }

    public function ebayMasterProductSearch(Request $request){
        $search_keyword =  $request->name;
        $search_result = null;
        $date = '12345';
        $status = $request->status;
        $search_priority = $request->search_priority;
        $take = $request->take;
        $skip = $request->skip;
        $ids = $request->ids;

        $matched_product_array = array();
        if (is_numeric($search_keyword)){
            if (strlen($search_keyword) == 13){
                $find_variation = EbayVariationProduct::where('ean','=',$search_keyword)->get()->first();
                if ($find_variation != null){
                    array_push($matched_product_array,$find_variation->id);
                    $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
                    $search_result = $search_draft_result['search'];
                    $ids = $search_draft_result['ids'];
                    $defaultEditAdd = NULL;
                    return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
                }else{
                    $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                    $search_result = $search_result_by_word["search"];
                    $search_priority = $search_result_by_word["search_priority"];
                    $ids = $search_result_by_word["ids"];

                    if ($search_result->isEmpty()){
                        $skip = 0;
                        $search_sku_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                        $search_result = $search_sku_result['search'];
                        $ids = $search_sku_result['ids'];
                    }
                    $defaultEditAdd = NULL;
                    return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
                }
            }else{
                if (strlen($search_keyword) > 10){
                    $find_item = EbayMasterProduct::where('item_id','=',$search_keyword)->get()->first();
                    if ($find_item != null){
                        array_push($matched_product_array,$find_item->id);
                        $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
                        $search_result = $search_draft_result['search'];
                        $ids = $search_draft_result['ids'];
                        $defaultEditAdd = NULL;
                        return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
                    }
                }else{
                    $search_draft_result = $this->searchAsId($search_keyword,$status,$take,$skip,$ids);
                    $search_result = $search_draft_result['search'];
                    $ids = $search_draft_result['ids'];
                    if($search_result->isEmpty()){
                        $skip = 0;
                        $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                        $search_result = $search_result_by_word["search"];
                        $search_priority = $search_result_by_word["search_priority"];
                        $ids = $search_result_by_word["ids"];
                        if ($search_result->isEmpty()){
                            $skip = 0;
                            $search_sku_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                            $search_result = $search_sku_result['search'];
                            $ids = $search_sku_result['ids'];
                        }
                    }
                }
                $defaultEditAdd = NULL;
                return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
            }

        }else{
            if (strpos($search_keyword," ") != null){

                $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                $search_priority = $search_result_by_word["search_priority"];
                $ids = $search_result_by_word["ids"];
                $defaultEditAdd = NULL;
                return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);

            }else{
                $search_sku_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_sku_result['search'] ?? null;
                $ids = $search_sku_result['ids'];
                if ($search_result== null){
                    $skip = 0;
                    $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                    $search_result = $search_result_by_word["search"];
                    $search_priority = $search_result_by_word["search_priority"];
                    $ids = $search_result_by_word["ids"];
                }
                $defaultEditAdd = NULL;
                return response()->json(['html' => view('ebay.master_product.search_master_product', compact('search_result', 'defaultEditAdd'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);

            }

        }
    }

    public function searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids){
        $matched_product_array = array();
        $search_result = null;
        $find_sku  =  EbayVariationProduct::where('sku','=',$search_keyword)
            //->where('status',$status)
            ->get();
        foreach($find_sku as $find_sku){
            array_push($matched_product_array, $find_sku->ebay_master_product_id);
        }
        if ($find_sku != null) {
            $search_draft_result = $this->getProductDraft('id', $matched_product_array, $status, $take, $skip, $ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }
        return ['search'=>$search_result,'ids' => $ids];
    }

    public function searchAsId($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $find_variation = EbayVariationProduct::where('id','=',$search_keyword)->get()->first();
        $find_draft = EbayMasterProduct::where('master_product_id','=',$search_keyword)->get();
        $search_draft_result = null;
        $matched_product_array = array();
        if ($find_variation != null && $find_draft !=null){
            if(count($find_draft) > 0){
                foreach ($find_draft as $master_variation){
                    array_push($matched_product_array,$master_variation->id);
                }
            }
            array_push($matched_product_array,$find_variation->product_draft_id);
//            array_push($matched_product_array,$find_draft->id);
            //return $matched_product_array;
            $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];

        }
        if ($find_variation != null){
            array_push($matched_product_array,$find_variation->product_draft_id);
            $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }if ($find_draft != null){
            if(count($find_draft) > 0){
                foreach ($find_draft as $master_variation){
                    array_push($matched_product_array,$master_variation->id);
                }
            }
            $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }

        return ['search'=>$search_result,'ids' => $ids];
    }
    public function getProductDraft($column_name,$word,$status,$take,$skip,$ids){
        $search_result = EbayMasterProduct::whereIn($column_name,$word)->whereNotIn('id', $ids)
            ->withCount('variationProducts')->where('product_status',"Active")
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function firstPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $search_result = EbayMasterProduct::where('title','REGEXP',"[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)
            ->withCount('variationProducts')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();
        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function secondPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = EbayMasterProduct::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->where('title','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)
            ->withCount('variationProducts')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();
        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function thirdPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = EbayMasterProduct::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->orWhere('title','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)
            ->withCount('variationProducts')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();
        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids){

        $search_result = null;

        if ($search_priority == 0){

            $search_result_by_word = $this->firstPSearch($search_keyword,$status,$take,$skip,$ids);

            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){

                $skip = 0;
                $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                if ($search_result->isEmpty()){
                    $skip = 0;
                    $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
                    $search_result = $search_result_by_word["search"];
                    if($search_result->isEmpty()){
                        return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 3];
                    }else{
                        return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
                    }

                }else{
                    ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
                }
                return ["search" => $search_result,"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
            }else{
                return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 0];
            }

        }
        if ($search_priority == 1){

            $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){
                $skip = 0;
                $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                if ($search_result->isEmpty()){
                    return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
                }else{
                    return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
                }

            }else{
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 1];
            }

        }if ($search_priority == 2){
            $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
            }else{
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
            }

        }

    }




    /*
     * Function : eBayActiveProductSearch
     * Route Type : ebay-master-product-list
     * Method Type : Post
     * Parameters : null
     * Creator : Solaiman
     * Creating Date : 02/02/2021
     * Description : This function is used for eBay Active product individual column search
     * Modifier :
     * Modified Date :
     * Modified Content :
     */


    public function eBayActiveProductSearch (Request $request)
    {
        if (!is_array($request->search_value)){
            $search_value = \Opis\Closure\unserialize($request->search_value);

        }
        // echo '<pre>';
        // print_r($request->all());
        // exit();

        //try {
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
            $setting = $settingData['setting'];
            $page_title = 'eBay Active | WMS360';
            $pagination = $settingData['pagination'];

            $shelfUse = $this->shelf_use;
            $user_list = User::get();

            $column_name = $request->column_name;
            $search_value = $request->search_value;

            //$aggregate_value = $request->aggregate_condition;

            $master_product_list = EbayMasterProduct::with('variationProducts')->where('product_status','!=',"Completed")
                ->orderByDesc('id')
                ->where(function ($query) use ($request, $column_name, $search_value) {
                    if (isset($search_value['item_id']['value'])) {

                        if (isset($search_value['item_id']['opt_out'])) {
                            $query->where('item_id', '!=', $search_value['item_id']['value']);
                        } else {
                            $query->where('item_id', $search_value['item_id']['value']);
                        }
                    } if (isset($search_value['master_product_id']['value'])) {

                        if (isset($search_value['master_product_id']['opt_out'])) {
                            $query->where('master_product_id', '!=', $search_value['master_product_id']['value']);
                        } else {
                            $query->where('master_product_id', $search_value['master_product_id']['value']);
                        }
                    }if (isset($search_value['title']['value'])) {
                        if(isset($search_value['title']['opt_out'])){
                            $query->where('title','NOT LIKE', "%{$search_value['title']['value']}%");
                        }else{
                            $query->where('title','LIKE', "%{$search_value['title']['value']}%");
                        }
                    } if (isset($search_value['stock']['value'])) {
                        $aggregate_value = $search_value['stock']['aggregate_condition'] ;//$request->aggregate_condition;
                        $stock_query = EbayMasterProduct::select('ebay_master_products.id', DB::Raw('sum(ebay_variation_products.quantity) stock'))
                            ->leftJoin('ebay_variation_products', 'ebay_master_products.id', '=', 'ebay_variation_products.ebay_master_product_id')
                            ->where([['ebay_master_products.deleted_at', null], ['ebay_variation_products.deleted_at', null]])
                            ->havingRaw('sum(ebay_variation_products.quantity)' . $aggregate_value . $search_value['stock']['value'])
                            ->groupBy('ebay_master_products.id')
                            ->get();

                        $ids = [];
                        if (count($stock_query) > 0) {
                            foreach ($stock_query as $stock) {
                                $ids[] = $stock->id;
                            }
                        }

                        if (isset($search_value['stock']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }

                    } if (isset($search_value['profile_name']['value'])) {
                        $ebay_profile_name_query = EbayMasterProduct::select('ebay_master_products.id')
                            ->leftJoin('ebay_profiles', 'ebay_master_products.profile_id', '=', 'ebay_profiles.id')
                            ->where('profile_name', $search_value['profile_name']['value'])
                            ->groupBy('ebay_master_products.id')
                            ->get();

                        $ids = [];
                        foreach ($ebay_profile_name_query as $ebay_profile_name) {
                            $ids[] = $ebay_profile_name->id;
                        }

                        if (isset($search_value['profile_name']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } if (isset($search_value['account_name']['value'])) {
                        $ebay_account_name_query = EbayMasterProduct::select('ebay_master_products.id')
                            ->leftJoin('ebay_accounts', 'ebay_master_products.account_id', '=', 'ebay_accounts.id')
                            ->where('account_id', $search_value['account_name']['value'])
                            ->groupBy('ebay_master_products.id')
                            ->get();

                        $ids = [];
                        foreach ($ebay_account_name_query as $ebay_account_name) {
                            $ids[] = $ebay_account_name->id;
                        }

                        if (isset($search_value['account_name']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }

                    } if (isset($search_value['creator_id']['value'])) {
                        if (isset($search_value['creator_id']['opt_out'])) {
                            $query->where('creator_id', '!=', $search_value['creator_id']['value']);
                        } else {
                            $query->where('creator_id', $search_value['creator_id']['value']);
                        }
                    } if (isset($search_value['modifier_id']['value'])) {
                        if (isset($search_value['modifier_id']['opt_out'])) {
                            $query->where('modifier_id', '!=', $search_value['modifier_id']['value']);
                        } else {
                            $query->where('modifier_id', $search_value['modifier_id']['value']);
                        }
                    }if (isset($search_value['product_status']['value'])){
                        $query->where('product_status', '=', $search_value['product_status']['value']);
                    }

                    // If user submit with empty data then this message will display table's upstairs
                    if ($search_value == '') {
                        return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
                    }

                })
                ->paginate($pagination)->appends(request()->query());



            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $ids = [];
            if (count($master_product_list) > 0) {
                foreach ($master_product_list as $result) {
                    $ids[] = $result->id;
                }
            }


            $master_decode_product_list = json_decode(json_encode($master_product_list));
//        echo '<pre>';
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
            return view('ebay.master_product.master_product_list', compact('master_product_list', 'master_decode_product_list', 'setting', 'page_title', 'pagination', 'shelfUse', 'column_name', 'search_value', 'user_list'));
//        } catch (\Exception $exception) {
//            return redirect('exception')->with('exception',$exception->getMessage());
//        }
    }

    public function eBayEndProductSearch (Request $request)
    {
        if (!is_array($request->search_value)){
            $search_value = \Opis\Closure\unserialize($request->search_value);

        }
        // echo '<pre>';
        // print_r($request->all());
        // exit();

        //try {
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
            $setting = $settingData['setting'];
            $page_title = 'eBay End Product | WMS360';
            $pagination = $settingData['pagination'];

            $shelfUse = $this->shelf_use;
            $user_list = User::get();

            $column_name = $request->column_name;
            $search_value = $request->search_value;

            //$aggregate_value = $request->aggregate_condition;

            $onlySoftDeletedList = EbayMasterProduct::where('product_status', '=', 'Completed')
                ->orderByDesc('id')//->onlyTrashed()
                ->where(function ($query) use ($request, $column_name, $search_value) {
                    if (isset($search_value['item_id']['value'])) {

                        if (isset($search_value['item_id']['opt_out'])) {
                            $query->where('item_id', '!=', $search_value['item_id']['value']);
                        } else {
                            $query->where('item_id', $search_value['item_id']['value']);
                        }
                    } if (isset($search_value['master_product_id']['value'])) {

                        if (isset($search_value['master_product_id']['opt_out'])) {
                            $query->where('master_product_id', '!=', $search_value['master_product_id']['value']);
                        } else {
                            $query->where('master_product_id', $search_value['master_product_id']['value']);
                        }
                    }if (isset($search_value['title']['value'])) {
                        if(isset($search_value['title']['opt_out'])){
                            $query->where('title','NOT LIKE', "%{$search_value['title']['value']}%");
                        }else{
                            $query->where('title','LIKE', "%{$search_value['title']['value']}%");
                        }
                    } if (isset($search_value['stock']['value'])) {
                        $aggregate_value = $search_value['stock']['aggregate_condition'] ;//$request->aggregate_condition;
                        $stock_query = EbayMasterProduct::select('ebay_master_products.id', DB::Raw('sum(ebay_variation_products.quantity) stock'))
                            ->leftJoin('ebay_variation_products', 'ebay_master_products.id', '=', 'ebay_variation_products.ebay_master_product_id')
                            ->where([['ebay_master_products.deleted_at', null], ['ebay_variation_products.deleted_at', null]])
                            ->havingRaw('sum(ebay_variation_products.quantity)' . $aggregate_value . $search_value['stock']['value'])
                            ->groupBy('ebay_master_products.id')//->onlyTrashed()
                            ->get();

                        $ids = [];
                        if (count($stock_query) > 0) {
                            foreach ($stock_query as $stock) {
                                $ids[] = $stock->id;
                            }
                        }

                        if (isset($search_value['stock']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }

                    } if (isset($search_value['profile_name']['value'])) {
                        $ebay_profile_name_query = EbayMasterProduct::where('product_status', '=', 'Completed')->select('ebay_master_products.id')
                            ->leftJoin('ebay_profiles', 'ebay_master_products.profile_id', '=', 'ebay_profiles.id')
                            ->where('profile_name', $search_value['profile_name']['value'])
                            ->groupBy('ebay_master_products.id')//->onlyTrashed()
                            ->get();

                        $ids = [];
                        foreach ($ebay_profile_name_query as $ebay_profile_name) {
                            $ids[] = $ebay_profile_name->id;
                        }

                        if (isset($search_value['profile_name']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } if (isset($search_value['account_name']['value'])) {
                        $ebay_account_name_query = EbayMasterProduct::where('product_status', '=', 'Completed')
                            ->select('ebay_master_products.id')
                            ->leftJoin('ebay_accounts', 'ebay_master_products.account_id', '=', 'ebay_accounts.id')
                            ->where('account_id', $search_value['account_name']['value'])
                            ->groupBy('ebay_master_products.id')//->onlyTrashed()
                            ->get();

                        $ids = [];
                        foreach ($ebay_account_name_query as $ebay_account_name) {
                            $ids[] = $ebay_account_name->id;

                            // echo '<pre>';
                            // print_r($ids[] = $ebay_account_name->id);

                        }
                        // exit();

                        if (isset($search_value['account_name']['opt_out'])) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }

                    } if (isset($search_value['creator_id']['value'])) {
                        if (isset($search_value['creator_id']['opt_out'])) {
                            $query->where('creator_id', '!=', $search_value['creator_id']['value']);
                        } else {
                            $query->where('creator_id', $search_value['creator_id']['value']);
                        }
                    } if (isset($search_value['modifier_id']['value'])) {
                        if (isset($search_value['modifier_id']['opt_out'])) {
                            $query->where('modifier_id', '!=', $search_value['modifier_id']['value']);
                        } else {
                            $query->where('modifier_id', $search_value['modifier_id']['value']);
                        }
                    }if (isset($search_value['product_status']['value'])){
                        $query->where('product_status', '=', $search_value['product_status']['value']);
                    }

                    // If user submit with empty data then this message will display table's upstairs
                    if ($search_value == '') {
                        return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
                    }

                })
                ->paginate($pagination)->appends(request()->query());



            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $ids = [];
            if (count($onlySoftDeletedList) > 0) {
                foreach ($onlySoftDeletedList as $result) {
                    $ids[] = $result->id;
                }
            }


            $end_decode_product_list = json_decode(json_encode($onlySoftDeletedList));
            return view('ebay.master_product.end_product_list', compact('onlySoftDeletedList', 'end_decode_product_list', 'setting', 'page_title', 'pagination', 'shelfUse', 'column_name', 'search_value', 'user_list'));
//
    }



    public function eBayPendingProductSearch(Request $request){

//        try{
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('ebay', 'ebay_pending_product');
            $setting = $settingData['setting'];
            $page_title = 'eBay Pending | WMS360';
            $pagination = $settingData['pagination'];

            $column_name = $request->column_name;
            $search_value = $request->search_value;
            $aggregate_value = $request->aggregate_condition;

            $shelfUse = Client::first()->shelf_use;
            $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
            $total_catalogue = ProductDraft::with(['all_category', 'WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info'])
                ->withCount('ProductVariations')
                ->where('status','publish')
                ->whereNotIn('id',$exist_ebay_catalogue)
                ->orderBy('id','DESC')
                ->where(function ($query)use($request, $column_name, $search_value, $aggregate_value){
                    if(isset($search_value['id']['value'])){
                        if(isset($search_value['id']['opt_out'])){
                            $query->where('id', '!=', $search_value['id']['value']);
                        }else{
                            $query->where('id', $search_value['id']['value']);
                        }
                    }if (isset($search_value['type']['value'])) {
                        if(isset($search_value['type']['opt_out'])){
                            $query->where('type','NOT LIKE', "%{$search_value['type']['value']}%");
                        }else{
                            $query->where('type','LIKE', "%{$search_value['type']['value']}%");
                        }
                    }
                    if (isset($search_value['title']['value'])) {
                        if(isset($search_value['title']['opt_out'])){
                            $query->where('name','NOT LIKE', "%{$search_value['title']['value']}%");
                        }else{
                            $query->where('name','LIKE', "%{$search_value['title']['value']}%");
                        }
                    }
                    if(isset($search_value['category']['value'])){
                        $category_info_query = ProductDraft::select('product_drafts.id')
                            ->leftJoin('woowms_categories', 'product_drafts.woowms_category', '=', 'woowms_categories.id')
                            ->where([['product_drafts.deleted_at', null],['woowms_categories.deleted_at', null]])
                            ->where('woowms_category', $search_value['category']['value'])
                            ->groupBy('product_drafts.id')
                            ->get();

                        $ids = [];
                        foreach ($category_info_query as $category_name){
                            $ids[] = $category_name->id;
                        }

                        if(isset($search_value['category']['opt_out'])){
                            $query->whereNotIn('id', $ids);
                        }else{
                            $query->whereIn('id', $ids);
                        }

                    }
//                elseif($column_name == 'stock'){
//                    $aggregate_value = $request->aggregate_condition;
//                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_variation.actual_quantity) stock'))
//                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
//                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
//                        ->havingRaw('sum(product_variation.actual_quantity)'.$aggregate_value.$search_value)
//                        ->groupBy('product_drafts.id')
//                        ->get();
//
//                    $ids = [];
//                    if(count($query_info) > 0){
//                        foreach ($query_info as $info){
//                            $ids[] = $info->id;
//                        }
//                    }
//
//                    if($request->opt_out == 1){
//                        $query->whereNotIn('id',$ids);
//                    }else{
//                        $query->whereIn('id',$ids);
//                    }
//
//                }elseif($column_name == 'product'){
//                    $aggrgate_value = $request->aggregate_condition;
//                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('count(product_variation.id) product'))
//                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
//                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
//                        ->havingRaw('count(product_variation.id)'.$aggrgate_value.$request->search_value)
//                        ->groupBy('product_drafts.id')
//                        ->get();
//                    $ids = [];
//                    if(count($query_info) > 0){
//                        foreach ($query_info as $info){
//                            $ids[] = $info->id;
//                        }
//                    }
//                    if($request->opt_out == 1){
//                        $query->whereNotIn('id',$ids);
//                    }else{
//                        $query->whereIn('id',$ids);
//                    }
//                }
                    if(isset($search_value['creator']['value'])){
                        if(isset($search_value['creator']['opt_out'])){
                            $query->where('user_id','!=',$search_value['creator']['value']);
                        }else{
                            $query->where('user_id',$search_value['creator']['value']);
                        }
                    }if(isset($search_value['modifier_id']['value'])){
                        if(isset($search_value['modifier_id']['opt_out'])){
                            $query->where('modifier_id','!=',$search_value['modifier_id']['value']);
                        }else{
                            $query->where('modifier_id',$search_value['modifier_id']['value']);
                        }
                    }

                })

                ->paginate($pagination)->appends(request()->query());


            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $ids = [];
            if(count($total_catalogue) > 0){
                foreach ($total_catalogue as $result){
                    $ids[] = $result->id;
                }
            }
//else{
//                return redirect('ebay-pending-list')->with('no_data_found','No data found');
//            }

            $users = User::orderBy('name', 'ASC')->get();
            $total_catalogue_info = json_decode(json_encode($total_catalogue));
//            echo '<pre>';
//            print_r($search_value);
//            exit();
            return view('ebay.master_product.pending_list',compact('total_catalogue','total_catalogue_info', 'shelfUse','setting', 'page_title','search_value', 'pagination','aggregate_value','users'));
//        }catch (\Exception $exception){
//            return redirect('exception')->with('exception',$exception->getMessage());
//        }
    }

}
