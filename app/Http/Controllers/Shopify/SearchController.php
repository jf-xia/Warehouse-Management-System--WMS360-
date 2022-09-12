<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\ProductVariation;
use App\shopify\ShopifyMasterProduct;
use App\shopify\ShopifyVariation;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //

    // public function searchCatalogueList(Request $request){
    //     $search_keyword =  $request->name;
    //     $search_woocom_result = null;
    //     $date = '12345';
    //     $status = $request->status;
    //     $search_priority = $request->search_priority;
    //     $take = $request->take;
    //     $skip = $request->skip;
    //     $ids = $request->ids;
    //     $matched_product_array = array();

    //     if (is_numeric($search_keyword)) {
    //         if (strlen($search_keyword) == 13) {
    //             $find_variation = ProductVariation::where('ean_no', '=', $search_keyword)->get()->first();
    //             if ($find_variation != null) {
    //                 array_push($matched_product_array, $find_variation->product_draft_id);
    //                 $search_woocom_result = $this->getWoocomMasterProduct('id', $matched_product_array, $status, $take, $skip, $ids);
    //                 $search_result = $search_woocom_result['search'];
    //                 $ids = $search_woocom_result['ids'];
    //                 return response()->json(['html' => view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
    //             }else{
    //                 $search_woocom_result = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
    //                 $search_result = $search_woocom_result['search'];
    //                 $ids = $search_woocom_result['ids'];

    //                 if ($search_result->isEmpty()){
    //                     $skip = 0;
    //                     $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
    //                     $search_result = $search_woocom_result['search'];
    //                     $ids = $search_woocom_result['ids'];
    //                 }
    //                 return response()->json(['html' => view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
    //             }
    //         }else{
    //             $search_woocom_result = $this->searchAsId($search_keyword,$status,$take,$skip,$ids);
    //             $search_result = $search_woocom_result['search'];
    //             $ids = $search_woocom_result['ids'];
    //             if($search_result->isEmpty()){
    //                 $skip = 0;
    //                 $search_woocom_result = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
    //                 $search_result = $search_woocom_result['search'];
    //                 $ids = $search_woocom_result['ids'];
    //                 $search_priority = $search_woocom_result["search_priority"];
    //                 if ($search_result->isEmpty()){
    //                     $skip = 0;
    //                     $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
    //                     $search_result = $search_woocom_result['search'];
    //                     $ids = $search_woocom_result['ids'];
    //                 }
    //             }
    //             return response()->json(['html' => view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
    //         }
    //     }else {
    //         if (strpos($search_keyword, " ") != null) {

    //             $search_woocom_result = $this->searchByWord($search_keyword, $status, $search_priority, $take, $skip,$ids);
    //             $search_result = $search_woocom_result['search'];
    //             $search_priority = $search_woocom_result["search_priority"];
    //             $ids = $search_woocom_result["ids"];
    //             return response()->json(['html' => view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);

    //         }
    //         else{
    //             $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
    //             $search_result = $search_woocom_result['search'];
    //             $ids = $search_woocom_result['ids'];
    //             if ($search_result == null){
    //                 $skip = 0;
    //                 $search_woocom_result = $this->searchByWord($search_keyword, $status, $search_priority, $take, $skip,$ids);
    //                 $search_result = $search_woocom_result['search'];
    //                 $search_priority = $search_woocom_result["search_priority"];
    //                 $ids = $search_woocom_result["ids"];
    //             }

    //             return response()->json(['html' => view('shopify.search_product_list', compact('search_result', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
    //         }
    //     }

    //     echo '<pre>';
    //     print_r($request->all());
    //     exit();
    // }

    // public function getWoocomMasterProduct($column_name,$word,$status,$take,$skip,$ids){
    //     $search_result = ShopifyMasterProduct::whereIn($column_name,$word)->whereNotIn('id', $ids)->with(['variations' => function ($query) {
    //         $query->select('shopify_master_product_id', DB::raw('sum(shopify_variations.quantity) stock'))
    //             ->groupBy('shopify_master_product_id');
    //     },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
    //         $query->select(['id','shopify_master_product_id'])->with(['order_products' => function($query){
    //             $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
    //         }]);
    //     }])
    //         ->withCount('variations')
    //         ->where('status',$status)
    //         ->orderBy('id','DESC')
    //         ->skip($skip)->take(10)->get();

    //     $ids = $search_result->pluck('id');

    //     return ['search' => $search_result,'ids' => $ids];
    // }


    // public function searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids){

    //     $search_result = null;

    //     if ($search_priority == 0){

    //         $search_result_by_word = $this->firstPSearch($search_keyword,$status,$take,$skip,$ids);

    //         $search_result = $search_result_by_word["search"];
    //         if ($search_result->isEmpty()){

    //             $skip = 0;
    //             $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
    //             $search_result = $search_result_by_word["search"];
    //             if ($search_result->isEmpty()){
    //                 $skip = 0;
    //                 $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
    //                 $search_result = $search_result_by_word["search"];
    //                 if($search_result->isEmpty()){
    //                     return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 3];
    //                 }else{
    //                     return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
    //                 }

    //             }else{
    //                 ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
    //             }
    //             return ["search" => $search_result,"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
    //         }else{
    //             return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 0];
    //         }

    //     }
    //     if ($search_priority == 1){

    //         $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
    //         $search_result = $search_result_by_word["search"];
    //         if ($search_result->isEmpty()){
    //             $skip = 0;
    //             $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
    //             $search_result = $search_result_by_word["search"];
    //             if ($search_result->isEmpty()){
    //                 return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
    //             }else{
    //                 return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
    //             }

    //         }else{
    //             return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 1];
    //         }

    //     }if ($search_priority == 2){
    //         $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
    //         $search_result = $search_result_by_word["search"];
    //         if ($search_result->isEmpty()){
    //             return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
    //         }else{
    //             return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
    //         }

    //     }

    // }

    // public function searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids){
    //     $matched_product_array = array();
    //     $search_result = null;
    //     $find_sku  =  ShopifyVariation::where('sku','=',$search_keyword)->get()->first();
    //     if ($find_sku != null){
    //         array_push($matched_product_array,$find_sku->woocom_master_product_id);
    //         $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
    //         $search_result = $search_draft_result['search'];
    //         $ids = $search_draft_result['ids'];
    //     }

    //     return ['search'=>$search_result,'ids' => $ids];
    // }


    // public function searchAsId($search_keyword,$status,$take,$skip,$ids){
    //     $search_result = null;
    //     $find_variation = ShopifyVariation::where('id','=',$search_keyword)->get()->first();
    //     $find_draft = ShopifyMasterProduct::where('master_catalogue_id','=',$search_keyword)->get()->first();
    //     $search_draft_result = null;
    //     $matched_product_array = array();
    //     if ($find_variation != null && $find_draft !=null){
    //         array_push($matched_product_array,$find_variation->product_draft_id);
    //         array_push($matched_product_array,$find_draft->id);
    //         //return $matched_product_array;
    //         $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
    //         $search_result = $search_draft_result['search'];
    //         $ids = $search_draft_result['ids'];

    //     }
    //     if ($find_variation != null){
    //         array_push($matched_product_array,$find_variation->product_draft_id);
    //         $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
    //         $search_result = $search_draft_result['search'];
    //         $ids = $search_draft_result['ids'];
    //     }if ($find_draft != null){
    //         array_push($matched_product_array,$find_draft->id);
    //         $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
    //         $search_result = $search_draft_result['search'];
    //         $ids = $search_draft_result['ids'];
    //     }

    //     return ['search'=>$search_result,'ids' => $search_draft_result['ids']];
    // }


    // public function firstPSearch($search_keyword,$status,$take,$skip,$ids){
    //     $search_result = null;
    //     $search_result = ShopifyMasterProduct::where('name','REGEXP',"[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->with(['variations' => function ($query) {
    //         $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
    //             ->groupBy('woocom_master_product_id');
    //     },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
    //         $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
    //             $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
    //         }]);
    //     }])
    //         ->withCount('variations')
    //         ->where('status',$status)
    //         ->orderBy('id','DESC')
    //         ->skip($skip)->take(10)->get();

    //     $ids = $search_result->pluck('id');

    //     return ['search' => $search_result,'ids' => $ids];
    // }

    // public function secondPSearch($search_keyword,$status,$take,$skip,$ids){
    //     $search_result = null;
    //     $findstring = explode(' ', $search_keyword);
    //     $search_result = ShopifyMasterProduct::where(function ($q) use ($findstring) {
    //         foreach ($findstring as $value) {
    //             $q->where('name','REGEXP',"[[:<:]]{$value}[[:>:]]");
    //         }
    //     })->whereNotIn('id', $ids)->with(['variations' => function ($query) {
    //         $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
    //             ->groupBy('woocom_master_product_id');
    //     },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
    //         $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
    //             $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
    //         }]);
    //     }])
    //         ->withCount('variations')
    //         ->where('status',$status)
    //         ->orderBy('id','DESC')
    //         ->skip($skip)->take(10)->get();

    //     $ids = $search_result->pluck('id');

    //     return ['search' => $search_result,'ids' => $ids];
    // }

    // public function thirdPSearch($search_keyword,$status,$take,$skip,$ids){
    //     $search_result = null;
    //     $findstring = explode(' ', $search_keyword);
    //     $search_result = ShopifyMasterProduct::where(function ($q) use ($findstring) {
    //         foreach ($findstring as $value) {
    //             $q->orWhere('name','REGEXP',"[[:<:]]{$value}[[:>:]]");
    //         }
    //     })->whereNotIn('id', $ids)->with(['variations' => function ($query) {
    //         $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
    //             ->groupBy('woocom_master_product_id');
    //     },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
    //         $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
    //             $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
    //         }]);
    //     }])
    //         ->withCount('variations')
    //         ->where('status',$status)
    //         ->orderBy('id','DESC')
    //         ->skip($skip)->take(10)->get();

    //     $ids = $search_result->pluck('id');

    //     return ['search' => $search_result,'ids' => $ids];
    // }

}
