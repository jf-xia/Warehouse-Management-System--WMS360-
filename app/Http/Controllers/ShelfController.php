<?php

namespace App\Http\Controllers;

use App\ReshelvedProduct;
use App\Shelf;
use App\ProductVariation;
use App\ShelfedProduct;
use App\ShelfQuantityChangeLog;
use App\User;
use App\Setting;
use App\Vendor;
use App\ProductDraft;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Crypt;
use App\ShelfQuantityChangeReason;
use Symfony\Component\Process\Process;
use App\Traits\CommonFunction;


class ShelfController extends Controller
{
    use CommonFunction;
    public function __construct()
    {
        //set_time_limit(300);
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    /*
    * Function : index
    * Route : shelf
    * Method Type : GET
    * Parametes : null
    * Creator : Unknown
    * Modifier : Solaiman
    * Description : This function is used for displaying Shelf list and pagination
    * Created Date: unknown
    * Modified Date : 7-12-2020
    * Modified Content : Screen option Pagination
    * Modified Content : Screen option Pagination
    */

    public function index(Request $request)
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('shelf', 'shelf_list');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting
        $search_column =$request->get('column_name');
        $search_value = $request->get('search_value');
        $search_opt_value = $request->get('opt_out');
        $search_filter_option = $request->get('filter_option');

        $all_shelf = Shelf::with(['user','total_product']);
        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->shelfSearchCondition($all_shelf, $request);
            $allCondition = $this->shelfConditionParams($request, $allCondition);
        }
        $all_shelf = $all_shelf->orderBy('id','DESC')->paginate($pagination);
        $shelfs = Shelf::get()->all();
        $total_shelf = Shelf::count();
        $users = User::all();
        $all_decode_shelf = json_decode(json_encode($all_shelf));
        $content = view('shelf.shelf_list',compact('all_shelf','all_decode_shelf','total_shelf','shelfs','users', 'setting', 'page_title', 'pagination','allCondition'));
        return view('master',compact('content'));
    }

    public function deleteShelf(Request $request){
        $shelf_not_empty = [];
        if (isset($request->shelfs)){
            foreach ($request->shelfs as $shelf){
                $count = ShelfedProduct::where('shelf_id',$shelf)->count();

                if ($count == 0){
                    ShelfedProduct::where('shelf_id',$shelf)->forceDelete();
                    $shelf = Shelf::find($shelf)->forceDelete();

                }
                $shelf_not_empty[] = $shelf;
            }
        }


        return response()->json(['shelf' => $shelf_not_empty]);
    }

    public function availableAndShelfEqual(){
        $product_variations = ProductVariation::get()->all();

        foreach ($product_variations as $product_variation){
//            echo "<pre>";
//            print_r($product_variation->actual_quantity);
//            exit();
           $result = DB::table('product_shelfs')->insert(['shelf_id' => '1','variation_id'=> $product_variation->id,'quantity' => $product_variation->actual_quantity]);
//                        echo "<pre>";
//            print_r($result);
//            exit();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $content = view('shelf.add_shelf');
        return view('master',compact('content'));
    }

    public function migration(Request $request){


        $form = Shelf::with(['user','total_product'])->find($request->from_id);
        $to = Shelf::with(['user','total_product'])->find($request->to_id);
//        return $to;
        $counter = 0;
        if ($form->id != $to->id){
            foreach ($form->total_product as $shelf_product){
                $temp = 0 ;
                foreach ($to->total_product as $value){
                    if ($shelf_product->pivot->variation_id == $value->pivot->variation_id){
                        $update_quantity = $shelf_product->pivot->quantity + $value->pivot->quantity;
//                    echo $update_quantity.'else';
                        $to_result = ShelfedProduct::where('shelf_id',$to->id)->where('variation_id' ,$value->id)->update(['quantity' => $update_quantity]);
                        $from_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['quantity' => 0]);

                        $temp = 1;

                    }
                }

                if ($temp == 0){
//                    echo $update_quantity.'if';
                    ShelfedProduct::create(['shelf_id'=>$to->id,'variation_id' => $shelf_product->pivot->variation_id,'quantity' => $shelf_product->pivot->quantity]);
                    $from_result = ShelfedProduct::where('shelf_id',$form->id)->where('variation_id' ,$shelf_product->id)->update(['quantity' => 0]);

                }

            }

        }else{
            return back()->with('shelf_delete_success_msg','Shelf Must Be Different');
        }


        return back()->with('shelf_add_success_msg','Shelf Migrated Successfully');
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
            'shelf_name' => 'required|unique:shelfs|max:255',
        ]);

        $request['user_id'] = Auth::user()->id;
        $add_shelf = Shelf::create($request->all());
        return back()->with('shelf_add_success_msg','Shelf added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $single_shelf_product = Shelf::with(['total_product' => function($query){
            $query->with('shelf_quantity');
        }])->where('id',Crypt::decrypt($id))->first();
