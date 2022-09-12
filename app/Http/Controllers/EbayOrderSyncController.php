<?php

namespace App\Http\Controllers;

use App\Client;
use App\DeveloperAccount;
use App\EbayVariationProduct;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\OnbuyAccount;
use App\OnbuyVariationProducts;
use App\Order;
use App\ProductOrder;
use App\ProductVariation;
use App\Shelf;
use App\ShelfedProduct;
use App\woocommerce\WoocommerceVariation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EbayAccount;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use DB;
use Illuminate\Support\Facades\Session;

class EbayOrderSyncController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Europe/London');
        ini_set('max_execution_time', '5000');
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
    public function syncOrderFromEbayClicked(Request $request,$type = "corn"){

        $date = isset($request->date) ? $_GET['date'] : null;

        $account_results = EbayAccount::with('developerAccount','sites')->get();
        $shelfUse = Session::get('shelf_use');
        if($shelfUse == ''){
            $shelfUse = Client::first()->shelf_use ?? null;
        }
        $created_at = '';

        if ($type == 'corn'){
            $current_zulu_time = Carbon::now()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            $hour_sub_zulu_time = Carbon::now()->subHour(1)->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            $created_at = '<CreateTimeFrom>'.$hour_sub_zulu_time.'</CreateTimeFrom>
                          <CreateTimeTo>'.$current_zulu_time.'</CreateTimeTo>';
        }elseif ($type=='form'){
            $created_at = '<CreateTimeFrom>'.$date.'T00:00:00.000Z</CreateTimeFrom>
                            <CreateTimeTo>'.$date.'T23:59:59.000Z</CreateTimeTo>';
        }

        $created_at = '';

        if ($type == 'corn'){
            $current_zulu_time = Carbon::now()->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            $hour_sub_zulu_time = Carbon::now()->subHour(3)->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
            $created_at = '<CreateTimeFrom>'.$hour_sub_zulu_time.'</CreateTimeFrom>
                          <CreateTimeTo>'.$current_zulu_time.'</CreateTimeTo>';
        }elseif ($type=='form'){
            $created_at = '<CreateTimeFrom>'.$date.'T00:00:00.000Z</CreateTimeFrom>
                            <CreateTimeTo>'.$date.'T23:59:59.000Z</CreateTimeTo>';
        }


        foreach ($account_results as $account_result){
            foreach($account_result->sites as $site){
                $site_id = $site->id;
                $currency = DB::table('ebay_currency')->where('site_id',$site_id)->get()->first();
                $currency = $currency->currency;
                $clientID  = $account_result->developerAccount->client_id;
                $clientSecret  = $account_result->developerAccount->client_secret;
                //dd($token_result->authorization_token);
                $url = 'https://api.ebay.com/identity/v1/oauth2/token';
                $headers = [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

                ];

                $body = http_build_query([
                    'grant_type'   => 'refresh_token',
                    'refresh_token' => $account_result->refresh_token,
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
                if (isset($response['access_token'])){
                    $currentDate = date("Y-m-d");
                    $this->ebay_access_token =  $response['access_token'];
                    $url = 'https://api.ebay.com/ws/api.dll';
                    $headers = [
                        'X-EBAY-API-SITEID:'.$site_id,
                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                        'X-EBAY-API-CALL-NAME:GetOrders',
                        'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
                    ];

                    $body = '<?xml version="1.0" encoding="utf-8"?>
                        <GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <ErrorLanguage>en_US</ErrorLanguage>
                            <WarningLevel>High</WarningLevel>
                          <OrderRole>Seller</OrderRole>
                          <OrderStatus>Completed</OrderStatus>
                          '.$created_at.'
                          <SortingOrder>Descending</SortingOrder>
                        </GetOrdersRequest>';
                    try{
                        $orders = $this->curl($url,$headers,$body,'POST');
                        $orders =simplexml_load_string($orders);
                        $orders = json_decode(json_encode($orders),true);


                        $page = $orders['PaginationResult']['TotalNumberOfPages'];

                        for($i = 1; $i <= $page; $i++){

                            $url = 'https://api.ebay.com/ws/api.dll';
                            $headers = [
                                'X-EBAY-API-SITEID:'.$site_id,
                                'X-EBAY-API-COMPATIBILITY-LEVEL:1211',
                                'X-EBAY-API-CALL-NAME:GetOrders',
                                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_access_token,
                            ];

                            $body = '<?xml version="1.0" encoding="utf-8"?>
                            <GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <ErrorLanguage>en_US</ErrorLanguage>
                                <WarningLevel>High</WarningLevel>
                                <Pagination>
                                    <PageNumber>'.$i.'</PageNumber>
                                </Pagination>
                              <OrderRole>Seller</OrderRole>
                                <OrderStatus>Completed</OrderStatus>
                              '.$created_at.'
                              <SortingOrder>Descending</SortingOrder>
                            </GetOrdersRequest>';

                            $orders = $this->curl($url,$headers,$body,'POST');
                            $orders =simplexml_load_string($orders);
                            $orders = json_decode(json_encode($orders),true);




                            if (isset($orders['OrderArray'])){
                                if (isset($orders['OrderArray']['Order'][0])){
                                    foreach ($orders['OrderArray']['Order'] as $order){


//                                        Log::info($order['OrderID']);

                                        if(!isset($order['ShippedTime'])){
                                            $order_find_result = Order::where('order_number',$order['OrderID'])->get()->first();
                                            if ($order_find_result == null){
                                                $order_array = null;
                                                $product_order_array = null;
                                                $stateOrProvince = null;
                                                $temp = [];

                                                if (gettype($order['ShippingAddress']['Name']) != 'array'){
                                                    $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['Name'] . '</h7></div></div>';
                                                }
                                                if (gettype($order['ShippingAddress']['Street1']) != 'array'){
                                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['Street1'] .'</h7></div></div>';
                                                }
                                                if (gettype($order['ShippingAddress']['CityName']) != 'array'){
                                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['CityName'] . '</h7></div></div>';
                                                }

                                                if (gettype($order['ShippingAddress']['StateOrProvince']) != 'array'){
                                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['StateOrProvince'] . '</h7></div></div>';
                                                }

                                                if (gettype($order['ShippingAddress']['PostalCode']) != 'array'){
                                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['PostalCode'] . '</h7></div></div>';
                                                }

                                                if (gettype($order['ShippingAddress']['CountryName']) != 'array'){
                                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $order['ShippingAddress']['CountryName'] . '</h7></div></div>';
                                                }

//                                                echo "<pre>";
//                                                $temp = serialize($order['TransactionArray']['Transaction']['Taxes']);
//                                                print_r(unserialize($temp));
//                                                exit();
                                                $eBayCollectAndRemitTaxes = null;
                                                if (isset($order['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes'])){
                                                    if ($order['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes']["TotalTaxAmount"] != "0.0"){
                                                        $eBayCollectAndRemitTaxes = serialize($order['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes']);
                                                    }
                                                }

                                                while (true){
                                                    $ebay_id = rand(1,1000000);
                                                    $order_result = Order::find($ebay_id);
                                                    if ($order_result == null){
                                                        break;
                                                    }
                                                }
                                                $email ='';
                                                if(isset($order['TransactionArray']['Transaction']['Buyer']['Email'])){
                                                    $email = $order['TransactionArray']['Transaction']['Buyer']['Email'];

                                                }elseif(isset($order['TransactionArray']['Transaction'][0])){
                                                    $email =$order['TransactionArray']['Transaction'][0]['Buyer']['Email'];
                                                }


                                                $transaction_id ='';
                                                if(isset($order['TransactionArray']['Transaction'][0]['TransactionID'])){
                                                    $transaction_id = $order['TransactionArray']['Transaction'][0]['TransactionID'];
                                                }elseif(isset($order['TransactionArray']['Transaction']['TransactionID'])){
                                                    $transaction_id = $order['TransactionArray']['Transaction']['TransactionID'];
                                                }
                                                if (isset($order['ShippingServiceSelected']['ShippingServiceCost'])){
                                                    $shipping_method =[
                                                        'id' => '',
                                                        'method_title' =>'',
                                                        'method_id' => '',
                                                        'instance_id' => '',
                                                        'total' => isset($order['ShippingServiceSelected']['ShippingServiceCost']) ? $order['ShippingServiceSelected']['ShippingServiceCost'] : 0.0,
                                                        'total_tax'=>'',
                                                        'taxes' => [],
                                                        'meta_data' => []

                                                    ];
                                                }
                                                else{
                                                    $shipping_method = '';
                                                }

                                                try{
                                                    $order_result = Order::insert([
                                                        'id' => $ebay_id,
                                                        'order_number' => (gettype($order['OrderID']) == 'array') ? null :  $order['OrderID'],
                                                        'ebay_order_id' => (gettype($order['ExtendedOrderID']) == 'array') ? null :  $order['ExtendedOrderID'],
                                                        'status' =>  'processing' ,
                                                        'created_via' => 'Ebay',
                                                        'buyer_message' => isset($order['BuyerCheckoutMessage']) ? $order['BuyerCheckoutMessage'] : '',
                                                        'is_buyer_message_read' => isset($order['BuyerCheckoutMessage']) ? 0 : null,
                                                        'account_id' => $account_result->id,
                                                        'currency' => $currency,
                                                        'total_price' =>(gettype($order['Total']) == 'array') ? null : $order['Total'],
                                                        //'customer_id' => $info->,
                                                        'customer_name' => (gettype($order['ShippingAddress']['Name']) == 'array') ? null : $order['ShippingAddress']['Name'],
                                                        'customer_email' => $email,
                                                        'customer_phone' => (gettype($order['ShippingAddress']['Phone'] ) == 'array') ? null : $order['ShippingAddress']['Phone'],
                                                        'customer_country' => (gettype($order['ShippingAddress']['Country']) == 'array') ? null : $order['ShippingAddress']['Country'],
                                                        'customer_city' =>(gettype($order['ShippingAddress']['CityName']) == 'array') ? null : $order['ShippingAddress']['CityName'],
                                                        'customer_zip_code' =>(gettype($order['ShippingAddress']['PostalCode']) == 'array') ? null : $order['ShippingAddress']['PostalCode'],
                                                        'customer_state' => (gettype($order['ShippingAddress']['StateOrProvince']) == 'array') ? null : $order['ShippingAddress']['StateOrProvince'],
                                                        'ebay_user_id' => $order['BuyerUserID'] ?? null,
                                                        'shipping' => $shipping,
                                                        // 'shipping_method' => \Opis\Closure\serialize($shipping_method),
                                                        'shipping_method' => isset($order['ShippingServiceSelected']['ShippingServiceCost']) ? $order['ShippingServiceSelected']['ShippingServiceCost'] : null,
                                                        'shipping_post_code' => (gettype($order['ShippingAddress']['PostalCode']) == 'array') ? null : $order['ShippingAddress']['PostalCode'],
                                                        //'tracking_number' => $info->,
                                                        'date_created' =>date('Y-m-d H:i:s', strtotime($order['CreatedTime'])),
                                                        'created_at'=> Carbon::now(),
                                                        'updated_at'=> Carbon::now(),
                                                        //'date_completed' => $info->,
                                                        'payment_method' => (gettype($order['CheckoutStatus']['PaymentMethod']) == 'array') ? null : $order['CheckoutStatus']['PaymentMethod'],
                                                        'transaction_id' => $transaction_id,
                                                        'shipping_user_name' => (gettype($order['ShippingAddress']['Name']) == 'array') ? null : $order['ShippingAddress']['Name'],
                                                        'shipping_phone' => (gettype($order['ShippingAddress']['Phone'] ) == 'array') ? null : $order['ShippingAddress']['Phone'],
                                                        'shipping_city' => (gettype($order['ShippingAddress']['CityName']) == 'array') ? null : $order['ShippingAddress']['CityName'],
                                                        'shipping_county' => (gettype($order['ShippingAddress']['StateOrProvince']) == 'array') ? null : $order['ShippingAddress']['StateOrProvince'],
                                                        'shipping_country' => (gettype($order['ShippingAddress']['Country']) == 'array') ? null : $order['ShippingAddress']['Country'],
                                                        'shipping_address_line_1' => (gettype($order['ShippingAddress']['Street1']) == 'array') ? null : $order['ShippingAddress']['Street1'],
                                                        'shipping_address_line_2' => (gettype($order['ShippingAddress']['Street2']) == 'array') ? null : $order['ShippingAddress']['Street2'],
                                                        'shipping_address_line_3' => null,
                                                        "ebay_tax_reference" => $eBayCollectAndRemitTaxes,
                                                    ]);
                                                }catch(Exception $e){
                                                    return $e;
                                                }
                                                // echo "<pre>";
                                                //                 print_r($order);
                                                //                 exit();
                                                if (isset($order['TransactionArray']['Transaction'][0])){
                                                    foreach ($order['TransactionArray']['Transaction'] as $product){
                                                        try{

                                                            if (gettype($product['Variation']['SKU']) != 'Array' ){
                                                                $product_variation_result = ProductVariation::where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                                //$woo_variation_result = WoocommerceVariation::where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                                //$ebay_variation_result = EbayVariationProduct::with(['masterProduct'])->where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                                //$onbuy_variation_result = OnbuyVariationProducts::where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                                // echo "<pre>";
                                                                // print_r($product);
                                                                // exit();
                                                                $product_order_result = ProductOrder::insert([
                                                                    'order_id'=> $ebay_id,
                                                                    'variation_id'=> $product_variation_result->id,
                                                                    'name'=> (gettype($product['Item']['Title']) == 'array') ? null : $product['Item']['Title'],
                                                                    'quantity'=> (gettype($product['QuantityPurchased']) == 'array') ? 0 : $product['QuantityPurchased'],
                                                                    'price'=> (gettype($product['TransactionPrice']) == 'array') ? null : $product['TransactionPrice'],
                                                                    'status'=> 0,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now(),
                                                                ]);
                                                                if ($product_variation_result != null){
                                                                    $check_quantity = new CheckQuantity();
                                                                    $check_quantity->checkQuantity($product['Variation']['SKU'],null,null,'Auto Sync',(gettype($product['QuantityPurchased']) == 'array') ? null : $product['QuantityPurchased'],false,$account_result->id);
                                                                    //$update_quantity = $product_variation_result->actual_quantity - $product['QuantityPurchased'];
//                                                                    ProductVariation::where('sku',$product['Variation']['SKU'])->update(['actual_quantity'=>$update_quantity]);
//                                                                    if($shelfUse == 0){
//                                                                        $shelfId = Shelf::first()->id;
//                                                                        if($shelfId) {
//                                                                            $productShelfInfo = ShelfedProduct::where('shelf_id', $shelfId)
//                                                                                ->where('variation_id', $product_variation_result->id)
//                                                                                ->where('quantity', '>', 0)->first();
//                                                                            if ($productShelfInfo) {
//                                                                                $newQuantity = $productShelfInfo->quantity - $product['QuantityPurchased'];
//                                                                                $updateInfo = ShelfedProduct::find($productShelfInfo->id)->update([
//                                                                                    'quantity' => $newQuantity
//                                                                                ]);
//                                                                            }
//                                                                        }
//                                                                    }


                                                                    // $woocom_get_result = Woocommerce::get('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id);
//                                                                    $variation_data = [
//                                                                        'stock_quantity' => $update_quantity,
//                                                                    ];
//                                                                    if ($woo_variation_result != null){
//                                                                        try{
//
//                                                                            $woocom_put_result = Woocommerce::put('products/'.$woo_variation_result->woocom_master_product_id.'/variations/'.$woo_variation_result->id,$variation_data);
//                                                                            $woo_update_info = WoocommerceVariation::where('id',$woo_variation_result->id)->update(['actual_quantity' => $update_quantity]);
//                                                                        }catch (Exception $exception){
////                                continue;
//                                                                            continue;
//                                                                        }
//                                                                    }

//                                                                    if ($ebay_variation_result !=null){
//                                                                        try{
//                                                                            if($update_quantity >=0){
//                                                                                $ebay_result = $this->updateEbayQuantity($product['Variation']['SKU'],$update_quantity);
//                                                                            }
//
//                                                                            $ebay_update_info = EbayVariationProduct::where('sku',$product['Variation']['SKU'])->update(['quantity' => $update_quantity]);
//                                                                        }catch (Exception $exception){
//                                                                            continue;
//                                                                        }
//                                                                    }
//                                                                    if ($onbuy_variation_result !=null){
//                                                                        try{
//
//                                                                            $this->updateOnbuyQuantity($update_quantity,$product['Variation']['SKU']);
//                                                                            OnbuyVariationProducts::where('sku',$product['Variation']['SKU'])->update(['stock'=>$update_quantity]);
//                                                                        }catch(Exception $e){
//                                                                            continue;
//                                                                        }
//                                                                    }



                                                                }
                                                            }else{
                                                                $product_variation_result = ProductVariation::where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'])->get()->first();
                                                                try{
                                                                    if ($product_variation_result != null){
                                                                        $product_order_result = ProductOrder::insert([
                                                                            'order_id'=> $ebay_id,
                                                                            'variation_id'=> $product_variation_result->id,
                                                                            'name'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['Title']) == 'array') ? null : $order['TransactionArray']['Transaction']['Item']['Title'],
                                                                            'quantity'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $order['TransactionArray']['Transaction']['QuantityPurchased'],
                                                                            'price'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionPrice']) == 'array') ? null : $order['TransactionArray']['Transaction']['TransactionPrice'],
                                                                            'status'=> 0,
                                                                            'created_at'=> Carbon::now(),
                                                                            'updated_at'=> Carbon::now(),
                                                                        ]);
                                                                        $check_quantity = new CheckQuantity();

                                                                        if (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                                            $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                        }elseif (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'])){
                                                                            $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                        }

                                                                    }
                                                                }catch(Exception $e){
                                                                    return $e;
                                                                }
                                                            }
                                                        }
                                                        catch(Exception $e){
                                                            return $e;
                                                        }
                                                    }
                                                }
                                                else{

                                                    if (isset($order['TransactionArray']['Transaction']['Variation']['SKU']) || isset($order['TransactionArray']['Transaction']['Item']['SKU'])){
                                                        //                              echo "<pre>";
                                                        // print_r($order['TransactionArray']['Transaction']['Variation']['SKU']);
                                                        // exit();
                                                        if (isset($order['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                            $product_variation_result = ProductVariation::where('sku' ,$order['TransactionArray']['Transaction']['Variation']['SKU'])->get()->first();
                                                        }
                                                        elseif (isset($order['TransactionArray']['Transaction']['Item'])){
                                                            $product_variation_result = ProductVariation::where('sku' ,$order['TransactionArray']['Transaction']['Item']['SKU'])->get()->first();
                                                        }



//                            $ebay_variation_result = json_decode(json_encode($ebay_variation_result));
//                            return  $ebay_variation_result[0]->masterProduct->item_id;
//                            echo "<pre>";
//                            //print_r($order['TransactionArray']['Transaction']['Variation']['SKU']);
//                            print_r($ebay_variation_result->masterProduct);
//                            exit();
                                                        try{
                                                            if ($product_variation_result != null){


                                                                $product_order_result = ProductOrder::insert([
                                                                    'order_id'=> $ebay_id,
                                                                    'variation_id'=> $product_variation_result->id,
                                                                    'name'=> (gettype($order['TransactionArray']['Transaction']['Item']['Title']) == 'array') ? null : $order['TransactionArray']['Transaction']['Item']['Title'],
                                                                    'quantity'=> (gettype($order['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $order['TransactionArray']['Transaction']['QuantityPurchased'],
                                                                    'price'=> (gettype($order['TransactionArray']['Transaction']['TransactionPrice']) == 'array') ? null : $order['TransactionArray']['Transaction']['TransactionPrice'],
                                                                    'status'=> 0,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now(),
                                                                ]);
                                                                $check_quantity = new CheckQuantity();

                                                                if (isset($order['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                                    $check_quantity->checkQuantity($order['TransactionArray']['Transaction']['Variation']['SKU'],null,null,'Auto Sync',(gettype($order['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $order['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                }
                                                                elseif(isset($order['TransactionArray']['Transaction']['Item'])){
                                                                    $check_quantity->checkQuantity($order['TransactionArray']['Transaction']['Item']['SKU'],null,null,'Auto Sync',(gettype($order['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $order['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                }

                                                            }
                                                        }catch(Exception $e){
                                                            return $e;
                                                        }

                                                    }

                                                }
                                            }

                                        }
                                    }
                                }

                                else{
                                    // echo "<pre>";
                                    // print_r($orders);
                                    // exit();
//                                 Log::info(11);
                                    $order_find_result = Order::where('order_number',$orders['OrderArray']['Order']['OrderID'])->get()->first();
                                    if ($order_find_result == null){
//                                     Log::info(12);
                                        $order_array = null;
                                        $product_order_array = null;
                                        $stateOrProvince = null;
                                        $country =null;
                                        $temp = [];
                                        $shipping = null;
                                        if(!isset($order['ShippedTime'])){
                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['Name']) != 'array'){
                                                $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['Name'] . '</h7></div></div>';
                                            }
                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['Street1']) != 'array'){
                                                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['Street1'] .'</h7></div></div>';
                                            }
                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['CityName']) != 'array'){
                                                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['CityName'] . '</h7></div></div>';
                                            }

                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['StateOrProvince']) != 'array'){
                                                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['StateOrProvince'] . '</h7></div></div>';
                                            }

                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['PostalCode']) != 'array'){
                                                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['PostalCode'] . '</h7></div></div>';
                                            }

                                            if (gettype($orders['OrderArray']['Order']['ShippingAddress']['CountryName']) != 'array'){
                                                $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $orders['OrderArray']['Order']['ShippingAddress']['CountryName'] . '</h7></div></div>';
                                            }

                                            while (true){
                                                $ebay_id = rand(1,1000000);
                                                $order_result = Order::find($ebay_id);
                                                if ($order_result == null){
                                                    break;
                                                }
                                            }


                                            //        $shipping .= '<div class="row"><div class="col-4"><h7> Company  </h7></div><div class="col-8"><h7> : '.$order->shipping->company.'</h7></div></div>';
                                            if (isset($order['ShippingAddress']['StateOrProvince'])){
                                                $stateOrProvince = '';
                                            }
                                            if (isset($orders['OrderArray']['Order']['ShippingAddress']['Country'])){
                                                $country = $orders['OrderArray']['Order']['ShippingAddress']['Country'];
                                            }
                                            $eBayCollectAndRemitTaxes = null;
                                            if (isset($orders['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes'])){
                                                if ($orders['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes']["TotalTaxAmount"] != "0.0"){
                                                    $eBayCollectAndRemitTaxes = serialize($orders['TransactionArray']['Transaction']['eBayCollectAndRemitTaxes']);
                                                }
                                            }
//                                         Log::info(13);
                                            $order_result = Order::insert([
                                                'id' => $ebay_id,
                                                'order_number' => $orders['OrderArray']['Order']['OrderID'] ,
                                                'status' =>  'processing' ,
                                                'created_via' => 'Ebay',
                                                'account_id' => $account_result->id,
                                                'currency' => 'GBP',
                                                'buyer_message' => isset($orders['OrderArray']['Order']['BuyerCheckoutMessage']) ? $orders['OrderArray']['Order']['BuyerCheckoutMessage'] : '',
                                                'is_buyer_message_read' => isset($orders['OrderArray']['Order']['BuyerCheckoutMessage']) ? 0 : null,
                                                'total_price' =>$orders['OrderArray']['Order']['Total'],
                                                //'customer_id' => $info->,
                                                'customer_name' => $orders['OrderArray']['Order']['ShippingAddress']['Name'],
                                                'customer_email' => $orders['OrderArray']['Order']['TransactionArray']['Transaction']['Buyer']['Email'],
                                                'customer_phone' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Phone']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Name'],
                                                'customer_country' => $country,
                                                'customer_city' => $orders['OrderArray']['Order']['ShippingAddress']['CityName'],
                                                'customer_zip_code' => $orders['OrderArray']['Order']['ShippingAddress']['PostalCode'],
                                                'customer_state' => $stateOrProvince,
                                                'ebay_user_id' => $order['BuyerUserID'] ?? null,
                                                'shipping' => $shipping,
                                                'shipping_post_code' => $orders['OrderArray']['Order']['ShippingAddress']['PostalCode'],
                                                //'tracking_number' => $info->,
                                                'date_created' =>date('Y-m-d h:i:s', strtotime($orders['OrderArray']['Order']['CreatedTime'])),
                                                'created_at'=> Carbon::now(),
                                                'updated_at'=> Carbon::now(),
                                                //'date_completed' => $info->,
                                                'payment_method' => $orders['OrderArray']['Order']['CheckoutStatus']['PaymentMethod'],
                                                'transaction_id' => $orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionID'],
                                                'shipping_user_name' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Name']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Name'],
                                                'shipping_phone' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Phone'] ) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Phone'],
                                                'shipping_city' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['CityName']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['CityName'],
                                                'shipping_county' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['StateOrProvince']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['StateOrProvince'],
                                                'shipping_country' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Country']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Country'],
                                                'shipping_address_line_1' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Street1']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Street1'],
                                                'shipping_address_line_2' => (gettype($orders['OrderArray']['Order']['ShippingAddress']['Street2']) == 'array') ? null : $orders['OrderArray']['Order']['ShippingAddress']['Street2'],
                                                'shipping_address_line_3' => null,
                                                "ebay_tax_reference" => $eBayCollectAndRemitTaxes,
                                            ]);

                                            if (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction'][0])){
//                                             Log::info(14);
                                                foreach ($orders['OrderArray']['Order']['TransactionArray']['Transaction'] as $product){
                                                    //                        echo "<pre>";
                                                    //                        print_r($product['Variation']['SKU']);
                                                    //                        exit();

                                                    if (isset($product['Variation']['SKU'])){
                                                        $product_variation_result = ProductVariation::where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                        $woo_variation_result = WoocommerceVariation::where('woocom_variation_id' ,$product_variation_result->id)->get()->first();
                                                        $ebay_variation_result = EbayVariationProduct::with(['masterProduct'])->where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                        $onbuy_variation_result = OnbuyVariationProducts::where('sku' ,$product['Variation']['SKU'])->get()->first();
                                                        //                        echo "<pre>";
                                                        //                        print_r($result->actual_quantity);
                                                        ////                        exit();
// Log::info(15);

                                                        if ($product_variation_result != null){
                                                            $update_quantity = $product_variation_result->actual_quantity - $product['QuantityPurchased'];
                                                            ProductVariation::where('sku',$product['Variation']['SKU'])->update(['actual_quantity'=>$update_quantity]);




                                                            $product_order_result = ProductOrder::insert([
                                                                'order_id'=> $ebay_id,
                                                                'variation_id'=> $product_variation_result->id,
                                                                'name'=> $product['Item']['Title'],
                                                                'quantity'=> $product['QuantityPurchased'],
                                                                'price'=> $product['TransactionPrice'],
                                                                'status'=> 0,
                                                                'created_at'=> Carbon::now(),
                                                                'updated_at'=> Carbon::now(),
                                                            ]);
//                                                         Log::info(16);
                                                            // $woocom_get_result = Woocommerce::get('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id);
                                                            $variation_data = [
                                                                'stock_quantity' => $update_quantity,
                                                            ];
                                                            if ($woo_variation_result != null){
                                                                try{
                                                                    $woo_update_info = WoocommerceVariation::where('id',$woo_variation_result->id)->update(['actual_quantity' => $update_quantity]);
                                                                    // $woocom_put_result = Woocommerce::put('products/'.$woo_variation_result->woocom_master_product_id.'/variations/'.$woo_variation_result->id,$variation_data);
                                                                }catch (Exception $exception){
                                                                    //                                continue;
                                                                    continue;
                                                                }
                                                            }

                                                            if ($ebay_variation_result !=null){
                                                                try{
                                                                    $ebay_update_info = EbayVariationProduct::where('sku',$product['Variation']['SKU'])->update(['quantity' => $update_quantity]);
                                                                    // $ebay_result = $this->updateEbayQuantity($ebay_variation_result[0]->masterProduct->item_id,$product['Variation']['SKU'],$update_quantity,$site_id);
                                                                }catch (Exception $exception){
                                                                    continue;
                                                                }
                                                            }
                                                            if ($onbuy_variation_result !=null){
                                                                try{
                                                                    OnbuyVariationProducts::where('sku',$product['Variation']['SKU'])->update(['stock'=>$update_quantity]);
                                                                    // $this->updateOnbuyQuantity($update_quantity,$product['Variation']['SKU']);
                                                                }catch(Exception $e){
                                                                    continue;
                                                                }
                                                            }
//                                                         Log::info(17);

                                                        }
                                                    }else{
                                                        $product_variation_result = ProductVariation::where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'])->get()->first();
                                                        try{
                                                            if ($product_variation_result != null){
                                                                $product_order_result = ProductOrder::insert([
                                                                    'order_id'=> $ebay_id,
                                                                    'variation_id'=> $product_variation_result->id,
                                                                    'name'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['Title']) == 'array') ? null : $order['TransactionArray']['Transaction']['Item']['Title'],
                                                                    'quantity'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $order['TransactionArray']['Transaction']['QuantityPurchased'],
                                                                    'price'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionPrice']) == 'array') ? null : $order['TransactionArray']['Transaction']['TransactionPrice'],
                                                                    'status'=> 0,
                                                                    'created_at'=> Carbon::now(),
                                                                    'updated_at'=> Carbon::now(),
                                                                ]);
                                                                $check_quantity = new CheckQuantity();

                                                                if (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                                    $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                }elseif (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item'])){
                                                                    $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                                }

                                                            }
                                                        }catch(Exception $e){
                                                            return $e;
                                                        }
                                                    }

                                                }
                                            }else{
// Log::info(18);
                                                if (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                    $product_variation_result = ProductVariation::where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])->get()->first();
                                                    $woo_variation_result = WoocommerceVariation::where('woocom_variation_id' ,$product_variation_result->id)->get()->first();
                                                    $ebay_variation_result = EbayVariationProduct::with(['masterProduct'])->where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])->get()->first();
                                                    $onbuy_variation_result = OnbuyVariationProducts::where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])->get()->first();
                                                    //                        echo "<pre>";
                                                    //                        print_r($result->actual_quantity);
                                                    ////                        exit();

                                                    if ($product_variation_result != null){
                                                        $update_quantity = $product_variation_result->actual_quantity - $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'];
                                                        ProductVariation::where('sku',$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])->update(['actual_quantity'=>$update_quantity]);



                                                        $product_order_result = ProductOrder::insert([
                                                            'order_id'=> $ebay_id,
                                                            'variation_id'=> $product_variation_result->id,
                                                            'name'=> $orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['Title'],
                                                            'quantity'=> $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],
                                                            'price'=> $orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionPrice'],
                                                            'status'=> 0,
                                                            'created_at'=> Carbon::now(),
                                                            'updated_at'=> Carbon::now(),
                                                        ]);
//                                                     Log::info(19);
                                                        // $woocom_get_result = Woocommerce::get('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id);
                                                        $variation_data = [
                                                            'stock_quantity' => $update_quantity,
                                                        ];
                                                        if ($woo_variation_result != null){
                                                            try{
                                                                $woo_update_info = WoocommerceVariation::where('id',$woo_variation_result->id)->update(['actual_quantity' => $update_quantity]);
                                                                // $woocom_put_result = Woocommerce::put('products/'.$woo_variation_result->woocom_master_product_id.'/variations/'.$woo_variation_result->id,$variation_data);
                                                            }catch (Exception $exception){
                                                                //                                continue;
                                                                continue;
                                                            }
                                                        }

                                                        if ($ebay_variation_result !=null){
                                                            try{
                                                                $ebay_update_info = EbayVariationProduct::where('id',$ebay_variation_result->id)->update(['quantity' => $update_quantity]);
                                                                // $ebay_result = $this->updateEbayQuantity($ebay_variation_result[0]->masterProduct->item_id,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'],$update_quantity,$site_id);
                                                            }catch (Exception $exception){
                                                                continue;
                                                            }
                                                        }
                                                        if ($onbuy_variation_result !=null){
                                                            try{
                                                                OnbuyVariationProducts::where('sku',$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])->update(['stock'=>$update_quantity]);
                                                                // $this->updateOnbuyQuantity($update_quantity,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU']);
                                                            }catch(Exception $exception){
                                                                continue;
                                                            }
                                                        }
