<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectedProductReason extends Model
{
    use SoftDeletes;
    protected $fillable = ['reason'];
}
