<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeTerm;
use App\Condition;
use App\DeveloperAccount;
use App\EbayMasterProduct;
use App\EbayMigration;
use App\EbayProfile;
use App\EbayTemplate;
use App\EbayVariationProduct;
use App\GenderWmsCategory;
use App\Image;
use App\ProductDraft;
use App\ProductVariation;
use App\ShelfedProduct;
use App\Traits\CommonFunction;
use App\Traits\Ebay;
use App\WooWmsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use App\EbayAccount;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Storage;
use ElephantIO;
use Illuminate\Support\Facades\Log;
use App\Traits\SearchCatalogue;
use App\Pagination;
use Auth;
use App\Setting;

class MigrationController extends Controller
{
    use SearchCatalogue;
    use Ebay;
    use CommonFunction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(){
        $user_id = Auth::user()->id;
        $page_info = Pagination::where('user_id',$user_id)->first();
        return $page_info->per_page;
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
                $tt = EbayMigration::where('account_id',$profile['account_id'])->where('category_id',$profile['category_id'])
                ->where('condition_id',$profile['condition_id'])->pluck('id')->toArray();
                foreach($tt as $t){
                    $migration_count_id[] = $t;
                }
            }
        }
        return $migration_count_id;
    }

    public function ebayMigration(Request $request){

         //Start page title and pagination setting
         $settingData = $this->paginationSetting('activitylog', 'activity_log_active_product');
         $setting = $settingData['setting'];
         $page_title = '';
         $pagination = $settingData['pagination'];
         //End page title and pagination setting

        $ebay_migration_result = EbayMigration::query();
        $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->ebayMigrationSearchCondition($ebay_migration_result, $request);
                $allCondition = $this->ebayMigrationSearchParams($request, $allCondition);
                //dd($allCondition);
            }

            $category_count_id = $this->creatableProfile();
            if($request->get('account_id')){
                $category_count = EbayMigration::where('account_id', $request->get('account_id'))
                ->whereNotIn('id',$category_count_id)
                ->where('status',0)
                ->distinct('category_id')
                ->groupBy('condition_id')
                ->count('category_id');
            }else{
                $category_count = EbayMigration::select('id','account_id','condition_id','category_id')
                ->whereNotIn('id',$category_count_id)
                ->where('status',0)
                ->groupBy('account_id')
                ->groupBy('category_id')
                ->groupBy('condition_id')
                ->get()
                ->count();
            }
            // echo '<pre>';
            // print_r($category_count);
            // exit();
            $category_count_reset = EbayMigration::where('status',0)
            ->groupBy('account_id')
            ->groupBy('category_id')
            ->groupBy('condition_id')
            ->get()
            ->count();
            $category_name = EbayMigration::select('category_name')
            ->distinct('category_id')
            ->get();
            $counter = 0;
        foreach ($category_name as $value){
            $counter++;
        }
        $ebay_migration_result = $ebay_migration_result->get();
        // start on page refresh function call
        if($request->has('is_clear_filter')){
            $ebay_migration_result = $ebay_migration_result;

            $view = view('migration.search_ebay_migration_list',compact('ebay_migration_result'))->render();
            return response()->json(['html' => $view]);
        }
        $acId = $request->get('account_id');
//       echo $counter;
//       exit();
        $ebay_migration_result_info = json_decode(json_encode($ebay_migration_result));
        return view('migration.ebay_migration',compact('ebay_migration_result','ebay_migration_result_info','category_count','category_count_reset','allCondition', 'acId'));
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
            $data['pagination'] = 500;
            if(isset($setting_info)) {
                if($setting_info->setting_attribute != null){
                    $data['setting'] = \Opis\Closure\unserialize($setting_info->setting_attribute);
                    if(array_key_exists($firstKey,$data['setting'])){
                        if($secondKey != null) {
                            if (array_key_exists($secondKey, $data['setting'][$firstKey])) {
                                $data['pagination'] = $data['setting'][$firstKey][$secondKey]['pagination'] ?? 500;
                            } else {
                                $data['pagination'] = 500;
                            }
                        }else{
                            $data['pagination'] = $data['setting'][$firstKey]['pagination'] ?? 500;
                        }
                    }else{
                        $data['pagination'] = 500;
                    }
                }else{
                    $data['setting'] = null;
                    $data['pagination'] = 500;
                }

            }else{
                $data['setting'] = null;
                $data['pagination'] = 500;
            }

            return $data;
        }


    public function descriptionMigration(){
        set_time_limit(5000);
        $ebay_products = EbayMasterProduct::where('description',null)->get()->all();

        foreach ($ebay_products as $ebay_product){

            //echo $ebay_product->master_product_id;
            if (isset($ebay_product->master_product_id)){
                $master_product = ProductDraft::find($ebay_product->master_product_id);
                $ebay_update_product = EbayMasterProduct::find($ebay_product->id);
                $ebay_update_product->description = $master_product->description;

                $ebay_update_product->save();
            }
            print_r($ebay_update_product);
            exit();
        }

    }

    public function syncEndedProduct(){
        $ebay_products = EbayMasterProduct::onlyTrashed()->where('product_status', '=', 'Completed')->get()->all();

        foreach ($ebay_products as $ebay_product){
//            $item_id_value = explode('/',$ebay_product->item_id);
//            $product = EbayMigration::where('item_id',$ebay_product->item_id)->get()->first();

////        print_r(explode(',',));

            $account_result = EbayAccount::find($ebay_product->account_id);
            $variation_specifics = array();
            $final_template_result = '';

            $this->ebayAccessToken($account_result->refresh_token);
            try {
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:' . $ebay_product->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->

                                  <ItemID>'.$ebay_product->item_id.'</ItemID>
                                    <DetailLevel>ItemReturnDescription</DetailLevel>
                                    <DetailLevel>ReturnAll</DetailLevel>
                                    <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                </GetItemRequest>';
                $item_details = $this->curl($url, $headers, $body, 'POST');
                $item_details = simplexml_load_string($item_details);
                $item_details = json_decode(json_encode($item_details), true);
                if (isset($item_details["Item"]["ItemSpecifics"]["NameValueList"][0])){
                    foreach ($item_details["Item"]["ItemSpecifics"]["NameValueList"] as $item_specifics_array){
                        if (is_array($item_specifics_array['Value'])){
                            $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'][0];
                        }else{
                            $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'];
                        }

                    }
                }
               $result = EbayMasterProduct::onlyTrashed()->where('product_status', '=', 'Completed')->where('item_id',$ebay_product->item_id)->update(["item_specifics" => \Opis\Closure\serialize($item_specifics)]);

            }catch (\Mockery\Exception $exception){

            }
        }
    }

    public function migrationStartedFromIntegration($account_id){
        $product = EbayMigration::where('account_id',$account_id)->where('status',0)->get()->first();
        if ($product){
            $ebay_migration_counter = EbayMigration::where('account_id',$account_id)->get();

            $this->ebay_update_access_token  = $this->getEbayToken($account_id,$this->getEbaySessionKey($account_id));
            $variation_specifics = array();
            $final_template_result = '';


            try{
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$product->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->

                                  <ItemID>'.$product->item_id.'</ItemID>
                                    <DetailLevel>ItemReturnDescription</DetailLevel>
                                    <DetailLevel>ReturnAll</DetailLevel>
                                    <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                </GetItemRequest>';
                $item_details = $this->curl($url,$headers,$body,'POST');
                $item_details =simplexml_load_string($item_details);
                $item_details = json_decode(json_encode($item_details),true);
                // Log:info($product->item_id);
                $product_variation_specifics = array();

//                echo "<pre>";
//                print_r($item_details);
//                exit();

                $existCatalogueItemId = EbayMasterProduct::where('item_id',$item_details["Item"]["ItemID"])->first();
                if(!$existCatalogueItemId){
//                    return response()->json(['done' => $counter->where('status',1)->count(),'remains' => $counter->where('status',0)->count(),'failed' => $counter->where('status',3)->count()]);
//                if(isset($item_details["Item"]["Variations"])){



                    if (isset($item_details["Item"]["Variations"]["Variation"][0])){
                        $counter = 0;
                        foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                            if (isset($variation["SKU"])){
                                $product_variation_find = ProductVariation::where('sku',$variation["SKU"])->first();
                                if ($product_variation_find != null){
                                    $counter++;

                                }
                            }

                        }
                    }else{
                        $counter = 0;
                        if (isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                            $product_variation_find = ProductVariation::where('sku',$item_details["Item"]["Variations"]["Variation"]["SKU"])->first();
                            if ($product_variation_find != null){
                                $counter++;

                            }
                        }
//                        elseif(isset($item_details["Item"]["Variations"]["Variation"]["SKU"])) {
//                            $product_variation_find = ProductVariation::where('sku', $item_details["Item"]["Variations"]["Variation"]["SKU"])->first();
//                            if ($product_variation_find != null) {
//                                $counter++;
//
//                            }
//                        }
                    }
//                        print_r($counter);
//                        echo '***';
//                        print_r(sizeof($item_details["Item"]["Variations"]["Variation"]));
//                        exit();
                    if( $counter == 0){

                        //foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                        $attribute_array = array();

                        //$product_variation_result  = ProductVariation::with('product_draft')->where('sku' , $variation["SKU"])->get()->first();
//                                                        echo "<pre>";
//                            print_r($product_variation_result);
//                            exit();
                        //if (!$product_variation_result){
                        $woowms_category_result = WooWmsCategory::where(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"]])->get()->first();
                        if (!isset($woowms_category_result->id)){
                            $woowms_category_result = WooWmsCategory::create(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],'user_id' => 1]);
                        }
                        if (isset($item_details["Item"]["ConditionID"])){
                            $woowms_condition_result = Condition::where(['condition_name' => $item_details["Item"]["ConditionDisplayName"]])->get()->first();
                            if(!isset($woowms_condition_result->id)){
                                $woowms_condition_result = Condition::create(['id' => $item_details["Item"]["ConditionID"] , 'condition_name' => $item_details["Item"]["ConditionDisplayName"], 'user_id' => 1]);
                            }
                        }


                        if (isset($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"][0]) && isset($item_details["Item"]["Variations"])){

                            foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"] as $key => $attribute){
                                $attribute_result = Attribute::where('attribute_name',$attribute["Name"])->get()->first();
                                if (!$attribute_result){
                                    $last_attribute = Attribute::get()->last();
                                    if (isset($last_attribute->id)){
                                        $attribute_result = Attribute::create(['id'=> ($last_attribute->id+1),'attribute_name' => $attribute["Name"]]);
                                    }else{
                                        $attribute_result = Attribute::create(['id'=> 1,'attribute_name' => $attribute["Name"]]);
                                    }
                                }
                                $all_terms = array();


                                if (isset($attribute["Value"][0]) && is_array($attribute["Value"])){


                                    foreach ($attribute["Value"] as $index => $terms){
                                        // Log::info($terms);

                                        $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                        if (!$attribute_terms_result){
                                            $last_attribute_terms = AttributeTerm::get()->last();
                                            if (isset($last_attribute_terms->id)){
                                                $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                            }else{
                                                $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                            }

                                        }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                        $all_terms[] =[
                                            'attribute_term_name' => $terms,
                                            'attribute_term_id' => $attribute_terms_result->id
                                        ] ;
//                                                $temp[] = $attribute_array;

                                    }

                                    $attribute_array [$attribute_result->id] =[
                                        $attribute["Name"] => $all_terms
                                    ];
                                }else{
                                    $attribute_terms_result = AttributeTerm::where('terms_name',$attribute["Value"])->get()->first();
                                    if (!$attribute_terms_result){
                                        $last_attribute_terms = AttributeTerm::get()->last();
                                        if (isset($last_attribute_terms->id)) {
                                            $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $attribute["Value"]]);
                                        }else{
                                            $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $attribute["Value"]]);
                                        }
                                    }

                                    $attribute_array [$attribute_result->id] =[
                                        $attribute["Name"] =>[
                                            [
                                                "attribute_term_id" => $attribute_terms_result->id,
                                                "attribute_term_name" => $attribute["Value"]
                                            ]
                                        ]
                                    ];
                                }


                            }
