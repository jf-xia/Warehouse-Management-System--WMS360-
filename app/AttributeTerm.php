<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
class AttributeTerm extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','attribute_id','terms_name'];
    protected $dates = ['deleted_at'];

    public function attribute(){
        return $this->belongsTo('App\Attribute');
    }
    public function productDrafts(){
        return $this->belongsToMany('App\ProductDraft');
    }
}
