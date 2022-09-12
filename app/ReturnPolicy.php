<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
    protected $table = 'return_policies';

    protected $fillable = ['site_id','account_id','return_id','return_name','return_description'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
