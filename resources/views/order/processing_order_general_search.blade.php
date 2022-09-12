@inject('CommonFunction', 'App\Helpers\TraitFromClass')
@foreach($all_processing_order as $pending)
    <tr>

        <td class="checkboxShowHide{{$pending->id}}" style="width: 4%; text-align: center !important;">
            @if(count($pending->product_variations) > 0 && ($pending->is_buyer_message_read !== 0))
{{--                <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
                <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" value="{{$pending->id}}">
            @else
                <input type="checkbox" style="display: none" class="checkBoxClass" id="customCheck{{$pending->id}}" value="{{$pending->id}}">
            @endif
        </td>

        <td class="order-no" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center">
                <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($pending->created_via,$pending) !!}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
            @if($pending->exchange_order_id)
                (Ex. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($pending->exchange_order_id)->order_number}}</span>)
            @endif
            <span class="append_note{{$pending->id}}">
                @if(isset($pending->order_note) || ($pending->buyer_message != null))
                    <label class="label label-success view-note" style="cursor: pointer" id="{{$pending->id}}" onclick="view_note({{$pending->id}});">View Note</label>
                @endif
            </span>
            @if($pending->customer_note != null)
                <span>
                    <label class="label label-danger">Customer Note</label>
                </span>
            @endif
        </td>
        <td class="order-date" style="cursor: pointer; text-align: center !important; width: 20%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            {{$CommonFunction->getDateByTimeZone($pending->date_created)}}
        </td>
        @php
            $return_order = \App\ReturnOrder::where('order_id',$pending->id)->first();
            $awaiting_dispatch = \App\Order::where('id',$pending->id)->where([['status','processing'],['picker_id',null]])->first();
            $assigned_order = \App\Order::where('id',$pending->id)->where('status','processing')->where('picker_id','!=',null)->where('assigner_id','!=',null)->first();
            $hold_order = \App\Order::where('id',$pending->id)->where('status',['on-hold','exchange-hold'])->first();
            $dispatch_order = \App\Order::where('id',$pending->id)->where([['status','completed']])->first();
            $dispatch_order = \App\Order::where('id',$pending->id)->where([['status','completed']])->first();
            $cancelled_order = \App\Order::where('id',$pending->id)->where([['status','cancelled']])->first();
        @endphp
        @if(isset($return_order))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-warning label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note" id="{{$pending->id}}"><p class="font-13 buyer-text"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Return Order
                                                        </span>
            </td>
        @elseif(isset($awaiting_dispatch))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-success label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Awaiting Dispatch
                                                        </span>
            </td>
        @elseif(isset($assigned_order))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-primary label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Assigned Order
                                                        </span>
            </td>
        @elseif(isset($hold_order))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-info label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Hold Order
                                                        </span>
            </td>
        @elseif(isset($dispatch_order))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-pink label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Dispatch Order
                                                        </span>
            </td>
        @elseif(isset($cancelled_order))
            <td class="status" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                        <span class="label label-table label-purple label-status">
                                                            <!-- <div class="ebay-order-note">
                                                                @if($pending->buyer_message)
                                                                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                                @endif
                                                            </div> -->
                                                                Cancelled Order
                                                        </span>
            </td>
        @else
            <td class="status" style="text-align: center !important; width: 10%">
            <!-- <div class="ebay-order-note">
                                                            @if($pending->buyer_message)
                <div class="ebay-inner-order-note"><p class="font-13"> <strong>Order Note:</strong> {{$pending->buyer_message ?? ''}}</p></div>
                                                            @endif
                </div> -->
                {{ucfirst($pending->status)}}
            </td>
        @endif
        <td class="order_note"></td>
        <td class="channel" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            @if(isset($pending->account_ID) && $pending->created_via == 'Ebay')
                @if(\App\EbayAccount::find($pending->account_id)->account_name ?? '')
                    <div class="d-flex justify-content-center align-item-center" title="eBay({{\App\EbayAccount::find($pending->account_id)->account_name ?? ''}})">
                        @if(\App\EbayAccount::find($pending->account_id)->logo ?? '')
                            <img style="height: 40px; width: auto;" src="{{\App\EbayAccount::find($pending->account_id)->logo ?? ''}}">
                        @else
                        <span class="account_trim_name">
                            @php
                            $ac = \App\EbayAccount::find($pending->account_id)->account_name ?? '';
                            echo implode('', array_map(function($name)
                            { return $name[0];
                            },
                            explode(' ', $ac)));
                            @endphp
                        </span>
                        @endif
                    </div>
                @endif
            @endif
            @if($pending->created_via == 'amazon')
            <img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="image">
            @elseif($pending->created_via == 'shopify')
                @php
                    $shopify_account_info = \App\shopify\ShopifyAccount::find($pending->account_id) ?? '';
                @endphp
                    @isset($shopify_account_info)
                    <img src="{{$shopify_account_info->account_logo ?? ''}}" alt="Shopify({{ $shopify_account_info->account_name ?? '' }})" style="height:40px; width:auto;">
                    @endisset
            @elseif($pending->created_via == 'rest-api')
                <img src="{{asset('assets/common-assets/wms.png')}}" alt="image">
            @elseif($pending->created_via == 'checkout')
                <img src="{{asset('assets/common-assets/wooround.png')}}" alt="image">
            @elseif($pending->created_via == 'onbuy')
                <img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image">
            @endif

        </td>
        @if($pending->payment_method == 'paypal' || $pending->payment_method == 'PayPal')
            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$pending->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$pending->payment_method}}"></a>
            </td>
        @elseif($pending->payment_method == 'Amazon')
            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$pending->payment_method}}">
                @if(!empty($pending->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$pending->transaction_id}}" target="_blank">({{$pending->transaction_id}})</a>@endif
            </td>
        @elseif($pending->payment_method == 'stripe')
            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$pending->payment_method}}">
                @if(!empty($pending->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$pending->transaction_id}}" target="_blank">({{$pending->transaction_id}})</a>@endif
            </td>
        @elseif($pending->payment_method == 'CreditCard')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$pending->payment_method}}" style="width: 65px;height: 50px;"></td>
        @else
            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{ucfirst($pending->payment_method)}}</td>
        @endif
        <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->ebay_user_id ?? ""}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="name"  style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->shipping_user_name ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="city" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->shipping_city ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        
        <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{count($pending->product_variations)}}</td>
        <td class="total-price" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->total_price}}</td>
        <td class="currency" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->currency}}</td>
        <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->shipping_post_code}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="country" style="cursor: pointer; text-align: center !important; width: 20%;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->shipping_country ?? ''}}</td>
        <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
            {{substr($pending->shipping_method ?? 0.0,0,10)}}
        </td>

        <td class="actions" style="width: 8%">
        <div class="btn-group dropup">
            <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Manage
            </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <div class="dropup-content">
                        <div class="action-1">
                            @if($shelfUse == 0)
                            <a href="{{route('complete-order.completeOrder',$pending->id)}}" class="btn-size make-complete-btn mr-2" data-toggle="tooltip" data-placement="top" title="Make Complete"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                            @endif
                            @if(count($pending->product_variations) == 0)
                                <a href="{{url('add-product-empty-order/'.$pending->id)}}" class="btn-size make-complete-btn mr-2" data-toggle="tooltip" data-placement="top" title="Add Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif
                            <a href="{{url('hold-assigned-order/'.$pending->id)}}" class="btn-size hold-order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Hold Order"><i class="fa fa-pause" aria-hidden="true"></i></a>
                            @if(!isset($pending->order_note))
                                <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note mr-2 append_button{{$pending->id}}" data-toggle="tooltip" data-placement="top" title="Add Note" id="{{$pending->id}}"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></button>
                            @endif
                            <a href="{{url('processing/cancel-order/'.$pending->id)}}" class="btn-size cancel-btn order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Cancel" onclick="return cancel_order_check({{$pending->id}},'processing');"><i class="fa fa-window-close" aria-hidden="true"></i></a>


                            <a style="background:skyblue !important" href="{{url('order/list/pdf/'.$pending->order_number.'/1')}}" class="btn-size cancel-btn order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <a style="background:green !important" href="{{url('order/list/pdf/'.$pending->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-light btn-sm w-100 border-secondary text-center text-danger create-dpd-order" data="{{$pending->order_number}}" data-toggle="tooltip" data-placement="top" title="Create DPD Order"><i class="fas fa-shipping-fast"></i></button>
                        </div>
                    </div>
                </div>
        </div>
        </td>
    </tr>

    <tr>
        <td colspan="15" class="hiddenRow">
            <div class="accordian-body collapse" id="demo{{$pending->order_number}}">
                <div class="row">
                    <div class="col-12">
                        <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                            <div class="border">
                                <div class="row m-t-10">
                                    <div class="col-2 text-center">
                                        <h6>Image</h6>
                                        <hr width="60%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6> Title </h6>
                                        <hr width="90%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6>SKU</h6>
                                        <hr width="60%">
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6> Quantity </h6>
                                        <hr width="60%">
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6> Price </h6>
                                        <hr width="60%">
                                    </div>
                                </div>

                                @foreach($pending->product_variations as $product)
                                    <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                        <div class="col-2 text-center">
                                            @if(isset($product->image))
                                                <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                            @else
                                                @if(isset($product->product_draft->single_image_info->image_url))
                                                <a href="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}">
                                                    <img src="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" alt="Product Image" width="50px" height="50px">
                                                </a>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-3 text-center">
                                            @isset($product->product_draft->single_image_info->image_url)
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button id_copy_button_order_product_name">
                                                        <a href="{{asset('product-draft')}}/{{$product->product_draft->id}}" target="_blank">{{$product->pivot->name}}</a>
                                                    </span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                                <a href="{{url('exchange-order-product/'.$product->pivot->id)}}" class="label label-table label-success" target="_blank">Edit</a>
                                                <a href="Javascript:void(0)" class="label label-table label-danger" onclick="deleteOrderProduct({{$product->id}},{{$product->pivot->id}})">Delete</a>
                                            </h7>
                                            @endisset
                                        </div>
                                        <div class="col-3 text-center">
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button id_copy_button_order_product_name">{{$product->sku}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </h7>
                                        </div>
                                        <div class="col-2 text-center">
                                            <h7> {{$product->pivot->quantity}} </h7>
                                        </div>
                                        <div class="col-2 text-center">
                                            <h7> {{$product->pivot->price}} </h7>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row m-b-20">
                                    <div class="col-8 text-center">
                                    </div>
                                    <div class="col-2 d-flex justify-content-center">
                                        <h7 class="font-weight-bold"> Total Price</h7>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h7 class="font-weight-bold"> {{$pending->total_price}} </h7>
                                    </div>
                                </div>
                            </div>


                            <!--- Shipping Billing --->
                            <div class="m-t-20 border">
                                <div class="shipping-billing px-4 py-3">
                                    <div class="shipping">
                                    <a href="{{url('add-product-empty-order/'.$pending->id)}}" class="btn btn-success btn-sm" target="_blank">Add Product</a>
                                        <div class="d-block mb-5">
                                            <h6>Shipping
                                                <span class="ml-1"><button type="button" class="btn btn-outline-primary edit-address" data="{{$pending->id}}" shipping-type="shipping">Edit</button></span>
                                            </h6>
                                            <hr class="m-t-5 float-left" width="50%">
                                        </div>
                                        <div class="shipping-content">
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Name </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_user_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 1 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_address_line_1}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 2 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_address_line_2}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 3 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_address_line_3}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_county}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_post_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->shipping_country}} </h7>
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
                                                    <h7> : {{$pending->customer_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Email </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_email}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_state}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_zip_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$pending->customer_country}} </h7>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($pending->customer_note != null)
                                    <div class="row px-4 py-3">
                                        <h6 style="color: #d80d0d;">Customer Note :</h6>
                                        <h6>&nbsp;{{$pending->customer_note}}</h6>
                                    </div>
                                @endif
                            </div> <!--Billing and shipping -->
                        </div> <!-- end card -->
                    </div> <!-- end col-12 -->
                </div> <!-- end row -->
            </div> <!-- end accordion body -->
        </td> <!-- hide expand td-->
    </tr> <!-- hide expand row-->
