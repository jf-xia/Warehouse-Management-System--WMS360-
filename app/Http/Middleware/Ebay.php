<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel;

class Ebay
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
        $ebayAccountInfo = Channel::where('channel_term_slug','ebay')->where('is_active',1)->first();
        if(!$ebayAccountInfo){
            return redirect('channels');
        }
        return $next($request);
    }
}
