<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonCondition extends Model
{
    use SoftDeletes;
    protected $fillable = ['condition_name','condition_slug'];
    protected $dates = ['deleted_at'];
}
