<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnbuyCategory extends Model
{
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_id','name','category_tree','category_type_id','category_type','parent_id','lvl','product_code_required','can_list_in'];
    protected $dates = ['deleted_at'];
}
