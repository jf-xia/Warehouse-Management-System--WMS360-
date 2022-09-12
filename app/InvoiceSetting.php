<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    //
    protected $fillable = ['sku_no','variation_id','ean_no','attribute','default_vat','invoice_notice'];
}
