<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Client;
use App\User;
use Str;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        $project_domain_name = Session::get('project_domain_name');
        // Given URL
        $url = url('/');

        // Search substring 
        $key = 'https://wms360.co.uk/';

        if (str_contains($url, $key)) {
            return redirect()->away('https://wms360.co.uk/my-account/');
        }
        else {
            return view('auth.login');
        }

        // if(isset($request->type) && ($request->type == 'client')){
        //     return redirect($project_domain_name.'/my-account/');
        // }else{
        //     return view('auth.login');
        // }
        //return redirect('https://devops.wms360.co.uk/wp/my-account/');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // $user_token_id = User::where('user_id', '=', '28')->where('user_token', '=', 'wuser_28_5327afe9e8a312f8e1678b33fdb9838f')->first();
        // $project_token = Client::where('project_token', '=', '3f6e96533d524fab57385ffa38713384214965c869782e50fd62cf853e35cb32')->first();

        if(isset($request->user_id) && isset($request->user_token) && isset($request->project_token)){

            Session::put('project_domain_name', $request->root_url);

            Session::put('middleman',$request->middleManUrl);
            $user_token_id = User::where('user_id', '=', $request->user_id)->where('user_token', '=', $request->user_token)->first();

            $project_token = Client::where('project_token', '=', $request->project_token)->first();

            if($user_token_id && $project_token){

                $this->validateLogin($request);

                // If the class is using the ThrottlesLogins trait, we can automatically throttle
                // the login attempts for this application. We'll key this by the username and
                // the IP address of the client making these requests into this application.
                if (method_exists($this, 'hasTooManyLoginAttempts') &&
                    $this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);

                    return $this->sendLockoutResponse($request);
                }

                if ($this->attemptLogin($request)) {

                    return $this->sendLoginResponse($request);
                }

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);
            }else{
                return response()->json([
                    'success' => 'false',
                    'reason' => 'Your user id, user token or project token invalid!',
                ], 401);
            }
        }else{
            Session::put('middleman',"https://wms360.co.uk/dev/");
            $this->validateLogin($request);
            if (method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {

                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        }

    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {



            if(isset($request->wp_logout)){

                $user_token_id = User::where('user_id', '=', $request->user_id)->where('user_token', '=', $request->user_token)->first();

                $project_token = Client::where('project_token', '=', $request->project_token)->first();

                $request['user_token'] = $request['new_user_token'];

                if($user_token_id && $project_token){

                    User::where('id', '=', Auth::user()->id)->update(['user_token' => $request['user_token']]);

                    $this->guard()->logout();

                    $request->session()->invalidate();

                    $request->session()->regenerateToken();
                    // Session::flush('middleman');
                    return response()->json([
                        'success' => true,
                    ]);

                }else{
                    return response()->json([
                        'success' => 'false',
                        'reason' => 'Something Went Wrong!'
                    ]);
                }

            }else{

                $project_domain_name = Session::get('project_domain_name');
                $user_info = User::where('id', Auth::user()->id)->first();

                if($user_info->user_token){
                    $url = $project_domain_name.'/wp-json/user/v1/logout';
                    $data = [
                        'user_id' => $user_info->user_id,
                        'user_token' => $user_info->user_token,
                    ];

                    $curl = curl_init();
                    curl_setopt_array($curl,array(
                        CURLOPT_URL => $url,
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
                    if(isset($result['data']['user_token'])){
                        $request['user_token'] = $result['data']['user_token'];
                        User::where('id', '=', Auth::user()->id)->update(['user_token' => $request['user_token']]);
                        curl_close($curl);
                        $this->guard()->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return $this->loggedOut($request) ?: redirect($project_domain_name.'/my-account/');
                    }else{
                        // $this->guard()->logout();
                        // $request->session()->invalidate();
                        // $request->session()->regenerateToken();
                        return $this->loggedOut($request) ?: redirect('/');
                    }

                }

                $this->guard()->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return $this->loggedOut($request) ?: redirect('/');


            }





    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

}
