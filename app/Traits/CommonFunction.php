<?php
namespace App\Traits;

use App\EbayAccount;
use App\OnbuyAccount;
use App\shopify\ShopifyAccount;
use App\WoocommerceAccount;
use App\amazon\AmazonAccount;
use Illuminate\Support\Facades\DB;
use App\Channel;
use App\Order;
use Illuminate\Support\Facades\Session;
use Storage;
use App\ReshelvedProduct;
use App\Shelf;
use App\ProductVariation;
use App\ItemAttribute;
use App\ItemAttributeProfileTerm;
use App\Setting;
use App\ItemAttributeTerm;
use Illuminate\Support\Facades\Auth;
use App\OnbuyMasterProduct;
use App\Image;

trait CommonFunction{

    public function accountInfo($rootChannel, $accountId){
        $accountInfo = null;
        if($rootChannel == 'ebay' || $rootChannel == 'Ebay'){
            $accountInfo = EbayAccount::find($accountId);
        }elseif($rootChannel == 'onbuy'){
            $accountInfo = OnbuyAccount::find($accountId);
        }elseif($rootChannel == 'woocommerce' || $rootChannel == 'checkout'){
            $accountInfo = WoocommerceAccount::find($accountId);
        }elseif($rootChannel == 'amazon'){
            $accountInfo = AmazonAccount::find($accountId);
        }
        return $accountInfo;
    }

    public function accountLogo($rootChannel, $accountId){
        $accountLogo = null;
        if($rootChannel == 'ebay' || $rootChannel == 'Ebay'){
            $accountLogo = EbayAccount::find($accountId)->logo;
        }elseif($rootChannel == 'onbuy'){
            $accountLogo = OnbuyAccount::find($accountId)->account_logo ?? asset('/assets/common-assets/onbuy.png');
        }elseif($rootChannel == 'woocommerce' || $rootChannel == 'checkout'){
            $accountLogo = WoocommerceAccount::find($accountId)->account_logo ?? asset('/assets/common-assets/wooround.png');
        }elseif($rootChannel == 'amazon'){
            $accountInfo = AmazonAccount::with(['accountApplication:id,amazon_account_id,amazon_marketplace_fk_id,application_logo'])->find($accountId);
            $accountLogo = $accountInfo->account_logo ? asset('/').$accountInfo->account_logo : asset('/').$accountInfo->accountApplication[0]->application_logo;
        }
        return $accountLogo;
    }

    public function uploadSingleImage($url,$diskStorage){

        $contents = $this->curl_get_file_contents($url);
        $name = random_int(1,1000000).'.webp';

        Storage::disk($diskStorage)->put($name, $contents);

       return $name;
    }

    public function orderWithoutCancelAndReturn($mainQuery, $channel = null, $accountId = null){
        //$mainQuery should come form ProductOrder model
        $mainQuery->select('order_id','variation_id', DB::raw('sum(product_orders.quantity) sold'))
            ->whereHas('order',function($q) use ($channel,$accountId){
                $q->where('status','!=','cancelled');
                if($channel != null){
                    $q->where('created_via',$channel);
                }
                if($accountId != null){
                    $q->where('account_id',$accountId);
                }
            })->doesntHave('returnOrder')->groupBy('order_id')->groupBy('variation_id');
    }

    public static function dynamicOrderLink($created_via,$order){
        if ($created_via == "Ebay"){
            $link = "<a href='https://www.ebay.co.uk/sh/ord/?search=ordernumber%3A".($order->order_number ?? '')."' "."target='_blank'>".($order->order_number ?? '').'</a>';
            return  $link;
        }elseif ($created_via == 'Woocommerce' || $created_via == 'checkout'){
            $account_info = WoocommerceAccount::first();
            //$account_info = WoocommerceAccount::find($order->account_id);
            $link = "<a href='".$account_info->site_url."wp-admin/post.php?post=".($order->order_number ?? '')."&action=edit' "."target='_blank'>".($order->order_number ?? '').'</a>';
            return $link;
        }elseif ($created_via == 'onbuy'){
            $link = "<a href='https://seller.onbuy.com/orders/".($order->order_number ?? '')."/' "."target='_blank'>".($order->order_number ?? '').'</a>';
            return $link;
        }elseif ($created_via == 'amazon'){
            $link = "<a href='https://sellercentral.amazon.co.uk/orders-v3/order/".($order->order_number ?? '')."' "."target='_blank'>".($order->order_number ?? '').'</a>';
            return $link;
        }elseif ($created_via == 'shopify'){
            $account_info = ShopifyAccount::find($order->account_id);
            $link = "<a href='".$account_info->shop_url."/admin/orders/".($order->order_number ?? '')."' "."target='_blank'>".($order->order_number ?? '').'</a>';
            return $link;
        }elseif ($created_via == 'rest-api'){
            $link = "<a href='#' target='_blank'>".($order->order_number ?? '')."</a>";
            return $link;
        }
    }

