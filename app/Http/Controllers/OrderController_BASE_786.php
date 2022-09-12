<?php

namespace App\Http\Controllers;

use App\CancelReason;
use App\Client;
use App\InvoiceSetting;
use App\DeveloperAccount;
use App\EbayAccount;
use App\EbayVariationProduct;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\Listeners\WoocomQuantityUpdateFired;
use App\OnbuyAccount;
use App\OnbuyVariationProducts;
use App\Order;
use App\OrderCancelReason;
use App\OrderNote;
use App\ProductDraft;
use App\ProductVariation;
use App\ReturnOrderProduct;
use App\ReturnReason;
use App\ShelfedProduct;
use App\User;
use App\Setting;
use App\Role;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use App\WoocommerceAccount;
use foo\bar;
//use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\ReturnOrder;
use App\ProductOrder;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Shelf;
use Arr;
use App\Traits\SearchOrder;
use App\Traits\StringConverter;
use PDF;
use App\amazon\AmazonAccountApplication;
use App\ReshelvedProduct;
use App\Traits\CommonFunction;


class OrderController extends Controller
{
    Use SearchOrder;
    use CommonFunction;
    public function __construct()
    {
        $this->middleware('auth');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
        $this->stringConverter = new StringConverter();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
                return redirect('/onbuy/master-product-list');
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




    public function clientInfo(){
        $shelfStatus = Session::get('shelf_use');
        if($shelfStatus != ''){
            return $shelfStatus;
        }else{
            $shelfInfo = Client::first();
            if($shelfInfo){
                Session::put('shelf_info',$shelfInfo->shelf_use);
                return $shelfInfo->shelf_use;
            }else{
                return 'not-use';
            }

        }
    }

    /*
      * Function : index
      * Route Type : order/list
      * Method Type : GET
      * Parameters : null
      * Creator : Mahfuzhur Rahman & Kazol Rajbongshi
      * Modifier : Solaiman Hosssain
      * Description : This function is used for Awaiting dispatch product list and pagination setting
      * Modified Date : 3-12-2020
      * Modified Content : Pagination setting
      */

      public function index(Request $request)
      {
          // $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';

          //Start page title and pagination setting
          $shelfUse = $this->shelf_use;
          $settingData = $this->paginationSetting('order','order_awaiting_dispatch');
          $setting = $settingData['setting'];
          $page_title = '';
          $pagination = $settingData['pagination'];
          //End page title and pagination setting

            $woocommerceSiteUrl = WoocommerceAccount::first();
            $wooChannel = WoocommerceAccount::get()->all();
            $onbuyChannel = OnbuyAccount::get()->all();
            $ebayChannel = EbayAccount::get()->all();
            $amazonChannel = AmazonAccountApplication::with(['accountInfo','marketPlace'])->get();

            $channels = array();
            $wooChannels = array();
            $onbuyChannels = array();
            $amazonChannels = array();
            $temp = array();
            $wooTemp = array();
            $onbuyTemp = array();
            $amazonTemp = array();
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
                    $amazonTemp[$amazon->id] = $amazon->application_name.'('.$amazon->accountInfo->account_name.' '.$amazon->marketPlace->marketplace.')';
                }
            }
            $channels["ebay"] = $temp;
            $wooChannels["checkout"] = $wooTemp;
            $onbuyChannels["onbuy"] = $onbuyTemp;
            $amazonChannels["amazon"] = $amazonTemp;

        //  echo "<pre>";
        //  print_r(array_merge($channels,$temp));
        //  exit();

  //        $args = array(
  //            'status' => 'processing',
  //        );cancelOrder
  //        echo "<pre>";
  //        print_r(Woocommerce::get('orders',$args));
  //        exit();

          $all_picker = Role::with(['users_list'])->where('id',3)->first();
          $all_pending_order = Order::with(['product_variations' => function($query){
              $query->with(['product_draft' => function($query_image){
                  $query_image->with('single_image_info');
              }]);
              $query->wherePivot('deleted_at','=', null)->withTrashed();
          },'order_note' => function($query){
              $query->select(['id','order_id','note']);
          },'account_ID:id,account_name,logo'
           //   'account_ID' => function($query){
         //       $query->select(['id','account_name','logo']);
          ])->whereIn('status',['processing'])
              ->where('picker_id',null);

              $isSearch = $request->get('is_search') ? true : false;
              $allCondition = [];
              if($isSearch){
                  $this->orderSearchCondition($all_pending_order, $request);
                  $allCondition = $this->orderConditionParams($request, $allCondition);
                //   dd($allCondition);
              }
              $all_pending_order = $all_pending_order->orderBy('date_created','DESC')->paginate($pagination)->appends($request->query());
            if($request->has('is_clear_filter')){
                $all_processing_order = $all_pending_order;
                $view = view('order.processing_order_general_search',compact('all_processing_order','shelfUse'))->render();
                return response()->json(['html' => $view]);
            }

          $total_pending_order = Order::where([['status','processing'],['picker_id',null]])->count();
          $distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
          $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
          $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
          $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
          $cancel_reasons = CancelReason::all();
//          echo "<pre>";
//          print_r(json_decode(json_encode($all_pending_order)));
//          exit();
          $all_pending_deocde_order = json_decode(json_encode($all_pending_order));

