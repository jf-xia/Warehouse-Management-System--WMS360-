<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\OnbuyAccount;
use App\OnbuyVariationProducts;
use App\Order;
use App\ProductOrder;
use App\woocommerce\WoocommerceVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Auth;
use App\OnbuyMasterProduct;
use App\EbayVariationProduct;
use App\EbayAccount;
use App\DeveloperAccount;
use Illuminate\Support\Facades\Session;

use App\ProductDraft;

use App\ProductVariation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;
class WoocomOrderSyncController extends Controller
{
    public function __construct()
    {
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
        $this->access_token = $token->access_token;
    }

    public function test1(){
        sleep(15);
        Log::info('test1');
    }

//    public function access_token(){
//
//
//
//        return $token->access_token;
//    }


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
//        print_r($order);
//        exit();
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



                        if ($product->sku != null){
                            $onbuy_product_variation_find = OnbuyVariationProducts::where('sku',$product->sku)->get()->first();

                            $product_variation_find = ProductVariation::find($product->variation_id);
                            $update_quantity = $product_variation_find->actual_quantity - $product->quantity;
                            $product_variation_find->actual_quantity = $update_quantity;
                            $result = $product_variation_find->save();

                            try{
                                $variation_data = [
                                    'stock_quantity' => $update_quantity,
                                ];
                                $woocom_put_result = Woocommerce::put('products/'.$product->product_id.'/variations/'.$product->variation_id,$variation_data);
                            }catch(Exception $exception){
                                continue;
                            }
//                            print_r($onbuy_product_variation_find == null ? 'yes': 'no');
//                            print_r($onbuy_product_variation_find);
//
//                            exit();

                            if ($onbuy_product_variation_find != null){

                                //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
                                $this->updateOnbuyQuantity($update_quantity,$product->sku);
                            }


                        }

