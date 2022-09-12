<?php

namespace App\Http\Controllers\woocommerce;

use App\Attribute;
use App\AttributeTerm;
use App\ProductDraft;
use App\ShelfedProduct;
use App\woocommerce\WoocommerceVariation;
use App\ProductVariation;
use App\woocommerce\WoocommerceCatalogue;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Illuminate\Support\Facades\DB;
use App\Traits\ActivityLogs;
use Auth;
use Illuminate\Support\Carbon;

class WoocommerceVariationController extends Controller
{
    use ActivityLogs;
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
//        $product_draft_result = WoocommerceCatalogue::with(['variations' => function($query) {
//            $query->with(['master_variation' => function($query){
//                $query->with(['shelf_quantity', 'order_products' => function ($query) {
//                    $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
//                }]);
//            }]);
//        }])->find($id);


        $all_product_variation = WoocommerceVariation::with(['master_catalogue','master_variation' => function($query){
            $query->with(['shelf_quantity', 'order_products' => function ($query) {
                $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }]);
        }])
//            ->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('id','DESC')->paginate(50);
        $total_variation = WoocommerceVariation::count();
        $variation_range = json_decode(json_encode($all_product_variation));
//        echo "<pre>";
//        print_r($variation_range);
//        exit();
        $content = view('woocommerce.variation.variation_list',compact('all_product_variation','total_variation','variation_range'));
        return view('master',compact('content'));
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
//        $variation_info = WoocommerceVariation::with((['master_catalogue:id,master_catalogue_id,name']))->find($id);
//        $product_draft_result = ProductDraft::with((['woocommerce_catalogue_attribute']))->find($variation_info->master_catalogue->master_catalogue_id);
//        $product_draft_results = json_decode(json_encode($product_draft_result)) ;


