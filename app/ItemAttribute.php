<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAttribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['item_attribute','item_attribute_slug','is_active'];
    protected $dates = ['deleted_at'];

    protected $columns = ['id','item_attribute','item_attribute_slug','is_active','created_at','updated_at','deleted_at'];

    public function scopeExclude($query,$value=[]){
        return $query->select( array_diff( $this->columns,(array) $value) );
    }

    public function itemAttributeTerms(){
        return $this->hasMany('App\ItemAttributeTerm','item_attribute_id','id');
    }

    public function categories(){
        return $this->belongsToMany('App\WooWmsCategory','category_item_attributes','item_attribute_id','category_id');
    }
}
