<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonMasterCatalogue extends Model
{
    use SoftDeletes;
    protected $fillable = ['master_product_id','application_id','title','master_asin','description',
    'images','product_type','condition_id','category_id','fulfilment_type','sale_price',
    'creator_id','modifier_id'];
    protected $dates = ['deleted_at'];

    public function variations(){
        return $this->hasMany('App\amazon\AmazonVariationProduct','amazon_master_product');
    }

    public function user_info(){
        return $this->belongsTo('App\User','creator_id','id');
    }

    public function modifier_info(){
        return $this->belongsTo('App\User','modifier_id','id');
    }

    public function sold_variations(){
        return $this->hasMany('App\amazon\AmazonVariationProduct','amazon_master_product');
    }

    public function allVariations(){
        return $this->variations();
    }

    public function catalogueType(){
        return $this->belongsTo('App\amazon\AmazonProductType','product_type','id');
    }

    public function applicationInfo(){
        return $this->belongsTo('App\amazon\AmazonAccountApplication','application_id','id');
    }

}
