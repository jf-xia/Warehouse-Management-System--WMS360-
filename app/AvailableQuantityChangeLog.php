<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableQuantityChangeLog extends Model
{
    protected $fillable = ['modified_by','variation_id','previous_quantity','updated_quantity','reason'];

    public function userInfo(){
        return $this->belongsTo('App\User','modified_by','id');
    }

    public function variationInfo(){
        return $this->belongsTo('App\ProductVariation','variation_id','id');
    }
}
