<?php
namespace App\Traits;

use App\Client;
use App\ProductDraft;
use App\OnbuyMasterProduct;
use App\EbayMasterProduct;
use App\amazon\AmazonMasterCatalogue;
use App\woocommerce\WoocommerceCatalogue;
use App\shopify\ShopifyMasterProduct;

trait ListingLimit {

    public function ListingLimitAllChannelActiveProduct(){
        $activeCatalogueCount = ProductDraft::where('status', 'publish')->count();
        $wooActiveProductCount = WoocommerceCatalogue::where('status', 'publish')->count();
        $onbuyActiveProductCount = OnbuyMasterProduct::where('status', 'success')->count();
        $ebayActiveProductCount = EbayMasterProduct::where('product_status', 'Active')->count();
        $amazonActiveProductCount = AmazonMasterCatalogue::count();
        $shopifyActiveProductCount = ShopifyMasterProduct::count();
        $subTotalActiveProduct =  $activeCatalogueCount + $wooActiveProductCount + $onbuyActiveProductCount + $ebayActiveProductCount + $amazonActiveProductCount + $shopifyActiveProductCount;

        $listing_limit_arr = [
            'activeCatalogueCount' => $activeCatalogueCount,
            'wooActiveProductCount' => $wooActiveProductCount,
            'onbuyActiveProductCount' => $onbuyActiveProductCount,
            'ebayActiveProductCount' => $ebayActiveProductCount,
            'amazonActiveProductCount' => $amazonActiveProductCount,
            'shopifyActiveProductCount' => $shopifyActiveProductCount,
            'subTotalActiveProduct' => $subTotalActiveProduct,
        ];
        // return $subTotalActiveProduct;
        return $listing_limit_arr;
    }

    public function ClientListingLimit(){
        $listingLimit = Client::first();
        $limit = $listingLimit['listing_limit'];
        return $limit;
    }

}
