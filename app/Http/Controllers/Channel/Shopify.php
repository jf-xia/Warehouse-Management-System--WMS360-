<?php


namespace App\Http\Controllers\Channel;


use App\Http\Controllers\Channel\EChannel;
use App\Traits\ActivityLogs;
use App\Traits\Shopify as Shop;
use Illuminate\Support\Carbon;
use PHPUnit\Exception;
use App\shopify\ShopifyAccount;
use App\shopify\ShopifyMasterProduct;
use App\shopify\ShopifyVariation;
use Auth;

class Shopify implements EChannel
{
    use Shop;
    use ActivityLogs;
    public function getChannelName(){
        return "Shopify";
    }

    public function updateQuantity($sku, $quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false)
    {
        try{
            $shopify_variation_result = ShopifyVariation::where('sku' ,$sku)->get()->first();

            if ($shopify_variation_result != null){
                $master_info = ShopifyMasterProduct::where('id' ,$shopify_variation_result->shopify_master_product_id)->first();
                // dd($shopify_variation_result);
                if(!empty($master_info->account_id)){
                    $variation_data = [
                        'stock_quantity' => $quantity,
                    ];

                        $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Shopify',1,$sku,$variation_data,null,Auth::user()->name ?? 'Quantity Sync',$shopify_variation_result->quantity,$quantity,Carbon::now(),1,0);
                        // $account_info = ShopifyVariation::with('masterProduct')->where('sku' ,$sku)->get()->first();

                        $shopify_account_info = ShopifyAccount::find($master_info->account_id);
                        $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);

                        $update_api = $shopify->Location()->get();
                        $location_id = array();
                        foreach($update_api as $key => $location){
                            $location_id[] = $location;
                        }

                        $variation_info = $shopify->ProductVariant($shopify_variation_result->shopify_variant_it)->get();

                        $postArray = [
                            "location_id" => $location_id[0]['id'],
                            "inventory_item_id" => $variation_info['inventory_item_id'],
                            "available" => $quantity,
                        ];


                        $update_quantity = $shopify->InventoryLevel()->set($postArray);








                        // $postArray = [
                        //     "location_id" => '60951953462',
                        //     "inventory_item_id" => '42273080377398',
                        //     "available" => $quantity,
                        // ];


                        // $update_api = $shopify->InventoryLevel()->put($postArray);


                        $woo_update_info = ShopifyVariation::where('id',$shopify_variation_result->id)->update(['quantity' => $quantity]);
                        if($update_quantity){
                            $updateResponse = $this->updateResponse($logInsertData->id,$update_api,1,1);
                        }else{
                            $updateResponse = $this->updateResponse($logInsertData->id,$update_api,0,0);
                        }

                }

            }
        }catch (Exception $exception){
                        $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Shopify',1,$sku,$variation_data,$woocom_put_result,Auth::user()->name ?? 'Quantity Sync',$woo_variation_result->actual_quantity,$quantity,Carbon::now(),'Error');
        //                                continue;

        }

    }

}
