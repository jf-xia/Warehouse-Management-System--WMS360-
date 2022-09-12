<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeTermProductDraft extends Model
{
    use SoftDeletes;
    protected $table = 'attribute_term_product_draft';

    protected $fillable = [
        'product_draft_id',
        'attribute_term_id',
        'attribute_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function attribute(){
        return $this->belongsTo('App\Attribute');
    }

    public function terms_info(){
        return $this->belongsTo('App\AttributeTerm','attribute_term_id');
    }

}
