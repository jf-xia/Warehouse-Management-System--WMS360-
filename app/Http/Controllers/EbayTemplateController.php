<?php

namespace App\Http\Controllers;

use App\EbayMasterProduct;
use App\EbayProfile;
use App\EbayTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EbayTemplateController extends Controller
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
        $results = EbayTemplate::get()->all();

        return view('ebay.template.index',compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ebay.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $fileName = $request->file->getClientOriginalName();
//        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//        $txt = "John Doe\n";
//        fwrite($myfile, $txt);
//        $txt = "Jane Doe\n";
//        fwrite($myfile, $txt);
//        fclose($myfile);
        $fileName = time().'.blade.php';
        Storage::disk('template')->put($fileName, $request->template_html);
        //$request->myfile->move('', $myfile);
        $result = EbayTemplate::create(['template_name'=>$request->template_name,'template_html' => $request->template_html,'template_file_name'=>$fileName]);

        return redirect('ebay-template')->with('success','successfully created');
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
        $result = EbayTemplate::find($id);
        return view('ebay.template.edit',compact('result'));
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
        $tracker_array =array();
        $result = EbayTemplate::find($id);
        if ($request->revise_flag){
            $profile_results = EbayProfile::select('id')->where('template_id',$id)->get();

            $tracker_array["condition_id"] = 0;
            $tracker_array["condition_description"] = 0;
            $tracker_array["category_id"] = 0;
            $tracker_array["store_id"] = 0;
            $tracker_array["store_name"] = 0;
            $tracker_array["store2_id"] = 0;
            $tracker_array["store2_name"] = 0;
            $tracker_array["duration"] = 0;
            $tracker_array["location"] = 0;
            $tracker_array["country"] = 0;
            $tracker_array["post_code"] = 0;
            $tracker_array["shipping_id"] = 0;
            $tracker_array["return_id"] = 0;
            $tracker_array["payment_id"] = 0;
            $tracker_array["currency"] = 0;
            $tracker_array["paypal"] = 0;
            $tracker_array["template_id"] = 1;
            $tracker_array["item_specifics"] = 0;
            $data  = \Opis\Closure\serialize($tracker_array);
            foreach ($profile_results as $profile_result){
                EbayMasterProduct::where('profile_id',$profile_result->id)->update(['profile_status'=>$data]);
            }
        }

        $fileName = $result->template_file_name;
        //$fileName = '1599118660'.'.blade.php';
        Storage::disk('template')->put($fileName, $request->template_html);
        //$request->myfile->move('', $myfile);

        $result->update(['template_name'=>$request->template_name,'template_html' => $request->template_html]);

        return redirect('ebay-template')->with('success','successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = EbayTemplate::destroy($id);

        return redirect('ebay-template')->with('success','deleted successfully');
    }
}
