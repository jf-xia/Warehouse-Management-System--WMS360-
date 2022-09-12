<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonProductType extends Model
{
    use SoftDeletes;
    protected $fillable = ['marketplace_id','product_type'];
    protected $dates = ['deleted_at'];
}
