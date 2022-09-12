<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use SoftDeletes;
    protected $fillable = ['condition_name','user_id'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
