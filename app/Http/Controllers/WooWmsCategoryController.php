<?php

namespace App\Http\Controllers;

use App\Gender;
use App\GenderWmsCategory;
use App\ProductDraft;
use App\ProductVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WooWmsCategory;
use Auth;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\StaticAnalysis\HappyPath\AssertIsArray\consume;

class WooWmsCategoryController extends Controller
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
        $genders = Gender::all();
        $all_woowms_categories = WooWmsCategory::orderByDesc('id')->get();
//            echo "<pre>";
//            print_r(json_decode($all_woowms_categories));
//            exit();
        $content = view('woowms_category.category_list',compact('all_woowms_categories', 'genders'));
        return view('master',compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genders = Gender::all();
        $content = view('woowms_category.create_category',compact('genders'));
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
        $validation = $request->validate([
            'category_name' => 'required',
        ]);
        try {
            $result = WooWmsCategory::create([
                'category_name' => $request->category_name,
                'user_id' => Auth::id()
            ]);
            $category_info = WooWmsCategory::find($result->id);
            foreach ($request->gender_id as $gender) {
                $category_info->genders()->attach($gender);
            }
            return redirect('woowms-category')->with('success','Category added successfully');
        }catch (\Exception $exception){
            return redirect('woowms-category/create')->with('error','Something went wrong');
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
        try {
            $genders = Gender::all();
            $woowms_single_category = WooWmsCategory::with('genders')->find($id);
//            echo "<pre>";
//            print_r(json_decode($genders));
//            exit();
            $content = view('woowms_category.edit_category',compact('woowms_single_category','genders'));
            return view('master',compact('content'));
        }catch (\Exception $exception){
            return redirect('woowms-category')->with('error','Something went wrong');
        }

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
        $validation = $request->validate([
            'category_name' => 'required',
        ]);
        try {
//            $category_result = WooWmsCategory::find($id);
//            $category_result->update([
//                'category_name' => $request->category_name,
//                'user_id' => Auth::id()
//            ]);
            $result = WooWmsCategory::where('id',$id)->update([
                'category_name' => $request->category_name,
            ]);
            // $category_info = WooWmsCategory::find($id);
            // foreach ($request->gender_id as $gender) {
            //     $ids[] = $gender;
            // }
            // $category_info->genders()->sync($ids);
            return redirect('woowms-category')->with('wms_category_update_success_msg','Category updated successfully');
        }catch (\Exception $exception){
            return redirect('woowms-category')->with('error','Something went wrong');
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

            $cat_info = WooWmsCategory::find($id);
            WooWmsCategory::destroy($id);
            $cat_info->genders()->detach();
            $catalogue_draft_ids = ProductDraft::select('id')->where('woowms_category',$id)->get();
            $master_ids = [];
            if(count($catalogue_draft_ids) > 0){
                foreach ($catalogue_draft_ids as $ids){
                    $master_ids[] = $ids->id;
                }
                $catalogue_delete_info = ProductDraft::whereIn('id',$master_ids)->delete();
                $product_variation_ids = ProductVariation::select('id')->whereIn('product_draft_id',$master_ids)->get();
                $variation_master_ids = [];
                if(count($product_variation_ids) > 0){
                    foreach ($product_variation_ids as $ids){
                        $variation_master_ids[] = $ids->id;
                    }
                    $variation_delete_info = ProductVariation::whereIn('id',$variation_master_ids)->delete();
                }
            }

            return redirect('woowms-category')->with('wms_category_delete_success_msg','Category deleted successfully');
        }catch (\Exception $exception){
            return redirect('woowms-category')->with('error','Something went wrong');
        }

    }
}
