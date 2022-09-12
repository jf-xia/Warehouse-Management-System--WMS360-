<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WoocommerceImage extends Model
{
    protected $table = 'woocom_images';
    protected $fillable = ['id','woo_master_catalogue_id','image_url'];
    protected $dates = ['deleted_at'];
}
