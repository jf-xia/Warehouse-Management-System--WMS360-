<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;
    protected $fillable = ['action_url','action_name','account_name','account_id','sku','request_data','response_data','action_by','last_quantity',
    'updated_quantity','action_date','solve_status','action_status'];
    protected $dates = ['deleted_at'];
    // protected $casts = [
    //     'request_data' => 'array',
    //     'response_data' => 'array'
    // ];
}
