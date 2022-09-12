<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WoocommerceAccount extends Model
{
    use SoftDeletes;
    protected $fillable = ['consumer_key','account_name','secret_key','site_url','status','creator','modifier'];
    protected $dates = ['deleted_at'];

    public function creatorInfo(){
        return $this->belongsTo('App\User','creator');
    }
    public function modifierInfo(){
        return $this->belongsTo('App\User','modifier');
    }
}
