<?php
namespace App\Http\Controllers;
use App\Client;
use App\DeveloperAccount;
use App\EbayMasterProduct;
use App\EbayAccount;
use App\EbayVariationProduct;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\Invoice;
use App\OnbuyAccount;
use App\OnbuyMasterProduct;
use App\OnbuyVariationProducts;
use App\Order;
use App\Product;
use App\ProductOrder;
use App\ProductVariation;
use App\ReshelvedProduct;
use App\Role;
use App\Shelf;
use App\ShelfedProduct;
use App\Url;
use App\Vendor;
use App\woocommerce\WoocommerceCatalogue;
use App\woocommerce\WoocommerceVariation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use PHPUnit\Exception;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Validator;
use App\InvoiceProductVariation;
use Illuminate\Support\Facades\Session;
use function GuzzleHttp\Promise\all;
use App\Brand;
use App\ProductDraft;
use App\Traits\CommonFunction;

class AuthController extends Controller
{
    use CommonFunction;
    public function __construct()
    {
        $this->project_url = $this->projectUrl();
        //$this->access_token = $this->access_token();
    }

    public function access_token(){

        $consumer_key = Session::get('consumer_key');
        $secret_key = Session::get('secret_key');
        if($consumer_key == ''){
            $info = OnbuyAccount::first();
            if($info) {
                Session::put('consumer_key', $info->consumer_key);
                Session::put('secret_key', $info->secret_key);
                $consumer_key = $info->consumer_key;
                $secret_key = $info->secret_key;
            }else{
                return redirect('/onbuy/master-product-list');
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
            CURLOPT_POSTFIELDS => array('secret_key' => $secret_key,'consumer_key' => $consumer_key),
            CURLOPT_HTTPHEADER => array(

            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $token = json_decode($response);

        return $token->access_token;
    }

    /**

    login api *
    @return \Illuminate\Http\Response /
     * public function login(){ if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ $user = Auth::user(); $success['token'] = $user->createToken('myApp')-> accessToken; return response()->json(['success' => $success], 200); } else{ return response()->json(['error'=>'Unauthorised'], 401); } } /*
     *
    Register api *
    @return \Illuminate\Http\Response */
    public function login(Request $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $root_path = asset('/uploads');
            $user = User::select('id','employee_id','name','last_name','email','phone_no','card_no',DB::raw('CONCAT("'.$root_path.'/", image) AS image'),'address','country',
                'city','zip_code','state','role','email_verified_at','created_at','updated_at','deleted_at')->find($user->id);
            $success['token'] = $user->createToken('androidClient')-> accessToken;
            return response()->json(['success' => $success,'user'=>$user], 200);
        } else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function loginWithId(Request $request)
    {
        //return $request->id;
        $root_path = asset('/uploads');
        $user = User::select('id','employee_id','name','last_name','email','phone_no','card_no','image','address','country',
            'city','zip_code','state','role','email_verified_at','created_at','updated_at','deleted_at')->where('employee_id', '=', $request->id)->first();

        //Auth::login($user);
        if($user !=null){
            //$user = Auth::user();
            $success['token'] = $user->createToken('androidClient')-> accessToken;
            $user['image'] = $user->image ? $root_path.'/'.$user->image : null;
            return response()->json(['success' => $success,'user'=>$user], 200);
        } else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required', 'email' => 'required|email',
            'password' => 'required', 'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails())
        {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('androidClient')-> accessToken;
        $success['name'] = $user->name;
        return response()->json(['success'=>$success], 200);
    }
    public function client($id){
        $invoice_result = InvoiceProductVariation::get()->all();
        return response()->json(['success' => $invoice_result, 200]);
    }

    public function assignedShelfList(Request $request){
        try{
            $result = InvoiceProductVariation::where(['shelver_user_id' => $request->user_id,'shelving_status' => 0])->whereHas('productVariation', function($variation){
                $variation->where('deleted_at',null);
            })->with(['productVariation' => function($query){
                $query->with(['master_single_image' => function($image){
                    $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                }]);
            }])->orderBy('id', 'desc')->limit(30)->get();
            return response()->json(['success' => $result], 200) ;
        }catch (Exception $exception){
            return response()->json(['error' => $exception], 404) ;
        }
    }

    public function productShelve(Request $request){
        $this->invoice_id = $request->invoice_id;
        $this->product_variation_id = $request->variation_id;
        $this->product_draft_id = $request->product_draft_id;
        $this->shelf_id = $request->shelf_id;
        $this->quantity = $request->quantity;

        $invoice_result = InvoiceProductVariation::where('id',$this->invoice_id)->first();
//        print_r($invoice_result);
//        exit();

        if ($invoice_result->quantity - $invoice_result->shelved_quantity >= $request->quantity){

            //  DB::transaction(function () use ($request,$invoice_result){

            //return $this->product_variation_id;
            try{


//                try{
//                    $woocom_result = Woocommerce::get('products/'.$this->product_draft_id.'/variations/'.$this->product_variation_id);
//                }catch (HttpClientException $exception){
//
//                    return back()->with('error', $exception->getMessage());
//                }

                //$woocom_result = json_decode(json_encode($woocom_result));
                //$update_quantity = $woocom_result->stock_quantity + $this->quantity;
//                $product_variation_find = ProductVariation::find($this->product_variation_id);
//                $update_quantity = $product_variation_find->actual_quantity + $this->quantity;
//                $product_variation_find->actual_quantity = $update_quantity;
//                $result = $product_variation_find->save();
//                print_r($update_quantity);
//                exit();
//                $data = [
//                    'stock_quantity' => $update_quantity
//                ];

                // $pendingForReshelve = ReshelvedProduct::with('user:id,name')->where('variation_id', $request->variation_id)->where('status',0)->first();
                // if($pendingForReshelve){
                //     $reshelver = $pendingForReshelve->user->name ?? '';
                //     return response()->json(['error' => 'This Product Is Pending For Reshelve (Reshelver: '.$reshelver.'). First Reshelve The Product, Then Shelve Again'],404);
                // }

                $this->shelf_product_result = ShelfedProduct::where(['variation_id' => $this->product_variation_id,'shelf_id' => $this->shelf_id])->get()->first();

                if ( $this->shelf_product_result ==null){

                    //  $result = ShelfedProduct::create($request->all());
                    $result = ShelfedProduct::create([
                        'shelf_id' => $request->shelf_id,
                        'variation_id' => $request->variation_id,
                        'quantity' => $request->quantity
                    ]);

                    $shelved_updated_quantity = $invoice_result->shelved_quantity + $this->quantity;
                    $invoice_result->shelved_quantity = $shelved_updated_quantity;
                    if ($invoice_result->quantity == $shelved_updated_quantity){
                        $invoice_result->shelving_status = 1;
                        $invoice_result->shelve_error = 0;
                    }
                    $invoice_result->save();

                }elseif( $this->shelf_product_result != null ){
                    $shelf_update_quantity = $this->shelf_product_result->quantity + $this->quantity;
                    $update_result = ShelfedProduct::find($this->shelf_product_result->id);
                    $update_result->quantity = $shelf_update_quantity;
                    $update_result->save();

                    $shelved_updated_quantity = $invoice_result->shelved_quantity + $this->quantity;
                    $invoice_result->shelved_quantity = $shelved_updated_quantity;
                    if ($invoice_result->quantity == $shelved_updated_quantity){
                        $invoice_result->shelving_status = 1;
                        $invoice_result->shelve_error = 0;
                    }
                    $invoice_result->save();

                }
                $sku = ProductVariation::find($this->product_variation_id)->sku;
                $check_quantity = new CheckQuantity();
                $check_quantity->checkQuantity($sku,null,null,'Shelve Quantity Through App',null,true,null);

//                $woocom_find_result = WoocommerceCatalogue::where('master_catalogue_id',$this->product_draft_id)->get()->first();
//                $onbuy_find_result = OnbuyMasterProduct::where('woo_catalogue_id',$this->product_draft_id)->get()->first();
//                $ebay_find_result = EbayMasterProduct::where('master_product_id',$this->product_draft_id)->get()->first();
//
//                if ($woocom_find_result != null){
//                    $woocom_variation = WoocommerceVariation::where('woocom_variation_id',$this->product_variation_id)->first();
//                    if($woocom_variation) {
//                        try {
//                            $woo_result = Woocommerce::put('products/' . $woocom_variation->woocom_master_product_id . '/variations/' . $woocom_variation->id, $data);
//                            $woocom_variation = WoocommerceVariation::where('woocom_variation_id',$this->product_variation_id)->update(['actual_quantity' => $update_quantity]);
//
//                        } catch (HttpClientException $exception) {
//
////                            return back()->with('error', $exception->getMessage());
//                            //continue;
//                        }
//                    }
//                }
//
//                if ($onbuy_find_result != null){
//                    $update_onbuy_quantity_info = OnbuyVariationProducts::where('sku',$product_variation_find->sku)->first();
//                    if($update_onbuy_quantity_info) {
//                        try {
//                            $this->updateOnbuyQuantity($update_quantity, $product_variation_find->sku);
//                        } catch (Exception $exception) {
////                            echo $exception;
//                            //continue;
//                        }
//                        $update_onbuy_quantity = OnbuyVariationProducts::find($update_onbuy_quantity_info->id)->update([
//                            'stock' => $update_quantity
//                        ]);
//
//                    }
//
//                }
//
//                if ($ebay_find_result != null){
//                    try{
//
//                        $item_id = $ebay_find_result->item_id;
//                        $site_id = $ebay_find_result->site_id;
//                        $ebay_update = EbayVariationProduct::where('sku',$product_variation_find->sku)->update(['quantity'=>$update_quantity]);
//
//                        //$onbuyProductQuantity = $this->getOnbuyQuantity($product->sku);
//                        $this->updateEbayQuantity($product_variation_find->sku,$update_quantity);
//                    }catch (Exception $exception){
////                        echo $exception;
//                        //continue;
//                    }
//                }



            }catch (Exception $exception){
                return response()->json(['error' => $exception],404);
            }


            //  });
            return response()->json(['success'=>$invoice_result],200);
        }else{
            return response()->json(['error'=>'quantity mismatched'],404);
        }



    }
    public function updateOnbuyQuantity($quantity,$sku){
        $this->access_token = $this->access_token();
        $data[] = [
            "sku"=> $sku,
            "stock" => $quantity
        ];
        $update_info= [
            "site_id" => 2000,
            "listings" => $data
        ];
        try{
            $product_info = json_encode($update_info);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.onbuy.com/v2/listings/by-sku",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS =>$product_info,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: ".$this->access_token,
                    "Content-Type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }catch (Exception $exception){
            echo $exception;
        }

    }

    public function updateEbayQuantity($sku,$quantity){


        $sku = $sku;
        $quantity = $quantity;
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
                            <SKU>'.$sku.'</SKU>

                            <Quantity>'.$quantity.'</Quantity>

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

    public function ebayAccessToken($refresh_token){
        $developer_result = DeveloperAccount::get()->first();

        $clientID  = $developer_result->client_id;
        $clientSecret  = $developer_result->client_secret;
//dd($token_result->authorization_token);
        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $refresh_token,
            'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        $this->ebay_update_access_token =  $response['access_token'];
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

    public function assignedOrderList(Request $request){

        // Try 1 start //
//        $info = Order::select('orders.id AS o_id','orders.order_number','orders.status','orders.date_created','product_orders.variation_id','product_orders.name',
//            'product_orders.quantity','product_shelfs.shelf_id','shelfs.id','shelfs.shelf_name')
//            ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
//            ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
//            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
//            ->join('shelfs','product_shelfs.shelf_id','=','shelfs.id')
//            ->where('orders.picker_id', $request->user_id)
//            ->where('orders.status','processing')
//            ->orderBy('shelfs.id','asc')
//            ->get()->all();
//        foreach ($info as $value){
//            $infos[] = $value->o_id;
//        }
//        $vals = array_count_values($infos);
//        foreach ($vals as $key => $value){
//            foreach ($info as $info_value){
//                if($key == $info_value->o_id){
//                    $data[] = [
//                        'order_id' => $info_value->o_id,
//                        'order_number' => $info_value->order_number,
//                        'status' => $info_value->status,
//                        'order_product' => $value,
//                        'order_date' => $info_value->date_created,
//                        'shelf_id' => $info_value->shelf_id,
//                        'shelf_name' => $info_value->shelf_name,
//                    ];
//                    break;
//                }
//            }
//        }
//        return response()->json(['success' => $data]);
        // Try 1 end //

        // Try 2 start //
//        $data = Order::where(['picker_id'=> $request->user_id,'status' => 'processing'])->with(['productOrders' => function($query) {
//            $query->with('shelf_quantity')->orderBy('id','asc');
//        }])->get()->all();
//        $data = array();
//        foreach ($result as $result){
//            if(gettype($result->product_orders) != NULL) {
//                if(gettype($result->product_orders->shelf_quantity) != NULL){
//                    array_push($data, $result->id);
//                }
//            }
//        }
//        return response()->json(['success'=> $data],200) ;
        // Try 2 end //

//        echo "<pre>";
//        print_r($info);
//        exit();

        $result = Order::where(['picker_id'=> $request->user_id,'status' => 'processing'])->with(['productOrders'=> function($query){
            $query->with(['product_draft' => function($query_image){
                $query_image->with(['single_image_info' => function($image){
                    $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                }]);
            }]);
        }])->orderByDesc('id')->get();

        return response()->json(['success'=> $result],200) ;
    }

    public function productPick(Request $request){
        if(!isset($request->bulk_picking)){
            $product_order_result = ProductOrder::find($request->product_order_id);
            $shelf_product_result = ShelfedProduct::where(['variation_id' => $request->variation_id,'shelf_id'=>$request->shelf_id])->where('quantity','>',0)->get()->first();

            if ($product_order_result->quantity - $product_order_result->picked_quantity >= $request->quantity){
                DB::transaction(function () use ($request,$shelf_product_result,$product_order_result){
                    try{
                        $this->shelf_product_update = ShelfedProduct::find($shelf_product_result->id);
                        $picked_update_quantity = $product_order_result->picked_quantity + $request->quantity;
                        $this->shelf_product_update_quantity = $this->shelf_product_update->quantity - $request->quantity;
                        $this->shelf_product_update->quantity =$this->shelf_product_update_quantity;
                        $product_order_result->picked_quantity = $picked_update_quantity;
                        if ($picked_update_quantity == $product_order_result->quantity){
                            $product_order_result->status = 1;
                        }
                        $product_order_result->updated_at = Carbon::now();
                        $this->shelf_product_update->save();
                        $product_order_result->save();

                    }catch (Exception $exception){
                        return response()->json(['error' => $exception],404);
                    }

                });

                return response()->json(['success' => $this->shelf_product_update],200);
            }else{
                return response()->json(['message' => 'Please give valid quantity'],404);
            }
        }elseif($request->bulk_picking == 'sku'){
            $allOrderProduct = ProductOrder::select('orders.id as order_pk_id','orders.order_number','orders.status as order_status','orders.date_created','product_orders.*')
            ->join('orders','product_orders.order_id','=','orders.id')
            ->where('orders.status','processing')
            ->where('orders.picker_id',$request->picker_id)
            ->where('product_orders.variation_id',$request->variation_id)
            ->where('product_orders.status',0)
            ->orderBy('date_created','ASC')
            ->get();
            if(($allOrderProduct->sum('quantity') - $allOrderProduct->sum('picked_quantity')) < $request->quantity){
                return response()->json(['type' => 'warning','message' => 'Quantity Given More Than Pickable Quantity'],200);
            }
            if(!empty($allOrderProduct)){
                $shelfInfo = ShelfedProduct::where('variation_id',$request->variation_id)->where('shelf_id',$request->shelf_id)->get();
                if(count($shelfInfo) > 0){
                    $quantity = $request->quantity;
                    $totalShelfDecrementQuantity = 0;
                    $totalOrderDecrementQuantity = 0;
                    foreach($shelfInfo as $shelf){
                        if($quantity >= $shelf->quantity){
                            $decrementQuantity = ShelfedProduct::find($shelf->id)->decrement('quantity',$shelf->quantity);
                            $quantity = $quantity - $shelf->quantity;
                            $totalShelfDecrementQuantity += $shelf->quantity;
                        }elseif($quantity < $shelf->quantity){
                            $decrementQuantity = ShelfedProduct::find($shelf->id)->decrement('quantity',$quantity);
                            $totalShelfDecrementQuantity += $quantity;
                            break;
                        }elseif($quantity == 0){
                            $totalShelfDecrementQuantity = $totalShelfDecrementQuantity;
                        }
                    }
                    if($totalShelfDecrementQuantity > 0){
                        foreach($allOrderProduct as $order){
                            if($totalShelfDecrementQuantity >= $order->quantity){
                                $orderPickedStatus = ProductOrder::find($order->id)->update(['picked_quantity' => $order->quantity, 'status' => 1]);
                                $totalShelfDecrementQuantity -= $order->quantity;
                            }elseif($totalShelfDecrementQuantity < $order->quantity){
                                $orderPickedStatus = ProductOrder::find($order->id);
                                $totalPicked = $orderPickedStatus->picked_quantity + $totalShelfDecrementQuantity;
                                $orderPickedStatus->picked_quantity = $totalPicked;
                                if($totalPicked == $orderPickedStatus->quantity){
                                    $orderPickedStatus->status = 1;
                                }
                                $orderPickedStatus->save();
                                $totalShelfDecrementQuantity = $order->quantity - $totalShelfDecrementQuantity;
                                break;
                            }else{
                                $totalShelfDecrementQuantity = $totalShelfDecrementQuantity;
                            }
                        }
                    }else{
                        return response()->json(['type' => 'warning','message' => 'No Product Found In The Shelf'],200);
                    }
                    return response()->json(['type' => 'success','message' => 'Successfully Bulk SKU Picked'],200);
                }else{
                    return response()->json(['type' => 'warning','message' => 'No Shelf Found'],200);
                }
            }else{
                return response()->json(['type' => 'warning','message' => 'No Product Found'],200);
            }
        }else{
            return response()->json(['type' => 'warning','message' => 'No Product Found']);
        }

    }

    public function productReshelve(Request $request){
        $variation_info = ProductVariation::where('id','LIKE',$request->variation_id)->orWhere('sku','LIKE',$request->variation_id)->orWhere('ean_no','LIKE',$request->variation_id)->first();
        if(!isset($variation_info)){
            return response()->json(['error'=>'SKU or EAN not found'],404);
        }
        $this->id = $variation_info->id;
        $product_shelf_result = ShelfedProduct::where(['variation_id' => $this->id,'shelf_id' => $request->shelf_id])->get()->first();

        if ($product_shelf_result->quantity >= $request->quantity){
            DB::transaction(function ()use ($request,$product_shelf_result){
                $product_shelf_update = ShelfedProduct::find($product_shelf_result->id);

                $shelf_update_quantity = $product_shelf_result->quantity - $request->quantity;

                $product_shelf_update->quantity = $shelf_update_quantity;
                $product_shelf_update->save();

//                $this->reshelve_result = ReshelvedProduct::create($request->all());
                $this->reshelve_result = ReshelvedProduct::create([
                    'shelf_id' => $request->shelf_id,
                    'variation_id' => $this->id,
                    'quantity' => $request->quantity,
                    'user_id' => $request->user_id

                ]);
            });

            return response()->json(['success'=>$this->reshelve_result],200);
        }else{
            return response()->json(['error'=>'Quantity Mismatch'],200);
        }

    }

    public function reshelveProductList(Request $request){
        $reshelve_product_result = ReshelvedProduct::with(['variation_info' => function($product){
            $product->select('id','product_draft_id','sku','ean_no','image')->with(['master_single_image' => function($master_image){
                $master_image->select('draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) as image_url"));
            }]);
        }])->where(['user_id' => $request->user_id,'status' => 0])->get()->all();

        return response()->json(['success'=>$reshelve_product_result],200);
    }

    public function shelveReshelvedProduct(Request $request){
        $reshelve_result = ReshelvedProduct::find($request->reshelve_id);

        if ($reshelve_result->quantity >= $reshelve_result->shelved_quantity + $request->quantity){
            $shelf_product_result = ShelfedProduct::where(['variation_id' => $request->variation_id,'shelf_id' => $request->shelf_id])->get()->first();

            DB::transaction(function ()use ($request,$reshelve_result,$shelf_product_result){
                if ($shelf_product_result != null){
                    $shelf_product_update = ShelfedProduct::find($shelf_product_result->id);

                    $shelf_update_quantity = $shelf_product_update->quantity + $request->quantity;
                    $shelf_product_update->quantity = $shelf_update_quantity;
                    $reshelve_update_quantity = $reshelve_result->shelved_quantity + $request->quantity;
                    $reshelve_result->shelved_quantity = $reshelve_update_quantity;
                    if ($reshelve_update_quantity == $reshelve_result->quantity){
                        $reshelve_result->status = 1;
                    }
                    $shelf_product_update->save();
                    $reshelve_result->save();

                }elseif ($shelf_product_result == null){
                    $shelf_product_create_result = ShelfedProduct::create($request->all());
                    $reshelve_result = ReshelvedProduct::find($request->reshelve_id);
                    $reshelve_quantity_update = $reshelve_result->shelved_quantity + $request->quantity;
                    $reshelve_result->shelved_quantity = $reshelve_quantity_update;
                    if ($reshelve_quantity_update == $reshelve_result->quantity){
                        $reshelve_result->status = 1;
                    }
                    $reshelve_result->save();
                }
            });
            $reshelve_result['quantity'] = $reshelve_result->quantity - $reshelve_result->shelved_quantity;
            return response()->json(['success' => $reshelve_result],200);
        }
        return response()->json(['erroe' => 'quantity'],404);
    }

    public function productShelveList(Request $request){
        $variation_id = $request->variation_id;

        $sort_shelf_ids = Shelf::select('shelfs.id as shelf_id','product_shelfs.id as id')
            ->join('product_shelfs','shelfs.id','=','product_shelfs.shelf_id')
            ->where('product_shelfs.variation_id',$variation_id)
            ->where('product_shelfs.quantity','>',0)
            ->orderBy('shelfs.shelf_name','asc')
            ->get();

        $shelf_ids = [];
        if(count($sort_shelf_ids) > 0){
            foreach ($sort_shelf_ids as $info){
                array_push($shelf_ids,$info->id);
            }
            $implode_id = implode(',',$shelf_ids);
            $result = ShelfedProduct::with(['shelf_info:id,shelf_name'])
                ->where( [['quantity','!=',0]])
                ->whereIn('id',$shelf_ids)
                ->orderByRaw("FIELD(id, $implode_id)")
                ->get();

            return response()->json(['success' => $result],200);
        }else{
            return response()->json(['message' => 'No Shelf Found'],200);
        }

    }

    public function appUrl(Request $request){
//        $app_url_info = Url::first();
        $app_url_info = Client::where('client_id',$request->client_id)->first();
        if($app_url_info) {
            return response()->json(['success' => $app_url_info], 200);
        }else{
            return response()->json(['error' => 'Not found'], 200);
        }
    }

    public function singleShelfProduct(Request $request){
        $total_product = 0;
        $single_shelf_product = Shelf::with('total_product')->where('id',$request->shelf_id)->first();
        $total_distinct_product = count($single_shelf_product->total_product);
        if(isset($single_shelf_product)) {
            foreach ($single_shelf_product->total_product as $shelf) {
                $total_product += $shelf->pivot->quantity;
            }
            return response()->json(['total_product' => $total_product, 'total_distinct_product' => $total_distinct_product, 'data' => $single_shelf_product], 200);
        }else{
            return response()->json(['error' => 'Shelf not found'], 404);
        }
    }

    /*
     * Below function for Shelver App
     * Function : shelfedProductListBySKU
     * Route : shelfed-product-list-by-sku
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for getting product info by id, sku and ean.
     * Created Date: unknown
     * Modified Date : 23-11-2020
     * Modified Content : Supplier company name instead of name and return message
     */
    public function shelfedProductListBySKU(Request $request){
        $variation_info = ProductVariation::select(['id','product_draft_id','image','sku','actual_quantity','ean_no','sale_price','attribute'])
            ->with(['master_single_image' => function($image){
                $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
            },'product_draft:id,name,brand_id'])
            ->where('id','LIKE',$request->sku)
            ->orWhere('sku','LIKE',$request->sku)
            ->orWhere('ean_no','LIKE',$request->sku)->first();
        $variation = '';
        if($variation_info) {
            $shelfQuantity = ShelfedProduct::where('variation_id',$variation_info->id)->sum('quantity');
            $changed_variation_info = [
                "id" => $variation_info->id ?? '',
                "product_draft_id" => $variation_info->product_draft_id ?? '',
                'product_draft' => [
                    'id' => $variation_info->product_draft->id ?? '',
                    'name' => $variation_info->product_draft->name ?? '',
                    'brand' => $variation_info->product_draft->brand_id ? $this->getWmsBrandName($variation_info->product_draft->brand_id) : ''
                ],
                "image" => $variation_info->image ?? '',
                "sku" => $variation_info->sku ?? '',
                "actual_quantity" =>  (int) $shelfQuantity ??$variation_info->actual_quantity ?? '',
                "ean_no" =>  $variation_info->ean_no ?? '',
                "sale_price" => $variation_info->sale_price ?? '',
                "master_single_image" => $variation_info->master_single_image ?? '',
                "variation" => '',
            ];
            if($variation_info->attribute != null) {
                foreach (\Opis\Closure\unserialize($variation_info->attribute) as $variation) {
                    $changed_variation_info[$variation["attribute_name"]] = $variation["terms_name"] ?? '';
                    $changed_variation_info["variation"] = $changed_variation_info["variation"] . ' ' . $variation["terms_name"] ?? '';
                }
            }
            $result = ShelfedProduct::with(['shelf_info:id,shelf_name'])->where(['variation_id' => $variation_info->id])
                ->where('quantity', '>', 0)->get();
            return response()->json(['product_info' => $changed_variation_info, 'success' => $result], 200);
        }else{
            return response()->json(['message' => 'No product found'], 200);
        }
    }

    public function searchAssignShelfList(Request $request){
        $variation_info = ProductVariation::where('id','LIKE',$request->search_value)->orWhere('sku','LIKE',$request->search_value)
            ->orWhere('ean_no','LIKE',$request->search_value)->first();
        if(isset($variation_info)){
            $info = InvoiceProductVariation::with(['productVariation' => function($query){
                $query->with(['master_single_image' => function($image){
                    $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                }]);
            }])->where(['shelver_user_id' => $request->user_id,'shelving_status' => 0, 'product_variation_id' => $variation_info->id])->get();
//        $info = ProductVariation::with(['invoiceProductVariations' => function ($query) use ($request,$id){
//            $query->where(['shelver_user_id' => $request->user_id,'shelving_status' => 0,'product_variation_id' => $id->id]);
//        }])->where('id',$request->search_value)->orWhere('sku',$request->search_value)->orWhere('ean_no',$request->search_value)->get();
            if(isset($info)) {
                return response()->json(['data' => $info],200);
            }else{
                return response()->json(['error' => 'No data found'],404);
            }
        }else{
            return response()->json(['error' => 'Something error'],404);
        }

    }

    /*
     * Below function for Picker App
     * Function : filterAssignedOrderList
     * Route : filter-assigned-oder-list
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for displaying all assigned order to user with filter option and pagination
     * Created Date: unknown
     * Modified Date : 22-11-2020
     * Modified Content : Foreach loop of result variable and isset condition
     */
    public function filterAssignedOrderList(Request $request){
        $limit = 20;
        $offset = $offset = (($request->offset_value ?? 0) - 1) * $limit;
        $query_info = [];
        $update_result = array();
        $variation = '';
        if($request->filter_value == 'shelfwise') {
            $query_info = Order::select('orders.id AS order_id', 'orders.order_number','shelfs.shelf_name','shelfs.id','product_variation.id as variation_id')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->where('product_shelfs.quantity','>',0)
                ->orderBy('shelfs.shelf_name', 'asc')
                ->groupBy('orders.id')
                ->groupBy('product_variation.id')
                ->groupBy('orders.order_number')
//                ->groupBy('shelfs.shelf_name')
                ->limit($limit)
                ->offset($offset)
                ->get();
//            return response($query_info);
            $total_result = Order::select('orders.id AS order_id', 'orders.order_number','shelfs.shelf_name','shelfs.id','product_variation.id as variation_id')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->where('product_shelfs.quantity','>',0)
                ->orderBy('shelfs.shelf_name', 'asc')
                ->groupBy('orders.id')
                ->groupBy('product_variation.id')
                ->groupBy('orders.order_number')
//                ->groupBy('shelfs.shelf_name')
                ->get();
        }elseif($request->filter_value == 'postcodewise'){
            $query_info = Order::select('orders.id AS order_id','orders.shipping_post_code')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->where([['orders.status', 'processing'],['orders.shipping_post_code','!=',null]])
                ->where([['orders.picker_id', '=', $request->user_id],['product_orders.status',0]])
                ->orderBy('orders.shipping_post_code', 'asc')
                ->groupBy('orders.shipping_post_code')
                ->groupBy('orders.id')
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select('orders.id AS order_id','orders.shipping_post_code')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->where([['orders.status', 'processing'],['orders.shipping_post_code','!=',null]])
                ->where([['orders.picker_id', '=', $request->user_id],['product_orders.status',0]])
                ->orderBy('orders.shipping_post_code', 'asc')
                ->groupBy('orders.shipping_post_code')
                ->groupBy('orders.id')
                ->get();
        }elseif($request->filter_value == 'skuwise'){
            $query_info = Order::select('orders.id AS order_id', 'orders.order_number','product_variation.sku')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->orderBy('product_variation.sku', 'asc')
                ->groupBy('orders.id')
                ->groupBy('orders.order_number')
                ->groupBy('product_variation.sku')
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select('orders.id AS order_id', 'orders.order_number','product_variation.sku')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->orderBy('product_variation.sku', 'asc')
                ->groupBy('orders.id')
                ->groupBy('orders.order_number')
                ->groupBy('product_variation.sku')
                ->get();
        }elseif($request->filter_value == 'datewise'){
            $query_info = Order::select('orders.id AS order_id', 'orders.order_number','orders.date_created')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->orderBy('orders.date_created', 'desc')
                ->groupBy('orders.id')
                ->groupBy('orders.order_number')
                ->groupBy('orders.date_created')
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select('orders.id AS order_id', 'orders.order_number','orders.date_created')
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->orderBy('orders.date_created', 'desc')
                ->groupBy('orders.id')
                ->groupBy('orders.order_number')
                ->groupBy('orders.date_created')
                ->get();
        }elseif($request->filter_value == 'groupshelf'){
            $query_info = Order::select('shelfs.id','shelfs.shelf_name',DB::raw('count(shelfs.shelf_name) as total_product'))
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->where('product_shelfs.quantity','>',0)
                ->where([['product_orders.deleted_at',null],['product_variation.deleted_at',null],
                    ['product_shelfs.deleted_at',null],['shelfs.deleted_at',null]])
//                ->where('product_orders.quantity','>=','product_shelfs.quantity')
                ->orderBy('shelfs.shelf_name', 'asc')
                ->groupBy('shelfs.id')
                ->groupBy('shelfs.shelf_name')
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select('shelfs.id','shelfs.shelf_name',DB::raw('count(shelfs.shelf_name) as total_product'))
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
                ->where('product_shelfs.quantity','>',0)
                ->where([['product_orders.deleted_at',null],['product_variation.deleted_at',null],
                    ['product_shelfs.deleted_at',null],['shelfs.deleted_at',null]])
//                ->where('product_orders.quantity','>=','product_shelfs.quantity')
                ->orderBy('shelfs.shelf_name', 'asc')
                ->groupBy('shelfs.id')
                ->groupBy('shelfs.shelf_name')
                ->get();
            $groupShelfOrders = [];
            if(count($query_info) > 0) {
                $total_row = ceil(count($total_result) / $limit);
                foreach($query_info as $info){
                    $groupShelfOrders[] = [
                        'id' => $info->id,
                        'shelf_name' => $info->shelf_name,
                        'total_product' => $info->total_product,
                        'group_shelf_order' => $this->singleShelfOrderedProductList($request->user_id, $info->id)
                    ];
                }
                return response()->json(['pagination' => $total_row, 'success' => $groupShelfOrders], 200);
            }else{
                return response()->json(['success' => 'No order found'], 200);
            }
        }elseif($request->filter_value == 'grouppostcode'){
            $query_info = Order::select(DB::raw('count(orders.shipping_post_code) as order_count'),'orders.shipping_post_code')->where([['orders.status', 'processing'],['orders.shipping_post_code','!=',null],['orders.picker_id',$request->user_id]])
                ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                ->where('product_orders.status',0)
                ->havingRaw('count(shipping_post_code) > 1')
                ->orderBy('order_count','DESC')
                ->groupBy(['shipping_post_code'])
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select(DB::raw('count(orders.shipping_post_code) as order_count'),'orders.shipping_post_code')->where([['orders.status', 'processing'],['orders.shipping_post_code','!=',null],['orders.picker_id',$request->user_id]])
                ->leftJoin('product_orders','orders.id','=','product_orders.order_id')
                ->where('product_orders.status',0)
                ->havingRaw('count(shipping_post_code) > 1')
                ->orderBy('order_count','DESC')
                ->groupBy(['shipping_post_code'])
                ->get();
            $groupPostcodeOrders = [];
            if(count($query_info) > 0){
                $total_row = ceil(count($total_result) / $limit);
                foreach($query_info as $info){
                    $groupPostcodeOrders[] = [
                        'order_count' => $info->order_count,
                        'shipping_post_code' => $info->shipping_post_code,
                        'group_postcode_order' => $this->groupPostcodeOrderedProductList($request->user_id, $info->shipping_post_code)
                    ];
                }
                return response()->json(['pagination' => $total_row, 'success' => $groupPostcodeOrders],200);
            }else{
                return response()->json(['success' => 'No order found'],200);
            }

        }elseif($request->filter_value == 'groupsku'){
            $query_info = Order::select('product_orders.variation_id','product_variation.sku',
                DB::raw('sum(product_orders.quantity) as total_product'))
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
//                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
//                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
//                ->where('product_shelfs.quantity','>',0)
                ->where([['product_orders.deleted_at',null],['product_variation.deleted_at',null]])
                ->havingRaw('sum(product_orders.quantity) > 1')
                ->orderBy('total_product', 'desc')
                ->groupBy('product_variation.sku')
                ->groupBy('product_orders.variation_id')
                ->limit($limit)
                ->offset($offset)
                ->get();
            $total_result = Order::select('product_orders.variation_id','product_variation.sku',
                DB::raw('sum(product_orders.quantity) as total_product'))
                ->leftJoin('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
//                ->join('product_shelfs', 'product_variation.id', '=', 'product_shelfs.variation_id')
//                ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                ->where('orders.status', 'processing')
                ->where('orders.picker_id', '=', $request->user_id)
                ->where('product_orders.status',0)
//                ->where('product_shelfs.quantity','>',0)
                ->where([['product_orders.deleted_at',null],['product_variation.deleted_at',null]])
                ->havingRaw('sum(product_orders.quantity) > 1')
                ->orderBy('total_product', 'desc')
                ->groupBy('product_variation.sku')
                ->groupBy('product_orders.variation_id')
                ->get();
            $groupSkuOrders = [];
            if(count($query_info) > 0) {
                $total_row = ceil(count($total_result) / $limit);
                foreach($query_info as $info){
                    $groupSkuOrders[] = [
                        'variation_id' => $info->variation_id,
                        'sku' => $info->sku,
                        'total_product' => $info->total_product,
                        'group_postcode_order' => $this->groupSkuOrderList($request->user_id, $info->variation_id)
                    ];
                }
                return response()->json(['pagination' => $total_row, 'success' => $groupSkuOrders],200);
            }else{
                return response()->json(['success' => 'No order found'], 200);
            }
        }
        $order_id = [];
        if(count($query_info) > 0){
            foreach ($query_info as $info){
                array_push($order_id,$info->order_id);
            }
            $implode_id = implode(',',$order_id);
        }

        if(count($order_id) > 0) {
            if($request->filter_value != 'shelfwise') {
                $result = Order::select('id', 'order_number', 'shipping_post_code', 'total_price', 'date_created as order_date')->with(['productOrders' => function ($query) {
                    $query->select(['variation_id as id', 'product_draft_id', 'image', 'sku', 'actual_quantity', 'ean_no', 'attribute'])
                        ->with(['shelf_quantity' => function ($query) {
                            $query->select('shelf_name')->where('quantity', '>', 0);
                        }, 'product_draft' => function ($query_image) {
                            $query_image->select(['id', 'name'])
                                ->with(['single_image_info' => function($image){
                                    $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                                }]);
                        }])->where('status', 0);
                }])->whereIn('id', $order_id)
                    ->orderByRaw("FIELD(id, $implode_id)")
                    ->get();
            }else {
                foreach ($query_info as $info) {
                    $result[] = Order::select('id', 'order_number', 'shipping_post_code', 'total_price', 'date_created as order_date')->with(['productOrders' => function ($query) use ($info) {
                        $query->join('product_shelfs', 'product_shelfs.variation_id', '=', 'product_variation.id')
                            ->join('shelfs', 'product_shelfs.shelf_id', '=', 'shelfs.id')
                            ->where('product_shelfs.quantity', '>', 0)
                            ->orderBy('shelfs.shelf_name', 'asc')
                            ->groupBy('product_variation.id')
                            ->groupBy('product_variation.product_draft_id')
                            ->where('product_variation.id', $info->variation_id)
                            ->select(['product_variation.id', 'product_variation.product_draft_id'])->with(['shelf_quantity' => function ($query) use ($info) {
                                $query->select('shelf_name')->where('quantity', '>', 0)->orderBy('shelf_name');
                            }, 'product_draft' => function ($query) {
                                $query->select(['id', 'name'])->with(['single_image_info' => function($image){
                                    $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                                }]);
                            }, 'getSelfVariation:id,product_draft_id,image,sku,actual_quantity,ean_no,attribute'])
                            ->where('status', 0);
                    }])->where('id', $info->order_id)
                        ->orderByRaw("FIELD(id, $implode_id)")
                        ->first();
                }
            }
//            return response()->json($result);
//        return $result[0]->productOrders[0]->id;
            foreach ($result as $order){
                $update_result["id"]= $order->id ?? '';
                $update_result["order_number"] = $order->order_number ?? '';
                $update_result["shipping_post_code"]= $order->shipping_post_code ?? '';
                $update_result["total_price"]= $order->total_price ?? '';
                $update_result["order_date"] = $order->order_date ?? '';

                if($request->filter_value == 'shelfwise') {
                    foreach ($order->productOrders as $key => $product_variation) {
                        $variation = '';
                        $update_result["product_orders"][$key]["id"] = $product_variation->getSelfVariation->id ?? '';
                        $update_result["product_orders"][$key]["product_draft_id"] = $product_variation->getSelfVariation->product_draft_id ?? '';
                        $update_result["product_orders"][$key]["image"] = $product_variation->getSelfVariation->image ?? '';
                        $update_result["product_orders"][$key]["sku"] = $product_variation->getSelfVariation->sku ?? '';
                        $update_result["product_orders"][$key]["actual_quantity"] = $product_variation->getSelfVariation->actual_quantity ?? '';
                        $update_result["product_orders"][$key]["ean_no"] = $product_variation->getSelfVariation->ean_no ?? '';
                        $update_result["product_orders"][$key]["pivot"] = $product_variation->pivot ?? '';
                        $update_result["product_orders"][$key]["shelf_quantity"] = $product_variation->shelf_quantity ?? '';
                        $update_result["product_orders"][$key]["product_draft"] = $product_variation->product_draft ?? '';
                        if ($product_variation->getSelfVariation->attribute) {
                            foreach (\Opis\Closure\unserialize($product_variation->getSelfVariation->attribute) as $attribute) {
//                        $update_result["product_orders"][$key][$attribute["attribute_name"]] = $attribute["terms_name"] ?? '';
                                $variation .= $attribute["terms_name"] . ',';
                            }
                        }
                        $update_result["product_orders"][$key]["variation"] = rtrim($variation, ',');
                    }
                }else{
                    foreach ($order->productOrders as $key => $product_variation) {
                        $variation = '';
                        $update_result["product_orders"][$key]["id"] = $product_variation->id ?? '';
                        $update_result["product_orders"][$key]["product_draft_id"] = $product_variation->product_draft_id ?? '';
                        $update_result["product_orders"][$key]["image"] = $product_variation->image ?? '';
                        $update_result["product_orders"][$key]["sku"] = $product_variation->sku ?? '';
                        $update_result["product_orders"][$key]["actual_quantity"] = $product_variation->actual_quantity ?? '';
                        $update_result["product_orders"][$key]["ean_no"] = $product_variation->ean_no ?? '';
                        $update_result["product_orders"][$key]["pivot"] = $product_variation->pivot ?? '';
                        $update_result["product_orders"][$key]["shelf_quantity"] = $product_variation->shelf_quantity ?? '';
                        $update_result["product_orders"][$key]["product_draft"] = $product_variation->product_draft ?? '';
                        if ($product_variation->attribute) {
                            foreach (\Opis\Closure\unserialize($product_variation->attribute) as $attribute) {
//                        $update_result["product_orders"][$key][$attribute["attribute_name"]] = $attribute["terms_name"] ?? '';
                                $variation .= $attribute["terms_name"] . ',';
                            }
                        }
                        $update_result["product_orders"][$key]["variation"] = rtrim($variation, ',');
                    }
                }
                $all_order[] = $update_result;
                $update_result = [];
            }
            $total_row = ceil(count($total_result) / $limit);
            return response()->json(['pagination' => $total_row, 'success' => $all_order], 200);
        }
        else{
            return response()->json(['message' => 'No order found'], 200);
        }
    }

    /*
     * Below function for Shelver App
     * Function : shelverHistory
     * Route : shelver-history
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for displaying all shelved product of a user
     * Created Date: unknown
     * Modified Date : 22-11-2020
     * Modified Content : Foreach loop of result variable and isset condition
     */
    public function shelverHistory(Request $request){
        $updated_shelve_product = array();
        $variation= '';
        $invoice_by_filter = Invoice::select('invoice_product_variation.id')
            ->join('invoice_product_variation', 'invoices.id', '=', 'invoice_product_variation.invoice_id')
            ->where([['invoice_product_variation.shelver_user_id', $request->user_id],
                ['invoice_product_variation.shelving_status', $request->filter_option == 'pending' ? 0 : 1],
                ['invoice_product_variation.deleted_at','=', null]])
            ->orderBy('invoices.receive_date', 'desc')
            ->limit(20)
//            ->offset($offset)
            ->get();
        if (count($invoice_by_filter) > 0){
            $ids = [];
            foreach ($invoice_by_filter as $filter_value){
                array_push($ids,$filter_value->id);
            }
            $implode_id = implode(',',$ids);
            $shelve_product = InvoiceProductVariation::select(['id', 'invoice_id', 'product_variation_id', 'quantity', 'shelved_quantity', 'price', 'total_price', 'shelving_status'])
                ->with(['user_shelved_invoice_no:id,invoice_number,receive_date', 'user_shelved_product' => function ($query) {
                    $query->select(['id', 'product_draft_id', 'sku', 'ean_no', 'image', 'regular_price', 'sale_price', 'attribute'])
                        ->with(['product_draft' => function ($query) {
                            $query->select('id')->with(['single_image_info' => function($image){
                                $image->select('id as image_id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                            }]);
                        }]);
                }])
                ->whereIn('id',$ids)
                ->orderByRaw("FIELD(id, $implode_id)")
                ->get();

            foreach ($shelve_product as $shelve_product){
                $updated_shelve_product["id"] = $shelve_product->id ?? '';
                $updated_shelve_product["invoice_id"] = $shelve_product->invoice_id ?? '';
                $updated_shelve_product["product_variation_id"] = $shelve_product->product_variation_id ?? '';
                $updated_shelve_product["quantity"] = $shelve_product->quantity ?? '';
                $updated_shelve_product["shelved_quantity"] = $shelve_product->shelved_quantity ?? '';
                $updated_shelve_product["price"] = $shelve_product->price ?? '';
                $updated_shelve_product["total_price"] = $shelve_product->total_price ?? '';
                $updated_shelve_product["shelving_status"] = $shelve_product->shelving_status ?? '';
                $updated_shelve_product["user_shelved_invoice_no"] = $shelve_product->user_shelved_invoice_no ?? '';
                $updated_shelve_product["user_shelved_product"]["id"] = $shelve_product->user_shelved_product->id ?? '';
                $updated_shelve_product["user_shelved_product"]["product_draft_id"] = $shelve_product->user_shelved_product->product_draft_id ?? '';
                $updated_shelve_product["user_shelved_product"]["sku"] = $shelve_product->user_shelved_product->sku ?? '';
                $updated_shelve_product["user_shelved_product"]["ean_no"] = $shelve_product->user_shelved_product->ean_no ?? '';
                $updated_shelve_product["user_shelved_product"]["image"] = $shelve_product->user_shelved_product->image ?? $shelve_product->user_shelved_product->product_draft->single_image_info->image_url ?? '';
                $updated_shelve_product["user_shelved_product"]["regular_price"] = $shelve_product->user_shelved_product->regular_price ?? '';
                $updated_shelve_product["user_shelved_product"]["sale_price"] = $shelve_product->user_shelved_product->sale_price ?? '';

                if (isset($shelve_product->user_shelved_product->attribute)) {
                    foreach ((\Opis\Closure\unserialize($shelve_product->user_shelved_product->attribute)) as $attribute) {

                        $updated_shelve_product["user_shelved_product"] += [
                            $attribute["attribute_name"] => $attribute["terms_name"]
                        ];
                        $variation .= $attribute["terms_name"] . ' ';
                    }
                }
                $updated_shelve_product["user_shelved_product"]["variation"] = $variation;
                $temp[] = $updated_shelve_product;
                $variation = '';
                $updated_shelve_product["user_shelved_product"] = [];
            }
            return response()->json(['success' => $temp],200);
        }else{
            return response()->json(['message' => 'No history found'],200);
        }
    }

    /*
     * Below function for Picker App
     * Function : pickerHistory
     * Route : picker-history
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for displaying all Picked Order of a user
     * Created Date: unknown
     * Modified Date : 22-11-2020
     * Modified Content : Foreach loop of result variable and isset condition
     */
    public function pickerHistory(Request $request){
        $updated_picker_history = array();

        $orderIdList = Order::whereHas('productOrders', function($query){
                $query->where('status',1);
        })->select('id')
            ->where('picker_id',$request->user_id)
            ->orderByDesc('date_created')
            ->limit(20)
            ->get();
        if(count($orderIdList) > 0){
            $ids = [];
            foreach ($orderIdList as $orderId){
                $ids[] = $orderId->id;
            }
            $orderProductList = ProductOrder::select('id','order_id','variation_id','name','quantity','status','updated_at')->with(['order' => function($query) {
                $query->select('id','order_number','status','shipping_post_code','date_created');
            },'variation_info' => function($query){
                $query->select('id','product_draft_id','image','sku','attribute')->with(['master_single_image' => function($image){
                    $image->select('id as image_id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
                }])->withTrashed();
            }])
                ->whereIn('order_id',$ids)
                ->orderByDesc('updated_at')
                ->get();

            foreach ($orderProductList as $user_picked_order){
                $updated_picker_history['id'] = $user_picked_order->order->id;
                $updated_picker_history['order_number'] = $user_picked_order->order->order_number;
                $updated_picker_history['status'] = $user_picked_order->order->status;
                $updated_picker_history['shipping_post_code'] = $user_picked_order->order->shipping_post_code;
                $updated_picker_history['order_date'] = date('d-m-Y h:i:s',strtotime($user_picked_order->order->date_created));
                $updated_picker_history['picked_time'] = ($user_picked_order->updated_at != null) ? $user_picked_order->updated_at->format('d-m-Y H:i:s') : null;

                $pivot = [
                    'order_id' => $user_picked_order->order->id,
                    'variation_id' => $user_picked_order->variation_id,
                    'id' => $user_picked_order->id,
                    'name'=> $user_picked_order->name,
                    'quantity'=> $user_picked_order->quantity,
                    'status'=> $user_picked_order->status
                ];
                $master_single_image =
                    $user_picked_order->variation_info->master_single_image ?? null
                ;
                $productDraft = [
                    'id' => $user_picked_order->variation_info->product_draft_id,
                    'single_image_info' =>$master_single_image
                ];
                $variation = '';
                if($user_picked_order->variation_info->attribute != null){
                    foreach (\Opis\Closure\unserialize($user_picked_order->variation_info->attribute) as $attribute){
                        $variation .= $attribute["terms_name"];
                    }
                }
                $updated_picker_history["product_variations"][] = [
                    'order_id' => $user_picked_order->order->id,
                    'variation_id' => $user_picked_order->variation_id,
                    'product_draft_id' => $user_picked_order->variation_info->product_draft_id,
                    'image' => $user_picked_order->variation_info->image,
                    'sku' => $user_picked_order->variation_info->sku,
                    'pivot' => $pivot,
                    'product_draft' => $productDraft,
                    'variation' => $variation
                    ];
                $temp[] = $updated_picker_history;
                $updated_picker_history = [];
            }
            return response()->json(['success' => $temp]);
        }else{
            return response()->json(['message' => 'No order found'],200);
        }
    }

    /*
     * Below function for Shelver App
     * Function : receiveInvoice
     * Route : invoice/receive
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for displaying supplier and Shelver information
     * Created Date: unknown
     * Modified Date : 23-11-2020
     * Modified Content : Supplier company name instead of name
     */
    public function receiveInvoice(Request $request){
        $supplier = Vendor::select('id','company_name as name')->get();
        $shelver = User::select('id','name')->whereRaw("FIND_IN_SET(4, role)")->get();
        return response()->json(['supplier' => $supplier,'shelver' => $shelver]);
    }

    /*
     * Below function for Shelver App
     * Function : existInvoice
     * Route : invoice/exist-invoice
     * Method Type : GET
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for checking exist invoice
     * Created Date: unknown
     * Modified Date : 23-11-2020
     * Modified Content : Supplier company name instead of name and return message
     */
    public function existInvoice(Request $request){
        $invoice_info = Invoice::select('id as invoice_id','vendor_id','invoice_number','receive_date')
            ->with('vendor_info:id,company_name as name')
            ->where('invoice_number',$request->invoice_number)
            ->first();
        if ($invoice_info){
            return response()->json(['result' => $invoice_info],200);
        }else{
            return response()->json(['message' => 'invoice not found'],200);
        }
    }

    public function variationInfo(Request $request){
        $update_variation_info = array();
        $variation_info = ProductVariation::with(['master_single_image' => function($image){
                $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
            }])
            ->where('id','LIKE',$request->filter_value)
            ->orWhere('sku','LIKE',$request->filter_value)
            ->orWhere('ean_no','LIKE',$request->filter_value)
            ->first();
        if($variation_info){
            $update_variation_info['id'] = $variation_info->id;
            $update_variation_info['sku'] = $variation_info->sku;
            $update_variation_info['ean_no'] = $variation_info->ean_no;
            $update_variation_info['image'] = $variation_info->image ?? $variation_info->master_single_image->image_url ?? null;
            $update_variation_info['cost_price'] = $variation_info->cost_price;
            $variation = '';
            if($variation_info->attribute != null){
                foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){
                    $update_variation_info[$attribute['attribute_name']] = $attribute['terms_name'];
                    $variation .= $attribute['terms_name'].',';
                }
            }
            $update_variation_info['variation'] = rtrim($variation,',');
            if($update_variation_info){
                return response()->json(['success' => $update_variation_info]);
            }else{
                return response()->json(['message' => 'No product found.']);
            }
        }else{
            return response()->json(['message' => 'No product found.']);
        }
    }

    public function invoiceProductReceive(Request $request){
        $invoice_number_result = Invoice::where('invoice_number', $request->invoice_number)->get()->first();

        if ($invoice_number_result !=null){
            $invoice_total_price = $invoice_number_result->invoice_total_price + $request->total_price;
            $invoice_product_create_result = InvoiceProductVariation::create(['invoice_id' => $invoice_number_result->id,'product_variation_id'=> $request->product_variation_id,
                'shelver_user_id'=>$request->shelver_user_id,'quantity'=>$request->quantity,'price'=>$request->price,
                'product_type'=>$request->product_type,'total_price'=>$request->total_price]);
            $invoicre_total_price_update = Invoice::find($invoice_number_result->id);
            $invoicre_total_price_update -> invoice_total_price = $invoice_total_price;
            $invoicre_total_price_update->save();

            return response()->json(['success' => $invoice_product_create_result,'status'=>200]);
        }elseif ($invoice_number_result ==null){
            $invoice_create_reasult = Invoice::create(['vendor_id'=>$request->vendor_id,'receiver_user_id'=>$request->receiver_user_id,
                'invoice_number'=>$request->invoice_number,'invoice_total_price'=>$request->total_price,'receive_date'=>$request->receive_date ]);

            $invoice_product_create_result = InvoiceProductVariation::create(['invoice_id' => $invoice_create_reasult->id,'product_variation_id'=> $request->product_variation_id,
                'shelver_user_id'=>$request->shelver_user_id,'quantity'=>$request->quantity,'price'=>$request->price,
                'product_type'=>$request->product_type,'total_price'=>$request->total_price]);
            return response()->json(['success' => $invoice_product_create_result,'status'=>200]);
        }
        //return $invoice_number_result;
    }
    public function ebay(){

//        curl -X POST 'https://api.sandbox.ebay.com/identity/v1/oauth2/token' \
//        -H 'Content-Type: application/x-www-form-urlencoded' \
//        -H 'Authorization: Basic UkVTVFRlc3...wZi1hOGZhLTI4MmY=' \
//        -d 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.ebay.com%2Foauth%2Fapi_scope';
//        $ch = curl_init();
//        $curlConfig = array(
//            CURLOPT_URL            => "https://api.sandbox.ebay.com/identity/v1/oauth2/token",
//            CURLOPT_POST           => true,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_HTTPHEADER => array(
//                'Content-Type' => 'application/x-www-form-urlencoded',
//                'Authorization' => 'Basic v^1.1#i^1#p^1#r^0#I^3#f^0#t^H4sIAAAAAAAAAOVYa2wUVRTu9kUqrSS8xEfiOiAR687e2Z2d3RnZJVsedoU+YNtSGqTenbmzHbs7M8zcod0q2pQEiD9I+CPCryKaSIr8gBBekZhgogmISqgPoiGC7xgSEgQjKXpndinbSqDQFZu4fyb33vP8zjn3nL2gt7zi6Y21G69WuSYV9/eC3mKXi5kMKsrLqh8sKX6krAjkEbj6e+f0lvaV/DzfhOmULqxApq6pJnJ3p1OqKTibYcoyVEGDpmIKKkwjU8CiEI/WLRN8NBB0Q8OaqKUod2xRmAr4ZF6W/TwAosjxMER21Rsym7QwhSSO8QdkADkEOcgEyblpWiimmhiqOEz5gA94AOdhmCYQElhW8DE0C3xtlLsFGaaiqYSEBlTEMVdweI08W29vKjRNZGAihIrEokviDdHYosX1TfO9ebIiORziGGLLHLlaqEnI3QJTFrq9GtOhFuKWKCLTpLyRrIaRQoXoDWPuwXwHan9IlqEcZBkkspyIUEGgXKIZaYhvb4e9o0ge2SEVkIoVnLkTogSNxEtIxLlVPRERW+S2P8stmFJkBRlhanFNdFW0sZGK1MEO2erpsDxd0EAdmmV64jWtHtGHEizPsn4PIzNBwIi+nKKstBzMozQt1FRJsUEz3fUarkHEajQaG38eNoSoQW0wojK2LcqjY0AOQz/PtdlBzUbRwh2qHVeUJkC4neWdIzDMjbGhJCyMhiWMPnAgClNQ1xWJGn3o5GIufbrNMNWBsS54vV1dXXSXn9aMpNcHAONtrVsWFztQGlKE1q71LL1yZwaP4rgiktwi9ALO6MSWbpKrxAA1SUX8LBfg+RzuI82KjN79x0aez96RFVGoCmECjJwAflnmednPsHIhKiSSS1KvbQdKwIwnDY1OhPUUFJFHJHlmpZGhSAK55XykRJFH4njZw5Jb0ZMISESZjBBAKJEQ+dD/qVDGmupxJBoIFyTXC5bnPXCprmekeOuKQJsRRF0y29OMg/EGqUnSWrydyzh1ZayBb1jaHFgVHms13Np5UdNRo5ZSxEwBELBrvYAo+A2pERo4U2NlyDqOUinyGZe7pu3uxAq1zW8SAVBXaLu8aVFLezVI7nV7q92x2D0WIm/CytBJC5mYWCGR1jpmJoXUB01uCWnsLNk7iDgwdhYyt0mWiO9JkXPZ0QRJJdmBzbvS2T0ClHFlT1TXY+m0hWEihWKF6Y7/UWe8pXsKmR3H7pNd6/fBLxLZbIgVKTv40U6caXOdSBvI1CyDzLx0gz0HNWmdSCVdBRtaKoWMFmbcwZ5gMb7L5ntvfhdu8ptIuS2mFJI+7RPNs/sSUQWOd7op7XNtK7DnTIBnQlwAcOOr0oVOXJsyE62r12omRtK/8EfFO/LZJFLk/Jg+1/ugz3W42OUCQeBhqsG88pLm0pJKyiTNnTahKiW0blqBMk1aqAqxZSC6E2V0qBjF5S7l7Bnxj7wHm/4XwKzhJ5uKEmZy3vsNeOzmSRkz5aEqAgzHMCDEsj6mDcy+eVrKzCydfjrx44WTNduvRBt3TJKXN9Y8t7e6ElQNE7lcZUUku4pW7f72wNeZ/nNXetuC5xar1/Z3nvio/QsuZJVfrtv+xu8fcj3rffu+mzHzzQVTL/806VD5vhmJwfSpNDeX709vHlp/aq5snVyzZ229b0nL9Jqn9pw/s/XgpWO9G96d2r5+zpGtYObK81vo0IvhZPBA88Dh2ss7kkMXq2edPfb6hvprT77s/2T2mdeWP3Gx9fsfpp040PPqzjW/UckLlz67Xno69srHQ+3Ps0OPHt//1t4jjZP/7D9aeWrncaMu9E3ntoHVfGny4g7arD04G4SuTTm/bmD1B4kHqnfPrTsWmfdp/JnBz49emvZO1fXN/Y9vmrGg6teKv355+NkvKwf9h9d9BTYNvHfo6q7MWmZw3663s2H8G+mXR3tKEwAA'//sprintf('Basic %s',base64_encode(sprintf('%s:%s', 'Mahfuzhu-warehous-SBX-c2eb49443-1f1701c2', 'SBX-2eb49443d788-c92b-48c5-a494-8068')))
//            ),
//            CURLOPT_POSTFIELDS     => array(
//                'grant_type' => 'client_credentials',
//                'scope'=>'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.order.readonly https://api.ebay.com/oauth/api_scope/buy.guest.order https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.marketplace.insights.readonly https://api.ebay.com/oauth/api_scope/commerce.catalog.readonly https://api.ebay.com/oauth/api_scope/buy.shopping.cart https://api.ebay.com/oauth/api_scope/buy.offer.auction https://api.ebay.com/oauth/api_scope/commerce.identity.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.email.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.phone.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.address.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.name.readonly https://api.ebay.com/oauth/api_scope/commerce.identity.status.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.item.draft https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/sell.item'
//
//            )
//        );
//        curl_setopt_array($ch, $curlConfig);
//        $result = curl_exec($ch);
//        curl_close($ch);
//
//        return $result;
        $authCode = $_GET['code'];
        $clientID = 'Mahfuzhu-warehous-PRD-b2eb49443-8e2b8238';
        $clientSecret = 'PRD-2eb494438182-53e2-4200-9cb6-6457';
        $ruName = 'Mahfuzhur_Rahma-Mahfuzhu-wareho-uyhilcaf';
        //$authCode = '<AUTH CODE>';

        $url = 'https://api.ebay.com/identity/v1/oauth2/token';

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'authorization_code',
            'code'         => $authCode,
            'redirect_uri' => $ruName,

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        //$result = json_decode($response,true);
        $url = 'https://api.ebay.com/ws/api.dll';

        $headers = [
            'X-EBAY-API-SITEID:3',
            'X-EBAY-API-COMPATIBILITY-LEVEL:967',
            'X-EBAY-API-CALL-NAME:AddFixedPriceItem',
            'X-EBAY-API-IAF-TOKEN:'.$response['access_token'],

        ];
        $value = '<?xml version="1.0" encoding="utf-8"?>
<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<Item>
		<Country>GB</Country>
		<Currency>GBP</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>GTC</ListingDuration>
		<ListingType>FixedPriceItem</ListingType>
		<PaymentMethods>PayPal</PaymentMethods>
		<!--Enter your Paypal email address-->
		<PayPalEmailAddress>Maxkhaninc@gmail.com</PayPalEmailAddress>
		<PostalCode>DA11 9NL</PostalCode>
		<PrimaryCategory>
			<CategoryID>37565</CategoryID>
		</PrimaryCategory>
		<Title>New Ralph Lauren Polo shirt Pink Black Blue Yellow</Title>
		<Description>Four different colors and five different sizes of Ralph Lauren Polo Shirts</Description>
		<PictureDetails>
			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
		</PictureDetails>

		<ItemSpecifics>
			<NameValueList>
				<Name>Occasion</Name>
				<Value>Casual</Value>
			</NameValueList>
			<NameValueList>
				<Name>Brand</Name>
				<Value>Ralph Lauren</Value>
			</NameValueList>
			<NameValueList>
				<Name>Style</Name>
				<Value>Polo Shirt</Value>
			</NameValueList>
			<NameValueList>
				<Name>Sleeve Style</Name>
				<Value>Short Sleeve</Value>
			</NameValueList>
		</ItemSpecifics>
		<Variations>
			<VariationSpecificsSet>
				<NameValueList>
					<Name>Size</Name>
					<Value>XS</Value>
					<Value>S</Value>
					<Value>M</Value>
					<Value>L</Value>
					<Value>XL</Value>
				</NameValueList>
				<NameValueList>
					<Name>Color</Name>
					<Value>Black</Value>
					<Value>Pink</Value>
					<Value>Yellow</Value>
					<Value>Blue</Value>
				</NameValueList>
			</VariationSpecificsSet>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Pnk_S</SKU>
				<StartPrice>17.99</StartPrice>
				<Quantity>4</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Pink</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Pnk_M</SKU>
				<StartPrice>17.99</StartPrice>
				<Quantity>8</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Pink</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blk_S</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Black</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blk_M</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Black</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blu_S</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Blue</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>S</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Variation>
				<SKU>RLauren_Wom_TShirt_Blu_M</SKU>
				<StartPrice>20.00</StartPrice>
				<Quantity>10</Quantity>
				<VariationSpecifics>
					<NameValueList>
						<Name>Color</Name>
						<Value>Blue</Value>
					</NameValueList>
					<NameValueList>
						<Name>Size</Name>
						<Value>M</Value>
					</NameValueList>
				</VariationSpecifics>
			</Variation>
			<Pictures>
				<VariationSpecificName>Color</VariationSpecificName>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Pink</VariationSpecificValue>
					<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
					<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sb2.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Blue</VariationSpecificValue>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sb2.JPG</PictureURL>
					<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sb3.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Black</VariationSpecificValue>
					<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
				</VariationSpecificPictureSet>
				<VariationSpecificPictureSet>
					<VariationSpecificValue>Yellow</VariationSpecificValue>
					<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d89f_1_sbl.JPG</PictureURL>
				</VariationSpecificPictureSet>
			</Pictures>
		</Variations>
		  <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
		     instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
         For help, see the API Reference for Business Policies:
		     https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->
       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>135899715023</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>91633586023</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>80764845023</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>
	</Item>
</AddFixedPriceItemRequest>';
        // $value = json_encode($value);

        // $body = $value;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $value,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            dd( $response);
        }


    }

//    public function saveInvoice(Request $request){
//
//        $invoice_exist = Invoice::where('invoice_number',$request->invoice_number)->first();
//
//        $variation_ids = json_decode($request->product_variation_ids);
//        $product_type = json_decode($request->product_type);
//        $quantity = json_decode($request->quantity);
//        $price = json_decode($request->price);
//        $shelver_id = json_decode($request->shelver_user_id);
//
////        return response()->json(['success' => $variation_ids],200);
//
//        if(!$invoice_exist){
//            $invoice_save_info = Invoice::create([
//                'vendor_id' => $request->vendor_id,
//                'receiver_user_id' => $request->receiver_user_id,
//                'invoice_number' => $request->invoice_number,
//                'invoice_total_price' => 0.00,
//                'receive_date' => $request->receive_date
//            ]);
//
//            $total_price = 0;
//            foreach ($variation_ids as $key => $value) {
//                if ($invoice_save_info->id != null) {
//                    $invoice_product_info[] = [
//                        'invoice_id' => $invoice_save_info->id,
//                        'product_variation_id' => $variation_ids[$key],
//                        'shelver_user_id' => $product_type[$key] == 1 ? $shelver_id[$key] : null,
//                        'quantity' => $quantity[$key],
//                        'price' => $price[$key],
//                        'product_type' => $product_type[$key],
//                        'total_price' => ($quantity[$key] * $price[$key]),
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now()
//                    ];
//                    $total_price += ($quantity[$key] * $price[$key]);
//                }
//            }
//            $invoice_product_result = InvoiceProductVariation::insert($invoice_product_info);
//            $update = Invoice::where('id',$invoice_save_info->id)->update([
//                'invoice_total_price' => $total_price
//            ]);
//        }else{
//            $total_price = 0;
//            foreach ($variation_ids as $key => $value) {
//                if ($invoice_exist->id != null) {
//                    $invoice_product_info[] = [
//                        'invoice_id' => $invoice_exist->id,
//                        'product_variation_id' => $variation_ids[$key],
//                        'shelver_user_id' => $product_type[$key] == 1 ? $shelver_id[$key] : null,
//                        'quantity' => $quantity[$key],
//                        'price' => $price[$key],
//                        'product_type' => $product_type[$key],
//                        'total_price' => ($quantity[$key] * $price[$key]),
//                        'created_at' => Carbon::now(),
//                        'updated_at' => Carbon::now()
//                    ];
//                    $total_price += ($quantity[$key] * $price[$key]);
//                }
//            }
//            $invoice_product_result = InvoiceProductVariation::insert($invoice_product_info);
//            $before_total = Invoice::find($invoice_exist->id)->invoice_total_price;
//            $update = Invoice::where('id',$invoice_exist->id)->update([
//                'invoice_total_price' => ($before_total + $total_price)
//            ]);
//        }
//        return response()->json(['success' => 'Invoice added successfully'],200);
//    }

    public function singleShelfOrderedProductList($userId, $shelfId){
        $query_info = Shelf::select('product_variation.id as variation_id','product_orders.name','product_orders.id as product_order_id',
            'shelfs.id as shelf_id','shelfs.shelf_name','orders.order_number',DB::raw("CONCAT('$this->project_url',image) AS image"),'product_variation.sku','product_variation.attribute',
            'product_variation.ean_no', 'product_orders.quantity','product_orders.picked_quantity', 'product_shelfs.quantity as shelf_quantity',
            DB::raw('(select image_url from images where draft_product_id = product_variation.product_draft_id order by id asc limit 1) as master_image'))
            ->join('product_shelfs','shelfs.id','=','product_shelfs.shelf_id')
            ->join('product_variation','product_shelfs.variation_id','=','product_variation.id')
//            ->join('images','product_variation.product_draft_id','=','images.draft_product_id')
            ->join('product_orders','product_variation.id','=','product_orders.variation_id')
            ->join('orders','product_orders.order_id','=','orders.id')
            ->where([['shelfs.deleted_at',null],['product_variation.deleted_at',null],['orders.deleted_at',null]])
            ->where([['orders.status','processing'],['orders.picker_id',$userId]])
            ->where('product_orders.status',0)
            ->where('product_shelfs.quantity','>',0)
            ->where('shelfs.id',$shelfId)
            ->orderBy('product_variation.sku','asc')
            ->get();
        if(count($query_info) > 0){
            $variation = null;
            $i = 0;
            foreach ($query_info as $info) {
                if ($info->attribute != null && is_array(\Opis\Closure\unserialize($info->attribute))) {
                    foreach (\Opis\Closure\unserialize($info->attribute) as $attribute) {
                        $variation .= $attribute['attribute_name'] . '->' . $attribute["terms_name"] . ',';
                    }
                    $variation = rtrim($variation, ',');
                }
                $query_info[$i]['master_image'] = $this->project_url.$info->master_image;
                $query_info[$i]['variation'] = $variation;
                $variation = null;
                $i++;
            }
            return $query_info;
            //return response()->json(['success' => $query_info],200);
        }else{
            return [];
            //return response()->json(['message' => 'No data found'],200);
        }

//        echo "<pre>";
//        print_r(json_decode($query_info));
//        exit();
    }

    public function groupPostcodeOrderedProductList($userId, $postcode){
        $query_info = Order::select('product_variation.id as variation_id','product_orders.name','product_orders.id as product_order_id',
            'orders.order_number',DB::raw("CONCAT('$this->project_url',image) AS image"),'product_variation.sku','product_variation.attribute',
            'product_variation.ean_no', 'product_orders.quantity','product_orders.picked_quantity',
            DB::raw('(select image_url from images where draft_product_id = product_variation.product_draft_id order by id asc limit 1) as master_image')  )
            ->join('product_orders','orders.id','=','product_orders.order_id')
            ->join('product_variation','product_orders.variation_id','=','product_variation.id')
//            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
//            ->join('shelfs','product_shelfs.shelf_id','=','shelfs.id')
            ->where([['product_variation.deleted_at',null],['orders.deleted_at',null]])
            ->where([['orders.status','processing'],['orders.picker_id',$userId],['orders.shipping_post_code',$postcode],
                ['product_orders.status',0]])
            ->orderBy('product_variation.sku','asc')
            ->get();

        if(count($query_info) > 0) {
            foreach ($query_info as $info) {
//            $shelf = ShelfedProduct::select(['id','shelf_id','variation_id','quantity'])->with(['shelf_info:id,shelf_name'])->where([['variation_id',$info->variation_id],['quantity','>',0]])->get();
                $shelf = ShelfedProduct::select(['shelf_id'])->where([['variation_id', $info->variation_id], ['quantity', '>', 0]])->get();
                $shelf_quantity = [];
                if (count($shelf) > 0) {
                    foreach ($shelf as $shelf_id) {
                        $shelf_quantity[] = Shelf::select(['id', 'shelf_name'])->with(['pivot' => function ($query) use ($shelf_id, $info) {
                            $query->select(['id', 'shelf_id', 'variation_id', 'quantity'])->where([['shelf_id', $shelf_id->shelf_id], ['variation_id', $info->variation_id]]);
                        }])->where('id', $shelf_id->shelf_id)->first();
//                $shelf_ids[] = $shelf_id->shelf_id;
                    }
                }
                $variation = null;
                if($info->attribute != null && is_array(\Opis\Closure\unserialize($info->attribute))){
                    foreach (\Opis\Closure\unserialize($info->attribute) as $attribute){
                        $variation .= $attribute['attribute_name'].'->'.$attribute["terms_name"].',';
                    }
                    $variation = rtrim($variation,',');
                }
//            $shelf_quantity[] = Shelf::with('pivot')->whereIn('id',$shelf_ids)->get();
                $result_info[] = [
                    'variation_id' => $info->variation_id,
                    'name' => $info->name,
                    'product_order_id' => $info->product_order_id,
                    'order_number' => $info->order_number,
                    'image' => $info->image,
                    'sku' => $info->sku,
                    'ean_no' => $info->ean_no,
                    'quantity' => $info->quantity,
                    'picked_quantity' => $info->picked_quantity,
                    'variation' => $variation,
                    'master_image' => $this->project_url.$info->master_image,
                    'shelf_quantity' => $shelf_quantity ?? null
                ];
            }
//        $query_info = Order::select('id','order_number','shipping_post_code','total_price','date_created as order_date')->with(['productOrders'=> function($query){
//            $query->select(['variation_id as id','product_draft_id','image','sku','actual_quantity','ean_no','attribute1 as size','attribute2 as colour','attribute3 as style','attribute4 as design',
//                DB::raw("CONCAT(IFNULL(attribute1,''),' ',IFNULL(attribute2,''),' ',IFNULL(attribute3,''),' ',IFNULL(attribute4,'')) AS variation")])
//                ->with(['shelf_quantity' => function($query){
//                    $query->select('shelf_name')->where('quantity','>',0);
//                },'product_draft' => function($query_image){
//                    $query_image->select(['id', 'name'])
//                        ->with(['single_image_info:draft_product_id,image_url']);
//                }])->where('status',0);
//        }])->where([['status','processing'],['picker_id',$request->user_id],['shipping_post_code',$request->post_code]])
//            ->get();
            return $result_info;
            // return response()->json(['success' => $result_info], 200);
        }else{
            return [];
            //return response()->json(['message' => 'No data found'], 200);
        }
    }

    public function groupSkuOrderList($userId, $variationId){
        $variation_info = ProductVariation::select('product_variation.id as variation_id','product_drafts.name',DB::raw("CONCAT('$this->project_url',image) AS image"),
            'product_variation.sku','product_variation.ean_no','product_variation.attribute',
            DB::raw('(select image_url from images where draft_product_id = product_variation.product_draft_id order by id asc limit 1) as master_image') )
            ->join('product_drafts','product_drafts.id','=','product_variation.product_draft_id')
            ->where([['product_drafts.deleted_at',null],['product_variation.deleted_at',null]])
            ->where('product_variation.id',$variationId)
            ->first();
        if($variation_info) {
//        $variation_info['shelf'] = ShelfedProduct::select(['id','shelf_id','variation_id','quantity'])->with(['shelf_info:id,shelf_name'])->where([['variation_id',$request->variation_id],['quantity','>',0]])->get();
            $shelf = ShelfedProduct::select('shelf_id')->where([['variation_id', $variationId], ['quantity', '>', 0]])->get();
            $shelf_info = [];
            if (count($shelf) > 0) {
                foreach ($shelf as $shelf_id) {
                    $shelf_info[] = Shelf::select(['id', 'shelf_name'])->with(['pivot' => function ($query) use ($shelf_id, $variationId) {
                        $query->select(['id', 'shelf_id', 'variation_id', 'quantity'])->where([['shelf_id', $shelf_id->shelf_id], ['variation_id', $variationId]]);
                    }])->where('id', $shelf_id->shelf_id)->first();
//                $shelf_ids[] = $shelf_id->shelf_id;
                }
            }
            $variation = null;
            if($variation_info->attribute != null && is_array(\Opis\Closure\unserialize($variation_info->attribute))){
                foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){
                    $variation .= $attribute['attribute_name'].'->'.$attribute["terms_name"].',';
                }
                $variation = rtrim($variation,',');
            }
            $variation_info['shelf_quantity'] = $shelf_info;
            $variation_info['variation'] = $variation;
            $variation_info['master_image'] = $this->project_url.$variation_info->master_image;
//        $query_info = ProductVariation::with(['shelf_quantity'])->where('id',$request->variation_id)->get();
//        $query_info = Order::select('product_variation.id','product_orders.id as product_order_id','shelfs.id as shelf_id','shelfs.shelf_name','orders.order_number','product_variation.image',
//            'product_variation.sku','product_variation.ean_no','product_orders.quantity','product_orders.picked_quantity', 'product_shelfs.quantity as shelf_quantity',
//            DB::raw('(select image_url from images where draft_product_id = product_variation.product_draft_id order by id asc limit 1) as master_image')  )
//            ->join('product_orders','orders.id','=','product_orders.order_id')
//            ->join('product_variation','product_orders.variation_id','=','product_variation.id')
//            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
//            ->join('shelfs','product_shelfs.shelf_id','=','shelfs.id')
//            ->where([['shelfs.deleted_at',null],['product_variation.deleted_at',null],['orders.deleted_at',null]])
//            ->where([['orders.status','processing'],['orders.picker_id',$request->user_id],['product_variation.id',
//                $request->variation_id],['product_shelfs.quantity','>',0],['product_orders.status',0]])
//            ->orderBy('shelfs.shelf_name')
//            ->get();
            $query_info = Order::select(DB::raw('sum(product_orders.quantity) as total_product'), 'product_orders.id as product_order_id', 'orders.order_number', 'orders.date_created as order_date')
                ->join('product_orders', 'orders.id', '=', 'product_orders.order_id')
                ->join('product_variation', 'product_orders.variation_id', '=', 'product_variation.id')
//            ->join('product_shelfs','product_variation.id','=','product_shelfs.variation_id')
//            ->join('shelfs','product_shelfs.shelf_id','=','shelfs.id')
                ->where([['product_variation.deleted_at', null], ['orders.deleted_at', null]])
                ->where([['orders.status', 'processing'], ['orders.picker_id', $userId], ['product_variation.id',
                $variationId], ['product_orders.status', 0]])
//            ->orderBy('shelfs.shelf_name')
                ->orderBy('orders.date_created', 'asc')
                ->groupBy('product_orders.id')
                ->groupBy('orders.order_number')
                ->groupBy('orders.date_created')
                ->get();
            $result_info = null;
            if (count($query_info) > 0) {
                foreach ($query_info as $info) {
                    $order_info = ProductOrder::select('quantity', 'picked_quantity')->find($info->product_order_id);
                    $result_info[] = [
                        'total_product' => $info->total_product,
                        'product_order_id' => $info->product_order_id,
                        'order_number' => $info->order_number,
                        'order_date' => $info->order_date,
                        'quantity' => $order_info->quantity,
                        'picked_quantity' => $order_info->picked_quantity
                    ];

                }
            }
            return ['variation_info' => $variation_info, 'success' => $result_info];
            //return response()->json(['variation_info' => $variation_info, 'success' => $result_info], 200);
        }else{
            return [];
            //return response()->json(['message' => 'No data found'], 200);
        }
    }

    public function shelfMigration(Request $request){
        try{
            $form = Shelf::with(['user','total_product'])->find($request->shelf_migrated_from);
            $to = Shelf::with(['user','total_product'])->find($request->shelf_migrated_to);
            $counter = 0;
            if ($form->id != $to->id){
                foreach ($form->total_product as $shelf_product){
                    $temp = 0 ;
                    foreach ($to->total_product as $value){
                        if ($shelf_product->pivot->variation_id == $value->pivot->variation_id){
                            $update_quantity = $shelf_product->pivot->quantity + $value->pivot->quantity;
                            // $to_result = ShelfedProduct::where('shelf_id',$to->id)->where('variation_id' ,$value->id)->update(['quantity' => $update_quantity]);
                            // $from_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['quantity' => 0]);
                            $migrate_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['shelf_id' => $to->id]);
                            $temp = 1;
                        }
                    }
                    if ($temp == 0){
                        // ShelfedProduct::create(['shelf_id'=>$to->id,'variation_id' => $shelf_product->pivot->variation_id,'quantity' => $shelf_product->pivot->quantity]);
                        // $from_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['quantity' => 0]);
                        $migrate_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['shelf_id' => $to->id]);
                    }
                }
                return response()->json(['type' => 'success','msg'=>'Shelf Migrated Successfully']);
            }else{
                return response()->json(['type' => 'error','msg' => 'Shelf Must Be Different']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong.']);
        }
    }

    public function shelfInfo($shelfId){
        try{
            $shelfInfo = Shelf::withCount(['total_shelf_product' => function($query){
                $query->select(DB::raw("COALESCE(SUM(quantity),0)" ));
            }])->find($shelfId);
            return response()->json(['type' => 'success','shelfInfo' => $shelfInfo],200);
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => 'Something Went Wrong']);
        }
    }

    public function getOrderProductBySKU(Request $request){
        try{
            $productInfo = ProductVariation::select('id','product_draft_id','image','attribute','sku','actual_quantity','ean_no')
            ->with(['product_draft:id,name','master_single_image' => function($image){
                $image->select('id','draft_product_id',DB::raw("CONCAT('$this->project_url',image_url) AS image_url"));
            }])
            ->where('id','LIKE',$request->value)
            ->orWhere('sku','LIKE',$request->value)->orWhere('ean_no','LIKE',$request->value)
            ->first();
            if($productInfo){
                $variation = '';
                if(isset($productInfo->attribute)){
                    foreach (\Opis\Closure\unserialize($productInfo->attribute) as $attribute) {
                        $variation .= $attribute["terms_name"] . ',';
                    }
                }
                $productInfo['variation'] = rtrim($variation,',');
                $orderedProduct = Order::select(DB::raw('sum(product_orders.quantity - product_orders.picked_quantity) as total_quantity'))
                ->join('product_orders','orders.id','=','product_orders.order_id')
                ->where('orders.status','processing')->where('orders.picker_id',$request->user_id)
                ->where('product_orders.variation_id',$productInfo->id)->where('product_orders.status', 0)
                ->get();
                return response()->json(['productInfo' => $productInfo, 'totalProduct' => $orderedProduct[0]->total_quantity]);
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Product Not Found']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function bulkProductPick(Request $request){
        try{
            $orderedProduct = Order::select('orders.id',DB::raw('sum(product_orders.quantity - product_orders.picked_quantity) as total_quantity'))
                ->join('product_orders','orders.id','=','product_orders.order_id')
                ->where('orders.status','processing')->where('orders.picker_id',$request->user_id)
                ->where('product_orders.variation_id',$request->variation_id)->where('product_orders.status', 0)
                ->groupBy('orders.id')
                ->orderBy('date_created','ASC')
                ->get();
                if(isset($orderedProduct) && count($orderedProduct) > 0){
                    $requestQuantity = $request->quantity;
                    foreach($orderedProduct as $order){
                        if($requestQuantity > 0) {
                            $orderInfo = ProductOrder::where('order_id', $order->id)
                            ->where('variaion_id',$request->variaiton_id)
                            ->where('quantity','>',0)
                            ->first();
                            if($orderInfo){
                                $decrementQuantity = (($requestQuantity - $orderInfo->quantity) > -1) ? $orderInfo->quantity : $requestQuantity;
                                $orderProductReduceInfo = ProductOrder::find($orderInfo->id)->increment('picked_quantity',$decrementQuantity);
                                $requestQuantity = $requestQuantity - $orderInfo->quantity;
                            }else{
                                return response()->json(['type' => 'error', 'msg' => 'No Shelf Found Or Product Not Found In This Shelf']);
                            }
                        }
                    }
                    $shelfProductReduce = ShelfedProduct::where('shelf_id',$request->shelf_id)
                        ->where('variation_id',$request->variation_id)->decrement('quanatity',$request->quantity);

                    return response()->json(['type' => 'success', 'orderInfo' => $orderedProduct]);
                }else{
                    return response()->json(['type' => 'error', 'msg' => 'No Order Found']);
                }

        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }

    public function getWmsBrandName($brandId){
        $wmsBrandInfo = Brand::find($brandId);
        if($wmsBrandInfo){
            return $wmsBrandInfo->name ?? '';
        }
        return '';
    }

    public function manualOrderApi(Request $request){
        try {
            $order_number = mt_rand(100000, 999999);
            while(true){
                $exist_order = Order::find($order_number);
                if(!$exist_order){
                    break;
                }
                $order_number = mt_rand(100000, 999999);
            }
            $misMatchQuantity = [];
            foreach (json_decode($request->sku) as $key => $value){
                $variation_info = ProductVariation::where('sku',$value)->first();
                if($variation_info){
                    if(($variation_info->actual_quantity <= 0) || (($variation_info->actual_quantity - json_decode($request->quantity)[$key]) < 0) || json_decode($request->quantity)[$key] <= 0) {
                        $misMatchQuantity[] = $value;
                    }
                }
            }
            if(count($misMatchQuantity) > 0){
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity Mismatch',
                ]);
            }

            $name = $request->customer_name ?? null;
            $email = $request->customer_email ?? null;
            $phone = $request->customer_phone ?? null;
            $country = $request->customer_country ?? null;
            $state = $request->customer_state ?? null;
            $city = $request->customer_city ?? null;
            $postcode = $request->customer_zip_code ?? null;
            $shipping_address = $request->address ?? null;
            $total_price = $request->total_price ?? '0.00';
            $paymentMethod = $request->payment_method ?? null;

            $shipping = '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Name  </h7></div><div class="content-right"><h7> : ' . $name . '</h7></div></div>';
            $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Address  </h7></div><div class="content-right"><h7> : ' . $shipping_address . '</h7></div></div>';
            $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> City  </h7></div><div class="content-right"><h7> : ' . $city . '</h7></div></div>';
            $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> State  </h7></div><div class="content-right"><h7> : ' . $state . '</h7></div></div>';
            $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Postcode  </h7></div><div class="content-right"><h7> : ' . $postcode . '</h7></div></div>';
            $shipping .= '<div class="d-flex justify-content-start mb-1"><div class="content-left"><h7> Country  </h7></div><div class="content-right"><h7> : ' . $country . '</h7></div></div>';
            
            $insert_order_info = Order::create([
                'id' => $order_number,
                'order_number' => $order_number,
                'status' => 'processing',
                'created_via' => 'rest-api',
                'currency' => 'GBP',
                'total_price' => $total_price,
                'customer_name' => $name,
                'customer_email' => $email,
                'customer_phone' => $phone,
                'customer_country' => $country,
                'customer_city' => $city,
                'customer_zip_code' => $postcode,
                'customer_state' => $state,
                'payment_method' => 'cash',
                'shipping' => $shipping,
                'shipping_post_code' => $postcode,
                'date_created' => \Illuminate\Support\Carbon::now()
            ]);
            
            $variation_arr_info = [];
            $missing_sku = [];
            foreach (json_decode($request->sku) as $key => $value){
                $variation_info = ProductVariation::where('sku',$value)->first();
                if($variation_info) {
                    $draft_product_name = ProductDraft::find($variation_info->product_draft_id)->name;
                    $variation_arr_info = ProductOrder::create([
                        'order_id' => $order_number,
                        'variation_id' => $variation_info->id,
                        'name' => $draft_product_name,
                        'quantity' => json_decode($request->quantity)[$key],
                        'price' => json_decode($request->price)[$key] ?? '0.00',
                        'status' => 0
                    ]);
                    $check_quantity = new CheckQuantity();
                    $check_quantity->checkQuantity($value,null,null,'Manual Order Create');

                }else{
                    $missing_sku[] = $value;
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'missing_skus' => $missing_sku
            ]);

        }catch (\Exception $ex){
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong'
           ]);
        }
    }

    public function holdOrder(Request $request){
        try{
            $orderSetHold = Order::where('id',$request->order_id)->where('status','processing')->first();
            if($orderSetHold){
                $orderSetHold->status = 'on-hold';
                $orderSetHold->cancelled_by = $request->user_id;
                $orderSetHold->save();
                return response()->json(['success' => true, 'message' => 'Order Hold Successfully']);
            }else{
                return response()->json(['success' => false, 'message' => 'Order Not Found In Awaiting Dispatch Or Assigned Order']);
            }
        }catch(\Exception $exception){
            return response()->json(['success' => false,'message' => 'Something Went Wrong']);
        }
    }

    public function storeShelveError(Request $request){
        try{
            $updateErrorShelveProductInvoice = InvoiceProductVariation::find($request->id);
            $updateErrorShelveProductInvoice->shelve_error = 1;
            $updateErrorShelveProductInvoice->error_shelve_details = json_encode([
                'variation_id' => $request->variation_id,
                'sku' => \App\ProductVariation::find($request->variation_id)->sku ?? '',
                'shelf_id' => $request->shelf_id,
                'shelf_name' => \App\Shelf::find($request->shelf_id)->shelf_name ?? '',
                'quantity' => $request->quantity,
            ]);
            $updateErrorShelveProductInvoice->save();
            return response()->json(['success' => true,'message' => 'Shelve Error Store Successfully']);
        }catch (\Exception $exception){
            return response()->json(['success' => false, 'message' => 'Something Went Wrong']);
        }

    }


}
