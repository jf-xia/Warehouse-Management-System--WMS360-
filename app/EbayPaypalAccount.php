<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayPaypalAccount extends Model
{
    protected $table = 'ebay_paypal_accounts';

    protected $fillable = ['id','paypal_email','account_id','site_id'];

    protected $dates = ['created_at','updated_at'];
}
