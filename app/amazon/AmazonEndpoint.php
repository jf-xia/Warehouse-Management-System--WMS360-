<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonEndpoint extends Model
{
    use SoftDeletes;
    protected $fillable = ['endpoint','endpoint_shortcode','url','region'];
}
