<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\shopify\ShopifyAccount;
use App\Traits\Shopify;
use App\shopify\ShopifyVariation;
use App\shopify\ShopifyMasterProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Channel;

class AccountController extends Controller
{
    use Shopify;
    //
    public function __construct(){
        $this->middleware('auth');
    }

    // Shopify Account List function
    public function accountList(){
        try {
            $shopifyAccounts = ShopifyAccount::get();

            // $shopify_variation_result = ShopifyVariation::where('sku' ,'A&F_VEGAN_BROWN_XS')->get()->first();
            // if ($shopify_variation_result != null){
            //     $master_info = ShopifyMasterProduct::where('id' ,$shopify_variation_result->shopify_master_product_id)->first();
            //     if(!empty($master_info)){
            //         echo 'its not empty';
            //     }else{
            //         echo 'its empty';
            //     }
            // }else{
            //     echo 'its empty';
            // }
            // echo '<pre>';
            // print_r($master_info->account_id);
            // exit();
            return view('shopify.account_list', compact('shopifyAccounts'));
        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }
    }

    // creating shopify account
    public function createAccount(Request $request){
        try {

            $shopifyCreateAccount = new ShopifyAccount();
            $shopifyCreateAccount->account_name = $request->account_name;
            $path = '';
            if ($request->hasFile('account_logo')){
                $logo = $request->account_logo;
                $filename = rand(100,1000).'.'. $logo->extension();
                $path = asset('uploads/shopify-account-logo').'/'.$filename;
                $logo->move('./uploads/shopify-account-logo/',$filename);
            }
            $shopifyCreateAccount->account_logo = $path;
            $shopifyCreateAccount->account_status = $request->account_status;
            $shopifyCreateAccount->shop_url = $request->shop_url;
            $shopifyCreateAccount->api_key = $request->api_key;
            $shopifyCreateAccount->password = $request->password;
            $shopifyCreateAccount->save();

            $channelUpdateStatus = Channel::where('channel_term_slug','shopify')->update(['is_active' => 1]);

            if(isset($request->request_type)){
                return response()->json(['type' => 'success','msg' => 'Account Added Successfully']);
            }

            return Redirect::back()->with('success', 'Shopify Account Added');
        }catch (HttpClientException $exception){
            if(isset($request->request_type)){
                return response()->json(['type' => 'error','msg' => $exception->getMessage()]);
            }
            return back()->with('error', $exception->getMessage());
        }
    }

    // shopify account delete
    public function accountDelete($id){
        try{
            $shopifyAccountDelete = ShopifyAccount::find($id);
            $shopifyAccountDelete->delete();
            return Redirect::back()->with('error', 'Shopify Account Successfully Deleted');
        }catch (HttpClientException $exception){

            return back()->with('error', $exception->getMessage());
        }
    }


    public function editAccount(Request $request, $id){
        try {
//            echo '<pre>';
//            print_r($id);
//            exit();

            $shopifyeditAccount = ShopifyAccount::find($id);
            $shopifyeditAccount->account_name = $request->account_name;
            $shopifyeditAccount->account_status = $request->account_status;
            $shopifyeditAccount->shop_url = $request->shop_url;
            $shopifyeditAccount->api_key = $request->api_key;
            $shopifyeditAccount->password = $request->password;
            if ($request->hasFile('account_logo')){
                $logo = $request->account_logo;
                $filename = rand(100,1000).'.'. $logo->extension();
                $path = asset('uploads/shopify-account-logo').'/'.$filename;
                $logo->move('./uploads/shopify-account-logo/',$filename);
                $shopifyeditAccount->account_logo = $path;
            }
            $shopifyeditAccount->update();

            return Redirect::back()->with('success', 'Shopify Account Successfully Edited');
        }catch (HttpClientException $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
