<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDraftCategory extends Model
{
    protected $table = 'product_draft_category';
    protected $fillable = ['category_id','product_draft_id'];
}
