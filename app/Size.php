<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['size_name'];
    protected $dates = ['deleted_at'];
}
