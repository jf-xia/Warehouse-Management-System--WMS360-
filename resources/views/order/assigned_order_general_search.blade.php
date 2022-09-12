@inject('CommonFunction', 'App\Helpers\TraitFromClass')
@foreach($all_assigned_order as $assigned)
    <tr>
        <td style="width: 4%; text-align: center !important;">
        @php
            $picking_count = 0;
                foreach ($assigned->product_variations as $variation){
                    $picking_count += $variation->pivot->status;
                    $pickedTime = $CommonFunction->getDateByTimeZone($variation->pivot->updated_at);
                }
        @endphp

{{--            <input type="checkbox" class="checkBoxClass" id="customCheck{{$assigned->id}}" name="multiple_checkbox[]" value="{{$assigned->id}}">--}}
            <input type="checkbox" class="checkBoxClass" id="customCheck{{$assigned->id}}" value="{{$assigned->id}}">

        </td>
        <td class="order-no" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle copyTo">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($assigned->created_via,$assigned) !!}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
            <span class="append_note{{$assigned->id}}">
                @if(isset($assigned->order_note) || (($assigned->buyer_message != null) || ($assigned->buyer_message != '')))
                    <label class="label label-success view-note" style="cursor: pointer" id="{{$assigned->id}}" onclick="view_note({{$assigned->id}});">View Note</label>
                @endif
            </span>
        </td>
        <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            {{$CommonFunction->getDateByTimeZone($assigned->date_created)}}
        </td>
        @if($assigned->status == 'processing')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-warning">{{$assigned->status}}</span></td>
        @elseif($assigned->status == 'completed')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-success">{{$assigned->status}}</span></td>
        @elseif($assigned->status == 'on-hold')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><span class="label label-table label-status label-primary">{{$assigned->status}}</span></td>
        @else
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($assigned->status)}}</td>
        @endif
        @if(($assigned->created_via == 'ebay' || $assigned->created_via == 'Ebay') && ($assigned->account_id == null))
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
        @elseif(($assigned->created_via == 'ebay' || $assigned->created_via == 'Ebay') && ($assigned->account_id != null))
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\EbayAccount::find($assigned->account_id);
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
        @elseif($assigned->created_via == 'amazon')
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($assigned->account_id);
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
        @elseif($assigned->created_via == 'shopify')
                @php
                    $shopify_account_info = \App\shopify\ShopifyAccount::find($assigned->account_id) ?? '';
                @endphp
                    @isset($shopify_account_info)
                    {{-- <img src="{{$shopify_account_info->account_logo ?? ''}}" alt="Shopify({{ $shopify_account_info->account_name ?? '' }})" style="height:40px; width:auto;"> --}}
                    <td title="shopify({{  $shopify_account_info->account_name ?? ''  }})" class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{$shopify_account_info->account_logo ?? ''}}" alt="image" style="height:40px; width:auto;"></td>
                    @endisset
        @elseif($assigned->created_via == 'checkout')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
        @elseif($assigned->created_via == 'onbuy')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image"></td>
        @elseif($assigned->created_via == 'rest-api')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
        @else
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{ucfirst($assigned->created_via)}}</td>
        @endif
        @if($assigned->payment_method == 'paypal' || $assigned->payment_method == 'PayPal')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
                <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$assigned->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$assigned->payment_method}}"></a>
            </td>
        @elseif($assigned->payment_method == 'Amazon')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$assigned->payment_method}}">
                @if(!empty($assigned->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$assigned->transaction_id}}" target="_blank">({{$assigned->transaction_id}})</a>@endif
            </td>
        @elseif($assigned->payment_method == 'stripe')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$assigned->payment_method}}">
                @if(!empty($assigned->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$assigned->transaction_id}}" target="_blank">({{$assigned->transaction_id}})</a>@endif
            </td>
        @elseif($assigned->payment_method == 'CreditCard')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$assigned->payment_method}}" style="width: 65px;height: 50px;"></td>
        @else
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{ucfirst($assigned->payment_method)}}</td>
        @endif
        <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$assigned->ebay_user_id ?? ""}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$assigned->shipping_user_name ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="city" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$assigned->shipping_city ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        
        <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{count($assigned->product_variations)}}</td>
        <td class="picking-status" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">

            {!! (count($assigned->product_variations) == $picking_count) ? '<span class="label label-success label-status" title=".$pickedTime.">Picked</span>' : '<span class="label label-danger label-status">Unpicked</span>'!!}
            {{$picking_count}}/{{count($assigned->product_variations)}}
        </td>
        <td class="packer" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{$assigned->picker_info->name ?? ''}}</td>
        <td class="assigner" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{$assigned->assigner_info->name ?? ''}}</td>
        <td class="total-price" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{$assigned->total_price}}</td>
        <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{$assigned->currency}}</td>
        <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$assigned->shipping_post_code}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="country" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">{{$assigned->shipping_country ?? ''}}</td>
        <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$assigned->order_number}}" class="accordion-toggle">
            {{substr($assigned->shipping_method ?? 0.0,0,10)}}
        </td>
        <td style="width: 6%">
            <div class="btn-group dropup">
                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </button>
                <div class="dropdown-menu">
                    <!-- Dropdown menu links -->
                    <div class="dropup-content">
                        <div class="action-1">
                            @if(count($assigned->product_variations) == $picking_count)
                                <a href="{{route('complete-order.completeOrder',$assigned->id)}}" class="btn-size make-complete-btn mr-2" data-toggle="tooltip" data-placement="top" title="Make Complete"><i class="fa fa-check-square" aria-hidden="true"></i></a>
                            @endif
                            <a href="{{url('hold-assigned-order/'.$assigned->id)}}" class="btn-size hold-order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Hold Order"><i class="fa fa-pause" aria-hidden="true"></i></a>
                            @if(!isset($assigned->order_note))
                                <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note mr-2 append_button{{$assigned->id}}" id="{{$assigned->id}}" data-toggle="tooltip" data-placement="top" title="Add Note"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></button>
                            @endif
                            <a href="{{url('assigned/cancel-order/'.$assigned->id)}}" class="btn-size cancel-btn order-btn mr-2" onclick="return cancel_order_check({{$assigned->id}},'assigned');" data-toggle="tooltip" data-placement="top" title="Cancel Order"><i class="fa fa-window-close" aria-hidden="true"></i></a>

                            <a style="background:skyblue !important" href="{{url('order/list/pdf/'.$assigned->order_number.'/1')}}" class="btn-size cancel-btn order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <a style="background:green !important" href="{{url('order/list/pdf/'.$assigned->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <button type="button" class="btn btn-light btn-sm w-100 border-secondary text-center text-danger create-dpd-order" data="{{$assigned->order_number}}" data-toggle="tooltip" data-placement="top" title="Create DPD Order"><i class="fas fa-shipping-fast"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <!--start hidden row-->
    <tr>
        <td colspan="18" class="hiddenRow">
            <div class="accordian-body collapse" id="demo{{$assigned->order_number}}">
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
                                        <hr class="order-hr" width="98%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6>SKU</h6>
                                        <hr class="order-hr" width="100%">
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6> Quantity </h6>
                                        <hr class="order-hr" width="100%">
                                    </div>
                                    <div class="col-1 text-center">
                                        <h6> Price </h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                </div>

                                @foreach($assigned->product_variations as $product)

                                    <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                        <div class="col-2 text-center">
                                            {!! $product->pivot->status == 1 ? '<span class="label label-success">Picked</span>' : '<span class="label label-danger">Unpicked</span>' !!}
                                            @if(isset($product->image))
                                                <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                            @elseif(isset($product->product_draft->single_image_info->image_url))
                                            <a href="{{isset($product->product_draft->single_image_info) ? ((filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url) : ''}}">
                                                <img src="{{isset($product->product_draft->single_image_info) ? ((filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url) : ''}}" width="50px" height="50px">
                                            </a>
                                            @endif
                                        </div>
                                        <div class="col-3 text-center">
                                            @isset($product->product_draft->single_image_info->image_url)
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">
                                                        <a href="{{asset('product-draft')}}/{{$product->product_draft->id ?? ''}}" target="_blank">{{$product->pivot->name}}</a>
                                                    </span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                                <div class="mt-3">
                                                    @if($product->pivot->status != 1)
                                                        <a href="{{url('exchange-order-product/'.$product->pivot->id ?? '')}}" class="label label-table label-success" target="_blank">Edit</a>
                                                    @endif
                                                    <a href="Javascript:void(0)" class="label label-table label-danger" onclick="deleteOrderProduct({{$assigned->id}},{{$product->pivot->id ?? ''}},{{$product->pivot->status}})">Delete</a>
                                                </div>
                                            </h7>
                                            @endisset
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-5 card">
                                                    <h7 class="product-sku" id="id{{$product->id}}h">
                                                        <div class="order_page_tooltip_container d-flex justify-content-start align-items-center">
                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button" style="@if($product->deleted_at != null) color: black !important @endif">{{$product->sku}}</span>
                                                            <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                        </div>
                                                    </h7>
                                                </div>
                                                <div class="col-3">
                                                    <img  id="id{{$product->id}}ok" src="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" id="id{{$product->id}}"  onclick="myFunction(event);return false;" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-4">
                                                    <input class="o{{$assigned->order_number}} form-control" id="id{{$product->id}}q" oninput="quantity({{$product->id}})" type="text" value="0"><div class="m-t-5 m-l-5" id="id{{$product->id}}f"></div>
                                                </div>
                                                <div class="col-4">
                                                    <img  id="id{{$product->id}}eq" src="">
                                                </div>
                                                <div class="col-4 product-pivot">
                                                    <div class="card">
                                                        <div class="m-l-5 product-pivot-quantity"> {{$product->pivot->quantity}}   <input class="o{{$assigned->order_number}}" id="id{{$product->id}}aq" type="hidden" value="{{$product->pivot->quantity}}">  </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-1 text-center">
                                            <h7> {{$product->pivot->price}} </h7>
                                        </div>
                                    </div>

                                @endforeach

                                <div class="row m-b-20 mt-3">
                                    <div class="col-8"> </div>
                                    <div class="col-3 text-center">
                                        <h7 class="float-right font-weight-bold"> Total Price</h7>
                                    </div>
                                    <div class="col-1 text-center">
                                        <h7 class="font-weight-bold"> {{$assigned->total_price}} </h7>
                                    </div>
                                </div>
                            </div>


                            <!--- Shipping Billing --->
                            <div class="m-t-20 border">
                                <div class="shipping-billing px-4 py-3">
                                    <div class="shipping">
                                    <a href="{{url('add-product-empty-order/'.$assigned->id)}}" class="btn btn-success btn-sm" target="_blank">Add Product</a>
                                        <div class="d-block mb-5">
                                            <h6 class="text-left">Shipping
                                                <span class="ml-1"><button type="button" class="btn btn-outline-primary edit-address" data="{{$assigned->id}}" shipping-type="shipping">Edit</button></span>
                                            </h6>
                                            <hr class="m-t-5 float-left" width="50%">
                                        </div>
                                        <div class="shipping-content">
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Name </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_user_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 1 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_address_line_1}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 2 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_address_line_2}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Address Line 3 </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_address_line_3}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_county}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_post_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->shipping_country}} </h7>
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
                                                    <h7> : {{$assigned->customer_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Email </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_email}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_state}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_zip_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$assigned->customer_country}} </h7>
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
    </tr>
    <!--End  hide expand row-->
@endforeach

<!--Modal-->
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
                <button type="button" class="btn btn-primary update-note">update</button>
                <button type="button" class="btn btn-danger delete-note">Delete</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->


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
                            '<strong>Created By : ' + response.data.user_info.name + '</strong>' +
                            '<strong class="pull-right">Modified By : ' + response.data.modifier_info.name + ' (' + response.data.updated_at + ')' + '</strong>'
                        infoModal.find('.modal-body-view')[0].innerHTML = info;
                        infoModal.modal();
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


    // Check uncheck active catalogue counter
    var ajaxCountCheckedAll = function() {
        var counter = $(".checkBoxClass:checked").length;
        $(".checkbox-count").html( counter + " assigned order selected!" );
        console.log(counter + ' assigned order selected!');
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
                $('div.assigned-order-bulk-complete').show(500);
            }else{
                $('div.assigned-order-bulk-complete').hide(500);
            }
        })
    });
    //End Check uncheck active catalogue counter



</script>
