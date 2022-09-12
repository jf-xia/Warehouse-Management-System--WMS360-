<?php

namespace App\Http\Controllers\woocommerce;

use App\Attribute;
use App\AttributeTerm;
use App\AttributeTermProductDraft;
use App\Brand;
use App\Category;
use App\Client;
use App\Gender;
use App\Image;
use App\Pagination;
use App\ProductDraft;
use App\ProductVariation;
use App\Setting;
use App\ShelfedProduct;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use App\WoocommerceAccount;
use App\WoocommerceImage;
use App\WooWmsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Session;
use Arr;
use App\ProductDraftCategory;
use App\Traits\SearchCatalogue;
use App\Traits\ActivityLogs;
use App\Traits\WoocommerceCommonFuntions;
use App\Traits\ListingLimit;
use App\Traits\CommonFunction;
use App\woocommerce\WoocommerceAttribute;
use App\woocommerce\WoocommerceItemTerm;
use App\Mapping;
use App\CatalogueAttributeTerms;
use App\ItemAttributeTermValue;
use App\woocommerce\WoocommerceAttributeTerm;
use App\Http\Controllers\Channel\ChannelFactory;
use App\Channel;

class WoocommerceCatalogueController extends Controller
{
    use SearchCatalogue;
    use ActivityLogs;
    use WoocommerceCommonFuntions;
    use ListingLimit;

    use CommonFunction;

    //get channel id by name
    protected $channel = ChannelFactory::Woocommerce;

