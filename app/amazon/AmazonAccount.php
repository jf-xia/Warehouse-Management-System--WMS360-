<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonAccount extends Model
{
    use SoftDeletes;
    protected $fillable = ['account_name','account_status','account_logo'];
    protected $dates = ['deleted_at'];

    public function sellerSites(){
        return $this->hasMany('App\amazon\AmazonSellerSite','account_id','id');
    }
    public function accountApplication(){
        return $this->hasMany('App\amazon\AmazonAccountApplication','amazon_account_id','id');
    }
}
