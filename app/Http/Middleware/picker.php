<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class picker
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
        if (Auth::check() && in_array('1',explode(',',Auth::user()->role))) {
            return $next($request);
        }
        elseif (Auth::check() && in_array('2',explode(',',Auth::user()->role))) {
            return $next($request);
        }
        elseif (Auth::check() && in_array('3',explode(',',Auth::user()->role))) {
            return $next($request);
        }
        elseif (Auth::check() && in_array('4',explode(',',Auth::user()->role))) {
            return redirect('shelf');
        }
        elseif (Auth::check() && in_array('5',explode(',',Auth::user()->role))) {
            return redirect('role');
        }

        else {
            return redirect()->route('login');
        }
    }
}
