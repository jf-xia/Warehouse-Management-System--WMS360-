<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EbayProfile extends Model
{
    protected $table = 'ebay_profiles';

    protected $fillable = ['account_id','site_id','profile_name','profile_description','product_type','start_price','condition_id','condition_name','condition_description',
        'category_id','sub_category_id','category_name','sub_category_name','store_id','store_name','store2_id','currency','store2_name','duration','location','country','post_code','item_specifics','shipping_id','return_id','payment_id',
        'template_id','paypal','galleryPlus','eps'];

    protected $dates = ['create_at','updated_at','deleted_at'];
}
