<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['color_name'];
    protected $dates = ['deleted_at'];
}
