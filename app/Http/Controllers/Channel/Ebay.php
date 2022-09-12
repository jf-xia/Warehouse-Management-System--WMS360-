<?php


namespace App\Http\Controllers\Channel;


use App\DeveloperAccount;
use App\EbayVariationProduct;
use App\ProductOrder;
use App\ProductVariation;
use App\ShelfedProduct;
use App\EbayAccount;
use App\Traits\ActivityLogs;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\Log;

class Ebay implements EChannel
{
    use ActivityLogs;
    public function getChannelName(){
        return "eBay";
    }
    public function updateQuantity($sku,$quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false,$account_id = null)
    {

        $sku = $sku;
        $quantity = $quantity;
        $wms_quantity = $quantity;
        $ebay_product_find = null;
        $account_result = null;
        if ($channel == null) {
            $ebay_product_find = EbayVariationProduct::whereHas('masterProduct', function($mp) {
                $mp->where('product_status','!=','Completed');
            })->with('masterProduct')->where('sku', $sku)->get()->all();
        } else {
            $ebay_product_find = EbayVariationProduct::whereHas('masterProduct', function($mp) {
                $mp->where('product_status','!=','Completed');
            })->with('masterProduct')->where('sku', $sku)->where('account_id', $channel)->get()->all();
            $account_result = EbayAccount::find($channel);
            $this->ebayAccessToken($account_result->refresh_token);
        }


        foreach ($ebay_product_find as $product) {
            if ($channel == null) {
                $account_result = EbayAccount::find($product->masterProduct->account_id);
            }
            if ($product->masterProduct->account_id == $account_id){
                $force_update = true;
            }


//            $ebay = new CheckEbayQuantity();
//            $checkQuantity = new CheckQuantity();
//            $quantity = $checkQuantity->checkAvailableQuantity($ebay,$product,$quantity);
//            if (isset(\Opis\Closure\unserialize($product->masterProduct->draft_status)["feeder_flag"])){
//                if (\Opis\Closure\unserialize($product->masterProduct->draft_status)["feeder_flag"]){
//
//
//                    $updated_available_quantity = $this->getUpdateAvailableQuantity($product->master_variation_id);
//
//                    if ($updated_available_quantity >= $product->masterProduct->custom_feeder_quantity){
//
//                        return $product->masterProduct->custom_feeder_quantity;
//                    }
//                }
//                return $updated_available_quantity;
//            }
            if ($quantity < 0) {
                $quantity = 0;
            }

            if (isset(\Opis\Closure\unserialize($product->masterProduct->draft_status)["feeder_flag"]) && \Opis\Closure\unserialize($product->masterProduct->draft_status)["feeder_flag"]) {
                $update_quantity = $quantity;
                if ($quantity < $product->masterProduct->custom_feeder_quantity || $ordered_quantity == $product->masterProduct->custom_feeder_quantity || $force_update) {

                    if ($quantity > $product->masterProduct->custom_feeder_quantity) {
                        $update_quantity = $product->masterProduct->custom_feeder_quantity;
                    }

                    if ($channel == null) {
                        $this->ebayAccessToken($account_result->refresh_token);
                    }

                    if ($this->ebay_update_access_token != 'noToken') {
                        $url = 'https://api.ebay.com/ws/api.dll';
                        $headers = [
                            'X-EBAY-API-SITEID:' . $product->masterProduct->site_id,
                            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                            'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                        ];
                        $update_info = '';
                        if ($product->masterProduct->type == 'variable') {
                            $update_info = '<Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                            <SKU>' . '<![CDATA[' . $sku . ']]>' . '</SKU>

                            <Quantity>' . $update_quantity . '</Quantity>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>';
                        } else {
                            $update_info = '<Quantity>' . $update_quantity . '</Quantity>';
                        }

                        $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>' . $product->masterProduct->item_id . '</ItemID>
                        ' . $update_info . '
                      </Item>
                    </ReviseFixedPriceItemRequest>';
                        try {
                            $logInsertData = $this->paramToArray(url()->full(), $change_reason, 'Ebay', $account_result->id, $sku, $body, null, Auth::user()->name ?? 'Quantity Sync', $product->quantity, $update_quantity, Carbon::now(), 2, 2);
                            $update_ebay_product = $this->curl($url, $headers, $body, 'POST');
                            $update_ebay_product = simplexml_load_string($update_ebay_product);
                            $update_ebay_product = json_decode(json_encode($update_ebay_product), true);
//                            Log::info($update_ebay_product);
                            if ($update_ebay_product['Ack'] == 'Warning' || $update_ebay_product['Ack'] == 'Success') {
                                $updateResponse = $this->updateResponse($logInsertData->id, $update_ebay_product, 1, 1);
                                $ebay_update_info = EbayVariationProduct::where('sku', $sku)->update(['quantity' => $update_quantity]);
                                //                $ebay_product_variation = EbayVariationProduct::find($product->id);
                                //                $ebay_product_variation->quantity = $quantity;
                                //                $ebay_product_variation->save();
                            } else {
                                $updateResponse = $this->updateResponse($logInsertData->id, $update_ebay_product, 0, 0);
                            }
                        } catch (\Exception $exception) {
                            $logInsertData = $this->paramToArray(url()->full(), $change_reason, 'Ebay', $account_result->id, $sku, $body, $exception, Auth::user()->name ?? 'Quantity Sync', $product->quantity, $update_quantity, Carbon::now(), 0, 0);
                        }
                    }


//                        $quantity = $product->masterProduct->custom_feeder_quantity;
                }

            } else {

                if ($channel == null) {
                    $this->ebayAccessToken($account_result->refresh_token);
                }

                if ($this->ebay_update_access_token != 'noToken') {
                    $url = 'https://api.ebay.com/ws/api.dll';
                    $headers = [
                        'X-EBAY-API-SITEID:' . $product->masterProduct->site_id,
                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                        'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                        'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                    ];
                    $update_info = '';
                    if ($product->masterProduct->type == 'variable') {
                        $update_info = '<Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                            <SKU>' . '<![CDATA[' . $sku . ']]>' . '</SKU>

                            <Quantity>' . $quantity . '</Quantity>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>';
                    } else {
                        $update_info = '<Quantity>' . $quantity . '</Quantity>';
                    }

                    $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>' . $product->masterProduct->item_id . '</ItemID>
                        ' . $update_info . '
                      </Item>
                    </ReviseFixedPriceItemRequest>';
                    try {
                        $logInsertData = $this->paramToArray(url()->full(), $change_reason, 'Ebay', $account_result->id, $sku, $body, null, Auth::user()->name ?? 'Quantity Sync', $product->quantity, $quantity, Carbon::now(), 2, 2);
                        $update_ebay_product = $this->curl($url, $headers, $body, 'POST');
                        $update_ebay_product = simplexml_load_string($update_ebay_product);
                        $update_ebay_product = json_decode(json_encode($update_ebay_product), true);

                        if ($update_ebay_product['Ack'] == 'Warning' || $update_ebay_product['Ack'] == 'Success') {
                            $updateResponse = $this->updateResponse($logInsertData->id, $update_ebay_product, 1, 1);
                            $ebay_update_info = EbayVariationProduct::where('sku', $sku)->update(['quantity' => $wms_quantity]);
                            //                $ebay_product_variation = EbayVariationProduct::find($product->id);
                            //                $ebay_product_variation->quantity = $quantity;
                            //                $ebay_product_variation->save();
                        } else {
                            $updateResponse = $this->updateResponse($logInsertData->id, $update_ebay_product, 0, 0);
                        }
                    } catch (\Exception $exception) {
                    $logInsertData = $this->paramToArray(url()->full(), $change_reason, 'Ebay', $account_result->id, $sku, $body, $exception, Auth::user()->name ?? 'Quantity Sync', $product->quantity, $update_quantity, Carbon::now(), 0, 0);
                }

//                        $quantity = $product->masterProduct->custom_feeder_quantity;
                }
            }


        }
    }


//    public function checkQuantity($product,$quantity){
//       if (\Opis\Closure\unserialize($product->masterProduct->draft_status)["feeder_flag"]){
//                $shelf_quantity = ShelfedProduct::where('variation_id',$product->master_variation_id)->sum('quantity');
//                $pending_order_quantity = ProductOrder::where('variation_id',$product->master_variation_id)->where('status', 0)->sum('quantity');
//                $pending_order_picked_quantity = ProductOrder::where('variation_id',$product->master_variation_id)->where('status', 0)->sum('quantity');
//                $pending_order_available_quantity = $pending_order_quantity-$pending_order_picked_quantity;
//
//                $shelf_quantity = $shelf_quantity - $pending_order_available_quantity;
//                if ($shelf_quantity >= $product->masterProduct->custom_feeder_quantity){
//                    return $product->masterProduct->custom_feeder_quantity;
//                }
//                return $shelf_quantity;
//            }
//            return $quantity;
//
//    }

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
        if (isset($response['access_token'])){
            $this->ebay_update_access_token =  $response['access_token'];
        }else{
            $this->ebay_update_access_token =  "noToken";
        }

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
}
