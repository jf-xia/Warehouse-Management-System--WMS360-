<?php
namespace App\Http\Middleware;
use App\DeveloperAccount;
use App\OnbuyAccount;
use App\WoocommerceAccount;
use Closure;
use Auth;
use Illuminate\Support\Facades\Session;
class ChannelAccount
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
        $woocommerce_consumer_key = Session::get('woocommerce_consumer_key');
        $woocommerce_secret_key = Session::get('woocommerce_secret_key');
        if($woocommerce_consumer_key == '' && $woocommerce_secret_key == '') {
            $woocommerCredentials = WoocommerceAccount::where('status', 1)->first();
            if ($woocommerCredentials) {
                Session::put('woocommerce_consumer_key', $woocommerCredentials->consumer_key);
                Session::put('woocommerce_secret_key', $woocommerCredentials->secret_key);
            }
        }
        $onbuy_consumer_key = Session::get('onbuy_consumer_key');
        $onbuy_secret_key = Session::get('onbuy_secret_key');
        if($onbuy_consumer_key == '' && $onbuy_secret_key == '') {
            $onbuyCredentials = OnbuyAccount::where('status', 1)->first();
            if ($onbuyCredentials) {
                Session::put('onbuy_consumer_key', $onbuyCredentials->consumer_key);
                Session::put('onbuy_secret_key', $onbuyCredentials->secret_key);
            }
        }
        $ebay_client_id = Session::get('ebay_client_id');
        $ebay_client_secret = Session::get('ebay_client_secret');
        if($ebay_client_id == '' && $ebay_client_secret == '') {
            $ebayDeveloperCredentials = DeveloperAccount::where('status', 1)->first();
            if ($ebayDeveloperCredentials) {
                Session::put('ebay_client_id', $ebayDeveloperCredentials->client_id);
                Session::put('ebay_client_secret', $ebayDeveloperCredentials->client_secret);
                Session::put('ebay_redirect_url', $ebayDeveloperCredentials->redirect_url_name);
                Session::put('ebay_sign_in_link', $ebayDeveloperCredentials->sign_in_link);
            }
        }

        return $next($request);
    }
}
