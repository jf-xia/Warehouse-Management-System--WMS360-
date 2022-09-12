<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    protected $table = 'invoices';
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'receiver_user_id',
        'invoice_number',
        'invoice_total_price',
        'receive_date',
        'return_order_id',
    ];


    protected $dates = ['created_at, updated_at', 'deleted_at'];

    public function productVariations(){

        return $this->belongsToMany('App\ProductVariation','invoice_product_variation');
    }

    public function invoiceProductVariations(){
        return $this->hasMany('App\InvoiceProductVariation');
    }

    public function invoice_product_variation_info(){

        return $this->belongsToMany('App\ProductVariation','invoice_product_variation')->withPivot('shelver_user_id','quantity','price','shelving_status','product_type','total_price');
    }

    public function user_info(){
        return $this->belongsTo('App\User','receiver_user_id');
    }

    public function vendor_info(){
        return $this->belongsTo('App\Vendor','vendor_id','id');
    }

    public function return_order_info(){
        return $this->belongsTo('App\ReturnOrder','return_order_id','id');
    }
}
