<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeTerm;
use App\Client;
use App\DeveloperAccount;
use App\EbayAccount;
use App\EbayMasterProduct;
use App\EbayVariationProduct;
use App\OnbuyAccount;
use App\OnbuyMasterProduct;
use App\OnbuyVariationProducts;
use App\ProductDraft;
use App\ProductVariation;
use App\Setting;
use App\ShelfedProduct;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use App\WoocommerceAccount;
use App\WooWmsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Carbon;
use Crypt;
use DB;
use Illuminate\Support\Facades\Session;
use Auth;
use App\ProductOrder;
use App\AvailableQuantityChangeLog;
use Arr;
use App\Traits\SearchCatalogue;
use App\Traits\ActivityLogs;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\DefectedProduct;
use App\DefectedProductReason;
use App\DefectProductAction;
use Illuminate\Support\Facades\Response;
use App\amazon\AmazonAccountApplication;
use App\amazon\AmazonVariationProduct;
require_once './vendor/autoload.php';
use App\Traits\Amazon;
use App\Traits\ImageUpload;
use App\Traits\CommonFunction;
use App\Traits\Ebay;
use App\Traits\Onbuy;


class ProductVariationController extends Controller
{
    use SearchCatalogue;
    use ActivityLogs;
    use Amazon;
    use ImageUpload;
    use CommonFunction;
    use Ebay;
    use Onbuy;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('channelAccount');
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

