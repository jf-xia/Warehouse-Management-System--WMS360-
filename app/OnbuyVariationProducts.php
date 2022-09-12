<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnbuyVariationProducts extends Model
{
    use SoftDeletes;
    protected $fillable = ['sku','updated_sku','master_product_id','queue_id','update_queue_id','opc','ean_no','attribute1_name','attribute1_value','attribute2_name','attribute2_value',
        'name','group_sku','price','base_price','max_price','stock','technical_detail','product_listing_id', 'product_listing_condition_id','condition','product_encoded_id',
        'delivery_weight','delivery_template_id','boost_marketing_commission','low_quantity'];
    protected $dates = ['deleted_at'];

    public function master_product_info(){
        return $this->belongsTo('App\OnbuyMasterProduct','master_product_id','id');
    }
}
