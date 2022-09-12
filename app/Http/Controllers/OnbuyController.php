<?php

namespace App\Http\Controllers;

use App\CancelReason;
use App\Client;
use App\EbayMasterProduct;
use App\EbayVariationProduct;
use App\OnbuyAccount;
use App\OnbuyBrand;
use App\OnbuyCategory;
use App\OnbuyMasterProduct;
use App\OnbuyVariationProducts;
use App\Order;
use App\ProductDraft;
use App\ProductOrder;
use App\ProductVariation;
use App\WooWmsCategory;
use App\Role;
use App\User;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use App\OnbuyProfile;
use Auth;
use Arr;
use App\Traits\SearchCatalogue;
use App\Traits\ActivityLogs;
use App\Traits\ListingLimit;
use App\Channel;
use App\Traits\CommonFunction;

class OnbuyController extends Controller
{
    use SearchCatalogue;
    use ActivityLogs;
    use ListingLimit;
    use CommonFunction;
    public function __construct()
    {
        $this->middleware('auth');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function access_token(){

        $consumer_key = Session::get('consumer_key');
        $secret_key = Session::get('secret_key');
        if($consumer_key == ''){
            $info = OnbuyAccount::first();
            if($info) {
                Session::put('consumer_key', $info->consumer_key);
                Session::put('secret_key', $info->secret_key);
                $consumer_key = $info->consumer_key;
                $secret_key = $info->secret_key;
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
            CURLOPT_POSTFIELDS => array('secret_key' => $secret_key,'consumer_key' => $consumer_key),
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

    public function browseCategory(){
        $access_token = $this->access_token();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/categories?site_id=2000&limit=100&offset=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$access_token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response,JSON_PRETTY_PRINT);
        echo "<pre>";
        print_r($data);
        exit();
    }

    public function createProduct($id){

        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
        // dd($listingLimitInfo,$clientListingLimit);
        // dd($listingLimitAllChannelActiveProduct);

        $profile_lists = OnbuyProfile::get()->all();
        //$profile_lists = OnbuyProfile::get()->all();
        //$brand_info = DB::table('onbuy_brands')->get();
        //$all_parent_category = DB::table('onbuy_categories')->where('lvl',2)->orderBy('name','ASC')->get();
//        echo "<pre>";
//        print_r(json_decode($brand_info));
//        exit();
        $content = view('onbuy.create_product',compact('profile_lists','id','listingLimitAllChannelActiveProduct','clientListingLimit','listingLimitInfo'));
        return view('master',compact('content'));
    }

    public function saveOnbuyProduct(Request $request){
        try {
            $masterCatalogueInfo = ProductDraft::find($request->catalogue_id);
            
            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

            // $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
            // $clientListingLimit = $this->ClientListingLimit();

            //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

            if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
                return redirect('onbuy/create-product/'.$request->catalogue_id);
            }
            else{
                $access_token = $this->access_token();

    //        echo "<pre>";
    //        print_r($request->m_tectnical_details);
    //        exit();

                foreach ($request->m_tectnical_details as $details) {
                    $m_t_d[] = [
                        "detail_id" => explode('/', $details)[0],
                        "value" => explode('/', $details)[1]
                    ];
                }
    //        echo "<pre>";
    //        print_r($request->product_variant_option);
    //        exit();

                foreach ($request->m_label as $key => $value) {
                    $m_p_d[] = [
                        "label" => $value,
                        "value" => $request->m_value[$key]
                    ];
                }

                $variant_loop_count = 1;
                $count = 0;
                $test1 = array();
                $option_value1 = array();
                foreach ($request->product_codes as $key => $value) {
                if($masterCatalogueInfo->type == 'variable') {
                    if ($request->product_variant_option[$key] != null) {
                        foreach ($request->product_variant_option[$key] as $variation) {
                            if ($variation != null) {
                                $op_value = $variation;
                                $count++;
                            }
                        }
                    }

                    if (!isset($request->custom_variant[$key])) {
                        $custom_count = 0;
                        foreach ($request->product_variant_option[$key] as $variation) {
                            if ($variation != null) {
                                $test1["variant_" . $variant_loop_count] = [
                                    "option_id" => explode('/', $variation)[0],
                                    "name" => $request->product_variant_custom_option[$key][$custom_count] ?? null
                                ];
                                $option_value1["variant_" . $variant_loop_count] = [
                                    "option_id" => $variation,
                                    "name" => $request->product_variant_custom_option[$key][$custom_count] ?? null
                                ];
                                $variant_loop_count++;
                            }
                            elseif ($request->product_variant_custom_option[$key][$custom_count] != null && $variation == null) {
                                $test1["variant_" . $variant_loop_count] = [
                                    "name" => $request->product_variant_custom_option[$key][$custom_count]
                                ];
                                $option_value1["variant_" . $variant_loop_count] = [
                                    "name" => $request->product_variant_custom_option[$key][$custom_count]
                                ];
                                $variant_loop_count++;
                            }
                            $custom_count++;
                        }
                    } elseif (isset($request->custom_variant[$key]) && $count > 0) {
                        $test1["variant_1"] = [
                            "option_id" => explode('/', $op_value)[0]
                        ];
                        $option_value1["variant_1"] = [
                            "option_id" => $op_value
                        ];
                        $test1["variant_2"] = [
                            "name" => $request->custom_variant[$key]
                        ];
                        $option_value1["variant_2"] = [
                            "name" => $request->custom_variant[$key]
                        ];
                    } else {
                        $test1["variant_1"] = [
                            "name" => $request->custom_variant[$key]
                        ];
                        $option_value1["variant_1"] = [
                            "name" => $request->custom_variant[$key]
                        ];
                    }
                }else {
                    $test1["variant_1"] = [
                        "name" => $request->custom_variant[$key]
                    ];
                    $option_value1["variant_1"] = [
                        "name" => $request->custom_variant[$key]
                    ];
                }

                    $test3 = [
    //                "mpn" => '',
                        "product_codes" => [
                            $request->product_codes[$key]
                        ],
    //                "summary_points" => $request->m_summary_points,
    //                "product_name" => $request->m_product_name,
    //                "description" => '',
                        "default_image" => $request->default_image,
                        "additional_images" =>  $request->images ?? null,
    //                "rrp" => $request->m_rrp,
    //                "product_data" => $m_p_d,
                        "technical_detail" => $m_t_d,
                        "listings" => [
                            "new" => [
                                "sku" => $request->sku[$key],
                                "group_sku" => $request->gro_sku[$key],
                                "price" => $request->m_rrp,
                                "stock" => $request->stock[$key],
                                "handling-time" => $request->h_time[$key]
                            ]
                        ]
                    ];
                    if($request->sale_price[$key]){
                        $test3['listings']['new']['sale_price'] = $request->sale_price[$key];
                        $test3['listings']['new']['sale_start_date'] = $request->sale_start_date[$key];
                        $test3['listings']['new']['sale_end_date'] = $request->sale_end_date[$key];
                    }
                    if($request->boost_commission[$key]){
                        $test3['listings']['new']['boost_marketing_commission'] = $request->boost_commission[$key];
                    }
                    $variant_loop_count = 1;
                    $variant_info[] = array_merge($test1, $test3);
                    $variant_db_info[] = array_merge($option_value1, $test3);
                }

    //        echo "<pre>";
    //        print_r(json_encode($variant_info,JSON_PRETTY_PRINT));
    //        exit();

                $data1 = [
                    "site_id" => 2000,
                    "category_id" => $request->last_cat_id,
                    "published" => "1",
                    "brand_id" => $request->brand_id,
                    "mpn" => '',
    //            "product_codes" => [
    //                $request->m_product_codes
    //            ],
                    "summary_points" => $request->m_summary_points,
                    "product_name" => $request->m_product_name,
                    "description" => $request->m_product_description,
                    "default_image" => $request->default_image,
                    "additional_images" => $request->images ?? null,
                    "rrp" => $request->m_rrp,
                    "product_data" => $m_p_d
                ];
                $variant_loop_counts = 0;
                if ($request->m_variant != null) {
                    foreach ($request->m_variant as $m_variant) {
                        if ($m_variant != null) {
                            $variant_loop_counts++;
                        }
                    }
                }

    //        for parent single variant option
    //        foreach ($request->product_variant_option as $variation) {
    //            foreach ($variation as $var){
    //                if($var != null) {
    //                    $option[] = [
    //                        "option_id" => $var
    //                    ];
    //                }
    //            }
    //        }

    //        echo "<pre>";
    //        print_r($variant_loop_counts);
    //        exit();

                if (!isset($request->m_custom_variant)) {
                    if ($variant_loop_counts == 1) {
                        $option = array();
                        foreach ($request->product_variant_option as $variation) {
                            foreach ($variation as $var) {
                                if ($var != null) {
                                    $option[] = [
                                        "option_id" => $var
                                    ];
                                }
                            }
                        }
                        foreach ($request->m_variant as $m) {
                            if ($m != null) {
    //                        $attr_1_value = explode('/',$m);
                                $data2_variant_1 = $m;
                                $data2 = [
                                    "variant_1" => [
                                        "feature_id" => explode('/', $m)[0]
    //                    "options" => $option
                                    ]
                                ];
                            }
                        }
                    }

                    if ($variant_loop_counts == 2) {
                        $i = 0;
                        foreach ($request->product_variant_option as $variation) {
    //                echo "<pre>";
    //                print_r($variation);
    //                exit();

    //                foreach ($variation as $var){
    //                for ($i = 0 ; $i <= count($variation) - 1 ; $i++) {
    //                    if ($variation[$i] != null) {
                            $option1[] = [
                                "option_id" => $variation[$i]
                            ];
    //                        $option2[] = [
    //                            "option_id" => $variation[$i+1]
    //                        ];
                            for ($j = $i; $j < count($variation) - 1; $j++) {
                                if ($variation[$j + 1] != null) {
                                    $option2[] = [
                                        "option_id" => $variation[$j + 1]
                                    ];
                                    $i = 0;
                                    break;
                                }
                            }

    //                    }
    //                    else{
    //                        $i++;
    //                    }
    //                }

    //                }
    //                $i++;
                        }

    //                    echo "<pre>";
    //        print_r($option2);
    //        exit();
                        $k = 0;
                        foreach ($request->m_variant as $m_v) {
                            if ($m_v != null) {
                                $master_variant[] = $m_v;
                            }
                        }

    //                $attr_2_value_1 = explode('/',$master_variant[0]);
    //                $attr_2_value_2 = explode('/',$master_variant[1]);

                        $data2_variant_1 = $master_variant[0];
                        $data2_variant_2 = $master_variant[1];

                        $data2 = [
                            "variant_1" => [
                                "feature_id" => explode('/', $master_variant[0])[0]
    //                    "options" => $option1
                            ],
                            "variant_2" => [
                                "feature_id" => explode('/', $master_variant[1])[0]
    //                    "options" => $option2
                            ]
                        ];
                    }
                } elseif (isset($request->m_custom_variant) && $variant_loop_counts > 0) {
    //            return $variant_loop_counts;
                    foreach ($request->m_variant as $m_v) {
                        if ($m_v != null) {
                            $master_variant[] = $m_v;
                        }
                    }
    //            $attr_1_cus_value_1 = explode('/',$master_variant[0]);
                    $data2_variant_1 = $master_variant[0];
                    $data2 = [
                        "variant_1" => [
                            "feature_id" => explode('/', $master_variant[0])[0]
                        ],
                        "variant_2" => [
                            "name" => $request->m_custom_variant
                        ]
                    ];
                } else {
                    $data2 = [
                        "variant_1" => [
                            "name" => $request->m_custom_variant
                        ]
                    ];
                }

    //        echo "<pre>";
    //        print_r($data2);
    //        exit();

                $data3 = [
                    "variants" => $variant_info
                ];

                $features = null;
                $db_features = null;

                if (isset($request->m_feature)) {
                    foreach ($request->m_feature as $value) {
                        if ($value != null) {
                            $db_features[] = [
                                "option_id" => $value
                            ];
                            $features[] = [
                                "option_id" => explode('/', $value)[0]
                            ];
                        }
                    }
                }
                $data4 = array();
                if (isset($features)) {
                    $data4 = [
                        "features" => $features
                    ];
                }


                $datas = array_merge($data1, $data2, $data3, $data4);
                $product_info = json_encode($datas, JSON_PRETTY_PRINT);

    //            echo "<pre>";
    //            print_r($product_info);
    //            exit();

                $url = "https://api.onbuy.com/v2/products";
                $post_data = $product_info;
                $method = "POST";
                $http_header = array("Authorization: ".$access_token, "Content-Type: application/json");
                $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);

                $data = json_decode($result_info, JSON_PRETTY_PRINT);

                $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                    . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
                shuffle($seed); // probably optional since array_is randomized; this may be redundant
                $rand = '';
                foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];

                $result = (object)$data;
                $masterCatalogurInfo = ProductDraft::find($request->catalogue_id);
                if(isset($result->queue_id)) {
                    $insert_info = OnbuyMasterProduct::create([
                        'opc' => $rand,
                        'woo_catalogue_id' => $request->catalogue_id,
                        'master_category_id' => $request->last_cat_id,
                        'master_brand_id' => $request->brand_id,
                        'product_type' => $masterCatalogueInfo->product_type ?? null,
                        'summary_points' => json_encode($request->m_summary_points) ?? null,
                        'published' => 1,
                        'product_name' => $request->m_product_name,
                        'queue_id' => $result->queue_id ?? $rand,
                        'description' => $request->m_product_description,
    //            'videos' => $rand,
    //            'documents' => $rand,
                        'default_image' => $request->default_image,
                        'additional_images' => json_encode($request->images) ?? null,
                        'product_data' => json_encode($m_p_d) ?? null,
                        'features' => json_encode($db_features) ?? null,
                        'rrp' => $request->m_rrp,
                        'base_price' => $masterCatalogurInfo->base_price ?? null,
                        'low_quantity' => 5,
                        'status' => 'pending'
                    ]);

                    $variant_db_info = json_decode(json_encode($variant_db_info));
                    $data2 = json_decode(json_encode($data2));

                    foreach ($variant_db_info as $variant) {
    //            echo "<pre>";
    //            print_r($variant);
    //            exit();
                        $info = OnbuyVariationProducts::create([
                            'sku' => $variant->listings->new->sku,
                            'master_product_id' => $insert_info->id,
                            'queue_id' => $result->queue_id ?? $rand,
                            'opc' => $rand,
                            'ean_no' => $variant->product_codes[0],
                            'attribute1_name' => $data2_variant_1 ?? $data2->variant_1->name ?? null,
                            'attribute1_value' => $variant->variant_1->name ?? $variant->variant_1->option_id ?? null,
                            'attribute2_name' => $data2_variant_2 ?? $data2->variant_2->name ?? null,
                            'attribute2_value' => $variant->variant_2->name ?? $variant->variant_2->option_id ?? null,
                            'name' => $request->m_product_name,
                            'group_sku' => $variant->listings->new->group_sku ?? null,
                            'price' => $variant->listings->new->price ?? null,
                            'base_price' => $masterCatalogurInfo->base_price ?? null,
                            'max_price' => $variant->listings->new->price ?? null,
                            'stock' => $variant->listings->new->stock ?? null,
                            'technical_detail' => json_encode($m_t_d) ?? null,
    //                'product_listing_id' => $variant->listing->new->sku,
    //                'product_listing_condition_id' => $variant->listing->new->sku,
                            'condition' => "new",
    //                'product_encoded_id' => $variant->listing->new->sku,
    //                'delivery_weight' => $variant->listing->new->sku,
    //                'delivery_template_id' => $variant->listing->new->sku,
    //                'boost_marketing_commission' => $variant->listing->new->sku,
                            'low_quantity' => 5
                        ]);
                    }
                    return redirect('onbuy/master-product-list')->with('success','Product created successfully');
                }else{
                    return back()->with('error',$data['error']['message']);
                }

    //        echo "<pre>";
    //        print_r(json_decode($product_info));
    //        exit();


                echo "<pre>";
                print_r($data);
                exit();
            }

        }catch (\Exception $ex){
            return $ex->getMessage();
        }
//        echo $response;
    }


