<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenderWmsCategory extends Model
{
    use SoftDeletes;
    protected $table = 'gender_wms_categories';
    protected $fillable = ['id','gender_id','wms_category_id'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
