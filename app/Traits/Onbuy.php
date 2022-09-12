<?php
namespace App\Traits;

use App\OnbuyAccount;
use App\OnbuyVariationProducts;

trait Onbuy {

    public function getVariationInfo($param, $type = 'sku') {
        if($type == 'id') {
            return OnbuyVariationProducts::find($param);
        }
        if($type == 'sku') {
            return OnbuyVariationProducts::where('sku',$param)->first();
        }
        if($type == 'updated_sku') {
            return OnbuyVariationProducts::where('updated_sku',$param)->first();
        }
        
    }

    public function isOnbuyActiveFromAccount() {
        $accountInfo = $this->getOnbuyAccountInfo();
        if($accountInfo) {
            return $accountInfo->status == 1 ? true : false;
        }
    }

    public function getOnbuyAccountInfo() {
        return OnbuyAccount::first();
    }
}
