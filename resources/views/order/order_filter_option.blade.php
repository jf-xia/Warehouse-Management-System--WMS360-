@foreach($all_completed_order as $completed_order)
    <tr>
        {{--                                                    <td>--}}
        {{--                                                        <input type="checkbox" class=" checkBoxClass" id="customCheck{{$completed_order->id}}" name="multiple_order[]" value="{{$completed_order->id}}" required>--}}
        {{--                                                    </td>--}}
        <td class="order-no" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
            {{$completed_order->order_number}}
            <span class="append_note{{$completed_order->id}}">
                                                    @isset($completed_order->order_note)
                    <br><label class="label label-success view-note" style="cursor: pointer" id="{{$completed_order->id}}" onclick="view_note({{$completed_order->id}});">View Note</label>
                @endisset
                                                    </span>
        </td>
        @if($completed_order->status == 'processing')
            <td class="status" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-warning">{{$completed_order->status}}</span></td>
        @elseif($completed_order->status == 'completed')
            <td class="status" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-success">{{$completed_order->status}}</span></td>
        @else
            <td class="status">{{$completed_order->status}}</td>
        @endif
        @if($completed_order->created_via == 'ebay')
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/ebay-42x16.png')}}" alt="image"></td>
        @elseif($completed_order->created_via == 'amazon')
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/amazon-orange-16x16.png')}}" alt="image"></td>
        @elseif($completed_order->created_via == 'checkout')
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/tbo.png')}}" alt="image"></td>
        @elseif($completed_order->created_via == 'onbuy')
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/onbuy.png')}}" alt="image"></td>
        @elseif($completed_order->created_via == 'rest-api')
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/wms.png')}}" alt="image"></td>
        @else
            <td class="channel" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->created_via}}</td>
        @endif
        @if($completed_order->payment_method == 'paypal')
            <td class="payment" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/paypal.png')}}" alt="{{$completed_order->payment_method}}">
                @if(!empty($completed_order->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$completed_order->transaction_id}}" target="_blank">({{$completed_order->transaction_id}})</a>@endif
            </td>
        @elseif($completed_order->payment_method == 'Amazon')
            <td class="payment" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/amazon-orange-16x16.png')}}" alt="{{$completed_order->payment_method}}">
                @if(!empty($completed_order->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$completed_order->transaction_id}}" target="_blank">({{$completed_order->transaction_id}})</a>@endif
            </td>
        @elseif($completed_order->payment_method == 'stripe')
            <td class="payment" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><img src="{{asset('uploads/stripe.png')}}" alt="{{$completed_order->payment_method}}">
                @if(!empty($completed_order->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$completed_order->transaction_id}}" target="_blank">({{$completed_order->transaction_id}})</a>@endif
            </td>
        @else
            <td class="payment" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->payment_method}}</td>
        @endif
        <td class="currency" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->currency}}</td>
        <td class="name" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->customer_name}}</td>
        <td class="country" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->customer_country}}</td>
        <td class="city" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->customer_city}}</td>
        <td class="order-date" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{date('d-m-Y H:i:s',strtotime($completed_order->date_created))}}</td>
        <td class="order-product" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{count($completed_order->product_variations)}}</td>
        <td class="picker" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->picker_info->name}}</td>
        <td class="packer" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->packer_info->name}}</td>
        <td class="assigner" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->assigner_info->name}}</td>
        <td class="shipping-cost" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
            {{--                                                @php $shipping_method = json_decode($completed_order->shipping_method)[0]; @endphp--}}
            {{ json_decode($completed_order->shipping_method)[0]->total ?? null}}
        </td>
        <td class="total-price" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{$completed_order->total_price}}</td>
        <td class="actions form_action">
            <a href="{{url('choose-return-product/'.$completed_order->id)}}"><button class="vendor_btn_edit btn-primary w-100 text-center">Return</button></a>
            @if(!isset($completed_order->order_note))
                <button type="button" class="btn btn-primary btn-sm order-note m-t-5 w-100 text-center append_button{{$completed_order->id}}" id="{{$completed_order->id}}">Add Note</button>
            @endif
            {{--                                                        <a href="" ><button class="vendor_btn_view btn-success">View</button></a>&nbsp;--}}
            {{--                                                        <form action="" method="post">--}}
            {{--                                                            <a href="#" class="on-default remove-row" ><button class="vendor_btn_delete btn-danger" onclick="">Delete</button>  </a>--}}
            {{--                                                        </form>--}}
        </td>
    </tr>

    <tr>
        <td colspan="16" class="hiddenRow">
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
                                    <div class="row pt-2">
                                        <div class="col-2 text-center">
                                            @if(isset($product->image))
                                                <a href="{{$product->image}}"><img src="{{$product->image}}" width="50px" height="50px"></a>
                                            @else
                                                <a href="{{$product->product_draft->single_image_info->image_url ?? null}}"><img src="{{$product->product_draft->single_image_info->image_url ?? null}}" width="50px" height="50px"></a>
                                            @endif
                                        </div>
                                        <div class="col-3 text-center">
                                            <h7> {{$product->pivot->name}} </h7>
                                        </div>
                                        <div class="col-3 text-center">
                                            <h7> {{$product->sku}} </h7>
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
                            <div style="border: 1px solid #ccc" class="m-t-20">
                                <div class="shipping-billing px-3 py-2">
                                    <div class="shipping">
                                        <div class="d-block mb-5">
                                            <h6 class="text-left">Shipping (<span class="text-success">{{ json_decode($completed_order->shipping_method)[0]->method_title ?? null}},{{ json_decode($completed_order->shipping_method)[0]->method_id ?? null}}</span>)</h6>
                                            <hr class="m-t-5 float-left" width="50%">
                                        </div>
                                        <div class="shipping-content">
                                            {!! $completed_order->shipping !!}
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
                                                    <h7> State </h7>
                                                </div>
                                                <div class="content-right">
                                                    <h7> : {{$completed_order->customer_state}} </h7>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-start mb-1">
                                                <div class="content-left">
                                                    <h7> Zip Code </h7>
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
<tr>
    <td colspan="2">
        <p>Paginate</p>
        <select class="form-control select_opt_btn_ajax">
{{--        <ul class="pagination">--}}
            @for($i = 1; $i <= $page; $i++)
                <option value="{{$i}}" @if($i == $page_number) selected @endif>{{$i}}</option>
{{--                @if($i == $page_number)--}}
{{--                    <li style="margin: 5px;border: 1px solid black;background: #9ec1a6;">--}}
{{--                        <a href="#" class="select_opt_btn_ajax" style="margin: 5px;">{{$i}}</a>--}}
{{--                    </li>--}}
{{--                @else--}}
{{--                    <li style="margin: 5px;border: 1px solid black;">--}}
{{--                        <a href="#" class="select_opt_btn_ajax" style="margin: 5px;">{{$i}}</a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--                <br>--}}
            @endfor
{{--        </ul>--}}
        </select>
{{--        <button class="btn btn-primary">Load More</button>--}}
    </td>
<tr>
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
            $('.select_opt_btn_ajax').on('change',function () {
                var search_value = $('.search_filter_option').val();
                var status = $('.select_opt_status').val();
                var column = $('.select_opt_column').val();
                var column_arr = [];
                var page = $(this).val();
                column_arr.push(column);
                // var filter_optio = $('.select_opt_chk').val();
                var filter_option = 0;
                if ($('input.select_opt_chk').is(':checked')) {
                    var filter_option = 1;
                }
                console.log(page);
                $.ajax({
                    type : "post",
                    url : "{{url('order-search-filter-option')}}",
                    data : {
                        "_token" : "{{csrf_token()}}",
                        "search" : search_value,
                        "column" : column_arr,
                        "status" : status,
                        "filter_option" : filter_option,
                        "page_number" : page
                    },
                    beforeSend: function () {
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        $('table tbody').html(response);
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                });
            })
        });
        $('.order-note').click(function () {
            var id = $(this).attr('id');
            $('#order_id').val(id);
            $('#orderNoteModal').modal();
        });

    </script>

