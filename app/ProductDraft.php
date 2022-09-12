<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AttributeTerm;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDraft extends Model
{
    protected $table = 'product_drafts';
    use SoftDeletes;

    protected $fillable =
        ['id',
        'user_id', 'modifier_id','woowms_category','condition',
        'regular_price',
        'sale_price','rrp',
        'cost_price','base_price','vat','product_code','color','color_code','attribute','sku_short_code',
        'low_quantity',
        'name',
        'type',
        'description',
        'short_description',
            'status','change_message',
            'brand_id',
            'gender_id',
            // 'deleted_at',
        ];
    protected $dates =[
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function attributeTerms(){
        return $this->belongsToMany('App\AttributeTerm');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function all_category(){

        return $this->belongsToMany('App\Category','product_draft_category','product_draft_id','category_id');
    }

    public function ProductVariations(){

        return $this->hasMany('App\ProductVariation');
    }

    public function images(){
        return $this->hasMany('App\Image','draft_product_id')->orderBy('id');
    }

    public function user_info(){
        return $this->belongsTo('App\User','user_id','id')->select('id','name','deleted_at')->withTrashed();
    }

    public function product_draft_attribute(){
        return $this->belongsToMany('App\Attribute','attribute_term_product_draft','product_draft_id','attribute_id')
            ->withPivot('attribute_term_id');
    }

    public function single_image_info(){
        return $this->hasOne('App\Image','draft_product_id')->orderBy('id');
    }

    public function product_catalogue_image(){
        return $this->hasOne('App\Image','draft_product_id');
    }

    public function shelf_quantity(){
        return $this->belongsToMany('App\Shelf','product_shelfs','variation_id','shelf_id')->withPivot('quantity');
    }

    public function modifier_info(){
        return $this->belongsTo('App\User','modifier_id','id')->select('id','name','deleted_at')->withTrashed();
    }

    public function onbuy_product_info(){
        return $this->hasOne('App\OnbuyMasterProduct','woo_catalogue_id');
    }

    public function variations(){
        return $this->hasMany('App\ProductVariation');
    }

    public function woocommerce_catalogue_attribute(){
        return $this->belongsToMany('App\Attribute','attribute_term_product_draft','product_draft_id','attribute_id')
            ->withPivot('attribute_term_id');
    }

    public function woowmsCategory(){
        return $this->belongsTo('App\WooWmsCategory','woowms_category','id');
    }

    public function woocommerce_catalogue_info(){
        return $this->hasOne('App\woocommerce\WoocommerceCatalogue','master_catalogue_id','id');
    }

    public function catalogueVariation(){
        return $this->hasMany('App\ProductVariation');
    }

    public function ebayCatalogueInfo(){
        return $this->hasMany('App\EbayMasterProduct','master_product_id','id');
    }

    public function amazonCatalogueInfo(){
        return $this->hasMany('App\amazon\AmazonMasterCatalogue','master_product_id','id');
    }

    public function shopifyCatalogueInfo(){
        return $this->hasMany('App\shopify\ShopifyMasterProduct','master_catalogue_id','id');
    }

}
