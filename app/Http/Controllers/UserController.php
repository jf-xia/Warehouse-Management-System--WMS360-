<?php

namespace App\Http\Controllers;

use App\Client;
use App\Invoice;
use App\Order;
use App\ProductVariation;
use App\Role;
use App\User;
use App\Setting;
use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
use App\InvoiceProductVariation;
use Crypt;
use Illuminate\Support\Facades\Input as input;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
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
    * Route Type : user-list
    * Method Type : GET
    * Parameters : null
    * Creator : unknown
    * Modifier : kazol & solaiman
    * Description : This function is used for user list and pagination setting
    * Modified Date : 30-11-2020
    * Modified Content : Pagination setting
    */

    public function clientInfo(){
        $shelfStatus = Session::get('shelf_use');
        if($shelfStatus != ''){
            return $shelfStatus;
        }else{
            $shelfInfo = Client::first();
            if($shelfInfo){
                Session::put('shelf_info',$shelfInfo->shelf_use);
                return $shelfInfo->shelf_use;
            }else{
                return 'not-use';
            }

        }
    }


    public function index()
    {

        //Start page title and pagination setting
        $settingData = $this->paginationSetting('user', 'user_list');
        $setting = $settingData['setting'];
        $page_title = 'User | WMS360';
        $pagination = $settingData['pagination'];
        //End page title and pagination setting


        $all_role = Role::all();
        $all_user = User::with(['roles'])->paginate($pagination);
        $total_user = User::count();
        $all_decode_user = json_decode(json_encode($all_user));
        $content = view('user.user_list',compact('all_user','all_decode_user','total_user','all_role','pagination','setting','page_title'));
        return view('master',compact('content'));
    }



    /*
    * Function : paginationSetting
    * Route Type : null
    * Parameters : null
    * Creator : Kazol
    * Modifier : solaiman
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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_role = Role::all();
        $content = view('user.add_user',compact('all_role'));
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
        $data = '';
        $multiple_role = $request->role;
        foreach ($request->role as $role){
            $data .= $role.',';
        }
        $request['role'] = rtrim($data,',');

        $validate = $request->validate([
            'name' => 'required|max:255|unique:users',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users',
            'phone_no' => 'required|numeric|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'role' => 'required'
        ]);
        $filename = '';
        if($request->hasFile('user_image')){
            $file = $request->user_image;
            $filename = rand().'.'.$file->clientExtension();
            $file->move('uploads/', $filename);
        }
        $request['image'] = $filename;
        $password_wp = $request->password;
        $request['password'] = Hash::make($request->password);

        //Child User API SECTION
        $project_domain_name = Session::get('project_domain_name');
        // $post_url = 'https://wms360.co.uk/wp-json/register/v1/new/chield/user';
        $post_url = $project_domain_name.'/wp-json/register/v1/new/chield/user';
        // $parent_info = User::find(2);
        $parent_info = User::where('user_role', '=', 'parent')->first();

        $client_info = Client::first();

        if(isset($parent_info->user_id)){

            $data = [
                'user_id' => $parent_info->user_id,
                'user_token' => $parent_info->user_token,
                'project_token' => $client_info->project_token,
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => $password_wp,
            ];

            $curl = curl_init();
            curl_setopt_array($curl,array(
                CURLOPT_URL => $post_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                ),
            ));

            $response = curl_exec($curl);
            $result = json_decode($response, true);

            curl_close($curl);

            if(isset($result['data']['user_id']) && isset($result['data']['user_token'])){

                $request['user_id'] = $result['data']['user_id'];
                $request['user_token'] = $result['data']['user_token'];
                // $add_user = User::create($request->all());
                $add_user = User::create([
                    'employee_id' => $request['user_id'],
                    'user_role' => 'child',
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone_no' => $request->phone_no,
                    'card_no' => $request->card_no,
                    'image' => $request['image'],
                    'address' => $request->address,
                    'country' => $request->country,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'state' => $request->state,
                    'role' => $request['role'],
                    'password' => $request['password'],
                    'user_id' => $request['user_id'],
                    'user_token' => $request['user_token']
                ]);
                $user = User::find($add_user->id);
                foreach ($multiple_role as $role) {
                    $data = $role;
                    $user->roles()->attach($data);
                }

                return back()->with('user_add_success_msg','User added successfully');

            }else{

                return back()->with('child_user_error','Something went wrong! Please try again!');

            }
        }else{

            $add_user = User::create($request->all());
            $user = User::find($add_user->id);
            foreach ($multiple_role as $role) {
                $data = $role;
                $user->roles()->attach($data);
            }

            return back()->with('user_add_success_msg','User added successfully');

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
        $shelfUse = $this->clientInfo();
        $id = Crypt::decrypt($id);
        $single_user = User::with(['roles'])->find($id);
        $all_role = Role::all();
        $user_shelved_product = [];
//        echo '<pre>';
//        print_r(json_decode($single_user));
//        exit();
        $user_pending_shelved_product = InvoiceProductVariation::with(['user_shelved_product','user_shelved_invoice_no:id,invoice_number'])->where([['shelver_user_id',$id],['shelving_status',0]])->get();
        if($shelfUse == 1) {
            $user_shelved_product = InvoiceProductVariation::with(['user_shelved_product', 'user_shelved_invoice_no:id,invoice_number'])->where([['shelver_user_id', $id], ['shelving_status', 1]])->get();
        }
        $user_assigned_order = Order::with(['product_variations','assigner_info:id,name'])->where([['picker_id',$id],['status','processing']])->get();
        $user_picked_order = Order::with(['product_variations','assigner_info:id,name'])->where([['picker_id',$id],['status','completed']])->get();
        $user_packed_order = Order::with(['product_variations','assigner_info:id,name','picker_info:id,name'])->where([['packer_id',$id],['status','completed']])->get();
        $user_receive_product = Invoice::with(['invoice_product_variation_info','vendor_info:id,name'])->where('receiver_user_id',$id)->get();
//        echo "<pre>";
//        print_r(json_decode(json_encode($user_receive_product)));
//        exit();
        $single_user = json_decode(json_encode($single_user));
        $content = view('user.user_details',compact('single_user','user_pending_shelved_product','user_shelved_product','user_assigned_order','user_picked_order','user_packed_order','user_receive_product','all_role','shelfUse','id'));
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
        $id = Crypt::decrypt($id);
        //$single_user = User::find($id);
        $all_role = Role::all();
        $single_user = User::with(['roles'])->find($id);
        $single_user = json_decode(json_encode($single_user));
        $content = view('user.edit_user',compact('single_user','all_role'));
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
//        return $request->role;
        $validator = $request->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|regex:/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}/|unique:users,email,' . $id,
            'phone_no' => 'required|numeric|unique:users,phone_no,' . $id
        ]);
        if(in_array('1', explode(',', Auth::user()->role))) {
            $data = '';
            $multiple_role = $request->role;
            foreach ($request->role as $role) {
                $data .= $role . ',';
            }
            $request['role'] = rtrim($data, ',');
        }

        $fileName = $request->exist_image;
        if ($request->hasfile('user_image')) {
            $file = $request->user_image;
            $fileName = time() . '.' . $file->clientExtension();
            $file->move('uploads/', $fileName);
        }
        $user_obj = User::find($id);
        $request['image'] = $fileName;
        $update_user = $user_obj->update($request->all());
//        $user = User::find($update_user->id);
        if(in_array('1', explode(',', Auth::user()->role))){
            $user_obj->roles()->detach();
            foreach ($multiple_role as $role) {
                $data = $role;
                $user_obj->roles()->attach($data);
            }
        }
        return back()->with('user_update_success_msg','User successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::destroy($request->user_id);
        return back()->with('user_delete_success_msg','User successfully deleted');
    }

    public function changePassword($id)
    {
        $content = view('user.change_password_form',compact('id'));
        return view('master',compact('content'));
    }

    public function updatePassword(Request $request)
    {
            $validate = $request->validate([
                'old_password' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            $current_password = User::find($request->user_id)->password;
            if(Hash::check($request->old_password, $current_password))
            {
                $obj_user = User::find($request->user_id);

                $wp_user_id = User::find($request->user_id)->employee_id;
                $user_token = User::find($request->user_id)->user_token;
                //reset password from wms
                $post_url = 'https://wms360.co.uk/wp-json/register/v1/reset/password';
                $data = [
                    'user_id' => $wp_user_id,
                    'user_token' => $user_token,
                    'new_password' => $request->password
                ];

                $curl = curl_init();
                curl_setopt_array($curl,array(
                    CURLOPT_URL => $post_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                    ),
                ));

                $response = curl_exec($curl);
                $result = json_decode($response, true);
                curl_close($curl);
                if(isset($result['success'])){
                    $obj_user->password = Hash::make($request->password);
                    $obj_user->save();
                    return back()->with('password_success_msg','Password successfully changed');
                }else{
                    return back()->with('password_not_match_msg','Please try again!!');
                }
            }
            else{
                return back()->with('password_not_match_msg','Please enter correct current password');
            }

    }

    public function credential_rules(array $data)
    {
        $message = [
            'old_password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
            'password_confirmation' => 'Please enter confirm password',
        ];

        $validator = Validator::make($data,[
           'old_password' => 'required',
           'password' => 'required|',
           'password_confirmation' => 'required|same:password',
        ]);
        return $validator;
    }

    /*
      * Function : userColumnsearch
      * Route Type : {route_name}/user/search
      * Parameters : null
      * Creator : solaiman
      * Modifier :
      * Description : This function is used for pagination setting and Individual column search
      * Created Date : 03-01-2021
      */


    public function userColumnsearch(Request $request) {

        $settingData = $this->paginationSetting('user', 'user_list');
        $setting = $settingData['setting'];
        $page_title = 'User List | WMS360';
        $pagination = $settingData['pagination'];


        $column = $request->column_name;
        $value = $request->search_value;

        $all_user = User::select('employee_id','name','last_name', 'email', 'phone_no')
                   ->Where(function($query) use($request, $column, $value){
                       if($column == 'employee_id'){
                           if($request->opt_out == 1){
                               $query->where($column,'!=',$value);
                           }else{
                               $query->where($column, $value);
                           }
                       }elseif($column == 'name'){
                           if($request->opt_out == 1){
                               $query->where($column,'NOT LIKE', '%' . $value . '%');
                           }else{
                               $query->where($column,'like', '%' . $value. '%');
                           }
                       }elseif($column == 'last_name'){
                           if($request->opt_out == 1){
                               $query->where($column,'NOT LIKE', '%' . $value . '%');
                           }else{
                               $query->where($column,'like', '%' . $value. '%');
                           }
                       }elseif($column == 'email'){
                           if($request->opt_out == 1){
                               $query->where($column,'NOT LIKE', '%' . $value . '%');
                           }else{
                               $query->where($column,'like', '%' . $value. '%');
                           }
                       }elseif($column == 'phone_no'){
                           if($request->opt_out == 1){
                               $query->where($column,'NOT LIKE', '%' . $value . '%');
                           }else{
                               $query->where($column,'like', '%' . $value. '%');
                           }
                       }

                       // If user submit with empty data then this message will display table's upstairs
                       if($value == ''){
                           return back()->with('no_data_found', 'Your input field is empty!! Please submit valuable data!!');
                       }

                   })

                   ->paginate($pagination);


                // If user submit with wrong data or not exist data then this message will display table's upstairs
                $all_user_Ids = [];
                if((is_countable($all_user) && count($all_user)) > 0){
                    foreach ($all_user as $result){
                        $all_user_Ids[] = $result->id;
                    }
                }else{
                    return redirect('/user-list')->with('message','No data found');
                }

        $all_role = Role::all();
        $total_user = User::count();
        $all_decode_user = json_decode(json_encode($all_user));
        $content = view('user.user_list',compact('all_user','all_decode_user','total_user','pagination','setting','page_title', 'column', 'value', 'all_role'));
        return view('master',compact('content'));

    }

       /*
        * Function : userIdNamesearch
        * Route Type : {route_name}/id/name/search
        * Parameters : null
        * Creator : solaiman
        * Modifier :
        * Description : This function is used for pagination setting and user list employee id, name search
        * Created Date : 03-01-2021
        */

    public function userIdNamesearch(Request $request){

        $settingData = $this->paginationSetting('user', 'user_list');
        $setting = $settingData['setting'];
        $page_title = 'User List | WMS360';
        $pagination = $settingData['pagination'];

        $id_name_search_value = $request->search_value;
        $all_user = User::where('employee_id', $id_name_search_value)
                    ->orWhere('name','LIKE', '%'. $id_name_search_value.'%')
                    ->orWhere('last_name','LIKE', '%'. $id_name_search_value.'%')
                    ->paginate($pagination);


        // If user submit with wrong data or not exist data then this message will display table's upstairs
        $all_user_Ids = [];
        if((is_countable($all_user) && count($all_user)) > 0){
            foreach ($all_user as $result){
                $all_user_Ids[] = $result->id;
            }
        }else{
            return redirect('/user-list')->with('message','No data found');
        }

        $all_role = Role::all();
        $total_user = User::count();
        $all_decode_user = json_decode(json_encode($all_user));
//        echo "<pre>";
//        print_r($all_user);
//        exit();
        return view('user.user_list',compact('all_user','all_decode_user','total_user', 'setting', 'page_title', 'pagination', 'all_role'));
    }


}