//                                    echo "<pre>";
//                                    print_r($attribute_array);
                            // exit();
                        }elseif(!isset($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"][0]) && isset($item_details["Item"]["Variations"])){

                            $attribute_result = Attribute::where('attribute_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"])->get()->first();
                            if (!isset($attribute_result->id)){
                                $last_attribute = Attribute::get()->last();
                                if (isset($last_attribute->id)) {
                                    $attribute_result = Attribute::create(['id' => ($last_attribute->id+1),'attribute_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"]]);
                                }else{
                                    $attribute_result = Attribute::create(['id' => 1,'attribute_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"]]);
                                }
                            }

                            $all_terms = array();

                            if(is_array($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])){
                                foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"] as $terms){

                                    $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                    if (!isset($attribute_terms_result->id)){
                                        $last_attribute_terms = AttributeTerm::get()->last();
                                        if (isset($last_attribute_terms->id)) {
                                            $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                        }else{
                                            $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                        }
                                    }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                    $all_terms[] =[
                                        'attribute_term_name' => $terms,
                                        'attribute_term_id' => $attribute_terms_result->id
                                    ] ;
//                                                $temp[] = $attribute_array;

                                }

                                $attribute_array [$attribute_result->id] =[
                                    $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => $all_terms
                                ];
                            }else{

                                $attribute_terms_result = AttributeTerm::where('terms_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])->get()->first();
                                if (!isset($attribute_terms_result->id)){
                                    $last_attribute_terms = AttributeTerm::get()->last();
                                    if (isset($last_attribute_terms->id)) {
                                        $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]]);
                                    }else{
                                        $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]]);
                                    }
                                }

                                $attribute_array [$attribute_result->id] =[
                                    $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => [
                                        ["attribute_term_id" => $attribute_terms_result->id,
                                            "attribute_term_name" => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]

                                        ]
                                    ]
                                ];
                            }
                        }

