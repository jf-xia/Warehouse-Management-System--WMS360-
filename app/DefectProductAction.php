<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefectProductAction extends Model
{
    use SoftDeletes;
    protected $fillable = ['action'];
}
