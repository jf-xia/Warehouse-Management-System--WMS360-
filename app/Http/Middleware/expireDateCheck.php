<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Client;
use Auth;
use Redirect;

class expireDateCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $currentDate = date('Y-m-d H:i:s');
        $userExpireDate = Client::where('expire_date', '<' , $currentDate)->first();
        
        if($userExpireDate){
            return Redirect::to('dashboard');
        }
        
        return $next($request);
        
    }
}
