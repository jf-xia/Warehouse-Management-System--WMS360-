<?php


namespace App\Traits;


use App\Image;
use App\ProductDraft;
use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\EbayAccount;
use DB;


trait Ebay
{
    public function getCategoryWithOutParent($site_id){
        $url = Session::get('middleman').'api/get-category';
        $headers = [];
        $body =http_build_query(["site_id" => $site_id,"LevelLimit" => 1]) ;
        $categories = $this->curl($url,$headers,$body,'POST');
        $categories = json_decode($categories,true);
        return $categories;
    }

    public function getCategoryWithParent($site_id,$level,$parent_id){
        $url = Session::get('middleman').'api/get-category-parent';
        $headers = [];
        $body =http_build_query(["site_id" => $site_id,"LevelLimit" => $level,'CategoryParentID' => $parent_id]) ;
        $categories = $this->curl($url,$headers,$body,'POST');
        $categories = json_decode($categories,true);
        return $categories;
    }

    public function getImageVariation($product_draft_id){
        $counter = 0;
        $image_variation = '';
        $image_attribute = '';
        $base_url =App::make('url')->to('/').'/';
        $image_variation_array = array();
        $variation_image = DB::table('product_variation')->where('product_draft_id',$product_draft_id)->where('deleted_at',null)->select('variation_images','image_attribute')->groupBy('image_attribute')
            ->get();
        // dd($variation_image);
        if (isset($variation_image)){
            $attribute_data =  $variation_image[0]->image_attribute;
            if($attribute_data != null){
                foreach (\Opis\Closure\unserialize($attribute_data) as $key => $terms){
                    $image_attribute = $key;
                }
                $image_variation.='<Pictures>
                    <VariationSpecificName>'.$image_attribute.'</VariationSpecificName>';

                foreach ($variation_image as $value){
                    if($value->variation_images != null){
                        $variation_images = \Opis\Closure\unserialize($value->variation_images);
                        foreach (\Opis\Closure\unserialize($value->image_attribute) as $terms){
                            $image_variation.=  '<VariationSpecificPictureSet>
                            <VariationSpecificValue>'.'<![CDATA['.$terms.']]>'.'</VariationSpecificValue>';
                        }

                        if(is_array($variation_images) && count($variation_images) > 0){
                            foreach ($variation_images as $image_url){
                                $image_variation_array[$terms][] =$image_url;
                                $image_variation.='<PictureURL>'.$base_url.$image_url.'</PictureURL>';
                            }
                        }
                        $image_variation.='</VariationSpecificPictureSet>';
                    }

                }
                $this->ebay_variation_images[$image_attribute]=$image_variation_array;
                $image_variation .= '</Pictures>';
            }

//            foreach ($variation_image as $key1 => $value1){
//
//                if ($key1 == $image_attributes){
//
//                    foreach ($value1 as $key2 => $value2){
//
//                        $image_variation.=  '<VariationSpecificPictureSet>
//             <VariationSpecificValue>'.'<![CDATA['.$key2.']]>'.'</VariationSpecificValue>';
//
//                        foreach ($value2 as $value3){
//                            if(isset($value3)){
//                                $counter++;
//                            }
//                            if (!in_array($value2, $image_variation_array))
//                            {
//                                array_push($image_variation_array, $key2);
//                                $image_variation.='<PictureURL>'.$value3.'</PictureURL>';
//                            }
//                            break;
//                        }
//
//                        $image_variation.='</VariationSpecificPictureSet>';
//                    }
//                }
//
//            }


//            $image_variation .= '</Pictures>';
        }


//        if($counter == 0){
//            $image_variation = '';
//        }
        return $image_variation;
    }
    public function getMasterProductImagesXml($id){
        $result = Image::select('image_url')->where('draft_product_id',$id)->get();
        $image_array = json_decode($result);

        $pictures = "<PictureDetails>";
        foreach ($image_array as $image) {

            $pictures .='<PictureURL>'.asset($image->image_url).'</PictureURL>';
        }
        $pictures .= "</PictureDetails>";
        return $pictures;

    }
    public function curl($url,$header,$body,$method){
        $url = $url;
        $header = $header;
        $body = $body;
        $method = $method;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $header
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        return $response;
    }
    public function getEbaySessionKey($id){
        return 'ebay-'.$id;
    }
    public function getItemSpecifics($category_id,$ebay_access_token,$category_tree_id = 0){
        $url = 'https://api.ebay.com/commerce/taxonomy/v1/category_tree/'.$category_tree_id.'/get_item_aspects_fr_category?category_id='.$category_id;
        $headers = [
            'Authorization:Bearer '.$ebay_access_token,
            'Accept:application/json',
            'Content-Type:application/json'
        ];
        $body ='';

        $response = $this->curl($url,$headers,$body,'GET');
        $response =  \GuzzleHttp\json_decode($response,true);
        return $response;
    }
    public function getEbayToken($id,$session_key){
        $session_value = Session::get($session_key);
        if (isset($session_value)){
            if ($session_value['time'] > Carbon::now()){
               return $session_value['token'];
            }else{
                return $this->getToken($id,$session_key);
            }
        }else{
            return $this->getToken($id,$session_key);
        }
    }

    public function getToken($id,$session_key){
        $account_result = EbayAccount::with('developerAccount')->find($id);

        $clientID  = $account_result->developerAccount->client_id;
        $clientSecret  = $account_result->developerAccount->client_secret;

        $url = 'https://api.ebay.com/identity/v1/oauth2/token';
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret),

        ];

        $body = http_build_query([
            'grant_type'   => 'refresh_token',
            'refresh_token' => $account_result->refresh_token,
            'scope' => 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly',

        ]);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $headers
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        if (isset($response['access_token'])){
            $session_array = [
               'time' => Carbon::now()->addHour(2),
                'token'=> $response['access_token']
            ];
            Session::put($session_key,$session_array);
            return $response['access_token'];
        }else{
            return 'unathorize';
        }

    }
}
