<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use App\Client;
use App\User;
use DB;
use Log;
use App\Traits\ListingLimit;

class MasterAppApiController extends Controller
{
    use ListingLimit;

    public function register(Request $request)
    {

            $validator = Validator::make($request->all(),[
                'name' => ['required','string','max:255'],
                'email' => ['required','string', 'email', 'max:255', 'unique:users'],
                'user_id' => ['required','integer','unique:users'],
                'bussiness_url' => ['required'],
                'listing_limit' => ['required'],
                'start_date' => ['required'],
                'expire_date' => ['required'],
                'user_token' => ['required','string','unique:users'],
            ]);


            if ($validator->fails()){
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->toArray()
                ]);
            }


         try{

            $user_data = array();
            $client_data = array();
            $user_data['user_id'] = $request->user_id;
            $user_data['employee_id'] = $request->user_id;
            $user_data['name'] = $request->name;
            $user_data['email'] = $request->email;
            $user_data['password'] = Hash::make($request->password);
            $user_data['role'] = '1,2,3,4,5,6';
            $user_data['user_role'] = 'parent';
            $client_data['bussiness_name'] = $request->bussiness_name;
            $client_data['client_id'] = $request->user_id;
            $client_data['client_name'] = $request->bussiness_name ?? null;
            $client_data['url'] = asset('/').'api';
            $client_data['logo_url'] = asset('/').'assets/common-assets/app_logo.jpg';
            $client_data['bussiness_url'] = $request->bussiness_url;
            $client_data['listing_limit'] = $request->listing_limit;
            $client_data['listing_max'] = $request->listing_limit;
            $client_data['start_date'] = date("Y-m-d H:i:s", strtotime($request->start_date)) ?? null;
            $client_data['expire_date'] = date("Y-m-d H:i:s", strtotime($request->expire_date)) ?? null;
            $client_data['apps_links'] = \Opis\Closure\serialize([
                    "zebra_apps"   => $request->zebra_apps,
                    "android_link" => $request->android_link,
                    "ios_link"     => $request->ios_link
                ]);
//            Log::info($client_data['apps_links']);
//             Log::info($request->zebra_apps);
//             Log::info($request->android_link);
//             Log::info($request->ios_link);
            $user_data['user_token'] = $request->user_token;
            $token = Str::random(60);
            $client_data['project_token'] = hash('sha256', $token);
            DB::table('users')->Insert($user_data);
            DB::table('clients')->Insert($client_data);
            DB::table('user_role')->insert([
                ["user_id" => "2","role_id" => "1"],
                ["user_id" => "2","role_id" => "2"],
                ["user_id" => "2","role_id" => "3"],
                ["user_id" => "2","role_id" => "4"],
                ["user_id" => "2","role_id" => "5"],
                ["user_id" => "2","role_id" => "6"]
            ]);
            $client = DB::table('clients')->where('project_token', $client_data['project_token'])->first();

            return response()->json([
                'success' => 'true',
                'project_token' => $client->project_token
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => 'false',
                'errors' => $e->getMessage(),
           ]);
        }



    }


    public function updatePasswordApi(Request $request){

        $user_info = DB::table('users')->where('user_id', $request->user_id)->where('user_token', $request->user_token)->first();
        // $user_token = DB::table('users')->where('user_token', $request->user_token)->first();
        if($user_info){
            $new_password = Hash::make($request->new_password);
            DB::table('users')->where('id', '=', $user_info->id)->update(['password' => $new_password]);
            return response()->json([
                'success' => 'password updated successfully',
                'user_id' => $request->user_id,
                'user_token' => $request->user_token,
                'new_password' => $request->new_password
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }

    }

    // give the packages info to wp
    public function infoPackagesApi(Request $request){
        $client_info = DB::table('clients')->where('project_token',$request->project_token)->first();
        $listingLimitAllChannelActiveProduct = $this->ListingLimitAllChannelActiveProduct();
        if($client_info){
            return response()->json([
                'success' => true,
                'listing_max' => $client_info->listing_max,
                'listing_limit' => $listingLimitAllChannelActiveProduct,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User info are mismatch!'
            ]);
        }
        
    }   


    public function updatePackagesApi(Request $request){
        $user_id = DB::table('users')->where('user_id', $request->user_id)->first();
//        $project_token = DB::table('clients')->where('email', $request->email)->get();
        $client_info = DB::table('clients')->where('project_token',$request->project_token)->first();
    //    foreach ($client_info as $client){
    //        $cat_listing = $client['listing_limit'];
    //    }

        if(!empty($request->catalogue)){
            
            // if(($request->catalogue > $client_info->listing_max)){
                $expire_date = date('Y-m-d',strtotime(str_replace('/', '-', $request->next_payment_date)));
                if(($request->user_id == $user_id->user_id) && ($request->project_token == $client_info->project_token)){
                    DB::table('clients')->update([
                        'expire_date' => $expire_date,
                        'listing_limit' => $request->catalogue,
                        // 'listing_max' => $request->catalogue
                    ]);
                    $client_info = DB::table('clients')->where('project_token',$request->project_token)->first();
                    return response()->json([
                        'success' => true,
                        'listing_limit' => $client_info->listing_limit,
                        'message' => 'Listing Limite are Updated',
                        'expire_date' => $client_info->expire_date,
                        'variable_check' => $expire_date,
                        'from_wp' => $request->next_payment_date
                        // 'update_max' => $request->catalogue,
                        // 'remaining' => $update_listing_limit
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'User info are mismatch!'
                    ]);
                }
            // }
            // else{
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Catalogue need to be Upgrade another higher package!'
            //     ]);
            // }
        }
        // else{
        //     DB::table('clients')->update([
        //         'expire_date' => date("Y-m-d H:i:s", strtotime($request->next_payment_date)),
        //     ]);
        //     return response()->json([
        //         'success' => true,
        //         'update_message' => 'package date updated'
        //     ]);
        // }
    }


    public function logout(Request $request) {

        // return 'success';

        if(isset($request->wp_logout)){
            // return 'success';

            $project_token = Client::where('project_token', '=', $request->project_token)->first();

            // if($project_token){
            //     return 'success';
            // }

            $user_token_id = User::where('user_id', '=', $request->user_id)->where('user_token', '=', $request->user_token)->first();

        //    if($user_token_id){
        //        return 'success';
        //    }

            $request['user_token'] = $request['new_user_token'];

            // if($request['user_token']){
            //     return 'success';
            // }



            if($user_token_id && $project_token){

                // return 'success';

                // User::where('id', '=', Auth::user()->id)->update(['user_token' => $request['user_token']]);

                Auth::logout();
                Session::flush();

                // $request->session()->invalidate();

                // $request->session()->regenerateToken();

                // $this->guard()->logout();

                // $request->session()->invalidate();

                // $request->session()->regenerateToken();

                return response()->json([
                    'success' => true,
                ]);

            }else{
                return response()->json([
                    'success' => 'false',
                    'reason' => 'Something Went Wrong!'
                ]);
            }

        }
    }


    // support login user create .............
    public function CreateSupportUser(Request $request){
        
        $user_token_id = User::where('user_role', '=', 'support')->first();
        $exist_user = User::onlyTrashed()->where('user_role', '=', 'support')->first();
        
        if(!empty($exist_user)){
            
            User::onlyTrashed()->find($exist_user->id)->restore();
            $update_user = User::where('user_role', '=', 'support')->update([
                'name' => 'Combosoft',
                'last_name' => 'Support',
                'email' => $request->email,
                'phone_no' => $request->number,
                'role' => '1,2,3,4,5,6',
                'password' => $request->password,
                'user_id' => $request->user_id,
                'user_role' => 'support',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'found the softdelete user',
            ]);
        }else{
            if(empty($user_token_id)){
                $add_user = User::create([
                    'name' => 'Combosoft',
                    'last_name' => 'Support',
                    'email' => $request->email,
                    'phone_no' => $request->number,
                    'role' => '1,2,3,4,5,6',
                    'password' => $request->password,
                    'user_id' => $request->user_id,
                    'user_role' => 'support',
                ]);
                return response()->json([
                    'success' => true,
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message' => 'found the existing user'
                ]);
            }
        }





        // if(!empty($user_token_id) && empty($exist_user)){
        //     User::withTrashed()->where('user_role', '=', 'support')->restore();
        //     return response()->json([
        //         'error' => true,
        //         'reason' => 'user exist... !'
        //     ]);
        // }else{
        //     $add_user = User::create([
        //         'name' => 'Combosoft',
        //         'last_name' => 'Support',
        //         'email' => $request->email,
        //         'phone_no' => '01785445545',
        //         'role' => '1,2,3,4,5,6',
        //         'password' => $request->password,
        //         'user_id' => $request->user_id,
        //         'user_role' => 'support',
        //     ]);
        //     $user_info = User::where('email', '=', $request->email)->first();
        //     return response()->json([
        //         'success' => true,
        //     ]);
        // }
        
    }

	// delete support user .....
    public function deleteSupportUser(Request $request){
        $delete_user = User::where('user_role', '=', 'support')->first();
        if(!empty($delete_user)){
            $delete_user = User::where('user_role', '=', 'support')->delete();
            return response()->json([
                'success' => true,
            ]);
        }else{
            return response()->json([
                'error' => true,
                'reason' => 'No user found... !'
            ]);
        }
    }


}
