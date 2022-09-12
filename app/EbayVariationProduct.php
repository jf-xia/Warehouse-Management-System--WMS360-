<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbayVariationProduct extends Model
{
    use SoftDeletes;
    protected $table = 'ebay_variation_products';

    protected $fillable = ['id','ebay_master_product_id','master_variation_id','sku','variation_specifics',
        'start_price','rrp','quantity','ean','change_status'];

    protected $dates = ['created_at','updated_at','deleted_at'];

    public function masterProduct(){
        return $this->belongsTo('App\EbayMasterProduct','ebay_master_product_id','id');
    }

    public function orderProduct(){
        return $this->hasMany('App\ProductOrder','variation_id','master_variation_id');
    }

}
