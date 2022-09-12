<?php
namespace App\Traits;

use App\Order;
use App\ReturnOrder;
use App\EbayAccount;
use App\EbayMasterProduct;
use App\woocommerce\WoocommerceCatalogue;
use App\OnbuyMasterProduct;
use App\WoocommerceAccount;
use App\OnbuyAccount;
use App\amazon\AmazonAccountApplication;

use Illuminate\Support\Facades\DB;

trait SearchOrder {

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

    public function orderSearchCondition($mainQuery, $request){

        $mainQuery->where(function($query) use ($request){

            // print_r($request->get('channels'));
            // exit();

            $status = ($request->get('status') == 'processing') ? 'processing' : (($request->get('status') == 'assigned') ? 'processing' : ($request->get('status') ?? 'on-hold'));

            if($request->order_number){
                $orderNo = $request->order_number;
                if($request->orderNo_opt_out == 1){
                    $query->where('order_number', '!=', $orderNo);
                }else{
                    $query->where('order_number', $orderNo);
                }
            }

            if($request->get('channels')){
                $channel_search = explode(' ~',$request->get('channels'));
                $ids = array();
                $channels = [];
                $accounts = [];
                foreach($channel_search as $channel){
                    $channel_name = explode('/',$channel);
                    // dd($channel_name);
                    if($channel_name[0] == 'ebay'){
                        $ebay_account_id = EbayAccount::where('account_name', $channel_name[1])->first();
                        $channels[] = 'Ebay';
                        $accounts[] = $ebay_account_id->id;
                        //$query->where('created_via', 'Ebay')->where('status',$status)->where('account_id', $ebay_account_id->id);

                        //dd($ids);
                    }elseif($channel_name[0] == 'checkout'){
                        $woocommerce_account_id = WoocommerceAccount::where('account_name', $channel_name[1])->first();
                        $channels[] = 'checkout';
                        $accounts[] = $woocommerce_account_id->id;
                        //$query->where('created_via', 'checkout')->where('status',$status)->where('account_id', $woocommerce_account_id->id);

                        // dd($ids);
                    }elseif($channel_name[0] == 'onbuy'){
                        $onbuy_account_id = OnbuyAccount::where('account_name', $channel_name[1])->first();
                        $channels[] = 'onbuy';
                        $accounts[] = $onbuy_account_id->id;
                        //$query->where('created_via', 'onbuy')->where('status',$status)->where('account_id', $onbuy_account_id->id);

                        //  dd($ids);
                    }elseif($channel_name[0] == 'amazon'){
                        $amazon_account_id = AmazonAccountApplication::where('application_name', explode('(',$channel_name[1])[0])->first();
                        $channels[] = 'amazon';
                        $accounts[] = $amazon_account_id->id;
                        //$query->where('created_via', 'amazon')->where('status',$status)->where('account_id', $amazon_account_id->id);

                    }
                    //dd($ids);
                    // exit();

                }
                if($request->get('channel_opt_out') == 1){
                    $query->whereNotIn('created_via', $channels)->where('status',$status)->whereNotIn('account_id', $accounts);
                }else{
                    $query->whereIn('created_via', $channels)->where('status',$status)->where(function($q) use ($accounts){
                        $q->whereNull('account_id')->orWhereIn('account_id', $accounts);
                    });
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

            if($request->get('payment')){
                $payment_search = explode(' ~', $request->get('payment'));
                if($request->get('payment_opt_out') == 1){
                    $query->whereNotIn('payment_method',$payment_search);
                }else{
                    $query->whereIn('payment_method', $payment_search);
                }
            }
            if($request->customer_name){
                $customer_name = $request->customer_name;
                if($request->customer_name_optout == 1){
                    $query->where('customer_name', '!=', $customer_name);
                }else{
                    $query->where('customer_name', $customer_name);
                }
            }
            if($request->ebay_user_id){
                $ebay_user_id = $request->ebay_user_id;
                if($request->ebay_user_id_opt_out == 1){
                    $query->where('ebay_user_id', '!=', $ebay_user_id);
                }else{
                    $query->where('ebay_user_id', $ebay_user_id);
                }
            }
            if($request->customer_city){
                $customer_city = $request->customer_city;
                if($request->customer_city_optout == 1){
                    $query->where('customer_city', '!=', $customer_city);
                }else{
                    $query->where('customer_city', $customer_city);
                }
            }
            if($request->shipping_post_code){
                $shipping_post_code = $request->shipping_post_code;
                if($request->shipping_post_code_optout == 1){
                    $query->where('shipping_post_code', '!=', $shipping_post_code);
                }else{
                    $query->where('shipping_post_code', $shipping_post_code);
                }
            }
            if($request->date_created){
                $date_created = $request->date_created;
                if($request->date_created_optout == 1){
                    $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->date_created))]);
                }else{
                    $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->date_created))]);
                }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                $product_query = Order::select('orders.id',DB::raw('count(product_orders.id) as product'))
                    ->leftJoin('product_orders','orders.id','=','product_orders.order_id');
                    if($request->get('status') == 'completed'){
                        $product_query = $product_query->where('orders.status','completed');
                    }
                    elseif($request->get('status') == 'assigned'){
                        $product_query = $product_query->where('orders.status','processing')->where('picker_id','!=',null);
                    }
                    else{
                        $product_query = $product_query->where('orders.picker_id','=',null);
                    }
                    if($productOpt){
                        $product_query = $product_query->havingRaw('count(product_orders.id)' .$productOpt.$product );
                    }else{
                        $product_query = $product_query->havingRaw('count(product_orders.id) =' .$product);
                    }
                    $product_query =  $product_query->groupBy('orders.id')->get();

                   $ids = [];
                    foreach($product_query as $product){
                        $ids[] = $product->id;
                    }

                    if($request->get('product_optout') == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
            }

            if($request->get('price')){
                $price = $request->get('price');
                $price_opt = $request->get('price_opt') ? $request->get('price_opt') : null;
                if($request->get('price_optout') == 1){
                    $price_opt = $request->get('price_opt') ? $this->optOutOperator($request->get('price_opt')) : null;
                    if($price_opt){
                        $query->where('total_price',$price_opt, $price);
                    }else{
                        $query->where('total_price','!=', $price);
                    }
                }else{
                    if($price_opt){
                        $query->where('total_price',$price_opt,$price);
                    }else{
                        $query->where('total_price',$price);
                    }
                }
            }

            if($request->has('shipping_fee')){
                $price = $request->get('shipping_fee');
                $price_opt = $request->get('shipping_fee_opt') ? $request->get('shipping_fee_opt') : null;
                if($request->get('shipping_fee_optout') == 1){
                    $price_opt = $request->get('shipping_fee_opt') ? $this->optOutOperator($request->get('shipping_fee_opt')) : null;
                    if($price_opt){
                        $query->where('shipping_method',$price_opt, $price);
                    }else{
                        $query->where('shipping_method','!=', $price);
                    }
                }else{
                    if($price_opt){
                        $query->where('shipping_method',$price_opt,$price);
                    }else{
                        $query->where('shipping_method',$price);
                    }
                }
            }

            if($request->has('hold-by')){
                $holdUser = $request->get('hold-by');
                // dd($request->get('currency'));
                if($request->get('hold_by_optout') == 1){
                    $query->where('cancelled_by', '!=', $holdUser);
                }else{
                    $query->where('cancelled_by', $holdUser);
                }
            }
            if($request->get('currency')){
                $currency_search = $request->get('currency');
                // dd($request->get('currency'));
                if($request->get('currency_optout') == 1){
                    $query->where('currency', '!=', $currency_search);
                }else{
                    $query->where('currency', $currency_search);
                }
            }
            if($request->get('country')){
                $country_search = $request->get('country');
                // dd($request->get('country'));
                if($request->get('country_optout') == 1){
                    $query->where('customer_country', '!=', $country_search);
                }else{
                    $query->where('customer_country', $country_search);
                }
            }
            if($request->picker){
                $picker_search = $request->picker;
                // dd($request->get('picker'));
                if($request->picker_optout == 1){
                    $query->where('picker_id', '!=', $picker_search);
                }else{
                    $query->where('picker_id', $picker_search);
                }
            }
            if($request->packer){
                $picker_search = $request->packer;
                // dd($request->get('picker'));
                if($request->get('packer_opt_out') == 1){
                    $query->where('packer_id', '!=', $picker_search);
                }else{
                    $query->where('packer_id', $picker_search);
                }
            }
            if($request->assigner){
                $assigner_search = $request->assigner;
                // dd($request->get('assigner'));
                if($request->assigner_optout == 1){
                    $query->where('assigner_id', '!=', $assigner_search);
                }else{
                    $query->where('assigner_id', $assigner_search);
                }
            }
            if($request->has('picking_status')){
                $picking_status_search = $request->get('picking_status');
                $picking_status_query = Order::select('orders.id')
                    ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                    ->where('orders.picker_id','!=',null)
                    ->where('orders.status','processing');
                    if($picking_status_search == 0){
                        $picking_status_query = $picking_status_query->havingRaw('sum(product_orders.quantity) > sum(product_orders.picked_quantity)');
                    }else{
                        $picking_status_query = $picking_status_query->havingRaw('sum(product_orders.quantity) = sum(product_orders.picked_quantity)');
                    }
                    $picking_status_query = $picking_status_query->groupBy('orders.id')
                    ->get();
                $ids_arr = [];
                foreach ($picking_status_query as $order_status){
                    $ids_arr[] = $order_status->id;
                }
                $query->whereIn('id', $ids_arr);
                // if($picking_status_search == 1){
                //     $query->whereIn('id', $ids_arr);
                // }
                // if($picking_status_search == 0){
                //     dd($ids_arr);
                //     $query->whereNotIn('id', $ids_arr);
                // }
            }
            if($request->get('status_opt_out') != 1){
//                dd($request->order_status);
                if ($request->order_status == "awaiting dispatch"){
                    $query->where([['status','processing'],['picker_id',null]]);
                }
                elseif ($request->order_status == "assigned order"){
                    $query->where('status','processing')->where('picker_id','!=',null)->where('assigner_id','!=',null);
                }elseif ($request->order_status == "hold order"){
                    $query->where('status',['on-hold','exchange-hold']);
                }elseif ($request->order_status == "dispatch order"){
                    $query->where([['status','completed']]);
                }elseif ($request->order_status == "cancelled order"){
                    $query->where([['status','cancelled']]);
                }elseif ($request->order_status == "return order"){
//                    $query->
//                    $all_return_order = ReturnOrder::with(['return_product_save' => function($query){
//                        $query->with(['product_draft' => function($image_query){
//                            $image_query->with('single_image_info');
//                        }])->withTrashed();
//                        $query->wherePivot('deleted_at','=', null)->withTrashed();
//                    },'orders', 'returned_by_user', 'order_note' => function($query){
//                        $query->select(['id','order_id','note']);
//                    }]);
                }
//                $status_search = ($request->get('status') == 'awaiting dispatch' || $request->get('status') == 'assigned' ? 'processing' : $request->get('status'));
//                elseif($request->get('status_optout') == 1){
//                    $query->where([['status','processing'],['picker_id',null]]);
//                }
//else{
//                    $query->where('status', $status_search);
//                }
            }if ($request->get('status_opt_out') == 1){
                if ($request->order_status == "awaiting dispatch"){
                    $query->where([['status','!=','processing'],['picker_id',null]]);
                }
                elseif ($request->order_status == "assigned order"){
                    $query->where('picker_id','=',null)->where('assigner_id','=',null);
                }elseif ($request->order_status == "hold order"){
                    $query->where('status','!=',['on-hold','exchange-hold']);
                }elseif ($request->order_status == "dispatch order"){
                    $query->where([['status','!=','completed']]);
                }elseif ($request->order_status == "cancelled order"){
                    $query->where([['status','!=','cancelled']]);
                }elseif ($request->order_status == "return order"){
//                    $query->
//                    $all_return_order = ReturnOrder::with(['return_product_save' => function($query){
//                        $query->with(['product_draft' => function($image_query){
//                            $image_query->with('single_image_info');
//                        }])->withTrashed();
//                        $query->wherePivot('deleted_at','=', null)->withTrashed();
//                    },'orders', 'returned_by_user', 'order_note' => function($query){
//                        $query->select(['id','order_id','note']);
//                    }]);
                }
            }
            if($request->get('reason')){
                $reason_search = $request->get('reason');
                $cancelled_reason_query = Order::select('orders.id')
                ->leftJoin('order_cancel_reasons', 'orders.id', '=', 'order_cancel_reasons.order_id')
                ->where('orders.status', 'cancelled')
                ->where('order_cancel_reasons.order_cancel_id', 'LIKE', '%' . $reason_search . '%')
                ->groupBy('orders.id')
                ->get();

                $ids = [];
                foreach ($cancelled_reason_query as $reason) {
                $ids[] = $reason->id;
                }

                if($request->get('reason_optout') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->cancelled_by){
                $cancelled_by_search = $request->cancelled_by;
                // dd($request->get('cancelled_by'));
                if($request->cancelled_by_optout == 1){
                    $query->where('cancelled_by', '!=', $cancelled_by_search);
                }else{
                    $query->where('cancelled_by', $cancelled_by_search);
                }
            }
            if($request->ebay_user_id){
                $ebay_user_id = $request->ebay_user_id;

                // dd($request->get('cancelled_by'));

                if($request->ebay_user_id_opt_out == 1){

                    $query->where('ebay_user_id', '!=', $ebay_user_id);

                }else{
                    $query->where('ebay_user_id', $ebay_user_id);

                }
            }

            if($request->has('order_note')){
                if($request->order_note == 1){
                    $query->has('order_note')->orWhere(function($q) {
                        $q->where('buyer_message','!=', null)->where('buyer_message','!=','');
                    });
                }else{
                    $query->doesntHave('order_note')->where(function($q){
                        $q->where('buyer_message',null)->orWhere('buyer_message','=','');
                    });
                }
            }
            //$this->allSearchConditionArr('condition',$allConditions);
        });
        // dd($this->allSearchConditionArr('result'));

    }

    public function orderConditionParams($request, $allCondition){

        if($request->order_number){
            $allCondition['order_number'] = $request['order_number'];
        }
        if($request->orderNo_opt_out){
            $allCondition['orderNo_opt_out'] = $request->get('orderNo_opt_out');
        }
        if($request->customer_name){
            $allCondition['customer_name'] = $request['customer_name'];
        }
        if($request->customer_name_optout){
            $allCondition['customer_name_optout'] = $request['customer_name_optout'];
        }
        if($request->customer_city){
            $allCondition['customer_city'] = $request['customer_city'];
        }
        if($request->customer_city_optout){
            $allCondition['customer_city_optout'] = $request['customer_city_optout'];
        }
        if($request->shipping_post_code){
            $allCondition['shipping_post_code'] = $request['shipping_post_code'];
        }
        if($request->shipping_post_code_optout){
            $allCondition['shipping_post_code_optout'] = $request['shipping_post_code_optout'];
        }
        if($request->date_created){
            $allCondition['date_created'] = $request['date_created'];
        }
        if($request->date_created_optout){
            $allCondition['date_created_optout'] = $request['date_created_optout'];
        }
        if($request->has('product')){
            $allCondition['product'] = $request->get('product');
        }
        if($request->get('product_opt')){
            $allCondition['product_opt'] = $request->get('product_opt');
        }
        if($request->get('product_optout')){
            $allCondition['product_optout'] = $request->get('product_optout');
        }
        if($request->price){
            $allCondition['price'] = $request->get('price');
        }
        if($request->price_opt){
            $allCondition['price_opt'] = $request->get('price_opt');
        }
        if($request->price_optout){
            $allCondition['price_optout'] = $request->get('price_optout');
        }
        if($request->shipping_fee){
            $allCondition['shipping_fee'] = $request->get('shipping_fee');
        }
        if($request->shipping_fee_opt){
            $allCondition['shipping_fee_opt'] = $request->get('shipping_fee_opt');
        }
        if($request->shipping_fee_optout){
            $allCondition['shipping_fee_optout'] = $request->get('shipping_fee_optout');
        }
        if($request->get('channels')){
            $allCondition['channels'] = explode(' ~',$request->get('channels'));
        }
        if($request->get('channel_opt_out')){
            $allCondition['channel_opt_out'] = $request->get('channel_opt_out');
        }
        if($request->get('payment')){
            $allCondition['payment'] = explode(' ~',$request->get('payment'));
        }
        if($request->get('payment_opt_out')){
            $allCondition['payment_opt_out'] = $request->get('payment_opt_out');
        }
        if($request->get('currency')){
            $allCondition['currency'] = $request->get('currency');
        }
        if($request->get('currency_optout')){
            $allCondition['currency_optout'] = $request->get('currency_optout');
        }
        if($request->get('country')){
            $allCondition['country'] = $request->get('country');
        }
        if($request->get('hold_by_optout')){
            $allCondition['hold_by_optout'] = $request->get('hold_by_optout');
        }
        if($request->get('hold-by')){
            $allCondition['hold-by'] = $request->get('hold-by');
        }
        if($request->get('country_optout')){
            $allCondition['country_optout'] = $request->get('country_optout');
        }
        if($request->get('picker')){
            $allCondition['picker'] = $request->get('picker');
        }
        if($request->get('packer')){
            $allCondition['packer'] = $request->get('packer');
        }
        if($request->get('packer_opt_out')){
            $allCondition['packer_opt_out'] = $request->get('packer_opt_out');
        }
        if($request->get('picker_optout')){
            $allCondition['picker_optout'] = $request->get('picker_optout');
        }
        if($request->get('assigner')){
            $allCondition['assigner'] = $request->get('assigner');
        }
        if($request->get('assigner_optout')){
            $allCondition['assigner_optout'] = $request->get('assigner_optout');
        }
        if($request->has('picking_status')){
            $allCondition['picking_status'] = $request->get('picking_status');
        }
        if($request->get('order_status')){
            $allCondition['order_status'] = $request->get('order_status');
        }
        if($request->get('status_opt_out')){
            $allCondition['status_opt_out'] = $request->get('status_opt_out');
        }
        if($request->get('ebay_user_id')){
            $allCondition['ebay_user_id'] = $request->get('ebay_user_id');
        }
        if($request->get('ebay_user_id_opt_out')){
            $allCondition['ebay_user_id_opt_out'] = $request->get('ebay_user_id_opt_out');
        }
        if($request->get('reason')){
            $allCondition['reason'] = $request->get('reason');
        }
        if($request->get('reason_optout')){
            $allCondition['reason_optout'] = $request->get('reason_optout');
        }
        if($request->get('return_date')){
            $allCondition['return_date'] = $request->get('return_date');
        }
        if($request->get('return_date_opt_out')){
            $allCondition['return_date_opt_out'] = $request->get('return_date_opt_out');
        }
        if($request->get('return_by')){
            $allCondition['return_by'] = $request->get('return_by');
        }
        if($request->get('return_by_opt_out')){
            $allCondition['return_by_opt_out'] = $request->get('return_by_opt_out');
        }
        if($request->get('return_reason')){
            $allCondition['return_reason'] = $this->stringConverter->andConvertToLogicalAnd($request->get('return_reason'));
        }
        if($request->get('return_reason_optout')){
            $allCondition['return_reason_optout'] = $request->get('return_reason_optout');
        }
        if($request->has('return_cost')){
            $allCondition['return_cost'] = $request->get('return_cost');
        }
        if($request->has('return_cost_opt')){
            $allCondition['return_cost_opt'] = $request->get('return_cost_opt');
        }
        if($request->has('return_cost_optout')){
            $allCondition['return_cost_optout'] = $request->get('return_cost_optout');
        }
        if($request->get('cancelled_by')){
            $allCondition['cancelled_by'] = $request->get('cancelled_by');
        }
        if($request->get('cancelled_by_optout')){
            $allCondition['cancelled_by_optout'] = $request->get('cancelled_by_optout');
        }
        if($request->has('order_note')){
            $allCondition['order_note'] = $request->get('order_note');
        }
        
        // print_r($allCondition['price_opt']);
        // exit();

        return $allCondition;
    }

    public function returnOrderSearchCondition($mainQuery, $request){
        $mainQuery->where(function($query) use ($request){
            if($request->has('order_number')){
                $data['query'] = $query;
                $data['value'] = $request->get('order_number');
                $data['optOutValue'] = $request->get('orderNo_opt_out') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'order_number';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('return_date')){
                $returnDate = $request->get('return_date');
                if($request->get('return_date_opt_out') == 1){
                    $query->whereRaw('DATE(created_at) != ?',[date('Y-m-d',strtotime($returnDate))]);
                }else{
                    $query->whereRaw('DATE(created_at) = ?',[date('Y-m-d',strtotime($returnDate))]);
                }
            }
            if($request->has('return_by')){
                $returnBy = $request->get('return_by');
                if($request->get('return_by_opt_out') == 1){
                    $query->where('returned_by','!=',$returnBy);
                }else{
                    $query->where('returned_by',$returnBy);
                }
            }
            if($request->has('channels')){
                $data['query'] = $query;
                $data['value'] = $this->channelSearch(explode(' ~',$request->get('channels')));
                $data['optOutValue'] = $request->get('channel_opt_out') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'id';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('payment')){
                $data['query'] = $query;
                $data['value'] = explode(' ~',$request->get('payment'));
                $data['optOutValue'] = $request->get('payment_opt_out') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'payment_method';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('payment')){
                $data['query'] = $query;
                $data['value'] = explode(' ~',$request->get('payment'));
                $data['optOutValue'] = $request->get('payment_opt_out') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'payment_method';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('customer_name')){
                $data['query'] = $query;
                $data['value'] = $request->get('customer_name');
                $data['optOutValue'] = $request->get('customer_name_optout') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'customer_name';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('customer_city')){
                $data['query'] = $query;
                $data['value'] = $request->get('customer_city');
                $data['optOutValue'] = $request->get('customer_city_optout') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'customer_city';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('date_created')){
                $orderDate = $request->get('date_created');
                if($request->get('date_created_optout') == 1){
                    $query->whereHas('orders', function($q) use ($orderDate){
                        $q->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($orderDate))]);
                   });
                }else{
                    $query->whereHas('orders', function($q) use ($orderDate){
                        $q->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($orderDate))]);
                   });
                }
            }
            if($request->has('product')){
                $product = $request->get('product');
                $productOpt = $request->get('product_opt') ? $request->get('product_opt') : null;
                $ids = ReturnOrder::whereHas('orderedProduct', function($q) use ($product, $productOpt){
                    if($productOpt){
                        $q->havingRaw('count(id)'.$productOpt.$product );
                    }else{
                        $q->havingRaw('count(id) = '.$product );
                    }
                })->pluck('id')->toArray();
                if($request->get('product_optout') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->has('price')){
                $price = $request->get('price');
                $priceOpt = $request->get('price_opt') ? $request->get('price_opt') : null;
                $ids = ReturnOrder::whereHas('orders', function($q) use ($price, $priceOpt){
                    if($priceOpt){
                        $q->where('total_price', $priceOpt, $price);
                    }else{
                        $q->where('total_price', $price);
                    }
                })->pluck('id')->toArray();
                if($request->get('price_optout') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->has('shipping_fee')){
                $price = $request->get('shipping_fee');
                $price_opt = $request->get('shipping_fee_opt') ? $request->get('shipping_fee_opt') : null;
                $ids = ReturnOrder::whereHas('orders', function($q) use ($price, $price_opt){
                    if($price_opt){
                        $q->where('shipping_method', $price_opt, $price);
                    }else{
                        $q->where('shipping_method', $price);
                    }
                })->pluck('id')->toArray();
                if($request->has('shipping_fee_optout') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->has('currency')){
                $data['query'] = $query;
                $data['value'] = $request->get('currency');
                $data['optOutValue'] = $request->get('currency_optout') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'currency';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('return_reason')){
                $returnReason = $this->stringConverter->andConvertToLogicalAnd($request->get('return_reason'));
                if($request->get('return_reason_optout') == 1){
                    $query->where('return_reason','!=',$returnReason);
                }else{
                    $query->where('return_reason',$returnReason);
                }
            }
            if($request->has('return_cost')){
                $returnCost = $request->get('return_cost');
                $returnCostOpt = $request->get('return_cost_opt') ? $request->get('return_cost_opt') : null;
                $ids = ReturnOrder::query();
                if($returnCostOpt){
                    $ids = $ids->where('return_cost',$returnCostOpt,$returnCost);
                }else{
                    $ids = $ids->where('return_cost','!=',$returnCost);
                }
                $ids = $ids->pluck('id')->toArray();

                if($request->get('return_cost_optout') == 1){
                    $query->whereNotIn('id', $ids);
                }else{
                    $query->whereIn('id', $ids);
                }
            }
            if($request->has('shipping_post_code')){
                $data['query'] = $query;
                $data['value'] = $request->get('shipping_post_code');
                $data['optOutValue'] = $request->get('shipping_post_code_optout') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'shipping_post_code';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
            if($request->has('country')){
                $data['query'] = $query;
                $data['value'] = $request->get('country');
                $data['optOutValue'] = $request->get('country_optout') ?? null;
                $data['model'] = 'orders';
                $data['column'] = 'customer_country';
                $data['request'] = $request;
                $this->eagerWhereHas($data);
            }
        });
    }

    public function eagerWhereHas($data){
        if($data['optOutValue'] == 1){
            $data['query']->whereHas($data['model'], function($q) use ($data){
                if(is_array($data['value'])){
                    // dd($data['value']);
                    $q->whereNotIn($data['column'],$data['value']);
                }else{
                    // dd($data['value']);
                    $q->where($data['column'],'!=',$data['value']);

                }
            });
        }else{
            $data['query']->whereHas($data['model'], function($q) use ($data){
                if(is_array($data['value'])){
                    // dd($data['value']);
                    $q->whereIn($data['column'],$data['value']);
                }else{
                    // dd($data['value']);
                    $q->where($data['column'],$data['value']);
                }
            });
        }
    }

    public function channelSearch($channel_search){
        $ids = [];
        foreach($channel_search as $channel){
            $channel_name = explode('/',$channel);
            if($channel_name[0] == 'ebay'){
                $ebay_account_id = EbayAccount::where('account_name', $channel_name[1])->first();
                $temp = Order::where('created_via', 'Ebay')->where('account_id', $ebay_account_id->id)->pluck('id')->toArray();
                $ids = array_merge($ids,$temp);
            }elseif($channel_name[0] == 'checkout'){
                $woocommerce_account_id = WoocommerceAccount::where('account_name', $channel_name[1])->first();
                $temp = Order::where('created_via', 'checkout')->where('account_id', $woocommerce_account_id->id)->pluck('id')->toArray();
                $ids = array_merge($ids,$temp);
            }elseif($channel_name[0] == 'onbuy'){
                $onbuy_account_id = OnbuyAccount::where('account_name', $channel_name[1])->first();
                $temp = Order::where('created_via', 'onbuy')->where('account_id', $onbuy_account_id->id)->pluck('id')->toArray();
                $ids = array_merge($ids,$temp);
            }elseif($channel_name[0] == 'amazon'){
                $amazon_account_id = AmazonAccountApplication::where('application_name', explode('(',$channel_name[1])[0])->first();
                $temp = Order::where('created_via', 'amazon')->where('account_id', $amazon_account_id->id)->pluck('id')->toArray();
                $ids = array_merge($ids,$temp);
            }
        }
        return $ids;
    }


}