     /*
      * Function : masterProductList
      * Route Type : onbuy/master-product-list
      * Method Type : GET
      * Parameters : null
      * Creator :Kazol
      * Modifier : Solaiman
      * Description : This function is used for OnBuy Active product list and pagination setting
      * Modified Date : 28-11-2020, 1-12-2020
      * Modified Content : Pagination setting
      */

    public function masterProductList(Request $request)
    {
        //Start page title and pagination setting
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        $settingData = $this->paginationSetting('onbuy', 'onbuy_active_product');
        $setting = $settingData['setting'];
        $page_title = 'OnBuy | Active Product | WMS360';
        $pagination = $settingData['pagination'];

        $distinct_status = OnbuyMasterProduct::distinct()->orderBy('status','ASC')->get(['status'])->where('status', '!=', null);
        $distinct_category = OnbuyCategory::distinct()->orderBy('name','ASC')->get(['category_id','name','category_tree'])->where('name', '!=', null);

        $master_product_list = OnbuyMasterProduct::with('category_info')
        ->withCount('variation_product');
        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->onbuyMasterCatalogueSearchCondition($master_product_list, $request);
            $allCondition = $this->onbuyMasterCatalogueConditionParams($request, $allCondition);
            //dd($allCondition);
        }
        $master_product_list = $master_product_list->orderByDesc('id')->paginate($pagination);
        if($request->has('is_clear_filter')){
            $search_result = $master_product_list;
            $view = view('onbuy.master_product.search_master_product', compact('search_result'))->render();
            return response()->json(['html' => $view]);
        }
        $decode_master_product = json_decode(json_encode($master_product_list));
        $total_product = OnbuyMasterProduct::count();
//        echo "<pre>";
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
        $content = view('onbuy.master_product.master_product_list',compact('master_product_list','decode_master_product','total_product', 'setting', 'page_title', 'pagination','distinct_status','distinct_category','url','allCondition'));
        return view('master',compact('content'));

    }



    /*
     * Function : onbuyMasterProductSearch
     * Route Type : OnBuy/active/product/search
     * Method Type : Post
     * Parameters : null
     * Creator : Solaiman
     * Creating Date : 31/01/2021
     * Description : This function is used for OnBuy Active product individual column search
     * Modifier :
     * Modified Date :
     * Modified Content :
     */

    public function onbuyMasterProductSearch (Request $request) {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('onbuy', 'onbuy_active_product');
        $setting = $settingData['setting'];
        $page_title = 'OnBuy | Active Product | WMS360';
        $pagination = $settingData['pagination'];

        $column_name = $request->column_name;
        $search_value = $request->search_value;
        $aggregate_value = $request->aggregate_condition;

        $distinct_status = OnbuyMasterProduct::distinct()->get(['status'])->where('status', '!=', null);
        $distinct_category = OnbuyCategory::distinct()->get(['name'])->where('name', '!=', null);

        $master_product_list = OnbuyMasterProduct::with('category_info')
               ->withCount('variation_product')
               ->orderByDesc('id')
               ->where(function ($query) use ($request,$column_name,$search_value,$aggregate_value){
                   if($column_name == 'opc') {
                       if ($request->opt_out == 1) {
                           $query->where($column_name, '!=', $search_value);
                       } else {
                           $query->where($column_name, $search_value);
                       }
                   }elseif ($column_name == 'woo_catalogue_id'){
                       if ($request->opt_out == 1) {
                           $query->where($column_name, '!=', $search_value);
                       }else{
                           $query->where($column_name, $search_value);
                       }
                   }elseif ($column_name == 'product_name'){
                       if ($request->opt_out == 1) {
                           $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
                       }else{
                           $query->where($column_name, 'LIKE', '%' . $search_value . '%');
                       }
                   }elseif ($column_name == 'name') {
                       $category_name_query = OnbuyMasterProduct::select('onbuy_master_products.id')
                                ->leftJoin('onbuy_categories', 'onbuy_master_products.master_category_id', '=', 'onbuy_categories.category_id')
                                ->where([['onbuy_master_products.deleted_at', null],['onbuy_categories.deleted_at', null]])
                                ->where($column_name, 'LIKE', '%' . $search_value . '%')
                                ->groupBy('onbuy_master_products.id')
                                ->get();

                       $ids = [];
                       foreach ($category_name_query as $category_name){
                           $ids [] = $category_name->id;
                       }
                       if($request->opt_out == 1){
                           $query->whereNotIn('id', $ids);
                       }else{
                           $query->whereIn('id', $ids);
                       }
                   }elseif ($column_name == 'base_price'){
                       $aggregate_value = $request->aggregate_condition;
                       if($request->opt_out == 1){
                           $query->where('base_price', '!=', $search_value);
                       }else{
                           $query->where('base_price', $aggregate_value, $search_value);
                       }
                   }
                   elseif ($column_name == 'product'){
                       $aggregate_value = $request->aggregate_condition;
                       $product_query = OnbuyMasterProduct::select('onbuy_master_products.id', DB::raw('count(onbuy_variation_products.id) product'))
                           ->leftJoin('onbuy_variation_products', 'onbuy_master_products.id', '=', 'onbuy_variation_products.master_product_id')
                           ->havingRaw('count(onbuy_variation_products.id)' .$aggregate_value.$search_value)
                           ->groupBy('onbuy_master_products.id')
                           ->get();

                       $ids = [];
                       foreach ($product_query as $product){
                           $ids[] = $product->id;
                       }

                       if($request->opt_out == 1){
                           $query->whereNotIn('id', $ids);
                       }else{
                           $query->whereIn('id', $ids);
                       }

                   }elseif ($column_name == 'status'){
                       if($request->opt_out == 1){
                           $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
                       }else{
                           $query->where($column_name, 'LIKE', '%' . $search_value . '%');
                       }
                   }
                   else{
                       if ($request->opt_out == 1) {
                           $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
                       }else{
                           $query->where($column_name, 'LIKE', '%' . $search_value . '%');
                       }
                   }

                   // If user submit with empty data then this message will display table's upstairs
                   if($search_value == ''){
                       return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
                   }

               })
               ->paginate(500);


        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $ids = [];
        if(count($master_product_list) > 0){
            foreach ($master_product_list as $result){
                $ids[] = $result->id;
            }
        }
        else{
            return back()->with('no_data_found','No data found');
        }


        $decode_master_product = json_decode(json_encode($master_product_list));
//        echo "<pre>";
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
        return view('onbuy.master_product.master_product_list',compact('master_product_list','decode_master_product', 'setting', 'page_title', 'pagination','column_name','search_value','aggregate_value','distinct_status','distinct_category'));
    }

    public function getVariation(Request $request){
        $id = $request->product_draft_id;
        $status = $request->status;

        $shelfUse = $this->shelf_use;
        if ($status == 'onbuy_ean_pending'){
            $product_draft = ProductVariation::where('product_draft_id',$id)->get();

            $catalogue = json_decode(json_encode($product_draft));

            return view('onbuy.master_product.variation_ajax',compact('catalogue','id','status','shelfUse'));
        }elseif($status == 'active'){
            $product_list = OnbuyVariationProducts::where('master_product_id',$id)->get();
            $product_list = json_decode(json_encode($product_list));
//        echo "<pre>";
//        print_r($product_list);
//        exit();
            return response()->json(view('onbuy.master_product.variation_ajax',compact('product_list','id','status','shelfUse'))->render());
        }

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



    public function masterProductDetails($id){
        $shelf_ues = $this->shelf_use;
        $single_master_product_details = OnbuyMasterProduct::with('variation_product')->where('id',$id)->first();
//        echo "<pre>";
//        print_r(json_decode(json_encode($single_master_product_details)));
//        exit();
        $content = view('onbuy.master_product.master_product_details',compact('single_master_product_details','shelf_ues'));
        return view('master',compact('content'));
    }

    public function syncOrderFromOnbuy(){


        $access_token = $this->access_token();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/orders?site_id=2000&filter[status]=awaiting_dispatch&limit=100&offset=0&filter[order_ids]=&sort[created]=desc&previously_exported=0'",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$access_token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response);



        $order_array = array();
        $product_order_array = array();
        try {

            foreach ($data->results as $info) {
                $find_order_result = Order::find($info->onbuy_internal_reference);
                if (empty($find_order_result)){
                    $order_array = null;
                    $product_order_array = null;
                    $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->name . '</h7></div></div>';
//        $shipping .= '<div class="row"><div class="col-4"><h7> Company  </h7></div><div class="col-8"><h7> : '.$order->shipping->company.'</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->line_1 . ',' . $info->delivery_address->line_2 . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->town . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->county . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->postcode . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->country . '</h7></div></div>';
                    $order_array[]=[
                        'id' =>$info->onbuy_internal_reference ,
                        'order_number' => $info-> order_id ,
                        'status' =>  $info->status = 'Awaiting Dispatch' ? 'processing' : $info->status,
                        'created_via' => 'onbuy',
                        'currency' => $info->currency_code,
                        'total_price' => $info->price_total,
                        //'customer_id' => $info->,
                        'customer_name' => $info->buyer->name,
                        'customer_email' => $info->buyer->email,
                        'customer_phone' => $info->buyer->phone,
                        'customer_country' => $info->billing_address->country,
                        'customer_city' => $info->billing_address->town,
                        'customer_zip_code' => $info->billing_address->postcode,
                        'customer_state' => $info->billing_address->county,
                        'shipping' => $shipping,
                        'shipping_post_code' => $info->delivery_address->postcode,
                        //'tracking_number' => $info->,
                        'date_created' => $info->date,
                        'created_at'=> Carbon::now(),
                        'updated_at'=> Carbon::now(),
                        //'date_completed' => $info->,
                        'payment_method' => $info->paypal_capture_id != null ? ( 'paypal' ) : ( $info->stripe_transaction_id !=null ? ( 'stripe' ) : ('null' ) ),
                    ];
//            $array[] = array('brand_id' => $info->brand_id ?? null, 'name' => $info->name ?? null, 'brand_type_id' => $info->brand_type_id ?? null, 'type' => $info->type ?? null);
//            $fp = fopen('brands.csv', 'w');
//            foreach ($array as $fields) {
//                fputcsv($fp, $fields);
//            }
//            fclose($fp);

//            echo "<pre>";
//            print_r($result);
//            exit();
                    foreach ($info->products as $product){
                        $result = ProductVariation::where('sku' ,$product->sku)->get()->first();
//                print_r($result->id);
//                exit();
                        $product_order_array[]= [
                            'order_id'=> $info->onbuy_internal_reference,
                            'variation_id'=> $result->id,
                            'name'=> $product->name,
                            'quantity'=> $product->quantity,
                            'price'=> $product->total_price,
                            'status'=> 0,
                            'created_at'=> Carbon::now(),
                            'updated_at'=> Carbon::now(),
                        ];

                    }

                    $order_result = Order::insert($order_array);
                    $product_order_result = ProductOrder::insert($product_order_array);
                }
            }
        }catch (Exception $exception){
            echo $exception;
        }
        return redirect('order/list');
    }

    public function ajaxCategoryChildList(Request $request){
//        $category_id = $request->category_id;
//        $category_label = DB::table('onbuy_categories')->where('category_id',$category_id)->first();
//        $label = $category_label->lvl;
//        $dependent_category = DB::table('onbuy_categories')->where('parent_id',$category_id)->orderBy('name','ASC')->get();
//        if(count($dependent_category) > 0){
//            $output = '<div class="col-md-2"></div><div class="col-md-10 m-t-5 controls" id="category-level-'.$category_label->lvl.'-group">
//                        <select class="form-control category_select" name="child_cat['.$category_label->lvl.']" id="child_cat_'.$category_label->lvl.'" onchange="myFunction('.$category_label->lvl.')">
//                        <option value="">Select Category</option>';
//            foreach($dependent_category as $category)
//            {
//                $output .= '<option value="'.$category->category_id.'">'.$category->name.'</option>';
//            }
//            $output .= '</select></div>';
//            return response()->json(['data' => 1,"content" => $output, 'lavel' => $label - 1]);
//        }else{
            $access_token = $this->access_token();
//            $catalogue_info = ProductDraft::with('images')->find($request->catalogue_id);
            $profile_result = OnbuyProfile::find($request->profile_id);
            $brand_info = DB::table('onbuy_brands')->orderBy('name')->get();
            $feature_array = unserialize($profile_result->features);
            $technical_details = unserialize($profile_result->technical_details);

            $catalogue_info = ProductDraft::with('ProductVariations','images')->find($request->catalogue_id);
            $catalogue_info = json_decode($catalogue_info);
            $parent_variant_1_row = $catalogue_info->product_variations[0];
            $p_v = array();
            if($parent_variant_1_row->attribute != null){
                foreach (\Opis\Closure\unserialize($parent_variant_1_row->attribute) as $attribute){
                    $p_v[] = $attribute['attribute_name'];
                }
            }
            $exits_ean = array();
            $exits_ean_product_info = [];
            foreach ($catalogue_info->product_variations as $ean_no){

                if($ean_no->ean_no != null) {
                    $url = "https://api.onbuy.com/v2/products?site_id=2000&filter[query]=".$ean_no->ean_no."&filter[field]=product_code";
                    $post_data = null;
                    $method = "GET";
                    $http_header = array("Authorization: " . $access_token);
                    $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
                    $exits_ean_data = json_decode($result_info1);
                    if(!empty($exits_ean_data->results)) {
                        $exits_ean[] = [
                            'opc' => $exits_ean_data->results[0]->opc,
                            'ean_no' => $exits_ean_data->results[0]->product_codes[0],
                            'product_id' => explode('/',substr($exits_ean_data->results[0]->url, strpos($exits_ean_data->results[0]->url, "~p") + 2))[0]
                        ];
                        $exits_ean_product_info[$exits_ean_data->results[0]->product_codes[0]] = [
                            'opc' => $exits_ean_data->results[0]->opc,
                            'name' => $exits_ean_data->results[0]->name,
                            'ean_no' => $exits_ean_data->results[0]->product_codes[0],
                            'image_url' => $exits_ean_data->results[0]->thumbnail_url,
                            'product_url' => $exits_ean_data->results[0]->url,
                            'product_id' => explode('/',substr($exits_ean_data->results[0]->url, strpos($exits_ean_data->results[0]->url, "~p") + 2))[0]
                        ];
                    }
                }

            }


            $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/variants?site_id=2000";
            $post_data = null;
            $method = "GET";
            $http_header = array("Authorization: ".$access_token);
            $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
            $category_data = json_decode($result_info1);


            $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/technical-details?site_id=2000";
            $post_data = null;
            $method = "GET";
            $http_header = array("Authorization: ".$access_token);
            $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
            $technical_data = json_decode($result_info2);
            $catalogue_id = $request->catalogue_id;
            $variant_view = view('onbuy.category_variant_by_ajax',compact('category_data','technical_data','catalogue_info','p_v','exits_ean','profile_result','brand_info','feature_array','technical_details','catalogue_id','exits_ean_product_info'));
            echo $variant_view;
//        }
//        return response()->json(['data' => $dependent_category]);
    }

    public function checkQueueId(Request $request){
        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/queues/".$request->queue_id."?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        $data = json_decode($result_info);

        if($data->results->status == 'success') {
            $master_opc = OnbuyMasterProduct::select('opc')->where('queue_id')->first();
            $product_id = explode('/',substr($data->results->product_url, strpos($data->results->product_url, "~p") + 2))[0];
            $master_product_update = OnbuyMasterProduct::where('queue_id', $data->results->queue_id)->update([
                'product_id' => $product_id,'opc' => $data->results->opc, 'status' => $data->results->status
            ]);
            $variation_ids = OnbuyVariationProducts::select('id')->where('queue_id',$data->results->queue_id)->get();
            $variant_opc = json_decode(json_encode($data->results->variant_opcs));
            $i = 0;
            foreach ($variation_ids as $id) {
                $variant_product_update = OnbuyVariationProducts::where([['id', $id->id],['queue_id', $data->results->queue_id]])->update([
                    'opc' => $variant_opc[$i]
                ]);
                $i++;
            }
//        echo "<pre>";
//        print_r($data);
//        exit();
            return response()->json(['status' => $data->results->status, 'opc' => $data->results->opc]);
        }elseif ($data->results->status == 'failed'){
            $master_product_update = OnbuyMasterProduct::where('queue_id', $data->results->queue_id)->update([
                'status' => $data->results->status
            ]);
            return response()->json(['status' => $data->results->status, 'error_message' => $data->results->error_message]);
        }
        else{
            return response()->json(['status' => $data->results->status]);
        }
    }

    public function variationProductDetails($variation_id){
        $variation_product_info = OnbuyVariationProducts::with('master_product_info')->find($variation_id);
//        echo "<pre>";
//        print_r(json_decode($variation_product_info));
//        exit();
        $content = view('onbuy.variant_product.variant_product_details',compact('variation_product_info'));
        return view('master',compact('content'));
    }

    public function editMasterProduct($id){
        $access_token = $this->access_token();
        $single_master_product_info = OnbuyMasterProduct::with('category_info:category_id,name','brand_info:brand_id,name')->find($id);

        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/categories/".$single_master_product_info->category_info->category_id."/features?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        $category_data = json_decode($result_info);
//        echo "<pre>";
//        print_r($category_data);
//        exit();
        $content = view('onbuy.master_product.edit_onbuy_product',compact('single_master_product_info','category_data'));
        return view('master',compact('content'));
    }

    public function updateMasterProduct(Request $request, $id){
        $access_token = $this->access_token();

        foreach ($request->m_label as $key => $value){
            $m_p_d[] = [
                "label" => $value,
                "value" => $request->m_value[$key]
            ];
        }

        $features = null;
        $db_features = null;

        if(isset($request->m_feature)) {
            foreach ($request->m_feature as $value) {
                if ($value != null) {
                    $db_features[] = [
                        "option_id" => $value
                    ];
                    $features[] = [
                        "option_id" => explode('/',$value)[0]
                    ];
                }
            }
        }
        $data4 = array();
        if(isset($features)) {
            $data4 = [
                "features" => $features
            ];
        }

        $data1 = [
            "site_id" => 2000,
            "category_id" => $request->last_cat_id,
            "published" => "1",
            "brand_id" => $request->brand_id,
            "mpn" => '',
            "default_image" => $request->default_image,
            "additional_images" => $request->images,
            "summary_points" => $request->m_summary_points ?? null,
            "product_name" => $request->m_product_name,
            "description" => $request->m_product_description,
            "rrp" => $request->m_rrp,
            "product_data" => $m_p_d ?? null
        ];

        $datas = array_merge($data1,$data4);
        $product_info = json_encode($datas,JSON_PRETTY_PRINT);
        $single_master_product_info = OnbuyMasterProduct::find($id);

//        echo "<pre>";
//        print_r($product_info);
//        exit();

        try{
            //$logInsertData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,null,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'null');
            $url = "https://api.onbuy.com/v2/products/".$single_master_product_info->opc;
            $post_data = $product_info;
            $method = "PUT";
            $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $data = json_decode($result_info,JSON_PRETTY_PRINT);
            // if($result_info){
            //     $UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Success');
            // }else{
            //     $UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Fail');
            // }
        } catch (HttpClientException $exception){
            //$UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Fail');
        }

        // $url = "https://api.onbuy.com/v2/products/".$single_master_product_info->opc;
        // $post_data = $product_info;
        // $method = "PUT";
        // $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
        // $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        // $data = json_decode($result_info,JSON_PRETTY_PRINT);

        $result = (object) $data;

        if(isset($result->queue_id)) {

            $insert_info = OnbuyMasterProduct::where('id', $id)->update([
//            'master_category_id' => $request->last_cat_id,
//            'master_brand_id' => $request->brand_id,
                'summary_points' => json_encode($request->m_summary_points) ?? null,
                'update_queue_id' => $result->queue_id ?? null,
//            'published' => 1,
                'product_name' => $request->m_product_name,
                'description' => $request->m_product_description,
//            'videos' => $rand,
//            'documents' => $rand,
                'product_data' => json_encode($m_p_d) ?? null,
                'features' => json_encode($db_features) ?? null,
                'rrp' => $request->m_rrp,
                'base_price' => $request->base_price ?? null
            ]);
        }else{
            return back()->with('error',$data['error']['message']);
        }

        $variant_opc = OnbuyVariationProducts::select('opc')->where('master_product_id',$id)->distinct()->get();
//        echo "<pre>";
//        print_r($opc_data);
//        exit();

        foreach ($variant_opc as $opc){
            $data2 = [
                "opc" =>$opc->opc,
                "summary_points" => $request->m_summary_points ?? null,
                "description" => $request->m_product_description,
                "default_image" => $request->default_image,
                "additional_images" => $request->images,
                "summary_points" => $request->m_summary_points ?? null,
                "rrp" => $request->m_rrp
//                'base_price' => $request->base_price ?? null
//                "product_data" => $m_p_d ?? null
            ];
            $data_batch = array_merge($data2,$data4);
            $opc_batch_update[] = $data_batch;
            if($request->base_price != null || $request->m_rrp != null){
                $variationId = OnbuyVariationProducts::where('opc',$opc->opc)->first();
                if($variationId){
                    $updateInfo = OnbuyVariationProducts::find($variationId->id)->update([
                        'base_price' => $request->base_price ?? null,
                        'max_price' => $request->m_rrp ?? null
                    ]);
                }
            }
        }
        $batch_info = [
            "site_id" => 2000,
            "products" => $opc_batch_update
        ];
        $batch_product_info = json_encode($batch_info,JSON_PRETTY_PRINT);

//        echo "<pre>";
//        print_r($batch_product_info);
//        exit();

        try{
            //$logInsertData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,null,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'null');
            $url = "https://api.onbuy.com/v2/products";
            $post_data = $batch_product_info;
            $method = "PUT";
            $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $data = json_decode($result_info,JSON_PRETTY_PRINT);
            // if($result_info){
            //     $UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Success');
            // }else{
            //     $UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Fail');
            // }
        }catch (HttpClientException $exception){
            //$UpdateData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,$result_info,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'Fail');
        }

        // $logInsertData = $this->paramToArray(url()->full(),'OnBuy Product Update','OnBuy',1,$data,null,Auth::user()->name,$master_variation_info->actual_quantity,$newUpdatedData,Carbon::now(),'null');
        // $url = "https://api.onbuy.com/v2/products";
        // $post_data = $batch_product_info;
        // $method = "PUT";
        // $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
        // $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        // $data = json_decode($result_info,JSON_PRETTY_PRINT);

        return back()->with('success','Product updated successfully');
        echo "<pre>";
        print_r($data);
        exit();
        echo $response;
    }

    public function editVariationProduct($id){
        $single_variation_product_info = OnbuyVariationProducts::find($id);
//        echo "<pre>";
//        print_r(json_decode($single_variation_product_info));
//        exit();
        $content = view('onbuy.variant_product.edit_variation_product',compact('single_variation_product_info'));
        return view('master',compact('content'));
        exit();
    }

    public function updateVariationProduct(Request $request, $id){
        $access_token = $this->access_token();
        $data[] = [
            "sku" => $request->sku,
            "price" => $request->price,
            "stock" => $request->stock
        ];
        $update_info= [
            "site_id" => 2000,
            "listings" => $data
        ];

        $product_info = json_encode($update_info,JSON_PRETTY_PRINT);
        try{
            $url = "https://api.onbuy.com/v2/listings/by-sku";
            $post_data = $product_info;
            $method = "PUT";
            $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
            $logInsertData = $this->paramToArray(url()->full(),'Variation Update','Onbuy',1,$request->sku,$update_info,null,Auth::user()->name,null,$request->stock,Carbon::now(),2,2);
            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            //dd($result_info);
            $data = json_decode($result_info);
            if(isset($data->success)){
                if(isset($data->results[0]->error)){
                    $updateResponse = $this->updateResponse($logInsertData->id,$result_info,0,0);
                }else{
                    $updateResponse = $this->updateResponse($logInsertData->id,$result_info,1,1);
                }
            }else{
                $updateResponse = $this->updateResponse($logInsertData->id,$result_info,0,0);
            }
        }catch(\Exception $exception){
            $logInsertData = $this->paramToArray(url()->full(),'Variation Update','Onbuy',1,$request->sku,$update_info,$exception,Auth::user()->name,null,$request->stock,Carbon::now(),0,0);
        }

        $update_info = OnbuyVariationProducts::where('id',$id)->update([
            'sku' => $request->updated_sku ?? $request->sku,
            'price' => $request->price,
            'stock' => $request->stock,
            'base_price' => $request->base_price ?? null,
            'max_price' => $request->max_price
        ]);

        return back()->with('success','Listing updated successfully');

        echo "<pre>";
        print_r($data);
        exit();

    }

    public function duplicateMasterProduct($id){
        $access_token = $this->access_token();

        $single_master_product_info = OnbuyMasterProduct::with('category_info:category_id,name','brand_info:brand_id,name')->find($id);
//        echo "<pre>";
//        print_r(json_decode($single_master_product_info));
//        exit();

        $url = "https://api.onbuy.com/v2/categories/".$single_master_product_info->category_info->category_id."/variants?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $category_data = json_decode($result_info1);

        $url = "https://api.onbuy.com/v2/categories/".$single_master_product_info->category_info->category_id."/technical-details?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $technical_data = json_decode($result_info2);
//        echo "<pre>";
//        print_r(json_decode($master_product_info));
//        exit();
        $content = view('onbuy.master_product.duplicate_master_product',compact('single_master_product_info','category_data','technical_data'));
        return view('master',compact('content'));
    }

    public function saveDuplicateMasterProduct(Request $request,$id){
//        echo "<pre>";
//        print_r($m_t_d);
//        exit();

//        $access_token = $this->access_token();

//        echo "<pre>";
//        print_r(json_encode($data4,JSON_PRETTY_PRINT));
//        exit();

        foreach ($request->m_tectnical_details as $details) {
            $m_t_d[] = [
                "detail_id" => explode('/', $details)[0],
                "value" => explode('/', $details)[1]
            ];
        }
//        echo "<pre>";
//        print_r($m_t_d);
//        exit();

        foreach ($request->m_label as $key => $value) {
            $m_p_d[] = [
                "label" => $value,
                "value" => $request->m_value[$key]
            ];
        }

        $variant_loop_count = 1;
        $count = 0;
        foreach ($request->product_codes as $key => $value) {

            if ($request->product_variant_option[$key] != null) {
                foreach ($request->product_variant_option[$key] as $variation) {
                    if ($variation != null) {
                        $op_value = $variation;
                        $count++;
                    }
                }
            }

            if (!isset($request->custom_variant[$key])) {
                foreach ($request->product_variant_option[$key] as $variation) {
                    if ($variation != null) {
                        $test1["variant_" . $variant_loop_count] = [
                            "option_id" => explode('/', $variation)[0]
                        ];
                        $option_value1["variant_" . $variant_loop_count] = [
                            "option_id" => $variation
                        ];
                        $variant_loop_count++;
                    }
                }
            } elseif (isset($request->custom_variant[$key]) && $count > 0) {
                $test1["variant_1"] = [
                    "option_id" => explode('/', $op_value)[0]
                ];
                $option_value1["variant_1"] = [
                    "option_id" => $op_value
                ];
                $test1["variant_2"] = [
                    "name" => $request->custom_variant[$key]
                ];
                $option_value1["variant_2"] = [
                    "name" => $request->custom_variant[$key]
                ];
            } else {
                $test1["variant_1"] = [
                    "name" => $request->custom_variant[$key]
                ];
                $option_value1["variant_1"] = [
                    "name" => $request->custom_variant[$key]
                ];
            }

            $test3 = [
//                "mpn" => '',
                "product_codes" => [
                    $request->product_codes[$key]
                ],
//                "summary_points" => $request->m_summary_points,
//                "product_name" => $request->m_product_name,
//                "description" => '',
                "default_image" => $request->default_image,
                "additional_images" =>  $request->images,
//                "rrp" => $request->m_rrp,
//                "product_data" => $m_p_d,
                "technical_detail" => $m_t_d,
                "listings" => [
                    "new" => [
                        "sku" => $request->sku[$key],
                        "group_sku" => $request->gro_sku[$key],
                        "price" => $request->m_rrp,
                        "stock" => $request->stock[$key],
                        "handling-time" => $request->h_time[$key]
                    ]
                ]
            ];
            $variant_loop_count = 1;
            $variant_info[] = array_merge($test1, $test3);
            $variant_db_info[] = array_merge($option_value1, $test3);
        }

//        echo "<pre>";
//        print_r(json_encode($variant_info,JSON_PRETTY_PRINT));
//        exit();

        $data1 = [
            "site_id" => 2000,
            "category_id" => $request->last_cat_id,
            "published" => "1",
            "brand_id" => $request->brand_id,
            "mpn" => '',
//            "product_codes" => [
//                $request->m_product_codes
//            ],
            "summary_points" => $request->m_summary_points,
            "product_name" => $request->m_product_name,
            "description" => $request->m_product_description,
            "default_image" => $request->default_image,
            "additional_images" => $request->images,
            "rrp" => $request->m_rrp,
            "product_data" => $m_p_d
        ];
        $variant_loop_counts = 0;
        if ($request->m_variant != null) {
            foreach ($request->m_variant as $m_variant) {
                if ($m_variant != null) {
                    $variant_loop_counts++;
                }
            }
        }

//        for parent single variant option
//        foreach ($request->product_variant_option as $variation) {
//            foreach ($variation as $var){
//                if($var != null) {
//                    $option[] = [
//                        "option_id" => $var
//                    ];
//                }
//            }
//        }

//        echo "<pre>";
//        print_r($variant_loop_counts);
//        exit();

        if (!isset($request->m_custom_variant)) {
            if ($variant_loop_counts == 1) {
                $option = array();
                foreach ($request->product_variant_option as $variation) {
                    foreach ($variation as $var) {
                        if ($var != null) {
                            $option[] = [
                                "option_id" => $var
                            ];
                        }
                    }
                }
                foreach ($request->m_variant as $m) {
                    if ($m != null) {
//                        $attr_1_value = explode('/',$m);
                        $data2_variant_1 = $m;
                        $data2 = [
                            "variant_1" => [
                                "feature_id" => explode('/', $m)[0]
//                    "options" => $option
                            ]
                        ];
                    }
                }
            }

            if ($variant_loop_counts == 2) {
                $i = 0;
                foreach ($request->product_variant_option as $variation) {
//                echo "<pre>";
//                print_r($variation);
//                exit();

//                foreach ($variation as $var){
//                for ($i = 0 ; $i <= count($variation) - 1 ; $i++) {
//                    if ($variation[$i] != null) {
                    $option1[] = [
                        "option_id" => $variation[$i]
                    ];
//                        $option2[] = [
//                            "option_id" => $variation[$i+1]
//                        ];
                    for ($j = $i; $j < count($variation) - 1; $j++) {
                        if ($variation[$j + 1] != null) {
                            $option2[] = [
                                "option_id" => $variation[$j + 1]
                            ];
                            $i = 0;
                            break;
                        }
                    }

//                    }
//                    else{
//                        $i++;
//                    }
//                }

//                }
//                $i++;
                }

//                    echo "<pre>";
//        print_r($option2);
//        exit();
                $k = 0;
                foreach ($request->m_variant as $m_v) {
                    if ($m_v != null) {
                        $master_variant[] = $m_v;
                    }
                }

//                $attr_2_value_1 = explode('/',$master_variant[0]);
//                $attr_2_value_2 = explode('/',$master_variant[1]);

                $data2_variant_1 = $master_variant[0];
                $data2_variant_2 = $master_variant[1];

                $data2 = [
                    "variant_1" => [
                        "feature_id" => explode('/', $master_variant[0])[0]
//                    "options" => $option1
                    ],
                    "variant_2" => [
                        "feature_id" => explode('/', $master_variant[1])[0]
//                    "options" => $option2
                    ]
                ];
            }
        } elseif (isset($request->m_custom_variant) && $variant_loop_counts > 0) {
//            return $variant_loop_counts;
            foreach ($request->m_variant as $m_v) {
                if ($m_v != null) {
                    $master_variant[] = $m_v;
                }
            }
//            $attr_1_cus_value_1 = explode('/',$master_variant[0]);
            $data2_variant_1 = $master_variant[0];
            $data2 = [
                "variant_1" => [
                    "feature_id" => explode('/', $master_variant[0])[0]
                ],
                "variant_2" => [
                    "name" => $request->m_custom_variant
                ]
            ];
        } else {
            $data2 = [
                "variant_1" => [
                    "name" => $request->m_custom_variant
                ]
            ];
        }

//        echo "<pre>";
//        print_r($data2);
//        exit();

        $data3 = [
            "variants" => $variant_info
        ];

        $features = null;
        $db_features = null;

        if (isset($request->m_feature)) {
            foreach ($request->m_feature as $value) {
                if ($value != null) {
                    $db_features[] = [
                        "option_id" => $value
                    ];
                    $features[] = [
                        "option_id" => explode('/', $value)[0]
                    ];
                }
            }
        }
        $data4 = array();
        if (isset($features)) {
            $data4 = [
                "features" => $features
            ];
        }


        $datas = array_merge($data1, $data2, $data3, $data4);
        $product_info = json_encode($datas, JSON_PRETTY_PRINT);
        echo "<pre>";
        print_r($product_info);
        exit();

        $access_token = $this->access_token();

        $url = "https://api.onbuy.com/v2/products";
        $post_data = $product_info;
        $method = "POST";
        $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        $data = json_decode($result_info, JSON_PRETTY_PRINT);

        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];

        $result = (object)$data;

        if(isset($result->queue_id)) {

            $variant_db_info = json_decode(json_encode($variant_db_info));
            $data2 = json_decode(json_encode($data2));

            $insert_info = OnbuyMasterProduct::where('id',$id)->update([
                'opc' => $rand,
                'woo_catalogue_id' => $request->catalogue_id,
                'master_category_id' => $request->last_cat_id,
                'master_brand_id' => $request->brand_id,
                'summary_points' => json_encode($request->m_summary_points) ?? null,
                'published' => 1,
                'product_name' => $request->m_product_name,
                'queue_id' => $result->queue_id ?? $rand,
                'description' => $request->m_product_description,
                'default_image' => $request->default_image,
                'additional_images' => json_encode($request->images) ?? null,
                'product_data' => json_encode($m_p_d) ?? null,
                'features' => json_encode($db_features) ?? null,
                'rrp' => $request->m_rrp,
                'low_quantity' => 5,
                'status' => 'pending'
            ]);

            foreach ($variant_db_info as $variant) {
//            echo "<pre>";
//            print_r($variant);
//            exit();
                $info = OnbuyVariationProducts::create([
                    'sku' => $variant->listings->new->sku,
                    'master_product_id' => $id,
                    'queue_id' => $result->queue_id ?? $rand,
                    'opc' => $rand,
                    'ean_no' => $variant->product_codes[0],
                    'attribute1_name' => $data2_variant_1 ?? $data2->variant_1->name ?? null,
                    'attribute1_value' => $variant->variant_1->option_id ?? $variant->variant_1->name ?? null,
                    'attribute2_name' => $data2_variant_2 ?? $data2->variant_2->name ?? null,
                    'attribute2_value' => $variant->variant_2->option_id ?? $variant->variant_2->name ?? null,
                    'name' => $request->m_product_name,
                    'group_sku' => $variant->listings->new->group_sku ?? null,
                    'price' => $variant->listings->new->price ?? null,
                    'stock' => $variant->listings->new->stock ?? null,
                    'technical_detail' => json_encode($m_t_d) ?? null,
//                'product_listing_id' => $variant->listing->new->sku,
//                'product_listing_condition_id' => $variant->listing->new->sku,
                    'condition' => "new",
//                'product_encoded_id' => $variant->listing->new->sku,
//                'delivery_weight' => $variant->listing->new->sku,
//                'delivery_template_id' => $variant->listing->new->sku,
//                'boost_marketing_commission' => $variant->listing->new->sku,
                    'low_quantity' => 5
                ]);
            }
            return redirect('onbuy/master-product-list')->with('success','Product added successfully');
        }else{
            return back()->with('error',$data['error']['message']);
        }

        echo "<pre>";
        print_r($data);
        exit();
        echo $response;

    }

    public function addExistEanListing(Request $request){
        $catalogueId = $request->get('catalogue_id');
        $existEAN = $request->get('exist_ean');
        $existOPC = $request->get('exist_opc');
        $productId = $request->get('product_id');
        $profileId = $request->get('profile_id');
        $onbuyBrand = OnbuyBrand::all();
        $allProfile = OnbuyProfile::all();
        $profileInfo = [];
        if($profileId){
            $profileInfo = OnbuyProfile::find($profileId);
        }
        // $productInfo = ProductVariation::where('ean_no',$existEAN)->first();
        $productInfo = ProductVariation::find($productId);
//        echo '<pre>';
//        print_r(\Opis\Closure\unserialize($productInfo->attribute));
//        exit();

//        $access_token = $this->access_token();
//
//        $url = "https://api.onbuy.com/v2/categories/".$profileInfo->last_category_id."/variants?site_id=2000";
//        $post_data = null;
//        $method = "GET";
//        $http_header = array("Authorization: ".$access_token);
//        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
//        $category_data = json_decode($result_info);
//        echo '<pre>';
//        print_r($category_data);
//        exit();

        $content = view('onbuy.variant_product.add_listing_existing_ean',compact('catalogueId','existEAN','existOPC','productId','profileId','onbuyBrand','profileInfo','productInfo','allProfile'));
        return view('master',compact('content'));
    }

    public function saveExistEanListing(Request $request){
    //    echo '<pre>';
    //    print_r($request->all());
    //    exit();
        $attribute1_name = null;
        $attribute1_value = null;
        $attribute2_name = null;
        $attribute2_value = null;
        if(isset($request->variation_terms) && count($request->variation_terms) > 0){
            $arr_total = count($request->variation_terms);
            $j = 0;
            for ($i = 0; $i < $arr_total; $i++) {
                foreach ($request->variation_terms[$i] as $key => $value) {
                    if ($value != '') {
                        if($j == 0) {
                            $attribute1_name = $key;
                            $attribute1_value = $value;
                            $j++;
                        }elseif($j == 1){
                            $attribute2_name = $key;
                            $attribute2_value = $value;
                        }
                    }
                }
            }

            if($j > 1){
                return back()->with('error','Maximum two attribute allowed');
            }
        }


//        echo '<pre>';
//        print_r($attribute2_name);
//        exit();
//        dd($request->all());
        $access_token = $this->access_token();
        if($access_token) {
            $catalogueId = $request->master_catalogue;
            $existOPC = $request->exist_opc;
            $existEAN = $request->exist_ean ?? null;
            $productId = $request->productId;
            $brandId = $request->brand_id;
            $profileId = $request->profileId;
            $data = [
                "site_id" => 2000,
                "listings" => [
                    $request->condition => [
                        "sku" => $request->sku,
                        "group_sku" => $request->group_sku ?? null,
                        "price" => $request->price,
                        "stock" => $request->stock ?? 0
                    ]
                ]
            ];
            $post_data = json_encode($data, JSON_PRETTY_PRINT);
//        echo "<pre>";
//        print_r(json_encode($data,JSON_PRETTY_PRINT));
//        exit();

            $url = "https://api.onbuy.com/v2/products/".$existOPC."/listings";
            $method = "POST";
            $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
            $result = $this->curl_request_send($url, $method, $post_data, $http_header);
            $res_result = json_decode($result);
            $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $rand = '';
            foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];

            $existOnbuyMasterCatalogue = OnbuyMasterProduct::where('woo_catalogue_id',$catalogueId)->first();
            $masterCatalogueInfo = ProductDraft::with(['single_image_info' => function($img) {
                $img->where('deleted_at',null);
            },'images'])->find($catalogueId);
            $masterImages = $this->getMasterCatalogueImageAsArray($catalogueId); //used common function trait
            if (!$existOnbuyMasterCatalogue) {
                $profileInfo = OnbuyProfile::find($profileId);
                $insert_info = OnbuyMasterProduct::create([
                    'opc' => $existOPC ?? $rand,
                    'product_id' => $productId ?? null,
                    'woo_catalogue_id' => $catalogueId,
                    'master_category_id' => $profileInfo->last_category_id,
                    'master_brand_id' => $brandId,
                    'product_type' => $masterCatalogueInfo->product_type ?? null,
                    'summary_points' => null,
                    'published' => 1,
                    'product_name' => $masterCatalogueInfo->name,
                    'queue_id' => $rand,
                    'description' => $masterCatalogueInfo->description,
                    'default_image' => $masterCatalogueInfo->single_image_info ? asset('/'). $masterCatalogueInfo->single_image_info->image_url : null,
                    'additional_images' => empty($masterImages) ? null : json_encode($masterImages),
                    'product_data' => null,
                    'features' => null,
                    'rrp' => $masterCatalogueInfo->rrp ?? null,
                    'low_quantity' => 2,
                    'status' => 'success'
                ]);
                $onbuyMasterCatalogueId = $insert_info->id;
            } else {
                $onbuyMasterCatalogueId = $existOnbuyMasterCatalogue->id;
            }

            $info = OnbuyVariationProducts::create([
                'sku' => $request->sku,
                'master_product_id' => $onbuyMasterCatalogueId,
                'queue_id' => $rand,
                'opc' => $existOPC ?? $rand,
                'ean_no' => $existEAN ?? null,
                'attribute1_name' => $attribute1_name ?? null,
                'attribute1_value' => $attribute1_value ?? null,
                'attribute2_name' => $attribute2_name ?? null,
                'attribute2_value' => $attribute2_value ?? null,
                'name' => $masterCatalogueInfo->name,
                'group_sku' => $request->group_sku ?? null,
                'price' => $request->price ?? '0.00',
                'stock' => $request->stock ?? 0,
                'technical_detail' => null,
                'condition' => $request->condition,
                'low_quantity' => 2
            ]);
            return back()->with('success', 'Product Listing Added Successfully');
        }
    }

    public function addListing($id){
        $opc = OnbuyVariationProducts::find($id)->opc;
        $exit_condition = OnbuyVariationProducts::select('condition')->where([['opc',$opc],['condition','!=','new']])->distinct()->get();
        $conditions = [

            [
                'condition' => 'excellent'
            ],
            [
                'condition' => 'verygood'
            ],
            [
                'condition' => 'good'
            ],
            [
                'condition' => 'average'
            ],
            [
                'condition' => 'belowaverage'
            ]
        ];

        $condition_arr = array();
        $exit_arr = array();

        foreach($conditions as $condition){
            $condition_arr[] = $condition['condition'];
        }

        foreach($exit_condition as $exit){
            $exit_arr[] = $exit['condition'];
        }
        $new_condition = array_diff($condition_arr,$exit_arr);

//        echo "<pre>";
//        print_r($new_condition);
//        exit();
        $content = view('onbuy.variant_product.add_listing',compact('id','conditions','new_condition'));
        return view('master',compact('content'));
    }

    public function saveListings(Request $request,$id){
        $access_token = $this->access_token();
        $single_variation_info = OnbuyVariationProducts::find($id);

        $data = [
            "site_id" => 2000,
            "listings" => [
                explode('/',$request->condition)[0] => [
                    "sku" => $request->sku,
                    "group_sku" => $request->group_sku ?? null,
                    "price" => $request->price,
                    "stock" => $request->stock ?? null
                ]
            ]
        ];

        $post_data = json_encode($data,JSON_PRETTY_PRINT);

//        echo "<pre>";
//        print_r(json_encode($data,JSON_PRETTY_PRINT));
//        exit();

        $url = "https://api.onbuy.com/v2/products/".$single_variation_info->opc."/listings";
        $method = "POST";
        $http_header = array("Authorization: ".$access_token, "Content-Type: application/json");
        $result = $this->curl_request_send($url, $method, $post_data, $http_header);



//        echo "<pre>";
//        print_r(json_decode($single_variation_info));
//        exit();
        $info = OnbuyVariationProducts::create([
            'sku' => $request->sku,
            'master_product_id' => $single_variation_info->master_product_id,
            'queue_id' => $single_variation_info->queue_id,
            'opc' => $single_variation_info->opc,
            'ean_no' => $single_variation_info->ean_no,
            'attribute1_name' => $single_variation_info->attribute1_name ?? null,
            'attribute1_value' => $single_variation_info->attribute1_value ?? null,
            'attribute2_name' => $single_variation_info->attribute2_name ?? null,
            'attribute2_value' => $single_variation_info->attribute2_value ?? null,
            'name' => $single_variation_info->name,
            'group_sku' => $request->group_sku ?? null,
            'price' => $request->price ?? null,
            'stock' => $request->stock ?? null,
            'technical_detail' => $single_variation_info->technical_detail ?? null,
            'condition' => $request->condition,
            'low_quantity' => 5
        ]);

        return back()->with('success','Listing added successfully');

        echo "<pre>";
        print_r(json_decode($result));
        exit();

    }

    public function deleteListing($master_id,$listing_id = null){
        if($listing_id == null){
            $sku_arr = [];
            $skus = OnbuyVariationProducts::select('sku')->where('master_product_id',$master_id)->get();
            foreach ($skus as $sku){
                array_push($sku_arr,$sku->sku);
            }
        }else{
            $sku_arr = [];
            $sku = OnbuyVariationProducts::find($listing_id)->sku;
            array_push($sku_arr,$sku);
        }
        $access_token = $this->access_token();
        $data = [
            "site_id" => 2000,
            "skus" => $sku_arr
        ];
        $url = "https://api.onbuy.com/v2/listings/by-sku";
        $post_data = json_encode($data,JSON_PRETTY_PRINT);
        $method = "DELETE";
        $http_header = array("Authorization: ".$access_token, "Content-Type: application/json");
        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);

        $result_info = json_decode($result_info);
        if(isset($result_info->results)){
            if($listing_id == null){
                $master = OnbuyMasterProduct::find($master_id);
                $master->variation_product()->delete();
                $master_del = OnbuyMasterProduct::find($master_id)->delete();
            }else{
                $delete_info = OnbuyVariationProducts::find($listing_id)->delete();
            }
        }else{
            if($listing_id == null){
                $master = OnbuyMasterProduct::find($master_id);
                $master->variation_product()->delete();
                $master->delete();
            }else{
                $delete_info = OnbuyVariationProducts::find($listing_id)->delete();
            }
        }

        return back()->with('success','Deleted successfully');

        echo "<pre>";
        print_r(json_encode($data,JSON_PRETTY_PRINT));
        exit();

    }

    /*
      * Function : profileList
      * Route : profile-list
      * Method Type : GET
      * Parametes : null
      * Creator : Kazol
      * Modifier : Solaiman
      * Description : This function is used for displaying Profile list and pagination
      * Created Date: unknown
      * Modified Date : 10-12-2020
      * Modified Content : Screen option Pagination
      * Modified Content : Screen option Pagination
      */

    public function profileList()
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('onbuy', 'onbuy_profile');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