//        echo "<pre>";
//        print_r(json_decode(json_encode($single_shelf_product->total_product)));
//        exit();
        $content = view('shelf.single_shelf_product_list',compact('single_shelf_product'));
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
        $single_shelf = Shelf::find($id);
        $content = view('shelf.edit_shelf',compact('single_shelf'));
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
            'shelf_name' => 'required|unique:shelfs,shelf_name,'.$id.'|max:255',
        ]);
        $update_shelf = Shelf::find($id);
        $request['user_id'] = Auth::user()->id;
        $shelf = $update_shelf->update($request->all());
        return back()->with('shelf_updated_success_msg','Shelf updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shelf::destroy($id);
        return back()->with('shelf_delete_success_msg','Shelf deleted successfully');
    }

    public function reshelved_product(Request $request){

        DB::beginTransaction();
        try {
            $insert_data = ReshelvedProduct::create($request->all());
            $update = DB::table('product_shelfs')->where('shelf_id',$request->shelf_id)->where('variation_id',$request->variation_id)->decrement('quantity',$request->quantity);
            DB::commit();
            return $insert_data;
        } catch (\Exception $e) {
            DB::rollback();
            return 'something went wrong';
        }
    }


    /*
   * Function : reshelvedProductList
   * Route Type : reshelved-product-list
   * Method Type : GET
   * Parameters : null
   * Creator :
   * Modifier : solaiman
   * Description : This function is used for Reshelved product list, Column Search and pagination setting
   * Modified Date : 30-11-2020
   * Modified Content : Pagination setting
   */


    public function reshelvedProductList(Request $request){

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('shelf', 'reshelved_product');
        $setting = $settingData['setting'];
        $page_title = 'Reshelved Product | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting
        $all_reshelved_product_list = ReshelvedProduct::with(['user_info', 'variation_info', 'shelf_info']);
        $isSearch = $request->get('is_search') ? true : false;
        $allCondition = [];
        if($isSearch){
            $this->reshelfSearchCondition($all_reshelved_product_list, $request);
            $allCondition = $this->reshelfConditionParams($request, $allCondition);
        }

        $all_reshelved_product_list = $all_reshelved_product_list->orderBy('id','DESC')->paginate($pagination);
        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $all_reshelved_product_list_Ids = [];
        if((is_countable($all_reshelved_product_list) && count($all_reshelved_product_list)) > 0){
            foreach ($all_reshelved_product_list as $result){
                $all_reshelved_product_list_Ids[] = $result->id;
            }
        }
        $all_reshelved_product_list = $all_reshelved_product_list->appends($request->query());
        $total_product = ReshelvedProduct::count();
        $all_decode_reshelved_product = json_decode(json_encode($all_reshelved_product_list));
        return view('shelf.reshelved_product_list',compact('all_reshelved_product_list','all_decode_reshelved_product','total_product','setting','page_title','pagination','allCondition'));

    }
    public function printShelfBarcode($id){
        $shelf_info = Shelf::find($id);
        $shelf_id = $id;
        $shelf_name = $shelf_info->shelf_name;


        $data = "

        <style>


/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;

  height: 90px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>
        <div class='row'>
  <div class='column' style='margin-left:-35px;'>".\SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($id)."

  </div>
  <div class='column' style=''>
  <span style='font-size: 30px; margin-left:20px;margin-right:-35px;display: inline-block;'><b>$shelf_name</b></span><br>
  <span style='font-size: 30px; margin-left:30px;margin-right:-35px;display: inline-block;text-align: center;'><b>$shelf_id</b></span>
  </div>
</div>";

        return view('shelf.barcode',compact('data'));
    }

