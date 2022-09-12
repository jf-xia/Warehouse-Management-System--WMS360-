<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectedProduct extends Model
{
    use SoftDeletes;
    protected $fillable = ['variation_id','defected_product','defect_reason_id','defect_action_id'];

    public function defectReason(){
        return $this->hasOne('App\DefectedProductReason','id','defect_reason_id');
    }

    public function variationInfo(){
        return $this->hasOne('App\ProductVariation','id','variation_id');
    }

    public function defectAction(){
        return $this->hasOne('App\DefectProductAction','id','defect_action_id');
    }
}
