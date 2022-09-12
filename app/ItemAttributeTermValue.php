<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAttributeTermValue extends Model
{
    use softDeletes;
    protected $fillable = ['item_attribute_term_id','item_attribute_term_value'];
    protected $dates = ['deleted_at'];

    public function mappingFields(){
        return $this->belongsTo('App\Mapping','item_attribute_term_id','attribute_term_id');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint){
        return $query->whereHas($relation, $constraint)
                     ->with([$relation => $constraint]);
    }
}
