<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//    protected $table = ['orders'];
    protected $fillable = ['id','order_number','exchange_order_id','status','created_via','currency','total_price','customer_id','customer_name','customer_email','customer_phone','customer_country','customer_city',
        'customer_zip_code','customer_state','customer_note','shipping','shipping_post_code','postcode_status','shipping_method','picker_id','assigner_id','packer_id','cancelled_by','payment_method','transaction_id','date_created','date_completed','account_id','buyer_message','is_buyer_message_read',
    'shipping_user_name','ebay_user_id','shipping_phone','shipping_city','shipping_county','shipping_country','shipping_address_line_1','shipping_address_line_2','shipping_address_line_3','ebay_tax_reference'];
    protected $dates = ['deleted_at'];

    public function product_variations()
    {
       return $this->belongsToMany('App\ProductVariation','product_orders','order_id','variation_id')
           ->withPivot('id','name','quantity', 'price', 'status','picked_quantity','status','updated_at');
    }

    public function picker_info()
    {
        return $this->belongsTo('App\User','picker_id','id');
    }

    public function packer_info()
    {
        return $this->belongsTo('App\User','packer_id', 'id');
    }

    public function assigner_info()
    {
        return $this->belongsTo('App\User','assigner_id', 'id');
    }

    public function cancelled_by_user()
    {
        return $this->belongsTo('App\User', 'cancelled_by', 'id');
    }

    public function productOrders()
    {
        return $this->belongsToMany('App\ProductVariation','product_orders','order_id','variation_id')
            ->withPivot('id','name','quantity','picked_quantity', 'price', 'status')->wherePivot('deleted_at',null);
    }

    public function order_note(){
        return $this->hasOne('App\OrderNote');
    }

    public function orderCancelReason(){
        return $this->belongsToMany('App\CancelReason','order_cancel_reasons','order_id','order_cancel_id');
    }

    public function account_ID(){
        return $this->belongsTo('App\EbayAccount', 'account_id', 'id');
    }

    public function ebayMaster(){
        return $this->hasMany('App\EbayMasterProduct','account_id','account_id');
    }

    public function orderedProduct(){
        return $this->hasMany('App\ProductOrder','order_id','id');
    }

    public function returnOrder(){
        return $this->belongsTo('App\ReturnOrder','id','order_id');
    }

}
