<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Client;
use App\Condition;
use App\DeveloperAccount;
use App\EbayVariationProduct;
use App\ProductDraft;
use App\ReturnOrder;
use App\ReturnOrderProduct;
use App\Shelf;
use App\ShelfedProduct;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use peal\barcodegenerator\Facades\BarCode;
use App\Invoice;
use App\InvoiceProductVariation;
use App\ProductVariation;
use App\Role;
use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;
use PHPUnit\Framework\MockObject\Stub\ReturnReference;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Illuminate\Support\Carbon;
use DB;
use App\EbayAccount;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use function foo\func;

class InvoiceController extends Controller
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

        $shelfUse = $this->clientInfo();
        $invoice_result = Invoice::with(['invoiceProductVariations' => function($query){
            $query->with('condition');
            },'return_order_info'])->whereDate('receive_date', '>', Carbon::now()->subDays(30))
            ->orderBy('id','DESC')
            ->paginate(50);
        $vendors = Vendor::get()->all();
        $invoice_results = json_decode(json_encode($invoice_result));
        $total_invoice_result = Invoice::whereDate('receive_date', '>', Carbon::now()->subDays(30))->count();
//        echo "<pre>";
//        print_r($invoice_results);
//        exit();
        return view('invoice.invoice_view',compact('invoice_result','invoice_results','vendors','total_invoice_result','shelfUse'));

    }

    public function invoiceNoSKUSearch (Request $request) {

        try{

                $search_value = $request->search_value;
                $variation_id_query = ProductVariation::where('sku', $search_value)->get()->first();
                if($variation_id_query != null){
                    $invoice_id_query = InvoiceProductVariation::where('product_variation_id', $variation_id_query->id)->pluck('invoice_id')->toArray();
                    //$invoice_number_query = Invoice::where('id', $invoice_id_query->invoice_id)->get()->first();
                    $invoice_ids = Invoice::whereIn('id', $invoice_id_query)->get();
                }else{
                    $invoice_ids = Invoice::where('invoice_number', $search_value)->get();
                }

                $invoice_ids_arr = [];
                if(count( $invoice_ids) > 0){
                    foreach ( $invoice_ids as $ids){
                        $invoice_ids_arr[] = $ids->id;
                    }
                }

                // dd($invoice_ids_arr);

                $shelfUse = $this->clientInfo();
                $invoice_result = Invoice::with(['invoiceProductVariations' => function($query){
                    $query->with('condition');
                },'return_order_info'])
                    ->whereIn('id', $invoice_ids_arr)
                    ->orderByDesc('id')
                    ->paginate(50);

                // If user submit with wrong data or not exist data then this message will display table's upstairs
                $ids = [];
                if(count($invoice_result) > 0){
                    foreach ($invoice_result as $result){
                        $ids[] = $result->id;
                    }
                }else{
                    return redirect('/invoice')->with('message','No data found');
                }

                $vendors = Vendor::get()->all();
                $invoice_results = json_decode(json_encode($invoice_result));
                // echo "<pre>";
                // print_r($invoice_results);
                // exit();
                return view('invoice.invoice_view',compact('invoice_result','invoice_results','vendors','shelfUse','search_value'));

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }





    // public function invoiceNoSearch (Request $request) {

    //     try{

    //         $search_value = $request->search_value;
    //         $shelfUse = $this->clientInfo();
    //         $invoice_result = Invoice::with(['invoiceProductVariations' => function($query){
    //             $query->with('condition');
    //         },'return_order_info'])->whereDate('receive_date', '>', Carbon::now()->subDays(30))
    //             ->where('invoice_number', $request->search_value)
    //             ->leftJoin()
    //             // ->whereIn('id', $invoice_ids_arr)
    //             ->paginate(50);

    //         // If user submit with wrong data or not exist data then this message will display table's upstairs
    //         $ids = [];
    //         if(count($invoice_result) > 0){
    //             foreach ($invoice_result as $result){
    //                 $ids[] = $result->id;
    //             }
    //         }else{
    //             return redirect('/invoice')->with('message','No data found');
    //         }

    //         $vendors = Vendor::get()->all();
    //         $invoice_results = json_decode(json_encode($invoice_result));
    // //    echo "<pre>";
    // //    print_r($invoice_results);
    // //    exit();
    //         return view('invoice.invoice_view',compact('invoice_result','invoice_results','vendors','shelfUse','search_value'));

    //     }catch (\Exception $exception){
    //         return $exception->getMessage();
    //     }
    // }




    public function invoiceHistorySearch (Request $request) {
        try{
            $search_value = $request->search_value;
            $column_name = $request->column_name;
            $shelfUse = $this->clientInfo();
            $invoice_result = Invoice::with(['invoiceProductVariations' => function($query){
                $query->with('condition');
            },'return_order_info'])->whereDate('receive_date', '>', Carbon::now()->subDays(30))
                ->orderBy('id','DESC')
                ->where(function($query)use($request,$search_value,$column_name){
                    if($column_name == 'invoice_number'){
                        if($request->opt_out == 1){
                            $query->where($column_name, '!=' , $search_value);
                        }else{
                            $query->where($column_name, $search_value);
                        }
                    }
                    elseif ($column_name == 'company_name'){
                        $supplier_query = Invoice::select('invoices.id')
                            ->leftJoin('vendors', 'invoices.vendor_id', '=', 'vendors.id')
                            ->where($column_name, $search_value)
                            ->groupBy('invoices.id')
                            ->get();
                        $ids = [];
                        foreach ($supplier_query as $supplier){
                            $ids[] = $supplier->id;
                        }
                        if($request->opt_out == 1) {
                            $query->whereNotIn('id', $ids);
                        }else{
                            $query->whereIn('id', $ids);
                        }
                    }
                    elseif ($column_name == 'receive_date'){
                        if($request->opt_out == 1){
                            $query->whereRaw('DATE(receive_date) != ?',[date('Y-m-d',strtotime($search_value))]);
                        }else{
                            $query->whereRaw('DATE(receive_date) = ?',[date('Y-m-d',strtotime($search_value))]);
                        }
                    }
                })
                ->paginate(50);


            // If user submit with wrong data or not exist data then this message will display table's upstairs
            $invoice_ids = [];
            if(count($invoice_result) > 0){
                foreach ($invoice_result as $result){
                    $invoice_ids[] = $result->id;
                }
            }else{
                return redirect('/invoice')->with('message','No data found');
            }

            $vendors = Vendor::get()->all();
            $invoice_results = json_decode(json_encode($invoice_result));
//        echo "<pre>";
//        print_r($invoice_results);
//        exit();
            return view('invoice.invoice_view',compact('invoice_result','invoice_results','vendors','shelfUse','search_value','column_name'));
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shelfUse = $this->clientInfo();
        $invoice_numbers = Invoice::select('invoice_number')->get()->all();
        $vendors = Vendor::get()->all();
        $all_shelver = [];
        if($shelfUse == 1) {
            $all_shelver = Role::with(['users_list'])->where('id', 4)->first();
        }
//        dd($all_shelver);
        $product_variations = ProductVariation::orderBy('created_at','DESC')->get()->all();
        $all_return_order = ReturnOrder::with(['orders:id,order_number','is_return_product_shelved'])->get();
//        echo "<pre>";
//        print_r(json_decode(json_encode($all_return_order)));
//        exit();
        $content = view('invoice.receive_invoice',compact('vendors','product_variations','all_shelver','all_return_order','invoice_numbers','shelfUse'));
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
        try{
//            if ($request->product_type == 1){
//                $product_draft_result = ProductVariation::select('product_draft_id')->where('id',$request->product_variation_id)->get()->first();
////            print_r($product_draft_result->product_draft_id);
////            exit();
//                $woocom_product_variation_result = Woocommerce::get('products/'.$product_draft_result->product_draft_id.'/variations/'.$request->product_variation_id);
//                $woocom_product_variation_result = json_decode(json_encode($woocom_product_variation_result));
//
//                $update_quantity = $request->quantity+$woocom_product_variation_result->stock_quantity;
//                $vendor_info = Vendor::find($request->vendor_id);
//                $update_sku = $woocom_product_variation_result->sku.'-V-'.$vendor_info->registration_no;
//                $data = [
//                    'stock_quantity' => $update_quantity
//                    //'sku' => $update_sku
//                ];
//                $woocom_update_result = Woocommerce::put('products/'.$product_draft_result->product_draft_id.'/variations/'.$request->product_variation_id,$data);
//            }
//            else{
            $sku = ProductVariation::find($request->product_variation_id)->sku;
            $vendor_info = Vendor::find($request->vendor_id);
            $update_sku = $sku.'-V-'.$vendor_info->registration_no;
//            }
//            DB::transaction(function () {
//
//            });
            if ($request->order_id != null){
                $return_order = ReturnOrder::where('order_id',$request->order_id)->get()->first();
                $request->request->add(['receiver_user_id' => Auth::id(),'invoice_total_price' => $request->total_price,'return_order_id' => $return_order->id, 'receive_date' => date('Y-m-d H:i:s',strtotime($request->receive_date) )]);
            }else{
                $request->request->add(['receiver_user_id' => Auth::id(),'invoice_total_price' => $request->total_price, 'receive_date' => date('Y-m-d H:i:s',strtotime($request->receive_date) )]);
            }


            $invoice_result = Invoice::select('id')->where('invoice_number',$request->invoice_number)->get()->first();
            $shelf_use = $this->clientInfo();
            if($shelf_use == 0){
                $genericShelfId = Shelf::first()->id ?? null;
                $firstUser = User::first()->id ?? null;
            }
            if (!isset($invoice_result)){
                $invoice_create_result = Invoice::create($request->all());

                if ($invoice_create_result->id != null){
                    $request->request->add(['invoice_id'=> $invoice_create_result->id]);
                    if ($shelf_use == 0) {
                        $request->request->add(['shelved_quantity' => $request->quantity,'shelving_status' => 1]);
                    }
                    $invoice_product_result = InvoiceProductVariation::create($request->all());
                    $update_variation = ProductVariation::find($request->product_variation_id);

//                    $barcode = [
//                        'text' => $update_sku,
//                        'size' => 50,
//                        'orientation' => 'horizontal',
//                        'code_type' => 'code128',
//                        'print' => true,
//                        'sizefactor' => 1,
//                        'filename' => $update_sku.'.jpg'
//                    ];
                    $data ='';
//                    $barcontent = BarCode::barcodeFactory()->renderBarcode(
//                        $text=$barcode["text"],
//                        $size=$barcode['size'],
//                        $orientation=$barcode['orientation'],
//                        $code_type=$barcode['code_type'], // code_type : code128,code39,code128b,code128a,code25,codabar
//                        $print=$barcode['print'],
//                        $sizefactor=$barcode['sizefactor'],
//                        $filename = $barcode['filename'],
//                        $filepath = 'barcode'
//                    )->filename($barcode['filename']);
//
//                    $update_variation->barcode = $update_sku.'.jpg';
//                    $update_variation->save();

                    if ($request->return_order_product_id !=null){
                        ReturnOrderProduct::where('id',$request->return_order_product_id)->update(['status' => 1]);
                    }
                    if ($shelf_use == 0) {
                        $channelUpdate = $this->syncQuantityWithoutApp($request->product_variation_id, $request->quantity);
                        $productShelfData = ShelfedProduct::create([
                            'shelf_id' => $genericShelfId,
                            'variation_id' => $request->product_variation_id,
                            'quantity' => $request->quantity
                        ]);
                    }
                    if ($request->printer_option == 1) {

                        // $variation_info = ProductVariation::find($request->product_variation_id);
                        // $product_id = $request->product_variation_id;
                        // $sku = $variation_info->sku;
                        // $data = "<p class='inline'><span style='font-size: 15px;'><b>SKU: $sku</b></span>".$this->bar128(stripcslashes($sku))."<span style='font-size: 15px;'><b>ID: ".$request->product_variation_id." </b><span></p>&nbsp&nbsp&nbsp&nbsp";

                        // $view = view('product_variation.barcode',compact('data'));;
//                    return $data;
                        return $this->printBarcode($request->product_variation_id);;
                    }else{
                        return '1';
                    }

//                    return  'Product successfully received at invoice number: '. $request->invoice_number;
                }
            }else{
                if ($invoice_result->id != null){
                    $request->request->add(['invoice_id'=> $invoice_result->id]);
                    if ($shelf_use == 0) {
                        $request->request->add(['shelved_quantity' => $request->quantity,'shelving_status' => 1]);
                    }
                    $invoice_product_result = InvoiceProductVariation::create($request->all());
                    $update_variation = ProductVariation::find($request->product_variation_id);

//                    $barcode = [
//                        'text' => $update_sku,
//                        'size' => 50,
//                        'orientation' => 'horizontal',
//                        'code_type' => 'code128',
//                        'print' => true,
//                        'sizefactor' => 1,
//                        'filename' => $update_sku.'.jpg'
//                    ];
                    $data ='';
//                    $barcontent = BarCode::barcodeFactory()->renderBarcode(
//                        $text=$barcode["text"],
//                        $size=$barcode['size'],
//                        $orientation=$barcode['orientation'],
//                        $code_type=$barcode['code_type'], // code_type : code128,code39,code128b,code128a,code25,codabar
//                        $print=$barcode['print'],
//                        $sizefactor=$barcode['sizefactor'],
//                        $filename = $barcode['filename'],
//                        $filepath = 'barcode'
//                    )->filename($barcode['filename']);
//
//                    $update_variation->barcode = $update_sku.'.jpg';
//                    $update_variation->save();
                    if ($request->return_order_product_id !=null){
                        ReturnOrderProduct::where('id',$request->return_order_product_id)->update(['status' => 1]);
                    }
                    if ($shelf_use == 0) {
                        $channelUpdate = $this->syncQuantityWithoutApp($request->product_variation_id, $request->quantity);
                        $productShelfData = ShelfedProduct::create([
                            'shelf_id' => $genericShelfId,
                            'variation_id' => $request->product_variation_id,
                            'quantity' => $request->quantity
                        ]);
                    }
                    if ($request->printer_option == 1) {

                        // $variation_info = ProductVariation::find($request->product_variation_id);
                        // $product_id = $request->product_variation_id;
                        // $sku = $variation_info->sku;
                        // $data = "<p class='inline'><span style='font-size: 15px;'><b>SKU: $sku</b></span>" . $this->bar128(stripcslashes($sku)) . "<span style='font-size: 15px;'><b>ID: " . $request->product_variation_id . " </b><span></p>&nbsp&nbsp&nbsp&nbsp";

                        // $view = view('product_variation.barcode', compact('data'));;
//                    return $data;
                        return $this->printBarcode($request->product_variation_id);
                    }else{
                        return '1';
                    }


//                    return 'Product successfully received at invoice number: '. $request->invoice_number;
                    //return 'test';
                }

            }


        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function getQuantity(Request $request){


        try {
            if (isset($request->master_catalogue_id)) {
                $catalogueWithVariation = ProductVariation::where('product_draft_id',$request->master_catalogue_id)->get();
                $invoiceReceiveInfo = [];
                if(count($catalogueWithVariation) > 0){
                    foreach($catalogueWithVariation as $variation){
                        $p_variation = '';
                        if(isset($variation->attribute) && is_array(unserialize($variation->attribute))){
                            foreach(unserialize($variation->attribute) as $attr){
                                $p_variation .= $attr['attribute_name'].'->'.$attr['terms_name'].',';
                            }
                        }
                        $invoiceReceiveInfo [] = [
                            'variation_id' => $variation->id,
                            'sku' => $variation->sku,
                            'variation' => rtrim($p_variation,','),
                            'cost_price' => $variation->cost_price,
                        ];
                    }
                }
                $all_shelver = Role::select('id','role_name')->with(['users_list:id,name'])->where('id',4)->first();
                return response()->json(['invoice_info' => $invoiceReceiveInfo,'logged_in_shelver_id' => Auth::id(),'shelver_info' => $all_shelver]);
            }
            if (isset($request->order_id)) {
                $result = ReturnOrder::select('id')->where('order_id', $request->order_id)->get()->first();

                $return_order_result = ReturnOrderProduct::where(['return_order_id' => $result->id, 'variation_id' => $request->product_variation_id])->get()->first();
            }
            $product_price = ProductVariation::find($request->product_variation_id);
            $variation = '';
            foreach (\Opis\Closure\unserialize($product_price->attribute) as $attribute_value){
                $variation .= $attribute_value['attribute_name'].' -> '.$attribute_value['terms_name'].' , ';
            }
            $all_variation = rtrim($variation, ', ');
            if (isset($request->order_id)){
                return response()->json(['quantity' => $return_order_result->return_product_quantity ?? '', 'cost_price' => $product_price->cost_price, 'variation' => $all_variation]);
            }else{
                return response()->json(['variation' => $all_variation, 'cost_price' => $product_price->cost_price]);
            }

            return $return_order_result;
        }catch (Exception $exception){
            return $exception;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(Auth::check() && in_array('1',explode(',',Auth::user()->role))) {
            $pending_products = InvoiceProductVariation::where([['shelving_status', 0]])->orderBy('id', 'desc')->paginate(50);
            $shelver_list = Role::with(['users_list'])->where('id', 4)->first();
        }else{
            $pending_products = InvoiceProductVariation::where([['shelving_status', 0], ['shelver_user_id' => Auth::user()->id]])->orderBy('id', 'desc')->paginate(50);
            $shelver_list = Role::with(['users_list'])->where('id', 4)->first();
        }
        $shelfUse = $this->clientInfo();
        $decode_InvoiceProductVariation = json_decode(json_encode($pending_products));
//        echo '<pre>';
//        print_r($decode_InvoiceProductVariation);
//        exit();
        $content = view('invoice.pending_receive',compact('pending_products','shelver_list', 'decode_InvoiceProductVariation','shelfUse'));
        return view('master',compact('content'));
    }

    public function pendingReceiveInvoiceNo (Request $request) {

        try{
            $search_value = $request->search_value;
            if(Auth::check() && in_array('1',explode(',',Auth::user()->role))) {
                $pending_products = InvoiceProductVariation::
                    where([['invoice_product_variation.shelving_status', 0], ['invoice_product_variation.product_type','!=', 0]])
                    ->leftJoin('invoices', 'invoice_product_variation.invoice_id', '=', 'invoices.id')
                    ->select('invoice_product_variation.*', 'invoices.id', 'invoices.invoice_number')
                    ->where('invoices.invoice_number', $search_value)
                    ->groupBy('invoice_product_variation.id')
                    ->paginate(50);
                $shelver_list = Role::with(['users_list'])->where('id', 4)->first();
            }else{
                $pending_products = InvoiceProductVariation::
                    where([['invoice_product_variation.shelving_status', 0], ['invoice_product_variation.product_type','!=', 0]])
                    ->leftJoin('invoices', 'invoice_product_variation.invoice_id', '=', 'invoices.id')
                    ->select('invoice_product_variation.*', 'invoices.id', 'invoices.invoice_number')
                    ->where('invoices.invoice_number', $search_value)
                    ->groupBy('invoice_product_variation.id')
                    ->paginate(50);
                $shelver_list = Role::with(['users_list'])->where('id', 4)->first();
            }
            $shelfUse = $this->clientInfo();
            $decode_InvoiceProductVariation = json_decode(json_encode($pending_products));
//            echo '<pre>';
//            print_r($decode_InvoiceProductVariation);
//            exit();
            return view('invoice.pending_receive',compact('pending_products','shelver_list', 'decode_InvoiceProductVariation','shelfUse','search_value'));
        }catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

//    public function pendingReceive($id){
//        $invoice_product = InvoiceProductVariation::find($id);
//        $users = User::get()->all();
//        $content = view('invoice_product.invoice_product_edit',compact('invoice_product','users'));
//        return view('master',compact('content'));
//    }

    public function getInvoiceNumber(Request $request){
        $invoice_number = $request->invoice_number;

        $invoice_result = Invoice::select('invoice_number')->orWhere('invoice_number', 'like', '%' . $invoice_number . '%')->get();
        //$invoice_result = json_decode(json_encode($invoice_result));
        return $invoice_result;
    }

    public function getVendor(Request $request){
        $vendor = Invoice::select('vendor_id')->where('invoice_number', $request->invoice_number)->get()->first();

        return $vendor;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice_result = Invoice::find($id);
        $vendor_results = Vendor::get()->all();
//        print_r($invoice_result);
//        exit();
        $content = view('invoice.invoice_edit',compact('invoice_result','vendor_results'));
        return view('master',compact('content'));
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
        try{
//            $validatedData = $request->validate([
//                'invoice_number' => 'required|unique:invoices',
//            ]);
            $invoice_result = Invoice::find($id);
            $invoice_result = $invoice_result->update($request->all());

            if ($invoice_result){
                return redirect('/invoice')->with('success', 'invoice updated successfully');
            }
        }catch (Exception $exception){
            return back()->with('error', $exception );
        }


    }

    public function invoiceCheck(Request $request){


//        $return_order = ReturnOrder::where('order_id',$request->order_id)->get()->first();

        try{
            $content = view('invoice.getModalAjax',compact('request'));
            return $content;
        }catch (Exception $exception){
            return $exception;
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
            $invoice_delete = Invoice::find($id);
            DB::transaction(function () use ($invoice_delete) {
                $invoice_delete->delete();
                $invoice_delete->invoiceProductVariations()->delete();
            });

            if ($invoice_delete){
                return redirect('/invoice')->with('success', 'Invoice deleted successfully');
            }
        }catch (Exception $exception){
            return redirect('/invoice')->with('error', $exception);
        }

    }

    public function printBarcode($id){

        $variation_info = ProductVariation::with('product_draft')->find($id);
//         echo "<pre>";
//         print_r($variation_info->product_draft->brand_id);
//         exit();
        $product_id = $id;
        $sku = $variation_info->sku;

        $brand = Brand::find($variation_info->product_draft->brand_id)->name ?? '';
        $attribute_vaue = '';
//        $data = asset('barcode/'.$variation_info->barcode);
//        return $data;
        if ($variation_info->product_draft->type == 'variable'){
            foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){

                $attribute_vaue = $attribute_vaue ."<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".$attribute["attribute_name"] .': '.$attribute["terms_name"]." </b><span><br>";
            }
        }

//        if (isset($variation_info->attribute1)){
//            $attribute1 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(5)->attribute_name .': '.$variation_info->attribute1." </b><span><br>";
//        }if (isset($variation_info->attribute2)){
//            $attribute2 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(6)->attribute_name .': '.$variation_info->attribute2." </b><span><br>";
//        }if (isset($variation_info->attribute3)){
//            $attribute3 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(7)->attribute_name .': '.$variation_info->attribute3." </b><span><br>";
//        }if (isset($variation_info->attribute4)){
//            $attribute4 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(7)->attribute_name .': '.$variation_info->attribute4." </b><span><br>";
//        }if (isset(Brand::find($variation_info->product_draft->brand_id)->name)){
//            $brand ="<span style='font-size: 15px;padding-left: 0px;clear: both;display: inline-block;
//                    overflow: hidden;white-space: nowrap;'>".Brand::find($variation_info->product_draft->brand_id)->name." </b><span><br>" ;
//        }

//        $data = "<p class='inline'><span ><b>Item: $product</b></span>".$this->bar128(stripcslashes($product_id))."<span ><b>Price: ".$rate." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
        $data = "<div style='height: 90px; width: 180px;'>
                    <div style='height: 65px; width: 66px;float: left;padding: 0 !important;margin: 0 !important;'>".\SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)
                ->generate($sku)."
                    </div>
                    <div style='height: 65px; width: 106px;float: left;padding-left: 0px !important;margin: 0 !important;'>
                    <span style='font-size: 15px;padding-left: 0px;clear: both;display: inline-block;
//                    overflow: hidden;white-space: nowrap;'>".$brand."</b><span><br>".
                    $attribute_vaue.

                    "</div>
                    <div style = 'height: 10px;padding: 0 !important;margin: 0 !important;display: inline-block;'><span style='font-size: 20px;'><b>$sku</b></span></div>
                </div>
                 ";

        return view('product_variation.barcode',compact('data'));

    }
    public function test(){

    }
    public function printBulkBarcode($id){
        $data = '';
        $product_draft = ProductDraft::with('ProductVariations')->find($id);
//         echo "<pre>";
//         print_r($product_draft->ProductVariations);
//         exit();
        $product_id = $id;


        $brand = Brand::find($product_draft->brand_id)->name ?? '';

//        $data = asset('barcode/'.$variation_info->barcode);
//        return $data;
        foreach ($product_draft->ProductVariations as $variation_info){
            $attribute_value = '';
            $sku = $variation_info->sku;
            foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){

                $attribute_value = $attribute_value ."<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".$attribute["attribute_name"] .': '.$attribute["terms_name"]." </b><span><br>";
            }
//        if (isset($variation_info->attribute1)){
//            $attribute1 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(5)->attribute_name .': '.$variation_info->attribute1." </b><span><br>";
//        }if (isset($variation_info->attribute2)){
//            $attribute2 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(6)->attribute_name .': '.$variation_info->attribute2." </b><span><br>";
//        }if (isset($variation_info->attribute3)){
//            $attribute3 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(7)->attribute_name .': '.$variation_info->attribute3." </b><span><br>";
//        }if (isset($variation_info->attribute4)){
//            $attribute4 = "<span style='font-size: 10px;padding-left: 0px;display: inline-block;'><b>".Attribute::find(7)->attribute_name .': '.$variation_info->attribute4." </b><span><br>";
//        }if (isset(Brand::find($variation_info->product_draft->brand_id)->name)){
//            $brand ="<span style='font-size: 15px;padding-left: 0px;clear: both;display: inline-block;
//                    overflow: hidden;white-space: nowrap;'>".Brand::find($variation_info->product_draft->brand_id)->name." </b><span><br>" ;
//        }

//        $data = "<p class='inline'><span ><b>Item: $product</b></span>".$this->bar128(stripcslashes($product_id))."<span ><b>Price: ".$rate." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
            $data .= "<div style='height: 90px; width: 180px;'>
                    <div style='height: 65px; width: 66px;float: left;padding: 0 !important;margin: 0 !important;'>".\SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)
                    ->generate($sku)."
                    </div>
                    <div style='height: 65px; width: 106px;float: left;padding-left: 0px !important;margin: 0 !important;'>
                    <span style='font-size: 15px;padding-left: 0px;clear: both;display: inline-block;
//                    overflow: hidden;white-space: nowrap;'>".$brand."</b><span><br>".
                    $attribute_value.

                    "</div>
                    <div style = 'height: 10px;padding: 0 !important;margin: 0 !important;display: inline-block;'><span style='font-size: 20px;'><b>$sku</b></span></div>
                </div><br>
                 ";
        }


        return view('product_variation.barcode',compact('data'));

    }

    public function bar128($text){

        global $char128asc,$char128charWidth,$char128wid;
        $char128asc=' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        $char128wid = array(
            '212222','222122','222221','121223','121322','131222','122213','122312','132212','221213', // 0-9
            '221312','231212','112232','122132','122231','113222','123122','123221','223211','221132', // 10-19
            '221231','213212','223112','312131','311222','321122','321221','312212','322112','322211', // 20-29
            '212123','212321','232121','111323','131123','131321','112313','132113','132311','211313', // 30-39
            '231113','231311','112133','112331','132131','113123','113321','133121','313121','211331', // 40-49
            '231131','213113','213311','213131','311123','311321','331121','312113','312311','332111', // 50-59
            '314111','221411','431111','111224','111422','121124','121421','141122','141221','112214', // 60-69
            '112412','122114','122411','142112','142211','241211','221114','413111','241112','134111', // 70-79
            '111242','121142','121241','114212','124112','124211','411212','421112','421211','212141', // 80-89
            '214121','412121','111143','111341','131141','114113','114311','411113','411311','113141', // 90-99
            '114131','311141','411131','211412','211214','211232','23311120' ); // 100-106


        $w = $char128wid[$sum = 104]; // START symbol
        $onChar=1;
        for($x=0;$x<strlen($text);$x++) // GO THRU TEXT GET LETTERS
            if (!( ($pos = strpos($char128asc,$text[$x])) === false )){ // SKIP NOT FOUND CHARS
                $w.= $char128wid[$pos];
                $sum += $onChar++ * $pos;
            }
        $w.= $char128wid[ $sum % 103 ].$char128wid[106]; //Check Code, then END
        //Part 2, Write rows
        $html="<table cellpadding=0 cellspacing=0><tr>";
        for($x=0;$x<strlen($w);$x+=2) // code 128 widths: black border, then white space
            $html .= "<td><div class=\"b128\" style=\"border-left-width:{$w[$x]};width:{$w[$x+1]}\"></div></td>";
//        return "$html<tr><td colspan=".strlen($w)." align=left><font family=arial size=2>$text</td></tr></table>";
        return "$html<tr><td colspan=".strlen($w)." align=left><font family=arial size=2></td></tr></table>";
    }

    public function InvoiceListSearch(Request $request){
        //return $request;
//        return date('Y-m-d', strtotime($request->start_date))." 00:00:00";
        $invoice_result = Invoice::with('invoiceProductVariations','return_order_info')->paginate(50);
        if($request->sku_or_id != null){
            $id = ProductVariation::where('sku',$request->sku_or_id)->orWhere('id',$request->sku_or_id)->first();
            $invoice_result = Invoice::with(['invoiceProductVariations' => function($query) use ($id){
                $query->where('product_variation_id',$id->id ?? null);
            },'return_order_info']);
        }
//        $invoice_result = array();
        if(isset($request->start_date) && isset($request->end_date)) {
            $invoice_result = $invoice_result->wherebetween('receive_date', [date('Y-m-d', strtotime($request->start_date))." 00:00:00",date('Y-m-d', strtotime($request->end_date))." 23:59:59"]);
        }
        if(isset($request->vendor_id)){
            $invoice_result = $invoice_result->where('vendor_id' , 'LIKE','%'.$request->vendor_id.'%');
        }
        if(isset($request->invoice_number)){
            $invoice_result = $invoice_result->where('invoice_number', 'LIKE', '%' . $request->invoice_number . '%');
        }
        $invoice_result = $invoice_result->orderByDesc('receive_date')->get();

//        $invoice_result = Invoice::with('invoiceProductVariations','return_order_info')
//            ->where('invoice_number' , 'LIKE','%'.$request->invoice_number.'%')
//            ->where(  'vendor_id' , 'LIKE','%'.$request->vendor_id.'%'  )
//            ->orwhereBetween('created_at', [date('Y-m-d', strtotime($request->start_date)),date('Y-m-d', strtotime($request->end_date))])
//            ->get();
        $vendors = Vendor::get()->all();
        $total_invoice_result = Invoice::count();
        $invoice_results = json_decode(json_encode($invoice_result));

        echo "<pre>";
        print_r($total_invoice_result);
        exit();

        $content = view('invoice.invoice_view',compact('invoice_results','vendors', 'invoice_result', 'total_invoice_result'));
        return view('master',compact('content'));

    }

    public function bulkShelverChange(Request $request){
        try {
            $result  = InvoiceProductVariation::whereIn('id',$request->checkbox)->update(['shelver_user_id'=> $request->shelver_id]);
            return response()->json(['data' => 'success']);
        }catch (\Exception $ex){
            return response()->json(['data' => 'error']);
        }
    }

    public function getProductPriceAjax(Request  $request){
        $product_price = ProductVariation::find($request->prodcut_id);
        $variation = '';
        $variation = '';
        foreach (\Opis\Closure\unserialize($product_price->attribute) as $attribute_value){
            $variation .= $attribute_value['attribute_name'].' -> '.$attribute_value['terms_name'].' , ';
        }
//        if(isset($product_price->attribute1)){
//            $attribute_name = Attribute::find(5)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute1.', ';
//        }
//        if(isset($product_price->attribute2)){
//            $attribute_name = Attribute::find(6)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute2.', ';
//        }
//        if(isset($product_price->attribute3)){
//            $attribute_name = Attribute::find(7)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute3.', ';
//        }
//        if(isset($product_price->attribute4)){
//            $attribute_name = Attribute::find(8)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute4.', ';
//        }
//        if(isset($product_price->attribute5)){
//            $attribute_name = Attribute::find(9)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute5.', ';
//        }
//        if(isset($product_price->attribute6)){
//            $attribute_name = Attribute::find(10)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute6.', ';
//        }
//        if(isset($product_price->attribute7)){
//            $attribute_name = Attribute::find(11)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute7.', ';
//        }
//        if(isset($product_price->attribute8)){
//            $attribute_name = Attribute::find(12)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute8.', ';
//        }
//        if(isset($product_price->attribute9)){
//            $attribute_name = Attribute::find(13)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute9.', ';
//        }
//        if(isset($product_price->attribute10)){
//            $attribute_name = Attribute::find(14)->attribute_name;
//            $variation .= $attribute_name.'->'.$product_price->attribute10.', ';
//        }
        $all_variation = rtrim($variation,', ');
        return response()->json(['data' => $product_price->cost_price, 'variation' => $all_variation]);
    }

    /*
     * Function : catalogueProductInvoiceReceive
     * Route : catalogue-product-invoice-receive
     * parameters: $id(catalogue ID), $var_id(variation ID), $type(return or not), $return_id(Return Order ID)
     * Request : get
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for receive product (new product or return order product)
     * Created Date: unknown
     * Modified Date : 18-11-2020
     * Modified Content : isset error check and error exception handle
     */
    public function catalogueProductInvoiceReceive($id,$var_id = null,$type = null,$return_id = null, $variationId = null){
        try {
            $catalogue_name = ProductDraft::find($id);
            $vendors = Vendor::get()->all();
            $all_shelver = Role::with(['users_list'])->where('id',4)->first();
            $variation = '';
            $variation_info = null;
            $singleVariationInfo = [];
            $shelfUse = Client::first()->shelf_use;
            $allInvoiceNumbers = [];
            if($var_id != null){
                if($return_id == null) {
                    $product_variations = ProductVariation::select('id','sku','cost_price')->where('product_draft_id',$id)->orderBy('created_at','DESC')->get()->all();
                    $variation_info = ProductVariation::find($var_id);
                    $variation = '';
                    if($variation_info){
                        if(isset($variation_info->attribute)){
                            foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){
                                $variation .= $attribute['attribute_name'].' -> '.$attribute['terms_name'].' , ';
                            }
                        }
                        $singleVariationInfo['variation'] = rtrim($variation, ',');
                        $singleVariationInfo['cost_price'] = $variation_info->cost_price;
                    }
                }else{
                    $order_id = ReturnOrderProduct::select('variation_id')->where('return_order_id',$return_id)->get();
                    $variation_info = ProductVariation::find($var_id);
                    $variation = '';
                    if($variation_info){
                        if(isset($variation_info->attribute)){
                            foreach (\Opis\Closure\unserialize($variation_info->attribute) as $attribute){
                                $variation .= $attribute['attribute_name'].' -> '.$attribute['terms_name'].',';
                            }
                        }
                        $singleVariationInfo['variation'] = rtrim($variation, ',');
                    }
                    if(count($order_id) > 0){
                        $ids = [];
                        foreach ($order_id as $id){
                            $ids[] = $id->variation_id;
                        }
                        $implode_id = implode(',',$ids);
                        $product_variations = ProductVariation::select('id','sku','cost_price','attribute')->whereIn('id',$ids)
                            ->orderByRaw("FIELD(id, $implode_id)")
                            ->orderBy('created_at','DESC')
                            ->get()->all();
                        if($variationId){
                            $singleOrderVariationInfo = ProductVariation::find($variationId);
                            foreach (\Opis\Closure\unserialize($singleOrderVariationInfo->attribute) as $attribute){
                                $variation .= $attribute['attribute_name'].' -> '.$attribute['terms_name'].',';
                            }
                            $singleVariationInfo['variation'] = rtrim($variation, ',');
                            $singleVariationInfo['cost_price'] = $singleOrderVariationInfo->cost_price;
                            $singleVariationInfo['return_quantity'] = ReturnOrderProduct::where('return_order_id',$return_id)->where('variation_id',$variationId)->first()->return_product_quantity;
                        }else{
                            if(count($product_variations) == 1){
                                foreach (\Opis\Closure\unserialize($product_variations[0]->attribute) as $attribute){
                                    $variation .= $attribute['attribute_name'].' -> '.$attribute['terms_name'].',';
                                }
                                $singleVariationInfo['variation'] = rtrim($variation, ',');
                                $singleVariationInfo['cost_price'] = $product_variations[0]->cost_price;
                                $singleVariationInfo['return_quantity'] = ReturnOrderProduct::where('return_order_id',$return_id)->where('variation_id',$product_variations[0]->id)->first()->return_product_quantity;
                            }
                        }
                        $allInvoiceIds = [];
                        $supplierIds = [];
                        $invoiceVariationInfo = InvoiceProductVariation::whereIn('product_variation_id',$ids)->get()->toArray();
                        if(count($invoiceVariationInfo) > 0){
                            foreach($invoiceVariationInfo as $invoice){
                                $allInvoiceIds[] = $invoice['invoice_id'];
                            }

                        }
                        $invoiceNumberInfo = Invoice::whereIn('id',$allInvoiceIds)->get()->toArray();
                        if(count($invoiceNumberInfo) > 0){
                            foreach($invoiceNumberInfo as $info){
                                $allInvoiceNumbers[] = [
                                    'invoice_number' => $info['invoice_number'],
                                    'vendor_id' => $info['vendor_id']
                                ];
                                if(!in_array($info['vendor_id'],$supplierIds)){
                                    $supplierIds[] = $info['vendor_id'];
                                }
                            }

                        }
                        // foreach($product_variations as $invoice){
                        //     if(count(json_decode($invoice)->variation_invoices) > 0){
                        //         foreach(json_decode($invoice)->variation_invoices as $variation){
                        //             $allInvoiceNumbers[] = $variation->invoice_number;
                        //             $allInvoiceIds[] = $variation->id;
                        //             if(!in_array($variation->vendor_id,$supplierIds)){
                        //                 $supplierIds[] = $variation->vendor_id;
                        //             }
                        //         }
                        //     }
                        // }
                        $vendors = Vendor::whereIn('id',$supplierIds)->get()->all();
                    }else{
                        $product_variations = null;
                    }
                }

            }else{
                $product_variations = ProductVariation::select('id','sku')->where('product_draft_id',$id)->get()->all();

            }
            $variationId = $variationId ? $variationId : (!$return_id ? $var_id : null);
            $conditions = Condition::all();
            $content = view('invoice.catalogue_product_invoice_receive',compact('id','vendors','all_shelver','product_variations','catalogue_name','var_id','singleVariationInfo','return_id','variation_info','conditions','shelfUse','allInvoiceNumbers','variationId'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return $exception->getMessage();
            // return redirect('exception')->with('exception',$exception->getMessge());
        }

    }

    public function clientInfo(){
        $shelfStatus = Session::get('shelf_use');
        if($shelfStatus != ''){
            return $shelfStatus;
        }else{
            $shelfInfo = Client::first();
            if($shelfInfo){
                Session::put('shelf_info',$shelfInfo->shelf_use);
                return $shelfInfo->shelf_use;
            }else{
                return 'not-use';
            }

        }
    }

    /*
     * Function : saveCatalogueProductInvoiceReceive
     * Route : save-catalogue-product-invoice-receive
     * Method Type : POST
     * Parametes : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for saving invoice receive information
     * Created Date: unknown
     * Modified Date : 29-11-2020
     * Modified Content : Sync quantity in different channel depending on client app use
     */
    public function saveCatalogueProductInvoiceReceive(Request $request){
        try {
            $invoice_result = Invoice::select('id')->where('invoice_number',$request->invoice_number)->get()->first();
            $shelf_use = $this->clientInfo();
            if($shelf_use == 0){
                $genericShelfId = Shelf::first()->id ?? null;
                $firstUser = User::first()->id ?? null;
            }
            if (!isset($invoice_result)) {
                $invoice_create_result = Invoice::create([
                    'vendor_id' => $request->vendor_id,
                    'receiver_user_id' => Auth::id(),
                    'return_order_id' => $request->invoice_type ?? null,
                    'invoice_number' => $request->invoice_number ?? null,
                    'invoice_total_price' => '0.00',
                    'receive_date' => $request->receive_date ?? now()
                ]);
                $total_price = 0;
                if(count($request->product_variation_id) > 0) {
                    foreach ($request->product_variation_id as $key => $value) {
                        if ($invoice_create_result->id != null) {
                            $invoice_product_result = InvoiceProductVariation::create([
                                'invoice_id' => $invoice_create_result->id ?? null,
                                'product_variation_id' => $request->product_variation_id[$key],
                                'shelver_user_id' => ($shelf_use == 1) ? ($request->shelver_user_id[$key] ?? null) : $firstUser,
                                'quantity' => $request->quantity[$key],
                                'shelved_quantity' => ($shelf_use == 0) ? $request->quantity[$key] : 0,
                                'price' => $request->price[$key] ?? '0.00',
                                'shelving_status' => ($shelf_use == 0) ? 1 : 0,
                                'product_type' => 1,
                                'total_price' => ($request->quantity[$key] * $request->price[$key])
                            ]);
                            $total_price += ($request->quantity[$key] * $request->price[$key]);
                            if ($request->pk_return_order_id != null) {
                                $shelve_result = ReturnOrderProduct::where('return_order_id', $request->pk_return_order_id)
                                    ->where('variation_id', $request->product_variation_id[$key])
                                    ->update(['status' => 1]);
                            }
                            if ($shelf_use == 0) {
                                $channelUpdate = $this->syncQuantityWithoutApp($request->product_variation_id[$key], $request->quantity[$key]);
                                $productShelfData = ShelfedProduct::create([
                                    'shelf_id' => $genericShelfId,
                                    'variation_id' => $request->product_variation_id[$key],
                                    'quantity' => $request->quantity[$key]
                                ]);
                            }
                        }

                    }
                }

                $update = Invoice::where('id',$invoice_create_result->id)->update([
                    'invoice_total_price' => $total_price
                ]);
                return back()->with('success','Product successfully received at invoice number: '.$request->invoice_number);
            }else{
                $total_price = 0;
                if(count($request->product_variation_id) > 0) {
                    foreach ($request->product_variation_id as $key => $value) {
                        if ($invoice_result->id != null) {
                            $invoice_product_result = InvoiceProductVariation::create([
                                'invoice_id' => $invoice_result->id ?? null,
                                'product_variation_id' => $request->product_variation_id[$key],
                                'shelver_user_id' => ($shelf_use == 1) ? ($request->shelver_user_id[$key] ?? null) : $firstUser,
                                'quantity' => $request->quantity[$key],
                                'shelved_quantity' => ($shelf_use == 0) ? $request->quantity[$key] : 0,
                                'price' => $request->price[$key] ?? '0.00',
                                'shelving_status' => ($shelf_use == 0) ? 1 : 0,
                                'product_type' => 1,
                                'total_price' => ($request->quantity[$key] * $request->price[$key])
                            ]);
                            $total_price += ($request->quantity[$key] * $request->price[$key]);
                            if ($request->pk_return_order_id != null) {
                                $shelve_result = ReturnOrderProduct::where('return_order_id', $request->pk_return_order_id)
                                    ->where('variation_id', $request->product_variation_id[$key])
                                    ->update(['status' => 1]);
                            }
                            if ($shelf_use == 0) {
                                $channelUpdate = $this->syncQuantityWithoutApp($request->product_variation_id[$key], $request->quantity[$key]);
                                $productShelfData = ShelfedProduct::create([
                                    'shelf_id' => $genericShelfId,
                                    'variation_id' => $request->product_variation_id[$key],
                                    'quantity' => $request->quantity[$key]
                                ]);
                            }
                        }
                    }
                }
                $before_total = Invoice::find($invoice_result->id)->invoice_total_price;

                $update = Invoice::where('id',$invoice_result->id)->update([
                    'invoice_total_price' => ($before_total + $total_price)
                ]);
                return back()->with('success','Product successfully received at invoice number: '.$request->invoice_number);
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }

    }

    /*
     * Function : syncQuantityWithoutApp
     * Route : child function
     * Method Type :
     * Parametes : $variationId,$receiveQnty
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for getting variation info and account info of ebay
     * Created Date: 29-11-2020
     * Modified Date : 29-11-2020
     * Modified Content :
     */

    public function syncQuantityWithoutApp($variationId,$receiveQnty){
        try {
            $variation_exist = ProductVariation::find($variationId);
            if($variation_exist) {
                $check_quantity = new CheckQuantity();
                $check_quantity->checkQuantity($variation_exist->sku, $receiveQnty,null, 'Sync Quantity Without App');
                // $update_quantity = $variation_exist->actual_quantity + $receiveQnty;
                // $variation_exist->actual_quantity = $update_quantity;
                // $result = $variation_exist->save();

                // $ebayStatus = DeveloperAccount::where('status', 1)->first();
                // if ($ebayStatus) {
                //     if ($variation_exist->sku != '') {
                //         $ebay_product_variation_finds = EbayVariationProduct::with(['masterProduct'])->where('sku', $variation_exist->sku)->get();
                //         if (count($ebay_product_variation_finds) > 0) {
                //             foreach ($ebay_product_variation_finds as $ebay_product_variation_find) {
                //                 if ($ebay_product_variation_find != null) {
                //                     $item_id = $ebay_product_variation_find->masterProduct->item_id;
                //                     $site_id = $ebay_product_variation_find->masterProduct->site_id;
                //                     $this->updateEbayQuantity($variation_exist->sku, $update_quantity);
                //                     $ebay_update = EbayVariationProduct::where('sku', $variation_exist->sku)->update(['quantity' => $update_quantity]);
                //                 }
                //             }
                //         }else{
                //             return back()->with('error','eBay variation product not found');
                //         }
                //     }
                // }else{
                //     return back()->with('error','Developer account not found');
                // }
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /*
     * Function : updateEbayQuantity
     * Route : child function
     * Method Type :
     * Parametes : $sku,$quantity
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for updating ebay variation quantity through api
     * Created Date: 29-11-2020
     * Modified Date : 29-11-2020
     * Modified Content :
     */
    public function updateEbayQuantity($sku,$quantity){
        try {
            $ebay_product_find = EbayVariationProduct::with('masterProduct')->where('sku',$sku)->get()->all();
            if(count($ebay_product_find) > 0) {
                foreach ($ebay_product_find as $product) {
                    $account_result = EbayAccount::find($product->masterProduct->account_id);
                    $this->ebayAccessToken($account_result->refresh_token);
                    $url = 'https://api.ebay.com/ws/api.dll';
                    $headers = [
                        'X-EBAY-API-SITEID:' . $product->masterProduct->site_id,
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
                            <ItemID>' . $product->masterProduct->item_id . '</ItemID>
                            <Variations>
                                <!-- Identify the first new variation and set price and available quantity -->
                              <Variation>
                                <SKU>' . $sku . '</SKU>

                                <Quantity>' . $quantity . '</Quantity>

                              </Variation>
                              <!-- Identify the second new variation and set price and available quantity -->

                            </Variations>
                          </Item>
                        </ReviseFixedPriceItemRequest>';
                    $update_ebay_product = $this->curl($url, $headers, $body, 'POST');
                }
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /*
     * Function : ebayAccessToken
     * Route : child function
     * Method Type :
     * Parametes : $refresh_token
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for getting the ebay access token
     * Created Date: 29-11-2020
     * Modified Date : 29-11-2020
     * Modified Content :
     */
    public function ebayAccessToken($refresh_token){
        try {
            $developer_result = DeveloperAccount::get()->first();
            $clientID  = $developer_result->client_id;
            $clientSecret  = $developer_result->client_secret;
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
        }catch (\Exception $exception){
            return $exception;
        }
    }

    /*
     * Function : curl
     * Route : child function
     * Method Type :
     * Parametes : $url,$header,$body,$method
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for requesting the ebay site and return the response
     * Created Date: 29-11-2020
     * Modified Date : 29-11-2020
     * Modified Content :
     */
    public function curl($url,$header,$body,$method){
        try {
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
        }catch (\Exception $exception){
            return $exception;
        }
    }
}
