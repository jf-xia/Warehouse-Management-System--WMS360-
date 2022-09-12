<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','category_name'];
    protected $dates = ['deleted_at'];

    public function productDrafts(){
        return $this->belongsToMany('App\ProductDraft');
    }
}