          $content = view('order.receive_order',compact('all_pending_order','all_picker','distinct_channel','distinct_currency','total_pending_order','all_pending_deocde_order','cancel_reasons', 'setting', 'page_title', 'pagination','shelfUse', 'distinct_payment', 'distinct_country', 'allCondition','woocommerceSiteUrl','channels', 'wooChannels', 'onbuyChannels','amazonChannels'));
          return view('master',compact('content'));
      }




    // public function allSearchConditionArr($value, $allCondition = null){
    //     if($value == 'condition'){
    //         $allCondition = $allCondition;
    //     }else{
    //         return $allCondition;
    //     }
    // }

    // public function optOutOperator($optVal){
    //     if($optVal == '>'){
    //         return '<';
    //     }
    //     elseif($optVal == '<'){
    //         return '>';
    //     }
    //     elseif($optVal == '='){
    //         return '!=';
    //     }
    //     elseif($optVal == '>='){
    //         return '<=';
    //     }
    //     elseif($optVal == '<='){
    //         return '>=';
    //     }
    // }


    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Creator : solaiman
    * Description : This function is used for pagination setting
    * Created Date : 3-12-2020
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
//                    dd($data['pagination']);
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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//    return 'order will create via webhook';
        $data = [
            'payment_method' => 'bacs',
            'payment_method_title' => 'Direct Bank Transfer',
            'shipping_total' => '10.00',
            'total' => '30.00',
//            'set_paid' => true,
            'status' => 'processing',
            'billing' => [
                'first_name' => 'Combosoft',
                'last_name' => 'user',
                'address_1' => 'Mirpur',
                'address_2' => '',
                'city' => 'Dhaka',
                'state' => 'DHK',
                'postcode' => '1212',
                'country' => 'BD',
                'email' => 'combosoft@example.com',
                'phone' => '123456789'
            ],
            'shipping' => [
                'first_name' => 'Test',
                'last_name' => 'Rahman',
                'address_1' => 'badda',
                'address_2' => '',
                'city' => 'Dhaka',
                'state' => 'DHK',
                'postcode' => '1212',
                'country' => 'BD'
            ],
            'line_items' => [
                [
                    'name' => 'Test product 2',
                    'product_id' => 21022,
                    'variation_id' => 21028,
                    'quantity' => 5
                ]
            ]
        ];
        Woocommerce::post('orders', $data);
        return 'order placed';
        $all_pending_order = Order::all();
        $content = view('order.receive_order',compact('all_pending_order'));
        return view('master',compact('content'));
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

    public function orderCreateWebhooks(Request $request)
    {
        $signature = $request->header('x-wc-webhook-signature');

        $payload = $request->getContent();
        $calculated_hmac = base64_encode(hash_hmac('sha256', $payload, env('WOOCOMMERCE_WEBHOOK_ORDER_CREATED'), true));

        if($signature != $calculated_hmac) {
            logger('secret key mismatch');
            return false;
        }
        logger('found');
        logger($request->all());

        // $all_order = Woocommerce::get('orders');
        $all_order = $request->all();
        $order = json_decode(json_encode($all_order));

        $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : '.$order->shipping->first_name.' '.$order->shipping->last_name.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Company  </h7></div><div class="content-right"><h7> : '.$order->shipping->company.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : '.$order->shipping->address_1.','.$order->shipping->address_2.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : '.$order->shipping->city.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : '.$order->shipping->state.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : '.$order->shipping->postcode.'</h7></div></div>';
        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : '.$order->shipping->country.'</h7></div></div>';
//        $shipping .= 'Company : '.$order->shipping->company.'</br>';
//        $shipping .= 'Address : '.$order->shipping->address_1.','.$order->shipping->address_2.'</br>';
//        $shipping .= 'City : '.$order->shipping->city.'</br>';
//        $shipping .= 'State : '.$order->shipping->state.'</br>';
//        $shipping .= 'Postcode : '.$order->shipping->postcode.'</br>';
//        $shipping .= 'Country : '.$order->shipping->country.'</br>';

        $data = Order::create([
            'id' => $order->id,
            'order_number' => $order->number,
            'status' => $order->status,
            'created_via' => $order->created_via,
            'currency' => $order->currency,
            'total_price' => $order->total,
            'customer_id' => $order->customer_id,
            'customer_name' => $order->billing->first_name.' '.$order->billing->last_name,
            'customer_email' => $order->billing->email,
            'customer_phone' => $order->billing->phone,
            'customer_country' => $order->billing->country,
            'customer_city' => $order->billing->city,
            'customer_zip_code' => $order->billing->postcode,
            'customer_state' => $order->billing->state,
            'shipping' => $shipping,
            'payment_method' => $order->payment_method,
            'date_created' => $order->date_created
        ]);

        $single_order = Order::find(json_decode($data->id));

        $count = 1;
        foreach ($order->line_items as $product){
            $datas['variation_id'] = $product->variation_id;
            $datas['name'] = $product->name;
            $datas['quantity'] = $product->quantity;
            $datas['price'] = $product->price;
            $datas['status'] = 0;
            $single_order->product_variations()->attach($single_order->id,$datas);
            $count++;
        }

    }

    public function assignPicker(Request $request){

//        $validation = $request->validate([
//            'picker_id' => 'required',
//            'multiple_order' => 'required'
//        ]);

        $assigner_id = Auth::user()->id;
        $picker_id = $request->picker_id;
        $order_id = $request->multiple_order;
        $order_assign = Order::whereIn('id',$order_id)->update([
            'status' => 'processing',
            'picker_id' => $picker_id,
            'assigner_id' => $assigner_id
        ]);

        return response()->json($order_assign);

//        return redirect('order/list')->with('assign_success_msg','Orders assigned successfully');
//        return back()->with('assign_success_msg','Orders assigned successfully');
    }

    public function OrderSearch(Request $request){
//        $validation = $request->validate([
//            'search' => 'required|max:100',
//            'chek_value' => 'required'
//        ]);

        $shelfUse = $this->shelf_use;
        $distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $distinct_status = Order::distinct()->get(['status'])->where('status', '!=', null);
        $distinct_return_reason = ReturnOrder::distinct()->get(['return_reason'])->where('return_reason', '!=', null);
        $users = User::all();
        $search_column = $request->get('column_name');
        $search_value = $request->get('search_value');
        $field = $request->chek_value;
        $search = $request->search;


        if ($request->status == 'processing'){

            $all_picker = Role::with(['users_list'])->where('id', 3)->first();
            $all_pending_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
            }])->where([['status', 'processing'], ['picker_id', null]])->where(function ($query) use ($request, $field, $search) {
                for ($i = 0; $i < count($field); $i++) {
                    if ($field[$i] == 'date_created'){
                        if($request->opt_out == 1){
                            $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->search))]);
                        }else{
                            $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->search))]);
                        }

                    }elseif($field[$i] == 'total_product'){
                        $order_ids = Order::select('orders.id',DB::raw('count(product_orders.id) as product_count'))
                            ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                            ->where('orders.status','processing')
                            ->where('orders.picker_id','=',null)
                            ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search)
                            ->groupBy('orders.id')
                            ->get();
                        $ids_arr = [];
                        foreach ($order_ids as $order_id){
                            array_push($ids_arr,$order_id->id);
                        }
                        if($request->opt_out == 1){
                            $query->whereNotIn('id', $ids_arr);
                        }else{
                            $query->whereIn('id', $ids_arr);
                        }

                    }elseif($field[$i] == 'total_price'){
                        if($request->opt_out == 1){
                            $query->where('total_price', '!=', $request->search);
                        }else{
                            $query->where('total_price', $request->filter_option, $request->search);
                        }
                    }elseif($field[$i] == 'shipping_post_code'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }elseif($field[$i] == 'payment_method'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'LIKE', '%' . $request->search . '%');
                        }
                    }else {
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }

                    }

                }

                // If user submit with empty data then this message will display table's upstairs
                if($search == ''){
                    return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                }

            })
                ->orderBy('date_created','DESC')
                ->paginate(500);



            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($all_pending_order) > 0){
                foreach ($all_pending_order as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/order/list')->with('message','No data found');
            }


            $all_pending_deocde_order = json_decode(json_encode($all_pending_order));
            $cancel_reasons = CancelReason::all();
            $content = view('order.receive_order',compact('all_pending_order','all_picker','distinct_channel','distinct_currency','all_pending_deocde_order','cancel_reasons','shelfUse','distinct_payment','distinct_country','search'));
            return view('master',compact('content'));

        }elseif($request->status == 'completed'){
            $total_completed_order = Order::where('status','completed')->count();
            $all_completed_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
            },'picker_info','packer_info','assigner_info'])->where([['status', 'completed']])->where(function ($query) use ($request, $field, $search) {
                for ($i = 0; $i < count($field); $i++) {
                    if ($field[$i] == 'date_created'){
                        if($request->opt_out == 1){
                            $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->search))]);
                        }else{
                            $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->search))]);
                        }

                    }elseif($field[$i] == 'total_product'){
                        $order_ids = Order::select('orders.id',DB::raw('count(product_orders.id) as product_count'))
                            ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                            ->where('orders.status','completed')
                            ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search)
                            ->groupBy('orders.id')
                            ->get();
                        $ids_arr = [];
                        foreach ($order_ids as $order_id){
                            array_push($ids_arr,$order_id->id);
                        }
                        if($request->opt_out == 1){
                            $query->whereNotIn('id', $ids_arr);
                        }else{
                            $query->whereIn('id', $ids_arr);
                        }

                    }elseif($field[$i] == 'total_price'){
                        if($request->opt_out == 1){
                            $query->where('total_price', '!=', $request->search);
                        }else{
                            $query->where('total_price', $request->filter_option, $request->search);
                        }
                    }
                    elseif($field[$i] == 'picker_id' || $field[$i] == 'packer_id' || $field[$i] == 'assigner_id'){
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i],$request->search);
                        }
                    }elseif($field[$i] == 'shipping_post_code'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }
                    elseif($field[$i] == 'shipping_post_code'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }
                    else {
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }
                }

                // If user submit with empty data then this message will display table's upstairs
                if($search == ''){
                    return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                }

            })
                ->orderBy('date_created','DESC')
                ->paginate(500);


           // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($all_completed_order) > 0){
                foreach ($all_completed_order as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/completed/order/list')->with('message','No data found');
            }


            $all_completed_order_info = json_decode(json_encode($all_completed_order));
            $content = view('order.completed_order_list',compact('all_completed_order','all_completed_order_info','distinct_channel','distinct_currency','users','shelfUse','distinct_payment','distinct_country','search'));
            return view('master',compact('content'));
        }
        elseif($request->status == 'assigned'){

            $all_assigned_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
            },'picker_info','assigner_info'])->where([['status', 'processing'],['picker_id','!=',null],['assigner_id','!=',null]])->where(function ($query) use ($request, $field, $search) {
                for ($i = 0; $i < count($field); $i++) {
                    if ($field[$i] == 'date_created'){
                        if($request->opt_out == 1){
                            $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->search))]);
                        }else{
                            $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->search))]);
                        }

                    }elseif($field[$i] == 'total_product'){
                        $order_ids = Order::select('orders.id',DB::raw('count(product_orders.id) as product_count'))
                            ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                            ->where('orders.status','processing')
                            ->where('orders.picker_id','!=',null)
                            ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search)
                            ->groupBy('orders.id')
                            ->get();

                        $ids_arr = [];
                        foreach ($order_ids as $order_id){
                            array_push($ids_arr,$order_id->id);
                        }
                        if($request->opt_out == 1){
                            $query->whereNotIn('id', $ids_arr);
                        }else{
                            $query->whereIn('id', $ids_arr);
                        }

                    }elseif($field[$i] == 'id'){
                        $all_assigned_order = Order::select('orders.id')
                            ->join('product_orders', 'orders.id', '=', 'product_orders.order_id')
                            ->where('orders.status', 'processing')
                            ->where('orders.picker_id','!=',null)
                            ->where('product_orders.status', 'Like', '%' . $request->search . '%')
                            ->groupBy('orders.id')
                            ->get();

                        $ids_arr = [];
                        foreach ($all_assigned_order as $order_status){
                            $ids_arr[] = $order_status->id;
                        }
                        if($request->search == 1){
                            $query->whereIn('id', $ids_arr);
                        }
                        elseif($request->search == 0){
                            $query->whereIn('id', $ids_arr);
                        }

                    }elseif($field[$i] == 'total_price'){
                        if($request->opt_out == 1){
                            $query->where('total_price', '!=', $request->search);
                        }else{
                            $query->where('total_price', $request->filter_option, $request->search);
                        }

                    }elseif($field[$i] == 'picker_id'){
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i],$request->search);
                        }

                    }elseif($field[$i] == 'assigner_id'){
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i],$request->search);
                        }

                    }elseif($field[$i] == 'shipping_post_code'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }

                    }else {
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }
                }

                // If user submit with empty data then this message will display table's upstairs
                if($search == ''){
                    return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                }

            })
                ->orderBy('date_created','DESC')
                ->paginate(500);

           // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($all_assigned_order) > 0){
                foreach ($all_assigned_order as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/assigned/order/list')->with('message','No data found');
            }


            $total_assigned_order = Order::where([['status', 'processing'], ['picker_id', Auth::user()->id], ['assigner_id', '!=', null]])->count();
            $all_decode_assigned_order = json_decode(json_encode($all_assigned_order));
            $cancel_reasons = CancelReason::all();
            $content = view('order.assigned_order_list',compact('all_assigned_order','all_decode_assigned_order','total_assigned_order','distinct_channel','distinct_currency','users','cancel_reasons','distinct_payment','distinct_country','search'));
            return view('master',compact('content'));

        }elseif($request->status == 'rest-api'){
            $all_picker = Role::with(['users_list'])->where('id', 3)->first();
            $all_manual_order = Order::with(['product_variations'])->where([['status','processing'],['created_via','rest-api']])->where(function ($query) use ($request, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->search . '%');
                }
            })->get();
            $all_manual_order = json_decode(json_encode($all_manual_order));
            $content = view('order.manual_order_list',compact('all_manual_order','all_picker'));
            return view('master',compact('content'));

        }elseif ($request->status == 'on-hold'){
            $all_picker = Role::with(['users_list'])->where('id', 3)->first();
            $all_hold_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
            }])->where([['status', 'on-hold']])->where(function ($query) use ($request, $field, $search) {
                for ($i = 0; $i < count($field); $i++) {
                    if ($field[$i] == 'date_created'){
                        if($request->opt_out == 1){
                            $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->search))]);
                        }else{
                            $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->search))]);
                        }
                    }elseif($field[$i] == 'total_product'){
                        $order_ids = Order::select('orders.id',DB::raw('count(product_orders.id) as product_count'))
                            ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                            ->where('orders.status','on-hold')
                            ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search)
                            ->groupBy('orders.id')
                            ->get();
                        $ids_arr = [];
                        foreach ($order_ids as $order_id){
                            array_push($ids_arr,$order_id->id);
                        }
                        if($request->opt_out == 1){
                            $query->whereNotIn('id', $ids_arr);
                        }else{
                            $query->whereIn('id', $ids_arr);
                        }

                    }elseif($field[$i] == 'total_price'){
                        if($request->opt_out == 1){
                            $query->where('total_price', '!=', $request->search);
                        }else{
                            $query->where('total_price', $request->filter_option, $request->search);
                        }
                    }
                    elseif($field[$i] == 'shipping_post_code'){
                        if($request->opt_out == 1){
                            $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }else {
                        if($request->opt_out == 1){
                            $query->where($field[$i],'!=',$request->search);
                        }else{
                            $query->where($field[$i], 'like', '%' . $request->search . '%');
                        }
                    }
                }

                // If user submit with empty data then this message will display table's upstairs
                if($search == ''){
                    return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                }

            })

                ->orderBy('date_created','DESC')
                ->paginate(500);

            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($all_hold_order) > 0){
                foreach ($all_hold_order as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/hold/order/list')->with('message','No data found');
            }


            $all_decode_hold_order = json_decode(json_encode($all_hold_order));
            $cancel_reasons = CancelReason::all();
            $content = view('order.hold_order_list',compact('all_hold_order','all_picker','all_decode_hold_order','distinct_channel','distinct_currency','cancel_reasons','distinct_payment','distinct_country','shelfUse','distinct_status','search'));
            return view('master',compact('content'));

        }elseif($request->status == 'cancelled'){
            $cancel_reasons = CancelReason::all();
            $cancelledOrderList = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
            } ,'picker_info','packer_info','assigner_info','cancelled_by_user','order_note' => function($query){
                $query->select(['id','order_id','note']);
            },'orderCancelReason'])->where([['status','cancelled']])->where(function ($query) use ($request,$search_column,$search_value){
                if($search_column == 'date_created'){
                    if($request->opt_out == 1){
                        $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->get('search_value')))]);
                    }else{
                        $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->get('search_value')))]);
                    }
                }elseif($search_column == 'total_price'){
                    if($request->opt_out == 1){
                        $query->where('total_price', '!=', $request->search_value);
                    }else{
                        $query->where('total_price', $request->filter_option, $request->search_value);
                    }

                }elseif($search_column == 'id'){
                    $cancelled_reason = Order::select('orders.id')
                        ->leftJoin('order_cancel_reasons', 'orders.id', '=', 'order_cancel_reasons.order_id')
                        ->where('orders.status', 'cancelled')
                        ->where('order_cancel_reasons.order_cancel_id', 'LIKE', '%' . $request->search_value . '%')
                        ->groupBy('orders.id')
                        ->get();

                    $ids = [];
                    foreach ($cancelled_reason as $reason) {
                    $ids[] = $reason->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }

                }elseif($search_column == 'total_product'){
                    $order_total_product = Order::select('orders.id',DB::raw('count(product_orders.id) as product_count'))
                        ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                        ->where('orders.status','cancelled')
                        ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search_value)
                        ->groupBy('orders.id')
                        ->get();
                    $ids_arr = [];
                    foreach ($order_total_product as $order_id){
                        $ids_arr[] = $order_id->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id', $ids_arr);
                    }else{
                        $query->whereIn('id', $ids_arr);
                    }

                }elseif($search_column == 'cancelled_by'){
                    if($request->opt_out == 1){
                        $query->where($search_column, '!=', $request->search_value);
                    }else{
                        $query->where($search_column, $request->search_value);
                    }

                }else {
                    if($request->opt_out == 1){
                        $query->where($search_column,'!=',$request->get('search_value'));
                    }else{
                        $query->where($search_column, 'like', '%' . $request->get('search_value') . '%');
                    }
                }

                // If user submit with empty data then this message will display table's upstairs
                if($search_value == ''){
                    return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                }

            })
                ->orderByDesc('date_created')
                ->paginate(500);

            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($cancelledOrderList) > 0){
                foreach ($cancelledOrderList as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/cancelled/order/list')->with('message','No data found');
            }

            $all_cancelledOrderList = json_decode(json_encode($cancelledOrderList));
            $content = view('order.cancelled_order_list',compact('cancelledOrderList','all_cancelledOrderList','shelfUse','search_column', 'search_value','distinct_channel','distinct_currency','distinct_payment','distinct_country','cancel_reasons'));
            return view('master',compact('content'));

        }elseif($request->status == 'return'){
//            $all_return_order = ReturnOrder::with(['return_product_save' => function($query){
//                $query->with(['product_draft' => function($image_query){
//                    $image_query->with('single_image_info');
//                }]);
//            },'orders','order_note' => function($query){
//                $query->select(['id','order_id','note']);
//            }])
//                ->orderByDesc('id')->paginate(50);
//            $total_return_order = ReturnOrder::count();
//            $return_reason = ReturnReason::orderByDesc('id')->get();
//            $all_decode_return_product = json_decode(json_encode($all_return_order));
            $field = $request->chek_value;
            $query_result = ReturnOrder::select('return_orders.id')
                ->join('orders','return_orders.order_id','=','orders.id')
                ->join('product_orders','orders.id','=','product_orders.order_id')
                ->join('product_variation','product_orders.variation_id','=','product_variation.id')
                ->where(function ($query) use ($field,$request,$search){
                    for ($i = 0; $i < count($field); $i++) {
                        if ($field[$i] == 'date_created'){
                            if($request->opt_out == 1){
                                $query->whereRaw('DATE(date_created) != ?',[date('Y-m-d',strtotime($request->search))]);
                            }else{
                                $query->whereRaw('DATE(date_created) = ?',[date('Y-m-d',strtotime($request->search))]);
                            }
                        }elseif ($field[$i] == 'created_at'){
                            if($request->opt_out == 1){
                                $query->whereRaw('DATE(return_orders.created_at) != ?',[date('Y-m-d',strtotime($request->search))]);
                            }else{
                                $query->whereRaw('DATE(return_orders.created_at) = ?',[date('Y-m-d',strtotime($request->search))]);
                            }
                        }elseif($field[$i] == 'returned_by'){
                            if($request->opt_out == 1){
                                $query->where($field[$i],'!=',$request->search);
                            }else{
                                $query->where($field[$i],$request->search);
                            }
                        }elseif($field[$i] == 'total_product'){
                            $order_ids = ReturnOrder::select('return_orders.id',DB::raw('count(product_orders.id) as product_count'))
                                ->join('orders','return_orders.order_id','=','orders.id')
                                ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                                ->where('orders.status','completed')
                                ->havingRaw('count(product_orders.id) '.$request->filter_option.' '.$request->search)
                                ->groupBy('return_orders.id')
                                ->get();
//                            echo '<pre>';
//                            print_r(json_decode($order_ids));
//                            exit();
                            $ids_arr = [];
                            foreach ($order_ids as $order_id){
                                array_push($ids_arr,$order_id->id);
                            }
                            if($request->opt_out == 1){
                                $query->whereNotIn('return_orders.id', $ids_arr);
                            }else{
                                $query->whereIn('return_orders.id', $ids_arr);
                            }

                        }elseif($field[$i] == 'total_price'){
                            if($request->opt_out == 1){
                                $query->where('orders.total_price', '!=', $request->search);
                            }else{
                                $query->where('orders.total_price', $request->filter_option, $request->search);
                            }
                        }
                        elseif($field[$i] == 'picker_id' || $field[$i] == 'packer_id' || $field[$i] == 'assigner_id'){
                            if($request->opt_out == 1){
                                $query->where($field[$i],'!=',$request->search);
                            }else{
                                $query->where($field[$i],$request->search);
                            }
                        }
                        elseif($field[$i] == 'return_reason'){
                            if($request->opt_out == 1){
                                $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                            }else{
                                $query->where($field[$i], 'like', '%' . $request->search . '%');
                            }
                        }
                        elseif($field[$i] == 'return_cost'){
                            if($request->opt_out == 1){
                                $query->where('return_orders.return_cost', '!=', $request->search);
                            }else{
                                $query->where('return_orders.return_cost', $request->filter_option, $request->search);
                            }
                        }
                        elseif($field[$i] == 'shipping_post_code'){
                            if($request->opt_out == 1){
                                $query->where($field[$i], 'NOT LIKE', '%' . $request->search . '%');
                            }else{
                                $query->where($field[$i], 'like', '%' . $request->search . '%');
                            }
                        }
                        else {
                            if($request->opt_out == 1){
                                $query->where($field[$i],'!=',$request->search);
                            }else{
                                $query->where($field[$i], 'like', '%' . $request->search . '%');
                            }
                        }
                    }

                    // If user submit with empty data then this message will display table's upstairs
                    if($search == ''){
                        return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
                    }

                })

                ->where('orders.status','completed')
                ->groupBy('return_orders.id')
                ->get();
//            echo '<pre>';
//            print_r(json_decode($query_result));
//            exit();

            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $order_ids = [];
            if(count($query_result) > 0){
                foreach ($query_result as $result){
                    $order_ids[] = $result->id;
                }
            }else{
                return redirect('/return/order/list')->with('message','No data found');
            }

//            return response()->json(['data' => $order_ids]);
            $all_return_order = [];
            if(count($order_ids) > 0) {
                $all_return_order = ReturnOrder::with(['return_product_save' => function ($query) {
                    $query->with(['product_draft' => function ($image_query) {
                        $image_query->with('single_image_info');
                    }]);
                }, 'orders', 'returned_by_user', 'order_note' => function ($query) {
                    $query->select(['id', 'order_id', 'note']);
                }])->orderByDesc('id')
                    ->whereIn('id',$order_ids)
                    ->paginate(500);
            }
            $total_return_order = ReturnOrder::count();
            $return_reason = ReturnReason::orderByDesc('id')->get();
            $all_decode_return_product = json_decode(json_encode($all_return_order));
//        echo "<pre>";
//        print_r($all_decode_return_product);
//        exit();
            $content = view('order.return_order_list',compact('all_return_order','return_reason','all_decode_return_product','total_return_order','distinct_channel','distinct_currency','users','distinct_payment','distinct_country','distinct_return_reason','search'));
            return view('master',compact('content'));
        }
    }



    /*
    * Function : completedOrderList
    * Route Type : completed/order/list
    * Method Type : GET
    * Parameters : null
    * Creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for Dispatched Order list and pagination setting
    * Modified Date : 5-12-2020
    * Modified Content : Pagination setting
    */


    public function completedOrderList(Request $request)
    {
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        //Start page title and pagination setting
        $shelfUse = $this->shelf_use;
        $settingData = $this->paginationSetting('order','completed_order');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


        $all_completed_order = Order::with(['product_variations' => function($query){
            $query->with(['product_draft' => function($query_image){
                $query_image->with('single_image_info');
            }])->withTrashed();
            $query->wherePivot('deleted_at','=', null)->withTrashed();
        } ,'picker_info','packer_info','assigner_info','order_note' => function($query){
            $query->select(['id','order_id','note']);
        }])->where([['status','completed']]);
        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->orderSearchCondition($all_completed_order, $request);
            $allCondition = $this->orderConditionParams($request, $allCondition);
        }
        $all_completed_order = $all_completed_order->orderByDesc('date_created')->paginate($pagination)->appends($request->query());
        if($request->has('is_clear_filter')){
            $all_completed_order = $all_completed_order;
            $view = view('order.completed_order_general_search',compact('all_completed_order','shelfUse'))->render();
            return response()->json(['html' => $view]);
        }
        $allChannels = $this->allChannels();
        //$distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $users = User::all();
        $all_completed_order_info = json_decode(json_encode($all_completed_order));
        $content = view('order.completed_order_list',compact('all_completed_order','all_completed_order_info','allChannels','distinct_currency','users','setting','page_title','pagination','shelfUse','distinct_payment','distinct_country','allCondition','url'));
        return view('master',compact('content'));
    }

    public function completeOrderCsvDownload(Request $request){

        if ($request->start_date != $request->end_date){

            $result = Order::with(['productOrders'])->whereDate('created_at','>=',$request->start_date )->whereDate('created_at','<=',$request->end_date)->where('status' , 'completed')->get();
        }
        elseif ($request->start_date == $request->end_date ){
            $result = Order::with(['productOrders'])->whereDate('created_at',$request->start_date)->where('status' , 'completed')->get();
        }


        $filename = "tweets.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ORDER NUMBER','ORDER DATE','PRODUCT TITLE',' COUNTRY',  'CHANNEL', 'SKU','QUANTITY','SALE PRICE','TOTAL PRICE','COST PRICE', 'STATUS'));

        foreach($result as $row) {
            $index = 1;
            $lastIndex = sizeof($row->product_variations);
            foreach ($row->product_variations as $row2){
                //$temp_order = $row['order_number'];
                if ($index == $lastIndex){
                    fputcsv($handle, array($row['order_number'],$row['date_created'],$row2['pivot']->name,
                        $row['customer_country'], $row['created_via'], $row2['sku'],
                        $row2->pivot['quantity'],
                        $row2->pivot['price'],$row['total_price'],  $row2['cost_price'] * $row2->pivot['quantity'],$row['status']));
                }else{
                    fputcsv($handle, array($row['order_number'],$row['date_created'],$row2['pivot']->name,
                        $row['customer_country'], $row['created_via'], $row2['sku'],
                        $row2->pivot['quantity'],
                        $row2->pivot['price'],'',  $row2['cost_price'] * $row2->pivot['quantity'],$row['status']));
                }


                $index++;
            }

        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return \response()->download($filename, 'tweets.csv', $headers);
        // $result = json_decode(json_encode($result));
        //return $result;
    }

    public function chooseReturnProduct($id){
        $single_order_product = Order::with(['product_variations'])->find($id);
        $return_reason = ReturnReason::orderByDesc('id')->get();
        $content = view('order.choose_return_product',compact('single_order_product','return_reason'));
        return view('master',compact('content'));
    }

    /*
     * Function : assignedOrderList
     * Route Type : assigned/order/list
     * Method Type : GET
     * Parameters : null
     * Creator : Unknown
     * Modifier : Solaiman
     * Description : This function is used for Assigned order list and pagination setting
     * Modified Date : 5-12-2020
     * Modified Content : Pagination setting
     */

    public function assignedOrderList(Request $request)
    {
        // $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        $shelfUse = $this->shelf_use;
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('order', 'assigned_order');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting
        $pickerInfo = Role::with(['users_list'])->where('id',3)->first();


        if(Auth::check() && in_array('1',explode(',',Auth::user()->role))) {
            $all_assigned_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
                $query->wherePivot('deleted_at','=', null)->withTrashed();
            }, 'picker_info', 'assigner_info','order_note' => function($query){
                $query->select(['id','order_id','note']);
            }])->where('status','processing')->where('picker_id','!=',null)->where('assigner_id','!=',null);
            // ->where([['status', 'processing'], ['picker_id', '!=', null], ['assigner_id', '!=', null]]);

            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->orderSearchCondition($all_assigned_order, $request);
                $allCondition = $this->orderConditionParams($request, $allCondition);
                //dd($allCondition);
            }
            $all_assigned_order = $all_assigned_order->orderByDesc('date_created')->paginate($pagination)->appends($request->query());

            $total_assigned_order = Order::where([['status', 'processing'], ['picker_id','!=',null], ['assigner_id', '!=', null]])->count();
        }else{
            $all_assigned_order = Order::with(['product_variations' => function($query){
                $query->wherePivot('deleted_at','=', null)->withTrashed();
                $query->withTrashed();
            }, 'picker_info', 'assigner_info','order_note' => function($query){
                $query->select(['id','order_id','note']);
            }])->where([['status', 'processing'], ['picker_id', Auth::user()->id], ['assigner_id', '!=', null]]);

            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->orderSearchCondition($all_assigned_order, $request);
                $allCondition = $this->orderConditionParams($request, $allCondition);
                //dd($allCondition);
            }
            $all_assigned_order = $all_assigned_order->orderByDesc('date_created')->paginate($pagination)->appends($request->query());

            $total_assigned_order = Order::where([['status', 'processing'], ['picker_id', Auth::user()->id], ['assigner_id', '!=', null]])->count();
        }
        if($request->has('is_clear_filter')){
            $all_assigned_order = $all_assigned_order;
            $view = view('order.assigned_order_general_search',compact('all_assigned_order','shelfUse'))->render();
            return response()->json(['html' => $view]);
        }
        $users = User::all();
        $allChannels = $this->allChannels();
        //$distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $all_decode_assigned_order = json_decode(json_encode($all_assigned_order));
        $cancel_reasons = CancelReason::all();
        $content = view('order.assigned_order_list',compact('all_assigned_order','total_assigned_order','all_decode_assigned_order','allChannels','distinct_currency','users','cancel_reasons','setting','page_title','pagination','distinct_payment','distinct_country', 'allCondition','pickerInfo'));
        return view('master',compact('content'));
    }

    public function saveReturnOrder(Request $request){

        $validation = $request->validate([
            'return_product_info' => 'required',
            'return_reasone' => 'required'
//            'return_cost' => 'required'
        ]);

        $return_order_info = ReturnOrder::create([
            'order_id' => $request->return_order,
            'returned_by' => Auth::id(),
            'return_reason' => $request->return_reasone,
            'return_cost' => $request->return_cost ?? 0
        ]);
        $return_order = ReturnOrder::find(json_decode($return_order_info->id));
        foreach ($request->return_product_info as $return_product){
            if(isset($return_product['product_id'])) {
                $datas['variation_id'] = $return_product['product_id'];
                $datas['product_name'] = $return_product['product_name'] ?? 'Not found';
                $datas['return_product_quantity'] = $return_product['return_quantity'] ?? 0;
                $datas['price'] = $return_product['product_price'] ?? 0;
                $datas['status'] = 0;
                $return_order->return_product_save()->attach($return_order->id, $datas);
            }
        }
        return back()->with('return_order_success_msg','Return product added successfully');
    }


    /*
    * Function : returnOrderList
    * Route Type : return/order/list
    * Method Type : GET
    * Parameters : null
    * Creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for Return Order List and pagination setting
    * Modified Date : 5-12-2020
    * Modified Content : Pagination setting
    */


    public function returnOrderList(Request $request)
    {
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('order','return_order');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

        $allChannels = $this->allChannels();
        //$distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $distinct_return_reason = ReturnOrder::distinct()->get(['return_reason'])->where('return_reason', '!=', null);
        $users = User::all();
        $all_return_order = ReturnOrder::with(['return_product_save' => function($query){
            $query->with(['product_draft' => function($image_query){
                $image_query->with('single_image_info');
            }])->withTrashed();
            $query->wherePivot('deleted_at','=', null)->withTrashed();
        },'orders', 'returned_by_user', 'order_note' => function($query){
            $query->select(['id','order_id','note']);
        }]);
        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->returnOrderSearchCondition($all_return_order, $request);
            $allCondition = $this->orderConditionParams($request, $allCondition);
        }
        $all_return_order = $all_return_order->orderByDesc('created_at')->paginate($pagination)->appends($request->query());
        if($request->has('is_clear_filter')){
            $all_return_order = $all_return_order;
            $view = view('order.cancelled_order_general_search',compact('all_return_order','shelfUse'))->render();
            return response()->json(['html' => $view]);
        }
        $total_return_order = ReturnOrder::count();
        $return_reason = ReturnReason::orderByDesc('id')->get();
        $all_decode_return_product = json_decode(json_encode($all_return_order));
