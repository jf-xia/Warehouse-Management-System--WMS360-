<?php
namespace App\Traits;

use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\woocommerce\WoocommerceCatalogue;

trait WoocommerceCommonFuntions {

    public function catalogueBulkDelete($requestData){
        $data['delete'] = $requestData->catalogueIDs;
        $woocommerceDeleteResult = Woocommerce::post('products/batch', $data);
        if($woocommerceDeleteResult){
            $woocommerceWmsDeleteResult = WoocommerceCatalogue::whereIn('id', $requestData->catalogueIDs)->delete();
        }
    }

}