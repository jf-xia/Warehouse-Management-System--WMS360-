


        @foreach($all_completed_order as $completed_order)
            <tr>
                {{--                                                    <td>--}}
                {{--                                                        <input type="checkbox" class=" checkBoxClass" id="customCheck{{$completed_order->id}}" name="multiple_order[]" value="{{$completed_order->id}}" required>--}}
                {{--                                                    </td>--}}
                <td class="order-no" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($completed_order->created_via,$completed_order) !!}</span>
                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                    </div>
                    @if($completed_order->exchange_order_id)
                        (Ex. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($completed_order->exchange_order_id)->order_number ?? ''}}</span>)
                    @endif
                    <span class="append_note{{$completed_order->id}}">
                        @isset($completed_order->order_note)
                            <label class="label label-success view-note" style="cursor: pointer" id="{{$completed_order->id}}" onclick="view_note({{$completed_order->id}});">View Note</label>
                        @endisset
                    </span>
                </td>
                @if($completed_order->status == 'processing')
                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-warning">{{$completed_order->status}}</span></td>
                @elseif($completed_order->status == 'completed')
                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-success">{{$completed_order->status}}</span></td>
                @else
                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($completed_order->status)}}</td>
                @endif
                @if(($completed_order->created_via == 'ebay' || $completed_order->created_via == 'Ebay') && ($completed_order->account_id == null))
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                @elseif(($completed_order->created_via == 'ebay' || $completed_order->created_via == 'Ebay') && ($completed_order->account_id != null))
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    @php
                        $accountInfo = \App\EbayAccount::find($completed_order->account_id);
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
                @elseif($completed_order->created_via == 'amazon')
                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    @php
                        $accountInfo = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($completed_order->account_id);
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
                @elseif($completed_order->created_via == 'shopify')
                    @php
                        $logo = '';
                        $accountName = \App\shopify\shopifyAccount::find($completed_order->account_id);
                        if($accountName){
                            $logo = $accountName->account_logo;
                        }
                    @endphp
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                        <div class="d-flex justify-content-center align-item-center" title="Shopify({{$accountName->account_name ?? ''}})">
                            <img src="{{$logo}}" alt="image" style="height: 40px; width: auto;">
                        </div>
                    </td>
                @elseif($completed_order->created_via == 'checkout')
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
                @elseif($completed_order->created_via == 'onbuy')
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image"></td>
                @elseif($completed_order->created_via == 'rest-api')
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
                @else
                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{ucfirst($completed_order->created_via)}}</td>
                @endif
                @if($completed_order->payment_method == 'paypal' || $completed_order->payment_method == 'PayPal')
                    <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                        <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$completed_order->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$completed_order->payment_method}}"></a>
                    </td>
                @elseif($completed_order->payment_method == 'Amazon')
                    <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$completed_order->payment_method}}">
                        @if(!empty($completed_order->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$completed_order->transaction_id}}" target="_blank">({{$completed_order->transaction_id}})</a>@endif
                    </td>
                @elseif($completed_order->payment_method == 'stripe')
                    <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$completed_order->payment_method}}">
                        @if(!empty($completed_order->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$completed_order->transaction_id}}" target="_blank">({{$completed_order->transaction_id}})</a>@endif
                    </td>
                @elseif($completed_order->payment_method == 'CreditCard')
                    <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$completed_order->payment_method}}" style="width: 65px;height: 50px;"></td>
                @else
                    <td class="payment" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{ucfirst($completed_order->payment_method)}}</td>
                @endif
                <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$completed_order->ebay_user_id ?? ""}}</span>
                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$completed_order->shipping_user_name ?? ''}}</span>
                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="city" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$completed_order->shipping_city ?? ''}}</span>
                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{date('d-m-Y H:i:s',strtotime($completed_order->date_created))}}</td>
                <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{count($completed_order->product_variations)}}</td>
                @if($shelfUse == 1)
                <td class="picker" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->picker_info->name ?? ''}}</td>
                <td class="packer" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->packer_info->name ?? ''}}</td>
                <td class="assigner" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->assigner_info->name ?? ''}}</td>
                @endif
                <td class="total-price" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->total_price}}</td>
                <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->currency}}</td>
                <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                        <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$completed_order->shipping_post_code}}</span>
                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                    </div>
                </td>
                <td class="country" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->shipping_country ?? ''}}</td>
                <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                    {{substr($completed_order->shipping_method ?? 0.0,0,10)}}
                </td>
                <td>
                    <div class="btn-group dropup">
                        <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                        </button>
                        <div class="dropdown-menu">
                            <!-- Dropdown menu links -->
                            <div class="dropup-content">
                                <div class="action-1">
                                    {{--                                                            <a href="{{url('choose-return-product/'.$completed_order->id)}}"><button class="vendor_btn_edit btn-warning w-100 text-center">Return</button></a>--}}
                                    {{-- <a href="{{url('choose-return-product/'.$completed_order->id)}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn mr-2" data-toggle="tooltip" data-placement="top" title="Return Order"><i class="fa fa-undo" aria-hidden="true"></i></button></a> --}}
                                    <button style="cursor: pointer" onclick="dispatchedReturnOrderBtn(this,{{ $completed_order->id }})" class="btn-size order-return-btn mr-2" data-toggle="tooltip" data-placement="top" title="Return Order"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                    @if(!isset($completed_order->order_note))
                                        {{--                                                                <button type="button" class="btn btn-primary btn-sm order-note m-t-5 w-100 text-center append_button{{$completed_order->id}}" id="{{$completed_order->id}}">Add Note</button>--}}
                                        <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note append_button{{$completed_order->id}}" id="{{$completed_order->id}}" data-toggle="tooltip" data-placement="top" title="Add Note"><i class="fas fa-sticky-note" aria-hidden="true"></i></button>
                                    @endif
                                    <a href="{{url('manual-order/'.$completed_order->id)}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn ml-2 mr-2" data-toggle="tooltip" data-placement="top" title="Exchange Return"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></a>

                                    <a style="background:skyblue !important; margin-right:7px;" href="{{url('order/list/pdf/'.$completed_order->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                    <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$completed_order->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="category-modal return-order-modal" id="dispatchedReturnOrder{{ $completed_order->id }}" style="display: none">
                        <div class="cat-header dis-return-order-header">
                            <div>
                                <label id="label_name" class="cat-label">Return order</label>
                            </div>
                            <div class="cursor-pointer" onclick="trashClick(this)">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </div>
                        </div>

                        @php
                            $single_order_product = \App\Order::with(['product_variations'])->find($completed_order->id);
                            // var_dump($single_order_product);
                        @endphp

                        <div class="cat-body return-order-modal-body">
                            <form id="return-reason-form" action="{{url('save-return-order')}}" onsubmit="return returnReasonValidation(event)" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="return-order-product-details">
                                            <div class="font-18 p-2">Product Details</div>
                                            <div class="font-16 return-order-number m-l-5 m-r-5">
                                                <div class="ml-2">Order Number : {{$single_order_product->order_number}}</div>
                                                <div><a class="btn btn-default" data-toggle="modal" data-target="#addModal">Click to Add / Edit / Delete Reason</a></div>
                                            </div>
                                        </div>
                                        {{-- <h5>Order Number : {{$single_order_product->order_number}}</h5> --}}
                                        <div class="m-t-5 m-b-5 m-l-5 m-r-5">
                                            {{-- <h5 class="text-left">Product Details</h5> --}}
                                            <div class="border table-responsive p-2">
                                                <table class="w-100">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%">
                                                                {{-- <input type="checkbox" id="checkAll" onclick="selectAllCheckbox(this)" checked> --}}
                                                                <input type="checkbox" id="checkAll" onclick="selectAllCheckbox(this,{{ $single_order_product->id }})" checked>
                                                            </th>
                                                            <th style="width: 10%">Image</th>
                                                            <th class="text-left" style="width: 25%">Name</th>
                                                            <th class="text-center" style="width: 5%">QR</th>
                                                            <th class="text-center" style="width: 20%">SKU</th>
                                                            <th class="text-center" style="width: 5%">Quantity</th>
                                                            <th class="text-center" style="width: 15%">Return Quantity</th>
                                                            <th class="text-center" style="width: 15%"><div class="chose-retn-pro-price text-center">Price</div></th>
                                                        </tr>
                                                    </thead>

                                                    <input type="hidden" name="return_order" value="{{$single_order_product->id}}">

                                                    <tbody id="returnProduct_{{$single_order_product->id}}">
                                                        @php
                                                            $counter =0;
                                                        @endphp
                                                        @foreach($single_order_product->product_variations as $product)
                                                            <tr>
                                                                <td class="text-center return-order-checkbox" style="width: 5%">
                                                                    <input type="checkbox" checked name="return_product_info[{{$counter}}][product_id]" class="return-qty-check checkBoxClass" id="return_product{{$product->id}}" onclick="select_product(this.value);" value="{{$product->id}}">
                                                                </td>
                                                                <td style="width: 10%"><img class="return-order-modal-img" src="{{ $product->image }}" alt="Return product image"></td>
                                                                <td class="text-left" style="width:25%;">
                                                                    <h7>
                                                                        <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">
                                                                                <a href="{{asset('product-draft')}}/{{$product->product_draft->id ?? ''}}" target="_blank">{{$product->pivot->name}}</a>
                                                                            </span>
                                                                            <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                                        </div>
                                                                    </h7>
                                                                    <input type="hidden" name="return_product_info[{{$counter}}][product_name]" id="return_product_name{{$product->id}}" value="{{$product->pivot->name}}">
                                                                </td>
                                                                <td class="text-center" style="width: 5%">{!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product->sku ?? ''); !!}</td>
                                                                <td class="text-center" style="width: 20%">
                                                                    <h7>
                                                                        <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}} </span>
                                                                            <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                                        </div>
                                                                    </h7>
                                                                </td>
                                                                <td class="text-center" style="width: 5%">
                                                                    <h7>{{$product->pivot->quantity}}</h7>
                                                                    <input type="hidden" name="return_product_info{{$product->id}}" id="quantity{{$product->id}}" value="{{$product->pivot->quantity}}">
                                                                </td>
                                                                <td class="text-center" style="width: 15%">
                                                                    <input type="number" name="return_product_info[{{$counter}}][return_quantity]" id="return_quantity{{$product->id}}" oninput="return_qtn_check({{$product->id}})" class="form-control text-center return-qty-info" value="{{$product->pivot->quantity}}">
                                                                    <div id="err_return_qtn{{$product->id}}" style="color: red;"></div>
                                                                    <input type="hidden" class="product-unit-price" id="unit-price-{{$product->id}}" value="{{ $product->sale_price }}">
                                                                </td>
                                                                <td class="text-center" style="width: 15%">
                                                                    <div class="chose-retn-pro-price text-center">
                                                                        <input type="text" class="form-control text-center" name="return_product_info[{{$counter}}][product_price]" id="return_product_price{{$product->id}}" value="{{$product->pivot->quantity * $product->sale_price}}">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @php
                                                            $counter++;
                                                        @endphp
                                                        @endforeach
                                                    </tbody>

                                                </table>
                                            </div>

                                            @php
                                                $return_reason = \App\ReturnReason::orderByDesc('id')->get();
                                            @endphp

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="mt-4">
                                                        <div class="return-reason-title font-18">Return Reason</div>
                                                        <div class="card b-r-0">
                                                            <div class="return-reason-sec return-reason-sec-{{ $single_order_product->id }} row p-2">
                                                                @isset($return_reason)
                                                                    @foreach($return_reason as $reason)
                                                                    <div class="return-reason reason-color return-reason-{{ $reason->id }} col-md-4 p-1" onclick="returnReasonName({{ $reason->id }}, {{ $single_order_product->id }})">
                                                                        <span id="returnReasonText{{ $reason->id }}">{{$reason->reason}}</span>
                                                                        <input type="hidden" class="return-reason-input" id="returnReason{{ $reason->id }}" value="{{$reason->reason}}">
                                                                    </div>
                                                                    @endforeach
                                                                @endisset
                                                            </div>
                                                            <input type="hidden" class="individual-return-reason" id="individual-return-reason-{{ $single_order_product->id }}" name="return_reasone">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="zzz mt-3">
                                                        <div>
                                                            <input type="text" name="return_cost" onkeyup="dispatchedReturnCost(this)" class="form-control label-pad returncost-without-val" placeholder="Enter Return Cost">
                                                        </div>
                                                        <div class="abc">Return Cost &nbsp;<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span></div>
                                                    </div>
                                                    {{-- <lebel>Return Cost</lebel> --}}
                                                    {{-- <input type="number"name="return_cost" class="form-control">  --}}
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mt-3">
                                                        <button type="submit" id="submit_button" class="btn dispatch-return-order-btn">Submit</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div> <!-- end card -->

                                    </div> <!-- end col-12 -->
                                </div> <!-- end row -->
                            </form>
                        </div>
                    </div>

                    <!--Reason add modal start-->
                    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Return reason information</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="reason" class="col-form-label">Reason:</label>
                                            <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter return reason...">
                                            <input type="hidden" name="update_reason" id="update_reason" value="">
                                        </div>
                                    </form>
                                    <div class="modal-footer border-top-0">
                                        <button class="btn btn-primary ajaxAddUpdateReason add_reason" onclick="addUpdate()">Add</button>
                                    </div>
                                    <h5>All Reason</h5>
                                    <p class="text-success" style="display: none;">Added successfully</p>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Reason</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @isset($return_reason)
                                            @foreach($return_reason as $reason)
                                                <tr id="row_id_{{$reason->id}}">
                                                    <td>{{$reason->reason}}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-start">
                                                            <a class="btn-size edit-btn btn-sm mr-2" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                            <a class="btn-size delete-btn btn-sm" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Reason add modal start-->


                </td>
            </tr>

            <tr>
                <td colspan="17" class="hiddenRow">
                    <div class="accordian-body collapse" id="demo{{$completed_order->order_number}}">
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
                                        @foreach($completed_order->product_variations as $product)
                                            <div class="row pt-2 @if($product->deleted_at != null) bg-danger text-white @endif">
                                                <div class="col-2 text-center">
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
                                                <h7 class="font-weight-bold"> {{$completed_order->total_price}} </h7>
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
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Name </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_user_name}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Phone </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_phone}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 1 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_address_line_1}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 2 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_address_line_2}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Address Line 3 </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_address_line_3}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> City </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_city}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> County </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_county}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Post code </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_post_code}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-2">
                                                        <div class="content-left">
                                                            <h7> Country </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->shipping_country}} </h7>
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
                                                            <h7> : {{$completed_order->customer_name}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Email </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_email}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Phone </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_phone}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> City </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_city}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> County </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_state}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-1">
                                                        <div class="content-left">
                                                            <h7> Post code </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_zip_code}} </h7>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start mb-2">
                                                        <div class="content-left">
                                                            <h7> Country </h7>
                                                        </div>
                                                        <div class="content-right">
                                                            <h7> : {{$completed_order->customer_country}} </h7>
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
            //
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

        </script>


