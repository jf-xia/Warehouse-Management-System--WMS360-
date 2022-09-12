<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryItemAttribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id','item_attribute_id'];
    protected $dates = ['deleted_at'];

    public function attributes(){
        return $this->hasMany('App\ItemAttribute','id','item_attribute_id');
    }
}
