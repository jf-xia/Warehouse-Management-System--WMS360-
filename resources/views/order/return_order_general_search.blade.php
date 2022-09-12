@inject('CommonFunction', 'App\Helpers\TraitFromClass')
@foreach($all_return_order as $return_order)
    <tr>
        <td class="order-no" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($return_order->orders->created_via,$return_order->orders) !!}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
            @if($return_order->orders->exchange_order_id)
                (Ex. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($return_order->orders->exchange_order_id)->order_number ?? ''}}</span>)
            @endif
            <span class="append_note{{$return_order->order_id}}">
                @isset($return_order->order_note)
                    <label class="label label-success view-note" style="cursor: pointer" id="{{$return_order->order_id}}" onclick="view_note({{$return_order->order_id}});">View Note</label>
                @endisset
            </span>
        </td>
        <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            {{$CommonFunction->getDateByTimeZone($return_order->orders->date_created)}}
        </td>
        <td class="return-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            {{$CommonFunction->getDateByTimeZone($return_order->created_at)}}
        </td>
        <td class="returned_by" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->returned_by_user->name ?? ''}}</td>
        @if($return_order->orders->status == 'processing')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><span class="label label-table label-status label-warning">{{$return_order->orders->status}}</span></td>
        @elseif($return_order->orders->status == 'completed')
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><span class="label label-table label-status label-success">{{$return_order->orders->status}}</span></td>
        @else
            <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($return_order->orders->status)}}</td>
        @endif
        @if(($return_order->orders->created_via == 'ebay' || $return_order->orders->created_via == 'Ebay') && ($return_order->orders->account_id == null))
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->orders->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
        @elseif(($return_order->orders->created_via == 'ebay' || $return_order->orders->created_via == 'Ebay') && ($return_order->orders->account_id != null))
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->orders->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\EbayAccount::find($return_order->orders->account_id);
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
        @elseif($return_order->orders->created_via == 'amazon')
        <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->orders->order_number}}" class="accordion-toggle">
            @php
                $accountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($return_order->orders->account_id);
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
        @elseif($return_order->orders->created_via == 'checkout')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
        @elseif($return_order->orders->created_via == 'onbuy')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image"></td>
        @elseif($return_order->orders->created_via == 'rest-api')
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
        @else
            <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{ucfirst($return_order->orders->created_via)}}</td>
        @endif
        @if($return_order->orders->payment_method == 'paypal' || $return_order->orders->payment_method == 'PayPal')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$return_order->orders->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$return_order->orders->payment_method}}"></a>
            </td>
        @elseif($return_order->orders->payment_method == 'Amazon')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$return_order->orders->payment_method}}">
                @if(!empty($return_order->orders->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$return_order->orders->transaction_id}}" target="_blank">({{$return_order->orders->transaction_id}})</a>@endif
            </td>
        @elseif($return_order->orders->payment_method == 'stripe')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$return_order->orders->payment_method}}">
                @if(!empty($return_order->orders->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$return_order->orders->transaction_id}}" target="_blank">({{$return_order->orders->transaction_id}})</a>@endif
            </td>
        @elseif($return_order->orders->payment_method == 'CreditCard')
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->orders->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$return_order->orders->payment_method}}" style="width: 65px;height: 50px;"></td>
        @else
            <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{ucfirst($return_order->orders->payment_method)}}</td>
        @endif
        <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$return_order->orders->shipping_user_name ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="city" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$return_order->orders->shipping_city ?? ''}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        
        <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{count($return_order->return_product_save)}}</td>
        <td class="total-price" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->orders->total_price}}</td>
        <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->orders->currency}}</td>
        <td class="return-reason" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->return_reason}}</td>
        <td class="return-cost" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->return_cost}}</td>
        <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$return_order->orders->shipping_post_code}}</span>
                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
            </div>
        </td>
        <td class="country" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{$return_order->orders->shipping_country ?? ''}}</td>
        <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
            {{substr($return_order->orders->shipping_method ?? 0.0,0,10)}}
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
                            @if(count($return_order->return_product_save) > 0)
                                {{--                                                                    <a href="{{url('catalogue-product-invoice-receive/'.($return_order->return_product_save[0]->product_draft_id ?? 0).'/'.$return_order->order_id.'/return/'.$return_order->id)}}"    --}}
                                {{--                                                                       class="btn btn-success btn-sm m-b-5 w-100 text-center" target="_blank">Restock</a>--}}
                                <a href="{{url('catalogue-product-invoice-receive/'.($return_order->return_product_save[0]->product_draft_id ?? 0).'/'.$return_order->order_id.'/return/'.$return_order->id)}}"
                                   class="btn-size restock-btn mr-2" target="_blank" data-toggle="tooltip" data-placement="top" title="Restock"><i class="fas fa-exchange-alt"></i></a>
                            @endif
                            @if(!isset($return_order->order_note))
                                {{--                                                                        <button type="button" class="btn btn-primary btn-sm w-100 order-note append_button{{$return_order->order_id}}" id="{{$return_order->order_id}}">Add Note</button>--}}
                                <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note append_button{{$return_order->order_id}}" id="{{$return_order->order_id}}" data-toggle="tooltip" data-placement="top" title="Add Note"><i class="fas fa-sticky-note"></i></button>
                                    <a href="{{url('manual-order/'.$return_order->order_id.'/return')}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn mr-2" data-toggle="tooltip" data-placement="top" title="Exchange Return"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></a>
                            @endif
                            <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$return_order->orders->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$return_order->orders->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <td colspan="18" class="hiddenRow">
            <div class="accordian-body collapse" id="demo{{$return_order->id}}">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                            <div class="border" style="border: 1px solid #ccc;">
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
                                        <h6> Return Quantity </h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                    <div class="col-2 text-center">
                                        <h6> Price </h6>
                                        <hr class="order-hr" width="60%">
                                    </div>
                                </div>
                                @foreach($return_order->return_product_save as $product)
                                    <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                        <div class="col-2 text-center">
                                            @if(isset($product->image))
                                                <a href="{{$product->image}}" target="_blank">
                                                    <img src="{{$product->image}}" width="50px" height="50px">
                                                </a>
                                            @elseif(isset($product->product_draft->single_image_info->image_url))
                                                <a href="{{$product->image}}" target="_blank">
                                                    <img src="{{(filter_var($product->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product->product_draft->single_image_info->image_url : $product->product_draft->single_image_info->image_url}}" width="50px" height="50px">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-3 text-center">
                                            @isset($product->product_draft->single_image_info->image_url)
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center mb-1">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">
                                                        <a href="{{asset('product-draft')}}/{{$product->product_draft->id}}" target="_blank">{{$product->pivot->product_name}}</a>
                                                    </span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                                @if($product->pivot->status == 1)
                                                    <buttton type="button" class="btn btn-success btn-sm">Shelved</buttton>
                                                @else
                                                    <span class="text-danger" id="btn_change_id{{$product->pivot->id}}">(Not shelved)
                                                        <buttton type="button" class="btn btn-primary btn-sm" onclick="shelve_return_product('{{$product->pivot->id}}')">Click to Shelve</buttton>
                                                    </span>
                                                @endif
                                            </h7>
                                            @endisset
                                        </div>
                                        <div class="col-3 text-center">
                                            <h7>
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center mb-1">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </h7>
                                        </div>
                                        <div class="col-2 text-center">
                                            <h7> {{$product->pivot->return_product_quantity}} </h7>
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
                                        <h7 class="font-weight-bold"> Return Cost</h7>
                                    </div>
                                    <div class="col-2 text-center">
                                        <h7 class="font-weight-bold"> {{$return_order->return_cost}} </h7>
                                    </div>
                                </div>
                            </div>

                            <!--- Shipping Billing --->
                            <div class="m-t-20 border">
                                <div class="shipping-billing px-3 py-2">
                                    <div class="shipping">
                                        <div class="d-block mb-5">
                                            <h6>Shipping </h6>
                                            <hr class="m-t-5 float-left" width="50%">
                                        </div>
                                        <div class="shipping-content">
                                            @if ($return_order->orders->shipping_user_name != null)
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Name </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_user_name}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Phone </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_phone}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Address Line 1 </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_address_line_1}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Address Line 2 </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_address_line_2}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Address Line 3 </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_address_line_3}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> City </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_city}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> County </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_county}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-1">
                                                    <div class="content-left">
                                                        <h7> Post code </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_post_code}} </h7>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-start mb-2">
                                                    <div class="content-left">
                                                        <h7> Country </h7>
                                                    </div>
                                                    <div class="content-right">
                                                        <h7> : {{$return_order->orders->shipping_country}} </h7>
                                                    </div>
                                                </div>
                                            @else
                                                {!! $return_order->orders->shipping !!}
                                            @endif
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
                                                    <h7> : {{$return_order->orders->customer_name}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Email </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_email}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Phone </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_phone}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> City </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_city}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> County </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_state}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Post code </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_zip_code}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-2">
                                                <div class="content-left">
                                                    <h7> Country </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$return_order->orders->customer_country}} </h7>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--Billing and shipping -->
                        </div> <!-- end card -->
                    </div> <!-- end col-md-12 -->
                </div> <!-- end row -->
            </div> <!-- end accordion body -->
        </td> <!-- hide expand td-->
    </tr> <!-- hide expand row-->
