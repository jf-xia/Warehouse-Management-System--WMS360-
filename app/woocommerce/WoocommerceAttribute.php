<?php

namespace App\woocommerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoocommerceAttribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','master_attribute_id','attribute_name','use_variation'];
    protected $dates = ['deleted_at'];

    public function attributesTerms(){
        return $this->hasMany('App\woocommerce\WoocommerceAttributeTerm','attribute_id','id');
    }
    public function woocommerceAttributesTerms(){
        return $this->hasMany('App\woocommerce\WoocommerceAttributeTerm','attribute_id','id');
    }

    // public function terms_ids(){
    //     return $this->hasMany('App\AttributeTermProductDraft');
    // }
}
