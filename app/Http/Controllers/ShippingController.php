<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Channel\ChannelFactory;
use Carbon\Carbon;
use App\Order;
use App\CatalogueAttributeTerms;
use App\ItemAttributeTermValue;

class ShippingController extends Controller
{
    protected $channel = ChannelFactory::DPD;

    public function __construct(){
        $this->middleware('auth');
    }

    public function curl_request_send($url, $method, $post_data = null, $http_header = []){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => $http_header,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function geoClient(){
        return 'account/114359';
    }

    public function geoSession(){
        if(Session::has('geo_session') && (Session::get('generate_geo_session_time') > Carbon::now()->subHours(23))){
            return Session::get('geo_session');
        }else{
            $url = "https://api.dpd.co.uk/user/?action=login";
            $post_data = null;
            $method = "POST";
            $http_header = array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic '.base64_encode('TOPBRANDOUTLET:TOPBRANDOUTLET2022'),
            );
            $geoSessionInfo = $this->curl_request_send($url, $method, $post_data, $http_header);
            $decodeGeoSessionInfo = json_decode($geoSessionInfo, JSON_PRETTY_PRINT);
            //dd($decodeGeoSessionInfo);
            if($decodeGeoSessionInfo['error'] == null){
                $geoSession = $decodeGeoSessionInfo['data']['geoSession'];
                Session::put('geo_session',$geoSession);
                Session::put('generate_geo_session_time',Carbon::now());
                return $geoSession;
            }
        }
    }

    public function getShippingCountry($countryCode){
        $url = "https://api.dpd.co.uk/shipping/country/".$countryCode;
        $post_data = null;
        $method = "GET";
        $http_header = array(
            'Accept: application/json',
            'GeoClient: '.$this->geoClient(),
            'GeoSession: '.$this->geoSession()
        );
        $countryResult = $this->curl_request_send($url, $method, $post_data, $http_header);
        $country = json_decode($countryResult, JSON_PRETTY_PRINT);
        if($country['data'] != null){
            return $country['data']['country']['isEUCountry'];
        }
    }

    public function getCatalogueAttributeTerm($master_catalogue_id){
        $catalogueAttributeTerms = CatalogueAttributeTerms::where('catalogue_id',$master_catalogue_id)->pluck('attribute_term_id')->toArray();
        $mappingDatas = [];
        $mapFields = [];
        if(count($catalogueAttributeTerms) > 0){
            //$channelInfo = $this->getChannelInfo($this->channel);
            $channelInfo = $this->channel;
            if($channelInfo){
                $mappingDatas = ItemAttributeTermValue::withAndWhereHas('mappingFields', function($q){
                    $q->where('mapping_field','!=',null);
                })
                ->whereIn('id',$catalogueAttributeTerms)->get();
                if(count($mappingDatas) > 0){
                    foreach($mappingDatas as $mapD){
                        $mapFields[$mapD->mappingFields->mapping_field] = $mapD->item_attribute_term_value;
                    }
                }
            }
        }
        return $mapFields;
    }

    public function getShippingCost($orderInfo){
        return $orderInfo->shipping_method ? ((@unserialize($orderInfo->shipping_method) !== false) ? (unserialize($orderInfo->shipping_method)['total'] ?? 0.0) : json_decode($orderInfo->shipping_method)[0]->total ?? $orderInfo->shipping_method ?? 0.0) : 0.0;
    }