//                                    echo "<pre>";
//                                    print_r($attribute_array);
//                                    exit();
                        $product_draft_result = ProductDraft::create(['user_id' => Auth::id(),'modifier_id' => Auth::id(),'woowms_category' => $woowms_category_result->id , 'condition' => $woowms_condition_result->id ?? NULL,
                            'name' => $item_details["Item"]["Title"],'description' => $item_details["Item"]["Description"],'type' => isset($item_details["Item"]["Variations"]) ? 'variable' : 'simple','sale_price' => $item_details["Item"]["StartPrice"],'rrp' => $item_details["Item"]["StartPrice"],
                            'attribute' => \Opis\Closure\serialize($attribute_array),'status' => 'publish']);

                        if ($product_draft_result){
                            $master_image = array();
                            if (isset($item_details["Item"]["PictureDetails"])){

                                if ( isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                    if (is_array($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                        foreach ($item_details["Item"]["PictureDetails"]["PictureURL"] as $image_url){

                                            $url = $image_url;
                                            $contents = $this->curl_get_file_contents($url);
                                            $name = random_int(1,1000000).'.webp';

                                            Storage::disk('product_image_custom')->put($name, $contents);
                                            Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                            $master_image[] = asset('/uploads/product-images/'.$name);
                                        }
                                    }else{
                                        if (isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                            $url = $item_details["Item"]["PictureDetails"]["PictureURL"];
                                        }
                                        $contents = $this->curl_get_file_contents($url);
                                        $name = random_int(1,1000000).'.webp';

                                        Storage::disk('product_image_custom')->put($name, $contents);
                                        Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                        $master_image[] = asset('/uploads/product-images/'.$name);
                                    }

                                }else{
                                    if (isset($item_details["Item"]["PictureDetails"]["GalleryURL"])){
                                        $url = $item_details["Item"]["PictureDetails"]["GalleryURL"];
                                    }
                                    $contents = $this->curl_get_file_contents($url);
                                    $name = random_int(1,1000000).'.webp';

                                    Storage::disk('product_image_custom')->put($name, $contents);
                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                    $master_image[] = asset('/uploads/product-images/'.$name);
                                }
                            }




                            $master_product_find_result = ProductDraft::where('id' , $product_draft_result->id)->first();
                            if (isset($item_details["Item"]["Variations"]["Variation"])){
                                foreach (\Opis\Closure\unserialize($master_product_find_result->attribute) as $attribute_id => $attribute_array){


                                    foreach ($attribute_array as $attribute_name => $terms_array){
//                echo "<pre>";
//                print_r($terms);
//                exit();
                                        if (is_array($terms_array)){
                                            foreach ($terms_array as $terms){
                                                if (isset($terms["attribute_term_name"])){
                                                    $variation_specifics[$attribute_name][] =$terms["attribute_term_name"];
                                                }

//                                                $variation_image[$attribute_name][$terms["attribute_term_name"]][] = $product_variation['image'];
                                            }
                                        }else{
                                            if (isset($attribute_name)){
                                                $variation_specifics[$attribute_name][] = $terms_array;
                                            }
                                        }


                                    }

                                }
                            }


                            if (isset($item_details["Item"]["ItemSpecifics"]["NameValueList"][0])){
                                foreach ($item_details["Item"]["ItemSpecifics"]["NameValueList"] as $item_specifics_array){
                                    if (is_array($item_specifics_array['Value'])){
                                        $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'][0];
                                    }else{
                                        $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'];
                                    }

                                }
                            }
                            $variation_image= array();
                            $terms_array = array();
                            $image_attribute = '';
                            if (isset($item_details["Item"]["Variations"]["Variation"])){
                                if (isset($item_details["Item"]["Variations"]["Pictures"][0])){
                                    foreach ($item_details["Item"]["Variations"]["Pictures"] as $variation_image_array){
                                        if (isset($variation_image_array["VariationSpecificPictureSet"]["PictureURL"][0])){
                                            foreach ($variation_image_array["VariationSpecificPictureSet"]["PictureURL"] as $url){
                                                $terms_array[$variation_image_array["VariationSpecificValue"]][] = $url;
                                            }
                                            $variation_image[$variation_image_array["VariationSpecificName"]] = $terms_array;
                                        }
                                    }
                                }else{
                                    if (isset($item_details["Item"]["Variations"]["Pictures"])){
                                        foreach ($item_details["Item"]["Variations"]["Pictures"]["VariationSpecificPictureSet"] as $terms_image){
//                        echo "<pre>";
//                        print_r($terms_image["VariationSpecificValue"]);
//                        exit();
                                            if(isset($terms_image["VariationSpecificValue"])){
                                                $terms_array[$terms_image["VariationSpecificValue"]][] = $terms_image["PictureURL"];
                                            }

                                        }
                                        $variation_image[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $terms_array;
                                    }


                                }
                                if (isset($variation_specifics)){
                                    $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                                }

                                if (isset($item_details["Item"]["Variations"]["Pictures"])){
                                    $image_attribute = $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"];
                                }else{
                                    $image_attribute = '';
                                }
                            }

                            $profile = EbayProfile::where('category_id',$item_details["Item"]["PrimaryCategory"]["CategoryID"])->first();

                            $ebay_master_product_result = EbayMasterProduct::create(['account_id' => $product->account_id,'master_product_id' => $product_draft_result->id,'site_id' => $product->site_id,
                                'title' => $item_details["Item"]["Title"],'subtitle' => $item_details["Item"]["SubTitle"] ?? '', 'item_id' => $item_details["Item"]["ItemID"],'item_description' => $item_details["Item"]["Description"],'description' => $item_details["Item"]["Description"],
                                'variation_specifics' => empty($variation_specifics) ? '' : $variation_specifics,'master_images' => \Opis\Closure\serialize($master_image) ?? '','variation_images' => \Opis\Closure\serialize($variation_image) ?? '','product_type' => 'product_type',
                                'dispatch_time' => $item_details["Item"]["DispatchTimeMax"] ?? '','start_price' => $item_details["Item"]["StartPrice"],
                                'condition_id' => $item_details["Item"]["ConditionID"] ?? NULL,'condition_name' => $item_details["Item"]["ConditionDisplayName"] ?? NULL,
                                'category_id' => $item_details["Item"]["PrimaryCategory"]["CategoryID"],'category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],
                                'store_id' =>  $item_details["Item"]["Storefront"]["StoreCategoryID"] ?? '','store2_id' => $item_details["Item"]["Storefront"]["StoreCategory2ID"] ?? '',
                                'duration' => $item_details["Item"]["ListingDuration"],'location' => $item_details["Item"]["Location"],
                                'country' => $item_details["Item"]["Country"],'post_code' => $item_details["Item"]["PostalCode"] ?? '','draft_status' => 'a:4:{s:10:"title_flag";s:1:"1";s:16:"description_flag";s:1:"1";s:10:"image_flag";s:1:"1";s:11:"feeder_flag";s:1:"1";}','item_specifics' => \Opis\Closure\serialize($item_specifics),
                                'shipping_id' => $item_details["Item"]["SellerProfiles"]["SellerShippingProfile"]["ShippingProfileID"] ?? null,'payment_id' => $item_details["Item"]["SellerProfiles"]["SellerPaymentProfile"]["PaymentProfileID"] ?? null,'return_id' => $item_details["Item"]["SellerProfiles"]["SellerReturnProfile"]["ReturnProfileID"] ?? null,
                                'currency' => $item_details["Item"]["Currency"], 'paypal' => $item_details["Item"]["PayPalEmailAddress"] ?? '','image_attribute' => $image_attribute,
                                'profile_id' => $profile->id ?? '','type' => isset($item_details["Item"]["Variations"]) ? 'variable' : 'simple','product_status' => 'Active']);
                            if ($ebay_master_product_result->profile_id != null && strpos('<html>',$item_details["Item"]["Description"]) != null){
                                $final_template_result .= '<Description>'.'<![CDATA[';
                                $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$ebay_master_product_result->master_product_id )->get();
                                $profile_result = EbayProfile::find($ebay_master_product_result->profile_id);
                                $template_result =  EbayTemplate::find($profile_result->template_id);
                                //return $template_result;
                                $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));

                                $template_result = view('ebay.all_templates.'.$template_name,compact('product_result'));
                                $final_template_result .= $template_result.']]>'.'</Description>';
                            }

                            if ($ebay_master_product_result != null &&  $product_draft_result != null){

                                if (isset($item_details["Item"]["Variations"]["Variation"][0])){



                                    foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                                        $ean = '';
                                        $product_variation_specifics = array();
                                        $ebay_product_variation_specifics = array();
                                        $variation_update = '';
                                        $variation_update = '<VariationSpecifics>';
                                        $variation_sku = $item_details["Item"]["ItemID"];
                                        if (isset($variation["VariationProductListingDetails"])){
                                            if ($variation["VariationProductListingDetails"]["EAN"] != 'Does not apply' or $variation["VariationProductListingDetails"]["EAN"] != ''){
                                                $ean = $variation["VariationProductListingDetails"]["EAN"];
                                            }
                                        }

                                        if (isset($variation["VariationSpecifics"]["NameValueList"][0])){

                                            foreach ($variation["VariationSpecifics"]["NameValueList"] as $variation_specifics){
                                                $variation_attribute = Attribute::where('attribute_name',$variation_specifics["Name"])->get()->first();
                                                $variation_terms = AttributeTerm::where('terms_name',$variation_specifics["Value"])->get()->first();
                                                $product_variation_specifics[] = [
                                                    'attribute_id' => $variation_attribute->id,
                                                    'attribute_name' => $variation_attribute->attribute_name,
                                                    'terms_id' => $variation_terms->id,
                                                    'terms_name' => $variation_terms->terms_name,
                                                ];
                                                $ebay_product_variation_specifics[$variation_specifics["Name"]] = $variation_specifics["Value"];
                                                $variation_sku .= '_'.$variation_terms->terms_name;
                                                $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation_specifics["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation_specifics["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';

                                            }
                                            $variation_update .= '</VariationSpecifics>';
                                        }else{
                                            $variation_attribute = Attribute::where('attribute_name', $variation["VariationSpecifics"]["NameValueList"]["Name"])->get()->first();
                                            $variation_terms = AttributeTerm::where('terms_name', $variation["VariationSpecifics"]["NameValueList"]["Value"])->get()->first();
                                            $product_variation_specifics[] = [
                                                'attribute_id' => $variation_attribute->id,
                                                'attribute_name' => $variation_attribute->attribute_name,
                                                'terms_id' => $variation_terms->id,
                                                'terms_name' => $variation_terms->terms_name,
                                            ];
                                            $variation_sku .= '_'.$variation_terms->terms_name;
                                            $ebay_product_variation_specifics[$variation["VariationSpecifics"]["NameValueList"]["Name"]] = $variation["VariationSpecifics"]["NameValueList"]["Value"];
                                            $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation["VariationSpecifics"]["NameValueList"]["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation["VariationSpecifics"]["NameValueList"]["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';
                                            $variation_update .= '</VariationSpecifics>';
                                        }
                                        if (isset($variation["SKU"])){
                                            $variation_sku = str_replace('/',',',str_replace(' ','_',$variation["SKU"]));

                                        }else{
                                            $variation_sku = str_replace('/',',',str_replace(' ','_',$variation_sku));
                                        }
                                        $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $variation["SKU"] ?? $variation_sku,'attribute' => \Opis\Closure\serialize($product_variation_specifics), 'actual_quantity' => ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"]),'ean_no' => $ean,
                                            'regular_price' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $variation["StartPrice"]]);
                                        $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                        $quantity = 0;
                                        if ($shelf_product != null){

                                            $quantity = $shelf_product->quantity + ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"]);
                                            ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                        }else{
                                            ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"])]);
                                        }

                                        if ($product_variation_create_result != null){
                                            if (!isset($variation["SKU"])){
                                                $url = 'https://api.ebay.com/ws/api.dll';
                                                $headers = [
                                                    'X-EBAY-API-SITEID:'.$product->site_id,
                                                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                    'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                                ];
                                                $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>

                                                                        <Variations>
                                                                            <Variation>
                                                                            <SKU>'.$variation_sku.'</SKU>
                                                                              '.$variation_update.'
                                                                            </Variation>
                                                                        </Variations>
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                                $result = $this->curl($url,$headers,$body,'POST');
                                                $result =simplexml_load_string($result);
                                                $result = json_decode(json_encode($result),true);

                                                if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                    EbayVariationProduct::create(['sku' => $variation["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                        'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $variation["StartPrice"],
                                                        'rrp' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $variation["Quantity"], 'ean' => $ean]);
                                                    $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);
                                                }
                                            }else{
                                                EbayVariationProduct::create(['sku' => $variation["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $variation["StartPrice"],
                                                    'rrp' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $variation["Quantity"], 'ean' => $ean]);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);
                                            }


                                        }
                                        $product_variation_specifics = null;
                                        $ebay_product_variation_specifics = null;

                                    }
                                }elseif(isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){

                                    $ean = '';
                                    $product_variation_specifics = array();
                                    $ebay_product_variation_specifics = array();
                                    $variation_update = '';
                                    $variation_update = '<VariationSpecifics>';
                                    $variation_sku = $item_details["Item"]["ItemID"];
                                    if (isset($item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"])){
                                        if ($item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"] != 'Does not apply' or $item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"] != ''){
                                            $ean = $item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"];
                                        }
                                    }

                                    if (isset($item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"][0])){

                                        foreach ($item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"] as $variation_specifics){
                                            $variation_attribute = Attribute::where('attribute_name',$variation_specifics["Name"])->get()->first();
                                            $variation_terms = AttributeTerm::where('terms_name',$variation_specifics["Value"])->get()->first();
                                            $product_variation_specifics[] = [
                                                'attribute_id' => $variation_attribute->id,
                                                'attribute_name' => $variation_attribute->attribute_name,
                                                'terms_id' => $variation_terms->id,
                                                'terms_name' => $variation_terms->terms_name,
                                            ];
                                            $ebay_product_variation_specifics[$variation_specifics["Name"]] = $variation_specifics["Value"];
                                            $variation_sku .= '_'.$variation_terms->terms_name;
                                            $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation_specifics["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation_specifics["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';

                                        }
                                        $variation_update .= '</VariationSpecifics>';
                                    }else{
                                        $variation_attribute = Attribute::where('attribute_name', $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"])->get()->first();
                                        $variation_terms = AttributeTerm::where('terms_name', $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"])->get()->first();
                                        $product_variation_specifics[] = [
                                            'attribute_id' => $variation_attribute->id,
                                            'attribute_name' => $variation_attribute->attribute_name,
                                            'terms_id' => $variation_terms->id,
                                            'terms_name' => $variation_terms->terms_name,
                                        ];
                                        $variation_sku .= '_'.$variation_terms->terms_name;
                                        $ebay_product_variation_specifics[$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"]] = $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"];
                                        $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';
                                        $variation_update .= '</VariationSpecifics>';
                                    }
                                    if (isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$item_details["Item"]["Variations"]["Variation"]["SKU"]));

                                    }else{
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$variation_sku));
                                    }
                                    $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku,'attribute' => \Opis\Closure\serialize($product_variation_specifics), 'actual_quantity' => ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"]),'ean_no' => $ean,
                                        'regular_price' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"]]);
                                    $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                    $quantity = 0;
                                    if ($shelf_product != null){

                                        $quantity = $shelf_product->quantity + ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"]);
                                        ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                    }else{
                                        ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"])]);
                                    }

                                    if ($product_variation_create_result != null){
                                        if (!isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:'.$product->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                            ];
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>

                                                                        <Variations>
                                                                            <Variation>
                                                                            <SKU>'.$variation_sku.'</SKU>
                                                                              '.$variation_update.'
                                                                            </Variation>
                                                                        </Variations>
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                            $result = $this->curl($url,$headers,$body,'POST');
                                            $result =simplexml_load_string($result);
                                            $result = json_decode(json_encode($result),true);

                                            if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                EbayVariationProduct::create(['sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"],
                                                    'rrp' => $item_details["Item"]["Variations"]["Variation"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Variations"]["Variation"]["Quantity"], 'ean' => $ean]);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                            }
                                        }else{
                                            EbayVariationProduct::create(['sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"],
                                                'rrp' => $item_details["Item"]["Variations"]["Variation"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Variations"]["Variation"]["Quantity"], 'ean' => $ean]);
                                            $ebay_migration = EbayMigration::find($product->id);
                                            $ebay_migration->status = 1;
                                            $ebay_migration->save();
                                        }


                                    }
                                    $product_variation_specifics = null;
                                    $ebay_product_variation_specifics = null;


                                }elseif(!isset($item_details["Item"]["Variations"])){
                                    $variation_sku = null;
                                    if (isset($item_details["Item"]["SKU"])){
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$item_details["Item"]["SKU"]));

                                    }else{
                                        $variation_sku = random_int(1,1000000);
                                    }
                                    $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $item_details["Item"]["SKU"] ?? $variation_sku,'attribute' =>  '', 'actual_quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]),'ean_no' => $item_details["Item"]["ProductListingDetails"]["EAN"] ?? '',
                                        'regular_price' => $item_details["Item"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $item_details["Item"]["StartPrice"]]);
                                    $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                    $quantity = 0;
                                    if ($shelf_product != null){

                                        $quantity = $shelf_product->quantity + ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]);
                                        ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                    }else{
                                        ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"])]);
                                    }
                                    if ($product_variation_create_result != null){
                                        if (!isset($item_details["Item"]["SKU"])){
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:'.$product->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                            ];
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>
                                                                        <SKU>'.$variation_sku.'</SKU>

                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                            $result = $this->curl($url,$headers,$body,'POST');
                                            $result =simplexml_load_string($result);
                                            $result = json_decode(json_encode($result),true);

                                            if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                EbayVariationProduct::create(['sku' => $item_details["Item"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'start_price' => $item_details["Item"]["StartPrice"],
                                                    'rrp' => $item_details["Item"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Quantity"], 'ean' => $item_details['ProductListingDetails']["EAN"] ?? '']);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                            }
                                        }else{
                                            EbayVariationProduct::create(['sku' => $item_details["Item"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                'start_price' => $item_details["Item"]["StartPrice"],
                                                'rrp' => $item_details["Item"]["Variations"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]), 'ean' => $item_details['ProductListingDetails']["EAN"] ?? '']);
                                            $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                        }


                                    }
                                }

                            }

                        }


                        // }
                        //}
                    }



//                }
                    return response()->json(['done' => $ebay_migration_counter->where('status',1)->count(),'remains' => $ebay_migration_counter->where('status',0)->count(),'failed' => $ebay_migration_counter->where('status',3)->count()]);
                }else{
                    $ebayMigrationExist = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->first();
                    if($ebayMigrationExist){
                        $updateInfo = EbayMigration::find($ebayMigrationExist->id)->update(['status' => 1]);
                    }
                }
//                if ($item_details["Item"]["PrimaryCategory"]["CategoryID"] == '11483'){
//                    ProductDraft::create(['user_id' => 1,'woowms_category' => 14,'condition' => 1,'name' => $item_details["Item"]["Title"],'type' => 'variable']);
//                }
//                echo "<pre>";
//                print_r($item_details["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               foreach ($item_details as $item_detail){
//                                   echo "<pre>";
//                print_r($item_detail["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               }
//                            echo "<pre>";
//                            print_r($item_category_details);
//                            exit();
//               EbayMigration::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'item_id' => $item["ItemID"],
//                   'imgae' => $item["PictureDetails"]["GalleryURL"],'title' => $item["Title"],'category_id'=>$item_category_details["Item"]["PrimaryCategory"]["CategoryID"],
//                   'category_name' => $item_category_details["Item"]["PrimaryCategory"]["CategoryName"],
//                   'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $counter,'item_number' => $index]);
            }catch (Exception $ex){

//                return response()->json(['done' => $counter->where('status',1)->count(),'remains' => $counter->where('status',0)->count(),'failed' => $counter->where('status',3)->count()]);
                $ebayMigrationExist = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->first();
                if($ebayMigrationExist){
                    $updateInfo = EbayMigration::find($ebayMigrationExist->id)->update(['status' => 3,'message' => $ex]);
                }
                return response()->json(['done' => $ebay_migration_counter->where('status',1)->count(),'remains' => $ebay_migration_counter->where('status',0)->count(),'failed' => $ebay_migration_counter->where('status',3)->count()]);
            }

        }

    }

    public function migrationStarted(Request $request,$type){

//

        $master_image = array();
        $item_specifics = array();
        $item_ids = null;
        if ($type == 'old'){
            $item_ids = explode(',',$request->catalogue_id);
//            return $item_ids;
        }elseif ($type == 'new'){
            $item_ids  = EbayMigration::select('item_id')->get()->toArray();
//            return $item_ids;
        }

//        echo "<pre>";
////        print_r(explode(',',));
//        print_r($item_ids);
//        exit();
//        $ebay_migration_result = EbayMigration::where('status',0)->get()->all();

        foreach ($item_ids as $item_id){
            if ($type == 'old'){
                $item_id_value = explode('/',$item_id);
                $product = EbayMigration::where('item_id',$item_id_value[3])->get()->first();
//            return $product;
            }elseif ($type == 'new'){

                $product = EbayMigration::where('item_id',$item_id["item_id"])->get()->first();
//                return $product;
            }

//                    echo "<pre>";
////        print_r(explode(',',));
//        print_r($product);
//        exit();
            $account_result = EbayAccount::find($product->account_id);
            $variation_specifics = array();
            $final_template_result = '';

            $this->ebayAccessToken($account_result->refresh_token);
            try{
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$product->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->

                                  <ItemID>'.$product->item_id.'</ItemID>
                                    <DetailLevel>ItemReturnDescription</DetailLevel>
                                    <DetailLevel>ReturnAll</DetailLevel>
                                    <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                </GetItemRequest>';
                $item_details = $this->curl($url,$headers,$body,'POST');
                $item_details =simplexml_load_string($item_details);
                $item_details = json_decode(json_encode($item_details),true);
                // Log:info($product->item_id);
                $product_variation_specifics = array();
//                dd($item_details);
//                echo "<pre>";
//                print_r($item_details);
//                exit();




                $existCatalogueItemId = EbayMasterProduct::where('item_id',$item_details["Item"]["ItemID"])->first();

                if(!$existCatalogueItemId){

//                if(isset($item_details["Item"]["Variations"])){

                    if (isset($item_details["Item"]["Variations"]["Variation"][0])){
                        $counter = 0;
                        foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                            if (isset($variation["SKU"])){
                                $product_variation_find = ProductVariation::where('sku',$variation["SKU"])->first();
                                if ($product_variation_find != null){
                                    $counter++;

                                }
                            }

                        }
                    }else{
                        $counter = 0;
                        if (isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                            $product_variation_find = ProductVariation::where('sku',$item_details["Item"]["Variations"]["Variation"]["SKU"])->first();
                            if ($product_variation_find != null){
                                $counter++;

                            }
                        }
//                        elseif(isset($item_details["Item"]["Variations"]["Variation"]["SKU"])) {
//                            $product_variation_find = ProductVariation::where('sku', $item_details["Item"]["Variations"]["Variation"]["SKU"])->first();
//                            if ($product_variation_find != null) {
//                                $counter++;
//
//                            }
//                        }
                    }
//                        print_r($counter);
//                        echo '***';
//                        print_r(sizeof($item_details["Item"]["Variations"]["Variation"]));
//                        exit();
//                    dd('test');
                    if( $counter == 0){

                        //foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                        $attribute_array = array();

                        //$product_variation_result  = ProductVariation::with('product_draft')->where('sku' , $variation["SKU"])->get()->first();
//                                                        echo "<pre>";
//                            print_r($product_variation_result);
//                            exit();
                        //if (!$product_variation_result){
                        $woowms_category_result = WooWmsCategory::where(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"]])->get()->first();
                        if (!isset($woowms_category_result->id)){
                            $woowms_category_result = WooWmsCategory::create(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],'user_id' => 1]);
                        }
                        if (isset($item_details["Item"]["ConditionID"])){
                            $woowms_condition_result = Condition::where(['condition_name' => $item_details["Item"]["ConditionDisplayName"]])->get()->first();
                            if(!isset($woowms_condition_result->id)){
                                $woowms_condition_result = Condition::create(['id' => $item_details["Item"]["ConditionID"] , 'condition_name' => $item_details["Item"]["ConditionDisplayName"], 'user_id' => 1]);
                            }
                        }


                        if (isset($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"][0]) && isset($item_details["Item"]["Variations"])){

                            foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"] as $key => $attribute){
                                $attribute_result = Attribute::where('attribute_name',$attribute["Name"])->get()->first();
                                if (!$attribute_result){
                                    $last_attribute = Attribute::get()->last();
                                    if (isset($last_attribute->id)){
                                        $attribute_result = Attribute::create(['id'=> ($last_attribute->id+1),'attribute_name' => $attribute["Name"]]);
                                    }else{
                                        $attribute_result = Attribute::create(['id'=> 1,'attribute_name' => $attribute["Name"]]);
                                    }
                                }
                                $all_terms = array();


                                if (isset($attribute["Value"][0]) && is_array($attribute["Value"])){


                                    foreach ($attribute["Value"] as $index => $terms){
                                        // Log::info($terms);

                                        $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                        if (!$attribute_terms_result){
                                            $last_attribute_terms = AttributeTerm::get()->last();
                                            if (isset($last_attribute_terms->id)){
                                                $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                            }else{
                                                $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                            }

                                        }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                        $all_terms[] =[
                                            'attribute_term_name' => $terms,
                                            'attribute_term_id' => $attribute_terms_result->id
                                        ] ;
//                                                $temp[] = $attribute_array;

                                    }

                                    $attribute_array [$attribute_result->id] =[
                                        $attribute["Name"] => $all_terms
                                    ];
                                }else{
                                    $attribute_terms_result = AttributeTerm::where('terms_name',$attribute["Value"])->get()->first();
                                    if (!$attribute_terms_result){
                                        $last_attribute_terms = AttributeTerm::get()->last();
                                        if (isset($last_attribute_terms->id)) {
                                            $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $attribute["Value"]]);
                                        }else{
                                            $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $attribute["Value"]]);
                                        }
                                    }

                                    $attribute_array [$attribute_result->id] =[
                                        $attribute["Name"] =>[
                                            [
                                                "attribute_term_id" => $attribute_terms_result->id,
                                                "attribute_term_name" => $attribute["Value"]
                                            ]
                                        ]
                                    ];
                                }


                            }
