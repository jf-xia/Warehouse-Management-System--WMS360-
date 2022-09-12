<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentPolicy extends Model
{
    protected $table = 'shipment_policies';

    protected $fillable = ['shipment_id','account_id','site_id','shipment_name','shipment_description'];
    protected $dates = ['created_at','updated_at','deleted_at'];
}
