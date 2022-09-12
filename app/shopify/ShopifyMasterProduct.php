<?php

namespace App\shopify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShopifyMasterProduct extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['account_id','master_catalogue_id','shopify_product_id','title','description','vendor','product_type','attribute','image','tags','regular_price','sale_price','rrp','status','creator_id','modifier_id'];

    public function variationProducts(){
        return $this->hasMany('App\shopify\ShopifyVariation','shopify_master_product_id','id');
    }

    public function modifier_info(){
        return $this->belongsTo('App\User', 'modifier_id', 'id')->select('id', 'name');

    }

    public function shopifyUserInfo(){
        return $this->belongsTo('App\shopify\ShopifyAccount', 'account_id', 'id')->select('id', 'account_name','account_logo','shop_url');

    }
}
