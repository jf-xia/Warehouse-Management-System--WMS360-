<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonAccountApplication extends Model
{
    use SoftDeletes;
    protected $fillable = ['amazon_account_id','application_name','application_id','iam_arn','lwa_client_id','lwa_client_secret',
    'aws_access_key_id','aws_secret_access_key','amazon_marketplace_fk_id ','oauth_login_url',
    'oauth_redirect_url','application_status','application_logo'];
    protected $dates = ['deleted_at'];

    public function accountInfo(){
        return $this->belongsTo('App\amazon\AmazonAccount','amazon_account_id','id');
    }

    public function marketPlace(){
        return $this->belongsTo('App\amazon\AmazonMarketPlace','amazon_marketplace_fk_id','id');
    }

    public function token(){
        return $this->belongsTo('App\amazon\AmazonToken','id','application_id');
    }

    // public function endpointInfo (){
    //     return $this->hasOneThrough('App\amazon\AmazonEndpoint','App\amazon\AmazonMarketPlace','endpoint_id','id','amazon_marketplace_fk_id','id');
    // }
}
