<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    protected $fillable = ['client_id','client_name','url','logo_url','address_line_1','address_line_2','address_line_3','country','city','post_code','phone_no','reg_no','email','vat','apps_links'
        ,'old_version','new_version','old_migration_count','new_migration_count'];

    protected $dates = ['created_at','updated_at','deleted_at'];
}
