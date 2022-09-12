<?php

namespace App\Http\Controllers;

use App\AttributeTerm;
use App\Category;
use App\EbayMasterProduct;
use App\EbayVariationProduct;
use App\Http\Controllers\Controller;
use App\OnbuyAccount;
use App\Setting;
use App\shopify\ShopifyAccount;
use App\shopify\ShopifyCollection;
use App\shopify\ShopifyMasterProduct;
use App\shopify\ShopifyTag;
use App\shopify\ShopifyVariation;
use App\Traits\ImageUpload;
use App\Traits\SearchCatalogue;
use App\Traits\Shopify;
use App\Traits\ListingLimit;
use App\WoocommerceAccount;
use App\WooWmsCategory;
use Faker\Test\Provider\Collection;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PHPShopify\ShopifySDK;
use PHPShopify\AuthHelper;
use App\ProductDraft;
use App\ProductVariation;
use App\EbayAccount;
use App\User;
use Arr;
use App\Attribute;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class ShopifyController extends Controller
{
    //
    use Shopify;
    use ImageUpload;
    use ListingLimit;

    use SearchCatalogue;

    public function __construct(){
        $this->middleware('auth');
    }

    public function shopifyApiTest(){
        $config = array(
            'ShopUrl' => 'https://alibabadecor.myshopify.com',
            'ApiKey' => 'c4cdc25c47f76c3db0f98d108eb4ce49',
            'Password' => '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',
        );
        $result = ShopifySDK::config($config);

        $shopify = new ShopifySDK($config);

        // $productID = 6633749282870;
        // $product = $shopify->Product($productID)->get();

        $postArray = array(
            [
                "title" => "IPods",
                "body_html" => "<p>The body text changes, but the collects don't! Help</p>",
            ]


        );
        $product_single = $shopify->CustomCollection->post($postArray);
        echo '<pre>';
        var_dump($product_single);
        exit();

    }

    public function create($id = null){

        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
        // dd($listingLimitInfo,$clientListingLimit);
        // dd($listingLimitAllChannelActiveProduct);

        $accounts = ShopifyAccount::get();

        $collections = ShopifyCollection::with(['user_info' => function($query){
            $query->select('id','account_name');
        }])->get();

//        $product_draft = ProductDraft::find($id);
        $product_draft = ProductDraft::with('variations','ProductVariations')->find($id);
        $category = WooWmsCategory::all();
//         echo '<pre>';
//         print_r($catagory);
//         exit();
        $all_tags = ShopifyTag::get();
//        echo '<pre>';
//        print_r($all_tags);
//        exit();
        $content = view('shopify.create_catalogue', compact('product_draft','category','accounts','collections','all_tags','listingLimitInfo','clientListingLimit','listingLimitAllChannelActiveProduct'));
        return view('master',compact('content'));
    }

    // shopify create product----
    public function store(Request $request){
        try{

            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

            //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

            if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
                return redirect('/shopify/catalogue/create/'.$request->product_draft_id);
            }else {
                $master_catalogue_details = ProductDraft::find($request->product_draft_id);
                $attribute_terms_details = ProductVariation::where('product_draft_id', $request->product_draft_id)->get();

                foreach ($request->account_name as $account){

                    $shopify_account_info = ShopifyAccount::find($account);
                    $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);

    //                $existingProduct = $shopify->Product->get();
    //                $product_existing_id = array();
    //                foreach ($existingProduct as $product){
    ////                    echo '<pre>';
    ////                    var_dump($product['id']);
    //                    $product_existing_id[] = $product['id'];
    //                }
                    $master_product_exist = ShopifyMasterProduct::where('master_catalogue_id',$request->product_draft_id)->where('account_id', $account)->first();
                    if(empty($master_product_exist)){
                        $variants = array();
                        $variations = array();
                        if(isset($attribute_terms_details)){
                            foreach($attribute_terms_details as $index => $attribute){
                                $attr = $attribute->attribute;
                                $attrr = unserialize($attr);
                                $temp = array();
                                $attribute_option = array();
                                $test_account = array();
                                foreach($attrr as $key => $att_tearms){
                                    $test_account[] = $account;
                                    $variants[$index]['option'.($key + 1)] = $att_tearms['terms_name'];
                                    $temp['option'.($key + 1)] = $att_tearms['terms_name'];
                                    // $att_name = array_push($att_tearms['attribute_name']);
                                    $attribute_option[$key]['name'] = $att_tearms['attribute_name'];

                                }
                                $temp['price'] = $attribute->sale_price;
                                $temp['sku'] = $attribute->sku;
                                $temp['inventory_management'] = "shopify";
                                $temp['inventory_quantity'] = $attribute->actual_quantity;
                                $variations[] = $temp;
                                // echo '<pre>';
                                // print_r($liste);

                            }
                        }
                        // product variation image all---
                        $product_image = array();
                        if(isset($request->images)){
                            foreach ($request->images as $image){
                                    $product_image[]['src'] = $image;
                            }
                        }
                        $main_img = $product_image;

                        // all tag collection
                        $tags = array();
                        $main_tags = $request->tags;
                        if(isset($main_tags)){
                            $tags[] = implode(",",$main_tags);
                        }

                        $postArray = array(
                            "title" => $request->title,
                            "body_html" => $request->body_html,
                            "vendor" => $shopify_account_info['account_name'],
    //                    "product_type" => $request->product_type,
                            "variants" => $variations,
                            "options" => $attribute_option,
                            "status"=> $request->status,
                            "tags" => $tags,
                            "images" => $main_img
                        );
    //             echo '<pre>';
    //             print_r($request->all());
    //             exit();
                        $product_single = $shopify->Product->post($postArray);
    //                echo '<pre>';
    //                print_r($product_single);
    //                exit();
                        foreach ($product_single['variants'] as $variantImg){

                            if(isset($variantImg['sku'])){
                                $searchSku = ProductVariation::where('sku',$variantImg['sku'])->first();

                                $newString = explode('product_variation/',$searchSku['image']);
                                if(isset($newString[1])){
                                    $variationImage = $newString[1];
                                    $variationImage = explode('.',$variationImage);
                                    $variationImage = $variationImage[0];
                                    $variationId = $variantImg['id'];
    //                        echo '<pre>';
    //                        print_r($newString);
                                    foreach ($product_single['images'] as $productImages){
                                        // Test if string contains the word
                                        if (strpos($productImages['src'], $variationImage) !== false) {

                                            $variantsArray =
                                                [
                                                    "id" => $variationId,
                                                    "image_id" => $productImages['id'],
                                                ];
                                            $productVariantImgSave = $shopify->ProductVariant($variantImg['id'])->put($variantsArray);
    //                                    echo '<pre>';
    //                                    var_dump($productVariantImgSave);
                                        }
                                    }
                                }
                                else{
                                    $variationId = $variantImg['id'];
                                    $variantsArray =
                                        [
                                            "id" => $variationId,
                                            "image_id" => $product_single['image']['id'],
                                        ];

    //                                echo '<pre>';
    //                            var_dump($product_single['image']);
                                    $productVariantImgSave = $shopify->ProductVariant($variantImg['id'])->put($variantsArray);
                                }

                            }
                        }

    //                exit();
                        $single_variants_shopify = $product_single['variants'];

                        if(isset($product_single)){
    //                    $product_handle = array(
    //                        "handle" => $product_single['handle']
    //                    );
                            $master_img = serialize($product_single['images']);

    //                        $shopify_collection_id = array();
    //                        if(!empty($request->collections)){
    //                            foreach ($request->collections as $collection){
    //                                $ca = explode('/',$collection);
    //                                if($account == $ca[1]) {
    //                                    $shopify_collection_id[] = $ca[0];
    //                                }
    //                            }
    //                        }
    //                        $add_collection = \Opis\Closure\serialize($shopify_collection_id);

                            // add collection to product
                            $add_product_to_collection = array();
                            if(!empty($request->collections)){
                                foreach ($request->collections as $collection){
                                    $ca = explode('/',$collection);
                                    if($account == $ca[1]) {
                                        $find_collection = ShopifyCollection::where('user_id', $account)->where('shopify_collection_id', $ca[0])->first();
                                            $postArray = [
                                                "product_id" => $product_single['id'],
                                                "collection_id" => $ca[0],
                                            ];
                                            $add_product_to_collection[] = $shopify->Collect->post($postArray);
                                    }
                                }
                            }

                            if(isset($add_product_to_collection)){
                                $add_collect_info = array();
                                foreach ($add_product_to_collection as $collect){
                                    $add_collect_info[] = $collect['id'].'/'.$collect['collection_id'];
                                }
                            }
                            $add_collection = \Opis\Closure\serialize($add_collect_info);
    //                        print_r($add_collection);
                            $shopify_master_product = ShopifyMasterProduct::create([
                                'account_id' => $account,
                                'master_catalogue_id' => $request->product_draft_id,
                                'shopify_product_id' => $product_single['id'],
                                'title' => $product_single['title'],
                                'description' => $product_single['body_html'],
                                'vendor' => $product_single['vendor'],
                                'product_type' => $add_collection,
                                'attribute' => $master_catalogue_details->attribute,
                                'image' => $master_img,
                                'tags' => $product_single['tags'],
                                'regular_price' => $request->regular_price,
                                'sale_price' => $request->sale_price,
                                'rrp' => $request->rrp,
                                'status' => $product_single['status'],
                                'creator_id' => Auth::user()->id,
                                'modifier_id' => Auth::user()->id,

                            ]);

                            foreach ($attribute_terms_details as $shopify_variation_details){
                                foreach ($single_variants_shopify as $single_variant){
                                    if($single_variant['sku'] == $shopify_variation_details['sku']){
                                        $att_image = ProductVariation::where('sku',$shopify_variation_details['sku'])->first();
                                        $attr = $shopify_variation_details['attribute'];
                                        $shopify_variation = ShopifyVariation::create([
                                            'shopify_master_product_id' => $shopify_master_product['id'],
                                            'master_variation_id' => $shopify_variation_details['id'],
                                            'image' => $att_image['image'],
                                            'attribute' => $attr,
                                            'sku' => $shopify_variation_details['sku'],
                                            'quantity' => $shopify_variation_details['actual_quantity'],
                                            'regular_price' => $shopify_variation_details['regular_price'],
                                            'sale_price' => $shopify_variation_details['sale_price'],
                                            'rrp' => $shopify_variation_details['rrp'],
                                            'shopify_variant_it' => $single_variant['id'],
                                            'fulfillment_service' => 'manual',
                                            'inventory_management' => 'shopify',
                                            'image_id' => '',
                                            'inventory_item_id' => $single_variant['inventory_item_id'],
                                        ]);
                                    }
                                }
                            }
                        }

                    }
    //                echo '<pre>';
    //                print_r($shopify_variation);
    //                exit();
                }
    //            exit();
            //    echo '<pre>';
            //    print_r($product_single);
            //    exit();

                // $productID = 6633749282870;
                // $product = $shopify->Product($productID)->get();

                return redirect('shopify/shopify-master-product-list');
            }

        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }


    }

    // shopify variation add

    public function addNewVariation($request){

        $shopify_account_info = ShopifyAccount::all();

        foreach ($shopify_account_info as $account) {
            $shopify = $this->getConfig($account->shop_url, $account->api_key, $account->password);


            if($request->sku != null) {
                if($account->account_status == 1){
                    $shopify_catalogue = ShopifyMasterProduct::where('master_catalogue_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->first();
                    if ($shopify_catalogue != null) {
                        $shopify_catalogue = ShopifyMasterProduct::where('master_catalogue_id', $request->product_draft_id)->get();
                        $product_draft = ProductDraft::find($request->product_draft_id);
                        if ($product_draft->attribute != null) {
                            foreach (\Opis\Closure\unserialize($product_draft->attribute) as $attribute_id => $attribute_array) {

                            }
                        }
                    }






                    $shopify_variation_info = ShopifyVariation::where('sku', $request->sku)->first();
                    if ($shopify_variation_info == null) {
                        // $productID = 6637446496310;

                        $postArray = [

                            "option1" => "Yellow",

                            "price" => "1.00"

                        ];


                        $product = $shopify->Product($shopify_variation_info->shopify_variant_it)->Variant($postArray);
                        // echo '<pre>';
                        // print_r($product);
                    }
                }
            }


        }
        // exit();
    }

    // edit active catalogue status-------
    public function makeActiveCatalogue($id){
        try {
            $shopifyProducts = ShopifyMasterProduct::find($id);
            $shopify_account_info = ShopifyAccount::find($shopifyProducts['account_id']);
            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
            $postArray =
                [
                    "id" => $shopifyProducts['shopify_product_id'],
                    "status" => "active"
                ];
            $shopifyApiProduct = $shopify->Product($shopifyProducts['shopify_product_id'])->put($postArray);
            if(isset($shopifyApiProduct)){
                $shopify_edit_draft_to_active = ShopifyMasterProduct::find($id);
                $shopify_edit_draft_to_active->status = 'active';
                $shopify_edit_draft_to_active->update();
            }
            return Redirect::back()->with('success', 'Shopify Account Successfully Edited');

        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


    // active catalogue list function --------
    public function activeCatalogues(Request $request){
        try {
            $page_title = 'Shopify Active | WMS360';
            $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
            $setting = $settingData['setting'];
            $pagination = $settingData['pagination'];

            $master_product_list = ShopifyMasterProduct::where('status', 'active')->with(['variationProducts' => function($query){
                $query->select('shopify_master_product_id', DB::raw('sum(shopify_variations.quantity) stock'))
                    ->groupBy('shopify_master_product_id');
            }],'modifier_info');
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->shopifyActiveCatalogueSearchCondition($master_product_list, $request);
                $allCondition = $this->activeCatalogueSearchParams($request, $allCondition);
            }

            $master_product_list = $master_product_list->orderBy('id','DESC')->paginate($pagination);
            $master_decode_product_list = json_decode(json_encode($master_product_list));
            $users = User::orderBy('name', 'ASC')->get();
            $channels = array();
            $temp = array();
            $channels = ShopifyAccount::get()->all();


            if($request->has('is_clear_filter')){
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
//                $woocommerceSiteUrl = WoocommerceAccount::first();
                $search_result = $master_product_list;
//                echo '<pre>';
//                print_r($search_results);
//                exit();
                $view = view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render();
                return response()->json(['html' => $view]);
            }

            return view('shopify.master_product_list', compact('master_product_list','page_title','master_decode_product_list','allCondition','users','channels'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    // Draft catalogue list function --------
    public function draftCatalogues(Request $request){
        try {
            $page_title = 'Shopify Draft | WMS360';
            $settingData = $this->paginationSetting('ebay', 'ebay_active_product');
            $setting = $settingData['setting'];
            $pagination = $settingData['pagination'];

            $master_product_list = ShopifyMasterProduct::where('status', 'draft')->with(['variationProducts' => function($query){
                $query->select('shopify_master_product_id', DB::raw('sum(shopify_variations.quantity) stock'))
                    ->groupBy('shopify_master_product_id');
            }],'modifier_info');

            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->shopifyActiveCatalogueSearchCondition($master_product_list, $request);
                $allCondition = $this->activeCatalogueSearchParams($request, $allCondition);
            }

            $master_product_list = $master_product_list->orderBy('id','DESC')->paginate($pagination);
            $master_decode_product_list = json_decode(json_encode($master_product_list));

            $users = User::orderBy('name', 'ASC')->get();
            $channels = array();
            $temp = array();
            $channels = ShopifyAccount::get()->all();


            if($request->has('is_clear_filter')){
                $status = $request->get('status') ?? 'publish';
                $date = '12345';
//                $woocommerceSiteUrl = WoocommerceAccount::first();
                $search_result = $master_product_list;
//                echo '<pre>';
//                print_r($search_results);
//                exit();
                $view = view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render();
                return response()->json(['html' => $view]);
            }

            return view('shopify.draft_product_list', compact('master_product_list','page_title','master_decode_product_list','allCondition','channels','users'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    // shopify pending catalogue function ============
    public function pendingCatalogue(Request $request){
        try {
            // dd($request);
            // exit();
            $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
            //Start page title and pagination setting
//            $shelf_use = $this->shelf_use;
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

            $exist_shopify_catalogue = ShopifyMasterProduct::select('master_catalogue_id')->get()->toArray();
            $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
                $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->groupBy('product_draft_id');
            },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id,name','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id,product_name,master_category_id,product_id',
                'ebayCatalogueInfo' => function($query){
                    $query->select(['id','account_id','master_product_id','item_id'])->with(['AccountInfo:id,account_name,logo']);
                },'amazonCatalogueInfo' => function($amazonCatalogue){
                    $amazonCatalogue->select('id','master_product_id','application_id')->with(['applicationInfo' => function($applicationInfo){
                        $applicationInfo->select('id','amazon_account_id','application_name','application_logo','amazon_marketplace_fk_id')->with(['accountInfo:id,account_name,account_logo','marketPlace:id,marketplace']);
                    }]);
                }, 'variations' => function($query){
                    $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                        $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                    }]);
                }])
                ->withCount('ProductVariations')
                ->where('status','publish')->whereNotIn('id',$exist_shopify_catalogue);
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
            return view('shopify.pending_product_list', compact('product_drafts','total_product_drafts','product_drafts_info','setting','pagination','users','see_more','woocommerceSiteUrl','channels','allCondition','url'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Description : This function is used for pagination setting
    * Created Date : 10/25/2021
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

    // shopify variation view append---------
    public function getVariation(Request $request){
        try {
            $id = $request->product_draft_id;
            $status = 'shopify_pending';
            $product_draft = ShopifyVariation::where('shopify_master_product_id', $id)->get();
            $product_draft = json_decode(json_encode($product_draft));
//        echo '<pre>';
//        print_r($product_list);
//        exit();
            return view('shopify.variation.variation_ajax',compact('product_draft','id','status'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    // shopify product delete function ----------
    public function productDelete($id){
        try {
            $product_info = ShopifyMasterProduct::find($id);
            $variation_info = ShopifyVariation::where('shopify_master_product_id', $product_info->id)->get();

            // echo '<pre>';
            // print_r($variation_info);
            // exit();
            $account_info = $product_info->account_id;
            $shopify_account_info = ShopifyAccount::find($account_info);
            $shopify = $this->getConfig($shopify_account_info->shop_url, $shopify_account_info->api_key, $shopify_account_info->password);
            $product_id = $product_info->shopify_product_id;
            $apiProductDelete = $shopify->Product($product_id)->delete([$shopify_account_info->shop_url]);

            foreach($variation_info as $variation){
                $variation->delete();
            }
            $product_info->delete();
            return Redirect::back()->with('success', 'Ebay Product Successfully Deleted');
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * view specified catalogue page
     * @param  int  $id
     */

    public function show($id){
        try {
            $product_draft = ShopifyMasterProduct::with('variationProducts')->find($id);
//            echo '<pre>';
            $masterImages = unserialize($product_draft['image']);
//            foreach ($masterImages as $images){
//                var_dump($images['src']);
//
//            }
//            exit();

            return view('shopify.product_catalogue_details',compact('product_draft','masterImages'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }

    }

    // shopify master product edit------------

    public function edit($id){
        try {
            $image_src = [];
            $accounts = ShopifyAccount::all();
            $product_draft = ShopifyMasterProduct::find($id);
            $account_id = $product_draft->account_id;
            $select_account = ShopifyAccount::find($account_id);
            $tags = $product_draft->tags;
            $tags = explode(',',$tags);
            $tags = array_map('trim', $tags);
            $product_image = unserialize($product_draft->image);
            foreach ($product_image as $image){
                $image_src[] = $image['src'];
            }
            $image_as_string = implode(",",$image_src);
            $collection_id = \Opis\Closure\unserialize($product_draft->product_type);

            $all_collection = ShopifyCollection::where('user_id',$account_id)->get();
//            echo '<pre>';
//            print_r($all_collection);
//            exit();
            $all_tags = ShopifyTag::get();

            return view('shopify.edit_catalogue',compact('product_draft','accounts','select_account','tags','product_image','image_as_string','collection_id','all_collection','all_tags'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    // update active product ---------
    public function update(Request $request, $id){
        try {
//            echo '<pre>';
//            print_r($request->all());
//            exit();

            $image_array = array();
            // all tag collection
            $tags = array();
            $main_tags = $request->tags;
            if(isset($main_tags)){
                $tags[] = implode(",",$main_tags);
            }

            $shopify_master_product = ShopifyMasterProduct::find($id);
            $shopify_account_info = ShopifyAccount::find($shopify_master_product->account_id);

//            echo '<pre>';
//            print_r($shopify_master_product->shopify_product_id);
//            exit();
            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
            $postArray = array(
                "title" => $request->title,
                "body_html" => $request->description,
                "product_type" => $request->product_type,
                "status"=> $request->status,
                "tags" => $tags,
            );
            $product_single = $shopify->Product($shopify_master_product->shopify_product_id)->put($postArray);

            if(!empty($request->collections)){
                $request_collection = $request->collections;
                $stored_collection = \Opis\Closure\unserialize($shopify_master_product->product_type);
//                $collectionForApi = array_diff($request_collection,$stored_collection);
//                echo '<pre>';
//                print_r($stored_collection);
                if(!empty($stored_collection)){
                    foreach ($stored_collection as $single_collection){
                        $remove_collect = explode('/', $single_collection);
                        $remove_stored_collection = $shopify->Collect($remove_collect[0])->delete();
                    }
                }
                $add_product_to_collection = array();
                foreach ($request_collection as $collection){
                        if(isset($product_single)){
                            $postArray = [
                                "product_id" => $shopify_master_product->shopify_product_id,
                                "collection_id" => $collection,
                            ];
                            $add_product_to_collection[] = $shopify->Collect->post($postArray);
                        }
                }
            }
            if(isset($add_product_to_collection)){
                $add_collect_info = array();
                foreach ($add_product_to_collection as $collect){
                    $add_collect_info[] = $collect['id'].'/'.$collect['collection_id'];
                }
            }
            $add_collection = \Opis\Closure\serialize($add_collect_info);
//            exit();


            $existingProductImage = $shopify->Product($shopify_master_product->shopify_product_id)->get();
//            $existingProductImage = $existingProductImage['images'];
            if($request->image_update_check == 1) {
                $folderPath = 'uploads/product-images/';
                if ($request->newUploadImage != null) {
                    foreach ($request->newUploadImage as $imageName => $imageContent) {
                        if (filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE) {
                            $updatedImageName = $this->base64ToImage($shopify_master_product->id, $imageName, $imageContent, $folderPath);
                            $image_array[] = asset($folderPath . $updatedImageName);
                        } else {
                            $image_array[] = $imageContent;
                        }
                    }
                }


                $product_image = array();
                foreach ($image_array as $images){
                    $product_image[]['src'] = $images;
                }
                $main_img = $product_image;

                $postArray = array(
                    "images" => $main_img
                );
                $edit_image = $shopify->Product($shopify_master_product->shopify_product_id)->put($postArray);
//                echo '<pre>';
//                print_r($postArray);
            }

//            $shopify_collection_id = array();
//            if(!empty($request->collections)){
//                foreach ($request->collections as $collection){
//                        $shopify_collection_id[] = $collection;
//                }
//            }
//            $add_collection = \Opis\Closure\serialize($shopify_collection_id);

            if(isset($edit_image)){
                $master_img = serialize($edit_image['images']);
            }
            if(isset($product_single)){
                $shopifyCatalogue = ShopifyMasterProduct::find($id);
                $shopifyCatalogue->title = $request->title;
                $shopifyCatalogue->product_type = $add_collection;
                $shopifyCatalogue->tags = $product_single['tags'];
                $shopifyCatalogue->description = $request->description;
                $shopifyCatalogue->regular_price = $request->regular_price;
                $shopifyCatalogue->sale_price = $request->sale_price;
                $shopifyCatalogue->rrp = $request->rrp;
                $shopifyCatalogue->status = $request->status;
                if(isset($master_img)){
                    $shopifyCatalogue->image = $master_img;
                }
                $shopifyCatalogueUpdate = $shopifyCatalogue->update();
            }
            return back()->with('success','Edit shopify catalogue successfully');
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


    // shopify product sync function

    public function productSync($id){
        try {
//            $test = [
//                "zebra_apps"   => 'https://cutt.ly/pPusnB6',
//                "android_link" => 'https://cutt.ly/2PusEz0',
//                "ios_link"     => 'https://www.apple.com/app-store/'
//            ];
//            echo serialize($test);
//            exit();
            $shopify_account_info = ShopifyAccount::find($id);


            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
            $postArray = array(
                "limit" => 1,
            );
            $allProducts = $shopify->Product->get($postArray);
//            echo '<pre>';
//            print_r($allProducts);
//            exit();
            $allProducts = $shopify->Product->get($postArray);
//            $i = 0;
            foreach ($allProducts as $shopifyProduct) {
//                echo '<pre>';
//                print_r($shopifyProduct['options']);
                foreach ($shopifyProduct['options'] as $option){
//                    echo '<pre>';
//                    print_r($option['name']);
//                    print_r($option);
                    $attribute_result = Attribute::where('attribute_name',$option['name'])->get()->first();

                    if (!$attribute_result){
                        $last_attribute = Attribute::get()->last();
                        if (isset($last_attribute->id)){
//                            echo 'found the name';
                            $attribute_results = Attribute::create(['id'=> ($last_attribute->id+1),'attribute_name' => $option['name']]);
                        }
//                        else{
//                            echo 'not found the same';
//                            $attribute_results = Attribute::create(['id'=> 1,'attribute_name' => $option['name']]);
//                        }
                    }
                    echo '<pre>';
                    print_r($attribute_results);

//                    $all_terms = array();
//
//                    foreach ($option['values'] as $term){
////                        echo '<pre>';
////                        print_r($term);
//                        $attribute_terms_result = AttributeTerm::where('terms_name',$term)->get()->first();
//                        if (!$attribute_terms_result){
//                            $last_attribute_terms = AttributeTerm::get()->last();
//                            if (isset($last_attribute_terms->id)){
//                                $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $term]);
//                            }else{
//                                $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $term]);
//                            }
//
//                        }
//                        $all_terms[] =[
//                            'attribute_term_name' => $term,
//                            'attribute_term_id' => $attribute_terms_result->id
//                        ] ;
//                    }
//                    echo '<pre>';
//                    print_r($all_terms);


                }

//                    exit();
//                $product_draft_create_result = ProductDraft::create([
//                    'user_id' => Auth::user()->id,
//                    'woowms_category' => 9,
//                    'name' => $shopifyProduct['title'],
//                    'description' => $shopifyProduct['body_html'],
////                    'attribute' => $attribute_array ?? null,
//                    'status' => 'draft',
//                ]);
//                echo '<pre>';
//                print_r($product_draft_create_result);
//                $i++;
//                if(!empty($product_draft_create_result)){
//                foreach ($shopifyProduct['variants'] as $variation) {
//                    $product_variation = ProductVariation::create([
//                            'product_draft_id' => $product_draft_create_result->id,
//                            'sku' => $variation['sku'],
//                            'actual_quantity' => $variation['inventory_quantity'],
//                            'sale_price' => $variation['price'],
//                            'regular_price' => $variation['old_inventory_quantity'],
//                        ]
//                    );
//                }
//                echo '<pre>';
////                print_r($product_variation);
//            }

            }
//            echo '<pre>';
//            print_r($allProducts);
            exit();
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }


}


