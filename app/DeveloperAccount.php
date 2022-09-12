<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeveloperAccount extends Model
{
    protected $table = 'developer_accounts';

    protected $fillable = ['client_id','client_secret','redirect_url_name','sign_in_link','status'];

    protected $dates = ['create_at','updated_at'];
}