//                                    echo "<pre>";
//                                    print_r($attribute_array);
                            // exit();
                        }elseif(!isset($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"][0]) && isset($item_details["Item"]["Variations"])){

                            $attribute_result = Attribute::where('attribute_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"])->get()->first();
                            if (!isset($attribute_result->id)){
                                $last_attribute = Attribute::get()->last();
                                if (isset($last_attribute->id)) {
                                    $attribute_result = Attribute::create(['id' => ($last_attribute->id+1),'attribute_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"]]);
                                }else{
                                    $attribute_result = Attribute::create(['id' => 1,'attribute_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"]]);
                                }
                            }


                            $all_terms = array();

                            if(is_array($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])){
                                foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"] as $terms){

                                    $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                    if (!isset($attribute_terms_result->id)){
                                        $last_attribute_terms = AttributeTerm::get()->last();
                                        if (isset($last_attribute_terms->id)) {
                                            $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                        }else{
                                            $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                        }
                                    }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                    $all_terms[] =[
                                        'attribute_term_name' => $terms,
                                        'attribute_term_id' => $attribute_terms_result->id
                                    ] ;
//                                                $temp[] = $attribute_array;

                                }

                                $attribute_array [$attribute_result->id] =[
                                    $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => $all_terms
                                ];
                            }else{

                                $attribute_terms_result = AttributeTerm::where('terms_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])->get()->first();
                                if (!isset($attribute_terms_result->id)){
                                    $last_attribute_terms = AttributeTerm::get()->last();
                                    if (isset($last_attribute_terms->id)) {
                                        $attribute_terms_result = AttributeTerm::create(['id' => ($last_attribute_terms->id+1),'attribute_id' => $attribute_result->id, 'terms_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]]);
                                    }else{
                                        $attribute_terms_result = AttributeTerm::create(['id' => 1,'attribute_id' => $attribute_result->id, 'terms_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]]);
                                    }
                                }

                                $attribute_array [$attribute_result->id] =[
                                    $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => [
                                        ["attribute_term_id" => $attribute_terms_result->id,
                                            "attribute_term_name" => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]

                                        ]
                                    ]
                                ];
                            }
                        }

//                                    echo "<pre>";
//                                    print_r($attribute_array);
//                                    exit();

                        $product_draft_result = ProductDraft::create(['user_id' => Auth::id(),'modifier_id' => Auth::id(),'woowms_category' => $woowms_category_result->id , 'condition' => $woowms_condition_result->id ?? NULL,
                            'name' => $item_details["Item"]["Title"],'description' => $item_details["Item"]["Description"],'type' => isset($item_details["Item"]["Variations"]) ? 'variable' : 'simple','sale_price' => $item_details["Item"]["StartPrice"],'rrp' => $item_details["Item"]["StartPrice"],
                            'attribute' => \Opis\Closure\serialize($attribute_array),'status' => 'publish']);
                        if (isset($item_details["Item"]["Variations"]["Pictures"])){
                            $variation_image_array = $this->getVariationImage($item_details["Item"]["Variations"]["Pictures"]);
                        }

                        if ($product_draft_result){
                            $master_image = array();
                            if (isset($item_details["Item"]["PictureDetails"])){

                                if ( isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                    if (is_array($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                        foreach ($item_details["Item"]["PictureDetails"]["PictureURL"] as $image_url){

                                            $name = $this->uploadSingleImage($image_url,'product_image_custom');
                                            Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => '/uploads/product-images/'.$name]);
                                            $master_image[] = '/uploads/product-images/'.$name;
                                        }
                                    }else{
                                        if (isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                            $url = $item_details["Item"]["PictureDetails"]["PictureURL"];
                                        }
                                        $name = $this->uploadSingleImage($url,'product_image_custom');
                                        Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => '/uploads/product-images/'.$name]);
                                        $master_image[] = '/uploads/product-images/'.$name;
                                    }

                                }else{
                                    if (isset($item_details["Item"]["PictureDetails"]["GalleryURL"])){
                                        $url = $item_details["Item"]["PictureDetails"]["GalleryURL"];
                                    }
                                    $name = $this->uploadSingleImage($url,'product_image_custom');
                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => '/uploads/product-images/'.$name]);
                                    $master_image[] = '/uploads/product-images/'.$name;
                                }
                            }




                            $master_product_find_result = ProductDraft::where('id' , $product_draft_result->id)->first();
                            if (isset($item_details["Item"]["Variations"]["Variation"])){
                                foreach (\Opis\Closure\unserialize($master_product_find_result->attribute) as $attribute_id => $attribute_array){


                                    foreach ($attribute_array as $attribute_name => $terms_array){
//                echo "<pre>";
//                print_r($terms);
//                exit();
                                        if (is_array($terms_array)){
                                            foreach ($terms_array as $terms){
                                                if (isset($terms["attribute_term_name"])){
                                                    $variation_specifics[$attribute_name][] =$terms["attribute_term_name"];
                                                }

//                                                $variation_image[$attribute_name][$terms["attribute_term_name"]][] = $product_variation['image'];
                                            }
                                        }else{
                                            if (isset($attribute_name)){
                                                $variation_specifics[$attribute_name][] = $terms_array;
                                            }
                                        }


                                    }

                                }
                            }


                            if (isset($item_details["Item"]["ItemSpecifics"]["NameValueList"][0])){
                                foreach ($item_details["Item"]["ItemSpecifics"]["NameValueList"] as $item_specifics_array){
                                    if (is_array($item_specifics_array['Value'])){
                                        $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'][0];
                                    }else{
                                        $item_specifics[$item_specifics_array['Name']] =  $item_specifics_array['Value'];
                                    }

                                }
                            }
                            $variation_image= array();
                            $terms_array = array();
                            $image_attribute = '';
                            if (isset($item_details["Item"]["Variations"]["Variation"])){
                                if (isset($item_details["Item"]["Variations"]["Pictures"][0])){
                                    foreach ($item_details["Item"]["Variations"]["Pictures"] as $variation_image_array){
                                        if (isset($variation_image_array["VariationSpecificPictureSet"]["PictureURL"][0])){
                                            foreach ($variation_image_array["VariationSpecificPictureSet"]["PictureURL"] as $url){
                                                $terms_array[$variation_image_array["VariationSpecificValue"]][] = $url;
                                            }
                                            $variation_image[$variation_image_array["VariationSpecificName"]] = $terms_array;
                                        }
                                    }
                                }else{
                                    if (isset($item_details["Item"]["Variations"]["Pictures"])){
                                        foreach ($item_details["Item"]["Variations"]["Pictures"]["VariationSpecificPictureSet"] as $terms_image){
//                        echo "<pre>";
//                        print_r($terms_image["VariationSpecificValue"]);
//                        exit();
                                            if(isset($terms_image["VariationSpecificValue"])){
                                                $terms_array[$terms_image["VariationSpecificValue"]][] = $terms_image["PictureURL"];
                                            }

                                        }
                                        $variation_image[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $terms_array;
                                    }


                                }
                                if (isset($variation_specifics)){
                                    $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                                }

                                if (isset($item_details["Item"]["Variations"]["Pictures"])){
                                    $image_attribute = $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"];
                                }else{
                                    $image_attribute = '';
                                }
                            }

                            $profile = EbayProfile::where('category_id',$item_details["Item"]["PrimaryCategory"]["CategoryID"])->first();

                            $ebay_master_product_result = EbayMasterProduct::create(['account_id' => $product->account_id,'master_product_id' => $product_draft_result->id,'site_id' => $product->site_id,
                                'title' => $item_details["Item"]["Title"],'subtitle' => $item_details["Item"]["SubTitle"] ?? '', 'item_id' => $item_details["Item"]["ItemID"],'item_description' => $item_details["Item"]["Description"],'description' => $item_details["Item"]["Description"],
                                'variation_specifics' => empty($variation_specifics) ? '' : $variation_specifics,'master_images' => \Opis\Closure\serialize($master_image) ?? '','variation_images' => \Opis\Closure\serialize($variation_image) ?? '','product_type' => 'product_type',
                                'dispatch_time' => $item_details["Item"]["DispatchTimeMax"] ?? '','start_price' => $item_details["Item"]["StartPrice"],
                                'condition_id' => $item_details["Item"]["ConditionID"] ?? NULL,'condition_name' => $item_details["Item"]["ConditionDisplayName"] ?? NULL,
                                'category_id' => $item_details["Item"]["PrimaryCategory"]["CategoryID"],'category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],
                                'store_id' =>  $item_details["Item"]["Storefront"]["StoreCategoryID"] ?? '','store2_id' => $item_details["Item"]["Storefront"]["StoreCategory2ID"] ?? '',
                                'duration' => $item_details["Item"]["ListingDuration"],'location' => $item_details["Item"]["Location"],
                                'country' => $item_details["Item"]["Country"],'post_code' => $item_details["Item"]["PostalCode"] ?? '','draft_status' => 'a:4:{s:10:"title_flag";s:1:"1";s:16:"description_flag";s:1:"1";s:10:"image_flag";s:1:"1";s:11:"feeder_flag";s:1:"1";}','item_specifics' => \Opis\Closure\serialize($item_specifics),
                                'shipping_id' => $item_details["Item"]["SellerProfiles"]["SellerShippingProfile"]["ShippingProfileID"] ?? null,'payment_id' => $item_details["Item"]["SellerProfiles"]["SellerPaymentProfile"]["PaymentProfileID"] ?? null,'return_id' => $item_details["Item"]["SellerProfiles"]["SellerReturnProfile"]["ReturnProfileID"] ?? null,
                                'currency' => $item_details["Item"]["Currency"], 'paypal' => $item_details["Item"]["PayPalEmailAddress"] ?? '','image_attribute' => $image_attribute,
                                'profile_id' => $profile->id ?? '','type' => isset($item_details["Item"]["Variations"]) ? 'variable' : 'simple' ,'product_status' => 'Active']);
                            if ($ebay_master_product_result->profile_id != null && strpos('<html>',$item_details["Item"]["Description"]) != null){
                                $final_template_result .= '<Description>'.'<![CDATA[';
                                $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$ebay_master_product_result->master_product_id )->get();
                                $profile_result = EbayProfile::find($ebay_master_product_result->profile_id);
                                $template_result =  EbayTemplate::find($profile_result->template_id);
                                //return $template_result;
                                $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));

                                $template_result = view('ebay.all_templates.'.$template_name,compact('product_result'));
                                $final_template_result .= $template_result.']]>'.'</Description>';
                            }

                            if ($ebay_master_product_result != null &&  $product_draft_result != null){

                                if (isset($item_details["Item"]["Variations"]["Variation"][0])){



                                    foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                                        $ean = '';
                                        $product_variation_specifics = array();
                                        $ebay_product_variation_specifics = array();
                                        $variation_update = '';
                                        $variation_update = '<VariationSpecifics>';
                                        $variation_sku = $item_details["Item"]["ItemID"];
                                        if (isset($variation["VariationProductListingDetails"])){
                                            if ($variation["VariationProductListingDetails"]["EAN"] != 'Does not apply' or $variation["VariationProductListingDetails"]["EAN"] != ''){
                                                $ean = $variation["VariationProductListingDetails"]["EAN"];
                                            }
                                        }

                                        if (isset($variation["VariationSpecifics"]["NameValueList"][0])){
                                            $master_image_attribute_array = array();
                                            $master_variation_images_array = array();
                                            foreach ($variation["VariationSpecifics"]["NameValueList"] as $variation_specifics){
                                                $variation_attribute = Attribute::where('attribute_name',$variation_specifics["Name"])->get()->first();
                                                $variation_terms = AttributeTerm::where('terms_name',$variation_specifics["Value"])->get()->first();
                                                $product_variation_specifics[] = [
                                                    'attribute_id' => $variation_attribute->id,
                                                    'attribute_name' => $variation_attribute->attribute_name,
                                                    'terms_id' => $variation_terms->id,
                                                    'terms_name' => $variation_terms->terms_name,
                                                ];
                                                $ebay_product_variation_specifics[$variation_specifics["Name"]] = $variation_specifics["Value"];
                                                $variation_sku .= '_'.$variation_terms->terms_name;
                                                $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation_specifics["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation_specifics["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';

                                                if ($variation_attribute->attribute_name == $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"] && isset($variation_image_array[$variation_terms->terms_name])){
                                                    $master_image_attribute_array[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $variation_terms->terms_name;
//                                                    $master_variation_images_array = $variation_image_array[$variation_terms->terms_name];
                                                    foreach ($variation_image_array[$variation_terms->terms_name] as $url){
                                                        $name = $this->uploadSingleImage($url,'product_image_custom');
//                                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => '/uploads/product-images/'.$name]);
                                                        $master_variation_images_array[] = '/uploads/product-images/'.$name;
                                                    }
//                                                    echo "<pre>";
//                                                    print_r($master_variation_images_array);
//                                                    exit();

                                                }


                                            }
                                            $variation_update .= '</VariationSpecifics>';
                                        }else{
                                            $variation_attribute = Attribute::where('attribute_name', $variation["VariationSpecifics"]["NameValueList"]["Name"])->get()->first();
                                            $variation_terms = AttributeTerm::where('terms_name', $variation["VariationSpecifics"]["NameValueList"]["Value"])->get()->first();
                                            $product_variation_specifics[] = [
                                                'attribute_id' => $variation_attribute->id,
                                                'attribute_name' => $variation_attribute->attribute_name,
                                                'terms_id' => $variation_terms->id,
                                                'terms_name' => $variation_terms->terms_name,
                                            ];
                                            if(isset($item_details["Item"]["Variations"]["Pictures"])){
                                                if ($variation_attribute->attribute_name == $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"] && isset($variation_image_array[$variation_terms->terms_name])){
                                                    $master_image_attribute_array[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $variation_terms->terms_name;
                                                    //                                                $master_variation_images_array = $variation_image_array[$variation_terms->terms_name];
                                                    foreach ($variation_image_array[$variation_terms->terms_name] as $url){
                                                        $name = $this->uploadSingleImage($url,'product_image_custom');
                                                        //                                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => '/uploads/product-images/'.$name]);
                                                        $master_variation_images_array[] = '/uploads/product-images/'.$name;
                                                    }
                                                    //                                                echo "<pre>";
                                                    //                                                print_r($master_variation_images_array);
                                                    //                                                exit();
                                                }
                                            }

                                            $variation_sku .= '_'.$variation_terms->terms_name;
                                            $ebay_product_variation_specifics[$variation["VariationSpecifics"]["NameValueList"]["Name"]] = $variation["VariationSpecifics"]["NameValueList"]["Value"];
                                            $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation["VariationSpecifics"]["NameValueList"]["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation["VariationSpecifics"]["NameValueList"]["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';
                                            $variation_update .= '</VariationSpecifics>';
                                        }

                                        if (isset($variation["SKU"])){
                                            $variation_sku = str_replace('/',',',str_replace(' ','_',$variation["SKU"]));

                                        }else{
                                            $variation_sku = str_replace('/',',',str_replace(' ','_',$variation_sku));
                                        }
                                        $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $variation["SKU"] ?? $variation_sku,'attribute' => \Opis\Closure\serialize($product_variation_specifics),'image' => $master_image_attribute_array[0],'image_attribute' => \Opis\Closure\serialize($master_image_attribute_array),'variation_images' =>  \Opis\Closure\serialize($master_variation_images_array),'actual_quantity' => ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"]),'ean_no' => $ean,
                                            'regular_price' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $variation["StartPrice"]]);
                                        $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                        $quantity = 0;
                                        if ($shelf_product != null){

                                            $quantity = $shelf_product->quantity + ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"]);
                                            ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                        }else{
                                            ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($variation["Quantity"]-$variation["SellingStatus"]["QuantitySold"])]);
                                        }

                                        if ($product_variation_create_result != null){
                                            if (!isset($variation["SKU"])){
                                                $url = 'https://api.ebay.com/ws/api.dll';
                                                $headers = [
                                                    'X-EBAY-API-SITEID:'.$product->site_id,
                                                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                    'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                                ];
                                                $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>

                                                                        <Variations>
                                                                            <Variation>
                                                                            <SKU>'.$variation_sku.'</SKU>
                                                                              '.$variation_update.'
                                                                            </Variation>
                                                                        </Variations>
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                                $result = $this->curl($url,$headers,$body,'POST');
                                                $result =simplexml_load_string($result);
                                                $result = json_decode(json_encode($result),true);

                                                if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                    EbayVariationProduct::create(['sku' => $variation["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                        'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $variation["StartPrice"],
                                                        'rrp' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $variation["Quantity"], 'ean' => $ean]);
                                                    $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);
                                                }
                                            }else{
                                                EbayVariationProduct::create(['sku' => $variation["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $variation["StartPrice"],
                                                    'rrp' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $variation["Quantity"], 'ean' => $ean]);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);
                                            }


                                        }
                                        $product_variation_specifics = null;
                                        $ebay_product_variation_specifics = null;

                                    }
                                }elseif(isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){

                                    $ean = '';
                                    $product_variation_specifics = array();
                                    $ebay_product_variation_specifics = array();
                                    $variation_update = '';
                                    $variation_update = '<VariationSpecifics>';
                                    $variation_sku = $item_details["Item"]["ItemID"];
                                    $master_image_attribute_array = array();
                                    $master_variation_images_array = array();
                                    if (isset($item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"])){
                                        if ($item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"] != 'Does not apply' or $item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"] != ''){
                                            $ean = $item_details["Item"]["Variations"]["Variation"]["VariationProductListingDetails"]["EAN"];
                                        }
                                    }

                                    if (isset($item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"][0])){

                                        foreach ($item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"] as $variation_specifics){
                                            $variation_attribute = Attribute::where('attribute_name',$variation_specifics["Name"])->get()->first();
                                            $variation_terms = AttributeTerm::where('terms_name',$variation_specifics["Value"])->get()->first();
                                            $product_variation_specifics[] = [
                                                'attribute_id' => $variation_attribute->id,
                                                'attribute_name' => $variation_attribute->attribute_name,
                                                'terms_id' => $variation_terms->id,
                                                'terms_name' => $variation_terms->terms_name,
                                            ];
                                            if ($variation_attribute->attribute_name == $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"] && isset($variation_image_array[$variation_terms->terms_name])){
                                                $master_image_attribute_array[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $variation_terms->terms_name;
                                                $master_variation_images_array = $variation_image_array[$variation_terms->terms_name];
                                            }
                                            $ebay_product_variation_specifics[$variation_specifics["Name"]] = $variation_specifics["Value"];
                                            $variation_sku .= '_'.$variation_terms->terms_name;
                                            $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$variation_specifics["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$variation_specifics["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';

                                        }
                                        $variation_update .= '</VariationSpecifics>';
                                    }else{
                                        $variation_attribute = Attribute::where('attribute_name', $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"])->get()->first();
                                        $variation_terms = AttributeTerm::where('terms_name', $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"])->get()->first();
                                        $product_variation_specifics[] = [
                                            'attribute_id' => $variation_attribute->id,
                                            'attribute_name' => $variation_attribute->attribute_name,
                                            'terms_id' => $variation_terms->id,
                                            'terms_name' => $variation_terms->terms_name,
                                        ];
                                        if(isset($item_details["Item"]["Variations"]["Pictures"])){
                                            if ($variation_attribute->attribute_name == $item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"] && isset($variation_image_array[$variation_terms->terms_name])){
                                                $master_image_attribute_array[$item_details["Item"]["Variations"]["Pictures"]["VariationSpecificName"]] = $variation_terms->terms_name;
                                                foreach ($variation_image_array[$variation_terms->terms_name] as $url){

                                                }
                                                $master_variation_images_array = $variation_image_array[$variation_terms->terms_name];
                                            }
                                        }

                                        $variation_sku .= '_'.$variation_terms->terms_name;
                                        $ebay_product_variation_specifics[$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"]] = $item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"];
                                        $variation_update .=  '<NameValueList>
                                                                                    <Name>'.$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Name"].'</Name>
                                                                                    <Value>'.'<![CDATA['.$item_details["Item"]["Variations"]["Variation"]["VariationSpecifics"]["NameValueList"]["Value"].']]>'.'</Value>
                                                                                    </NameValueList>';
                                        $variation_update .= '</VariationSpecifics>';
                                    }
                                    if (isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$item_details["Item"]["Variations"]["Variation"]["SKU"]));

                                    }else{
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$variation_sku));
                                    }
                                    $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku,'attribute' => \Opis\Closure\serialize($product_variation_specifics),'image_attribute' => \Opis\Closure\serialize($master_image_attribute_array),'image' => $master_image_attribute_array[0],'variation_images' =>  \Opis\Closure\serialize($master_variation_images_array), 'actual_quantity' => ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"]),'ean_no' => $ean,
                                        'regular_price' => $variation["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"]]);
                                    $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                    $quantity = 0;
                                    if ($shelf_product != null){

                                        $quantity = $shelf_product->quantity + ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"]);
                                        ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                    }else{
                                        ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($item_details["Item"]["Variations"]["Variation"]["Quantity"]-$item_details["Item"]["Variations"]["Variation"]["SellingStatus"]["QuantitySold"])]);
                                    }

                                    if ($product_variation_create_result != null){
                                        if (!isset($item_details["Item"]["Variations"]["Variation"]["SKU"])){
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:'.$product->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                            ];
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>

                                                                        <Variations>
                                                                            <Variation>
                                                                            <SKU>'.$variation_sku.'</SKU>
                                                                              '.$variation_update.'
                                                                            </Variation>
                                                                        </Variations>
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                            $result = $this->curl($url,$headers,$body,'POST');
                                            $result =simplexml_load_string($result);
                                            $result = json_decode(json_encode($result),true);

                                            if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                EbayVariationProduct::create(['sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"],
                                                    'rrp' => $item_details["Item"]["Variations"]["Variation"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Variations"]["Variation"]["Quantity"], 'ean' => $ean]);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                            }
                                        }else{
                                            EbayVariationProduct::create(['sku' => $item_details["Item"]["Variations"]["Variation"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                'variation_specifics' => \Opis\Closure\serialize($ebay_product_variation_specifics), 'start_price' => $item_details["Item"]["Variations"]["Variation"]["StartPrice"],
                                                'rrp' => $item_details["Item"]["Variations"]["Variation"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Variations"]["Variation"]["Quantity"], 'ean' => $ean]);
                                            $ebay_migration = EbayMigration::find($product->id);
                                            $ebay_migration->status = 1;
                                            $ebay_migration->save();
                                        }


                                    }
                                    $product_variation_specifics = null;
                                    $ebay_product_variation_specifics = null;


                                }elseif(!isset($item_details["Item"]["Variations"])){
                                    $variation_sku = null;
                                    if (isset($item_details["Item"]["SKU"])){
                                        $variation_sku = str_replace('/',',',str_replace(' ','_',$item_details["Item"]["SKU"]));

                                    }else{
                                        $variation_sku = random_int(1,1000000);
                                    }
                                    $product_variation_create_result = ProductVariation::create(['product_draft_id' => $product_draft_result->id,'sku' => $item_details["Item"]["SKU"] ?? $variation_sku,'attribute' =>  '','image' => $master_image_attribute_array[0],'variation_images' =>  \Opis\Closure\serialize($master_variation_images_array), 'actual_quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]),'ean_no' => $item_details["Item"]["ProductListingDetails"]["EAN"] ?? '',
                                        'regular_price' => $item_details["Item"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'sale_price' => $item_details["Item"]["StartPrice"]]);
                                    $shelf_product = ShelfedProduct::where('variation_id', $product_variation_create_result->id)->get()->first();
                                    $quantity = 0;
                                    if ($shelf_product != null){

                                        $quantity = $shelf_product->quantity + ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]);
                                        ShelfedProduct::where('variation_id', $product_variation_create_result->id)->update(['quantity' => $quantity]);
                                    }else{
                                        ShelfedProduct::create(['shelf_id' => 1, 'variation_id' => $product_variation_create_result->id,'quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"])]);
                                    }
                                    if ($product_variation_create_result != null){
                                        if (!isset($item_details["Item"]["SKU"])){
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:'.$product->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                                            ];
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">

                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <ItemID>'.$item_details["Item"]["ItemID"].'</ItemID>
                                                                        <SKU>'.$variation_sku.'</SKU>

                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
//                                                            '.$final_template_result.'
                                            $result = $this->curl($url,$headers,$body,'POST');
                                            $result =simplexml_load_string($result);
                                            $result = json_decode(json_encode($result),true);

                                            if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                                                EbayVariationProduct::create(['sku' => $item_details["Item"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                    'start_price' => $item_details["Item"]["StartPrice"],
                                                    'rrp' => $item_details["Item"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => $item_details["Item"]["Quantity"], 'ean' => $item_details['ProductListingDetails']["EAN"] ?? '']);
                                                $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                            }
                                        }else{
                                            EbayVariationProduct::create(['sku' => $item_details["Item"]["SKU"] ?? $variation_sku, 'ebay_master_product_id' => $ebay_master_product_result->id, 'master_variation_id' => $product_variation_create_result->id,
                                                'start_price' => $item_details["Item"]["StartPrice"],
                                                'rrp' => $item_details["Item"]["Variations"]["OriginalRetailPrice"]["DiscountPriceInfo"] ?? 0.00, 'quantity' => ($item_details["Item"]["Quantity"]-$item_details["Item"]["SellingStatus"]["QuantitySold"]), 'ean' => $item_details['ProductListingDetails']["EAN"] ?? '']);
                                            $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                                        }


                                    }
                                }

                            }

                        }


                        // }
                        //}
                    }



//                }
                }else{
                    $ebayMigrationExist = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->first();
                    if($ebayMigrationExist){
                        $updateInfo = EbayMigration::find($ebayMigrationExist->id)->update(['status' => 1]);
                    }
                }
//                if ($item_details["Item"]["PrimaryCategory"]["CategoryID"] == '11483'){
//                    ProductDraft::create(['user_id' => 1,'woowms_category' => 14,'condition' => 1,'name' => $item_details["Item"]["Title"],'type' => 'variable']);
//                }
//                echo "<pre>";
//                print_r($item_details["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               foreach ($item_details as $item_detail){
//                                   echo "<pre>";
//                print_r($item_detail["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               }
//                            echo "<pre>";
//                            print_r($item_category_details);
//                            exit();
//               EbayMigration::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'item_id' => $item["ItemID"],
//                   'imgae' => $item["PictureDetails"]["GalleryURL"],'title' => $item["Title"],'category_id'=>$item_category_details["Item"]["PrimaryCategory"]["CategoryID"],
//                   'category_name' => $item_category_details["Item"]["PrimaryCategory"]["CategoryName"],
//                   'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $counter,'item_number' => $index]);
            }catch (Exception $ex){
            }

        }
    }

    public function getVariationImage($pictures){
        $variation_image = array();
        $terms_array = array();
        if (isset($pictures[0])){
            foreach ($pictures as $variation_image_array){
                if (isset($variation_image_array["VariationSpecificPictureSet"]["PictureURL"][0])){
                    foreach ($variation_image_array["VariationSpecificPictureSet"]["PictureURL"] as $url){
                        $terms_array[$variation_image_array["VariationSpecificValue"]][] = $url;
                    }
                    $variation_image[$variation_image_array["VariationSpecificName"]] = $terms_array;
                }
            }
        }else{
            if (isset($pictures)){

                foreach ($pictures["VariationSpecificPictureSet"] as $terms_image){

                    if (gettype($terms_image["PictureURL"]) == "array"){
                        foreach ($terms_image["PictureURL"] as $picture_url){
                            $terms_array[$terms_image["VariationSpecificValue"]][] = $picture_url;
                        }
                    }else{
                        if(isset($terms_image["VariationSpecificValue"])){
                            $terms_array[$terms_image["VariationSpecificValue"]][] = $terms_image["PictureURL"];
                        }
                    }

                }
//                $variation_image[$pictures["VariationSpecificName"]] = $terms_array;
            }
        }
        return $terms_array;
    }

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }
    public function onlyDraftProduct(){
        set_time_limit(50000);
//        $product = EbayVariationProduct::find(1);
//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($product->variation_specifics));
//        exit();
//        $ebay_migration = EbayMasterProduct::find(1);
//
//        echo "<pre>";
//        print_r(\Opis\Closure\unserialize($ebay_migration->variation_images));
//        exit();
        $master_image = array();
        $item_specifics = array();

        $ebay_migration_result = EbayMigration::where('status',0)->get()->all();

        foreach ($ebay_migration_result as $product){
            $account_result = EbayAccount::find($product->account_id);
            $this->ebayAccessToken($account_result->refresh_token);
            try{
                $url = 'https://api.ebay.com/ws/api.dll';
                $headers = [
                    'X-EBAY-API-SITEID:'.$product->site_id,
                    'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                    'X-EBAY-API-CALL-NAME:GetItem',
                    'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                ];
                $body = '<?xml version="1.0" encoding="utf-8"?>
                                <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                      <!--Enter an ItemID-->
                                   <ItemID>'.$product->item_id.'</ItemID>
                                    <DetailLevel>ItemReturnDescription</DetailLevel>
                                    <DetailLevel>ReturnAll</DetailLevel>
                                    <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                </GetItemRequest>';
                $item_details = $this->curl($url,$headers,$body,'POST');
                $item_details =simplexml_load_string($item_details);
                $item_details = json_decode(json_encode($item_details),true);

                if(isset($item_details["Item"]["Variations"])){


//                        $counter = 0;
//                        foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
//                            if (isset($variation["SKU"])){
//                                $product_variation_find = ProductVariation::where('sku',$variation["SKU"])->first();
//                                if ($product_variation_find != null){
//                                    $counter++;
//
//                                }
//                            }
//
//                        }
//                        print_r($counter);
//                        echo '***';
//                        print_r(sizeof($item_details["Item"]["Variations"]["Variation"]));
//                        exit();
//                        if( $counter == 0){
                    //foreach ($item_details["Item"]["Variations"]["Variation"] as $variation){
                    $attribute_array = array();

                    //$product_variation_result  = ProductVariation::with('product_draft')->where('sku' , $variation["SKU"])->get()->first();
//                                                        echo "<pre>";
//                            print_r($product_variation_result);
//                            exit();
                    //if (!$product_variation_result){
                    $woowms_category_result = WooWmsCategory::where([ 'category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"]])->get()->first();
                    if (!isset($woowms_category_result->id)){
                        $woowms_category_result = WooWmsCategory::create(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],'user_id' => 1]);
                    }
                    if (isset($item_details["Item"]["ConditionID"])){
                        $woowms_condition_result = Condition::where([ 'condition_name' => $item_details["Item"]["ConditionDisplayName"]])->get()->first();
                        if(!isset($woowms_condition_result->id)){
                            $woowms_condition_result = Condition::create(['condition_name' => $item_details["Item"]["ConditionDisplayName"], 'user_id' => 1]);
                        }
                    }


                    if (is_array($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]) && isset($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"][0])){

                        foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"] as $attribute){
                            $attribute_result = Attribute::where('attribute_name',$attribute["Name"])->get()->first();
                            if (!$attribute_result){
                                $attribute_result = Attribute::create(['attribute_name' => $attribute["Name"]]);
                            }
                            $all_terms = array();
                            if (is_array($attribute["Value"])){

                                foreach ($attribute["Value"] as $terms){

                                    $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                    if (!$attribute_terms_result){
                                        $attribute_terms_result = AttributeTerm::create(['attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                    }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                    $all_terms[] =[
                                        'attribute_term_name' => $terms,
                                        'attribute_term_id' => $attribute_terms_result->id
                                    ] ;
//                                                $temp[] = $attribute_array;

                                }

                                $attribute_array [$attribute_result->id] =[
                                    $attribute["Name"] => $all_terms
                                ];
                            }else{
                                $attribute_terms_result = AttributeTerm::where('terms_name',$attribute["Value"])->get()->first();
                                if (!$attribute_terms_result){
                                    $attribute_terms_result = AttributeTerm::create(['attribute_id' => $attribute_result->id, 'terms_name' => $attribute["Value"]]);
                                }

                                $attribute_array [$attribute_result->id] =[
                                    $attribute["Name"] => $attribute["Value"]
                                ];
                            }


                        }
//                                    echo "<pre>";
//                                    print_r($attribute_array);
//                                    exit();
                    }else{
                        $attribute_result = Attribute::where('attribute_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"])->get()->first();
                        if (!$attribute_result){
                            $attribute_result = Attribute::create(['attribute_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"]]);
                        }
                        $all_terms = array();
                        if(is_array($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])){

                            foreach ($item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"] as $terms){

                                $attribute_terms_result = AttributeTerm::where('terms_name',$terms)->get()->first();
                                if (!$attribute_terms_result){
                                    $attribute_terms_result = AttributeTerm::create(['attribute_id' => $attribute_result->id, 'terms_name' => $terms]);
                                }
//                                                echo "<pre>";
//                                                print_r($attribute_terms_result);
//                                                exit();
                                $all_terms[] =[
                                    'attribute_term_name' => $terms,
                                    'attribute_term_id' => $attribute_terms_result->id
                                ] ;
//                                                $temp[] = $attribute_array;

                            }

                            $attribute_array [$attribute_result->id] =[
                                $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => $all_terms
                            ];
                        }else{
                            $attribute_terms_result = AttributeTerm::where('terms_name',$item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"])->get()->first();
                            if (!isset($attribute_terms_result->id)){
                                $attribute_terms_result = AttributeTerm::create(['attribute_id' => $attribute_result->id, 'terms_name' => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]]);
                            }

                            $attribute_array [$attribute_result->id] =[
                                $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Name"] => $item_details["Item"]["Variations"]["VariationSpecificsSet"]["NameValueList"]["Value"]
                            ];
                        }
                    }

//                                    echo "<pre>";
//                                    print_r($attribute_array);
//                                    exit();
                    $product_draft_result = ProductDraft::create(['user_id' => 1,'woowms_category' => $woowms_category_result->id , 'condition' => $woowms_condition_result->id,
                        'name' => $item_details["Item"]["Title"],'description' => $item_details["Item"]["Description"],'type' =>isset($item_details["Item"]["Variations"]) ? 'variable' : 'simple','sale_price' => $item_details["Item"]["StartPrice"],
                        'attribute' => \Opis\Closure\serialize($attribute_array),'status' => 'publish']);
                    $ebay_migration = EbayMigration::find($product->id);
                    $ebay_migration->status = 1;
                    $ebay_migration->save();

                    if ($product_draft_result){

                        if (isset($item_details["Item"]["PictureDetails"])){

                            if (is_array($item_details["Item"]["PictureDetails"]["PictureURL"])){

                                foreach ($item_details["Item"]["PictureDetails"]["PictureURL"] as $image_url){

                                    $url = $image_url;
                                    $contents = $this->curl_get_file_contents($url);
                                    $name = random_int(1,1000000).'.webp';

                                    Storage::disk('product_image_custom')->put($name, $contents);
                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                    $master_image[] = asset('/uploads/product-images/'.$name);
                                }
                            }else{
                                if (isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                    $url = $item_details["Item"]["PictureDetails"]["PictureURL"];
                                }
                                $contents = $this->curl_get_file_contents($url);
                                $name = random_int(1,1000000).'.webp';

                                Storage::disk('product_image_custom')->put($name, $contents);
                                Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                $master_image[] = asset('/uploads/product-images/'.$name);
                            }
                        }


                    }


                    // }
                    //}
                    //}


                }else{
                    $woowms_category_result = WooWmsCategory::where([ 'category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"]])->get()->first();
                    if (!isset($woowms_category_result->id)){
                        $woowms_category_result = WooWmsCategory::create(['category_name' => $item_details["Item"]["PrimaryCategory"]["CategoryName"],'user_id' => 1]);
                    }
                    if (isset($item_details["Item"]["ConditionID"])){
                        $woowms_condition_result = Condition::where(['condition_name' => $item_details["Item"]["ConditionDisplayName"]])->get()->first();
                        if(!isset($woowms_condition_result->id)){
                            $woowms_condition_result = Condition::create(['condition_name' => $item_details["Item"]["ConditionDisplayName"], 'user_id' => 1]);
                        }
                    }

                    $product_draft_result = ProductDraft::create(['user_id' => 1,'woowms_category' => $woowms_category_result->id, 'condition' => $woowms_condition_result->id,
                        'name' => $item_details["Item"]["Title"],'description' => $item_details["Item"]["Description"],'type' => 'simple','sale_price' => $item_details["Item"]["StartPrice"],
                        'status' => 'publish']);
                    $ebay_migration = EbayMigration::where('item_id',$item_details["Item"]["ItemID"])->update(['status' => 1]);

                    if ($product_draft_result){

                        if (isset($item_details["Item"]["PictureDetails"])){

                            if (is_array($item_details["Item"]["PictureDetails"]["PictureURL"])){

                                foreach ($item_details["Item"]["PictureDetails"]["PictureURL"] as $image_url){

                                    $url = $image_url;
                                    try{
                                        $contents = $this->curl_get_file_contents($url);
                                        $name = random_int(1,1000000).'.webp';
                                    }catch(Exception $ex){
                                        $name = '';
                                    }

                                    Storage::disk('product_image_custom')->put($name, $contents);
                                    Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                    $master_image[] = asset('/uploads/product-images/'.$name);
                                }
                            }else{
                                if (isset($item_details["Item"]["PictureDetails"]["PictureURL"])){
                                    $url = $item_details["Item"]["PictureDetails"]["PictureURL"];
                                }
                                $contents = $this->curl_get_file_contents($url);
                                $name = random_int(1,1000000).'.webp';

                                Storage::disk('product_image_custom')->put($name, $contents);
                                Image::create(['draft_product_id' => $product_draft_result->id, 'image_url' => asset('/uploads/product-images/'.$name)]);
                                $master_image[] = asset('/uploads/product-images/'.$name);
                            }
                        }


                    }
                }
//                if ($item_details["Item"]["PrimaryCategory"]["CategoryID"] == '11483'){
//                    ProductDraft::create(['user_id' => 1,'woowms_category' => 14,'condition' => 1,'name' => $item_details["Item"]["Title"],'type' => 'variable']);
//                }
//                echo "<pre>";
//                print_r($item_details["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               foreach ($item_details as $item_detail){
//                                   echo "<pre>";
//                print_r($item_detail["Item"]["PrimaryCategory"]["CategoryID"]);
//                exit();
//               }
//                            echo "<pre>";
//                            print_r($item_category_details);
//                            exit();
//               EbayMigration::create(['site_id' => $site->id,'account_id' => $this->account_result->id,'item_id' => $item["ItemID"],
//                   'imgae' => $item["PictureDetails"]["GalleryURL"],'title' => $item["Title"],'category_id'=>$item_category_details["Item"]["PrimaryCategory"]["CategoryID"],
//                   'category_name' => $item_category_details["Item"]["PrimaryCategory"]["CategoryName"],
//                   'status' => 0, 'url' =>  $item["ListingDetails"]["ViewItemURL"],'page_number' => $counter,'item_number' => $index]);
            }catch (Exception $ex){
            }
        }
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


    public function migrationCategoryPage(Request $request){
        //dd($request->all());
        $category_count_id = $this->creatableProfile();
        if(isset($request->migration_category)){
            $accountArr = [];
            $categoryArr = [];
            $searchIds = [];
            //dd($request->migration_category);
            foreach(explode(',',$request->migration_category) as $arr){
                $explodeData = explode('/',$arr);
                if(!in_array($explodeData[0],$accountArr)){
                    $accountArr[] = $explodeData[0];
                }
                if(!in_array($explodeData[1],$categoryArr)){
                    $categoryArr[] = $explodeData[1];
                }
                if(!in_array($explodeData[2],$categoryArr)){
                    $conditionArr[] = $explodeData[2];
                }
                $migrationInfo = EbayMigration::select('id')->where('account_id',$explodeData[0])
                ->where('category_id',$explodeData[1])
                ->where('condition_id',$explodeData[2])->first();
                $searchIds[] = $migrationInfo->id;
            }
            $category_sorting = EbayMigration::with(['accountInfo:id,account_name,logo'])
            ->whereNotIn('id',$category_count_id)
            ->whereIn('id',$searchIds)
            ->whereIn('account_id',$accountArr)
            ->whereIn('category_id',$categoryArr)
            ->whereIn('condition_id',$conditionArr)
            ->groupBy('category_id')
            ->groupBy('account_id')
            ->groupBy('condition_id')
            ->get();
        }elseif(isset($request->account_id)){
            $category_sorting = EbayMigration::with(['accountInfo:id,account_name,logo'])
            ->whereNotIn('id',$category_count_id)
            ->where('account_id', $request->account_id)
            ->groupBy('category_id')
            ->groupBy('account_id')
            ->groupBy('condition_id')
            ->get();
        }else{
            $category_sorting = EbayMigration::with(['accountInfo:id,account_name,logo'])
            ->whereNotIn('id',$category_count_id)
            ->groupBy('category_id')
            ->groupBy('account_id')
            ->groupBy('condition_id')
            ->get();
        }
        // echo '<pre>';
        // print_r(json_decode($category_sorting));
        // exit();

        return view('migration.ebay_migration_category_list', compact('category_sorting'));
    }

    public function autoCreateProfile($id){

            $uniqProfiles = EbayMigration::where('account_id',$id)->GroupBy(['category_id','condition_id'])->get();

            $ebay_account = EbayAccount::find($id);
            $policy = \Opis\Closure\unserialize($ebay_account->default_policy);

            foreach ($uniqProfiles as $uniqProfile){
                $ebay_site = DB::table('ebay_currency')->where('site_id',$uniqProfile['site_id'])->get()->first();
//                return $uniqProfile['account_id'];
                $profile = EbayProfile::where('account_id',$uniqProfile['account_id'])->where('site_id',$uniqProfile['site_id'])->where('condition_id',$uniqProfile['condition_id'])->where('category_id',$uniqProfile['category_id'])->get()->first();

                if (!isset($profile)){

                    $profile_name = $uniqProfile['category_name'].' ('.$ebay_account->account_name.')';
                    EbayProfile::updateOrCreate(['account_id' => $uniqProfile['account_id'],'site_id' => $uniqProfile['site_id'],'condition_id' => $uniqProfile['condition_id'],'category_id' => $uniqProfile['category_id']],['account_id' => $uniqProfile['account_id'],'site_id' => $uniqProfile['site_id'],'profile_name' => $uniqProfile['category_name'] .' ('.$ebay_account->account_name.')','condition_id' => $uniqProfile['condition_id'],'condition_name' => $uniqProfile['condition_name'],'category_id' => $uniqProfile['category_id'],'category_name' => $uniqProfile['category_name'],
                        'location' => $ebay_account->location,'country' => $ebay_account->country,
                        'shipping_id' => $policy['shipment_policy'],'return_id' => $policy['return_policy'],'payment_id' => $policy['payment_policy'],'currency' => $ebay_site->currency,'template_id' => 1,'eps' => 'EPS']);
                }

            }
            return 1;
    }

    public function creatableProfileBySearch(){
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
