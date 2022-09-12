<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShelfQuantityChangeLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','shelf_id','variation_id','previous_quantity','update_quantity','reason'];
    protected $dates = ['deleted_at'];

    public function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function shelf_info(){
        return $this->hasOne('App\Shelf','id','shelf_id');
    }

    public function variation_info(){
        return $this->hasOne('App\ProductVariation','id','variation_id');
    }
}
