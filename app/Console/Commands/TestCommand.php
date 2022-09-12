<?php

namespace App\Console\Commands;

use App\EbayMasterProduct;
use App\EbayProfile;
use App\EbayTemplate;
use App\EbayVariationProduct;
use App\Http\Controllers\CheckQuantity\CheckQuantity;
use App\ProductDraft;
use Automattic\WooCommerce\HttpClient\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Traits\StringConverter;
use App\EbayAccount;
use auth;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testcommand:test {test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will print loop';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        sleep(10);
        Log::info('sleep');
        $request = $this->argument('test');
        $arrayConverter = new StringConverter();
//        Log::info($sqlfile);
////        $request = $this->request;
////        $name = request->name;
////        dd($name);
////        $temp = $this->addArgument('test');
//
////        Log::info('test');
        $image_array = [];
        $newProfileImageArr = $request->newUploadImage;
        if(isset($request->newUploadImage) && count($request->newUploadImage) > 0){
            foreach($request->newUploadImage as $profileId => $images){
                $folderPath = 'uploads/product-images/';
                if(isset($newProfileImageArr[$profileId])){
                    foreach($images as $imageName => $imageContent){
                        if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){

                            $info = pathinfo($imageName);
                            $image_name =  basename($imageName,'.'.$info['extension']);
                            $ext = explode(".", $imageName);
                            $image_type = end($ext);
                            if($image_type == "webp"){
                                $ext = str_replace("webp","jpg",$image_type);
                                $name_str = $image_name . '.' . $ext;
                                $imageName = $name_str;
                            }
                            $updatedImageName = $this->base64ToImage($request->id, $imageName, $imageContent, $folderPath);
                            $image_array[$profileId][] = asset($folderPath.$updatedImageName);
                        }else{
                            $info = pathinfo($imageContent);
                            $image_name =  basename($imageContent,'.'.$info['extension']);
                            $ext = explode(".", $imageContent);
                            $image_type = end($ext);
                            if($image_type == "webp"){
                                $ext = str_replace("webp","jpg",$image_type);
                                $name_str = $image_name . '.' . $ext;
                                $imageContent = asset($folderPath.$name_str);
                            }
                            $image_array[$profileId][] = $imageContent;



                        }

                        // $imageName = $image->getClientOriginalName();
                        // $key = array_search($imageName,$newProfileImageArr[$profileId]);
                        // if($key !== FALSE){
                        //     $ImageArr[] = $imageName;
                        //     $name = $request->product_id.'-'.str_replace([' ',':','%'],'-',Carbon::now()->toDateTimeString());
                        //     $name .= str_replace(['&',' '],'-',$imageName);
                        //     $image->move('uploads/product-images/', $name);
                        //     $image_url = asset('uploads/product-images/' . $name);
                        //     $newProfileImageArr[$profileId][$key] = $image_url;
                        // }
                    }



                    // if($request->newUploadImage != null){
                    //     foreach($request->newUploadImage as $imageName => $imageContent){
                    //         if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                    //             $updatedImageName = $this->base64ToImage($id, $imageName, $imageContent, $folderPath);
                    //             $image_array[] = asset($folderPath.$updatedImageName);
                    //         }else{
                    //             $image_array[] = $imageContent;
                    //         }
                    //     }
                    // }





                    // else{
                    //     $newProfileImageArr[$profileId][$key] = 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482953.jpg';
                    // }

                    // foreach($request->newUploadImage as $imageName => $imageContent){
                    //     if(filter_var($imageContent, FILTER_VALIDATE_URL) === FALSE){
                    //         $updatedImageName = $this->base64ToImage($productDraft->id, $imageName, $imageContent, $folderPath);
                    //         $image_array[] = asset($folderPath.$updatedImageName);
                    //     }else{
                    //         $image_array[] = $imageContent;
                    //     }
                    // }
                }
            }
        }

        $request['image'] = $image_array;
        // echo '<pre>';
        // print_r($request['image']);
        // exit();

//        foreach ($request->profile as $profile){
//            echo $profile;
//        }
//        exit();


        //    echo "<pre>";
        //    print_r($request->all());
        //    exit();


        $pictures = '';
        $item_specifics = '';
        $variations ='';
        $attribute = '';
        $name_value = '';
        $image_variation = '';
        $ean = '';
        $galleryPlus = '';
        $subcategory = '';
        $category2 = null;
        $eps = '';
        $full_variation = null;

