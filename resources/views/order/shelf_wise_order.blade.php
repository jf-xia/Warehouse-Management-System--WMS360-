@extends('master')

@section('title')
    Shelf Wise Order | WMS360
@endsection

@section('content')


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <div class="wms-breadcrumb-middle justify-content-between">
                    <div>
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item" aria-current="page">Order</li>
                            <li class="breadcrumb-item active" aria-current="page">Group Order</li>
                        </ol>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Group By
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{asset('group-order?order_filter_type=order_by_postcode')}}">Postcode</a>
                            <a class="dropdown-item" href="{{asset('group-order?order_filter_type=group_by_sku')}}">SKU</a>
                            <a class="dropdown-item" href="{{asset('group-order?order_filter_type=group_by_catalogue')}}">Catalogue</a>
                            <a class="dropdown-item" href="{{asset('group-order?order_filter_type=order_by_shelf')}}">Shelf</a>
                        </div>
                    </div>
                    <!-- <div class="btn-group">
                        <form action="{{url('shelf-wise-order-list')}}" methos="post">
                            @csrf
                            <select class="form-control" name="orderFilterType" id="orderFilterType">
                                <option value="order_by_postcode">Order By Postcode</option>
                                <option value="group_by_sku">Group By SKU</option>
                                <option value="group_by_catalogue">Group By Catalogue</option>
                                <option value="order_by_shelf">Order By Shelf</option>
                            </select>
                            <button type="submit" class="btn btn-info">Apply</button>
                        </form>
                    </div> -->
                </div>



                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="shelf-wise-order shadow">

                            <ul class="nav nav-tabs shelf-tab-btn" role="tablist">
                                @if(($orderFilterType == null) || $orderFilterType == 'order_by_postcode')
                                    <li class="nav-item text-center w-100">
                                        <a class="nav-link active" data-toggle="tab" href="#post_code_wise_order">Post Code</a>
                                        <!-- <a class="nav-link @if($shelfUse != 1) active @endif" data-toggle="tab" href="#post_code_wise_order">Post Code Wise Order</a> -->
                                    </li>
                                @endif
                                @if($orderFilterType == 'group_by_sku')
                                    <li class="nav-item text-center w-100">
                                        <a class="nav-link active" data-toggle="tab" href="#group_by_order">SKU</a>
                                    </li>
                                @endif
                                @if($orderFilterType == 'group_by_catalogue')
                                    <li class="nav-item text-center w-100">
                                        <a class="nav-link active" data-toggle="tab" href="#group_by_catalogue">Catalogue</a>
                                    </li>
                                @endif
                                @if($orderFilterType == 'order_by_shelf')
                                    @if($shelfUse == 1)
                                    <li class="nav-item text-center w-100">
                                        <a class="nav-link active" data-toggle="tab" href="#shelf_wise_order">Shelf</a>
                                    </li>
                                    @endif
                                @endif
                            </ul>
                            <div class="container-fluid tab-content shelf-content product-content">
                                <div id='loader' style='display: none;justify-content: center'>
                                    <img src='https://www.istitutomarangoni.com/fe-web/img/marangoni/loader.gif'>
                                </div>
                                @if(($orderFilterType == null) || $orderFilterType == 'order_by_postcode')
                                <h5>Search result showing depending on: (
                                @isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['postcode']) Postcode, @endisset
                                @isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['channel']) Channel, @endisset
                                @isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['customer_name']) Customer Name, @endisset
                                @isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['1st_line_address']) 1st line of address, @endisset
                                @isset($unserializeCombinedOrderSettingInfo['order']['combined_order']['user_id']) User Id, @endisset)
                                </h5>
                                    <div id="post_code_wise_order" class="tab-pane active m-b-20"><br>
                                        <input type="hidden" class="order-filter-type" value="order_by_postcode">
                                        <div class="product-inner justify-content-between p-b-10">
                                            <div class="row-wise-search table-terms">
                                                <input class="form-control mb-1" id="post-code-wise-order-search" type="text" placeholder="Search....">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success" style="width: 10px; height: 10px"></div>&nbsp;Picked
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary" style="width: 10px; height: 10px"></div>&nbsp;Unpicked
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row collapsable-checkbox-content-div d-none">
                                            <div class="col-md-4">
                                                <div class="btn-group">
                                                    <select class="form-control picker_id select2" name="picker_id" required>
                                                    @if(($pickerInfo->users_list)->count() == 1)
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected="true" disabled="disabled">Select Picker</option>
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    <button type="button" class="btn btn-primary picker-assign"> Assign </button>
                                                    <button type="button" class="btn btn-primary filter-order-export-csv ml-3" data="order-by-postcode"> Export CSV </button>
                                                </div>
                                                <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="post-code-wise-table-sort-list" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th><p class="text-center">Select All</p><input type="checkbox" class="form-control selectAllCheckbox"></th>
                                                    <th class="header-cell" onclick="post_code_wise_sortTable(0)">View</th>
                                                    <th class="header-cell" onclick="post_code_wise_sortTable(0)">Customer Post Code</th>
                                                    <th class="header-cell" onclick="post_code_wise_sortTable(0)">Channel</th>
                                                    <th class="header-cell" onclick="post_code_wise_sortTable(0)">Total Order</th>
                                                    <th class="header-cell" onclick="post_code_wise_sortTable(0)">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="post-code-wise-order-tbody">
                                                @foreach($customer_order_by_phone_post as $customer_order)
                                                    @if($customer_order->order_count > 1)
                                                        <tr class="filter-order-row-{{$customer_order->shipping_post_code}}">
                                                            <td><input type="checkbox" class="form-control table-row-checkbox" name="shipping_postcode" id="" value="{{$customer_order->shipping_post_code}}"></td>
                                                            <td>
                                                                <a href="#">
                                                                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal{{$customer_order->shipping_post_code}}/{{$customer_order->created_via}}/{{$customer_order->account_id}}"><i class="fa fa-eye"></i></button>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$customer_order->shipping_post_code}}</span>
                                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                            </td>
                                                            <td>

                                                            <div class="row mb-2">
                                                                @php
                                                                    $all_chennel_logo = [];
                                                                    $single_customer_order = [];
                                                                    $combinedOrderSetting = \App\Setting::where('user_id',1)->first();
                                                                    if($combinedOrderSetting){
                                                                        $combinedOrderSetting = unserialize($combinedOrderSetting->setting_attribute);
                                                                        if(isset($combinedOrderSetting['order']['combined_order']['channel'])){
                                                                            $all_chennel_logo = \App\Order::select('created_via', 'account_id')->where('status' , '=', 'processing')
                                                                            ->where('shipping_post_code', '=', $customer_order->shipping_post_code)
                                                                            ->where('created_via','=',$customer_order->created_via)
                                                                            ->where('account_id',$customer_order->account_id)
                                                                            ->havingRaw('count(order_number) > 1')->groupBy('created_via')
                                                                            ->groupBy('account_id')
                                                                            ->get();
                                                                            $single_customer_order = \App\Order::where(function($order) use ($combinedOrderSetting,$customer_order){
                                                                                if(Session::get('ebay') == 0){
                                                                                    $order->where('created_via','!=','Ebay')->where('created_via','!=','ebay');
                                                                                }
                                                                                if(Session::get('woocommerce') == 0){
                                                                                    $order->where('created_via','!=','checkout');
                                                                                }
                                                                                if(Session::get('onbuy') == 0){
                                                                                    $order->where('created_via','!=','onbuy');
                                                                                }
                                                                                if(Session::get('amazon') == 0){
                                                                                    $order->where('created_via','!=','amazon');
                                                                                }
                                                                                if(Session::get('shopify') == 0){
                                                                                    $order->where('created_via','!=','shopify');
                                                                                }
                                                                                if(isset($combinedOrderSetting['order']['combined_order']['channel'])){
                                                                                    $order->where('created_via','=',$customer_order->created_via)
                                                                                            ->where('account_id',$customer_order->account_id);
                                                                                }
                                                                            })->with(['product_variations' => function ($query) {
                                                                                $query->with(['shelf_quantity' => function($query){
                                                                                    $query->orderBy('shelf_name','ASC')->wherePivot('quantity','>',0);
                                                                                },'product_draft' => function($query_image){
                                                                                    $query_image->with('single_image_info');
                                                                                }]);
                                                                            }])->where([['shipping_post_code',$customer_order->shipping_post_code],['status','processing']])->where('created_via','=',$customer_order->created_via)
                                                                            ->where('account_id',$customer_order->account_id)->orderByDesc('id')->get();
                                                                        }else{
                                                                            $all_chennel_logo = \App\Order::select('created_via', 'account_id')->where('status' , '=', 'processing')->where('shipping_post_code', '=', $customer_order->shipping_post_code)->havingRaw('count(order_number) > 1')->groupBy('created_via')->groupBy('account_id')->get();
                                                                            $single_customer_order = \App\Order::where(function($order) use ($combinedOrderSetting,$customer_order){
                                                                                if(Session::get('ebay') == 0){
                                                                                    $order->where('created_via','!=','Ebay')->where('created_via','!=','ebay');
                                                                                }
                                                                                if(Session::get('woocommerce') == 0){
                                                                                    $order->where('created_via','!=','checkout');
                                                                                }
                                                                                if(Session::get('onbuy') == 0){
                                                                                    $order->where('created_via','!=','onbuy');
                                                                                }
                                                                                if(Session::get('amazon') == 0){
                                                                                    $order->where('created_via','!=','amazon');
                                                                                }
                                                                                if(Session::get('shopify') == 0){
                                                                                    $order->where('created_via','!=','shopify');
                                                                                }
                                                                            })->with(['product_variations' => function ($query) {
                                                                                $query->with(['shelf_quantity' => function($query){
                                                                                    $query->orderBy('shelf_name','ASC')->wherePivot('quantity','>',0);
                                                                                },'product_draft' => function($query_image){
                                                                                    $query_image->with('single_image_info');
                                                                                }]);
                                                                            }])->where([['shipping_post_code',$customer_order->shipping_post_code],['status','processing']])->orderByDesc('id')->get();
                                                                        }
                                                                    }
                                                                    
                                                                    
                                                                    $orderPickedCount = 0;
                                                                    $pickedProgressBarValue = 0;
                                                                    $unPickedProgressBarValue = 0;
                                                                    if(count($single_customer_order) > 0){
                                                                        foreach ($single_customer_order as $single_cus_order){
                                                                            $picking_count = 0;
                                                                            foreach($single_cus_order->product_variations as $sin_order){
                                                                                $picking_count += $sin_order->pivot->status;
                                                                            }
                                                                            if(count($single_cus_order->product_variations) == $picking_count){
                                                                                $orderPickedCount++;
                                                                            }
                                                                        }
                                                                        $pickedProgressBarValue = ($orderPickedCount >= $customer_order->order_count) ? 100 : round($orderPickedCount * (100 / $customer_order->order_count));
                                                                        $unPickedProgressBarValue = (100 - $pickedProgressBarValue);
                                                                    }
                                                                @endphp
                                                                @if(count($all_chennel_logo) > 0)
                                                                @foreach($all_chennel_logo as $single_chennel_logo)
                                                                            <div class="col-md-2 mb-1">
                                                                            @if(isset($single_chennel_logo->created_via))
                                                                            @if (Session::get('ebay') == 1)
                                                                                @if($single_chennel_logo->created_via == 'Ebay')
                                                                                    @php
                                                                                        $single_logo = \App\EbayAccount::select('account_name', 'logo', 'id')->where('id' , '=', $single_chennel_logo->account_id)->get();
                                                                                    @endphp
                                                                                    @foreach($single_logo as $logo)
                                                                                        @if(isset($logo->logo))
                                                                                        <a title="eBay({{\App\EbayAccount::find($logo->id)->account_name ?? ''}})" target="_blank">
                                                                                            <img style="height: 30px; width: 30px;" src="{{\App\EbayAccount::find($logo->id)->logo ?? ''}}">
                                                                                        @else
                                                                                            <span class="account_trim_name">
                                                                                            @php
                                                                                                $ac = \App\EbayAccount::find($logo->id)->account_name;
                                                                                                echo implode('', array_map(function($name)
                                                                                                { return $name[0];
                                                                                                },
                                                                                                explode(' ', $ac)));
                                                                                            @endphp
                                                                                            </span>
                                                                                        @endif
                                                                                    </a>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                            @if (Session::get('woocommerce') == 1)
                                                                                @if(($single_chennel_logo->created_via == 'Woocommerce') || ($single_chennel_logo->created_via == 'checkout') || ($single_chennel_logo->created_via == 'woocommerce'))
                                                                                    @php
                                                                                        $single_logo = \App\WoocommerceAccount::select('account_name', 'id')->where('id' , '=', $single_chennel_logo->account_id ?? 1)->get();
                                                                                    @endphp
                                                                                        @foreach($single_logo as $logo)

                                                                                        <a title="Woocommerce({{\App\WoocommerceAccount::find($logo->id)->account_name ?? ''}})" target="_blank">
                                                                                            <img style="height: 30px; width: 30px;" src="{{asset('/assets/common-assets/wooround.png')}}">
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                            @if (Session::get('onbuy') == 1)
                                                                                @if($single_chennel_logo->created_via == 'onbuy')
                                                                                    @php
                                                                                        $single_logo = \App\OnbuyAccount::select('account_name', 'id')->where('id' , '=', $single_chennel_logo->account_id)->get();
                                                                                    @endphp
                                                                                        @foreach($single_logo as $logo)

                                                                                        <a title="OnBuy({{\App\OnbuyAccount::find($logo->id)->account_name ?? ''}})" target="_blank">
                                                                                            <img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg">
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endif
                                                                            @if (Session::get('amazon') == 1)
                                                                                @if($single_chennel_logo->created_via == 'amazon')
                                                                                    @php
                                                                                        $amzAccountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo'])->find($single_chennel_logo->account_id);
                                                                                    @endphp
                                                                                    <a title="Amazon({{$amzAccountInfo->accountInfo->account_name ?? ''}})" target="_blank">
                                                                                        <img style="height: 30px; width: 30px;" src="{{asset('/').$amzAccountInfo->application_logo}}">
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                            @endif
                                                                            </div>
                                                                    @endforeach
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="progress" style="height: 20px !important">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$pickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$pickedProgressBarValue }}" aria-valuemin="0" aria-valuemax="100">{{$pickedProgressBarValue }}%</div>
                                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{$unPickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$unPickedProgressBarValue}}" aria-valuemin="0" aria-valuemax="100">{{$unPickedProgressBarValue}}%</div>
                                                                </div>
                                                                <span>
                                                                    <small class="text-success">{{($orderPickedCount >= $customer_order->order_count) ? $customer_order->order_count : $orderPickedCount}} picked </small> and
                                                                    <small class="text-primary">{{$customer_order->assigned_order}} assigned </small>of {{$customer_order->order_count}} orders
                                                                </span>
                                                            </td>
                                                            <td id="postcode-{{$customer_order->shipping_post_code}}">
                                                                @if($customer_order->postcode_status != 1)
                                                                    <!-- <a href="{{url('complete-postcode-order/'.$customer_order->shipping_post_code)}}" class="btn btn-success">Complete</a> -->
                                                                    <button type="button" class="btn btn-success postcode-mark-complete" id="{{$customer_order->shipping_post_code}}">Complete</button>
                                                                @else
                                                                    <img src="https://img.pngio.com/check-correct-mark-success-tick-valid-yes-icon-check-icon-valid-png-512_512.png" width="50px" height="50px">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        

                                                        <div class="modal fade" id="myModal{{$customer_order->shipping_post_code}}/{{$customer_order->created_via}}/{{$customer_order->account_id}}">
                                                            <div class="modal-dialog modal-lg custom-modal">
                                                                <div class="modal-content">

                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Order Details</h4>
                                                                        <button type="button" class="close custom-modal-close-btn" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <!--End Modal Header -->


                                                                    <!--Modal body start-->
                                                                    @if(count($single_customer_order) > 0)
                                                                    @foreach($single_customer_order as $customer_order)
                                                                        <div class="modal-body" id="modal-body">
                                                                            <div>
                                                                            <h5 style="display:inline;">Order No: #{!! \App\Traits\CommonFunction::dynamicOrderLink($customer_order->created_via,$customer_order) !!}</h5>
{{--                                                                                {{dynamicOrderLink($customer_order->created_via,$customer_order)}}--}}
                                                                            @if(isset($customer_order->created_via))
                                                                            @if($customer_order->created_via == 'Ebay')
                                                                                    @php
                                                                                        $single_logo = \App\EbayAccount::select('account_name', 'logo', 'id')->where('id' , '=', $customer_order->account_id)->get();
                                                                                    @endphp
                                                                                    @foreach($single_logo as $logo)
                                                                                        @if(isset($logo->logo))
                                                                                        <a title="eBay({{\App\EbayAccount::find($logo->id)->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                                                            <img style="height: 30px; width: 30px;" src="{{\App\EbayAccount::find($logo->id)->logo ?? ''}}">
                                                                                        @else
                                                                                            <span class="account_trim_name">
                                                                                            @php
                                                                                                $ac = \App\EbayAccount::find($logo->id)->account_name;
                                                                                                echo implode('', array_map(function($name)
                                                                                                { return $name[0];
                                                                                                },
                                                                                                explode(' ', $ac)));
                                                                                            @endphp
                                                                                            </span>
                                                                                        @endif
                                                                                    </a>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if(($single_chennel_logo->created_via == 'Woocommerce') || ($single_chennel_logo->created_via == 'checkout') || ($single_chennel_logo->created_via == 'woocommerce'))
                                                                                    @php
                                                                                        $single_logo = \App\WoocommerceAccount::select('account_name', 'id')->where('id' , '=', $customer_order->account_id ?? 1)->get();
                                                                                    @endphp
                                                                                        @foreach($single_logo as $logo)

                                                                                        <a title="Woocommerce({{\App\WoocommerceAccount::find($logo->id)->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                                                            <img style="height: 30px; width: 30px;" src="{{asset('/assets/common-assets/wooround.png')}}">
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if($customer_order->created_via == 'onbuy')
                                                                                    @php
                                                                                        $single_logo = \App\OnbuyAccount::select('account_name', 'id')->where('id' , '=', $customer_order->account_id)->get();
                                                                                    @endphp
                                                                                        @foreach($single_logo as $logo)

                                                                                        <a title="OnBuy({{\App\OnbuyAccount::find($logo->id)->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                                                            <img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg">
                                                                                        </a>
                                                                                    @endforeach
                                                                                @endif
                                                                                @if($customer_order->created_via == 'amazon')
                                                                                    @php
                                                                                        $amzAccountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo'])->find($customer_order->account_id);
                                                                                    @endphp
                                                                                    <a title="Amazon({{$amzAccountInfo->accountInfo->account_name ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                                                        <img style="height: 30px; width: 30px;" src="{{asset('/').$amzAccountInfo->application_logo}}">
                                                                                    </a>
                                                                                @endif
                                                                                @endif
                                                                            </div>
                                                                            <span class="font-16">Order Date: {{date('d-m-Y H:i:s',strtotime($customer_order->date_created))}},</span>
                                                                            <span class="text-purple font-16"> Status: {{$customer_order->status}}</span>
                                                                                <div class="body-part-one" style="border: 1px solid #ccc">
                                                                                    <div class="row m-t-10">
                                                                                        <div class="col-2 text-center">
                                                                                            <h6> Image </h6>
                                                                                            <hr class="order-hr" width="60%">
                                                                                        </div>
                                                                                        <div class="col-3 text-center">
                                                                                            <h6> Name </h6>
                                                                                            <hr class="order-hr" width="90%">
                                                                                        </div>
                                                                                        <div class="col-2 text-center">
                                                                                            <h6>SKU</h6>
                                                                                            <hr class="order-hr" width="60%">
                                                                                        </div>
                                                                                        @if($shelfUse == 1)
                                                                                            <div class="col-2 text-center">
                                                                                                <h6>Shelf</h6>
                                                                                                <hr class="order-hr" width="60%">
                                                                                            </div>
                                                                                        @endif
                                                                                        <div class="col-1 text-center">
                                                                                            <h6> Quantity </h6>
                                                                                            <hr class="order-hr" width="60%">
                                                                                        </div>
                                                                                        <div class="col-2 text-center">
                                                                                            <h6> Price </h6>
                                                                                            <hr class="order-hr" width="60%">
                                                                                        </div>
                                                                                    </div>
                                                                                    @foreach($customer_order->product_variations as $product)
                                                                                        <div class="row pt-2">
                                                                                            <div class="col-2 text-center">
                                                                                                @if(isset($product->image))
                                                                                                    <a href="{{$product->image}}" target="_blank"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                                                                                @else
                                                                                                    <a href="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" target="_blank">
                                                                                                        <img src="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" width="50px" height="50px">
                                                                                                    </a>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div class="col-3 text-center">
                                                                                                <h7> {{$product->pivot->name}} </h7>
                                                                                            </div>
                                                                                            <div class="col-2 text-center">
                                                                                                <h7>
                                                                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}}</span>
                                                                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                                                                </h7>
                                                                                            </div>
                                                                                            @if($shelfUse == 1)
                                                                                                <div class="col-2 text-center">
                                                                                                    @foreach($product->shelf_quantity as $shelf)
                                                                                                        <h7 class="label label-default mr-1"> {{$shelf->shelf_name}} -> {{$shelf->pivot->quantity}} </h7>
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            @endif
                                                                                            <div class="col-1 text-center">
                                                                                                <h7> {{$product->pivot->quantity}} </h7>
                                                                                            </div>
                                                                                            <div class="col-2 text-center">
                                                                                                <h7> {{$product->pivot->price}} </h7>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                    <div class="row m-b-20 m-t-10">
                                                                                        <div class="col-9">
                                                                                        </div>
                                                                                        <div class="col-1 d-flex justify-content-center">
                                                                                            <h7 class="font-weight-bold"> Total</h7>
                                                                                        </div>
                                                                                        <div class="col-2 text-center">
                                                                                            <h7 class="font-weight-bold"> {{$customer_order->total_price}}</h7>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!--- Shipping Billing --->
                                                                                <div style="border: 1px solid #ccc" class="m-t-20">
                                                                                    <div class="shipping-billing">
                                                                                        <div class="shipping">
                                                                                            <div class="d-block mb-5">
                                                                                                <h6>Shipping</h6>
                                                                                                <hr class="m-t-5 float-left" width="50%">
                                                                                            </div>
                                                                                            <div class="shipping-content">
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Name </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_user_name}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Phone </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_phone}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Address Line 1 </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_address_line_1}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Address Line 2 </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_address_line_2}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Address Line 3 </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_address_line_3}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> City </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_city}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> County </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_county}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Post code </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_post_code}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-2">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Country </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->shipping_country}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="billing">
                                                                                            <div class="d-block mb-5">
                                                                                                <h6> Billing </h6>
                                                                                                <hr class="m-t-5 float-left" width="50%">
                                                                                            </div>
                                                                                            <div class="billing-content">
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Name </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_name}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Email </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_email}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Phone </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_phone}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> City </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_city}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> State </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_state}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-1">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Zip Code </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_zip_code}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="d-flex justify-content-start mb-2">
                                                                                                    <div class="content-left">
                                                                                                        <h7> Country </h7>
                                                                                                    </div>
                                                                                                    <div class="content-right">
                                                                                                        <h7> : {{$customer_order->customer_country}} </h7>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> <!--Billing and shipping -->

                                                                        </div>
                                                                    @endforeach
                                                                    @endif
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>  <!-- // The Modal -->
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if($orderFilterType == 'group_by_sku')
                                    <div id="group_by_order" class="tab-pane active m-b-20"><br>
                                        <input type="hidden" class="order-filter-type" value="group_by_sku">
                                        <div class="product-inner justify-content-between p-b-10">
                                            <div class="row-wise-search table-terms">
                                                <input class="form-control mb-1" id="group-by-sku-search" type="text" placeholder="Search....">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success" style="width: 10px; height: 10px"></div>&nbsp;Picked
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary" style="width: 10px; height: 10px"></div>&nbsp;Unpicked
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row collapsable-checkbox-content-div d-none">
                                            <div class="col-md-4">
                                                <div class="btn-group">
                                                    <select class="form-control picker_id select2" name="picker_id" required>
                                                    @if(($pickerInfo->users_list)->count() == 1)
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected="true" disabled="disabled">Select Picker</option>
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    <button type="button" class="btn btn-primary picker-assign"> Assign </button>
                                                    <button type="button" class="btn btn-primary filter-order-export-csv ml-3" data="group-by-sku"> Export CSV </button>
                                                </div>
                                                <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="shelf-wise-table-sort-list" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th><p class="text-center">Select All</p><input type="checkbox" class="form-control selectAllCheckbox"></th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Image</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Id</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">SKU</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Variation</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Product Order</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Total Product</th>
                                                </tr>
                                                </thead>
                                                <tbody id="group-by-sku-tbody">
                                                @if(count($groupBySku) > 0)
                                                    @foreach($groupBySku as $bySku)
                                                        <tr class="filter-order-row-{{$bySku->variation_id}}">
                                                            <td><input type="checkbox" class="form-control table-row-checkbox" name="variation_id" id="" value="{{$bySku->variation_id}}"></td>
                                                            <td><img src="{{$bySku->variation_info->image ?? ((filter_var($bySku->variation_info->master_single_image->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$bySku->variation_info->master_single_image->image_url : '')}}" height="50" width="50" alt=""></td>
                                                            <td>{{$bySku->variation_id}}</td>
                                                            <td>
                                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$bySku->variation_info->sku}}</span>
                                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                            </td>
                                                            @php
                                                                $variation = '';
                                                                if($bySku->variation_info->attribute != null && is_array(unserialize($bySku->variation_info->attribute)) == TRUE){
                                                                    foreach(unserialize($bySku->variation_info->attribute) as $attribute){
                                                                        $variation .= $attribute['attribute_name'].'->'.$attribute['terms_name'].',';
                                                                    }
                                                                }
                                                                $pickedProgressBarValue = round($bySku->picked_order * (100 / $bySku->order_count));
                                                                $unPickedProgressBarValue = (100 - $pickedProgressBarValue);
                                                            @endphp
                                                            <td>{{rtrim($variation,',')}}</td>
                                                            <td>
                                                                <div class="progress" style="height: 20px !important">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$pickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$pickedProgressBarValue }}" aria-valuemin="0" aria-valuemax="100">{{$pickedProgressBarValue }}%</div>
                                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{$unPickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$unPickedProgressBarValue}}" aria-valuemin="0" aria-valuemax="100">{{$unPickedProgressBarValue}}%</div>
                                                                </div>
                                                                <span>
                                                                    <small class="text-success">{{$bySku->picked_order}} picked </small> and
                                                                    <small class="text-primary">{{count($bySku->variation_info->getProductOrders)}} assigned </small>of {{$bySku->order_count}} orders
                                                                </span>
                                                            </td>
                                                            <td>{{$bySku->total_quantity}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if($orderFilterType == 'group_by_catalogue')
                                    <div id="group_by_catalogue" class="tab-pane active m-b-20"><br>
                                        <input type="hidden" class="order-filter-type" value="group_by_catalogue">
                                        <div class="product-inner justify-content-between p-b-10">
                                            <div class="row-wise-search table-terms">
                                                <input class="form-control mb-1" id="group-by-catalogue-search" type="text" placeholder="Search....">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success" style="width: 10px; height: 10px"></div>&nbsp;Picked
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary" style="width: 10px; height: 10px"></div>&nbsp;Unpicked
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row collapsable-checkbox-content-div d-none">
                                            <div class="col-md-4">
                                                <div class="btn-group">
                                                    <select class="form-control picker_id select2" name="picker_id" required>
                                                    @if(($pickerInfo->users_list)->count() == 1)
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected="true" disabled="disabled">Select Picker</option>
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    <button type="button" class="btn btn-primary picker-assign"> Assign </button>
                                                    <button type="button" class="btn btn-primary filter-order-export-csv ml-3" data="group-by-catalogue"> Export CSV </button>
                                                </div>
                                                <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th><p class="text-center">Select All</p><input type="checkbox" class="form-control selectAllCheckbox"></th>
                                                    <th>Image</th>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>SKU Short Code</th>
                                                    <th>Order Product</th>
                                                    <th>Total Product</th>
                                                </tr>
                                                </thead>
                                                <tbody id="group-by-catalogue-tbody">
                                                @if(count($catalogueOrderArr) > 0)
                                                    @foreach($catalogueOrderArr as $catalogue)
                                                        <tr class="filter-order-row-{{$catalogue['catalogue_id']}}">
                                                            <td><input type="checkbox" class="form-control table-row-checkbox" name="catalogue_id" id="" value="{{$catalogue['catalogue_id']}}"></td>
                                                            <td><img src="{{(filter_var($catalogue['image'], FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue['image'] : $catalogue['image']}}" height="50" width="50" alt=""></td>
                                                            <td>{{$catalogue['catalogue_id']}}</td>
                                                            <td>{{$catalogue['name']}}</td>
                                                            <td>
                                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$catalogue['sku_short_code']}}</span>
                                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                            </td>
                                                            <td>
                                                                @php
                                                                $pickedProgressBarValue = round($catalogue['picked_order'] * (100 / $catalogue['total_order']));
                                                                $unPickedProgressBarValue = (100 - $pickedProgressBarValue);
                                                                @endphp
                                                                <div class="progress" style="height: 20px !important">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{$pickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$pickedProgressBarValue }}" aria-valuemin="0" aria-valuemax="100">{{$pickedProgressBarValue }}%</div>
                                                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: {{$unPickedProgressBarValue}}%; font-size: 12px" aria-valuenow="{{$unPickedProgressBarValue}}" aria-valuemin="0" aria-valuemax="100">{{$unPickedProgressBarValue}}%</div>
                                                                </div>
                                                                <span>
                                                                    <small class="text-success">{{$catalogue['picked_order']}} picked </small> and
                                                                    <small class="text-primary">{{$catalogue['assigned_order']}} assigned </small>of {{$catalogue['total_order']}} orders
                                                                </span>
                                                            </td>
                                                            <td>{{$catalogue['total_product']}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                @if($orderFilterType == 'order_by_shelf')
                                    @if($shelfUse == 1)
                                    <div id="shelf_wise_order" class="tab-pane active m-b-20"><br>
                                        <input type="hidden" class="order-filter-type" value="order_by_shelf">
                                        <div class="product-inner justify-content-between p-b-10">
                                            <div class="row-wise-search table-terms">
                                                <input class="form-control mb-1" id="shelf-wise-order-search" type="text" placeholder="Search....">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success" style="width: 10px; height: 10px"></div>&nbsp;Picked
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary" style="width: 10px; height: 10px"></div>&nbsp;Unpicked
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row collapsable-checkbox-content-div d-none">
                                            <div class="col-md-4">
                                                <div class="btn-group">
                                                    <select class="form-control picker_id select2" name="picker_id" required>
                                                    @if(($pickerInfo->users_list)->count() == 1)
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @else
                                                        <option selected="true" disabled="disabled">Select Picker</option>
                                                        @foreach($pickerInfo->users_list as $picker)
                                                            <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                        @endforeach
                                                    @endif
                                                    </select>
                                                    <button type="button" class="btn btn-primary picker-assign"> Assign </button>
                                                    <button type="button" class="btn btn-primary filter-order-export-csv ml-3" data="order-by-shelf"> Export CSV </button>
                                                </div>
                                                <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="shelf-wise-table-sort-list" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th><p class="text-center">Select All</p><input type="checkbox" class="form-control selectAllCheckbox"></th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">View</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Order Number</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Channel</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Currency</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Status</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Order Product</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Order Date</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Picking Status</th>
                                                    <th class="header-cell" onclick="shelf_wise_sortTable(0)">Shelf Name</th>
                                                </tr>
                                                </thead>
                                                <tbody id="shelf-wise-order-tbody">
                                                @foreach($order_info as $order)
                                                    <tr class="filter-order-row-{{$order->order_id}}">
                                                        <td><input type="checkbox" class="form-control table-row-checkbox" name="catalogue_id" id="" value="{{$order->order_id}}"></td>
                                                        <td><button class="btn btn-success" onclick="order_product({{$order->order_id}});"><i class="fa fa-eye"></i></button></td>
                                                        <td>{{$order->order_number}}</td>
                                                        <td>
                                                            <img style="height: 30px; width: 30px;" src="{{$order->account_logo}}">
                                                        </td>
                                                        <td>{{$order->currency}}</td>
                                                        <td>{{$order->status}}</td>
                                                        <td>{{$order->order_product}}</td>
                                                        <td>{{date('d-m-Y H:i:s',strtotime($order->order_date))}}</td>
                                                        <td>
                                                            <div class="progress" style="height: 20px !important">
                                                                <div class="progress-bar @if($order->is_picked_order) bg-success @else bg-secondary @endif" role="progressbar" style="width: 100%; font-size: 12px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                                            </div>
                                                            <span>
                                                                <small class="text-success">{{$order->is_picked_order ? 1 : 0}} picked </small> and
                                                                <small class="text-primary">{{$order->assigned_order}} assigned </small>of 1 orders
                                                            </span>
                                                        </td>
                                                        <td>{{$order->shelf_name}} ({{$order->quantity}})</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end col -->
            </div>
        </div> <!-- container -->

    </div> <!-- content -->

    <div class="modal fade" id="myModal1">
        <div class="modal-dialog modal-lg custom-modal">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Shelf Product</h4>
                    <button type="button" class="close custom-modal-close-btn" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" id="modal-body1">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>

    </div>  <!-- // The Modal -->




    <script>
       function order_product(id) {
            $.ajax({
                type: "post",
                url: "{{url('ajax-shelf-wise-product-list')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "id" : id
                },
                success: function (response) {
                    var infoModal = $('#myModal1');
                    // $('#myModal').modal('show');
                    infoModal.find('#modal-body1')[0].innerHTML = response;
                    infoModal.modal();

                }
            });
       }
    </script>

