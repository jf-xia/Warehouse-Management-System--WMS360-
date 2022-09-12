<?php

namespace App\Http\Controllers;

use App\EbayVariationProduct;
use App\Events\WoocomQuantityUpdate;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\OnbuyAccount;
use App\OnbuyVariationProducts;
use App\Order;
use App\ProductOrder;
use App\ProductVariation;
use App\woocommerce\WoocommerceVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Carbon;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use App\EbayAccount;

use App\DeveloperAccount;

class OnbuyOrderSyncController extends Controller
{
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

    public function test2(){
        sleep(15);
        Log::info('test2');

    }
    public function syncOrderFromOnbuy(){


        $access_token = $this->access_token();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/orders?site_id=2000&filter[status]=awaiting_dispatch&limit=100&offset=0&filter[order_ids]=&sort[created]=desc&previously_exported=0'",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$access_token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response);
//        echo "<pre>";
//        print_r($data);
//        exit();



        $order_array = array();
        $product_order_array = array();
        $woocomUpdateArray = array();
        try {

            foreach ($data->results as $info) {

                $find_order_result = Order::find($info->onbuy_internal_reference);

                if ($find_order_result == null){
                    $order_array = null;
                    $product_order_array = null;
                    $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->name . '</h7></div></div>';
//        $shipping .= '<div class="row"><div class="col-4"><h7> Company  </h7></div><div class="col-8"><h7> : '.$order->shipping->company.'</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->line_1 . ',' . $info->delivery_address->line_2 . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->town . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->county . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->postcode . '</h7></div></div>';
                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->country . '</h7></div></div>';


                    $order_result = Order::insert([
                        'id' =>$info->onbuy_internal_reference ,
                        'order_number' => $info-> order_id ,
                        'status' =>  $info->status = 'Awaiting Dispatch' ? 'processing' : $info->status,
                        'created_via' => 'onbuy',
                        'currency' => $info->currency_code,
                        'total_price' => $info->price_total,
                        //'customer_id' => $info->,
                        'customer_name' => $info->buyer->name,
                        'customer_email' => $info->buyer->email,
                        'customer_phone' => $info->buyer->phone,
                        'customer_country' => $info->billing_address->country,
                        'customer_city' => $info->billing_address->town,
                        'customer_zip_code' => $info->billing_address->postcode,
                        'customer_state' => $info->billing_address->county,
                        'shipping' => $shipping,
                        'shipping_post_code' => $info->delivery_address->postcode,
                        //'tracking_number' => $info->,
                        'date_created' => $info->date,
                        'created_at'=> Carbon::now(),
                        'updated_at'=> Carbon::now(),
                        //'date_completed' => $info->,
                        'payment_method' => $info->paypal_capture_id != null ? ( 'paypal' ) : ( $info->stripe_transaction_id !=null ? ( 'stripe' ) : ('null' ) ),
                    ]);

                    foreach ($info->products as $product){

                        $product_variation_result = ProductVariation::where('sku' ,$product->sku)->get()->first();
//                        echo "<pre>";
//                        print_r($result->actual_quantity);
////                        exit();

                        if ($product_variation_result != null){
                            $update_quantity = $product_variation_result->actual_quantity - $product->quantity;
                            ProductVariation::where('sku',$product->sku)->update(['actual_quantity'=>$update_quantity]);
                            $product_order_result = ProductOrder::insert([
                                'order_id'=> $info->onbuy_internal_reference,
                                'variation_id'=> $product_variation_result->id,
                                'name'=> $product->name,
                                'quantity'=> $product->quantity,
                                'price'=> $product->total_price,
                                'status'=> 0,
                                'created_at'=> Carbon::now(),
                                'updated_at'=> Carbon::now(),
                            ]);
                            // $woocom_get_result = Woocommerce::get('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id);
                            $variation_data = [
                                'stock_quantity' => $update_quantity,
                            ];
                            try{
                                $woocom_put_result = Woocommerce::put('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id,$variation_data);
                            }catch (Exception $exception){
                                continue;
                            }
                        }

                    }



                }
            }

        }catch (Exception $exception){
            echo $exception;
        }

        Log::info('onbuy');

    }

    public function syncOrderFromOnbuyClicked(){


        $access_token = $this->access_token();
        if($access_token != 'notoken') {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.onbuy.com/v2/orders?site_id=2000&filter[status]=awaiting_dispatch&limit=100&offset=0&filter[order_ids]=&sort[created]=desc&previously_exported=0'",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: " . $access_token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $data = json_decode($response);
//        echo "<pre>";
//        print_r($data);
//        exit();


            $order_array = array();
            $product_order_array = array();
            $woocomUpdateArray = array();
            try {

                foreach ($data->results as $info) {

                    $find_order_result = Order::find($info->onbuy_internal_reference);

                    if ($find_order_result == null) {
                        $order_array = null;
                        $product_order_array = null;
                        $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->name . '</h7></div></div>';
//        $shipping .= '<div class="row"><div class="col-4"><h7> Company  </h7></div><div class="col-8"><h7> : '.$order->shipping->company.'</h7></div></div>';
                        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->line_1 . ',' . $info->delivery_address->line_2 . '</h7></div></div>';
                        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->town . '</h7></div></div>';
                        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->county . '</h7></div></div>';
                        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->postcode . '</h7></div></div>';
                        $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $info->delivery_address->country . '</h7></div></div>';


                        $order_result = Order::insert([
                            'id' => $info->onbuy_internal_reference,
                            'order_number' => $info->order_id,
                            'status' => $info->status = 'Awaiting Dispatch' ? 'processing' : $info->status,
                            'created_via' => 'onbuy',
                            'account_id' => 1,
                            'currency' => $info->currency_code,
                            'total_price' => $info->price_total,
                            //'customer_id' => $info->,
                            'customer_name' => $info->buyer->name,
                            'customer_email' => $info->buyer->email,
                            'customer_phone' => $info->buyer->phone,
                            'customer_country' => $info->billing_address->country,
                            'customer_city' => $info->billing_address->town,
                            'customer_zip_code' => $info->billing_address->postcode,
                            'customer_state' => $info->billing_address->county,
                            'shipping' => $shipping,
                            'shipping_post_code' => $info->delivery_address->postcode,
                            //'tracking_number' => $info->,
                            'date_created' => $info->date,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            //'date_completed' => $info->,
                            'payment_method' => $info->paypal_capture_id != null ? ('paypal') : ($info->stripe_transaction_id != null ? ('stripe') : ('null')),
                            'transaction_id' => $info->paypal_capture_id ?? $info->stripe_transaction_id ?? null,
                            'shipping_user_name' => $info->delivery_address->name ?? null,
                            'shipping_phone' => $info->buyer->phone ?? null,
                            'shipping_city' => $info->delivery_address->town ?? null,
                            'shipping_county' => $info->delivery_address->county ?? null,
                            'shipping_country' => $info->delivery_address->country ?? null,
                            'shipping_address_line_1' => $info->delivery_address->line_1 ?? null,
                            'shipping_address_line_2' => $info->delivery_address->line_2 ?? null,
                            'shipping_address_line_3' => $info->delivery_address->line_3 ?? null,
                        ]);

                        foreach ($info->products as $product) {
                            $sku = $product->sku;
                            $onbuyVariationInfo = OnbuyVariationProducts::where('sku',$sku)->orWhere('updated_sku',$sku)->first();
                            if($onbuyVariationInfo) {
                                $sku = $onbuyVariationInfo->updated_sku ?? $onbuyVariationInfo->sku;
                            }
                            $product_variation_result = ProductVariation::where('sku', $sku)->get()->first();
                            //$woo_variation_result = WoocommerceVariation::where('woocom_variation_id', $product_variation_result->id)->get()->first();
//                        echo "<pre>";
//                        print_r($result->actual_quantity);
////                        exit();

                            if ($product_variation_result != null) {
//                                $update_quantity = $product_variation_result->actual_quantity - $product->quantity;
//                                ProductVariation::where('sku', $product->sku)->update(['actual_quantity' => $update_quantity]);
//                                OnbuyVariationProducts::where('sku', $product->sku)->update(['stock' => $update_quantity]);
//                                $woo_update_info = WoocommerceVariation::where('id', $woo_variation_result->id)->update(['actual_quantity' => $update_quantity]);
                                $product_order_result = ProductOrder::insert([
                                    'order_id' => $info->onbuy_internal_reference,
                                    'variation_id' => $product_variation_result->id,
                                    'name' => $product->name,
                                    'quantity' => $product->quantity,
                                    'price' => $product->total_price,
                                    'status' => 0,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                                // $woocom_get_result = Woocommerce::get('products/'.$product_variation_result->product_draft_id.'/variations/'.$product_variation_result->id);
//                                $variation_data = [
//                                    'stock_quantity' => $update_quantity,
//                                ];
//                                try {
//                                    $woocom_put_result = Woocommerce::put('products/' . $woo_variation_result->woocom_master_product_id . '/variations/' . $woo_variation_result->id, $variation_data);
//                                } catch (Exception $exception) {
////                                continue;
//                                    return $exception->getMessage();
//                                }
//                                try {
//                                    $this->updateOnbuyQuantity($update_quantity, $product->sku);
//                                } catch (Exception $e) {
//                                    continue;
//                                }
//
//                                try {
//                                    $ebay_product_variation_finds = EbayVariationProduct::with(['masterProduct'])->where('sku', $product->sku)->get();
//                                    if (count($ebay_product_variation_finds) > 0) {
//                                        foreach ($ebay_product_variation_finds as $ebay_product_variation_find) {
//                                            if ($ebay_product_variation_find != null) {
//
//
//                                                $item_id = $ebay_product_variation_find->masterProduct->item_id;
//                                                $site_id = $ebay_product_variation_find->masterProduct->site_id;
//                                                $ebay_update = EbayVariationProduct::where('sku', $product->sku)->update(['quantity' => $update_quantity]);
//
//                                                //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                                                $this->updateEbayQuantity($product->sku, $update_quantity);
//                                            }
//                                        }
//                                    }
//
////                                $this->updateOnbuyQuantity($update_quantity,$product->sku);
//                                } catch (Exception $e) {
//                                    continue;
//                                }
                                $check_quantity = new CheckQuantity();
                                $check_quantity->checkQuantity($sku,null,null,'Auto Sync');

                            }

                        }


                    }
                }

            } catch (Exception $exception) {
                echo $exception;
            }
        }

        Log::info('onbuy');
//        return redirect('order/list');

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