    public function getChannelInfo($channel){
        return Channel::where('channel',$channel)->first();
    }

    public function getOrderCSV($conditionArr = [], $orderIdsArr = null){
        $orderInfo = Order::with('orderedProduct.variation_info');
        if(count($conditionArr) > 0){
            foreach($conditionArr as $condition){
                $value = $condition['value'];
                if($condition['operator'] == null){
                    if(is_array($value) || (gettype($value) == 'object')){
                        $orderInfo = $orderInfo->whereIn($condition['column'],$value);
                    }else{
                        $orderInfo = $orderInfo->where($condition['column'],$value);
                    }
                }else{
                    if((is_array($value) || (gettype($value) == 'object')) && ($condition['operator'] == '!=')){
                        $orderInfo = $orderInfo->whereNotIn($condition['column'],$value);
                    }else{
                        $orderInfo = $orderInfo->where($condition['column'],$condition['operator'],$value);
                    }
                }
            }
            if($orderIdsArr != null){
                $orderInfo = $orderInfo->whereIn('id',$orderIdsArr);
            }
        }
        $orderInfo = $orderInfo->get();
        return $orderInfo;
    }

    public function parseUrl($url){
        return parse_url($url);
    }

    public function projectUrl(){
        return asset('/');
    }

    public function channel_restriction_order_session($query){
        if(Session::get('ebay') == 0){
            $query->where('created_via','!=','Ebay')->where('created_via','!=','ebay');
        }
        if(Session::get('woocommerce') == 0){
            $query->where('created_via','!=','checkout');
        }
        if(Session::get('onbuy') == 0){
            $query->where('created_via','!=','onbuy');
        }
        if(Session::get('amazon') == 0){
            $query->where('created_via','!=','amazon');
        }
        if(Session::get('shopify') == 0){
            $query->where('created_via','!=','shopify');
        }
    }

    public function checkChannelActiveBySessionValue($channel){
        return (Session::get($channel) == 1) ? true : false;
    }

    public function activityLogChannelRestriction($query){
        if(Session::get('ebay') == 0){
            $query->where('account_name','!=','Ebay')->where('account_name','!=','ebay');
        }
        if(Session::get('woocommerce') == 0){
            $query->where('account_name','!=','Woocommerce');
        }
        if(Session::get('onbuy') == 0){
            $query->where('account_name','!=','Onbuy');
        }
        if(Session::get('amazon') == 0){
            $query->where('account_name','!=','Amazon');
        }
        if(Session::get('shopify') == 0){
            $query->where('account_name','!=','Shopify');
        }
    }

    public function reshelfConditionParams($request, $allCondition){
        if($request->shelf_id){
            $allCondition['shelf_id'] = $request['shelf_id'];
        }
        if($request->shelf_opt_out){
            $allCondition['shelf_opt_out'] = $request['shelf_opt_out'];
        }
        if($request->variation_id){
            $allCondition['variation_id'] = $request['variation_id'];
        }
        if($request->variation_id_opt_out){
            $allCondition['variation_id_opt_out'] = $request['variation_id_opt_out'];
        }
        if($request->shelved_quantity){
            $allCondition['shelved_quantity'] = $request['shelved_quantity'];
        }
        if($request->shelved_quantity_opt){
            $allCondition['shelved_quantity_opt'] = $request['shelved_quantity_opt'];
        }
        if($request->shelved_quantity_opt_out){
            $allCondition['shelved_quantity_opt_out'] = $request['shelved_quantity_opt_out'];
        }
        if($request->user_id){
            $allCondition['user_id'] = $request['user_id'];
        }
        if($request->user_id_opt_out){
            $allCondition['user_id_opt_out'] = $request['user_id_opt_out'];
        }
        if($request->has('status')){
            $allCondition['status'] = ($request->status == 1) ? '1' : '0';
        }
        if($request->status_opt_out){
            $allCondition['status_opt_out'] = $request['status_opt_out'];
        }
        return $allCondition;
    }

