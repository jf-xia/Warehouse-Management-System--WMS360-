<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCancelReason extends Model
{
    use SoftDeletes;
    protected $fillable = ['order_id','order_cancel_id','canceller_id','modifier_id'];
    protected $dates = ['deleted_at'];
}
