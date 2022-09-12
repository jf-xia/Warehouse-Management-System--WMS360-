<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','registration_no','name','company_name','email','phone_no','address','website','vat_no','country','city','state','post_code'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function invoice_info(){
        return $this->hasMany('App\Invoice');
    }
}
