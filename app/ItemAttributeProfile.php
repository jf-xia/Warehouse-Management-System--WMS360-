<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAttributeProfile extends Model
{
    use SoftDeletes;
    protected $fillable = ['profile_name','item_attribute_id','category_id'];
    protected $dates = ['deleted_at'];

    public function profileTerm() {
        return $this->belongsTo('App\ItemAttribute','item_attribute_id','id');
    }

    public function itemAttributeProfileTerm() {
        return $this->hasMany('App\ItemAttributeProfileTerm','item_attribute_profile_id','id');
    }
}
