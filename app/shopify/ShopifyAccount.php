<?php

namespace App\shopify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopifyAccount extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['account_name','account_logo','account_status','shop_url','api_key','password'];
}
