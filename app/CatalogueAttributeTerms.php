<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogueAttributeTerms extends Model
{
    use softDeletes;
    protected $fillable = ['catalogue_id','attribute_id','attribute_term_id'];
    protected $dates = ['deleted_at'];

    public function itemAttributeTermValue(){
        return $this->belongsTo('App\ItemAttributeTermValue','attribute_term_id','id');
    }
}
