<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $fillable = ['aggregate_value, shipping_fee'];
}