    public function __construct()
    {
        $this->middleware('auth');
        $this->shelf_use = Session::get('shelf_use');
        if($this->shelf_use == ''){
            $this->shelf_use = Client::first()->shelf_use ?? 0;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(){
        $user_id = Auth::user()->id;
        $page_info = Pagination::where('user_id',$user_id)->first();
        return $page_info->per_page;
    }

    // public function softdeleteMultipleWooVariation(){
    //     $woo_catalogue = WoocommerceCatalogue::onlyTrashed()->get();
    //     foreach($woo_catalogue as $single_id){
    //         echo '<pre>';
    //         echo $single_id->id;
    //         $woo_variation = WoocommerceVariation::where('woocom_master_product_id', $single_id->id)->get();
    //         foreach($woo_variation as $single_variation){
    //             WoocommerceVariation::where('id',$single_variation->id)->delete();
    //         }
    //     }
    //     // exit();
    // }


    /*
     * Function : index
     * Route Type : {type}/catalogue/list
     * Method Type : GET
     * Parameters : 1 ($status_type)
     * Creator :Kazol
     * Modifier : Solaiman
     * Description : This function is used for WooCommerce Active product list and pagination setting
     * Modified Date : 28-11-2020, 1-12-2020
     * Modified Content : Pagination setting
     */

    public function index(Request $request, $status_type)
    {
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
    	 try {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('woocommerce', 'woocommerce_active_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting



//        $limit = $this->value();

        $shelfUse = $this->shelf_use;
        Session::put('shelf_use',$shelfUse);


        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
//        $limit = $setting_info->pagination ?? 50;

        $woocommerce_list = WoocommerceCatalogue::with(['variations' => function($query){
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_variation_id as variation_id','woocom_master_product_id'])->with(['order_products_without_cancel_and_return' => function($query){
                $this->orderWithoutCancelAndReturn($query,'checkout');
                //$query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('variations')->where('status',$status_type);

            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->woocommerceCatalogueSearchCondition($woocommerce_list, $request);
                $allCondition = $this->woocommerceCatalogueSearchParams($request, $allCondition);
                // dd($allCondition);
            }
        //    ->whereDate('created_at', '>', Carbon::now()->subDays(30))
        // $woocommerce_list = $woocommerce_list->orderBy('id','DESC')->paginate($pagination);
        $woocommerce_list = $woocommerce_list->orderBy('id','DESC')->paginate($pagination)->appends(request()->query());
        // $woocommerce_list = $woocommerce_list->orderBy('id','DESC')->paginate($pagination)->appends(request()->query());

        if($request->has('is_clear_filter')){
            $woocommerce_list = $woocommerce_list;
            $status = $status_type;
            $date = '12345';
            $view = view('woocommerce.search_catalogue_list',compact('woocommerce_list','shelfUse', 'status', 'date'))->render();
            return response()->json(['html' => $view]);
        }
            // ->orderBy('id','DESC')->paginate($pagination);
        $catalogue_info = json_decode(json_encode($woocommerce_list));
        $total_catalogue = WoocommerceCatalogue::where('status',$status_type)->count();
//        echo "<pre>";
//        print_r($catalogue_info);
//        exit();

        $content = view('woocommerce.catalogue_list',compact('woocommerce_list','catalogue_info','status_type','total_catalogue', 'shelfUse','setting', 'page_title', 'pagination', 'setting_info','allCondition','url'));

        return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }

    }

    public function allSearchConditionArr($value, $allCondition = null){
        if($value == 'condition'){
            $allCondition = $allCondition;
        }else{
            return $allCondition;
        }
    }

    public function optOutOperator($optVal){
        if($optVal == '>'){
            return '<';
        }
        elseif($optVal == '<'){
            return '>';
        }
        elseif($optVal == '='){
            return '!=';
        }
        elseif($optVal == '>='){
            return '<=';
        }
        elseif($optVal == '<='){
            return '>=';
        }
    }



     /*
      * Function : paginationSetting
      * Route Type : null
      * Parameters : null
      * Creator : Solaiman
      * Description : This function is used for pagination setting
      * Created Date : 1-12-2020
      */

    public function paginationSetting ($firstKey, $secondKey = NULL) {
        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
        $data['setting'] = null;
        $data['pagination'] = 50;
        if(isset($setting_info)) {
            if($setting_info->setting_attribute != null){
                $data['setting'] = \Opis\Closure\unserialize($setting_info->setting_attribute);
                if(array_key_exists($firstKey,$data['setting'])){
                    if($secondKey != null) {
                        if (array_key_exists($secondKey, $data['setting'][$firstKey])) {
                            $data['pagination'] = $data['setting'][$firstKey][$secondKey]['pagination'] ?? 50;
                        } else {
                            $data['pagination'] = 50;
                        }
                    }else{
                        $data['pagination'] = $data['setting'][$firstKey]['pagination'] ?? 50;
                    }
                }else{
                    $data['pagination'] = 50;
                }
            }else{
                $data['setting'] = null;
                $data['pagination'] = 50;
            }

        }else{
            $data['setting'] = null;
            $data['pagination'] = 50;
        }

        return $data;
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($master_catalogue_id)
    {
        $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
        $clientListingLimit = $this->ClientListingLimit();
        $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;
        // dd($listingLimitInfo,$clientListingLimit);
        // dd($listingLimitAllChannelActiveProduct);

        $categories = Category::get();
        $brands = Brand::get();
        $genders = Gender::get();
        $master_images = ProductDraft::select('id')->with('images:id,draft_product_id,image_url')->find($master_catalogue_id);
        //$attribute_info = ProductDraft::with(['woocommerce_catalogue_attribute'])->where('id',$master_catalogue_id)->first();
        $attribute_info = ProductDraft::where('id',$master_catalogue_id)->first();
        //$attribute_terms = Attribute::With(['woocommerceAttributesTerms'])->where('use_variation',1)->get();
        $attribute_terms = WoocommerceAttribute::with(['woocommerceAttributesTerms'])->where('use_variation',1)->get();
        $not_use_variation_attribute_terms = WoocommerceAttribute::With(['woocommerceAttributesTerms'])->where('use_variation',0)->get();
        $master_brand = Brand::find($attribute_info->brand_id)->name ?? null;
        $master_gender = Gender::find($attribute_info->gender_id)->name ?? null;
        $attribute_terms = json_decode(json_encode($attribute_terms));
        $not_use_variation_attribute_terms = json_decode(json_encode($not_use_variation_attribute_terms));
        $woo_attribute_info = \Opis\Closure\unserialize($attribute_info->attribute);
//        echo "<pre>";
//        print_r(json_decode($master_images));
//        exit();
        $catalogueAttributeTerms = CatalogueAttributeTerms::where('catalogue_id',$master_catalogue_id)->pluck('attribute_term_id')->toArray();
        $mappingDatas = [];
        $mapFields = [];
        if(count($catalogueAttributeTerms) > 0){
            //$channelInfo = $this->getChannelInfo($this->channel);
            $channelInfo = $this->channel;
            if($channelInfo){
                $mappingDatas = ItemAttributeTermValue::withAndWhereHas('mappingFields', function($q){
                    $q->where('mapping_field','!=',null);
                })
                ->whereIn('id',$catalogueAttributeTerms)->get();
                if(count($mappingDatas) > 0){
                    foreach($mappingDatas as $mapD){
                        $mapFields[$mapD->mappingFields->mapping_field] = $mapD->item_attribute_term_value;
                    }
                }
            }
        }
        $content = view('woocommerce.create_catalogue',compact('categories','attribute_terms','brands','genders','master_catalogue_id','attribute_info','master_images','woo_attribute_info','not_use_variation_attribute_terms','master_brand','master_gender','listingLimitAllChannelActiveProduct','clientListingLimit','mappingDatas','mapFields','listingLimitInfo'));
        return view('master',compact('content'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skuExist = WoocommerceCatalogue::where('sku',$request->sku)->first();
        if($skuExist){
            return back()->with('error','Master SKU Already Exists');
        }
        $deletedExist = WoocommerceCatalogue::withTrashed()->where('sku',$request->sku)->first();
        if($deletedExist){
            $deletedExist->sku = $deletedExist->sku.'_'.date("Ymdhis");
            $deletedExist->save();
        }
        try{

            $woo_master_catalogue_id = $request->master_catalogue_id;
            //dd($woo_master_catalogue_id);

            $listingLimitInfo = $this->ListingLimitAllChannelActiveProduct();
            $clientListingLimit = $this->ClientListingLimit();
            $listingLimitAllChannelActiveProduct = $listingLimitInfo['subTotalActiveProduct'] ?? 0;

            // $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
            // $clientListingLimit = $this->ClientListingLimit();

            //dd($listingLimitAllChannelActiveProduct,$clientListingLimit);

            if($listingLimitAllChannelActiveProduct >= $clientListingLimit){
                return redirect('woocommerce/catalogue/create/'.$woo_master_catalogue_id);
            }else{
                $category = $request->category_id;

                foreach ($category as $category){
                    $data[]['id'] = $category;
                }

                $woocommerce_dataSet = array();

                $woocommerce_dataSet['name']=$request->name;
                $woocommerce_dataSet['type'] = 'variable';
                $woocommerce_dataSet['description'] = $request->description;
                $woocommerce_dataSet['short_description'] = $request->short_description ?? null;
                $woocommerce_dataSet['status'] = 'draft';
                $woocommerce_dataSet['sku'] = $request->sku ?? '';
                $woocommerce_dataSet['meta_data'][] = [
                    'key' => 'rrp',
                    'value' => $request->rrp
                ];
                $i = 0;
                if($request->images){
                    foreach ($request->images as $image){
    //                    $dataset[]['src'] = $image;
    //                    $dataset[]['position'] = $i;
                        $dataset[] = [
                            'src' => $image,
                            'position' => $i
                        ];
                        $i++;
                    }
                    $woocommerce_dataSet['images'] = $dataset;
                }else {
                    // $woocommerce_dataSet['images'] = [
                    //     [
                    //         'src' => 'https://www.studyinindia.gov.in/img/noImageAvailable.png',
                    //         'position' => 0,
                    //     ]
                    // ];
                }
                $woocommerce_dataSet['categories'] =$data;
    //            echo '<pre>';
    //            print_r($woocommerce_dataSet);
    //            exit();

                $attribute_array= array();
                $attributes_value_array = array();
                $attributes_options_array = array();
                $not_as_variation_attribute_value_array = array();
                $not_as_variation_attribute_option_array = array();
                $all_attribute_array = array();
                $all_not_attribute_array = array();
                $attributes_terms = $request->terms;

                if ($attributes_terms != null){
                    foreach ($attributes_terms as $key => $value){

    //                    if(array_key_exists($key,$request->not_variation)){
    ////                    if(isset($request->not_variation[$key]) && ($request->not_variation[$key] == $key)){
    //                        $attributes_value_array['id'] = $key;
    //                        $attributes_value_array['variation'] = false;
    //                        $attributes_value_array['visible'] = false;
    //                    }else {
                            $attributes_value_array['id'] = $key;
                            $attributes_value_array['variation'] = true;
                            $attributes_value_array['visible'] = true;
    //                    }

                        foreach ($value as $key => $value){

                            $attributes_terms_name =  WoocommerceAttributeTerm::where('id', $value)->first()->terms_name;
                            array_push($attributes_options_array,$attributes_terms_name);
                        }
                        $attributes_value_array['options'] = $attributes_options_array;
                        array_push($attribute_array,$attributes_value_array);
                        $attributes_options_array = (array) null;

                    }
                    if($request->not_variation != null) {
                        foreach ($request->not_variation as $key => $value) {
                            $not_as_variation_attribute_value_array['id'] = $key;
                            $not_as_variation_attribute_value_array['variation'] = false;
                            $not_as_variation_attribute_value_array['visible'] = false;
                            foreach ($value as $key => $value) {

                                $attributes_terms_name_not_as_variation = WoocommerceAttributeTerm::where('id', $value)->first()->terms_name;
                                array_push($not_as_variation_attribute_option_array, $attributes_terms_name_not_as_variation);
                            }
                            $not_as_variation_attribute_value_array['options'] = $not_as_variation_attribute_option_array;
                            array_push($attribute_array, $not_as_variation_attribute_value_array);
                            $not_as_variation_attribute_option_array = (array)null;

                        }
                    }

    //                echo '<pre>';
    //                print_r($attribute_array);
    //                exit();
                    $woocommerce_dataSet['attributes'] = $attribute_array;
                    try{
                        $product = Woocommerce::post( 'products', $woocommerce_dataSet );
                    }catch (HttpClientException $exception){

                        return back()->with('error', $exception->getMessage());
                    }

                    $product = json_decode(json_encode($product));
                    $this->product_draft_id = $product->id;

                    $function = DB::transaction(function () use ($request,$product,$all_attribute_array,$all_not_attribute_array) {
                        $dataimage = [];
                        if (count($product->images) > 0) {
                            foreach ($product->images as $image) {
                                $dataimage[] = [
                                    'id' => $image->id,
                                    'image_url' => $image->src
                                ];
                            }
                        }
                        $attributes_terms = $request->terms;
                        foreach ($attributes_terms as $attribute_id => $attribute_terms_id){
                            foreach ($attribute_terms_id as $attribute_term_id){
                                $all_attribute_array[$attribute_id][Attribute::find($attribute_id)->attribute_name][] =
                                    ["attribute_term_id" => $attribute_term_id,
                                        "attribute_term_name" => WoocommerceAttributeTerm::find($attribute_term_id)->terms_name,
                                    ];
                            }
                        }
                        $not_attributes_terms = $request->not_variation;
                        if($not_attributes_terms != null) {
                            foreach ($not_attributes_terms as $attribute_id => $attribute_terms_id) {
                                foreach ($attribute_terms_id as $attribute_term_id) {
                                    $all_not_attribute_array[$attribute_id][Attribute::find($attribute_id)->attribute_name][] =
                                        ["attribute_term_id" => $attribute_term_id,
                                            "attribute_term_name" => WoocommerceAttributeTerm::find($attribute_term_id)->terms_name,
                                        ];
                                }
                            }
                        }
                        $serialize_attribute_array = \Opis\Closure\serialize($all_attribute_array);
                        $not_as_variation_serialize_attribute_array = \Opis\Closure\serialize($all_not_attribute_array);
                        $product_draft_create_result = WoocommerceCatalogue::create([
                            'id' => $this->product_draft_id,
                            'user_id' => Auth::user()->id,
                            'master_catalogue_id' => $request->master_catalogue_id,
                            'modifier_id' => Auth::user()->id,
    //                        'brand_id' => $request->brand_id,
    //                        'gender_id' => $request->gender_id,
                            'name' => $request->name,
                            'type' => 'variable',
                            'sku' => $request->sku ?? null,
                            'description' => $request->description,
                            'short_description' => $request->short_description,
    //                        'images' => json_encode($dataimage) ?? null,
                            'regular_price' => $request->regular_price,
                            'sale_price' => $request->sale_price,
                            'rrp' => $request->rrp ?? $request->regular_price ?? null,
                            'cost_price' => $request->cost_price,
                            'product_code' => $request->product_code,
                            'color_code' => $request->color_code,
                            'attribute' => $serialize_attribute_array,
                            'not_attribute' => $not_as_variation_serialize_attribute_array,
                            'low_quantity' => $request->low_quantity,
                            'status'=> 'draft'
                        ]);
    //                    dd($product_draft_create_result);
                        $product_draft_category = WoocommerceCatalogue::find($this->product_draft_id);
                        foreach ($product->categories as $categories){
                            $id = $categories->id;
                            $product_draft_category->all_category()->attach($id);
                        }
                        $dataimage = [];
                        if (count($product->images) > 0) {
                            foreach ($product->images as $image) {
                                $dataimage[] = [
                                    'id' => $image->id,
                                    'woo_master_catalogue_id' =>$this->product_draft_id,
                                    'image_url' => $image->src
                                ];
                            }
                            $image = WoocommerceImage::insert($dataimage);
                        }
                    });
                    serialize($function);

                    return redirect('woocommerce/catalogue/'.$this->product_draft_id.'/variation')
                        ->with('success','Catalogue added successfully');
                }else{
                    return back()->with('error','Please select at least one attribute terms');
                }
            }

        }catch (\Exception $e){
            return redirect('exception')->with('exception',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type,$id)
    {
        $shelf_use = $this->shelf_use;
        $attribute_info = WoocommerceCatalogue::with(['master_product' => function($query){
            $query->with(['attributeTerms' => function($query){
                $query->with('attribute:id,attribute_name');
            }]);
        }])->find($id);

        $product_draft_result = WoocommerceCatalogue::with(['variations' => function($query) {
            $query->with(['master_variation' => function($query){
                $query->with(['shelf_quantity', 'order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }]);
        },'all_image_info'])->find($id);
        $product_draft_variation_results = json_decode(json_encode($product_draft_result));
        $attribute_info = json_decode($attribute_info);
//        echo "<pre>";
//        print_r(unserialize($attribute_info->attribute));
//        exit();
        $content = view('woocommerce.product_catalogue_details',compact('product_draft_variation_results','attribute_info','shelf_use'));
        return view('master',compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($status_type,$id)
    {
        //        echo "<pre>";
//        print_r($result);
//        exit();
        $image_src = [];
        $categories = Category::get();
        $brands = Brand::get();
        $genders = Gender::get();
        $product_draft = WoocommerceCatalogue::with(['all_category','all_image_info'])->find($id);
        $not_variation_attribute = Attribute::select('id','attribute_name','use_variation')->with('woocommerceAttributesTerms:id,attribute_id,terms_name')->where('use_variation',0)->get();
        $images = json_decode($product_draft->images);
        foreach ($product_draft->all_image_info as $catalogue_image){
//            print_r($image->image_url);
//            exit();
            $image_src[] = $catalogue_image->image_url;
        }
        $image_as_string = implode(",",$image_src);
        $not_variation_attribute = json_decode($not_variation_attribute);
//        echo "<pre>";
//        print_r(unserialize(json_decode($product_draft)->not_attribute));
//        exit();
        $content = view('woocommerce.edit_catalogue',compact('product_draft','categories','image_as_string','brands','genders','status_type','not_variation_attribute'));
        return view('master', compact('content'));
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
//        echo '<pre>';
//        print_r($request->all());
//        exit();
        try{
            $productDraft = WoocommerceCatalogue::find($id);
            foreach ($request->category_id as $category){
                $ids[]['id'] = $category;
            }
            if($request->update_img_check == 1) {
                if ($request->sortable_image && $request->images != null) {
                    $image_array = explode(',', $request->sortable_image);
                        foreach ($request->images as $image) {
                                $name = str_replace(' ', '-',$image->getClientOriginalName());
                                $image->move('uploads/product-images/', $name);
//                    $dataset[]['src'] = asset('uploads/product-images/'.$name);
                                $image = asset('uploads/product-images/' . $name);
                                array_push($image_array,$image);
                        }

                }elseif($request->sortable_image){
                    $files = explode(',', $request->sortable_image);
                    foreach ($files as $file) {
                        $image_array[] = $file;
                    }
                }
                else{
                    foreach ($request->images as $image) {
                        $name = str_replace(' ', '-',$image->getClientOriginalName());
                        $image->move('uploads/product-images/', $name);
                        $image_array[] = asset('uploads/product-images/' . $name);

                    }
                }
                foreach ($image_array as $image) {
                    if($image != '') {
                        $dataset[]['src'] = $image;
//                    $dataimage[] = [
//                        'id' => $id,
//                        'image_url' => $image
//                    ];
                    }

                }
                $data = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'sku' => $request->sku ?? '',
                    'short_description' => isset($request->short_description) ? $request->short_description : null,
                    'categories' => $ids,
                    'images' => $dataset
                ];

            }else{
                $data = [
                    'name' => $request->name,
                    'description' => $request->description,
                    'sku' => $request->sku ?? '',
                    'short_description' => isset($request->short_description) ? $request->short_description : null,
                    'categories' => $ids
                ];
            }

            $data['meta_data'][] = [
                'key' => 'rrp',
                'value' => $request->rrp
            ];

            $attribute_array= array();
            $attributes_value_array = array();
            $attributes_options_array = array();
            $not_as_variation_attribute_value_array = array();
            $not_as_variation_attribute_option_array = array();
            $all_attribute_array = array();
            $all_not_attribute_array = array();

            if($request->not_variation != null) {
                foreach ($request->not_variation as $key => $value) {
                    if($value[0] != null) {
                        $not_as_variation_attribute_value_array['id'] = $key;
                        $not_as_variation_attribute_value_array['variation'] = false;
                        $not_as_variation_attribute_value_array['visible'] = false;
                        foreach ($value as $ke => $val) {
                            $attributes_terms_name_not_as_variation = AttributeTerm::where('id', $val)->first()->terms_name;
                            array_push($not_as_variation_attribute_option_array, $attributes_terms_name_not_as_variation);
                        }
                        $not_as_variation_attribute_value_array['options'] = $not_as_variation_attribute_option_array;
                        array_push($attribute_array, $not_as_variation_attribute_value_array);
                        $not_as_variation_attribute_option_array = (array)null;
                    }

                }
            }

            $woo_attribute_info = WoocommerceCatalogue::find($id)->attribute;
            $unserialized_data = unserialize($woo_attribute_info);
            if(is_array($unserialized_data) == TRUE) {
                foreach ($unserialized_data as $key => $value){
                    $attributes_value_array['id'] = $key;
                    $attributes_value_array['variation'] = true;
                    $attributes_value_array['visible'] = true;
                    foreach ($value as $key => $value){
                        foreach($value as $val){
                            $attributes_terms_name =  WoocommerceAttributeTerm::where('id', $val['attribute_term_id'])->first()->terms_name;
                            array_push($attributes_options_array,$attributes_terms_name);
                        }
                    }
                    $attributes_value_array['options'] = $attributes_options_array;
                    array_push($attribute_array,$attributes_value_array);
                    $attributes_options_array = (array) null;
                }
            }
            $not_attributes_terms = $request->not_variation;
            if($not_attributes_terms != null) {
                foreach ($not_attributes_terms as $attribute_id => $attribute_terms_id) {
                    foreach ($attribute_terms_id as $attribute_term_id) {
                        if ($attribute_term_id != null) {
                            $all_not_attribute_array[$attribute_id][Attribute::find($attribute_id)->attribute_name][] =
                                ["attribute_term_id" => $attribute_term_id,
                                    "attribute_term_name" => AttributeTerm::find($attribute_term_id)->terms_name,
                                ];
                        }
                    }
                }
            }
            $data['attributes'] = $attribute_array;
            $not_as_variation_serialize_attribute_array = \Opis\Closure\serialize($all_not_attribute_array);
            try{
                $woocom_product_result = Woocommerce::put('products/'.$id, $data);
            }catch (HttpClientException $exception){
                echo $exception->getMessage();
                return back()->with('error', $exception->getMessage());
            }
            $woocom_product_result = json_decode(json_encode($woocom_product_result));
            if ($woocom_product_result !=null) {
//                $request['modifier_id'] = Auth::user()->id;
//                $input = $request->all();
//                $product_result = $productDraft->fill($input)->save();
                $update_catalogue = WoocommerceCatalogue::where('id',$id)->update([
                    'modifier_id' => Auth::id(),
                    'brand_id' => $request->brand_id ?? null,
                    'gender_id' => $request->gender_id ?? null,
                    'name' => $request->name ?? null,
                    'sku' => $request->sku ?? null,
                    'not_attribute' => $not_as_variation_serialize_attribute_array,
                    'description' => $request->description ?? null,
                    'short_description' => $request->short_description ?? null,
                    'regular_price' => $request->regular_price ?? null,
                    'sale_price' => $request->sale_price ?? null,
                    'rrp' => $request->rrp ?? $request->regular_price ?? null,
                    'cost_price' => $request->cost_price ?? null,
                    'product_code' => $request->product_code ?? null,
                    'color_code' => $request->color_code ?? null,
                    'low_quantity' => $request->low_quantity ?? null
                ]);

                $product_draft_category = WoocommerceCatalogue::find($id);
                $product_draft_category->all_category()->sync($request->category_id);
                if ($request->update_img_check == 1) {
                    $dataimage = [];
//                    if (count($woocom_product_result->images) > 0) {
                        foreach ($woocom_product_result->images as $image) {
                            $dataimage[] = [
                                'id' => $image->id,
                                'woo_master_catalogue_id' =>$id,
                                'image_url' => $image->src
                            ];
                        }
//                    }
                    WoocommerceImage::where('woo_master_catalogue_id', $id)->delete();
                    $image = WoocommerceImage::insert($dataimage);
                }
            }
            return back()->with('success', 'Updated Successfully');

        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Woocommerce::delete('products/'.$id);
//            $delete_result = ProductDraft::destroy($id);
            $catalogue_delete = WoocommerceCatalogue::find($id);
            DB::transaction(function () use ($catalogue_delete) {
                $catalogue_delete->delete();
//                foreach ($catalogue_delete->variations as $variation){
//                    $del = ShelfedProduct::where('variation_id',$variation->id)->delete();
//                }
                // $catalogue_delete->variations()->delete();
                $woocommerceDeleteInfo = WoocommerceVariation::where('woocom_master_product_id',$catalogue_delete->id)->delete();
            });
            return back()->with('success', 'Catalogue deleted successfully');
        }catch (HttpClientException $exception){
            return back()->with('success', $exception);
        }
    }

    public function SsearchCatalogueList(Request $request){
        if($request->status == 'draft' || $request->status == 'publish'){
            $data_arr = [];
            array_push($data_arr,$request->status);
        }else{
            $data_arr = $request->status;
        }
        $field = ['woocom_master_products.name','woocom_master_products.id','woocom_master_products.master_catalogue_id','woocom_variation_products.id','woocom_variation_products.sku','woocom_variation_products.ean_no'];
        $catalogue_ids = WoocommerceCatalogue::select('woocom_master_products.id')
            ->leftJoin('woocom_variation_products','woocom_master_products.id','=','woocom_variation_products.woocom_master_product_id')
            ->where([['woocom_master_products.deleted_at','=',null],['woocom_variation_products.deleted_at','=',null]])
            ->whereIn('woocom_master_products.status',$data_arr)
            ->where(function ($query) use ($field,$request){
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere($field[$i], 'like', '%' . $request->name . '%');
                }
            })
            ->orderByDesc('woocom_master_products.id')
            ->groupBy('woocom_master_products.id')
            ->take(50)
            ->get();
        $catalogur_arr_ids = [];
        if(count($catalogue_ids) > 0) {
            foreach ($catalogue_ids as $id) {
                $catalogur_arr_ids[] = $id->id;
            }
            $implode_id = implode(',',$catalogur_arr_ids);
            $woocommerce_list = WoocommerceCatalogue::with(['woocommVariation' => function($query){
                $query->with(['master_variation' => function($query){
                    $query->with(['shelf_quantity', 'order_products' => function ($query) {
                        $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                    }]);
                }]);
            }])
                ->withCount('variations')
//            ->whereIn('status', $data_arr)->where(function($q) use($request){
//                $q->where('name','LIKE','%'. $request->name.'%')->orWhere('id','LIKE','%'.$request->name.'%');
//            })
                ->where('id', $catalogur_arr_ids)
                ->orderByRaw("FIELD(id, $implode_id)")
                ->get();
            $date = '12345';
            $status_type = $request->status;
            echo view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status_type', 'date'));
        }else{
            return response()->json(['data' => 'error']);
        }
    }

    public function searchCatalogueList(Request $request){

        $search_keyword =  $request->name;
        $search_woocom_result = null;
        $date = '12345';
        $status = $request->status;
        $search_priority = $request->search_priority;
        $take = $request->take;
        $skip = $request->skip;
        $ids = $request->ids;

        $matched_product_array = array();
//        if($request->status == 'draft' || $request->status == 'publish'){
//            $data_arr = [];
//            array_push($data_arr,$request->status);
//        }else{
//            $data_arr = $request->status;
//        }

        if (is_numeric($search_keyword)) {
            if (strlen($search_keyword) == 13) {
                $find_variation = ProductVariation::where('ean_no', '=', $search_keyword)->get()->first();
                if ($find_variation != null) {
                    array_push($matched_product_array, $find_variation->product_draft_id);
                    $search_woocom_result = $this->getWoocomMasterProduct('id', $matched_product_array, $status, $take, $skip, $ids);
                    $woocommerce_list = $search_woocom_result['search'];
                    $ids = $search_woocom_result['ids'];
                    return response()->json(['html' => view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
                }else{
                    $search_woocom_result = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                    $woocommerce_list = $search_woocom_result['search'];
                    $ids = $search_woocom_result['ids'];

                    if ($woocommerce_list->isEmpty()){
                        $skip = 0;
                        $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                        $woocommerce_list = $search_woocom_result['search'];
                        $ids = $search_woocom_result['ids'];
                    }
                    return response()->json(['html' => view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
                }
            }else{
                $search_woocom_result = $this->searchAsId($search_keyword,$status,$take,$skip,$ids);
                $woocommerce_list = $search_woocom_result['search'];
                $ids = $search_woocom_result['ids'];
                if($woocommerce_list->isEmpty()){
                    $skip = 0;
                    $search_woocom_result = $this->searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids);
                    $woocommerce_list = $search_woocom_result['search'];
                    $ids = $search_woocom_result['ids'];
                    $search_priority = $search_woocom_result["search_priority"];
                    if ($woocommerce_list->isEmpty()){
                        $skip = 0;
                        $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                        $woocommerce_list = $search_woocom_result['search'];
                        $ids = $search_woocom_result['ids'];
                    }
                }
                return response()->json(['html' => view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
            }
        }else {
            if (strpos($search_keyword, " ") != null) {

                $search_woocom_result = $this->searchByWord($search_keyword, $status, $search_priority, $take, $skip,$ids);
                $woocommerce_list = $search_woocom_result['search'];
                $search_priority = $search_woocom_result["search_priority"];
                $ids = $search_woocom_result["ids"];
                return response()->json(['html' => view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);

            }
            else{
                $search_woocom_result = $this->searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids);
                $woocommerce_list = $search_woocom_result['search'];
                $ids = $search_woocom_result['ids'];
                if ($woocommerce_list == null){
                    $skip = 0;
                    $search_woocom_result = $this->searchByWord($search_keyword, $status, $search_priority, $take, $skip,$ids);
                    $woocommerce_list = $search_woocom_result['search'];
                    $search_priority = $search_woocom_result["search_priority"];
                    $ids = $search_woocom_result["ids"];
                }

                return response()->json(['html' => view('woocommerce.search_catalogue_list', compact('woocommerce_list', 'status', 'date'))->render(), 'search_priority' => $search_priority, 'skip' => $skip, 'ids' => $ids]);
            }
        }

    }

    public function searchAsId($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $find_variation = WoocommerceVariation::where('id','=',$search_keyword)->get()->first();
        $find_draft = WoocommerceCatalogue::where('master_catalogue_id','=',$search_keyword)->get()->first();
        $search_draft_result = null;
        $matched_product_array = array();
        if ($find_variation != null && $find_draft !=null){
            array_push($matched_product_array,$find_variation->product_draft_id);
            array_push($matched_product_array,$find_draft->id);
            //return $matched_product_array;
            $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];

        }
        if ($find_variation != null){
            array_push($matched_product_array,$find_variation->product_draft_id);
            $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }if ($find_draft != null){
            array_push($matched_product_array,$find_draft->id);
            $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }

        return ['search'=>$search_result,'ids' => $search_draft_result['ids']];
    }

    public function searchAsSku($search_keyword,$status,$search_priority,$take,$skip,$ids){
        $matched_product_array = array();
        $search_result = null;
        $find_sku  =  WoocommerceVariation::where('sku','=',$search_keyword)->get()->first();
        if ($find_sku != null){
            array_push($matched_product_array,$find_sku->woocom_master_product_id);
            $search_draft_result = $this->getWoocomMasterProduct('id',$matched_product_array,$status,$take,$skip,$ids);
            $search_result = $search_draft_result['search'];
            $ids = $search_draft_result['ids'];
        }

        return ['search'=>$search_result,'ids' => $ids];
    }

    public function searchByWord($search_keyword,$status,$search_priority,$take,$skip,$ids){

        $search_result = null;

        if ($search_priority == 0){

            $search_result_by_word = $this->firstPSearch($search_keyword,$status,$take,$skip,$ids);

            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){

                $skip = 0;
                $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                if ($search_result->isEmpty()){
                    $skip = 0;
                    $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
                    $search_result = $search_result_by_word["search"];
                    if($search_result->isEmpty()){
                        return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 3];
                    }else{
                        return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
                    }

                }else{
                    ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
                }
                return ["search" => $search_result,"ids"=>$search_result_by_word['ids'],"search_priority" => 2];
            }else{
                return ["search" => $search_result_by_word["search"],"ids"=>$search_result_by_word['ids'],"search_priority" => 0];
            }

        }
        if ($search_priority == 1){

            $search_result_by_word = $this->secondPSearch($search_keyword,$status,$take,$skip,$ids);
            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){
                $skip = 0;
                $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
                $search_result = $search_result_by_word["search"];
                if ($search_result->isEmpty()){
                    return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
                }else{
                    return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
                }

            }else{
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 1];
            }

        }if ($search_priority == 2){
            $search_result_by_word = $this->thirdPSearch($search_keyword,$status,$take,$skip,$ids);
            $search_result = $search_result_by_word["search"];
            if ($search_result->isEmpty()){
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 3];
            }else{
                return ["search" => $search_result_by_word["search"],'ids'=>$search_result_by_word['ids'],"search_priority" => 2];
            }

        }

    }

    public function firstPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $search_result = WoocommerceCatalogue::where('name','REGEXP',"[[:<:]]{$search_keyword}[[:>:]]")->whereNotIn('id', $ids)->with(['variations' => function ($query) {
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('variations')
            ->where('status',$status)
            ->orderBy('id','DESC')
            ->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function secondPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = WoocommerceCatalogue::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->where('name','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)->with(['variations' => function ($query) {
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('variations')
            ->where('status',$status)
            ->orderBy('id','DESC')
            ->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function thirdPSearch($search_keyword,$status,$take,$skip,$ids){
        $search_result = null;
        $findstring = explode(' ', $search_keyword);
        $search_result = WoocommerceCatalogue::where(function ($q) use ($findstring) {
            foreach ($findstring as $value) {
                $q->orWhere('name','REGEXP',"[[:<:]]{$value}[[:>:]]");
            }
        })->whereNotIn('id', $ids)->with(['variations' => function ($query) {
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('variations')
            ->where('status',$status)
            ->orderBy('id','DESC')
            ->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function getWoocomMasterProduct($column_name,$word,$status,$take,$skip,$ids){
        $search_result = WoocommerceCatalogue::whereIn($column_name,$word)->whereNotIn('id', $ids)->with(['variations' => function ($query) {
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_variation_id as variation_id','woocom_master_product_id'])->with(['order_products_without_cancel_and_return' => function($query){
                $this->orderWithoutCancelAndReturn($query,'checkout');
                //$query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('variations')
            ->where('status',$status)
            ->orderBy('id','DESC')
            ->skip($skip)->take(10)->get();

        $ids = $search_result->pluck('id');

        return ['search' => $search_result,'ids' => $ids];
    }

    public function getVariation(Request $request){

        $status = $request->status;
        $shelfUse = $this->shelf_use;
        $id = $request->woocom_master_product_id;
        if ($status == 'draft' || $status == 'publish'){
            $list = WoocommerceCatalogue::where('id', $request->woocom_master_product_id)->with(['woocommVariation' => function($query){
                $query->with(['master_variation' => function($query){
                    $query->with(['shelf_quantity', 'order_products' => function ($query) {
                        $this->orderWithoutCancelAndReturn($query,'checkout');
                        //$query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                    }]);
                }]);
            }])->where('status',$status)
                ->get()->first();
            return view('woocommerce.variation_ajax',compact('list','shelfUse','status'));
        }elseif ($status == 'woocom_pending'){
            $product_draft = ProductVariation::where('product_draft_id',$id)->get();
            return view('woocommerce.variation_ajax',compact('product_draft','shelfUse','status','id'));
        }



    }

    public function duplicateCatalogue($id){
        $categories = Category::get();
        $brands = Brand::get();
        $genders = Gender::get();
        $product_draft = WoocommerceCatalogue::with(['all_category'])->find($id);
        $attribute_info = ProductDraft::with(['woocommerce_catalogue_attribute'])->where('id',$product_draft->master_catalogue_id)->first();
        $attribute_terms = Attribute::With(['woocommerceAttributesTerms'])->get();
        $attribute_terms = json_decode(json_encode($attribute_terms));
//        echo "<pre>";
//        print_r($attribute_terms);
//        exit();
        $content = view('woocommerce.duplicate_catalogue',compact('categories','attribute_terms','product_draft','attribute_info','brands','genders'));
        return view('master', compact('content'));
    }

    public function publishCatalogue($id){
        try{
            $data = [
                'status' => 'publish'
            ];
            try{
                $result = Woocommerce::put('products/'.$id, $data);
            }catch (HttpClientException $exception){
                return back()->with('error', $exception->getMessage());
            }
            if ($result != null){
                WoocommerceCatalogue::find($id)->update(['status'=> 'publish']);
                return back()->with('success','Product Published');
            }
        }catch (Exception $exception){
            return back()->with('error',$exception->getMessage());
        }

    }

    public function uploadCSV(Request $request){

        $file = $request->file('csv_file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if(in_array(strtolower($extension),$valid_extension)) {

            // Check file size
            if ($fileSize <= $maxFileSize) {

                // File upload location
                $location = 'csv';

                // Upload file
                $file->move($location, $filename);

                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    // Skip first row (Remove below comment if you want to skip the first row)
                    if($i == 0){
                        $i++;
                        continue;
                    }
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata [$c];
                    }
                    $i++;
                }
                fclose($file);
//                dd($importData_arr);

                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    $insertData = WoocommerceCatalogue::updateOrCreate([
                        'id' => $importData[0]
                    ],[
                        'id' => $importData[0],
                        'user_id' => $importData[1],
                        'master_catalogue_id' => $importData[2],
                        'modifier_id' => $importData[3],
                        'brand_id' => $importData[4],
                        'gender_id' => $importData[5],
                        'name' => $importData[6],
                        'type' => $importData[7],
                        'description' => $importData[8],
                        'short_description' => $importData[9],
                        'images' => $importData[10],
                        'regular_price' => $importData[11],
                        'sale_price' => $importData[12],
                        'cost_price' => $importData[13],
                        'product_code' => $importData[14],
                        'color_code' => $importData[15],
                        'low_quantity' => $importData[16],
                        'status'=> $importData[17],
                        'created_at' => $importData[18],
                        'updated_at' => $importData[19],
                        'deleted_at' => $importData[20]
                    ]);
                }
            }
        }
        return back()->with('success','CSV file uploaded successfully');
    }

    public function woocommeerceSearchCatalogueByDate(Request $request){

        if($request->status == 'draft' || $request->status == 'publish'){
            $data_arr = [];
            array_push($data_arr,$request->status);
        }else{
            $data_arr = $request->status;
        }
        $operator = ($request->search_date == 'outofstock') ? '=' : '>';

        $woocommerce_list = WoocommerceCatalogue::with(['variations' => function($query) use ($request, $operator){
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->when(is_numeric($request->search_date) == FALSE,function($q)use ($operator){
                    $q->havingRaw('SUM(woocom_variation_products.actual_quantity)'.$operator.'0');
                })
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info','modifier_info','sold_variations' => function($query){
            $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        },'woocommVariation' => function($query){
            $query->with(['master_variation' => function($query){
                $query->with(['shelf_quantity', 'order_products' => function ($query) {
                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                }]);
            }]);
        }])
            ->withCount('variations')
//            ->whereIn('status',$data_arr)
            ->when(is_numeric($request->search_date) == TRUE,function($q) use ($request){
                $q->whereDate('created_at', '>', Carbon::now()->subDays($request->search_date));
            })
//            ->whereDate('created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')->paginate(500);

//        $search_result = json_decode($search_result);
        $status_type = $request->status;
        $date = $request->search_date;
        $content = view('woocommerce.search_catalogue_list',compact('woocommerce_list', 'status_type', 'date'))->render();
        return response()->json(['data' => $content, 'total_row' => count($woocommerce_list)]);
    }


        /*
       * Function : pendingCatalogueList
       * Route Type : pending/catalogue/lists
       * Method Type : GET
       * Parameters : null
       * Creator :Kazol
       * Modifier : Solaiman
       * Description : This function is used for WooCommerce pending product list and pagination setting
       * Modified Date : 28-11-2020, 1-12-2020
       * Modified Content : Pagination setting
       */

    public function pendingCatalogueList(Request $request)
    {

        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
    	 try {

        //Start page title and pagination setting
        $shelf_use = $this->shelf_use;
        $settingData = $this->paginationSetting('woocommerce', 'woocommerce_pending_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

        $product_drafts = ProductDraft::whereDoesntHave('woocommerce_catalogue_info', function($woocom){
            $woocom->whereRaw('id != woocom_master_products.master_catalogue_id');
        })
        ->whereHas('ProductVariations', function($query){
            $query->havingRaw('sum(actual_quantity) > 0');
        })->with(['ProductVariations' => function($query){
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
            $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')
            ->where('status','publish');
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->masterCatalogueSearchCondition($product_drafts, $request);
                $allCondition = $this->masterCatalogueSearchParams($request, $allCondition);
                // dd($allCondition);
            }
            // $product_drafts = $product_drafts->orderBy('id','DESC')->paginate($pagination);
            $product_drafts = $product_drafts->orderBy('id','DESC')->paginate($pagination)->appends(request()->query());
            // ->orderBy('id','DESC')->paginate($pagination);

            if($request->has('is_clear_filter')){
                $search_result = $product_drafts;
                $status = 'woocom_pending';
                $date = '12345';
                $view = view('product_draft.search_product_list',compact('search_result', 'status', 'shelf_use', 'date'))->render();
                return response()->json(['html' => $view]);
            }

        $users = User::orderBy('name', 'ASC')->get();
        $product_drafts_info = json_decode(json_encode($product_drafts));

//        echo "<pre>";
//        print_r(json_decode(json_encode($product_drafts)));
//        exit();

        $content = view('woocommerce.pending_catalogue_list',compact('product_drafts','product_drafts_info','setting','users', 'pagination', 'page_title','shelf_use','allCondition','url'));
        return view('master',compact('content'));
    }catch (\Exception $exception){
        return redirect('exception')->with('exception',$exception->getMessage());
    }
    }



    /*
     * Function : accountCredentials
     * Route : woocommerce/account-credentials
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for display the woocommerce API key in the frontend
     * Created Date: 12-11-2020
     * Modified Date :
     */
    public function accountCredentials(){
        $account_details = WoocommerceAccount::with(['creatorInfo:id,name','modifierInfo:id,name'])->get();
        $content = view('woocommerce.account_credentials',compact('account_details'));
        return view('master',compact('content'));
    }
    /*
     * Function : woocommerceCreateAccount
     * Route : woocommerce/create-account
     * Creator : Kazol
     * Modifier :
     * Description : This function is used for store woocommerce API key in the database
     * Created Date: 12-11-2020
     * Modified Date :
     */
    public function woocommerceCreateAccount(Request $request){
        $existCheck = WoocommerceAccount::where('consumer_key',$request->consumer_key)->orWhere('secret_key',$request->secret_key)
        ->orWhere('account_name',$request->account_name)->first();
        if($existCheck){
            return response()->json(['type' => 'error','msg' => 'Credentials Already Exists']);
        }
        $valildation = $request->validate([
            'consumer_key' => 'required|unique:woocommerce_accounts|max:255',
            'secret_key' => 'required|unique:woocommerce_accounts|max:255',
        ]);
        try {
            $insert = WoocommerceAccount::create([
                'consumer_key' => $request->consumer_key,
                'secret_key' => $request->secret_key,
                'site_url' => $request->site_url ?? null,
                'account_name' => $request->account_name ?? null,
                'status' => $request->status ?? null,
                'creator' => Auth::id()
            ]);
            $channelUpdateStatus = Channel::where('channel_term_slug','woocommerce')->update(['is_active' => 1]);
            if(isset($request->request_type)){
                return response()->json(['type' => 'success','msg' => 'Account Added Successfully']);
            }
            return back()->with('success','Account credential created successfully');
        }catch (\Exception $exception){
            if(isset($request->request_type)){
                return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
            }
            return back()->with('error',$exception->getMessage());
        }

    }
    /*
    * Function : updateAccount
    * Route : woocommerce/update-account/{id}
    * Creator : Kazol
    * Modifier :
    * Description : This function is used for update woocommerce API key in the database
    * Created Date: 12-11-2020
    * Modified Date :
    */
    public function updateAccount(Request $request, $id){
        try {
            $valildation = $request->validate([
                'consumer_key' => 'required|unique:woocommerce_accounts,consumer_key,'.$id.'|max:255',
                'secret_key' => 'required|unique:woocommerce_accounts,secret_key,'.$id.'|max:255'
            ]);
            $update_info = WoocommerceAccount::find($id)->update([
                'consumer_key' => $request->consumer_key,
                'secret_key' => $request->secret_key,
                'site_url' => $request->site_url ?? null,
                'status' => $request->status,
                'modifier' => Auth::id()
            ]);
            return back()->with('success','Account credentials update successfully');
        }catch (\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }

    }

    public function bulkDraftCatalogueComplete(Request $request){
        try {
            $catalogueIds = $request->catalogueIDs;
            $single_woo_arr = [];
            foreach ($catalogueIds as $id){
                $woo_var_ids = [
                    'id' => $id,
                    'status' => 'publish'
                ];
                array_push($single_woo_arr,$woo_var_ids);
            }
            $data['update'] = $single_woo_arr;
            try {
                $product_variation_result = Woocommerce::post('products/batch', $data);
                $updateInfo = WoocommerceCatalogue::whereIn('id',$catalogueIds)->update(['status' => 'publish']);
            }catch (\Exception $exception){
                return response()->json(['data' => 'error','msg' => $exception->getMessage()]);
            }
            return response()->json(['data' => 'success']);
        }catch (\Exception $exception){
            return response()->json(['data' => 'error','msg' => $exception->getMessage()]);
        }
    }


    /*
    * Function : WooCommerceColumnSearch;
    * Route Name : {route_name}/woocommerce/catalogue/search
    * Creator : Solaiman
    * Modifier :
    * Description : This function is used for WooCommerce active product datatable individual column search
    * Created Date: 26-01-2021
    * Modified Date :
   */

    public function WooCommerceActiveDraftProductColumnSearch(Request $request, $status_type){

//        dd($status_type);

        // Screen option and Pagination
        $settingData = $this->paginationSetting('woocommerce', 'woocommerce_active_product');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];

        $shelfUse = $this->shelf_use;
        Session::put('shelf_use',$shelfUse);

        $column = $request->column_name;
        $value = $request->search_value;
        $status_type = $request->status;

        $woocommerce_list = WoocommerceCatalogue::with(['variations' => function($query){
            $query->select('woocom_master_product_id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                ->groupBy('woocom_master_product_id');
        },'all_category','user_info:id,name','modifier_info:id,name','single_image_info','sold_variations' => function($query){
            $query->select(['id','woocom_master_product_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])->withCount('variations')
            ->where('status', $request->status)
            ->orderBy('id','DESC')
            ->where(function($query) use ($request,$column,$value,$status_type){
                if($column == 'master_catalogue_id'){
                    if($request->opt_out == 1){
                        $query->where($column,'!=',$value);
                    }else{
                        $query->where($column,$value);
                    }
                }
                elseif ($column == 'rrp'){
                    $aggregate_value = $request->aggregate_condition;
                    if ($request->opt_out == 1){
                        $query->where($column, '!=', $value);
                    }else{
                        $query->where($column, $aggregate_value, $value);
                    }
                }
                elseif ($column == 'sold'){
                    $aggregate_value = $request->aggregate_condition;
                    $sold_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('sum(product_orders.quantity) sold'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id')
                        ->join('product_variation', 'woocom_variation_products.woocom_variation_id', '=', 'product_variation.id')
                        ->join('product_orders', 'product_variation.id', '=', 'product_orders.variation_id')
                        ->where([['woocom_master_products.deleted_at', null], ['woocom_variation_products.deleted_at', null], ['product_variation.deleted_at', null],['product_orders.deleted_at', null]])
                        ->havingRaw('sum(product_orders.quantity)' .$aggregate_value.$value)
                        ->groupBy('woocom_master_products.id')
                        ->get();

                    $ids = [];
                    foreach ($sold_query as $sold){
                        $ids[] = $sold->id;
                    }

                    if($request->opt_out == 1){
                         $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
                }
                elseif ($column == 'stock'){
                    $aggregate_value = $request->aggregate_condition;
                    $stock_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('sum(woocom_variation_products.actual_quantity) stock'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id')
                        ->where([['woocom_master_products.deleted_at', null], ['woocom_variation_products.deleted_at', null]])
                        ->havingRaw('sum(woocom_variation_products.actual_quantity)' .$aggregate_value.$value)
                        ->groupBy('woocom_master_products.id')
                        ->get();

                    $ids = [];
                    foreach ($stock_query as $stock){
                        $ids[] = $stock->id;
                    }

                    if($request->opt_out == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }

                }
                elseif ($column == 'product'){
                    $aggregate_value = $request->aggregate_condition;
                    $product_query = WoocommerceCatalogue::select('woocom_master_products.id', DB::raw('count(woocom_variation_products.id) product'))
                        ->leftJoin('woocom_variation_products', 'woocom_master_products.id', '=', 'woocom_variation_products.woocom_master_product_id')
                        ->havingRaw('count(woocom_variation_products.id)' .$aggregate_value.$value)
                        ->groupBy('woocom_master_products.id')
                        ->get();

                    $ids = [];
                    foreach ($product_query as $product){
                        $ids[] = $product->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id', $ids);
                    }else{
                        $query->whereIn('id', $ids);
                    }
                }
                elseif ($column == 'user_id') {
                    if($request->opt_out == 1){
                        $query->where($column, '!=', $value);
                    }else{
                        $query->where($column, $value);
                    }
                }
                elseif ($column == 'modifier_id'){
                    if($request->opt_out == 1){
                        $query->where($column, '!=', $value);
                    }else{
                        $query->where($column, $value);
                    }
                }
                else {
                    if($request->opt_out == 1){
                        $query->where($column,'NOT LIKE', '%' . $value . '%');
                    }else{
                        $query->where($column, 'like', '%' . $value . '%');
                    }
                }

                // If user submit with empty data then this message will display table's upstairs
                if($value == ''){
                    return back()->with('empty_data_submit', 'Your input field is empty!! Please submit valuable data!!');
                }

            })
            ->paginate(500);


        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $ids = [];
        if(count($woocommerce_list) > 0){
            foreach ($woocommerce_list as $result){
                array_push($ids,$result);
            }
        }else{
            if($request->status == 'publish'){
                return redirect('woocommerce/publish/catalogue/list')->with('no_data_found','No data found');
            }elseif($request->status == 'draft'){
                return redirect('woocommerce/draft/catalogue/list')->with('no_data_found','No data found');
            }
        }


        $catalogue_info = json_decode(json_encode($woocommerce_list));
        $total_catalogue = WoocommerceCatalogue::where('status',$status_type)->count();
//        echo "<pre>";
//        print_r($catalogue_info);
//        exit();
        return view('woocommerce.catalogue_list',compact('woocommerce_list','catalogue_info','status_type','total_catalogue', 'shelfUse','setting', 'page_title', 'pagination'));
    }


    /*
     * Function : wooCommercePendingColumnSearch
     * Route Type : {route_name}/pending/catalogue/search
     * Method Type : Post
     * Parameters : null
     * Creator : Solaiman
     * Creating Date : 02/08/2021
     * Description : This function is used for WooCommerce pending product individual column search
     * Modifier Date:
     * Modified Content :
     */


    public function wooCommercePendingColumnSearch(Request $request){


        // Screen option and Pagination
        $shelf_use = $this->shelf_use;
        $settingData = $this->paginationSetting('woocommerce', 'woocommerce_pending_product');
        $setting = $settingData['setting'];
        $pagination = $settingData['pagination'];

        $column = $request->column_name;
        $value = $request->search_value;

        $distinct_woo_master_catalogue_id = WoocommerceCatalogue::distinct()->get(['master_catalogue_id']);
        $ids_arr = [];
        if (count($distinct_woo_master_catalogue_id) > 0){
            foreach ($distinct_woo_master_catalogue_id as $catalogue_id){
                $ids_arr[] = $catalogue_id->master_catalogue_id;
            }
        }

        $product_drafts = ProductDraft::with(['ProductVariations' => function($query){
            $query->select('product_draft_id', DB::raw('sum(product_variation.actual_quantity) stock'))
                ->groupBy('product_draft_id');
        },'all_category','WooWmsCategory:id,category_name','woocommerce_catalogue_info:id,master_catalogue_id','user_info','modifier_info','single_image_info','onbuy_product_info:id,opc,woo_catalogue_id','variations' => function($query){
            $query->select(['id','product_draft_id'])->with(['order_products' => function($query){
                $query->select('variation_id',DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
            ->withCount('ProductVariations')
            ->where('status','publish')
            ->where(function ($result) use($ids_arr) {
                $result->whereNotIn('id',$ids_arr);
            })
            ->orderBy('id','DESC')
            ->where(function($query) use($request,$column,$value){
                if($column == 'id'){
                    if($request->opt_out == 1){
                        $query->where($column,'!=',$value);
                    }else{
                        $query->where($column, $value);
                    }
                }elseif($column == 'name'){
                    if($request->opt_out == 1){
                        $query->where($column,'NOT LIKE', '%' . $value . '%');
                    }else{
                        $query->where($column,'like', '%' . $value. '%');
                    }
                }
                elseif($column == 'woowms_category'){
                    $category_info = WooWmsCategory::where('category_name',$value)->first();
                    $value = $category_info->id;
                    if($request->opt_out == 1){
                        $query->where($column,'!=',$value);
                    }else{
                        $query->where($column,'like', '%' . $value. '%');
                    }
                }elseif ($column == 'rrp' || $column == 'base_price'){
                    $aggregate_value = $request->aggregate_condition;
                    if($request->opt_out == 1){
                        $query->where($column, '!=', '$value');
                    }else{
                        $query->where($column, $aggregate_value,$value);
                    }
                }elseif($column == 'sold'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_orders.quantity) sold'))
                        ->leftJoin('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->join('product_orders','product_variation.id','=','product_orders.variation_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null],['product_orders.deleted_at',null]])
                        ->havingRaw('sum(product_orders.quantity)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'stock'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('sum(product_variation.actual_quantity) stock'))
                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
                        ->havingRaw('sum(product_variation.actual_quantity)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'product'){
                    $aggrgate_value = $request->aggregate_condition;
                    $query_info = ProductDraft::select('product_drafts.id',DB::raw('count(product_variation.id) product'))
                        ->join('product_variation','product_drafts.id','=','product_variation.product_draft_id')
                        ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
                        ->havingRaw('count(product_variation.id)'.$aggrgate_value.$request->search_value)
                        ->groupBy('product_drafts.id')
                        ->get();
                    $ids = [];
                    foreach ($query_info as $info){
                        $ids[] = $info->id;
                    }
                    if($request->opt_out == 1){
                        $query->whereNotIn('id',$ids);
                    }else{
                        $query->whereIn('id',$ids);
                    }
                }elseif($column == 'creator'){
                    if($request->opt_out == 1){
                        $query->where('user_id','!=',$request->user_id);
                    }else{
                        $query->where('user_id',$request->user_id);
                    }
                }elseif($column == 'modifier'){
                    if($request->opt_out == 1){
                        $query->where('modifier_id','!=',$request->user_id);
                    }else{
                        $query->where('modifier_id',$request->user_id);
                    }
                }

            })
            ->paginate(500);


        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $ids = [];
        if(count($product_drafts) > 0){
            foreach ($product_drafts as $result){
                array_push($ids,$result);
            }
        }else{
            return redirect('woocommerce/pending/catalogue/lists')->with('no_data_found','No data found');
        }

        $users = User::orderBy('name', 'ASC')->get();
        $product_drafts_info = json_decode(json_encode($product_drafts));
        $content = view('woocommerce.pending_catalogue_list',compact('product_drafts','product_drafts_info','setting','value','users', 'pagination', 'shelf_use'));
        return view('master',compact('content'));
    }

    public function parentSkuSentToWoocommerce(){
        $offset = 0;
        while(true){
            $woocommerceInfo = WoocommerceCatalogue::select('id','sku')->skip($offset)->take(100)->get()->toArray();
            if (count($woocommerceInfo) == 0){
                break;
            }
            $skus = [];
            if (count($woocommerceInfo) > 0) {
                foreach($woocommerceInfo as $info){
                    $skus[] = ['id' => $info['id'], 'sku' => $info['sku']];
                }
                $data = [
                    'update' => $skus
                ];
                $woocommerceResponse = Woocommerce::post('products/batch',$data);
            }
            $offset += 100;
        }
        echo '<pre>';
        print_r($woocommerceResponse);
        exit();
    }

    public function activeCatalogueBulkDelete(Request $request){
        try{
            $this->catalogueBulkDelete($request);
            return response()->json(['type' => 'success','msg' => 'Catalogue Successfully Deleted.']);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
        }
    }

    public function updateAttributeTerm(Request $request){
        try{
            try{
                $existCheck = WoocommerceAttributeTerm::where('attribute_id',$request->attribute_id)
                ->where('terms_name',$request->attribute_term)
                ->where('id','!=',$request->attribute_term_id)->first();
                if($existCheck){
                    return response()->json(['type' => 'error','msg' => 'Term Already Exists']);
                }
                $data = [
                    'name' => $request->attribute_term
                ];
                $termUpdateInfo = Woocommerce::put('products/attributes/'.$request->attribute_id.'/terms'.'/'.$request->attribute_term_id, $data);
                $wmsTermInfo = WoocommerceAttributeTerm::where('id',$request->attribute_term_id)->first();
                if($wmsTermInfo){
                    $wmsTermInfo->terms_name = $request->attribute_term;
                    $wmsTermInfo->save();
                }
                return response()->json(['type' => 'success','msg' => 'Attribute Term Updated Successfully']);
            }catch (HttpClientException $exception){
                return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function deleteAttributeTerm(Request $request){
        try{
            try{
                $termDeleteInfo = Woocommerce::delete('products/attributes/'.$request->attribute_id.'/terms'.'/'.$request->attribute_term_id, ['force' => true]);
                $wmsTermInfo = WoocommerceAttributeTerm::where('id',$request->attribute_term_id)->first();
                if($wmsTermInfo){
                    $wmsTermInfo->delete();
                }
                return response()->json(['type' => 'success','msg' => 'Attribute Term Deleted Successfully']);
            }catch (HttpClientException $exception){
                return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function addAttributeTerm(Request $request){
        try{
            if($request->action_type == 'get-attribute'){
                $attributeInfo = WoocommerceAttribute::all();
                return response()->json(['type' => 'success','msg' => 'Attribute Found','all_attributes' => $attributeInfo]);
            }elseif($request->action_type == 'add-attribute-term'){
                $existCheck = WoocommerceAttributeTerm::where('attribute_id',$request->attribute_id)
                ->where('terms_name',$request->term_value)
                ->first();
                if($existCheck){
                    return response()->json(['type' => 'error','msg' => 'Term Already Exists']);
                }
                $existWoocommerceAttributeInfo = WoocommerceAttribute::where('id',$request->attribute_id)->first();
                $existMasterAttributeTerm = AttributeTerm::where('attribute_id',$existWoocommerceAttributeInfo->master_attribute_id)->where('terms_name',$request->term_value)->first();
                $i = 1;
                $lastRow = DB::table('attribute_terms')->orderBy('id','desc')->first();
                if(!$existMasterAttributeTerm){
                    $masterTermInsertInfo = AttributeTerm::create([
                        'id' => $lastRow ? $lastRow->id + $i : 1,
                        'attribute_id' => $existWoocommerceAttributeInfo->master_attribute_id,
                        'terms_name' => $request->term_value,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }else{
                    $existMasterId = $existMasterAttributeTerm->id;
                }
                $data = [
                    'name' => $request->term_value
                ];
                $wooInsertInfo = Woocommerce::post('products/attributes/' . $request->attribute_id . '/terms'.'/', $data);
                if($wooInsertInfo){
                    $wmsInsertInfo = WoocommerceAttributeTerm::create([
                        'id' => $wooInsertInfo['id'],
                        'attribute_id' => $request->attribute_id,
                        'master_terms_id' => $existMasterId ?? ($lastRow ? $lastRow->id + $i : 1),
                        'terms_name' => $request->term_value,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
                return response()->json(['type' => 'success','msg' => 'Attribute Term Added Successfully']);
            }
            return response()->json(['type' => 'success','msg' => 'No Attribute Found']);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }


}