                        $count++;
                    }
                    // });
                }catch(\Exception $ex){
                    continue;
                }
            }
        }


        //return redirect('order/list');
        Log::info('woocom');

    }

    public function syncOrderFromWoocommerceClicked(){

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
//        echo "<pre>";
//        print_r($order);
//        exit();
        foreach ($order as $order) {
            $order_channel = $order->created_via;
            if($order_channel != 'ebay'){
                $order_exist = Order::where('order_number',$order->id)->first();
                if(!isset($order_exist)) {
                    $orderPrimaryExistCheck = Order::find($order->id);
                    if($orderPrimaryExistCheck){
                        $lastOrderInfo = Order::orderByDesc('id')->first();
                        $orderId = $lastOrderInfo->id + 1;
                    }else{
                        $orderId = $order->id;
                    }
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
                            'id' => $orderId,
                            'order_number' => $order->number,
                            'status' => $order->status,
                            'created_via' => $order->created_via,
                            'account_id' => 1,
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
                            'customer_note' => null,
                            'buyer_message' => $order->customer_note ?? null,
                            'is_buyer_message_read' => $order->customer_note ? 0 : null,
                            'shipping' => $shipping,
                            'shipping_post_code' => $order->shipping->postcode,
                            // 'shipping_method' => json_encode($order->shipping_lines) ?? null,
                            'shipping_method' => $order->shipping_lines[0]->total ?? null,
                            'payment_method' => $order->payment_method,
                            'transaction_id' => $order->transaction_id,
                            'date_created' => $order->date_created,
                            'shipping_user_name' => $order->shipping->first_name.' '.$order->shipping->last_name,
                            'shipping_phone' => $order->billing->phone ?? null,
                            'shipping_city' => $order->shipping->city ?? null,
                            'shipping_county' => $order->shipping->state ?? null,
                            'shipping_country' => $order->shipping->country ?? null,
                            'shipping_address_line_1' => $order->shipping->address_1 ?? null,
                            'shipping_address_line_2' => $order->shipping->address_2 ?? null,
                            'shipping_address_line_3' => null,
                        ]);

                        $single_order = Order::find($orderId);


                        $count = 1;
                        foreach ($order->line_items as $product) {
                            //            $datas['variation_id'] = $product->variation_id;
                            $woo_product_variation_find = WoocommerceVariation::find($product->variation_id);
                            if(isset($woo_product_variation_find->woocom_variation_id)) {
                                $datas['variation_id'] = $woo_product_variation_find->woocom_variation_id;
                                $datas['name'] = $product->name;
                                $datas['quantity'] = $product->quantity;
                                $datas['price'] = $product->price;
                                $datas['status'] = 0;

                                $single_order->product_variations()->attach($single_order->id, $datas);

//                                $product_variation_find = ProductVariation::find($woo_product_variation_find->woocom_variation_id);
//                                $update_quantity = $product_variation_find->actual_quantity - $product->quantity;
//                                $product_variation_find->actual_quantity = $update_quantity;
//                                $result = $product_variation_find->save();
//
//                                $woo_product_variation_find->actual_quantity = $update_quantity;
//                                $result = $woo_product_variation_find->save();
//
//                                try{
//                                    $variation_data = [
//                                        'stock_quantity' => $update_quantity,
//                                    ];
//                                    $woocom_put_result = Woocommerce::put('products/'.$product->product_id.'/variations/'.$product->variation_id,$variation_data);
//                                }catch(Exception $exception){
//                                    //                            continue;
//                                    return $exception;
//                                }
//
//
//                                if ($product->sku != ''){
//                                    $onbuy_product_variation_find = OnbuyVariationProducts::where('sku',$product->sku)->get()->first();
//                                    if($onbuy_product_variation_find){
//                                        $onbuy_update = OnbuyVariationProducts::where('id',$onbuy_product_variation_find->id)->update(['stock'=>$update_quantity]);
//
//                                        //                            print_r($onbuy_product_variation_find == null ? 'yes': 'no');
//                                        //                            print_r($onbuy_product_variation_find);
//                                        //
//                                        //                            exit();
//
//                                        if ($onbuy_product_variation_find != null){
//
//                                            //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                                            $this->updateOnbuyQuantity($update_quantity,$product->sku);
//                                        }
//                                    }
//
//
//                                }
//                                if ($product->sku != ''){
//
//                                    $ebay_product_variation_finds = EbayVariationProduct::with(['masterProduct'])->where('sku',$product->sku)->get();
//
//
//
//                                    //$ebay_update = EbayVariationProduct::where('sku',$onbuy_product_variation_find->id)->update(['stock'=>$update_quantity]);
//
//                                    //                            print_r($onbuy_product_variation_find == null ? 'yes': 'no');
//                                    //                            print_r($onbuy_product_variation_find);
//                                    //
//                                    //                            exit();
//                                    if(count($ebay_product_variation_finds) > 0){
//                                        foreach ($ebay_product_variation_finds as $ebay_product_variation_find){
//                                            if ($ebay_product_variation_find != null){
//
//
//
//
//                                                $item_id = $ebay_product_variation_find->masterProduct->item_id;
//                                                $site_id = $ebay_product_variation_find->masterProduct->site_id;
//                                                $ebay_update = EbayVariationProduct::where('sku',$product->sku)->update(['quantity'=>$update_quantity]);
//
//                                                //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                                                $this->updateEbayQuantity($product->sku,$update_quantity);
//                                            }
//                                        }
//                                    }
//
//
//
//                                }
                                $check_quantity = new CheckQuantity();
                                $check_quantity->checkQuantity($woo_product_variation_find->sku,null,null,'Auto Sync');

                                $count++;
                            }
                        }
                        // });
                    }catch(\Exception $ex){
                        //                    continue;
                        return $ex;
                    }
                }
            }
        }


//        return redirect('order/list');
        Log::info('woocom clicked');

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

    public function getOnbuyQuantity($sku){
        $product_curl = curl_init();
        curl_setopt_array($product_curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/listings?site_id=2000&filter[sku]=".$sku,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: ".$this->access_token
            ),
        ));
        $onbuy_product_response = curl_exec($product_curl);
        curl_close($product_curl);
        $onbuy_product_data = json_decode($onbuy_product_response);

        return $onbuy_product_data->results[0]->stock;
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
                "Authorization: ".$this->access_token,
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
