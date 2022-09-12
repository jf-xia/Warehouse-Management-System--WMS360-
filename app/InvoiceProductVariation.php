<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceProductVariation extends Model
{
    protected $table = 'invoice_product_variation';
    use SoftDeletes;
    protected $fillable = [
        'invoice_id',
        'product_variation_id',
        'shelver_user_id',
        'quantity',
        'shelved_quantity',
        'price',
        'shelving_status',
        'product_type',
        'total_price',
        'shelve_error',
        'error_shelve_details'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function getErrorShelveDetailsAttribute(){
        if($this->attributes['error_shelve_details'] != null){
            return json_decode($this->attributes['error_shelve_details']);
        }
    }


    public function user_shelved_product(){
        return $this->belongsTo('App\ProductVariation','product_variation_id','id');
    }

    public function user_shelved_invoice_no(){
        return $this->belongsTo('App\Invoice','invoice_id','id');
    }

    public function productVariation(){
        return $this->belongsTo('App\ProductVariation');
    }

    public function product_invoice_info(){
        return $this->belongsTo('App\Invoice','invoice_id','id');
    }

    public function product_variation_info(){
        return $this->belongsTo('App\ProductVariation','product_variation_id','id');
    }

    public function condition(){
        return $this->belongsTo('App\Condition','product_type','id');
    }

}
