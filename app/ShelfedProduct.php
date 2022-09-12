<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShelfedProduct extends Model
{
   use SoftDeletes;
    protected $table = 'product_shelfs';

   protected $fillable = ['shelf_id', 'variation_id','quantity'];

   protected $dates = ['created_at', 'updated_at','deleted_at'];

   public function shelf_info(){
       return $this->belongsTo('App\Shelf','shelf_id','id');
   }

   public function variation_info(){
       return $this->belongsTo('App\ProductVariation','variation_id');
   }
}
