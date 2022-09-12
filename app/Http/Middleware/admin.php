<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if (Auth::check() && in_array('1',explode(',',Auth::user()->role))) {
            return $next($request);
        }
        // elseif (Auth::check() && in_array('2',explode(',',Auth::user()->role))) {
        //     return $next($request);
        // }
        // elseif (Auth::check() && in_array('3',explode(',',Auth::user()->role))) {
        //     return redirect('assigned/order/list');
        // }
        // elseif (Auth::check() && in_array('4',explode(',',Auth::user()->role))) {
        //     return redirect('pending-receive');
        // }
        // elseif (Auth::check() && in_array('5',explode(',',Auth::user()->role))) {
        //     return redirect('completed/order/list');
        // }

        else {
            if($role && $role == 'manager' && Auth::check() && in_array('2',explode(',',Auth::user()->role))){
                return $next($request);
            }
            return redirect('completed-catalogue-list')->with('error','You are not allowed to go to your intended page');
            //return redirect()->route('login');
        }
    }
}
