<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonSellerSite extends Model
{
    use SoftDeletes;
    protected $fillable = ['account_id','wms_marketplace_pk_id','marketplace_id','name','country_code','default_currency_code','default_language_code','domain_name'];
    protected $dates = ['deleted_at'];
}
