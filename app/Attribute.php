<?php

namespace App;
use App\AttributeTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    protected $fillable = ['id','attribute_name','use_variation'];
    protected $dates = ['deleted_at'];

    public function attributesTerms(){
        return $this->hasMany('App\AttributeTerm');
    }
    public function woocommerceAttributesTerms(){
        return $this->hasMany('App\AttributeTerm');
    }

    public function terms_ids(){
        return $this->hasMany('App\AttributeTermProductDraft');
    }

}
