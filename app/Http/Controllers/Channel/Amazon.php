<?php
namespace App\Http\Controllers\Channel;

use App\Traits\ActivityLogs;
use SellingPartnerApi\Api;
use SellingPartnerApi\Configuration;
use SellingPartnerApi\Endpoint;
use App\amazon\AmazonVariationProduct;
use App\amazon\AmazonAccountApplication;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class Amazon implements EChannel {

    use ActivityLogs;

    protected $applicationInfo = [];
    protected $marketPlaceId = '';
    protected $marketPlace = '';
    protected $productType = '';
    protected $sellerId = 'A1FJB341J9DM5D';
    protected $issueLocal = 'en_GB';
    protected $changeReason = null;

    public function getChannelName(){
        return "Amazon";
    }

    public function updateQuantity($sku,$quantity, $change_reason,$channel = null,$ordered_quantity=null,$force_update=false){
        $this->changeReason = $change_reason;
        $amazonExistVariation = AmazonVariationProduct::with(['masterCatalogue' => function($query){
            $query->with(['applicationInfo']);
        }])->where('sku',$sku)->get();
        foreach($amazonExistVariation as $variationInfo){
            if(isset($variationInfo->masterCatalogue->applicationInfo)){
                $updateQuantity = $this->quantitySyncInAmazonAccount($variationInfo, $quantity);
            }
        }
    }

    public function quantitySyncInAmazonAccount($variationInfo, $quantity){
        try{
            $amazonVariationInfo = AmazonVariationProduct::with(['masterCatalogue' => function($query){
                $query->with(['catalogueType']);
            }])->find($variationInfo->id);

            $config = $this->configuration($amazonVariationInfo->masterCatalogue->application_id);
            $data = [
                'productType' => $amazonVariationInfo->masterCatalogue->catalogueType->product_type,
                'patches' => [
                    [
                        'op' => 'replace',
                        'path' => '/attributes/fulfillment_availability',
                        'value' => [
                            [
                                'fulfillment_channel_code' => 'DEFAULT',
                                'quantity' => $quantity,
                            ]
                        ]
                    ]
                ]
            ];
            $body = json_encode($data);
            $api = new Api\ListingsApi($config);
            $marketplace_ids = array($this->marketPlaceId);
            $logInsertData = $this->paramToArray(url()->full(),$this->changeReason,'Amazon',$amazonVariationInfo->masterCatalogue->application_id,$amazonVariationInfo->sku,$data,null,'Quantity Sync',$amazonVariationInfo->quantity,$quantity,Carbon::now(),2,2);
            $result = $api->patchListingsItem($this->sellerId, $amazonVariationInfo->sku, $marketplace_ids, $body);
            if($result['status'] == 'ACCEPTED'){
                $wmsAmazonVariationInfoUpdate = AmazonVariationProduct::find($amazonVariationInfo->id)
                ->update(['quantity' => $quantity]);
                $updateResponse = $this->updateResponse($logInsertData->id,$result,1,1);
//                Log::info('SKU ' .$amazonVariationInfo->sku. ' quantity sync successfully in amazon');
            }else{
                $updateResponse = $this->updateResponse($logInsertData->id,$result,0,0);
//                Log::info('SKU ' .$amazonVariationInfo->sku. ' quantity not sync successfully in amazon');
            }
            sleep(1);
        }catch(\Exception $exception){
            $logInsertData = $this->paramToArray(url()->full(),$this->changeReason,'Amazon',$variationInfo->masterCatalogue->applicationInfo->id,$variationInfo->sku,null,$exception,'Quantity Sync',$variationInfo->quantity,$quantity,Carbon::now(),0,0);
            Log::info('Something Went Wrong When Quantity Sync In Amazon');
        }
    }

    public function configuration($applicationId){
        try{
            $config = [];
            $applicationInfo = $this->applicationInfoWithToken($applicationId);

            $this->applicationInfo = $applicationInfo;
            $this->marketPlaceId = $applicationInfo->marketPlace->marketplace_id;
            $this->marketPlace = $applicationInfo->marketPlace->marketplace;

            $config['lwaClientId'] = $applicationInfo->lwa_client_id;
            $config['lwaClientSecret'] = $applicationInfo->lwa_client_secret;
            $config['lwaRefreshToken'] = $applicationInfo->token->refresh_token;
            $config['awsAccessKeyId'] = $applicationInfo->aws_access_key_id;
            $config['awsSecretAccessKey'] = $applicationInfo->aws_secret_access_key;
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'NA'){
                $config['endpoint'] = Endpoint::NA;
            }
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'EU'){
                $config['endpoint'] = Endpoint::EU;
            }
            if($applicationInfo->marketPlace->endpointInfo->endpoint_shortcode == 'FE'){
                $config['endpoint'] = Endpoint::FE;
            }
            $config['roleArn'] = $applicationInfo->iam_arn;
            $configuration = new Configuration($config);
            return $configuration;
        }catch(\Exception $exception){
            Log::info('Something went wrong when configure amazon credentials');
        }
    }

    public function applicationInfoWithToken($id){
        try{
            $applicationInfo = AmazonAccountApplication::with(['token','marketPlace' => function($query){
                $query->with(['endpointInfo']);
            }])->find($id);
            return $applicationInfo;
        }catch(\Exception $exception){
            Log::info('Something went wrong when fetching amazon tokens');
        }
    }

}
