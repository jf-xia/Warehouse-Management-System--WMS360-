<?php


namespace App\Http\Controllers\Channel;


use App\OnbuyAccount;
use App\OnbuyVariationProducts;
use App\Traits\ActivityLogs;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;
use Auth;

class Onbuy implements EChannel
{
    use ActivityLogs;
    public function getChannelName(){
        return "OnBuy";
    }
    public function updateQuantity($sku, $quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false)
    {
        // TODO: Implement updateQuantity() method.
        $onbuy_variation_result = OnbuyVariationProducts::where('sku' ,$sku)->orWhere('updated_sku',$sku)->get()->first();
        if ($onbuy_variation_result !=null){
            try{

                $this->updateOnbuyQuantity($quantity,$onbuy_variation_result,$onbuy_variation_result->stock,$change_reason);
                OnbuyVariationProducts::where('sku',$onbuy_variation_result->sku)->update(['stock'=>$quantity]);
            }catch(Exception $e){

            }
        }

    }

    public function updateOnbuyQuantity($quantity,$onbuy_variation_result,$beforeQuantity,$change_reason){
        $access_token = $this->access_token();
        $data[] = [
            "sku"=> $onbuy_variation_result->sku,
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
            $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Onbuy',1,$onbuy_variation_result->updated_sku ?? $onbuy_variation_result->sku,$update_info,null,Auth::user()->name ?? 'Quantity Sync',$beforeQuantity,$quantity,Carbon::now(),1,0);
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response);
            if(isset($data->success)){
                if(isset($data->results[0]->error)){
                    $updateResponse = $this->updateResponse($logInsertData->id,$response,0,0);
                }else{
                    $updateResponse = $this->updateResponse($logInsertData->id,$response,1,1);
                }
            }else{
                $updateResponse = $this->updateResponse($logInsertData->id,$response,0,0);
            }
            //$updateResponse = $this->updateResponse('response_data',$logInsertData->id,$response,1);
        }catch (Exception $exception){
            $logInsertData = $this->paramToArray(url()->full(),$change_reason,'Onbuy',1,$onbuy_variation_result->updated_sku ?? $onbuy_variation_result->sku,$update_info,$exception,Auth::user()->name,$beforeQuantity,$quantity,Carbon::now(),0,0);
        }

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


}
