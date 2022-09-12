<?php

namespace App\Http\Controllers;

use App\ProductDraft;
use App\ProductVariation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Crypt;

class VariationController extends Controller
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
        $content = view('product_variation.create_product_variation');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $content = view('product_variation.variation_receiving_page');
        return view('master',compact('content'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $content = view('product_variation.variation_edit');
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
        //
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

    public function variationDetails($id=null){
        if($id != null){
            $id = Crypt::decrypt($id);
        }else{
            $id = null;
        }
        $single_variation_info = ProductVariation::with(['product_draft'])->where('id',$id)->find($id);
        $attribute_info = ProductDraft::with(['product_draft_attribute'])->where('id',$single_variation_info->product_draft_id)->get();
//        echo "<pre>";
//        print_r(json_decode(json_encode($attribute_info)));
//        exit();
        $content = view('product_variation.variation_details',compact('single_variation_info','attribute_info'));
        return view('master',compact('content'));
    }
}
