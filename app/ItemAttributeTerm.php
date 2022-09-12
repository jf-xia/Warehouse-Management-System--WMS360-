<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAttributeTerm extends Model
{
    use SoftDeletes;
    protected $fillable = ['item_attribute_id','item_attribute_term','item_attribute_term_slug','is_active'];
    protected $dates = ['deleted_at'];

    protected $columns = ['id','item_attribute_id','item_attribute_term','item_attribute_term_slug','is_active','created_at','updated_at','deleted_at'];

    public function scopeExclude($query,$value=[]){
        return $query->select( array_diff( $this->columns,(array) $value) );
    }
    public function itemAttribute(){
        return $this->belongsTo('App\ItemAttribute');
    }

    public function catalogueItemAttribute(){
        return $this->belongsTo('App\CatalogueAttributeTerms','id','attribute_id');
    }

    public function itemProfileAttributeTermValue() {
        return $this->belongsTo('App\ItemAttributeProfileTerm','id','item_attribute_term_id');
    }
}
