<?php

namespace App\woocommerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoocommerceAttributeTerm extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','attribute_id','master_terms_id','terms_name'];
    protected $dates = ['deleted_at'];

    // public function attribute(){
    //     return $this->belongsTo('App\Attribute');
    // }
    // public function productDrafts(){
    //     return $this->belongsToMany('App\ProductDraft');
    // }
}
