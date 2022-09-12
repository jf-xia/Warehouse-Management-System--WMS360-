<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel;

class Onbuy
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
        $onbuyAccountInfo = Channel::where('channel_term_slug','onbuy')->where('is_active',1)->first();
        if(!$onbuyAccountInfo){
            return redirect('channels')->with('warning','Onbuy Is Not Active. Please Contact With Support.');
        }
        return $next($request);
    }
}