<script>
    // for quantity and return quantity check start
    function return_qtn_check(id){
        var quantity = $('#quantity'+id).val();
        var return_quantity = $('#return_quantity'+id).val();
        var unitPrice = document.getElementById('unit-price-'+id).value
        if(Number(return_quantity) > Number(quantity)){
            console.log(return_quantity);
            console.log(quantity);
            document.getElementById('err_return_qtn'+id).innerHTML = 'Invalid input';
            document.getElementById("submit_button").disabled = true;
        }else{
            document.getElementById('err_return_qtn'+id).innerHTML = '';
            document.getElementById("submit_button").disabled = false;
        }

        var returnProductPrice = return_quantity * unitPrice
        // alert(returnProductPrice)
        $('return_product_price'+id).val(returnProductPrice)
        // document.getElementById('return_product_price'+id).value = returnProductPrice

    }
    // for quantity and return quantity check end


    // for enabled and disabled input field using checkbox start
    function select_product(id){
        var checkBoxCount = $('#return_product'+id).closest('tbody').find('input.checkBoxClass').length
        var checkBoxCheckedCount = $('#return_product'+id).closest('tbody').find('input.checkBoxClass:checkbox:checked').length
        if(checkBoxCount != checkBoxCheckedCount){
            $('#return_product'+id).closest('table').find('input#checkAll').prop('checked',false)
        }
        document.getElementById('return_product'+id).onchange = function() {
            document.getElementById('return_quantity'+id).disabled = !this.checked;
        };
    }
    // for enabled and disabled input field using checkbox end


    function selectAllCheckbox(e,id){
        // console.log(id)
        $('tbody').find('tr:visible input[type=checkbox]').prop('checked', $(e).prop('checked'))
        $('tbody#returnProduct_'+id+' tr').each(function(i, obj){
            if($(this).children().children('input.return-qty-check').is('checked')){
                enable()
            }else{
                disable()
                return false
            }
        })

        function enable(){
            $('tbody#returnProduct_'+id+' tr').each(function(){
                $(this).children().children('input.return-qty-info').prop('disabled',false)
            })
        }

        function disable(){
            $('tbody#returnProduct_'+id+' tr').each(function(){
                $(this).children().children('input.return-qty-info').prop('disabled',true)
            })
        }
    }


    function addUpdate(){
        var reason = $('#reason').val();
        var button_name = $('button.ajaxAddUpdateReason').first().text()
        if(button_name == 'Add'){
            var method = "POST";
            var url = "{{url('return-reason')}}";
        }else if(button_name == 'Update'){
            var method = "PUT";
            var id = $('#update_reason').val();
            var url = "{{url('return-reason')}}"+'/'+id;
        }
        console.log(url);
        $.ajax({
            type: method,
            url: url,
            data: {
                "_token": "{{csrf_token()}}",
                "reason": reason
            },
            success: function (response) {
                console.log(response.data);
                if(button_name == 'Add') {
                    $('.modal-body table tbody').prepend('<tr id="row_id_'+response.data.id+'">' +
                        '<td>' + response.data.reason + '</td>' +
                        '<td>' +
                        '<a class="btn-size edit-btn btn-sm mr-2" style="cursor: pointer; color: #ffffff;" id="'+response.data.id+'"><i class="fa fa-edit" aria-hidden="true"></i></a>' +
                        '<a class="btn-size delete-btn btn-sm" style="cursor: pointer; color: #ffffff;" id="'+response.data.id+'"><i class="fa fa-trash" aria-hidden="true"></i></a>' +
                        '</td>' +
                        '</tr>');
                    $('.modal-body p').show();
                    $('#reason').val('');
                    var reasonNameBtn = ' <div class="return-reason return-reason-'+response.data.id+' col-md-4 p-1" onclick="returnReasonName('+response.data.id+')">'+
                        '    <span>'+ response.data.reason +'</span>'+
                        '    <input type="hidden" class="return-reason-input" id="returnReason'+response.data.id+'" value="'+ response.data.reason +'">'+
                        '</div>'
                    $('div.return-reason-sec').prepend(reasonNameBtn)
                }else if(button_name == 'Update'){
                    $('p.text-success').show().html('Updated successfully');
                    $('#row_id_'+id).children('td').first().html(reason);
                    $('#reason').val('');
                    $('.modal .modal-footer button').removeClass('update_reason');
                    $('.modal .modal-footer button').addClass('add_reason');
                    $('.modal .modal-footer button').text('Add');
                    $('span#returnReasonText'+id).text(reason);
                    $('input#returnReason'+id).val(reason);
                    console.log(response.data);
                }
            }
        });
    }


    $(document).ready(function () {

        $('.modal-body table tbody tr td a.edit-btn').on('click',function () {
            var id = $(this).attr('id');
            var text = $(this).closest('tr').children('td').first().html();
            $('#reason').val(text);
            $('.modal .modal-footer button').removeClass('add_reason');
            $('.modal .modal-footer button').addClass('update_reason');
            $('.modal .modal-footer button').text('Update');
            $('#update_reason').val(id);
            console.log(text);
        });

        $('.modal-body table tbody tr td a.delete-btn').on('click',function () {
            var check = confirm('Are you sure to delete this ?');
            if(check){
                console.log('execute');
                var id = $(this).attr('id');
                $.ajax({
                    type: "DELETE",
                    url: "{{url('return-reason')}}"+'/'+id,
                    data: {
                        "_token": "{{csrf_token()}}",
                    },
                    success: function (response) {
                        $('tr#row_id_'+id).remove();
                        $('div.return-reason-'+id).remove();
                        $('p.text-success').show().html('Deleted successfully');
                        console.log(response.data);
                    }
                });
            }else{
                return false;
            }
        });
    });


    function returnReasonName(id , parentId){
        $('input.individual-return-reason').val(null)
        var reasonName = $('div.return-reason-sec-'+parentId+' span#returnReasonText'+id).text()
        $('input#individual-return-reason-'+parentId).val(reasonName)
        $('div.return-reason-sec-'+parentId+' input#returnReason'+id).closest('div.return-reason-sec-'+parentId).find('div.return-reason').css('background-color','var(--wms-primary-color)')
        $('div.return-reason-sec-'+parentId+' input#returnReason'+id).closest('div.return-reason-sec-'+parentId).find('div.return-reason-'+id).css('background-color','green')
    }


    function returnReasonValidation(event){
        // console.log(event.target)
        var getReasonVal = $(event.target).find('input.individual-return-reason').val()
        console.log(getReasonVal);
        if(getReasonVal == ''){
            Swal.fire({
                icon: 'error',
                title: 'Oops... Select return reason!',
            });
            event.preventDefault();
            return false
        }

    }




</script>
