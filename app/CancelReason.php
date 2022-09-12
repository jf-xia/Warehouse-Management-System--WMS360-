<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CancelReason extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','reason','increment_quantity'];
    protected $dates = ['deleted_at'];
}
