<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WooWmsCategory extends Model
{
    use SoftDeletes;
    protected $table = 'woowms_categories';
    protected $fillable = ['category_name','user_id'];
    protected $dates =['created_at','updated_at','deleted_at'];

    public function genders(){
        return $this->belongsToMany('App\Gender','gender_wms_categories','wms_category_id','gender_id');
    }
        public function categoryAttribute(){
            return $this->hasMany('App\CategoryItemAttribute','category_id','id');
        }

}

