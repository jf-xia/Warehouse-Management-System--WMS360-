<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonMarketPlace extends Model
{
    use SoftDeletes;
    protected $fillable = ['marketplace','endpoint_id','marketplace_id','marketplace_url','marketplace_logo'];
    protected $dates = ['deleted_at'];

    public function productType(){
        return $this->hasMany('App\amazon\AmazonProductType','marketplace_id','id');
    }

    public function endpointInfo(){
        return $this->belongsTo('App\amazon\AmazonEndpoint','endpoint_id','id');
    }
}
