<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonToken extends Model
{
    use SoftDeletes;
    protected $fillable = ['application_id','refresh_token','access_token','token_type','expire_in'];
    protected $dates = ['deleted_at'];
}
