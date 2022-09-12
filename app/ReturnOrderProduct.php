<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnOrderProduct extends Model
{
    use SoftDeletes;
    protected $table = 'return_order_products';

    protected $fillable = ['return_order_id', 'variation_id', 'product_name', 'return_product_quantity', 'price', 'status'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
