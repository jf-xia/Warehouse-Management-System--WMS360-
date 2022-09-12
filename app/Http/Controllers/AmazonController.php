<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DB;
use Carbon\Carbon;
require_once './vendor/autoload.php';
use SellingPartnerApi\Api;
use SellingPartnerApi\Configuration;
use SellingPartnerApi\Endpoint;
use App\amazon\AmazonAccount;
use App\amazon\AmazonAccountApplication;
use App\amazon\AmazonMarketPlace;
use App\Traits\ImageUpload;
use Session;
use App\ProductDraft;
use App\amazon\AmazonMasterCatalogue;
use App\Setting;
use Auth;
use App\Client;
use App\User;
use Arr;
use App\ProductVariation;
use App\Traits\SearchCatalogue;
use App\Traits\ActivityLogs;
use App\amazon\AmazonCountry;
use App\amazon\AmazonCondition;
use App\amazon\AmazonVariationProduct;
use App\amazon\AmazonProductType;
use App\amazon\AmazonSellerSite;
use App\Order;
use App\ProductOrder;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use Illuminate\Support\Facades\Log;
use App\amazon\AmazonToken;
use App\Traits\ListingLimit;
use App\Traits\CommonFunction;
use App\Channel;

class AmazonController extends Controller
{
    use ImageUpload;
    use SearchCatalogue;
    use ActivityLogs;
    use ListingLimit;
    use CommonFunction;

    protected $applicationInfo = [];
    protected $marketPlaceId = '';
    protected $marketPlace = '';
    protected $productType = '';
    protected $sellerId = 'A1FJB341J9DM5D';
    protected $issueLocal = 'en_GB';

    public function __construct()
    {
        $this->middleware('auth');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
    }

    public function getRefreshToken($request, $applicationInfo){
        $url = 'https://api.amazon.com/auth/o2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        $body = http_build_query([
            'grant_type'   => 'authorization_code',
            'code'         => $request->spapi_oauth_code,
            'redirect_uri' => $applicationInfo->oauth_redirect_url,
            'client_id' => $applicationInfo->lwa_client_id,
            'client_secret' => $applicationInfo->lwa_client_secret,
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
        return $response;
    }

