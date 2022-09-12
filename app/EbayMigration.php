<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EbayAccount;

class EbayMigration extends Model
{
    protected $table = 'ebay_migration';
    protected $fillable = ['id','site_id','account_id','imgae','title','category_id','category_name','item_id','url',
        'status','message','page_number','item_number','condition_id','condition_name'];
    protected $dates = ['create_at','updated_at'];

    public function accountInfo(){
        return $this->belongsTo('App\EbayAccount','account_id','id');
    }

}