//        $template_result = 'this is a test product';

        if (isset($request->child_cat2[1])){
            foreach ($request->child_cat2 as $category_request){
                $category2_array =$this->stringConverter->separateStringToArray($category_request);// explode('/',$category_request);
                $category2 .= '>'.$category2_array[1];
            }
        }

        if (isset($request->item_specific)){
            foreach ($request->item_specific as $key=>$item_specific){
//            return gettype($key);
                //if ($item_specific !=null){
                $item_specifics .='<NameValueList>
				                    <Name>'.'<![CDATA['.$key.']]>'.'</Name>
				                    <Value>'.'<![CDATA['.$item_specific.']]>'.'</Value>
			                      </NameValueList>';
                //}

            }

            $item_specifics = '<ItemSpecifics>'.$item_specifics.'</ItemSpecifics>';
        }

        $variation_specifics = array();
        $master_product_find_result = ProductDraft::where('id' , $request->product_id)->first();
        if ($request->type == 'variable'){
            foreach ($request->productVariation as $product_variation){
                foreach (\Opis\Closure\unserialize($master_product_find_result->attribute) as $attribute_id => $attribute_array){

                    foreach ($attribute_array as $attribute_name => $terms_array){
//                echo "<pre>";
//                print_r($terms);
//                exit();
                        foreach ($terms_array as $terms){
                            $variation_specifics[$attribute_name][] =$terms["attribute_term_name"];
                            $variation_image[$attribute_name][$terms["attribute_term_name"]][] = $product_variation['image'];
                        }

                    }

                }
            }
        }


        $item_specific =\Opis\Closure\serialize($request->item_specific);
        $start_price = '<StartPrice>'.$request->start_price.'</StartPrice>';
        if ($request->type == 'variable'){
            $variation_specifics =\Opis\Closure\serialize($variation_specifics);
            $variation_image = \Opis\Closure\serialize($variation_image);
            $start_price = '';
        }

        if ($request->condition_id){

            $condition = $arrayConverter->separateStringToArray($request->condition_id);

        }
        if (isset($request->last_cat2_id)){
            $subcategory = '<SecondaryCategory>
      <CategoryID>'.$request->last_cat2_id.'</CategoryID>
    </SecondaryCategory>';
        }else{
            $subcategory = '';
        }

        if ($request->eps == 'Vendor'){
            $eps = '<PictureDetailsType>Vendor</PictureDetailsType>';
        }else{
            $eps = '';
        }


        foreach ($request->profile as $profile){
            $pictures ='';
            $profile_info = EbayProfile::find($profile);
            $tracker_array = array();
            $tracker_array['title_flag'] = $request->title_flag[$profile] ?? 0;
            $tracker_array['description_flag'] = $request->description_flag[$profile] ?? 0;
            $tracker_array['image_flag'] = $request->image_flag[$profile] ?? 0;
            $tracker_array['feeder_flag'] = $request->custom_feeder_flag[$profile] ?? 0;

            $name = $request->name[$profile];
            $description = $request->description[$profile];
            $images = $request->image[$profile];
            if ($request->type == 'variable'){
                $full_variation = $this->getFullVariation($request->productVariation,$request->custom_feeder_quantity[$profile] ?? 0,$request->custom_feeder_flag[$profile] ?? 0,$request->attribute,$request->image_attribute,$request->variation_image);

            }else{
                $ean = $request->productVariation[0]['ean'] ?? 'Does not apply';
                $full_variation = '<ProductListingDetails><EAN>'.$ean.'</EAN></ProductListingDetails><SKU>'.'<![CDATA['.$request->productVariation[0]['sku'].']]>'.'</SKU>';
            }

//          $product_result = ProductDraft::with(['ProductVariations','images'])->where('id',$request->product_id )->get();
            $template_result =  EbayTemplate::find($profile_info->template_id);
            $template_name = substr($template_result->template_file_name, 0, strpos($template_result->template_file_name, '.'));
            $template_result = view('ebay.all_templates.'.$template_name,compact('name','description','images'));

            $ebay_access_token = $this->getAuthorizationToken($profile_info->account_id);


//            if (isset($profile_info->store_id)){
//                $store_one = $profile_info->store_id;
//                //$store_one = explode("/", $store_one);
//                //(int)$store = $store_one[0];
//                $final_store='<StoreCategoryID>'.$store_one.'</StoreCategoryID>';
//
//            }else{
//                $final_store='';
//            }
//            if ($profile_info->store2_id != null){
//                $store_two = $profile_info->store2_id;
//                //$store_two = explode("/", $store_two);
//                //(int)$store2 = $store_two[0];
//                $final_store2='<StoreCategory2ID>'.$store_two.'</StoreCategory2ID>';
//            }else{
//                $final_store2= '';
//            }
            if (isset($request->store_id[$profile])){
                $store_one = $arrayConverter->separateStringToArray($request->store_id[$profile]);
                (int)$store = $store_one[0];
                $final_store='<StoreCategoryID>'.$store.'</StoreCategoryID>';

            }else{
                $final_store='';
            }
            if (isset($request->store2_id[$profile])){
                $store_two =$arrayConverter->separateStringToArray($request->store2_id[$profile]);
                (int)$store2 = $store_two[0];
                $final_store2='<StoreCategory2ID>'.$store2.'</StoreCategory2ID>';
            }else{
                $final_store2= '';
            }

            if(isset($request->image[$profile])){
                foreach ($request->image[$profile] as $image){

                    $pictures .='<PictureURL>'.'<![CDATA['.$image.']]>'.'</PictureURL>';
                }
            }else{
                $pictures .='<PictureURL>'.'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-no-image-available-icon-flat-vector-illustration-132482930.jpg'.'</PictureURL>';
            }
            if (isset($request->galleryPlus[$profile])){
                $galleryPlus = '<GalleryType>Plus</GalleryType>';
            }else{
                $galleryPlus = '';
            }

            if($request->condition_id == 1000){
                $condition_des = '';
            }else{
                $condition_des = $request->condition_description;
            }

            // echo $condition_des;
            // exit();


            $body = '<?xml version="1.0" encoding="utf-8"?>
<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
	<ErrorLanguage>en_US</ErrorLanguage>
	<WarningLevel>High</WarningLevel>
	<Item>
		<Country>'.$profile_info->country.'</Country>
		<Currency>'.$profile_info->currency.'</Currency>
		<DispatchTimeMax>3</DispatchTimeMax>
		<ListingDuration>'.$profile_info->duration.'</ListingDuration>
		<ListingType>FixedPriceItem</ListingType>
		<ConditionID>'.$condition[0].'</ConditionID>
		<ConditionDescription>'.$condition_des.'</ConditionDescription>
		<PostalCode>'.$profile_info->post_code.'</PostalCode>
		<PrimaryCategory>
			<CategoryID>'.$profile_info->category_id.'</CategoryID>
		</PrimaryCategory>
		'.$subcategory.'
		<Title>'.'<![CDATA['.$request->name[$profile].']]>'.'</Title>
		<SubTitle>'.'<![CDATA['.$request->subtitle[$profile].']]>'.'</SubTitle>
		<Description>'.'<![CDATA['.$template_result.']]>'.'</Description>
		'.$start_price.'
		<PictureDetails>'.$galleryPlus. $pictures
//			<PictureURL>https://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i22.ebayimg.com/01/i/04/8e/53/69_1_sbl.JPG</PictureURL>
//			<PictureURL>https://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
                .$eps.'</PictureDetails>


			'.$item_specifics.'
         <Storefront>
         '.$final_store.$final_store2.'


        </Storefront>
        '.$full_variation.'

		  <!-- If the seller is subscribed to Business Policies, use the <SellerProfiles> Container
		     instead of the <ShippingDetails>, <PaymentMethods> and <ReturnPolicy> containers.
         For help, see the API Reference for Business Policies:
		     https://developer.ebay.com/Devzone/business-policies/CallRef/index.html -->

       <SellerProfiles>
      		<SellerShippingProfile>
       			 <ShippingProfileID>'.$profile_info->shipping_id.'</ShippingProfileID>
    		  	</SellerShippingProfile>
      		<SellerReturnProfile>
        			<ReturnProfileID>'.$profile_info->return_id.'</ReturnProfileID>
      		</SellerReturnProfile>
      		<SellerPaymentProfile>
        			<PaymentProfileID>'.$profile_info->payment_id.'</PaymentProfileID>
      		</SellerPaymentProfile>
       </SellerProfiles>
	</Item>
</AddFixedPriceItemRequest>';
// return $body;
            //$logInsertData = $this->paramToArray(url()->full(),'Create Ebay product','Ebay',$profile_info->account_id,$body,null,Auth::user()->name,null,null, \Illuminate\Support\Carbon::now(),);
            $url = 'https://api.ebay.com/ws/api.dll';

            $headers = [
                'X-EBAY-API-SITEID:'.$profile_info->site_id,
                'X-EBAY-API-COMPATIBILITY-LEVEL:967',
                'X-EBAY-API-CALL-NAME:AddFixedPriceItem',
                'X-EBAY-API-IAF-TOKEN:'.$ebay_access_token,

            ];

//                            echo "<pre>";
//                print_r($store2);
//            echo "<pre>";
//                print_r($body);
//                exit();

            $result = $this->curl($url,$headers,$body,'POST');
            $result =simplexml_load_string($result);
            $result = json_decode(json_encode($result),true);

            if (isset($result['ItemID'])){
                $campaign_array = array();
                //$updateResponse = $this->updateResponse('response_data',$result);
//                if (1==1){
//                sleep(15);
//                //        campaign starts
//                $url = 'https://api.ebay.com/sell/marketing/v1/ad_campaign/'.$request->campaign_id.'/bulk_create_ads_by_listing_id';
//                $headers = [
//                    'Authorization:Bearer '.$ebay_access_token,
//                    'Accept:application/json',
//                    'Content-Type:application/json'
//                ];
//                $body ='{
//                            "requests": [
//                                {
//                                    "bidPercentage": "'.$request->bid_rate.'",
//                                    "listingId": "'.(string)$result['ItemID'].'"
//                                }
//                            ]
//                        }';
//                $campaigns = $this->curl($url,$headers,$body,'POST');
//                $campaigns = \GuzzleHttp\json_decode($campaigns);

                $campaign_array = array();
                if(isset($request->campaign_id[$profile]) && isset($request->bid_rate[$profile])){
                    $campaign_array = [
                        "campaignId" =>$request->campaign_id[$profile],
                        "bidPercentage" => $request->bid_rate[$profile]
                    ];
                }

//        campaign ends
                if (isset($request->image[$profile])){
                    $mater_images = \Opis\Closure\serialize($request->image[$profile]);
                }else{
                    $mater_images = '';
                }
//                echo "<pre>";
//                print_r($campaign_array);
//                exit();
                $ebayMasterPID = EbayMasterProduct::where('id', $request->p_id)->first();
                if($ebayMasterPID){
                    $ebay_permanent_delete = EbayMasterProduct::where('id',$ebayMasterPID->id)->forceDelete();
                }
                $master_product_result = EbayMasterProduct::create(['item_id' => $result['ItemID'] ,'account_id' => $profile_info->account_id,'master_product_id' => $request->product_id,'site_id' => $profile_info->site_id ?? null, 'creator_id' => Auth::user()->id ?? null,'campaign_status' => isset($request->campaign_checkbox) ? 0 : 1,'campaign_data'=> isset($request->campaign_checkbox) ? \Opis\Closure\serialize($campaign_array) : '',
                    'title' => $request->name[$profile],'description' =>$request->description[$profile],'item_description' => $template_result,'variation_specifics' => isset($variation_specifics) ?  $variation_specifics : null,'master_images' => $mater_images,'variation_images' => $variation_image ?? null,'dispatch_time' => 3,
                    'product_type' => 'FixedPrice','product_status' => 'Active','start_price' => $request->start_price ?? 0.0,'condition_id' => $condition[0],'condition_name' => $condition[1],'condition_description' => $condition_des ?? '', 'category_id' => $profile_info->category_id, 'sub_category_id' => $request->last_cat2_id,'category_name' => $profile_info->category_name,'sub_category_name' => isset($category2) ? $category2 : $request->sub_category_name,'store_id' => $store ?? null,
                    'store_name' => $store_one[1] ?? null,'store2_id' => $store2 ?? null,'currency' => $profile_info->currency,'store2_name' => $store_two[1] ?? null,'duration' => $profile_info->duration,'location' => $profile_info->location,'country' => $profile_info->country,'post_code' => $profile_info->post_code,
                    'item_specifics' => $item_specific,'shipping_id' => $profile_info->shipping_id,'return_id' => $profile_info->return_id,'payment_id' => $profile_info->payment_id,'image_attribute'=>$request->image_attribute ?? '','profile_id' => $profile,'draft_status' => \Opis\Closure\serialize($tracker_array),'custom_feeder_quantity'=>$request->custom_feeder_quantity[$profile],'campaign' => $campaign_array,'subtitle' => $request->subtitle[$profile] ?? '', "galleryPlus" => $request->galleryPlus[$profile] ?? 0,'eps' => $request->eps ?? '','type' => $request->type]);


                foreach ($request->productVariation as $key => $product_variation){
                    $variation_specifics = null;
                    if($request->type == 'variable'){
                        foreach ($product_variation["attribute"] as $attribute){

                            $variation_specifics[$attribute["attribute_name"]] =$attribute["terms_name"];
                        }
                    }

                    $variation_specifics = \Opis\Closure\serialize($variation_specifics);
                    $ebay_variation_result = EbayVariationProduct::create(['ebay_master_product_id' => $master_product_result->id,'master_variation_id' => $product_variation['variation_id'],
                        'sku' => $product_variation['sku'],'variation_specifics' => $variation_specifics, 'start_price' => $product_variation['start_price'],'rrp'=> $product_variation['rrp'],'quantity' => $product_variation['quantity'],
                        'ean' => $product_variation['ean']]);
                }



            }else{
                return $result;//redirect('ebay-master-product-list')->with('error',$result['Errors']['LongMessage']);
            }
        }
        Log::info('done');


    }
    public function getFullVariation($variations,$quantity,$flag,$attributes,$image_attributes,$variation_image){
        $variations = $this->getProductVariation($variations,$quantity,$flag);
        $name_value = $this->getNameValue($attributes);
        $image_variation = $this->getImageVariation($image_attributes,$variation_image);
        $full_variation = '<Variations>
			<VariationSpecificsSet>
				'.$name_value.'
			</VariationSpecificsSet>
			'.$variations.$image_variation.'

		</Variations>';
        return $full_variation;
    }
    public function getNameValue($attributes){

        $name_value = '';
        $name_value_array = array();
        foreach ($attributes as $key => $values){
            $name_value .='<NameValueList>
                            <Name>'.$key.'</Name>';
            foreach ($values as $value){
                if (!in_array($value, $name_value_array))
                {
                    array_push($name_value_array, (string)$value);
                    $name_value .=  '<Value>'.$value.'</Value>';
                }
            }
            $name_value .= '</NameValueList>';
        }

        return $name_value;
    }
    public function getImageVariation($image_attributes,$variation_image){
        $counter = 0;
        $image_variation = '';
        $image_variation_array = array();

        if ($image_attributes != null && isset($variation_image)){
            $image_variation.='<Pictures>
				<VariationSpecificName>'.$image_attributes.'</VariationSpecificName>';

            foreach ($variation_image as $key1 => $value1){

                if ($key1 == $image_attributes){

                    foreach ($value1 as $key2 => $value2){

                        $image_variation.=  '<VariationSpecificPictureSet>
					<VariationSpecificValue>'.'<![CDATA['.$key2.']]>'.'</VariationSpecificValue>';

                        foreach ($value2 as $value3){
                            if(isset($value3)){
                                $counter++;
                            }
                            if (!in_array($value2, $image_variation_array))
                            {
                                array_push($image_variation_array, $key2);
                                $image_variation.='<PictureURL>'.$value3.'</PictureURL>';
                            }
                            break;
                        }

                        $image_variation.='</VariationSpecificPictureSet>';
                    }
                }

            }


            $image_variation .= '</Pictures>';
        }


        if($counter == 0){
            $image_variation = '';
        }
        return $image_variation;
    }

    public function getProductVariation($productVariations,$feeder_quantity,$flag){
        $variations='';
        $quantity='';
        foreach ($productVariations as $product_variation){
            if ($flag){
                $ebay = new CheckQuantity();
                $shelf_quantity = $ebay->getShelfQuantity($product_variation["variation_id"]);
                if ($shelf_quantity >= $feeder_quantity){
                    $quantity = $feeder_quantity;
                }else{
                    $quantity = $shelf_quantity;
                }

            }else{
                $quantity = $product_variation['quantity'];
            }
            $attribute = '';

            foreach ($product_variation["attribute"] as $product_variation_attribute){
                $attribute .= '<NameValueList>
						<Name>'.'<![CDATA['.$product_variation_attribute["attribute_name"].']]>'.'</Name>
						<Value>'.'<![CDATA['.$product_variation_attribute["terms_name"].']]>'.'</Value>
					</NameValueList>';
            }
            if (isset($product_variation['ean'])){
                $ean = $product_variation['ean'];
            }else{
                $ean = 'Does not apply';
            }
            $variations .= '<Variation>
                <DiscountPriceInfo>
                  <OriginalRetailPrice>'.$product_variation['rrp'].'</OriginalRetailPrice>

                </DiscountPriceInfo>
				<SKU>'.'<![CDATA['.$product_variation['sku'].']]>'.'</SKU>
				<StartPrice>'.$product_variation['start_price'].'</StartPrice>
				<Quantity>'.$quantity.'</Quantity>
				<VariationProductListingDetails>
                <EAN>'. $ean .'</EAN>

                </VariationProductListingDetails>
				<VariationSpecifics>'
                .$attribute.'
				</VariationSpecifics>
			</Variation>';
        }
        return $variations;
    }
    public function getAuthorizationToken($id){
        $account_result = EbayAccount::where('id',$id)->with('developerAccount')->get()->first();

        $clientID  = $account_result->developerAccount->client_id;
        $clientSecret  = $account_result->developerAccount->client_secret;

//dd($token_result->authorization_token);
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
        //dd($response);
        /// ////////////////////////////// end

        return $response['access_token'];
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

}
