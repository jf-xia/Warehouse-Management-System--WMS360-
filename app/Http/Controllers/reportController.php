<?php

namespace App\Http\Controllers;

use App\amazon\AmazonAccount;
use App\EbayAccount;
use App\Http\Controllers\Controller;
use App\OnbuyAccount;
use App\Order;
use App\ProductDraft;
use App\ProductOrder;
use App\ProductVariation;
use App\Setting;
use App\shopify\ShopifyAccount;
use App\Traits\CommonFunction;
use App\WoocommerceAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class reportController extends Controller
{
    use CommonFunction;
    //global report form option
    public function globalReports(){

        $wooChannel = WoocommerceAccount::get()->all();
        $onbuyChannel = OnbuyAccount::get()->all();
        $ebayChannel = EbayAccount::get()->all();
        $shopifyChannel = ShopifyAccount::get()->all();
        $amazonChannel = AmazonAccount::get()->all();

        $channels = array();
        $temp = array();
        $shop = array();
        $amz = array();
        $onb = array();
        $woo = array();
        foreach ($wooChannel as $woocommerce){
            $woo[$woocommerce->id] = $woocommerce->account_name;
        }

        foreach ($onbuyChannel as $onbuy){
            $onb[$onbuy->id] = $onbuy->account_name;
        }
        foreach ($ebayChannel as $ebay){
            $temp[$ebay->id] = $ebay->account_name;
        }
        foreach ($shopifyChannel as $shopify){
            $shop[$shopify->id] = $shopify->account_name;
        }
        foreach ($amazonChannel as $amazon){
            $amz[$amazon->id] = $amazon->account_name;
        }

        $channels["ebay"] = $temp;
        $channels["shopify"] = $shop;
        $channels["amazon"] = $amz;
        $channels["onbuy"] = $onb;
        $channels["woocommerce"] = $woo;
        return view('reports.global_report', compact('channels'));
    }

//    unsold sku report
    public function unsoldCatalogueSku(Request $request){
        $csv_predefine_date = $request->predefine_date;
        $csv_start_date = $request->start_date;
        $csv_end_date = $request->end_date;
        $csv_sku = $request->sku;
        $csv_accounts = $request->accounts;

        $woocommerceSiteUrl = WoocommerceAccount::first();
        $date = date('Y-m-d');
        $today = date('Y-m-d', strtotime($date.' + 1 days'));
        $yesterday = date('Y-m-d', strtotime($date. ' - 1 days'));
        $sevendays = date('Y-m-d', strtotime($date. ' - 7 days'));
        $oneMonth = date('Y-m-d', strtotime($date. ' - 30 days'));
        $twoMonth = date('Y-m-d', strtotime($date. ' - 60 days'));
        $threeMonth = date('Y-m-d', strtotime($date. ' - 90 days'));
        $predefine_date = $request->predefine_date;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $sku = $request->sku;
        $accounts = $request->accounts;
        $account = (explode("/",$accounts));

        $find_sku  =  ProductVariation::where('sku','=',$sku)->get()->first();
        $variation_id = $find_sku->id;

        $product_order = ProductOrder::with(['Order'])->where('variation_id', $variation_id)->get();
        $sold = 0;
        $all_value = array();
        foreach ($product_order as $p_order){
            $order_query = Order::with(['productOrders'])->where('id',$p_order->order->id);
            $product_drafts = array();
            if(isset($request->predefine_date)){
                if($request->predefine_date == 0){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$date, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$date, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 1){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$yesterday, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$yesterday, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 2){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$sevendays, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$sevendays, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 3){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$oneMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$oneMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 4){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$twoMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$twoMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 5){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$threeMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$threeMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }
            }elseif(isset($request->start_date) && isset($request->end_date)){
                if(isset($accounts)){
                    $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$request->end_date, $request->start_date])->first();
                }else{
                    $product_drafts[] = $order_query->whereBetween('date_created',[$request->end_date, $request->start_date])->first();
                }
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }elseif(!isset($request->start_date) && !isset($request->end_date) && !isset($predefine_date) && isset($accounts)){
                $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->first();
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }else{
                $product_drafts[] = $order_query->first();
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }
//            echo '<pre>';
//            print_r($product_drafts);
            $all_value[] = $product_drafts;
        }
