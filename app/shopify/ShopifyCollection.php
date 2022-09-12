<?php

namespace App\Shopify;

use Illuminate\Database\Eloquent\Model;

class ShopifyCollection extends Model
{
    //
    protected $fillable = ['category_name','user_id','shopify_collection_id'];

    public function user_info(){
        return $this->belongsTo('App\shopify\ShopifyAccount','user_id','id');
    }
}
