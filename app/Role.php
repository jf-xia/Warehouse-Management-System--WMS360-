<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['role_name'];
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function users_list()
    {
        return $this->belongsToMany('App\User','user_role','role_id','user_id');
    }
}