    public function reshelfSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            if($request->has('shelved_quantity')){
                $search_value = $request->get('shelved_quantity');
                $search_filter_option = $request->get('shelved_quantity_opt');
                $raw_condition = ($request->get('shelved_quantity_opt_out') != 1) ? '' : '!';
                $reshelved_quantity = ReshelvedProduct::select('reshelved_product.id')
                    ->havingRaw("sum(reshelved_product.shelved_quantity)".$raw_condition.$search_filter_option.$search_value)
                    ->groupBy('reshelved_product.id')
                    ->get();
                $ids = [];
                if(count($reshelved_quantity) > 0) {
                    foreach ($reshelved_quantity as $quantity) {
                        $ids[] = $quantity->id;
                    }
                }
                $query->whereIn('id',$ids);
            }
            if($request->has('shelf_id')){
                $search_value = $request->get('shelf_id');
                $shelfInfo = Shelf::where('shelf_name',$search_value)->first();
                $shelfIds = [$shelfInfo->id ?? ''];
                $query->where(function($s_query) use ($shelfIds,$request){
                    if($request->get('shelf_opt_out') == 1){
                        $s_query->whereNotIn('shelf_id',$shelfIds);
                    }else{
                        $s_query->whereIn('shelf_id',$shelfIds);
                    }
                });
            }
            if($request->has('variation_id')){
                $search_value = $request->get('variation_id');
                $variationInfo = ProductVariation::where('sku', $search_value)->first();
                $variationIds = [$variationInfo->id ?? ''];
                $query->where(function($s_query)use($request,$variationIds){
                    if($request->get('variation_id_opt_out') == 1){
                        $s_query->whereNotIn('variation_id', $variationIds);
                    }else{
                        $s_query->whereIn('variation_id', $variationIds);
                    }
                });
            }
            if($request->has('user_id')){
                $search_value = $request->get('user_id');
                $query->where(function($s_query)use($request,$search_value){
                    if($request->get('user_id_opt_out') == 1){
                        $s_query->whereNotIn('user_id', [$search_value]);
                    }else{
                        $s_query->where('user_id', $search_value);
                    }
                });
            }
            if($request->has('status')){
                $search_value = $request->get('status');
                $query->where(function($s_query)use($request,$search_value){
                    if($request->get('status_opt_out') == 1){
                        $s_query->whereNotIn('status', [$search_value]);
                    }else{
                        $s_query->where('status', $search_value);
                    }
                });
            }
        });
    }

    public function shelfConditionParams($request, $allCondition){
        if($request->id){
            $allCondition['id'] = $request['id'];
        }
        if($request->id_opt_out){
            $allCondition['id_opt_out'] = $request['id_opt_out'];
        }
        if($request->shelf_name){
            $allCondition['shelf_name'] = $request['shelf_name'];
        }
        if($request->shelf_opt_out){
            $allCondition['shelf_opt_out'] = $request['shelf_opt_out'];
        }
        if($request->has('total_quantity')){
            $allCondition['total_quantity'] = $request['total_quantity'];
        }
        if($request->total_quantity_opt){
            $allCondition['total_quantity_opt'] = $request['total_quantity_opt'];
        }
        if($request->total_quantity_opt_out){
            $allCondition['total_quantity_opt_out'] = $request['total_quantity_opt_out'];
        }
        if($request->user_id){
            $allCondition['user_id'] = $request['user_id'];
        }
        if($request->user_id_opt_out){
            $allCondition['user_id_opt_out'] = $request['user_id_opt_out'];
        }
        return $allCondition;
    }

    public function shelfSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            if($request->has('total_quantity')){
                $search_value = $request->get('total_quantity');
                $search_filter_option = $request->get('total_quantity_opt');
                $raw_condition = ($request->get('total_quantity_opt_out') != 1) ? '' : '!';
                $shelf_quantity = Shelf::select('shelfs.id')
                    ->join('product_shelfs','shelfs.id','=','product_shelfs.shelf_id')
                    ->havingRaw("sum(product_shelfs.quantity)".$raw_condition.$search_filter_option.$search_value)
                    ->groupBy('shelfs.id')
                    ->take(50)
                    ->get();
                $ids = [];
                if(count($shelf_quantity) > 0) {
                    foreach ($shelf_quantity as $quantity) {
                        $ids[] = $quantity->id;
                    }
                }
                $query->whereIn('id',$ids);
            }
            if($request->has('id')){
                $search_value = $request->get('id');
                $query->where(function($s_query)use($request,$search_value){
                    if($request->get('id_opt_out') != 1){
                        $s_query->where('id', $search_value);
                    }else{
                        $s_query->where('id','!=',$search_value);
                    }
                });
            }
            if($request->has('shelf_name')){
                $search_value = $request->get('shelf_name');
                $query->where(function($s_query)use($request,$search_value){
                    if($request->get('shelf_opt_out') != 1){
                        $s_query->where('shelf_name', 'LIKE', '%' . $search_value . '%');
                    }else{
                        $s_query->where('shelf_name','NOT LIKE','%'.$search_value.'%');
                    }
                });
            }
            if($request->has('user_id')){
                $search_value = $request->get('user_id');
                $query->where(function($s_query)use($request,$search_value){
                    if($request->get('user_id_opt_out') != 1){
                        //dd($search_value);
                        $s_query->where('user_id','=', $search_value);
                    }else{
                        $s_query->where('user_id','!=',$search_value);
                    }
                });
            }
        });
    }

    public function itemProfileSearchParams($request, $allCondition){
        if($request->search_value){
            $allCondition['search_value'] = $request['search_value'];
        }
        if($request->profile_name){
            $allCondition['profile_name'] = $request['profile_name'];
        }
        if($request->profile_name_opt_out){
            $allCondition['profile_name_opt_out'] = $request['profile_name_opt_out'];
        }
        if($request->item_attribute){
            $allCondition['item_attribute'] = $request['item_attribute'];
        }
        if($request->item_attribute_opt_out){
            $allCondition['item_attribute_opt_out'] = $request['item_attribute_opt_out'];
        }
        return $allCondition;
    }

    public function itemProfileSearch($mainQuery, $request) {
        $mainQuery->where(function($query) use ($request){
            if($request->has('profile_name')){
                $search_value = $request->get('profile_name');
                $query->where(function($s_query) use ($request, $search_value){
                    if($request->get('profile_name_opt_out') != 1){
                        $s_query->where('profile_name','LIKE','%'.$search_value.'%');
                    }else{
                        $s_query->where('profile_name','NOT LIKE','%'.$search_value.'%');
                    }
                });
            }
            if($request->has('item_attribute')){
                $search_value = $request->get('item_attribute');
                $attributeIds = ItemAttribute::where('item_attribute','LIKE','%'.$search_value.'%')->pluck('id')->toArray();
                $query->where(function($s_query) use ($request, $attributeIds){
                    if($request->get('item_attribute_opt_out') != 1){
                        $s_query->whereIn('item_attribute_id',$attributeIds);
                    }else{
                        $s_query->whereNotIn('item_attribute_id',$attributeIds);
                    }
                });
            }
            if($request->has('search_value')){
                $search_value = $request->get('search_value');
                $query->where('profile_name','LIKE','%'.$search_value.'%')->orWhere(function($s_query) use ($search_value) {
                    $attributeIds = ItemAttribute::where('item_attribute','LIKE','%'.$search_value.'%')->pluck('id')->toArray();
                    $s_query->whereIn('item_attribute_id',$attributeIds);
                })->orwhere(function($s_query) use ($search_value) {
                    $attributeIds = ItemAttributeProfileTerm::where('item_attribute_term_value','LIKE','%'.$search_value.'%')->pluck('item_attribute_profile_id')->toArray();
                    $s_query->whereIn('id',$attributeIds);
                })->orwhere(function($s_query) use ($search_value) {
                    $termIds = ItemAttributeTerm::where('item_attribute_term','LIKE','%'.$search_value.'%')->pluck('id')->toArray();
                    $attributeIds = ItemAttributeProfileTerm::whereIn('item_attribute_term_id',$termIds)->pluck('item_attribute_profile_id')->toArray();
                    $s_query->whereIn('id',$attributeIds);
                });
            }
        });
    }

    public function userPaginationSetting ($firstKey, $secondKey = NULL) {
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

    public function checkCatalogueExistInChannel($channel, $catalogue) {
        if($channel == 'onbuy') {
            $channelInfo = OnbuyMasterProduct::where('woo_catalogue_id', $catalogue)->first();
            if($channelInfo) {
                return response()->json(['success' => false]);
            }
            return response()->json(['success' => true]);
        }
    }

    public function getMasterCatalogueImageAsArray($catalogueId) {
        $images = Image::where('draft_product_id',$catalogueId)->where('deleted_at',null)->pluck('image_url')->toArray();
        return array_map(function($img) {
            return asset('/').$img;
        },$images);
    }

    public function getDateByTimeZone($date, $timeZone = 'Europe/London', $format = 'd-m-Y H:i:s') {
        return $date ? \Carbon\Carbon::parse($date)->timezone($timeZone)->format($format) ?? '' : '';
    }

}
