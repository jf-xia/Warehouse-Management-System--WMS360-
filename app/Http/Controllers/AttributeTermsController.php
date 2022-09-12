<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeTerm;
use App\AttributeTermProductDraft;
use App\ProductDraft;
use App\ProductVariation;
use App\Setting;
use App\User;
use App\WoocommerceAccount;
use auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use App\woocommerce\WoocommerceAttribute;
use App\woocommerce\WoocommerceAttributeTerm;
use Illuminate\Support\Facades\Session;

class AttributeTermsController extends Controller
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
   * Route Type : attribute-terms
   * Method Type : GET
   * Parameters : null
   * Creator : Unknown
   * Modifier : Solaiman
   * Description : This function is used for Attribute terms list and pagination setting
   * Modified Date : 19-12-2020, 3-3-2021
   * Modified Content : Pagination setting
   */

    public function index()
    {
        //Start page title and pagination setting
        $settingData = $this->paginationSetting('catalogue', 'attribute_terms_list');
        $setting = $settingData['setting'];
        $page_title = '';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting

        $all_attribute = Attribute::all();
        $attribute_terms = AttributeTerm::with(['attribute'])->paginate($pagination);
        $all_attribute_terms = json_decode(json_encode($attribute_terms));
//        echo '<pre>';
//        print_r($pagination);
//        exit();
        $total_attribute_terms = AttributeTerm::count();
        $content = view('attribute-terms.attribute_terms_list',compact('attribute_terms','all_attribute_terms','total_attribute_terms', 'all_attribute','setting','page_title', 'pagination'));
        return view('master',compact('content'));
    }




    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Creator : solaiman
    * Description : This function is used for pagination setting
    * Created Date : 7-12-2020
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
        $all_attribute = Attribute::all();
        $content = view('attribute-terms.add_attribute_terms',compact('all_attribute'));
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
        $validator = $request->validate([
            'attribute_id' => 'required',
            // 'terms_name' => ['required',Rule::unique('attribute_terms')->where(function ($query) use($request) {
            //     return $query->where('attribute_id', $request->attribute_id)
            //     ->where('terms_name', $request->terms_name);
            // }),]
        ]);
        try {

            $woocommerceInsertableTerms = [];
            // $wmsInsertableTerms = [];

            // $lastRow = DB::table('attribute_terms')->orderBy('id','desc')->first();
            // $i = 1;
            // if(isset($request->type)){
            //     $attribute_terms[] = $request->terms_name;
            // }else{
            //     $attribute_terms = $request->terms_name;
            // }


            foreach($request->terms_name as $terms){
                $lastRow = DB::table('attribute_terms')->orderBy('id','desc')->first();
                if($lastRow){
                    $newId = $lastRow->id + 1;
                }else{
                    $newId = 1;
                }
                $existTerms = AttributeTerm::where([['attribute_id',$request->attribute_id],['terms_name',$terms]])->first();
                if(!$existTerms){
                    $woocommerceInsertableTerms[] = ['name' => $terms];
                    AttributeTerm::create([
                        'id' => $newId,
                        'attribute_id' => $request->attribute_id,
                        'terms_name' => $terms,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $getTerms = AttributeTerm::where('terms_name', $terms)->latest()->first();

                    $termsData[] = [$getTerms];

                }
            }


            // foreach($attribute_terms as $terms){
            //     $existTerms = AttributeTerm::where([['attribute_id',$request->attribute_id],['terms_name',$terms]])->first();
            //     if(!$existTerms){
            //         $woocommerceInsertableTerms[] = ['name' => $terms];
            //         $wmsInsertableTerms[] = [
            //             'id' => $lastRow ? $lastRow->id + $i : 1,
            //             'attribute_id' => $request->attribute_id,
            //             'terms_name' => $terms,
            //             'created_at' => now(),
            //             'updated_at' => now()
            //         ];
            //         $i++;
            //     }
            // }


            // if(count($wmsInsertableTerms) > 0){
            //     $termsInsertedInfo = AttributeTerm::insert($wmsInsertableTerms);
            // }

            if(Session::get('woocommerce') == 1){
            $woocommerceStatus = WoocommerceAccount::where('status',1)->first();
            if($woocommerceStatus){
                if(count($woocommerceInsertableTerms) > 0){
                    $data = [
                        'create' => $woocommerceInsertableTerms
                    ];
                    $woocommerceAttributeInfo = WoocommerceAttribute::where('master_attribute_id',$request->attribute_id)->first();
                    // return 'woo';
                    if($woocommerceAttributeInfo){
                        try{
                            $info = Woocommerce::post('products/attributes/' . $woocommerceAttributeInfo->id . '/terms/batch', $data);
                        }catch (HttpClientException $exception){
                            return redirect('exception')->with('exception', $exception->getMessage());
                        }
                        $woocommerceAttributeResultInfo = [];
                        if(count($info['create']) > 0){
                            foreach($info['create'] as $result){
                                if(!isset($result['error'])){
                                    $existsTermId = WoocommerceAttributeTerm::where([['attribute_id',$woocommerceAttributeInfo->id],['terms_name',$result['name']]])->first();
                                    if(!$existsTermId){
                                        $masterTermsId = AttributeTerm::where([['attribute_id',$request->attribute_id],['terms_name',$result['name']]])->first();
                                        $woocommerceAttributeResultInfo = WoocommerceAttributeTerm::create([
                                            'id' => $result['id'],
                                            'attribute_id' => $woocommerceAttributeInfo->id,
                                            'master_terms_id' => $masterTermsId ? $masterTermsId->id : 0,
                                            'terms_name' => $result['name'],
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]);
                                    }
                                }
                            }
                            // if(count($woocommerceAttributeResultInfo) > 0){
                            //     $termsInsertedInfo = AttributeTerm::insert($woocommerceAttributeResultInfo);
                            // }
                        }
                    }else{
                        $masterAttributeInfo = Attribute::find($request->attribute_id);
                        $dataAttribute = [
                            'name' => $masterAttributeInfo->attribute_name,
                            'type' => 'select',
                            'order_by' => 'menu_order',
                            'has_archives' => true
                        ];
                        try{
                            $info = Woocommerce::post('products/attributes', $dataAttribute);
                        }catch (HttpClientException $exception){
                            return back()->with('error', $exception->getMessage());
                        }
                        $add_woocommerce_attribute = WoocommerceAttribute::create([
                            'id' => $info['id'],
                            'master_attribute_id' => $request->attribute_id,
                            'attribute_name' => $masterAttributeInfo->attribute_name,
                            'use_variation' => $masterAttributeInfo->use_variation,
                        ]);
                        $dataAttributeTerms = [
                            'create' => $woocommerceInsertableTerms
                        ];
                        try{
                            $info = Woocommerce::post('products/attributes/' . $add_woocommerce_attribute->id . '/terms/batch', $dataAttributeTerms);
                        }catch (HttpClientException $exception){
                            return redirect('exception')->with('exception', $exception->getMessage());
                        }
                        $woocommerceAttributeResultInfo = [];
                        if(count($info['create']) > 0){
                            foreach($info['create'] as $result){
                                if(!isset($result['error'])){
                                    $existsTermId = WoocommerceAttributeTerm::where([['attribute_id',$add_woocommerce_attribute->id],['terms_name',$result['name']]])->first();
                                    if(!$existsTermId){
                                        $masterTermsId = AttributeTerm::where([['attribute_id',$request->attribute_id],['terms_name',$result['name']]])->first();
                                        $woocommerceAttributeResultInfo = WoocommerceAttributeTerm::create([
                                            'id' => $result['id'],
                                            'attribute_id' => $add_woocommerce_attribute->id,
                                            'master_terms_id' => $masterTermsId ? $masterTermsId->id : 0,
                                            'terms_name' => $result['name'],
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ]);
                                    }
                                }
                            }
                            // if(count($woocommerceAttributeResultInfo) > 0){
                            //     $termsInsertedInfo = AttributeTerm::insert($woocommerceAttributeResultInfo);
                            // }
                        }

                    }
                    // $request['id'] = $info['id'];
                }
            }else{
                // if(count($wmsInsertableTerms) > 0){
                //     $termsInsertedInfo = AttributeTerm::insert($wmsInsertableTerms);
                // }
//                $lastRow = AttributeTerm::orderBy('id','desc')->first();
                // $lastRow = DB::table('attribute_terms')->orderBy('id','desc')->first();
                // if($lastRow){
                //     $request['id'] = $lastRow->id + 1;
                // }else{
                //     $request['id'] = 1;
                // }
            }
        }

            // $latestInsertedTerm = AttributeTerm::where('terms_name', $request->terms_name)->latest()->first();
            if(isset($request->type)){
                // return response()->json(['type' => 'success', 'msg' => 'Successfully added', 'data' => $latestInsertedTerm, 'name' => 'term']);
                return response()->json(['type' => 'success', 'msg' => 'Successfully added', 'data' => $termsData, 'name' => 'term']);
            }else{
                return back()->with('attribute_terms_add_success_msg', 'Attribute Terms added successfully.');
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
        $single_attribute_terms = AttributeTerm::find($id);
        $content = view('attribute-terms.edit_attribute_terms',compact('single_attribute_terms'));
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
            'terms_name' => 'required|unique:attribute_terms|max:255'
        ]);
        try {
            $data = [
                'name' => $request->terms_name,
            ];

            try{
                $info = Woocommerce::put('products/attributes/'.$request->attribute_id.'/terms/'.$id, $data);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            $update_attribute_terms = AttributeTerm::find($id);
            $attribute_terms = $update_attribute_terms->update($request->all());
            return back()->with('attribute_terms_edit_success_msg','Attribute Terms updated successfully');
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
        $ids = explode('-',$id);
        try {


            try{
                $info = Woocommerce::delete('products/attributes/'.$ids[0].'/terms/'.$ids[1], ['force' => true]);
            }catch (HttpClientException $exception){

                return back()->with('error', $exception->getMessage());
            }

            AttributeTerm::destroy($ids[1]);
            return back()->with('attribute_terms_delete_success_msg','Attribute terms deleted successfully.');
        }catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function getTermsInformation(Request $request){
        $terms_ids = explode('/',$request->ids);
        $catalogue_variation_info = ProductVariation::where('product_draft_id',$terms_ids[0])->get();
        if(count($catalogue_variation_info) > 0){
            $variation_terms_arr = [];
            $variation_terms_array = [];
            foreach ($catalogue_variation_info as $variation){
                foreach (\Opis\Closure\unserialize($variation->attribute) as $att){
                    if($att['attribute_id'] == $terms_ids[1]){
                        if(!in_array($att['terms_name'], $variation_terms_arr)) {
                            $variation_terms_array[] = [
                                'terms' => $att['terms_name'],
                                'image' => $variation->image ?? 'https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png'
                            ];
                            $variation_terms_arr[] = $att['terms_name'];
                        }
                    }
                }

            }
            foreach ($variation_terms_array as $terms){
                $variation_ids = [];
                foreach ($catalogue_variation_info as $variation){
                    foreach (\Opis\Closure\unserialize($variation->attribute) as $att){
                        if($att['attribute_id'] == $terms_ids[1]){
                            if($att['terms_name'] == $terms['terms']) {
                                $variation_ids[] = $variation->id;
                            }
                        }
                    }
                }
                $variaition_terms[] = [
                    'var_id' => $variation_ids,
                    'product_draft_id' => $terms_ids[0],
                    'terms_name' => $terms['terms'],
                    'image' => $terms['image'],
                    'variation_id' => $variation_ids ?? null,
                    'attribute_name' => Attribute::find($terms_ids[1])->attribute_name
                ];
            }

        }
        return response()->json($variaition_terms);
    }

    public function getAttributeTerms(Request $request){
        try{
            $attributeName = Attribute::find($request->attribute_id);
            $termsInfo = AttributeTerm::where('attribute_id', $request->attribute_id)->get();
            return response(['type' => 'success', 'data' => $termsInfo, 'attribute_name' => $attributeName->attribute_name ?? '', 'total_terms' => $termsInfo->count() ?? 0]);
            // $content = view('product_draft.ajax_attribute_terms',compact('attributeName','termsInfo'));
            // echo $content;
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
        }
    }

    public function attributeTermsSearch(Request $request){

        $search_value = $request->attribute_terms_search;
        $attribute_terms = AttributeTerm::join('attributes', 'attribute_terms.attribute_id', '=', 'attributes.id')
                            ->where(function($query)use($search_value){
                                $query->where('attribute_terms.terms_name','LIKE', '%'. $search_value .'%')
                                    ->orWhere('attributes.attribute_name', 'LIKE', '%'. $search_value .'%');
                            })
                            ->paginate(50);


        $total_attribute_terms = count($attribute_terms);
        $all_attribute_terms = json_decode(json_encode($attribute_terms));

        return view('attribute-terms.attribute_terms_list', compact('attribute_terms','all_attribute_terms','total_attribute_terms'));
    }


}
