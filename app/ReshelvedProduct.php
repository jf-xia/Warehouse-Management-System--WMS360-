<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReshelvedProduct extends Model
{
    protected $table = 'reshelved_product';
    protected $fillable = ['variation_id','shelf_id','user_id','quantity','status'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function shelf_info(){
        return $this->belongsTo('App\Shelf','shelf_id','id');
    }

    public function variation_info(){
        return $this->belongsTo('App\ProductVariation','variation_id','id');
    }

    public function user_info(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
