<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeTerm;
use App\Brand;
use App\Category;
use App\Client;
use App\Condition;
use App\DeveloperAccount;
use App\EbayMasterProduct;
use App\EbayProfile;
use App\EbayTemplate;
use App\EbayVariationProduct;
use App\Gender;
use App\GenderWmsCategory;
use App\Http\Controllers\Channel\Onbuy;
use App\OnbuyAccount;

use App\OnbuyMasterProduct;
use App\OnbuyVariationProducts;
use App\ProductDraft;
use App\AttributeTermProductDraft;
use App\Setting;
use App\ShelfedProduct;
use App\EbayAccount;

use App\Traits\Ebay;
use App\User;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use App\WoocommerceAccount;
use App\WoocommerceImage;
use App\WooWmsCategory;
use Facade\FlareClient\Stacktrace\File;

use App\ProductVariation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\Image;
use Auth;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\ShelfQuantityChangeReason;
use Arr;
use App\Traits\SearchCatalogue;
use App\Traits\ImageUpload;
use App\Traits\ListingLimit;
use App\amazon\AmazonMasterCatalogue;
use App\amazon\AmazonAccountApplication;
use App\Traits\CommonFunction;
use App\woocommerce\WoocommerceAttribute;
use App\woocommerce\WoocommerceAttributeTerm;
use App\ItemAttribute;
use App\ItemAttributeTerm;
use App\CategoryItemAttribute;
use App\ItemAttributeTermValue;
use App\CatalogueAttributeTerms;
use App\Channel;
use App\Mapping;
use App\shopify\ShopifyAccount;
use App\shopify\ShopifyMasterProduct;
use App\shopify\ShopifyVariation;
use App\ItemAttributeProfile;


