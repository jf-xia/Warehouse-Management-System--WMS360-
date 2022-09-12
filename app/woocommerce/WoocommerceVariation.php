<?php

namespace App\woocommerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoocommerceVariation extends Model
{
    use SoftDeletes;
    protected  $table = 'woocom_variation_products';
    protected $fillable = [
        'id', 'woocom_master_product_id','woocom_variation_id','image','attribute',
        'attribute1', 'attribute2', 'attribute3','attribute4','attribute5','attribute6',
        'attribute7','attribute8','attribute9','attribute10',
        'sku','actual_quantity','ean_no',
        'regular_price',
        'sale_price','rrp',
        'cost_price','product_code','color_code',
        'low_quantity',
        'notification_status',
        'manage_stock',
        'description',
    ];
    protected $dates =[
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function order_products(){
        return $this->hasMany('App\ProductOrder','variation_id','id');
    }

    public function shelf_quantity(){
        return $this->belongsToMany('App\Shelf','product_shelfs','variation_id','shelf_id')->withPivot('id','quantity');
    }

    public function master_variation(){
        return $this->belongsTo('App\ProductVariation','woocom_variation_id');
    }

    public function master_catalogue(){
        return $this->belongsTo('App\woocommerce\WoocommerceCatalogue','woocom_master_product_id');
    }

    public function order_products_without_cancel_and_return(){
        return $this->hasMany('App\ProductOrder','variation_id','variation_id');
    }

}
