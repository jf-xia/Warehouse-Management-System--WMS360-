<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CommonFunction;

class ProductVariation extends Model
{
    use SoftDeletes;
    use CommonFunction;
    protected $table = 'product_variation';

    protected $fillable = [
        'id', 'product_draft_id','image','image_attribute','variation_images','attribute',
        'sku','actual_quantity','ean_no',
        'regular_price',
        'sale_price','rrp',
        'cost_price','base_price','product_code','color_code',
        'low_quantity','low_quantity_visibility',
        'notification_status','change_message',
        'manage_stock',
        'description',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getImageAttribute(){
        $parseUrlInfo = $this->parseUrl($this->attributes['image']);
        if(($this->attributes['image'] != null) && (!isset($parseUrlInfo['scheme']))){
            return $this->projectUrl().$this->attributes['image'];
        }
        return $this->attributes['image'];
    }

    public function product(){

        return $this->belongsTo('App\ProductDraft');
    }

    public function orders(){
       return $this->belongsToMany('App\Order','product_orders')->withPivot('quantity', 'price', 'status');
    }

    public function invoices(){

        return $this->belongsToMany('App\Invoice');
    }

    public function product_draft(){
        return $this->belongsTo('App\ProductDraft','product_draft_id','id');
    }

    public function invoiceProductVariations(){
        return $this->hasMany('App\InvoiceProductVariation');
    }

    public function shelf_quantity(){
        return $this->belongsToMany('App\Shelf','product_shelfs','variation_id','shelf_id')->wherePivot('deleted_at', NULL)->withPivot('id','quantity');
    }

    public function top_order_product_list(){

        return $this->belongsTo('App\ProductDraft','product_draft_id','id');
    }

    public function order_products(){
        return $this->hasMany('App\ProductOrder','variation_id','id');
    }

    public function woocommerce_variations(){
        return $this->belongsTo('App\woocommerce\WoocommerceVariation','id','woocom_variation_id');
    }

    public function master_single_image(){
        return $this->hasOne('App\Image','draft_product_id','product_draft_id');
    }

    public function getSelfVariation(){
        return $this->hasOne('App\ProductVariation','id');
    }

    public function variationInvoices(){
        return $this->hasManyThrough('App\Invoice','App\InvoiceProductVariation','product_variation_id','id','id','invoice_id');
    }

    public function getProductOrders(){
        return $this->belongsToMany('App\Order','product_orders','variation_id','order_id')->withPivot('quantity', 'price', 'status');
     }

    public function getOnlyOrders(){
        return $this->hasMany('App\ProductOrder','variation_id','id');
    }
    public function get_reshelved_product(){
        return $this->hasMany('App\ReshelvedProduct','variation_id','id');
    }

}
