@isset($searchCancelledOrderList)
    @foreach($searchCancelledOrderList as $cancelledOrder)
        <tr>
            <td class="order-no" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($cancelledOrder->created_via,$cancelledOrder) !!}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
                <span class="append_note{{$cancelledOrder->id}}">
                    @isset($cancelledOrder->order_note)
                        <label class="label label-success view-note" style="cursor: pointer" id="{{$cancelledOrder->id}}" onclick="view_note({{$cancelledOrder->id}});">View Note</label>
                    @endisset
                </span>
            </td>
            @if(($cancelledOrder->created_via == 'ebay' || $cancelledOrder->created_via == 'Ebay') && ($cancelledOrder->account_id == null))
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
            @elseif(($cancelledOrder->created_via == 'ebay' || $cancelledOrder->created_via == 'Ebay') && ($cancelledOrder->account_id != null))
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                @php
                    $accountInfo = \App\EbayAccount::find($cancelledOrder->account_id);
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
            @elseif($cancelledOrder->created_via == 'amazon')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                @php
                    $accountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($cancelledOrder->account_id);
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
            @elseif($cancelledOrder->created_via == 'shopify')
                @php
                    $logo = '';
                    $accountName = \App\shopify\shopifyAccount::find($cancelledOrder->account_id);
                    if($accountName){
                        $logo = $accountName->account_logo;
                    }
                @endphp
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                    <div class="d-flex justify-content-center align-item-center" title="Shopify({{$accountName->account_name ?? ''}})">
                        <img src="{{$logo}}" alt="image" style="height: 40px; width: auto;">
                    </div>
                </td>
            @elseif($cancelledOrder->created_via == 'checkout')
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
            @elseif($cancelledOrder->created_via == 'onbuy')
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image"></td>
            @elseif($cancelledOrder->created_via == 'rest-api')
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
            @else
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{ucfirst($cancelledOrder->created_via)}}</td>
            @endif
            @if($cancelledOrder->payment_method == 'paypal' || $cancelledOrder->payment_method == 'PayPal')
                <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                    <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$cancelledOrder->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$cancelledOrder->payment_method}}"></a>
                </td>
            @elseif($cancelledOrder->payment_method == 'Amazon')
                <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$cancelledOrder->payment_method}}">
                    @if(!empty($cancelledOrder->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$cancelledOrder->transaction_id}}" target="_blank">({{$cancelledOrder->transaction_id}})</a>@endif
                </td>
            @elseif($cancelledOrder->payment_method == 'stripe')
                <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$cancelledOrder->payment_method}}">
                    @if(!empty($cancelledOrder->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$cancelledOrder->transaction_id}}" target="_blank">({{$cancelledOrder->transaction_id}})</a>@endif
                </td>
            @elseif($cancelledOrder->payment_method == 'CreditCard')
                <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$cancelledOrder->payment_method}}" style="width: 65px;height: 50px;"></td>
            @else
                <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{ucfirst($cancelledOrder->payment_method)}}</td>
            @endif
            <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->ebay_user_id ?? ""}}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->customer_name}}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{date('d-m-Y H:i:s',strtotime($cancelledOrder->date_created))}}</td>
            <td class="order-product" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{count($cancelledOrder->product_variations)}}</td>
            <td class="total-price" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->total_price}}</td>
            <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->currency}}</td>
            <td class="shipping-post-code" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->shipping_post_code}}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="country" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->customer_country}}</td>
            <td class="city" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->customer_city}}</span>
                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                </div>
            </td>
            <td class="reason" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                @if(count($cancelledOrder->orderCancelReason) > 0)
                    <span class="">
                        @foreach($cancelledOrder->orderCancelReason as $reason)
                            {{$reason->reason}}
                        @endforeach
                    </span>
                @endif
            </td>
            <td class="cancelled_by" style="width: 10%; text-align: center!important; cursor: pointer" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->cancelled_by_user->name ?? ''}}</td>
            @if($shelfUse == 1)
            <td class="picker" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->picker_info->name ?? ''}}</td>
            <td class="packer" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->packer_info->name ?? ''}}</td>
            <td class="assigner" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->assigner_info->name ?? ''}}</td>
            @endif
            <td class="shipping-cost" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                {{substr($cancelledOrder->shipping_method ?? 0.0,0,10)}}
            </td>
            <td>
                <div class="action-1">
                    <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$cancelledOrder->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                    <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$cancelledOrder->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="17" class="hiddenRow">
                <div class="accordian-body collapse" id="demo{{$cancelledOrder->order_number}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                <div class="border">
                                    <div class="row m-t-10">
                                        <div class="col-2 text-center">
                                            <h6> Image </h6>
                                            <hr class="order-hr" width="60%">
                                        </div>
                                        <div class="col-3 text-center">
                                            <h6> Name </h6>
                                            <hr class="order-hr" width="98%">
                                        </div>
                                        <div class="col-3 text-center">
                                            <h6>SKU</h6>
                                            <hr class="order-hr" width="60%">
                                        </div>
                                        <div class="col-2 text-center">
                                            <h6> Quantity </h6>
                                            <hr class="order-hr" width="60%">
                                        </div>
                                        <div class="col-2 text-center">
                                            <h6> Price </h6>
                                            <hr class="order-hr" width="60%">
                                        </div>
                                    </div>
                                    @foreach($cancelledOrder->product_variations as $product)
                                        <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                            <div class="col-2 text-center">
                                            @isset($product->product_draft->single_image_info->image_url)
                                                @if(isset($product->image))
                                                    <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                                @elseif(isset($product->product_draft->single_image_info->image_url))
                                                    <a href="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}">
                                                        <img src="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" width="50px" height="50px">
                                                    </a>
                                                @endif
                                            @endisset
                                            </div>
                                            <div class="col-3 text-center">
                                                @isset($product->product_draft->single_image_info->image_url)
                                                <h7>
                                                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center mb-1">
                                                        <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">
                                                            <a href="{{asset('product-draft')}}/{{$product->product_draft->id ?? ''}}" target="_blank">{{$product->pivot->name}}</a>
                                                        </span>
                                                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                    </div>
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
                                        <div class="col-8 text-center">
                                        </div>
                                        <div class="col-2 d-flex justify-content-center">
                                            <h7 class="font-weight-bold"> Total Price</h7>
                                        </div>
                                        <div class="col-2 text-center">
                                            <h7 class="font-weight-bold"> {{$cancelledOrder->total_price}} </h7>
                                        </div>
                                    </div>
                                </div>

                                <!--- Shipping Billing --->
                                <div class="m-t-20 border">
                                    <div class="shipping-billing px-3 py-2">
                                        <div class="shipping">
                                            <div class="d-block mb-5">
                                                <h6 class="text-left">Shipping </h6>
                                                <hr class="m-t-5 float-left" width="50%">
                                            </div>
                                            <div class="shipping-content">
                                                @if ($cancelledOrder->shipping_user_name != null)
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Name </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_user_name}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Phone </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_phone}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 1 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_address_line_1}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 2 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_address_line_2}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 3 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_address_line_3}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> City </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_city}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> County </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_county}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Post code </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_post_code}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-2">
                                                        <div class="content-left">
                                                            <h7> Country </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$cancelledOrder->shipping_country}} </h7>
                                                        </div>
                                                    </div>
                                                @else
                                                    {!! $cancelledOrder->shipping !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="billing">
                                            <div class="d-block mb-5">
                                                <h6 class="text-left"> Billing </h6>
                                                <hr class="m-t-5 float-left" width="50%">
                                            </div>
                                            <div class="billing-content">
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Name </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_name}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Email </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_email}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Phone </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_phone}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> City </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_city}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> County </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_state}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Post code </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_zip_code}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-2">
                                                    <div class="content-left">
                                                        <h7> Country </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$cancelledOrder->customer_country}} </h7>
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
@endisset


<!--Order note modal view-->
<div class="modal fade" id="orderNoteModalView" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ordr Note</h5>
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
<!--End Order note modal view-->


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
                    var info = '<strong>Note Create Date : ' + response.data.created_at + '</strong><br>' +
                        '<strong>Note : </strong>\n' +
                        '<p class=""></p>' +
                        '<textarea class="form-control" name="order_note_view" id="order_note_view" cols="5" rows="3" placeholder="Type your note here..">' + response.data.note + '</textarea>\n' +
                        '<strong>Created By : ' + response.data.user_info.name + '</strong>' +
                        '<strong class="pull-right">Modified By : ' + response.data.modifier_info.name + ' (' + response.data.updated_at + ')' + '</strong>'
                    infoModal.find('.modal-body-view')[0].innerHTML = info;
                    infoModal.modal();
                    $('#orderNoteModalView .modal-footer .update-note').attr('id',response.data.id);
                    $('#orderNoteModalView .modal-footer .delete-note').attr('id',response.data.id);
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
                    $(' #search_oninput').addClass('loading');
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




</script>
