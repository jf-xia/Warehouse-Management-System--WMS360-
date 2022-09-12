<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\Http\Controllers\Controller;
use App\Order;
use App\ProductOrder;
use App\ProductVariation;
use App\shopify\ShopifyAccount;
use App\Traits\Shopify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    use Shopify;
    public function __construct(){
//        $this->middleware('auth');
    }
    //
    public function shopifyOrder(){

        try {
            $shopify_account_info = ShopifyAccount::all();
            foreach ($shopify_account_info as $account){
                $shopify = $this->getConfig($account->shop_url,$account->api_key,$account->password);
                $allOrder = $shopify->Order->get();
                if(isset($allOrder)){
                    $count = 1;
                    foreach ($allOrder as $order){
//                        echo '<pre>';
//                        print_r($order['customer']['note']);
//                        exit();
                        // echo '<pre>';
                        // print_r($order);
                        // exit();
                        $order_table_primary_key = Order::orderBy('created_at', 'desc')->first();
                        $order_info = Order::where('order_number', $order['id'])->first();
                        // echo '<pre>';
                        // print_r($order_info);
                        // exit();
                        if(!isset($order_info)){
                            if(isset($order['billing_address'])){
                                if (gettype($order['billing_address']['name']) != 'array'){
                                    $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['name'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['address1']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['address1'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['phone']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Phone  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['phone'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['city']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['city'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['zip']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> ZIP  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['zip'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['company']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Company  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['company'] . '</h7></div></div>';
                                }
                                if (gettype($order['billing_address']['country_code']) != 'array'){
                                    $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country Code  </h7></div><div class="content-right"><h7> : ' . $order['billing_address']['country_code'] . '</h7></div></div>';
                                }
                            }

//                        echo '<pre>';
//                        var_dump($order_table_primary_key->id+$count++);
                            if (isset($order['customer']['note'])){
                                $is_buyer_message_read = 0;
                            }else{
                                $is_buyer_message_read = NULL;
                            }
                            $order_id = $order_table_primary_key->id+1;
                            $shopify_order = new Order();
                            $shopify_order->id = $order_table_primary_key->id+1;
                            $shopify_order->order_number = $order['id'];
                            $shopify_order->created_via = 'shopify';
                            $shopify_order->status = 'processing';
                            $shopify_order->account_id = $account->id;
                            $shopify_order->currency = $order['currency'];
                            $shopify_order->total_price = $order['total_price'];
                            if(isset($order['customer'])){
                            $shopify_order->customer_id = $order['customer']['id'];
                            $shopify_order->customer_name = $order['customer']['first_name'];
                            $shopify_order->customer_email = $order['customer']['email'];
                            $shopify_order->customer_phone = $order['customer']['phone'];
                            $shopify_order->customer_country = $order['customer']['default_address']['country'];
                            $shopify_order->customer_city = $order['customer']['default_address']['city'];
                            $shopify_order->customer_zip_code = $order['customer']['default_address']['zip'];
                            $shopify_order->customer_state = $order['customer']['state'];
                            $shopify_order->buyer_message = $order['customer']['note'];
                            }

                            $shopify_order->is_buyer_message_read = $is_buyer_message_read;
                            $shopify_order->payment_method = $order['processing_method'];
                            $shopify_order->shipping = (isset($shipping)) ? $shipping : null;
                            $shopify_order->date_created = $order['created_at'];
                            if(isset($order['shipping_address'])){
                                $shopify_order->shipping_user_name = $order['shipping_address']['name'] ?? null;
                                $shopify_order->shipping_phone = $order['shipping_address']['phone'] ?? null;
                                $shopify_order->shipping_city = $order['shipping_address']['city'] ?? null;
                                $shopify_order->shipping_county = $order['shipping_address']['province'] ?? null;
                                $shopify_order->shipping_country = $order['shipping_address']['country'] ?? null;
                                $shopify_order->shipping_address_line_1 = $order['shipping_address']['address1'] ?? null;
                                $shopify_order->shipping_address_line_2 = $order['shipping_address']['address2'] ?? null;
                                $shopify_order->shipping_address_line_3 = null;
                            }

                            $shopify_main_order = $shopify_order->save();
                    //    echo '<pre>';
                    //    print_r($shopify_main_order);
                    //    exit();
                            $individualProduct = $order['line_items'];
                            if(isset($shopify_main_order)){
                                foreach ($individualProduct as $product_order){
                                    $variation_id = ProductVariation::where('sku', $product_order['sku'])->first();
//                                echo '<pre>';
//                                print_r($variation_id['sku']);
//                                print_r($product_order['sku']);
                                    if($product_order['sku'] == $variation_id['sku']){
                                        $productOrder = new ProductOrder();
                                        $productOrder->order_id = $order_id;
                                        $productOrder->variation_id = $variation_id['id'];
                                        $productOrder->name = $product_order['name'];
                                        $productOrder->quantity = $product_order['quantity'];
                                        $productOrder->picked_quantity = 0;
                                        $productOrder->price = $product_order['price'];
                                        $productOrder->status = 0;
                                        $save_product_order = $productOrder->save();

                                        if(isset($save_product_order)){
                                            $check_quantity = new CheckQuantity();
                                            $check_quantity->checkQuantity($product_order['sku'],null,null,'Auto Sync');
                                        }
                                    }

                                }
                            }
                        }else{

                        }
//                        echo '<pre>';
//                        var_dump($shopify_main_order);
                    }
                }
            }
            return Redirect::back();
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
