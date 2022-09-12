<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Setting;
use App\shopify\ShopifyAccount;
use App\Traits\Shopify;
use Illuminate\Http\Request;
use App\shopify\ShopifyCollection;
use Auth;
use Illuminate\Support\Facades\Redirect;

class ShopifyCollectionController extends Controller
{
    use Shopify;
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function collectionList(){
        try{
//            $all_category = ShopifyCollection::get();
            //Start page title and pagination setting
            $settingData = $this->paginationSetting('collection', 'shopify_collection_list');
//        echo '<pre>';
//        print_r($settingData);
//        exit();
            $setting = $settingData['setting'];
            $page_title = '';
            $pagination = $settingData['pagination'];
            //End page title and pagination setting

            $all_category = ShopifyCollection::with(['user_info' => function($query){
                $query->select('id','account_name');
            }])->paginate($pagination);
//            $all_category = $all_category->paginate($pagination);
            $all_decode_category = json_decode(json_encode($all_category));
            $accounts = ShopifyAccount::get();
//            foreach ($all_category as $cat){
//                $catt = $cat->user_info;
//                    echo '<pre>';
//                    var_dump($catt);
//
//            }

//            exit();
            return view('shopify.collection/collection_list', compact('all_category','all_decode_category','pagination','accounts'));
        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }
    }


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


    public function collectionAdd(Request $request){
        try {
        foreach ($request->account_name as $account){
            $shopify_account_info = ShopifyAccount::find($account);
            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);

            $postArray = [

                "title" => $request->category_name,
            ];
            $catagory_get = ShopifyCollection::where('user_id',$account)->where('category_name',$request->category_name)->get();
//            $catagory_name_validation = $catagory_get ? true : false;
//            echo '<pre>';
//            var_dump($catagory_name_validation);
            if(count($catagory_get) == 0){
                $collection_single = $shopify->CustomCollection->post($postArray);
                if(isset($collection_single)){
                    $shopifyCollectionCreate = ShopifyCollection::create([
                        'category_name' => $request->category_name,
                        'user_id' => $account,
                        'shopify_collection_id' => $collection_single['id']
                    ]);
//                    echo '<pre>';
//                    var_dump($shopifyCollectionCreate);
                }
            }
        }
//        exit();
            return Redirect::back()->with('success', 'Collection Successfully added');
        }catch (HttpClientException $exception){

        return back()->with('error', $exception->getMessage());
        }
    }


    // collection delete function
    public function delete(Request $request){
        try {
            $shopify_account_info = ShopifyAccount::find($request->account_id);
            if(!empty($shopify_account_info)){
                $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
                if(!empty($request->shopify_category_id)){
                    $collection_delete = $shopify->CustomCollection($request->shopify_category_id)->delete();
                }
            }

//            var_dump($shopify);
//            exit();
//            $postArray = [
//                "id" => $request->shopify_category_id,
//                "title" => $request->category_name,
//            ];

//            var_dump($collection_delete);
//            exit();
//            dd($request->shopify_collection_id);
            ShopifyCollection::find($request->collection_delete_id)->delete();
            return Redirect::back()->with('category_delete_success_msg', 'Collection Successfully Deleted');
        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }

    }

    // collection edit function
    public function edit(Request $request){
        try {
            $shopify_account_info = ShopifyAccount::find($request->account_id);
            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
//            var_dump($shopify);
//            exit();
            $postArray = [
                "id" => $request->shopify_category_id,
                "title" => $request->category_name,
            ];
            $collection_single = $shopify->CustomCollection($request->shopify_category_id)->put($postArray);
            if(isset($collection_single)){
                $shopifyCollectionEdit = ShopifyCollection::where('id', $request->category_id)->update([
                    'category_name' => $request->category_name,
                ]);
            }
//            dd($request);
//            echo '<pre>';
//            var_dump($collection_single);
//            exit();
            return Redirect::back()->with('category_edit_success_msg', 'Collection Successfully Edited');
        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }

    }

    // migration collection function

    public function migration(Request $request){
        try {
            $shopify_account_info = ShopifyAccount::find($request->migration_account);
            $shopify = $this->getConfig($shopify_account_info->shop_url,$shopify_account_info->api_key,$shopify_account_info->password);
//            var_dump($shopify);
//            exit();
            $postArray = [
                "limit" => 250,
            ];

            $collection_single = $shopify->CustomCollection->get($postArray);
//            echo '<pre>';
//            print_r($collection_single);
//            exit();
            foreach ($collection_single as $collection){
                $catagory_get = ShopifyCollection::where('shopify_collection_id',$collection['id'])->where('category_name',$collection['title'])->get();
                if(count($catagory_get) == 0){
                    $shopifyCollectionCreate = ShopifyCollection::create([
                        'category_name' => $collection['title'],
                        'user_id' => $request->migration_account,
                        'shopify_collection_id' => $collection['id']
                    ]);
                }
//                echo '<pre>';
//                var_dump($collection['id']);
//                var_dump($collection['title']);
            }
//            exit();
            return Redirect::back()->with('success', 'Collection Successfully added');
            dd($request->account_name);

        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }
    }
}
