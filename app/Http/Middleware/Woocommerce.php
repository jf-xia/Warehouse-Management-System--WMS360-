<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel;

class Woocommerce
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
        $woocommerceAccountInfo = Channel::where('channel_term_slug','woocommerce')->where('is_active',1)->first();
        if(!$woocommerceAccountInfo){
            return redirect('channels')->with('warning','Woocommerce Is Not Active. Please Contact With Support.');
        }
        return $next($request);
    }
}
