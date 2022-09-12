<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnbuyMasterProduct extends Model
{
    use SoftDeletes;
//    protected $table = ['onbuy_master_product'];
    protected $fillable = ['opc','product_id','woo_catalogue_id','master_category_id','master_brand_id','product_type','summary_points','published','product_name','queue_id','update_queue_id','description','videos','documents','default_image','additional_images',
        'product_data','features','rrp','base_price','low_quantity','status'];
    protected $dates = ['deleted_at'];

    public function variation_product(){
        return $this->hasMany('App\OnbuyVariationProducts','master_product_id','id');
    }

    public function category_info(){
        return $this->belongsTo('App\OnbuyCategory','master_category_id','category_id');
    }

    public function brand_info(){
        return $this->belongsTo('App\OnbuyBrand','master_brand_id','brand_id');
    }
}
