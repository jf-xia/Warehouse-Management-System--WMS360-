<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonVariationProduct extends Model
{
    use SoftDeletes;
    protected $fillable = ['amazon_master_product','master_variation_id','attribute','sku',
    'ean_no','asin','quantity','regular_price','sale_price','rrp','is_master_editable'];
    protected $dates = ['deleted_at'];

    public function order_products(){
        return $this->hasMany('App\ProductOrder','variation_id','master_variation_id');
    }

    public function masterCatalogue(){
        return $this->belongsTo('App\amazon\AmazonMasterCatalogue','amazon_master_product','id');
    }

    public function accountSite(){
        return $this->hasOneThrough('App\amazon\AmazonAccountApplication','App\amazon\AmazonMasterCatalogue','application_id','id','amazon_master_product','id');
    }


}
