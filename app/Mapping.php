<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mapping extends Model
{
    use softDeletes;
    protected $fillable = ['channel_id','attribute_term_id','mapping_field'];
    protected $dates = ['deleted_at'];

    public function attributeTerms(){
        return $this->belongsTo('App\ItemAttributeTerm','attribute_term_id','id');
    }
}
