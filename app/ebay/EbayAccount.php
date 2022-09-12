<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayAccount extends Model
{
    protected $table = 'ebay_accounts';

    protected $fillable = ['id','developer_id','account_name','authorization_token','access_token','refresh_token','session_id','expiry_date'];
    protected $dates = ['deleted_at','created_at','updated_at'];

    public function sites(){

        return $this->belongsToMany('App\EbaySites','ebay_account_site','account_id','site_id');

    }

    public function developerAccount(){
        return $this->hasOne('App\DeveloperAccount','id','developer_id');
    }
}
