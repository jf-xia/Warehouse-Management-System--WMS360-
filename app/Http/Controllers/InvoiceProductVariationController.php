<?php

namespace App\Http\Controllers;

use App\Client;
use App\Condition;
use App\InvoiceProductVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;
use App\DefectedProduct;
use App\DefectProductAction;
use App\DefectedProductReason;


class InvoiceProductVariationController extends Controller
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
     * @param  \App\InvoiceProductVariation  $invoiceProductVariation
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceProductVariation $invoiceProductVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceProductVariation  $invoiceProductVariation
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceProductVariation $invoiceProductVariation,$id)
    {
        $shelfUse = $this->clientInfo();
        $invoice_product = InvoiceProductVariation::find($id);
        $users = User::get()->all();
        $conditions = Condition::all();
        $content = view('invoice_product.invoice_product_edit',compact('invoice_product','users','shelfUse','conditions'));
        return view('master',compact('content'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceProductVariation  $invoiceProductVariation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceProductVariation $invoiceProductVariation,$id)
    {

        try{
            $invoiceProductVariation = InvoiceProductVariation::find($id);
            // echo '<pre>';
            // dd($invoiceProductVariation);
            // exit();
            $result = 0;
            if($request->quantity > $invoiceProductVariation->shelved_quantity){
                $result = $invoiceProductVariation->update($request->all());
            }elseif($request->quantity == $invoiceProductVariation->shelved_quantity){
                $request['shelving_status'] = 1;
                $result = $invoiceProductVariation->update($request->all());
            }

            if ($result == 1){
                return redirect('pending-receive')->with('success', 'updated successfully');
            }else{
                return back()->with('error', 'Not Updated : Quantity lower then shelved');
            }
        }catch (Exception $exception){
            return redirect('pending-receive')->with('error', $exception);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceProductVariation  $invoiceProductVariation
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceProductVariation $invoiceProductVariation,$id)
    {
        try{
            $result = $invoiceProductVariation::destroy($id);
            if ($result){
                return redirect('pending-receive')->with('success', 'deleted successfully');
            }
        }catch (Exception $exception){
            return redirect('pending-receive')->with('error', $exception);
        }

    }

    public function defectedProductList(){

        $allDefectReasons = DefectedProductReason::orderBy('id','DESC')->paginate(50);
        $allDefectActions = DefectProductAction::orderBy('id','DESC')->paginate(50);

//        $distinc_value = InvoiceProductVariation::distinct()->get(['quantity']);
//        $distinc_value = json_decode(json_encode($distinc_value));
////        return $distinc_value[1]->quantity;
//        foreach ($distinc_value as $value){
////            return $value->quantity;
//            $result = InvoiceProductVariation::where('quantity',$value->quantity)->update(['shelved_quantity' => $value->quantity,'shelving_status' => 1]);
//        }
//        exit();
        $all_defected_product_list = InvoiceProductVariation::with(['product_invoice_info' => function($query){
            $query->with(['vendor_info:id,company_name','user_info:id,name']);
        },'product_variation_info' => function($query1){
            $query1->with(['product_draft:id,name']);
        }])
        ->whereIn('product_type',[0,2])->get();

        $declareDefectProductList = DefectedProduct::with(['defectReason:id,reason','variationInfo' => function($query){
            $query->select('id','product_draft_id','image','attribute','sku','actual_quantity','ean_no')->with(['product_draft' => function($query1){
                $query1->select('id','name')->with(['single_image_info:id,draft_product_id,image_url']);
            }]);
        }])->where('defect_action_id','=',null)->orderByDesc('id')->paginate(50);
        $defectActionList = DefectProductAction::all();
    //    echo "<pre>";
    //    print_r(json_decode(json_encode($declareDefectProductList)));
    //    exit();
        $content = view('product.defected_product_list',compact('all_defected_product_list','declareDefectProductList','defectActionList','allDefectReasons','allDefectActions'));
        return view('master',compact('content'));

    }


    public function defectReasonAction(Request $request, $type, $action, $id = null){
        try{
            if($type == 'na'){
                if($action == 'all'){
                    $allDefectReasons = DefectedProductReason::orderBy('id','DESC')->paginate(50);
                    $allDefectActions = DefectProductAction::orderBy('id','DESC')->paginate(50);
                    return view('product_variation.defect_reason',compact('allDefectReasons','allDefectActions'));
                }
            }else{
                if($action == 'add'){
                    $exist = DefectedProductReason::where('reason',$request->input_value)->first();
                    if($exist){
                        return response()->json(['type' => 'error','msg' => 'Alread Exists']);
                    }
                    $insertInfo = DefectedProductReason::create(['reason' => $request->input_value]);
                    return response()->json(['type' => 'success','msg' => 'Defect Reason Added Successfully','response_data' => $insertInfo]);
                }elseif($action == 'edit'){
                    $exist = DefectedProductReason::where('reason',$request->input_value)->where('id','!=',$request->action_id)->first();
                    if($exist){
                        return response()->json(['type' => 'error','msg' => 'Alread Exists']);
                    }
                    $updateInfo = DefectedProductReason::find($request->action_id)->update(['reason' => $request->input_value]);
                    return response()->json(['type' => 'success','msg' => 'Defect Reason Updated Successfully']);
                }elseif($action == 'delete'){
                    $deleteInfo = DefectedProductReason::find($id)->delete();
                    return response()->json(['type' => 'success','msg' => 'Defect Reason Deleted Successfully']);
                }else{
                    return response()->json(['type' => 'error','msg' => 'Nothing Happaned']);
                }
            }

        }catch(\Exception $exception){
            if($type == 'na'){
                return back()->with('error','Something Went Wrong');
            }else{
                return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
            }
        }
    }


    public function defectProductAction(Request $request, $type, $action, $id = null){
        try{
            if($action == 'add'){
                $exist = DefectProductAction::where('action',$request->input_value)->first();
                if($exist){
                    return response()->json(['type' => 'error','msg' => 'Alread Exists']);
                }
                $insertInfo = DefectProductAction::create(['action' => $request->input_value]);
                return response()->json(['type' => 'success','msg' => 'Defect Product Action Added Successfully','response_data' => $insertInfo]);
            }elseif($action == 'edit'){
                $exist = DefectProductAction::where('action',$request->input_value)->where('id','!=',$request->action_id)->first();
                if($exist){
                    return response()->json(['type' => 'error','msg' => 'Alread Exists']);
                }
                $updateInfo = DefectProductAction::find($request->action_id)->update(['action' => $request->input_value]);
                return response()->json(['type' => 'success','msg' => 'Defect Product Action Updated Successfully']);
            }elseif($action == 'delete'){
                $deleteInfo = DefectProductAction::find($id)->delete();
                return response()->json(['type' => 'success','msg' => 'Defect Product Action Deleted Successfully']);
            }else{
                return response()->json(['type' => 'error','msg' => 'Nothing Happaned']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Something Went Wrong']);
        }
    }



    public function sellDefectedProduct(Request $request){
        $update_ok = InvoiceProductVariation::where('id',$request->id)->update(['product_type'=>2]);
        return response()->json(['data'=>'found']);
    }
}