//    public function printShelfBarcode($id){
//        $shelf_info = Shelf::find($id);
//        $shelf_id = $id;
//        $shelf_name = $shelf_info->shelf_name;
//
//
//        $data = "<p class='inline'><span style='font-size: 10px;'><b>Shelf Name: $shelf_name</b></span>".\QrCode::size(100)
//
//                ->generate($id)."<span style='font-size: 10px;'><b>Shelf ID: ".$shelf_id." </b><span></p>&nbsp&nbsp&nbsp&nbsp";
//
//        return view('shelf.barcode',compact('data'));
//    }

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
            $html .= "<td><div class=\"b128\" style=\"border-left-width:{$w[$x]};width:{$w[$x+1]}; \"></div></td>";
//        return "$html<tr><td colspan=".strlen($w)." align=left><font family=arial size=2>$text</td></tr></table>";
        return "$html<tr><td colspan=".strlen($w)." align=left><font family=arial size=2></td></tr></table>";
    }

    public function shelfQuantityUpdate(Request $request){
        $shelf_info = ShelfedProduct::find($request->product_shelf_id);
        $result = ShelfedProduct::find($request->product_shelf_id)->update(['quantity' => $request->quantity]);
        if($result){
            $add_result = ShelfQuantityChangeLog::create([
                'user_id' => Auth::user()->id,
                'shelf_id' => $shelf_info->shelf_id,
                'variation_id' => $shelf_info->variation_id,
                'previous_quantity' => $shelf_info->quantity,
                'update_quantity' => $request->quantity,
                'reason' => $request->reason ?? null
            ]);
        }
        return response()->json(['data' => $result,'oldShelfInfo' => $shelf_info]);
    }


      /*
      * Function : changeShelfQuantityLog
      * Route Type : change-shelf-quantity-log
      * Method Type : GET
      * Parameters : null
      * Creator : unknown
      * Modifier : solaiman
      * Description : This function is used for Shelf Quantity Change Log list, Column Search and pagination setting
      * Modified Date : 30-11-2020
      * Modified Content : Pagination setting
      */

    public function changeShelfQuantityLog(Request $request){

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('shelf', 'shelf_quantity_change_log');
        $setting = $settingData['setting'];
        $page_title = 'Change Shelf Quantity Log | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


        $search_column = $request->get('column_name');
        $search_value = $request->get('search_value');
        $search_opt_value = $request->get('opt_out');
        $search_filter_option = $request->get('filter_option');
        if($search_column != null){
            if($search_column == 'previous_quantity'){
                $raw_condition = ($search_opt_value != 1) ? '' : '!';
                $change_log_previous_quantity = ShelfQuantityChangeLog::select('shelf_quantity_change_logs.id')
                    ->havingRaw("sum(shelf_quantity_change_logs.previous_quantity)".$raw_condition.$search_filter_option.$search_value)
                    ->groupBy('shelf_quantity_change_logs.id')
                    ->take(50)
                    ->get();

                $ids = [];
                if(count($change_log_previous_quantity) > 0) {
                    foreach ($change_log_previous_quantity as $previous_quantity) {
                        $ids[] = $previous_quantity->id;
                    }
                }
                $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                    $query->with('product_draft:id,name');
                }])
                    ->whereIn('id',$ids)
                    ->paginate($pagination);

            }elseif($search_column == 'update_quantity'){
                    $raw_condition = ($search_opt_value != 1) ? '' : '!';
                    $change_log_update_quantity = ShelfQuantityChangeLog::select('shelf_quantity_change_logs.id')
                        ->havingRaw("sum(shelf_quantity_change_logs.update_quantity)".$raw_condition.$search_filter_option.$search_value)
                        ->groupBy('shelf_quantity_change_logs.id')
                        ->take(50)
                        ->get();

                    $ids = [];
                    if(count($change_log_update_quantity) > 0){
                        foreach ($change_log_update_quantity as $update_quantity)
                            $ids[] = $update_quantity->id;
                    }

                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->whereIn('id',$ids)
                        ->paginate($pagination);

            }elseif($search_column == 'shelf_id'){
                $shelfInfo = Shelf::where('shelf_name',$search_value)->get();
                $shelfIds = [];
                if(count($shelfInfo) > 0){
                    foreach ($shelfInfo as $info){
                        $shelfIds[] = $info->id;
                    }
                }
                $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                    $query->with('product_draft:id,name');
                }])
                    ->where(function($query) use ($shelfIds,$request){
                        if($request->get('opt_out') == 1){
                            $query->whereNotIn('shelf_id',$shelfIds);
                        }else{
                            $query->whereIn('shelf_id',$shelfIds);
                        }
                    })
                    ->paginate($pagination);

            }elseif($search_column == 'variation_id'){
                    $productVariation = ProductVariation::select('product_variation.id')
                        ->join('product_drafts','product_variation.product_draft_id','=','product_drafts.id')
                        ->where([['product_drafts.deleted_at',NULL],['product_variation.deleted_at',NULL]])
                        ->where('product_drafts.name','LIKE','%'.$search_value.'%')
                        ->groupBy('product_variation.id')
                        ->get();

                    $productVariationIds = [];
                    if (is_countable($productVariation) && count($productVariation) > 0) {
                        foreach ($productVariation as $variation) {
                            $productVariationIds[] = $variation->id;
                        }
                    }
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name', 'shelf_info:id,shelf_name', 'variation_info' => function ($query) {
                        $query->with('product_draft:id,name');
                    }])
                        ->where(function ($query) use ($productVariationIds, $request) {
                            if ($request->get('opt_out') == 1) {
                                $query->whereNotIn('variation_id', $productVariationIds);
                            } else {
                                $query->whereIn('variation_id', $productVariationIds);
                            }
                        })
                        ->paginate($pagination);

            }elseif($search_column == 'updated_at'){
                $search_value = date('Y-m-d',strtotime($search_value));
                if($search_opt_value != 1){
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                     $query->with('product_draft:id,name');
                 }])
                        ->whereRaw('DATE(updated_at) = ?', $search_value)
                        ->paginate($pagination);
                }else{
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->whereRaw('DATE(updated_at) != ?', $search_value)
                        ->paginate($pagination);
                }

            }elseif($search_column == 'user_id'){
                if($search_opt_value != 1) {
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->where($search_column, $search_value)
                        ->paginate($pagination);
                }else{
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->where($search_column,'!=',$search_value)
                        ->paginate($pagination);
                }
            }
            else{
                if($search_opt_value != 1) {
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->where($search_column, 'LIKE', '%' . $search_value . '%')
                        ->paginate($pagination);
                }else{
                    $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                        $query->with('product_draft:id,name');
                    }])
                        ->where($search_column,'NOT LIKE','%'.$search_value.'%')
                        ->paginate($pagination);
                }

            }

            // If user submit with empty data then this message will display table's upstairs
            if($search_value == ''){
                return back()->with('no_data_found', 'Your input field is empty!! Please submit valid data!!');
            }


        }else{
            $query_result = ShelfQuantityChangeLog::with(['user_info:id,name','shelf_info:id,shelf_name','variation_info' => function ($query){
                $query->with('product_draft:id,name');
            }])
                ->orderByDesc('id')
                ->paginate($pagination);
        }

        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $changeShelfQuantityLogIds = [];
        if((is_countable($query_result) && count($query_result)) > 0){
            foreach ($query_result as $result){
                $changeShelfQuantityLogIds[] = $result->id;
            }
        }


        $total_product = ShelfQuantityChangeLog::count();
        $all_decode_ShelfQuantityChangeLog_product = json_decode(json_encode($query_result));
