<?php
namespace App\Traits;

use SellingPartnerApi\Api;
use SellingPartnerApi\Configuration;
use SellingPartnerApi\Endpoint;
use App\amazon\AmazonAccountApplication;

trait Amazon {
    protected $applicationInfo = [];
    protected $marketPlaceId = '';
    protected $marketPlace = '';
    protected $productType = '';
    protected $sellerId = 'A1FJB341J9DM5D';
    protected $issueLocal = 'en_GB';
    
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
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function applicationInfoWithToken($id){
        try{
            $applicationInfo = AmazonAccountApplication::with(['token','marketPlace' => function($query){
                $query->with(['endpointInfo']);
            }])->find($id);
            return $applicationInfo;
        }catch(\Exception $exception){
            return redirect('exception')->with('exception','Something Went Wrong');
        }
    }

    public function deleteListingFromWmsAndAmazon($sku, $config){
        $api = new Api\ListingsApi($config);
        $marketplace_ids = array($this->marketPlaceId);
        return $api->deleteListingsItem($this->sellerId, $sku, $marketplace_ids);
        
    }

    public function changePriceFromWmsAndAmazon($productType,$sku,$value,$config){
        $data = [
            'productType' => $productType,
            'patches' => [
                [
                    'op' => 'replace',
                    'path' => '/attributes/purchasable_offer',
                    'value' => [
                        [
                            'marketplace_id'  => $this->marketPlaceId,
                            'currency' => 'GBP',
                            'our_price' => [
                                [
                                    'schedule' => [
                                            [
                                                'value_with_tax' => $value
                                            ]
                                        ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $body = json_encode($data);
        $api = new Api\ListingsApi($config);
        $marketplace_ids = array($this->marketPlaceId);
        $result = $api->patchListingsItem($this->sellerId, $sku, $marketplace_ids, $body);
        return $result;
    }


}