@endforeach

<!--Modal note view modal-->
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
<!--End Modal note view modal-->


<script>
    //-datatable toogle collapse/expand
    // $('.accordian-body').on('show.bs.collapse', function () {
    //     $(this).closest("table")
    //         .find(".collapse.in")
    //         .not(this)
    //         .collapse('toggle')
    // });



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




    //Window local storage
    // $(function() {
    //     // get data from storage and convert from string to array
    //     var hiddenCols = JSON.parse(localStorage.getItem('hidden-cols') || '[]'),
    //         $checkBoxes = $('.onoffswitch-checkbox'),
    //         $rows = $('#local-storage tr');
    //
    //     // loop over array and hide appropriate columns and check appropriate checkboxes
    //     $.each(hiddenCols, function(i, col) {
    //         $checkBoxes.filter('[name=' + col + ']').prop('checked', true)
    //         $rows.find('.' + col).hide();
    //     });
    //
    //     $checkBoxes.change(function() {
    //         // toggle appropriate column class
    //         $('table .' + this.name).toggle(!this.checked);
    //         // create and store new array
    //         hiddenCols = $checkBoxes.filter(':checked').map(function() {
    //             return this.name;
    //         }).get();
    //         logHiddenCols();
    //         localStorage.setItem('hidden-cols', JSON.stringify(hiddenCols))
    //     });
    //
    //     logHiddenCols();
    //     // demo helper function
    //     function logHiddenCols(){
    //         console.log(hiddenCols)
    //     }
    // })
    //End Window local storage



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


</script>