//        echo "<pre>";
//        print_r($all_decode_return_product);
//        exit();
        $content = view('order.return_order_list',compact('all_return_order','return_reason','all_decode_return_product','total_return_order','allChannels','distinct_currency','users','setting', 'page_title','pagination','distinct_payment','distinct_country','distinct_return_reason','url','allCondition'));
        return view('master',compact('content'));
    }


    public function getReturnOrderProductSKU(Request $request){
        if ($request->id != null){
            $all_return_product_sku = ReturnOrder::with(['is_return_product_shelved'])->where('order_id',$request->id)->first();
        }else{
            $all_return_product_sku = ProductVariation::get()->all();
        }
        $all_shelver = Role::with(['users_list'])->where('id',4)->first();
        $id_value = $request->id;
//        echo $all_return_product_sku;
        $not_in_invoice_sku = view('order.get_return_product_sku_ajax',compact('all_return_product_sku','id_value','all_shelver'));
        return $not_in_invoice_sku ;
    }

//    public function pickedOrderList(){
//        $all_pending_order = Order::with(['product_variations'])->where([['status','processing'],['picker_id',!null]])->get();
//        $all_pending_order = json_decode(json_encode($all_pending_order));
//        return response()->json($all_pending_order);
////        $content = view('order.receive_order',compact('all_pending_order','all_picker'));
////        return view('master',compact('content'));
//    }

    public function manualOrder($orderId = null, $orderType = null)
    {
        $decodeExchanegableOrderInfo = null;
        if($orderId){
            $exchanegableOrderInfo = Order::find($orderId);
            $decodeExchanegableOrderInfo = json_decode($exchanegableOrderInfo);
//            echo '<pre>';
//            print_r(json_decode($exchanegableOrderInfo));
//            exit();
        }
//        $all_product_draft = ProductDraft::all();
        $all_product_sku = ProductVariation::orderBy('id','desc')->get();
//        echo "<pre>";
//        print_r(json_decode(json_encode($all_product_sku)));
//        exit();
        $content = view('order.manual_order',compact('all_product_sku','orderId','decodeExchanegableOrderInfo','orderType'));
        return view('master',compact('content'));
    }


    public function getAllVariationByProductDraftAjax(Request $request){
        $all_variation = ProductVariation::where('product_draft_id',$request->id)->get();
        return view('order.variation_by_product_draft_ajax',compact('all_variation'));
    }

    public function manualOrderSaveAjax(Request $request)
    {   
        // dd($request->all());
        try {
            $order_number = mt_rand(100000, 999999);
            while(true){
                $exist_order = Order::find($order_number);
                if(!$exist_order){
                    break;
                }
                $order_number = mt_rand(100000, 999999);
            }
            $misMatchQuantity = [];
            foreach ($request->sku as $key => $value){
                $variation_info = ProductVariation::where('sku',$value)->first();
                if(($variation_info->actual_quantity <= 0) || (($variation_info->actual_quantity - $request->quantity[$key]) < 0) || $request->quantity[$key] <= 0) {
                    $misMatchQuantity[] = $value;
                }
            }
            if(count($misMatchQuantity) > 0){
                return back()->with('quantityMismatch',$misMatchQuantity);
            }

            $address_one = $request->address ?? null;
            $address_two = $request->address_two ?? null;
            $address = $address_one.', '.$address_two;

            $name = $request->customer_name ?? null;
            $email = $request->customer_email ?? null;
            $phone = $request->customer_phone ?? null;
            $country = $request->customer_country ?? null;
            $state = $request->customer_state ?? null;
            $city = $request->customer_city ?? null;
            $postcode = $request->customer_zip_code ?? null;
            $shipping_address = $address ?? null;
            $total_price = $request->total_price ?? '0.00';
            $status = $request->status ?? null;
            $paymentMethod = $request->payment_method ?? null;

            if($request->orderId){
                $shipping = $address ?? '';
            }else {
                $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $name . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $shipping_address . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $city . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $state . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $postcode . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $country . '</h7></div></div>';
            }


            $insert_order_info = Order::create([
                'id' => $order_number,
                'order_number' => $order_number,
                'exchange_order_id' => $request->orderId ?? null,
                'status' => $status,
                'created_via' => 'rest-api',
                'currency' => 'GBP',
                'total_price' => $total_price,
                'customer_name' => $name,
                'customer_email' => $email,
                'customer_phone' => $phone,
                'customer_country' => $country,
                'customer_city' => $city,
                'customer_zip_code' => $postcode,
                'customer_state' => $state,
                'payment_method' => $paymentMethod,
                'shipping' => $shipping,
                'shipping_post_code' => $postcode,
                'date_created' => \Illuminate\Support\Carbon::now()
            ]);
            

            if($request->orderId){
                $lastCreatedId = Order::where('exchange_order_id',$request->orderId)->first()->id;
                $updateExchange = Order::find($request->orderId)->update(['exchange_order_id' => $lastCreatedId]);
            }
            $variation_arr_info = [];
            $missing_sku = '';
            foreach ($request->sku as $key => $value){
                $variation_info = ProductVariation::where('sku',$value)->first();
                if($variation_info) {
                    $draft_product_name = ProductDraft::find($variation_info->product_draft_id)->name;
                    $variation_arr_info = ProductOrder::create([
                        'order_id' => $order_number,
                        'variation_id' => $variation_info->id,
                        'name' => $draft_product_name,
                        'quantity' => $request->quantity[$key],
                        'price' => $request->price[$key],
                        'status' => 0
                    ]);
                    
                    $check_quantity = new CheckQuantity();
                    $check_quantity->checkQuantity($value,null,null,'Manual Order Create');

//                    $new_update_quantity = $variation_info->actual_quantity - $request->quantity[$key];
//                    $variation_info->actual_quantity = $new_update_quantity;
//                    $result = $variation_info->save();
//
//                    $woocomm_status = WoocommerceAccount::first()->status;
//                    if($woocomm_status == 1) {
//                        $woo_comm_variation = WoocommerceVariation::where('woocom_variation_id', $variation_info->id)->first();
//                        if ($woo_comm_variation) {
//                            try {
//                                $variation_data = [
//                                    'stock_quantity' => $new_update_quantity,
//                                ];
//                                $woocom_update_result = Woocommerce::put('products/' . $woo_comm_variation->woocom_master_product_id . '/variations/' . $woo_comm_variation->id, $variation_data);
//                                $woo_comm_wms_update_result = WoocommerceVariation::find($woo_comm_variation->id)->update([
//                                    'actual_quantity' => $new_update_quantity
//                                ]);
//                            } catch (Exception $exception) {
//
//                            }
//                        }
//                    }
//
//                    $onbuy_status = OnbuyAccount::first()->status;
//                    if($onbuy_status == 1) {
//                        $onbuy_product_variation = OnbuyVariationProducts::where('sku', $variation_info->sku)->first();
//                        if ($onbuy_product_variation) {
//                            $this->updateOnbuyQuantity($new_update_quantity, $variation_info->sku);
//                            $onbuy_update = OnbuyVariationProducts::find($onbuy_product_variation->id)->update(['stock' => $new_update_quantity]);
//                        }
//                    }
//
//                    $ebay_status = DeveloperAccount::first()->status;
//                    if($ebay_status == 1) {
//                        $ebay_product_variation = EbayVariationProduct::with(['masterProduct'])->where('sku', $variation_info->sku)->get();
//                        if (count($ebay_product_variation) > 0) {
//                            foreach ($ebay_product_variation as $ebay_product_variation_find) {
//                                if ($ebay_product_variation_find != null) {
//                                    $item_id = $ebay_product_variation_find->masterProduct->item_id;
//                                    $site_id = $ebay_product_variation_find->masterProduct->site_id;
//                                    $this->updateEbayQuantity($variation_info->sku, $new_update_quantity);
//                                    $ebay_update = EbayVariationProduct::where('sku', $variation_info->sku)->update(['quantity' => $new_update_quantity]);
//                                }
//                            }
//                        }
//                    }

                }else{
                    $missing_sku .= $value.',';
                }
            }
//            $order_product_insert_info = ProductOrder::insert($variation_arr_info);
            if($missing_sku != ''){
                $missing_sku = ' <span style="color: #ff0000">' .$missing_sku.' These skus are missing.</span>';
            }
            return back()->with('order_success_message','Order placed successfully'.$missing_sku);

        }catch (\Exception $ex){
            return $ex->getMessage();
        }
    }

    public function updateOnbuyQuantity($quantity,$sku){
        $data[] = [
            "sku"=> $sku,
            "stock" => $quantity
        ];
        $update_info= [
            "site_id" => 2000,
            "listings" => $data
        ];
        $onbuy_access_token = $this->access_token();
        $product_info = json_encode($update_info);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/listings/by-sku",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>$product_info,
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$onbuy_access_token,
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function completeOrder($id){

        DB::transaction(function ()use ($id){
//            $data = [
//                'status' => 'completed'
//            ];
//            try{
//                $this->woo_result = Woocommerce::put('orders/'.$id, $data);
//            }catch (HttpClientException $exception){
//                echo $exception->getMessage();
//                return back()->with('error', $exception->getMessage());
//            }

            if($this->shelf_use == 0){
                $idArr[] = $id;
                $orderProductUpdate = $this->orderProductUpdate($idArr);
            }
            $result  = Order::find($id)->update(['status'=> 'completed','packer_id' => Auth::user()->id]);

        });
        return back()->with('success','Successfully Completed');


    }

    public function syncOrderFromWoocommerce(){
        $args = array(
            'status' => 'processing',
        );
//        echo "<pre>";

        try{
            $all_order = Woocommerce::get('orders?status=processing&offset=0&per_page=100');
        }catch (HttpClientException $exception){
            echo $exception->getMessage();
            return back()->with('error', $exception->getMessage());
        }

//        exit();

        $order = json_decode(json_encode($all_order));
        $user_id = Auth::user()->id;

        // echo "<pre>";
        // print_r($order);
        // exit();

        foreach ($order as $order) {

            $order_exist = Order::find($order->id);
            if(!isset($order_exist)) {

                $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $order->shipping->first_name . ' ' . $order->shipping->last_name . '</h7></div></div>';
//        $shipping .= '<div class="row"><div class="col-4"><h7> Company  </h7></div><div class="col-8"><h7> : '.$order->shipping->company.'</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $order->shipping->address_1 . ',' . $order->shipping->address_2 . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $order->shipping->city . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $order->shipping->state . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $order->shipping->postcode . '</h7></div></div>';
                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $order->shipping->country . '</h7></div></div>';
                try{
                    // DB::transaction(function () use ($order,$shipping) {
                    $data = Order::create([
                        'id' => $order->id,
                        'order_number' => $order->number,
                        'status' => $order->status,
                        'created_via' => $order->created_via,
                        'currency' => $order->currency,
                        'total_price' => $order->total,
                        'customer_id' => $order->customer_id,
                        'customer_name' => $order->billing->first_name . ' ' . $order->billing->last_name,
                        'customer_email' => $order->billing->email,
                        'customer_phone' => $order->billing->phone,
                        'customer_country' => $order->billing->country,
                        'customer_city' => $order->billing->city,
                        'customer_zip_code' => $order->billing->postcode,
                        'customer_state' => $order->billing->state,
                        'shipping' => $shipping,
                        'shipping_post_code' => $order->shipping->postcode,
                        'payment_method' => $order->payment_method,
                        'transaction_id' => $order->transaction_id,
                        'date_created' => $order->date_created
                    ]);

                    $single_order = Order::find($order->id);

                    $count = 1;
                    foreach ($order->line_items as $product) {
//            $datas['variation_id'] = $product->variation_id;
                        $datas['variation_id'] = $product->variation_id;
                        $datas['name'] = $product->name;
                        $datas['quantity'] = $product->quantity;
                        $datas['price'] = $product->price;
                        $datas['status'] = 0;
                        $single_order->product_variations()->attach($single_order->id, $datas);
                        $count++;
                    }
                    // });
                }catch(\Exception $ex){
                    continue;
                }
            }
        }


        return redirect('order/list');

    }

    public function manualOrderUpdate(){
        $data = [
            'line_items' => [
                [
                    'name' => 'Sailor Tshirt',
                    'product_id' => 21069,
                    'variation_id' => 21073,
//                    'product_id' => 21022,
//                    'variation_id' => 21023,
                    'quantity' => 2
//                    'price' => $request->price
                ]
            ]
        ];
        try{
            print_r(Woocommerce::put('orders/21100', $data));
        }catch (HttpClientException $exception){
            echo $exception->getMessage();
            return back()->with('error', $exception->getMessage());
        }

    }



    /*
    * Function : manualOrderList
    * Route : manual-order-list
    * Method Type : GET
    * Parametes : null
    * Creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for displaying Manual Order list and pagination
    * Created Date: unknown
    * Modified Date : 7-12-2020
    * Modified Content : Screen option Pagination
    */

    public function manualOrderList()
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('order', 'manual_order_list');
//        echo ('<pre>');
//        print_r($settingData);
//        exit();
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


        $all_picker = Role::with(['users_list'])->where('id',3)->first();
        $all_manual_order = Order::with(['product_variations' => function($query){
            $query->withTrashed();
            $query->wherePivot('deleted_at','=', null)->withTrashed();
        }])->where([['created_via','rest-api']])->orderBy('date_created','DESC')->paginate($pagination);
        $total_order = Order::where([['created_via','rest-api']])->count();
        $all_decode_manual_order = json_decode(json_encode($all_manual_order));
        $content = view('order.manual_order_list',compact('all_manual_order','all_picker','all_decode_manual_order','total_order', 'setting', 'page_title', 'pagination'));
        return view('master',compact('content'));
    }

    public function bulkCompleteOrder(Request $request){
//        $validation = $request->validate([
//            'multiple_checkbox' => 'required'
//        ]);
        $orderIds = $this->getPickedOrderIds($request->multiple_checkbox);
        if($this->shelf_use == 0){
            $bulkOrderComplete = $this->orderProductUpdate($orderIds);
        }
        $result  = Order::whereIn('id',$orderIds)->update(['status'=> 'completed','packer_id' => Auth::user()->id]);
        return response()->json($result);
//        return redirect('/assigned/order/list')->with('assign_success_msg','All checked orders successfully completed');
    }

    public function exchangeOrderProduct($id = null){
        $product_info = ProductOrder::with(['variation_info'])->find($id);
        $content = view('order.exchange_order_product',compact('id','product_info'));
        return view('master',compact('content'));
    }

    public function saveExchangeOrderProduct(Request $request){
        $orderedSku = $request->order_sku;
        $exchangedSku = $request->exchange_sku;
        $order_product_id = ProductVariation::where('sku',$orderedSku)->first();
        $exchange_product_id = ProductVariation::where('sku',$exchangedSku)->first();
        $picked_product = [];
        $action_name = 'Exchange Product';
        if($order_product_id != null && $exchange_product_id != null) {
            if($orderedSku == $exchangedSku){
                if($request->exchange_quantity == $request->order_quantity){
                    return back()->with('error','Exchange Quantity Must Be Less Than Or Greater Than Ordered Quantity');
                }
                $check_quantity = new CheckQuantity();
                $incrementalQuantity = $request->order_quantity - $request->exchange_quantity;
                $check_quantity->checkQuantity($orderedSku, $incrementalQuantity, null, $action_name);
            }else{
                $check_quantity = new CheckQuantity();
                $check_quantity->checkQuantity($orderedSku, $request->order_quantity, null, $action_name);

                $check_quantity2 = new CheckQuantity();
                $exChangeQnty = 0 - $request->exchange_quantity;
                $check_quantity2->checkQuantity($exchangedSku, $exChangeQnty, null, $action_name);
            }
            // $woo_comm_ordered_product_exist_check = WoocommerceVariation::where('sku',$orderedSku)->first();
            // $woo_comm_exchanged_product_exist_check = WoocommerceVariation::where('sku',$exchangedSku)->first();
            // $new_ordered_product_update_quantity = $order_product_id->actual_quantity + $request->order_quantity;
            // $new_exchanged_product_update_quantity = $exchange_product_id->actual_quantity - $request->order_quantity;
//             if($woo_comm_ordered_product_exist_check != null && $woo_comm_exchanged_product_exist_check != null) {
//                 $order_product_data = [
//                     'stock_quantity' => $new_ordered_product_update_quantity
//                 ];
//                 try {
//                     $woo_result = Woocommerce::put('products/' . $woo_comm_ordered_product_exist_check->woocom_master_product_id . '/variations/' . $woo_comm_ordered_product_exist_check->id, $order_product_data);
//                     $ordered_product_update_result = WoocommerceVariation::find($woo_comm_ordered_product_exist_check->id)->update([
//                         'actual_quantity' => $new_ordered_product_update_quantity
//                     ]);
//                 } catch (HttpClientException $exception) {
// //                    return back()->with('error', $exception->getMessage());
//                 }

//                 $exchange_product_data = [
//                     'stock_quantity' => $new_exchanged_product_update_quantity
//                 ];
//                 try {
//                     $woo_result1 = Woocommerce::put('products/' . $woo_comm_exchanged_product_exist_check->woocom_master_product_id . '/variations/' . $woo_comm_exchanged_product_exist_check->id, $exchange_product_data);
//                     $exchanged_product_update_result = WoocommerceVariation::find($woo_comm_exchanged_product_exist_check->id)->update([
//                         'actual_quantity' => $new_exchanged_product_update_quantity
//                     ]);
//                 } catch (HttpClientException $exception) {
// //                    return back()->with('error', $exception->getMessage());
//                 }
//             }
            // $onbuy_ordered_product_exist_check = OnbuyVariationProducts::where('sku',$orderedSku)->first();
            // $onbuy_exchanged_product_exist_check = OnbuyVariationProducts::where('sku',$exchangedSku)->first();
            // if($onbuy_ordered_product_exist_check != null && $onbuy_exchanged_product_exist_check != null){
            //     try {
            //         $product_var_data = [
            //             [
            //                 "sku" => $orderedSku,
            //                 "stock" => $new_ordered_product_update_quantity
            //             ],
            //             [
            //                 "sku" => $exchangedSku,
            //                 "stock" => $new_exchanged_product_update_quantity
            //             ]
            //         ];
            //         $update_info = [
            //             "site_id" => 2000,
            //             "listings" => $product_var_data
            //         ];

            //         $access_token = $this->access_token();

            //         $var_product_info = json_encode($update_info, JSON_PRETTY_PRINT);
            //         $url = "https://api.onbuy.com/v2/listings/by-sku";
            //         $var_post_data = $var_product_info;
            //         $method = "PUT";
            //         $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
            //         $result_info = $this->curl_request_send($url, $method, $var_post_data, $http_header);

            //         $ordered_product_update_info = OnbuyVariationProducts::where('id', $onbuy_ordered_product_exist_check->id)->update([
            //             'stock' => $new_ordered_product_update_quantity
            //         ]);
            //         $exchange_product_update_info = OnbuyVariationProducts::where('id', $onbuy_exchanged_product_exist_check->id)->update([
            //             'stock' => $new_exchanged_product_update_quantity
            //         ]);

            //         $data = json_decode($result_info);

            //     }catch (\Exception $exception){

            //     }
            // }
            // $ebay_ordered_product_exist_check = EbayVariationProduct::where('sku',$orderedSku)->first();
            // $ebay_exchanged_product_exist_check = EbayVariationProduct::where('sku',$exchangedSku)->first();
            // if($ebay_ordered_product_exist_check != null && $ebay_exchanged_product_exist_check != null){
            //     $ebay_ordered_product_variation_info = EbayVariationProduct::where('sku', $orderedSku)->first();
            //     if ($ebay_ordered_product_variation_info) {
            //         $this->updateEbayVariation($ebay_ordered_product_variation_info->sku,$new_ordered_product_update_quantity);
            //         $ebay_orderd_product_update = EbayVariationProduct::where('sku',$ebay_ordered_product_variation_info->sku)->update(['quantity' => $new_ordered_product_update_quantity]);

            //     }
            //     $ebay_exchange_product_variation_info = EbayVariationProduct::where('sku', $exchangedSku)->first();
            //     if ($ebay_exchange_product_variation_info) {
            //         $this->updateEbayVariation($ebay_exchange_product_variation_info->sku,$new_exchanged_product_update_quantity);
            //         $ebay_exchange_product_update = EbayVariationProduct::where('sku',$ebay_exchange_product_variation_info->sku)->update(['quantity' => $new_exchanged_product_update_quantity]);

            //     }
            // }

            $productOrderInfo = ProductOrder::find($request->product_order_id);
            $result = ProductOrder::where('id', $request->id)->update(['variation_id' => $exchange_product_id->id, 'quantity' => $request->exchange_quantity, 'picked_quantity' => 0, 'status' => 0]);
            if ($request->picked_quantity > 0) {
                $shelf_info = ShelfedProduct::with(['shelf_info'])->where('variation_id', $productOrderInfo->variation_id)->get();
                $variation_details = json_decode(ShelfedProduct::with(['variation_info:id,product_draft_id,sku'])->where('variation_id', $productOrderInfo->variation_id)->first());
                if (count($shelf_info) > 0) {
                    $picked_product[] = [
                        'product_order_id' => $productOrderInfo->id,
                        'order_id' => $productOrderInfo->order_id,
                        'variation_id' => $productOrderInfo->variation_id,
                        'name' => $productOrderInfo->name,
                        'quantity' => $request->exchange_quantity,
                        'picked_quantity' => $productOrderInfo->picked_quantity,
                        'status' => $productOrderInfo->status,
                        'variation_details' => $variation_details,
                        'shelf_details' => json_decode($shelf_info)
                    ];
                }
                $route = 'order/list';
                $content = view('order.cancel_order_not_picked', compact('picked_product', 'route'));
                return view('master', compact('content'));
            }
            // $increment = ProductVariation::find($order_product_id->id)->update(['actual_quantity'=> $new_ordered_product_update_quantity]);
            // $decrement = ProductVariation::find($exchange_product_id->id)->update(['actual_quantity' => $new_exchanged_product_update_quantity]);
            return back()->with('success_msg', 'Order Product Exchange Successfully');
        }
        else{
            return back()->with('error','Please check for orderd and exchaged product availability ?');
        }


    }

    public function updateEbayVariation($sku,$updated_quantity){
        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();
        foreach ($ebay_product_find as $product){
            $account_result = EbayAccount::find($product->masterProduct->account_id);

            $this->ebayAccessToken($account_result->refresh_token);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$product->masterProduct->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$product->masterProduct->item_id.'</ItemID>
                        <Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                            <SKU>'.$sku.'</SKU>
                            <Quantity>'.$updated_quantity.'</Quantity>
                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

            $update_ebay_product = $this->curl($url,$headers,$body,'POST');
//            print_r($update_ebay_product);
//            exit();

        }
    }

    public function holdAssignedOrder($id){
        $info = Order::where('id',$id)->update(['status' => 'on-hold', 'cancelled_by' => Auth::id()]);
        $order_number = Order::find($id)->order_number;
        return redirect('order/list')->with('assign_success_msg','Order No. '.$order_number.' is hold successfully');
    }


    /*
   * Function : holdOrderList
   * Route Type : hold/order/list
   * Method Type : GET
   * Parameters : null
   * Creator : Unknown
   * Modifier : Solaiman
   * Description : This function is used for Hold order list and pagination setting
   * Modified Date : 5-12-2020
   * Modified Content : Pagination setting
   */

  public function holdOrderList(Request $request)
    {
        //Start page title and pagination setting
        $shelfUse = $this->shelf_use;
        $settingData = $this->paginationSetting('order','hold_order');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting
        $userInfo = User::all();
        $allChannels = $this->allChannels();
        //$distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $distinct_status = Order::distinct()->get(['status'])->where('status', '!=', null);
        $all_picker = Role::with(['users_list'])->where('id',3)->first();
        $all_hold_order = Order::with(['product_variations' => function($query){
            $query->with(['product_draft' => function($query_image){
                $query_image->with('single_image_info');
            }])->withTrashed();
            $query->wherePivot('deleted_at','=', null)->withTrashed();
        },'order_note' => function($query){
            $query->select(['id','order_id','note']);
        },'cancelled_by_user:id,name'])->whereIn('status',['on-hold','exchange-hold']);

        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->orderSearchCondition($all_hold_order, $request);
            $allCondition = $this->orderConditionParams($request, $allCondition);
            //dd($allCondition);
        }
        $all_hold_order = $all_hold_order->orderBy('date_created','DESC')->paginate($pagination)->appends($request->query());

        $all_decode_hold_order = json_decode(json_encode($all_hold_order));
        $cancel_reasons = CancelReason::all();
        $content = view('order.hold_order_list',compact('all_hold_order','all_picker','all_decode_hold_order','allChannels','distinct_currency','cancel_reasons','setting','page_title','pagination','shelfUse','distinct_payment','distinct_country','distinct_status', 'allCondition','userInfo'));
        return view('master',compact('content'));
    }

    public function shelfWiseOrderList(Request $request){
        $orderFilterType = $request->get('order_filter_type') ?? null;
        $catalogueOrderArr = [];
        $pickerInfo = [];
        $pickerInfo = Role::with(['users_list'])->where('id',3)->first();
        if($orderFilterType == 'group_by_catalogue'){
            $groupByCatalogueOrder = ProductOrder::select(DB::raw('sum(quantity) as total_quantity'), 'variation_id')->whereHas('order', function($query){
                $query->where('status','processing');
            })->with(['variation_info' => function($query){
                $query->select('id','product_draft_id','image','attribute','sku')->with('product_draft:id,name,sku_short_code','master_single_image:id,draft_product_id,image_url');
            }])->groupBy('variation_id')->get();
            $uniqueCatalogueArr = [];
            if(count($groupByCatalogueOrder) > 0){
                foreach($groupByCatalogueOrder as $key => $catalogueOrder){
                    $orderDetails = [];
                    $catalogueId = $catalogueOrder->variation_info->product_draft_id ?? '';
                    if(!in_array($catalogueId, $uniqueCatalogueArr)){
                        $productVariation = ProductVariation::select('id')->where('product_draft_id',$catalogueId)->get()->toArray();
                        $orderProduct = ProductOrder::whereHas('order', function($query){
                            $query->where('status','processing');
                        })->groupBy('order_id')->whereIn('variation_id',$productVariation)->pluck('order_id');
                        
                        $multiple_customer_order = Order::with(['product_variations'])->whereIn('id',$orderProduct)->orderByDesc('id')->get();
                        $orderPickedCount = 0;
                        $assignedOrder = 0;
                        foreach ($multiple_customer_order as $single_cus_order){
                            if($single_cus_order->picker_id != null){
                                $assignedOrder++;
                            }
                            $picking_count = 0;
                            foreach($single_cus_order->product_variations as $sin_order){
                                $picking_count += $sin_order->pivot->status;
                            }
                            if(count($single_cus_order->product_variations) == $picking_count){
                                $orderPickedCount++;
                            }
                        }
                        
                        $catalogueOrderArr[$catalogueId] = [
                            'catalogue_id' => $catalogueId,
                            'name' => $catalogueOrder->variation_info->product_draft->name ?? '',
                            'image' => $catalogueOrder->variation_info->master_single_image->image_url ?? '',
                            'sku_short_code' => $catalogueOrder->variation_info->product_draft->sku_short_code ?? '',
                            'total_product' => $catalogueOrder->total_quantity,
                            'picked_order' => $orderPickedCount,
                            'total_order' => count($orderProduct),
                            'assigned_order' => $assignedOrder
                        ];
                        //array_push($catalogueOrderArr, $orderDetails);
                        array_push($uniqueCatalogueArr, $catalogueId);
                    }else{
                        $catalogueOrderArr[$catalogueId]['total_product'] += $catalogueOrder->total_quantity;
                    }
                }
            }
        }
        $catalogueOrderArr = collect($catalogueOrderArr)->sortBy('total_product')->where('total_product','>',1)->reverse()->toArray();
        // $groupByCatalogueOrder = ProductDraft::select(DB::raw('sum(product_orders.quantity) as total_order_quantity'),'product_drafts.id as catalogue_id','product_drafts.name')
        // ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
        // ->join('product_orders','product_variation.id','=','product_orders.variation_id')
        // ->join('orders','product_orders.order_id','=','orders.id')
        // ->where([['orders.status','processing'],['picker_id',null]])
        // //->where([['product_variation.deleted_at',null],['product_drafts.deleted_at',null]])
        // ->havingRaw('sum(product_orders.quantity) > 1')
        // ->groupBy('product_drafts.id')
        // ->get();
        // $catalogueOrderArr = [];
        // if(count($groupByCatalogueOrder) > 0){
        //     foreach($groupByCatalogueOrder as $catalogueOrder){
        //         $catalogueOrderArr[] = ProductDraft::with(['ProductVariations' => function($query){
        //             $query->with(['order_products' => function($query2){
        //                 $query2->whereHas('order', function($query3){
        //                     $query3->where('status','processing')->where('picker_id',null);
        //                 });
        //             }]);
        //         }])->find($catalogueOrder->catalogue_id);
        //     }
        // }
        // return $catalogueOrderArr;
        // echo '<pre>';
        // print_r(json_decode($groupByCatalogueOrder));
        // exit();

//        return 'Now: '.Carbon::now().' Sub: '.Carbon::now()->subHour(20);
        $shelfUse = $this->clientInfo();
        $groupBySku = [];
        if($orderFilterType == 'group_by_sku'){
            $groupBySku = ProductOrder::select(DB::raw('sum(quantity) as total_quantity'), 'variation_id',DB::raw('count(order_id) as order_count'),DB::raw('sum(status) as picked_order'))->whereHas('order', function($query){
                $query->where('status','processing');
            })->with(['variation_info' => function($query){
                $query->select('id','product_draft_id','image','attribute','sku')->with(['getProductOrders' => function($getPro){
                    $getPro->select('orders.picker_id')->where('orders.status','processing')->where('orders.picker_id','!=',null);
                },'master_single_image:id,draft_product_id,image_url']);
            }])->havingRaw('sum(quantity) > 1')->groupBy('variation_id')->get();
        }
        $customer_order_by_phone_post = [];
        if(($orderFilterType == null) || $orderFilterType == 'order_by_postcode'){
            $customer_order_by_phone_post = Order::select(DB::raw('count(shipping_post_code) as order_count'),DB::raw('count(assigner_id) as assigned_order'),'shipping_post_code','postcode_status')->where([['status', 'processing'],['shipping_post_code','!=',null]])
    //            ->whereDate('date_created','>', Carbon::now()->subHour(20))
    //            ->groupBy(['customer_zip_code','customer_phone'])->get();
                ->havingRaw('count(shipping_post_code) > 1')
                ->orderBy('order_count','DESC')
                ->groupBy(['shipping_post_code','postcode_status'])->get();
        }

//        $info = Order::select('orders.customer_zip_code','orders.customer_phone')
//            ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
//            ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
//            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
//            ->join('shelfs','product_shelfs.shelf_id','=','shelfs.id')
////            ->where('orders.picker_id', Auth::id())
//            ->where('orders.status','processing')
//            ->where('orders.picker_id','!=',null)
//            ->where('orders.assigner_id','!=',null)
//            ->where('product_shelfs.quantity','!=',0)
//            ->whereDate('date_created','>',Carbon::now()->subHour(20))
//            ->orderBy('shelfs.id','asc')
//            ->groupBy('orders.customer_zip_code')
//            ->groupBy('orders.customer_phone')
//            ->get()->all();

//        echo "<pre>";
//        print_r(json_decode(json_encode($customer_order_by_phone_post)));
//        exit();
        $order_info = [];
        if($orderFilterType == 'order_by_shelf'){
            if($shelfUse == 1) {
                $info = Order::select('orders.id AS o_id', 'orders.order_number', 'orders.created_via', 'orders.currency', 'orders.status', 'orders.date_created', 'product_orders.variation_id', 'product_orders.name',
                    'product_shelfs.quantity', 'product_shelfs.shelf_id', 'shelfs.id', 'shelfs.shelf_name')
                    ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                    ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                    ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                    ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
    //            ->where('orders.picker_id', Auth::id())
                    ->where('orders.status', 'processing')
                    //->where('orders.picker_id',null)
    //            ->where('orders.assigner_id','!=',null)
                    ->where('product_shelfs.quantity', '!=', 0)
                    ->groupBy('product_orders.variation_id')
                    ->orderBy('shelfs.shelf_name', 'asc')
                    ->get()->all();
                $infos = array();
                foreach ($info as $value) {
                    $infos[] = $value->o_id;
                }

                $order_info = array();
                $vals = array_count_values($infos);
                foreach ($vals as $key => $value) {
                    foreach ($info as $info_value) {
                        if ($key == $info_value->o_id) {
                            $multiple_customer_order = Order::with(['product_variations'])->where('id',$info_value->o_id)->first();
                            $orderPicked = false;
                            $picking_count = 0;
                            foreach($multiple_customer_order->product_variations as $sin_order){
                                $picking_count += $sin_order->pivot->status;
                            }
                            if(count($multiple_customer_order->product_variations) == $picking_count){
                                $orderPicked = true;;
                            }
                            $order_info[] = [
                                'order_id' => $info_value->o_id,
                                'order_number' => $info_value->order_number,
                                'created_via' => $info_value->created_via,
                                'currency' => $info_value->currency,
                                'status' => $info_value->status,
                                'order_product' => $value,
                                'order_date' => $info_value->date_created,
                                'shelf_id' => $info_value->shelf_id,
                                'shelf_name' => $info_value->shelf_name,
                                'quantity' => $info_value->quantity,
                                'is_picked_order' => $orderPicked,
                                'assigned_order' => $multiple_customer_order->picker_id ? 1 : 0,
                                'account_logo' => $this->accountLogo($info_value->created_via,$multiple_customer_order->account_id)
                            ];
                            break;
                        }
                    }
                }

                $order_info = json_decode(json_encode($order_info));
            }
        }

        $content = view('order.shelf_wise_order',compact('order_info','customer_order_by_phone_post','shelfUse','groupBySku','catalogueOrderArr','orderFilterType','pickerInfo'));
        return view('master',compact('content'));
    }

    public function ajaxShelfWiseProductList(Request $request){
        $product_info = Order::with(['productOrders' => function ($query) {
            $query->with(['shelf_quantity' => function($query){
                $query->orderBy('shelf_name','ASC')->wherePivot('quantity','>',0);
            },'product_draft' => function($query_image){
                $query_image->with('single_image_info');
            }]);
        }])->where('id',$request->id)->first();
//        echo "<pre>";
//        print_r(json_decode(json_encode($product_info)));
//        exit();
        return view('order.ajax_shelf_wise_order',compact('product_info'));
    }

    public function posOrder(){
        $content = view('order.pos_order');
        return view('master',compact('content'));
    }

    public function posProductSearch(Request $request){

        $product_info = ProductVariation::with('product_draft')->where('ean_no',$request->ean_no)->first();
        if(isset($product_info)) {
            $output = '<tr id="tr_id_'.$product_info->id.'"><td class="text-center" style="width: 40%;">' . $product_info->product_draft->name . '</td>';
            $output .='<td class="text-center" style="width: 10%;"><input class="form-control text-center" id="product_id_'.$product_info->id.'" type="text" name="product_id[]" value="'.$product_info->id.'"></td></td>';
            $output .='<td class="text-center" style="width: 15%;"><input class="form-control text-center" id="sku_id_'.$product_info->id.'" type="text" name="sku[]" value="'.$product_info->sku.'"></td></td>';
            $output .= '<td class="text-center" style="width: 10%;"><input class="form-control text-center" id="qty_id_'.$product_info->id.'" type="text" oninput="custom_qty_input('.$product_info->id.','.$product_info->sale_price.');" name="qty[]" value="1"></td>';
            $output .= '<td class="text-center" style="width: 15%;"><input class="form-control text-center price_id" id="price_id_' . $product_info->id . '" type="text" name="price[]" value="'.$product_info->sale_price.'"></td>';
            $output .= '<td class="text-center" style="width: 10%;"><button type="button" class="btn btn-danger remove-product" onclick="remove_tr('.$product_info->id.');"><i class="fa fa-remove"></i></button></td></tr>';
            return response()->json(['data' => 1, "content" => $output, "product_id" => $product_info->id]);
        }else{
            return response()->json(['data' => 2, "content" => "No product found"]);
        }
    }

    public function createPosOrder(Request $request){

//        echo "<pre>";
//        print_r($request->all());
//        exit();
        try {
//            $catalogue_info = ProductVariation::find($request->variation_id);
            $product_info = array();
            foreach ($request->product_id as $key => $value) {
                $catalogue_info = ProductVariation::find($value);
                $draft_product_name = ProductDraft::find($catalogue_info->product_draft_id)->name;
                $product_info[] = [
                    'name' => $draft_product_name,
                    'product_id' => $catalogue_info->product_draft_id,
                    'variation_id' => $value,
                    'quantity' => $request->qty[$key]
                ];
            }
            echo "<pre>";
            print_r(json_decode(json_encode($product_info)));
            exit();
            $data = [
//                'payment_method' => 'bacs',
//                'payment_method_title' => 'Cash',
                'status' => 'processing',
//            'created_via' => $request->created_via,
//                'currency' => $request->currency,
//            'total' => $request->total_price,
                'line_items' => $product_info
            ];

            try {
                $all_order = Woocommerce::post('orders', $data);
            } catch (HttpClientException $exception) {

                return back()->with('error', $exception->getMessage());
            }

            if (isset($all_order)) {
                $order = json_decode(json_encode($all_order));
                $user_id = Auth::user()->id;
                $shipping = '<div class="row"><div class="col-4"><h7> Name  </h7></div><div class="col-8"><h7> : </h7></div></div>';
                $shipping .= '<div class="row"><div class="col-4"><h7> Address  </h7></div><div class="col-8"><h7> : </h7></div></div>';
                $shipping .= '<div class="row"><div class="col-4"><h7> City  </h7></div><div class="col-8"><h7> : </h7></div></div>';
                $shipping .= '<div class="row"><div class="col-4"><h7> State  </h7></div><div class="col-8"><h7> : </h7></div></div>';
                $shipping .= '<div class="row"><div class="col-4"><h7> Postcode  </h7></div><div class="col-8"><h7> : </h7></div></div>';
                $shipping .= '<div class="row"><div class="col-4"><h7> Country  </h7></div><div class="col-8"><h7> : </h7></div></div>';

                $data = Order::create([
                    'id' => $order->id,
                    'order_number' => $order->number,
                    'status' => $order->status,
                    'created_via' => $order->created_via,
                    'shipping' => $shipping,
                    'date_created' => $order->date_created
                ]);

                $single_order = Order::find(json_decode($data->order_number));

                $count = 1;
                foreach ($order->line_items as $product) {
                    $datas['variation_id'] = $product->variation_id;
                    $datas['name'] = $product->name;
                    $datas['quantity'] = $product->quantity;
                    $datas['price'] = $product->price;
                    $datas['status'] = 0;
                    $single_order->product_variations()->attach($single_order->id, $datas);
                    $count++;
                }

                return back()->with('order_success_message','Order placed successfully');

//                return response()->json(['data' => 1]);
            }else{
//                return response()->json(['data' => 2]);
                return "woocommerce order not ceateed";
            }
        }
        catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function shelveReturnProduct(Request $request){
        try {
            $shelve_result = ReturnOrderProduct::where('id',$request->id)->update(['status' => 1]);
            return response()->json($shelve_result);
        }catch (\Exception $ex){
            return response()->json($ex->getMessage());
        }

    }

    public function completeOrderGeneralSearch(Request $request){
        $shelfUse = $this->shelf_use;
        if($request->order_search_status == 'processing'){
            $condition = [['orders.status','processing'],['orders.picker_id',null]];
        }
        elseif($request->order_search_status == 'assign-processing'){
            $condition = [['orders.status','processing'],['orders.picker_id','!=',null]];
        }
        elseif($request->order_search_status == 'completed'){
            $condition = [['orders.status','completed']];
        }
        elseif($request->order_search_status == 'on-hold'){
            $condition = [['orders.status','on-hold']];
        }
        elseif($request->order_search_status == 'cancelled'){
            $condition = [['orders.status','cancelled']];
        }
        elseif($request->order_search_status == 'return'){
            $field = ['orders.order_number','orders.customer_name','orders.customer_city','product_orders.name','orders.shipping_post_code','product_variation.sku'];
            $query_result = ReturnOrder::select('return_orders.order_id')
                ->join('orders','return_orders.order_id','=','orders.id')
                ->join('product_orders','orders.id','=','product_orders.order_id')
                ->join('product_variation','product_orders.variation_id','=','product_variation.id')
                ->where(function ($query) use ($field,$request){
                    for ($i = 0; $i < count($field); $i++) {
                        $query->orwhere($field[$i], 'like', '%' . $request->search_value . '%');
                    }
                })
                ->where('orders.status','completed')
                ->groupBy('return_orders.order_id')
                ->get();
            $order_ids = [];
            foreach ($query_result as $result){
                $order_ids[] = $result->order_id;
            }
//            return response()->json(['data' => $order_ids]);
            if(count($order_ids) > 0) {
                $all_return_order = ReturnOrder::with(['return_product_save' => function ($query) {
                    $query->with(['product_draft' => function ($image_query) {
                        $image_query->with('single_image_info');
                    }])->withTrashed();
                    $query->wherePivot('deleted_at','=', null)->withTrashed();
                }, 'orders', 'returned_by_user', 'order_note' => function ($query) {
                    $query->select(['id', 'order_id', 'note']);
                }])->orderByDesc('id')
                    ->whereIn('order_id',$order_ids)
                    ->get();
            }
            echo view('order.return_order_general_search',compact('all_return_order','shelfUse'));
        }
        $field = ['orders.order_number','orders.customer_name','orders.customer_city','product_orders.name','orders.shipping_post_code','product_variation.sku'];
        $query_result = Order::select('orders.order_number')
            ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
            ->leftJoin('product_variation','product_orders.variation_id','=','product_variation.id')
            ->where(function ($query) use ($field,$request){
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->search_value . '%');
                }
            });
            if($request->order_search_status == 'on-hold'){
                $query_result = $query_result->whereIn('orders.status',['on-hold','exchange-hold']);
            }else{
                $query_result = $query_result->where($condition);
            }
        $query_result = $query_result->get();
