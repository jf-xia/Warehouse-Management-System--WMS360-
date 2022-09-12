<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayTemplate extends Model
{
    protected $table = 'ebay_templates';
    protected $fillable = ['id','template_name','template_html','template_file_name'];
    protected $dates = ['created_at','updated_at'];
}
