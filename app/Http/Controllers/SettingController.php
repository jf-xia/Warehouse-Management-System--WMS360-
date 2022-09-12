<?php

namespace App\Http\Controllers;

use App\Client;
use App\InvoiceSetting;
use App\Setting;
use App\ShippingSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
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
        $setting_info = Setting::where('user_id',Auth::user()->id)->first();
        return redirect(url('settings/'.Auth::user()->id));
        // if(isset($setting_info->setting_attribute)){
        //     return redirect(url('settings/'.Auth::user()->id));
        // }else {
        //     $content = view('setting.setting');
        //     return view('master', compact('content'));
        // }
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
        $user_id = Auth::user()->id;
        foreach ($request->page_name as $key => $value){
            $setting_arr[$value] = [
                'page_name' => $value,
                'page_title' => $request->page_title[$key] ?? null,
                'table_header_color' => $request->table_header_color[$key] ?? null,
                'table_header_text_color' => $request->table_header_text_color[$key] ?? null
            ];
        }
        $setting_info = json_encode($setting_arr);
        $exist_user = Setting::where('user_id',$user_id)->first();
        if(!$exist_user) {
            $insert_info = Setting::create([
                'user_id' => Auth::user()->id,
                'setting_attribute' => $setting_info ?? null
            ]);
            return back()->with('success', 'Setting added successfully');
        }else{
            $insert_info = Setting::where('user_id',$user_id)->update([
                'setting_attribute' => $setting_info ?? null
            ]);
        }
        return back()->with('success', 'Setting added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*
     * Function : show
     * Route : settings/{id}
     * Method Type : GET
     * Parametes : $id
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for showing user settings and can be edit from there
     * Created Date: unknown
     * Modified Date : 29-11-2020
     * Modified Content :
     */
    public function show($id)
    {
        try {
            $client_info = Client::first();
            $combinedOrderSettingInfo = Setting::where('user_id',1)->first();
            $unserializeCombinedOrderSettingInfo = isset($combinedOrderSettingInfo->setting_attribute) ? unserialize($combinedOrderSettingInfo->setting_attribute) : [];
            if($client_info){
                $content = view('setting.view_setting',compact('client_info','unserializeCombinedOrderSettingInfo'));
                return view('master',compact('content'));
            }else{
                return redirect('exception')->with('exception','Client not found. Client may be not set');
            }
        }catch (\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    /*
     * Function : shelfSetting
     * Route : shelf-use-setting/{shelfStatus} (ajax)
     * Method Type : GET
     * Parametes : $shelfStatus
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for changing the permission of client shelf use
     * Created Date: 29-11-2020
     * Modified Date : 29-11-2020
     * Modified Content :
     */
    public function shelfSetting($shelfStatus)
    {
        try {
            $clientInfo = Client::first();
            if($clientInfo){
                $clientInfo->shelf_use = $shelfStatus;
                $clientInfo->save();
                Session::put('shelf_use',$shelfStatus);
                return response()->json('Saved Successfully');
            }else{
                return response()->json('Client Not Found');
            }
        }catch (\Exception $exception){
            return response()->json('Something Went Wrong');
        }
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
        foreach ($request->page_name as $key => $value){
            $setting_arr[$value] = [
                'page_name' => $value,
                'page_title' => $request->page_title[$key] ?? null,
                'table_header_color' => $request->table_header_color[$key] ?? null,
                'table_header_text_color' => $request->table_header_text_color[$key] ?? null
            ];
        }

        $setting_info = json_encode($setting_arr);
//        echo "<pre>";
//        print_r($setting_arr);
//        exit();
        $insert_info = Setting::where('user_id',Auth::user()->id)->update([
            'user_id' => Auth::user()->id,
            'setting_attribute' => $setting_info ?? null
        ]);
        return back()->with('success','Setting updated successfully');
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


    /*
     * Function : saveSetting
     * Route : save-setting
     * Method Type : POST
     * Parameters : null
     * Creator : Kazol
     * Modifier : Kazol
     * Description : This function is used for setting pagination value and screen option
     * Created Date: unknown
     * Modified Date : 24-11-2020
     * Modified Content : Foreach loop of result variable and isset condition
     */

    public function saveSetting(Request $request){
        // dd($request->all());
        try {
            $user_id = Auth::user()->id;
            $screenOptionArr = (array)$request->screen_option;
            $arrFirstKey = $request->arrFirstKey;
            $arrSecondKey = $request->arrSecondKey;
            $exist_user = Setting::where('user_id',$user_id)->first();
//            if(count($screenOptionArr) > 0) {
                if ($exist_user) {
                    $existScreenOption = \Opis\Closure\unserialize($exist_user->setting_attribute);
                    if ($existScreenOption != null) {
                        if (array_key_exists($arrFirstKey, $existScreenOption)) {
                            if (array_key_exists($arrSecondKey, $existScreenOption[$arrFirstKey])) {
                                $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                                $existScreenOption[$arrFirstKey][$arrSecondKey]['pagination'] = $request->per_page;
                            } else {
                                foreach ($existScreenOption[$arrFirstKey] as $key => $value) {
                                    $existScreenOption[$arrFirstKey][$key] = $value;
                                }
                                $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                                $existScreenOption[$arrFirstKey][$arrSecondKey]['pagination'] = $request->per_page;
                            }
                        } else {
                            foreach ($existScreenOption as $key => $value) {
                                $existScreenOption[$key] = $value;
                            }
                            if ($arrSecondKey != '') {
                                $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                                $existScreenOption[$arrFirstKey][$arrSecondKey]['pagination'] = $request->per_page;
                            } else {
                                $existScreenOption[$arrFirstKey] = $screenOptionArr;
                                $existScreenOption[$arrFirstKey]['pagination'] = $request->per_page;
                            }
                        }
                    } else {
                        $existScreenOption = [];
                        if ($arrSecondKey != '') {
                            $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                            $existScreenOption[$arrFirstKey][$arrSecondKey]['pagination'] = $request->per_page;
                        } else {
                            $existScreenOption[$arrFirstKey] = $screenOptionArr;
                            $existScreenOption[$arrFirstKey]['pagination'] = $request->per_page;
                        }
                    }
//                    return response()->json($existScreenOption);
                    $update_info = Setting::where('user_id', $user_id)->update(['setting_attribute' => \Opis\Closure\serialize($existScreenOption)]);
                    // dd($update_info);
                    return response()->json(['data' => '<h5>Table Column And Pagination Updated Successfully!!</h5>']);
                } else {
                    $existScreenOption = [];
                    if ($arrSecondKey != '') {
                        $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                    } else {
                        $existScreenOption[$arrFirstKey] = $screenOptionArr;
                    }
                    $create_info = Setting::create(['user_id' => $user_id, 'setting_attribute' => \Opis\Closure\serialize($existScreenOption)]);
                    return response()->json(['data' => 'Pagination Created Successfully']);
                }
//            }else{
//                return response()->json(['data' => 'Screen Option Value Not Found']);
//            }
        }catch (\Exception $exception){
            return response()->json(['data' => 'Something went wrong']);
        }
    }

// Auto Sync on off Button setting
    public function autoSyncButton(){
        try{
            return view('setting/auto_sync_on_of_button');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }
// Auto Sync on off Button setting
    public function autoSyncButtonSave(Request $request){
        try{
            return view('setting/auto_sync_on_of_button');
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }


// invoice setting
    public function invoiceSetting(){
        try{
            $invoiceSetting = InvoiceSetting::first();
            return view('setting/invoice_setting', compact('invoiceSetting'));
        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }


    // invoice setting save
    public function invoiceSettingSave(Request $request){

        try{

            if(empty(InvoiceSetting::count())){
                $invoiceSetting = new InvoiceSetting;
                $invoiceSetting->sku_no = $request->sku_no;
                $invoiceSetting->variation_id = $request->variation_id;
                $invoiceSetting->ean_no = $request->ean_no;
                $invoiceSetting->attribute = $request->attribute;
                $invoiceSetting->default_vat = $request->default_vat;
                $invoiceSetting->invoice_notice = $request->invoice_notice;
                $invoiceSetting->save();
                return back()->with('success', 'Updated Successfully');
            }else{
                $invoiceSetting = InvoiceSetting::first();
                $invoiceSetting->sku_no = $request->sku_no;
                $invoiceSetting->variation_id = $request->variation_id;
                $invoiceSetting->ean_no = $request->ean_no;
                $invoiceSetting->attribute = $request->attribute;
                $invoiceSetting->default_vat = $request->default_vat;
                $invoiceSetting->invoice_notice = $request->invoice_notice;
                $invoiceSetting->save();
                return back()->with('success', 'Updated Successfully');
            }




        }catch(\Exception $exception){
            return redirect('exception')->with('exception',$exception->getMessage());
        }
    }

    public function saveCombinedOrderSettings(Request $request){
        try{
            $screenOptionArr = $request->filter_order;
            $arrFirstKey = 'order';
            $arrSecondKey = 'combined_order';
            $filterOrderUser = Setting::where('user_id',1)->first();
            if ($filterOrderUser) {
                $existScreenOption = \Opis\Closure\unserialize($filterOrderUser->setting_attribute);
                if ($existScreenOption != null) {
                    if (array_key_exists($arrFirstKey, $existScreenOption)) {
                        if (array_key_exists($arrSecondKey, $existScreenOption[$arrFirstKey])) {
                            $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                        } else {
                            foreach ($existScreenOption[$arrFirstKey] as $key => $value) {
                                $existScreenOption[$arrFirstKey][$key] = $value;
                            }
                            $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                        }
                    } else {
                        foreach ($existScreenOption as $key => $value) {
                            $existScreenOption[$key] = $value;
                        }
                        if ($arrSecondKey != '') {
                            $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                        } else {
                            $existScreenOption[$arrFirstKey] = $screenOptionArr;
                        }
                    }
                } else {
                    $existScreenOption = [];
                    if ($arrSecondKey != '') {
                        $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                    } else {
                        $existScreenOption[$arrFirstKey] = $screenOptionArr;
                    }
                }
                $update_info = Setting::where('user_id', 1)->update(['setting_attribute' => \Opis\Closure\serialize($existScreenOption)]);
                return back()->with('success','Setting Updated Successfully');
            } else {
                $existScreenOption = [];
                if ($arrSecondKey != '') {
                    $existScreenOption[$arrFirstKey][$arrSecondKey] = $screenOptionArr;
                } else {
                    $existScreenOption[$arrFirstKey] = $screenOptionArr;
                }
                $create_info = Setting::create(['user_id' => 1, 'setting_attribute' => \Opis\Closure\serialize($existScreenOption)]);
                return back()->with('success','Setting Saved Successfully');
            }
        }catch(\Exception $exception){
            return back()->with('error','Something Went Wrong');
        }
    }


    public function shippingFee(){
        $shipping_fee = ShippingSetting::first();
        return view('setting.shipping_setting', compact('shipping_fee'));
    }

    public function storeShippingFee(Request $request){
        $shipping_fee = ShippingSetting::first();
        if(empty($shipping_fee)){
            ShippingSetting::insert([
                'aggregate_value' => $request->aggregate_value,
                'shipping_fee' => $request->shipping_fee
            ]);
            return response()->json(['data' => 'Shipping fee added successfully']);
        }else{
            ShippingSetting::where('id', $shipping_fee->id)->update([
                'aggregate_value' => $request->aggregate_value,
                'shipping_fee' => $request->shipping_fee
            ]);
            return response()->json(['data' => 'Shipping fee updated successfully']);
        }
    }


}
