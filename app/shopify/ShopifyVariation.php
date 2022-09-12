<?php

namespace App\shopify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopifyVariation extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['shopify_master_product_id','master_variation_id','image','attribute','sku','quantity','regular_price','sale_price','rrp','shopify_variant_it','fulfillment_service','inventory_management','image_id','inventory_item_id'];

    public function masterProduct(){
        return $this->belongsTo('App\shopify\ShopifyMasterProduct','shopify_master_product_id','id');
    }
}
