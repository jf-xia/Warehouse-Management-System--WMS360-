@inject('CommonFunction', 'App\Helpers\TraitFromClass')
@foreach($all_hold_order as $hold)
    <tr>
        @if($shelfUse == 1)
        <td style="width: 4%; text-align: center !important;">
{{--            <input type="checkbox" class="checkBoxClass" id="customCheck{{$hold->id}}" name="multiple_order[]" value="{{$hold->id}}">--}}
            <input type="checkbox" class="checkBoxClass" id="customCheck{{$hold->id}}" value="{{$hold->id}}">
        </td>
        @endif
        <td class="order-no" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($hold->created_via,$hold) !!}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
            <span class="append_note{{$hold->id}}">
                @isset($hold->order_note)
                    <label class="label label-success view-note" style="cursor: pointer" id="{{$hold->id}}" onclick="view_note({{$hold->id}});">View Note</label>
                @endisset
            </span>
        </td>
        <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            {{$CommonFunction->getDateByTimeZone($hold->date_created)}}
        </td>
        @if($hold->status == 'processing')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-warning">{{$hold->status}}</span></td>
        @elseif($hold->status == 'completed')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-success">{{$hold->status}}</span></td>
        @elseif($hold->status == 'on-hold')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-primary">{{$hold->status}}</span></td>
        @elseif($hold->status == 'exchange-hold')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-danger label-status">{{$hold->status}}</span></td>
        @else
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($hold->status)}}</td>
        @endif
        @if(($hold->created_via == 'ebay' || $hold->created_via == 'Ebay') && ($hold->account_id == null))
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
        @elseif(($hold->created_via == 'ebay' || $hold->created_via == 'Ebay') && ($hold->account_id != null))
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\EbayAccount::find($hold->account_id);
            @endphp
            @if($accountInfo)
                <div class="d-flex justify-content-center align-item-center" title="eBay({{$accountInfo->account_name ?? ''}})">
                    <img style="height: 30px; width: 30px;" src="{{$accountInfo->logo ?? ''}}">
                    @if(!isset($accountInfo->logo))
                        <span class="account_trim_name">
                            @php
                            $ac = $accountInfo->account_name ?? '';
                            echo implode('', array_map(function($name)
                            { return $name[0];
                            },
                            explode(' ', $ac)));
                            @endphp
                        </span>
                    @endif
                </div>
            @else
                <img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image">
            @endif
        </td>
        @elseif($hold->created_via == 'amazon')
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($hold->account_id);
            @endphp
            @if($accountInfo)
                <div class="d-flex justify-content-center align-item-center" title="Amazon({{$accountInfo->accountInfo->account_name ?? ''}} {{$accountInfo->marketPlace->marketplace ?? ''}})">
                    <img style="height: 30px; width: 30px;" src="{{$accountInfo->application_logo ? asset('/').$accountInfo->application_logo : ''}}">
                    @if($accountInfo->application_logo == null)
                        <span class="account_trim_name">
                            @php
                            $ac = $accountInfo->accountInfo->account_name ?? '';
                            echo implode('', array_map(function($name)
                            { return $name[0];
                            },
                            explode(' ', $ac)));
                            @endphp
                        </span>
                    @endif
                </div>
            @else
                <img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="image">
            @endif
        </td>
        @elseif($hold->created_via == 'checkout')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
        @elseif($hold->created_via == 'onbuy')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image"></td>
        @elseif($hold->created_via == 'rest-api')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
        @else
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{ucfirst($hold->created_via)}}</td>
        @endif
        @if($hold->payment_method == 'paypal' || $hold->payment_method == 'PayPal')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
                <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$hold->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$hold->payment_method}}"></a>
            </td>
        @elseif($hold->payment_method == 'Amazon')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$hold->payment_method}}">
                @if(!empty($hold->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$hold->transaction_id}}" target="_blank">({{$hold->transaction_id}})</a>@endif
            </td>
        @elseif($hold->payment_method == 'stripe')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$hold->payment_method}}">
                @if(!empty($hold->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$hold->transaction_id}}" target="_blank">({{$hold->transaction_id}})</a>@endif
            </td>
        @elseif($hold->payment_method == 'CreditCard')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$hold->payment_method}}" style="width: 65px;height: 50px;"></td>
        @else
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{ucfirst($hold->payment_method)}}</td>
        @endif
            <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$hold->ebay_user_id ?? ""}}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
            </td>
        <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$hold->shipping_user_name ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="city" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$hold->shipping_city ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        
        <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{count($hold->product_variations)}}</td>
        <td class="total-price" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{$hold->total_price}}</td>
        <td class="hold-by" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{$hold->cancelled_by_user->name ?? ''}}</td>
        <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{$hold->currency}}</td>
        <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$hold->shipping_post_code}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="country" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">{{$hold->shipping_country ?? ''}}</td>
        <td class="shipping-cost" style="cursor: pointer; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
            {{substr($hold->shipping_method ?? 0.0,0,10)}}
        </td>
        <td class="note_btn_append{{$hold->id}}" style="width: 6%">
            <a href="{{url('unhold-order/'.$hold->id)}}"><button class="btn btn-default btn-sm m-b-5 w-100 text-success">Unhold</button></a>
            @if(!isset($hold->order_note))
                <a href="#"><button type="button" class="btn btn-primary btn-sm order-note m-b-5 w-100 label-status append_button{{$hold->id}}" id="{{$hold->id}}">Add Note</button></a>
            @endif
            <a href="{{url('hold/cancel-order/'.$hold->id)}}" class="btn btn-danger order-btn m-b-5 w-100 text-center" onclick="return cancel_order_check({{$hold->id}},'hold');">Cancel</a>
            <button type="button" class="btn btn-success btn-sm m-b-5 w-100 text-center create-royal-mail-order" data="{{$hold->order_number}}" style="background-color: #d42024 !important; color: #ffca00 !important">Create RM Order</button>
            <button type="button" class="btn btn-light btn-sm m-b-5 w-100 border-secondary text-center text-danger create-dpd-order" data="{{$hold->order_number}}">Create DPD Order</button>
            <div class="action-1">
                <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$hold->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$hold->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
            </div>
        </td>
    </tr>

    <tr>
        <td colspan="16" class="hiddenRow">
            <div class="accordian-body collapse" id="demo{{$hold->order_number}}">
                <div class="row">
                    <div class="col-12">
                        <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                            <div class="border">
                                <div class="row m-t-10">
                                    <div class="col-2 text-center">
                                        <h6>Image</h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6> Name </h6>
                                        <hr class="order-hr" width="90%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6>SKU</h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6> Quantity </h6>
                                        <hr width="60%">
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6> Price </h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                </div>
                                @foreach($hold->product_variations as $product)
                                    <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                        <div class="col-2 text-center">
                                            @if(isset($product->image))
                                                <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                            @elseif(isset($product->product_draft->single_image_info->image_url))
                                                <a href="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}">
                                                    <img src="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" width="50px" height="50px">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-3 text-center">
                                            @isset($product->product_draft->single_image_info->image_url)
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">
                                                        <a href="{{asset('product-draft')}}/{{$product->product_draft->id}}" target="_blank">{{$product->pivot->name}}</a>
                                                    </span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                                <a href="{{url('exchange-order-product/'.$product->pivot->id)}}" class="label label-table label-success" target="_blank">Edit</a>
                                            </h7>
                                            @endisset
                                        </div>
                                        <div class="col-3 text-center">
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}}</span>
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
                                    <div class="col-8 text-center"></div>
                                    <div class="col-2 d-flex justify-content-center">
                                        <h7 class="font-weight-bold"> Total Price</h7>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h7 class="font-weight-bold"> {{$hold->total_price}} </h7>
                                    </div>
                                </div>
                            </div>


                            <!--- Shipping Billing --->
                            <div class="m-t-20 border">
                                <div class="shipping-billing">
                                    <div class="shipping px-4 py-3">
                                        <div class="d-block mb-5">
                                            <h6 class="text-left">Shipping
                                                <span class="ml-1"><button type="button" class="btn btn-outline-primary edit-address" data="{{$hold->id}}" shipping-type="shipping">Edit</button></span>
                                            </h6>
                                            <hr class="m-t-5 float-left" width="50%">
                                        </div>
                                        <div class="shipping-content">
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Name </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_user_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 1 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_address_line_1}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 2 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_address_line_2}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 3 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_address_line_3}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_county}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_post_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->shipping_country}} </h7>
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
                                                    <h7> : {{$hold->customer_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Email </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_email}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_state}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_zip_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$hold->customer_country}} </h7>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--Billing and shipping -->
                        </div> <!-- end card -->
                    </div> <!-- end col-12 -->
                </div> <!-- end row -->
            </div> <!-- end accordion body -->
        </td> <!-- hide expand td-->
    </tr> <!-- hide expand row-->
@endforeach

<!--Modal Start-->
<div class="modal fade" id="orderNoteModalView" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
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
<!--End Modal Start-->



<script>

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
                        $('#orderNoteModalView .modal-footer .update-note').attr('id',response.data.id);
                        $('#orderNoteModalView .modal-footer .delete-note').attr('id',response.data.id);
                        $('#orderNoteModalView .modal-footer').removeClass('d-none')
                    }else{
                        $('#orderNoteModalView .modal-footer').addClass('d-none')
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



    // Check uncheck active catalogue counter
    var ajaxCountCheckedAll = function() {
        var counter = $(".checkBoxClass:checked").length;
        $(".checkbox-count").html( counter + " hold order selected!" );
        console.log(counter + ' hold order selected!');
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
                $('div.hold-order-select-assign-picker').show(500);
            }else{
                $('div.hold-order-select-assign-picker').hide(500);
            }
        })
    });
    //End Check uncheck active catalogue counter




</script>
