<?php
namespace App\Traits;

use App\woocommerce\WoocommerceCatalogue;
use App\OnbuyMasterProduct;
use App\EbayAccount;
use App\EbayMasterProduct;
use App\WooWmsCategory;
use App\ProductDraft;
use App\OnbuyCategory;
use App\ProductVariation;
use App\Category;
use App\ProductDraftCategory;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\ActivityLog;
use App\WoocommerceAccount;
use App\OnbuyAccount;
use App\amazon\AmazonMasterCatalogue;
use App\amazon\AmazonMarketPlace;
use App\amazon\AmazonAccountApplication;
use App\amazon\AmazonAccount;

trait SearchCatalogue {
    public function optOutOperator($optVal){
        if($optVal == '>'){
            return '<';
        }
        elseif($optVal == '<'){
            return '>';
        }
        elseif($optVal == '='){
            return '!=';
        }
        elseif($optVal == '>='){
            return '<=';
        }
        elseif($optVal == '<='){
            return '>=';
        }
    }
    public function masterCatalogueSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            $allConditions = [];
            if($request->get('catalogue_id')){
                $catalogueId = $request->get('catalogue_id');
                if($request->get('catalogue_opt_out') == 1){
                    $query->where('id', '!=' ,$catalogueId);
                    $allConditions['catalogue'] = $catalogueId;
                }else{
                    $query->where('id', $catalogueId);
                    $allConditions['catalogue'] = $catalogueId;
                }
            }
            if($request->get('channel')){
                //dd(explode(' ~',$request->get('channel')));
                $channelArr = explode(' ~',$request->get('channel'));
                $ids = array();
                foreach ($channelArr as $channel){
                    if ($channel == "woocommerce"){
                        $ids =  WoocommerceCatalogue::select('master_catalogue_id as id' )->get()->pluck('id')->toArray();
                    }
                    elseif ($channel == "onbuy"){
                        $temp = OnbuyMasterProduct::select('woo_catalogue_id as id')->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    elseif ($channel == "Topbrandoutlet-ltd"){
                        $ebay_account_id = EbayAccount::where('account_name', $channel)->first();
                        $temp = EbayMasterProduct::select('master_product_id as id')->where('account_id', $ebay_account_id->id)->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    elseif ($channel == "Topbrandclearence"){
                        $ebay_account_id = EbayAccount::where('account_name', $channel)->first();
                        $temp = EbayMasterProduct::select('master_product_id as id')->where('account_id', $ebay_account_id->id)->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    elseif ($channel == "Fashion Aid"){
                        $ebay_account_id = EbayAccount::where('account_name', $channel)->first();
                        $temp = EbayMasterProduct::select('master_product_id as id')->where('account_id', $ebay_account_id->id)->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                }
                if($request->get('channel_opt_out') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->get('type')){
                $type = $request->get('type');
                if($request->get('type_opt_out') == 1){
                    $query->where('type','!=',$type);
                }else{
                    $query->where('type',$type);
                }
            }
            if($request->get('title')){
                $title = $request->get('title');
                if($request->get('title_opt_out') == 1){
                    $query->where('name','NOT LIKE', "%{$title}%");
                }else{
                    $query->where('name','LIKE', "%{$title}%");
                }
            }
            if($request->get('category')){
                $catIds = explode(' ~', $request->get('category'));
                $category_info = WooWmsCategory::whereIn('id',$catIds)->pluck('id')->toArray();
                //$value = $category_info->id;
                if($request->get('category_opt_out') == 1){
                    $query->whereNotIn('woowms_category',$category_info);
                }else{
                    $query->whereIn('woowms_category',$category_info);
                }
            }
            if($request->get('rrp')){
                $rrp = $request->get('rrp');
                $rrpOpt = $request->get('rrp_opt') ? $request->get('rrp_opt') : null;
                if($request->get('rrp_opt_out') == 1){
                    $rrpOpt = $request->get('rrp_opt') ? $this->optOutOperator($request->get('rrp_opt')) : null;
                    if($rrpOpt){
                        $query->where('rrp',$rrpOpt, $rrp);
                    }else{
                        $query->where('rrp','!=', $rrp);
                    }
                }else{
                    if($rrpOpt){
                        $query->where('rrp',$rrpOpt,$rrp);
                    }else{
                        $query->where('rrp',$rrp);
                    }
                }
            }
            if($request->has('base_price')){
                $basePrice = $request->get('base_price');
                $basePriceOpt = $request->get('base_price_opt') ? $request->get('base_price_opt') : null;
                if($request->get('base_price_opt_out') == 1){
                    $basePriceOpt = $request->get('base_price_opt') ? $this->optOutOperator($request->get('base_price_opt')) : null;
                    if($basePriceOpt){
                        $query->where('base_price',$basePriceOpt, $basePrice);
                    }else{
                        $query->where('base_price','!=', $basePrice);
                    }
                }else{
                    if($basePriceOpt){
                        $query->where('base_price',$basePriceOpt,$basePrice);
                    }else{
                        $query->where('base_price',$basePrice);
                    }
                }
            }
            if($request->has('sold')){
                $soldQty = $request->get('sold');
                $soldOpt = $request->get('sold_opt') ? $request->get('sold_opt') : null;
                $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_orders.quantity) sold'))
                    ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                    ->join('product_orders','product_variation.id','=','product_orders.variation_id')
                    ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null],['product_orders.deleted_at',null]]);
                    if($soldOpt){
                        $query_info = $query_info->havingRaw('sum(product_orders.quantity)'.$soldOpt.$soldQty);
                    }else{
                        $query_info = $query_info->havingRaw('sum(product_orders.quantity) = '.$soldQty);
                    }
                    $query_info = $query_info->groupBy('product_drafts.id')
                    ->get();
                $ids = [];
                foreach ($query_info as $info){
                    $ids[] = $info->id;
                }
                //dd($ids);
                if($request->get('sold_opt_out') == 1){
                    $query->whereNotIn('id',$ids);
                }else{
                    $query->whereIn('id',$ids);
                }
            }
            if($request->has('stock')){
                $stock = $request->get('stock');
                $stockOpt = $request->get('stock_opt') ? $request->get('stock_opt') : null;
                $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                    ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]]);
                    if($stockOpt){
                        $query_info = $query_info->havingRaw('sum(product_variation.actual_quantity)'.$stockOpt.$stock);
                    }else{
                        $query_info = $query_info->havingRaw('sum(product_variation.actual_quantity) = '.$stock);
                    }
                    $query_info = $query_info->groupBy('product_drafts.id')
                    ->get();

                // $query_info = ProductDraft::select('product_drafts.id')->whereHas('ProductVariations', function($query) use($stock, $stockOpt){
                //     if($stockOpt){
                //         $query->havingRaw('sum(product_variation.actual_quantity)'.$stockOpt.$stock);
                //     }
                //     else{
                //         $query->havingRaw('sum(product_variation.actual_quantity) = '.$stock);
                //     }
                // })->get();

                $ids = [];
                foreach ($query_info as $info){
                    $ids[] = $info->id;
                }
                if($request->get('stock_opt_out') == 1){
                    $query->whereNotIn('id',$ids);
                }else{
                    $query->whereIn('id',$ids);
                }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                $query_info = ProductDraft::select('product_drafts.id',DB::raw('count(product_variation.id) product'))
                    ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                    ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]]);
                    if($productOpt){
                        $query_info = $query_info->havingRaw('count(product_variation.id)'.$productOpt.$product);
                    }else{
                        $query_info = $query_info->havingRaw('count(product_variation.id) = '.$product);
                    }
                    $query_info = $query_info->groupBy('product_drafts.id')
                    ->get();
                $ids = [];
                foreach ($query_info as $info){
                    $ids[] = $info->id;
                }
                if($request->get('product_opt_out') == 1){
                    $query->whereNotIn('id',$ids);
                }else{
                    $query->whereIn('id',$ids);
                }
            }
            if($request->get('creator')){
                $creator = $request->get('creator');
                if($request->get('creator_opt_out') == 1){
                    $query->where('user_id','!=',$creator);
                }else{
                    $query->where('user_id',$creator);
                }
            }
            if($request->get('modifier')){
                $modifier = $request->get('modifier');
                if($request->get('modifier_opt_out') == 1){
                    $query->where('modifier_id','!=',$modifier);
                }else{
                    $query->where('modifier_id',$modifier);
                }
            }
            //$this->allSearchConditionArr('condition',$allConditions);
        });
        //dd($this->allSearchConditionArr('result'));
    }

    public function masterCatalogueSearchParams($request, $allCondition){
        //dd($request);
        if($request->get('catalogue_id')){
            $allCondition['catalogue_id'] = $request->get('catalogue_id');
        }
        if($request->get('catalogue_opt_out')){
            $allCondition['catalogue_opt_out'] = $request->get('catalogue_opt_out');
        }
        if($request->get('channel')){
            $allCondition['channel'] = explode(' ~',$request->get('channel'));
        }
        if($request->get('channel_opt_out')){
            $allCondition['channel_opt_out'] = $request->get('channel_opt_out');
        }
        if($request->get('type')){
            $allCondition['type'] = $request->get('type');
        }
        if($request->get('type_opt_out')){
            $allCondition['type_opt_out'] = $request->get('type_opt_out');
        }
        if($request->get('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->get('title_opt_out')){
            $allCondition['title_opt_out'] = $request->get('title_opt_out');
        }
        if($request->get('category')){
            $allCondition['category'] = explode(' ~', $request->get('category'));
        }
        if($request->get('category_opt_out')){
            $allCondition['category_opt_out'] = $request->get('category_opt_out');
        }
        if($request->get('rrp_opt')){
            $allCondition['rrp_opt'] = $request->get('rrp_opt');
        }
        if($request->get('rrp')){
            $allCondition['rrp'] = $request->get('rrp');
        }
        if($request->get('rrp_opt_out')){
            $allCondition['rrp_opt_out'] = $request->get('rrp_opt_out');
        }
        if($request->get('base_price_opt')){
            $allCondition['base_price_opt'] = $request->get('base_price_opt');
        }
        if($request->has('base_price')){
            $allCondition['base_price'] = $request->get('base_price');
        }
        if($request->get('base_price_opt_out')){
            $allCondition['base_price_opt_out'] = $request->get('base_price_opt_out');
        }
        if($request->get('sold_opt')){
            $allCondition['sold_opt'] = $request->get('sold_opt');
        }
        if($request->has('sold')){
            $allCondition['sold'] = $request->get('sold');
        }
        if($request->get('sold_opt_out')){
            $allCondition['sold_opt_out'] = $request->get('sold_opt_out');
        }
        if($request->get('stock_opt')){
            $allCondition['stock_opt'] = $request->get('stock_opt');
        }
        if($request->has('stock')){
            $allCondition['stock'] = $request->get('stock');
        }
        if($request->get('stock_opt_out')){
            $allCondition['stock_opt_out'] = $request->get('stock_opt_out');
        }
        if($request->get('product_opt')){
            $allCondition['product_opt'] = $request->get('product_opt');
        }
        if($request->has('product')){
            $allCondition['product'] = $request->get('product');
        }
        if($request->get('product_opt_out')){
            $allCondition['product_opt_out'] = $request->get('product_opt_out');
        }
        if($request->get('creator')){
            $allCondition['creator'] = $request->get('creator');
        }
        if($request->get('creator_opt_out')){
            $allCondition['creator_opt_out'] = $request->get('creator_opt_out');
        }
        if($request->get('modifier')){
            $allCondition['modifier'] = $request->get('modifier');
        }
        if($request->get('modifier_opt_out')){
            $allCondition['modifier_opt_out'] = $request->get('modifier_opt_out');
        }
        return $allCondition;
    }

    public function onbuyMasterCatalogueSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            if($request->get('opc')){
                $opc = $request->get('opc');
                if($request->get('opc_opt_out') == 1){
                    $query->where('opc','!=',$opc);
                }else{
                    $query->where('opc',$opc);
                }
            }
            if($request->get('woo_catalogue_id')){
                $wooCatalogueId = $request->get('woo_catalogue_id');
                if($request->get('woo_catalogue_id_opt_out') == 1){
                    $query->where('woo_catalogue_id','!=',$wooCatalogueId);
                }else{
                    $query->where('woo_catalogue_id',$wooCatalogueId);
                }
            }
            if($request->get('title')){
                $title = $request->get('title');
                if($request->get('title_opt_out') == 1){
                    $query->where('product_name','NOT LIKE', "%{$title}%");
                }else{
                    $query->where('product_name','LIKE', "%{$title}%");
                }
            }
            if($request->get('category')){
                $catName = explode(' ~', $request->get('category'));
                $catIds = OnbuyCategory::whereIn('category_id',$catName)->pluck('category_id')->toArray();
                if($request->get('category_opt_out') == 1){
                    $query->whereNotIn('master_category_id',$catIds);
                }else{
                    $query->whereIn('master_category_id',$catIds);
                }
            }
            if($request->has('product_type')){
                $pType = $request->get('product_type');
                if($request->get('product_type_opt_out') == 1){
                    $query->where('product_type','!=',$pType);
                }else{
                    $query->where('product_type','=',$pType);
                }
            }
            if($request->has('msp')){
                $msp = $request->get('msp');
                $mspOpt = $request->get('msp_opt') ? $request->get('msp_opt') : null;
                if($request->get('msp_opt_out') == 1){
                    $mspOpt = $request->get('msp_opt') ? $this->optOutOperator($request->get('msp_opt')) : null;
                    if($mspOpt){
                        $query->where('base_price',$mspOpt, $msp);
                    }else{
                        $query->where('base_price','!=', $msp);
                    }
                }else{
                    if($mspOpt){
                        $query->where('base_price',$mspOpt,$msp);
                    }else{
                        $query->where('base_price',$msp);
                    }
                }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                $product_query = OnbuyMasterProduct::select('onbuy_master_products.id', DB::raw('count(onbuy_variation_products.id) product'))
                    ->leftJoin('onbuy_variation_products', 'onbuy_master_products.id', '=', 'onbuy_variation_products.master_product_id');
                    if($productOpt){
                        $product_query = $product_query->havingRaw('count(onbuy_variation_products.id)' .$productOpt.$product);
                    }else{
                        $product_query = $product_query->havingRaw('count(onbuy_variation_products.id) =' .$product);
                    }
                    $product_query = $product_query->groupBy('onbuy_master_products.id')->get();
                $ids = [];
                foreach ($product_query as $product){
                    $ids[] = $product->id;
                }

                if($request->get('product_opt_out') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->get('status')){
                $status = $request->get('status');
                if($request->get('status_opt_out') == 1){
                    $query->where('status','!=',$status);
                }else{
                    $query->where('status',$status);
                }
            }
        });
    }

    public function onbuyMasterCatalogueConditionParams($request, $allCondition){
        if($request->get('opc')){
            $allCondition['opc'] = $request->get('opc');
        }
        if($request->get('opc_opt_out')){
            $allCondition['opc_opt_out'] = $request->get('opc_opt_out');
        }
        if($request->get('woo_catalogue_id')){
            $allCondition['woo_catalogue_id'] = $request->get('woo_catalogue_id');
        }
        if($request->get('woo_catalogue_id_opt_out')){
            $allCondition['woo_catalogue_id_opt_out'] = $request->get('woo_catalogue_id_opt_out');
        }
        if($request->get('product_type')){
            $allCondition['product_type'] = $request->get('product_type');
        }
        if($request->get('product_type_opt_out')){
            $allCondition['product_type_opt_out'] = $request->get('product_type_opt_out');
        }
        if($request->get('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->get('title_opt_out')){
            $allCondition['title_opt_out'] = $request->get('title_opt_out');
        }
        if($request->get('category')){
            $allCondition['category'] = explode(' ~', $request->get('category'));
        }
        if($request->get('category_opt_out')){
            $allCondition['category_opt_out'] = $request->get('category_opt_out');
        }
        if($request->has('msp')){
            $allCondition['msp'] = $request->get('msp');
        }
        if($request->has('msp_opt')){
            $allCondition['msp_opt'] = $request->get('msp_opt');
        }
        if($request->get('msp_opt_out')){
            $allCondition['msp_opt_out'] = $request->get('msp_opt_out');
        }
        if($request->has('product')){
            $allCondition['product'] = $request->get('product');
        }
        if($request->has('product_opt')){
            $allCondition['product_opt'] = $request->get('product_opt');
        }
        if($request->get('product_opt_out')){
            $allCondition['product_opt_out'] = $request->get('product_opt_out');
        }
        if($request->get('status')){
            $allCondition['status'] = $request->get('status');
        }
        if($request->get('status_opt_out')){
            $allCondition['status_opt_out'] = $request->get('status_opt_out');
        }
        return $allCondition;
    }

    public function lowQuantitySearchCondition($mainQuery, $request, $visibilityType = null){
        $mainQuery->where(function($query) use ($request, $visibilityType){
            if($request->get('catalogue_id')){
                $query->where('product_draft_id', $request->get('catalogue_id'));
            }
            if($request->get('title')){
                $title = $request->get('title');
                $catalogueId = ProductDraft::where('name','LIKE', '%'.$title.'%')->pluck('id')->toArray();
                $query->whereIn('product_draft_id', $catalogueId);
            }
            if($request->has('sale_price')){
                $query->where('sale_price',$request->get('sale_price'));
            }
            if($request->has('product')){
                $product = $request->get('product');
                $ids = ProductDraft::join('product_variation','product_variation.product_draft_id','=','product_drafts.id')
                ->whereRaw('product_variation.actual_quantity < product_variation.low_quantity');
                if($visibilityType == null){
                    $ids = $ids->whereIn('product_variation.low_quantity_visibility',[0,1])
                    ->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` > 0,`actual_quantity` > -1)');
                }else{
                    $ids = $ids->where('product_variation.low_quantity_visibility', 0)
                    ->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` = 0,`actual_quantity` > 0)');
                }
                $ids = $ids->where('product_drafts.deleted_at',null)
                ->where('product_variation.deleted_at',null)
                ->havingRaw('count(product_drafts.id) = '.$product)
                ->groupBy('product_drafts.id')
                ->pluck('product_drafts.id')->toArray();
                $query->whereIn('product_draft_id', $ids);
            }
        });
    }

    public function lowQuantitySearchParams($request, $allCondition){
        if($request->has('catalogue_id')){
            $allCondition['catalogue_id'] = $request->get('catalogue_id');
        }
        if($request->has('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->has('sale_price')){
            $allCondition['sale_price'] = $request->get('sale_price');
        }
        if($request->has('product')){
            $allCondition['product'] = $request->get('product');
        }
        return $allCondition;
    }

    public function activityLogSearchCondition($mainQuery, $request, $visibilityType = null){
        $mainQuery->where(function($query) use ($request, $visibilityType){
            if($request->get('id')){
                $id = $request->get('id');
                if($request->get('id_opt_out') == 1){
                    $query->where('id', '!=', $id);
                }else{
                    $query->where('id', $id);
                }
            }
            if($request->get('action_name')){
                $action_name = $request->get('action_name');
                if($request->get('action_name_opt_out') == 1){
                    $query->where('action_name','NOT LIKE', "%{$action_name}%");
                }else{
                    $query->where('action_name','LIKE', "%{$action_name}%");
                }
            }
            if($request->get('account_name')){
                $account_name = $request->get('account_name');
                if($request->get('account_name_opt_out') == 1){
                    $query->where('account_name','NOT LIKE', "%{$account_name}%");
                }else{
                    $query->where('account_name','LIKE', "%{$account_name}%");
                }
            }
            if($request->get('channels')){
                $channel_search = explode(' ~',$request->get('channels'));
                $ids = array();
                foreach($channel_search as $channel){
                    $channel_name = explode('/',$channel);
                    // dd($channel_name);
                    if($channel_name[0] == 'ebay'){
                        $ebay_account_id = EbayAccount::where('account_name', $channel_name[1])->first();
                        $temp = ActivityLog::where('account_name', 'Ebay')->where('account_id', $ebay_account_id->id)->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                        //dd($ids);
                    }elseif($channel_name[0] == 'woocommerce'){
                        $woocommerce_account_id = WoocommerceAccount::where('account_name', $channel_name[1])->first();
                        $temp = ActivityLog::where('account_name', 'woocommerce')->where('account_id', $woocommerce_account_id->id)->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                        // dd($ids);
                    }elseif($channel_name[0] == 'onbuy'){
                        $onbuy_account_id = OnbuyAccount::where('account_name', $channel_name[1])->first();
                        $temp = ActivityLog::where('account_name', 'onbuy')->where('account_id', $onbuy_account_id->id)->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                        //  dd($ids);
                    }
                    elseif($channel_name[0] == 'amazon'){
                        $amazon_account_id = AmazonAccountApplication::where('application_name', explode('(',$channel_name[1])[0])->first();
                        $temp = ActivityLog::where('account_name', 'Amazon')->where('account_id', $amazon_account_id->id)->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    //dd($ids);
                    // exit();

                }
                if($request->get('channel_opt_out') == 1){
                            $query->whereNotIn('id',$ids);
                            }else{
                                $query->whereIn('id', $ids);
                                // dd($query);
                            }
                // if($request->get('channels') == 'woocommerce' || $request->get('channels') == 'onbuy'){
                //     if($request->get('channel_opt_out') == 1){
                //         $query->whereNotIn('created_via',$channel_search);
                //         }else{
                //             $query->whereIn('created_via', $channel_search);
                //             // dd($query);
                //         }
                // }
                // else{
                //     if($request->get('channel_opt_out') == 1){
                //         $query->whereNotIn('account_id',$ids);
                //         }else{
                //             $query->whereIn('account_id', $ids);
                //             // dd($query);
                //         }
                // }



                // if($request->get('channel_opt_out') == 1){
                //         $query->whereNotIn('account_id',$ids);
                // }else{
                //     // dd($temp);
                //     $query->whereIn('account_id', $ids);
                // }
            }
            if($request->get('account_id')){
                $account_id = $request->get('account_id');
                if($request->get('account_id_opt_out') == 1){
                    $query->where('account_id', '!=', $account_id);
                }else{
                    $query->where('account_id', $account_id);
                }
            }
            if($request->get('sku')){
                $sku = $request->get('sku');
                if($request->get('sku_opt_out') == 1){
                    $query->where('sku', '!=', $sku);
                }else{
                    $query->where('sku', $sku);
                }
            }
            if($request->get('action_by')){
                $action_by = $request->get('action_by');
                if($request->get('action_by_opt_out') == 1){
                    $query->where('action_by', '!=', $action_by);
                }else{
                    $query->where('action_by', $action_by);
                }
            }
            if($request->get('last_quantity')){
                $last_quantity = $request->get('last_quantity');
                $last_quantityOpt = $request->get('last_quantity_opt') ? $request->get('last_quantity_opt') : null;
                if($request->get('last_quantity_opt_out') == 1){
                    $last_quantityOpt = $request->get('last_quantity_opt') ? $this->optOutOperator($request->get('last_quantity_opt')) : null;
                    if($last_quantityOpt){
                        $query->where('last_quantity',$last_quantityOpt, $last_quantity);
                    }else{
                        $query->where('last_quantity','!=', $last_quantity);
                    }
                }else{
                    if($last_quantityOpt){
                        $query->where('last_quantity',$last_quantityOpt,$last_quantity);
                    }else{
                        $query->where('last_quantity',$last_quantity);
                    }
                }
            }
            if($request->get('updated_quantity')){
                $updated_quantity = $request->get('updated_quantity');
                $updated_quantity_opt = $request->get('updated_quantity_opt') ? $request->get('updated_quantity_opt') : null;
                if($request->get('updated_quantity_opt_out') == 1){
                    $updated_quantity_opt = $request->get('updated_quantity_opt') ? $this->optOutOperator($request->get('updated_quantity_opt')) : null;
                    if($updated_quantity_opt){
                        $query->where('updated_quantity',$updated_quantity_opt, $updated_quantity);
                    }else{
                        $query->where('updated_quantity','!=', $updated_quantity);
                    }
                }else{
                    if($updated_quantity_opt){
                        $query->where('updated_quantity',$updated_quantity_opt,$updated_quantity);
                    }else{
                        $query->where('updated_quantity',$updated_quantity);
                    }
                }
            }
            if($request->get('action_date')){
                $action_date = $request->get('action_date');
                if($request->get('action_date_opt_out') == 1){
                    $query->where('action_date','NOT LIKE', "%{$action_date}%");
                }else{
                    $query->where('action_date','LIKE', "%{$action_date}%");
                }
            }
            if($request->has('solve_status')){
                $solve_status = $request->get('solve_status');
                if($request->get('solve_status_opt_out') == 1){
                    $query->where('solve_status', '!=', $solve_status);
                }else{
                    $query->where('solve_status', $solve_status);
                }
            }
            if($request->has('action_status')){
                $action_status = $request->get('action_status');
                if($request->get('action_status_opt_out') == 1){
                    $query->where('action_status', '!=', $action_status);
                }else{
                    $query->where('action_status', $action_status);
                }
            }
            if($request->get('created_at')){
                $created_at = $request->get('created_at');
                if($request->get('created_at_opt_out') == 1){
                    $query->where('created_at','NOT LIKE', "%{$created_at}%");
                }else{
                    $query->where('created_at','LIKE', "%{$created_at}%");
                }
            }
            if($request->get('updated_at')){
                $updated_at = $request->get('updated_at');
                if($request->get('updated_at_opt_out') == 1){
                    $query->where('updated_at','NOT LIKE', "%{$updated_at}%");
                }else{
                    $query->where('updated_at','LIKE', "%{$updated_at}%");
                }
            }
            if($request->get('deleted_at')){
                $deleted_at = $request->get('deleted_at');
                if($request->get('deleted_at_opt_out') == 1){
                    $query->where('deleted_at','NOT LIKE', "%{$deleted_at}%");
                }else{
                    $query->where('deleted_at','LIKE', "%{$deleted_at}%");
                }
            }
        });
    }

    public function activiyLogSearchParams($request, $allCondition){
        if($request->has('id')){
            $allCondition['id'] = $request->get('id');
        }
        if($request->has('id_opt_out')){
            $allCondition['id_opt_out'] = $request->get('id_opt_out');
        }
        if($request->has('action_name')){
            $allCondition['action_name'] = $request->get('action_name');
        }
        if($request->has('action_name_opt_out')){
            $allCondition['action_name_opt_out'] = $request->get('action_name_opt_out');
        }
        if($request->has('account_name')){
            $allCondition['account_name'] = $request->get('account_name');
        }
        if($request->has('account_name_opt_out')){
            $allCondition['account_name_opt_out'] = $request->get('account_name_opt_out');
        }
        if($request->get('channels')){
            $allCondition['channels'] = explode(' ~',$request->get('channels'));
        }
        if($request->get('channel_opt_out')){
            $allCondition['channel_opt_out'] = $request->get('channel_opt_out');
        }
        if($request->has('account_id')){
            $allCondition['account_id'] = $request->get('account_id');
        }
        if($request->has('sku')){
            $allCondition['sku'] = $request->get('sku');
        }
        if($request->has('sku_opt_out')){
            $allCondition['sku_opt_out'] = $request->get('sku_opt_out');
        }
        if($request->has('account_id_opt_out')){
            $allCondition['account_id_opt_out'] = $request->get('account_id_opt_out');
        }
        if($request->has('action_by')){
            $allCondition['action_by'] = $request->get('action_by');
        }
        if($request->has('action_by_opt_out')){
            $allCondition['action_by_opt_out'] = $request->get('action_by_opt_out');
        }
        if($request->has('last_quantity')){
            $allCondition['last_quantity'] = $request->get('last_quantity');
        }
        if($request->has('last_quantity_opt')){
            $allCondition['last_quantity_opt'] = $request->get('last_quantity_opt');
        }
        if($request->has('last_quantity_opt_out')){
            $allCondition['last_quantity_opt_out'] = $request->get('last_quantity_opt_out');
        }
        if($request->has('updated_quantity')){
            $allCondition['updated_quantity'] = $request->get('updated_quantity');
        }
        if($request->has('updated_quantity_opt')){
            $allCondition['updated_quantity_opt'] = $request->get('updated_quantity_opt');
        }
        if($request->has('updated_quantity_opt_out')){
            $allCondition['updated_quantity_opt_out'] = $request->get('updated_quantity_opt_out');
        }
        if($request->has('action_date')){
            $allCondition['action_date'] = $request->get('action_date');
        }
        if($request->has('action_date_opt_out')){
            $allCondition['action_date_opt_out'] = $request->get('action_date_opt_out');
        }
        if($request->has('solve_status')){
            $allCondition['solve_status'] = $request->get('solve_status');
        }
        if($request->has('solve_status_opt_out')){
            $allCondition['solve_status_opt_out'] = $request->get('solve_status_opt_out');
        }
        if($request->has('action_status')){
            $allCondition['action_status'] = $request->get('action_status');
        }
        if($request->has('action_status_opt_out')){
            $allCondition['action_status_opt_out'] = $request->get('action_status_opt_out');
        }
        if($request->has('created_at')){
            $allCondition['created_at'] = $request->get('created_at');
        }
        if($request->has('created_at_opt_out')){
            $allCondition['created_at_opt_out'] = $request->get('created_at_opt_out');
        }
        if($request->has('updated_at')){
            $allCondition['updated_at'] = $request->get('updated_at');
        }
        if($request->has('updated_at_opt_out')){
            $allCondition['updated_at_opt_out'] = $request->get('updated_at_opt_out');
        }
        if($request->has('deleted_at')){
            $allCondition['deleted_at'] = $request->get('deleted_at');
        }
        if($request->has('deleted_at_opt_out')){
            $allCondition['deleted_at_opt_out'] = $request->get('deleted_at_opt_out');


        }
        return $allCondition;
    }
    public function woocommerceCatalogueSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            $allConditions = [];
            if($request->get('master_catalogue_id')){
                $catalogueId = $request->get('master_catalogue_id');
                if($request->get('catalogue_opt_out') == 1){
                    $query->where('master_catalogue_id', '!=' ,$catalogueId);
                    $allConditions['catalogue'] = $catalogueId;
                }else{
                    $query->where('master_catalogue_id', $catalogueId);
                    $allConditions['catalogue'] = $catalogueId;
                }
            }
            if($request->get('title')){
                $title = $request->get('title');
                if($request->get('title_opt_out') == 1){
                    $query->where('name','NOT LIKE', "%{$title}%");
                }else{
                    $query->where('name','LIKE', "%{$title}%");
                }
            }
            if($request->get('category')){
                $catIds = explode(' ~', $request->get('category'));
                //dd($catIds);
                $category_info = Category::whereIn('id',$catIds)->pluck('id')->toArray();
                //dd($category_info);
                $category_info = ProductDraftCategory::whereIn('category_id',$category_info)->groupBy('product_draft_id')->pluck('product_draft_id')->toArray();
                //dd($category_info);
                //$value = $category_info->id;
                if($request->get('category_opt_out') == 1){
                    $query->whereNotIn('id',$category_info);
                }else{
                    $query->whereIn('id',$category_info);
                }
            }
            if($request->get('rrp')){
                $rrp = $request->get('rrp');
                $rrpOpt = $request->get('rrp_opt') ? $request->get('rrp_opt') : null;
                if($request->get('rrp_opt_out') == 1){
                    $rrpOpt = $request->get('rrp_opt') ? $this->optOutOperator($request->get('rrp_opt')) : null;
                    if($rrpOpt){
                        $query->where('rrp',$rrpOpt, $rrp);
                    }else{
                        $query->where('rrp','!=', $rrp);
                    }
                }else{
                    if($rrpOpt){
                        $query->where('rrp',$rrpOpt,$rrp);
                    }else{
                        $query->where('rrp',$rrp);
                    }
                }
            }
            if($request->get('base_price')){
                $basePrice = $request->get('base_price');
                $basePriceOpt = $request->get('base_price_opt') ? $request->get('base_price_opt') : null;
                if($request->get('base_price_opt_out') == 1){
                    $basePriceOpt = $request->get('base_price_opt') ? $this->optOutOperator($request->get('base_price_opt')) : null;
                    if($basePriceOpt){
                        $query->where('base_price',$basePriceOpt, $basePrice);
                    }else{
                        $query->where('base_price','!=', $basePrice);
                    }
                }else{
                    if($basePriceOpt){
                        $query->where('base_price',$basePriceOpt,$basePrice);
                    }else{
                        $query->where('base_price',$basePrice);
                    }
                }
            }
            if($request->has('sold')){
                $soldQty = $request->get('sold');
                $soldOpt = $request->get('sold_opt') ? $request->get('sold_opt') : null;
                    $sold_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('sum(product_orders.quantity) sold'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id')
                        ->join('product_variation', 'woocom_variation_products.woocom_variation_id', '=', 'product_variation.id')
                        ->join('product_orders', 'product_variation.id', '=', 'product_orders.variation_id')
                        ->where([['woocom_master_products.deleted_at', null], ['woocom_variation_products.deleted_at', null], ['product_variation.deleted_at', null],['product_orders.deleted_at', null]]);
                        if($soldOpt){
                            $sold_query = $sold_query->havingRaw('sum(product_orders.quantity)'.$soldOpt.$soldQty);
                        }else{
                            $sold_query = $sold_query->havingRaw('sum(product_orders.quantity) =' .$soldQty);
                        }
                        $sold_query = $sold_query->groupBy('woocom_master_products.id')->get();

                    $ids = [];
                    foreach ($sold_query as $sold){
                        $ids[] = $sold->id;
                    }

                    if($request->get('sold_opt_out') == 1){
                         $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
            }
            if($request->has('stock')){

                $stock = $request->get('stock');
                $stockOpt = $request->get('stock_opt') ? $request->get('stock_opt') : null;
                    $stock_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id')
                        ->where([['woocom_master_products.deleted_at', null], ['woocom_variation_products.deleted_at', null]]);
                        if($stockOpt){
                                    $stock_query = $stock_query->havingRaw('sum(woocom_variation_products.actual_quantity)'.$stockOpt.$stock);
                                }else{
                                    $stock_query = $stock_query->havingRaw('sum(woocom_variation_products.actual_quantity) = '.$stock);
                                }
                                $stock_query = $stock_query->groupBy('woocom_master_products.id')
                        ->get();

                    $ids = [];
                    foreach ($stock_query as $stock){
                        $ids[] = $stock->id;
                    }

                    if($request->get('stock_opt_out') == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                    $product_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('count(woocom_variation_products.id) product'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id');
                        if($productOpt){
                                $product_query = $product_query->havingRaw('count(woocom_variation_products.id)'.$productOpt.$product);
                            }else{
                                $product_query = $product_query->havingRaw('count(woocom_variation_products.id) = '.$product);
                            }
                            $product_query = $product_query->groupBy('woocom_master_products.id')
                        ->get();

                    $ids = [];
                    foreach ($product_query as $product){
                        $ids[] = $product->id;
                    }
                    if($request->get('product_opt_out') == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
                }

            if($request->get('creator')){
                $creator = $request->get('creator');
                if($request->get('creator_opt_out') == 1){
                    $query->where('user_id','!=',$creator);
                }else{
                    $query->where('user_id',$creator);
                }
            }
            if($request->get('modifier')){
                $modifier = $request->get('modifier');
                if($request->get('modifier_opt_out') == 1){
                    $query->where('modifier_id','!=',$modifier);
                }else{
                    $query->where('modifier_id',$modifier);
                }
            }
            //$this->allSearchConditionArr('condition',$allConditions);
        });
    }

    public function woocommerceCatalogueSearchParams($request, $allCondition){
        if($request->get('master_catalogue_id')){
            $allCondition['master_catalogue_id'] = $request->get('master_catalogue_id');
        }
        if($request->get('catalogue_opt_out')){
            $allCondition['catalogue_opt_out'] = $request->get('catalogue_opt_out');
        }
        if($request->get('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->get('title_opt_out')){
            $allCondition['title_opt_out'] = $request->get('title_opt_out');
        }
        if($request->get('category')){
            $allCondition['category'] = explode(' ~', $request->get('category'));
        }
        if($request->get('category_opt_out')){
            $allCondition['category_opt_out'] = $request->get('category_opt_out');
        }
        if($request->get('rrp_opt')){
            $allCondition['rrp_opt'] = $request->get('rrp_opt');
        }
        if($request->get('rrp')){
            $allCondition['rrp'] = $request->get('rrp');
        }
        if($request->get('rrp_opt_out')){
            $allCondition['rrp_opt_out'] = $request->get('rrp_opt_out');
        }
        if($request->get('base_price_opt')){
            $allCondition['base_price_opt'] = $request->get('base_price_opt');
        }
        if($request->has('base_price')){
            $allCondition['base_price'] = $request->get('base_price');
        }
        if($request->get('base_price_opt_out')){
            $allCondition['base_price_opt_out'] = $request->get('base_price_opt_out');
        }
        if($request->get('sold_opt')){
            $allCondition['sold_opt'] = $request->get('sold_opt');
        }
        if($request->has('sold')){
            $allCondition['sold'] = $request->get('sold');
        }
        if($request->get('sold_opt_out')){
            $allCondition['sold_opt_out'] = $request->get('sold_opt_out');
        }
        if($request->get('stock_opt')){
            $allCondition['stock_opt'] = $request->get('stock_opt');
        }
        if($request->has('stock')){
            $allCondition['stock'] = $request->get('stock');
        }
        if($request->get('stock_opt_out')){
            $allCondition['stock_opt_out'] = $request->get('stock_opt_out');
        }
        if($request->get('product_opt')){
            $allCondition['product_opt'] = $request->get('product_opt');
        }
        if($request->has('product')){
            $allCondition['product'] = $request->get('product');
        }
        if($request->get('product_opt_out')){
            $allCondition['product_opt_out'] = $request->get('product_opt_out');
        }
        if($request->get('creator')){
            $allCondition['creator'] = $request->get('creator');
        }
        if($request->get('creator_opt_out')){
            $allCondition['creator_opt_out'] = $request->get('creator_opt_out');
        }
        if($request->get('modifier')){
            $allCondition['modifier'] = $request->get('modifier');
        }
        if($request->get('modifier_opt_out')){
            $allCondition['modifier_opt_out'] = $request->get('modifier_opt_out');
        }
        return $allCondition;
    }

    public function ebayMigrationSearchCondition($mainQuery, $request, $visibilityType = null){
        $mainQuery->where(function($query) use ($request, $visibilityType){

            if($request->get('account_id')){
                $account_id = $request->get('account_id');
                if($request->get('account_name_opt_out') == 1){
                    $query->where('account_id','!=',$account_id);
                }else{
                    $query->where('account_id',$account_id);
                }
            }
            if($request->get('title')){
                $title = $request->get('title');
                if($request->get('title_optout') == 1){
                    $query->where('title','NOT LIKE', "%{$title}%");
                }else{
                    $query->where('title','LIKE', "%{$title}%");
                }
            }
            if($request->get('condition_name')){
                $condition_name = $request->get('condition_name');
                if($request->get('condition_name_optout') == 1){
                    $query->where('condition_name','NOT LIKE', "%{$condition_name}%");
                }else{
                    $query->where('condition_name','LIKE', "%{$condition_name}%");
                }
            }
            if($request->get('category_id')){
                $category_id = $request->get('category_id');
                if($request->get('category_id_optout') == 1){
                    $query->where('category_id', '!=', $category_id);
                }else{
                    $query->where('category_id', $category_id);
                }
            }
            if($request->get('item_id')){
                $item_id = $request->get('item_id');
                if($request->get('item_id_optout') == 1){
                    $query->where('item_id', '!=', $item_id);
                }else{
                    $query->where('item_id', $item_id);
                }
            }

        });
    }

    public function ebayMigrationSearchParams($request, $allCondition){
        if($request->has('account_id')){
            $allCondition['account_id'] = $request->get('account_id');
        }
        if($request->has('account_name_opt_out')){
            $allCondition['account_name_opt_out'] = $request->get('account_name_opt_out');
        }
        if($request->has('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->has('title_optout')){
            $allCondition['title_optout'] = $request->get('title_optout');
        }
        if($request->has('condition_name')){
            $allCondition['condition_name'] = $request->get('condition_name');
        }
        if($request->has('condition_name_optout')){
            $allCondition['condition_name_optout'] = $request->get('condition_name_optout');
        }
        if($request->has('category_id')){
            $allCondition['category_id'] = $request->get('category_id');
        }
        if($request->has('category_id_optout')){
            $allCondition['category_id_optout'] = $request->get('category_id_optout');
        }
        if($request->has('item_id')){
            $allCondition['item_id'] = $request->get('item_id');
        }
        if($request->has('item_id_optout')){
            $allCondition['item_id_optout'] = $request->get('item_id_optout');
        }
        return $allCondition;
    }

    public function amazonCatalogueSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            $allConditions = [];
            if($request->has('catalogue_id')){
                $catalogueId = $request->get('catalogue_id');
                if($request->get('catalogue_opt_out') == 1){
                    $query->where('master_product_id', '!=' ,$catalogueId);
                }else{
                    $query->where('master_product_id', $catalogueId);
               }
            }
            if($request->has('title')){
                $title = $request->get('title');
                if($request->get('title_opt_out') == 1){
                    $query->where('title', 'NOT LIKE' ,'%'.$title.'%');
                }else{
                    $query->where('title','LIKE' ,'%'.$title.'%');
               }
            }
            if($request->has('application')){
                $applicationId = $request->get('application');
                if($request->get('application_opt_out') == 1){
                    $query->where('application_id','!=',$applicationId);
                }else{
                    $query->where('application_id',$applicationId);
               }
            }
            if($request->has('account')){
                $accountId = $request->get('account');
                $applictionIds = AmazonMarketPlace::select('amazon_account_applications.id')
                ->leftJoin('amazon_account_applications','amazon_market_places.id','=','amazon_account_applications.amazon_marketplace_fk_id')
                ->where('amazon_account_applications.application_status',1)
                ->where('amazon_account_applications.deleted_at',null)
                ->where('amazon_market_places.id',$accountId)
                ->get()->toArray();
                if($request->get('account_opt_out') == 1){
                    $query->whereNotIn('application_id',$applictionIds);
                }else{
                    $query->whereIn('application_id',$applictionIds);
               }
            }
            if($request->has('master_sale_price')){
                $salePrice = $request->get('master_sale_price');
                $salePriceOpt = $request->get('master_sale_price_opt') ? $request->get('master_sale_price_opt') : null;
                if($request->get('master_sale_price_opt_out') == 1){
                    $query->where('sale_price','!=',$salePrice);
                }else{
                    $query->where('sale_price',$salePriceOpt ? $salePriceOpt : '',$salePrice);
                }
                if($request->get('master_sale_price_opt_out') == 1){
                    $salePriceOpt = $request->get('master_sale_price_opt') ? $this->optOutOperator($request->get('master_sale_price_opt')) : null;
                    if($salePriceOpt){
                        $query->where('sale_price',$salePriceOpt, $salePrice);
                    }else{
                        $query->where('sale_price','!=', $salePrice);
                    }
                }else{
                    if($salePriceOpt){
                        $query->where('sale_price',$salePriceOpt,$salePrice);
                    }else{
                        $query->where('sale_price',$salePrice);
                    }
                }
            }
            if($request->has('stock')){
                $stock = $request->get('stock');
                $stockOpt = $request->get('stock_opt') ? $request->get('stock_opt') : null;
                $stock_query = AmazonMasterCatalogue::select('amazon_master_catalogues.id', DB::raw('sum(amazon_variation_products.quantity) stock'))
                    ->leftJoin('amazon_variation_products', 'amazon_master_catalogues.id', '=', 'amazon_variation_products.amazon_master_product')
                    ->where([['amazon_master_catalogues.deleted_at', null], ['amazon_variation_products.deleted_at', null]]);
                    if($stockOpt){
                                $stock_query = $stock_query->havingRaw('sum(amazon_variation_products.quantity)'.$stockOpt.$stock);
                            }else{
                                $stock_query = $stock_query->havingRaw('sum(amazon_variation_products.quantity) = '.$stock);
                            }
                            $stock_query = $stock_query->groupBy('amazon_master_catalogues.id')
                    ->get();
                $ids = [];
                foreach ($stock_query as $stock){
                    $ids[] = $stock->id;
                }
                if($request->get('stock_opt_out') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                $product_query = AmazonMasterCatalogue::select('amazon_master_catalogues.id', DB::raw('count(amazon_variation_products.id) product'))
                    ->leftJoin('amazon_variation_products', 'amazon_master_catalogues.id', '=', 'amazon_variation_products.amazon_master_product');
                    if($productOpt){
                            $product_query = $product_query->havingRaw('count(amazon_variation_products.id)'.$productOpt.$product);
                        }else{
                            $product_query = $product_query->havingRaw('count(amazon_variation_products.id) = '.$product);
                        }
                        $product_query = $product_query->groupBy('amazon_master_catalogues.id')
                    ->get();

                $ids = [];
                foreach ($product_query as $product){
                    $ids[] = $product->id;
                }
                if($request->get('product_opt_out') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->get('creator')){
                $creator = $request->get('creator');
                if($request->get('creator_opt_out') == 1){
                    $query->where('creator_id','!=',$creator);
                }else{
                    $query->where('creator_id',$creator);
                }
            }
            if($request->get('modifier')){
                $modifier = $request->get('modifier');
                if($request->get('modifier_opt_out') == 1){
                    $query->where('modifier_id','!=',$modifier);
                }else{
                    $query->where('modifier_id',$modifier);
                }
            }
        });
    }

    public function amazonCatalogueSearchParams($request, $allCondition){
        if($request->get('catalogue_id')){
            $allCondition['catalogue_id'] = $request->get('catalogue_id');
        }
        if($request->get('catalogue_opt_out')){
            $allCondition['catalogue_opt_out'] = $request->get('catalogue_opt_out');
        }
        if($request->get('title')){
            $allCondition['title'] = $request->get('title');
        }
        if($request->get('title_opt_out')){
            $allCondition['title_opt_out'] = $request->get('title_opt_out');
        }
        if($request->get('application')){
            $allCondition['application'] = $request->get('application');
        }
        if($request->get('application_opt_out')){
            $allCondition['application_opt_out'] = $request->get('application_opt_out');
        }
        if($request->get('account')){
            $allCondition['account'] = $request->get('account');
        }
        if($request->get('account_opt_out')){
            $allCondition['account_opt_out'] = $request->get('account_opt_out');
        }
        if($request->get('stock')){
            $allCondition['stock'] = $request->get('stock');
        }
        if($request->get('stock_opt')){
            $allCondition['stock_opt'] = $request->get('stock_opt');
        }
        if($request->get('master_sale_price')){
            $allCondition['master_sale_price'] = $request->get('master_sale_price');
        }
        if($request->get('master_sale_price_opt')){
            $allCondition['master_sale_price_opt'] = $request->get('master_sale_price_opt');
        }
        if($request->get('master_sale_price_opt_out')){
            $allCondition['master_sale_price_opt_out'] = $request->get('master_sale_price_opt_out');
        }
        if($request->get('stock_opt_out')){
            $allCondition['stock_opt_out'] = $request->get('stock_opt_out');
        }
        if($request->get('product')){
            $allCondition['product'] = $request->get('product');
        }
        if($request->get('product_opt')){
            $allCondition['product_opt'] = $request->get('product_opt');
        }
        if($request->get('product_opt_out')){
            $allCondition['product_opt_out'] = $request->get('product_opt_out');
        }
        if($request->get('creator')){
            $allCondition['creator'] = $request->get('creator');
        }
        if($request->get('creator_opt_out')){
            $allCondition['creator_opt_out'] = $request->get('creator_opt_out');
        }
        if($request->get('modifier')){
            $allCondition['modifier'] = $request->get('modifier');
        }
        if($request->get('modifier_opt_out')){
            $allCondition['modifier_opt_out'] = $request->get('modifier_opt_out');
        }
        return $allCondition;
    }

    public function exportCatalogueCsvQuery($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            if($request->has('status') && ($request->get('status') != null)){
                $query->where('status', $request->get('status'));
            }
            if($request->has('type') && ($request->get('type') != null)){
                $query->where('type', $request->get('type'));
            }
            if($request->has('category')){
                $query->whereIn('woowms_category',$request->get('category'));
            }
            if($request->has('channel')){
                $channelArr = $request->get('channel');
                $ids = array();
                foreach ($channelArr as $channels){
                    $channel = explode('/',$channels)[0];
                    $account_name = explode('/',$channels)[1];
                    if ($channel == "website"){
                        $ids =  WoocommerceCatalogue::select('master_catalogue_id as id' )->get()->pluck('id')->toArray();
                    }
                    elseif ($channel == "onbuy"){
                        $temp = OnbuyMasterProduct::select('woo_catalogue_id as id')->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    elseif ($channel == "ebay"){
                        $ebay_account_id = EbayAccount::where('account_name', $account_name)->first();
                        $temp = EbayMasterProduct::select('master_product_id as id')->where('account_id', $ebay_account_id->id)->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                    elseif ($channel == "amazon"){
                        $amazon_account_id = AmazonAccount::where('account_name', $account_name)->first();
                        $amazon_application_id = AmazonAccountApplication::where('amazon_account_id', $amazon_account_id->id)->first();
                        $temp = AmazonMasterCatalogue::select('master_product_id as id')->where('application_id', $amazon_application_id->id)->get()->pluck('id')->toArray();
                        $ids = array_merge($ids,$temp);
                    }
                }
                $query->whereIn('id', $ids);
            }
            if($request->has('stock') && ($request->get('stock') != null)){
                $stockOpt = ($request->get('stock') == 'instock') ? '>' : '=';
                $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_variation.actual_quantity) stock'))
                    ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                    ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]]);
                    $query_info = $query_info->havingRaw('sum(product_variation.actual_quantity)'.$stockOpt.'0');
                    $query_info = $query_info->groupBy('product_drafts.id')
                    ->get();
                $ids = [];
                foreach ($query_info as $info){
                    $ids[] = $info->id;
                }
                $query->whereIn('id',$ids);
            }
        });
    }



}