//        foreach ($all_value as $val){
//            echo '<pre>';
//            print_r($val);
//            print_r($sold);
//        }
//        exit();

        return view('reports.report_table', compact('all_value','sold', 'csv_predefine_date', 'csv_start_date', 'csv_end_date', 'csv_sku', 'csv_accounts'));
    }

    public function unsoldCatalogueSkuCsvDownload(Request $request){
        $date = date('Y-m-d');
        $today = date('Y-m-d', strtotime($date.' + 1 days'));
        $yesterday = date('Y-m-d', strtotime($date. ' - 1 days'));
        $sevendays = date('Y-m-d', strtotime($date. ' - 7 days'));
        $oneMonth = date('Y-m-d', strtotime($date. ' - 30 days'));
        $twoMonth = date('Y-m-d', strtotime($date. ' - 60 days'));
        $threeMonth = date('Y-m-d', strtotime($date. ' - 90 days'));
        $predefine_date = $request->predefine_date;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $sku = $request->sku;
        $accounts = $request->accounts;
        $account = (explode("/",$accounts));

        $find_sku  =  ProductVariation::where('sku','=',$sku)->get()->first();
        $variation_id = $find_sku->id;

        $product_order = ProductOrder::with(['Order'])->where('variation_id', $variation_id)->get();
        $sold = 0;
        $all_value = array();
        foreach ($product_order as $p_order){
            $order_query = Order::with(['productOrders'])->where('id',$p_order->order->id);
            $product_drafts = array();
            if(isset($request->predefine_date)){
                if($request->predefine_date == 0){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$date, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$date, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 1){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$yesterday, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$yesterday, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 2){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$sevendays, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$sevendays, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 3){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$oneMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$oneMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 4){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$twoMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$twoMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }elseif($request->predefine_date == 5){
                    if(isset($accounts)){
                        $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$threeMonth, $today])->first();
                    }else{
                        $product_drafts[] = $order_query->whereBetween('date_created',[$threeMonth, $today])->first();
                    }
                    if(isset($product_drafts[0]->productOrders[0])){
                        $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                    }
                }
            }elseif(isset($request->start_date) && isset($request->end_date)){
                if(isset($accounts)){
                    $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->whereBetween('date_created',[$request->end_date, $request->start_date])->first();
                }else{
                    $product_drafts[] = $order_query->whereBetween('date_created',[$request->end_date, $request->start_date])->first();
                }
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }elseif(!isset($request->start_date) && !isset($request->end_date) && !isset($predefine_date) && isset($accounts)){
                $product_drafts[] = $order_query->where('created_via', $account[0])->where('account_id', $account[1])->first();
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }else{
                $product_drafts[] = $order_query->first();
                if(isset($product_drafts[0]->productOrders[0])){
                    $sold+= $product_drafts[0]->productOrders[0]->pivot->quantity;
                }
            }
