<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['id','draft_product_id','image_url'];
    protected $dates = ['deleted_at'];
}
