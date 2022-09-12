<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = ['style_name'];
    protected $dates = ['deleted_at'];
}