//        echo '<pre>';
//        print_r($all_decode_ShelfQuantityChangeLog_product);
//        exit();
        return view('shelf.shelf_quantity_change_log',compact('query_result', 'total_product', 'all_decode_ShelfQuantityChangeLog_product', 'setting', 'page_title', 'pagination'));
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




    public function deleteChangeShelfQuantityLog($id){
        $result = ShelfQuantityChangeLog::destroy($id);
        return back()->with('success','Log deleted successfully.');
    }

    public function shelfSearch(Request $request){

        $search_shelf_info = Shelf::with(['user','total_product'])
            ->where('id','LIKE','%'.$request->search_value.'%')
            ->orWhere('shelf_name','LIKE','%'.$request->search_value.'%')
            ->take(50)->get();
        if(count($search_shelf_info)) {
            $shelfs = Shelf::get()->all();
            $content = view('shelf.search_shelf_info', compact('search_shelf_info','shelfs'))->render();
            return response()->json(['data' => $content, 'total_row' => count($search_shelf_info)]);
        }else{
            return response()->json(['data' => 'error', 'total_row' => 0]);
        }
    }



        /*
      * Function : reshelvedProductSearch
      * Route Type : reshelved-product-list
      * Method Type : POST
      * Parameters : null
      * Creator : Solaiman
      * Modifier :
      * Description : This function is used for Reshelved product search
      * Modified Date : 09-01-2021
      * Modified Content : Reshelved product search
      */

    public function reshelvedProductSearch(Request $request) {
        $search_reshelved_product = ReshelvedProduct::with(['shelf_info:id,shelf_name','variation_info:id,sku','user_info:id,name'])
                ->where('shelf_id','LIKE','%'.Shelf::where('shelf_name',$request->search_value)->first()->id.'%')
                ->take(50)
                ->get();

                if(count($search_reshelved_product)){
                        $reshelved = ReshelvedProduct::get()->all();
                        $content = view('shelf.search_reshelved_product_list', compact('search_reshelved_product', 'reshelved'))->render();
                        return response()->json([
                         'data' => $content,
                         'total_row' => count($search_reshelved_product)
                        ]);
                }else{
                    return response()->json([
                        'data' => 'error',
                        'total_row' => 0
                    ]);
                }

             }


    /*
    * Function : shelfQtyChangeLogProductSearch
    * Route Type : change-shelf-quantity-log
    * Method Type : POST
    * Parameters : null
    * Creator : Solaiman
    * Modifier :
    * Description : This function is used for Shelf quantity change Log product search
    * Modified Date : 09-01-2021
    * Modified Content : Shelf quantity change Log product search
    */

    public function shelfQtyChangeLogProductSearch(Request $request){

        $search_shelf_quantity_change_log = ShelfQuantityChangeLog::with(['shelf_info:id,shelf_name','user_info:id,name'])
            ->where('shelf_id','LIKE','%'.Shelf::where('shelf_name',$request->search_value)->first()->id.'%')
            ->take(50)
            ->get();

            if(count($search_shelf_quantity_change_log)){
                $change_log_result = ShelfQuantityChangeLog::get()->all();
                $content = view('shelf.search_shelf_quantity_change_log', compact('search_shelf_quantity_change_log', 'change_log_result'))->render();
                return response()->json([
                    'data' => $content,
                    'total_row' => count($search_shelf_quantity_change_log)
                ]);
            }else{
                return response()->json([
                    'data' => 'error',
                    'total_row' => 0
                ]);
            }

        }

        public function shelfQuantityChangeReason(Request $request){
            try{
                $insertInfo = ShelfQuantityChangeReason::create($request->all());
                return response()->json(['type' => 'success','msg' => 'Reason added successfully','data' => $insertInfo]);
            }catch(\Exception $exception){
                return response()->json(['type' => 'error','msg' => 'Something went wrong','data' => $exception->getMessage()]);
            }
        }


}
