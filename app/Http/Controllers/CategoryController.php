<?php

namespace App\Http\Controllers;

use App\Category;
use App\ProductDraft;
use App\Setting;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\WooWmsCategory;

class CategoryController extends Controller
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
      * Route Type : category
      * Method Type : GET
      * Parameters : Null
      * Creator : Unknown
      * Modifier : Solaiman
      * Description : This function is used for Category, Category List and pagination setting
      * Modified Date : 12/13/2020
      * Modified Content : Pagination setting
      */

    public function index()
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('woocommerce', 'woocommerce_category_list');
//        echo '<pre>';
//        print_r($settingData);
//        exit();
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


        $all_category = Category::paginate($pagination);
        $all_decode_category = json_decode(json_encode($all_category));
        $total_category = Category::count();
        $content = view('category.category_list',compact('all_category','total_category','all_decode_category','setting', 'page_title', 'pagination'));
        return view('master',compact('content'));
    }




    /*
     * Function : paginationSetting
     * Route Type : null
     * Parameters : null
     * Creator : Solaiman
     * Description : This function is used for pagination setting
     * Created Date : 12/13/2020
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
                            $data['pagination'] = $data['setting'][$firstKey][$secondKey]['pagination'];
                        } else {
                            $data['pagination'] = 50;
                        }
                    }else{
                        $data['pagination'] = $data['setting'][$firstKey]['pagination'];
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






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = view('category.add_category');
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
//        $validate = $request->validate([
//            'category_name' => 'required|unique:categories|max:255',
//        ]);

        try{
            $data = [
                'name' => $request->category_name
            ];
            try{
                $info = Woocommerce::post('products/categories', $data);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            $request['id'] = $info['id'];
            $add_category = Category::create($request->all());
            return back()->with('category_add_success_msg','Category added successfully');
        }catch (\Exception $exception){
            try{
                $info = Woocommerce::delete('products/categories/'.$info['id'], ['force' => true]);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
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
        $category_info = Category::find($id);
        $category_name = $category_info->category_name;
        $all_category_product = ProductDraft::with(['ProductVariations','user_info:id,name'])->where('category_id',$id)->get();
        $content = view('category.category_product_list',compact('all_category_product','category_name'));
        return view('master',compact('content'));
//        echo "<pre>";
//        print_r(json_decode(json_encode($all_category_product)));
//        exit();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $single_category = Category::find($id);
        $content = view('category.edit_category',compact('single_category'));
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
            'category_name' => 'required|max:255|unique:categories,category_name,'.$id,
        ]);
        try {
            $data = [
                'name' => $request->category_name,
            ];
            try{
                $info = Woocommerce::put('products/categories/' . $id, $data);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            $update_category = Category::find($id);
            $category = $update_category->update($request->all());
            return back()->with('category_edit_success_msg','Category updated successfully');
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
            try{
                $info = Woocommerce::delete('products/categories/' . $id, ['force' => true]);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            Category::destroy($id);
            return back()->with('category_delete_success_msg','Category deleted successfully.');
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function getWmsCategory(){
        $categories = WooWmsCategory::all();
        return response()->json(['type' => 'success','categories' => $categories]);
    }
}
