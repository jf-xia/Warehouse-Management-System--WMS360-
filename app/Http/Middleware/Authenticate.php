<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */

//    public function get_user_info(){
//        $auth_user = Auth::user();
//        $user_info = User::get()->all();
//        return $auth_user;
//    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
//                echo '<pre>';
//                print_r($this->get_user_info());
//            $sessions = session()->all();
//            $user_info = User::where('business_url', 'https://woowms.co.uk/test-user-6')->first();
//            print_r($sessions);
//            print_r($user_info);
//            exit();

            $all_cookie = $_COOKIE;
            foreach ($all_cookie as $key => $coolie){
                $find_name = "wordpress_logged_in";
                $cName = $key;

                // Test if string contains the word
                if(strpos($cName, $find_name) !== false){
                    $cookie_name = $cName;
                    $cookie_value = "";
                    unset($_COOKIE[$key]);
                    setcookie($cookie_name,$cookie_value,time() - 3600, '/');
                }
            }
            return route('login');
        }
    }
}
