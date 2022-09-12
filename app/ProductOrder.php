<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOrder extends Model
{
    use SoftDeletes;
    protected $table = 'product_orders';

    protected $fillable = ['order_id','variation_id','name','quantity','picked_quantity','price','status'];

    protected $dates = ['create_at', 'updated_at', 'deleted_at'];

    public function order(){
        return $this->belongsTo('App\Order');
    }

    public function variation_info(){
        return $this->belongsTo('App\ProductVariation','variation_id');
    }

    public function returnOrder(){
        return $this->belongsTo('App\ReturnOrder','order_id','order_id');
    }
}
