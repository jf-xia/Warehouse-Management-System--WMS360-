<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAttributeProfileTerm extends Model
{
    use SoftDeletes;
    protected $fillable = ['item_attribute_profile_id','item_attribute_term_id','item_attribute_term_value'];
    protected $dates = ['deleted_at'];

    public function itemAttributeTerm() {
        return $this->belongsTo('App\ItemAttributeTerm','item_attribute_term_id','id');
    }
}
