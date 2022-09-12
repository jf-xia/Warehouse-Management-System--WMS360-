<?php

namespace App\amazon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazonCountry extends Model
{
    use SoftDeletes;
    protected $fillable = ['country','country_shortcode'];
    protected $dates = ['deleted_at'];
}
