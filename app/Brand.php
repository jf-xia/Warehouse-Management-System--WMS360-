<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = ['id','name'];
    protected $dates = ['deleted_at','create_at','updated_at'];
}
