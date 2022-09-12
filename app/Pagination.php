<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagination extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','per_page'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