//        $total_completed_order = Order::where('status','completed')->count();
        $all_filter_order = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }]);
                $query->wherePivot('deleted_at','=', null)->withTrashed();
            },'picker_info','packer_info','assigner_info','order_note' => function($query){
                $query->select(['id','order_id','note']);
            }]);
            if($request->order_search_status == 'on-hold'){
                $all_filter_order = $all_filter_order->with(['cancelled_by_user:id,name'])->whereIn('status',['on-hold','exchange-hold']);
            }else{
                $all_filter_order = $all_filter_order->where($condition);
            }
        $all_filter_order = $all_filter_order->whereIn('order_number',$query_result)->orderByDesc('date_created')->paginate(50);

        if($request->order_search_status == 'processing'){
            $all_processing_order = $all_filter_order;
            echo view('order.processing_order_general_search',compact('all_processing_order','shelfUse'));
        }
        elseif($request->order_search_status == 'assign-processing'){
            $all_assigned_order = $all_filter_order;
            echo view('order.assigned_order_general_search',compact('all_assigned_order','shelfUse'));
        }
        elseif($request->order_search_status == 'completed'){
            $all_completed_order_info = $all_filter_order;
            $all_completed_order = $all_filter_order;
            echo view('order.completed_order_general_search',compact('all_completed_order','all_completed_order_info','shelfUse'));
        }
        elseif($request->order_search_status == 'on-hold'){
            $all_hold_order = $all_filter_order;
            echo view('order.hold_order_general_search',compact('all_hold_order','shelfUse'));
        }
        elseif($request->order_search_status == 'cancelled'){
            $searchCancelledOrderList = Order::with(['product_variations' => function($query){
                $query->with(['product_draft' => function($query_image){
                    $query_image->with('single_image_info');
                }])->withTrashed();
                $query->wherePivot('deleted_at','=', null)->withTrashed();
            },'picker_info','packer_info','assigner_info','cancelled_by_user','order_note' => function($query){
                $query->select(['id','order_id','note']);
            },'orderCancelReason'])->where($condition)
                ->whereIn('order_number',$query_result)->orderByDesc('date_created')->paginate(50);
            echo view('order.cancelled_order_general_search',compact('searchCancelledOrderList','shelfUse'));
        }

    }

    public function addOrderNote(Request $request){
        $insert_info = OrderNote::create([
            'order_id' => $request->order_id,
            'note' => $request->order_note,
            'note_creator' => Auth::id(),
            'note_modifier' => Auth::id()
        ]);
        if($insert_info){
            return response()->json(['data' => $insert_info]);
        }else{
            return response()->json(['data' => 'error']);
        }
    }

    public function viewOrderNote(Request $request){
        $orderInfo = Order::find($request->order_id);
        if($orderInfo){
            if($orderInfo->buyer_message){
                $orderInfo->is_buyer_message_read = 1;
                $orderInfo->save();
            }
        }
        $order_note_info = OrderNote::with('user_info:id,name','modifier_info:id,name','orderInfo')->where('order_id',$request->order_id)->first();
        return response()->json(['data' => $order_note_info,'buyerMessage' => $orderInfo]);
    }

    public function updateOrderNote(Request $request){
        $update_info = OrderNote::where('id',$request->id)->update([
            'note' => $request->note,
            'note_modifier' => Auth::id()
        ]);
        if($update_info){
            return response()->json(['data' => $update_info]);
        }else{
            return response()->json(['data' => 'error']);
        }
    }

    public function deleteOrderNote(Request $request){
        $delete_info = OrderNote::where('id',$request->id)->delete();
        if($delete_info){
            return response()->json(['data' => $delete_info]);
        }else{
            return response()->json(['data' => 'error']);
        }
    }

    public function addProductEmptyOrder($order_id){
        $content = view('order.add_product_empty_order',compact('order_id'));
        return view('master',compact('content'));
    }

    public function saveProductEmptyOrder(Request $request){
        try {
            $i = 0;
            foreach ($request->product_sku as $sku){
                $info = ProductVariation::select('id','product_draft_id','actual_quantity')->with(['product_draft:id,name'])->where('sku',$sku)->first();
                if($info) {
                    $updated_quantity = $info->actual_quantity - $request->quantity[$i];
                    $data = ProductOrder::create([
                        'order_id' => $request->order_id,
                        'variation_id' => $info->id,
                        'name' => $info->product_draft->name,
                        'quantity' => $request->quantity[$i],
                        'price' => $request->price[$i],
                        'status' => 0
                    ]);
//                    $decrement = ProductVariation::find($info->id)->decrement('actual_quantity',$request->quantity[$i]);
//                    $woo_comm_variation_info = WoocommerceVariation::where('woocom_variation_id',$info->id)->first();
//                    if($woo_comm_variation_info) {
//                        $data = [
//                            'stock_quantity' => $updated_quantity
//                        ];
//                        try {
//                            $woo_result = Woocommerce::put('products/' . $woo_comm_variation_info->woocom_master_product_id . '/variations/' . $woo_comm_variation_info->id, $data);
//                        } catch (HttpClientException $exception) {
//                            return back()->with('error', $exception->getMessage());
//                        }
//                        $woo_comm_variation_update_info = WoocommerceVariation::where('id',$woo_comm_variation_info->id)->update([
//                            'actual_quantity' => $updated_quantity
//                        ]);
//                    }
//                    $ebay_variation_info = EbayVariationProduct::where('master_variation_id',$info->id)->first();
//                    if($ebay_variation_info) {
//
//                        try {
//                            $ebay_update = EbayVariationProduct::where('sku',$sku)->update(['quantity'=>$updated_quantity]);
//
//                            //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                            $this->updateEbayQuantity($sku,$updated_quantity);
//                        } catch (HttpClientException $exception) {
//                            return back()->with('error', $exception->getMessage());
//                        }
//
//                    }
//                    $onbuy_variation_info = OnbuyVariationProducts::where('sku',$sku)->first();
//                    if($onbuy_variation_info){
//                        $var_data[] = [
//                            "sku" => $onbuy_variation_info->sku,
//                            "stock" => $updated_quantity
//                        ];
//                        $update_info = [
//                            "site_id" => 2000,
//                            "listings" => $var_data
//                        ];
//
//                        try {
//
//                            $access_token = $this->access_token();
//
//                            $var_product_info = json_encode($update_info, JSON_PRETTY_PRINT);
//                            $url = "https://api.onbuy.com/v2/listings/by-sku";
//                            $var_post_data = $var_product_info;
//                            $method = "PUT";
//                            $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
//                            $result_info = $this->curl_request_send($url, $method, $var_post_data, $http_header);
//
//                            $update_info = OnbuyVariationProducts::where('id', $onbuy_variation_info->id)->update([
//                                'stock' => $updated_quantity
//                            ]);
//
//                            $data = json_decode($result_info);
//                        }catch (\Exception $exception) {
//                            return back()->with('error', $exception->getMessage());
//                        }
//                    }
                    $check_quantity = new CheckQuantity();
                    $check_quantity->checkQuantity($sku, null, null, 'Add Product In Empty Order');
                }

                $i++;
            }
            return back()->with('success','Product added in this order succesfully');
//            echo "<pre>";
//            print_r($data);
//            exit();

        }catch (\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    public function orderSearchFilterOption(Request $request){
        $limit = 50;
        $page_number = $request->page_number;
        $offset = $page_number * $limit;
        $field = $request->column;
        $total_completed_order = Order::where('status',$request->status)->count();
        if($request->filter_option == 0) {
            $all_completed_order = Order::with(['product_variations' => function ($query) {
                $query->with(['product_draft' => function ($query_image) {
                    $query_image->with('single_image_info');
                }]);
            }, 'picker_info', 'packer_info', 'assigner_info'])->where([['status', $request->status]])->where(function ($query) use ($request, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->search . '%');
                }
            })->orderByDesc('date_created')->limit($limit)->offset($offset)->get();
            $count_data = Order::with(['product_variations' => function ($query) {
                $query->with(['product_draft' => function ($query_image) {
                    $query_image->with('single_image_info');
                }]);
            }, 'picker_info', 'packer_info', 'assigner_info'])->where([['status', $request->status]])->where(function ($query) use ($request, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->search . '%');
                }
            })->orderByDesc('date_created')->count();
        }else{
            $all_completed_order = Order::with(['product_variations' => function ($query) {
                $query->with(['product_draft' => function ($query_image) {
                    $query_image->with('single_image_info');
                }]);
            }, 'picker_info', 'packer_info', 'assigner_info'])->where([['status', $request->status]])->where(function ($query) use ($request, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i],'not like', '%' . $request->search . '%');
                }
            })->orderByDesc('date_created')->limit($limit)->offset($offset)->get();
            $count_data = Order::with(['product_variations' => function ($query) {
                $query->with(['product_draft' => function ($query_image) {
                    $query_image->with('single_image_info');
                }]);
            }, 'picker_info', 'packer_info', 'assigner_info'])->where([['status', $request->status]])->where(function ($query) use ($request, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i],'not like', '%' . $request->search . '%');
                }
            })->orderByDesc('date_created')->count();
        }
        $all_completed_order_info = json_decode(json_encode($all_completed_order));
        $page = ceil($count_data / $limit);
        $cancel_reasons = CancelReason::all();
        echo view('order.order_filter_option',compact('all_completed_order','all_completed_order_info','page','page_number','cancel_reasons'));
