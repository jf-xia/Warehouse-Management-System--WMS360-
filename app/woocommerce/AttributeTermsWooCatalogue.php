<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeTermsWooCatalogue extends Model
{
    use SoftDeletes;
    protected $table = 'attribute_terms_woo_catalogue';
    protected $fillable = [
        'product_draft_id',
        'attribute_term_id',
        'attribute_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