{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#datatable').DataTable();--}}
{{--            $('.dataTables_length').addClass('bs-select');--}}
{{--        } );--}}

{{--    </script>--}}


    <script>

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#shelf-wise-order-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#shelf-wise-order-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
            $("#group-by-sku-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#group-by-sku-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });

            $('button.postcode-mark-complete').click(function(){
                $(this).html('<i class="fa fa-spinner fa-spin"></i>Loading')
                let postcode = $(this).attr('id')
                let url = "{{asset('complete-postcode-order')}}"+"/"+postcode
                fetch(url)
                .then(response => response.json())
                .then(data => {
                    if(data.type == 'success'){
                        Swal.fire('Success','Postcode <span class="text-primary">'+ postcode + '</span> is marked as completed', 'success')
                        $(this).closest('td').html('<img src="https://img.pngio.com/check-correct-mark-success-tick-valid-yes-icon-check-icon-valid-png-512_512.png" width="50px" height="50px">')
                    }else{
                        Swal.fire('Oops!', data.msg, 'error')
                    }
                })
                .catch(error => {
                    Swal.fire('Oops!','Something went wrong','error')
                })
            })
        });

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#post-code-wise-order-search, #group-by-catalogue-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#post-code-wise-order-tbody  tr, #group-by-catalogue-tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
            var countCheckedAll = function() {
                var counter = $(".table-row-checkbox:checked").length;
                $(".checkbox-count").html( counter + " Catalogue Selected" );
            };
            $(".selectAllCheckbox").click(function () {
                $(".table-row-checkbox").prop('checked', $(this).prop('checked'))
                $('.collapsable-checkbox-content-div').removeClass('d-none').addClass('d-block')
                countCheckedAll()
            });

            $('.selectAllCheckbox, .table-row-checkbox').click(function () {
                if($('.selectAllCheckbox:checked, .table-row-checkbox:checked').length > 0) {
                    $('.collapsable-checkbox-content-div').removeClass('d-none').addClass('d-block')
                    countCheckedAll()
                }else{
                    $('.collapsable-checkbox-content-div').removeClass('d-block').addClass('d-none')
                    countCheckedAll()
                }
            })
            $('button.picker-assign').on('click',function () {
              var order_number = [];
              $('table tbody tr td :checkbox:checked').each(function(i){
                  order_number[i] = $(this).val();
              });
              if(order_number.length == 0){
                    Swal.fire('Please Select an Order','','warning')
                    return false;
              }
              var picker_id = $('select.picker_id').val();
              if(picker_id === null){
                    Swal.fire('Please Select a Picker','','warning')
                    return false;
              }
              let orderFilterType = $('input.order-filter-type').val()
              $.ajax({
                  type: "POST",
                  url: "{{url('group-catalogue-picker-assign')}}",
                  data: {
                      "_token" : "{{csrf_token()}}",
                      "picker_id" : picker_id,
                      "multiple_order" : order_number,
                      "order_filter_type" : orderFilterType
                  },
                  success: function (response) {
                      if(response.type == 'success') {
                            Swal.fire('Success',response.message,'success')
                            order_number.forEach((orderId) => {
                                console.log(orderId)
                                $('tbody tr.filter-order-row-'+orderId).remove()
                            })
                            $(".checkbox-count").html('');
                      }else{
                            Swal.fire('Oops!',response.message,'error')
                      }
                  }
              });
          });

          $('button.filter-order-export-csv').on('click',function(){
            var order_number = [];
            $('table tbody tr td :checkbox:checked').each(function(i){
                order_number[i] = $(this).val();
            });
            if(order_number.length == 0){
                Swal.fire('Please Select an Order','','warning')
                return false;
            }
            let orderFilterType = $(this).attr('data')
            $.ajax({
                type: "POST",
                url: "{{url('filter-order-export-csv')}}",
                responseType: "blob",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "multiple_order" : order_number,
                    "filter_order_type" : orderFilterType
                },
                success: function (response) {
                    if(response.type == 'success'){
                        const link = document.createElement('a');
                        link.href = response.url;
                        link.setAttribute('download',response.file_name);
                        console.log(link)
                        document.body.appendChild(link);
                        link.click();
                    }else{
                        Swal.fire('Oops!',response.message,'error')
                    }
                }
            });
          })
        });


        //sort ascending and descending table rows js 1st Tab
        function shelf_wise_sortTable(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("shelf-wise-table-sort-list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }



        //sort ascending and descending table rows js 2nd Tab
        function post_code_wise_sortTable(n) {
            let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("post-code-wise-table-sort-list");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName("TR");
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }


        // sort ascending descending icon active and active-remove js
        $('.header-cell').click(function() {
            let isSortedAsc  = $(this).hasClass('sort-asc');
            let isSortedDesc = $(this).hasClass('sort-desc');
            let isUnsorted = !isSortedAsc && !isSortedDesc;

            $('.header-cell').removeClass('sort-asc sort-desc');

            if (isUnsorted || isSortedDesc) {
                $(this).addClass('sort-asc');
            } else if (isSortedAsc) {
                $(this).addClass('sort-desc');
            }
        });

    </script>

@endsection
