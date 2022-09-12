<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    protected $fillable = ['order_id','returned_by','return_reason','return_cost'];

    public function return_product_save(){
        return $this->belongsToMany('App\ProductVariation','return_order_products','return_order_id','variation_id')
            ->withPivot('id','product_name','return_product_quantity','price','status');
    }

    public function orders(){
        return $this->belongsTo('App\Order','order_id','id');
    }

    public function is_return_product_shelved(){
        return $this->belongsToMany('App\ProductVariation','return_order_products','return_order_id','variation_id')->wherePivot('status',0);
    }

    public function returned_by_user (){
        return $this->belongsTo('App\User', 'returned_by', 'id');
    }

    public function order_note(){
        return $this->hasOne('App\OrderNote','order_id','order_id');
    }

    public function orderedProduct(){
        return $this->hasMany('App\ReturnOrderProduct');
    }
}
