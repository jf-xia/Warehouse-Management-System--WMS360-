<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\WoocommerceAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Illuminate\Support\Facades\DB;
use App\woocommerce\WoocommerceAttribute;
use Illuminate\Support\Facades\Session;




class AttributeController extends Controller
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
        $all_attribute = Attribute::get();
//        $filename = "tweets.csv";
//        $handle = fopen($filename, 'w+');
//        fputcsv($handle, array('id', 'attribute_name'));
//
//        foreach($all_attribute as $row) {
//            fputcsv($handle, array($row['id'], $row['attribute_name']));
//        }
//
//        fclose($handle);
//
//        $headers = array(
//            'Content-Type' => 'text/csv',
//        );
//
//        return \response()->download($filename, 'tweets.csv', $headers);
        $content = view('attribute.attribute_list',compact('all_attribute'));
        return view('master',compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = view('attribute.add_attribute');
        return view('master',compact('content'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
    * Function : store
    * Route : attribute
    * Method Type : POST
    * Parametes : null
    * Creator : Kazol
    * Modifier : Kazol
    * Description : This function is used for storing attribute name
    * Created Date: unknown
    * Modified Date : 14-12-2020
    * Modified Content : save attribute depending on user woocommerce use
    */

    public function store(Request $request)
    {
        $validation = $request->validate([
            'attribute_name' => 'required|unique:attributes,attribute_name,NULL,id,deleted_at,NULL|max:255',
            'use_variation' => 'required'
        ]);

            try {

                // $lastRow = DB::table('attributes')->orderBy('id','desc')->first();
                // if($lastRow){
                //     $request['id'] = $lastRow->id + 1;
                // }else{
                //     $request['id'] = 1;
                // }

                foreach ($request->attribute_name as $attribute_name) {
                    //dd($attribute_name);
                    $lastRow = DB::table('attributes')->orderBy('id','desc')->first();
                    if($lastRow){
                        $newId = $lastRow->id + 1;
                    }else{
                        $newId = 1;
                    }
                    $add_attribute = Attribute::create([
                        'id' => $newId,
                        'attribute_name' => $attribute_name,
                        'use_variation' => $request->use_variation,
                    ]);

                    // $add_attribute = Attribute::create($request->all());

                    $masterAttributeInfo = Attribute::where('attribute_name',$add_attribute->attribute_name)->first();

                    $data = [
                        'name' => $add_attribute->attribute_name,
    //                    'slug' => 'pa_'.$request->attribute_name,
                        'type' => 'select',
                        'order_by' => 'menu_order',
                        'has_archives' => true
                    ];
                    // dd($data);
                    if(Session::get('woocommerce') == 1){
                        $woocommerceStatus = WoocommerceAccount::where('status',1)->first();
                        if($woocommerceStatus){
                            $woocommerceExistCheck = WoocommerceAttribute::where('attribute_name',$add_attribute->attribute_name)->first();
                            if(!$woocommerceExistCheck){
                                try{
                                    $info = Woocommerce::post('products/attributes', $data);
                                }catch (HttpClientException $exception){
                                    return back()->with('error', $exception->getMessage());
                                }
                                //$request['id'] = $info['id'];
                                $add_woocommerce_attribute = WoocommerceAttribute::create([
                                    'id' => $info['id'],
                                    'master_attribute_id' => $masterAttributeInfo->id,
                                    'attribute_name' => $add_attribute->attribute_name,
                                    'use_variation' => $request->use_variation,
                                ]);
                            }

                        }else{
                                // //                    $lastRow = Attribute::orderBy('id','desc')->first();
                                //                     $lastRow = DB::table('attributes')->orderBy('id','desc')->first();
                                //                     if($lastRow){
                                //                         $request['id'] = $lastRow->id + 1;
                                //                     }else{
                                //                         $request['id'] = 1;
                                //                     }
                        }
                    }
                    //$add_attribute = Attribute::create($request->all());
                    $latestInsertedAttribute = Attribute::where('attribute_name', $add_attribute->attribute_name)->latest()->first();

                    $attribute[] = [$latestInsertedAttribute];

                }


                if(isset($request->type)){
                    // return response()->json(['type' => 'success', 'msg' => 'Successfully added', 'data' => $latestInsertedAttribute,'name' => 'attribute', 'request-all' => $add_attribute]);
                    return response()->json(['type' => 'success', 'msg' => 'Successfully added', 'data' => $attribute,'name' => 'attribute', 'request-all' => $data]);
                }else{
                    return back()->with('attribute_add_success_msg','Attribute added successfully');
                }

            }catch (\Exception $exception){
                if(isset($request->type)){
                    return response()->json(['type' => 'error', 'msg' => 'Something went wrong']);
                }else{
                    return redirect('exception')->with('exception',$exception->getMessage());
                }

            }

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
        $single_attribute = Attribute::find($id);
        $content = view('attribute.edit_attribute',compact('single_attribute'));
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
        $validator = $request->validate([
            'attribute_name' => 'required|max:255|unique:attributes,attribute_name,'.$id,
        ]);
        try {
            $update_attribute = Attribute::find($id);
            $attribute = $update_attribute->update($request->all());
            if(Session::get('woocommerce') == 1){
            $woocommerceInfo = WoocommerceAccount::where('status', 1)->first();
            if($woocommerceInfo && $woocommerceInfo->status == 1){
                $woocommerceExistCheck = WoocommerceAttribute::where('master_attribute_id',$id)->first();
                if($woocommerceExistCheck){
                    $data = [
                        'name' => $request->attribute_name,
                    ];
                    try{
                        $info = Woocommerce::put('products/attributes/' . $woocommerceExistCheck->id, $data);
                        $woocommerceUpdate = $woocommerceExistCheck->update([
                            'attribute_name' => $request->attribute_name
                        ]);
                    }catch (HttpClientException $exception){
                        echo $exception->getMessage();
                        return back()->with('error', $exception->getMessage());
                    }
                }
            }
        }


            return back()->with('attribute_edit_success_msg','Attribute updated successfully');
        }catch (\Exception $exception){
            echo $exception->getMessage();
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
        try {
            $info = Woocommerce::delete('products/attributes/' . $id, ['force' => true]);
            Attribute::destroy($id);
            return back()->with('attribute_delete_success_msg','Attribute deleted successfully.');
        }catch (HttpClientException $exception){
            echo $exception->getMessage();
        }
    }

    public function attributeAsVariationModify($attributeId,$value){
        return Attribute::where('id',$attributeId)->update(['use_variation' => ($value == 1) ? 0 : 1]);
    }

}