        $single_variation_info = WoocommerceVariation::with(['master_catalogue:id,master_catalogue_id,name,description'])->find($id);
        $attribute_info = ProductDraft::with(['woocommerce_catalogue_attribute'])->where('id',$single_variation_info->master_catalogue->master_catalogue_id)->get();
//        echo "<pre>";
//        print_r(json_decode(json_encode($single_variation_info)));
//        exit();
        $content = view('woocommerce.variation.variation_details',compact('single_variation_info','attribute_info'));
        return view('master',compact('content'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variation_info = WoocommerceVariation::with((['master_catalogue:id,master_catalogue_id,name']))->find($id);
        $product_draft_result = ProductDraft::with((['woocommerce_catalogue_attribute']))->find($variation_info->master_catalogue->master_catalogue_id);
        $product_draft_results = json_decode(json_encode($product_draft_result));
//        echo "<pre>";
//        print_r($product_draft_results);
//        exit();
//        $attribute_array = array();
//        foreach ($product_draft_results->woocommerce_catalogue_attribute as $attribute_term){
//            $attribute_array[$attribute_term->attribute_id][] = ["id"=>$attribute_term->id,'name'=>$attribute_term->terms_name];
//        }

//        echo "<pre>";
//        print_r(json_decode($variation_info));
//        exit();
        return view('woocommerce.variation.edit_variation',compact('variation_info'));
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
        $productVariation = WoocommerceVariation::find($id);
        $valildation = $request->validate([
            'sku' => 'required|unique:woocom_variation_products,sku,'.$productVariation->id.',id,deleted_at,NULL',
        ]);
        try{

            if(isset($request->ean_no)) {
                request()->validate([
                    'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                    'ean_no' => 'digits:13|unique:woocom_variation_products,ean_no,'.$productVariation->id.',id,deleted_at,NULL',
                ]);
            }else{
                request()->validate([
                    'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                ]);
            }

            if ($request->hasFile('file')){
                $imageName = time().'.'.request()->file->getClientOriginalExtension();

                $image_result = request()->file->move('assets/images/product_variation/', $imageName);

            }

            $attribute = array();
            $attribute_value = array();
            if(isset($request->a5) && $request->a5 != 'select'){
                $attribute_value['id'] = 5;
                $attribute_value['option'] = $request->a5;
                array_push($attribute,$attribute_value);
                $datas['attribute1'] = $request->a5;
            }
            if(isset($request->a6) && $request->a6 != 'select'){
                $attribute_value['id'] = 6;
                $attribute_value['option'] = $request->a6;
                array_push($attribute,$attribute_value);
                $datas['attribute2'] = $request->a6;
            }

            if(isset($request->a7) && $request->a7 != 'select'){
                $attribute_value['id'] = 7;
                $attribute_value['option'] = $request->a7;
                array_push($attribute,$attribute_value);
                $datas['attribute3'] = $request->a7;
            }

            if(isset($request->a8) && $request->a8 != 'select'){
                $attribute_value['id'] = 8;
                $attribute_value['option'] = $request->a8;
                array_push($attribute,$attribute_value);
                $datas['attribute4'] = $request->a8;
            }

            if(isset($request->a9) && $request->a9 != 'select'){
                $attribute_value['id'] = 9;
                $attribute_value['option'] = $request->a9;
                array_push($attribute,$attribute_value);
                $datas['attribute5'] = $request->a9;
            }

            if(isset($request->a10) && $request->a10 != 'select'){
                $attribute_value['id'] = 10;
                $attribute_value['option'] = $request->a10;
                array_push($attribute,$attribute_value);
                $datas['attribute6'] = $request->a10;
            }

            if(isset($request->a11) && $request->a11 != 'select'){
                $attribute_value['id'] = 11;
                $attribute_value['option'] = $request->a11;
                array_push($attribute,$attribute_value);
                $datas['attribute7'] = $request->a11;
            }

            if(isset($request->a12) && $request->a12 != 'select'){
                $attribute_value['id'] = 12;
                $attribute_value['option'] = $request->a12;
                array_push($attribute,$attribute_value);
                $datas['attribute8'] = $request->a12;
            }

            if(isset($request->a13) && $request->a13 != 'select'){
                $attribute_value['id'] = 13;
                $attribute_value['option'] = $request->a13;
                array_push($attribute,$attribute_value);
                $datas['attribute9'] = $request->a13;
            }

            if(isset($request->a14) && $request->a14 != 'select'){
                $attribute_value['id'] = 14;
                $attribute_value['option'] = $request->a14;
                array_push($attribute,$attribute_value);
                $datas['attribute10'] = $request->a14;
            }

            $data = [
                'regular_price' => $request->regular_price,
                'sale_price' => $request->sale_price,
                'sku' => $request->sku,
                'stock_quantity' => $request->actual_quantity,
                'description' => isset($request->description) ? $request->description : null,

            ];

//            if(!empty($attribute)){
//                $data['attributes'] = $attribute;
//            }
            if ($request->hasFile('file')){
                $data['image'] = [
                    'src' =>asset('assets/images/product_variation/'.$imageName),
                ];
            }

//            echo "<pre>";
//            print_r($data);
//            exit();

            try{
                $logInsertData = $this->paramToArray(url()->full(),'Variation Update','Woocommerce',1,$request->sku,$data,null,Auth::user()->name,$productVariation->actual_quantity,$request->actual_quantity,Carbon::now(),2,2);
                $product_variation_result = Woocommerce::put('products/'.$productVariation->woocom_master_product_id.'/variations/'.$productVariation->id, $data);
                if($product_variation_result){
                    $updateResponse = $this->updateResponse($logInsertData->id,$product_variation_result,1,1);
                }else{
                    $updateResponse = $this->updateResponse($logInsertData->id,$product_variation_result,0,0);
                }
            }catch (HttpClientException $exception){
                $logInsertData = $this->paramToArray(url()->full(),'Variation Update','Woocommerce',1,$request->sku,$data,$exception,Auth::user()->name,$productVariation->actual_quantity,$request->actual_quantity,Carbon::now(),0,0);
//                echo $exception->getMessage();
                return back()->with('error', $exception->getMessage());
            }


             $product_variation_decode_result = json_decode(json_encode($product_variation_result));

            if ($product_variation_result != null){
            if ($request->hasFile('file')){
//                    $request->request->add(['notification_status' => isset($request->notification_status) ? true : false,'image' => $product_variation_decode_result->image->src]);
                $datas['image'] = asset('assets/images/product_variation/'.$imageName);
            }
//                $request->request->add(['notification_status' => isset($request->notification_status) ? true : false]);

//                $product_variation_result = ProductVariation::find($productVariation->id)->update($request->all());

            $datas['regular_price'] = $request->regular_price;
            $datas['sale_price'] = $request->sale_price;
            $datas['sku'] = $request->sku;
            $datas['description'] = isset($request->description) ? $request->description : null;
            $datas['ean_no'] = $request->ean_no;
            $datas['sale_price'] = $request->sale_price;
            $datas['cost_price'] = $request->cost_price;
            $datas['product_code'] = $request->product_code;
            $datas['color_code'] = $request->color_code;
            $datas['low_quantity'] = $request->low_quantity;
            $datas['actual_quantity'] = $request->actual_quantity ?? 0;
            $datas['notification_status'] = isset($request->notificationCheckbox) ? true : false;


            $product_variation_result = WoocommerceVariation::find($productVariation->id)->update($datas);

            return back()->with('success','Product Variation updated successfully');

            }

        }catch (Exception $exception){
            return back()->with('error',$exception);
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
        $productVariation = WoocommerceVariation::find($id);
        try{
            try{
                $product_variation_result = Woocommerce::delete('products/'.$productVariation->woocom_master_product_id.'/variations/'.$productVariation->id, ['force' => true]);
            }catch (HttpClientException $exception){
                return back()->with('error', $exception->getMessage());
            }

            WoocommerceVariation::destroy($productVariation->id);
//            ShelfedProduct::where('variation_id',$productVariation->id)->delete();

            return back()->with('success', 'Successfully deleted');

        }catch (Exception $exception){
            return back()->with('error', $exception);
        }
    }

    public function cataloguevariation($woo_id){
        $master_id = WoocommerceCatalogue::find($woo_id)->master_catalogue_id;
        $master_variation = ProductVariation::with('woocommerce_variations')->where('product_draft_id',$master_id)->get();
//        echo "<pre>";
//        print_r(json_decode($master_variation));
//        exit();

        $content = view('woocommerce.catalogue_variation',compact('master_variation','woo_id'));
        return view('master',compact('content'));
    }

    public function variationCreate(Request $request){

        foreach ($request->sku as $key => $value) {
//            $variation_find = WoocommerceVariation::where('attribute1',$request->a5)->where('attribute2',$request->a6)
//                ->where('attribute3',$request->a7)->where('attribute4',$request->a8)->where('attribute5',$request->a9)
//                ->where('attribute6',$request->a10)->where('attribute7',$request->a11)->where('attribute8',$request->a12)
//                ->where('attribute9',$request->a13)->where('attribute10',$request->a14)
//                ->where('woocom_master_product_id',$request->woocom_master_product_id)->get()->first();
            $attribute = array();
            $attribute_value = array();
            foreach ($request->attribute as $attribute_id => $trems_id){

                $attribute_value[] =
                    [ "attribute_id" => $attribute_id,
                        "attribute_name" => Attribute::find($attribute_id)->attribute_name,
                        "terms_id" => $trems_id[$key],
                        "terms_name" => AttributeTerm::find($trems_id[$key])->terms_name
                    ];
                $woo_attributes[] = [
                    'id' => $attribute_id,
                    'option' => AttributeTerm::find($trems_id[$key])->terms_name
                ];
                ;
            }


            $attribute_value_serialize = \Opis\Closure\serialize($attribute_value);

            $variation_find = WoocommerceVariation::where([['woocom_master_product_id', $request->woocom_master_product_id],['attribute',$attribute_value_serialize]])->get()->first();
            //dd($variation_find);
            if(empty($variation_find)){
                $data = WoocommerceVariation:: where([['woocom_master_product_id', $request->woocom_master_product_id], ['sku', $request->sku[$key]]])->where('deleted_at', '=', NULL)->first();
                if (isset($data)) {
                    return back()->with('error', 'This ' . $data->sku . ' already exist under this catalogue.');
                }
                $deletedExist = WoocommerceVariation::withTrashed()->where([['woocom_master_product_id', $request->woocom_master_product_id], ['sku', $request->sku[$key]]])->first();
                if($deletedExist){
                    $deletedExist->sku = $deletedExist->sku.'_'.date("Ymdhis");
                    $deletedExist->save();
                }
//            $validation = $request->validate([
//                'sku' => 'required|unique:product_variation'
////            'ean_no' => 'required|digits:13|unique:product_variation'
//            ]);

                try {
//                    $attribute = array();
//                    $attribute_value = array();
//                    if ($request->a5 != null && $request->a5[$key] != 'select') {
//                        $attribute_value['id'] = 5;
//                        $attribute_value['option'] = $request->a5[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//                    if ($request->a6 != null && $request->a6[$key] != 'select') {
//                        $attribute_value['id'] = 6;
//                        $attribute_value['option'] = $request->a6[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a7 != null && $request->a7[$key] != 'select') {
//                        $attribute_value['id'] = 7;
//                        $attribute_value['option'] = $request->a7[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a8 != null && $request->a8[$key] != 'select') {
//                        $attribute_value['id'] = 8;
//                        $attribute_value['option'] = $request->a8[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a9 != null && $request->a9[$key] != 'select') {
//                        $attribute_value['id'] = 9;
//                        $attribute_value['option'] = $request->a9[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a10 != null && $request->a10[$key] != 'select') {
//                        $attribute_value['id'] = 10;
//                        $attribute_value['option'] = $request->a10[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a11 != null && $request->a11[$key] != 'select') {
//                        $attribute_value['id'] = 11;
//                        $attribute_value['option'] = $request->a11[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a12 != null && $request->a12[$key] != 'select') {
//                        $attribute_value['id'] = 12;
//                        $attribute_value['option'] = $request->a12[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a13 != null && $request->a13[$key] != 'select') {
//                        $attribute_value['id'] = 13;
//                        $attribute_value['option'] = $request->a13[$key];
//                        array_push($attribute, $attribute_value);
//                    }
//
//                    if ($request->a14 != null && $request->a14[$key] != 'select') {
//                        $attribute_value['id'] = 14;
//                        $attribute_value['option'] = $request->a14[$key];
//                        array_push($attribute, $attribute_value);
//                    }


                    $variation_data = [

                        'description' => empty($request->description[$key]) ? null : $request->description[$key],
                        'sku' => $request->sku[$key],
                        'regular_price' => $request->regular_price[$key],
                        'sale_price' => $request->sale_price[$key],
                        'manage_stock' => true,
                        'stock_quantity' => $request->actual_quantity[$key] ?? 0,
                        'attributes' => $woo_attributes,
                    ];
                    if($request->image[$key] != null){
                        $variation_data['image'] = [
                            'src' => $request->image[$key] ?? null
                        ];
                    }

                    try{
                        $result = Woocommerce::post( "products/".$request->woocom_master_product_id."/variations", $variation_data );
                    }catch (HttpClientException $exception){

                        return back()->with('error', $exception->getMessage());
                    }

                    $result = json_decode(json_encode($result));

                    WoocommerceVariation::create(['id' => $result->id, 'woocom_master_product_id' => $request->woocom_master_product_id,
                        'woocom_variation_id' => $request->woocomm_variation_id[$key],
                        'attribute' => $attribute_value_serialize,
                        'sku' => $request->sku[$key], 'actual_quantity' => $request->actual_quantity[$key],
                        'ean_no' => $request->ean_no[$key],'cost_price' => $request->cost_price[$key],
                        'regular_price' => $request->regular_price[$key], 'sale_price' => $request->sale_price[$key],
                        'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                        'product_code' => $request->product_code[$key], 'color_code' => $request->color_code[$key],
                        'low_quantity' => $request->low_quantity[$key],
                        'description' => $request->description[$key] ?? null,
                        'notification_status' => (isset($request->notificationCheckbox)) ? true : false,
                        'manage_stock' => true
                    ]);

                }catch (Exception $exception){
                    return back()->with('error', $exception);
                }

            }else{
                return back()->with('success', 'this variation is already available '  );
            }

        }
        return back()->with('success', 'Variation added successfully');

//        return redirect('catalogue-product-invoice-receive/'.$request->product_draft_id)
//            ->with('success', 'Product created successfully.');

//        return back()->with('success', 'Product created successfully.');
    }

}
