<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'genders';

    protected $fillable = ['id','name'];
    protected $dates = ['deleted_at','create_at','updated_at'];

    public function genders(){
        return $this->belongsToMany('App\WooWmsCategory','gender_wms_categories','gender_id','wms_category_id');
    }
}
