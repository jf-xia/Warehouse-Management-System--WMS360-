<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentPolicy extends Model
{
    protected $table = 'payment_policies';
    protected $fillable = ['payment_id','account_id','site_id','payment_name','payment_description'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