@endforeach

<!--order note modal-->
<div class="modal fade" id="orderNoteModalView" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Note</h5>
                <button type="button" id="buttons"  class="close" data-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <div class="modal-body-view">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary update-note">Update</button>
                <button type="button" class="btn btn-danger delete-note">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--End order note modal-->



<script>
    function unread(id){
        $.ajax({
            type: "POST",
            url:"{{url('unread')}}",
            data: {
                "_token" : "{{csrf_token()}}",
                "order_id" : id
            },
            success: function (response) {
                if(response.data !== 'error'){
                    if(response.data == 1){
                        $("#customCheck"+id).hide();
                        $("#unread"+id).hide();
                    }
                    // var info = '';
                    // if(response.buyerMessage.buyer_message){
                    //     info += '<div class="alert alert-warning text-dark"> Buyer Note : '+response.buyerMessage.buyer_message+'</div>'
                    //     $('table tbody tr td.checkboxShowHide'+id).html('<input type="checkbox" class="checkBoxClass" id="customCheck'+id+'" value="'+id+'">')
                    // }
                    // if(response.data){
                    //     info += '<strong>Note Create Date : ' + response.data.created_at + '</strong><br>' +
                    //         '<strong>Note : </strong>\n' +
                    //         '<p class=""></p>' +
                    //         '<textarea class="form-control" name="order_note_view" id="order_note_view" cols="5" rows="3" placeholder="Type your note here..">' + response.data.note + '</textarea>\n' +
                    //         '<strong>Created By : ' + creatorName + '</strong>' +
                    //         '<strong class="pull-right">Modified By : ' + modifierName + ' (' + response.data.updated_at + ')' + '</strong>'
                    //     // infoModal.find('.modal-body-view')[0].innerHTML = info;
                    //     // infoModal.modal();
                    //     $('#orderNoteModalView .modal-footer .update-note').attr('id',response.data.id);
                    //     $('#orderNoteModalView .modal-footer .delete-note').attr('id',response.data.id);
                    //     $('#orderNoteModalView .modal-footer').removeClass('d-none')
                    // }else{
                    //     $('#orderNoteModalView .modal-footer').addClass('d-none')
                    // }
                    // infoModal.find('.modal-body-view')[0].innerHTML = info;
                    // infoModal.modal();
                }else{
                    alert('Something went wrong');
                }
            }
        });
    }
    function view_note(id) {
        // var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            url:"{{url('view-order-note')}}",
            data: {
                "_token" : "{{csrf_token()}}",
                "order_id" : id
            },
            success: function (response) {
                if(response.data !== 'error'){
                    var infoModal = $('#orderNoteModalView');
                    if(response.data){
                          var creatorName = (response.data.user_info == null) ? '' : response.data.user_info.name;
                          var modifierName = (response.data.modifier_info == null) ? '' : response.data.modifier_info.name;
                      }
                    var info = '';
                    $("#customCheck"+id).show();
                    $("#unread"+id).show();
                    // if(response.buyerMessage.buyer_message){
                    //     info += '<div class="alert alert-warning text-dark"> Buyer Note : '+response.buyerMessage.buyer_message+'</div>'
                    //     $('table tbody tr td.checkboxShowHide'+id).html('<input type="checkbox" class="checkBoxClass" id="customCheck'+id+'" value="'+id+'">')
                    // }
                    if(response.buyerMessage.buyer_message){
                        info += '<div class="alert alert-warning text-dark"> Buyer Note : '+response.buyerMessage.buyer_message+'</div>'
                        $('table tbody tr td.checkboxShowHide'+id).html('<input type="checkbox" class="checkBoxClass" id="customCheck'+id+'" value="'+id+'">')
                    }
                    if(response.data){
                        info += '<strong>Note Create Date : ' + response.data.created_at + '</strong><br>' +
                            '<strong>Note : </strong>\n' +
                            '<p class=""></p>' +
                            '<textarea class="form-control" name="order_note_view" id="order_note_view" cols="5" rows="3" placeholder="Type your note here..">' + response.data.note + '</textarea>\n' +
                            '<strong>Created By : ' + creatorName + '</strong>' +
                            '<strong class="pull-right">Modified By : ' + modifierName + ' (' + response.data.updated_at + ')' + '</strong>'
                        // infoModal.find('.modal-body-view')[0].innerHTML = info;
                        // infoModal.modal();
                        $('#orderNoteModalView .modal-footer .update-note').attr('id',response.data.id);
                        $('#orderNoteModalView .modal-footer .delete-note').attr('id',response.data.id);
                        $('#orderNoteModalView .modal-footer').removeClass('d-none')
                    }else{
                        $('#orderNoteModalView .modal-footer').addClass('d-none')
                    }
                    if (response.buyerMessage.is_buyer_message_read == 1){
                        // $("#buttons").html('<button type="button" class="btn btn-dark update-note" id="unread'+response.buyerMessage.id+'" onclick="unread('+response.buyerMessage.id+');">Mark as Unread</button>')
                        $("#buttons").html('<button type="button" class="btn btn-danger" style="margin-right: 0%" id="unread'+response.buyerMessage.id+'" onclick="unread('+response.buyerMessage.id+');">Mark as Unread</button>\n' +
                            '                        <span aria-hidden="true">&times;</span>')
                    }
                    infoModal.find('.modal-body-view')[0].innerHTML = info;
                    infoModal.modal();
                }else{
                    alert('Something went wrong');
                }
            }
        });
    }



    $(document).ready(function () {
        $('#search_oninput').on('input',function () {
            var search_value = $('#search_oninput').val();
            var order_search_status = $('#order_search_status').val();
            if(search_value.length != '' && search_value.length < 3){
                return false;
            }
            console.log(search_value);
            $.ajax({
                type: "POST",
                url: "{{url('complete-order-general-search')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "search_value" : search_value,
                    "order_search_status" : order_search_status
                },
                beforeSend:function(){
                    $('#search_oninput').addClass('loading');
                },
                success: function (response) {
                    $('table tbody').html(response);
                },
                complete:function () {
                    $('#search_oninput').removeClass('loading');
                }
            });
        });
        $('.order-note').click(function () {
            var id = $(this).attr('id');
            $('#order_id').val(id);
            $('#orderNoteModal').modal();
        });
    })

    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });

    // // Entire table row column display
    // $("#display-all").click(function(){
    //     $("table tr th, table tr td").show();
    //     $(".disp-column-display li input[type=checkbox]").prop("checked", "true");
    // });
    //
    // // After unchecked any column display all checkbox will be unchecked
    // $(".disp-column-display li input[type=checkbox]").change(function(){
    //     if (!$(this).prop("checked")){
    //         $("#display-all").prop("checked",false);
    //     }
    // });



    // table column hide and show toggle checkbox
    $("input:checkbox").click(function(){
        let column = "."+$(this).attr("name");
        $(column).toggle();
    });

    //table column by default hide
    $("input:checkbox:not(:checked)").each(function() {
        var column = "table ." + $(this).attr("name");
        $(column).hide();
    });

    //prevent onclick dropdown menu close
    $('.filter-content').on('click', function(event){
        event.stopPropagation();
    });

    $('.order-complete').on('click',function(e, data){
        e.preventDefault();
        var currentElement = $(this);
        Swal.fire({
            title: 'Are you sure to complete this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = currentElement.attr('href');
            }
        })
    });


    @if($shelfUse == 1)
        // Check uncheck active catalogue counter
        var ajaxCountCheckedAll = function() {
            var counter = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( counter + " awaiting dispatched selected!" );
            console.log(counter + ' awaiting dispatched selected!');
        };

        $(".checkBoxClass").on( "click", ajaxCountCheckedAll );

        $('.ckbCheckAll').click(function (e) {
            $(this).closest('table').find('td .checkBoxClass').prop('checked', this.checked);
            ajaxCountCheckedAll();
        })

        $(document).ready(function() {
            $(".ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $(".ckbCheckAll").prop("checked",false);
                }
            });
            $('.ckbCheckAll, .checkBoxClass').click(function () {
                if($('.ckbCheckAll:checked, .checkBoxClass:checked').length > 0) {
                    $('div.awaiting-dispatch-select-picker-content').show(500);
                }else{
                    $('div.awaiting-dispatch-select-picker-content').hide(500);
                }
            })
        });
        //End Check uncheck active catalogue counter
    @endif

</script>
