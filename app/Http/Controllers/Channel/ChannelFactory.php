<?php


namespace App\Http\Controllers\Channel;


use App\Http\Controllers\Channel\Ebay;
use App\Http\Controllers\Channel\Onbuy;
use App\Http\Controllers\Channel\WMS;
use App\Http\Controllers\Channel\CWoocommerce;
use App\Http\Controllers\Channel\Shopify;
use App\Http\Controllers\Channel\Amazon;
use Illuminate\Support\Facades\Session;
use App\Channel;

class ChannelFactory
{
    const eBay =1;
    const OnBuy =2;
    const Woocommerce =3;
    const Amazon =4;
    const Shopify =5;
    const DPD =6;

    public function getChannelArray(){
        $channel_array= array();
        array_push($channel_array,new WMS());

        $channels = Channel::get()->toArray();

        if(($key = array_search('ebay',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                array_push($channel_array,new Ebay());
            }
        }
        if(($key = array_search('onbuy',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                array_push($channel_array,new Onbuy());
            }
        }
        if(($key = array_search('woocommerce',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                array_push($channel_array,new CWoocommerce());
            }
        }
        if(($key = array_search('amazon',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                array_push($channel_array,new Amazon());
            }
        }
        if(($key = array_search('shopify',array_column($channels,'channel_term_slug'))) !== false){
            if($channels[$key]['is_active'] == 1){
                array_push($channel_array,new Shopify());
            }
        }
        // if(Session::get('ebay') == 1){
        //     array_push($channel_array,new Ebay());
        // }
        // if(Session::get('woocommerce') == 1){
        //     array_push($channel_array,new CWoocommerce());
        // }
        // if(Session::get('onbuy') == 1){
        //     array_push($channel_array,new Onbuy());
        // }
        // if(Session::get('amazon') == 1){
        //     array_push($channel_array,new Amazon());
        // }



        return $channel_array;
    }

}