//        $content = view('order.completed_order_list',compact('all_completed_order','all_completed_order_info'));
//        return view('master',compact('content'));
    }

    public function cancelOrder(Request $request,$route,$order_id){
        $cancel_reason = $request->get('reason', false);
        $cancel_reason_id = explode('/',$cancel_reason);
        $ordered_product = ProductOrder::where('order_id',$order_id)->get();
        $picked_product = [];
        $picked_product_id = [];
        $i = 0;

        if (count($ordered_product) > 0){

            foreach ($ordered_product as $product) {
//                DB::transaction(function ()use ($product) {
                if($cancel_reason_id[1] == 1) {
                    try {

                    //    if ($result){
                           $variation_info = ProductVariation::find($product->variation_id);
                           $check_quantity = new CheckQuantity();
                           $check_quantity->checkQuantity($variation_info->sku, $product->quantity, null, 'Cancel Order');
                    //    }

//                        if ($variation_info) {
//
//                            $updated_new_quantity = $variation_info->actual_quantity + $product->quantity;
////                        echo "<pre>";
////                        print_r(json_decode($variation_info->actual_quantity));
////                        exit();
//                            ProductVariation::where('id', $product->variation_id)->update([
//                                'actual_quantity' => $updated_new_quantity
//                            ]);
//
//                            $woocomm_master_catalogue_id = WoocommerceVariation::where('woocom_variation_id', $product->variation_id)->first();
//                            if ($woocomm_master_catalogue_id) {
//                                $data = [
//                                    'stock_quantity' => $updated_new_quantity
//                                ];
//
//                                $product_variation_result = Woocommerce::put('products/' . $woocomm_master_catalogue_id->woocom_master_product_id . '/variations/' . $woocomm_master_catalogue_id->id, $data);
//
//                                $woo_update_info = WoocommerceVariation::where('woocom_variation_id', $product->variation_id)->update([
//                                    'actual_quantity' => $updated_new_quantity
//                                ]);
//                            }
//
//                            $ebay_variation_find = EbayVariationProduct::where('master_variation_id', $product->variation_id)->first();
//                            if ($ebay_variation_find) {
//
//                                $ebay_update = EbayVariationProduct::where('sku', $variation_info->sku)->update(['quantity' => $updated_new_quantity]);
//
//                                //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                                $this->updateEbayQuantity($variation_info->sku, $updated_new_quantity);
//
//                            }
//
//                            $onbuy_product_info = OnbuyVariationProducts::where('sku', $variation_info->sku)->first();
//                            if ($onbuy_product_info) {
//                                $access_token = $this->access_token();
//
//                                $onbuy_products[] = [
//                                    "sku" => $variation_info->sku,
//                                    "stock" => $updated_new_quantity
//                                ];
//                                $update_info = [
//                                    "site_id" => 2000,
//                                    "listings" => $onbuy_products
//                                ];
//
//                                $product_info = json_encode($update_info, JSON_PRETTY_PRINT);
//
//                                $url = "https://api.onbuy.com/v2/listings/by-sku";
//                                $post_data = $product_info;
//                                $method = "PUT";
//                                $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
//                                $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
//                                $data = json_decode($result_info);
//
//                                $onbuy_id = OnbuyVariationProducts::where('sku', $variation_info->sku)->first();
//                                $update_info = OnbuyVariationProducts::where('id', $onbuy_id->id)->update([
//                                    'stock' => $updated_new_quantity
//                                ]);
//                            }
//
//                        }

                    } catch (\Exception $exception) {
                        return back()->with('assign_success_msg', $exception->getMessage());
                    }
                }
                if ($product->picked_quantity > 0) {
                    $shelf_info = ShelfedProduct::with(['shelf_info'])->where('variation_id', $product->variation_id)->get();
                    $variation_details = json_decode(ShelfedProduct::with(['variation_info:id,product_draft_id,sku'])->where('variation_id', $product->variation_id)->first());
                    if (count($shelf_info) > 0) {
                        $picked_product[] = [
                            'product_order_id' => $product->id,
                            'order_id' => $product->order_id,
                            'variation_id' => $product->variation_id,
                            'name' => $product->name,
                            'quantity' => $product->quantity,
                            'picked_quantity' => $product->picked_quantity,
                            'status' => $product->status,
                            'variation_details' => $variation_details,
                            'shelf_details' => json_decode($shelf_info)
                        ];
                    }
                }

                $result = ProductOrder::where('id',$product->id)->where('order_id',$order_id)->update(['picked_quantity' => $product->quantity,'status' => 1]);
//                });
            }
        }
        $order_update_info = Order::where('id', $order_id)->update(['status' => 'cancelled','cancelled_by' => Auth::id()]);
        $exist_order_cancel = OrderCancelReason::where('order_id', $order_id)->first();
        if ($exist_order_cancel) {
            $cancel_update = OrderCancelReason::where('order_id', $order_id)->update([
                'order_cancel_id' => $cancel_reason_id[0],
                'modifier_id' => Auth::id()
            ]);
        } else {
            $order_cancel = OrderCancelReason::create([
                'order_id' => $order_id,
                'order_cancel_id' => $cancel_reason_id[0],
                'canceller_id' => Auth::id()
            ]);
        }
        if (count($picked_product) > 0) {
            $content = view('order.cancel_order_not_picked', compact('picked_product', 'route'));
            return view('master', compact('content'));
        }
        return back()->with('assign_success_msg', 'Order Cancelled Successfully');
    }

    public function cancelOrderProductSync(Request $request){
        $i = 0;
        //dd($request->all());
        foreach ($request->shelf_id as $id){
            //$shelf_quantity_update = ShelfedProduct::find($request->shelf_id[$i])->increment('quantity',$request->picked_quantity[$i]);
            $reshelve_result = ReshelvedProduct::create([
                'shelf_id' => $request->shelf_id[$i],
                'variation_id' => $request->variation_id[$i],
                'quantity' => $request->picked_quantity[$i],
                'user_id' => Auth::id()
            ]);
            $i++;
        }
        if($request->route_name == 'assigned'){
            return redirect('assigned/order/list')->with('assign_success_msg','Order Cancelled Successfully');
        }elseif($request->route_name == 'processing'){
            return redirect('order/list')->with('assign_success_msg','Order Cancelled Successfully');
        }elseif($request->route_name == 'hold'){
            return redirect('hold/order/list')->with('assign_success_msg','Order Cancelled Successfully');
        }else{
            return redirect('order/list')->with('assign_success_msg','Order Changed Successfully');
        }
    }

    public function updateEbayQuantity($sku,$quantity){


        $sku = $sku;
        $quantity = $quantity;
        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();

        foreach ($ebay_product_find as $product){
            $account_result = EbayAccount::find($product->masterProduct->account_id);

            $this->ebayAccessToken($account_result->refresh_token);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$product->masterProduct->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$product->masterProduct->item_id.'</ItemID>
                        <Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                            <SKU>'.$sku.'</SKU>

                            <Quantity>'.$quantity.'</Quantity>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

            $update_ebay_product = $this->curl($url,$headers,$body,'POST');
        }

//        $update_ebay_product =simplexml_load_string($update_ebay_product);
//        $update_ebay_product = json_decode(json_encode($update_ebay_product),true);
//        echo $itemId.'****'.$sku.'*****'.$quantity.'********'.$siteId;
//        exit();


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


    /*
    * Function : cancelledOrderList
    * Route Type : cancelled/order/list
    * Method Type : GET
    * Parameters : null
    * Creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for Cancelled Order List and pagination setting
    * Modified Date : 5-12-2020
    * Modified Content : Pagination setting
    */

    public function cancelledOrderList(Request $request)
    {
        //Start page title and pagination setting
        $shelfUse = $this->shelf_use;
        $settingData = $this->paginationSetting('order','cancelled_order');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

        $allOrderCancelReason = CancelReason::all();
        $allChannels = $this->allChannels();
        //$distinct_channel = Order::distinct()->get(['created_via'])->where('created_via','!=',null);
        $distinct_currency = Order::distinct()->get(['currency'])->where('currency','!=',null);
        $distinct_payment = Order::distinct()->get(['payment_method'])->where('payment_method', '!=', null);
        $distinct_country = Order::distinct()->get(['customer_country'])->where('customer_country', '!=', null);
        $cancel_reasons = CancelReason::all();
        $cancelledOrderList = Order::with(['product_variations' => function($query){
            $query->with(['product_draft' => function($query_image){
                $query_image->with('single_image_info');
            }])->withTrashed();
            $query->wherePivot('deleted_at','=', null)->withTrashed();
        } ,'picker_info','packer_info','assigner_info', 'cancelled_by_user','order_note' => function($query){
            $query->select(['id','order_id','note']);
        },'orderCancelReason'])->where([['status','cancelled']]);

        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->orderSearchCondition($cancelledOrderList, $request);
            $allCondition = $this->orderConditionParams($request, $allCondition);
            //dd($allCondition);
        }

        $cancelledOrderList = $cancelledOrderList->orderByDesc('date_created')->paginate($pagination)->appends($request->query());
        if($request->has('is_clear_filter')){
            $searchCancelledOrderList = $cancelledOrderList;
            $view = view('order.cancelled_order_general_search',compact('searchCancelledOrderList','shelfUse'))->render();
            return response()->json(['html' => $view]);
        }
        $all_cancelledOrderList = json_decode(json_encode($cancelledOrderList));
//        echo '<pre>';
//        print_r($cancelledOrderList);
//        exit();
        $content = view('order.cancelled_order_list',compact('cancelledOrderList','all_cancelledOrderList','setting','page_title','pagination','shelfUse','allChannels','distinct_currency','distinct_payment','distinct_country','cancel_reasons', 'allCondition', 'allOrderCancelReason'));
        return view('master',compact('content'));
    }

    public function complePostCodeOrder($postcode){
        try {
            $orderUpdate = Order::where('shipping_post_code',$postcode)->where('status','processing')->update([
                'postcode_status' => 1
            ]);
            return response()->json(['type' => 'success']);
        }catch (\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => $exception->getMessage()]);
        }
    }

    public function unholdOrder($orderId){
        try {
            $makeUnholdOrder = Order::find($orderId)->update(['status' => 'processing']);
            return back()->with('success','Order unhold successfully');
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function deleteOrderProduct($orderId, $productId = null, $shelfId = null){
        try{
            if($shelfId != null){
                $orderProductInfo = ProductOrder::find($productId);
                $increasableQuantity = ($orderProductInfo->quantity > $orderProductInfo->picked_quantity) ? $orderProductInfo->quantity - $orderProductInfo->picked_quantity : $orderProductInfo->quantity;
                $shelf_quantity_update = ShelfedProduct::find($shelfId)->increment('quantity',$increasableQuantity);
            }
            $orderProductRowInfo = ProductOrder::with('variation_info:id,sku,actual_quantity')->find($productId);
            if($orderProductRowInfo){
                try {
                    $variation_info = ProductVariation::find($orderProductRowInfo->variation_id);
                    if ($variation_info) {
                        $check_quantity = new CheckQuantity();
                        $check_quantity->checkQuantity($variation_info->sku, $orderProductRowInfo->quantity,null,'Delete Ordered Product');
                        // $updated_new_quantity = $variation_info->actual_quantity + $orderProductRowInfo->quantity;
                        // $woocommerceStatus = WoocommerceAccount::where('status', 1)->first();
                        // if($woocommerceStatus){
                        //     $woocomm_master_catalogue_id = WoocommerceVariation::where('woocom_variation_id', $variation_info->id)->first();
                        //     if ($woocomm_master_catalogue_id) {
                        //         $data = [
                        //             'stock_quantity' => $updated_new_quantity
                        //         ];
                        //         $product_variation_result = Woocommerce::put('products/' . $woocomm_master_catalogue_id->woocom_master_product_id . '/variations/' . $woocomm_master_catalogue_id->id, $data);
                        //         $woo_update_info = WoocommerceVariation::where('woocom_variation_id', $variation_info->id)->update([
                        //             'actual_quantity' => $updated_new_quantity
                        //         ]);
                        //     }
                        // }
                        // $ebayStatus = DeveloperAccount::where('status', 1)->first();
                        // if($ebayStatus){
                        //     $ebay_variation_find = EbayVariationProduct::where('master_variation_id', $variation_info->id)->first();
                        //     if ($ebay_variation_find) {
                        //         $this->updateEbayQuantity($variation_info->sku, $updated_new_quantity);
                        //         $ebay_update = EbayVariationProduct::where('sku', $variation_info->sku)->update(['quantity' => $updated_new_quantity]);
                        //     }
                        // }
                        // $onbuyStatus = OnbuyAccount::where('status',1)->first();
                        // if($onbuyStatus){
                        //     $onbuy_product_info = OnbuyVariationProducts::where('sku', $variation_info->sku)->first();
                        //     if ($onbuy_product_info) {
                        //         $access_token = $this->access_token();
                        //         $onbuy_products[] = [
                        //             "sku" => $variation_info->sku,
                        //             "stock" => $updated_new_quantity
                        //         ];
                        //         $update_info = [
                        //             "site_id" => 2000,
                        //             "listings" => $onbuy_products
                        //         ];
                        //         $product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                        //         $url = "https://api.onbuy.com/v2/listings/by-sku";
                        //         $post_data = $product_info;
                        //         $method = "PUT";
                        //         $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                        //         $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                        //         $data = json_decode($result_info);
                        //         $update_info = OnbuyVariationProducts::where('id', $onbuy_product_info->id)->update([
                        //             'stock' => $updated_new_quantity
                        //         ]);
                        //     }
                        // }
                        // ProductVariation::where('id', $variation_info->id)->update([
                        //     'actual_quantity' => $updated_new_quantity
                        // ]);
                        $deleteInfo = ProductOrder::find($orderProductRowInfo->id)->delete();
                        return response()->json(['type' => 'success', 'msg' => 'Product deleted from order successfully']);
                    }
                } catch (\Exception $exception) {
                    return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
                }
            }else{
                return response()->json(['type' => 'warning', 'msg' => 'No product found']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something went wrong']);
        }
    }

    public function getPickedProduct($id){
        try{
            $orderProductInfo = ProductOrder::find($id);
            $shelf_info = ShelfedProduct::select('id','quantity','shelf_id','variation_id')->with(['shelf_info:id,shelf_name'])->where('variation_id', $orderProductInfo->variation_id)->get();
            return response()->json(['type' => 'success', 'data' => $shelf_info]);
        }catch (\Exception $ex){
            return response()->json(['type' => 'error','msg' => 'Something went wrong']);
        }
    }

    public function orderCancelReason(){
        try{
            $allOrderCancelReason = CancelReason::all();
            $content = view('order.order_cancel_reason',compact('allOrderCancelReason'));
            return view('master',compact('content'));
        }catch (\Exception $e){
            return redirect('exception')->with('exception',$e->getMessage());
        }
    }

    public function addOrderCancelReason(Request $request){
        try{
            $insertInfo = CancelReason::create($request->all());
            return response()->json(['type' => 'success', 'msg' => 'Successfully added', 'data' => $insertInfo]);
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
        }
    }

    public function updateOrderCancelReason(Request $request){
        try{
            $updateInfo = CancelReason::where('id',$request->id)->update(['reason' => $request->reason,'increment_quantity' => $request->incQuantity]);
            return response()->json(['type' => 'success', 'msg' => 'Successfully updated', 'data' => $updateInfo]);
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
        }
    }

    public function deleteOrderCancelReason(Request $request){
        try{
            $deleteInfo = CancelReason::destroy($request->id);
            return response()->json(['type' => 'success', 'msg' => 'Successfully deleted', 'data' => $deleteInfo]);
        }catch(\Exception $e){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
        }
    }

    public function validateUploadOrderProductCSV(Request $request){
        try{
            $csvData = $this->csvToArray($request->csvFile);
            if($csvData) return response()->json(['type' => 'success', 'result' => $csvData]);
            else return response()->json(['type' => 'error', 'msg' => 'Something went wrong. Please try again']);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong. Please try again']);
        }
    }

    public function csvToArray($fileName = '', $delimeter = ','){
        if(!file_exists($fileName) && !is_readable($fileName)){
            return false;
        }
        $header = null;
        $orderableProducts = [];
        $exception = [];
        $allProducts = [];
        $reason = '';
        if(($handle = fopen($fileName, 'r')) !== false){
            while(($row = fgetcsv($handle, $delimeter)) !== false){
                if(!$header){
                    //$header = $row;
                    $header[] = 'customer';
                    $header[] = 'sku';
                    $header[] = 'quantity';
                    $header[] = 'price';
                    $header[] = 'total_price';
                    //return $header;
                }
                else{
                    // return $header;
                    if(is_numeric($row[2]) && $row[2] > 0){
                        $existVariation = ProductVariation::where('sku',$row[1])->first();
                        if($existVariation){
                            $checkQuantity = new CheckQuantity();

                            if($checkQuantity->getUpdateAvailableQuantity($existVariation->id) >= $row[2]){
                                $orderableProducts[] = array_combine($header, $row);
                                $reason = '';
                            }else{
                                $reason = 'Ordered quantity is greater than available quantity';
                                $exception[] = $this->uploadCSVFormattedData($row, $reason);
                            }
                        }else{
                            $reason = 'Invalid SKU';
                            $exception[] = $this->uploadCSVFormattedData($row, $reason);
                        }

                    }else {
                        $reason = 'Invalid Value';
                        $exception[] = $this->uploadCSVFormattedData($row, $reason);
                    }
                    // fputcsv($fp, [$row[0],$row[1],$reason]);
                    $allProducts[] = $this->uploadCSVFormattedData($row, $reason);
                }
                //return $header;
            }
            fclose($handle);
        }
        //return $exception;
        $csvPath = '';
        $total_price = 0;
        $customer = '';
        if(count($allProducts) > 0){
            $csvPath = asset('assets/order-csv/mismatch-products.csv');
            // return $csvPath;
            if(file_exists($csvPath))
                unlink($csvPath);
            // Open a file in write mode ('w')
            // $fp = fopen('public/'.date("d-m-Y-H-i-s").'-'.'mismatch-products.csv', 'w');
            $fp = fopen('assets/order-csv/mismatch-products.csv', 'w');
            // Loop through file pointer and a line
            fputcsv($fp, ['customer','sku','quantity','price','total_price','reason']);
            $i = 1;
            foreach ($allProducts as $fields) {
                $total_price += ($fields['total_price'] != '') ? $fields['total_price'] : 0;
                $customer = ($customer == '') ? $fields['customer'] : $customer;
                fputcsv($fp, [($i == 1) ? $fields['customer'] : '',$fields['sku'],$fields['quantity'],$fields['price'],$fields['total_price'],$fields['reason']]);
                $i++;
            }
            fclose($fp);
        }
        $parsedCSVInfo['orderable_products'] = $orderableProducts;
        $parsedCSVInfo['mismatch_products'] = $exception;
        $parsedCSVInfo['customer'] = $customer;
        $parsedCSVInfo['total_price'] = $total_price;
        $parsedCSVInfo['csv_link'] = $csvPath;
        return $parsedCSVInfo;
    }

    public function uploadCSVFormattedData($row, $reason){
        $arrInfo = [
            'customer' => $row[0],
            'sku' => $row[1],
            'quantity' => $row[2],
            'price' => $row[3],
            'total_price' => $row[4],
            'reason' => $reason
        ];
        return $arrInfo;
    }

    public function orderProductUpdate($orderIds){
        $shelfId = Shelf::first()->id;
        if ($shelfId) {
            foreach($orderIds as $id){
                $orderedProduct = ProductOrder::where('order_id',$id)->get();
                if(count($orderedProduct) > 0){
                    foreach($orderedProduct as $product){
                        $productShelfInfo = ShelfedProduct::where('variation_id', $product->variation_id)
                            ->where('quantity', '>=', $product->quantity)->first();
                        if ($productShelfInfo) {
                            $updateInfo = ShelfedProduct::find($productShelfInfo->id)->update([
                                'quantity' => $productShelfInfo->quantity - $product->quantity
                            ]);
                        }else{
                            $this->remainQuantity($product->variation_id, $product->quantity);
                        }
                    }
                }
            }
        }
        $updateProductOrder = ProductOrder::whereIn('order_id', $orderIds)->update([
            'picked_quantity' => DB::raw("`quantity`"),
            'status' => 1
        ]);
    }

    public function remainQuantity($id, $remainQuantity){
        $productShelfInfo = ShelfedProduct::where('variation_id', $id)
        ->where('quantity', '>', 0)->first();
        if($productShelfInfo){
            $remainQuantity = $remainQuantity - $productShelfInfo->quantity;
            if($remainQuantity > 0){
                $updateInfo = ShelfedProduct::find($productShelfInfo->id)->update([
                    'quantity' => 0
                ]);
                return $this->remainQuantity($id, $remainQuantity);
            }else{
                $updateInfo = ShelfedProduct::find($productShelfInfo->id)->update([
                    'quantity' => 0 - $remainQuantity
                ]);
            }
        }
    }

// this function for invoice
    public function showpage($order_number, $inv_no){
                try{
                $inv_no;
                $all_pending_order = Order::where('order_number', $order_number)->get();
                $auth_info = Auth::user();
                $client = Client::first();
                $InvoiceSetting = InvoiceSetting::first();

                $pdf = PDF::loadView('order.index-pdf', compact('all_pending_order','auth_info','client','inv_no','InvoiceSetting'));
                return $pdf->download($order_number.'.pdf');
            }catch(\Exception $exception){
                return redirect('exception')->with('exception',$exception->getMessage());
            }

                // return view('order.index-pdf', ['all_pending_order' => $all_pending_order, 'auth_info' => $auth_info, 'client' => $client, 'inv_no' => $inv_no, 'InvoiceSetting' => $InvoiceSetting]);


        // return view('order.test_pdf_view', compact('data'));
    }

    public function readBuyerMessage($orderId){
        try{
            $orderInfo = Order::find($orderId);
            if($orderInfo){
                $orderInfo->is_buyer_message_read = 1;
                $orderInfo->save();
                return response()->json(['type' => 'success', 'msg' => 'Buyer Message Read Successfully']);
            }else{
                return response()->json(['type' => 'error', 'Order Not Found']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function groupCataloguePickerAssign(Request $request){
        try{
            if($request->order_filter_type == 'group_by_catalogue'){
                $catalogueArr = $request->multiple_order;
                $productVariation = ProductVariation::select('id')->whereIn('product_draft_id',$catalogueArr)->get()->toArray();
                $orderProduct = ProductOrder::whereHas('order', function($query){
                    $query->where('status','processing')->where('picker_id',null);
                })->groupBy('order_id')->whereIn('variation_id',$productVariation)->pluck('order_id');
                if(count($orderProduct) > 0){
                    $orderAssingToPicker = Order::whereIn('id',$orderProduct)->update(['picker_id' => $request->picker_id, 'assigner_id' => Auth::id()]);
                    return response()->json(['type' => 'success', 'message' => 'Order Assigned Successfully Of This Catalogue']);
                }else{
                    return response()->json(['type' => 'error', 'message' => 'No Order Found']);
                }
            }elseif($request->order_filter_type == 'order_by_shelf'){
                $orderAssingToPicker = Order::whereIn('id',$request->multiple_order)->where('picker_id',null)->update(['picker_id' => $request->picker_id, 'assigner_id' => Auth::id()]);
                return response()->json(['type' => 'success', 'message' => 'Order Assigned Successfully']);
            }elseif($request->order_filter_type == 'group_by_sku'){
                $groupBySku = ProductOrder::whereHas('order', function($query){
                    $query->where('status','processing')->where('picker_id',null);
                })->whereIn('variation_id',$request->multiple_order)->pluck('order_id');
                $orderAssingToPicker = Order::whereIn('id',$groupBySku)->update(['picker_id' => $request->picker_id, 'assigner_id' => Auth::id()]);
                return response()->json(['type' => 'success', 'message' => 'Order Assigned Successfully']);
            }elseif($request->order_filter_type == 'order_by_postcode'){
                $customer_order_by_phone_post = Order::whereIn('shipping_post_code',$request->multiple_order)->where([['status', 'processing'],['picker_id',null],['shipping_post_code','!=',null]])->pluck('id');
                $orderAssingToPicker = Order::whereIn('id',$customer_order_by_phone_post)->update(['picker_id' => $request->picker_id, 'assigner_id' => Auth::id()]);
                return response()->json(['type' => 'success', 'message' => 'Order Assigned Successfully']);
            }
            elseif($request->order_filter_type == 'assigned-order'){
                $orderProduct = $this->getUnpickedOrderIds($request->multiple_order);
                $orderAssingToPicker = Order::whereIn('id',$orderProduct)->where('status','processing')->update(['picker_id' => $request->picker_id, 'assigner_id' => Auth::id()]);
                return response()->json(['type' => 'success', 'message' => 'Order Assigned Successfully']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'message' => 'Something Went Wrong']);
        }
    }

    public function allChannels(){
        $wooChannel = WoocommerceAccount::get()->all();
        $onbuyChannel = OnbuyAccount::get()->all();
        $ebayChannel = EbayAccount::get()->all();
        $amazonChannel = AmazonAccountApplication::with(['accountInfo','marketPlace'])->get();
        $allChannels = [];
        if($ebayChannel){
            foreach ($ebayChannel as $ebay){
                $allChannels[] = [
                    'account' => 'ebay/'.$ebay->account_name,
                    'channel' => $ebay->account_name
                ];
            }
        }
        if($wooChannel){
            foreach ($wooChannel as $woo){
                $allChannels[] = [
                    'account' => 'checkout/'.$woo->account_name,
                    'channel' => $woo->account_name
                ];
            }
        }
        if($onbuyChannel){
            foreach ($onbuyChannel as $onbuy){
                $allChannels[] = [
                    'account' => 'onbuy/'.$onbuy->account_name,
                    'channel' => $onbuy->account_name
                ];
            }
        }
        if($amazonChannel){
            if(count($amazonChannel) > 0){
                foreach($amazonChannel as $amazon){
                    $allChannels[] = [
                        'account' => 'amazon/'.$amazon->application_name.'('.$amazon->accountInfo->account_name.' '.$amazon->marketPlace->marketplace.')',
                        'channel' => $amazon->application_name.'('.$amazon->accountInfo->account_name.' '.$amazon->marketPlace->marketplace.')'
                    ];
                }
            }
        }
        return $allChannels;
    }

    public function filterOrderExportCsv(Request $request){
        try{
            
            if($request->filter_order_type == 'order-by-shelf'){
                $filename = "filter-order.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','CUSTOMER NAME','POSTCODE','COUNTRY','TITLE','SKU','VARIATION','ORDER QUANTITY','SHELF']);
                if(count($request->multiple_order) > 0){
                    foreach($request->multiple_order as $order_id){
                        $this->singleOrderInfo($order_id,$handle);
                    }
                }
                fclose($handle);
            }elseif($request->filter_order_type == 'group-by-catalogue'){
                $filename = "filter-order.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','CUSTOMER NAME','POSTCODE','COUNTRY','TITLE','SKU','VARIATION','ORDER QUANTITY','SHELF']);
                $catalogueArr = $request->multiple_order;
                $productVariation = ProductVariation::select('id')->whereIn('product_draft_id',$catalogueArr)->get()->toArray();
                $orderProduct = ProductOrder::whereHas('order', function($query){
                    $query->where('status','processing')->where('picker_id','!=',null);
                })->groupBy('order_id')->whereIn('variation_id',$productVariation)->pluck('order_id');
                if(count($orderProduct) > 0){
                    foreach($orderProduct as $order_id){
                        $this->singleOrderInfo($order_id,$handle);
                    }
                }
                fclose($handle);
            }elseif($request->filter_order_type == 'group-by-sku'){
                $filename = "filter-order.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','CUSTOMER NAME','POSTCODE','COUNTRY','TITLE','SKU','VARIATION','ORDER QUANTITY','SHELF']);
                $groupBySku = ProductOrder::whereHas('order', function($query){
                    $query->where('status','processing')->where('picker_id','!=',null);
                })->whereIn('variation_id',$request->multiple_order)->pluck('order_id');
                if(count($groupBySku) > 0){
                    foreach($groupBySku as $order_id){
                        $this->singleOrderInfo($order_id,$handle);
                    }
                }
                fclose($handle);
            }elseif($request->filter_order_type == 'order-by-postcode'){
                $filename = "filter-order.csv";
                $handle = fopen($filename, 'w+');
                fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','CUSTOMER NAME','POSTCODE','COUNTRY','TITLE','SKU','VARIATION','ORDER QUANTITY','SHELF']);
                $postcodes = $request->multiple_order;
                if(count($postcodes) > 0){
                    foreach($postcodes as $postcode){
                        $customer_order_by_phone_post = Order::where([['status', 'processing'],['picker_id','!=',null],['shipping_post_code',$postcode],['shipping_post_code','!=',null]])->pluck('id');
                        if(count($customer_order_by_phone_post) > 0){
                            foreach($customer_order_by_phone_post as $order_id){
                                $this->singleOrderInfo($order_id,$handle);
                            }
                        }
                    }
                }
                fclose($handle);
            }
            elseif($request->filter_order_type == 'assigned-order-csv'){
                $unpickedOrderProduct = $this->getUnpickedOrderIds($request->multiple_order);
                if(count($unpickedOrderProduct) > 0){
                    $time = date('d-m-Y-h-i-s');
                    $filename = "Export-Order-".$time.".csv";
                    $handle = fopen($filename, 'w+');
                    fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','TITLE','SKU','QUANTITY','NAME','ADDRESS_LINE1','ADDRESS_LINE2','ADDRESS_LINE3',
                    'CITY','COUNTY','POSTCODE','COUNTRY','PHONE','EMAIL']);
                    // foreach($orderProduct as $order_id){
                    //     $this->singleOrderInfo($order_id,$handle);
                    // }
                    $conditionArr = [
                        [
                            'column' => 'id',
                            'operator' => null,
                            'value' => $unpickedOrderProduct
                        ]
                    ];
                    $orderProduct = $this->getOrderCSV($conditionArr);
                    foreach($orderProduct as $product){
                        $channel = $this->accountInfo($product->created_via,$product->account_id);
                        $onceDone = false;
                        foreach($product->orderedProduct as $orderp){
                            if($onceDone == false){
                                fputcsv($handle,[$product->order_number,$product->date_created,$channel->account_name ?? null,$orderp->name ?? null,
                                $orderp->variation_info->sku,$orderp->quantity,$product->shipping_user_name,$product->shipping_address_line_1,$product->shipping_address_line_2,$product->shipping_address_line_3,
                                $product->shipping_city,$product->shipping_county,$product->shipping_post_code,$product->shipping_country,$product->shipping_phone,$product->customer_email]);
                                $onceDone = true;
                            }else{
                                fputcsv($handle,[NULL,NULL,NULL,$orderp->name ?? null,
                                $orderp->variation_info->sku,$orderp->quantity,NULL,
                                NULL,NULL,NULL,NULL,NULL,NULL,
                                NULL,NULL,NULL]);
                            }
                        }
                    }
                    fclose($handle);
                }
            }
            elseif($request->filter_order_type == 'awating-dispatch-order-csv'){
                $conditionArr = [
                    [
                        'column' => 'status',
                        'operator' => null,
                        'value' => 'processing'
                    ],
                    [
                        'column' => 'picker_id',
                        'operator' => null,
                        'value' => null
                    ],
                ];
                $orderProduct = $this->getOrderCSV($conditionArr,$request->multiple_order);
                if(count($orderProduct) > 0){
                    $time = date('d-m-Y-h-i-s');
                    $filename = "Export-Order-".$time.".csv";
                    $handle = fopen($filename, 'w+');
                    fputcsv($handle, ['ORDER NUMBER','ORDER DATE','CHANNEL','TITLE','SKU','QUANTITY','NAME','ADDRESS_LINE1','ADDRESS_LINE2','ADDRESS_LINE3',
                    'CITY','COUNTY','POSTCODE','COUNTRY','PHONE','EMAIL']);
                    foreach($orderProduct as $product){
                        $channel = $this->accountInfo($product->created_via,$product->account_id);
                        $onceDone = false;
                        foreach($product->orderedProduct as $orderp){
                            if($onceDone == false){
                                fputcsv($handle,[$product->order_number,$product->date_created,$channel->account_name ?? null,$orderp->name ?? null,
                                $orderp->variation_info->sku,$orderp->quantity,$product->shipping_user_name,$product->shipping_address_line_1,$product->shipping_address_line_2,$product->shipping_address_line_3,
                                $product->shipping_city,$product->shipping_county,$product->shipping_post_code,$product->shipping_country,$product->shipping_phone,$product->customer_email]);
                                $onceDone = true;
                            }else{
                                fputcsv($handle,[NULL,NULL,NULL,$orderp->name ?? null,
                                $orderp->variation_info->sku,$orderp->quantity,NULL,
                                NULL,NULL,NULL,NULL,NULL,NULL,
                                NULL,NULL,NULL]);
                            }
                        }
                    }
                    fclose($handle);
                }
            }
            
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return response()->json(['type' => 'success', 'url' => asset('/').$filename, 'file_name' => $filename]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'message' => 'Something Went Wrong']);
        }
    }

    //This function is for single order informatin with shelf information
    public function singleOrderInfo($order_id,$handle = null){
        $product_info = Order::with(['productOrders' => function ($query) {
            $query->with(['shelf_quantity' => function($query){
                $query->orderBy('shelf_name','ASC')->wherePivot('quantity','>',0);
            },'product_draft' => function($query_image){
                $query_image->with('single_image_info');
            }])->wherePivot('status',0);
        }])->where('picker_id','!=',null)->where('id',$order_id)->first();
        $this->putOrderInfoInCsv($product_info,$handle);
    }

    //This function is for putting order information in csv
    public function putOrderInfoInCsv($product_info,$handle){
        if($product_info){
            if(count($product_info->productOrders) > 0){
                $accountInfo = $product_info->created_via ? $this->accountInfo($product_info->created_via, $product_info->account_id) : null;
                foreach($product_info->productOrders as $order){
                    $shelf = '';
                    if(count($order->shelf_quantity) > 0){
                        foreach($order->shelf_quantity as $shelf_q){
                            $shelf .= $shelf_q->shelf_name.'('.$shelf_q->pivot->quantity.'),';
                        }
                    }
                    $variation = '';
                    if(is_array(unserialize($order->attribute))){
                        foreach(unserialize($order->attribute) as $att){
                            $variation .= $att['attribute_name'].'->'.$att['terms_name'].',';
                        }
                    }
                    fputcsv($handle, [$product_info->order_number ?? '',$product_info->date_created ? date('d-m-Y:H:i:s', strtotime($product_info->date_created)) : '', $accountInfo ? $accountInfo->account_name.'('.$product_info->created_via.')' : $product_info->created_via,
                    $product_info->customer_name ?? '',$product_info->shipping_post_code ?? '',$product_info->customer_country ?? '',
                    $order->pivot->name ?? '',$order->sku ?? '',rtrim($variation,','),$order->pivot->quantity ?? '',rtrim($shelf,',')]);
                }
            }
        }
    }

    public function getUnpickedOrderIds($orderIds){
        $orderProduct = ProductOrder::whereHas('order', function($query){
            $query->where('status','processing')->where('picker_id','!=',null);
        })->whereIn('order_id',$orderIds)->groupBy('order_id')->pluck('order_id');
        return $orderProduct;
    }

    public function getPickedOrderIds($orderIds){
        $orderProduct = ProductOrder::whereHas('order', function($query){
            $query->where('status','processing')->where('picker_id','!=',null);
        })->where('status',0)->whereIn('order_id',$orderIds)->groupBy('order_id')->pluck('order_id')->toArray();
        $pickedOrderIds = array_diff($orderIds, $orderProduct);
        return $pickedOrderIds;
    }


    public function getScanningSkuResult(Request $request){

        $product_data = ProductVariation::where('sku', '=', $request->sku)->first();
        $master_product = ProductDraft::where('id', '=', $product_data->product_draft_id)->first();
        $attribute = unserialize($product_data->attribute);
        return response()->json([
            "product_id" => $product_data->id,
            "sku" => $product_data->sku,
            "sale_price" => $product_data->sale_price,
            "actual_qty" => $product_data->actual_quantity,
            "item_name" => $master_product->name,
            "attribute" => $attribute
        ]);

    }



}