class ProductDraftController extends Controller
{
    use SearchCatalogue;
    use ImageUpload;
    use ListingLimit;
    use CommonFunction;
    use Ebay;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('channelAccount');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
    }

    public function access_token(){
        $onbuy_consumer_key = Session::get('onbuy_consumer_key');
        $onbuy_secret_key = Session::get('onbuy_secret_key');
        if($onbuy_consumer_key == '' && $onbuy_secret_key == ''){
            $info = OnbuyAccount::where('status',1)->first();
            if($info) {
                Session::put('onbuy_consumer_key', $info->consumer_key);
                Session::put('onbuy_secret_key', $info->secret_key);
                $onbuy_consumer_key = $info->consumer_key;
                $onbuy_secret_key = $info->secret_key;
            }else{
//                return redirect('/onbuy/master-product-list');
                return 'notoken';
            }
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/auth/request-token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('secret_key' => $onbuy_secret_key,'consumer_key' => $onbuy_consumer_key),
            CURLOPT_HTTPHEADER => array(

            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $token = json_decode($response);
        return $token->access_token;
    }

    public function curl_request_send($url, $method, $post_data = null, $http_header = []){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => $http_header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    // public function productVariationCsv (Request $request){
// //        $array = explode(',', $request->catalogue_id);
// //        $result = ProductDraft::with(['ProductVariations','images'])->whereIn('id',$array)->get();
//         $result = EbayMasterProduct::with('variationProducts')->where('account_id',2)->get()->all();


// ////       return \response()->json($result[0]['ProductVariations'][0]->id);
//         // return \response()->json($result);
// //        exit();
// //        $string = str_replace(' ', '', Carbon::now());
//         $dt = Carbon::now();
// //        echo $dt->toDateString();
//         $filename = $dt->toDateString().".csv";
//         $handle = fopen($filename, 'w+');
//         fputcsv($handle, array('Item ID','SKU','Quantity',));

//         foreach($result as $row) {
// //            print_r( );
// //            exit();
//             foreach ($row['variationProducts'] as $row2) {
//                 fputcsv($handle, array($row['item_id'], $row2['sku'], $row2['quantity'],
//                     ));
//             }
//         }

//         fclose($handle);

//         $headers = array(
//             'Content-Type' => 'text/csv',
//         );

//         return Response::download($filename, $filename, $headers);
//     }
    public function productVariationCsv (Request $request){
        $array = explode(',', $request->catalogue_id);
        $result = ProductDraft::with(['ProductVariations' => function($query){
            $query->with(['order_products' => function($query){
                $this->orderWithoutCancelAndReturn($query);
            },'shelf_quantity' => function($query2){
                $query2->wherePivot('quantity','>',0);
            },'invoiceProductVariations' => function($query3){
                $query3->select('product_variation_id',DB::raw('sum(quantity) as total_receive'))->whereHas('product_invoice_info',function($query4){
                    $query4->where('return_order_id',null);
                })->groupBy('product_variation_id');
            }]);
        },'images'])->whereIn('id',$array)->get();


////       return \response()->json($result[0]['ProductVariations'][0]->id);
        // return \response()->json($result);
//        exit();
//        $string = str_replace(' ', '', Carbon::now());
        $dt = Carbon::now();
//        echo $dt->toDateString();
        $filename = $dt->toDateString().".csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('CATALOGUE ID','NAME','IMAGE','VARIATION ID','SKU','VARIATION',
            'AVAILABLE QUANTITY', 'SHELF QUANTITY','SOLD','EAN NO', 'REGULAR PRICE', 'SALE PRICE', 'COST PRICE', 'TOTAL RECEIVE','COLOUR CODE','PRODUCT CODE'));

        foreach($result as $row) {
//            print_r( );
//            exit();
            foreach ($row['ProductVariations'] as $row2) {
                $variation = '';
                if(is_array(unserialize($row2['attribute']))){
                    foreach(unserialize($row2['attribute']) as $attr){
                        $variation .= $attr['attribute_name'].'->'.$attr['terms_name'].',';
                    }
                }
                $total_sold = 0;
                if(count($row2['order_products']) > 0){
                    foreach($row2['order_products'] as $sold){
                        $total_sold += $sold['sold'];
                    }
                }
                $shelfQuantity = 0;
                if(count($row2['shelf_quantity']) > 0){
                    foreach($row2['shelf_quantity'] as $shelf){
                        $shelfQuantity += $shelf['pivot']['quantity'];
                    }
                }
                fputcsv($handle, array($row['id'], $row['name'],$row2['image'] ?? $row['images'][0]['image_url'] ??  'NULL',$row2['id'], $row2['sku'],
                     rtrim($variation,','), $row2['actual_quantity'],$shelfQuantity,$total_sold, $row2['ean_no'], $row2['regular_price'],
                    $row2['sale_price'], $row2['cost_price'],$row2['invoiceProductVariations'][0]['total_receive'] ?? 0,$row2['color_code'],$row2['product_code'],));
            }
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers);
    }

    public function itemProfileList() {
        return ItemAttributeProfile::with(['profileTerm'])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : index
     * Route : completed-catalogue-list
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol, Solaiman
     * Description : This function is used for displaying active master catalogue
     * Created Date: unknown
     * Modified Date : 24-11-2020, 1-12-2020, 28-12-2020
     * Modified Content : Setting information change, Pagination setting
     */

    public function index(Request $request)
    {

    	 try {
            // dd($request);
            // exit();
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
             //Start page title and pagination setting
             $shelf_use = $this->shelf_use;
             $settingData = $this->paginationSetting('catalogue', 'active_catalogue');
             $setting = $settingData['setting'];
             $page_title = '';
             $see_more = 0;
             $pagination = $settingData['pagination'];
             //End page title and pagination setting
            $woocommerceSiteUrl = WoocommerceAccount::first();
            $wooChannel = WoocommerceAccount::get()->all();
            $onbuyChannel = OnbuyAccount::get()->all();
            $ebayChannel = EbayAccount::get()->all();

            $channels = array();
            $temp = array();
            foreach ($wooChannel as $woo){
                $channels["woocommerce"] = "woocommerce";
            }

            foreach ($onbuyChannel as $onbuy){
                $channels["onbuy"] = "onbuy";
            }
            foreach ($ebayChannel as $ebay){
                $temp[$ebay->id] = $ebay->account_name;
            }
            $channels["ebay"] = $temp;

            $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id,name','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id,product_name,master_category_id,product_id',
                'ebayCatalogueInfo' => function($query){
                $query->select(['id','account_id','master_product_id','item_id','product_status'])->with(['AccountInfo:id,account_name,logo']);
            },'amazonCatalogueInfo' => function($amazonCatalogue){
                $amazonCatalogue->select('id','master_product_id','application_id')->with(['applicationInfo' => function($applicationInfo){
                    $applicationInfo->select('id','amazon_account_id','application_name','application_logo','amazon_marketplace_fk_id')->with(['accountInfo:id,account_name,account_logo','marketPlace:id,marketplace']);
                }]);
            },'shopifyCatalogueInfo' => function($shopifyCatalogue){
                $shopifyCatalogue->select(['id','master_catalogue_id','account_id'])->with(['shopifyUserInfo:id,account_name,account_logo,shop_url']);
            },'variations' => function($query){
                $query->select(['id','product_draft_id','actual_quantity'])->with(['order_products' => function($query){
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status','publish');
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->masterCatalogueSearchCondition($product_drafts, $request);
                $allCondition = $this->masterCatalogueSearchParams($request, $allCondition);
            }
            $product_drafts = $product_drafts->orderBy('id','DESC')->paginate($pagination);
            // echo '<pre>';
            // print_r($product_drafts);
            // exit();

            if($request->has('is_clear_filter')){
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
                $woocommerceSiteUrl = WoocommerceAccount::first();
                $search_result = $product_drafts;
                $view = view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render();
                return response()->json(['html' => $view]);
            }

            $users = User::orderBy('name', 'ASC')->get();
            $product_drafts_info = json_decode(json_encode($product_drafts));

            $total_product_drafts = ProductDraft::where('status','publish')->count();
            $content = view('product_draft.complete_catalogue_list',compact('product_drafts','total_product_drafts','product_drafts_info','setting','pagination','users','see_more','shelf_use','woocommerceSiteUrl','channels','allCondition','url'));
            return view('master',compact('content','page_title'));
         }catch (\Exception $exception){
             return redirect('exception')->with('exception',$exception->getMessage());
         }
    }

    public function trash(Request $request){
        try {
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
             //Start page title and pagination setting
             $shelf_use = $this->shelf_use;
             $settingData = $this->paginationSetting('catalogue', 'active_catalogue');
             $setting = $settingData['setting'];
             $page_title = '';
             $see_more = 0;
             $pagination = $settingData['pagination'];
             //End page title and pagination setting
            $woocommerceSiteUrl = WoocommerceAccount::first();
            $wooChannel = WoocommerceAccount::get()->all();
            $onbuyChannel = OnbuyAccount::get()->all();
            $ebayChannel = EbayAccount::get()->all();

            $channels = array();
            $temp = array();
            foreach ($wooChannel as $woo){
                $channels["woocommerce"] = "woocommerce";
            }

            foreach ($onbuyChannel as $onbuy){
                $channels["onbuy"] = "onbuy";
            }
            foreach ($ebayChannel as $ebay){
                $temp[$ebay->id] = $ebay->account_name;
            }
            $channels["ebay"] = $temp;

            $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id,name','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id,product_name,master_category_id,product_id',
                'ebayCatalogueInfo' => function($query){
                $query->select(['id','account_id','master_product_id','item_id'])->with(['AccountInfo:id,account_name,logo']);
            }, 'variations' => function($query){
                $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                    $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->onlyTrashed()
                ->where('status','publish');
            // echo "<pre>";
            // print_r($product_drafts);
            // exit();
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->masterCatalogueSearchCondition($product_drafts, $request);
                $allCondition = $this->masterCatalogueSearchParams($request, $allCondition);
            }
            $product_drafts = $product_drafts->orderBy('id','DESC')->paginate($pagination);

            if($request->has('is_clear_filter')){
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
                $woocommerceSiteUrl = WoocommerceAccount::first();
                $search_result = $product_drafts;
                $view = view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render();
                return response()->json(['html' => $view]);
            }

            $users = User::orderBy('name', 'ASC')->get();
            $product_drafts_info = json_decode(json_encode($product_drafts));
            $total_product_drafts = ProductDraft::where('status','publish')->count();
            $content = view('product_draft.complete_catalogue_list',compact('product_drafts','total_product_drafts','product_drafts_info','setting','pagination','users','see_more','shelf_use','woocommerceSiteUrl','channels','allCondition','url'));
            return view('master',compact('content','page_title'));
         }catch (\Exception $exception){
             return redirect('exception')->with('exception',$exception->getMessage());
         }
    }

    public function allSearchConditionArr($value, $allCondition = null){
        if($value == 'condition'){
            $allCondition = $allCondition;
        }else{
            return $allCondition;
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    * Function : create
    * Route : product-draft/create
    * Method Type : GET
    * Parametes : null
    * Creator : Kazol
    * Modifier : Kazol,Solaiman
    * Description : This function is used for adding master catalogue with all information
    * Created Date: unknown
    * Modified Date : 25-11-2020, 24-11-2021
    * Modified Content : isset and error handle
    */

    public function create()
    {
        try {
            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
            // dd($listingLimitInfo,$clientListingLimit);
            // dd($listingLimitAllChannelActiveProduct);
            $itemInfos = ItemAttribute::with(['itemAttributeTerms' => function($query){
                $query->where('is_active',1);
            }])->where('is_active',1)->get();
            $categories = WooWmsCategory::get();
            $conditions = Condition::all();
            $brands = Brand::get();
            $genders = Gender::get();
            $attribute_terms = '';
            $attribute_terms = Attribute::With(['attributesTerms' => function($query){
                $query->orderBy('terms_name','asc');
            }])->where('use_variation',1)->get();
            $attribute_terms = json_decode(json_encode($attribute_terms));
            $content = view('product_draft.create_product_draft',compact('categories','attribute_terms','brands','genders','conditions','listingLimitAllChannelActiveProduct','clientListingLimit','itemInfos','listingLimitInfo'));
            return view('master',compact('content'));
        } catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
    * Function : store
    * Route : product-draft/store
    * Method Type : POST
    * Parametes : null
    * Creator : Kazol
    * Modifier : Kazol,Solaiman
    * Description : This function is used for saving master catalogue
    * Created Date: unknown
    * Modified Date : 25-11-2020, 24-11-2021
    * Modified Content : isset and error handle
    */
    public function store(Request $request)
    {
        // dd($request->all());

        $exitsTitle = ProductDraft::where('name',$request->name)->first();
        if($exitsTitle){
            return back()->with('error','Catalogue Already Exists. Please Try Another Name');
        }


        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

        // $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
        // $clientListingLimit = $this->ClientListingLimit();

        //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

        if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
            return redirect('/product-draft/create');
        }else{

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'condition' => 'required',
                'brand_id' => 'required',
                'gender_id' => 'required',
                'category_id' => 'required',
            ],
                [
                    'name.required' => 'Please give a title',
                    'condition.required' => 'Please select a condition',
                    'brand_id.required' => 'Please select a brand name',
                    'gender_id.required' => 'Please select a department',
                    'category_id.required' => 'Please select a category',
                ]);
    //        try {
                $this->category = $request->category_id;
                $attribute_array= array();
                $attributes_value_array = array();
                $attributes_options_array = array();
                $attributes_terms = $request->terms;
                $att_name_test = $request->att_name_test ?? '';
                    if ($request->type =='variable'){
                        $attributes_terms_main = [];
                        foreach($att_name_test as $att_title){
                            // echo $att_title;
                            foreach($attributes_terms as $key=>$att_val){
                                if($att_title == $key){
                                    $attributes_terms_main[$key] = $att_val;

                                }
                            }

                        }
                        $attributes_terms = $attributes_terms_main;
                    }


                if ($attributes_terms == null && $request->type =='variable'){
                    return back()->with('error','Please select at least one attribute terms');
                }else {
                    if ($request->type == 'variable') {
                        foreach ($attributes_terms as $attribute_id => $attribute_terms_id) {
                            if (count($attribute_terms_id) > 0) {
                                foreach ($attribute_terms_id as $attribute_term_id) {
                                    $attribute_array[$attribute_id][Attribute::find($attribute_id)->attribute_name][] =
                                        ["attribute_term_id" => $attribute_term_id ?? null,
                                            "attribute_term_name" => AttributeTerm::find($attribute_term_id)->terms_name ?? null,
                                        ];
                                }
                            }
                        }
                    }
                }
                    // $randomInteger = mt_rand(100000, 999999);
                    // $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                    //         . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
                    // shuffle($seed);
                    // $randomString = '';
                    // foreach (array_rand($seed, 4) as $k) $randomString .= $seed[$k];
                    // $sku = $randomInteger.$randomString;

                    $attribute_array = \Opis\Closure\serialize($attribute_array);


                    $product_draft_create_result = ProductDraft::create([
                        'user_id' => Auth::user()->id,
                        'woowms_category' => $request->category_id ?? null,
                        'condition' => $request->condition ?? null,
                        'name' => $request->name,
                        'type' => $request->type,
                        'description' => $request->description,
                        'short_description' => $request->short_description ?? null,
                        'regular_price' => $request->regular_price ?? null,
                        'sale_price' => $request->sale_price ?? null,
                        'rrp' => $request->rrp ?? $request->regular_price ?? null,
                        'cost_price' => $request->cost_price ?? null,
                        'base_price' => $request->base_price ?? null,
                        'vat' => $request->vat ?? null,
                        'product_code' => $request->product_code ?? null,
                        'attribute' => $attribute_array ?? null,
                        'color' => $request->color ?? null,
                        'color_code' => $request->color_code ?? null,
                        'sku_short_code' => $request->sku_short_code ?? null,
                        'low_quantity' => $request->low_quantity ?? null,
                        'status'=> 'draft',
                        'brand_id' => $request->brand_id ?? null,
                        'gender_id' => $request->gender_id ?? null,
                    ]);
                    $product_variation = null;
    //                return $product_draft_create_result;
                    if (isset($product_draft_create_result->id)){
                        $termInsertInfo = [];
                        if($request->item_attribute != null){
                            foreach($request->item_attribute as $key => $item_attr){
                                if($item_attr != null){
                                    $termInsertInfo = ItemAttributeTermValue::create([
                                        'item_attribute_term_id' => $key,
                                        'item_attribute_term_value' => $item_attr
                                    ]);
                                    if($termInsertInfo){
                                        $catalogueTermInsertInfo = CatalogueAttributeTerms::create([
                                            'catalogue_id' => $product_draft_create_result->id,
                                            'attribute_id' => $key,
                                            'attribute_term_id' => $termInsertInfo->id
                                        ]);
                                    }
                                }
                            }
                        }
                        $data = ProductVariation:: where([['product_draft_id', $request->product_draft_id],['sku', $request->sku]])->where('deleted_at','=',NULL)->first();
                        if(isset($data)){
                            return back()->with('error', 'This product already exist under this catalogue.');
                        }elseif($request->type =='simple'){
                            $product_variation = ProductVariation::create(['product_draft_id'=> $product_draft_create_result->id,'sku' => $request->sku, 'actual_quantity' => 0,'sale_price' => $request->sale_price ?? null,'rrp' => $request->rrp ?? $request->regular_price ?? null,'regular_price' => $request->rrp ?? $request->regular_price ?? null,'ean_no' => $request->ean_no ?? '','notification_status' => (isset($request->notificationCheckbox)) ? true : false,'low_quantity' => $request->low_quantity ?? 0]);
                        }

                    }

                    if($request->sku_short_code == null){
                        $skuShortCodeUpdate = ProductDraft::find($product_draft_create_result->id)->update(['sku_short_code' => $product_draft_create_result->id]);
                    }
                    if($request->newUploadImage != null){
                        $folderPath = 'uploads/product-images/';
                        foreach($request->newUploadImage as $imageName => $imageContent){
                            $updatedImageName = $this->base64ToImage($product_draft_create_result->id, $imageName, $imageContent, $folderPath);

                            // $info = pathinfo($updatedImageName);
                            // $image_name =  basename($updatedImageName,'.'.$info['extension']);
                            // $ext = explode(".", $updatedImageName);
                            // $image_type = end($ext);
                            // if($image_type == "webp"){
                            //     $ext = str_replace("webp","jpg",$image_type);
                            //     $name_str = $image_name . '.' . $ext;
                            //     $insertableImage[] = [
                            //         'draft_product_id' => $product_draft_create_result->id,
                            //         'image_url' => asset('uploads/product-images/' . $name_str)
                            //     ];
                            //     // $imageInsertInfo = Image::insert($insertableImage);
                            // }
                            // echo '<pre>';
                            // print_r($name_str);

                            $insertableImage[] = [
                                'draft_product_id' => $product_draft_create_result->id,
                                'image_url' => 'uploads/product-images/' . $updatedImageName
                            ];
                            // echo '<pre>';
                            // print_r($insertableImage);
                            //$imageName = Str::random(10).'.'.$extension;
                            //Storage::disk('public')->put($imageName, base64_decode($image));
                        }
                        $imageInsertInfo = Image::insert($insertableImage);
                    }
                    // Old Image Upload Code Start
                    // if($request->sortable_image != null){
                    //     $insertableImage = [];
                    //     $sortAbleImageArray = explode(',',$request->sortable_image);
                    //     foreach ($sortAbleImageArray as $file) {
                    //         foreach ($request->images as $image) {
                    //             if ($file == $image->getClientOriginalName()) {
                    //                 $name = $product_draft_create_result->id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                    //                 $name .= str_replace(' ', '-',$image->getClientOriginalName());
                    //                 $image->move('uploads/product-images/', $name);
                    //                 $insertableImage[] = [
                    //                     'draft_product_id' => $product_draft_create_result->id,
                    //                     'image_url' => asset('uploads/product-images/' . $name)
                    //                 ];
                    //             }
                    //         }
                    //     }
                    //     $imageInsertInfo = Image::insert($insertableImage);
                    // }
                    //Old Image Upload Code End

            if ($request->type =='variable'){
                return redirect('catalogue/'.$product_draft_create_result->id.'/product')
                    ->with('add_product_success','Catalogue added successfully. You can now add product from here');
            }
        }


        return redirect('catalogue-product-invoice-receive/'.$product_draft_create_result->id.'/'.$product_variation->id);
//        }catch (\Exception $exception){
//            return redirect('exception')->with('exception',$exception->getMessage());
//        }
    }

    public function publish($id){



        try{
            $data = [
                'status' => 'publish'
            ];

            try{
                $result = Woocommerce::put('products/'.$id, $data);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }


            if ($result != null){
                ProductDraft::find($id)->update(['status'=> 'publish']);
                return back()->with('success','Product Published');
            }


        }catch (Exception $exception){
            return back()->with('error',$exception);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
     * Function : show
     * Route : product-draft.show
     * parameters: $id (Catalogue ID)
     * Request : get
     * Creator : Kazol, Mahfuz, Solaiman
     * Modifier : Kazol, Solaiman
     * Description : This function is used for showing the single master catalogue and screen option table column hide show toggle
     * Created Date: unknown
     * Modified Date : 17-11-2020, 20-12-2020, 28-12-202
     */
    public function show($id)
    {
        try {
//            $result = ProductDraft::with('ProductVariations')->where('id',$id)->first();
//            echo "<pre>";
//            print_r(\Opis\Closure\unserialize($result->productVariations[0]->variation_images));
//            exit();
            //Add Terms to Catalogue attribute modal view
            $attribute_info = ProductDraft::with(['woocommerce_catalogue_info','onbuy_product_info','ebayCatalogueInfo'])->where('id',$id)->first();
            if($attribute_info) {
                $attribute_terms = Attribute::With(['attributesTerms'])->get();
                $attribute_terms = json_decode(json_encode($attribute_terms));
                $productVariationExist = (($attribute_info->woocommerce_catalogue_info != null) || ($attribute_info->onbuy_product_info != null) || ($attribute_info->ebayCatalogueInfo->count() > 0 )) ? true : false;
                $attribute_info_unserialize = \Opis\Closure\unserialize($attribute_info->attribute);
                //$productVariationExist = ProductVariation::where('product_draft_id',$id)->first();
                // if($attribute_info->attribute != null) {
                //     $product_attribute = \Opis\Closure\unserialize($attribute_info->attribute);
                // }else{
                //     $product_attribute = null;
                // }
                $existAttr = [];
                if($attribute_info_unserialize && is_array($attribute_info_unserialize)){
                    foreach($attribute_info_unserialize as $attr_id => $attr_value){
                        foreach($attr_value as $attr_name => $value){
                            $existAttr[$attr_id] = $attr_name;
                        }
                    }
                }

                // echo'<pre>';
                // print_r($attribute_info);
                // exit();

                // dd($existAttr);

            }else{
                return back()->with('error','No Catalogue Found');
            }

            //End Add Terms to Catalogue attribute modal view



            //Start page title and pagination setting
            $shelf_use = $this->shelf_use;
            $settingData = $this->paginationSetting('catalogue', 'catalogue_details');
//                    echo('<pre>');
//                    print_r($settingData);
//                    exit();
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting
            $shelfQuantityChangeReason = ShelfQuantityChangeReason::all();

            $attribute_info = ProductDraft::with(['product_draft_attribute'])->where('id', $id)->get();
            $product_image = ProductDraft::find($id)->images;
            $distinct_attribute = null;
            if ($attribute_info[0]->type == 'variable'){
                $distinct_attribute = AttributeTermProductDraft::select('attribute_id')->with(['attribute' => function ($query) use ($id) {
                    $query->with(['terms_ids' => function ($query) use ($id) {
                        $query->with('terms_info')->where('product_draft_id', $id);
                    }]);
                }])->where('product_draft_id', $id)->groupBy('attribute_id')->get();
            }
            $product_draft_result = ProductDraft::with(['ProductVariations' => function($query) {
                $query->with(['shelf_quantity', 'order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                },'get_reshelved_product' => function($reshelve){
                    $reshelve->where('status',0)->select('variation_id',DB::raw('sum(reshelved_product.quantity) pending_reshelve'))->groupBy('variation_id');
                }]);
            },'WooWmsCategory:id,category_name'])->find($id);
            $product_draft_variation_results = json_decode(json_encode($product_draft_result));
//            echo "<pre>";
//            print_r($product_draft_variation_results);
//            exit();
            $distinctTerms = [];
            $distinctVariationInfo = [];
            $variaition_terms = [];
            if ($product_draft_variation_results->type == 'variable'){
                foreach($product_draft_variation_results->product_variations as $variationInfo){
                    foreach(unserialize($variationInfo->attribute) as $attribute){
                        if(!in_array($attribute['terms_name'],$distinctTerms)){

                            $variation = [
                                'attribute_name' => $attribute['attribute_name'],
                                'terms_name' => $attribute['terms_name'],

                            ];
                            $distinctVariationInfo[] = $variation;
                            $distinctTerms[] = $attribute['terms_name'];
                        }
                    }
                }
                asort($distinctVariationInfo);
                foreach($distinctVariationInfo as $terms){
                    $variation_ids = '';
                    foreach($product_draft_variation_results->product_variations as $varInfo){
                        foreach (\Opis\Closure\unserialize($varInfo->attribute) as $att){
                            if($att['terms_name'] == $terms['terms_name']) {
                                $variation_ids .= $varInfo->id.'/';
                            }
                        }
                    }
                    $variaition_terms[] = [
                        'terms_name' => $terms['terms_name'],
                        'attribute_name' => $terms['attribute_name'],
                        'variation_id' => rtrim($variation_ids,'/') ?? null,
                    ];
                }
            }


            // echo '<pre>';
            // print_r($variaition_terms);
            // exit();
            // echo '<pre>';
            // print_r(json_decode($attribute_info));
            // exit();
            $content = view('product_draft.product_draft_details',compact('product_draft_variation_results','product_image','attribute_info','distinct_attribute','id', 'setting', 'page_title', 'pagination','shelf_use','variaition_terms','shelfQuantityChangeReason','attribute_terms', 'attribute_info_unserialize', 'id','productVariationExist','existAttr'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : edit
     * Route : product-draft.edit
     * parameters: $id (This is the master catalogue id)
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for editing master catalogue with all master catalogue information in the edit view page
     * Created Date: unknown
     * Modified Date : 15-11-2020, 16-1-2020
     */

    public function edit($id)
    {
        try {
            $account['ebay_status'] = DeveloperAccount::first();
            $account['woocommerce_status'] = WoocommerceAccount::first();
            $account['onbuy_status'] = OnbuyAccount::first();
//            echo '<pre>';
//            print_r(json_decode(json_encode($account)));
//            exit();
            $categories = WooWmsCategory::get();
            $conditions = Condition::all();
            $brands = Brand::get();
            $genders = Gender::get();
            $product_variation = ProductVariation::where('product_draft_id',$id)->get()->first();

            $channels = Channel::get();

            $product_draft = ProductDraft::with(['all_category','images' => function($query){
                $query->orderBy('id');
            },'woocommerce_catalogue_info:id,master_catalogue_id,name',
            'onbuy_product_info:id,opc,woo_catalogue_id,product_name,master_category_id,product_id',
            'ebayCatalogueInfo:id,account_id,master_product_id,site_id',
            'amazonCatalogueInfo:id,master_product_id',
            'shopifyCatalogueInfo:id,account_id,master_catalogue_id'])->find($id);
            // echo '<pre>';
            // print_r(json_decode($product_draft));
            // exit();
            $image_src = [];
            $image_as_string = '';
            if($product_draft) {
                if(count($product_draft->images) > 0) {
                    foreach ($product_draft->images as $image) {
                        $image_src[] = $image->image_url;
                    }
                    $image_as_string = implode(",",$image_src);
                }
            }
            $ebay_product_info = EbayMasterProduct::where('master_product_id', $id)->get();
            $active_status = [];
            foreach ($ebay_product_info as $ebay_master_catalog) {
                if($ebay_master_catalog->product_status == "Active"){
                    $active_status[] = $ebay_master_catalog->id;
                }
            }
            $tabAttributeInfo = $this->getCatalogueTabAttribute($product_draft->woowms_category, $id);
            $content = view('product_draft.edit_product_draft',compact('product_draft','product_variation','categories','image_as_string','brands','genders','conditions','account','tabAttributeInfo','channels','active_status'));
            return view('master', compact('content'));
        }catch (\Exception $exception){
            return back()->with('wms_error','Something went wrong');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
     * Function : update
     * Route : product-draft.update
     * parameters: $productDraft (As model)
     * Request : post
     * Creator : Kazol, Mahfuzhur, Solaiman
     * Modifier : Kazol, Mahfuzhur, Solaiman
     * Description : This function is used for updating master catalogue with every channel with all master catalogue information from the edit view page
     * Created Date: unknown
     * Modified Date : 16-11-2020
     */
    public function update(Request $request, ProductDraft $productDraft)
    {
        // dd($request);
    //    echo "<pre>";
    //    print_r($request->all());
    //    exit();
        $request->validate([
            'name' => 'required|max:255|unique:product_drafts,name,'.$productDraft->id,
            'description' => 'required',
        ]);
        $data = $request;
        $pictures = '';
        $image_array = array();
        $this->ebay_result = '';
        $this->onbuy_result = '';
        $this->woocom_result = '';
        $this->wms = '';
        $woocommcerce_status = '';
        $onbuy_status = '';
        $ebay_status = '';
        $ebay_flag = '';
        $onbuy_flag = '';
        $woocom_flag = '';
        $wms_flag = '';
        $dataimage = [];
        try {
            if($request->image_update_check == 1) {
                $folderPath = 'uploads/product-images/';
                if($request->newUploadImage != null){
                    foreach($request->newUploadImage as $imageName => $imageContent){
                        if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                            $updatedImageName = $this->base64ToImage($productDraft->id, $imageName, $imageContent, $folderPath);
                            $image_array[] = asset($folderPath.$updatedImageName);
                            $dataimage[] = [
                                'draft_product_id' => $productDraft->id,
                                'image_url' => $folderPath.$updatedImageName
                            ];
                        }else{
                            $image_array[] = $imageContent;
                            $dataimage[] = [
                                'draft_product_id' => $productDraft->id,
                                'image_url' => $imageName
                            ];
                        }
                    }
                }

//                 if ($request->sortable_image && $request->images != null) {
//                     $files = explode(',', $request->sortable_image);
//                     foreach ($files as $file) {
//                         $temp = null;
//                         foreach ($request->images as $image) {
//                             if ($file == $image->getClientOriginalName()) {
//                                 $name = $productDraft->id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
//                                 $name .= str_replace(' ', '-',$image->getClientOriginalName());

//                                 $image->move('uploads/product-images/', $name);
// //                    $dataset[]['src'] = asset('uploads/product-images/'.$name);
//                                 $image_array[] = asset('uploads/product-images/' . $name);
//                                 $temp = 1;
//                             }
//                         }
//                         if($temp == null) {
//                             $image_array[] = $file;
//                         }
//                     }
//                 }elseif($request->sortable_image){
//                     $files = explode(',', $request->sortable_image);
//                     foreach ($files as $file) {
//                         $image_array[] = $file;
//                     }
//                 }
//                 else{
//                     foreach ($request->images as $image) {
//                         $name = $productDraft->id.'-'.str_replace(' ', '-',$image->getClientOriginalName());
//                         $image->move('uploads/product-images/', $name);
//                         $image_array[] = asset('uploads/product-images/' . $name);

//                     }
//                 }
//                $ebay_product_info = EbayMasterProduct::where('master_product_id', 94671)->first();
//                echo "<pre>";
//                print_r(\Opis\Closure\unserialize($ebay_product_info->variation_images) );
////                print_r($image_array);
//                exit();
                if(count($image_array) > 0) {
                    // echo '<pre>';
                    // print_r($image_array);
                    // exit();
                    $pictures .= "<PictureDetails>";
                    foreach ($image_array as $image) {
                        // $dataimage[] = [
                        //     'draft_product_id' => $productDraft->id,
                        //     'image_url' => $image
                        // ];
                        $woo_dataimage[] = [
                            'src' => $image
                        ];
                        $onbuy_dataimage[] = $image;

                        $pictures .='<PictureURL>'.$image.'</PictureURL>';
                    }
                    $pictures .= "</PictureDetails>";
                    $exist_image = Image::where('draft_product_id', $productDraft->id)->get();
                    if(count($exist_image) > 0){
                        Image::where('draft_product_id', $productDraft->id)->delete();
                        $image = Image::insert($dataimage);
                    }else{
                        $image = Image::insert($dataimage);
                    }
                }
            }
        }catch (\Exception $exception){
            return back()->with('wms_error','Something went wrong with image. Please check and retry');
        }

        if($request->upload_variation_image == 1){
            $woocommcerce_active = WoocommerceAccount::where('status',1)->first();
            if(isset($request->singleVariationImageCheckbox) && $request->singleVariationImageCheckbox == 1){
                if($request->hasFile('singleImageFile')){
                    $file = $request->singleImageFile;
                    $name = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->move('assets/images/product_variation/', $name);
                    $image_url = asset('assets/images/product_variation/' . $name);
                    $single_woo_arr = [];

                    foreach ($request->variation_ids as $key => $value) {
                        $attribute_and_terms = [
                            $request->attribute_name[$key] => $request->attribute_terms[$key]
                        ];
                        $single_image_url_update = ProductVariation::whereIn('id', explode(',', $request->var_id[$key]))->update([
                            'image' => $image_url,
                            'image_attribute' => \Opis\Closure\serialize($attribute_and_terms)
                        ]);
    //                    $extact_id = json_decode($value);
                        if($woocommcerce_active && $request->button != "wms" ){
                            $woo_comm_variation_info = WoocommerceVariation::whereIn('woocom_variation_id', explode(',', $request->var_id[$key]))->get();
                            $woo_var_ids = [];
                            foreach ($woo_comm_variation_info as $info) {
                                $woo_var_ids = [
                                    'id' => $info->id,
                                    'image' => [
                                        'src' => $image_url
                                    ]
                                ];
                                array_push($single_woo_arr,$woo_var_ids);
                            }
                        }

                    }

                    if($woocommcerce_active && $request->button != "wms"){
                        if (count($single_woo_arr) > 0) {
                            $wooCommPostData['update'] = $single_woo_arr;
                            try {
                                $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info[0]->woocom_master_product_id . '/variations/batch', $wooCommPostData);
                            } catch (HttpClientException $exception) {
                                return back()->with('error', $exception->getMessage());
                            }
                            $product_variation_decode_result = json_decode(json_encode($product_variation_result));

                            foreach ($product_variation_decode_result->update as $result) {
                                $woo_product_variation_result = WoocommerceVariation::where('id', $result->id)->update([
                                    'image' => $result->image->src ?? null
                                ]);
                            }
                        }
                    }
                }

            }else {
                if (isset($request->variation_image) && count($request->variation_image) > 0) {
                    foreach ($request->variation_image as $key => $value) {
                        $attribute_and_terms = [
                            $request->attribute_name[$key] => $request->attribute_terms[$key]
                        ];
                        $file = $request->variation_image[$key];
                        $name = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                        $file->move('assets/images/product_variation/', $name);
                        $image_url = asset('assets/images/product_variation/' . $name);
                        $single_image_url_update = ProductVariation::whereIn('id', explode(',', $request->var_id[$key]))->update([
                            'image' => $image_url,
                            'image_attribute' => \Opis\Closure\serialize($attribute_and_terms)
                        ]);
                        $extact_id = json_decode($request->variation_ids[$key]);
                        if ($request->button != "wms"){
                            $woo_comm_variation_info = WoocommerceVariation::whereIn('woocom_variation_id', $extact_id)->get();
                            if (count($woo_comm_variation_info) > 0) {
                                $woo_var_ids = [];
                                foreach ($woo_comm_variation_info as $info) {
                                    $woo_var_ids[] = [
                                        'id' => $info->id,
                                        'image' => [
                                            'src' => $image_url
                                        ]
                                    ];
                                }

                                $wooCommPostData['update'] = $woo_var_ids;
                                try {
                                    $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info[0]->woocom_master_product_id . '/variations/batch', $wooCommPostData);
                                } catch (HttpClientException $exception) {
                                    return back()->with('error', $exception->getMessage());
                                }
                                $product_variation_decode_result = json_decode(json_encode($product_variation_result));
                                foreach ($product_variation_decode_result->update as $result) {
                                    $woo_product_variation_result = WoocommerceVariation::where('id', $result->id)->update([
                                        'image' => $result->image->src ?? null
                                    ]);
                                }
                            }
                        }

                    }
                }
            }
        }

        try {
            $master_catalogue_update_result = ProductDraft::where('id', $productDraft->id)->update([
                'modifier_id' => Auth::user()->id ?? null,
                'woowms_category' => $request->category_id ?? null,
                'condition' => $request->condition ?? null,
                'name' => $request->name,
                'description' => $request->description,
                'short_description' => $request->short_description ?? null,
                'regular_price' => $request->regular_price ?? null,
                'sale_price' => $request->sale_price ?? null,
                'rrp' => $request->rrp ?? $request->regular_price ?? null,
                'cost_price' => $request->cost_price ?? null,
                'base_price' => $request->base_price ?? null,
                'product_code' => $request->product_code ?? null,
                'color' => $request->color ?? null,
                'color_code' => $request->color_code ?? null,
                'sku_short_code' => $request->sku_short_code ?? null,
                'low_quantity' => $request->low_quantity ?? null,
                'brand_id' => $request->brand_id ?? null,
                'gender_id' => $request->gender_id ?? null,
            ]);
            $termInsertInfo = [];
            if($request->item_attribute != null){
                foreach($request->item_attribute as $key => $item_attr){
                    $explodeVal = explode('/',$key);
                    if($item_attr != null && $explodeVal[1] != null){
                        $updateInfo = ItemAttributeTermValue::find($explodeVal[1])->update(['item_attribute_term_value' => $item_attr]);
                    }elseif($item_attr != null && $explodeVal[1] == null){
                        $termInsertInfo = ItemAttributeTermValue::create([
                            'item_attribute_term_id' => $explodeVal[0],
                            'item_attribute_term_value' => $item_attr
                        ]);
                        if($termInsertInfo){
                            $catalogueTermInsertInfo = CatalogueAttributeTerms::create([
                                'catalogue_id' => $productDraft->id,
                                'attribute_id' => $explodeVal[0],
                                'attribute_term_id' => $termInsertInfo->id
                            ]);
                        }
                    }elseif($item_attr == null && $explodeVal[1] != null){
                        $deleteInfo = ItemAttributeTermValue::find($explodeVal[1])->delete();
                        if($deleteInfo){
                            $attributeExistCheck = CatalogueAttributeTerms::where('catalogue_id',$productDraft->id)
                            ->where('attribute_id',$explodeVal[0])->first();
                            $attributeExistCheck->delete();
                        }
                    }
                }
            }
        }catch (Exception $exception){
            $this->wms = $exception;
        }
        try {
            $product_variation_cost_price = ProductVariation::select('id','low_quantity')->where('product_draft_id',$productDraft->id)->get();
            if(count($product_variation_cost_price) > 0) {
                foreach ($product_variation_cost_price as $cost_price) {
                    // if ($cost_price->cost_price == $request->old_cost_price) {
                    //     $update_info = ProductVariation::where(['id' => $cost_price->id])->update(['cost_price' => $request->cost_price ?? null]);
                    // }
                    $variation_update_info = ProductVariation::where('product_draft_id', $productDraft->id)->update([
                        //  'regular_price' => $request->regular_price ?? null,
                        //  'sale_price' => $request->sale_price ?? null,
                        //  'rrp' => $request->rrp ?? $request->regular_price ?? null,
                        // 'base_price' => $request->base_price ?? null,
                        'low_quantity' => ($cost_price->low_quantity == $request->old_low_quantity) ? $request->low_quantity : $cost_price->low_quantity
                    ]);
                }
            }
        }catch (\Exception $exception){
            return back()->with('wms_error','Something went wrong when updating master variation information');
        }

        //woocommerce update start
//        if(Session::get('woocommerce') == 1 && $request->button != "wms"){
//            if($request->website_update == 1) {
//                $woocommcerce_status = WoocommerceAccount::where('status',1)->first();
//                if($woocommcerce_status){
//                    $woo_catalogue_info = WoocommerceCatalogue::where('master_catalogue_id', $productDraft->id)->first();
//                    if ($woo_catalogue_info) {
//                        $data = [
//                            'name' => $request->name ?? null,
//                            'description' => $request->description ?? null,
//                            'short_description' => $request->short_description ?? null
//                        ];
//                        // $data['meta_data'][] = [
//                        //     'key' => 'rrp',
//                        //     'value' => $request->rrp ?? $request->regular_price ?? null,
//                        // ];
//                        if ($request->image_update_check == 1 && (count($woo_dataimage) > 0)) {
//                            $data['images'] = $woo_dataimage;
//                        }
//                        try {
//                            $woocom_product_result = Woocommerce::put('products/' . $woo_catalogue_info->id, $data);
//                            $woocom_product_result = json_decode(json_encode($woocom_product_result));
//                            $woo_master_catalogue_update_result = WoocommerceCatalogue::where('master_catalogue_id', $productDraft->id)->update([
//                                'modifier_id' => Auth::user()->id ?? null,
//                                'name' => $request->name,
//                                'description' => $request->description,
//                                'short_description' => $request->short_description ?? null,
//                                // 'regular_price' => $request->regular_price ?? null,
//                                // 'sale_price' => $request->sale_price ?? null,
//                                // 'rrp' => $request->rrp ?? $request->regular_price ?? null,
//                                // 'cost_price' => $request->cost_price ?? null,
//                                'product_code' => $request->product_code ?? null,
//                                'color_code' => $request->color_code ?? null,
//                                'low_quantity' => $request->low_quantity ?? null
//                            ]);
//                            if ($request->image_update_check == 1 && (count($woocom_product_result->images) > 0)) {
//                                $woo_system_dataimage = [];
//                                foreach ($woocom_product_result->images as $image) {
//                                    $woo_system_dataimage[] = [
//                                        'id' => $image->id,
//                                        'woo_master_catalogue_id' => $woo_catalogue_info->id ?? null,
//                                        'image_url' => $image->src ?? null
//                                    ];
//                                }
//                                $woocommerce_image = WoocommerceImage::where('woo_master_catalogue_id', $woo_catalogue_info->id)->get();
//                                if(count($woocommerce_image) > 0) {
//                                    WoocommerceImage::where('woo_master_catalogue_id', $woo_catalogue_info->id)->delete();
//                                }
//                                $image = WoocommerceImage::insert($woo_system_dataimage);
//                            }
//                            // $variation_data = [
//                            //     'regular_price' => $request->regular_price ?? 0,
//                            //     'sale_price' => $request->sale_price ?? 0
//                            // ];
//                            // $woo_variation_info = WoocommerceVariation::where('woocom_master_product_id', $woo_catalogue_info->id)->get();
//                            // if (count($woo_variation_info) > 0) {
//                            //     foreach ($woo_variation_info as $varaition_info) {
//                            //         try {
//                            //             $product_variation_result = Woocommerce::put('products/' . $varaition_info->woocom_master_product_id . '/variations/' . $varaition_info->id, $variation_data);
//                            //         } catch (HttpClientException $exception) {
//                            //             return back()->with('woocom_error', $exception->getMessage());
//                            //         }
//                            //         if ($varaition_info->cost_price == $request->old_cost_price) {
//                            //             $update_info = WoocommerceVariation::where(['id' => $varaition_info->id])->update(['cost_price' => $request->cost_price ?? 0]);
//                            //         }
//                            //         $update = WoocommerceVariation::where('woocom_master_product_id', $woo_catalogue_info->id)->update([
//                            //             'regular_price' => $request->regular_price ?? 0,
//                            //             'sale_price' => $request->sale_price ?? 0,
//                            //             'rrp' => $request->rrp ?? $request->regular_price ?? null
//                            //         ]);
//                            //     }
//                            // }
//                        } catch (HttpClientException $exception) {
//                            $this->woocom_result = $exception->getMessage();
//                        }
//                    }
//
//                }
//            }
//        }
        //woocommerce update end

        //ebay update starts
        if(Session::get('ebay') == 1 && $request->button != "wms"){
            if($request->ebay_update == 1) {
                $ebay_status = DeveloperAccount::where('status',1)->first();
                if($ebay_status) {
                    $ebay_product_info = EbayMasterProduct::where('master_product_id', $productDraft->id)->first();
                    $variation_array = null;
                    if ($ebay_product_info) {

                        $variation_array = array();
                        // dd(\Opis\Closure\unserialize($productDraft->attribute));
                        if ($ebay_product_info->variation_specifics == NULL){

                            foreach (\Opis\Closure\unserialize($productDraft->attribute) as $attribute_id => $attribute_array){
                                foreach ($attribute_array as $attribute_name => $value){
                                    foreach ($value as $index2 => $value2){
                                        $variation_array[$attribute_name][] = $value2['attribute_term_name'];
                                    }
                                }
                            }


                            EbayMasterProduct::where('master_product_id', $productDraft->id)->update(['variation_specifics' => \Opis\Closure\serialize($variation_array)]);
                        }

                        $profile_result = EbayProfile::find($ebay_product_info->profile_id);
                        if($profile_result) {

                            if ($request->image_update_check != 1) {
                                $pictures = '';
                            }
                            $master_images = \Opis\Closure\serialize($image_array);
                            try {


                                $ebay_result = $this->updateEbayMasterProduct($productDraft->id, $data, $pictures, $request,$image_array);



                            } catch (HttpClientException $exception) {
                                return response()->json($exception->getMessage());
                            }
                        }
                    }
                }
            }
        }
        //ebay update end

        //Onbuy update start
        if(Session::get('onbuy') == 1 && $request->button != "wms"){
        if($request->onbuy_update == 1) {
            $onbuy_status = OnbuyAccount::where('status',1)->first();
            if($onbuy_status) {
                $single_master_product_info = OnbuyMasterProduct::where('woo_catalogue_id', $productDraft->id)->first();
                if ($single_master_product_info) {
                    $data = [
                        "site_id" => 2000,
                        "product_name" => $request->name ?? '',
                        "description" => $request->description ?? '',
                        // "rrp" => $request->sale_price ?? 0
                    ];
                    if ($request->image_update_check == 1 && (count($onbuy_dataimage) > 0)) {
                        $data['default_image'] = $onbuy_dataimage[0] ?? null;
                        $data['additional_images'] = $onbuy_dataimage ?? null;
                    }
                    $product_info = json_encode($data, JSON_PRETTY_PRINT);
                    try {
                        $access_token = $this->access_token();
                        if($access_token != 'notoken') {
                            $url = "https://api.onbuy.com/v2/products/" . $single_master_product_info->opc;
                            $post_data = $product_info;
                            $method = "PUT";
                            $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                            $data = json_decode($result_info, JSON_PRETTY_PRINT);

                            $update = OnbuyMasterProduct::where('id', $single_master_product_info->id)->update([
                                'product_name' => $request->name,
                                'description' => $request->description,
                                // 'rrp' => $request->sale_price ?? null,
                                // 'base_price' => $request->base_price ?? null,
                            ]);

                            if ($request->image_update_check == 1 && (count($onbuy_dataimage) > 0)) {
                                $update = OnbuyMasterProduct::where('id', $single_master_product_info->id)->update([
                                    'default_image' => $onbuy_dataimage[0] ?? null,
                                    'additional_images' => json_encode($onbuy_dataimage) ?? null,
                                ]);
                            }

                            $onbuy_variation_info = OnbuyVariationProducts::where('master_product_id', $single_master_product_info->id)->get();
                            if (count($onbuy_variation_info) > 0) {
                                foreach ($onbuy_variation_info as $variation_info) {
                                    $var_data[] = [
                                        "sku" => $variation_info->sku,
                                        // "price" => $request->sale_price ?? 0.00
//                                "stock" => $request->stock
                                    ];
                                    if ($request->image_update_check == 1 && (count($onbuy_dataimage) > 0)) {
                                        $update_info = [
                                            "site_id" => 2000,
                                            "default_image" => $onbuy_dataimage[0],
                                            "additional_images" => $onbuy_dataimage,
                                            "listings" => $var_data
                                        ];
                                    } else {
                                        $update_info = [
                                            "site_id" => 2000,
                                            "listings" => $var_data
                                        ];
                                    }
                                    $var_product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                                    $var_post_data = $var_product_info;
                                    $method = "PUT";
                                    $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                                    $result_info = $this->curl_request_send($url, $method, $var_post_data, $http_header);

//                                     $update_info = OnbuyVariationProducts::where('id', $variation_info->id)->update([
//                                         'price' => $request->sale_price ?? 0.00,
//                                         'base_price' => $request->base_price ?? null,
// //                                'stock' => $request->stock
//                                     ]);
                                }
                                $data = json_decode($result_info);
                            }
                        }

                    } catch (\Exception $exception) {
                        $this->onbuy_result = $exception->getMessage();
                    }
                }
            }
        }
        }
        //Onbuy update end

        if ($this->wms != null){
            $wms_flag = 'wms_error';
            $this->wms = 'Wms Failed :' .$this->wms;
        }else{
            $wms_flag = 'wms_success';
            $this->wms = 'WMS Successfully Updated';
        }
        if ($this->onbuy_result != null && $onbuy_status && $request->button != "wms"){
            $onbuy_flag = 'onbuy_error';
            $this->onbuy_result = 'Onbuy Failed :' .$this->onbuy_result;
        }else if($onbuy_status && $request->button != "wms"){
            $onbuy_flag = 'onbuy_success';
            $this->onbuy_result = 'OnBuy Successfully Updated';
        }
        if ($this->woocom_result != null && $woocommcerce_status && $request->button != "wms"){
            $woocom_flag = 'woocom_error';
            $this->woocom_result = 'Woocommerce Failed :' .$this->woocom_result;
        }else if($woocommcerce_status && $request->button != "wms"){
            $woocom_flag = 'woocom_success';
            $this->woocom_result = 'WooCommerce Successfully Updated';
        }

        if ($this->ebay_result !=null && $ebay_status && $request->button != "wms"){
            $ebay_flag = 'ebay_error';
            $this->ebay_result = ' Ebay failed : ' . $this->ebay_result;
        }else if($ebay_status && $request->button != "wms"){
            $ebay_flag = 'ebay_success';
            $this->ebay_result = 'eBay Successfully Updated';
        }
        return back()->with($ebay_flag, $this->ebay_result)
            ->with($onbuy_flag,$this->onbuy_result)
            ->with($woocom_flag,$this->woocom_result)
            ->with($wms_flag,$this->wms);
    }
    public function addProductDraftValue(Request $request){
        $result = null;
        $id = null;
        if ($request->name == "Add Condition"){
            $result = Condition::create(['condition_name'=>$request->value,'user_id'=> Auth::user()->id]);
            //$result = Condition::get()->all();
            $id = "selectCondition";
        }else if($request->name == "Add Brand"){
            $result = Brand::create(['name'=>$request->value]);
            //$result = Condition::get()->all();
            $id = "selectBrand";
        }else if ($request->name == "Add Department"){
            $result = Gender::create(['name'=>$request->value]);
            //$result = Condition::get()->all();
            $id = "selectDepartment";
        }else if ($request->name == "Add Wms Category"){
            $result = WooWmsCategory::create(['category_name'=>$request->value,'user_id' => Auth::user()->id]);

            GenderWmsCategory::create(["wms_category_id" => $result->id,"gender_id" => $request->department]);
            //$result = Condition::get()->all();
            $id = "selectWMSCategory";
        }
        return ["result"=>$result,"id"=> $id];
    }
    public function updateEbayMasterProduct($master_product_id,$data,$pictures,$request,$image_array){
        $master_product_id = $master_product_id;
        $data = $data;
        $title = '';
        $description = '';
        $ebay_product_find = EbayMasterProduct::where('master_product_id',$master_product_id)->where('product_status',"Active")->get()->all();
        if(count($ebay_product_find) > 0) {
            foreach ($ebay_product_find as $product) {

                $variations = '';
                $name= '';
                $title = '';
                $description = '';
                $tracker_array =\Opis\Closure\unserialize($product->draft_status) ;
                $ebay_pictures = '';


                $account_result = EbayAccount::find($product->account_id);
                if($account_result) {
                    $this->ebayAccessToken($account_result->refresh_token);
                    if($this->ebay_update_access_token != '') {
                        $product_result = ProductDraft::with(['ProductVariations', 'images'])->where('id', $product->master_product_id)->get();

                        if($product_result[0]->type=="variable"){
                            $variation_image = $this->getImageVariation($product->master_product_id);
                            if($variation_image != ""){
                                $variations = '<Variations>

                            ' . $variation_image . '

                                                </Variations>';
                            }
                        }
                        $profile_result = EbayProfile::find($product->profile_id);
                        $template_result = EbayTemplate::find($profile_result->template_id);

                        $title = $product->title;
                        $description = $product->description;
                        $name = $product->title;

                        if($template_result) {
                            if (isset($tracker_array['title_flag'])){
                                if ($tracker_array['title_flag'] == 1){
//                                    $name = $product->title;
//                                    $title = $product->title;
                                    $name = $product_result[0]->name;
                                    $title = $product_result[0]->name;
                                }
                            }
                            if (isset($tracker_array['description_flag'])){
                                if ($tracker_array['description_flag'] == 1){
//                                    $description = $product->description;
                                    $description = $product_result[0]->description;
                                }
                            }
                            if (isset($tracker_array['image_flag'])){
                                if ($tracker_array['image_flag'] == 1){
                                    $ebay_pictures = $pictures;
                                }
                            }

                            $images = \Opis\Closure\unserialize($product->master_images) ;
                            $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
                            $template_result = view('ebay.all_templates.' . $template_name, compact('name','description','images'));
                        }else{
                            $template_result = EbayTemplate::where('template_name','Default Template')->get()->first();
                            if ($tracker_array['title_flag'] == 1){
                                $name = $product->title;
                                $title = $product->title;
                            }if ($tracker_array['description_flag'] == 1){
                                $description = $product->description;
                            }

                            if (isset($tracker_array['image_flag'])){
                                if ($tracker_array['image_flag'] == 1){
                                    $ebay_pictures = $pictures;
                                }
                            }
                            $images = \Opis\Closure\unserialize($product->master_images) ;
                            $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
                            $template_result = view('ebay.all_templates.' . $template_name, compact('name','description','images'));

                        }
                        $url = 'https://api.ebay.com/ws/api.dll';
                        $headers = [
                            'X-EBAY-API-SITEID:' . $product->site_id,
                            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                            'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                        ];
//                        <Title>'.$data['name'].'</Title>
                        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>' . $product->item_id . '</ItemID>
                        <Title>'. '<![CDATA[' .$title. ']]>' . '</Title>';
                        if(isset($product->type) && ($product->type == 'simple') && isset($request->sku)){
                            $body .= '<SKU>'.$request->sku.'</SKU>';
                        }
                        $body .= '<Description>' . '<![CDATA[' . $template_result . ']]>' . '</Description>
                         '. $ebay_pictures
                            .$variations. '

                      </Item>
                    </ReviseFixedPriceItemRequest>';

                        $update_ebay_product = $this->curl($url, $headers, $body, 'POST');
                        $update_ebay_product = simplexml_load_string($update_ebay_product);
                        $update_ebay_product = json_decode(json_encode($update_ebay_product), true);

                        if ($update_ebay_product['Ack'] == 'Warning' || $update_ebay_product['Ack'] == 'Success') {
                            EbayMasterProduct::where('item_id', $product->item_id)->update(['change_message' => 'success','item_description' => $template_result,'title' => $title,'description' => $description]);
                            if (isset($tracker_array['image_flag'])){
                                if ($tracker_array['image_flag'] == 1){
                                    if (count($image_array) > 0) {
                                        $master_images = \Opis\Closure\serialize($image_array);
                                        $master_product_result = EbayMasterProduct::where('id', $product->id)->update(['master_images' => $master_images]);
                                    }
                                }
                            }

                        } else {
                            EbayMasterProduct::where('item_id', $product->item_id)->update(['change_message' => \GuzzleHttp\json_encode($update_ebay_product),'item_description' => $template_result]);
                            $this->ebay_result = 'Item ID :' . $product->item_id . $this->ebay_result . \GuzzleHttp\json_encode($update_ebay_product) . '\n';
                        }
                    }
                }
            }
        }
    }

    public function ebayAccessToken($refresh_token){
        $developer_result = DeveloperAccount::get()->first();
        if($developer_result) {
            $clientID = $developer_result->client_id;
            $clientSecret = $developer_result->client_secret;
            $url = 'https://api.ebay.com/identity/v1/oauth2/token';
            $headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret),
            ];
            $body = http_build_query([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',
            ]);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $headers
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $response = json_decode($response, true);
            if($response['access_token'] != '') {
                $this->ebay_update_access_token = $response['access_token'];
            }else{
                $this->ebay_update_access_token = '';
            }
        }else{
            $this->ebay_update_access_token = '';
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : destroy
     * Route : product-draft.destroy
     * parameters: $id (This is the master catalogue id)
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for deleting master catalogue with all channel catalogue and variations
     * Created Date: unknown
     * Modified Date : 13-11-2020, 15-11-2020
     */

    public function destroy($id)
    {
        try{
            $catalogue_info = ProductDraft::find($id);
            if($catalogue_info){
                $ebayExceptionMsg = '';
                if(Session::get('ebay') == 1){
                try{
                    $ebay_client_id = Session::get('ebay_client_id');
                    $ebay_client_secret = Session::get('ebay_client_secret');
//                    if($ebay_client_id != '' && $ebay_client_secret != '') {
                        $ebay_product_result = EbayMasterProduct::where('master_product_id', $id)->get();
                        if(count($ebay_product_result) > 0) {
                            foreach ($ebay_product_result as $ebay_product) {
                                $ebay_access_token = $this->getAuthorizationToken($ebay_product->account_id);
                                if ($ebay_access_token != '') {
                                    $body = '<?xml version="1.0" encoding="utf-8"?>
                                    <EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                        <ErrorLanguage>en_US</ErrorLanguage>
                                        <WarningLevel>High</WarningLevel>
                                        <!-- Enter the ItemID you wantto end-->
                                      <ItemID>' . $ebay_product->item_id . '</ItemID>
                                      <EndingReason>NotAvailable</EndingReason>
                                    </EndFixedPriceItemRequest>';

                                    $url = 'https://api.ebay.com/ws/api.dll';
                                    $headers = [
                                        'X-EBAY-API-SITEID:' . $ebay_product->site_id,
                                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                        'X-EBAY-API-CALL-NAME:EndFixedPriceItem',
                                        'X-EBAY-API-IAF-TOKEN:' . $ebay_access_token,

                                    ];
                                    $result = $this->curl($url, $headers, $body, 'POST');
                                    $result = simplexml_load_string($result);
                                    $result = json_decode(json_encode($result), true);

                                    if ($result['Ack'] == 'Success') {
                                        $ebay_master_product = EbayMasterProduct::find($ebay_product->id);
                                        if($ebay_master_product) {
                                            $ebay_master_product->variationProducts()->delete();
                                            EbayMasterProduct::destroy($ebay_product->id);
                                        }
                                    } else {
                                        $ebay_master_product = EbayMasterProduct::find($ebay_product->id);
                                        if($ebay_master_product) {
                                            $ebay_master_product->variationProducts()->delete();
                                            EbayMasterProduct::destroy($ebay_product->id);
                                        }
                                    }
                                }
                            }
                        }
//                    }

                }
                catch (\Exception $exception){
                    $ebayExceptionMsg = '('. $exception->getMessage() .')';
                }
            }
            $woocommerceExceptionMsg = '';
            if(Session::get('woocommerce') == 1){
                try {
                    $woocommerce_consumer_key = Session::get('woocommerce_consumer_key');
                    $woocommerce_secret_key = Session::get('woocommerce_secret_key');
                    if($woocommerce_consumer_key == '' && $woocommerce_secret_key == ''){
                        $wooAccInfo = WoocommerceAccount::where('status',1)->first();
                        if($wooAccInfo){
                            $woocommerce_consumer_key = $wooAccInfo->consumer_key ?? '';
                            $woocommerce_secret_key = $wooAccInfo->secret_key ?? '';
                            Session::put('woocommerce_consumer_key',$wooAccInfo->consumer_key);
                            Session::put('woocommerce_secret_key',$wooAccInfo->secret_key);
                        }
                    }
                    if($woocommerce_consumer_key != '' && $woocommerce_secret_key != '') {
                        $woocommerce_catalogue_info = WoocommerceCatalogue::where('master_catalogue_id', $id)->first();
                        if ($woocommerce_catalogue_info) {
                            Woocommerce::delete('products/' . $woocommerce_catalogue_info->id);
                            DB::transaction(function () use ($woocommerce_catalogue_info) {
                                $woocommerce_catalogue_info->variations()->delete();
                                $woocommerceImage = WoocommerceImage::where('woo_master_catalogue_id',$woocommerce_catalogue_info->id)->get();
                                if(count($woocommerceImage) > 0){
                                    WoocommerceImage::where('woo_master_catalogue_id',$woocommerce_catalogue_info->id)->delete();
                                }
                                $woocommerce_catalogue_info->delete();
                            });

                        }
                    }
                }catch (\Exception $exception){
                    $woocommerceExceptionMsg = '('. $exception->getMessage() .')';
                }
            }
            if(Session::get('onbuy') == 1){
                $onbuyExceptionMsg = '';
                try {
                    $onbuy_consumer_key = Session::get('onbuy_consumer_key');
                    $onbuy_secret_key = Session::get('onbuy_secret_key');
                    if($onbuy_consumer_key == '' && $onbuy_secret_key == ''){
                        $info = OnbuyAccount::where('status',1)->first();
                        if($info) {
                            Session::put('onbuy_consumer_key', $info->consumer_key);
                            Session::put('onbuy_secret_key', $info->secret_key);
                            $onbuy_consumer_key = $info->consumer_key;
                            $onbuy_secret_key = $info->secret_key;
                        }
                    }
                    if($onbuy_consumer_key != '' && $onbuy_secret_key != ''){
                        $onbuy_catalogue_info = OnbuyMasterProduct::where('woo_catalogue_id', $id)->first();
                        if($onbuy_catalogue_info){
                            $skus = OnbuyVariationProducts::select('sku')->where('master_product_id',$onbuy_catalogue_info->id)->get();
                            $sku_arr = [];
                            if(count($skus) > 0) {
                                foreach ($skus as $sku) {
                                    array_push($sku_arr, $sku->sku);
                                }

                                $access_token = $this->access_token();
                                if($access_token != '') {
                                    $data = [
                                        "site_id" => 2000,
                                        "skus" => $sku_arr
                                    ];
                                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                                    $post_data = json_encode($data, JSON_PRETTY_PRINT);
                                    $method = "DELETE";
                                    $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                                    $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);

                                    $result_info = json_decode($result_info);
                                    if (isset($result_info->results)) {
                                        $master = OnbuyMasterProduct::find($onbuy_catalogue_info->id);
                                        if($master) {
                                            $master->variation_product()->delete();
                                            $master_del = OnbuyMasterProduct::find($onbuy_catalogue_info->id)->delete();
                                        }
                                    }
                                }
                            }else{
                                $master = OnbuyMasterProduct::find($onbuy_catalogue_info->id)->delete();
                            }
                        }
                    }
                }catch (\Exception $exception){
                    $onbuyExceptionMsg = '('. $exception->getMessage() .')';
                }
            }
                DB::transaction(function () use ($catalogue_info) {
                    if(count($catalogue_info->ProductVariations) > 0) {
                        foreach ($catalogue_info->ProductVariations as $variation) {
                            $del = ShelfedProduct::where('variation_id', $variation->id)->delete();
                        }
                    }
                    $catalogue_info->ProductVariations()->delete();
                    $masterImage = Image::where('draft_product_id',$catalogue_info->id)->get();
                    if(count($masterImage) > 0){
                        Image::where('draft_product_id',$catalogue_info->id)->delete();
                    }
                    $catalogue_info->delete();
                });
                return back()->with('success', 'Catalogue Successfully Deleted'. $ebayExceptionMsg . $woocommerceExceptionMsg .$onbuyExceptionMsg);
            }else{
                return back()->with('error','Catalogue is not found');
            }
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
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

    public function publishedProductList(){

        $shelf_use = $this->shelf_use;
        $settingData = $this->paginationSetting('', '');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

//        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
//        if(isset($setting_info)) {
//            if($setting_info->setting_attribute){
//                $setting = json_decode($setting_info->setting_attribute);
//                $page_title = $setting->master_publish_catalogue->page_title ?? null;
//            }
//            $value = $setting_info->value ?? 50;
//        }else{
//            $setting = null;
//            $page_title = null;
//            $value = 50;
//        }

        $published_product = ProductDraft::with(['ProductVariations' => function($query){
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        },'all_category','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
            $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')->where('status','publish')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(120))
            ->orderBy('id','DESC')->paginate($pagination);
        $published_product_info = json_decode(json_encode($published_product));
        $published_product_infos = $published_product;
        $total_published_product = ProductDraft::where('status','publish')->count();
//        echo "<pre>";
//        print_r(json_decode(json_encode($published_product)));
//        exit();
        $content = view('product_draft.published_product_list',compact('published_product','total_published_product','published_product_info','published_product_infos',
            'setting','pagination','shelf_use'));
        return view('master',compact('content','page_title'));
    }

    public function SsearchProductList(Request $request){
        if($request->status == 'draft' || $request->status == 'publish'){
            $data_arr = [];
            array_push($data_arr,$request->status);
        }else{
            $data_arr = $request->status;
        }
        $field = ['product_drafts.name','product_drafts.id','product_variation.id','product_variation.sku','product_variation.ean_no'];
        $catalogue_ids = ProductDraft::select('product_drafts.id')
            ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
            ->where([['product_drafts.deleted_at','=',null],['product_variation.deleted_at','=',null]])
            ->whereIn('product_drafts.status',$data_arr)
            ->where(function ($query) use ($field,$request){
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->name . '%');
                }
            })
            ->orderByDesc('product_drafts.id')
            ->groupBy('product_drafts.id')
            ->get();
        $catalogur_arr_ids = [];
        if(count($catalogue_ids) > 0) {
            foreach ($catalogue_ids as $id) {
                $catalogur_arr_ids[] = $id->id;
            }
            $implode_id = implode(',',$catalogur_arr_ids);;
            $search_result = ProductDraft::with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
                $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                    $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            },'catalogueVariation' => function($query){
                $query->with(['shelf_quantity', 'order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereIn('status', $data_arr)->where(function($q) use($request){
//                $q->where('name','LIKE','%'. $request->name.'%')->orWhere('id','LIKE','%'.$request->name.'%');
//            })
                ->whereIn('id', $catalogur_arr_ids)
                ->orderByRaw("FIELD(id, $implode_id)")
                ->get();
//            echo "<pre>";
//            print_r(json_decode($search_result));
//            exit();
            $date = '12345';
            $status = $request->status;
            return view('product_draft.search_product_list', compact('search_result', 'status', 'date'));
        }else{
            return response()->json(['data' => 'error']);
        }
    }

    public function getVariation(Request $request){
        $shelf_use = $this->shelf_use;
        $searchKeyword = $request->searchKeyword;
        $shelfQuantityChangeReason = ShelfQuantityChangeReason::all();
        $product_draft = ProductDraft::where('id',$request->product_draft_id)->with(['catalogueVariation' => function($query){
            $query->with(['shelf_quantity', 'order_products' => function ($query) {
                $this->orderWithoutCancelAndReturn($query);
            },'get_reshelved_product' => function($reshelve){
                $reshelve->where('status',0)->select('variation_id',DB::raw('sum(reshelved_product.quantity) pending_reshelve'))->groupBy('variation_id');
            }]);
        }])
//            ->whereIn('status', $data_arr)->where(function($q) use($request){
//                $q->where('name','LIKE','%'. $request->name.'%')->orWhere('id','LIKE','%'.$request->name.'%');
//            })
            ->get()->first();
//        echo "<pre>";
//        print_r($product_draft);
//        exit();
        return view('product_draft.variation_ajax',compact('product_draft','shelf_use','shelfQuantityChangeReason','searchKeyword'));
    }

        public function searchProductList(Request $request){
        // $res = ProductVariation::where('attribute', 'regexp', '.*"terms_name";s:[0-9]+:"UK 28 (US 28 / 32)".*')->pluck('product_draft_id')->toArray();

        $search_keyword =  $request->name;
        $search_result = null;
        $date = '12345';
        $status = $request->status;
        $search_priority = $request->search_priority;
        $take = $request->take;
        $skip = $request->skip;
        $ids = $request->ids;
        $woocommerceSiteUrl = WoocommerceAccount::first();

//        return $request;
        $matched_product_array = array();
        if (is_numeric($search_keyword)){
            if (strlen($search_keyword) == 13){
                $find_variation = ProductVariation::where('ean_no','=',$search_keyword)->get()->first();
                if ($find_variation != null){
                    array_push($matched_product_array,$find_variation->product_draft_id);
                    $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
                    $search_result = $search_draft_result['search'];
                    $ids = $search_draft_result['ids'];
                    return response()->json(['html' => view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
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
                    return response()->json(['html' => view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
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
                return response()->json(['html' => view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
            }

        }else{
            if (strpos($search_keyword," ") != null){

                $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                $search_priority = $search_result_by_word["search_priority"];
                $ids = $search_result_by_word["ids"];
                return response()->json(['html' => view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
            }else{
                $search_sku_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_sku_result['search'];
                $ids = $search_sku_result['ids'];
                if ($search_result== null){
                    $skip = 0;
                    $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                    $search_result = $search_result_by_word["search"];
                    $search_priority = $search_result_by_word["search_priority"];
                    $ids = $search_result_by_word["ids"];
                }

                return response()->json(['html' => view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);

            }

        }

    }

    public function searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids){
        $matched_product_array = array();
        $search_result = null;
        $find_sku  =  ProductVariation::where('sku','=',$search_keyword)->get()->first();
        if ($find_sku != null) {
            array_push($matched_product_array, $find_sku->product_draft_id);
            $search_draft_result = $this->getProductDraft('id', $matched_product_array, $status, $take, $skip, $ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }
        return ['search'=>$search_result,'ids' => $ids];
    }

    public function searchAsId($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $find_variation = ProductVariation::where('id','=',$search_keyword)->get()->first();
        $find_draft = ProductDraft::where('id','=',$search_keyword)->get()->first();
        $search_draft_result = null;
        $matched_product_array = array();
        if ($find_variation != null && $find_draft !=null){
            array_push($matched_product_array,$find_variation->product_draft_id);
            array_push($matched_product_array,$find_draft->id);
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
            array_push($matched_product_array,$find_draft->id);
            $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }

        return ['search'=>$search_result,'ids' => $search_draft_result['ids']];
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

    public function firstPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        if ($status == 'draft' || $status == 'publish') {
            $search_result = ProductDraft::where('name', 'REGEXP', "[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status', $status)
                //            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'ebay_pending'){
            $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where('name', 'REGEXP', "[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])->where('status','publish')
                ->withCount('ProductVariations')
                //            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'onbuy_ean_pending'){
            $exist_ebay_catalogue = OnbuyMasterProduct::select('woo_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where('name', 'REGEXP', "[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                //            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'amazon_ean_pending'){
            $exist_amazon_catalogue = AmazonMasterCatalogue::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where('name', 'REGEXP', "[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->whereNotIn('id',$exist_amazon_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                //            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif($status == 'woocom_pending'){
            $exist_ebay_catalogue = WoocommerceCatalogue::select('master_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where('name', 'REGEXP', "[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                //            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }

    }

    public function secondPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        if ($status == 'draft' || $status == 'publish') {
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->where('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status', $status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'ebay_pending'){
            $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->where('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])->where('status','publish')
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'onbuy_ean_pending'){
            $exist_ebay_catalogue = OnbuyMasterProduct::select('woo_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->where('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'amazon_ean_pending'){
            $exist_amazon_catalogue = AmazonMasterCatalogue::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->where('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_amazon_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif($status == 'woocom_pending'){
            $exist_ebay_catalogue = WoocommerceCatalogue::select('master_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->where('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }
    }

    public function thirdPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        if ($status == 'draft' || $status == 'publish') {
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status', $status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'ebay_pending'){
            $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])->where('status','publish')
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'onbuy_ean_pending'){
            $exist_ebay_catalogue = OnbuyMasterProduct::select('woo_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'amazon_ean_pending'){
            $exist_amazon_catalogue = AmazonMasterCatalogue::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_amazon_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif($status == 'woocom_pending') {
            $exist_ebay_catalogue = WoocommerceCatalogue::select('master_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::where(function ($q) use ($findstring) {
                foreach ($findstring as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();
            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }
    }

    public function getProductDraft($column_name,$word,$status,$take,$skip,$ids){

        if ($status == 'draft' || $status == 'publish') {
            $search_result = ProductDraft::whereIn($column_name, $word)->whereNotIn('id', $ids)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id,name', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id,product_name,master_category_id,product_id','ebayCatalogueInfo' => function($query){
                $query->select(['id','account_id','master_product_id','item_id','product_status'])->with(['AccountInfo:id,account_name,logo']);
            },'amazonCatalogueInfo' => function($amazonCatalogue){
                $amazonCatalogue->select('id','master_product_id','application_id')->with(['applicationInfo' => function($applicationInfo){
                    $applicationInfo->select('id','amazon_account_id','application_name','application_logo','amazon_marketplace_fk_id')->with(['accountInfo:id,account_name,account_logo','marketPlace:id,marketplace']);
                }]);
            }, 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status', $status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();

            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'ebay_pending'){
            $exist_ebay_catalogue = EbayMasterProduct::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::whereIn($column_name, $word)->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])->where('status','publish')
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();

            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif ($status == 'onbuy_ean_pending'){
            $exist_ebay_catalogue = OnbuyMasterProduct::select('woo_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::whereIn($column_name, $word)->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();

            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif($status == 'woocom_pending') {
            $exist_ebay_catalogue = WoocommerceCatalogue::select('master_catalogue_id')->get()->toArray();
            $search_result = ProductDraft::whereIn($column_name, $word)->whereNotIn('id', $ids)->whereNotIn('id',$exist_ebay_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();

            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }elseif($status == 'amazon_ean_pending'){
            $exist_amazon_catalogue = AmazonMasterCatalogue::select('master_product_id')->get()->toArray();
            $search_result = ProductDraft::whereIn($column_name, $word)->whereNotIn('id', $ids)->whereNotIn('id',$exist_amazon_catalogue)->with(['ProductVariations' => function ($query) {
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'onbuy_product_info:id,opc,woo_catalogue_id', 'variations' => function ($query) {
                $query->select(['id', 'product_draft_id'])->with(['order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('id', 'DESC')->skip($skip)->take(10)->get();

            $ids = $search_result->pluck('id');

            return ['search' => $search_result, 'ids' => $ids];
        }
    }

    public function addAdditionalTermsCatalogue($id){
        try {
            // $attribute_info = ProductDraft::find($id);
            $attribute_info = ProductDraft::with(['woocommerce_catalogue_info','onbuy_product_info','ebayCatalogueInfo'])->where('id',$id)->first();
            if($attribute_info) {
                $attribute_terms = Attribute::With(['attributesTerms'])->get();
                $attribute_terms = json_decode(json_encode($attribute_terms));
                $productVariationExist = (($attribute_info->woocommerce_catalogue_info != null) || ($attribute_info->onbuy_product_info != null) || ($attribute_info->ebayCatalogueInfo->count() > 0 )) ? true : false;
                $attribute_info = \Opis\Closure\unserialize($attribute_info->attribute);
                //$productVariationExist = ProductVariation::where('product_draft_id',$id)->first();
                // if($attribute_info->attribute != null) {
                //     $product_attribute = \Opis\Closure\unserialize($attribute_info->attribute);
                // }else{
                //     $product_attribute = null;
                // }
                $existAttr = [];
                if($attribute_info && is_array($attribute_info)){
                    foreach($attribute_info as $attr_id => $attr_value){
                        foreach($attr_value as $attr_name => $value){
                            $existAttr[$attr_id] = $attr_name;
                        }
                    }
                }

                $select_attribute = '';
                $select_attribute_option = '';
                $selected_attribute_option = '';
                $not_selected_attribute_option = '';
                if($attribute_info != null && count($attribute_info) > 0){
                    if($attribute_terms != null && count($attribute_terms) > 0){
                        $select_attribute_option = '<option value="">Select Attribute</option>';
                        foreach ($existAttr as $attr_id => $attr_name) {
                            $attr_id = $attr_id ?? '';
                            $attr_name = $attr_name ?? '';
                            $selected_attribute_option .= '<option value="'.$attr_id.'" selected="selected">'.$attr_name.'</option>';
                        }
                        if(!$productVariationExist){
                            foreach ($attribute_terms as $attribute) {
                                $attribute_id = $attribute->id ?? '';
                                $attribute_name = $attribute->attribute_name ?? '';
                                if(!isset($existAttr[$attribute->id])){
                                    $not_selected_attribute_option .= '<option value="'.$attribute_id.'">'.$attribute_name.'</option>';
                                }
                            }
                        }
                        $all_attribute_terms_option = '';
                        foreach ($attribute_terms as $attribute) {
                            $all_attribute_id = $attribute->id ?? '';
                            $all_attribute_name = $attribute->attribute_name ?? '';
                            $all_attribute_terms_option .= '<option value="'.$all_attribute_id.'">'.$all_attribute_name.'</option>';
                        }
                    }
                }
                if($attribute_info != null && count($attribute_info) > 0){
                    $select_attribute = '<select class="form-control selected_value" multiple disabled>
                        '.$select_attribute_option.'
                        '.$selected_attribute_option.'
                        '.$not_selected_attribute_option.'
                    </select>';
                }else {
                    $select_attribute = '<select class="form-control selected_value" multiple>
                        '.$select_attribute_option.'
                        '.$all_attribute_terms_option.'
                    </select>
                   ';
                }

                $attribute_terms_content = '';
                $not_exist_att_terms_content = '';
                $at_id = '';
                $at_name = '';
                $null_att_info_content = '';
                if($attribute_info != null && count($attribute_info) > 0){
                    foreach ($attribute_info as $attribute_id => $attribute_name_array) {
                        foreach ($attribute_name_array as $attribute_name => $attribute_terms_array) {
                            $attribute_terms_content .= '<div class="input-group m-b-20 attribute-terms-container" id="attribute-terms-container-'.$attribute_id.'">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                <span class="caret"> '.$attribute_name.'</span>
                            </button>
                            <select class="form-control variation-term-select2" name="terms['.$attribute_id.'][]" id="attribute-terms-option-'.$attribute_id.'" multiple="multiple">';
                            if(count($attribute_terms) > 0){
                                foreach($attribute_terms as $all_terms){
                                    if(($all_terms->attribute_name == $attribute_name)  && count($all_terms->attributes_terms) > 0){
                                        if(is_array($attribute_terms_array)){
                                            foreach($attribute_terms_array as $attribute_term){
                                                foreach($all_terms->attributes_terms as $terms){
                                                    $is_array_terms_id = $terms->id ?? '';
                                                    $is_array_terms_name = $terms->terms_name ?? '';
                                                    if($terms->terms_name == $attribute_term['attribute_term_name']){
                                                        $attribute_terms_content .= '<option value="'.$is_array_terms_id.'" selected="selected">'.$is_array_terms_name.'</option>';
                                                    }else{
                                                        $attribute_terms_content .= '<option value="'.$is_array_terms_id.'">'.$is_array_terms_name.'</option>';
                                                    }
                                                }
                                            }
                                        }else{
                                            foreach($all_terms->attributes_terms as $terms){
                                                $is_not_array_terms_id = $terms->id ?? '';
                                                $is_not_array_terms_name = $terms->terms_name ?? '';
                                                if($terms->terms_name == $attribute_terms_array){
                                                    $attribute_terms_content .= '<option value="'.$is_not_array_terms_id.'" selected="selected">'.$is_not_array_terms_name.'</option>';
                                                }else{
                                                    $attribute_terms_content .= '<option value="'.$is_not_array_terms_id.'">'.$is_not_array_terms_name.'</option>';
                                                }
                                            }
                                        }

                                    }
                                }
                            }

                            $attribute_terms_content .= '</select>
                            </div>';
                        }
                    }
                    if(count($attribute_terms) > 0){
                        foreach ($attribute_terms as $all_terms) {
                            if(!isset($existAttr[$all_terms->id])){
                                $not_exist_att_terms_content = '<div class="input-group m-b-20" id="attribute-terms-container-'.$all_terms->id.'" style="display:none;">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">
                                            <span class="caret">'.$all_terms->attribute_name.'</span>
                                        </button>
                                        <select class="form-control select2" name="terms[][]" id="attribute-terms-option-" multiple="multiple">';
                                        foreach ($all_terms->attributes_terms as $terms) {
                                            $not_exist_att_terms_id = $terms->id ?? '';
                                            $not_exist_att_terms_name = $terms->terms_name ?? '';
                                            $not_exist_att_terms_content .= '<option value="'.$not_exist_att_terms_id.'">'.$not_exist_att_terms_name.'</option>';
                                        }
                                        $not_exist_att_terms_content .= '</select>
                                    </div>';
                            }
                        }
                    }
                }else{
                    if(count($attribute_terms) > 0){
                        foreach ($attribute_terms as $attribute_term) {
                            $at_id = $attribute_term->id;
                            $at_name = $attribute_term->attribute_name;
                            if(isset($attribute_info[$at_id][$at_name])){
                                $null_att_info_content = '<div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-'.$attribute_term->id.'">';
                            }else{
                                $null_att_info_content = '<div class="input-group col-md-4 col-sm-6 m-b-20" id="attribute-terms-container-'.$attribute_term->id.'" style="display:none;">';
                            }
                            $null_att_info_content .= '<button type="button" class="btn btn-primary btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret"> '.$attribute_term->attribute_name.' ('.count($attribute_term->attributes_terms).')</span></button>
                                <select class="form-control select2" name="terms['.$attribute_term->id.'][]" id="attribute-terms-option-'.$attribute_term->id.'" multiple="multiple">';
                                foreach ($attribute_term->attributes_terms as $terms) {
                                    $temp = '';
                                    $notinfo_terms_id = $terms->id ?? '';
                                    $notinfo_terms_name = $terms->terms_name ?? '';
                                    if(isset($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name])){
                                        foreach ($attribute_info[$terms->attribute_id][\App\Attribute::find($terms->attribute_id)->attribute_name] as $attributes) {
                                            if($terms->id == $attributes["attribute_term_id"]){
                                                $null_att_info_content .= '<option value="'.$notinfo_terms_id.'" selected="selected">'.$notinfo_terms_name.'</option>';
                                                $temp = 1;
                                            }
                                        }
                                    }
                                    if($temp == null){
                                        $null_att_info_content .= '<option value="'.$notinfo_terms_id.'">'.$notinfo_terms_name.'</option>';
                                    }
                                }
                            $null_att_info_content .= '</select>
                            </div>';
                        }
                    }
                }

                $catalog_terms_modal = '<div class="row" id="sortableAttribute">
                        <div class="input-group col-md-12 col-sm-12 m-b-20 all-attribute-container">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle form-control" data-toggle="dropdown">  <span class="caret">Variation</span></button>
                            '.$select_attribute.'
                            '.$attribute_terms_content.'
                            '.$not_exist_att_terms_content.'
                            '.$null_att_info_content.'
                        </div>
                    </div>';

                return response()->json(['addCatalogTermsModal' => $catalog_terms_modal]);

            }

        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /*
     * Function : addAdditionalTermsDraft
     * Route : add-additional-terms-draft
     * parameters: $id (Catalogue ID)
     * Request : get
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for viewing the adding additional attribute terms page from the master catalogue
     * Created Date: unknown
     * Modified Date : 18-11-2020
     */
    public function addAdditionalTermsDraft($id){
        try {
            $attribute_info = ProductDraft::find($id);
            $attribute_info = ProductDraft::with(['woocommerce_catalogue_info','onbuy_product_info','ebayCatalogueInfo'])->where('id',$id)->first();
            if($attribute_info) {
                $attribute_terms = Attribute::With(['attributesTerms'])->get();
                $attribute_terms = json_decode(json_encode($attribute_terms));
                $productVariationExist = (($attribute_info->woocommerce_catalogue_info != null) || ($attribute_info->onbuy_product_info != null) || ($attribute_info->ebayCatalogueInfo->count() > 0 )) ? true : false;
                $attribute_info = \Opis\Closure\unserialize($attribute_info->attribute);
                //$productVariationExist = ProductVariation::where('product_draft_id',$id)->first();
                // if($attribute_info->attribute != null) {
                //     $product_attribute = \Opis\Closure\unserialize($attribute_info->attribute);
                // }else{
                //     $product_attribute = null;
                // }
                $existAttr = [];
                if($attribute_info && is_array($attribute_info)){
                    foreach($attribute_info as $attr_id => $attr_value){
                        foreach($attr_value as $attr_name => $value){
                            $existAttr[$attr_id] = $attr_name;
                        }
                    }
                }


                // dd($existAttr);
                $content = view('product_draft.add_attribute_terms_draft', compact('attribute_terms', 'attribute_info', 'id','productVariationExist','existAttr'));
                return view('master', compact('content'));
            }
            else{
                return back()->with('error','No Catalogue Found');
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }


    }

    /*
     * Function : saveAdditionalTermsDraft
     * Route : save-additional-terms-draft
     * parameters:
     * Request : post
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for saving additional attribute terms to master catalogue
     * Created Date: unknown
     * Modified Date : 18-11-2020
     */
    public function saveAdditionalTermsDraft(Request $request){
        try {
            $woocommerce_dataSet = array();
            $attribute_array= array();
            $woocommerce_attribute_array= array();
            $attributes_value_array = array();
            $attributes_options_array = array();
            $woocommerce_attributes_value_array = [];
            $woocommerce_attributes_options_array = [];
            $attributes_terms = $request->terms;
            $wmsExistTerms = [];
            $woocommerceExistTerms = [];
            if ($attributes_terms != null) {
                if($request->product_draft_id != null) {
                    foreach ($attributes_terms as $attribute_id => $attribute_terms_array) {
                        $wooAttributeInfo = WoocommerceAttribute::where('master_attribute_id',$attribute_id)->first();
                        foreach ($attribute_terms_array as $attribute_term_id) {
                            if(in_array($attribute_term_id,$wmsExistTerms) === FALSE){
                                $wmsExistTerms[] = $attribute_term_id;
                                $attributes_value_array[$attribute_id][Attribute::find($attribute_id)->attribute_name][] = [
                                    "attribute_term_id" => $attribute_term_id ?? '',
                                    "attribute_term_name" => AttributeTerm::find($attribute_term_id)->terms_name ?? ''
                                ];
                            }

                            if(Session::get('woocommerce') == 1){
                            $woocommerceStatus = WoocommerceAccount::where('status',1)->first();
                                if($woocommerceStatus && $wooAttributeInfo){
                                    $woocomerce_terms = WoocommerceAttributeTerm::where('master_terms_id',$attribute_term_id)->first();
                                    if($woocomerce_terms){
                                        if(!in_array($woocomerce_terms->id,$woocommerceExistTerms)){
                                            $woocommerceExistTerms[] = $woocomerce_terms->id;
                                            $woocommerce_attributes_value_array[$wooAttributeInfo->id][ $wooAttributeInfo->attribute_name][] = [
                                                "attribute_term_id" => $woocomerce_terms->id ?? '',
                                                "attribute_term_name" => $woocomerce_terms->terms_name ?? ''
                                            ];
                                        }

                                    }
                                }
                            }
                        }
                        if(Session::get('woocommerce') == 1){
                            $woocommerceStatus = WoocommerceAccount::where('status',1)->first();
                            if($woocommerceStatus){
                                $woo_attributes_value_array['id'] = $wooAttributeInfo->id;
                                $woo_attributes_value_array['variation'] = true;
                                $woo_attributes_value_array['visible'] = true;
                            }
                        }
                        foreach ($attribute_terms_array as $value) {
                            $attributes_terms_name = AttributeTerm::where('id', $value)->first()->terms_name;
                            array_push($attributes_options_array, $attributes_terms_name);
                            $woocommerce_attributes_terms_info = WoocommerceAttributeTerm::where('master_terms_id', $value)->first();
                            if($woocommerce_attributes_terms_info){
                                array_push($woocommerce_attributes_options_array, $woocommerce_attributes_terms_info->terms_name);
                            }
                        }
                        $woo_attributes_value_array['options'] = $woocommerce_attributes_options_array;
                        array_push($woocommerce_attribute_array, $woo_attributes_value_array);
                        $attributes_options_array = (array)null;
                        $woocommerce_attributes_options_array = (array)null;
                    }
                    if(Session::get('woocommerce') == 1){
                        $woocommerce_status = WoocommerceAccount::where('status', 1)->first();
                        if ($woocommerce_status) {
                            $woocommerce_dataSet['attributes'] = $woocommerce_attribute_array;
                            $woo_master_id = WoocommerceCatalogue::where('master_catalogue_id', $request->product_draft_id)->first();
                            if ($woo_master_id) {
                                try {
                                    $product = Woocommerce::put('products/' . $woo_master_id->id, $woocommerce_dataSet);
                                } catch (HttpClientException $exception) {

                                    return back()->with('error', $exception->getMessage());
                                }
                                $woocommerce_attribute = \Opis\Closure\serialize($woocommerce_attributes_value_array);
                                $woo_update_result = WoocommerceCatalogue::find($woo_master_id->id);
                                $woo_update_result->attribute = $woocommerce_attribute;
                                $woo_update_result->save();
                            }
                        }
                    }
                }
                $attribute = \Opis\Closure\serialize($attributes_value_array);
                $update_result = ProductDraft::find($request->product_draft_id);
                $update_result->attribute = $attribute;
                $update_result->save();
                return back()->with('success_message', 'New variation terms added successfully')->with('product_draft_id', $request->product_draft_id);
            }else{
                return back()->with('error','Please select attribute terms');
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function duplicateDraftCatalogue($id){
//        return $id;
        $attribute_info = ProductDraft::where('id',$id)->get();
//        $categories = Category::get();

        $categories = WooWmsCategory::get();
        $conditions = Condition::all();
        $brands = Brand::get();
        $genders = Gender::get();
        $product_variation = ProductVariation::where('product_draft_id',$id)->get()->first();
        $product_draft = ProductDraft::with(['all_category'])->find($id);
        $attribute_terms = Attribute::With(['attributesTerms'])->get();
        $attribute_terms = json_decode(json_encode($attribute_terms));
        $attribute_info = \Opis\Closure\unserialize($attribute_info[0]->attribute);

        // echo "<pre>";
        // print_r($attribute_info[5]["Size"]);
        // exit();
        $tabAttributeInfo = $this->getCatalogueTabAttribute($product_draft->woowms_category, $id);
        $content = view('product_draft.duplicate_draft_catalogue',compact('categories','attribute_terms','product_draft','attribute_info','conditions','brands','genders','product_variation','tabAttributeInfo'));
        return view('master', compact('content'));
    }

    public function searchCatalogueByDate(Request $request){
        if($request->status == 'draft' || $request->status == 'publish'){
            $data_arr = [];
            array_push($data_arr,$request->status);
        }else{
            $data_arr = $request->status;
        }
        $operator = ($request->search_date == 'outofstock') ? '=' : '>';
        $search_result = ProductDraft::with(['ProductVariations' => function($query) use ($request, $operator){
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->when(is_numeric($request->search_date) == FALSE,function($q)use ($operator){
                    $q->havingRaw('SUM(product_variation.actual_quantity)'.$operator.'0');
                })
                ->groupBy('product_draft_id');
        },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','catalogueVariation' => function($query){
            $query->with(['shelf_quantity', 'order_products' => function ($query) {
                $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')
            ->whereIn('status',$data_arr)
            ->when(is_numeric($request->search_date) == TRUE,function($q) use ($request){
                $q->whereDate('created_at', '>', Carbon::now()->subDays($request->search_date));
            })
            ->orderBy('id','DESC')->paginate(500);
//        $search_result = json_decode($search_result);
        $status = $request->status;
        $date = $request->search_date;
        $content = view('product_draft.search_product_list',compact('search_result','status','date'))->render();
        return response()->json(['data' => $content, 'total_row' => count($search_result)]);
//        echo $search_catalogue_info;
//        echo "<pre>";
//        print_r($search_result);
//        exit();
    }

    public function uploadCSV(Request $request){

        $file = $request->file('csv_file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)) {

            // Check file size
            if ($fileSize <= $maxFileSize) {

                // File upload location
                $location = 'csv';

                // Upload file
                $file->move($location, $filename);

                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    // Skip first row (Remove below comment if you want to skip the first row)
                    if($i == 0){
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata [$c];
                    }
                    $i++;
                }
                fclose($file);
//                dd($importData_arr)

                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    $insertData = ProductDraft::updateOrCreate([
                        'name' => $importData[2]
                    ],[
                        'user_id' => $importData[0],
                        'modifier_id' => $importData[1],
                        'name' => $importData[2],
                        'type' => $importData[3],
                        'description' => $importData[4],
                        'short_description' => $importData[5],
                        'regular_price' => $importData[6],
                        'sale_price' => $importData[7],
                        'cost_price' => $importData[8],
                        'product_code' => $importData[9],
                        'color_code' => $importData[10],
                        'low_quantity' => $importData[11],
                        'status'=> $importData[12],
                        'created_at' => $importData[13],
                        'updated_at' => $importData[14],
                        'deleted_at' => $importData[15],
                        'brand_id' => $importData[16],
                        'gender_id' => $importData[17],
                    ]);

//                    Page::insertData($insertData);
                }
            }
        }
        return back()->with('success','CSV file uploaded successfully');

//        $file = file($request->csv_file->getRealPath());
//        $data = array_slice($file,1);
//        $parts = (array_chunk($data,500));
//        foreach ($parts as $index => $part){
//            $filename = public_path('csv/'.date('y-m-d-H-i-s').$index.'.csv');
//            file_put_contents($filename,$part);
//        }
//        $path = public_path('csv/*.csv');
//        $g = glob($path);
//        foreach (array_slice($g,0,1) as $file){
//            $data = array_map('str_getcsv',file($file));
//            foreach ($data as $row){
//                $up = CsvUser::create([
//                    'name' => $row[0],
//                    'email' => $row[1],
//                    'password' => $row[2]
//                ]);
////                dd($row);
//            }
//        }
    }


    /*
     * Function : columnSearch
     * Route Type : {route_name}/catalogue/search
     * Method Type : Post
     * Parameters : null
     * Creator : Kazol
     * Creating Date : 02/02/2021
     * Description : This function is used for eBay Active product individual column search
     * Modifier : Solaiman
     * Modified Date : 03-02-2021, 13-02-2021
     * Modified Content :
     */


    public function columnSearch(Request $request){

        // Screen option and Pagination
        $shelf_use = $this->shelf_use;
        $settingData = $this->paginationSetting('', '');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        $woocommerceSiteUrl = WoocommerceAccount::first();

//        $column = Input::get('search_column');
//        $value = str_replace('%20',' ',Input::get('value'));
//        $opt_out = Input::get('opt_out');

        $column = $request->column_name;
        $value = $request->search_value;

        $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
            $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        },'catalogueVariation' => function($query){
            $query->with(['shelf_quantity', 'order_products' => function ($query) {
                $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')
            ->orderBy('id','DESC')
            ->where('status',$request->status)
            ->where(function($query) use($request,$column,$value){
                if($column == 'id'){
                    if($request->opt_out == 1){
                        $query->where($column,'!=',$value);
                    }else{
                        $query->where($column, $value);
                    }
                }elseif($column == 'name'){
                    if($request->opt_out == 1){
                        $query->where($column,'NOT LIKE', '%' . $value . '%');
                    }else{
                        $query->where($column,'like', '%' . $value. '%');
                    }
                }
                elseif($column == 'woowms_category'){
                    $category_info = WooWmsCategory::where('category_name',$value)->first();
                    $value = $category_info->id;
                    if($request->opt_out == 1){
                        $query->where($column,'!=',$value);
                    }else{
                        $query->where($column,'like', '%' . $value. '%');
                    }
                }
                elseif ($column == 'rrp' || $column == 'base_price'){
                    $aggregate_value = $request->aggregate_condition;
                    if($request->opt_out == 1){
                        $query->where($column, '!=', '$value');
                    }else{
                        $query->where($column, $aggregate_value,$value);
                    }
                }elseif($column == 'sold'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_orders.quantity) sold'))
                        ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->join('product_orders','product_variation.id','=','product_orders.variation_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null],['product_orders.deleted_at',null]])
                        ->havingRaw('sum(product_orders.quantity)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'stock'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_variation.actual_quantity) stock'))
                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
                        ->havingRaw('sum(product_variation.actual_quantity)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'product'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('count(product_variation.id) product'))
                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
                        ->havingRaw('count(product_variation.id)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'creator'){
                    if($request->opt_out == 1){
                        $query->where('user_id','!=',$request->user_id);
                    }else{
                        $query->where('user_id',$request->user_id);
                    }
                }elseif($column == 'modifier_id'){
                    $modifier_id_query = ProductDraft::select('product_drafts.id')
                        ->leftJoin('users', 'product_drafts.modifier_id', '=', 'users.id')
                        ->where('modifier_id', $value)
                        ->groupBy('product_drafts.id')
                        ->get();

                    $ids = [];
                    foreach ($modifier_id_query as $modifier_id){
                        $ids[] = $modifier_id->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }

                }elseif($column == "channel"){
                    $ids = array();


                    foreach ($value as $channel){

                        if ($channel == "woocommerce"){
                            //$ids =  WoocommerceCatalogue::select('master_catalogue_id as id' )->get()->pluck('id');
                            $ids =  WoocommerceCatalogue::select('master_catalogue_id as id' )->get()->pluck('id')->toArray();

                        }
                        elseif ($channel == "onbuy"){
                            $temp = OnbuyMasterProduct::select('woo_catalogue_id as id')->get()->pluck('id')->toArray();

                            $ids = array_merge($ids,$temp);

                        }
                        elseif ($channel != "onbuy" || $channel != "woocommerce"){
                            $temp = EbayMasterProduct::select('master_product_id as id')->where('account_id',$channel)->get()->pluck('id')->toArray();
                            $ids = array_merge($ids,$temp);
                        }
                    }
                    if ($request->opt_out){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }


                }

            })
            ->paginate(500);
        $wooChannel = WoocommerceAccount::get()->all();
        $onbuyChannel = OnbuyAccount::get()->all();
        $ebayChannel = EbayAccount::get()->all();
        $channels = array();
        $temp = array();
        foreach ($wooChannel as $woo){
            $channels["woocommerce"] = "woocommerce";
        }

        foreach ($onbuyChannel as $onbuy){
            $channels["onbuy"] = "onbuy";
        }
        foreach ($ebayChannel as $ebay){
            $temp[$ebay->id] = $ebay->account_name;
        }
        $channels["ebay"] = $temp;
        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $ids = [];
        if(count($product_drafts) > 0){
            foreach ($product_drafts as $result){
                array_push($ids,$result);
            }
        }else{
            if($request->status == 'publish'){
                return redirect('completed-catalogue-list')->with('no_data_found','No data found');
            }elseif($request->status == 'draft'){
                return redirect('draft-catalogue-list')->with('no_data_found','No data found');
            }
        }


        $users = User::orderBy('name', 'ASC')->get();
        $product_drafts_info = json_decode(json_encode($product_drafts));
        $total_product_drafts = ProductDraft::count();
        $content = view('product_draft.complete_catalogue_list',compact('product_drafts','total_product_drafts','product_drafts_info','setting','value','users', 'page_title', 'pagination', 'shelf_use','woocommerceSiteUrl','channels'));
        return view('master',compact('content'));
    }

    /*
     * Function : draftCatalogueList
     * Route : draft-catalogue-list
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol, Solaiman
     * Description : This function is used for displaying draft master catalogue
     * Created Date: unknown
     * Modified Date : 24-11-2020, 1-12-2020, 28-12-202
     * Modified Content : Setting information change, Pagination setting
     */

    public function draftCatalogueList(Request $request){
        // try {
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
            //Start page title and pagination setting
            $shelf_use = $this->shelf_use;
            $settingData = $this->paginationSetting('catalogue', 'draft_catalogue');
            $setting = $settingData['setting'];
            $page_title = '';
            $see_more = 0;
            $pagination = $settingData['pagination'];
            //End page title and pagination setting



            $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
                $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                    $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            },'catalogueVariation' => function($query){
                $query->with(['shelf_quantity', 'order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
                ->withCount('ProductVariations')
                ->where('status','draft');
                $isSearch = $request->get('is_search') ? true : false;
                $allCondition = [];
                if($isSearch){
                    $this->masterCatalogueSearchCondition($product_drafts, $request);
                    $allCondition = $this->masterCatalogueSearchParams($request, $allCondition);

                    //dd($allCondition);
                }
                $product_drafts = $product_drafts->orderBy('id','DESC')->paginate($pagination);
            if($request->has('is_clear_filter')){
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
                $woocommerceSiteUrl = WoocommerceAccount::first();
                $search_result = $product_drafts;
                $view = view('product_draft.search_product_list', compact('search_result', 'status', 'date','woocommerceSiteUrl'))->render();
                return response()->json(['html' => $view]);
            }
            $users = User::orderBy('name', 'ASC')->get();
            $product_drafts_info = json_decode(json_encode($product_drafts));
            $total_product_drafts = ProductDraft::where('status','draft')->count();
            $content = view('product_draft.product_draft_list',compact('product_drafts','total_product_drafts','product_drafts_info','setting','pagination','users','see_more','shelf_use','allCondition','url'));
            return view('master',compact('content','page_title'));
        // }catch (\Exception $exception){
        //     return redirect('exception')->with('exception',$exception->getMessage());
        // }
    }


    /*
     * Function : paginationSetting
     * Route Type : null
     * Parameters : null
     * Creator : Solaiman
     * Description : This function is used for pagination setting
     * Created Date : 1-12-2020
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




    public function draftMakeComplete(Request $request){
        $update_info = ProductDraft::find($request->catalogue_id)->update([
            'status' => 'publish'
        ]);
        return back()->with('success','Draft catalogue completed successfully');
    }

    /*
     * Function : genderCategory
     * Route : gender-category
     * Method Type : POST (ajax call)
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for displaying wms category when select dropdown
     * Created Date: unknown
     * Modified Date : 25-11-2020
     * Modified Content : isset check and error handle
     */
    public function genderCategory(Request $request){
        try {
            // $category_info = Gender::select('id','name')->with(['genders' => function($query){
            //     $query->select('wms_category_id as id','category_name');
            // }])->where('id',$request->gender_id)->first();
            $itemProfileList = $this->itemProfileList();
            $categoryInfo = $this->getCatalogueTabAttribute($request->category_id);
            return response()->json(['type' => 'success', 'data' => $categoryInfo,'itemProfileList' => $itemProfileList]);
        }catch (\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function bulkDraftCatalgueComplete(Request $request){
        try {
            $catalogueIds = $request->catalogueIDs;
            $catalogueUpdateInfo = ProductDraft::whereIn('id',$catalogueIds)->update(['status' => 'publish']);
            return response()->json('success');
        }catch (\Exception $exception){
            return response()->json('error');
        }
    }


    public function attributeNewFormate(){
//        $catalogue_info = ProductDraft::skip(3000)->take(500)->get();
//        $i = 3000;
//        $j = 3000;
//        foreach ($catalogue_info as $info){
//            $catalogue_attribute = AttributeTermProductDraft::select('attribute_id')->with(['attribute' => function($query) use ($info){
//                $query->with(['terms_ids' => function($query) use ($info){
//                    $query->with('terms_info')->where('product_draft_id',$info->id);
//                }]);
//            }])->where('product_draft_id',$info->id)->groupBy('attribute_id')->get();
//            $att_arr = [];
//            if(count($catalogue_attribute) > 0) {
//                foreach ($catalogue_attribute as $attribute) {
//                    $term = [];
//                    foreach ($attribute->attribute->terms_ids as $terms) {
//                        $term [] = [
//                            'attribute_term_id' => $terms->terms_info->id,
//                            'attribute_term_name' => $terms->terms_info->terms_name
//                        ];
//                    }
////                echo '<pre>';
////                print_r($term);
////                exit();
//                    $att_arr[$attribute->attribute_id] = [
//                        $attribute->attribute->attribute_name => $term ?? null
//                    ];
//                }
////            echo '<pre>';
////            print_r($att_arr);
////            exit();
////                $all_att_arr[] = $att_arr;
//                $attribute_array = \Opis\Closure\serialize($att_arr);
//                $update_info = ProductDraft::find($info->id)->update([
//                    'attribute' => $attribute_array
//                ]);
//                $i++;
//            }
//            $j++;
//        }
//        return $i.'/'.$j;
//        echo '<pre>';
//        print_r($all_att_arr);
//        exit();


        $pick_variation_info = ProductVariation::skip(5000)->take(5000)->get();
        $i = 5000;
        $j = 0;
        foreach ($pick_variation_info as $variation){
            $formate_arr = [];
            if($variation->attribute1) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute1)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 5,
                        'attribute_name' => Attribute::find(5)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute2) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute2)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 6,
                        'attribute_name' => Attribute::find(6)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute3) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute3)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 7,
                        'attribute_name' => Attribute::find(7)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute4) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute4)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 8,
                        'attribute_name' => Attribute::find(8)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute5) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute5)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 9,
                        'attribute_name' => Attribute::find(9)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute6) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute6)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 10,
                        'attribute_name' => Attribute::find(10)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute7) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute7)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 11,
                        'attribute_name' => Attribute::find(11)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute8) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute8)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 12,
                        'attribute_name' => Attribute::find(12)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute9) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute9)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 13,
                        'attribute_name' => Attribute::find(13)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
            if($variation->attribute10) {
                $terms_info = AttributeTerm::where('terms_name',$variation->attribute10)->first();
                if($terms_info) {
                    $formate_arr[] = [
                        'attribute_id' => 14,
                        'attribute_name' => Attribute::find(14)->attribute_name,
                        'terms_id' => $terms_info->id,
                        'terms_name' => $terms_info->terms_name
                    ];
                }
            }
//            echo '<pre>';
//            print_r($formate_arr);
//            exit();
            $i++;
//            $attribute_array = \Opis\Closure\serialize($formate_arr);
//            $update_info = ProductVariation::find($variation->id)->update([
//                'attribute' => $attribute_array
//            ]);
            $all_formate_ar[] = $formate_arr;
//            echo '<pre>';
//            print_r($formate_arr);
//            exit();
        }
//        return $i++;
        echo '<pre>';
        print_r($all_formate_ar);
        exit();
    }

    // restore function start

    public function masterCatalogueBulkRestore(Request $request){
        // return response()->json($request->all());
            // echo '<pre>';
            // print_r($request);
            // exit();
            $masterCatalogueIdsArray = $request->masterCatalogueIds;

            foreach($masterCatalogueIdsArray as $masterId){
                // $catalogue_info = ProductDraft::find($masterId);
            //     if(count($catalogue_info->ProductVariations) > 0) {
            //     foreach ($catalogue_info->ProductVariations as $variation) {
            //         $restore_attribute = ProductVariation::withTrashed()->where('id', $variation->id)->restore();
            //     }
            // }
                $catalogue_info = ProductDraft::withTrashed()->where('id', $masterId)->restore();

            }
            return response()->json($catalogue_info);

            return response()->json(['type' => 'success', 'msg' => 'Catalogue Successfully Restore']);
    }

    public function masterCatalogueBulkDelete(Request $request){
        try {
            $woocommerceIdsArray = [];
            $ebayIdsArray = [];
            $onbuyIdsArray = [];
            $masterCatalogueIdsArray = $request->masterCatalogueIds;

            $woocommerceExceptionMsg = '';
            try {
                $wooAccInfo = WoocommerceAccount::where('status',1)->first();
                if($wooAccInfo){
                    $woocommerce_consumer_key = Session::get('woocommerce_consumer_key');
                    $woocommerce_secret_key = Session::get('woocommerce_secret_key');
                    if($woocommerce_consumer_key == '' && $woocommerce_secret_key == ''){
                        $woocommerce_consumer_key = $wooAccInfo->consumer_key ?? '';
                        $woocommerce_secret_key = $wooAccInfo->secret_key ?? '';
                        Session::put('woocommerce_consumer_key',$wooAccInfo->consumer_key);
                        Session::put('woocommerce_secret_key',$wooAccInfo->secret_key);
                    }

                    if($woocommerce_consumer_key != '' && $woocommerce_secret_key != '') {
                        $woocommerce_catalogue_ids = WoocommerceCatalogue::whereIn('master_catalogue_id', $masterCatalogueIdsArray)->pluck('id')->toArray();
                        if (count($woocommerce_catalogue_ids) > 0) {
                            $data = [
                                'delete' => $woocommerce_catalogue_ids
                            ];
                            // Woocommerce::delete('products/' . $woocommerce_catalogue_info->id);
                            Woocommerce::post('products/batch',$data);
                            foreach($woocommerce_catalogue_ids as $catalogueId){
                                $woocommerce_catalogue_info = WoocommerceCatalogue::find($catalogueId);
                                DB::transaction(function () use ($catalogueId,$woocommerce_catalogue_info) {
                                    $woocommerce_catalogue_info->variations()->delete();
                                    $woocommerceImage = WoocommerceImage::where('woo_master_catalogue_id',$catalogueId)->get();
                                    if(count($woocommerceImage) > 0){
                                        WoocommerceImage::where('woo_master_catalogue_id',$catalogueId)->delete();
                                    }
                                    $woocommerce_catalogue_info->delete();
                                });
                            }
                        }
                    }
                }
            }catch (\Exception $exception){
                $woocommerceExceptionMsg = '('. $exception->getMessage() .')';
            }

            $onbuyExceptionMsg = '';
            try {
                $onbuyAccInfo = OnbuyAccount::where('status',1)->first();
                if($onbuyAccInfo) {
                    $onbuy_consumer_key = Session::get('onbuy_consumer_key');
                    $onbuy_secret_key = Session::get('onbuy_secret_key');
                    if($onbuy_consumer_key == '' && $onbuy_secret_key == ''){
                        Session::put('onbuy_consumer_key', $onbuyAccInfo->consumer_key);
                        Session::put('onbuy_secret_key', $onbuyAccInfo->secret_key);
                        $onbuy_consumer_key = $onbuyAccInfo->consumer_key;
                        $onbuy_secret_key = $onbuyAccInfo->secret_key;
                    }

                    if($onbuy_consumer_key != '' && $onbuy_secret_key != ''){
                        $onbuy_catalogue_ids = OnbuyMasterProduct::whereIn('woo_catalogue_id', $masterCatalogueIdsArray)->pluck('id')->toArray();
                        if(count($onbuy_catalogue_ids) > 0){
                            $skus = OnbuyVariationProducts::whereIn('master_product_id',$onbuy_catalogue_ids)->pluck('sku')->toArray();
                            if(count($skus) > 0) {
                                $access_token = $this->access_token();
                                if($access_token != '') {
                                    $data = [
                                        "site_id" => 2000,
                                        "skus" => $skus
                                    ];
                                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                                    $post_data = json_encode($data, JSON_PRETTY_PRINT);
                                    $method = "DELETE";
                                    $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                                    $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);

                                    $result_info = json_decode($result_info);
                                    if (isset($result_info->results)) {
                                        foreach($onbuy_catalogue_ids as $id){
                                            $master = OnbuyMasterProduct::find($id);
                                            if($master) {
                                                $master->variation_product()->delete();
                                                $master_del = OnbuyMasterProduct::find($id)->delete();
                                            }
                                        }
                                    }
                                }
                            }else{
                                $master = OnbuyMasterProduct::whereIn($onbuy_catalogue_ids)->delete();
                            }
                        }
                    }
                }
            }catch (\Exception $exception){
                $onbuyExceptionMsg = '('. $exception->getMessage() .')';
            }

            $ebayExceptionMsg = '';
            try{
                $ebayDeveloperAccountInfo = DeveloperAccount::where('status',1)->first();
                if($ebayDeveloperAccountInfo) {
                    $ebay_client_id = Session::get('ebay_client_id');
                    $ebay_client_secret = Session::get('ebay_client_secret');
                    if($ebay_client_id == '' && $ebay_client_secret == ''){
                        Session::put('ebay_client_id', $ebayDeveloperAccountInfo->client_id);
                        Session::put('ebay_client_secret', $ebayDeveloperAccountInfo->client_secret);
                        $ebay_client_id = $ebayDeveloperAccountInfo->client_id;
                        $ebay_client_secret = $ebayDeveloperAccountInfo->client_secret;
                    }
                    if($ebay_client_id != '' && $ebay_client_secret != '') {
                        // $ebay_master_ids = EbayMasterProduct::whereIn('master_product_id', $masterCatalogueIdsArray)->groupBy('account_id')->pluck('id')->toArray();
                        $ebay_master_info = EbayMasterProduct::select('id','account_id')->whereIn('master_product_id', $masterCatalogueIdsArray)->get();
                        $ebayMasterIds = [];
                        if(count($ebay_master_info) > 0){
                            foreach($ebay_master_info as $info){
                                if(!array_key_exists($info->account_id,$ebayMasterIds)){
                                    $ebayMasterIds[$info->account_id] = [$info->id];
                                }
                                else{
                                    array_push($ebayMasterIds[$info->account_id],$info->id);
                                }
                            }
                            if(count($ebayMasterIds) > 0) {
                                foreach ($ebayMasterIds as $account_id => $ebay_master_id) {
                                    $ebay_access_token = $this->getAuthorizationToken($account_id);
                                    if ($ebay_access_token != '') {
                                        $ebayMasterCatalogueInfo = EbayMasterProduct::whereIn('id',$ebay_master_id)->get();
                                        foreach($ebayMasterCatalogueInfo as $catalogueInfo){
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                            <EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                                <ErrorLanguage>en_US</ErrorLanguage>
                                                <WarningLevel>High</WarningLevel>
                                                <!-- Enter the ItemID you wantto end-->
                                            <ItemID>' . $catalogueInfo->item_id . '</ItemID>
                                            <EndingReason>NotAvailable</EndingReason>
                                            </EndFixedPriceItemRequest>';
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:' . $catalogueInfo->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:EndFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:' . $ebay_access_token,

                                            ];
                                            $result = $this->curl($url, $headers, $body, 'POST');
                                            $result = simplexml_load_string($result);
                                            $result = json_decode(json_encode($result), true);

                                            if ($result['Ack'] == 'Success') {
                                                $ebay_master_product = EbayMasterProduct::find($catalogueInfo->id);
                                                if($ebay_master_product) {
                                                    $ebay_master_product->variationProducts()->delete();
                                                    EbayMasterProduct::destroy($catalogueInfo->id);
                                                }
                                            } else {
                                                $ebay_master_product = EbayMasterProduct::find($catalogueInfo->id);
                                                if($ebay_master_product) {
                                                    $ebay_master_product->variationProducts()->delete();
                                                    EbayMasterProduct::destroy($catalogueInfo->id);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            catch (\Exception $exception){
                $ebayExceptionMsg = '('. $exception->getMessage() .')';
            }

            DB::transaction(function () use ($masterCatalogueIdsArray) {
                foreach($masterCatalogueIdsArray as $masterId){
                    $catalogue_info = ProductDraft::find($masterId);
                    if(count($catalogue_info->ProductVariations) > 0) {
                        foreach ($catalogue_info->ProductVariations as $variation) {
                            $del = ShelfedProduct::where('variation_id', $variation->id)->delete();
                        }
                    }
                    $catalogue_info->ProductVariations()->delete();
                    $masterImage = Image::where('draft_product_id',$catalogue_info->id)->get();
                    if(count($masterImage) > 0){
                        Image::where('draft_product_id',$catalogue_info->id)->delete();
                    }
                    $catalogue_info->delete();
                }
            });
            // return back()->with('success', 'Catalogue Successfully Deleted'. $ebayExceptionMsg . $woocommerceExceptionMsg .$onbuyExceptionMsg);
            return response()->json(['type' => 'success', 'msg' => 'Catalogue Successfully Deleted'. $ebayExceptionMsg . $woocommerceExceptionMsg .$onbuyExceptionMsg]);
        }catch(\Exception $ex){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong.']);
        }
    }

    public function masterCatalogueExistCheck(Request $request){

        if(isset($request->id)){
            $updateIsCatalogurExist = ProductDraft::select('name')->where('name',$request->title)->where('id','!=',$request->id)->first();
        }else{
            $updateIsCatalogurExist = ProductDraft::select('name')->where('name',$request->title)->first();
        }

        if($updateIsCatalogurExist){
            return response()->json(['type' => 1]);
        }else{
            return response()->json(['type' => 2]);
        }
    }

    public function reports(){
        try{
            $wooChannel = WoocommerceAccount::get()->all();
            $onbuyChannel = OnbuyAccount::get()->all();
            $ebayChannel = EbayAccount::get()->all();
            $amazonChannel = AmazonAccountApplication::with(['accountInfo','marketPlace'])->get();
            $channels = [];
            $temp = [];
            $wooTemp = [];
            $onbuyTemp = [];
            $amazonTemp = [];
            foreach ($wooChannel as $woo){
                $wooTemp[$woo->id] = $woo->account_name;
            }
            foreach ($onbuyChannel as $onbuy){
                $onbuyTemp[$onbuy->id] = $onbuy->account_name;
            }
            foreach ($ebayChannel as $ebay){
                $temp[$ebay->id] = $ebay->account_name;
            }
            if(count($amazonChannel) > 0){
                foreach($amazonChannel as $amazon){
                    $amazonTemp[$amazon->id] = $amazon->accountInfo->account_name;
                }
            }
            $channels["ebay"] = $temp;
            $channels["website"] = $wooTemp;
            $channels["onbuy"] = $onbuyTemp;
            $channels["amazon"] = $amazonTemp;

            $wmsCategoryLists = WooWmsCategory::select('id','category_name')->get();

            $content = view('reports.report',compact('channels','wmsCategoryLists'));
            return view('master',compact('content'));
        }catch(\Exception $ex){

        }
    }

    public function exportCatalogueCsv(Request $request){
        try{
            $catalogueLists = ProductDraft::select('id','name','cost_price','sale_price','regular_price','status','type')->with(['ProductVariations' => function($query){
                $query->select('id','product_draft_id','sku','actual_quantity')->with(['shelf_quantity' => function($query2){
                    $query2->wherePivot('quantity','>',0);
                }]);
            },'variations' => function($variation){
                $variation->select('id','product_draft_id','actual_quantity')->where('actual_quantity','>',0);
            },'onbuy_product_info:id,woo_catalogue_id','woocommerce_catalogue_info:id,master_catalogue_id','ebayCatalogueInfo' => function($ebay){
                $ebay->select('id','account_id','category_id','condition_id','master_product_id')->with(['AccountInfo:id,account_name']);
            },'amazonCatalogueInfo' => function($amazon){
                $amazon->select('id','application_id','category_id','condition_id','master_product_id')->with(['applicationInfo' => function($application){
                    $application->select('id','amazon_account_id','amazon_marketplace_fk_id')->with(['accountInfo:id,account_name']);
                }]);
            },'woowmsCategory']);
            $this->exportCatalogueCsvQuery($catalogueLists, $request);
            $catalogueLists = $catalogueLists->get();
            if(count($catalogueLists) > 0){
                $filename = "catalogue.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, ['ID','TITLE','SKU','AVAILABLE QUANTITY','SHELF QUANTITY','CHANNEL','STATUS','TYPE','CATEGORY','AVAILABILITY','COST PRICE','SALES PRICE','REGULAR PRICEC']);
                $saveCsvValue = '';
                foreach($catalogueLists as $catalogue){
                    $channels = '';
                    if(count($catalogue->ebayCatalogueInfo) > 0){
                        foreach($catalogue->ebayCatalogueInfo as $ebay){
                            $channels .= $ebay->AccountInfo->account_name.'(ebay),';
                        }
                    }
                    if($catalogue->woocommerce_catalogue_info){
                        $channels .= 'website,';
                    }
                    if($catalogue->onbuy_product_info){
                        $channels .= 'onbuy,';
                    }
                    if(count($catalogue->amazonCatalogueInfo) > 0){
                        foreach($catalogue->amazonCatalogueInfo as $amazon){
                            $channels .= $amazon->applicationInfo->accountInfo->account_name.'(amazon),';
                        }
                    }
                    foreach($catalogue->ProductVariations as $variation){
                        $shelfQuantity = 0;
                        if(count($variation->shelf_quantity) > 0){
                            foreach($variation->shelf_quantity as $shelf){
                                $shelfQuantity += $shelf->pivot->quantity;
                            }
                        }
                        $alreadyPutInCsv = ($catalogue->id != $saveCsvValue) ? true : false;
                        fputcsv($handle, [$alreadyPutInCsv ? $catalogue->id : '', $catalogue->name ?? '', $variation->sku ?? '', $variation->actual_quantity ?? '', $shelfQuantity, $alreadyPutInCsv ? rtrim($channels,',') : '',
                        $alreadyPutInCsv ? (($catalogue->status == 'publish') ? 'Active' : 'Draft') : '', $alreadyPutInCsv ? ($catalogue->type ?? '') : '', $alreadyPutInCsv ? ($catalogue->woowmsCategory->category_name ?? '') : '', $alreadyPutInCsv ? ((count($catalogue->variations) > 0) ? 'Instock' : 'Out Of Stock' ) : '', $alreadyPutInCsv ? $catalogue->cost_price : '',
                        $alreadyPutInCsv ? $catalogue->sale_price : '', $alreadyPutInCsv ? $catalogue->regular_price : '']);
                        $saveCsvValue = $catalogue->id;
                    }
                    $saveCsvValue = '';
                }
                fclose($handle);
                $headers = array(
                    'Content-Type' => 'text/csv',
                );
                return response()->json(['type' => 'success', 'url' => asset('/').$filename, 'file_name' => $filename]);
            }else{
                return response()->json(['type' => 'error', 'message' => 'No Catalogue Found']);
            }
        }catch(\Exception $ex){
            return response()->json(['type' => 'error', 'message' => 'Something Went Wrong']);
        }
    }

    public function getCatalogue(Request $request){
        $skip = $request->page * 100;
        $searchValue = $request->searchTerm;
        if(is_numeric($searchValue)){
            $draftIds = ProductVariation::orWhere('id',$searchValue)
            ->orWhere('product_draft_id',$searchValue)
            ->orWhere('ean_no',$searchValue)
            ->pluck('product_draft_id')
            ->toArray();
        }elseif(strpos($searchValue," ") != null){
            $draftIds = ProductDraft::where(function ($q) use ($searchValue) {
                foreach (explode(' ',$searchValue) as $value) {
                    $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                }
            })
            ->pluck('id')->toArray();
        }else{
            $draftIds = ProductVariation::where('sku',$searchValue)
            ->pluck('product_draft_id')
            ->toArray();
            if(count($draftIds) == 0){
                $draftIds = ProductDraft::where(function ($q) use ($searchValue) {
                    foreach (explode(' ',$searchValue) as $value) {
                        $q->orWhere('name', 'REGEXP', "[[:<:]]{$value}[[:>:]]");
                    }
                })
                ->pluck('id')->toArray();
            }
        }
        $catalogues = ProductDraft::select('id','name')->with(['ProductVariations' => function($query){
            $query->select('id','product_draft_id','image','attribute','sku','ean_no');
        },'single_image_info:id,draft_product_id,image_url'])
        ->whereIn('id',$draftIds)
        ->skip($skip)
        ->take(100)
        ->get();

        $formatedCatalogues = [];
        if(count($catalogues) > 0){
            foreach($catalogues as $catalogue){
                $formatedProducts = [];
                if($catalogue->ProductVariations != null){
                    foreach($catalogue->ProductVariations as $product){
                        $unserializeData = unserialize($product->attribute);
                        $variation = '';
                        if(is_array($unserializeData)){
                            foreach($unserializeData as $data){
                                $variation .= $data['attribute_name'].'->'.$data['terms_name'].',';
                            }
                        }
                        $formatedProducts[] = [
                            'id' => $product->id ?? '',
                            'product_draft_id' => $product->product_draft_id ?? '',
                            'image' => $product->image ?? asset('assets/common-assets/no_image.jpg'),
                            'variation' => rtrim($variation,','),
                            'sku' => $product->sku ?? '',
                            'ean_no' => $product->ean_no ?? ''
                        ];
                    }
                }
                $formatedCatalogues[] = [
                    'id' => $catalogue->id ?? '',
                    'name' => $catalogue->name ?? '',
                    'image_url' => (filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $product_draft->single_image_info->image_url,
                    'products' => $formatedProducts
                ];
            }
        }
        return response()->json($formatedCatalogues);
    }

    public function itemAttribute(){
        $itemAttribute = ItemAttribute::with(['itemAttributeTerms','categories'])
        ->where('is_active',1)
        ->get();
        $categories = WooWmsCategory::all();
        $channels = Channel::where('is_active',1)->get();
        $itemAttributeTerms = ItemAttributeTerm::with(['itemAttribute' => function($attribute){
            $attribute->exclude(['created_at','updated_at','deleted_at']);
        }])
        ->exclude(['created_at','updated_at','deleted_at'])
        ->get();
        //return $itemAttribute;
        $content = view('product_draft.item_attribute',compact('itemAttribute','categories','channels','itemAttributeTerms'));
        return view('master',compact('content'));
    }

    public function saveItemAttribute(Request $request){
        //dd($request->all());
        if($request->item_type == 'attribute'){
            if($request->action_type == 'add'){
                if(count($request->item_attribute) > 0){
                    foreach($request->item_attribute as $key => $attribute){
                        $existCheckAttribute = ItemAttribute::where('item_attribute',$attribute)->first();
                        if($existCheckAttribute){
                            if(isset($request->category_id) && $request->category_id != null){
                                foreach($request->category_id as $cat){
                                    $existCheckAttribute->categories()->syncWithoutDetaching($cat);
                                }
                            }
                        }else{
                            $insertInfo = ItemAttribute::create([
                                'item_attribute' => $attribute,
                                'item_attribute_slug' => strtolower(str_replace(' ','_',$attribute)),
                                'is_active' => 1
                            ]);
                            if($insertInfo){
                                if(isset($request->category_id) && $request->category_id != null){
                                    foreach($request->category_id as $cat){
                                        $insertInfo->categories()->attach($cat);
                                    }
                                }
                            }
                        }
                    }
                }
                return back()->with('success','Item Attribute Successfully Added');
            }elseif($request->action_type == 'edit'){
                if(($request->item_attribute != '') || ($request->item_attribute != null)){
                    $existCheckAttribute = ItemAttribute::find($request->item_attribute_id);
                    if($existCheckAttribute){
                        $existCheckAttribute->categories()->sync($request->category_id);
                        $existCheckAttribute->item_attribute = $request->item_attribute;
                        $existCheckAttribute->save();
                    }
                    return back()->with('success','Item Attribute Successfully Updated');
                }else{
                    return back()->with('error','Enter Item Attribute');
                }
            }
            return back()->with('error','Someting Went Wrong');
        }elseif($request->item_type == 'attribute-term'){
            $itemInfo = ItemAttribute::find($request->item_attribute);
            if($itemInfo){
                foreach($request->item_attribute_term as $key => $term){
                    $existCheck = ItemAttributeTerm::where('item_attribute_id',$request->item_attribute)->where('item_attribute_term',$term)->first();
                    if(!$existCheck){
                        $itemTermInsert= ItemAttributeTerm::create([
                            'item_attribute_id' => $request->item_attribute,
                            'item_attribute_term' => $term,
                            'item_attribute_term_slug' => strtolower(str_replace(' ','_',$term)),
                            'is_active' => 1
                        ]);
                    }
                }
                $itemInfo->save();
                return back()->with('success','Item Attribute Term Successfully Added');
            }else{
                return back()->with('error','Select An Item Attribute');
            }
        }
    }

    public function editItemTerm(Request $request){
        $existCheck = ItemAttributeTerm::where('item_attribute_term',$request->term)->where('id','!=',$request->id)->first();
        if(!$existCheck){
            $termInfo = ItemAttributeTerm::find($request->id);
            $termInfo->item_attribute_term = $request->term;
            $termInfo->save();
            return response()->json(['type' => 'success', 'msg' => 'Attribute Term Updated Successfully']);
        }else{
            return response()->json(['type' => 'error', 'msg' => 'Item Already Exist']);
        }
    }

    public function deleteItemTerm(Request $request){
        try{
            $termInfo = ItemAttributeTerm::destroy($request->id);
            return response()->json(['type' => 'success','msg' => 'Attribute Term Deleted Successfully']);
        }catch(\Exception $ex){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function saveMappingItemTerm(Request $request){
        //dd($request->all());
        if(count($request->master_terms) > 0){
            foreach($request->master_terms as $key => $term){
                $existCheck = Mapping::where('channel_id',$request->channel)
                ->where('attribute_term_id',$request->master_terms[$key])
                ->where('mapping_field',$request->channel_field[$key])
                ->first();
                if(!$existCheck){
                    $mappingInsert = Mapping::create([
                        'channel_id' => $request->channel,
                        'attribute_term_id' => $request->master_terms[$key],
                        'mapping_field' => $request->channel_field[$key]
                    ]);
                }
            }
        }else{
            return back()->with('error','No Master Attribute Selected');
        }
        return back()->with('success','Field Mapping Successfully Done');
    }

    public function getCatalogueTabAttribute($category_id, $catalogue_id = null){
        $categoryInfo = WooWmsCategory::select('id','category_name','user_id')->with(['categoryAttribute' => function($catAttr) use ($catalogue_id){
            $catAttr->select('id','category_id','item_attribute_id')->with(['attributes' => function($attribute)  use ($catalogue_id){
                $attribute->select('id','item_attribute','item_attribute_slug','is_active')->with(['itemAttributeTerms' => function($term) use ($catalogue_id){
                    $term->select('id','item_attribute_id','item_attribute_term','item_attribute_term_slug','is_active')
                    ->with(['catalogueItemAttribute' => function($catalogue) use ($catalogue_id){
                        $catalogue->select('id','catalogue_id','attribute_id','attribute_term_id')
                        ->with(['itemAttributeTermValue' => function($value){
                            $value->select('id','item_attribute_term_id','item_attribute_term_value');
                        }])
                        ->where('catalogue_id',$catalogue_id);
                    }])->where('is_active',1);
                }])->where('is_active',1);
            }]);
        }])
        ->where('id',$category_id)
        ->first();
        return $categoryInfo;
    }

    public function getMappingField(Request $request){
        $mapInfo = Mapping::find($request->map_id);
        $allAttributeField = ItemAttributeTerm::exclude(['created_at','updated_at','deleted_at'])->get();
        return response()->json(['all_field' => $allAttributeField, 'map_info' => $mapInfo]);
    }

    public function modifyMappingField(Request $request){
        try{
            if($request->type == 'edit'){
                $existCheck = Mapping::where('channel_id',$request->channel_id)
                //->where('attribute_term_id',$request->attribute_term)
                ->where('mapping_field',$request->mapping_field)
                ->where('id','!=',$request->map_id)
                ->first();
                if($existCheck){
                    return response()->json(['type' => 'error', 'msg' => 'Mapping Field Already Exist']);
                }
                $updateInfo = Mapping::find($request->map_id)->update([
                    'attribute_term_id' => $request->attribute_term,
                    'mapping_field' => $request->mapping_field
                ]);
                return response()->json(['type' => 'success', 'msg' => 'Mapping Field Updated Successfully']);
            }else{
                $deleteInfo = Mapping::find($request->map_id)->delete();
                return response()->json(['type' => 'success', 'msg' => 'Mapping Field Deleted Successfully']);
            }
        }catch(\Exception $ex){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function updateItemAttribute(Request $request){
        try{
            $existCheck = ItemAttribute::where('item_attribute',$request->item_attribute)
            ->where('id','!=',$request->attribute_id)->first();
            if($existCheck){
                return response()->json(['type'=>'error','msg'=>'Attribute Already Exist']);
            }
            $updateInfo = ItemAttribute::find($request->attribute_id)->update([
                'item_attribute' => $request->item_attribute
            ]);
            return response()->json(['type'=>'success','msg'=>'Attribute Updated Successfully']);
        }catch(\Exception $exception){
            return response()->json(['type'=>'error','msg'=>'Something Went Wrong']);
        }
    }

    public function removeDomainFromUrl(){
        $skip = 0;
        $imgArr = [];
        $i = 1;
        while(true){
            $images = Image::where('image_url','LIKE','%woowms.com%')->skip($skip)->take(500)->get();
            if(count($images) > 0){
                foreach($images as $image){
                    $parseUrlInfo = $this->parseUrl($image->image_url);
                    if($parseUrlInfo['host'] == 'woowms.com'){
                        $updateInfo = Image::find($image->id)->update(['image_url' => substr($parseUrlInfo['path'],7)]);
                    }
                    $i++;
                }
            }else{
                break;
            }
            $skip += 500;
        }
        return redirect('completed-catalogue-list');
    }

    public function getItemAttributeTerm($attrId) {
        try {
            $itemAttributeTerms = ItemAttribute::with(['itemAttributeTerms'])->find($attrId);
            return response()->json(['type' => 'success', 'attribute' => $itemAttributeTerms]);
        }catch(\Exception $ex) {
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function masterCatalogueBySkuAjax(Request $request) {
        try{
            $variationInfo = ProductVariation::with(['product_draft'])->where('sku',$request->sku)->first();
            if($variationInfo) {
                return response()->json(['type' => 'success','result' => $variationInfo]);
            }
            return response()->json(['type' => 'error','msg' => 'No Catalogue Found','icon' => 'warning']);
        }catch (\Exception $exception) {
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong','icon' => 'error']);
        }
    }



}
