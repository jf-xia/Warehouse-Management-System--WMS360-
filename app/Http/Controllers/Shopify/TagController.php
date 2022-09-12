<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Setting;
use App\shopify\ShopifyTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //

    public function tagsList(){
        try {
            $settingData = $this->paginationSetting('shopify', 'shopify_tag_list');
            $setting = $settingData['setting'];

            $pagination = $settingData['pagination'];

            $all_tags = ShopifyTag::paginate($pagination);

            $all_decode_tag = json_decode(json_encode($all_tags));
//            echo '<pre>';
//            print_r($all_tags);
//            exit();
            return view('shopify.tag.tag_list', compact('all_tags','all_decode_tag','pagination','settingData','setting'));
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function create(Request $request){
        try {
//            print_r($request->tag);
//            exit();
            if(!empty($request->tag)){
                foreach ($request->tag as $tag){
                    $tags = ShopifyTag::create([
                        "tag_name" => $tag,
                    ]);
                }
            }

//            exit();
            return Redirect::back()->with('success', 'Tag Successfully added');
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


    public function edit($id, Request $request){
        try {
            $tag_update = ShopifyTag::find($id)->update([
                "tag_name" => $request->tag,
            ]);
            return Redirect::back()->with('tag_edit_success_msg', 'Tag Successfully Edited');
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id){
        try {
            $delete_tag = ShopifyTag::find($id)->delete();
            return Redirect::back()->with('tag_delete_success_msg', 'Tag Successfully Deleted');
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
