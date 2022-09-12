<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class AppDownloadController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function download(){

        $client_info = Client::first();
        $client_id = $client_info['client_id'];
        $client_url = $client_info['url'];

        $apps_links = \Opis\Closure\unserialize($client_info['apps_links']);

        $project_domain_name = Session::get('project_domain_name');

        $url = $project_domain_name.'/wp-json/app/v1/wp/app_download';

                    $curl = curl_init();
                    curl_setopt_array($curl,array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            'Accept: application/json',
                            'Content-Type: application/json',
                        ),
                    ));

                    $response = curl_exec($curl);
                    $apps_links = json_decode($response, true);
                    curl_close($curl);
                    // if(isset($result['data'])){
                    //     echo '<pre>';
                    //     print_r($result['data']['zebra_link']);
                    // }else{
                    //     return Response::json(['msg' => 'Something Went Wrong'], 500);
                    // }
                    // exit();

        // $serial_value = \Opis\Closure\serialize([
        //     "zebra_apps"   => 'https://cutt.ly/pPusnB6',
        //     "android_link" => 'https://cutt.ly/2PusEz0',
        //     "ios_link"     => 'https://i.diawi.com/7fHENx'
        // ]);
        // echo $serial_value;
        // exit();
        $qr_url = $client_url.'/app-url?client_id='.$client_id;
        return view('app_download_page.download_app', compact('qr_url','apps_links'));
    }
}
