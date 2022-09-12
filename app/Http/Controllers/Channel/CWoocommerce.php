<?php


namespace App\Http\Controllers\Channel;


use App\Http\Controllers\Channel\EChannel;
use App\Traits\ActivityLogs;
use App\woocommerce\WoocommerceVariation;
use Illuminate\Support\Carbon;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Auth;

class CWoocommerce implements EChannel
{
    use ActivityLogs;
    public function getChannelName(){
        return "WooCommerce";
    }
    public function updateQuantity($sku, $quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false)
    {
        // TODO: Implement updateQuantity() method.
        $woo_variation_result = WoocommerceVariation::where('sku' ,$sku)->get()->first();

        if ($woo_variation_result != null){
            $variation_data = [
                'stock_quantity' => $quantity,
            ];
            try{
                $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Woocommerce',1,$sku,$variation_data,null,Auth::user()->name ?? 'Quantity Sync',$woo_variation_result->actual_quantity,$quantity,Carbon::now(),1,0);
                $woocom_put_result = Woocommerce::put('products/'.$woo_variation_result->woocom_master_product_id.'/variations/'.$woo_variation_result->id,$variation_data);

                $woo_update_info = WoocommerceVariation::where('id',$woo_variation_result->id)->update(['actual_quantity' => $quantity]);
                if($woocom_put_result){
                    $updateResponse = $this->updateResponse($logInsertData->id,$woocom_put_result,1,1);
                }else{
                    $updateResponse = $this->updateResponse($logInsertData->id,$woocom_put_result,0,0);
                }
            }catch (Exception $exception){
                $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Woocommerce',1,$sku,$variation_data,$woocom_put_result,Auth::user()->name ?? 'Quantity Sync',$woo_variation_result->actual_quantity,$quantity,Carbon::now(),'Error');
//                                continue;

            }
        }
    }
}