//                                                     Log::info(20);

                                                    }
                                                }elseif (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item'])){

                                                    $product_variation_result = ProductVariation::where('sku' ,$orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'])->get()->first();
                                                    try{
                                                        if ($product_variation_result != null){
                                                            $product_order_result = ProductOrder::insert([
                                                                'order_id'=> $ebay_id,
                                                                'variation_id'=> $product_variation_result->id,
                                                                'name'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['Title']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['Title'],
                                                                'quantity'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],
                                                                'price'=> (gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionPrice']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['TransactionPrice'],
                                                                'status'=> 0,
                                                                'created_at'=> Carbon::now(),
                                                                'updated_at'=> Carbon::now(),
                                                            ]);
                                                            $check_quantity = new CheckQuantity();

                                                            if (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'])){
                                                                $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Variation']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                            }elseif (isset($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item'])){
                                                                $check_quantity->checkQuantity($orders['OrderArray']['Order']['TransactionArray']['Transaction']['Item']['SKU'],null,null,'Auto Sync',(gettype($orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased']) == 'array') ? null : $orders['OrderArray']['Order']['TransactionArray']['Transaction']['QuantityPurchased'],false,$account_result->id);
                                                            }

                                                        }
                                                    }catch(Exception $e){
                                                        return $e;
                                                    }
                                                }

                                            }
                                        }

                                    }

                                }
                            }else{
                                echo gettype($orders['OrderArray']);

                            }


                        }



                    }catch (Exception $exception){
                        return $exception;
                    }
                }
            }



        }

//        return redirect('order/list');
    }
    public function test(){
        $check_quantity = new CheckQuantity();
        $check_quantity->checkQuantity('N8B-5843-XL');
//        $channel = new ChannelFactory();
//        $channel->getChannelArray();
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

    public function updateOnbuyQuantity($quantity,$sku){
        $access_token = $this->access_token();
        $data[] = [
            "sku"=> $sku,
            "stock" => $quantity
        ];
        $update_info= [
            "site_id" => 2000,
            "listings" => $data
        ];
        try{
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
                    "Authorization: ".$access_token,
                    "Content-Type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }catch (Exception $exception){
            echo $exception;
        }

    }


}
