<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderNote extends Model
{
    use SoftDeletes;
    protected $fillable = ['order_id','note','note_creator','note_modifier'];
    protected $dates = ['deleted_at'];

    public function user_info(){
        return $this->belongsTo('App\User','note_creator');
    }
    public function modifier_info(){
        return $this->belongsTo('App\User','note_modifier');
    }
    public function orderInfo(){
        return $this->belongsTo('App\Order','order_id','id');
    }
}