//            echo '<pre>';
//            print_r($product_drafts);
            $all_value[] = $product_drafts;
        }



        $filename = "catalogue_report.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Name','SKU','Variation ID','Catalogue ID','Order ID','Order Number','Order Date','Sold']);
        foreach($all_value as $key=> $product_draft){
            if(isset($product_draft[0]->productOrders[0])){
                $order_date = date('d-m-Y', strtotime($product_draft[0]->date_created));
                fputcsv($handle, [$product_draft[0]->productOrders[0]->pivot->name ?? '', $product_draft[0]->productOrders[0]->sku ?? '', $product_draft[0]->productOrders[0]->pivot->variation_id ?? '', $product_draft[0]->productOrders[0]->product_draft_id ?? '', $product_draft[0]->id ?? '', $product_draft[0]->order_number ?? '', $order_date ?? '', $product_draft[0]->productOrders[0]->pivot->quantity ?? '']);
            }
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return \response()->download($filename, 'SKU_sold.csv', $headers);
    }

    public function unsoldCatalogueReport(Request $request){
        // echo '<pre>';
        // print_r($request->all());
        // exit();
        // ->whereBetween('created_at',[$start_date,$end_date])
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        $settingData = $this->paginationSetting('catalogue');
        $setting = $settingData['setting'];
        $pagination = $settingData['pagination'];
        $woocommerceSiteUrl = WoocommerceAccount::first();
        $mainQuery = '';
        $start_date = date('Y-m-d h:i:s', strtotime($request->start_date));
        $end_date = date('Y-m-d h:i:s', strtotime($request->end_date));
        $unsold_start_date = date('Y-m-d h:i:s', strtotime($request->unsold_start_date));
        $unsold_end_date = date('Y-m-d h:i:s', strtotime($request->unsold_end_date));
        //dd($start_date);
        if(isset($request->start_date) && isset($request->end_date)){
            // $productDraftInfo = ProductDraft::select('product_drafts.id')->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
            // ->join('product_orders','product_variation.id','=','product_orders.variation_id')
            // ->join('orders','orders.id','=','product_orders.order_id')
            // ->groupBy('product_drafts.id')
            // //->groupBy('product_variation.product_draft_id')
            // //->whereNotBetween('orders.date_created',[$start_date,$end_date])
            // //->whereBetween('created_at',[$start_date,$end_date])
            // ->paginate(20);
            // echo '<pre>';
            // print_r(json_decode(json_encode($productDraftInfo)));
            // exit();
            // $mainQuery = ProductDraft::with(['ProductVariations'=> function($draft) use($start_date,$end_date){
            //     $draft->whereHas('getOnlyOrders',function ($orderData) use($start_date,$end_date){
            //         $orderData->whereHas('order',function($order) use($start_date,$end_date){
            //             $order->whereNotBetween('date_created',[$start_date,$end_date]);
            //         })->groupBy('order_id');
            //     });
            // }])->whereBetween('created_at',[$start_date,$end_date]);

            $mainQuery = ProductDraft::whereHas('ProductVariations', function($draft) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                $draft->whereHas('getOnlyOrders',function ($orderData) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                    $orderData->whereHas('order',function($order) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                        $order->whereBetween('date_created',[$unsold_start_date,$unsold_end_date]);
                    })->groupBy('order_id');
                });
            })->whereBetween('created_at',[$start_date,$end_date])->pluck('id')->toArray();
            // echo '<pre>';
            // print_r($mainQuery);
            // exit();

            // $mainQuery = ProductDraft::select('id')->with(['ProductVariations' => function($draft) use($start_date,$end_date){
            //     $draft->with(['getOnlyOrders'=> function ($orderData) use($start_date,$end_date){
            //         $orderData->whereHas('order',function($order) use($start_date,$end_date){
            //             $order->whereNotBetween('date_created',[$start_date,$end_date]);
            //         })->groupBy('order_id');
            //     }]);
            // }]);
            // ->where('id',7407)->first();

            // echo '<pre>';
            // print_r(json_decode(json_encode($mainQuery)));
            // exit();

            // $mainQuery = ProductDraft::doesntHave('ProductVariations.getOnlyOrders')->whereBetween('created_at',[$start_date,$end_date]);
        }else{
            $mainQuery = ProductDraft::doesntHave('ProductVariations.getOnlyOrders');
        }
        // echo '<pre>';
        // print_r(json_decode($mainQuery->get()));
        // // $query = $mainQuery->get();
        // // foreach($query as $qry){
        // //     echo '<pre>';
        // //     print_r($qry->ProductVariations);
        // // }
        // exit();

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
            }, 'variations' => function($query){
                $query->select(['id','product_draft_id','actual_quantity'])->with(['order_products' => function($query){
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
            ->withCount('ProductVariations')
            ->where('status','publish')->whereBetween('created_at',[$start_date,$end_date])->whereNotIn('id', $mainQuery)->paginate($pagination);
        $product_drafts_info = json_decode(json_encode($product_drafts));

        return view('reports.catalogue_report_table', compact('product_drafts','woocommerceSiteUrl','setting','pagination','product_drafts_info','url','start_date','end_date','unsold_start_date','unsold_end_date'));
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


    public function unsoldCatalogueCsvDownload(Request $request){
        $woocommerceSiteUrl = WoocommerceAccount::first();
        $mainQuery = '';
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $unsold_start_date = date('Y-m-d h:i:s', strtotime($request->unsold_start_date));
        $unsold_end_date = date('Y-m-d h:i:s', strtotime($request->unsold_end_date));
        if(isset($request->start_date) && isset($request->end_date)){
            // $mainQuery = ProductDraft::whereHas('ProductVariations', function($draft) use($start_date,$end_date){
            //     $draft->whereHas('getOnlyOrders',function ($orderData) use($start_date,$end_date){
            //         $orderData->whereHas('order',function($order) use($start_date,$end_date){
            //             $order->whereNotBetween('date_created',[$end_date,$start_date]);
            //         })->groupBy('order_id');
            //     });
            // })->whereBetween('created_at',[$start_date,$end_date]);
            $mainQuery = ProductDraft::whereHas('ProductVariations', function($draft) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                $draft->whereHas('getOnlyOrders',function ($orderData) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                    $orderData->whereHas('order',function($order) use($start_date,$end_date,$unsold_start_date,$unsold_end_date){
                        $order->whereBetween('date_created',[$unsold_start_date,$unsold_end_date]);
                    })->groupBy('order_id');
                });
            })->whereBetween('created_at',[$start_date,$end_date])->pluck('id')->toArray();
            // echo '<pre>';
            // print_r($unsold_start_date);
            // print_r($mainQuery);
            // exit();

        }else{
            $mainQuery = ProductDraft::doesntHave('ProductVariations.getOnlyOrders');
        }

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
            }, 'variations' => function($query){
                $query->select(['id','product_draft_id','actual_quantity'])->with(['order_products' => function($query){
                    $this->orderWithoutCancelAndReturn($query);
                    // $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }])
            ->withCount('ProductVariations')
            ->where('status','publish')->whereBetween('created_at',[$start_date,$end_date])->whereNotIn('id', $mainQuery)->get();

        $filename = "catalogue_report.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID','Product Type','Channel','Title','Category','RRP','Base Price','Cost Price','Sold','Stock','Product']);

        $channels_name = [];
        foreach($product_drafts as $key=> $product_draft){
            $channels_name = [];
            if(isset($product_draft)){
                if($product_draft->type == 'simple'){
                    $product_type = 'Simple';
                }else{
                    $product_type = 'Variation';
                }
                $data = 0;
                if(count($product_draft->variations) > 0){
                    foreach ($product_draft->variations as $variation){
                        if(isset($variation->order_products) && (count($variation->order_products) > 0)){
                            foreach($variation->order_products as $product){
                                $data += $product->sold;
                            }
                        }
                    }
                }

                foreach($product_draft->ebayCatalogueInfo as $catalogueInfo){
                    $channels_name[] = $catalogueInfo->AccountInfo->account_name;
                }
                if(isset($product_draft->woocommerce_catalogue_info)){
                    $channels_name[] = 'Woocommerce';
                }
                if(isset($product_draft->onbuy_product_info)){
                    $channels_name[] = 'OnBuy';
                }
                // if(isset($product_draft->onbuy_product_info)){
                //     $channels_name[] = 'OnBuy';
                // }
                if(isset($product_draft->amazonCatalogueInfo)){
                    foreach($product_draft->amazonCatalogueInfo as $amazon){
                        $channels_name[] = $amazon->applicationInfo->accountInfo->account_name;
                    }
                }
                $List = implode(', ', $channels_name);


                fputcsv($handle, [$product_draft->id ?? '', $product_type ?? '', $List ?? '', $product_draft->name ?? '', json_decode($product_draft)->woo_wms_category->category_name ?? '', $product_draft->rrp ?? '', $product_draft->base_price ?? '', $product_draft->cost_price ?? '', $data ?? 0, $product_draft->ProductVariations[0]->stock ?? 0, $product_draft->product_variations_count ?? 0]);

            }
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return \response()->download($filename, 'catalogue_report.csv', $headers);
    }

}
