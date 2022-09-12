<?php

namespace App\woocommerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoocommerceCatalogue extends Model
{
    use SoftDeletes;
    protected  $table = 'woocom_master_products';
    protected $fillable =
        ['id', 'user_id','master_catalogue_id', 'modifier_id','brand_id','gender_id','name', 'type','sku', 'description', 'short_description','images' ,'regular_price',
            'sale_price','rrp', 'cost_price','product_code','color_code','attribute','not_attribute', 'low_quantity','status'];
    protected $dates =[
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function all_category(){
        return $this->belongsToMany('App\Category','product_draft_category','product_draft_id','category_id');
    }

    public function variations(){
        return $this->hasMany('App\woocommerce\WoocommerceVariation','woocom_master_product_id','id');
    }

    public function user_info(){
        return $this->belongsTo('App\User','user_id','id')->select('id','name','deleted_at')->withTrashed();
    }

    public function modifier_info(){
        return $this->belongsTo('App\User','modifier_id','id')->select('id','name','deleted_at')->withTrashed();
    }

    public function sold_variations(){
        return $this->hasMany('App\woocommerce\WoocommerceVariation','woocom_master_product_id');
    }

    public function attributeTerms(){
        return $this->belongsToMany('App\AttributeTerm','master_catalogue_id');
    }

    public function attribute(){
        return $this->belongsTo('App\Attribute');
    }

    public  function master_product(){
        return $this->belongsTo('App\ProductDraft','master_catalogue_id');
    }

    public function single_image_info(){
        return $this->hasOne('App\WoocommerceImage','woo_master_catalogue_id');
    }

    public function all_image_info(){
        return $this->hasMany('App\WoocommerceImage','woo_master_catalogue_id');
    }

    public function woocommVariation(){
        return $this->hasMany('App\woocommerce\WoocommerceVariation','woocom_master_product_id','id');
    }
}
