@extends('master')

@section('title')
    Manual Order List | WMS360
@endsection

@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                <input type="hidden" id="firstKey" value="order">
                <input type="hidden" id="secondKey" value="manual_order_list">
                <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn attr-cat-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"> Manual Order List </li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>




                <!-- Manual order list content start-->
                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box shadow manual-order-list-card table-responsive">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(Session::has('manual_assign_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('manual_assign_success_msg') !!}
                                </div>
                            @endif


                            <!--Form inside search and checkbox button field --->
{{--                            <form class="example m-b-5 m-t-10" action="{{url('order-search')}}" method="post">--}}
{{--                                @csrf--}}

{{--                                <div class="order-search-field pb-2">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <input type="text" class="form-control" placeholder="Search.." name="search">--}}
{{--                                            <input type="hidden" name="status" value="rest-api">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6"></div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row py-2">--}}
{{--                                        <div class="col-md-12 order-checkbox">--}}
{{--                                            <div class="d-flex justify-content-start order-checkbox-content">--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="order_number">&nbsp; Order No &nbsp; &nbsp;</div>--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="created_via">&nbsp; ChannelFactory &nbsp; &nbsp;</div>--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="customer_name">&nbsp; Name &nbsp; &nbsp;</div>--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="customer_country">&nbsp; Country &nbsp; &nbsp;</div>--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="city">&nbsp; City &nbsp; &nbsp;</div>--}}
{{--                                                <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="total_price">&nbsp; Total Price &nbsp; &nbsp;</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6 order-search-btn pb-2">--}}
{{--                                            <button type="submit"><i class="fa fa-search"></i></button>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6"></div>--}}
{{--                                    </div>--}}

{{--                                    <div class="total-r-o">--}}
{{--                                        <span class="total-return-order float-right"> Total Return Order : {{count($all_manual_order)}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </form>--}}
                                <!--// END Form inside search and checkbox button field --->


                                <!----Table form start --->
{{--                            <form action="{{url('picker-assign')}}" method="post">--}}
{{--                                @csrf--}}

{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-10"></div>--}}
{{--                                        <div class="col-md-2">--}}
{{--                                            <select class="form-control" name="picker_id" id="picker_id" style="float:right; margin-bottom: -34px; width: 111%" required>--}}
{{--                                                <option value="">Select Picker</option>--}}
{{--                                                @foreach($all_picker->users_list as $picker)--}}
{{--                                                    <option value="{{$picker->id}}">{{$picker->name}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <button type="submit" class="btn btn-success" style="width: auto; margin-bottom: 4px;">assign</button>--}}



                                <div class="d-flex justify-content-between product-inner p-b-10">
                                    <div class="row-wise-search search-terms">
                                        <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">
                                    </div>
                                    <div class="pagination-area mt-xs-10 mb-xs-5">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$all_manual_order->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                @if($all_manual_order->currentPage() > 1)
                                                <a class="first-page btn {{$all_manual_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_manual_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_manual_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_manual_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_manual_order->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_manual_order->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="manual-order-list">
                                                </span>
                                                @if($all_manual_order->currentPage() !== $all_manual_order->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_manual_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_manual_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                    <span class="screen-reader-text d-none">Last page</span>
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                                @endif
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <table class="manual-order-list-table w-100" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
{{--                                                <th><input type="checkbox" id="ckbCheckAll"  /><label for="selectall"></label></th>--}}
                                            <th>Order No</th>
                                            <th>Status</th>
                                            <th>Channel</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>City</th>
                                            <th>Order Date</th>
                                            <th class="text-center">Order Product</th>
                                            <th class="text-center">Total Price</th>
                                            {{--                                            <th>Actions</th>--}}

                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                    @foreach($all_manual_order as $manual)
                                        <tr>
{{--                                                    <td>--}}
{{--                                                        <input type="checkbox" class=" checkBoxClass" id="customCheck{{$manual->id}}" name="multiple_order[]" value="{{$manual->id}}" required>--}}

{{--                                                    </td>--}}
                                            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->order_number}}</td>
                                            @if($manual->status == 'processing')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><span class="label label-table label-warning label-status">{{$manual->status}}</span></td>
                                            @elseif($manual->status == 'completed')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><span class="label label-table label-success label-status">{{$manual->status}}</span></td>
                                            @else
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><span class="label label-table label-success label-status onhold-status">{{$manual->status}}</span></td>
                                            @endif
                                            @if($manual->created_via == 'ebay')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                                            @elseif($manual->created_via == 'amazon')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="image"></td>
                                            @elseif($manual->created_via == 'checkout')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/tbo.png')}}" alt="image"></td>
                                            @elseif($manual->created_via == 'rest-api')
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/wms.png')}}" alt="image"></td>
                                            @else
                                                <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->created_via}}</td>
                                            @endif
                                            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->customer_name}}</td>
                                            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->customer_country}}</td>
                                            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->customer_city}}</td>
                                            <td style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{date('m-d-Y H:i:s',strtotime($manual->date_created))}}</td>
                                            <td class="text-center" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{count($manual->product_variations)}}</td>
                                            <td class="text-center" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$manual->order_number}}" class="accordion-toggle">{{$manual->total_price}}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="10" class="hiddenRow">
                                                <div class="accordian-body collapse" id="demo{{$manual->order_number}}">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                <div class="border">
                                                                    <div class="row m-t-10">
                                                                        <div class="col-3 text-center">
                                                                            <h6> Name </h6>
                                                                            <hr width="98%">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h6>SKU</h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h6> Quantity </h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h6> Price </h6>
                                                                            <hr width="60%">
                                                                        </div>
                                                                    </div>
                                                                    @foreach($manual->product_variations as $product)
                                                                        <div class="row @if($product->deleted_at != null) bg-danger text-white @endif">
                                                                            <div class="col-3 text-center">
                                                                                <h7> {{$product->pivot->name}} </h7>
                                                                            </div>
                                                                            <div class="col-3 text-center">
                                                                                <h7> {{$product->sku}} </h7>
                                                                            </div>
                                                                            <div class="col-3 text-center">
                                                                                <h7> {{$product->pivot->quantity}} </h7>
                                                                            </div>
                                                                            <div class="col-3 text-center">
                                                                                <h7> {{$product->pivot->price}} </h7>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                    <div class="row m-b-20">
                                                                        <div class="col-3 text-center">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h7 class="font-weight-bold float-right"> Total Price</h7>
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            <h7 class="font-weight-bold"> {{$manual->total_price}} </h7>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="m-t-20 border">
                                                                    <div class="row">
                                                                        <div class="col-1"></div>
                                                                        <div class="col-5">
                                                                            <h6>Shipping</h6>
                                                                            <hr class="m-t-5 float-left" width="60%">
                                                                        </div>

                                                                        <div class="col-5">
                                                                            <h6> Billing </h6>
                                                                            <hr class="m-t-5 float-left" width="60%">
                                                                        </div>
                                                                        <div class="col-1"></div>
                                                                    </div>
                                                                    <div class="row m-b-10">
                                                                        <div class="col-1"></div>
                                                                        <div class="col-5">
                                                                            {!! $manual->shipping !!}
                                                                        </div> <!-- end row 5 -->
                                                                        <div class="col-5">
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> Name : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_name}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> Email : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_email}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> Phone : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_phone}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> City : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_city}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> State : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_state}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> Zip Code : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_zip_code}} </h7>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <h7> Country : </h7>
                                                                                </div>
                                                                                <div class="col-9">
                                                                                    <h7> {{$manual->customer_country}} </h7>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- end row 5 -->

                                                                        <div class="col-1"></div>
                                                                    </div> <!--Billing and shipping inside-->
                                                                </div> <!--Billing and shipping -->
                                                            </div> <!-- end card -->
                                                        </div> <!-- end col-12 -->
                                                    </div> <!-- end row -->
                                                </div> <!-- end accordion body -->
                                            </td> <!-- hide expand td-->
                                        </tr> <!-- hide expand row-->
                                    @endforeach
                                    </tbody>
                                </table>

                                <!--table below pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$all_manual_order->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($all_manual_order->currentPage() > 1)
                                                        <a class="first-page btn {{$all_manual_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_manual_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$all_manual_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_manual_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_manual_order->current_page}} of <span class="total-pages"> {{$all_decode_manual_order->last_page}} </span></span>
                                                        </span>
                                                        @if($all_manual_order->currentPage() !== $all_manual_order->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_manual_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_manual_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                            <span class="screen-reader-text d-none">Last page</span>
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                        @endif
                                                   </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End table below pagination sec-->


{{--                            </form>--}}
                                <!----// END Table form start --->
                        </div> <!--// card box--->
                    </div> <!-- // col-md-12 -->
                </div> <!-- end row --> <!--// END Manual order list content-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->

    <!-- responsive-table-->
{{--    <script src="{{asset('assets/plugins/responsive-table/js/rwd-table.min.js')}}" type="text/javascript"></script>--}}


    <script>

        // datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })


        // Drop down checkbox menu js
        // bootstrap dropdown with checkboxes

        var options = [];

        $( '.dropdown-menu a' ).on( 'click', function( event ) {

            var $target = $( event.currentTarget ),
                val = $target.attr( 'data-value' ),
                $inp = $target.find( 'input' ),
                idx;

            if ( ( idx = options.indexOf( val ) ) > -1 ) {
                options.splice( idx, 1 );
                setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
            } else {
                options.push( val );
                setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
            }

            $( event.target ).blur();

            console.log( options );
            return false;
        });



        // multiple select checkbox
        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
            });
        });

        //Datatable row-wise searchable option
        $(document).ready(function(){
            $("#row-wise-search").on("keyup", function() {
                let value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });

            });
        });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

    </script>



@endsection