    public function accountAuthorization(Request $request){
        try{
            $applicationId = Session::get('applicationId');
            if($applicationId != '' || $applicationId != null){
                $applicationInfo = AmazonAccountApplication::with(['token'])->find($applicationId);
                if($applicationInfo){
                    $response = $this->getRefreshToken($request, $applicationInfo);
                    Session::put('applicationId','');
                    if($applicationInfo->token){
                        $tokenAddOrUpdate = AmazonToken::find($applicationInfo->token->id);
                    }else{
                        $tokenAddOrUpdate = new AmazonToken();
                    }
                    $tokenAddOrUpdate->application_id = $applicationId;
                    $tokenAddOrUpdate->refresh_token = $response['refresh_token'];
                    $tokenAddOrUpdate->access_token = $response['access_token'];
                    $tokenAddOrUpdate->token_type = $response['token_type'];
                    $tokenAddOrUpdate->expire_in = now()->addHour(1);
                    $tokenAddOrUpdate->save();

                    $applicationInfo->is_authorize = 1;
                    $applicationInfo->save();
                    return redirect('amazon/applications')->with('success','Application Authorize Successfully');
                }else{
                    return redirect('amazon/applications')->with('error','Application Credentials Not Found');
                }
            }else{
                return redirect('amazon/applications')->with('error','Something Went Wrong. Please Authorize Again');
            }
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function getApplicationSessionValue($applicationId){
        try{
            Session::put('applicationId',$applicationId);
            return response()->json(['type' => 'success', 'msg' => 'Session Value Set Successfully']);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function accountList(){
        try{
            $accountLists = AmazonAccount::all();
            $content = view('amazon.account_list',compact('accountLists'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception');
        }
    }

    public function saveAccount(Request $request){
        try{
            $existAccountName = AmazonAccount::where('account_name',$request->amazon_account_name)->first();
            if($existAccountName){
                return response()->json(['type' => 'error', 'msg' => 'Account Name Already Exist']);
            }
            $folderPath = 'assets/amazon/';
            $imageName = null;
            if(isset($request->request_type)){
                if ($request->hasFile('amazon_account_logo')){
                    $logo = $request->amazon_account_logo;
                    $imageName = rand(10000, 99999).'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                    $imageName .= '-'.str_replace(' ', '-',$logo->getClientOriginalName());
                    $logo->move('./assets/amazon/',$imageName);
                }
            }else{
                if($request->amazon_account_logo != null){
                    $imageName = $this->singleBase64ToImage($request->amazon_logo_name, $request->amazon_account_logo, $folderPath);
                }
            }
            $insertInfo = AmazonAccount::create([
                'account_name' => $request->amazon_account_name,
                'account_status' => $request->amazon_account_status,
                'account_logo' => $imageName ? $folderPath.$imageName : null,
            ]);
            return response()->json(['type' => 'success', 'msg' => 'Account Added Successfully', 'data' => $insertInfo]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function singleAccountInfo($id){
        try{
            $accountInfo = AmazonAccount::find($id);
            if($accountInfo){
                return response()->json(['type' => 'success', 'msg' => '', 'data' => $accountInfo]);
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function updateAccount(Request $request){
        try{
            $existAccountName = AmazonAccount::where('account_name',$request->amazon_account_name)->where('id','!=',$request->amazon_account_primary_id)->first();
            if($existAccountName){
                return response()->json(['type' => 'error', 'msg' => 'Account Name Already Exist']);
            }
            $folderPath = 'assets/amazon/';
            $imageName = null;
            if($request->amazon_account_logo != null){
                $imageName = $this->singleBase64ToImage($request->amazon_logo_name, $request->amazon_account_logo, $folderPath);
            }
            $insertInfo = AmazonAccount::find($request->amazon_account_primary_id);
            $insertInfo->account_name = $request->amazon_account_name;
            $insertInfo->account_status = $request->amazon_account_status;
            if($imageName){
                $insertInfo->account_logo = $folderPath.$imageName;
            }
            $insertInfo->save();
            return response()->json(['type' => 'success', 'msg' => 'Account Updated Successfully', 'data' => $insertInfo]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function deleteAccount(Request $request){
        try{
            $deleteInfo = AmazonAccount::destroy($request->amazon_account_pk_id);
            return response()->json(['type' => 'success', 'msg' => 'Account Deleted Successfully','data' => $deleteInfo]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function generatenumber($limit){
        $code = '';
        for($i = 0; $i < $limit; $i++) {
            $code .= mt_rand(0, 9);
        }
        return $code;
    }

    public function applications(){
        try{
            $state = $this->generatenumber(16);
            $applicationsLists = AmazonAccountApplication::with(['accountInfo:id,account_name','marketPlace','token:id,application_id,refresh_token,access_token'])->get();
            $content = view('amazon.application.application_list',compact('applicationsLists','state'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function allAmazonAccount(){
        $allAccounts = AmazonAccount::where('account_status',1)->get();
        return $allAccounts;
    }

    public function allAmazonMarketPlace(){
        $allMarketPlaces = AmazonMarketPlace::all();
        return $allMarketPlaces;
    }

    public function addApplication(){
        try{
            $allAccounts = $this->allAmazonAccount();
            $allMarketPlaces = $this->allAmazonMarketPlace();
            $content = view('amazon.application.add_application',compact('allAccounts','allMarketPlaces'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function saveApplication(Request $request){
        $validation = $request->validate([
            'amazon_account_id' => 'required',
            'application_name' => 'required|max:255|unique:amazon_account_applications,application_name,NULL,id,deleted_at,NULL',
            'application_id' => 'required|unique:amazon_account_applications,application_id,NULL,id,deleted_at,NULL',
            'iam_arn' => 'required|unique:amazon_account_applications,iam_arn,NULL,id,deleted_at,NULL',
            'lwa_client_id' => 'required|unique:amazon_account_applications,lwa_client_id,NULL,id,deleted_at,NULL',
            'lwa_client_secret' => 'required|unique:amazon_account_applications,lwa_client_secret,NULL,id,deleted_at,NULL',
            'aws_access_key_id' => 'required|unique:amazon_account_applications,aws_access_key_id,NULL,id,deleted_at,NULL',
            'aws_secret_access_key' => 'required|unique:amazon_account_applications,aws_secret_access_key,NULL,id,deleted_at,NULL',
            'amazon_marketplace_fk_id' => 'required',
            'oauth_redirect_url' => 'required',
            'application_status' => 'required',
        ]);

        try{
            $applicationLogoName = '';
            if($request->has('application_logo')){
                $image = $request->application_logo;
                $name = rand(10000,99999).'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                $name .= str_replace(' ', '-',$image->getClientOriginalName());
                $image->move('assets/amazon/', $name);
                $applicationLogoName = 'assets/amazon/'.$name;
            }
            $applicationModel = new AmazonAccountApplication();
            $applicationModel->amazon_account_id = $request->amazon_account_id;
            $applicationModel->application_name = $request->application_name;
            $applicationModel->application_id = $request->application_id;
            $applicationModel->iam_arn = $request->iam_arn;
            $applicationModel->lwa_client_id = $request->lwa_client_id;
            $applicationModel->lwa_client_secret = $request->lwa_client_secret;
            $applicationModel->aws_access_key_id = $request->aws_access_key_id;
            $applicationModel->aws_secret_access_key = $request->aws_secret_access_key;
            $applicationModel->amazon_marketplace_fk_id = $request->amazon_marketplace_fk_id;
            $applicationModel->oauth_login_url = $request->oauth_login_url;
            $applicationModel->oauth_redirect_url = $request->oauth_redirect_url;
            $applicationModel->application_status = $request->application_status;
            $applicationModel->application_logo = $applicationLogoName;
            $applicationModel->save();

            $channelUpdateStatus = Channel::where('channel_term_slug','amazon')->update(['is_active' => 1]);
            if(isset($request->request_type)){
                return response()->json(['type' => 'success','msg' => 'Application Added Successfully']);
            }
            return back()->with('success','Application Added Successfully');
        }catch(\Exception $exception){
            if(isset($request->request_type)){
                return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
            }
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function editApplication($id){
        try{
            $allAccounts = $this->allAmazonAccount();
            $allMarketPlaces = $this->allAmazonMarketPlace();
            $singleApplicationInfo = AmazonAccountApplication::find($id);
            $content = view('amazon.application.edit_application',compact('allMarketPlaces','allAccounts','singleApplicationInfo'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function updateApplication(Request $request, $id){
        $validation = $request->validate([
            'amazon_account_id' => 'required',
            'application_name' => 'required|nullable|max:255|unique:amazon_account_applications,application_name,'.$id.',id,deleted_at,NULL',
            'application_id' => 'required',
            'iam_arn' => 'required',
            'lwa_client_id' => 'required',
            'lwa_client_secret' => 'required',
            'aws_access_key_id' => 'required',
            'aws_secret_access_key' => 'required',
            'amazon_marketplace_fk_id' => 'required',
            'oauth_redirect_url' => 'required',
            'application_status' => 'required',
        ]);
        try{
            $applicationLogoName = '';
            if($request->has('application_logo')){
                $image = $request->application_logo;
                $name = rand(10000,99999).'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                $name .= str_replace(' ', '-',$image->getClientOriginalName());
                $image->move('assets/amazon/', $name);
                $applicationLogoName = 'assets/amazon/'.$name;
            }
            $applicationModel = AmazonAccountApplication::find($id);
            $applicationModel->amazon_account_id = $request->amazon_account_id;
            $applicationModel->application_name = $request->application_name;
            $applicationModel->application_id = $request->application_id;
            $applicationModel->iam_arn = $request->iam_arn;
            $applicationModel->lwa_client_id = $request->lwa_client_id;
            $applicationModel->lwa_client_secret = $request->lwa_client_secret;
            $applicationModel->aws_access_key_id = $request->aws_access_key_id;
            $applicationModel->aws_secret_access_key = $request->aws_secret_access_key;
            $applicationModel->amazon_marketplace_fk_id = $request->amazon_marketplace_fk_id;
            $applicationModel->oauth_login_url = $request->oauth_login_url;
            $applicationModel->oauth_redirect_url = $request->oauth_redirect_url;
            $applicationModel->application_status = $request->application_status;
            if($applicationLogoName != ''){
                $applicationModel->application_logo = $applicationLogoName;
            }
            $applicationModel->save();
            return back()->with('success','Application Update Successfully');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function deleteApplication(Request $request){
        try{
            $deleteInfo = AmazonAccountApplication::destroy($request->amazon_application_pk_id);
            return response()->json(['type' => 'success', 'msg' => 'Application Deleted Successfully','data' => $deleteInfo]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

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

    public function activeCatalogues(Request $request){
        try{
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
            $settingData = $this->paginationSetting('amazon', 'amazon_pending_product');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'] ?? 50;
            $shelfUse = $this->shelf_use;

            $total_catalogues = AmazonMasterCatalogue::with(['applicationInfo' => function($application){
                $application->with(['accountInfo','marketPlace']);
            },'allVariations' => function($query){
                $query->with(['order_products' => function($query){
                    $this->orderWithoutCancelAndReturn($query,'amazon');
                    //$query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            },'variations' => function($query){
                $query->select('amazon_master_product', DB::raw('sum(amazon_variation_products.quantity) stock'))
                    ->groupBy('amazon_master_product');
            },'user_info' => function($user){
                $user->withTrashed();
            },'modifier_info' => function($modifier){
                $modifier->withTrashed();
            }])
                ->withCount('variations');

                $isSearch = $request->get('is_search') ? true : false;
                $allCondition = [];
                if($isSearch){
                    $this->amazonCatalogueSearchCondition($total_catalogues, $request);
                    $allCondition = $this->amazonCatalogueSearchParams($request, $allCondition);
                }
            $searchValue = null;
            if($request->has('search_value')){
                $searchValue = $request->get('search_value');
                $searchCatalogueIds = $this->amazonActiveCatalogueSeach($searchValue);
                $total_catalogues = $total_catalogues->whereIn('id',$searchCatalogueIds);
            }
            $total_catalogues = $total_catalogues->orderBy('id','DESC')->paginate($pagination)->appends(request()->query());
            $total_decode_catalogues = json_decode(json_encode($total_catalogues));
            $users = User::all();
            $applications = AmazonAccountApplication::where('application_status',1)->get();
            $accountWithMarketPlaces = AmazonMarketPlace::all();
            $content = view('amazon.catalogue.catalogue_list',compact('total_catalogues','total_decode_catalogues','allCondition','shelfUse','url','pagination','setting','users','searchValue','applications','accountWithMarketPlaces'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function searchWmsAmazonVariation($column, $value){
        $result = AmazonVariationProduct::select('amazon_master_product')->where($column,$value)->get()->toArray();
        return $result;
    }

    public function searchWmsAmazonCatalogue($column, $value){
        $result = AmazonMasterCatalogue::select('id')->where($column,$value)->get()->toArray();
        return $result;
    }

    public function amazonActiveCatalogueSeach($searchKeyword){
        try{
            if(is_numeric($searchKeyword)){
                if(strlen($searchKeyword) == 13){
                    $amazonCatalogueIds = $this->searchWmsAmazonVariation('ean_no',$searchKeyword);
                    return $amazonCatalogueIds;
                }else{
                    $amazonCatalogueIds = $this->searchWmsAmazonCatalogue('master_product_id',$searchKeyword);
                    return $amazonCatalogueIds;
                }
            }else{
                if(strlen($searchKeyword) == 10){
                    $amazonCatalogueIds = $this->searchWmsAmazonVariation('asin',$searchKeyword);
                    return $amazonCatalogueIds;
                }else{
                    $amazonCatalogueIdsBySKU = $this->searchWmsAmazonVariation('sku',$searchKeyword);
                    $amazonCatalogueIdsByTitle = AmazonMasterCatalogue::select('id')->where('title','LIKE','%'.$searchKeyword.'%')->get()->toArray();
                    return array_merge($amazonCatalogueIdsBySKU, $amazonCatalogueIdsByTitle);
                }
            }
        }catch(\Exception $exception){
            return $exception;
        }
    }

    public function pendingCatalogue(Request $request ,$ean = null){
        try{
            //Start page title and pagination setting
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
            $settingData = $this->paginationSetting('amazon', 'amazon_pending_product');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'] ?? 50;

            $shelfUse = $this->shelf_use;

            $total_catalogue = ProductDraft::whereDoesntHave('amazonCatalogueInfo', function($woocom){
                    $woocom->whereRaw('id != amazon_master_catalogues.master_product_id');
                })
                ->whereHas('ProductVariations', function($query){
                    $query->havingRaw('sum(actual_quantity) > 0');
                })->with(['ProductVariations' => function ($query) {
                    $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                        ->groupBy('product_draft_id');
                }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'catalogueVariation' => function ($query) {
                    $query->with(['shelf_quantity', 'order_products' => function ($query) {
                        $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                    }]);
                }])
                ->withCount('ProductVariations')
                ->where('status', 'publish');
                $isSearch = $request->get('is_search') ? true : false;
                $allCondition = [];
                if($isSearch){
                    $this->masterCatalogueSearchCondition($total_catalogue, $request);
                    $allCondition = $this->masterCatalogueSearchParams($request, $allCondition);
                }
            $total_catalogue = $total_catalogue->orderBy('id', 'DESC')->paginate($pagination);
            if($request->has('is_clear_filter')){
                $search_result = $total_catalogue;
                $view = view('amazon.catalogue.pending_catalogue_ajax', compact('search_result'))->render();
                return response()->json(['html' => $view]);
            }

            $users = User::orderBy('name', 'ASC')->get();
            $total_catalogue_info = json_decode(json_encode($total_catalogue));
            return view('amazon.catalogue.pending_catalogue',compact('total_catalogue','total_catalogue_info','users','ean','shelfUse', 'setting', 'page_title', 'pagination','url','allCondition'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function getPendingMasterVariation(Request $request){
        try{
            $id = $request->product_draft_id;
            $status = $request->status;
            $shelfUse = $this->shelf_use;
            if ($status == 'amazon_ean_pending'){
                $product_draft = ProductVariation::where('product_draft_id',$id)->get();
                $catalogue = json_decode(json_encode($product_draft));
                return view('amazon.catalogue.variation_ajax',compact('catalogue','id','status','shelfUse'));
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function createAmazonProduct($catalogueId){
        try{

            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
            // dd($listingLimitInfo,$clientListingLimit);
            // dd($listingLimitAllChannelActiveProduct);
            $masterCatalogueInfo = ProductDraft::with(['ProductVariations'])->find($catalogueId);
            $amazonApplicationInfo = AmazonAccountApplication::with(['accountInfo:id,account_name','marketPlace:id,marketplace'])->where('application_status',1)->where('is_authorize',1)->get();
            $content = view('amazon.catalogue.create_catalogue',compact('masterCatalogueInfo','amazonApplicationInfo','listingLimitAllChannelActiveProduct','clientListingLimit','listingLimitInfo'));
            return view('master',compact('content'));

        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function searchCatalogItemsInAmazon($applicationId, $keyword){
        $config = $this->configuration($applicationId);
        $api = new Api\CatalogApi($config);
        $marketplace_ids = array($this->marketPlaceId);
        $included_data = [
            // "attributes",
            "identifiers",
            "images",
            "productTypes",
            "salesRanks",
            "summaries",
            "variations"
            // "vendorDetails"
        ];
        return $api->searchCatalogItems($keyword, $marketplace_ids, $included_data);
    }

    public function checkDataIssetIsArrayGreaterThanOne($data){
        if(isset($data) && is_array($data) && (count($data) > 0)){
            return true;
        }
        return false;
    }

    public function existProductCheck(Request $request){
        try{
            $masterCatalogueInfo = ProductDraft::with(['ProductVariations'])->find($request->masterCatalogueId);
            if(($masterCatalogueInfo->ProductVariations != null) && (count($masterCatalogueInfo->ProductVariations) > 0)){
                $eanArr = [];
                $searchAbleEan = '';
                $amazonSearchResult = [];
                foreach($masterCatalogueInfo->ProductVariations as $variation){
                    if($variation->ean_no){
                        $eanArr[] = $variation->ean_no;
                        if($searchAbleEan == ''){
                            $searchAbleEan = $variation->ean_no;
                        }
                    }
                }
                if(count($eanArr) == 0){
                    return response()->json(['type' => 'success', 'html' => $this->errorMsgDivShow('No Ean Number Is Found In This Catalogue Variation')]);
                }
                foreach($eanArr as $ean){
                    $keywords = array($ean);
                    $allAsins = [];
                    $amazonSearchResultDataByEan = $this->searchCatalogItemsInAmazon($request->applicationId, $keywords, 20 );
                    if($this->checkDataIssetIsArrayGreaterThanOne($amazonSearchResultDataByEan['items'])){
                        break;
                    }
                }
                if($this->checkDataIssetIsArrayGreaterThanOne($amazonSearchResultDataByEan['items'])){
                    foreach($amazonSearchResultDataByEan['items'] as $result){
                        $isMasterAsin = $this->empty_array_check($result['variations']);
                        if($isMasterAsin){
                            $allAsins = $result['variations'][0]['asins'];
                        }else{
                            $allAsins[] = $result['asin'];
                        }
                        $amazonSearchResult['master_asin'] = $result['asin'] ?? '';
                        $amazonSearchResult['master_title'] = $result['summaries'][0]['item_name'] ?? '';
                        $amazonSearchResult['product_type'] = $result['product_types'][0]['product_type'] ?? '';
                        $amazonSearchResult['master_image'] = $result['images'][0]['images'][0]['link'] ?? '';
                    }
                }
                if(count($allAsins) == 0){
                    return response()->json(['type' => 'success', 'html' => $this->errorMsgDivShow('No ASIN Number Is Found Against This Catalogue')]);
                }
                $asinNewFormattedArr = [];
                $asinTempArr = [];
                $i = 1;
                foreach($allAsins as $asin){
                    $asinTempArr[] = $asin;
                    if((count($asinTempArr) == 10) || ($i == count($allAsins))){
                        $asinNewFormattedArr[] = $asinTempArr;
                        $asinTempArr = [];
                    }
                    $i++;
                }
                $amazonSearchResultData = [];
                $amazonSearchResultArr = [];
                $isMasterCatalogueExist = $this->amazonMasterCatalogueExistCheck($request->masterCatalogueId, $request->applicationId);
                if($isMasterCatalogueExist){
                    $amazonSearchResult['is_master_catalogue_exit'] = true;
                    $amazonSearchResult['exist_master_catalogue_id'] = $isMasterCatalogueExist->id;
                }
                $amazonSearchResult['master_sale_price'] = $masterCatalogueInfo->sale_price;
                $amazonSearchResult['marketplace'] = $this->marketPlace;
                foreach($asinNewFormattedArr as $asinArr){
                    try{
                        $amazonSearchResultData = $this->searchCatalogItemsInAmazon($request->applicationId, $asinArr);
                        if($this->checkDataIssetIsArrayGreaterThanOne($amazonSearchResultData['items'])){
                            foreach($amazonSearchResultData['items'] as $result){
                                $eanNo = $result['identifiers'][0]['identifiers'][0]['identifier'];
                                $wmsAmazonVariationExistCheck = $this->wmsAmazonVariationExistCheck($eanNo, 'ean');
                                if(!$wmsAmazonVariationExistCheck && in_array($eanNo,$eanArr)){

                                    $variationInfo = $this->getMasterVariationInfo($eanNo,'ean');
                                    $amazonItemOffers = $this->getAmazonOffers($request->applicationId,$result['asin'],'asin');
                                    $allOffers = null;
                                    if($amazonItemOffers['payload']){
                                        $payloadData = $amazonItemOffers['payload'];
                                        if($payloadData['status'] == 'Success'){
                                            $allOffers['total_offer_count'] = $payloadData['summary']['total_offer_count'] ?? 0;
                                            $allOffers['lowest_prices'] = $payloadData['summary']['lowest_prices'][0]['listing_price']['amount'] ?? 0.00;
                                            $allOffers['buy_box_prices'] = $payloadData['summary']['buy_box_prices'][0]['listing_price']['amount'] ?? 0.00;
                                            $allOffers['offers'] = [];
                                            if(count($payloadData['offers']) > 0){
                                                foreach($payloadData['offers'] as $offer){
                                                    $allOffers['offers'][] = [
                                                        'seller_feedback_rating' => $offer['seller_feedback_rating'],
                                                        'listing_price' => $offer['listing_price']['amount'] ?? 0.00,
                                                        'shipping' => $offer['shipping']['amount'] ?? 0.00,
                                                        'is_buy_box_winner' => $offer['is_buy_box_winner'] ?? false,
                                                    ];
                                                }
                                            }
                                        }
                                    }
                                    $amazonSearchResultArr[] = [
                                        'main_picture' => $result['images'][0]['images'][0]['link'] ?? '',
                                        'title' => $result['summaries'][0]['item_name'] ?? '',
                                        'asin' => $result['asin'] ?? '',
                                        'brand_name' => $result['summaries'][0]['brand_name'] ?? '',
                                        'product_type' => $result['product_types'][0]['product_type'] ?? '',
                                        'manufacturer' => $result['summaries'][0]['manufacturer'] ?? '',
                                        'model_number' => $result['summaries'][0]['model_number'] ?? '',
                                        'color_name' => $result['summaries'][0]['color_name'] ?? '',
                                        'size_name' => $result['summaries'][0]['size_name'] ?? '',
                                        'style_name' => $result['summaries'][0]['style_name'] ?? '',
                                        'ean_no' => $eanNo ?? '',
                                        'is_master_asin' => $isMasterAsin,
                                        'all_offers' => $allOffers,
                                        'variation_info' => [
                                            'variation_id' => $variationInfo->id ?? '',
                                            'attribute' => $variationInfo->attribute ?? '',
                                            'sku' => $variationInfo->sku ?? '',
                                            'sale_price' => $variationInfo->sale_price ?? '',
                                            'quantity' => $variationInfo->actual_quantity ?? '',
                                        ]
                                    ];
                                    // $amazonSearchResult['master_asin'] = $result['asin'] ?? '';
                                    // $amazonSearchResult['master_title'] = $result['summaries'][0]['item_name'] ?? '';
                                    // $amazonSearchResult['product_type'] = $result['product_types'][0]['product_type'] ?? '';
                                    // $amazonSearchResult['master_image'] = $result['images'][0]['images'][0]['link'] ?? '';
                                }
                            }
                        }
                        sleep(1);
                    }catch(\Exception $exception){
                        return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
                    }
                }
                $amazonSearchResult['items'] = $amazonSearchResultArr;
                $amazonSearchResult['amazon_country'] = AmazonCountry::all();
                $amazonSearchResult['item_condition'] = AmazonCondition::all();
                $amazonSearchResult['product_type'] = AmazonMarketPlace::with(['productType'])->where('marketplace_id', $this->marketPlaceId)->first();
                $exitProductView = view('amazon.catalogue.amazon_exist_product_check',compact('amazonSearchResult'))->render();
                return response()->json(['type' => 'success', 'html' => $exitProductView]);
            }else{
                return response()->json(['type' => 'success', 'html' => $this->errorMsgDivShow('No Variation Is Found In This Catalogue')]);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function getAmazonOffers($applicationId,$value,$type){
        $result = [];
        $config = $this->configuration($applicationId);
        $api = new Api\ProductPricingApi($config);
        $marketplace_id = $this->marketPlaceId;
        try{
            if($type == 'asin'){
                return $api->getItemOffers($marketplace_id, 'New', $value);
            }
            return $result;
        }catch(\Exception $exception){
            return $result;
        }
    }

    public function amazonMasterCatalogueExistCheck($wmsMasterCatalogueId, $applicationId){
        $catalogueInfo = AmazonMasterCatalogue::where('master_product_id',$wmsMasterCatalogueId)->where('application_id',$applicationId)->first();
        return $catalogueInfo;
    }

    public function errorMsgDivShow($message){
        $errorDivcontent = '<div class="alert alert-danger text-center">
                        <h5>'.$message.'</h5>
                    </div>';
        return $errorDivcontent;
    }

    public function saveAmazonProduct(Request $request){
        try{

            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

            // $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
            // $clientListingLimit = $this->ClientListingLimit();

            //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

            if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
                return redirect('amazon/create-amazon-product/'.$request->master_catalogue_id);
            }else{
                $masterCatalogueExitsInfo = AmazonMasterCatalogue::where('master_product_id',$request->master_catalogue_id)
                ->where('application_id',$request->amazon_application_id)->first();
                //dd($masterCatalogueExitsInfo);
                if(!$request->exists_master_catalogue_id && !$masterCatalogueExitsInfo){
                    $masterCatalogueInsertInfo = AmazonMasterCatalogue::create([
                        'master_product_id' => $request->master_catalogue_id,
                        'application_id' => $request->amazon_application_id,
                        'title' => $request->master_title,
                        'master_asin' => $request->master_asin,
                        'description' => null,
                        'images' => $request->master_image,
                        'product_type' => $this->productType($request->product_type) ? $this->productType : 1,
                        'condition_id' => explode('/',$request->item_condition)[0],
                        'category_id' => null,
                        'fulfilment_type' => 'Merchant',
                        'sale_price' => $request->master_sale_price,
                        'creator_id' => Auth::id(),
                        'modifier_id' => Auth::id(),
                    ]);
                    if($masterCatalogueInsertInfo){
                        $issues = $this->variationInsertInfo($request,$masterCatalogueInsertInfo->id);
                    }
                }else{
                    $issues = $this->variationInsertInfo($request,$masterCatalogueExitsInfo->id);
                }
                if(is_array($issues) && (count($issues) == 0)){
                    return redirect('amazon/active-catalogues')->with('success','Catalogue Added Successfully');
                }
                $issueDetails = '';
                $i = 1;
                foreach($issues as $issue){
                    $issueDetails .= 'Error'.$i.':'.$this->amazonExceptionIssueAsString($issue);
                    $i++;
                }
                return redirect('amazon/active-catalogues')->with('error',$issueDetails);
            }

        }catch(\Exception $exception){
            return back()->with('error','Something Went Wrong');
        }

    }

    public function amazonExceptionIssueAsString($singleIssue){
        $exceptionIssue = '';
        $issueString = ' SKU: '.$singleIssue['sku'].',';
        foreach($singleIssue['issues'] as $issue){
            $issueString .= ' Attribute Name: '.$issue['attribute_name'].',';
            $issueString .= ' Message: '.$issue['message'];
        }
        return $issueString;
    }

    public function variationInsertInfo($request,$amazonMasterCatalogueId){
        try{
            $exceptionIssues = [];
            foreach($request->master_variation_ean as $key => $value){
                $amazonInsertInfo = $this->listVariationInAmazon($request, $key);
                if($amazonInsertInfo && ($amazonInsertInfo['status'] == 'ACCEPTED')){
                    $amazonVariationExist = AmazonVariationProduct::where('amazon_master_product',$amazonMasterCatalogueId)->where('ean_no',$request->master_variation_ean[$key])->first();
                    if(!$amazonVariationExist){
                        $variationInsertInfo = AmazonVariationProduct::create([
                            'amazon_master_product' => $amazonMasterCatalogueId,
                            'master_variation_id' => $request->master_variation_id[$key],
                            'attribute' => $request->master_variation_attribute[$key],
                            'sku' => $request->sku[$key],
                            'ean_no' => $request->master_variation_ean[$key],
                            'asin' => $request->amazon_variation_asin[$key],
                            'quantity' => $request->quantity[$key],
                            'regular_price' => null,
                            'sale_price' => $request->sale_price[$key],
                            'rrp' => null,
                            'is_master_editable' => $request->is_master_editable[$key] ?? 1,
                        ]);
                    }
                }else{
                    $exceptionIssues[] = [
                        'sku' => $amazonInsertInfo['sku'],
                        'issues' => $amazonInsertInfo['issues']
                    ];
                }
            }
            return $exceptionIssues;
        }catch(\Exception $exception){
            return [];
        }
    }

    public function saveSingleAmazonProduct(Request $request){
        try{
            $exceptionIssues = [];
            $amazonExistMasterCatalogue = AmazonMasterCatalogue::find($request->existMasterCatalogueId);
            if($amazonExistMasterCatalogue){
                $request['amazon_application_id'] = $amazonExistMasterCatalogue->application_id;
                $request['product_type'] = $request->productType;
                $request['item_condition'] = $request->itemCondition;
                $request['master_variation_id'] = [$request->variationId];
                $request['master_variation_ean'] = [$request->ean];
                $request['amazon_variation_asin'] = [$request->asin];
                $request['sale_price'] = [$request->salePrice];
                $request['quantity'] = [$request->quantity];
                $request['sku'] = [$request->sku];
                $request['is_master_editable'] = [$request->isMasterEditable];
                $key = 0;
                $amazonVariationExist = AmazonVariationProduct::where('amazon_master_product',$amazonExistMasterCatalogue->id)->where('ean_no',$request->ean)->first();
                if(!$amazonVariationExist){
                    $amazonInsertInfo = $this->listVariationInAmazon($request, $key);
                        if($amazonInsertInfo && ($amazonInsertInfo['status'] == 'ACCEPTED')){
                            $variationInsertInfo = AmazonVariationProduct::create([
                                'amazon_master_product' => $request->existMasterCatalogueId,
                                'master_variation_id' => $request->master_variation_id[$key],
                                'attribute' => $request->attribute,
                                'sku' => $request->sku[$key],
                                'ean_no' => $request->master_variation_ean[$key],
                                'asin' => $request->amazon_variation_asin[$key],
                                'quantity' => $request->quantity[$key],
                                'regular_price' => null,
                                'sale_price' => $request->sale_price[$key],
                                'rrp' => null,
                                'is_master_editable' => $request->is_master_editable[$key] ?? 1,
                            ]);
                        return response()->json(['type' => 'success', 'msg' => 'Variation Added Successfully']);
                    }else{
                        $exceptionIssues[] = [
                            'sku' => $amazonInsertInfo['sku'],
                            'issues' => $amazonInsertInfo['issues']
                        ];
                        return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong. Plase Check WMS And Amazon']);
                    }
                }else{
                    return response()->json(['type' => 'error', 'msg' => 'Variation Already Listed']);
                }
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Master Catalogue Is Not Found In WMS']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function listVariationInAmazon($request, $key){
        try{
            $result = [];
            $config = $this->configuration($request->amazon_application_id);
            $amazonInsertableDataFormat = [
                'productType' => $request->product_type,
                'requirements' => 'LISTING_OFFER_ONLY',
                'attributes' => [
                    'externally_assigned_product_identifier' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'type' => 'ean',
                            'value' => $request->master_variation_ean[$key]
                        ]
                    ],
                    'merchant_suggested_asin' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'value' => $request->amazon_variation_asin[$key]
                        ]
                    ],
                    // 'item_name' => [
                    //     [
                    //         'language_tag' => 'en_GB',
                    //         'marketplace_id' => $this->marketPlaceId,
                    //         'value' => "Diesel Men's T-Joe-sc T-Shirt"
                    //     ]
                    // ],
                    // 'brand' => [
                    //     [
                    //         'language_tag' => 'en_GB',
                    //         'marketplace_id' => $this->marketPlaceId,
                    //         'value' => 'Diesel'
                    //     ]
                    // ],
                    'purchasable_offer' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'currency' => 'GBP',
                            'our_price' => [
                                [
                                    'schedule' => [
                                            [
                                                'value_with_tax' => $request->sale_price[$key]
                                            ]
                                        ]
                                ]
                            ]
                        ]
                    ],
                    'fulfillment_availability' => [
                        [
                            'fulfillment_channel_code' => 'DEFAULT',
                            'quantity' => $request->quantity[$key]
                            // 'fulfillment_channel_code' => 'AMAZON_EU',
                            // 'is_inventory_available' => true,
                            // 'lead_time_to_ship_max_days' => 30,
                        ]
                    ],
                    'condition_type' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'value' => explode('/',$request->item_condition)[1]
                        ]
                    ],
                    // 'country_of_origin' => [
                    //     [
                    //         'marketplace_id' => $this->marketPlaceId,
                    //         'value' => $request->country_of_origin
                    //     ]
                    // ],
                    'supplier_declared_dg_hz_regulation' => [
                        [
                            'value' => 'not_applicable'
                        ]
                    ],
                    'batteries_required' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'value' => false
                        ]
                    ],
                ]
            ];
            $body = json_encode($amazonInsertableDataFormat);
            $api = new Api\ListingsApi($config);
            $marketplace_ids = array($this->marketPlaceId);
            try{
                $result = $api->putListingsItem($this->sellerId, $request->sku[$key], $marketplace_ids, $body, $this->issueLocal);
            }catch(\Exception $exception){
                return $result;
            }
            return $result;
        }catch(\Exception $exception){
            return $result;
        }
    }

    public function createAmazonMasterCatalogue(){
        $config = $this->configuration(1);
        $amazonInsertableDataFormat = [
            'productType' => 'APPAREL',
            'requirements' => 'LISTING',
            'requirementsEnforced' => 'ENFORCED',
            'attributes' => [
                'fulfillment_availability' => [
                    [
                        'fulfillment_channel_code' => 'DEFAULT',
                        'quantity' => 1
                    ]
                ],
                'purchasable_offer' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'currency' => 'GBP',
                        'our_price' => [
                            [
                                'schedule' => [
                                        [
                                            'value_with_tax' => 29.99
                                        ]
                                    ]
                            ]
                        ]
                    ]
                ],
                'condition_type' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'new_new'
                    ]
                ],
                // 'main_product_image_locator' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://m.media-amazon.com/images/I/71lv7oaW9GL._AC_UX679_.jpg"
                //     ]
                // ],
                // 'other_product_image_locator_1' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://m.media-amazon.com/images/I/71MX0RnonCL._AC_UX679_.jpg"
                //     ]
                // ],
                // 'other_product_image_locator_2' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://woowms.com/admin/uploads/product-images/95569-2021-08-29-08-27-14-DIESEL-T-JOE-QJ-Mens-T-Shirt-Short-Sleeve-Crew-Neck-Casual-Summer-Cotton-Tees-Top-Brand-Outlet---topbrandoutlet.co-(1).jpg"
                //     ]
                // ],
                // 'other_product_image_locator_3' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://woowms.com/admin/uploads/product-images/95569-2021-08-29-08-27-14-DIESEL-T-JOE-QJ-Mens-T-Shirt-Short-Sleeve-Crew-Neck-Casual-Summer-Cotton-Tees-Top-Brand-Outlet---topbrandoutlet.co-(2).jpg"
                //     ]
                // ],
                // 'other_product_image_locator_4' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://woowms.com/admin/uploads/product-images/95569-2021-08-29-08-27-14-DIESEL-T-JOE-QJ-Mens-T-Shirt-Short-Sleeve-Crew-Neck-Casual-Summer-Cotton-Tees-Top-Brand-Outlet---topbrandoutlet.co-(3).jpg"
                //     ]
                // ],
                // 'other_product_image_locator_5' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'media_location' => "https://woowms.com/admin/uploads/product-images/95569-2021-08-29-08-27-14-DIESEL-T-JOE-QJ-Mens-T-Shirt-Short-Sleeve-Crew-Neck-Casual-Summer-Cotton-Tees-Top-Brand-Outlet---topbrandoutlet.co-(7).jpg"
                //     ]
                // ],
                // 'parentage_level' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 'parent'
                //     ]
                // ],
                // 'child_parent_sku_relationship' => [
                //     [
                //         'child_relationship_type' => 'variation',
                //         'marketplace_id'  => $this->marketPlaceId,
                //         // 'parent_sku' => '95569'
                //     ]
                // ],
                // 'variation_theme' => [
                //     [
                //         'name' => 'SIZE',
                //     ]
                // ],
                'country_of_origin' => [
                    [
                        'marketplace_id' => $this->marketPlaceId,
                        'value' => 'BD'
                    ]
                ],
                'supplier_declared_dg_hz_regulation' => [
                    [
                        'value' => 'not_applicable'
                    ]
                ],
                'supplier_declared_material_regulation' => [
                    [
                        'value' => 'not_applicable'
                    ]
                ],
                'item_name' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id' => $this->marketPlaceId,
                        'value' => "DIESEL T DIEGO BB Mens T-Shirt Crew Neck Short Sleeve Blue Tee Casual Cotton Top"
                    ]
                ],
                'brand' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id' => $this->marketPlaceId,
                        'value' => 'DIESEL'
                    ]
                ],
                'externally_assigned_product_identifier' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'type' => 'ean',
                        'value' => '8055192912961'
                    ]
                ],
                'product_description' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => "Diesel - is an Italian fashion label, founded in 1978. Diesel is an innovative fashion company, producing a wide-ranging collection of jeans, clothing, shoes, and accessories for men's, women's and kids. The clothing line has two different brands: Diesel and Diesel Black Gold. The brand is primarily known for its trademark denim and high-quality casual wear that puts an edgy twist on luxury fashion with its pioneering new styles and creative design methods.



                        Diesel Men's Short Sleeve Crew Neck T-Shirt
                        Style Name: T DIEGO BB T-Shirt
                        Product Code: 00SFVR-0HARE
                        Material: 100% Cotton
                        Pattern: Soft with print
                        Neckline: Round
                        Regular Fit
                        Made in Bangladesh
                        Crew Neck
                        Short Sleeve
                        Machine wash
                        Size: S - XL
                        Colour: Blue"
                    ]
                ],
                'bullet_point' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => "Soft with print,Round,Short Sleeves,Regular fit,Crew Neck"
                    ]
                ],
                // 'merchant_suggested_asin' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => $request->amazon_variation_asin[$key]
                //     ]
                // ],
                // 'power_plug_type' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 'no_plug'
                //     ]
                // ],
                // 'is_fragile' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => false
                //     ]
                // ],
                'size' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'L'
                    ]
                ],
                // 'number_of_items' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 1
                //     ]
                // ],
                // 'specific_uses_keyword' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'language_tag' => 'en_GB',
                //         'value' => 'Tshirts'
                //     ]
                // ],
                // 'part_number' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => '00SZRX-0JAOP'
                //     ]
                // ],
                // 'unit_count' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 1
                //     ]
                // ],
                'color' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'Blue',
                        'standardized_values' => ['Blue']
                    ]
                ],
                'item_type_name' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'T-Shirt'
                    ]
                ],
                'fabric_type' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => '100% Cotton'
                    ]
                ],
                // 'number_of_boxes' => [
                //     [
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 1
                //     ]
                // ],
                'model_name' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'Mens T-Shirt'
                    ]
                ],
                // 'pattern' => [
                //     [
                //         'language_tag' => 'en_GB',
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 'Solid'
                //     ]
                // ],
                'care_instructions' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'Machine Wash'
                    ]
                ],
                // 'item_form' => [
                //     [
                //         'language_tag' => 'en_GB',
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 'Bolt Of Fabric'
                //     ]
                // ],
                'manufacturer' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'DIESEL'
                    ]
                ],
                // 'weight_classification' => [
                //     [
                //         'language_tag' => 'en_GB',
                //         'marketplace_id'  => $this->marketPlaceId,
                //         'value' => 'Lightweight (116-200 GSM)'
                //     ]
                // ],
                'recommended_browse_nodes' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => '1731028031'
                    ]
                ],
                'batteries_required' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => false
                    ]
                ],
                'style' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'Short Sleeve'
                    ]
                ],
                'age_range_description' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'Adult'
                    ]
                ],
                'target_gender' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => 'male'
                    ]
                ],
                'department' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => "Men's"
                    ]
                ],
                'outer' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'material' => [
                            [
                                'language_tag' => 'en_GB',
                                'value' => "Cotton"
                            ]
                        ]
                    ]
                ],
                'closure' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'type' => [
                            [
                                'language_tag' => 'en_GB',
                                'value' => "Pull On"
                            ]
                        ]
                    ]
                ],
                'special_size_type' => [
                    [
                        'language_tag' => 'en_GB',
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => "Big Boys"
                    ]
                ],
                'model_number' => [
                    [
                        'marketplace_id'  => $this->marketPlaceId,
                        'value' => "00SFVR-0HARE"
                    ]
                ],
            ]
        ];
        $body = json_encode($amazonInsertableDataFormat);
        $api = new Api\ListingsApi($config);
        $marketplace_ids = array($this->marketPlaceId);
        // try{
            $result = $api->putListingsItem($this->sellerId, 'T-DIEGO-BB_8ER_M', $marketplace_ids, $body, $this->issueLocal);
            echo '<pre>';
            print_r($result);

        // }catch(\Exception $exception){
        //     echo '<pre>';
        //     print_r($exception);
        // }
        exit();
        return $result;
    }

    public function wmsAmazonVariationExistCheck($value, $type = null){
        if($type == 'ean'){
            return AmazonVariationProduct::where('ean_no',$value)->first();
        }
    }

    public function productType($productType, $marketPlace = null){
        $productTypeInfo = AmazonProductType::where('product_type',$productType)->first();
        if($productTypeInfo){
            $this->productType = $productTypeInfo->id;
        }
        return $productTypeInfo;
    }

    public function getMasterVariationInfo($value, $type = null){
        try{
            $info = [];
            if($type == 'ean'){
                $info = ProductVariation::where('ean_no',$value)->first();
            }
            return $info;
        }catch(\Exception $exception){
            return 'error';
        }
    }

    public function empty_array_check($data){
        if(is_array($data) && (count($data) > 0)){
            return true;
        }
        return false;
    }

    public function applicationInfoWithToken($id){
        try{
            $applicationInfo = AmazonAccountApplication::with(['token','marketPlace' => function($query){
                $query->with(['endpointInfo']);
            }])->find($id);
            return $applicationInfo;
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function configuration($applicationId){
        try{
            $config = [];
            $applicationInfo = $this->applicationInfoWithToken($applicationId);

            $this->applicationInfo = $applicationInfo;
            $this->marketPlaceId = $applicationInfo->marketPlace->marketplace_id;
            $this->marketPlace = $applicationInfo->marketPlace->marketplace;

            $config['lwaClientId'] = $applicationInfo->lwa_client_id;
            $config['lwaClientSecret'] = $applicationInfo->lwa_client_secret;
            $config['lwaRefreshToken'] = $applicationInfo->token->refresh_token;
            $config['awsAccessKeyId'] = $applicationInfo->aws_access_key_id;
            $config['awsSecretAccessKey'] = $applicationInfo->aws_secret_access_key;
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'NA'){
                $config['endpoint'] = Endpoint::NA;
            }
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'EU'){
                $config['endpoint'] = Endpoint::EU;
            }
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'FE'){
                $config['endpoint'] = Endpoint::FE;
            }
            $config['roleArn'] = $applicationInfo->iam_arn;
            $configuration = new Configuration($config);
            return $configuration;
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function updateVariation(Request $request){
        try{
            $amazonVariationInfo = AmazonVariationProduct::with(['masterCatalogue' => function($query){
                $query->with(['catalogueType']);
            }])->find($request->amazon_variation_id);
            $config = $this->configuration($amazonVariationInfo->masterCatalogue->application_id);
            $data = [
                'productType' => $amazonVariationInfo->masterCatalogue->catalogueType->product_type,
                'patches' => [
                    [
                        'op' => 'replace',
                        'path' => '/attributes/fulfillment_availability',
                        'value' => [
                            [
                                'fulfillment_channel_code' => 'DEFAULT',
                                'quantity' => $request->amazon_quantity,
                            ]
                        ]
                    ],
                    [
                        'op' => 'replace',
                        'path' => '/attributes/purchasable_offer',
                        'value' => [
                            [
                                'marketplace_id'  => $this->marketPlaceId,
                                'currency' => 'GBP',
                                'our_price' => [
                                    [
                                        'schedule' => [
                                                [
                                                    'value_with_tax' => $request->amazon_sales_price
                                                ]
                                            ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            $body = json_encode($data);
            $api = new Api\ListingsApi($config);
            $marketplace_ids = array($this->marketPlaceId);
            $result = $api->patchListingsItem($this->sellerId, $amazonVariationInfo->sku, $marketplace_ids, $body);
            if($result['status'] == 'ACCEPTED'){
                $wmsAmazonVariationInfoUpdate = AmazonVariationProduct::find($amazonVariationInfo->id)
                ->update(['quantity' => $request->amazon_quantity, 'sale_price' => $request->amazon_sales_price, 'is_master_editable' => $request->isMasterEditable]);
                if($wmsAmazonVariationInfoUpdate){
                    return response()->json(['type' => 'success', 'updated_quantity' => $request->amazon_quantity, 'updated_sale_price' => $request->amazon_sales_price, 'msg' => 'Variation Updated Successfully']);
                }else{
                    return response()->json(['type' => 'error', 'msg' => 'Amazon Updated But WMS Not Updated']);
                }
            }else{
                $issuesArr = [];
                if($result['issues']){
                    foreach($result['issues'] as $issue){
                        $issuesArr[$issue['attribute_name']] = $issue['message'];
                    }
                }
                return response()->json(['type' => 'issue', 'msg' => 'Something Went Wrong', 'issues' => $issuesArr]);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => $exception->getMessage()]);
        }
    }

    public function deleteVariation(Request $request){
        try{
            $amazonVariationInfo = AmazonVariationProduct::with(['masterCatalogue'])->find($request->amazon_variation_id);
            if($amazonVariationInfo){
                $config = $this->configuration($amazonVariationInfo->masterCatalogue->application_id);
                $result = $this->deleteListingFromWmsAndAmazon($amazonVariationInfo->sku,$config);
                if($result['status'] == 'ACCEPTED'){
                    $amazonVariationInfo->delete();
                    return response()->json(['type' => 'success', 'msg' => 'Variation Deleted Successfully']);
                }else{
                    $issuesArr = [];
                    if($result['issues']){
                        foreach($result['issues'] as $issue){
                            $issuesArr[$issue['attribute_name']] = $issue['message'];
                        }
                    }
                    return response()->json(['type' => 'issue', 'msg' => 'Something Went Wrong', 'issues' => $issuesArr]);
                }
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Amazon Variation Not Found In WMS']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function deleteListingFromWmsAndAmazon($sku, $config){
        $api = new Api\ListingsApi($config);
        $marketplace_ids = array($this->marketPlaceId);
        return $api->deleteListingsItem($this->sellerId, $sku, $marketplace_ids);

    }

    public function deleteCatalogue(Request $request){
        try{
            $amazonCatalogueInfo = AmazonMasterCatalogue::with(['variations'])->find($request->amazon_catalogue_id);
            $issuesArr = [];
            if($amazonCatalogueInfo){
                $config = $this->configuration($amazonCatalogueInfo->application_id);
                if(isset($amazonCatalogueInfo->variations)){
                    foreach($amazonCatalogueInfo->variations as $variation){
                        $wmsAmazonVariationInfo = AmazonVariationProduct::find($variation->id);
                        $result = $this->deleteListingFromWmsAndAmazon($wmsAmazonVariationInfo->sku,$config);
                        if($result['status'] == 'ACCEPTED'){
                            $wmsAmazonVariationInfo->delete();
                        }else{
                            if($result['issues']){
                                $issuesArr[] = [
                                    'sku' => $result['sku'],
                                    'issues' => $result['issues']
                                ];
                            }
                        }
                    }
                }
                if(count($issuesArr) > 0){
                    return response()->json(['type' => 'issue', 'msg' => 'Something Went Wrong', 'issues' => $issuesArr]);
                }
                $amazonCatalogueInfo->delete();
                return response()->json(['type' => 'success', 'msg' => 'Catalogue Deleted Successfully']);
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Amazon Catalogue Not Found In WMS']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function migrateProductType(Request $request){
        try{
            $config = $this->configuration($request->applicationId);
            $api = new Api\ProductTypeDefinitionsApi($config);
            $marketplace_ids = array($this->marketPlaceId);
            $result = [];
            try {
                $result = $api->searchDefinitionsProductTypes($marketplace_ids);
                if(isset($result['product_types'])){
                    $marketPlacePrimaryId = AmazonMarketPlace::where('marketplace_id',$this->marketPlaceId)->first();
                    if($marketPlacePrimaryId){
                        foreach($result['product_types'] as $type){
                            $typeInsert[] = [
                                'marketplace_id' => $marketPlacePrimaryId->id,
                                'product_type' => $type['name'],
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                        $insertResult = AmazonProductType::insert($typeInsert);
                    }else{
                        return response()->json(['type' => 'error', 'msg' => 'Market Place Not Foung In WMS']);
                    }
                }else{
                    return response()->json(['type' => 'error', 'msg' => 'No Product Type Found']);
                }
                return response()->json(['type' => 'success', 'msg' => 'Product Type Migrated Successfully', 'data' => $result['product_types']]);
            } catch (Exception $e) {
                return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function sellerSites(){
        try{
            $allAccountInfo = AmazonAccount::select('id','account_name')->with(['sellerSites'])->get();
            $content = view('amazon.seller_sites',compact('allAccountInfo'));
            return view('master',compact('content'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function migrateSellerSites(Request $request){
        try{
            $accountInfo = AmazonAccountApplication::where('amazon_account_id', $request->accountId)->first();
            if($accountInfo){
                $config = $this->configuration($accountInfo->id);
                $api = new Api\SellersApi($config);
                $result = [];
                try {
                    $result = $api->getMarketplaceParticipations();
                    if(isset($result['payload'])){
                        foreach($result['payload'] as $site){
                            $marketPlacePrimaryId = AmazonMarketPlace::where('marketplace_id',$site['marketplace']['id'])->first();
                            if($marketPlacePrimaryId){
                                $insertInfo = AmazonSellerSite::create([
                                    'account_id' => $request->accountId,
                                    'wms_marketplace_pk_id' => $marketPlacePrimaryId->id,
                                    'marketplace_id' => $site['marketplace']['id'],
                                    'name' => $site['marketplace']['name'],
                                    'country_code' => $site['marketplace']['country_code'],
                                    'default_currency_code' => $site['marketplace']['default_currency_code'],
                                    'default_language_code' => $site['marketplace']['default_language_code'],
                                    'domain_name' => $site['marketplace']['domain_name'],
                                ]);
                            }
                        }
                    }else{
                        return response()->json(['type' => 'error', 'msg' => 'No Seller Sites Found']);
                    }
                    return response()->json(['type' => 'success', 'msg' => 'Seller Sites Migrated Successfully', 'data' => $result['payload']]);
                } catch (Exception $e) {
                    return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
                }
            }else{
                return response()->json(['type' => 'error', 'msg' => 'No Application Found In Wms']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function allAccountInfo(){
        try{
            $allAccountInfo = AmazonAccount::all();
            return $allAccountInfo;
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function orderSync($orderType = null){
        try{
            $orderSyncType = ($orderType == 'manual') ? 'Manual Sync' : 'Auto Sync';
            $allAccountSites = AmazonAccountApplication::get();
            if(count($allAccountSites) > 0){
                foreach($allAccountSites as $site){
                    $config = $this->configuration($site->id);
                    $api = new Api\OrdersApi($config);
                    $marketplace_ids = array($this->marketPlaceId);
                    $created_after = date('Y-m-d', strtotime(Carbon::now()->subDays(3)));
                    try {
                        $allOrders = $api->getOrders($marketplace_ids, $created_after, null, null, null, array('Unshipped'));
                        if((is_array($allOrders['payload']['orders'])) && (count($allOrders['payload']['orders']) > 0)){
                            foreach($allOrders['payload']['orders'] as $order){
                                $existOrderInfo = Order::where('order_number',$order['amazon_order_id'])->first();
                                if(!$existOrderInfo){
                                    $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['name'].'</h7></div></div>';
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['address_line1']. ',' . $order['shipping_address']['address_line2']. ',' . $order['shipping_address']['address_line3'].'</h7></div></div>';
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['city']. '</h7></div></div>';
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['county']. '</h7></div></div>';
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['postal_code']. '</h7></div></div>';
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $order['shipping_address']['country_code']. '</h7></div></div>';

                                    $lastOrderInfo = Order::latest()->first();
                                    $orderPrimaryId = $lastOrderInfo->id + 1;
                                    if($lastOrderInfo){
                                        $amazonOrderInsertData = Order::create([
                                            'id' => $orderPrimaryId,
                                            'order_number' => $order['amazon_order_id'] ?? null,
                                            'status' => 'processing',
                                            'created_via' => 'amazon',
                                            'account_id' => $site->id,
                                            'currency' => $order['order_total']['currency_code'] ?? null,
                                            'total_price' => $order['order_total']['amount'] ?? 0.00,
                                            'customer_id' => null,
                                            'customer_name' => $order['buyer_info']['buyer_name'] ?? null,
                                            'customer_email' => $order['buyer_info']['buyer_email'] ?? null,
                                            'customer_phone' => null,
                                            'customer_country' => null,
                                            'customer_city' => null,
                                            'customer_zip_code' => null,
                                            'customer_state' => $order['buyer_info']['buyer_county'] ?? null,
                                            'customer_note' => null,
                                            'shipping' => $shipping,
                                            'shipping_post_code' => $order['shipping_address']['postal_code'] ?? null,
                                            'shipping_method' => null,
                                            'payment_method' => $order['payment_method'] ?? null,
                                            'transaction_id' => null,
                                            'date_created' => $order['purchase_date'],
                                            'shipping_user_name' => $order['shipping_address']['name'] ?? null,
                                            'shipping_phone' => null,
                                            'shipping_city' => $order['shipping_address']['city'] ?? null,
                                            'shipping_county' => $order['shipping_address']['county'] ?? null,
                                            'shipping_country' => $order['shipping_address']['country_code'] ?? null,
                                            'shipping_address_line_1' => $order['shipping_address']['address_line1'] ?? null,
                                            'shipping_address_line_2' => $order['shipping_address']['address_line2'] ?? null,
                                            'shipping_address_line_3' => $order['shipping_address']['address_line3'] ?? null,
                                        ]);

                                        $orderProduct = $api->getOrderItems($order['amazon_order_id'],null);
                                        if((is_array($orderProduct['payload']['order_items'])) && (count($orderProduct['payload']['order_items']) > 0)){
                                            foreach($orderProduct['payload']['order_items'] as $item){
                                                $variationExist = ProductVariation::where('sku',$item['seller_sku'])->first();
                                                if($variationExist){
                                                    $productOrderInsertResult = ProductOrder::create([
                                                        'order_id' => $orderPrimaryId,
                                                        'variation_id' => $variationExist->id,
                                                        'name' => $item['title'],
                                                        'quantity' => $item['quantity_ordered'],
                                                        'price' => $item['item_price']['amount'],
                                                        'status' => 0,
                                                    ]);
                                                    $check_quantity = new CheckQuantity();
                                                    Log::info('Seller Sku: '.$item['seller_sku']);
                                                    $check_quantity->checkQuantity($item['seller_sku'],null,null,$orderSyncType);
                                                }
                                            }
                                        }else{
                                            Log::info('No order items found');
                                        }

                                    }
                                }
                            }
                        }
                    } catch (Exception $e) {
                        continue;
                    }
                }
                if($orderType == 'manual'){
                    return response()->json(['type' => 'success', 'msg' => 'Amazon Order Sync Successfully']);
                }
                Log::info('Amazon Order Sync Successfully');
            }else{
                if($orderType == 'manual'){
                    return response()->json(['type' => 'error', 'msg' => 'No Site Found']);
                }
                Log::info('No Site Found');
            }
        }catch(\Exception $exception){
            if($orderType == 'manual'){
                return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
            }
            Log::info('Something Went Wrong. Please Check Manually Order Sync');
        }
    }







    public function amazon(Request $request){
        // return \Carbon\Carbon::now()->format("Ymd\THis\Z");
        $url = 'https://api.amazon.com/auth/o2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        // For getting access token and refresh token by authorization code
        // $body = http_build_query([
        //     'grant_type'   => 'authorization_code',
        //     'code'         => $request->spapi_oauth_code,
        //     'redirect_uri' => 'https://woowms.com/admin/amazon-authorization',
        //     'client_id' => 'amzn1.application-oa2-client.eb953824c6714bf8b9e4e8938274f7c0',
        //     'client_secret' => 'ac0e2f00d38c60c1612173cfcff7d8d831a583f326aa4dd23f3effc88802a7ad',
        // ]);
        // $refreshToken = DB::table('amazon_accounts')->first();
        // $body = http_build_query([
        //     'grant_type' => 'refresh_token',
        //     'refresh_token' => $refreshToken->refresh_token,
        //     'client_id' => $refreshToken->lwa_client_id,
        //     'client_secret' => $refreshToken->lwa_client_secret,
        // ]);
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL            => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_CUSTOMREQUEST  => 'POST',
        //     CURLOPT_POSTFIELDS     => $body,
        //     CURLOPT_HTTPHEADER     => $headers
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // $response = json_decode($response, true);

        $config = new Configuration([
            "lwaClientId" => 'amzn1.application-oa2-client.eb953824c6714bf8b9e4e8938274f7c0',
            "lwaClientSecret" => 'ac0e2f00d38c60c1612173cfcff7d8d831a583f326aa4dd23f3effc88802a7ad',
            "lwaRefreshToken" => 'Atzr|IwEBIPTn950v94M6BTx2glKiWml2fJ8n1n4Fm2QEynYFD8i3x11goo01KHa3O0GoU7OEbCELHxOKAAZsrx88m0fs6SMceJkC93RjvXMYB8rPn6IgVJORQsmTFue9xi0kN-oZzISmP6d4ON7uUOam8-lu6EeXRiWpgncsKYjtq_CgNV6zbArIr6ONBEgfNDvMm3xhtUZK8gG5oyKWB0Qm-baNDzjxUQeaEsI2V0NG5AqS9V5zevYVNJzDBvrYDkHo2ep9rOvDRN5nErax1GpoK1x2_hom127MbdEjRFgIr7a6RlVBS4Jd84zhep9gxETwNngA2fc',
            "awsAccessKeyId" => 'AKIAUBRGYVBSZBRHX4LU',
            "awsSecretAccessKey" => '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',
            // If you're not working in the North American marketplace, change
            // this to another endpoint from lib/Endpoint.php
            "endpoint" => Endpoint::EU,
            "roleArn" => 'arn:aws:iam::278180440165:role/mahfuzhur_role3',
        ]);

        $api = new Api\ProductTypeDefinitionsApi($config);
        $marketplace_ids = array('A1F83G8C2ARO7P');
        $created_after = '2021-11-01';

        $asin = 'B07J9VR2XG';
        $included_data = [
            // "attributes",
            "identifiers",
            "images",
            "productTypes",
            "salesRanks",
            "summaries",
            "variations"
            // "vendorDetails"
         ];

        $keywords = array('5056184110412'); // string[] | A comma-delimited list of words or item identifiers to search the Amazon catalog for.
        $locale = 'en_GB'; // string | Locale for retrieving localized summaries. Defaults to the primary locale of the marketplace.
        $skus = array('W-PATTY_100_M');
        $asins = array();
        $body = [
            'restrictedResources' => [
                [
                    'method' => 'GET',
                    'path' => '/orders/v0/orders',
                    'dataElements' => ['buyerInfo', 'shippingAddress']
                ]
            ]
        ];
        try {
            //$result = $api->getOrders($marketplace_ids, $created_after,null,null,null,array('Shipped'));
            //$result = $api->getOrder('206-8894687-3876304');
            //$result = $api->getOrderItems('202-3307224-5698745');
            //$result = $api->getCatalogItem('B01J9XCW3Q', $marketplace_ids, $included_data, $locale);;
            //$result = $api->searchCatalogItems('B01J9XCW3Q', $marketplace_ids, $included_data);
            //$result = $api->createRestrictedDataToken(json_encode($body));
            //$result = $api->getPricing('A1F83G8C2ARO7P', 'Sku', $asins, $skus);
            $result = $api->getDefinitionsProductType('APPAREL','A1F83G8C2ARO7P','A1FJB341J9DM5D');
            //$result = $api->searchDefinitionsProductTypes('A1F83G8C2ARO7P');
            //$result = $api->searchCatalogItems($keywords,$marketplace_ids,$included_data);
            //$result = $api->getMarketplaceParticipations();
            //$result = $api->getCompetitivePricing('A1F83G8C2ARO7P', 'Sku', null, array('BB8-1422'));
            //$result = $api->getItemOffers('A1F83G8C2ARO7P', 'New', 'B07TT5P9X3');
            //$result = $api->getListingOffers('A1F83G8C2ARO7P', 'New', '23088_W31_L32');
            //$result = $api->getPricing('A1F83G8C2ARO7P', 'Asin', array('B07N974FJN'), null);
            return $result;
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

    public function awsSignature(){
        $host		= 'sandbox.sellingpartnerapi-eu.amazon.com';
        $accessKey	= 'AKIAUBRGYVBS4JEWBBMZ';
        $secretKey 	= '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';
        $region 	= 'eu-west-1';
        $service 	= 'execute-api';
        $requestUrl	= 'https://sandbox.sellingpartnerapi-eu.amazon.com/orders/v0/orders?CreatedAfter=20210806T063010Z&MarketplaceIds=A1F83G8C2ARO7P';
        $uri = '/CreatedAfter=20210806T063010Z&MarketplaceIds=A1F83G8C2ARO7P';
        $httpRequestMethod = 'GET';
        $data = json_encode(array());
        $data = json_encode(array(
            "CreatedAfter" => "20210806T063010Z",
            "MarketplaceIds" => "A1F83G8C2ARO7P"
        ));
        $headers = $this->calcualteAwsSignatureAndReturnHeaders($host, $uri, $requestUrl,
			$accessKey, $secretKey, $region, $service,
			$httpRequestMethod, $data, TRUE);

        $result = $this->callToAPI(
        $requestUrl, $httpRequestMethod,
        $headers, $data, TRUE);
             return $result;
    }

    public function calcualteAwsSignatureAndReturnHeaders($host, $uri, $requestUrl,
			$accessKey, $secretKey, $region, $service,
			$httpRequestMethod, $data, $debug = TRUE){

        $terminationString	= 'aws4_request';
        $algorithm 		= 'AWS4-HMAC-SHA256';
        $phpAlgorithm 		= 'sha256';
        $canonicalURI		= $uri;
        $canonicalQueryString	= '';
        $signedHeaders		= 'host;user-agent;x-amz-access-token;x-amz-date';

        $currentDateTime = new DateTime('UTC');
        $reqDate = $currentDateTime->format('Ymd');
        $reqDateTime = $currentDateTime->format('Ymd\THis\Z');

        // Create signing key
        $kSecret = $secretKey;
        $kDate = hash_hmac($phpAlgorithm, $reqDate, 'AWS4' . $kSecret, true);
        $kRegion = hash_hmac($phpAlgorithm, $region, $kDate, true);
        $kService = hash_hmac($phpAlgorithm, $service, $kRegion, true);
        $kSigning = hash_hmac($phpAlgorithm, $terminationString, $kService, true);
        $accessToken = 'Atza|IwEBIO1WWILve0tISCohu9fkwDg0gLWspK-f36CkHKf8DM6fMmNu8HJPZ755el95B1DCm0s89xxGpjpu3OjhDgd0Akh6K8kUoCpO0NXHCTFSVi1FDQ6vpAhWq6Cj9MCQ53lgT3gcjpqGJ7bFT_X2Yd2GJvojkeBfQlLxHBEw-RjfCeYxfVpTdVw9ESZPjugW6QmnvYXljhNZxvvHahu2Aaq5hj1FqRJ0h6HFrapYNBUeToUuLO8oyXB85WciwpKDxvpqEtbmiiwqqeJRRSVxFHD2F3TAdqgqpYnaRPgrKOHXJgyaBg';

        // Create canonical headers
        $canonicalHeaders = array();
        //$canonicalHeaders[] = 'content-type:application/x-www-form-urlencoded';
        $canonicalHeaders[] = 'host:' . $host;
        $canonicalHeaders[] = 'user-agent:wms/2.0 (Language=PHP/7.3.27;Platform=Windows/10)';
        $canonicalHeaders[] = 'x-amz-access-token:' .$accessToken;
        $canonicalHeaders[] = 'x-amz-date:' . $reqDateTime;
        $canonicalHeadersStr = implode("\n", $canonicalHeaders);

        // Create request payload
        $requestHasedPayload = hash($phpAlgorithm, $data);

        // Create canonical request
        $canonicalRequest = array();
        $canonicalRequest[] = $httpRequestMethod;
        $canonicalRequest[] = $canonicalURI;
        $canonicalRequest[] = $canonicalQueryString;
        $canonicalRequest[] = $canonicalHeadersStr . "\n";
        $canonicalRequest[] = $signedHeaders;
        $canonicalRequest[] = $requestHasedPayload;
        $requestCanonicalRequest = implode("\n", $canonicalRequest);
        $requestHasedCanonicalRequest = hash($phpAlgorithm, utf8_encode($requestCanonicalRequest));
        if($debug){
            echo "<h5>Canonical to string</h5>";
            echo "<pre>";
            echo $requestCanonicalRequest;
            echo "</pre>";
        }

        // Create scope
        $credentialScope = array();
        $credentialScope[] = $reqDate;
        $credentialScope[] = $region;
        $credentialScope[] = $service;
        $credentialScope[] = $terminationString;
        $credentialScopeStr = implode('/', $credentialScope);

        // Create string to signing
        $stringToSign = array();
        $stringToSign[] = $algorithm;
        $stringToSign[] = $reqDateTime;
        $stringToSign[] = $credentialScopeStr;
        $stringToSign[] = $requestHasedCanonicalRequest;
        $stringToSignStr = implode("\n", $stringToSign);
        if($debug){
            echo "<h5>String to Sign</h5>";
            echo "<pre>";
            echo $stringToSignStr;
            echo "</pre>";
        }

        // Create signature
        $signature = hash_hmac($phpAlgorithm, $stringToSignStr, $kSigning);
        //return $signature;

        // Create authorization header
        $authorizationHeader = array();
        $authorizationHeader[] = 'Credential=' . $accessKey . '/' . $credentialScopeStr;
        $authorizationHeader[] = 'SignedHeaders=' . $signedHeaders;
        $authorizationHeader[] = 'Signature=' . ($signature);
        $authorizationHeaderStr = $algorithm . ' ' . implode(', ', $authorizationHeader);


        // Request headers
        $headers = array();
        $headers[] = 'authorization:'.$authorizationHeaderStr;
        $headers[] = 'x-amz-access-token: Atza|IwEBIO1WWILve0tISCohu9fkwDg0gLWspK-f36CkHKf8DM6fMmNu8HJPZ755el95B1DCm0s89xxGpjpu3OjhDgd0Akh6K8kUoCpO0NXHCTFSVi1FDQ6vpAhWq6Cj9MCQ53lgT3gcjpqGJ7bFT_X2Yd2GJvojkeBfQlLxHBEw-RjfCeYxfVpTdVw9ESZPjugW6QmnvYXljhNZxvvHahu2Aaq5hj1FqRJ0h6HFrapYNBUeToUuLO8oyXB85WciwpKDxvpqEtbmiiwqqeJRRSVxFHD2F3TAdqgqpYnaRPgrKOHXJgyaBg';
        $headers[] = 'user-agent: wms/2.0 (Language=PHP/7.3.27;Platform=Windows/10)';
        // $headers[] = 'content-length:'.strlen($data);
        // $headers[] = 'content-type: application/x-www-form-urlencoded';
        $headers[] = 'host: ' . $host;
        $headers[] = 'x-amz-date: ' . $reqDateTime;

        return $headers;
    }

    function callToAPI($requestUrl, $httpRequestMethod, $headers, $data, $debug=TRUE)
    {
        // Execute the call
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $requestUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_POST => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $httpRequestMethod,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_VERBOSE => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => false,
        CURLINFO_HEADER_OUT=>true,
        CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if($debug){
            $headers = curl_getinfo($curl, CURLINFO_HEADER_OUT);
            echo "<h5>Request</h5>";
            echo "<pre>";
            echo $headers;
            echo "</pre>";
        }

        curl_close($curl);

        if ($err) {
            if($debug){
                echo "<h5>Error:" . $responseCode . "</h5>";
                echo "<pre>";
                echo $err;
                echo "</pre>";
            }
        } else {
            if($debug){
                echo "<h5>Response:" . $responseCode . "</h5>";
                echo "<pre>";
                echo $response;
                echo "</pre>";
            }
        }

        return response()->json([
            "responseCode" => $responseCode,
            "response" => $response,
            "error" => $err
        ]);
    }

    public function amzTestOrder(){
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
    }

    public function amazonAuthorization(){
        $view = view('amazon.authorization');
        return view('master',compact('view'));
    }

    public function amazonAccessToken(){
        $url = 'https://api.amazon.com/auth/o2/token';
        $method = 'POST';
        $headers = [
            'Content-Type:application/x-www-form-urlencoded',
        ];
        $body = http_build_query([
            'grant_type' => 'authorization_code',
            'code' => 'RHIFmENhQiRvFBJEXUqX',
            'redirect_uri' => 'https://woowms.com/admin/amazon-credentials',
            'client_id' => 'amzn1.application-oa2-client.8b43bd94decc467da264f294dcafba57',
            'client_secret' => 'e507c035715bb8c957c11643e12035a30a321ce182dafe9d17eef66e8a8f858c'
        ]);
        $res = $this->curl($url,$headers,$body,$method);
        echo '<pre>';
        print_r($res);
        exit();
    }




    public function amazonGetData(){
        $url = 'https://sandbox.sellingpartnerapi-eu.amazon.com/orders/v0/orders';
        $method = 'GET';
        $headers = [
            'Authorization: AWS4-HMAC-SHA256 Credential=AKIAUBRGYVBS4JEWBBMZ/20210807/eu-west-1/execute-api/aws4_request, SignedHeaders=host;x-amz-access-token;x-amz-date, Signature=616fb5b1bbf4a7180798a9ccfbfd7c7f9c80152be8b4f3c6146e1b922caa57d7',
            'X-Amz-Date:20210807T125546Z',
            'x-amz-access-token: Atza|IwEBIO1WWILve0tISCohu9fkwDg0gLWspK-f36CkHKf8DM6fMmNu8HJPZ755el95B1DCm0s89xxGpjpu3OjhDgd0Akh6K8kUoCpO0NXHCTFSVi1FDQ6vpAhWq6Cj9MCQ53lgT3gcjpqGJ7bFT_X2Yd2GJvojkeBfQlLxHBEw-RjfCeYxfVpTdVw9ESZPjugW6QmnvYXljhNZxvvHahu2Aaq5hj1FqRJ0h6HFrapYNBUeToUuLO8oyXB85WciwpKDxvpqEtbmiiwqqeJRRSVxFHD2F3TAdqgqpYnaRPgrKOHXJgyaBg',
            'host:sandbox.sellingpartnerapi-eu.amazon.com',
            'user-agent:wms/2.0 (Language=PHP/7.3.27;Platform=Windows/10)'
        ];
        $marketPlace[] = 'A1F83G8C2ARO7P';
        $body = http_build_query([
            'CreatedAfter' => '20210803T055310Z',
            'MarketplaceIds' => $marketPlace,
        ]);
        $res = $this->curl($url,$headers,$body,$method);
        echo '<pre>';
        print_r($res);
        exit();
    }

    public function curl($url,$header,$body,$method){

        // $headers = [
        //     'Content-Type: application/x-www-form-urlencoded',
        //     'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        // ];

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

    public function amazonCredentials(Request $request){
        dd($request->all());
    }



}
