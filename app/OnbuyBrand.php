<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnbuyBrand extends Model
{
    protected $primaryKey = 'brand_id';
    protected $fillable = ['brand_id','name','brand_type_id','type'];
    protected $dates = ['deleted_at'];
}
