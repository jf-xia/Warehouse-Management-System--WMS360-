<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbaySites extends Model
{
    protected $table = 'ebay_sites';
    protected $fillable = ['id','name','global_id'];
    protected $dates = [ 'updated_at','created_at'];

    public function accounts(){
        $this->belongsToMany('App\EbayAccount','ebay_account_site','site_id','account_id');
    }

}
