<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbayMasterProduct extends Model
{
    use SoftDeletes;
    protected $table = 'ebay_master_products';
    protected $primaryKey = 'id';
    protected $fillable = ['id','item_id','account_id','master_product_id','site_id','creator_id','title','subtitle','description','item_description','variation_specifics','master_images','variation_images','dispatch_time','product_type','start_price','condition_id','condition_description',
        'category_id','category_name','store_id','store_name','store2_id','currency','store2_name','duration','location','country','post_code','item_specifics','shipping_id','return_id','payment_id','custom_feeder_quantity','product_status',
        'paypal','change_status','image_attribute','profile_id','profile_status','draft_status','campaign_status','campaign_data','modifier_id','galleryPlus','eps','type','private_listing','cross_border_trade','fees'];

    protected $dates = ['created_at','updated_at','deleted_at'];

    public function variationProducts(){
        return $this->hasMany('App\EbayVariationProduct','ebay_master_product_id','id');
    }

    public function AccountInfo(){
        return $this->hasOne('App\EbayAccount','id','account_id');

    }
    public function creator_info(){
        return $this->belongsTo('App\User', 'creator_id', 'id')->select('id', 'name');
    }

    public function modifier_info(){
        return $this->belongsTo('App\User', 'modifier_id', 'id')->select('id', 'name');

    }

    public function orders(){
        return $this->hasMany('App\Order','account_id','account_id');
    }
}