//        $profile_lists = OnbuyProfile::get()->all();
        $profile_lists = OnbuyProfile::paginate($pagination);
        $all_decode_profile_list = json_decode(json_encode($profile_lists));
        $content = view('onbuy.profile.profile_list',compact('profile_lists', 'setting', 'page_title', 'pagination','all_decode_profile_list'));
        return view('master',compact('content'));

    }

    public function createProfile(){
        //$catalogue_info = ProductDraft::with('images')->find($id);
        $brand_info = DB::table('onbuy_brands')->orderBy('name')->get();
        $all_parent_category = DB::table('onbuy_categories')->where('lvl',2)->orderBy('name','ASC')->get();
//        echo "<pre>";
//        print_r(json_decode($brand_info));
//        exit();
        $content = view('onbuy.profile.create_profile',compact('all_parent_category','brand_info'));
        return view('master',compact('content'));
    }

    public function editProfile($id){
        $profile_result = OnbuyProfile::find($id);
//        echo "<pre>";
//        print_r($profile_result);
//        exit();
        $brand_info = DB::table('onbuy_brands')->orderBy('name')->get();
        $feature_array = unserialize($profile_result->features);
        $technical_details = unserialize($profile_result->technical_details);
//                echo "<pre>";
//        print_r(explode('/',$feature_array[0])[0]);
//        exit();
        //$all_parent_category = DB::table('onbuy_categories')->where('lvl',2)->orderBy('name','ASC')->get();
//        echo "<pre>";
//        print_r(json_decode($brand_info));
//        exit();
        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/variants?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $category_data = json_decode($result_info1);


        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/technical-details?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $technical_data = json_decode($result_info2);
        $content = view('onbuy.profile.edite_profile',compact('profile_result','brand_info','category_data','technical_data','feature_array','technical_details'));
        return view('master',compact('content'));
    }

    public function updateProfile(Request $request,$id){
        $profile_result = OnbuyProfile::find($id);
        $profile_result->name = $request->name;
        $profile_result->brand = $request->brand_id;
        $profile_result->summery_points = serialize($request->m_summary_points);
        $profile_result->master_product_data = serialize(array_combine($request->m_label,$request->m_value));
        $profile_result->features = serialize($request->m_feature);
        $profile_result->technical_details = serialize($request->m_tectnical_details);

        $profile_result->save();

        return redirect('onbuy/profile-list')->with('success','profile updated');
    }

    public function deleteProfile($id){
        OnbuyProfile::destroy($id);
        return redirect('onbuy/profile-list')->with('success','profile deleted');
    }

    public function saveProfile(Request $request){

        $result = OnbuyProfile::create(['name' =>  $request->name,'brand' =>  $request->brand_id,'category_ids' =>  serialize($request->child_cat),'last_category_id' =>  $request->last_cat_id,'summery_points' =>  serialize($request->m_summary_points),
            'master_product_data' =>  serialize(array_combine($request->m_label,$request->m_value)),'features' =>  serialize($request->m_feature),'technical_details' =>  serialize($request->m_tectnical_details)]);
        return redirect('onbuy/create-profile')->with('success','profile created');
    }

    public function createAjaxPage(Request $request){
        $catalogue_info = ProductDraft::with('images')->find($request->catalogue_id);

        $profile_result = OnbuyProfile::find($request->profile_id);
//        echo "<pre>";
//        print_r($profile_result);
//        exit();
        $brand_info = DB::table('onbuy_brands')->orderBy('name')->get();
        $feature_array = unserialize($profile_result->features);
        $technical_details = unserialize($profile_result->technical_details);
//                echo "<pre>";
//        print_r(explode('/',$feature_array[0])[0]);
//        exit();
        //$all_parent_category = DB::table('onbuy_categories')->where('lvl',2)->orderBy('name','ASC')->get();
//        echo "<pre>";
//        print_r(json_decode($brand_info));
//        exit();
        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/variants?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $category_data = json_decode($result_info1);


        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/technical-details?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $technical_data = json_decode($result_info2);
        $content = view('onbuy.listing_ajax',compact('profile_result','brand_info','category_data','technical_data','feature_array','technical_details','catalogue_info'));
//        print_r($request->profile_id);
//        exit();
        return $content;
    }
    public function ajaxProfileCategoryChildList(Request $request){

        $category_id = $request->category_id;
        $category_label = DB::table('onbuy_categories')->where('category_id',$category_id)->first();
        $label = $category_label->lvl;
        $dependent_category = DB::table('onbuy_categories')->where('parent_id',$category_id)->orderBy('name','ASC')->get();
        if(count($dependent_category) > 0){
            $output = '<div class="col-md-2"></div><div class="col-md-10 m-t-5 controls" id="category-level-'.$category_label->lvl.'-group">
                        <select class="form-control category_select" name="child_cat['.$category_label->lvl.']" id="child_cat_'.$category_label->lvl.'" onchange="myFunction('.$category_label->lvl.')">
                        <option value="">Select Category</option>';
            foreach($dependent_category as $category)
            {
                $output .= '<option value="'.$category->category_id.'">'.$category->name.'</option>';
            }
            $output .= '</select></div>';
            return response()->json(['data' => 1,"content" => $output, 'lavel' => $label - 1]);
        }else{

            $access_token = $this->access_token();
            $url = "https://api.onbuy.com/v2/categories/".$category_id."/variants?site_id=2000";
            $post_data = null;
            $method = "GET";
            $http_header = array("Authorization: ".$access_token);
            $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
            $category_data = json_decode($result_info1);


            $url = "https://api.onbuy.com/v2/categories/".$category_id."/technical-details?site_id=2000";
            $post_data = null;
            $method = "GET";
            $http_header = array("Authorization: ".$access_token);
            $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
            $technical_data = json_decode($result_info2);

            $variant_view = view('onbuy.create_profile_ajax',compact('category_data','technical_data'));
            echo $variant_view;
        }
//        return response()->json(['data' => $dependent_category]);
    }

    public function searchProfile(Request $request){
        $profile_lists = OnbuyProfile::where('name','like', '%' .$request->search_value.'%')->orWhere('last_category_id',$request->search_value)->get();
        $result_view = view('onbuy.profile.ajax_search_profile',compact('profile_lists'));;
        echo $result_view;
    }

    public function duplicateProfile($id){
        $profile_result = OnbuyProfile::find($id);
        $brand_info = DB::table('onbuy_brands')->orderBy('name')->get();
        $feature_array = unserialize($profile_result->features);
        $technical_details = unserialize($profile_result->technical_details);
        $all_parent_category = DB::table('onbuy_categories')->where('lvl',2)->orderBy('name','ASC')->get();

        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/variants?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $category_data = json_decode($result_info1);


        $url = "https://api.onbuy.com/v2/categories/".$profile_result->last_category_id."/technical-details?site_id=2000";
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info2 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $technical_data = json_decode($result_info2);
        $content = view('onbuy.profile.duplicate_profile',compact('profile_result','brand_info','category_data','technical_data','feature_array','technical_details','all_parent_category'));
        return view('master',compact('content'));
    }

    public function saveDuplicateProfile(Request $request){
        $result = OnbuyProfile::create(['name' =>  $request->name,'brand' =>  $request->brand_id,'category_ids' =>  $request->last_cat_id ? serialize($request->child_cat) : $request->category_ids,'last_category_id' =>  $request->last_cat_id ?? $request->exist_cat_id,'summery_points' =>  serialize($request->m_summary_points),
            'master_product_data' =>  serialize(array_combine($request->m_label,$request->m_value)),'features' =>  serialize($request->m_feature),'technical_details' =>  serialize($request->m_tectnical_details)]);
        return redirect('onbuy/create-profile')->with('success','profile created');
    }

    public function _searchProductList(Request $request){
        $master_product_list = OnbuyMasterProduct::with('category_info','variation_product')
            ->withCount('variation_product')
            ->where('opc','like', '%' .$request->name. '%')->orWhere('woo_catalogue_id','like', '%' .$request->name. '%')->orWhere('product_name','like', '%' .$request->name. '%')
            ->orderByDesc('id')->get();
        $decode_master_product = json_decode(json_encode($master_product_list));

        echo view('onbuy.master_product.search_master_product',compact('master_product_list','decode_master_product'));
    }
    public function searchProductList(Request $request){

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
                $find_variation = OnbuyVariationProducts::where('ean','=',$search_keyword)->get()->first();
                if ($find_variation != null){
                    array_push($matched_product_array,$find_variation->id);
                    $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
                    $search_result = $search_draft_result['search'];
                    $ids = $search_draft_result['ids'];
                    return response()->json(['html' => view('onbuy.master_product.search_master_product', compact('search_result'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
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
                    return response()->json(['html' => view('onbuy.master_product.search_master_product', compact('search_result'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
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

                return response()->json(['html' => view('onbuy.master_product.search_master_product', compact('search_result'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);
            }

        }else{
            if (strpos($search_keyword," ") != null){

                $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                $search_priority = $search_result_by_word["search_priority"];
                $ids = $search_result_by_word["ids"];
                return response()->json(['html' => view('onbuy.master_product.search_master_product', compact('search_result'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);

            }else{

                $search_sku_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $search_result = $search_sku_result['search'];
                $ids = $search_sku_result['ids'];
                if ($search_result == null){

                        $find_item = OnbuyMasterProduct::where('opc','=',$search_keyword)->get()->first();

                        if ($find_item != null){
                            array_push($matched_product_array,$find_item->id);
                            $search_draft_result = $this->getProductDraft('id',$matched_product_array,$status,$take,$skip,$ids);
                            $search_result = $search_draft_result['search'];
                            $ids = $search_draft_result['ids'];

                        }else{
                            $skip = 0;
                            $search_result_by_word = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                            $search_result = $search_result_by_word["search"];
                            $search_priority = $search_result_by_word["search_priority"];
                            $ids = $search_result_by_word["ids"];
                        }


                }

                return response()->json(['html' => view('onbuy.master_product.search_master_product', compact('search_result'))->render(),'search_priority' => $search_priority,'skip' => $skip,'ids' => $ids]);

            }

        }

//        echo view('onbuy.master_product.search_master_product',compact('master_product_list','decode_master_product'));
    }
    public function searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids){
        $matched_product_array = array();
        $search_result = null;
        $find_sku  =  OnbuyVariationProducts::where('sku','=',$search_keyword)
            //->where('status',$status)
            ->get()->first();
        if ($find_sku != null) {
            array_push($matched_product_array, $find_sku->master_product_id);
            $search_draft_result = $this->getProductDraft('id', $matched_product_array, $status, $take, $skip, $ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }
        return ['search'=>$search_result,'ids' => $ids];
    }

    public function searchAsId($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $find_variation = OnbuyVariationProducts::where('id','=',$search_keyword)->get()->first();
        $find_draft = OnbuyMasterProduct::where('woo_catalogue_id','=',$search_keyword)->get()->first();
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

        return ['search'=>$search_result,'ids' => $ids];
    }
    public function getProductDraft($column_name,$word,$status,$take,$skip,$ids){
        $search_result = OnbuyMasterProduct::with('variation_product')->whereIn($column_name,$word)->whereNotIn('id', $ids)
            ->withCount('variation_product')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function firstPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $search_result = OnbuyMasterProduct::where('product_name','REGEXP',"[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)
            ->with('variation_product')
            ->withCount('variation_product')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();
        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function secondPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = OnbuyMasterProduct::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->where('product_name','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)->with('variation_product')
            ->withCount('variation_product')
            //->where('status',$status)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->skip($skip)->take(10)->get();
        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function thirdPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = OnbuyMasterProduct::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->orWhere('product_name','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)->with('variation_product')
            ->withCount('variation_product')
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
    * Function : pendingCatalogueListing
    * Route Type : pending-catalogue-listing/with-ean
    * Method Type : GET
    * Parametes : $ean
    * creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for displaying OnBuy pending EAN Product List and pagination
    * Modified Date : 3-12-2020
    * Modified Content : Screen option table column hide show and pagination
    */

    public function pendingCatalogueListing(Request $request ,$ean)
    {

        //Start page title and pagination setting
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        $settingData = $this->paginationSetting('onbuy', 'onbuy_pending_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

        $shelfUse = $this->shelf_use;

        $total_catalogue = ProductDraft::whereDoesntHave('onbuy_product_info', function($woocom){
                $woocom->whereRaw('id != onbuy_master_products.woo_catalogue_id');
            })
            ->whereHas('ProductVariations', function($query) use ($ean){
            $query->havingRaw('sum(actual_quantity) > 0');
            if($ean == 'with-ean') {
                $query->where('ean_no','!=',null);
            }else{
                $query->where('ean_no','=',null);
            }
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

                //dd($allCondition);
            }
//            ->whereIn('id', $notExistIds)
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        $total_catalogue = $total_catalogue->orderBy('id', 'DESC')->paginate($pagination);
        if($request->has('is_clear_filter')){
            $search_result = $total_catalogue;
            $view = view('onbuy.master_product.pending_catalogue_ajax', compact('search_result'))->render();
            return response()->json(['html' => $view]);
        }

        $users = User::orderBy('name', 'ASC')->get();
        $total_catalogue_info = json_decode(json_encode($total_catalogue));

        return view('onbuy.master_product.pending_catalogue_listing',compact('total_catalogue','total_catalogue_info','users','ean','shelfUse', 'setting', 'page_title', 'pagination','url','allCondition'));

    }



    public function columnSearch(Request $request){
        $column = $request->column_name;
        $value = $request->search;
        $master_product_list = OnbuyMasterProduct::with('category_info')
            ->where(function($result) use ($request, $column, $value){
                if($request->opt_out == 1){
                    $result->where($column,'NOT LIKE','%'.$value.'%');
                }else{
                    $result->where($column,'LIKE','%'.$value.'%');
                }
            })
            ->withCount('variation_product')
            ->orderByDesc('id')
            ->paginate(50);
        $decode_master_product = json_decode(json_encode($master_product_list));
        $total_product = OnbuyMasterProduct::count();
//        echo "<pre>";
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
        $content = view('onbuy.master_product.master_product_list',compact('master_product_list','decode_master_product','total_product'));
        return view('master',compact('content'));
    }

    public function accountCredentials(){
        $account_details = OnbuyAccount::with(['creatorInfo:id,name','modifierInfo:id,name'])->get();
        $content = view('onbuy.account_credentials',compact('account_details'));
        return view('master',compact('content'));
    }

    public function onbuyCreateAccount(Request $request){
        $existCheck = OnbuyAccount::where('consumer_key',$request->consumer_key)->orWhere('secret_key',$request->secret_key)
        ->orWhere('account_name',$request->account_name)->first();
        if($existCheck){
            return response()->json(['type' => 'error','msg' => 'Credentials Already Exists']);
        }
        try {
            $insert = OnbuyAccount::create([
                'consumer_key' => $request->consumer_key,
                'secret_key' => $request->secret_key,
                'account_name' => $request->account_name ?? null,
                'status' => $request->status ?? null,
                'creator' => Auth::id()
            ]);
            $channelUpdateStatus = Channel::where('channel_term_slug','onbuy')->update(['is_active' => 1]);
            if(isset($request->request_type)){
                return response()->json(['type' => 'success','msg' => 'Account Added Successfully']);
            }
            return back()->with('success','Account credential created successfully');
        }catch (\Exception $exception){
            if(isset($request->request_type)){
                return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
            }
            return back()->with('error',$exception->getMessage());
        }

    }

    public function updateAccount(Request $request, $id){
        try {
            $update_info = OnbuyAccount::find($id)->update([
                'consumer_key' => $request->consumer_key,
                'secret_key' => $request->secret_key,
                'modifier' => Auth::id()
            ]);
            return back()->with('success','Account credentials update successfully');
        }catch (\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }

    }

    public function queueIdBulkCheck(){
        $all_pending_queue_ids = OnbuyMasterProduct::select('id','opc','queue_id')->where('status','pending')->take(10)->get();
        if(count($all_pending_queue_ids) > 0){
            $ids_arr = [];
            $ids_string = '';
            foreach ($all_pending_queue_ids as $queue_id){
                $ids_arr[] = $queue_id->id;
                $ids_string .= $queue_id->queue_id.',';
            }
        }
        $access_token = $this->access_token();
        $url = "https://api.onbuy.com/v2/queues?site_id=2000&filter[limit]=100&filter[queue_ids]=".$ids_string;
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: ".$access_token);
        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
        $decode_result_data = json_decode($result_info);
        if(count($decode_result_data->results) > 0){
            foreach ($decode_result_data->results as $data) {
                if ($data->status == 'success') {
                    $master_opc = OnbuyMasterProduct::select('opc')->where('queue_id',$data->queue_id)->first();
                    $product_id = explode('/', substr($data->product_url, strpos($data->product_url, "~p") + 2))[0];
                    $master_product_update = OnbuyMasterProduct::where('queue_id', $data->queue_id)->update([
                        'product_id' => $product_id, 'opc' => $data->opc, 'status' => $data->status
                    ]);
                    $variation_ids = OnbuyVariationProducts::select('id')->where('queue_id', $data->queue_id)->get();
                    $variant_opc = json_decode(json_encode($data->variant_opcs));
                    $i = 0;
                    foreach ($variation_ids as $id) {
                        $variant_product_update = OnbuyVariationProducts::where([['id', $id->id], ['queue_id', $data->queue_id]])->update([
                            'opc' => $variant_opc[$i]
                        ]);
                        $i++;
                    }
//                return response()->json(['status' => $data->results->status, 'opc' => $data->opc]);
                }elseif ($data->status == 'failed'){
                    $master_opc = OnbuyMasterProduct::select('opc')->where('queue_id',$data->queue_id)->first();
                    $master_product_update = OnbuyMasterProduct::where('queue_id', $data->queue_id)->update([
                        'status' => $data->status
                    ]);
                }
            }
            return response()->json($decode_result_data);
        }else{
            return response()->json('no-data');
        }

    }



    /*
      * Function : failedCatalogueList
      * Route Type : failed-catalogue-list
      * Method Type : GET
      * Parametes : null
      * creator : Unknown
      * Modifier : Solaiman
      * Description : This function is used for displaying OnBuy Failed Product List and pagination
      * Modified Date : 3-12-2020
      * Modified Content : Screen option table column hide show and pagination
      */

    public function failedCatalogueList()
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('onbuy', 'onbuy_active_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

        $master_product_list = OnbuyMasterProduct::with('category_info','variation_product')->withCount('variation_product')->where('status','failed')->orderByDesc('id')->paginate($pagination);
        $decode_master_product = json_decode(json_encode($master_product_list));
        $total_product = OnbuyMasterProduct::where('status','failed')->count();
//        echo "<pre>";
//        print_r(json_decode(json_encode($master_product_list)));
//        exit();
        $content = view('onbuy.master_product.master_product_list',compact('master_product_list','decode_master_product','total_product', 'setting', 'page_title', 'pagination'));
        return view('master',compact('content'));
    }


    /*
     * Function : category
     * Route Type : onbuy/category
     * Method Type : GET
     * Parameters : Null
     * Creator : Unknown
     * Modifier : Solaiman
     * Description : This function is used for OnBuy Category list and pagination setting
     * Modified Date : 12/13/2020
     * Modified Content : Pagination setting
     */

    public function category(){
        try {

            //Start page title and pagination setting
            $settingData = $this->paginationSetting('onbuy', 'onbuy_category_list');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting


            $categories = OnbuyCategory::paginate($pagination);
            $decodeCategory = json_decode(json_encode($categories));
//            echo '<pre>';
//            print_r($decodeCategory->total);
//            exit();
//            dd($categories);
            $content = view('onbuy.category.category_list',compact('categories','decodeCategory', 'setting', 'page_title', 'pagination'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function categoryMigrate(Request $request){
        try {
            $access_token = $this->access_token();
            $i = 0;
            while(true){
                $url = "https://api.onbuy.com/v2/categories?site_id=2000&limit=100&offset=".$i;
                $post_data = null;
                $method = "GET";
                $http_header = array("Authorization: ".$access_token);
                $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                $category_data = json_decode($result_info);

                if(count($category_data->results) > 0) {
                    foreach ($category_data->results as $category) {
                        $create_info = OnbuyCategory::create([
                            'category_id' => $category->category_id,
                            'name' => $category->name,
                            'category_tree' => $category->category_tree ?? null,
                            'category_type_id' => $category->category_type_id,
                            'category_type' => $category->category_type ?? '',
                            'parent_id' => $category->parent_id,
                            'lvl' => $category->lvl,
                            'product_code_required' => $category->product_code_required,
                            'can_list_in' => $category->can_list_in
                        ]);
                        $i++;
                    }
                }else{
                    break;
                }
            }

            return response()->json($category_data);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }




    /*
     * Function : brand
     * Route Type : onbuy/brand
     * Method Type : GET
     * Parameters : Null
     * Creator : Unknown
     * Modifier : Solaiman
     * Description : This function is used for OnBuy Brand List and pagination setting
     * Modified Date : 12/13/2020
     * Modified Content : Pagination setting
     */


    public function brand(){
        try {

            //Start page title and pagination setting
            $settingData = $this->paginationSetting('onbuy', 'onbuy_brand_list');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting


            $brands = OnbuyBrand::paginate($pagination);
            $decodeBrand = json_decode(json_encode($brands));
            $content = view('onbuy.brand.brand_list',compact('brands','decodeBrand', 'setting', 'page_title', 'pagination'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function pullMatchedBrand(Request $request){
        try {
            $offset = ($request->currentPage - 1) * 100;
            $access_token = $this->access_token();
            $url = "https://api.onbuy.com/v2/brands?filter[name]=".$request->brandSearchValue."&sort[name]=asc&limit=100&offset=".$offset;
            $post_data = null;
            $method = "GET";
            $http_header = array("Authorization: ".$access_token);
            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $category_data = json_decode($result_info);
            return response()->json($category_data);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }
    }

    public function saveBrand(Request $request){
        try {
//            echo '<pre>';
//            print_r($request->all());
//            exit();
            if(isset($request->onbuy_brand_name) && count($request->onbuy_brand_name) > 0){
                $existBrandMsg = '';
                foreach ($request->onbuy_brand_name as $brand){
                    $splitedBrandName = explode('/',$brand);
                    $existBrand = OnbuyBrand::where('brand_id',$splitedBrandName[0])->first();
                    if(!$existBrand){
                        $brandCreateInfo = OnbuyBrand::create([
                            'brand_id' => $splitedBrandName[0],
                            'name' => $splitedBrandName[2],
                            'brand_type_id' => $splitedBrandName[1],
                            'type' => $splitedBrandName[3],
                        ]);
                    }else {
                        $existBrandMsg .= '<span class="text-danger">' . $existBrand->name . '</span>/';
                    }
                }
                return back()->with('success',($existBrandMsg != '') ? 'Brand added successfully ('.$existBrandMsg.' already exists)' : 'Brand added successfully');
            }else{
                return back()->with('error','Please select a brand');
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function bulkSalePriceBoostCommission(Request $request){
        try {
            if(count($request->catalogueIDs) > 0){
                $catalogueVariationInfo = OnbuyVariationProducts::select('sku','opc')->whereIn('master_product_id',$request->catalogueIDs)->get();
                if(count($catalogueVariationInfo) > 0){
                    $access_token = $this->access_token();
                    $i = 0;
                    foreach ($catalogueVariationInfo as $info){
                        $data[$i]['sku'] = $info->sku;
                        if($request->salePrice){
                            $data[$i]['sale_price'] = $request->salePrice;
                            $data[$i]['sale_start_date'] = $request->salePriceStartDate;
                            $data[$i]['sale_end_date'] = $request->salePriceEndDate;
                        }
                        if($request->boostCommission){
                            $data[$i]['boost_marketing_commission'] = $request->boostCommission;
                        }
                        $i++;
                    }
                    $update_info= [
                        "site_id" => 2000,
                        "listings" => $data
                    ];

                    $product_info = json_encode($update_info,JSON_PRETTY_PRINT);

                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                    $post_data = $product_info;
                    $method = "PUT";
                    $http_header = array("Authorization: ".$access_token,"Content-Type: application/json");
                    $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                    $response_data = json_decode($result_info);
                    if($response_data->success == true){
                        return response()->json(['data' => 'success','msg' => 'Information Updated Successfully']);
                    }else{
                        return response()->json(['data' => 'error','msg' => 'Something went wrong']);
                    }
                }
            }else{
                return response()->json(['data' => 'error','msg' => 'Please select at least one product']);
            }
        }catch (\Exception $exception){
            return response()->json(['data' => 'error','msg' => $exception->getMessage()]);
        }
    }

    public function leadListingCheck(){
        Log::info('all product check for lead listing start');
        $this->access_token = $this->access_token();
        $skus = [];
        $basePrice = [];
        $maxPrice = [];
        $skip = 0;
        $take = 100;
        while (true) {
            $onbuySkus = OnbuyVariationProducts::select('sku','base_price','max_price')->where([['base_price','!=',NULL],['max_price','!=',NULL],['stock', '>', 0]])->skip($skip)->take($take)->get();
            if (count($onbuySkus) > 0) {
                foreach ($onbuySkus as $sku) {
                    $skus[] = $sku->sku;
                    $basePrice[] = $sku->base_price;
                    $maxPrice[] = $sku->max_price;
                    $skip++;
                }
            }else{
                break;
            }
//                        return response()->json($maxPrice);
            $query = http_build_query(['skus' => $skus]);

            $url = "https://api.onbuy.com/v2/listings/check-winning?site_id=2000&" . $query;
            $post_data = NULL;
            $method = "GET";
            $http_header = array("Authorization: ".$this->access_token, "Content-Type: application/json");
            $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $response_data = json_decode($result_info);
//            return response()->json($response_data);
            if(!isset($response_data->error)) {
                $onbuyLeadSkus = [];
                $onbuyMismatchLeadSkus = [];
                $onbuyNotLeadSkus = [];
                if (count($response_data->results) > 0) {
                    $i = 0;
                    foreach ($response_data->results as $result) {
                        if (!isset($result->error)) {
                            if (isset($result->lead_price) && $result->winning == true  && isset($maxPrice[$i]) && $maxPrice[$i] == $result->lead_price) {
                                $onbuyLeadSkus[] = $result->sku;
                            }
                            if (isset($result->lead_price) && $result->winning == true  && isset($maxPrice[$i]) && $maxPrice[$i] != $result->lead_price) {
                                $onbuyMismatchLeadSkus[] = $result->sku;
                            }
                            if (isset($result->lead_price) && $result->winning == false) {
                                $onbuyNotLeadSkus[] = $result->sku;
                            }
                        }
                        $i++;
                    }
                    if (count($onbuyLeadSkus) > 0) {
                        $leadSkusUpdate = OnbuyVariationProducts::whereIn('sku', $onbuyLeadSkus)->update(['lead_listing' => 1]);
                    }
                    if (count($onbuyMismatchLeadSkus) > 0) {
                        $notLeadSkusUpdate = OnbuyVariationProducts::whereIn('sku', $onbuyMismatchLeadSkus)->update(['lead_listing' => 2]);
                    }
                    if (count($onbuyNotLeadSkus) > 0) {
                        $notLeadSkusUpdate = OnbuyVariationProducts::whereIn('sku', $onbuyNotLeadSkus)->update(['lead_listing' => 0]);
                    }
                }
            }else{
                $this->access_token = $this->access_token();
            }
//            return response(['totalLeadSku' => count($onbuyLeadSkus),'leadSku' => $onbuyLeadSkus,'totalNotLeasSku' => count($onbuyNotLeadSkus),'notLeadSku' => $onbuyNotLeadSkus]);
            $skus = [];
        }
        Log::info('all product check for lead listing end');
//        return redirect('onbuy/master-product-list')->with('success','All product check for lead listing');
    }

    public function searchLeadListingProduct(Request $request){
        try {
            $searchProduct = OnbuyVariationProducts::select('master_product_id')->whereIn('lead_listing',[0,2])->take(500)->get();
            $ids = [];
            if(count($searchProduct) > 0){
                foreach ($searchProduct as $id){
                    $ids[] = $id->master_product_id;
                }
            }
//            return response()->json($searchProduct);
            $master_product_list = OnbuyMasterProduct::with('category_info')
                ->withCount('variation_product')
                ->whereIn('id',$ids)
                ->orderByDesc('id')
                ->get();
            $search_result = json_decode(json_encode($master_product_list));
            $total_product = count($master_product_list);
            $content = view('onbuy.master_product.search_master_product',compact('master_product_list','search_result','total_product'))->render();
            return response()->json(['data' => $content,'total' => $total_product,'msg' => 'success']);
        }catch (\Exception $exception){
            return response()->json(['msg' => 'Something went wrong']);
        }
    }

    public function makeLeadListing(Request $request){
        try {
            $catalogueIDs = $request->catalogueIds;
            $notLeadListingInfo = OnbuyVariationProducts::select('sku','base_price','max_price','lead_listing')
                ->where([['base_price','!=',NULL],['max_price','!=',NULL]])
                ->whereIn('lead_listing',[0,2])
                ->whereIn('master_product_id',$catalogueIDs)
                ->get();
            $skus = [];
            $basePrice = [];
            $maxPrice = [];
            $isLead = [];
            if (count($notLeadListingInfo) > 0) {
                foreach ($notLeadListingInfo as $sku) {
                    $skus[] = $sku->sku;
                    $basePrice[$sku->sku] = $sku->base_price;
                    $maxPrice[$sku->sku] = $sku->max_price;
                    $isLead[$sku->sku] = $sku->lead_listing;
                }
            }else{
                return response()->json(['msg' => 'error','exception' => 'No sku found']);
            }
            $this->access_token = $this->access_token();
            $query = http_build_query(['skus' => $skus]);
            $url = "https://api.onbuy.com/v2/listings/check-winning?site_id=2000&" . $query;
            $post_data = NULL;
            $method = "GET";
            $http_header = array("Authorization: ".$this->access_token, "Content-Type: application/json");
            $lead_result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $lead_response_data = json_decode($lead_result_info);
//            return response()->json($lead_response_data);
            $data = [];
            $msgData = [];
            $warningMsgData = [];
            $i = 0;
            foreach ($lead_response_data->results as $result){
                if(!isset($result->error)){
                    $updatePrice = '';
                    if($result->winning == true && $maxPrice[$result->sku] != $result->lead_price && $isLead[$result->sku] == 2) {
                        $updatePrice = $result->price + 0.50;
                    }
                    elseif($result->winning == false && $maxPrice[$result->sku] != $result->lead_price && $isLead[$result->sku] == 2) {
                        $updatePrice = $result->price - 0.50;
                        $onbuyLeadSku = OnbuyVariationProducts::where('sku',$result->sku)->update([
                            'lead_listing' => 0
                        ]);
                    }
                    elseif($result->winning == false) {
                        $updatePrice = $result->price - 0.50;
                    }
                    else{
                        $updatePrice = '';
                    }
//                    return response()->json(['max' => $maxPrice[$result->sku],'lead' => $result->lead_price,'sku' => $result->sku,'update_price' => $updatePrice]);
                    if($updatePrice != '') {
                        foreach ($notLeadListingInfo as $info) {
                            if ($result->sku == $info->sku && $updatePrice >= $info->base_price) {
                                $newPrice = ($updatePrice > $info->max_price) ? $info->max_price : $updatePrice;
                                $formateUpdatedPrice = number_format($newPrice, 2, '.', '');
                                $data[] = [
                                    'sku' => $result->sku,
                                    'price' => $formateUpdatedPrice ?? $info->max_price
                                ];
                                $msgData[] = [
                                    'sku' => $result->sku,
                                    'old_price' => $result->item_price,
                                    'update_price' => $formateUpdatedPrice ?? $info->max_price,
                                    'lead_price' => $result->lead_price,
                                    'base_price' => $info->base_price
                                ];
                            }
                        }
                    }
                }
                $i++;
            }
//            return response()->json(['data' => $msgData,'msg' => 'success']);
            if(count($data) > 0) {
                $update_info = [
                    "site_id" => 2000,
                    "listings" => $data
                ];
                $product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                $url = "https://api.onbuy.com/v2/listings/by-sku";
                $post_data = $product_info;
                $method = "PUT";
                $http_header = array("Authorization: " . $this->access_token, "Content-Type: application/json");
                $update_result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                $listing_update_response_data = json_decode($update_result_info);
//                return response()->json($listing_update_response_data);
                if(count($listing_update_response_data->results) > 0){
                    foreach ($listing_update_response_data->results as $resultInfo){
                        $onbuyUpdateInfo = OnbuyVariationProducts::where('sku',$resultInfo->sku)->update([
                            'price' => $resultInfo->price
                        ]);
                    }
                }
                return response()->json(['data' => $msgData,'msg' => 'success']);
            }else{
                return response()->json(['data' => $warningMsgData,'msg' => 'warning']);
            }
        }catch (\Exception $exception){
            return response()->json(['msg' => 'error','exception' => $exception->getMessage()]);
        }
    }

    public function checkAndMakeLeadListing(){
        Log::info('Cron make lead listing start');
        $notLeadListingInfo = OnbuyVariationProducts::select('sku','base_price','max_price','lead_listing')
            ->where([['base_price','!=',NULL],['max_price','!=',NULL]])
            ->whereIn('lead_listing',[0,2])
            ->get();
        $skus = [];
        $basePrice = [];
        $maxPrice = [];
        $isLead = [];
        if (count($notLeadListingInfo) > 0) {
            foreach ($notLeadListingInfo as $sku) {
                $skus[] = $sku->sku;
                $basePrice[$sku->sku] = $sku->base_price;
                $maxPrice[$sku->sku] = $sku->max_price;
                $isLead[$sku->sku] = $sku->lead_listing;
            }

            $this->access_token = $this->access_token();
            $query = http_build_query(['skus' => $skus]);
            $url = "https://api.onbuy.com/v2/listings/check-winning?site_id=2000&" . $query;
            $post_data = NULL;
            $method = "GET";
            $http_header = array("Authorization: " . $this->access_token, "Content-Type: application/json");
            $lead_result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
            $lead_response_data = json_decode($lead_result_info);
            $data = [];
            $msgData = [];
            $warningMsgData = [];
            foreach ($lead_response_data->results as $result) {
                if (!isset($result->error)) {
                    $updatePrice = '';
                    if($result->winning == true && $maxPrice[$result->sku] != $result->lead_price && $isLead[$result->sku] == 2) {
                        $updatePrice = $result->price + 0.50;
                    }
                    elseif($result->winning == false && $maxPrice[$result->sku] != $result->lead_price && $isLead[$result->sku] == 2) {
                        $updatePrice = $result->price - 0.50;
                        $onbuyLeadSku = OnbuyVariationProducts::where('sku',$result->sku)->update([
                            'lead_listing' => 0
                        ]);
                    }
                    elseif($result->winning == false) {
                        $updatePrice = $result->price - 0.50;
                    }
                    else{
                        $updatePrice = '';
                    }
                    if($updatePrice != '') {
                        foreach ($notLeadListingInfo as $info) {
                            if ($result->sku == $info->sku && $updatePrice >= $info->base_price) {
                                $newPrice = ($updatePrice > $info->max_price) ? $info->max_price : $updatePrice;
                                $formateUpdatedPrice = number_format($newPrice, 2, '.', '');
                                $data[] = [
                                    'sku' => $result->sku,
                                    'price' => $formateUpdatedPrice ?? $info->max_price
                                ];
                                $msgData[] = [
                                    'sku' => $result->sku,
                                    'old_price' => $result->item_price,
                                    'update_price' => $formateUpdatedPrice ?? $info->max_price,
                                    'lead_price' => $result->lead_price,
                                    'base_price' => $info->base_price
                                ];
                            }
                        }
                    }

                }
            }
//            return response()->json($msgData);
            if (count($data) > 0) {
                $update_info = [
                    "site_id" => 2000,
                    "listings" => $data
                ];
                $product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                $url = "https://api.onbuy.com/v2/listings/by-sku";
                $post_data = $product_info;
                $method = "PUT";
                $http_header = array("Authorization: " . $this->access_token, "Content-Type: application/json");
                $update_result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                $listing_update_response_data = json_decode($update_result_info);
//                return response()->json($listing_update_response_data);
                if (count($listing_update_response_data->results) > 0) {
                    foreach ($listing_update_response_data->results as $resultInfo) {
                        $onbuyUpdateInfo = OnbuyVariationProducts::where('sku', $resultInfo->sku)->update([
                            'price' => $resultInfo->price
                        ]);
                    }
                }
                Log::info('Make product in lead successfully');
            } else {
                Log::info('All product are in lead position');
            }
        }else{
            Log::info('No sku found');
        }
        Log::info('Cron make lead listing end');
    }




    /*
    * Function : pendingMissingEanWithoutEanProductSearch
    * Route Type : {route_name}/{ean}/product/list/search
    * Method Type : Post
    * Parameters : $route, $ean
    * Creator : Solaiman
    * Creating Date : 06/02/2021
    * Description : This function is used for OnBuy Pending product & Missing EAN Product individual column search
    * Modifier :
    * Modified Date :
    * Modified Content :
    */

    public function pendingMissingEanWithoutEanProductSearch(Request $request, $route, $ean)
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('onbuy', 'onbuy_pending_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

        $shelfUse = $this->shelf_use;
        $column = $request->column_name;
        $value = $request->search_value;

        $onbuy_master_catalogue_id = OnbuyMasterProduct::select('woo_catalogue_id')->get()->toArray();
        $onbuy_master_catalogue_ids = [];
        if(count($onbuy_master_catalogue_id) > 0) {
            foreach ($onbuy_master_catalogue_id as $catalogue_ids) {
                $onbuy_master_catalogue_ids[] = $catalogue_ids['woo_catalogue_id'];
            }
        }

        $master_catalogue_not_exist_ean_ids = ProductDraft::select('product_drafts.id')
            ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
            ->where([['product_variation.ean_no',null],['product_drafts.status','publish']])
            ->where(function($query) use ($ean,$onbuy_master_catalogue_ids){
                if($ean = 'without-ean') {
                    $query->whereNotIn('product_drafts.id',$onbuy_master_catalogue_ids);
                }
            })
            ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
            ->groupBy('product_drafts.id')
            ->get()
            ->toArray();
        $notExistIds = [];
        if(count($master_catalogue_not_exist_ean_ids) > 0) {
            foreach ($master_catalogue_not_exist_ean_ids as $master_catalogue) {
                $notExistIds[] = $master_catalogue['id'];
            }
        }

        $without_ean_ids = array_merge($onbuy_master_catalogue_ids,$notExistIds);

        $total_catalogue = ProductDraft::with(['ProductVariations' => function ($query) {
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        }, 'all_category', 'WooWmsCategory:id,category_name', 'woocommerce_catalogue_info:id,master_catalogue_id', 'user_info', 'modifier_info', 'single_image_info', 'catalogueVariation' => function ($query) {
            $query->with(['shelf_quantity', 'order_products' => function ($query) {
                $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')
            ->where('status', 'publish')
            ->orderBy('id', 'DESC')
            ->where(function ($query) use ($ean, $notExistIds, $without_ean_ids){
                if($ean == 'with-ean') {
                    $query->whereNotIn('id',$without_ean_ids);
                }else{
                    $query->whereIn('id',$notExistIds);
                }
            })
            ->where(function($query)use($request, $column, $value, $notExistIds, $without_ean_ids){
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
                elseif($column == 'stock'){
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
                }elseif($column == 'user_id'){
                    if($request->opt_out == 1){
                        $query->where('user_id','!=', $request->user_id);
                    }else{
                        $query->where('user_id', $request->user_id);
                    }
                }elseif($column == 'modifier_id'){
                    if($request->opt_out == 1){
                        $query->where('modifier_id','!=', $request->modifier_id);
                    }else{
                        $query->where('modifier_id', $request->modifier_id);
                    }
                }
            })

            ->paginate(500);


        $users = User::orderBy('name', 'ASC')->get();
        $total_catalogue_info = json_decode(json_encode($total_catalogue));
//        echo '<pre>';
//        print_r($total_catalogue_info);
//        exit();
        return view('onbuy.master_product.pending_catalogue_listing',compact('total_catalogue','total_catalogue_info','users','ean','shelfUse', 'setting', 'page_title', 'pagination','column','value'));

    }


//    public function onbuyFailedProductSearch (Request $request){
//        //Start page title and pagination setting
//        $settingData = $this->paginationSetting('onbuy', 'onbuy_active_product');
//        $setting = $settingData['setting'];
//        $page_title = '';
//        $pagination = $settingData['pagination'];
//
//        $column_name = $request->column_name;
//        $search_value = $request->search_value;
//        $aggregate_value = $request->aggregate_condition;
//
//        $distinct_status = OnbuyMasterProduct::distinct()->get(['status'])->where('status', '=', null);
//        $distinct_category = OnbuyCategory::distinct()->get(['name'])->where('name', '=', null);
//
//        $master_product_list = OnbuyMasterProduct::with('category_info','variation_product')
//            ->withCount('variation_product')
//            ->where('status','failed')
//            ->orderByDesc('id')
//            ->where(function ($query) use ($request,$column_name,$search_value,$aggregate_value){
//                if($column_name == 'opc') {
//                    if ($request->opt_out == 1) {
//                        $query->where($column_name, '!=', $search_value);
//                    } else {
//                        $query->where($column_name, $search_value);
//                    }
//                }elseif ($column_name == 'woo_catalogue_id'){
//                    if ($request->opt_out == 1) {
//                        $query->where($column_name, '!=', $search_value);
//                    }else{
//                        $query->where($column_name, $search_value);
//                    }
//                }elseif ($column_name == 'product_name'){
//                    if ($request->opt_out == 1) {
//                        $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
//                    }else{
//                        $query->where($column_name, 'LIKE', '%' . $search_value . '%');
//                    }
//                }elseif ($column_name == 'name') {
//                    $category_name_query = OnbuyMasterProduct::select('onbuy_master_products.id')
//                        ->leftJoin('onbuy_categories', 'onbuy_master_products.master_category_id', '=', 'onbuy_categories.category_id')
//                        ->where([['onbuy_master_products.deleted_at', null],['onbuy_categories.deleted_at', null]])
//                        ->where($column_name, 'LIKE', '%' . $search_value . '%')
//                        ->groupBy('onbuy_master_products.id')
//                        ->get();
//
//                    $ids = [];
//                    foreach ($category_name_query as $category_name){
//                        $ids [] = $category_name->id;
//                    }
//                    if($request->opt_out == 1){
//                        $query->whereNotIn('id', $ids);
//                    }else{
//                        $query->whereIn('id', $ids);
//                    }
//                }elseif ($column_name == 'base_price'){
//                    $aggregate_value = $request->aggregate_condition;
//                    if($request->opt_out == 1){
//                        $query->where('base_price', '!=', $search_value);
//                    }else{
//                        $query->where('base_price', $aggregate_value, $search_value);
//                    }
//                }
//                elseif ($column_name == 'product'){
//                    $aggregate_value = $request->aggregate_condition;
//                    $product_query = OnbuyMasterProduct::select('onbuy_master_products.id', DB::raw('count(onbuy_variation_products.id) product'))
//                        ->leftJoin('onbuy_variation_products', 'onbuy_master_products.id', '=', 'onbuy_variation_products.master_product_id')
//                        ->havingRaw('count(onbuy_variation_products.id)' .$aggregate_value.$search_value)
//                        ->groupBy('onbuy_master_products.id')
//                        ->get();
//
//                    $ids = [];
//                    foreach ($product_query as $product){
//                        $ids[] = $product->id;
//                    }
//
//                    if($request->opt_out == 1){
//                        $query->whereNotIn('id', $ids);
//                    }else{
//                        $query->whereIn('id', $ids);
//                    }
//
//                }elseif ($column_name == 'status'){
//                    if($request->opt_out == 1){
//                        $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
//                    }else{
//                        $query->where($column_name, 'LIKE', '%' . $search_value . '%');
//                    }
//                }
//                else{
//                    if ($request->opt_out == 1) {
//                        $query->where($column_name, 'NOT LIKE', '%' . $search_value . '%');
//                    }else{
//                        $query->where($column_name, 'LIKE', '%' . $search_value . '%');
//                    }
//                }
//
//                // If user submit with empty data then this message will display table's upstairs
//                if($search_value == ''){
//                    return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
//                }
//
//            })
//
//            ->paginate($pagination);
//
//
//
//        // If user submit with wrong data or not exist data then this message will display table's upstairs
//        $ids = [];
//        if(count($master_product_list) > 0){
//            foreach ($master_product_list as $result){
//                $ids[] = $result->id;
//            }
//        }
//        else{
//            return back()->with('no_data_found','No data found');
//        }
//
//
//        $decode_master_product = json_decode(json_encode($master_product_list));
////        echo "<pre>";
////        print_r(json_decode(json_encode($master_product_list)));
////        exit();
//        return view('onbuy.master_product.master_product_list',compact('master_product_list','decode_master_product','total_product', 'setting', 'page_title', 'pagination','aggregate_value','distinct_category','distinct_status'));
//    }

    public function searchOnOnbuy(){
        $content = view('onbuy.search.search_on_onbuy');
        return view('master',compact('content'));
    }

    public function searchProductOnOnbuy(Request $request){
        $access_token = $this->access_token();
        $offset = $request->page * 100;
        $data = array(
            'site_id' => '2000',
            'filter[query]' => $request->searchTerm,
            'filter[field]' => $request->searchField,
            'limit' => 100,
            'offset' => $offset
        );
        $queryData = http_build_query($data);
        $url = "https://api.onbuy.com/v2/products?".$queryData;
        //$url = "https://api.onbuy.com/v2/products?site_id=2000&filter[query]=".$request->searchTerm."&filter[field]=".$request->searchField."&limit=100&offset=".$offset;
        $post_data = null;
        $method = "GET";
        $http_header = array("Authorization: " . $access_token);
        $result_info1 = $this->curl_request_send($url, $method, $post_data, $http_header);
        $exits_ean_data = json_decode($result_info1);
        $exits_ean_product_info = [];
        $totalRow = 0;
        if(!empty($exits_ean_data->results)) {
            foreach($exits_ean_data->results as $result){
                $exits_ean_product_info[$result->opc] = [
                    'opc' => $result->opc,
                    'name' => $result->name,
                    'ean_no' => $result->product_codes[0] ?? '',
                    'image_url' => $result->thumbnail_url,
                    'product_url' => $result->url,
                    'product_id' => explode('/',substr($result->url, strpos($result->url, "~p") + 2))[0]
                ];
            }
            $totalRow = $exits_ean_data->metadata->total_rows;
        }
        $variant_view = view('onbuy.search.search_onbuy_ajax',compact('exits_ean_product_info','totalRow'));
        echo $variant_view;
    }



}
