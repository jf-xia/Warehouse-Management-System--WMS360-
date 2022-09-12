<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Vendor;
use App\User;
use App\Setting;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class VendorController extends Controller
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




      /*
       * Function : index
       * Route Type : vendor-all-list
       * Method Type : GET
       * Parameters : null
       * Creator : unknown
       * Modifier : solaiman
       * Description : This function is used for supplier list and pagination setting
       * Modified Date : 30-11-2020
       * Modified Content : Pagination setting
       */

    public function index()
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('supplier', 'supplier_list');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting



        $all_vendor = Vendor::with(['user'])->paginate($pagination);
        $total_vendor = Vendor::count();
        $all_decode_vendor = json_decode(json_encode($all_vendor));
//        echo "<pre>";
//        print_r($all_vendor);
//        exit();
        //$all_vendor = Vendor::select('vendors.*','users.name AS creator_name')->Join('users','users.id', '=', 'vendors.user_id')->get()->all();
        $content = view('vendor.vendor_list',compact('all_vendor','all_decode_vendor','total_vendor', 'setting', 'page_title', 'pagination'));
        return view('master',compact('content'));
    }


    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Creator : solaiman
    * Description : This function is used for pagination setting
    * Created Date : 30-11-2020
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
//                    dd($data['pagination']);
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
    public function create()
    {
        $content = view('vendor.add_vendor');
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

        $validator = $request->validate([
//            'registration_no' => 'required|numeric|digits_between:0,15|unique:vendors',
//            'name' => 'required|max:255',
            'company_name' => 'required|max:255'
//            'email' => 'required|email|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:vendors|max:255',
//            'phone_no' => 'required|numeric|unique:vendors',
//            'address' => 'required',
//            'website' => 'required',
//            'vat_no' => 'required',
//            'country' => 'required|max:255',
//            'city' => 'required|max:255',
//            'state' => 'required|max:255',
//            'post_code' => 'required|max:255'
        ]);
        $request['user_id'] = Auth::user()->id;
        $add_vendor = Vendor::create($request->all());
        return back()->with('vendor_add_success_msg','Supplier added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor_info = Vendor::find($id);
        $content = view('vendor.vendor_details',compact('vendor_info'));
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
        $single_vendor = Vendor::find($id);
        $content = view('vendor.edit_vendor',compact('single_vendor'));
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
        
    
        try {
            // Your query here
            $validator = $request->validate([
            'registration_no' => 'digits_between:0,15,registration_no,unique:vendors'.$id,
//            'name' => 'required|max:255',
            'company_name' => 'required|max:255'
//            'vat_no' => 'required',
//            'email' => 'required|email|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:vendors,email,'.$id.'|max:255',
//            'phone_no' => 'required|numeric|unique:vendors,phone_no,'.$id,
//            'address' => 'required',
//            'website' => 'required',
//            'country' => 'required|max:255',
//            'city' => 'required|max:255',
//            'state' => 'required|max:255',
//            'post_code' => 'required|max:255'
        ]);
        $update_vendor = Vendor::findOrFail($id);
//        $request['user_id'] = Auth::user()->id;
        $vendor = $update_vendor->update($request->all());
        return back()->with('vendor_edit_success_msg','Supplier updated successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            // You need to handle the error here.
            // Either send the user back to the screen or redirect them somewhere else
        
            // Just some example
            return back()->with('message','Same data found here');
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->errorInfo);
            return back()->with('message','Same data found here');
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
        $vendor_delete = Vendor::destroy($id);
        return back()->with('vendor_delete_success_msg','Supplier deleted successfully');
    }

    public function verdorProductList($id){

        $all_invoice = Vendor::with(['invoice_info'])->find($id);
        $vendor_name = $all_invoice->name;
        $ids = array();
        foreach ($all_invoice->invoice_info as $invoice){
            $ids[] = $invoice->id;
        }
        $all_variation_product = Invoice::with(['invoice_product_variation_info','user_info'])->whereIn('id',$ids)->get();
        $content = view('vendor.vendor_product_list',compact('all_variation_product','id','vendor_name'));
        return view('master',compact('content'));
    }

    public function indivisualVendorInvoiceSearch(Request $request){
        $validation = $request->validate([
            'search' => 'required|max:200',
            'chek_value' => 'required'
        ]);
        $vendor_id = $request->id;
        $field = $request->chek_value;
        $single_invoice_info = Invoice::with(['invoice_product_variation_info','user_info'])->where('vendor_id',$vendor_id)->where(function ($query) use ($request,$field){
            for ($i = 0; $i < count($field); $i++){
                $query->orwhere($field[$i], 'like','%'.$request->search.'%');
            }
        })->get();
        $content = view('vendor.vendor_search_product_list',compact('single_invoice_info'));
        return view('master',compact('content'));
    }



    /*
     * Function : vendorColumnSearch
     * Route Type : {route_name}/supplier/search
     * Method Type : post
     * Creator : Solaiman
     * Description : This function is used for suppler each column search
     * Modified Date : 05-01-2021
     */


    public function vendorColumnSearch(Request $request){

        $column = $request->column_name;
        $value = $request->search_value;

        $all_vendor = Vendor::with(['user'])
                     ->Where(function($query) use($request, $column, $value){
                         if($column == 'registration_no'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'company_name'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'vat_no'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'email'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'phone_no'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'website'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'address'){
                             if($request->opt_out == 1){
                                 $query->where($column,'!=',$value);
                             }else{
                                 $query->where($column,'like', '%' . $value. '%');
                             }
                         }elseif($column == 'creator'){
                             if($request->opt_out == 1){
                                 $query->where('user_id','!=',$request->user_id);
                             }else{
                                 $query->where('user_id',$request->user_id);
                             }
                         }

                         // If user submit with empty data then this message will display table's upstairs
                         if($value == ''){
                             return back()->with('no_data_found', 'Your input field is empty!! Please submit valuable data!!');
                         }
                     })

                     ->paginate(50);


        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $all_vendor_Ids = [];
        if((is_countable($all_vendor) && count($all_vendor)) > 0){
            foreach ($all_vendor as $result){
                $all_vendor_Ids[] = $result->id;
            }
        }else{
            return redirect('/vendor-all-list')->with('message','No data found');
        }


        $users = User::all();
        $total_vendor = Vendor::count();
        $all_decode_vendor = json_decode(json_encode($all_vendor));
//        echo "<pre>";
//        print_r($all_decode_vendor);
//        exit();
        return view('vendor.vendor_list',compact('all_vendor','all_decode_vendor','total_vendor', 'users', 'column', 'value'));

    }


      /*
       * Function : searchSupplierCompanyName
       * Route Type : {route_name}/company/name/search
       * Method Type : post
       * Creator : Solaiman
       * Description : This function is used for suppler company name ande registration no
       * Modified Date : 05-01-2021
       */

    public function searchSupplierCompanyName(Request $request){

        $company_name_search_value = $request->search_value;
        $all_vendor = Vendor::where('company_name','LIKE', '%'. $company_name_search_value.'%')
                     ->orWhere('registration_no','LIKE', '%'. $company_name_search_value.'%')
                     ->paginate(50);

        $total_vendor = Vendor::count();
        $all_decode_vendor = json_decode(json_encode($all_vendor));
//        echo "<pre>";
//        print_r($all_decode_vendor);
//        exit();
        return view('vendor.vendor_list',compact('all_vendor','all_decode_vendor','total_vendor'));
    }


}
