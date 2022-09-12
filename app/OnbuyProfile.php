<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnbuyProfile extends Model
{
    use SoftDeletes;
    protected $table = 'onbuy_profiles';
    protected $fillable = ['id','name','brand','category_ids','last_category_id','summery_points','master_product_data','features','technical_details'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
