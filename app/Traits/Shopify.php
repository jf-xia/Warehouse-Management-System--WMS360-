<?php
namespace App\Traits;
use App\EbayMasterProduct;
use App\OnbuyMasterProduct;
use App\shopify\ShopifyAccount;
use App\shopify\ShopifyMasterProduct;
use App\woocommerce\WoocommerceCatalogue;
use PHPShopify\ShopifySDK;

trait Shopify{
    public function getConfig($shopUrl,$apiKey,$password){
        $config = array(
            'ShopUrl' => $shopUrl,
            'ApiKey' => $apiKey,
            'Password' => $password,
        );
        $shopify = new ShopifySDK($config);
        return $shopify;

    }

    // active catalogue search function-------------

    public function activeCatalogueSearchParams($request, $allCondition){

        if($request->get('id')){
            $allCondition['id'] = $request->get('id');
        }
        if($request->get('id_opt_out')){
            $allCondition['id_opt_out'] = $request->get('id_opt_out');
        }
        if($request->get('catalogue_id')){
            $allCondition['catalogue_id'] = $request->get('catalogue_id');
        }
        if($request->get('catalogue_opt_out')){
            $allCondition['catalogue_opt_out'] = $request->get('catalogue_opt_out');
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
        if($request->get('account')){
            $allCondition['account'] = $request->get('account');
        }
        if($request->get('account_opt_out')){
            $allCondition['account_opt_out'] = $request->get('account_opt_out');
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

    public function shopifyActiveCatalogueSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            $allConditions = [];
            if($request->get('id')){
                $id = $request->get('id');
                if($request->get('id_opt_out') == 1){
                    $query->where('id', '!=' ,$id);
                }else{
                    $query->where('id', $id);
                }
            }
            if($request->get('catalogue_id')){
                $catalogueId = $request->get('catalogue_id');
                if($request->get('catalogue_opt_out') == 1){
                    $query->where('master_catalogue_id', '!=' ,$catalogueId);
                }else{
                    $query->where('master_catalogue_id', $catalogueId);
                }
            }
            if($request->get('product_type')){
                $product_type = $request->get('product_type');
                if($request->get('product_type_opt_out') == 1){
                    $query->where('product_type','NOT LIKE', "%{$product_type}%");
                }else{
                    $query->where('product_type','LIKE', "%{$product_type}%");
                }
            }
            if($request->get('title')){
                $title = $request->get('title');
                if($request->get('title_opt_out') == 1){
                    $query->where('title','NOT LIKE', "%{$title}%");
                }else{
                    $query->where('title','LIKE', "%{$title}%");
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
            if($request->get('account')){
                $accountlArr = explode(' ~',$request->get('account'));
                $ids = array();
                foreach ($accountlArr as $channel){
                        $ids =  ShopifyMasterProduct::where('account_id', $channel)->get()->pluck('account_id')->toArray();
                    }
                if($request->get('account_opt_out') == 1){
                    $query->whereNotIn('account_id', $ids);
                }else{
                    $query->whereIn('account_id', $ids);
                }
            }
        });
    }

}
