<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbayAccount extends Model
{
    use SoftDeletes;
    protected $table = 'ebay_accounts';

    protected $fillable = ['id','developer_id','feeder_quantity','account_name','country','location','post_code','authorization_token','access_token','refresh_token','session_id','expiry_date','logo','default_policy'];
    protected $dates = ['deleted_at','created_at','updated_at'];

    public function sites(){

        return $this->belongsToMany('App\EbaySites','ebay_account_site','account_id','site_id');

    }

    public function developerAccount(){
        return $this->hasOne('App\DeveloperAccount','id','developer_id');
    }
}
