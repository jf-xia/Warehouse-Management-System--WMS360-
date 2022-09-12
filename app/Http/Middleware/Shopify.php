<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel;

class Shopify
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
        $shopifyAccountInfo = Channel::where('channel_term_slug','shopify')->where('is_active',1)->first();
        if(!$shopifyAccountInfo){
            return redirect('channels');
        }
        return $next($request);
    }
}
