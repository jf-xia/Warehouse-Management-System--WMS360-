<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeTerm;
use App\Image;
use App\ProductDraft;
use App\ProductVariation;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use App\WoocommerceImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\woocommerce\WoocommerceAttribute;
use App\woocommerce\WoocommerceAttributeTerm;

class WoocommerceMigrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function woocommerceAttributeList(){
        try{
            $all_attribute_list = Woocommerce::get('products/attributes');
            if(count($all_attribute_list) > 0){
                return response()->json(['type' => 'success', 'msg' => '', 'data' => $all_attribute_list]);
            }else{
                return response()->json(['type' => 'warning','msg' => 'No Attribute Found']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Somwthing Went Wrong']);
        }
        
//            echo '<pre>';
//            print_r($all_attribute_list);
//            exit();
        // if(count($all_attribute_list) > 0) {
        //     foreach ($all_attribute_list as $attribute) {
        //         $exist_attribute = Attribute::find($attribute['id']);
        //         if(!$exist_attribute) {
        //             $attribute_insert = Attribute::create([
        //                 'id' => $attribute['id'],
        //                 'attribute_name' => $attribute['name']
        //             ]);
        //         }
        //     }
        //     return 'Attribute added successfully';
        // }
        // return 'No attribute found';
    }

    public function woocommerceTermsAttributeList(){
        $all_attribute_list = Attribute::all();
        if(count($all_attribute_list) > 0 ) {
            foreach ($all_attribute_list as $attribute) {
                $all_attribute_terms_list = Woocommerce::get('products/attributes/'.$attribute->id.'/terms');
                if (count($all_attribute_terms_list) > 0) {
                    foreach ($all_attribute_terms_list as $attribute_term) {
                        $exist_attribute_terms = AttributeTerm::where('terms_name',$attribute_term['name'])->first();
                        if (!$exist_attribute_terms) {
                            $attribute_terms_insert = AttributeTerm::create([
                                'id' => $attribute_term['id'],
                                'attribute_id' => $attribute->id,
                                'terms_name' => $attribute_term['name']
                            ]);
                        }
                    }
                }
            }
            return 'Attribute terms added successfully';
        }
        return 'No attribute found';
    }

    public function woocommerceAsMasterCatalogue(){

        $i = 0;
        $offset = 0;
        $per_page = 50;
        $catalogue_array = [];
        $att_arr = [];
        $page = 1;
        while (true){
            $data = array(
//                'status' => 'publish',
//                'category' => '41',
                'type' => 'variable',
                'per_page' => 100,
                'offset' => $offset,
//                'stock_status' => 'instock',
                'orderby' => 'date',
                'order' => 'asc'
            );
//            $all_catalogue_list = Woocommerce::get('products/?offset='.$offset.'&per_page='.$per_page);
            $all_catalogue_list = Woocommerce::get('products',$data);
//                echo '<pre>';
//                print_r($all_catalogue_list);
//                exit();
            if (count($all_catalogue_list) == 0){
                break;
            }
            foreach ($all_catalogue_list as $list){
                foreach ($list['attributes'] as $attribute){
                    $options = [];
                    foreach ($attribute['options'] as $option){
                        $terms_info = AttributeTerm::where('terms_name',$option)->first();
                        $options[] = [
                            'attribute_term_id' => $terms_info->id ?? '',
                            'attribute_term_name' => $option
                        ];
                    }
                    $att_arr[$attribute['id']][$attribute['name']] = $options;
                }
                $exist_catalogue = ProductDraft::find($list['id']);
                if(!$exist_catalogue) {
                    $catalogue_array = ProductDraft::create([
                        'id' => $list['id'],
                        'user_id' => 1,
                        'modifier_id' => null,
                        'woowms_category' => null,
                        'condition' => null,
                        'name' => $list['name'],
                        'type' => 'variable',
                        'description' => $list['description'],
                        'short_description' => $list['short_description'] ?? null,
                        'regular_price' => ($list['regular_price'] == '') ? '0.00' : $list['regular_price'],
                        'sale_price' => ($list['sale_price'] == '') ? '0.00' : $list['sale_price'],
                        'cost_price' => null,
                        'product_code' => null,
                        'color' => null,
                        'color_code' => null,
                        'attribute' => \Opis\Closure\serialize($att_arr) ?? null,
                        'sku_short_code' => null,
                        'low_quantity' => 1,
                        'status' => $list['status'],
                        'created_at' => $list['date_created'] ?? null,
                        'updated_at' => $list['date_modified'] ?? null,
                        'deleted_at' => null,
                        'brand_id' => null,
                        'gender_id' => null
                    ]);

                    $dataimage = [];
                    if (count($list['images']) > 0) {
                        foreach ($list['images'] as $image) {
                            $exist_image = Image::find($image['id']);
                            if (!$exist_image) {
                                $insert_info = Image::create([
                                    'id' => $image['id'],
                                    'draft_product_id' => $list['id'] ?? null,
                                    'image_url' => $image['src'] ?? null
                                ]);
//                            $dataimage[] = [
//                                'id' => $image['id'],
//                                'draft_product_id' => $list['id'] ?? null,
//                                'image_url' => $image['src'] ?? null
//                            ];
                            }
                        }
//                    $image_insert = Image::insert($dataimage);
                    }
                }


//                $dataimage = [];
//                if (count($list['images']) > 0) {
//                    foreach ($list['images'] as $image) {
//                        $dataimage[] = [
//                            'id' => $image->id,
//                            'woo_master_catalogue_id' => $list['id'],
//                            'image_url' => $image->src
//                        ];
//                    }
//                }
//                echo '<pre>';
//                print_r($catalogue_array);
//                exit();
                $offset++;
            }
        }
        echo '<pre>';
        print_r(json_decode($offset));
        exit();
    }

    public function woocommerceAsMasterVariation(){
        $skip = 0;
        while(true) {
            $allMasterCatalogueList = ProductDraft::skip($skip)->take(100)->get();
            if (count($allMasterCatalogueList) == 0){
                break;
            }
            if (count($allMasterCatalogueList) > 0) {
                foreach ($allMasterCatalogueList as $masterCatalogue) {
                    $all_variation_list = Woocommerce::get('products/' . $masterCatalogue->id . '/variations/');
//                    echo '<pre>';
//                    print_r($all_variation_list);
//                    exit();
                    $catalogue_array = [];
                    foreach ($all_variation_list as $list) {
                        $options = [];
                        foreach ($list['attributes'] as $attribute) {
                            $terms_info = AttributeTerm::where('terms_name', $attribute['option'])->first();
                            $options[] = [
                                'attribute_id' => $attribute['id'],
                                'attribute_name' => $attribute['name'],
                                'terms_id' => $terms_info->id ?? '',
                                'terms_name' => $attribute['option']
                            ];
//                            $att_arr[$attribute['id']][$attribute['name']] = $options;
                        }
                        $master_catalogue_info = ProductDraft::where('id', $masterCatalogue->id)->first();
                        $master_variation_info = ProductVariation::where('sku', $list['sku'])->first();
                        if(!$master_variation_info) {
                            $catalogue_array = ProductVariation::create([
                                'id' => $list['id'],
                                'product_draft_id' => $masterCatalogue->id,
                                'image' => $list['image']['src'] ?? null,
                                'attribute' => \Opis\Closure\serialize($options),
                                'sku' => $list['sku'],
                                'actual_quantity' => $list['stock_quantity'],
                                'ean_no' => $master_variation_info->ean_no ?? null,
                                'product_code' => $master_catalogue_info->product_code ?? null,
                                'color_code' => $master_catalogue_info->color_code ?? null,
                                'regular_price' => ($list['regular_price'] == '') ? '0.00' : $list['regular_price'],
                                'sale_price' => ($list['sale_price'] == '') ? '0.00' : $list['sale_price'],
                                'cost_price' => $master_catalogue_info->cost_price ?? null,
                                'low_quantity' => $master_catalogue_info->low_quantity ?? null,
                                'notification_status' => 1,
                                'manage_stock' => $list['manage_stock'] ?? 1,
                                'description' => $list['description'] ?? null,
                                'created_at' => $list['date_created'],
                                'updated_at' => $list['date_modified'],
                                'deleted_at' => null
                            ]);
                        }
                    }
                    $skip++;
                }
            }
        }
        echo "<pre>";
        print_r($skip);
        exit();
    }

    public function woocommerceCatalogue(){
        $skip = 0;
        while (true){
            $allMasterCatalogue = ProductDraft::with('images')->skip($skip)->take(100)->get();
            if (count($allMasterCatalogue) == 0){
                break;
            }
            if(count($allMasterCatalogue) > 0) {
                foreach ($allMasterCatalogue as $catalogue) {
                    $exist_catalogue = WoocommerceCatalogue::where('master_catalogue_id',$catalogue->id)->first();
                    if (!$exist_catalogue) {
                        $woocommerce__create_result = WoocommerceCatalogue::create([
                            'id' => $catalogue->id,
                            'user_id' => $catalogue->user_id,
                            'master_catalogue_id' => $catalogue->id,
                            'modifier_id' => $catalogue->modifier_id ?? null,
                            'brand_id' => $catalogue->brand_id ?? null,
                            'gender_id' => $catalogue->gender_id ?? null,
                            'name' => $catalogue->name,
                            'type' => $catalogue->type,
                            'description' => $catalogue->description,
                            'short_description' => $catalogue->short_description ?? null,
                            'regular_price' => $catalogue->regular_price,
                            'sale_price' => $catalogue->sale_price,
                            'cost_price' => $catalogue->cost_price,
                            'product_code' => $catalogue->product_code,
                            'color_code' => $catalogue->color_code,
                            'attribute' => $catalogue->attribute,
                            'low_quantity' => $catalogue->low_quantity,
                            'status'=> $catalogue->status
                        ]);

                        $dataimage = [];
                        if (count($catalogue->images) > 0) {
                            foreach ($catalogue->images as $image) {
                                $exist_image = Image::find($image->id);
//                                if (!$exist_image) {
                                    $dataimage = WoocommerceImage::create([
                                        'id' => $image->id,
                                        'woo_master_catalogue_id' => $catalogue->id ?? null,
                                        'image_url' => $image->image_url ?? null
                                    ]);
//                                }
                            }
//                            $image_insert = WoocommerceImage::insert($dataimage);
                        }
                    }
//                echo '<pre>';
//                print_r($catalogue_array);
//                exit();
                    $skip++;
                }
            }
        }
        echo '<pre>';
        print_r(json_decode($skip));
        exit();
    }

    public function woocommerceVariation(){
        $skip = 0;
        while(true) {
            $allMasterVariationList = ProductVariation::skip($skip)->take(100)->get();
            if (count($allMasterVariationList) == 0){
                break;
            }
            if (count($allMasterVariationList) > 0) {
                foreach ($allMasterVariationList as $variation) {
//                    $all_catalogue_list = Woocommerce::get('products/' . $masterCatalogue->id . '/variations/');
                    $master_variation_info = WoocommerceVariation::find($variation->id);
                    if(!$master_variation_info) {
                        $catalogue_array = WoocommerceVariation::create([
                            'id' => $variation->id,
                            'woocom_master_product_id' => $variation->product_draft_id,
                            'woocom_variation_id' => $variation->id,
                            'image' => $variation->image ?? null,
                            'attribute' => $variation->attribute,
                            'sku' => $variation->sku,
                            'actual_quantity' => $variation->actual_quantity,
                            'ean_no' => $variation->ean_no ?? null,
                            'cost_price' => $variation->cost_price ?? null,
                            'regular_price' => $variation->regular_price,
                            'sale_price' => $variation->sale_price,
                            'product_code' => $variation->product_code ?? null,
                            'color_code' => $variation->color_code ?? null,
                            'low_quantity' => $variation->low_quantity ?? null,
                            'notification_status' => $variation->notification_status,
                            'manage_stock' => $variation->manage_stock,
                            'description' => $variation->description,
                            'created_at' => $variation->created_at,
                            'updated_at' => $variation->updated_at,
                            'deleted_at' => null
                        ]);
                    }
                    $skip++;
                }
            }
        }
        echo "<pre>";
        print_r($skip);
        exit();
    }

    public function woocommerceSingleAttribute(){
        $singleAttributeTerms = Woocommerce::get('products/attributes/15/terms?per_page=100');
        foreach (json_decode(json_encode($singleAttributeTerms)) as $term){
            $insertInfo = AttributeTerm::create([
                'id' => $term->id,
                'attribute_id' => 15,
                'terms_name' => $term->name
            ]);
        }
        echo '<pre>';
        print_r($singleAttributeTerms);
        exit();
    }

    public function woocommerceChooseMigration(){
        $allAttributes = WoocommerceAttribute::with(['attributesTerms'])->get();
        $allAttributes = $allAttributes->sortByDesc(function ($product, $key) {
            return count($product['attributesTerms']);
        });
        $content = view('woocommerce.migration.attribute_migration',compact('allAttributes'));
        return view('master',compact('content'));
    }

    public function woocommerSaveAttributeMigration(Request $request){
        try{
            if(count($request->attributeIds) > 0) {
                foreach ($request->attributeIds as $attribute) {
                    $offset = 0;
                    $explodeAttribute = explode('/',$attribute);
                    while (true){
                        $data = array(
                            'per_page' => 10,
                            'offset' => $offset
                        );
                        $all_attribute_terms_list = Woocommerce::get('products/attributes/'.$explodeAttribute[0].'/terms',$data);
                        if (count($all_attribute_terms_list) == 0){
                            break;
                        }
                        if (count($all_attribute_terms_list) > 0) {
                            $exist_attribute = Attribute::find($explodeAttribute[0]);
                            if(!$exist_attribute){
                                $attribute_insert = Attribute::create([
                                    'id' => $explodeAttribute[0],
                                    'attribute_name' => $explodeAttribute[1],
                                    'use_variation' => $request->useAsVariation ?? 1
                                ]);
                            }
                            $exist_woocommerce_attribute = WoocommerceAttribute::find($explodeAttribute[0]);
                            if(!$exist_woocommerce_attribute){
                                $insertInfo = WoocommerceAttribute::create([
                                    'id' => $explodeAttribute[0],
                                    'master_attribute_id' => $exist_attribute ? $exist_attribute->id : $explodeAttribute[0],
                                    'attribute_name' => $explodeAttribute[1],
                                    'use_variation' => $request->useAsVariation ?? 1,
                                ]);
                            }
                            foreach ($all_attribute_terms_list as $attribute_term) {
                                $exist_attribute_terms = AttributeTerm::find($attribute_term['id']);
                                if (!$exist_attribute_terms) {
                                    $attribute_terms_insert = AttributeTerm::create([
                                        'id' => $attribute_term['id'],
                                        'attribute_id' => $explodeAttribute[0],
                                        'terms_name' => $attribute_term['name']
                                    ]);
                                }
                                $exist_woocommerce_attribute_terms = WoocommerceAttributeTerm::where('attribute_id',$explodeAttribute[0])->where('terms_name',$attribute_term['name'])->first();
                                if (!$exist_woocommerce_attribute_terms) {
                                    $termsInsert = WoocommerceAttributeTerm::create([
                                        'id' => $attribute_term['id'],
                                        'attribute_id' => $explodeAttribute[0],
                                        'master_terms_id' => $exist_attribute_terms ? $exist_attribute_terms->id : $attribute_term['id'],
                                        'terms_name' => $attribute_term['name'],
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ]);
                                }
                                $offset++;
                            }
                        }
                    }
                }
                return response(['type' => 'success', 'msg' => 'Attribute added successfully']);
            }else{
                return response(['type' => 'warning','msg' => 'No Attribute Found']);
            }
        }catch(\Exception $exception){
            return response(['type' => 'error','msg' => 'Something Went Wrong']);
        }
        
    }

    public function masterAttributeMigrateToWoocommerce(){
        $allAttributeTerms = Attribute::with(['attributesTerms'])->get();
        if(count($allAttributeTerms) > 0){
            foreach($allAttributeTerms as $attribute){
                $attributeExist = WoocommerceAttribute::find($attribute->id);
                if(!$attributeExist){
                    $insertInfo = WoocommerceAttribute::create([
                        'id' => $attribute->id,
                        'master_attribute_id' => $attribute->id,
                        'attribute_name' => $attribute->attribute_name,
                        'use_variation' => $attribute->use_variation,
                    ]);
                }
                $att = [];
                if(count($attribute->attributesTerms) > 0){
                    foreach($attribute->attributesTerms as $terms){
                        $termExist = WoocommerceAttributeTerm::find($terms->id);
                        if(!$termExist){
                            $termsInsert = WoocommerceAttributeTerm::create([
                                'id' => $terms->id,
                                'attribute_id' => $attribute->id,
                                'master_terms_id' => $terms->id,
                                'terms_name' => $terms->terms_name,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json($allAttributeTerms);
    }

    public function editAttributeTerm($id){
        $attributeTerm = WoocommerceAttributeTerm::find($id);
        return response()->json($attributeTerm);
    }


}