    public function access_token(){
        $onbuy_consumer_key = Session::get('onbuy_consumer_key');
        $onbuy_secret_key = Session::get('onbuy_secret_key');
        if($onbuy_consumer_key == '' && $onbuy_secret_key == ''){
            $info = OnbuyAccount::where('status',1)->first();
            if($info) {
                Session::put('onbuy_consumer_key', $info->consumer_key);
                Session::put('onbuy_secret_key', $info->secret_key);
                $onbuy_consumer_key = $info->consumer_key;
                $onbuy_secret_key = $info->secret_key;
            }else{
//                return redirect('/onbuy/master-product-list');
                return 'notoken';
            }
        }
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.onbuy.com/v2/auth/request-token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('secret_key' => $onbuy_secret_key,'consumer_key' => $onbuy_consumer_key),
            CURLOPT_HTTPHEADER => array(

            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $token = json_decode($response);
        return $token->access_token;
    }

    public function curl_request_send($url, $method, $post_data = null, $http_header = []){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => $http_header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function index()
    {
        $all_product_variation = ProductVariation::with(['product_draft' => function ($query) {
            $query->with('product_catalogue_image');
        },'shelf_quantity','order_products' => function ($query) {
            $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
        }])
//            ->whereDate('created_at', '>', Carbon::now()->subDays(7))
            ->orderBy('id','DESC')->paginate(50);
        $total_variation = ProductVariation::count();
        $all_variation_decode_info = json_decode(json_encode($all_product_variation));
//        echo "<pre>";
//        print_r(json_decode(json_encode($all_product_variation)));
//        exit();
        $content = view('product_variation.variation_list',compact('all_product_variation','total_variation','all_variation_decode_info'));
        return view('master',compact('content'));
    }

    public function getAttribute(Request $request){


        $product_draft_result = ProductDraft::with((['attributeTerms']))->find($request->id);
        $product_draft_results = json_decode(json_encode($product_draft_result)) ;
        $attribute_array = array();
        foreach ($product_draft_results->attribute_terms as $attribute_term){
            $attribute_array[$attribute_term->attribute_id][] = ["id"=>$attribute_term->id,'name'=>$attribute_term->terms_name];
        }
//        echo $product_draft_result;
//        exit();
        $arrbute_ajax = view('product_variation.get_attribute_ajax',compact('attribute_array','product_draft_result'));
        return $arrbute_ajax ;
        //return 'test';

        //print_r($product_draft_result) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = ProductDraft::orderBy('id','desc')->get()->all();

        return view('product_variation.create_product_variation',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = ProductVariation:: where([['product_draft_id', $request->product_draft_id],['sku', $request->sku]])->where('deleted_at','=',NULL)->first();
        if(isset($data)){
            return back()->with('error', 'This product already exist under this catalogue.');
        }

//        $validation = $request->validate([
//            'sku' => 'required|unique:product_variation'
////            'ean_no' => 'required|digits:13|unique:product_variation'
//        ]);

        try{
            $attribute = array();
            $attribute_value = array();
            if($request->a5 != null){
                $attribute_value['id'] = 5;
                $attribute_value['option'] = $request->a5;
                array_push($attribute,$attribute_value);
            }
            if($request->a6 != null){
                $attribute_value['id'] = 6;
                $attribute_value['option'] = $request->a6;
                array_push($attribute,$attribute_value);
            }

            if($request->a7 != null){
                $attribute_value['id'] = 7;
                $attribute_value['option'] = $request->a7;
                array_push($attribute,$attribute_value);
            }

            if($request->a8 != null){
                $attribute_value['id'] = 8;
                $attribute_value['option'] = $request->a8;
                array_push($attribute,$attribute_value);
            }

            if($request->a9 != null){
                $attribute_value['id'] = 9;
                $attribute_value['option'] = $request->a9;
                array_push($attribute,$attribute_value);
            }

            if($request->a10 != null){
                $attribute_value['id'] = 10;
                $attribute_value['option'] = $request->a10;
                array_push($attribute,$attribute_value);
            }

            if($request->a11 != null){
                $attribute_value['id'] = 11;
                $attribute_value['option'] = $request->a11;
                array_push($attribute,$attribute_value);
            }

            if($request->a12 != null){
                $attribute_value['id'] = 12;
                $attribute_value['option'] = $request->a12;
                array_push($attribute,$attribute_value);
            }

            if($request->a13 != null){
                $attribute_value['id'] = 13;
                $attribute_value['option'] = $request->a13;
                array_push($attribute,$attribute_value);
            }

            if($request->a14 != null){
                $attribute_value['id'] = 14;
                $attribute_value['option'] = $request->a14;
                array_push($attribute,$attribute_value);
            }



            $variation_data = [

                'description' => empty($request->description) ? null: $request->description,
                'sku' => $request->sku,
                'regular_price' => $request->regular_price,
                'sale_price' => $request->sale_price,
                'manage_stock' =>true,
                'stock_quantity' => 0,
                'attributes' => $attribute,


            ];

            try{
                //$result = Woocommerce::post( "products/".$request->product_draft_id."/variations", $variation_data );
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            //$result = json_decode(json_encode($result));

            ProductVariation::create(['product_draft_id' => $request->product_draft_id,
                'attribute1' => $request->a5,'attribute2' => $request->a6,'attribute3' => $request->a7,'attribute4' => $request->a8,
                'attribute5' => $request->a9,'attribute6' => $request->a10,'attribute7' => $request->a11,'attribute8' => $request->a12,
                'attribute9' => $request->a13,'attribute10' => $request->a14,
                'sku' => $request->sku,'ean_no' => $request->ean_no, 'regular_price'=> $request->regular_price,'sale_price' => $request->sale_price,
                'cost_price' => $request->cost_price,'product_code' => $request->product_code,'color_code' => $request->color_code,'low_quantity'=>$request->low_quantity,
                'description' => empty($request->description) ? null: $request->description, 'notification_status' => (isset($request->notificationCheckbox)) ? true : false,
                'manage_stock' => true
            ]);
            return back()->with('success','Product created successfully.');
        }catch (Exception $exception){
            return back()->with('error', $exception);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : edit
     * Route : product-variation (resource router)
     * parameters: ProductVariation model
     * Request : get
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for viewing edit content in variation edit page
     * Created Date: unknown
     * Modified Date : 19-11-2020
     * Modified Content : isset error check and error exception handle. Also code minimized
     */
    public function edit(ProductVariation $productVariation)
    {
        try {
            $catalogue_id = ProductVariation::find($productVariation->id)->product_draft_id;
            if($catalogue_id) {
                $product_draft_result = ProductDraft::find($catalogue_id);
                $product_draft_results = json_decode(json_encode($product_draft_result));
                return view('product_variation.variation_edit', compact('productVariation','product_draft_results'));
            }else{
                return back()->with('error','No variation found');
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : update
     * Route : product-variation (resource router)
     * parameters: ProductVariation model
     * Request : post
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for update variation in different channel
     * Created Date: unknown
     * Modified Date : 19-11-2020
     * Modified Content : isset error check and error exception handle. Also code minimized
     */
    public function update(Request $request, ProductVariation $productVariation)
    {
        try {
            $valildation = $request->validate([
                'sku' => 'required|max:100'
            ]);
            $product_variation_find_result = ProductVariation::where('sku',$request->sku)->where('id','!=',$productVariation->id)->first();
            if ($product_variation_find_result){
//                return 'The sku is already taken';
                return back()->with('error', 'The sku is already taken');
            }
//            exit();
            $ebay_data = $request->all();
            try{
//                if(isset($request->ean_no)) {
//                    request()->validate([
//                        'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
//                        'ean_no' => 'digits:13|unique:product_variation,ean_no,'.$productVariation->id.',id,deleted_at,NULL',
//                    ]);
//                }else{
//                    request()->validate([
//                        'file' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
//                    ]);
//                }

                if ($request->hasFile('file')){
                    $image = $request->file;
                    $name = $productVariation->id.'-'.str_replace(' ','-', \Carbon\Carbon::now()->toDateTimeString());
                    $name .= str_replace(' ', '-',$image->getClientOriginalName());
                    $image->move('assets/images/product_variation/', $name);
//                    $imageName = time().'.'.request()->file->getClientOriginalExtension();
//                    $image_result = request()->file->move('assets/images/product_variation/', $imageName);
                }
                $attribute = array();
                $attribute_value = array();
                $data = [
                    'regular_price' => $request->regular_price ?? 0.00,
                    'sale_price' => $request->sale_price ?? 0.00,
                    'sku' => str_replace(' ','_',$request->sku) ?? '',
                    'stock_quantity' => $request->actual_quantity ?? 0,
                    'description' => isset($request->description) ? strip_tags($request->description) : null,
                ];
                $product_variation_find = ProductVariation::find($productVariation->id);

                if($product_variation_find) {

                    if ($request->hasFile('file')) {
                        $data['image'] = [
                            'src' => asset('assets/images/product_variation/' . $name),
                        ];
                    }

                    if ($request->hasFile('file')) {
                        $datas['image'] = 'assets/images/product_variation/' . $name;
                        $Woo_datas['image'] = $product_variation_decode_result->image->src ?? $this->projectUrl().$datas['image'];
                    }

                    $datas['regular_price'] = $request->regular_price ?? null;
                    $datas['sale_price'] = $request->sale_price ?? null;
                    $datas['sku'] = str_replace(' ','_',$request->sku);
                    $datas['description'] = isset($request->description) ? $request->description : null;
                    $datas['ean_no'] = $request->ean_no ?? null;
                    $datas['sale_price'] = $request->sale_price ?? null;
                    $datas['cost_price'] = $request->cost_price ?? null;
                    $datas['base_price'] = $request->base_price ?? null;
                    $datas['product_code'] = $request->product_code ?? null;
                    $datas['color_code'] = $request->color_code ?? null;
                    $datas['low_quantity'] = $request->low_quantity ?? null;
                    $datas['actual_quantity'] = $request->actual_quantity ?? 0;
                    $datas['notification_status'] = isset($request->notification_status) ? true : false;
                    $product_variation_result = ProductVariation::find($productVariation->id)->update($datas);

                    if(Session::get('woocommerce') == 1){
                        $woocommerce_status = WoocommerceAccount::where('status',1)->first();
                        if($woocommerce_status) {

                            $woo_comm_variation_info = WoocommerceVariation::where('woocom_variation_id', $productVariation->id)->first();
                            if ($woo_comm_variation_info) {
                                try {
                                    $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info->woocom_master_product_id . '/variations/' . $woo_comm_variation_info->id, $data);
                                } catch (HttpClientException $exception) {
                                    return back()->with('error', $exception->getMessage());
                                }
                                $product_variation_decode_result = json_decode(json_encode($product_variation_result));
                                $Woo_datas['regular_price'] = $request->regular_price ?? 0.00;
                                $Woo_datas['sale_price'] = $request->sale_price ?? 0.00;
                                $Woo_datas['sku'] = str_replace(' ','_',$request->sku);
                                $Woo_datas['ean_no'] = $request->ean_no ?? null;
                                $Woo_datas['cost_price'] = $request->cost_price ?? null;
                                $Woo_datas['product_code'] = $request->product_code ?? null;
                                $Woo_datas['color_code'] = $request->color_code ?? null;
                                $Woo_datas['low_quantity'] = $request->low_quantity ?? null;
                                $Woo_datas['actual_quantity'] = $request->actual_quantity ?? 0;
                                $Woo_datas['notification_status'] = isset($request->notificationCheckbox) ? true : false;

                                if (isset($woo_comm_variation_info->id)) {
                                    $woo_product_variation_result = WoocommerceVariation::find($woo_comm_variation_info->id)->update($Woo_datas);
                                }
                            }
                        }
                    }

                    if(Session::get('onbuy') == 1){
                        $onbuy_status = OnbuyAccount::where('status',1)->first();
                        if ($onbuy_status) {
                            $onbuy_variation_info = OnbuyVariationProducts::where('sku', $product_variation_find->sku)->first();
                            if ($onbuy_variation_info) {
                                $var_data[] = [
                                    "sku" => $onbuy_variation_info->sku,
                                    "price" => $request->sale_price ?? 0.00,
                                    "stock" => $request->actual_quantity ?? 0
                                ];
                                $update_info = [
                                    "site_id" => 2000,
                                    "listings" => $var_data
                                ];

                                $access_token = $this->access_token();
                                if ($access_token != 'notoken') {
                                    $var_product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                                    $var_post_data = $var_product_info;
                                    $method = "PUT";
                                    $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                                    $result_info = $this->curl_request_send($url, $method, $var_post_data, $http_header);

                                    $update_info = OnbuyVariationProducts::where('id', $onbuy_variation_info->id)->update([
                                        'price' => $request->sale_price ?? 0.00,
                                        'stock' => $request->actual_quantity ?? 0,
                                        'base_price' => $request->base_price ?? null
                                    ]);
                                    $data = json_decode($result_info);
                                }
                            }
                        }
                    }

                    if(Session::get('ebay') == 1){
                        $ebay_status = DeveloperAccount::where('status',1)->first();
                        if ($ebay_status) {
                            $ebay_variation_info = EbayVariationProduct::where('master_variation_id',$productVariation->id)->first();
//                        echo "<pre>";
//                        print_r(unserialize($ebay_variation_info->variation_specifics));
//                        exit();
                            if ($ebay_variation_info) {

                                $picture = '';
                                $variaiton = '';
                                $ebay_variation_image_array = array();

                                $product_variations = ProductVariation::where('product_draft_id',$productVariation->product_draft_id)->get()->all();



                                if (isset($product_variation_find->image) && isset($product_variation_find->image_attribute)){

                                    if ($request->hasFile('file')) {
                                        $image_url = $this->projectUrl().$datas['image'];
                                    }else{
                                        $image_url = $product_variation_find->image;
                                    }

                                    foreach ($product_variations as $product_variation){
                                        if($product_variation->image_attribute){
                                            foreach (unserialize($product_variation->image_attribute) as $attribute_name => $terms_name) {
                                                $image_array[$terms_name] = $product_variation->image;
                                            }
                                        }
                                    }
                                    foreach (unserialize($product_variation_find->image_attribute) as $attribute_name => $terms_name){

                                        $image_array[$terms_name] = $image_url;
                                    }

                                    foreach (unserialize($product_variation_find->image_attribute) as $attribute_name => $terms_name){

                                        $picture = '<Pictures><VariationSpecificName>'.$attribute_name.'</VariationSpecificName>';
                                        foreach ($image_array as $terms_name => $image_link){

                                            $ebay_array[$terms_name] =
                                                [
                                                    $image_link
                                                ]
                                            ;
                                            $picture .='<VariationSpecificPictureSet><VariationSpecificValue>'.$terms_name.'</VariationSpecificValue>'.'<PictureURL>'.$image_link.'</PictureURL></VariationSpecificPictureSet>';
                                        }
                                        $picture .='</Pictures>';
                                        $ebay_variation_image_array[$attribute_name] = $ebay_array;
                                    }

                                }

                                if(\Opis\Closure\unserialize($ebay_variation_info->variation_specifics) != ''){
                                    if (isset($ebay_variation_info->variation_specifics)){
                                        $variaiton = '<VariationSpecifics>';
                                        foreach (unserialize($ebay_variation_info->variation_specifics) as $attribute_name => $terms_name){
                                            $variaiton .= '<NameValueList><Name>'.$attribute_name.'</Name><Value>'.$terms_name.'</Value></NameValueList>';
                                        }
                                        $variaiton .= '</VariationSpecifics>';
                                    }
                                };


                                $this->updateEbayVariation($productVariation->id, $ebay_data,$picture,$variaiton,$ebay_variation_image_array);
                            }
                        }
                    }
                    return back()->with('success', 'Product Variation updated successfully');
                }

            }catch (Exception $exception){
                return back()->with('error',$exception);
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }

    }

    public function updateEbayVariation($variation_id,$data,$picture,$variation,$ebay_variation_image_array){

        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('master_variation_id',$variation_id)->get()->all();

        if(count($ebay_product_find) > 0) {

            foreach ($ebay_product_find as $product) {
                $ean = '';
                if (isset($data['ean_no'])){
                    $ean = $data['ean_no'];
                }else{
                    $ean = 'Does not apply';
                }
                $account_result = EbayAccount::find($product->masterProduct->account_id);
                if ($account_result) {
                    $this->ebayAccessToken($account_result->refresh_token);
                    $url = 'https://api.ebay.com/ws/api.dll';
                    $headers = [
                        'X-EBAY-API-SITEID:' . $product->masterProduct->site_id,
                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                        'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                        'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                    ];
                    $product_details='';
                    if ($product->masterProduct->type == 'variable'){
                        $product_details = '<Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>

                            <DiscountPriceInfo>
                            <OriginalRetailPrice>' . $data['regular_price'] . '</OriginalRetailPrice>
                            </DiscountPriceInfo>
                            <SKU>' . str_replace('&','&amp;',$data['sku']) . '</SKU>
                            <StartPrice>' . $data['sale_price'] . '</StartPrice>
                            <Quantity>' . $data['actual_quantity'] . '</Quantity>
                            <VariationProductListingDetails>
                            <EAN>' . $ean . '</EAN>
                            </VariationProductListingDetails>'.$variation.'
                          </Variation>'.$picture.'
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>';
                    }else{
                        $item_specifics = '';
                        $masterItemSpecific = $product->masterProduct->item_specifics;
                        if (isset($masterItemSpecific) && is_array(\Opis\Closure\unserialize($masterItemSpecific))){
                            foreach (\Opis\Closure\unserialize($masterItemSpecific) as $key=>$item_specific){
                                if(in_array($key, ['Model','Brand','Storage Capacity','Colour'])){
                                    $item_specifics .='<NameValueList>
        				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
        				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
        			                      </NameValueList>';
                                }
                            }

                        }
                        $product_details ='<ProductListingDetails><EAN>'.$ean.'</EAN></ProductListingDetails><SKU>'.str_replace('&','&amp;',$data['sku']).'</SKU>';
                        if($item_specifics != ''){
                            $product_details .= '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
                        }

                    }

                    $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>' . $product->masterProduct->item_id . '</ItemID>
                        '.$product_details.'
                      </Item>
                    </ReviseFixedPriceItemRequest>';

                    $update_ebay_product = $this->curl($url, $headers, $body, 'POST');

                }
                EbayVariationProduct::where('master_variation_id',$variation_id)->update(['sku' => $data['sku']]);
            }

            EbayMasterProduct::where('id',$product->masterProduct->id)->update(['variation_images' => \Opis\Closure\serialize($ebay_variation_image_array)]);

        }
    }

    public function getVariation(Request $request){

        $index = $request->id;
        $product_variations = ProductVariation::get()->all();
        $content = view('product_variation.ajax_receive_variation',compact('index','product_variations'));

        return $content;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $productVariation)
    {
        try{
            $variation_info = ProductVariation::find($productVariation->id);
            if(Session::get('woocommerce') == 1){
                $woo_variation_info = WoocommerceVariation::where('woocom_variation_id',$productVariation->id)->first();
                if($woo_variation_info) {
                    try {
                        $product_variation_result = Woocommerce::delete('products/' . $woo_variation_info->woocom_master_product_id . '/variations/' . $woo_variation_info->id, ['force' => true]);
                    } catch (HttpClientException $exception) {

//                    return back()->with('error', $exception->getMessage());
                    }
                    $woo_delete_info = WoocommerceVariation::find($woo_variation_info->id)->delete();
                }
            }
            if(Session::get('ebay') == 1){
                $ebay_variation_info = EbayVariationProduct::where('sku',$variation_info->sku)->first();
                if($ebay_variation_info) {
                    try {
                        $this->deleteEbayVariation($variation_info->sku);

//                    $product_variation_result = Woocommerce::delete('products/' . $woo_variation_info->woocom_master_product_id . '/variations/' . $woo_variation_info->id, ['force' => true]);
                    } catch (HttpClientException $exception) {

//                    return back()->with('error', $exception->getMessage());
                    }
                    $result = EbayVariationProduct::where('sku' , $variation_info->sku)->update(['deleted_at' => \Carbon\Carbon::now()]);
//                $woo_delete_info = WoocommerceVariation::find($woo_variation_info->id)->delete();
                }
            }
            if(Session::get('onbuy') == 1){
                $onbuy_variation_info = OnbuyVariationProducts::where('sku',$variation_info->sku)->first();
                if($onbuy_variation_info) {
                    $sku = OnbuyVariationProducts::find($onbuy_variation_info->id)->sku;
                    $sku_arr = [];
                    array_push($sku_arr,$sku);
                    $access_token = $this->access_token();
                    $data = [
                        "site_id" => 2000,
                        "skus" => $sku_arr
                    ];
                    try {
                        $url = "https://api.onbuy.com/v2/listings/by-sku";
                        $post_data = json_encode($data, JSON_PRETTY_PRINT);
                        $method = "DELETE";
                        $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                        $result_info = $this->curl_request_send($url, $method, $post_data, $http_header);
                    }catch (HttpClientException $exception){

                    }
                    $delete_info = OnbuyVariationProducts::find($onbuy_variation_info->id)->delete();
//                $result_info = json_decode($result_info);
//                if (isset($result_info->results)) {
//                    $delete_info = OnbuyVariationProducts::find($onbuy_variation_info->id)->delete();
//                }
                }
            }
            if(Session::get('amazon') == 1){
                $amazonAccountSites = AmazonAccountApplication::where('application_status',1)->get();
                if($amazonAccountSites && count($amazonAccountSites) > 0){
                    $amazonVariationProduct = AmazonVariationProduct::select('id','amazon_master_product','master_variation_id','sku')->with(['masterCatalogue:id,master_product_id,application_id'])->where('sku',$variation_info->sku)->get();
                    if(count($amazonVariationProduct) > 0){
                        foreach($amazonVariationProduct as $product){
                            $config = $this->configuration($product->masterCatalogue->application_id);
                            $result = $this->deleteListingFromWmsAndAmazon($product->sku,$config);
                        }
                    }
                }
            }

            ProductVariation::destroy($productVariation->id);
            ShelfedProduct::where('variation_id',$productVariation->id)->delete();

            return back()->with('success', 'Successfully deleted');

        }catch (Exception $exception){
            return back()->with('error', $exception);
        }

    }

    public function deleteEbayVariation($sku){


        $sku = $sku;

        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();

        foreach ($ebay_product_find as $product){
            $account_result = EbayAccount::find($product->masterProduct->account_id);

            $this->ebayAccessToken($account_result->refresh_token);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:'.$product->masterProduct->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
            ];

            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$product->masterProduct->item_id.'</ItemID>
                        <Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                          <Delete>true</Delete>
                            <SKU>'.$sku.'</SKU>

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

            $update_ebay_product = $this->curl($url,$headers,$body,'POST');

        }

//        $update_ebay_product =simplexml_load_string($update_ebay_product);
//        $update_ebay_product = json_decode(json_encode($update_ebay_product),true);
//        echo $itemId.'****'.$sku.'*****'.$quantity.'********'.$siteId;
//        exit();


    }




    public function defectedproduct(){
        $content = view('product_variation.defected_product');
        return view('master',compact('content'));
    }

    public function searchVariationList(Request $request){
        $variation_ids = ProductVariation::select('product_variation.id')
            ->join('product_drafts','product_variation.product_draft_id','=','product_drafts.id')
            ->where([['product_drafts.deleted_at','=',null],['product_variation.deleted_at','=',null]])
            ->where('product_variation.sku','LIKE','%'. $request->variation_search_value.'%')
            ->orWhere('product_variation.id','LIKE','%'.$request->variation_search_value.'%')
            ->orWhere('product_variation.ean_no','LIKE','%'.$request->variation_search_value.'%')
            ->orWhere('product_drafts.name','LIKE','%'.$request->variation_search_value.'%')
            ->get();
        $ids_arr = [];
        if(count($variation_ids) > 0){
            foreach ($variation_ids as $ids){
                $ids_arr[] = $ids->id;
            }
        }
        $search_result = ProductVariation::with(['product_draft' => function ($query) {
            $query->with('product_catalogue_image');
        },'shelf_quantity','order_products' => function ($query) {
            $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
        }])
            ->whereIn('id',$ids_arr)
            ->get();
        $variation_search_value = $request->variation_search_value;
//        return response()->json($search_result);
        if($request->page_name == 'low_quantity'){
            return view('product_variation.search_low_variation_list',compact('search_result','variation_search_value'));
        }else if($request->page_name == 'variation_page'){
            return view('product_variation.search_variation_list',compact('search_result','variation_search_value'));
        }
    }

    public function exitEanNoCheck(Request $request){
        $exist = ProductVariation::where('ean_no',$request->ean_no)->first();
        if(isset($exist)) {
            $url = asset('variation-details/'.Crypt::encrypt($exist->id));
            $link = '<a href="'.$url.'" target="_blank">EAN No. exist.Click here for details</a>';
//            $link = '<a href="{{asset(url('.'product-draft/'.$exist->product_draft_id.'))}}">Click here details</a>';
            return response()->json(['data' => $link]);
        }else{
            return response()->json(['data' => 2]);
        }
    }


    /*
     * Function : lowQuantityProductList
     * Route Type : low-quantity-product-list
     * Method Type : GET
     * Parametes : null
     * creator : Unknown
     * Modifier : Solaiman
     * Description : This function is used for displaying Low Quantity Product List and pagination
     * Modified Date : 25-11-2020, 1-12-2020
     * Modified Content : Screen option table column hide show and pagination
     */

    public function lowQuantityProductList($visibilityType = NULL, Request $request)
    {
        $url = $request->getQueryString() ? '&'.http_build_query(Arr::except(request()->query(), ['page'])) : '';
        try {

            $searchValue = $request->get('search-value');
            $catalogueIds = [];
            if($searchValue != null){
                if(is_numeric($searchValue) && strlen($searchValue) == 13){
                    //ean
                    $catalogueIds = $this->seachByEanNo($searchValue);
                }elseif(is_numeric($searchValue)){
                    //id
                    $catalogueIds = $this->searchById($searchValue);
                }else{
                    if(strpos($searchValue,' ') != null){
                        //title
                        $catalogueIds = $this->searchByTitle($searchValue);
                    }else{
                        //sku
                        $catalogueIds = $this->searchBySku($searchValue);
                    }
                }
            }
            $shelf_use = $this->shelf_use;
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('catalogue', 'low_quantity_product');
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting

            $low_quantity_product = ProductVariation::select('product_draft_id')->with(['product_draft' => function($query) use ($visibilityType){
                $query->select('id','name','sale_price')->with(['catalogueVariation' => function($variationQuery) use ($visibilityType){
                    $variationQuery->whereRaw('actual_quantity < low_quantity')
                        ->where(function($query) use ($visibilityType){
                            if($visibilityType == null){
                                $query->whereIn('low_quantity_visibility',[0,1])->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` > 0,`actual_quantity` > -1)');
                            }else{
                                $query->where('low_quantity_visibility',0)->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` = 0,`actual_quantity` > 0)');
                            }
                        })
                        ->with(['shelf_quantity:id,shelf_name','order_products' => function ($query) {
                            $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
                        }]);
                },'single_image_info:id,draft_product_id,image_url']);
            }])
                ->whereRaw('actual_quantity < low_quantity')
                ->where(function($query) use ($visibilityType){
                    if($visibilityType == null){
                        $query->whereIn('low_quantity_visibility',[0,1])->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` > 0,`actual_quantity` > -1)');
                    }else{
                        $query->where('low_quantity_visibility',0)->whereRaw('IF (`low_quantity_visibility` = 0, `actual_quantity` = 0,`actual_quantity` > 0)');
                    }
                });
            $isSearch = $request->get('is_search') ? true : false;
            $allCondition = [];
            if($isSearch){
                $this->lowQuantitySearchCondition($low_quantity_product, $request, $visibilityType);
                $allCondition = $this->lowQuantitySearchParams($request, $allCondition);
            }
            $low_quantity_product = $low_quantity_product->groupBy('product_draft_id');
            if(count($catalogueIds) > 0){
                $low_quantity_product = $low_quantity_product->whereIn('product_draft_id',$catalogueIds);
            }
            $low_quantity_product = $low_quantity_product->orderBy('id','DESC')->paginate($pagination)->appends(request()->query());
            $decode_low_product = json_decode(json_encode($low_quantity_product));
            $content = view('product_variation.low_quantity_product',compact('low_quantity_product','decode_low_product','setting','page_title','pagination','shelf_use','visibilityType','allCondition','url'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }




    /*
     * Function : paginationSetting\
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





    /*
     * Function : catalogueProduct
     * Route Type : catalogue/{id}/product
     * parameters: $id (Catalogue ID)
     * Request : get
     * Creator :
     * Modifier : Kazol
     * Description : This function is used for showing the available variation product (not crated yet) to the master catalogue
     * Created Date: unknown
     * Modified Date : 17-11-2020
     * Modified Content : check the empty array and give isset value to it
     */
    public function catalogueProduct($id){
        // try {

        // $attribute_info = ProductDraft::find($id);
        $attribute_info = ProductDraft::with(['woocommerce_catalogue_info','onbuy_product_info','ebayCatalogueInfo'])->where('id',$id)->first();
        if($attribute_info) {
            $attribute_terms = Attribute::With(['attributesTerms'])->get();
            $attribute_terms = json_decode(json_encode($attribute_terms));
            $productVariationExist = (($attribute_info->woocommerce_catalogue_info != null) || ($attribute_info->onbuy_product_info != null) || ($attribute_info->ebayCatalogueInfo->count() > 0 )) ? true : false;
            $attribute_info = \Opis\Closure\unserialize($attribute_info->attribute);
            //$productVariationExist = ProductVariation::where('product_draft_id',$id)->first();
            // if($attribute_info->attribute != null) {
            //     $product_attribute = \Opis\Closure\unserialize($attribute_info->attribute);
            // }else{
            //     $product_attribute = null;
            // }
            $existAttr = [];
            if($attribute_info && is_array($attribute_info)){
                foreach($attribute_info as $attr_id => $attr_value){
                    foreach($attr_value as $attr_name => $value){
                        $existAttr[$attr_id] = $attr_name;
                    }
                }
            }
            // dd($existAttr);
            // $content = view('product_draft.add_attribute_terms_draft', compact('attribute_terms', 'attribute_info', 'id','productVariationExist','existAttr'));
            // return view('master', compact('content'));
        }
        else{
            return back()->with('error','No Catalogue Found');
        }




        $product_variation_id = ProductVariation::find($id);
        $catalogueVariationInfo = ProductVariation::where('product_draft_id',$id)->where('image_attribute','!=',null)->groupBy('image_attribute')->get();
        $firstProduct = isset($catalogueVariationInfo[0]->image_attribute) ? unserialize($catalogueVariationInfo[0]->image_attribute) : [];
        $img_attribute = '';
        if(count($firstProduct) > 0){
            foreach($firstProduct as $attr_name => $attr_val){
                $img_attribute = $attr_name;
            }
        }
        $attributeTermImageArray = [];
        if(count($catalogueVariationInfo) > 0){
            foreach($catalogueVariationInfo as $info){
                if(($info->image_attribute != null) && is_array(unserialize($info->image_attribute))){
                    if(($info->variation_images != null) && is_array(unserialize($info->variation_images))){
                        $variationImages = unserialize($info->variation_images);
                        $attributeTermImageArray[unserialize($info->image_attribute)[$img_attribute]] = $variationImages;
                    }
                }
            }
        }
        if(array_search('Black',array_column($attributeTermImageArray,'attr_name'))){
            return 'found';
        }
        // dd($product_variation_id);
        $product_variation_result = json_decode(json_encode($product_variation_id));
        // dd($product_variation_result);
        if($product_variation_result != null){
            $product_variation_attribute_arrays = array();
            $unserialize_array = \Opis\Closure\unserialize($product_variation_result->attribute);
            // dd($unserialize_array);
            // if($product_variation_result->attribute != null){
            //     foreach($unserialize_array as $index => $attribute_array){
            //         // dd($unserialize_array);
            //         dd($attribute_array);
            //         $product_variation_attribute_arrays[] = [
            //             'id' =>  $attribute_array['attribute_id'] ?? '',
            //             'variation' => $attribute_array['attribute_name'] ?? '',
            //             'name' => $attribute_array['terms_name'] ?? '',
            //             'attribute_id' => $attribute_array['terms_id'] ?? ''
            //         ];
            //     }
            // }
        }

        // dd($product_variation_attribute_arrays);


        $product_draft_result = ProductDraft::find($id);
        // dd($product_draft_result);

        if($product_draft_result) {
            $product_draft_with_variation_result = ProductDraft::with((['ProductVariations']))->find($id);
            // dd($product_draft_with_variation_result);
            if($product_draft_with_variation_result) {
                $product_draft_results = json_decode(json_encode($product_draft_result));
                // dd($product_draft_results);
                $attribute_array = array();
                if($product_draft_result->attribute != null) {
                    foreach (\Opis\Closure\unserialize($product_draft_results->attribute) as $attribute_id => $attribute_find_array) {
                        // dd(\Opis\Closure\unserialize($product_draft_results->attribute));
                        foreach ($attribute_find_array as $attribute_name => $terms_array) {
                            //  dd($terms_array);
                            foreach ($terms_array as $index => $terms) {
                                // dd($terms);
                                $attribute_array[$attribute_id][] = ["id" => $terms["attribute_term_id"] ?? '', 'variation' => $attribute_name ?? '',  'name' => $terms["attribute_term_name"] ?? '', 'attribute_id' => $attribute_id ?? ''];
                            }
                        }
                    }
                }

                // echo '<pre>';
                // print_r($attribute_array);
                // exit();


                $cartesian_attributes = $this->cartesian($attribute_array);
                // dd($cartesian_attributes);
                $temp = [];
                $productVariation = [];
                $product_variation_combination_attribute_array = [];
                //dd($product_draft_with_variation_result);
                if ($product_draft_with_variation_result->ProductVariations->first()) {
                    // dd($product_draft_with_variation_result->ProductVariations->first());
                    foreach ($product_draft_with_variation_result->ProductVariations as $index => $productVariation) {
                        // dd($product_draft_with_variation_result->ProductVariations);
                        // dd($productVariation);
                        $product_variation1 = '';
                        $product_variation2 = '';

                        if($productVariation->attribute != null) {
                            foreach (\Opis\Closure\unserialize($productVariation->attribute) as $attribute) {
                                // dd($attribute);
                                $temp[$attribute["attribute_id"]] = ['name' => $attribute["terms_name"]];
                                $product_variation1 .= '<div>
                                                                <select name="attribute['.$attribute['attribute_id'].'][]" id="a'.$attribute['attribute_id'].''.$index.'" class="form-control-attribute'.$index.'">
                                                                    <option selected="selected" value="'.$attribute['terms_id'].'">'.$attribute['terms_name'].'</option>
                                                                </select>
                                                            </div>';
                                $product_variation2 .= '<span class="modified-variation'.$index.'">
                                                                <label>
                                                                    <b class="variation-color">'.$attribute['attribute_name'].'</b> <i aria-hidden="true" class="fas fa-long-arrow-alt-right"></i> <span class="terms-name">'.$attribute['terms_name'].',</span>
                                                                </label>
                                                            </span>';

                            }
                        }


                        if(isset($productVariation->image)){
                            $variation_image = '<a href="'.$productVariation->image.'" target="_blank"><img src="'.$productVariation->image.'" class="img-thumbnail"></a>';
                        }else {
                            $variation_image = '<img src="'.url('assets/common-assets/no_image.jpg').'" class="thumb-md" title="No image available" alt="catalogue-image">';
                        }


                        // dd($description_show);
                        // dd($index);
                        $productVariationSku = $productVariation->sku ?? '';
                        $productVariationEan = $productVariation->ean_no ?? '';
                        $productVariationDescription =  $productVariation->description ?? '';

                        if(Session::get('woocommerce') == 1){
                            $description_show = '<td class="" style="text-align: center !important; width: 10%;">
                            <a id="addDescription'.$index.'" class="add-description text-center btn btn-primary" onclick="addDescription('.$index.')">Add Description</a>
                            <div id="categoryModal'.$index.'" class="add-description-modal" style="display: none;">
                                <div class="cat-header">
                                    <div>
                                        <label id="label_name" class="cat-label">Add Description</label>
                                    </div>
                                    <div class="cursor-pointer" onclick="hideModal('.$index.')"><i aria-hidden="true" class="fa fa-close"></i></div>
                                </div>
                                <div class="cat-body">
                                    <div class="cat-input-div">
                                        <textarea name="description[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" class="form-control summernote">'.$productVariationDescription.'</textarea>
                                    </div>
                                    <div class="cat-modal-footer">
                                        <div class="trash-div" onclick="hideModal('.$index.')">Cancel</div>
                                        <div class="cat-add">
                                            <button type="button" onclick="saveDescription('.$index.')" class="btn btn-default category-subBtn mb-3"> Save </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>';
                        }
                        $description_show = $description_show ?? '';

                        $product_variation_combination_attribute_array[] = ['<tr id="cardId'.$index.'" class="tr-variation onloadMno old-add-pro-highlight">
                                    <td style="text-align: center !important; width: 5%;">
                                        <input type="checkbox" class="selectVariation">
                                        <input type="hidden" name="product_variation_id[]" value="'.$productVariation->id.'">
                                        <input type="hidden" class="created-product" name="product_variation_updated_id[]" value="0">
                                    </td>
                                    <td style="display: none;">
                                        '.$product_variation1.'
                                    </td>
                                    <td class="variation" style="text-align: left !important; width: 10%;">
                                        '.$product_variation2.'
                                    </td>
                                    <td class="image" style="text-align: center !important; width: 6%;">
                                        '.$variation_image.'
                                    </td>
                                    <td class="sku" style="text-align: center !important;">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button type="button" id="buttonid'.$index.'" onclick="generate_sku(this)" class="btn btn-primary generate-sku">Generate SKU</button>
                                        </div>
                                        <input type="text" onfocusin="inputFocusInValue(this)" oninput="nospaces(this)" name="sku[]" value="'.$productVariationSku.'" required="required" data-parsley-maxlength="30" id="sku'.$index.'" placeholder="" class="blank_all form-control-sku_class ap-input-css text-center">
                                        <span class="text-red"></span>
                                    </td>
                                    <td class="ean" style="text-align: center !important; width: 15%;">
                                        <input type="text" name="ean_no[]" onfocusin="inputFocusInValue(this)" oninput="preventDefault(this,'.$index.')" value="'.$productVariationEan.'" maxlength="13" pattern="[0-9]{13}" id="ean_no'.$index.'" class="ean_class ap-input-css text-center" style="width: 115px;">
                                        <span id="ean_no_exist_msg'.$index.'"></span>
                                    </td>
                                    <td class="regular-price" style="text-align: center !important; width: 8%;">
                                        <input type="text" name="regular_price[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" value="'.$productVariation->regular_price.'" required="required" data-parsley-maxlength="30" id="regular_price'.$index.'" class="regular-price text-center ap-input-css" style="width: 70px;">
                                    </td>
                                    <td class="sale-price" style="text-align: center !important; width: 8%;">
                                        <input type="text" name="sale_price[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" value="'.$productVariation->sale_price.'" required="required" data-parsley-maxlength="30" id="sale_price'.$index.'" class="sale-price text-center ap-input-css" style="width: 70px;">
                                    </td>
                                    <td class="rrp" style="text-align: center !important; width: 8%;">
                                        <input type="text" name="rrp[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" data-parsley-maxlength="30" id="" value="'.$productVariation->rrp.'" class="rrp text-center ap-input-css" style="width: 70px;">
                                    </td>
                                    <td class="base-price" style="text-align: center !important; width: 8%;">
                                        <input type="text" name="base_price[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" value="'.$productVariation->base_price.'" data-parsley-maxlength="30" id="" class="base-price text-center ap-input-css" style="width: 70px;">
                                    </td>
                                    <td class="cost-price" style="text-align: center !important; width: 8%;">
                                        <input type="text" name="cost_price[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" value="'.$productVariation->cost_price.'" data-parsley-maxlength="30" id="" class="cost-price text-center ap-input-css" style="width: 70px;">
                                    </td>
                                    <td class="low-qty" style="text-align: center !important; width: 10%;">
                                        <input type="text" name="low_quantity[]" onfocusin="inputFocusInValue(this)" oninput="inputKeyUpValue(this)" value="'.$productVariation->low_quantity.'" data-parsley-maxlength="30" id="" class="low-qty text-center ap-input-css" style="width: 50px;">
                                    </td>
                                    '.$description_show.'
                                    <td style="text-align: center !important; width: 5%;">

                                    </td>
                                </tr>'];
                        // dd($temp);
                        $attribute1[] = $temp;
                        // dd($temp);


                    }


                    // dd($temp);

                    //    dd($product_variation_combination_attribute_array);

                    if(count($attribute1) > 0) {
                        foreach ($attribute1 as $attribute_values) {
                            foreach ($cartesian_attributes as $cartesian_attribute_index => $cartesian_attribute) {
                                $this->index = 0;
                                $this->counter = 0;
                                foreach ($cartesian_attribute as $key => $value) {
                                    if (isset($attribute_values[$value['attribute_id']]['name'])) {
                                        if ($attribute_values[$value['attribute_id']]['name'] == $value['name']) {
                                            $this->counter++;
                                        }
                                    }
                                    $this->index++;
                                }
                                if ($this->index == $this->counter) {
                                    unset($cartesian_attributes[$cartesian_attribute_index]);
                                }
                            }
                        }
                    }

                    // dd($this->counter);

                    // $attribute_array = null;
                    // if(count($cartesian_attributes) > 0) {
                    //     foreach ($cartesian_attributes as $cartesian_attribute) {
                    //         foreach ($cartesian_attribute as $key => $value) {
                    //             $attribute_array [$key][] = [
                    //                 'id' => $value['id'],
                    //                 'name' => $value['name'],
                    //             ];
                    //             $attribute_array[$key] = array_unique($attribute_array [$key], SORT_REGULAR);
                    //         }
                    //     }
                    // }
                }
                $ebayExistProduct = EbayMasterProduct::where('master_product_id',$id)->first();
                // dd($ebayExistProduct);

                $cartesian_attributes = array_values($cartesian_attributes);
                //  dd($cartesian_attributes);
                $combination_attribute_array = [];
                $new_combination_attributes = [];
                $only_combination_array = [];
                $existCount = 0;
                $totlaExistCount = 0;
                foreach($cartesian_attributes as $index => $combination){
                    //dd($combination);
                    $variation1 = '';
                    $variation2 = '';
                    $variation_combination = '';

                    $existCount = count($product_variation_combination_attribute_array) + $index;
                    $totlaExistCount = count($product_variation_combination_attribute_array);


                    foreach($combination as $attribute_id => $attribute_list){
                        $variation_combination .= $attribute_list['variation'].'::'.$attribute_list['name'].',';
                        $variation1 .= '<div>
                                                <select name="attribute['.$attribute_list['attribute_id'].'][]" id="a'.$attribute_list['attribute_id'].''.$existCount.'" class="form-control-attribute'.$existCount.'">
                                                    <option selected="selected" value="'.$attribute_list['id'].'">'.$attribute_list['name'].'</option>
                                                </select>
                                            </div>';
                        $variation2 .= '<span class="modified-variation'.$existCount.'">
                                                <label>
                                                    <b class="variation-color">'.$attribute_list['variation'].'</b> <i aria-hidden="true" class="fas fa-long-arrow-alt-right"></i> <span class="terms-name">'.$attribute_list['name'].',</span>
                                                </label>
                                            </span>';
                    }
                    // dd($variation_combination);
                    // dd($variation_combination);
                    // dd($attribute_list);
                    // dd($attribute_list['name']);

                    if(Session::get('woocommerce') == 1){
                        $description_show2 = '<td class="description" style="text-align: center !important; width: 10%;">
                        <a id="addDescription'.$existCount.'" class="add-description text-center btn btn-primary" onclick="addDescription('.$existCount.')">Add Description</a>
                        <div id="categoryModal'.$existCount.'" class="add-description-modal" style="display: none;">
                            <div class="cat-header">
                                <div>
                                    <label id="label_name" class="cat-label">Add Description</label>
                                </div>
                                <div class="cursor-pointer" onclick="hideModal('.$existCount.')"><i aria-hidden="true" class="fa fa-close"></i></div>
                            </div>
                            <div class="cat-body">
                                <div class="cat-input-div">
                                    <textarea name="description[]" class="form-control summernote"></textarea>
                                </div>
                                <div class="cat-modal-footer">
                                    <div class="trash-div" onclick="hideModal('.$existCount.')">Cancel</div>
                                    <div class="cat-add">
                                        <button type="button" onclick="saveDescription('.$existCount.')" class="btn btn-default category-subBtn mb-3"> Save </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>';
                    }
                    $description_show2 = $description_show2 ?? '';

                    $only_combination_array[] = [$variation_combination];
                    $combination_attribute_array[$existCount] = ['<tr id="cardId'.$existCount.'" class="tr-variation mno">
                            <td style="text-align: center !important; width: 5%;">
                                <input type="checkbox" class="selectVariation">
                                <input type="hidden" name="product_variation_id[]" value="new">
                                <input type="hidden" class="created-product" name="product_variation_updated_id[]" value="1">
                            </td>
                            <td style="display: none;">
                                '.$variation1.'
                            </td>
                            <td class="variation" style="text-align: left !important; width: 10%;">
                                '.$variation2.'
                            </td>
                            <td class="image" style="text-align: center !important; width: 6%;"></td>
                            <td class="sku" style="text-align: center !important;">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" id="buttonid'.$existCount.'" onclick="generate_sku(this)" class="btn btn-primary generate-sku">Generate SKU</button>
                                </div>
                                <input type="text" oninput="nospaces(this)" name="sku[]" value="" required="required" data-parsley-maxlength="30" id="sku'.$existCount.'" placeholder="" class="blank_all form-control-sku_class ap-input-css text-center">
                                <span class="text-red"></span>
                            </td>
                            <td class="ean" style="text-align: center !important; width: 15%;">
                                <input type="text" name="ean_no[]" oninput="preventDefault('.$existCount.')" maxlength="13" pattern="[0-9]{13}" id="ean_no'.$existCount.'" class="ean_class ap-input-css text-center" style="width: 115px;">
                                <span id="ean_no_exist_msg'.$existCount.'"></span>
                            </td>
                            <td class="regular-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="regular_price[]" value="'.$product_draft_result->regular_price.'" required="required" data-parsley-maxlength="30" id="regular_price'.$existCount.'" class="regular-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="sale-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="sale_price[]" value="'.$product_draft_result->sale_price.'" required="required" data-parsley-maxlength="30" id="sale_price'.$existCount.'" class="sale-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="rrp" style="text-align: center !important; width: 8%;">
                                <input type="text" name="rrp[]" data-parsley-maxlength="30" id="" value="'.$product_draft_result->rrp.'" class="rrp text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="base-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="base_price[]" value="'.$product_draft_result->base_price.'" data-parsley-maxlength="30" id="" class="base-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="cost-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="cost_price[]" value="'.$product_draft_result->cost_price.'" data-parsley-maxlength="30" id="" class="cost-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="low-qty" style="text-align: center !important; width: 10%;">
                                <input type="text" name="low_quantity[]" value="'.$product_draft_result->low_quantity.'" data-parsley-maxlength="30" id="" class="low-qty text-center ap-input-css" style="width: 50px;">
                            </td>
                            '.$description_show2.'
                            <td style="text-align: center !important; width: 5%;">
                                <div onclick="removeVariation(this)" class="remove-variation">
                                    <i aria-hidden="true" class="fa fa-close"></i>
                                </div>
                            </td>
                        </tr>'];

                    $new_combination_attributes[] = ['<tr id="cardId'.$existCount.'" class="tr-variation mno">
                            <td style="text-align: center !important; width: 5%;">
                                <input type="checkbox" class="selectVariation">
                                <input type="hidden" name="product_variation_id[]" value="new">
                                <input type="hidden" class="created-product" name="product_variation_updated_id[]" value="1">
                            </td>
                            <td style="display: none;">
                                '.$variation1.'
                            </td>
                            <td class="variation" style="text-align: left !important; width: 10%;">
                                '.$variation2.'
                            </td>
                            <td class="image" style="text-align: center !important; width: 6%;"></td>
                            <td class="sku" style="text-align: center !important;">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" id="buttonid'.$existCount.'" onclick="generate_sku(this)" class="btn btn-primary generate-sku">Generate SKU</button>
                                </div>
                                <input type="text" oninput="nospaces(this)" name="sku[]" value="" required="required" data-parsley-maxlength="30" id="sku'.$existCount.'" placeholder="" class="blank_all form-control-sku_class ap-input-css text-center">
                                <span class="text-red"></span>
                            </td>
                            <td class="ean" style="text-align: center !important; width: 15%;">
                                <input type="text" name="ean_no[]" oninput="preventDefault('.$existCount.')" maxlength="13" pattern="[0-9]{13}" id="ean_no'.$existCount.'" class="ean_class ap-input-css text-center" style="width: 115px;">
                                <span id="ean_no_exist_msg'.$existCount.'"></span>
                            </td>
                            <td class="regular-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="regular_price[]" value="'.$product_draft_result->regular_price.'" required="required" data-parsley-maxlength="30" id="regular_price'.$existCount.'" class="regular-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="sale-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="sale_price[]" value="'.$product_draft_result->sale_price.'" required="required" data-parsley-maxlength="30" id="sale_price'.$existCount.'" class="sale-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="rrp" style="text-align: center !important; width: 8%;">
                                <input type="text" name="rrp[]" data-parsley-maxlength="30" id="" value="'.$product_draft_result->rrp.'" class="rrp text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="base-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="base_price[]" value="'.$product_draft_result->base_price.'" data-parsley-maxlength="30" id="" class="base-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="cost-price" style="text-align: center !important; width: 8%;">
                                <input type="text" name="cost_price[]" value="'.$product_draft_result->cost_price.'" data-parsley-maxlength="30" id="" class="cost-price text-center ap-input-css" style="width: 70px;">
                            </td>
                            <td class="low-qty" style="text-align: center !important; width: 10%;">
                                <input type="text" name="low_quantity[]" value="'.$product_draft_result->low_quantity.'" data-parsley-maxlength="30" id="" class="low-qty text-center ap-input-css" style="width: 50px;">
                            </td>
                            '.$description_show2.'
                            <td style="text-align: center !important; width: 5%;">
                                <div onclick="removeVariation(this)" class="remove-variation">
                                    <i aria-hidden="true" class="fa fa-close"></i>
                                </div>
                            </td>
                        </tr>'];


                }

                // dd($only_combination_array);
                // dd($cartesian_attributes);
                // dd($combination_attribute_array);





                $content = view('product_variation.catalogue_product', compact('attributeTermImageArray','attribute_array', 'product_draft_result', 'cartesian_attributes','ebayExistProduct','attribute_info','attribute_terms','productVariationExist','existAttr','id','combination_attribute_array','only_combination_array','product_variation_id','product_variation_combination_attribute_array','productVariation','totlaExistCount','existCount','new_combination_attributes'));
                return view('master', compact('content'));
            }
        }
        // }catch (\Exception $exception){
        //     return $exception->getMessage();
        // }
    }
    /*
    * Function : cartesian (inherited function from catalogueProduct)
    * Route :
    * parameters: $input (attribute terms array)
    * Request Type :
    * Creator :
    * Modifier : Kazol
    * Description : This function is used for showing the available variation product (not crated yet) to the master catalogue
    * Created Date: unknown
    * Modified Date : 17-11-2020
    * Modified Content : check the empty array and give isset value to it
    */
    function cartesian($attributeSet) {

        if (!$attributeSet) {
            return array(array());
        }

        $subset = array_shift($attributeSet);
        $cartesianSubset = self::cartesian($attributeSet);

        $result = array();
        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }

        return $result;

        // $result = array();
        // if(count($input) > 0) {
        //     foreach ($input as $key => $values) {
        //         // If a sub-array is empty, it doesn't affect the cartesian product
        //         if (empty($values)) {
        //             continue;
        //         }
        //         // Seeding the product array with the values from the first sub-array
        //         if (empty($result)) {
        //             foreach ($values as $value) {
        //                 $result[] = array($key => $value);
        //             }
        //         } else {
        //             // Second and subsequent input sub-arrays work like this:
        //             //   1. In each existing array inside $product, add an item with
        //             //      key == $key and value == first item in input sub-array
        //             //   2. Then, for each remaining item in current input sub-array,
        //             //      add a copy of each existing array inside $product with
        //             //      key == $key and value == first item of input sub-array

        //             // Store all items to be added to $product here; adding them
        //             // inside the foreach will result in an infinite loop
        //             $append = array();

        //             foreach ($result as &$product) {
        //                 // Do step 1 above. array_shift is not the most efficient, but
        //                 // it allows us to iterate over the rest of the items with a
        //                 // simple foreach, making the code short and easy to read.
        //                 $product[$key] = array_shift($values);

        //                 // $product is by reference (that's why the key we added above
        //                 // will appear in the end result), so make a copy of it here
        //                 $copy = $product;

        //                 // Do step 2 above.
        //                 foreach ($values as $item) {
        //                     $copy[$key] = $item;
        //                     $append[] = $copy;
        //                 }

        //                 // Undo the side effecst of array_shift
        //                 array_unshift($values, $product[$key]);
        //             }

        //             // Out of the foreach, we can add to $results now
        //             $result = array_merge($result, $append);
        //         }
        //     }
        // }

        // return $result;
    }
    /*
     * Function : multipleProductAdd
     * Route : multiple-product-add
     * parameters:
     * Request : post
     * Creator : Mahfuzhur, Kazol
     * Modifier : Mahfuzhur, Kazol
     * Description : This function is used for adding variation in multiple channel from master catalogue
     * Created Date: unknown
     * Modified Date : 18-11-2020
     * Modified Content : isset error check and error exception handle
     */
    public function multipleProductAdd(Request $request)
    {

//        try {
    //    echo "<pre>";
    //    print_r($request->all());
    //    exit();

        set_time_limit(5000);
        if ($request->sku != null) {

            $commonImageUrl = '';
            if ($request->common_attribute_image == 1 && $request->hasFile('common_image')) {
                $image = $request->common_image;
                $name = $request->product_draft_id . '-' . str_replace([' ', ':', '%'], '-', Carbon::now()->toDateTimeString()) . '-';
                $name .= str_replace(' ', '-', $image->getClientOriginalName());
                $image->move('assets/images/product_variation/', $name);
                $commonImageUrl = 'assets/images/product_variation/' . $name;
            }
            $serializeAllVariationImages = [];
            $serializeVariationImages = [];

            $count = 0;
            $all_sku_count = [];
            foreach ($request->sku as $value) {
                $count++;
                $all_sku_count = [$count];
            }
            $all_sku_count = $all_sku_count[0] ?? 0;

            $data = ProductVariation::where('product_draft_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->get();
            $exist_count = 0;
            $exist_sku_count = [];
            foreach ($data as $value) {
                $exist_count++;
                $exist_sku_count = [$exist_count];
            }
            $exist_sku_count = $exist_sku_count[0] ?? 0;
            if(!$request->attribute_variation){
                $getImageAttributeFirst = ProductVariation::where('product_draft_id',$request->product_draft_id)->where('image_attribute','!=',null)->first();
                if($getImageAttributeFirst){
                    $imgAttribute = array_key_first(unserialize(json_decode($getImageAttributeFirst)->image_attribute));
                    $attributeInfo = Attribute::where('attribute_name',$imgAttribute)->first();
                    if($attributeInfo){
                        $request['attribute_variation'] = $attributeInfo->id.'/'.$imgAttribute;
                    }
                }
            }
            $product_variation_update_array = array();
            $product_variation_update_array = $request->product_variation_updated_id;
            // foreach ($request->sku = str_replace(' ', '_', $request->sku) as $key => $value) {
//                if ($request->update_image){
//                    $product_variation_update_array[0] = 1;
//                }

            foreach ($request->product_variation_id as $key => $value) {
                // dd($value);
                $alreadyExistVariationInfo = ProductVariation::where('id', $request->product_variation_id[$key])->first();
                $variationWithoutAttribute = $alreadyExistVariationInfo;
                // dd($alreadyExistVariationInfo);
                // dd($request->product_variation_id[$key]);
//                if (!$alreadyExistVariationInfo) {


                if ($product_variation_update_array[$key]) {
                    $name_value = '';
                    $name_value_array = array();
                    $attribute_value = array();
                    $attribute = '';
                    $variations = '';
                    $variation_specifics = array();
                    $woo_attributes = [];
                    $variation_data = [];
                    if ($request->attribute != null) {
                        foreach ($request->attribute as $attribute_id => $trems_id) {
                            $attribute_value[] =
                                ["attribute_id" => $attribute_id ?? '',
                                    "attribute_name" => Attribute::find($attribute_id)->attribute_name ?? '',
                                    "terms_id" => $trems_id[$key] ?? '',
                                    "terms_name" => AttributeTerm::find($trems_id[$key])->terms_name ?? ''
                                ];
                            $woo_attributes[] = [
                                'id' => $attribute_id ?? '',
                                'option' => AttributeTerm::find($trems_id[$key])->terms_name ?? ''
                            ];
                            $attribute .= '<NameValueList>
						<Name>' . Attribute::find($attribute_id)->attribute_name . '</Name>
						<Value>' . AttributeTerm::find($trems_id[$key])->terms_name . '</Value>
					</NameValueList>';
                            $variation_specifics[Attribute::find($attribute_id)->attribute_name ?? ''] = AttributeTerm::find($trems_id[$key])->terms_name ?? '';
                        }
                    }
                    $attribute_value_serialize = \Opis\Closure\serialize($attribute_value);

                    $variation_find = ProductVariation::where([['product_draft_id', $request->product_draft_id], ['attribute', $attribute_value_serialize]])->get()->first();

                    if ($request->product_draft_id != null) {
//                        if (empty($variation_find)) {
                            try {
                                $imageUrl = '';
                                if ($commonImageUrl != '') {
                                    $imageUrl = $commonImageUrl;
                                } elseif (isset($request->variation_image[$key])) {
                                    $image = $request->variation_image[$key];
                                    $name = $request->product_draft_id . '-' . str_replace([' ', ':', '%'], '-', Carbon::now()->toDateTimeString()) . '-';
                                    $name .= str_replace(' ', '-', $image->getClientOriginalName());
                                    $image->move('assets/images/product_variation/', $name);
                                    $imageUrl = 'assets/images/product_variation/' . $name;
                                }

                                $attribute_and_terms = null;
                                if ($request->attribute_variation != null) {
                                    $attributeInfo = explode('/', $request->attribute_variation);
                                    $termId = $request->attribute[$attributeInfo[0]][$key];
                                    $terms = AttributeTerm::find($termId)->terms_name;
                                    $attribute_and_terms = [
                                        $attributeInfo[1] => $terms
                                    ];
                                    if (isset($request->newUploadImage[$termId])) {
                                        if (array_key_exists($termId, $serializeAllVariationImages)) {
                                            $serializeVariationImages = $serializeAllVariationImages[$termId];
                                        } else {
                                            $serializeVariationImages = [];
                                            $folderPath = 'assets/images/product_variation/';
                                            if (isset($request->image)) {
                                                $serializeVariationImages = [];
                                                foreach ($request->image[$termId] as $r_img) {
                                                    if (isset($request->newUploadImage[$termId][$r_img])) {
                                                        $imageName = $r_img;
                                                        $imageContent = $request->newUploadImage[$termId][$r_img];
                                                        $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                                        $serializeVariationImages[] = $folderPath . $updatedImageName;
                                                    } else {
                                                        $serializeVariationImages[] = $r_img;
                                                    }
                                                    $serializeAllVariationImages[$termId] = $serializeVariationImages;
                                                }
                                            }
                                            // foreach($request->newUploadImage[$termId] as $imageName => $imageContent){
                                            //     $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                            //     $serializeVariationImages[] = $folderPath . $updatedImageName;
                                            //     $serializeAllVariationImages[$termId] = $serializeVariationImages;
                                            // }
                                        }
                                        $imageUrl = $serializeVariationImages[0] ?? '';
                                    } else {
                                        $serializeVariationImages = [];
                                        if (isset($request->image[$termId])) {
                                            foreach ($request->image[$termId] as $r_img) {
                                                $serializeVariationImages[] = $r_img;
                                            }
                                            $serializeAllVariationImages[$key] = $serializeVariationImages;
                                            $imageUrl = $serializeVariationImages[0] ?? '';
                                        }
                                    }
                                }

                                $product_variation_result = null;
                                if ($request->product_draft_id != null && $request->product_variation_id[$key] != "new") {

                                    $data = ProductVariation::where('id', $request->product_variation_id[$key])->where('deleted_at', '=', NULL)->first();
                                    if (isset($data)) {
                                        try {
                                            $product_variation_result = ProductVariation::where('id', $request->product_variation_id[$key])->first();
                                            if($product_variation_result){
                                                $product_variation_result->update([
                                                    'image' => ($imageUrl != '') ? $imageUrl : null,
                                                    'image_attribute' => $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null,
                                                    'variation_images' => $serializeVariationImages ? \Opis\Closure\serialize($serializeVariationImages) : null,
                                                    // 'attribute' => $attribute_value_serialize ?? null,
                                                    'sku' => $request->sku[$key],
                                                    'ean_no' => $request->ean_no[$key] ?? null,
                                                    'regular_price' => $request->regular_price[$key] ?? null,
                                                    'sale_price' => $request->sale_price[$key] ?? null,
                                                    'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                    'cost_price' => $request->cost_price[$key] ?? null,
                                                    'base_price' => $request->base_price[$key],
                                                    'product_code' => $request->product_code[$key] ?? null,
                                                    'color_code' => $request->color_code[$key] ?? null,
                                                    'low_quantity' => $request->low_quantity[$key] ?? null,
                                                    'description' => empty($request->description[$key]) ? null : $request->description[$key],
                                                    'notification_status' => (isset($request->notificationStatus[$key])) ? true : false,
                                                    'manage_stock' => true
                                                ]);
                                            }

                                            // dd($request->all());

                                        } catch (Exception $exception) {
                                            return back()->with('error', $exception);
                                        }
                                    }

                                }else{
                                    $product_variation_result = ProductVariation::create(['product_draft_id' => $request->product_draft_id, 'image' => ($imageUrl != '') ? $imageUrl : null,
                                        'image_attribute' => $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null, 'variation_images' => $serializeVariationImages ? \Opis\Closure\serialize($serializeVariationImages) : null, 'attribute' => $attribute_value_serialize ?? null,
                                        'sku' => $request->sku[$key], 'ean_no' => $request->ean_no[$key] ?? null, 'regular_price' => $request->regular_price[$key] ?? null, 'sale_price' => $request->sale_price[$key] ?? null, 'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                        'cost_price' => $request->cost_price[$key] ?? null, 'base_price' => $request->base_price[$key], 'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null, 'low_quantity' => $request->low_quantity[$key] ?? null,
                                        'description' => empty($request->description[$key]) ? null : $request->description[$key], 'notification_status' => (isset($request->notificationStatus[$key])) ? true : false,
                                        'manage_stock' => true
                                    ]);
                                }

                                $imageUrl = ($imageUrl != '') ? $this->projectUrl() . $imageUrl : $imageUrl;
                                if (Session::get('woocommerce') == 1) {
                                    $woocommerce_status = WoocommerceAccount::where('status', 1)->first();
                                    if ($woocommerce_status) {
                                        $woo_variation_info = WoocommerceVariation::where('sku', $request->sku[$key])->first();
                                        if ($imageUrl != '') {
                                                $variation_data['image'] = ['src' => $imageUrl ?? ''];

                                            }
                                            $variation_data['description'] = $request->description[$key] ?? null;
                                            $variation_data['sku'] = $request->sku[$key];
                                            $variation_data['regular_price'] = $request->regular_price[$key] ?? 0.00;
                                            $variation_data['sale_price'] = $request->sale_price[$key] ?? 0.00;


                                        if (!$woo_variation_info && $request->product_variation_id[$key] == 'new') {

                                            $woo_catalogue = WoocommerceCatalogue::where('master_catalogue_id', $request->product_draft_id)->first();
                                            if ($woo_catalogue) {
                                                 if($request->product_variation_id[$key] == 'new'){
                                                     $variation_data['manage_stock'] = true;
                                                     $variation_data['stock_quantity'] = $request->actual_quantity[$key] ?? 0;
                                                     $variation_data['attributes'] = $woo_attributes ?? null;
                                                     try {
                                                         $result = Woocommerce::post("products/" . $woo_catalogue->id . "/variations", $variation_data);
                                                     } catch (HttpClientException $exception) {
                                                         return back()->with('error', $exception->getMessage());
                                                     }

                                                     $result = json_decode(json_encode($result));
                                                     WoocommerceVariation::create(['id' => $result->id, 'woocom_master_product_id' => $woo_catalogue->id,
                                                         'woocom_variation_id' => $product_variation_result->id,
                                                         'image' => $result->image->src ?? null,
                                                         'attribute' => $attribute_value_serialize ?? null,
                                                         'sku' => $request->sku[$key], 'actual_quantity' => 0,
                                                         'ean_no' => $request->ean_no[$key] ?? null, 'cost_price' => $request->cost_price[$key] ?? null,
                                                         'regular_price' => $request->regular_price[$key] ?? 0.00, 'sale_price' => $request->sale_price[$key] ?? 0.00,
                                                         'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                         'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null,
                                                         'low_quantity' => $request->low_quantity[$key] ?? null,
                                                         'description' => $request->description[$key] ?? null,
                                                         'notification_status' => (isset($request->notificationCheckbox)) ? true : false,
                                                         'manage_stock' => true
                                                     ]);
                                                 }
                                            }
                                        }else{
                                            $woo_variation_info = WoocommerceVariation::where('woocom_variation_id',$request->product_variation_id[$key])->first();
                                            if($request->product_variation_id[$key] != 'new'){
                                                if($woo_variation_info) {
                                                     try {
                                                         $result = Woocommerce::post("products/" .$woo_variation_info->woocom_master_product_id."/variations/".$woo_variation_info->id, $variation_data);
                                                     } catch (HttpClientException $exception) {
                                                         return back()->with('error', $exception->getMessage());
                                                     }
                                                     $wooUpdateInfo = WoocommerceVariation::find($woo_variation_info->id)->update([
                                                         'image' => $result['image']['src'] ?? null,
                                                         'sku' => $request->sku[$key],
                                                         'ean_no' => $request->ean_no[$key] ?? null, 'cost_price' => $request->cost_price[$key] ?? null,
                                                         'regular_price' => $request->regular_price[$key] ?? 0.00, 'sale_price' => $request->sale_price[$key] ?? 0.00,
                                                         'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                         'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null,
                                                         'low_quantity' => $request->low_quantity[$key] ?? null,
                                                         'description' => $request->description[$key] ?? null
                                                     ]);
                                                 }
                                            }
                                        }
                                    }
                                }

                                if (Session::get('onbuy') == 1) {
                                    $isActive = $this->isOnbuyActiveFromAccount();
                                    if ($isActive) {
                                        if($alreadyExistVariationInfo) {
                                            $onbuyVariationInfo = $this->getVariationInfo($alreadyExistVariationInfo->sku,'sku'); // see on onbuy trait
                                            if($onbuyVariationInfo) {
                                                $checkUpdatableSkuExist = $this->getVariationInfo($request->sku[$key],'updated_sku'); // see on onbuy trait
                                                if(!$checkUpdatableSkuExist && $request->product_variation_id[$key] != 'new') {
                                                    $onbuyVariationInfo->updated_sku = $request->sku[$key];
                                                    $onbuyVariationInfo->save();
                                                }
                                            }else {
                                                $onbuyVariationInfo = $this->getVariationInfo($alreadyExistVariationInfo->sku,'updated_sku');
                                                if($onbuyVariationInfo) {
                                                    $checkUpdatableSkuExist = $this->getVariationInfo($request->sku[$key],'updated_sku'); // see on onbuy trait
                                                    if(!$checkUpdatableSkuExist && $request->product_variation_id[$key] != 'new') {
                                                        if($onbuyVariationInfo->sku != $request->sku[$key]){
                                                            $onbuyVariationInfo->updated_sku = $request->sku[$key];
                                                        }else {
                                                            $onbuyVariationInfo->updated_sku = null;
                                                        }
                                                        $onbuyVariationInfo->save();
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                if (Session::get('ebay') == 1) {
                                    $ebay_status = DeveloperAccount::where('status', 1)->first();
                                    if ($ebay_status) {

                                        $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->first();

                                        if ($ebay_master_product_result != null && $product_variation_result != null) {
                                            $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->get();

                                            $product_draft = ProductDraft::find($request->product_draft_id);
                                            $custom_label = null;

                                            if ($product_draft->attribute != null) {
                                                foreach (\Opis\Closure\unserialize($product_draft->attribute) as $attribute_id => $attribute_array) {
                                                    foreach ($attribute_array as $attribute_name => $terms_array) {

                                                        $name_value .= '<NameValueList>
                                                    <Name>' . $attribute_name . '</Name>';

                                                        foreach ($terms_array as $terms) {
                                                            if (!in_array($terms["attribute_term_name"], $name_value_array)) {
                                                                array_push($name_value_array, $terms["attribute_term_name"]);
                                                                $name_value .= '<Value>' . $terms["attribute_term_name"] . '</Value>';
//                                                            $variation_specifics[$attribute_name] = $terms["attribute_term_name"];
                                                            }
                                                        }
                                                        $name_value .= '</NameValueList>';
                                                    }
                                                }
                                            }
                                            $picture = '';
                                            $master_product_images = '';
                                            if ($imageUrl != '') {
//                                                    $attributeInfo = explode('/', $request->ebayImageAttribute);
//                                                    $terms = $request->attribute[$attributeInfo[0]][$key];
//                                                    $picture = '<Pictures>
//                                                <VariationSpecificName>' . $attributeInfo[1] . '</VariationSpecificName>
//                                                <VariationSpecificPictureSet>'
//                                                        . '<VariationSpecificValue>' . $terms . '</VariationSpecificValue>'
//                                                        . '<PictureURL>' . $imageUrl . '</PictureURL>'
//                                                        . '</VariationSpecificPictureSet>
//                                            </Pictures>';
                                                $picture = $this->getImageVariation($request->product_draft_id);
                                                $master_product_images = $this->getMasterProductImagesXml($request->product_draft_id);
                                            }

                                            $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                                            if (count($ebay_master_product_result) > 0) {
                                                foreach ($ebay_master_product_result as $product) {
                                                    $variations = "";
                                                    $quantity = "";
                                                    if ($request->product_variation_id[$key] == "new"){
                                                        $quantity = '<Quantity>0</Quantity>';
                                                    }
                                                    $ean = $request->ean_no[$key] ?? 'Does not apply';
                                                    $variations .= '<Variation>
                                                    <SKU>' . '<![CDATA[' . $request->sku[$key] . ']]>' . '</SKU>


                                                <StartPrice>' . $request->sale_price[$key] . '</StartPrice>
                                                '.$quantity.'
                                                <VariationProductListingDetails>
                                                <EAN>' . $ean . '</EAN>

                                                </VariationProductListingDetails>
                                                <VariationSpecifics>'
                                                        . $attribute . '
                                                </VariationSpecifics>
                                            </Variation>';
                                                    if($product_draft->type == 'simple'){
                                                        $custom_label = "<SKU>".$request->sku[$key]."</SKU>";
                                                    }
                                                    $account_result = EbayAccount::find($product->account_id);
                                                    if ($account_result) {
                                                        $this->ebayAccessToken($account_result->refresh_token);
                                                    } else {
                                                        $this->ebay_update_access_token = '';
                                                    }
                                                    $url = 'https://api.ebay.com/ws/api.dll';
                                                    $headers = [
                                                        'X-EBAY-API-SITEID:' . $product->site_id,
                                                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                        'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                        'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                                                    ];
                                                    if($product_draft->type == 'simple'){
                                                        $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                                                                        you want to add new variations to -->
                                                                        <ItemID>' . $product->item_id . '</ItemID>
                                                                        '.$master_product_images.$custom_label.'
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
                                                    }else{
                                                        $body = '<?xml version="1.0" encoding="utf-8"?>
                                                                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                                                        <ErrorLanguage>en_US</ErrorLanguage>
                                                                        <WarningLevel>High</WarningLevel>
                                                                      <Item>
                                                                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                                                                        you want to add new variations to -->
                                                                        <ItemID>' . $product->item_id . '</ItemID>
                                                                        '.$master_product_images.$custom_label.'
                                                                        <Variations>
                                                                           <VariationSpecificsSet>
                                                                            ' . $name_value . '
                                                                            </VariationSpecificsSet>
                                                                            ' . $variations . '
                                                                            ' . $picture . '


                                                                        </Variations>
                                                                      </Item>
                                                                    </ReviseFixedPriceItemRequest>';
                                                    }

                                                    $update_ebay_product = $this->curl($url, $headers, $body, 'POST');

                                                    if ($request->product_variation_id[$key] == "new"){
                                                        $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $product->id, 'master_variation_id' => $product_variation_result->id,
                                                            'sku' => $request->sku[$key], 'variation_specifics' => $variation_specifics, 'start_price' => $request->sale_price[$key] ?? 0.00, 'rrp' => $request->regular_price[$key] ?? null,
                                                            'ean' => $request->ean_no[$key] ?? null]);
                                                    }else{
                                                        $product_variation_result = EbayVariationProduct::where('master_variation_id', $request->product_variation_id[$key])->first();
                                                        if (isset($product_variation_result)){
                                                            $product_variation_result->update([
                                                                'sku' => $request->sku[$key], 'variation_specifics' => $variation_specifics, 'start_price' => $request->sale_price[$key] ?? 0.00, 'rrp' => $request->regular_price[$key] ?? null,
                                                                'ean' => $request->ean_no[$key] ?? null
                                                            ]);
                                                        }
                                                    }

                                                }
                                            }
                                        }
                                    }
                                }

                            } catch (Exception $exception) {
                                return back()->with('error', $exception);
                            }

//                        }

                    } else {
                        return back()->with('success', 'this variation is already available ');
                    }
                }

            }
        }




        if($all_sku_count == $exist_sku_count){
            return back()->with('updated_success', 'Product updated successfully.');
        }else {
            return redirect('catalogue-product-invoice-receive/' . $request->product_draft_id)
                ->with('new_product_success', 'Product created successfully.');
        }



//        }catch (\Exception $exception){
//            return redirect('exception')->with('exception',$exception->getMessage());
//        }
    }


    public function manage_variation_sku_validation(Request $request){
        // dd($request->all());
        if($request->multiple_sku_validation){
            $sku_array = [];
            foreach ($request->sku as $value) {
                $product_variation_sku_check = ProductVariation::where('sku', $value)->first();
                if(isset($product_variation_sku_check)){
                    $sku_array[] = $product_variation_sku_check->sku;
                }
            }
            return response()->json(['sku_array' => $sku_array]);
        }else {
            $product_variation_single_sku_check = ProductVariation::where('sku', $request->sku)->first();
            if(isset($product_variation_single_sku_check)){
                return response()->json(['sku' => $product_variation_single_sku_check->sku]);
            }
        }
    }

    

    public function _multipleProductAdd(Request $request)
    {

//        try {

            echo "<pre>";
            print_r($request->all());
            exit();
            set_time_limit(5000);
            if ($request->sku != null) {

                $commonImageUrl = '';
                if ($request->common_attribute_image == 1 && $request->hasFile('common_image')) {
                    $image = $request->common_image;
                    $name = $request->product_draft_id . '-' . str_replace([' ', ':', '%'], '-', Carbon::now()->toDateTimeString()) . '-';
                    $name .= str_replace(' ', '-', $image->getClientOriginalName());
                    $image->move('assets/images/product_variation/', $name);
                    $commonImageUrl = 'assets/images/product_variation/' . $name;
                }
                $serializeAllVariationImages = [];
                $serializeVariationImages = [];

                $count = 0;
                $all_sku_count = [];
                foreach ($request->sku as $value) {
                    $count++;
                    $all_sku_count = [$count];
                }
                $all_sku_count = $all_sku_count[0] ?? 0;

                $data = ProductVariation::where('product_draft_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->get();
                $exist_count = 0;
                $exist_sku_count = [];
                foreach ($data as $value) {
                    $exist_count++;
                    $exist_sku_count = [$exist_count];
                }
                $exist_sku_count = $exist_sku_count[0] ?? 0;
                if(!$request->attribute_variation){
                    $getImageAttributeFirst = ProductVariation::where('product_draft_id',$request->product_draft_id)->where('image_attribute','!=',null)->first();
                    if($getImageAttributeFirst){
                        $imgAttribute = array_key_first(unserialize(json_decode($getImageAttributeFirst)->image_attribute));
                        $attributeInfo = Attribute::where('attribute_name',$imgAttribute)->first();
                        if($attributeInfo){
                            $request['attribute_variation'] = $attributeInfo->id.'/'.$imgAttribute;
                        }
                    }
                }

                // foreach ($request->sku = str_replace(' ', '_', $request->sku) as $key => $value) {
                foreach ($request->product_variation_id as $key => $value) {
                    // dd($value);
                    $alreadyExistVariationInfo = ProductVariation::where('id', $request->product_variation_id[$key])->first();
                    $variationWithoutAttribute = $alreadyExistVariationInfo;
                    // dd($alreadyExistVariationInfo);
                    // dd($request->product_variation_id[$key]);
                    if (!$alreadyExistVariationInfo) {
                        $name_value = '';
                        $name_value_array = array();
                        $attribute_value = array();
                        $attribute = '';
                        $variations = '';
                        $variation_specifics = array();
                        $woo_attributes = [];
                        $variation_data = [];
                        if ($request->attribute != null) {
                            foreach ($request->attribute as $attribute_id => $trems_id) {
                                $attribute_value[] =
                                    ["attribute_id" => $attribute_id ?? '',
                                        "attribute_name" => Attribute::find($attribute_id)->attribute_name ?? '',
                                        "terms_id" => $trems_id[$key] ?? '',
                                        "terms_name" => AttributeTerm::find($trems_id[$key])->terms_name ?? ''
                                    ];
                                $woo_attributes[] = [
                                    'id' => $attribute_id ?? '',
                                    'option' => AttributeTerm::find($trems_id[$key])->terms_name ?? ''
                                ];
                                $attribute .= '<NameValueList>
						<Name>' . Attribute::find($attribute_id)->attribute_name . '</Name>
						<Value>' . AttributeTerm::find($trems_id[$key])->terms_name . '</Value>
					</NameValueList>';
                                $variation_specifics[Attribute::find($attribute_id)->attribute_name ?? ''] = AttributeTerm::find($trems_id[$key])->terms_name ?? '';
                            }
                        }
                        $attribute_value_serialize = \Opis\Closure\serialize($attribute_value);

                        $variation_find = ProductVariation::where([['product_draft_id', $request->product_draft_id], ['attribute', $attribute_value_serialize]])->get()->first();

                        if ($request->product_draft_id != null) {
                            if (empty($variation_find)) {
                                try {
                                    $imageUrl = '';
                                    if ($commonImageUrl != '') {
                                        $imageUrl = $commonImageUrl;
                                    } elseif (isset($request->variation_image[$key])) {
                                        $image = $request->variation_image[$key];
                                        $name = $request->product_draft_id . '-' . str_replace([' ', ':', '%'], '-', Carbon::now()->toDateTimeString()) . '-';
                                        $name .= str_replace(' ', '-', $image->getClientOriginalName());
                                        $image->move('assets/images/product_variation/', $name);
                                        $imageUrl = 'assets/images/product_variation/' . $name;
                                    }

                                    $attribute_and_terms = null;
                                    if ($request->attribute_variation != null) {
                                        $attributeInfo = explode('/', $request->attribute_variation);
                                        $termId = $request->attribute[$attributeInfo[0]][$key];
                                        $terms = AttributeTerm::find($termId)->terms_name;
                                        $attribute_and_terms = [
                                            $attributeInfo[1] => $terms
                                        ];
                                        if (isset($request->newUploadImage[$termId])) {
                                            if (array_key_exists($termId, $serializeAllVariationImages)) {
                                                $serializeVariationImages = $serializeAllVariationImages[$termId];
                                            } else {
                                                $serializeVariationImages = [];
                                                $folderPath = 'assets/images/product_variation/';
                                                if (isset($request->image)) {
                                                    $serializeVariationImages = [];
                                                    foreach ($request->image[$termId] as $r_img) {
                                                        if (isset($request->newUploadImage[$termId][$r_img])) {
                                                            $imageName = $r_img;
                                                            $imageContent = $request->newUploadImage[$termId][$r_img];
                                                            $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                                            $serializeVariationImages[] = $folderPath . $updatedImageName;
                                                        } else {
                                                            $serializeVariationImages[] = $r_img;
                                                        }
                                                        $serializeAllVariationImages[$termId] = $serializeVariationImages;
                                                    }
                                                }
                                                // foreach($request->newUploadImage[$termId] as $imageName => $imageContent){
                                                //     $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                                //     $serializeVariationImages[] = $folderPath . $updatedImageName;
                                                //     $serializeAllVariationImages[$termId] = $serializeVariationImages;
                                                // }
                                            }
                                            $imageUrl = $serializeVariationImages[0] ?? '';
                                        } else {
                                            $serializeVariationImages = [];
                                            if (isset($request->image[$termId])) {
                                                foreach ($request->image[$termId] as $r_img) {
                                                    $serializeVariationImages[] = $r_img;
                                                }
                                                $serializeAllVariationImages[$key] = $serializeVariationImages;
                                                $imageUrl = $serializeVariationImages[0] ?? '';
                                            }
                                        }
                                    }

                                    $product_variation_result = ProductVariation::create(['product_draft_id' => $request->product_draft_id, 'image' => ($imageUrl != '') ? $imageUrl : null,
                                        'image_attribute' => $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null, 'variation_images' => $serializeVariationImages ? \Opis\Closure\serialize($serializeVariationImages) : null, 'attribute' => $attribute_value_serialize ?? null,
                                        'sku' => $request->sku[$key], 'ean_no' => $request->ean_no[$key] ?? null, 'regular_price' => $request->regular_price[$key] ?? null, 'sale_price' => $request->sale_price[$key] ?? null, 'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                        'cost_price' => $request->cost_price[$key] ?? null, 'base_price' => $request->base_price[$key], 'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null, 'low_quantity' => $request->low_quantity[$key] ?? null,
                                        'description' => empty($request->description[$key]) ? null : $request->description[$key], 'notification_status' => (isset($request->notificationStatus[$key])) ? true : false,
                                        'manage_stock' => true
                                    ]);
                                    $imageUrl = ($imageUrl != '') ? $this->projectUrl() . $imageUrl : $imageUrl;
                                    if (Session::get('woocommerce') == 1) {
                                        $woocommerce_status = WoocommerceAccount::where('status', 1)->first();
                                        if ($woocommerce_status) {
                                            $woo_variation_info = WoocommerceVariation::where('sku', $request->sku[$key])->first();
                                            if ($woo_variation_info == null) {
                                                if ($imageUrl != '') {
                                                    $variation_data['image'] = ['src' => $imageUrl ?? ''];
                                                }
                                                $variation_data['description'] = $request->description[$key] ?? null;
                                                $variation_data['sku'] = $request->sku[$key];
                                                $variation_data['regular_price'] = $request->regular_price[$key] ?? 0.00;
                                                $variation_data['sale_price'] = $request->sale_price[$key] ?? 0.00;
                                                $variation_data['manage_stock'] = true;
                                                $variation_data['stock_quantity'] = $request->actual_quantity[$key] ?? 0;
                                                $variation_data['attributes'] = $woo_attributes ?? null;
                                                $woo_catalogue = WoocommerceCatalogue::where('master_catalogue_id', $request->product_draft_id)->first();
                                                if ($woo_catalogue) {
                                                    try {
                                                        $result = Woocommerce::post("products/" . $woo_catalogue->id . "/variations", $variation_data);
                                                    } catch (HttpClientException $exception) {
                                                        return back()->with('error', $exception->getMessage());
                                                    }
                                                    $result = json_decode(json_encode($result));
                                                    WoocommerceVariation::create(['id' => $result->id, 'woocom_master_product_id' => $woo_catalogue->id,
                                                        'woocom_variation_id' => $product_variation_result->id,
                                                        'image' => $result->image->src ?? null,
                                                        'attribute' => $attribute_value_serialize ?? null,
                                                        'sku' => $request->sku[$key], 'actual_quantity' => 0,
                                                        'ean_no' => $request->ean_no[$key] ?? null, 'cost_price' => $request->cost_price[$key] ?? null,
                                                        'regular_price' => $request->regular_price[$key] ?? 0.00, 'sale_price' => $request->sale_price[$key] ?? 0.00,
                                                        'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                        'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null,
                                                        'low_quantity' => $request->low_quantity[$key] ?? null,
                                                        'description' => $request->description[$key] ?? null,
                                                        'notification_status' => (isset($request->notificationCheckbox)) ? true : false,
                                                        'manage_stock' => true
                                                    ]);
                                                }
                                            }
                                        }
                                    }

                                    if (Session::get('ebay') == 1) {
                                        $ebay_status = DeveloperAccount::where('status', 1)->first();
                                        if ($ebay_status) {

                                            $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->first();

                                            if ($ebay_master_product_result != null && $product_variation_result != null) {
                                                $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->get();

                                                $product_draft = ProductDraft::find($request->product_draft_id);
                                                if ($product_draft->attribute != null) {
                                                    foreach (\Opis\Closure\unserialize($product_draft->attribute) as $attribute_id => $attribute_array) {
                                                        foreach ($attribute_array as $attribute_name => $terms_array) {

                                                            $name_value .= '<NameValueList>
                                                    <Name>' . $attribute_name . '</Name>';

                                                            foreach ($terms_array as $terms) {
                                                                if (!in_array($terms["attribute_term_name"], $name_value_array)) {
                                                                    array_push($name_value_array, $terms["attribute_term_name"]);
                                                                    $name_value .= '<Value>' . $terms["attribute_term_name"] . '</Value>';
//                                                            $variation_specifics[$attribute_name] = $terms["attribute_term_name"];
                                                                }
                                                            }
                                                            $name_value .= '</NameValueList>';
                                                        }
                                                    }
                                                }
                                                $picture = '';
                                                $master_product_images = '';
                                                if ($imageUrl != '') {
//                                                    $attributeInfo = explode('/', $request->ebayImageAttribute);
//                                                    $terms = $request->attribute[$attributeInfo[0]][$key];
//                                                    $picture = '<Pictures>
//                                                <VariationSpecificName>' . $attributeInfo[1] . '</VariationSpecificName>
//                                                <VariationSpecificPictureSet>'
//                                                        . '<VariationSpecificValue>' . $terms . '</VariationSpecificValue>'
//                                                        . '<PictureURL>' . $imageUrl . '</PictureURL>'
//                                                        . '</VariationSpecificPictureSet>
//                                            </Pictures>';
                                                    $picture = $this->getImageVariation($request->product_draft_id);
                                                    $master_product_images = $this->getMasterProductImagesXml($request->product_draft_id);
                                                }

                                                $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                                                if (count($ebay_master_product_result) > 0) {
                                                    foreach ($ebay_master_product_result as $product) {
                                                        $variations = "";
                                                        $quentity = 0;
                                                        $ean = $request->ean_no[$key] ?? 'Does not apply';
                                                        $variations .= '<Variation>
                                                    <SKU>' . '<![CDATA[' . $request->sku[$key] . ']]>' . '</SKU>


                                                <StartPrice>' . $request->sale_price[$key] . '</StartPrice>
                                                <Quantity>' . $quentity . '</Quantity>
                                                <VariationProductListingDetails>
                                                <EAN>' . $ean . '</EAN>

                                                </VariationProductListingDetails>
                                                <VariationSpecifics>'
                                                            . $attribute . '
                                                </VariationSpecifics>
                                            </Variation>';
                                                        $account_result = EbayAccount::find($product->account_id);
                                                        if ($account_result) {
                                                            $this->ebayAccessToken($account_result->refresh_token);
                                                        } else {
                                                            $this->ebay_update_access_token = '';
                                                        }
                                                        $url = 'https://api.ebay.com/ws/api.dll';
                                                        $headers = [
                                                            'X-EBAY-API-SITEID:' . $product->site_id,
                                                            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                            'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                                                        ];
                                                        $body = '<?xml version="1.0" encoding="utf-8"?>
                                            <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                                <ErrorLanguage>en_US</ErrorLanguage>
                                                <WarningLevel>High</WarningLevel>
                                              <Item>
                                                <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                                                you want to add new variations to -->
                                                <ItemID>' . $product->item_id . '</ItemID>
                                                '.$master_product_images.'
                                                <Variations>
                                                   <VariationSpecificsSet>
                                                    ' . $name_value . '
                                                    </VariationSpecificsSet>
                                                    ' . $variations . '
                                                    ' . $picture . '


                                                </Variations>
                                              </Item>
                                            </ReviseFixedPriceItemRequest>';

                                                        $update_ebay_product = $this->curl($url, $headers, $body, 'POST');

                                                        $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $product->id, 'master_variation_id' => $product_variation_result->id,
                                                            'sku' => $request->sku[$key], 'variation_specifics' => $variation_specifics, 'start_price' => $request->sale_price[$key] ?? 0.00, 'rrp' => $request->regular_price[$key] ?? null,
                                                            'ean' => $request->ean_no[$key] ?? null]);
                                                    }
                                                }
                                            }
                                        }
                                    }

                                } catch (Exception $exception) {
                                    return back()->with('error', $exception);
                                }

                            }

                        } else {
                            return back()->with('success', 'this variation is already available ');
                        }
                    }
                    else {
                        if($request->attribute_variation == null){
                            return back()->with('error','Please select image attribute from dropdown');
                        }
                        $folderPath = 'assets/images/product_variation/';
                        if ($request->attribute != null) {
                            foreach ($request->attribute as $attribute_id => $trems_id) {
                                // dd($trems_id[$key]);
                                $attribute_value[] =
                                    ["attribute_id" => $attribute_id ?? '',
                                        "attribute_name" => Attribute::find($attribute_id)->attribute_name ?? '',
                                        "terms_id" => $trems_id[$key] ?? '',
                                        "terms_name" => AttributeTerm::find($trems_id[$key])->terms_name ?? ''
                                    ];
                            }
                        }
                        $attribute_value_serialize = \Opis\Closure\serialize($attribute_value);


                        $variation_find = ProductVariation::where([['product_draft_id', $request->product_draft_id], ['attribute', $attribute_value_serialize]])->get()->first();
                        if ($request->product_draft_id != null) {

                                $data = ProductVariation::where('id', $request->product_variation_id[$key])->where('deleted_at', '=', NULL)->first();
                                if (isset($data)) {
                                    try {
                                        $product_info = ProductVariation::where('id', $request->product_variation_id[$key])->first();
                                        if($product_info){
                                            $product_info->update([
                                                // 'image' => ($imageUrl != '') ? $imageUrl : null,
                                                // 'image_attribute' => $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null,
                                                // 'variation_images' => $serializeVariationImages ? \Opis\Closure\serialize($serializeVariationImages) : null,
                                                // 'attribute' => $attribute_value_serialize ?? null,
                                                'sku' => $request->sku[$key],
                                                'ean_no' => $request->ean_no[$key] ?? null,
                                                'regular_price' => $request->regular_price[$key] ?? null,
                                                'sale_price' => $request->sale_price[$key] ?? null,
                                                'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                'cost_price' => $request->cost_price[$key] ?? null,
                                                'base_price' => $request->base_price[$key],
                                                'product_code' => $request->product_code[$key] ?? null,
                                                'color_code' => $request->color_code[$key] ?? null,
                                                'low_quantity' => $request->low_quantity[$key] ?? null,
                                                'description' => empty($request->description[$key]) ? null : $request->description[$key],
                                                'notification_status' => (isset($request->notificationStatus[$key])) ? true : false,
                                                'manage_stock' => true
                                            ]);
                                        }

                                        // dd($request->all());

                                    } catch (Exception $exception) {
                                        return back()->with('error', $exception);
                                    }
                                }

                        }

                        if ($request->product_draft_id != null) {
                            if ($request->attribute_variation != null) {
                                $attributeInfo = explode('/', $request->attribute_variation);
                                $img_attribute = $alreadyExistVariationInfo->image_attribute ? unserialize($alreadyExistVariationInfo->image_attribute) : [];
                                if (count($img_attribute) > 0) {
                                    foreach ($img_attribute as $attr) {
                                        $attr_term_id = AttributeTerm::where('terms_name', $attr)->first()->id;

                                    }
                                    $serializeVariationImages = [];
                                    if (isset($request->newUploadImage[$attr_term_id])) {
                                        if (isset($request->image[$attr_term_id])) {
                                            foreach ($request->image[$attr_term_id] as $r_img) {
                                                if (isset($request->newUploadImage[$attr_term_id][$r_img])) {
                                                    $imageName = $r_img;
                                                    $imageContent = $request->newUploadImage[$attr_term_id][$r_img];
                                                    $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                                    $serializeVariationImages[] = $folderPath . $updatedImageName;
                                                } else {
                                                    $serializeVariationImages[] = $r_img;
                                                }
                                            }
                                        }
                                    } else {

                                        if (isset($request->image[$attr_term_id])) {
                                            foreach ($request->image[$attr_term_id] as $r_img) {
                                                $serializeVariationImages[] = $r_img;
                                                $imageUrl = $serializeVariationImages[0];
                                                $alreadyExistVariationInfo->image = $imageUrl;
                                                $alreadyExistVariationInfo->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                                                $alreadyExistVariationInfo->save();
                                            }
                                            $imageUrl = $serializeVariationImages[0];
                                            $alreadyExistVariationInfo->image = $imageUrl;
                                            $alreadyExistVariationInfo->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                                            $alreadyExistVariationInfo->save();
                                        }
                                    }
                                    if(count($serializeVariationImages)> 0){
                                        $imageUrl = $serializeVariationImages[0];
                                        $alreadyExistVariationInfo->image = $imageUrl;
                                        $alreadyExistVariationInfo->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                                        $alreadyExistVariationInfo->save();
                                    }
                                } else {
                                    $termId = $request->attribute[$attributeInfo[0]][$key];
                                    $terms = AttributeTerm::find($termId)->terms_name;
                                    $attribute_and_terms = [
                                        $attributeInfo[1] => $terms
                                    ];
                                    $existVariationTermId = unserialize($alreadyExistVariationInfo->attribute)[0]['terms_id'];
                                    $serializeVariationImages = [];
                                    if (isset($request->newUploadImage[$existVariationTermId])) {
                                        if (isset($request->image[$existVariationTermId])) {
                                            foreach ($request->image[$existVariationTermId] as $r_img) {
                                                if (isset($request->newUploadImage[$existVariationTermId][$r_img])) {
                                                    $imageName = $r_img;
                                                    $imageContent = $request->newUploadImage[$existVariationTermId][$r_img];
                                                    $updatedImageName = $this->base64ToImage($request->product_draft_id, $imageName, $imageContent, $folderPath);
                                                    $serializeVariationImages[] = $folderPath . $updatedImageName;
                                                } else {
                                                    $serializeVariationImages[] = $r_img;
                                                }
                                            }
                                            $alreadyExistVariationInfo->image = $serializeVariationImages[0];
                                            $alreadyExistVariationInfo->image_attribute = $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null;
                                            $alreadyExistVariationInfo->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                                            $alreadyExistVariationInfo->save();
                                        }
                                    } else {
                                        if (isset($request->image[$existVariationTermId])) {
                                            foreach ($request->image[$existVariationTermId] as $r_img) {
                                                $serializeVariationImages[] = $r_img;
                                            }
                                            $alreadyExistVariationInfo->image = $serializeVariationImages[0];
                                            $alreadyExistVariationInfo->image_attribute = $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null;
                                            $alreadyExistVariationInfo->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                                            $alreadyExistVariationInfo->save();
                                        }
                                    }
                                }

                            }

                            if(($variationWithoutAttribute->image_attribute == null) && ($variationWithoutAttribute->variation_images == null)){
                                $attr = explode('/', $request->attribute_variation)[1];
                                $key = array_search($attr, array_column(unserialize($variationWithoutAttribute->attribute), 'attribute_name'));
                                $attribute_and_terms = [
                                    $attr => unserialize($variationWithoutAttribute->attribute)[$key]['terms_name']
                                ];
                                $variationWithoutAttribute->image = $serializeVariationImages[0] ?? null;
                                $variationWithoutAttribute->image_attribute = $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null;
                                $variationWithoutAttribute->variation_images = $serializeVariationImages ? \Opis\Closure\serialize($serializeVariationImages) : null;
                                $variationWithoutAttribute->save();
                            }
                            if (Session::get('ebay') == 1) {
                                $ebay_status = DeveloperAccount::where('status', 1)->first();
                                if ($ebay_status) {
                                    $name_value = '';
                                    $name_value_array = array();
                                    $attribute_value = array();
                                    $attribute = '';
                                    $variations = '';
                                    $variation_specifics = array();

                                    $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->where('deleted_at', '=', NULL)->first();
//                                echo "<pre>";
//                                print_r($ebay_master_product_result);
//                                exit();
                                    if ($ebay_master_product_result != null) {
                                        $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $request->product_draft_id)->get();

                                        $product_draft = ProductDraft::find($request->product_draft_id);
                                        if ($product_draft->attribute != null) {
                                            foreach (\Opis\Closure\unserialize($product_draft->attribute) as $attribute_id => $attribute_array) {
                                                foreach ($attribute_array as $attribute_name => $terms_array) {

                                                    $name_value .= '<NameValueList>
                                                    <Name>' . $attribute_name . '</Name>';

                                                    foreach ($terms_array as $terms) {
                                                        if (!in_array($terms["attribute_term_name"], $name_value_array)) {
                                                            array_push($name_value_array, $terms["attribute_term_name"]);
                                                            $name_value .= '<Value>' . $terms["attribute_term_name"] . '</Value>';
//                                                            $variation_specifics[$attribute_name] = $terms["attribute_term_name"];
                                                        }
                                                    }
                                                    $name_value .= '</NameValueList>';
                                                }
                                            }
                                        }
                                    }
                                    $picture = '';
//                                        if($imageUrl != ''){
//                                            $attributeInfo = explode('/',$request->ebayImageAttribute);
//                                            $terms = $request->attribute[$attributeInfo[0]][$key];
//                                            $picture = '<Pictures>
//                                                <VariationSpecificName>'.$attributeInfo[1].'</VariationSpecificName>
//                                                <VariationSpecificPictureSet>'
//                                                .'<VariationSpecificValue>'.$terms.'</VariationSpecificValue>'
//                                                .'<PictureURL>'.$imageUrl.'</PictureURL>'
//                                                .'</VariationSpecificPictureSet>
//                                            </Pictures>';
//                                        }

                                    $picture = $this->getImageVariation($request->product_draft_id);
                                    $master_product_images = $this->getMasterProductImagesXml($request->product_draft_id);
                                    $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                                    if (($ebay_master_product_result != null) && count($ebay_master_product_result) > 0) {
                                        foreach ($ebay_master_product_result as $product) {
                                            $variations = "";
                                            $quentity = 0;
                                            $ean = $request->ean_no[$key] ?? 'Does not apply';
                                            $variations .= '<Variation>
                                                    <SKU>' . '<![CDATA[' . $request->sku[$key] . ']]>' . '</SKU>


                                                <StartPrice>' . $request->sale_price[$key] . '</StartPrice>
                                                <Quantity>' . $quentity . '</Quantity>
                                                <VariationProductListingDetails>
                                                <EAN>' . $ean . '</EAN>

                                                </VariationProductListingDetails>
                                                <VariationSpecifics>'
                                                . $attribute . '
                                                </VariationSpecifics>
                                            </Variation>';
                                            $account_result = EbayAccount::find($product->account_id);
                                            if ($account_result) {
                                                $this->ebayAccessToken($account_result->refresh_token);
                                            } else {
                                                $this->ebay_update_access_token = '';
                                            }
                                            $url = 'https://api.ebay.com/ws/api.dll';
                                            $headers = [
                                                'X-EBAY-API-SITEID:' . $product->site_id,
                                                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                                                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                                                'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
                                            ];
                                            $body = '<?xml version="1.0" encoding="utf-8"?>
                                            <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                                <ErrorLanguage>en_US</ErrorLanguage>
                                                <WarningLevel>High</WarningLevel>
                                              <Item>
                                                <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                                                you want to add new variations to -->
                                                <ItemID>' . $product->item_id . '</ItemID>
                                                '.$master_product_images.'
                                                <Variations>

                                                    ' . $picture . '

                                                </Variations>
                                              </Item>
                                            </ReviseFixedPriceItemRequest>';


                                            $update_ebay_product = $this->curl($url, $headers, $body, 'POST');

//                                                $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $product->id, 'master_variation_id' => $product_variation_result->id,
//                                                    'sku' => $request->sku[$key], 'variation_specifics' => $variation_specifics, 'start_price' => $request->sale_price[$key] ?? 0.00, 'rrp' => $request->regular_price[$key] ?? null,
//                                                    'ean' => $request->ean_no[$key] ?? null]);
                                        }
                                    }
                                }
                            }
                            if (Session::get('woocommerce') == 1) {
                                $woocommerce_status = WoocommerceAccount::where('status', 1)->first();
                                if ($woocommerce_status) {
                                    $woo_variation_info = null;
                                    if ($request->product_draft_id != null) {
                                       if (!empty($variation_find)) {
                                            if($data){
                                                $woo_variation_info = WoocommerceVariation::where('sku', $data->sku)->first();
                                            }
                                        }
                                    }
                                    if ($woo_variation_info) {
                                        $variation_data = [];
                                        $imageUrl = $serializeVariationImages[0] ?? '';
                                        $imageUrl = ($imageUrl != '') ? $this->projectUrl() . $imageUrl : $imageUrl;
                                        if ($imageUrl != '') {
                                            $variation_data['image'] = ['src' => $imageUrl ?? ''];
                                        }
                                        $variation_data['description'] = $request->description[$key] ?? null;
                                        $variation_data['sku'] = $request->sku[$key];
                                        $variation_data['regular_price'] = $request->regular_price[$key] ?? 0.00;
                                        $variation_data['sale_price'] = $request->sale_price[$key] ?? 0.00;
                                        if ($woo_variation_info) {
                                            try {
                                                $result = Woocommerce::post("products/" . $woo_variation_info->woocom_master_product_id . "/variations/".$woo_variation_info->id, $variation_data);
                                            } catch (HttpClientException $exception) {
                                                return back()->with('error', $exception->getMessage());
                                            }
                                            $wooUpdateInfo = WoocommerceVariation::find($woo_variation_info->id)->update([
                                                'image' => $result['image']['src'] ?? null,
                                                'sku' => $request->sku[$key],
                                                'ean_no' => $request->ean_no[$key] ?? null, 'cost_price' => $request->cost_price[$key] ?? null,
                                                'regular_price' => $request->regular_price[$key] ?? 0.00, 'sale_price' => $request->sale_price[$key] ?? 0.00,
                                                'rrp' => $request->rrp[$key] ?? $request->regular_price[$key] ?? null,
                                                'product_code' => $request->product_code[$key] ?? null, 'color_code' => $request->color_code[$key] ?? null,
                                                'low_quantity' => $request->low_quantity[$key] ?? null,
                                                'description' => $request->description[$key] ?? null
                                            ]);
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }




            if($all_sku_count == $exist_sku_count){
                return back()->with('updated_success', 'Product updated successfully.');
            }else {
                return redirect('catalogue-product-invoice-receive/' . $request->product_draft_id)
                ->with('new_product_success', 'Product created successfully.');
            }



//        }catch (\Exception $exception){
//            return redirect('exception')->with('exception',$exception->getMessage());
//        }
    }


    public function addVariationOnEbay($product_draft_id,$sku){
        $name_value_array = array();
        $name_value = '';
        $variations = '';
        $attribute = '';
        $variation_specifics = array();
        $product_variation_result = ProductVariation::where('sku',$sku)->get()->first();

        foreach (\Opis\Closure\unserialize($product_variation_result->attribute) as $attribute_array){
//            echo "<pre>";
//            print_r($attribute);
//            exit();
//            $attribute_value[] =
//                [ "attribute_id" => $attribute[],
//                    "attribute_name" => Attribute::find($attribute_id)->attribute_name,
//                    "terms_id" => $trems_id[$key],
//                    "terms_name" => AttributeTerm::find($trems_id[$key])->terms_name
//                ];
            $attribute .= '<NameValueList>
                  <Name>'.$attribute_array["attribute_name"].'</Name>
                  <Value>'.$attribute_array["terms_name"].'</Value>
               </NameValueList>';
            $variation_specifics[$attribute_array["attribute_name"]] = $attribute_array["terms_name"];

        }

        $variation_specifics_find = EbayVariationProduct::where('variation_specifics',\Opis\Closure\serialize($variation_specifics))->where('master_variation_id',$product_variation_result->id)->get()->first();
//        if (!isset($variation_specifics_find->id)){
        if (true){

            $attribute_value_serialize = $product_variation_result->attribute;


            $ebay_master_product_result = EbayMasterProduct::where('master_product_id', $product_draft_id)->where('deleted_at', '=', NULL)->first();

            if ($ebay_master_product_result != null){
                $ebay_master_product_result = EbayMasterProduct::where('master_product_id' , $product_draft_id)->get();
//                            echo "<pre>";
//                            print_r($attribute);
//                            exit();
                $product_draft = ProductDraft::find($product_draft_id);
//                                                        echo "<pre>";
//                            print_r(\Opis\Closure\unserialize($product_draft->attribute));
//                            exit();
                foreach (\Opis\Closure\unserialize($product_draft->attribute) as $attribute_id => $attribute_array){
                    foreach ($attribute_array as $attribute_name => $terms_array){

                        $name_value .='<NameValueList>
                                        <Name>'.$attribute_name.'</Name>';
                        foreach ($terms_array as $terms){
//                                        echo "<pre>";
//                                        print_r($terms_array);
//                                        exit();

                            if (!in_array($terms["attribute_term_name"], $name_value_array))
                            {
                                array_push($name_value_array, $terms["attribute_term_name"]);
                                $name_value .= '<Value>'.$terms["attribute_term_name"].'</Value>';
                            }

                        }
                        $name_value .= '</NameValueList>';
                    }

                }
                $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                foreach ($ebay_master_product_result as $product){
                    $quentity = 0;
                    $variations = '';
                    $ean = $product_variation_result->ean_no ?? 'Does not apply';
                    $variations .= '<Variation>
                                    <SKU>'.'<![CDATA['.$product_variation_result->sku.']]>'.'</SKU>


                                <StartPrice>'.$product_variation_result->sale_price.'</StartPrice>
                                <Quantity>'.$product_variation_result->actual_quantity.'</Quantity>
                                <VariationProductListingDetails>
                                <EAN>'. $ean.'</EAN>

                                </VariationProductListingDetails>
                                <VariationSpecifics>'
                        .$attribute.'
                                </VariationSpecifics>
                            </Variation>';

                    $account_result = EbayAccount::find($product->account_id);

                    $this->ebayAccessToken($account_result->refresh_token);
                    $url = 'https://api.ebay.com/ws/api.dll';
                    $headers = [
                        'X-EBAY-API-SITEID:'.$product->site_id,
                        'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                        'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                        'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                    ];

                    $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>'.$product->item_id.'</ItemID>
                        <Variations>
                           <VariationSpecificsSet>
            '.$name_value.'
         </VariationSpecificsSet>
                            '.$variations.'

                        </Variations>
                      </Item>
                    </ReviseFixedPriceItemRequest>';

                    $result = $this->curl($url,$headers,$body,'POST');
                    $result =simplexml_load_string($result);
                    $result = json_decode(json_encode($result),true);

                    if ($result['Ack'] == 'Warning' || $result['Ack'] == 'Success') {
                        $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $product->id, 'master_variation_id' => $product_variation_result->id,
                            'sku' => $product_variation_result->sku, 'variation_specifics' => $variation_specifics, 'start_price' => $product_variation_result->sale_price, 'rrp' => $product_variation_result->regular_price,
                            'ean' => $product_variation_result->ean_no]);
                    }

                }

            }
            return redirect('product-draft/'.$product_draft_id)
                ->with('success', 'Ebay Product Variation created successfully.');

        }
        return redirect('product-draft/'.$product_draft_id)
            ->with('error', 'Ebay Product Variation Exist');

    }


    /*
     * Function : unmatchedInventoryList
     * Route : unmatched-inventory-list
     * parameters:
     * Request : GET
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for viewing unmatched quantity product
     * Created Date: unknown
     * Modified Date : 30-11-2020
     * Modified Content : isset check and error handling and client shelf use check
     */
    public function unmatchedInventoryList(){
        try {
            $shelf_use = $this->shelf_use;
            $ebay_accounts = EbayAccount::get()->all();
            $negative_quantity = ProductVariation::select(['id', 'product_draft_id', 'image', 'sku', 'actual_quantity'])->with(['product_draft' => function ($query) {
                $query->select(['id', 'name'])->with('single_image_info:id,draft_product_id,image_url');
            }, 'shelf_quantity'])->where('actual_quantity', '<', 0)->get();

            $all_unmatched_quantity = ProductVariation::
            select('product_variation.id', 'product_variation.actual_quantity', DB::raw('SUM(product_shelfs.quantity) as shelf_quantity'))
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->having('product_variation.actual_quantity', '>', DB::raw('SUM(product_shelfs.quantity)'))
                ->groupBy('product_variation.id')
                ->groupBy('product_variation.actual_quantity')
                ->orderBy('product_variation.id', 'DESC')
                ->get();
            $all_unmatched_quantity = json_decode(json_encode($all_unmatched_quantity));
            $all_variation_info = $this->getProductInfoByUnmatchedId($all_unmatched_quantity);
            $threshold_quantity = 5;
            $shelve_qnty_larger = ProductVariation::
            select('product_variation.id', 'product_variation.actual_quantity', DB::raw('SUM(product_shelfs.quantity) as shelf_quantity'))
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->havingRaw('SUM(product_shelfs.quantity) - product_variation.actual_quantity >=' . $threshold_quantity)
                ->groupBy('product_variation.id')
                ->groupBy('product_variation.actual_quantity')
                ->orderBy('product_variation.id', 'DESC')
                ->get();
            $shelve_qnty_larger_than_available = $this->getProductInfoByUnmatchedId($shelve_qnty_larger);

            $content = view('product_variation.unmatched_inventory_list', compact('all_variation_info', 'shelve_qnty_larger_than_available', 'threshold_quantity', 'negative_quantity','shelf_use','ebay_accounts'));
            return view('master', compact('content'));
        } catch (\Exception $exception) {
            return redirect('exception')->with('exception', $exception->getMessage());
        }
    }

    /*
     * Function : getProductInfoByUnmatchedId
     * Route :
     * parameters: $ids(Variation ID)
     * Request :
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for getting unmatched product information
     * Created Date: unknown
     * Modified Date : 30-11-2020
     * Modified Content : isset check and error handling and client shelf use check
     */
    public function getProductInfoByUnmatchedId($ids){
        try {
            $all_variation_info = array();
            if (count($ids) > 0) {
                foreach ($ids as $quantity) {
                    $variation_info = ProductVariation::with(['product_draft' => function ($query) {
                        $query->with('single_image_info');
                    }])->find($quantity->id);
                    if (isset($variation_info)) {
                        $all_variation_info[] = [
                            "id" => $quantity->id,
                            "actual_quantity" => $quantity->actual_quantity ?? 0,
                            "shelf_quantity" => $quantity->shelf_quantity ?? 0,
                            "name" => $variation_info->product_draft->name ?? null,
                            "image" => $variation_info->image ?? null,
                            "sku" => $variation_info->sku,
                            'master_catalogue_id' => $variation_info->product_draft_id,
                            "master_image" => $variation_info->product_draft->single_image_info->image_url ?? null
                        ];
                    }
                }
            }
            return $all_variation_info;
        } catch (\Exception $exception) {
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /*
     * Function : searchThresholdUnmatchedProduct
     * Route : search-threshold-unmatched-product (ajax)
     * Method Type : POST
     * Parametes :
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for getting the unmatched quantity threshold product by ajax
     * Created Date: unknown
     * Modified Date : 30-11-2020
     * Modified Content : isset check and error handeling
     */
    public function searchThresholdUnmatchedProduct(Request $request){
        try {
            $threshold_quantity = $request->threshold_value;
            $shelve_qnty_larger = ProductVariation::
            select('product_variation.id','product_variation.actual_quantity',DB::raw('SUM(product_shelfs.quantity) as shelf_quantity'))
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->havingRaw('SUM(product_shelfs.quantity) - product_variation.actual_quantity >='.$threshold_quantity)
                ->groupBy('product_variation.id')
                ->groupBy('product_variation.actual_quantity')
                ->orderBy('product_variation.id','DESC')
                ->get();
            $shelve_qnty_larger_than_available = $this->getProductInfoByUnmatchedId($shelve_qnty_larger);
            $result_row = count($shelve_qnty_larger_than_available);
            $content = view('product_variation.search_threshold_unmatched_product',compact('shelve_qnty_larger_than_available','threshold_quantity'))->render();
            return response()->json(['data' => $content, 'row' => $result_row]);
        }catch (\Exception $exception){
            return response()->json(['data' => 'error']);
        }
    }

    public function variationPriceBulkUpdate(Request $request){
        $largerAvailableQuantityProducts = [];
        // if($request->editType == 'bulk_edit' && $request->input_field == 'actual_quantity'){
        //     $productOrderQuantity = ProductOrder::select(DB::raw('sum(product_orders.quantity - product_orders.picked_quantity) as totalQuantity'),'product_orders.variation_id')
        //                 ->join('orders','orders.id','=','product_orders.order_id')
        //                 ->whereIn('product_orders.variation_id',$request->variation_ids)
        //                 ->whereIn('orders.status',['processing','on-hold'])
        //                 ->where('product_orders.status',0)
        //                 ->groupBy('product_orders.variation_id')
        //                 ->get();
        //     $orderQuantity = [];
        //     if(count($productOrderQuantity) > 0){
        //         foreach($productOrderQuantity as $quantity){
        //             $orderQuantity[$quantity->variation_id] = $quantity->totalQuantity;
        //         }
        //     }
        // }
        $shelf_use = $this->shelf_use;
        if(count($request->variation_ids) > 0) {
            foreach ($request->variation_ids as $variation_id) {
                $master_variation_info = ProductVariation::find($variation_id);
                $responseContentShow[] = [
                    'variation_id' => $variation_id,
                    'updatedQuantity' => $request->input_value
                ];
                if($request->input_field == 'actual_quantity'){
                    $availableQuantity = AvailableQuantityChangeLog::create([
                        'modified_by' => Auth::id(),
                        'variation_id' => $master_variation_info->id,
                        'previous_quantity' => $master_variation_info->actual_quantity,
                        'updated_quantity' => $request->input_value,
                    ]);
                    $check_quantity = new CheckQuantity();
                    $check_quantity->checkQuantity($master_variation_info->sku, null,$request->input_value, 'Manually Available Quantity Update',null,true);
                }else{
                    $update_info = ProductVariation::where('id', $variation_id)->update([$request->input_field => $request->input_value]);
                    $newUpdatedData = $request->input_value;
                    if(Session::get('woocommerce') == 1){
                        $woo_comm_variation_info = WoocommerceVariation::where('woocom_variation_id',$variation_id)->first();
                        if($woo_comm_variation_info && $request->input_field != 'cost_price' && $request->input_field != 'base_price') {

                            $update_field = ($request->input_field != 'actual_quantity') ? $request->input_field : 'stock_quantity';
                            if($request->input_field != 'rrp'){
                                $data = [
                                    $update_field => $newUpdatedData
                                ];
                            }else{
                                $data['meta_data'][] = [
                                    'key' => 'rrp',
                                    'value' => $newUpdatedData,
                                ];
                            }
                            try {
                                $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info->woocom_master_product_id . '/variations/' . $woo_comm_variation_info->id, $data);
                            } catch (HttpClientException $exception) {
                                //return response()->json(['msg' => $exception->getMessage(),'largerAvailableQuantityProducts' => $largerAvailableQuantityProducts]);
                            }
                        }
                        if($request->input_field != 'base_price'){
                            $woo_comm_variation_update = WoocommerceVariation::where('woocom_variation_id',$variation_id)->update([$request->input_field => $newUpdatedData]);
                        }
                    }
                    if(Session::get('ebay') == 1){
                        $ebay_variation_info = EbayVariationProduct::with('masterProduct')->where('master_variation_id',$variation_id)->first();
                        if($ebay_variation_info && $request->input_field != 'cost_price' && $request->input_field != 'base_price') {
                            if ($request->input_field == 'actual_quantity'){
                                $update_field = 'quantity';
                            }
                            elseif ($request->input_field == 'regular_price'){
                                $update_field = 'rrp';
                            }
                            elseif($request->input_field == 'rrp'){
                                $update_field = 'rrp';
                            }
                            elseif ($request->input_field == 'sale_price'){
                                $update_field = 'start_price';
                            }


                            try {
                                try{
                                    $account_result = EbayAccount::find($ebay_variation_info->masterProduct->account_id);

                                    $this->ebayAccessToken($account_result->refresh_token);
                                    $item_id = $ebay_variation_info->masterProduct->item_id;
                                    $site_id = $ebay_variation_info->masterProduct->site_id;
                                    $ebay_update = EbayVariationProduct::where('sku',$ebay_variation_info->sku)->update([$update_field => $newUpdatedData]);

                                    //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
                                    $this->updateEbayQuantity($item_id,$ebay_variation_info->sku,$update_field,$newUpdatedData,$site_id);
                                }catch (Exception $exception){
                                    echo $exception;
                                    //continue;
                                }
                            } catch (HttpClientException $exception) {
                                //                        echo $exception->getMessage();
                                return response()->json(['msg' => $exception->getMessage(),'largerAvailableQuantityProducts' => $largerAvailableQuantityProducts]);
                            }
                        }
                    }

                    if(Session::get('onbuy') == 1){
                        $onbuy_variation_info = OnbuyVariationProducts::where('sku', $master_variation_info->sku)->first();
                        if ($onbuy_variation_info && $request->input_field != 'cost_price' && $request->input_field != 'regular_price' && $request->input_field != 'rrp') {

                            if($request->input_field != 'base_price'){
                                $update_field = ($request->input_field == 'actual_quantity') ? 'stock' : (($request->input_field == 'sale_price') ? 'price' :  $request->input_field);
                                $var_data[] = [
                                    "sku" => $onbuy_variation_info->sku,
                                    $update_field => $newUpdatedData
                                    //                        "price" => $request->sale_price,
                                    //                        "stock" => $request->actual_quantity
                                ];
                                $update_info = [
                                    "site_id" => 2000,
                                    "listings" => $var_data
                                ];
                            }else{
                                $update_field = 'base_price';
                            }

                            try {
                                if($request->input_field != 'base_price'){
                                    $access_token = $this->access_token();

                                    $var_product_info = json_encode($update_info, JSON_PRETTY_PRINT);
                                    $url = "https://api.onbuy.com/v2/listings/by-sku";
                                    $var_post_data = $var_product_info;
                                    $method = "PUT";
                                    $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");


                                    $result_info = $this->curl_request_send($url, $method, $var_post_data, $http_header);
                                    $decode_data = json_decode($result_info);
                                }

                                $update_info = OnbuyVariationProducts::where('id', $onbuy_variation_info->id)->update([
                                    $update_field => $newUpdatedData
                                ]);

                                // $data = json_decode($result_info);
                            }catch (\Exception $exception) {
                                //return response()->json(['msg' => $exception->getMessage(),'largerAvailableQuantityProducts' => $largerAvailableQuantityProducts,'responseContentShow' => $responseContentShow]);
                            }

                        }
                    }

                    if($request->input_field == 'sale_price'){
                        if(Session::get('amazon') == 1){
                            $amazonAccountSites = AmazonAccountApplication::where('application_status',1)->get();
                            if($amazonAccountSites && count($amazonAccountSites) > 0){
                                $amazonVariationProduct = AmazonVariationProduct::select('id','amazon_master_product','master_variation_id','sku')->with(['masterCatalogue' => function($query){
                                    $query->select('id','master_product_id','application_id','product_type')->with(['catalogueType:id,marketplace_id,product_type']);
                                }])->where('sku',$master_variation_info->sku)->get();
                                if(count($amazonVariationProduct) > 0){
                                    foreach($amazonVariationProduct as $product){
                                        $config = $this->configuration($product->masterCatalogue->application_id);
                                        $result = $this->changePriceFromWmsAndAmazon($product->masterCatalogue->catalogueType->product_type,$product->sku,$newUpdatedData,$config);
                                    }
                                }
                            }
                        }
                    }
                }


            }
            return response()->json(['msg' => 'success','largerAvailableQuantityProducts' => $largerAvailableQuantityProducts,'responseContentShow' => $responseContentShow]);
        }
//        else{
//            return response()->json(['msg' => 'Something went wrong','largerAvailableQuantityProducts' => $largerAvailableQuantityProducts,'responseContentShow' => $responseContentShow]);
//        }
    }
    public function updateEbayQuantity($itemId,$sku,$update_field,$update_value,$siteId){

        $sku = $sku;
        $update_field = $update_field;
        $update_value = $update_value;

        $value='';
        if ($update_field == 'quantity'){
            $value ='<Quantity>'.$update_value.'</Quantity>';
        }elseif($update_field == 'start_price'){
            $value ='<StartPrice>'.$update_value.'</StartPrice>';
        }elseif ($update_field == 'rrp'){
            $value ='<DiscountPriceInfo>
                  <OriginalRetailPrice>'.$update_value.'</OriginalRetailPrice>
                </DiscountPriceInfo>';
        }
//        print_r($itemId.'****'.$sku.'*****'.$quantity.'********',$siteId);
//        exit();
//        $quantity =1;
        $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();

        foreach ($ebay_product_find as $product) {
            $request_body = null;
            $account_result = EbayAccount::find($product->masterProduct->account_id);

            $this->ebayAccessToken($account_result->refresh_token);
            $url = 'https://api.ebay.com/ws/api.dll';
            $headers = [
                'X-EBAY-API-SITEID:' . $product->masterProduct->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:' . $this->ebay_update_access_token,
            ];
            if ($product->masterProduct->type == "variable"){
                $request_body = '<Variations>
                            <!-- Identify the first new variation and set price and available quantity -->
                          <Variation>
                            <SKU>'.str_replace('&','&amp;',$sku).'</SKU>

                            '. $value .'

                          </Variation>
                          <!-- Identify the second new variation and set price and available quantity -->

                        </Variations>';
            }else if($product->masterProduct->type == "simple" && $update_field == 'start_price'){
                $request_body = $value;
            }


            $body = '<?xml version="1.0" encoding="utf-8"?>
                    <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                        <ErrorLanguage>en_US</ErrorLanguage>
                        <WarningLevel>High</WarningLevel>
                      <Item>
                        <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                        you want to add new variations to -->
                        <ItemID>' . $product->masterProduct->item_id . '</ItemID>
                        '.$request_body.'
                      </Item>
                    </ReviseFixedPriceItemRequest>';
            try{

                $update_ebay_product = $this->curl($url, $headers, $body, 'POST');
                $update_ebay_product =simplexml_load_string($update_ebay_product);
                $update_ebay_product = json_decode(json_encode($update_ebay_product),true);

            }catch(\Exception $exception){

            }
        }
//        $update_ebay_product =simplexml_load_string($update_ebay_product);
//        $update_ebay_product = json_decode(json_encode($update_ebay_product),true);
//        echo $itemId.'****'.$sku.'*****'.$quantity.'********'.$siteId;
//        exit();


    }
    public function ebayAccessToken($refresh_token){
        $developer_result = DeveloperAccount::get()->first();
        if($developer_result) {
            $clientID = $developer_result->client_id;
            $clientSecret = $developer_result->client_secret;
//dd($token_result->authorization_token);
            $url = 'https://api.ebay.com/identity/v1/oauth2/token';
            $headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($clientID . ':' . $clientSecret),

            ];

            $body = http_build_query([
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',

            ]);


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => $headers
            ));

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);
            $response = json_decode($response, true);
            if($response['access_token'] != '') {
                $this->ebay_update_access_token = $response['access_token'];
            }else{
                $this->ebay_update_access_token = '';
            }
        }else{
            $this->ebay_update_access_token = '';
        }
    }
    public function curl($url,$header,$body,$method){
        $url = $url;
        $header = $header;
        $body = $body;
        $method = $method;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $header
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
    public function columnSearch(Request $request){
        $column = $request->column_name;
        $value = $request->search_value;
        if($request->route_name == 'product-variation') {
            $all_product_variation = ProductVariation::with(['product_draft' => function ($query) {
                $query->with('product_catalogue_image');
            }, 'shelf_quantity', 'order_products' => function ($query) {
                $query->select('variation_id', DB::raw('sum(product_orders.quantity) sold'))->groupBy('variation_id');
            }])
//            ->whereDate('created_at', '>', Carbon::now()->subDays(7))
                ->orderBy('id', 'DESC')
                ->where(function ($query) use ($request, $column, $value) {
                    if ($column == 'id') {
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    } elseif ($column == 'name') {
                        $query_info = ProductDraft::select('product_variation.id')
                            ->join('product_variation', 'product_drafts.id', '=', 'product_variation.product_draft_id')
                            ->where([['product_drafts.deleted_at', null], ['product_variation.deleted_at', null]])
                            ->where('product_drafts.name', 'like', '%' . $request->search_value . '%')
                            ->get();
                        $ids = [];
                        foreach ($query_info as $info) {
                            $ids[] = $info->id;
                        }
                        if ($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    }
                    elseif ($column == 'sku') {
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    }
                    elseif ($column == 'ean_no') {
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    } elseif ($column == 'actual_quantity') {

                        $aggrgate_value = $request->aggregate_condition;
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, $aggrgate_value, $value);
                        }
                    } elseif ($column == 'sold') {
                        $aggrgate_value = $request->aggregate_condition;
                        $query_info = ProductVariation::select('product_variation.id', DB::raw('sum(product_orders.quantity) sold'))
                            ->join('product_orders', 'product_variation.id', '=', 'product_orders.variation_id')
                            ->where([['product_variation.deleted_at', null], ['product_orders.deleted_at', null]])
                            ->havingRaw('sum(product_orders.quantity)' . $aggrgate_value . $request->search_value)
                            ->groupBy('product_variation.id')
                            ->get();
                        $ids = [];
                        foreach ($query_info as $info) {
                            $ids[] = $info->id;
                        }
                        if ($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } elseif ($column == 'shelf_quantity') {
                        $aggrgate_value = $request->aggregate_condition;
                        $query_info = ProductVariation::select('product_variation.id', DB::raw('sum(product_shelfs.quantity) shelf_quantity'))
                            ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                            ->where([['product_variation.deleted_at', null], ['product_shelfs.deleted_at', null]])
                            ->havingRaw('sum(product_shelfs.quantity)' . $aggrgate_value . $request->search_value)
                            ->groupBy('product_variation.id')
                            ->get();
                        $ids = [];
                        foreach ($query_info as $info) {
                            $ids[] = $info->id;
                        }
                        if ($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } elseif ($column == 'low_quantity') {
                        $aggrgate_value = $request->aggregate_condition;
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, $aggrgate_value, $value);
                        }
                    }

                })
                ->paginate(500);
            $total_variation = ProductVariation::count();
            $all_variation_decode_info = json_decode(json_encode($all_product_variation));
//        echo "<pre>";
//        print_r(json_decode(json_encode($all_product_variation)));
//        exit();
            $content = view('product_variation.variation_list',compact('all_product_variation','total_variation','all_variation_decode_info'));
            return view('master',compact('content'));
        }else{

            $low_quantity_product = ProductVariation::with(['product_draft','shelf_quantity'])
                ->whereRaw('actual_quantity < low_quantity')
                ->where(function ($query) use ($request, $column, $value) {
                    if ($column == 'id') {
                        if ($request->opt_out == 1) {
                            $query->where($column, 'NOT LIKE', '%' . $value . '%');
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    } elseif ($column == 'name') {
                        $query_info = ProductDraft::select('product_variation.id')
                            ->join('product_variation', 'product_drafts.id', '=', 'product_variation.product_draft_id')
                            ->where([['product_drafts.deleted_at', null], ['product_variation.deleted_at', null]])
                            ->where('product_drafts.name', 'like', '%' . $request->search_value . '%')
                            ->get();
                        $ids = [];
                        foreach ($query_info as $info) {
                            $ids[] = $info->id;
                        }
                        if ($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } elseif ($column == 'sku') {
                        if ($request->opt_out == 1) {
                            $query->where($column, 'NOT LIKE', '%' . $value . '%');
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    } elseif ($column == 'ean_no') {
                        if ($request->opt_out == 1) {
                            $query->where($column, 'NOT LIKE', '%' . $value . '%');
                        } else {
                            $query->where($column, 'like', '%' . $value . '%');
                        }
                    } elseif ($column == 'actual_quantity') {

                        $aggrgate_value = $request->aggregate_condition;
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, $aggrgate_value, $value);
                        }
                    }  elseif ($column == 'shelf_quantity') {
                        $aggrgate_value = $request->aggregate_condition;
                        $query_info = ProductVariation::select('product_variation.id', DB::raw('sum(product_shelfs.quantity) shelf_quantity'))
                            ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                            ->where([['product_variation.deleted_at', null], ['product_shelfs.deleted_at', null]])
                            ->havingRaw('sum(product_shelfs.quantity)' . $aggrgate_value . $request->search_value)
                            ->groupBy('product_variation.id')
                            ->get();
                        $ids = [];
                        foreach ($query_info as $info) {
                            $ids[] = $info->id;
                        }
                        if ($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        } else {
                            $query->whereIn('id', $ids);
                        }
                    } elseif ($column == 'low_quantity') {
                        $aggrgate_value = $request->aggregate_condition;
                        if ($request->opt_out == 1) {
                            $query->where($column, '!=', $value);
                        } else {
                            $query->where($column, $aggrgate_value, $value);
                        }
                    }

                })
                ->paginate(500);
            $total_low_quantity_product = ProductVariation::with(['product_draft','shelf_quantity'])->whereRaw('actual_quantity < low_quantity')->count();
            $decode_low_product = json_decode(json_encode($low_quantity_product));
            $content = view('product_variation.low_quantity_product',compact('low_quantity_product','decode_low_product','total_low_quantity_product'));
            return view('master',compact('content'));
        }
    }

    /*
     * Function : saveVariationImageAttributeWise
     * Route : save-variation-image-attribute-wise
     * Method Type : POST
     * Parametes :
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for saving single variation image from master catalogue details
     * Created Date: unknown
     * Modified Date : 06-12-2020
     * Modified Content : make image field single option choice
     */
    public function saveVariationImageAttributeWise(Request $request){
        try {
            if($request->singleVariationImageCheckbox == 1){
                $file = $request->singleImageFile;
                $name = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                $file->move('assets/images/product_variation/', $name);
                $image_url = 'assets/images/product_variation/' . $name;
                $single_woo_arr = [];

                foreach ($request->variation_ids as $key => $value) {
                    $attribute_and_terms = [
                        $request->attribute_name[$key] => $request->attribute_terms[$key]
                    ];
                    $single_image_url_update = ProductVariation::whereIn('id', explode(',', $request->var_id[$key]))->update([
                        'image' => $image_url,
                        'image_attribute' => \Opis\Closure\serialize($attribute_and_terms)
                    ]);
//                    $extact_id = json_decode($value);
                    $image_url = $this->projectUrl().$image_url;
                    $woo_comm_variation_info = WoocommerceVariation::whereIn('woocom_variation_id', explode(',', $request->var_id[$key]))->get();
                    $woo_var_ids = [];
                    foreach ($woo_comm_variation_info as $info) {
                        $woo_var_ids = [
                            'id' => $info->id,
                            'image' => [
                                'src' => $image_url
                            ]
                        ];
                        array_push($single_woo_arr,$woo_var_ids);
                    }

                }

                if (count($single_woo_arr) > 0) {
                    $data['update'] = $single_woo_arr;
                    try {
                        $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info[0]->woocom_master_product_id . '/variations/batch', $data);
                    } catch (HttpClientException $exception) {
                        return back()->with('error', $exception->getMessage());
                    }
                    $product_variation_decode_result = json_decode(json_encode($product_variation_result));

                    foreach ($product_variation_decode_result->update as $result) {
                        $woo_product_variation_result = WoocommerceVariation::where('id', $result->id)->update([
                            'image' => $result->image->src ?? null
                        ]);
                    }
                }

            }else {
                if (isset($request->variation_image) && count($request->variation_image) > 0) {
                    foreach ($request->variation_image as $key => $value) {
                        $attribute_and_terms = [
                            $request->attribute_name[$key] => $request->attribute_terms[$key]
                        ];
                        $file = $request->variation_image[$key];
                        $name = time() . '-' . str_replace(' ', '-', $file->getClientOriginalName());
                        $file->move('assets/images/product_variation/', $name);
                        $image_url = 'assets/images/product_variation/' . $name;
                        $single_image_url_update = ProductVariation::whereIn('id', explode(',', $request->var_id[$key]))->update([
                            'image' => $image_url,
                            'image_attribute' => \Opis\Closure\serialize($attribute_and_terms)
                        ]);
                        $image_url = $this->projectUrl().$image_url;
                        $extact_id = json_decode($request->variation_ids[$key]);
                        $woo_comm_variation_info = WoocommerceVariation::whereIn('woocom_variation_id', $extact_id)->get();
                        if (count($woo_comm_variation_info) > 0) {
                            $woo_var_ids = [];
                            foreach ($woo_comm_variation_info as $info) {
                                $woo_var_ids[] = [
                                    'id' => $info->id,
                                    'image' => [
                                        'src' => $image_url
                                    ]
                                ];
                            }

                            $data['update'] = $woo_var_ids;
                            try {
                                $product_variation_result = Woocommerce::put('products/' . $woo_comm_variation_info[0]->woocom_master_product_id . '/variations/batch', $data);
                            } catch (HttpClientException $exception) {
                                return back()->with('error', $exception->getMessage());
                            }
                            $product_variation_decode_result = json_decode(json_encode($product_variation_result));
                            foreach ($product_variation_decode_result->update as $result) {
                                $woo_product_variation_result = WoocommerceVariation::where('id', $result->id)->update([
                                    'image' => $result->image->src ?? null
                                ]);
                            }
                        }
                    }
                } else {
                    return back()->with('error', 'No image given');
                }
            }
            return back()->with('image_success', 'Image updated successfully');
        } catch (\Exception $exception) {
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function hideLowQuantityProduct($id){
        try{
            $hideResult = ProductVariation::where('product_draft_id',$id)->update([
                'low_quantity_visibility' => 0
            ]);
            return back()->with('success','Selected product is hiden from the list');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function shelfAvailableBulkSync(Request $request){

        $largerAvailableQuantityProducts = [];
        foreach($request->variationInfo as $info){

            $variationInfo = ProductVariation::find($info['id']);
            $check_quantity = new CheckQuantity();
            $check_quantity->checkQuantity($variationInfo->sku, null, null, 'Shelf And Available Bulk Sync',null,true);
        }
        return response()->json(['data' => 'success','msg' => 'Available and Shelf Quantity Sync Successfully','largerAvaiableQuantity' => $largerAvailableQuantityProducts]);
    }

    public function seachByEanNo($eanNo){
        $catalogueId = ProductVariation::where('ean_no',$eanNo)->pluck('product_draft_id')->toArray();
        return $catalogueId;
    }

    public function searchById($id){
        $catalogueId = ProductVariation::where('id',$id)->orWhere('product_draft_id',$id)->groupBy('product_draft_id')->pluck('product_draft_id')->toArray();
        return $catalogueId;
    }

    public function searchBySku($sku){
        $catalogueId = ProductVariation::where('sku',$sku)->pluck('product_draft_id')->toArray();
        return $catalogueId;
    }

    public function searchByTitle($title){
        $catalogueId = ProductDraft::where('name','LIKE', '%'.$title.'%')->pluck('id')->toArray();
        return $catalogueId;
    }

    public function availableQuantityChangeLog(Request $request){
        try{
            $isSearch = $request->get('is_search') ? true : false;
            $allChangeLog = AvailableQuantityChangeLog::with(['userInfo:id,name','variationInfo' => function($query){
                $query->select('id','product_draft_id','image','attribute','sku')->with(['product_draft:id,name','master_single_image:id,draft_product_id,image_url']);
            }]);
            if($isSearch){
                $this->searchCondition($allChangeLog, $request);
            }
            $allChangeLog = $allChangeLog->orderByDesc('id')->paginate(50);

            $all_decode_available_quantity_change_log = json_decode(json_encode($allChangeLog));
            $page_title = 'Available Quantity Change Log';
            $content = view('product_variation.available_quantity_change_log',compact('allChangeLog','page_title','all_decode_available_quantity_change_log','isSearch'));
            return view('master',compact('content'));
            echo '<pre>';
            print_r(json_decode(json_encode($all_decode_available_quantity_change_log)));
            exit();
        }catch(\Exception $exception){
            return back()->with('error',$exception->getMessage());
        }
    }

    public function searchCondition($mainQuery,$request){
        $mainQuery->where(function($query) use ($request){
            if($request->get('variation_id')){
                $query->where('variation_id', $request->get('variation_id'));
            }
            if($request->get('title')){
                $draftInfo = ProductDraft::where('name',$request->get('title'))->first();
                $variationInfo = ProductVariation::select('id')->where('product_draft_id', $draftInfo->id)->get()->toArray();
                $query->whereIn('variation_id', $variationInfo);
            }
            if($request->get('sku')){
                $info = ProductVariation::where('sku',$request->get('sku'))->first();;
                $query->where('variation_id', $info->id);
            }
            if($request->get('previous_quantity')){
                $query->where('previous_quantity', $request->get('previous_quantity'));
            }
            if($request->get('updated_quantity')){
                $query->where('updated_quantity', $request->get('updated_quantity'));
            }
            if($request->get('user_id')){
                $query->where('modified_by', $request->get('user_id'));
            }
            if($request->get('updated_at')){
                $query->whereDate('updated_at', date('Y-m-d', strtotime($request->get('updated_at'))));
            }
        });
    }

    public function variationBulkDelete(Request $request){
        $variationIds = $request->variaitonIds;

        $catalogueId = $request->catalogueId;
        $variationSkus = ProductVariation::whereIn('id',$variationIds)->pluck('sku')->toArray();
        $channel_response_result = [];
        $woo_variation_ids = WoocommerceVariation::whereIn('woocom_variation_id',$variationIds)->pluck('id')->toArray();
        $exceptionArr = [];
        if(count($woo_variation_ids) > 0) {
            try{
                $data = [
                    'delete' => $woo_variation_ids
                ];
                $woo_catalogue_id = WoocommerceCatalogue::where('master_catalogue_id', $catalogueId)->get(['id'])->first();
                $channel_response_result = Woocommerce::post('products/' . $woo_catalogue_id->id . '/variations/batch',$data);
                $woo_delete_info = WoocommerceVariation::whereIn('woocom_variation_id',$variationIds)->delete();
            } catch (Exception $exception) {
                $exceptionArr[] = '<strong class="text-primary">Woocommerce:</strong>'.$exception->getMessage();
            }
        }

        $ebay_master_product_ids = EbayVariationProduct::whereIn('sku',$variationSkus)->groupBy('ebay_master_product_id')->pluck('ebay_master_product_id')->toArray();
        if(count($ebay_master_product_ids) > 0) {
            foreach ($ebay_master_product_ids as $master_id){
                try {
                    $ebay_variation_skus = EbayVariationProduct::whereIn('sku',$variationSkus)->where('ebay_master_product_id',$master_id)->pluck('sku')->toArray();
                    if(count($ebay_variation_skus) > 0){
                        $variationInfo = '';
                        foreach($ebay_variation_skus as $sku){
                            $variationInfo .= '<Variation><Delete>true</Delete><SKU>'.$sku.'</SKU></Variation>';
                        }
                        //$channel_response_result = $variationInfo;
                        $ebayAccountId = EbayMasterProduct::find($master_id);
                        $account_result = EbayAccount::find($ebayAccountId->account_id);

                        $this->ebayAccessToken($account_result->refresh_token);
                        $url = 'https://api.ebay.com/ws/api.dll';
                        $headers = [
                            'X-EBAY-API-SITEID:'.$ebayAccountId->site_id,
                            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                            'X-EBAY-API-CALL-NAME:ReviseFixedPriceItem',
                            'X-EBAY-API-IAF-TOKEN:'.$this->ebay_update_access_token,
                        ];

                        $body = '<?xml version="1.0" encoding="utf-8"?>
                                <ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                    <ErrorLanguage>en_US</ErrorLanguage>
                                    <WarningLevel>High</WarningLevel>
                                <Item>
                                    <!-- Enter the ItemID of the multiple-variation, fixed-price listing
                                    you want to add new variations to -->
                                    <ItemID>'.$ebayAccountId->item_id.'</ItemID>
                                    <Variations>
                                        <!-- Identify the first new variation and set price and available quantity -->
                                    '.$variationInfo.'
                                    <!-- Identify the second new variation and set price and available quantity -->

                                    </Variations>
                                </Item>
                                </ReviseFixedPriceItemRequest>';
                        $deleteResponse = $this->curl($url,$headers,$body,'POST');
                        $xmlParseResponse =simplexml_load_string($deleteResponse);
                        $channel_response_result[] = json_decode(json_encode($xmlParseResponse),true);
                    }
                    $result = EbayVariationProduct::whereIn('sku',$variationSkus)->where('ebay_master_product_id',$master_id)->delete();
                } catch (HttpClientException $exception) {
                    $exceptionArr[] = '<strong class="text-danger">Ebay:</strong>'.$exception->getMessage();
                }
                if(count($channel_response_result) > 0){
                    foreach($channel_response_result as $result){
                        if(isset($result['Ack']) && $result['Ack'] == 'Failure'){
                            $exceptionArr[] = '<strong class="text-warning">Ebay Account: </strong><strong class="text-success">'. $account_result->account_name.'</strong>';
                            if(is_array($result['Errors'])){
                                foreach($result['Errors'] as $key => $error){
                                    $exceptionArr[] = '<strong">'.$key.': </strong>'.$error['ShortMessage'];
                                }
                            }
                        }
                    }
                }
            }
        }

        $onbuy_variation_skus = OnbuyVariationProducts::whereIn('sku',$variationSkus)->pluck('sku')->toArray();
        if(count($onbuy_variation_skus) > 0) {
            $access_token = $this->access_token();
            $data = [
                "site_id" => 2000,
                "skus" => $onbuy_variation_skus
            ];
            try{
                $url = "https://api.onbuy.com/v2/listings/by-sku";
                $post_data = json_encode($data, JSON_PRETTY_PRINT);
                $method = "DELETE";
                $http_header = array("Authorization: " . $access_token, "Content-Type: application/json");
                $channel_response_result = $this->curl_request_send($url, $method, $post_data, $http_header);
                $delete_info = OnbuyVariationProducts::whereIn('sku',$onbuy_variation_skus)->delete();
            }catch (Exception $exception){
                $exceptionArr[] = '<strong class="text-info">Onbuy:</strong>'.$exception->getMessage();
            }
        }
        ProductVariation::whereIn('id',$variationIds)->delete();
        ShelfedProduct::whereIn('variation_id',$variationIds)->delete();
        return response()->json(['response_data' => $channel_response_result,'exception' => $exceptionArr,'variation_ids' => $variationIds,'message' => 'Variation Deleted Successfully']);
    }

    public function changeLowQuantity($productId){
        try{
            $productInfo = ProductVariation::find($productId);
            if($productInfo){
                $productUpdate = ProductVariation::find($productId)->update(['low_quantity' => null,' low_quantity_visibily' => 1]);
                return response()->json(['type' => 'success', 'msg' => 'Change Low Quantity Successfully']);
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Product Not Found']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
        }
    }

    public function variationDeclareDefect(Request $request){
        try{
            $quantity = 0 - $request->defect_quantity;
            $productInfo = ProductVariation::find($request->defect_product_id);
            $check_quantity = new CheckQuantity();
            $check_quantity->checkQuantity($productInfo->sku, $quantity, null, 'Variation Declare Defect');
            $variationUpdate = ProductVariation::find($request->defect_product_id)->update(['actual_quantity' => $request->present_quantity - $request->defect_quantity]);
            if($request->shelf_id != null){
                $shelfDecrement = ShelfedProduct::where('shelf_id', $request->shelf_id)
                    ->where('variation_id',$request->defect_product_id)
                    ->get();
                if(count($shelfDecrement) > 0){
                    $defect = $request->defect_quantity;
                    foreach($shelfDecrement as $shelf){
                        if($defect >= $shelf->quantity){
                            $decrement = ShelfedProduct::find($shelf->id)->decrement('quantity',$shelf->quantity);
                            $defect = $defect - $shelf->quantity;
                        }elseif($defect < $shelf->quantity){
                            $decrement = ShelfedProduct::find($shelf->id)->decrement('quantity',$defect);
                            $defect = $defect - $defect;
                        }
                    }
                }
            }
            $insertInfo = DefectedProduct::create([
                'variation_id' => $request->defect_product_id,
                'defected_product' => $request->defect_quantity,
                'defect_reason_id' => $request->defect_reason
            ]);
            return response()->json(['type' => 'success', 'msg' => 'Variation Declare As Defect Successfully', 'insert_data' => $insertInfo]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => $exception->getMessage()]);
        }
    }

    public function getDefectedReason($id){
        try{
            $allDefectedReasons = DefectedProductReason::all();
            $shelfProduct = ShelfedProduct::select('shelf_id',DB::raw('sum(quantity) as total_quantity'))->with(['shelf_info:id,shelf_name'])->where('variation_id', $id)->where('quantity','>',0)->groupBy('shelf_id')->get();
            return response()->json(['type' => 'success', 'msg' => 'Defected Reason Found', 'allDefectedReason' => $allDefectedReasons,'shelfInfo' => $shelfProduct]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    // public function defectReasonAction(Request $request, $type, $action, $id = null){
    //     try{
    //         if($type == 'na'){
    //             if($action == 'all'){
    //                 $allDefectReasons = DefectedProductReason::orderBy('id','DESC')->paginate(50);
    //                 $allDefectActions = DefectProductAction::orderBy('id','DESC')->paginate(50);
    //                 return view('product_variation.defect_reason',compact('allDefectReasons','allDefectActions'));
    //             }
    //         }else{
    //             if($action == 'add'){
    //                 $exist = DefectedProductReason::where('reason',$request->input_value)->first();
    //                 if($exist){
    //                     return response()->json(['type' => 'error','msg' => 'Alread Exists']);
    //                 }
    //                 $insertInfo = DefectedProductReason::create(['reason' => $request->input_value]);
    //                 return response()->json(['type' => 'success','msg' => 'Defect Reason Added Successfully','response_data' => $insertInfo]);
    //             }elseif($action == 'edit'){
    //                 $exist = DefectedProductReason::where('reason',$request->input_value)->where('id','!=',$request->action_id)->first();
    //                 if($exist){
    //                     return response()->json(['type' => 'error','msg' => 'Alread Exists']);
    //                 }
    //                 $updateInfo = DefectedProductReason::find($request->action_id)->update(['reason' => $request->input_value]);
    //                 return response()->json(['type' => 'success','msg' => 'Defect Reason Updated Successfully']);
    //             }elseif($action == 'delete'){
    //                 $deleteInfo = DefectedProductReason::find($id)->delete();
    //                 return response()->json(['type' => 'success','msg' => 'Defect Reason Deleted Successfully']);
    //             }else{
    //                 return response()->json(['type' => 'error','msg' => 'Nothing Happaned']);
    //             }
    //         }

    //     }catch(\Exception $exception){
    //         if($type == 'na'){
    //             return back()->with('error','Something Went Wrong');
    //         }else{
    //             return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
    //         }
    //     }
    // }


    // public function defectProductAction(Request $request, $type, $action, $id = null){
    //     try{
    //         if($action == 'add'){
    //             $exist = DefectProductAction::where('action',$request->input_value)->first();
    //             if($exist){
    //                 return response()->json(['type' => 'error','msg' => 'Alread Exists']);
    //             }
    //             $insertInfo = DefectProductAction::create(['action' => $request->input_value]);
    //             return response()->json(['type' => 'success','msg' => 'Defect Action Added Successfully','response_data' => $insertInfo]);
    //         }elseif($action == 'edit'){
    //             $exist = DefectProductAction::where('action',$request->input_value)->where('id','!=',$request->action_id)->first();
    //             if($exist){
    //                 return response()->json(['type' => 'error','msg' => 'Alread Exists']);
    //             }
    //             $updateInfo = DefectProductAction::find($request->action_id)->update(['action' => $request->input_value]);
    //             return response()->json(['type' => 'success','msg' => 'Defect Action Updated Successfully']);
    //         }elseif($action == 'delete'){
    //             $deleteInfo = DefectProductAction::find($id)->delete();
    //             return response()->json(['type' => 'success','msg' => 'Defect Action Deleted Successfully']);
    //         }else{
    //             return response()->json(['type' => 'error','msg' => 'Nothing Happaned']);
    //         }
    //     }catch(\Exception $exception){
    //         return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
    //     }
    // }

    public function changeDefectProductStatus($productId,$actionId){
        try{
            $defectedReason = DefectProductAction::find($actionId);
            $updateInfo = DefectedProduct::find($productId)->update(['defect_action_id' => $actionId]);
            return response()->json(['type' => 'success', 'msg' => 'Update Successfully','response_data' => $defectedReason]);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function downloadDeclareDefectCsv(Request $request){
        try{
            $dt = Carbon::now();
            $filename = 'defect-product-list('.$dt->toDateString().").csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('VARIATION ID','NAME','IMAGE','SKU','AVAILABLE QUANTITY', 'EAN NO', 'DEFECTE QUANTITY','DEFECT REASON','ACTION','DEFECT DATE','ACTION DATE'));
            $defectedProductWithAction = DefectedProduct::with(['defectReason:id,reason','defectAction:id,action','variationInfo' => function($query){
                $query->select('id','product_draft_id','image','sku','actual_quantity','ean_no')->with(['product_draft:id,name','master_single_image:id,draft_product_id,image_url']);
            }]);
            if($request->action){
                $defectedProductWithAction = $defectedProductWithAction->where('defect_action_id', $request->action);
            }
            if($request->start_date && !$request->end_date){
                $defectedProductWithAction = $defectedProductWithAction->whereDate('updated_at','>=',  $request->start_date);
            }
            if($request->end_date && !$request->start_date){
                $defectedProductWithAction = $defectedProductWithAction->whereDate('updated_at','<=',  $request->end_date);
            }
            if($request->start_date && $request->end_date){
                // $defectedProductWithAction = $defectedProductWithAction->whereBetween('updated_at',[date($request->start_date),date($request->end_date)]);
                $defectedProductWithAction = $defectedProductWithAction->whereDate('updated_at','>=',$request->start_date)->whereDate('updated_at','<=',$request->end_date);
            }
            $defectedProductWithAction = $defectedProductWithAction->where('defect_action_id','!=',null)->get();
            foreach($defectedProductWithAction as $row) {
                fputcsv($handle, array($row->variation_id, $row->variationInfo->product_draft->name ?? '', $row->variationInfo->image ??  $row->variationInfo->master_single_image->image_url ?? '',
                    $row->variationInfo->sku ?? '',$row->variationInfo->actual_quantity ?? '', $row->variationInfo->ean_no ?? '',$row->defected_product ?? '',
                    $row->defectReason->reason ?? '', $row->defectAction->action ?? '', $row->created_at->format('d-m-Y') ?? '', $row->updated_at->format('d-m-Y') ?? ''));
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, $filename, $headers);
        }catch(\Exception $exception){
            return back()->with('error','Something Went Wrong');
        }
    }

    public function variationModified(Request $request){
        try{
            $existAttibuteInfo = ProductVariation::find($request->variation_id);
            $existAttribute = unserialize($existAttibuteInfo->attribute);
            foreach($request->attribute as $attr){
                if($attr != ''){
                    $explodeValue = explode('/',$attr);
                    $attributeInfo = Attribute::find($explodeValue[0]);
                    $termsInfo = AttributeTerm::where('terms_name',$explodeValue[1])->first();
                    $newVariationArr = [
                        'attribute_id' => $explodeValue[0],
                        'attribute_name' => $attributeInfo->attribute_name,
                        'terms_id' => $termsInfo->id,
                        'terms_name' => $explodeValue[1]
                    ];
                    array_push($existAttribute,$newVariationArr);
                }else{
                    return response()->json(['type' => 'error', 'msg' => 'All Available Attribute Should Select']);
                }
            }
            $variation = '';
            foreach($existAttribute as $att){
                $variation .= '<label><b style="color: #7e57c2">'.$att['attribute_name'].'</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>'. $att['terms_name'].'</label>';
            }
            $newSerialize = \Opis\Closure\serialize($existAttribute);
            $updateInfo = $existAttibuteInfo->update(['attribute' => $newSerialize]);
            return response()->json(['type' => 'success','msg' => 'Variation Successfully Modified' ,'response' => $updateInfo, 'variation' => $variation]);

        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
        }
    }

    public function reformateAddProductImage(Request $request){
        $productVariationInfo = ProductVariation::where('product_draft_id',$request->catalogueId)->get();
        if(count($productVariationInfo) > 0){
            foreach($productVariationInfo as $variation){
                $serializeVariationImages = [];
                if(($variation->image_attribute == null) && ($variation->variation_images == null)){
                    $imageAttribute = ProductVariation::where('product_draft_id',$request->catalogueId)->where('image_attribute','!=',null)->first();
                    if($imageAttribute){
                        foreach(unserialize($imageAttribute->image_attribute) as $key => $value){
                            $img_attr = $key;
                        }
                        $key = array_search($img_attr, array_column(unserialize($imageAttribute->attribute), 'attribute_name'));
                        $attribute_and_terms = [
                            $img_attr => unserialize($imageAttribute->attribute)[$key]['terms_name']
                        ];
                        $serializeVariationImages[] = $variation->image;
                        $variation->image_attribute = $attribute_and_terms ? \Opis\Closure\serialize($attribute_and_terms) : null;
                        $variation->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                        $variation->save();
                    }

                }elseif(($variation->image_attribute != null) && ($variation->variation_images == null)){
                    $serializeVariationImages[] = $variation->image;
                    $variation->variation_images = \Opis\Closure\serialize($serializeVariationImages);
                    $variation->save();
                }
            }
        }
        return response()->json(['type' => 'success','msg' => 'Variation image reformated successfully']);
    }


}