    public function fetchDPDAvailableInfo(Request $request){
        try{
            $orderInfo = Order::with(['orderedProduct.variation_info.product_draft.woowmsCategory'])->where('order_number',$request->orderNumber)->first();
            if(!$orderInfo){
                return response()->json(['type'=>'error','msg' => 'No Order Found']);
            }
            $collectionCountry = $request->collectionCountry;
            $collectionPostcode = str_replace(' ','',$request->collectionPostcode);
            $deliveryCountry = $orderInfo->shipping_country;
            $deliveryPostcode = ($orderInfo->shipping_country == 'US') ? explode('-',str_replace(' ','',$orderInfo->shipping_post_code))[0] : str_replace(' ','',$orderInfo->shipping_post_code);
            $url = "https://api.dpd.co.uk/shipping/network?collectionDetails.address.postcode=".$collectionPostcode."&collectionDetails.address.countryCode=".$collectionCountry."&deliveryDetails.address.countryCode=".$deliveryCountry."&deliveryDetails.address.postcode=".$deliveryPostcode."";
            $post_data = null;
            $method = "GET";
            $http_header = array(
                'Accept: application/json',
                'GeoClient: '.$this->geoClient(),
                'GeoSession: '.$this->geoSession()
            );
            $serviceResults = $this->curl_request_send($url, $method, $post_data, $http_header);
            $services = json_decode($serviceResults, JSON_PRETTY_PRINT);
            $exportReason = '';
            $invoiceTermType = '';
            $parcelProdudcts = '';
            $totalWeight = 0;
            if(count($orderInfo->orderedProduct) > 0){
                $i = 1;
                foreach($orderInfo->orderedProduct as $product){
                    if($product->variation_info && $i <= 3){
                        $refValue = $product->variation_info->sku ?? '';
                        if($i == 1){
                            $refOrderValue = $orderInfo->order_number;
                            $invoiceTermType .= '<div class="form-group col-md-6">
                                <label for="reference_'.$i.'">Reference '.$i.'</label>
                                <input type="text" class="form-control" name="reference_'.$i.'" value="'.( $refOrderValue ?? '').'">
                            </div>';
                            $i++;
                        }
                        $invoiceTermType .= '<div class="form-group col-md-6">
                            <label for="reference_'.$i.'">Reference '.$i.'</label>
                            <input type="text" class="form-control" name="reference_'.$i.'" value="'.( $refValue ?? '').'">
                        </div>';
                        $i++;
                    }
                }
            }
            if(($orderInfo->shipping_country != 'GB') && ($orderInfo->shipping_country != 'United Kingdom')){
                $exportReason .= '<label for="export_reason" class="required">Invoice Export Reason</label>
                <select class="form-control select2" name="export_reason">
                    <option value="01">Sale</option>
                    <option value="02">Return/Replacement (applicable for Air services only)</option>
                    <option value="03">Gift</option>
                </select>';

                $invoiceTermType .= '<div class="form-group col-md-6">
                <label for="invoice_terms_of_delivery" class="required">Invoice Terms Of Delivery</label>
                <select class="form-control select2" name="invoice_terms_of_delivery">
                    <option value="DAP">DAP</option>
                    <option value="DT1">DT1</option>
                </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="invoice_type" class="required">Invoice Type</label>
                    <select class="form-control select2" name="invoice_type">
                        <option value="1">Proforma</option>
                        <option value="2" selected>Commercial</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="invoice_reference">Invoice Reference</label>
                    <input type="text" class="form-control" name="invoice_reference" value="'.$orderInfo->order_number.'">
                </div>
                <div class="form-group col-md-6">
                    <label for="delivery_instruction">Delivery Instruction</label>
                    <input type="text" class="form-control" name="delivery_instruction" value="'.($orderInfo->buyer_message ?? '').'">
                </div>
                <div class="form-group col-md-6">
                    <label for="total_price">Total Price</label>
                    <input type="text" class="form-control" name="total_price" id="total_price" value="'.($orderInfo->total_price ?? '').'" required>
                </div>';
                if($orderInfo->shipping_country == 'US'){
                    $invoiceTermType .= '<div class="form-group col-md-6">
                    <label for="invoice_customs_number">Invoice Customs Number</label>
                    <input type="text" class="form-control" name="invoice_customs_number">
                </div>';
                }
                if($orderInfo->shipping_country == 'AU'){
                    $invoiceTermType .= '<div class="form-group col-md-6">
                    <label for="shipper_destination_tax_id" class="required">Shipper Destination Tax Id</label>
                    <input type="text" class="form-control" name="shipper_destination_tax_id">
                </div>
                <div class="form-group col-md-6">
                    <label for="vat_paid" class="required">Vat Paid</label>
                    <select class="form-control select2" name="vat_paid">
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </select>
                </div>';
                }
                $invoiceTermType .= '<div class="form-group col-md-6  pt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show_shipping_cost">
                            <label class="form-check-label" for="show_shipping_cost">
                                Show Shipping Cost(<span id="order_shipping_cost">'.$this->getShippingCost($orderInfo).')
                            </label>
                        </div>
                    </div>';
                    $parcelProdudcts .= '<div class="col-md-12 d-flex justify-content-between">
                    <strong>Total Parcel Products ('.count($orderInfo->orderedProduct).')</strong>
                    <strong>Total Price Without Shipping Cost (<span id="order_total_without_shipping">'.($orderInfo->total_price - $this->getShippingCost($orderInfo)).'</span>)</strong>
                    </div>';
                    if(count($orderInfo->orderedProduct) > 0){
                        foreach($orderInfo->orderedProduct as $product){
                            if($product->variation_info){
                                $itemAttributeInfo = $this->getCatalogueAttributeTerm($product->variation_info->product_draft->id);   
                                $parceIndex = $product->variation_info->id;
                                $notFoundValue = '';
                                $parcelProdudcts .= '<div class="form-row border m-2 p-2">
                                        <div class="form-group col-md-12">
                                            <label for="item_description" class="required">Item Description</label>
                                            <input type="text" class="form-control" name="item_description['.$parceIndex.']" value="'.($product->name ?? $notFoundValue).'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="sku">SKU</label>
                                            <input type="text" class="form-control" name="sku['.$parceIndex.']" value="'.($product->variation_info->sku ?? $notFoundValue).'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="type_description">Type Description</label>
                                            <input type="text" class="form-control" name="type_description['.$parceIndex.']" value="'.($product->variation_info->product_draft->woowmsCategory->category_name ?? $notFoundValue).'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="country_of_origin" class="required">Country Of Origin</label>
                                            <input type="text" class="form-control" name="country_of_origin['.$parceIndex.']" value="'.($itemAttributeInfo['countryOfOrigin'] ?? 'GB').'" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fabric">Fabric</label>
                                            <input type="text" class="form-control" name="fabric['.$parceIndex.']" value="'.($itemAttributeInfo['productFabricContent'] ?? $notFoundValue).'">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="hs_code" class="required">HS Code</label>
                                            <input type="text" class="form-control" name="hs_code['.$parceIndex.']" value="'.($itemAttributeInfo['productHarmonisedCode'] ?? $notFoundValue).'" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="number_of_items" class="required">Number Of Items</label>
                                            <input type="text" class="form-control number_of_item" name="number_of_items['.$parceIndex.']" value="'.($product->quantity ?? $notFoundValue).'" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="unit_weight" class="required">Unit Weight</label>
                                            <input type="text" class="form-control unit_weight" name="unit_weight['.$parceIndex.']" value="'.($itemAttributeInfo['unitWeight'] ?? $notFoundValue).'" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="unit_value" class="required">Unit Value</label>
                                            <input type="text" class="form-control unit_value" name="unit_value['.$parceIndex.']" value="'.($product->price ?? $notFoundValue).'" required>
                                        </div>
                                    </div>';
                                $totalWeight += ($product->quantity * ($itemAttributeInfo['unitWeight'] ?? 0));
                            }
                        }
                    }
            }else{
                if(count($orderInfo->orderedProduct) > 0){
                    foreach($orderInfo->orderedProduct as $product){
                        $itemAttributeInfo = $this->getCatalogueAttributeTerm($product->variation_info->product_draft->id);
                        $totalWeight += ($product->quantity * ($itemAttributeInfo['unitWeight'] ?? 0));
                    }
                }
            }
            if($services['data'] != null){
                $shippingDetails = '';
                
                if(count($services['data']) > 0){
                    $shippingDetails .= '<div class="col-md-6">
                                <p>Customer Name: '.$orderInfo->shipping_user_name.'</p>
                                <p>Address Line 1: '.$orderInfo->shipping_address_line_1.'</p>
                                <p>Address Line 2: '.$orderInfo->shipping_address_line_2.'</p>
                                <p>Address Line 3: '.$orderInfo->shipping_address_line_3.'</p>
                            </div>
                            <div class="col-md-6">
                                <p>City: '.$orderInfo->shipping_city.'</p>
                                <p>County: '.$orderInfo->shipping_county.'</p>
                                <p>Postcode: '.$orderInfo->shipping_post_code.'</p>
                                <p>Country: '.$orderInfo->shipping_country.'</p>
                            </div>';
                    if(($orderInfo->shipping_country != 'GB') && ($orderInfo->shipping_country != 'United Kingdom')){
                        $serviceOptions = '<option value="1^80">DPD Direct</option>';
                    }else {
                        $serviceOptions = '<option value="">Select Service</option>';
                        foreach($services['data'] as $service){
                            $invoiceStatus = $service["invoiceRequired"] ? '(Invoice Required)' : '';
                            $serviceOptions .= '<option value="'.$service['network']['networkCode'].'">'.$service['network']['networkDescription'].' '.$invoiceStatus.'</option>';
                        }
                    }
                }
            }else{
                return response()->json(['type'=>'error','msg' => $services['error']['errorMessage']]);
            }
            return response()->json([
                'type'=>'success',
                'order_info' => $orderInfo,
                'services' => $serviceOptions,
                'shipping_info' => $shippingDetails,
                'export_reason' => $exportReason,
                'invoice_term_type' => $invoiceTermType,
                'parcel_products' => $parcelProdudcts,
                'total_weight' => $totalWeight,
                'parcel_description' => $itemAttributeInfo['parcelDescription'] ?? ($orderInfo->orderedProduct[0] ? ($orderInfo->orderedProduct[0]->variation_info->product_draft->woowmsCategory->category_name ?? '') : '')
            ]);
        }catch(\Exception $exception){
            return response()->json(['type'=>'error','msg' => 'Something Went Wrong.']);
        }
    }

