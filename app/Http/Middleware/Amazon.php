<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel;

class Amazon
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
        $amazonAccountInfo = Channel::where('channel_term_slug','amazon')->where('is_active',1)->first();
        if(!$amazonAccountInfo){
            return redirect('channels')->with('warning','Amazon Is Not Active. Please Contact With Support.');
        }
        return $next($request);
    }
}
