<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbayAccountSite extends Model
{
    use  SoftDeletes;
    protected $table = 'ebay_account_site';
    protected $fillable = ['id','site_id','account_id'];
    protected $dates = ['deleted_at', 'created_at','update_at'];
}