    public function createDpdOrder(Request $request){
        try{
            if($request['order_id_for_dpd'] == null){
                return response()->json(['type' => 'error','msg'=> 'Order Not Found. Please Contact With Support.']);
            }
            $orderInfo = Order::with(['orderedProduct.variation_info.product_draft'])->find($request['order_id_for_dpd']);
            if($orderInfo){
                $orderData = [];
                $orderData['jobId'] = null;
                $orderData['collectionOnDelivery'] = null;
                $invoiceShipperOrcollectionDetails = [
                    'contactDetails' => [
                        'contactName' => 'MAHBUB RABBANI',
                        'telephone' => '07477979936'
                    ],
                    'address' => [
                        'organisation' => 'TOP BRAND OUTLET LTD',
                        'countryCode' => 'GB',
                        'postcode' => 'DA9 9EZ',
                        'street' => '35 KNOCKHALL ROAD',
                        'locality' => '',
                        'town' => 'GREENHITHE',
                        'county' => 'KENT'
                    ]
                ];
                $invoiceDeliveryOrDeliveryDetails = [
                    'contactDetails' => [
                        'contactName' => $orderInfo->shipping_user_name,
                        'telephone' => $orderInfo->shipping_phone
                    ],
                    'address' => [
                        'organisation' => $orderInfo->shipping_user_name,
                        'countryCode' => $orderInfo->shipping_country,
                        'postcode' => ($orderInfo->shipping_country == 'US') ? explode('-',$orderInfo->shipping_post_code)[0] : $orderInfo->shipping_post_code,
                        'street' => $orderInfo->shipping_address_line_1,
                        'locality' => $orderInfo->shipping_address_line_2,
                        'town' => $orderInfo->shipping_city,
                        'county' => $orderInfo->shipping_county
                    ]
                ];
                $forConsignmentCollectiondetails = $invoiceShipperOrcollectionDetails;
                $forConsignmentDeliverydetails = $invoiceDeliveryOrDeliveryDetails;
                $shippingCost = 0;
                if(($orderInfo->shipping_country != 'GB') && ($orderInfo->shipping_country != 'United Kingdom')){
                    $shippingCost = $this->getShippingCost($orderInfo);
                    $orderData['generateCustomsData'] = 'Y';
                    if($orderInfo->shipping_country == 'US'){
                        $orderData['invoice']['invoiceCustomsNumber'] = $request['invoice_customs_number'] ?? null;
                    }
                    $invoiceShipperOrcollectionDetails['valueAddedTaxNumber'] = 'GB324746791';
                    $invoiceShipperOrcollectionDetails['eoriNumber'] = 'GB324746791000';
                    $invoiceDeliveryOrDeliveryDetails['valueAddedTaxNumber'] = '';
                    $invoiceDeliveryOrDeliveryDetails['eoriNumber'] = '';
                    $invoiceDeliveryOrDeliveryDetails['pidNumber'] = '';
                    $orderData['invoice'] = [
                        'invoiceExportReason' => $request['export_reason'],
                        'invoiceTermsOfDelivery' => $request['invoice_terms_of_delivery'],
                        'invoiceReference' => $request['invoice_reference'] ?? null,
                        'invoiceType' => $request['invoice_type'],
                        'shippingCost' => $request['show_shipping_cost'] ? $shippingCost : '',
                        'invoiceShipperDetails' => $invoiceShipperOrcollectionDetails,
                        'invoiceDeliveryDetails' => $invoiceDeliveryOrDeliveryDetails,
                    ];
                    $parcelProducts = [];
                    if(count($orderInfo->orderedProduct) > 0){
                        foreach($orderInfo->orderedProduct as $product){
                            if($product->variation_info){
                                $itemAttributeInfo = $this->getCatalogueAttributeTerm($product->variation_info->product_draft->id);
                                $parceIndex = $product->variation_info->id;
                                $parcelProducts[] = [
                                    'productCode' => $request['sku['.$parceIndex.']'],
                                    'productTypeDescription' => $request['type_description['.$parceIndex.']'],
                                    'productItemsDescription' => $request['item_description['.$parceIndex.']'],
                                    'productFabricContent' => $request['fabric['.$parceIndex.']'],
                                    'countryOfOrigin' => $request['country_of_origin['.$parceIndex.']'],
                                    'productHarmonisedCode' => $request['hs_code['.$parceIndex.']'],
                                    'unitWeight' => $request['unit_weight['.$parceIndex.']'],
                                    'numberOfItems' => $request['number_of_items['.$parceIndex.']'],
                                    'unitValue' => $request['unit_value['.$parceIndex.']'],
                                    'productUrl' => ''
                                ];
                            }
                        }
                    }
                    
                    $parcel[] = [
                        'packageNumber' => 1,
                        'parcelProduct' => $parcelProducts,
                    ];
                    
                    
                }else{
                    $orderData['invoice'] = null;
                    $parcel = [];
                }

                $orderData['collectionDate'] = date('Y-m-d H:i:s',strtotime($request['shipping_date'].'+9 hours'));
                $orderData['consolidate'] = false;
                $forConsignmentDeliverydetails['notificationDetails']['email'] = $orderInfo->customer_email ?? '';
                $forConsignmentDeliverydetails['notificationDetails']['mobile'] = $orderInfo->shipping_phone ?? '';
                $orderData['consignment'][] = [
                    'consignmentNumber' => null,
                    'consignmentRef' => null,
                    'parcel' => $parcel,
                    'collectionDetails' => $forConsignmentCollectiondetails,
                    'deliveryDetails' => $forConsignmentDeliverydetails,
                    'networkCode' => $request['services'],
                    'numberOfParcels' => $request['number_of_parcel'],
                    'totalWeight' => $request['total_weight'],
                    'shippingRef1' => $request['reference_1'] ?? '',
                    'shippingRef2' => $request['reference_2'] ?? '',
                    'shippingRef3' => $request['reference_3'] ?? '',
                    'customsValue' => $orderInfo->total_price - $shippingCost,
                    'deliveryInstructions' => $request['delivery_instruction'],
                    'parcelDescription' => $request['parcel_description'],
                    'liabilityValue' => null,
                    'liability' => false,
                ];
                if($orderInfo->shipping_country == 'AU'){
                    $orderData['consignment'][0]['shippersDestinationTaxId'] = $request['shipper_destination_tax_id'];
                    $orderData['consignment'][0]['vatPaid'] = $request['vat_paid'];
                }else{
                    $isEUCountry = $this->getShippingCountry($orderInfo->shipping_country);
                    if($isEUCountry){
                        $orderData['consignment'][0]['shippersDestinationTaxId'] = 'IM2760000742';
                        $orderData['consignment'][0]['vatPaid'] = 'Y';
                    }
                }
                $url = "https://api.dpd.co.uk/shipping/shipment";
                $post_data = json_encode($orderData);
                $method = "POST";
                $http_header = array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'GeoClient: '.$this->geoClient(),
                    'GeoSession: '.$this->geoSession()
                );
                $response = $this->curl_request_send($url, $method, $post_data, $http_header);
                $decodeResponse = json_decode($response, JSON_PRETTY_PRINT);
                $errMsg = '';
                if($decodeResponse['error'] == null){
                    return response()->json(['type' => 'success','msg'=> 'Order Created Successfully.']);
                }else{
                    if($decodeResponse['data'] != null){
                        return response()->json(['type' => 'success','msg'=> 'Order Created Successfully.']);
                    }else{
                        foreach($decodeResponse['error'] as $err){
                            $errMsg .= $err['obj'].'('.$err['errorMessage'].')<br>';
                        }
                        return response()->json(['type' => 'error','msg'=> $errMsg]);
                    }
                }
            }else{
                return response()->json(['type' => 'error','msg'=> 'Order Not Found. Please Contact With Support.']);
            }
        }catch(\Exception $exception){
            return response()->json(['type' => 'error','msg'=> 'Something Went Wrong.']);
        }

    }
    

}
