@extends('master')

@section('title')
    All Order | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <style>
        input.loading {
            padding: 10px;
            width: 250px;
        }
        .loading {
            background-color: #ffffff;
            background-image: url("http://loadinggif.com/images/image-selection/3.gif");
            background-size: 25px 25px;
            background-position:right center;
            background-repeat: no-repeat;
        }
        .custom-font {
            font-size: 40px;
            color: #7e57c2;
        }
    </style>


    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content p-t-20 p-b-30" style="display: none; padding-top: 25px; padding-bottom: 25px;">



                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="row content-inner screen-option-responsive-content-inner">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-no" class="onoffswitch-checkbox" id="order-no" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['order-no']) && $setting['order']['order_awaiting_dispatch']['order-no'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['order-no']) && $setting['order']['order_awaiting_dispatch']['order-no'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order No</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-date" class="onoffswitch-checkbox" id="order-date" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['order-date']) && $setting['order']['order_awaiting_dispatch']['order-date'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['order-date']) && $setting['order']['order_awaiting_dispatch']['order-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['status']) && $setting['order']['order_awaiting_dispatch']['status'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['status']) && $setting['order']['order_awaiting_dispatch']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['channel']) && $setting['order']['order_awaiting_dispatch']['channel'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['channel']) && $setting['order']['order_awaiting_dispatch']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="payment" class="onoffswitch-checkbox" id="payment" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['payment']) && $setting['order']['order_awaiting_dispatch']['payment'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['payment']) && $setting['order']['order_awaiting_dispatch']['payment'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="payment">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Payment</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ebay-user-id" class="onoffswitch-checkbox" id="ebay-user-id" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['ebay-user-id']) && $setting['order']['order_awaiting_dispatch']['ebay-user-id'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['ebay-user-id']) && $setting['order']['order_awaiting_dispatch']['ebay-user-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ebay-user-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Ebay User Id</p></div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['name']) && $setting['order']['order_awaiting_dispatch']['name'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['name']) && $setting['order']['order_awaiting_dispatch']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="city" class="onoffswitch-checkbox" id="city" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['city']) && $setting['order']['order_awaiting_dispatch']['city'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['city']) && $setting['order']['order_awaiting_dispatch']['city'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="city">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>City</p></div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-product" class="onoffswitch-checkbox" id="order-product" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['order-product']) && $setting['order']['order_awaiting_dispatch']['order-product'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['order-product']) && $setting['order']['order_awaiting_dispatch']['order-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-price" class="onoffswitch-checkbox" id="total-price" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['total-price']) && $setting['order']['order_awaiting_dispatch']['total-price'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['total-price']) && $setting['order']['order_awaiting_dispatch']['total-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Price</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="currency" class="onoffswitch-checkbox" id="currency" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['currency']) && $setting['order']['order_awaiting_dispatch']['currency'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['currency']) && $setting['order']['order_awaiting_dispatch']['currency'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="currency">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Currency</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-post-code" class="onoffswitch-checkbox" id="shipping-post-code" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['shipping-post-code']) && $setting['order']['order_awaiting_dispatch']['shipping-post-code'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['shipping-post-code']) && $setting['order']['order_awaiting_dispatch']['shipping-post-code'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-post-code">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Post Code</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="country" class="onoffswitch-checkbox" id="country" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['country']) && $setting['order']['order_awaiting_dispatch']['country'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['country']) && $setting['order']['order_awaiting_dispatch']['country'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="country">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Country</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-cost" class="onoffswitch-checkbox" id="shipping-cost" tabindex="0" @if(isset($setting['order']['order_awaiting_dispatch']['shipping-cost']) && $setting['order']['order_awaiting_dispatch']['shipping-cost'] == 1) checked @elseif(isset($setting['order']['order_awaiting_dispatch']['shipping-cost']) && $setting['order']['order_awaiting_dispatch']['shipping-cost'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-cost">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shipping Cost</p></div>
                                    </div>

                                </div>
                            </div>


                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="order">
                            <input type="hidden" id="secondKey" value="order_awaiting_dispatch">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                            <!--Pagination Count and Apply Button Section-->
                            <div class="d-flex justify-content-between pagination-content">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? ''}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                            </div>
                            <!--End Pagination Count and Apply Button Section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Order</li>
                            <li class="breadcrumb-item active" aria-current="page">All Order</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>
                <!--End Breadcrumb section-->


                <!-- Awaiting dispatch content start-->
                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box shadow order-card table-responsive">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {!! Session::get('success') !!}
                                </div>
                            @endif
                            @if(Session::has('assign_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('assign_success_msg') !!}
                                </div>
                            @endif

                            @if(Session::has('message'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! Session::get('message') !!}</strong>
                                </div>
                            @endif

                            @if(Session::has('no_data_found'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{!! Session::get('no_data_found') !!}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif

                        <!--Order Note Modal-->
                            <div class="modal fade" id="orderNoteModal" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Order Note</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class=""></p>
                                            <textarea class="form-control" name="order_note" id="order_note" cols="5" rows="3" placeholder="Type your note here.." required></textarea>
                                            <input type="hidden" name="order_id" id="order_id" value="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary add-note">Add</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Order Note Modal-->


                            <!--start table upper side content-->
                            <div class="product-inner dispatched-order">

                                <!--Awaiting dispatch search area-->
                                <div class="dispatched-search-area">
{{--                                    <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">--}}
{{--                                        <input type="text" class="form-control order-search dispatch-oninput-search ajax-order-search" name="search_oninput" id="search_oninput" placeholder="Search..." required>--}}
{{--                                        <input type="hidden" name="order_search_status" id="order_search_status" value="all-order">--}}
{{--                                    </div>--}}
                                </div>
                                <!--End Awaiting dispatch search area-->

                                <!--Pagination area-->
                                <div class="pagination-area">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_pending_order->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                    @if($all_pending_order->currentPage() > 1)
                                                    <a class="first-page btn {{$all_pending_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_pending_deocde_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_pending_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_pending_deocde_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_pending_deocde_order->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_pending_deocde_order->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="all/order">
                                                    </span>
                                                    @if($all_pending_order->currentPage() !== $all_pending_order->lastPage())
                                                    <a class="next-page btn" href="{{$all_pending_deocde_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_pending_deocde_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                @endif
                                                </span>
                                        </div>
                                    </form>
                                </div>
                                <!--End Pagination area-->
                            </div>
                            <!--End table upper side content-->

                            <!--Awaiting dispatch select picker content-->
                            <div class="awaiting-dispatch-select-picker-content" style="display: none;">
                                @if($shelfUse == 1)
                                    <div class="order-select-picker">
                                        <select class="form-control picker_id select2" name="picker_id" required>
                                            @if(($all_picker->users_list)->count() == 1)
                                                @foreach($all_picker->users_list as $picker)
                                                    <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                @endforeach
                                            @else
                                                <option selected="true" disabled="disabled">Select Picker</option>
                                                @foreach($all_picker->users_list as $picker)
                                                    <option value="{{$picker->id}}">{{$picker->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="select-picker-assign-button">
                                        <button type="button" class="btn btn-primary"> Assign </button>
                                    </div>
                                    <button type="button" class="btn btn-primary awating-dispatch-order-export-csv ml-3" data="awating-dispatch-order-csv">Export CSV</button>
                                @else
                                    <button type="button" class="btn btn-info bulk-complete">Bulk Complete</button>
                                @endif
                                <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                            </div>
                            <!--End awaiting dispatch select picker content-->


                            <!--start table section-->
                            <table class="order-table receive-order w-100" style="border-collapse:collapse;">
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="search_route" value="all/order">
{{--                                    <input type="hidden" name="status" value="processing">--}}
                                    <tr>
                                        <th style="width: 4%; text-align: center"><input type="checkbox" class="ckbCheckAll" id="ckbCheckAll"><label for="selectall"></label></th>
                                        <th class="order-no" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">


                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['order_number'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="order_number" value="{{$allCondition['order_number'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="orderNo_opt_out" type="checkbox" name="orderNo_opt_out" value="1" @isset($allCondition['orderNo_opt_out']) checked @endisset><label for="orderNo_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['order_number']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="order_number" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Order No</div>
                                            </div>
                                        </th>
                                        <th class="order-date" style="width: 20% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['date_created'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="date_created" value="{{$allCondition['date_created'] ?? ''}}" placeholder="D-M-Y or Y-M-D">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="date_created_optout" type="checkbox" name="date_created_optout" value="1" @isset($allCondition['date_created_optout']) checked @endisset><label for="date_created_optout">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="chek_value[]" value="date_created"> -->
                                                        @if(isset($allCondition['date_created']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="date_created" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div>Date</div>
                                            </div>
                                        </th>
                                        <th class="status" style="width: 10%; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['order_status'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control" name="order_status">
{{--                                                            @if($distinct_currency->count() == 1)--}}
{{--                                                                @foreach($distinct_currency as $currency)--}}
{{--                                                                    <option value="{{$currency->currency}}">{{$currency->currency}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            @else--}}

                                                            <option value="" >Select Status</option>  
                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "awaiting dispatch"))
                                                                <option value="awaiting dispatch" selected>Awaiting Dispatch</option>
                                                            {{-- @elseif(isset($allCondition['order_status']))
                                                                <option value="awaiting dispatch">Awaiting Dispatch</option> --}}
                                                            @else
                                                                <option value="awaiting dispatch">Awaiting Dispatch</option>
                                                            @endif

                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "assigned order"))
                                                                <option value="assigned order" selected>Assigned Order</option>
                                                            @else
                                                                <option value="assigned order">Assigned Order</option>
                                                            @endif
                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "hold order"))
                                                                <option value="hold order" selected>Hold Order</option>
                                                            {{-- @elseif(isset($allCondition['order_status']))
                                                                    <option value="hold order">Hold Order</option> --}}
                                                            @else
                                                                <option value="hold order">Hold Order</option>
                                                            @endif
                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "Dispatch Order"))
                                                                <option value="dispatch order" selected>Dispatched Order</option>
                                                            @else
                                                                <option value="dispatch order">Dispatched Order</option>
                                                            @endif
                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "Return Order"))
                                                                <option value="return order" selected>Return Order</option>
                                                            {{-- @elseif(isset($allCondition['order_status']))
                                                                    <option value="return order">Return Order</option> --}}
                                                            @else
                                                                <option value="return order">Return Order</option>
                                                            @endif
                                                            @if(isset($allCondition['order_status']) && ($allCondition['order_status'] == "Cancelled Order"))
                                                                <option value="cancelled order" selected>Cancelled Order</option>
                                                                {{-- @elseif(isset($allCondition['order_status']))
                                                                    <option value="cancelled order">Cancelled Order</option> --}}
                                                            @else
                                                                <option value="cancelled order">Cancelled Order</option>
                                                            @endif

                                                            @if(!isset($allCondition['order_status']))
                                                                <option value="all-status" selected>All Status</option>
                                                            @else
                                                                <option value="all-status">All Status</option>
                                                            @endif
                                                            {{-- @if(!isset($allCondition['status']))
                                                                <option value="">Select Status</option>
                                                                <option value="awaiting dispatch">Awaiting Dispatch</option>
                                                                <option value="assigned order">Assigned Order</option>
                                                                <option value="hold order">Hold Order</option>
                                                                <option value="dispatch order">Dispatched Order</option>
                                                                <option value="return order">Return Order</option>
                                                                <option value="cancelled order">Cancelled Order</option>
                                                            @endif --}}
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="status_optout" type="checkbox" name="status_opt_out" value="1" @isset($allCondition['status_opt_out']) checked @endisset><label for="status_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['order_status']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="order_status" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div> Status </div>
                                            </div>

                                            </th>
                                        <th class="channel filter-symbol" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['channels'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>

                                                        <select class="form-control select2" name="channels[]" multiple>
                                                            <option value="">Manual</option>
                                                            @foreach($channels as $key=> $channel)
                                                                @if($key == "ebay")
                                                                    @foreach($channel as $key => $ebay)
                                                                        @if(isset($allCondition['channels']))
                                                                            @php
                                                                                $existEbayChannel = null;
                                                                                $getebay = 'ebay/'.$ebay;
                                                                            @endphp
                                                                            @foreach($allCondition['channels'] as $ch)
                                                                                @if($getebay == $ch)
                                                                                    <option value="ebay/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                    @php
                                                                                        $existEbayChannel = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existEbayChannel == null)
                                                                                <option value="ebay/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="ebay/{{$ebay}}">{{$ebay}}</option>
                                                                        @endif
                                                                    @endforeach

                                                                @endif
                                                            @endforeach
                                                            @foreach($wooChannels as $key=> $channel)
                                                                @if($key == "checkout")
                                                                    @foreach($channel as $key => $ebay)
                                                                        @if(isset($allCondition['channels']))
                                                                            @php
                                                                                $existEbayChannel = null;
                                                                                $getebay = 'checkout/'.$ebay;
                                                                            @endphp
                                                                            @foreach($allCondition['channels'] as $ch)
                                                                                @if($getebay == $ch)
                                                                                    <option value="checkout/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                    @php
                                                                                        $existEbayChannel = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existEbayChannel == null)
                                                                                <option value="checkout/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="checkout/{{$ebay}}">{{$ebay}}</option>
                                                                        @endif
                                                                    @endforeach

                                                                @endif
                                                            @endforeach
                                                            @foreach($onbuyChannels as $key=> $channel)
                                                                @if($key == "onbuy")
                                                                    @foreach($channel as $key => $ebay)
                                                                        @if(isset($allCondition['channels']))
                                                                            @php
                                                                                $existEbayChannel = null;
                                                                                $getebay = 'onbuy/'.$ebay;
                                                                            @endphp
                                                                            @foreach($allCondition['channels'] as $ch)
                                                                                @if($getebay == $ch)
                                                                                    <option value="onbuy/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                    @php
                                                                                        $existEbayChannel = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existEbayChannel == null)
                                                                                <option value="onbuy/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="onbuy/{{$ebay}}">{{$ebay}}</option>
                                                                        @endif
                                                                    @endforeach

                                                                @endif
                                                            @endforeach
                                                            @if(isset($amazonChannels['amazon']) && count($amazonChannels['amazon']) > 0)
                                                                @foreach($amazonChannels as $key=> $channel)
                                                                    @if($key == "amazon")
                                                                        @foreach($channel as $key => $amazon)
                                                                            @if(isset($allCondition['channels']))
                                                                                @php
                                                                                    $existAmazonChannel = null;
                                                                                    $getamazon = 'amazon/'.$amazon;
                                                                                @endphp
                                                                                @foreach($allCondition['channels'] as $ch)
                                                                                    @if($getamazon == $ch)
                                                                                        <option value="amazon/{{$amazon}}" selected>{{$amazon}}</option>
                                                                                        @php
                                                                                            $existAmazonChannel = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($existAmazonChannel == null)
                                                                                    <option value="amazon/{{$amazon}}">{{$amazon}}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="amazon/{{$amazon}}">{{$amazon}}</option>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="channel_opt_out" type="checkbox" name="channel_opt_out" value="1" @isset($allCondition['channel_opt_out']) checked @endisset><label for="channel_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['channels']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="channels" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div> Channel </div>
                                            </div>
                                        </th>
                                        <th class="payment" style="text-align: center; width: 10%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['payment'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="payment[]" multiple>
                                                            @isset($distinct_payment)
                                                                @if($distinct_payment->count() == 1)
                                                                    @foreach($distinct_payment as $pen_order_payment_method)
                                                                        <option value="{{$pen_order_payment_method->payment_method}}">{{ucfirst($pen_order_payment_method->payment_method)}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach($distinct_payment as $pen_order_payment_method)
                                                                        @if(isset($allCondition['payment']))
                                                                            @php
                                                                                $selected = null;
                                                                            @endphp
                                                                            @foreach($allCondition['payment'] as $ch)
                                                                                @if($pen_order_payment_method->payment_method == $ch)
                                                                                    <option value="{{$pen_order_payment_method->payment_method}}" selected>{{ucfirst($pen_order_payment_method->payment_method)}}</option>
                                                                                    @php
                                                                                        $selected = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($selected == null)
                                                                                <option value="{{$pen_order_payment_method->payment_method}}">{{ucfirst($pen_order_payment_method->payment_method)}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="{{$pen_order_payment_method->payment_method}}">{{ucfirst($pen_order_payment_method->payment_method)}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="payment_opt_out" type="checkbox" name="payment_opt_out" value="1" @isset($allCondition['payment_opt_out']) checked @endisset><label for="payment_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['payment']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="payment" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div> Payment </div>
                                            </div>
                                        </th>
                                        <th class="ebay-user-id" style="width: 20%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['ebay_user_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="ebay_user_id" value="{{$allCondition['ebay_user_id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="ebay_user_id_opt_out" type="checkbox" name="ebay_user_id_opt_out" value="1" @isset($allCondition['ebay_user_id_opt_out']) checked @endisset><label for="ebay_user_id_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['ebay_user_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="ebay_user_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Ebay User ID</div>
                                            </div>
                                        </th>
                                        <th class="name" style="width: 20%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['customer_name'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="customer_name" value="{{$allCondition['customer_name'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="customer_name_optout" type="checkbox" name="customer_name_optout" value="1" @isset($allCondition['customer_name_optout']) checked @endisset><label for="customer_name_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['customer_name']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="customer_name" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Name</div>
                                            </div>
                                        </th>
                                        <th class="city" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['customer_city'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="customer_city" value="{{$allCondition['customer_city'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="customer_city_optout" type="checkbox" name="customer_city_optout" value="1" @isset($allCondition['customer_city_optout']) checked @endisset><label for="customer_city_optout">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="chek_value[]" value="customer_city"> -->
                                                        @if(isset($allCondition['customer_city']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="customer_city" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div>City</div>
                                            </div>
                                        </th>
                                        
                                        <th class="order-product filter-symbol" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['product'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="product_opt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" class="form-control input-text symbol-filter-input-text" name="product" value="{{$allCondition['product'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="product_optout" type="checkbox" name="product_optout" value="1" @isset($allCondition['product_optout']) checked @endisset><label for="product_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div> Product </div>
                                            </div>
                                        </th>
                                        <th class="total-price filter-symbol" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['price'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="price_opt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="price" value="{{$allCondition['price'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="price_optout" type="checkbox" name="price_optout" value="1" @isset($allCondition['price_optout']) checked @endisset><label for="price_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['price']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="price" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Price</div>
                                            </div>
                                        </th>
                                        <th class="currency filter-symbol" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['currency'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control" name="currency">
                                                            {{-- @if($distinct_currency->count() == 1)
                                                                @foreach($distinct_currency as $currency)
                                                                    <option value="{{$currency->currency}}">{{$currency->currency}}</option>
                                                                @endforeach
                                                            @else --}}
                                                                <option value="">Select Currency</option>
                                                                @foreach($distinct_currency as $currency)
                                                                    @if(isset($allCondition['currency']) && ($allCondition['currency'] == $currency->currency))
                                                                        <option value="{{$currency->currency}}" selected>{{$currency->currency}}</option>
                                                                    @else
                                                                        <option value="{{$currency->currency}}">{{$currency->currency}}</option>
                                                                    @endif

                                                                @endforeach
                                                            {{-- @endif --}}
                                                        </select>
                                                        <!-- <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="chek_value[]" value="currency"> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="currency_optout" type="checkbox" name="currency_optout" value="1" @isset($allCondition['currency_optout']) checked @endisset><label for="currency_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['currency']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="currency" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div> Currency </div>
                                            </div>
                                        </th>
                                        <th class="shipping-post-code" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa  @isset($allCondition['shipping_post_code']) text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="shipping_post_code" value="{{$allCondition['shipping_post_code'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="shipping_post_code_optout" type="checkbox" name="shipping_post_code_optout" value="1" @isset($allCondition['shipping_post_code_optout']) checked @endisset><label for="shipping_post_code_optout">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="chek_value[]" value="shipping_post_code"> -->
                                                        @if(isset($allCondition['shipping_post_code']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="shipping_post_code" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div>Post Code</div>
                                            </div>
                                        </th>
                                        <th class="country" style="width: 20%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <!-- <form action="{{url('order-search')}}" method="post">
                                                                @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa  @isset($allCondition['country'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control b-r-0" name="country">
                                                            @isset($distinct_country)
                                                                {{-- @if($distinct_country->count() == 1)
                                                                    @foreach($distinct_country as $order_customer_country)
                                                                        <option value="{{$order_customer_country->customer_country}}">{{$order_customer_country->customer_country}}</option>
                                                                    @endforeach
                                                                @else --}}
                                                                    <option value="">Select Country</option>
                                                                    @foreach($distinct_country as $order_customer_country)
                                                                        @if(isset($allCondition['country']) && ($allCondition['country'] == $order_customer_country->customer_country))
                                                                            <option value="{{$order_customer_country->customer_country}}" selected>{{$order_customer_country->customer_country}}</option>
                                                                        @else
                                                                            <option value="{{$order_customer_country->customer_country}}">{{$order_customer_country->customer_country}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                {{-- @endif --}}
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="country_optout" type="checkbox" name="country_optout" value="1" @isset($allCondition['country_optout']) checked @endisset><label for="country_optout">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="status" value="processing">
                                                        <input type="hidden" name="chek_value[]" value="customer_country"> -->
                                                        @if(isset($allCondition['country']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="country" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                                <div> Country </div>
                                            </div>
                                        </th>
                                        {{-- <th class="shipping-cost filter-symbol" style="width: 10%">Shipping Fees</th> --}}
                                        <th class="shipping-cost filter-symbol" style="width: 10%">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['shipping_fee'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="shipping_fee_opt">
                                                                <option value=""></option>
                                                                <option value="=" @if(isset($allCondition['shipping_fee_opt']) && ($allCondition['shipping_fee_opt'] == '=')) selected @endif>=</option>
                                                                <option value="<" @if(isset($allCondition['shipping_fee_opt']) && ($allCondition['shipping_fee_opt'] == '<')) selected @endif><</option>
                                                                <option value=">" @if(isset($allCondition['shipping_fee_opt']) && ($allCondition['shipping_fee_opt'] == '>')) selected @endif>></option>
                                                                <option value="<=" @if(isset($allCondition['shipping_fee_opt']) && ($allCondition['shipping_fee_opt'] == '≤')) selected @endif>≤</option>
                                                                <option value=">=" @if(isset($allCondition['shipping_fee_opt']) && ($allCondition['shipping_fee_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="shipping_fee" value="{{$allCondition['shipping_fee'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="shipping_fee_optout" type="checkbox" name="shipping_fee_optout" value="1" @isset($allCondition['shipping_fee_optout']) checked @endisset><label for="shipping_fee_optout">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['shipping_fee']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" onclick="not_default_selected(this)" type="submit" name="shipping_fee" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right" onclick="not_default_selected(this)">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </div>
                                                <div>Shipping Fees</div>
                                            </div>
                                        </th>
{{--                                        <th class="shipping-cost filter-symbol" style="width: 10%">Status</th>--}}
                                        <th style="width: 8%">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>Actions</div> &nbsp; &nbsp;
                                                @if(count($allCondition) > 0)
                                                    <div><a title="Clear filters" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                                @endif
                                            </div>
                                        </th>
                                    </tr>
                                </form>
                                </thead>
                                <tbody>
                                @isset($all_pending_order)
                                    @isset($allCondition)
                                    @if(count($all_pending_order) == 0 && count($allCondition) != 0)
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                Swal.fire(
                                                    'No result found',
                                                    '',
                                                    'info'
                                                )
                                            });
                                        </script>
                                    @endif
                                    @endisset
                                @inject('CommonFunction', 'App\Helpers\TraitFromClass')
                                @foreach($all_pending_order as $pending)
                                    <?php // dd($all_pending_order); exit(); ?>
                                    <tr>
                                        <td class="checkboxShowHide{{$pending->id}}" style="width: 4%; text-align: center !important;">
                                            @if(count($pending->product_variations) > 0 && ($pending->is_buyer_message_read !== 0))
                                                <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" value="{{$pending->id}}">
                                            @endif
                                        </td>
                                        <td class="order-no" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            <div class="order_page_tooltip_container d-flex justify-content-center">
                                                <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($pending->created_via,$pending) !!}</span>
                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                            </div>

                                            {{-- Clear filters loader added --}}
                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            @if($pending->exchange_order_id)
                                                (Ex. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($pending->exchange_order_id)->order_number}}</span>)
                                            @endif
                                            <span class="append_note{{$pending->id}}">
                                                        @if(isset($pending->order_note) || ($pending->buyer_message != null))
                                                    <label class="label label-success view-note" style="cursor: pointer" id="{{$pending->id}}" onclick="view_note({{$pending->id}});">View Note</label>
                                                    @if($pending->is_buyer_message_read == 1)
                                                        <label class="label label-danger view-note" style="cursor: pointer" id="unread{{$pending->id}}" onclick="unread({{$pending->id}});">Unread</label>
                                                    @endif
                                                @endif
                                                    </span>
                                            @if($pending->customer_note != null)
                                                <span>
                                                        <label class="label label-danger">Customer Note</label>
                                                    </span>
                                            @endif
                                        </td>
                                        <td class="order-date" style="cursor: pointer; text-align: center !important; width: 20%!important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
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
                                                                Dispatched Order
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
                                                @php
                                                    $logo = '';
                                                    $accountName = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($pending->account_id);
                                                    if($accountName){
                                                        $logo = asset('/').$accountName->application_logo;
                                                    }
                                                @endphp
                                                <div class="d-flex justify-content-center align-item-center" title="Amazon({{$accountName->accountInfo->account_name ?? ''}} {{$accountName->marketPlace->marketplace ?? ''}})">
                                                    <img src="{{$logo}}" alt="image" width="30" height="30">
                                                </div>
                                            @elseif($pending->created_via == 'shopify')
                                            @php
                                                $logo = '';
                                                $accountName = \App\shopify\shopifyAccount::find($pending->account_id);
                                                if($accountName){
                                                    $logo = $accountName->account_logo;
                                                }
                                            @endphp
                                            <div class="d-flex justify-content-center align-item-center" title="Shopify({{$accountName->account_name ?? ''}})">
                                                <img src="{{$logo}}" alt="image" style="height: 40px; width: auto;">
                                            </div>
                                            @elseif($pending->created_via == 'rest-api')
                                                <img src="{{asset('assets/common-assets/wms.png')}}" alt="image">
                                            @elseif($pending->created_via == 'checkout')
                                                <img src="{{asset('assets/common-assets/wooround.png')}}" alt="image">
                                            @elseif($pending->created_via == 'onbuy')
                                                <img src="{{asset('assets/common-assets/onbuy.png')}}" alt="image">
                                            @endif

                                        </td>

                                        @if($pending->payment_method == 'paypal' || $pending->payment_method == 'PayPal')
                                            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                                <a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$pending->transaction_id}}" target="_blank"><img src="{{asset('assets/common-assets/paypal.png')}}" alt="{{$pending->payment_method}}"></a>
                                            </td>
                                        @elseif($pending->payment_method == 'Amazon')
                                            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/amazon-orange-16x16.png')}}" alt="{{$pending->payment_method}}">
                                                @if(!empty($pending->transaction_id))<a href="{{"https://www.paypal.com/cgi-bin/webscr?cmd=_view-a-trans&id=".$pending->transaction_id}}" target="_blank">({{$pending->transaction_id}})</a>@endif
                                            </td>
                                        @elseif($pending->payment_method == 'stripe')
                                            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/stripe.png')}}" alt="{{$pending->payment_method}}">
                                                @if(!empty($pending->transaction_id))<a href="{{"https://dashboard.stripe.com/payments/".$pending->transaction_id}}" target="_blank">({{$pending->transaction_id}})</a>@endif
                                            </td>
                                        @elseif($pending->payment_method == 'CreditCard')
                                            <td class="payment" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/credit-card.png')}}" alt="{{$pending->payment_method}}" style="width: 65px;height: 50px;"></td>
                                        @else
                                            <td class="payment" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{ucfirst($pending->payment_method)}}</td>
                                        @endif
                                        <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->ebay_user_id ?? ""}}</span>
                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="name" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->customer_name}}</span>
                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="city" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->customer_city}}</span>
                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        {{--                                                <td class="order-date" style="cursor: pointer" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{date('d-m-Y H:i:s',strtotime($pending->date_created))}}</td>--}}
                                        
                                        {{--                                                <td class="order-date" style="cursor: pointer; text-align: center !important; width: 20%!important;" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{ \Carbon\Carbon::parse($pending->date_created)->diffForHumans()}}</td>--}}
                                        <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{count($pending->product_variations)}}</td>
                                        <td style="cursor: pointer; text-align: center !important; width: 10%" class="total-price" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->total_price}}</td>
                                        <td class="currency" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->currency}}</td>
                                        <td class="shipping-post-code" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$pending->shipping_post_code}}</span>
                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="country" style="cursor: pointer; text-align: center !important; width: 20%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">{{$pending->customer_country}}</td>
                                        <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo{{$pending->order_number}}" class="accordion-toggle">
                                            {{substr($pending->shipping_method ?? 0.0,0,10)}}
                                        </td>
{{--                                        <td>--}}
{{--                                            {{$pending->status}}--}}
{{--                                            {{$pending->id}}--}}


{{--                                        </td>--}}
                                        <!--Action Button-->
                                        <td style="width: 8%">
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


                                                            <a style="background:skyblue !important;" href="{{url('order/list/pdf/'.$pending->order_number.'/1')}}" class="btn-size cancel-btn order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                            <a style="background:green !important;" href="{{url('order/list/pdf/'.$pending->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!--End Action Button-->
                                    </tr>
                                    <tr>
                                        <td colspan="16" class="hiddenRow">
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
{{--                                                                @php--}}
{{--                                                                    echo "<pre>";--}}
{{--                                                                print_r($pending->product_variations);--}}
{{--                                                                exit();--}}
{{--                                                                @endphp--}}
                                                                @foreach($pending->product_variations as $product)
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
                                                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button id_copy_button_order_product_name">
                                                                                                <a href="{{asset('product-draft')}}/{{$product->product_draft->id ?? ''}}" target="_blank">{{$product->pivot->name}}</a>
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
                                                            <div class="border m-t-20">
                                                                <div class="shipping-billing px-4 py-3">
                                                                    <div class="shipping">
                                                                        <a href="{{url('add-product-empty-order/'.$pending->id)}}" class="btn btn-success btn-sm" target="_blank">Add Product</a>
                                                                        <div class="d-block mb-5">
                                                                            <h6 class="text-left">Shipping </h6>
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
                                                                            <h6 class="text-left"> Billing </h6>
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
                                @endisset
                                </tbody>
                            </table>
                            <!--End table section-->

                            <!--table footer pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num pr-1">{{$all_pending_order->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($all_pending_order->currentPage() > 1)
                                                        <a class="first-page btn {{$all_pending_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_pending_deocde_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                        <a class="prev-page btn {{$all_pending_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_pending_deocde_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$all_pending_deocde_order->current_page}} of <span class="total-pages">{{$all_pending_deocde_order->last_page}}</span></span>
                                                    </span>
                                                    @if($all_pending_order->currentPage() !== $all_pending_order->lastPage())
                                                        <a class="next-page btn" href="{{$all_pending_deocde_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                        <a class="last-page btn" href="{{$all_pending_deocde_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                            <!--End table footer pagination sec-->


                        {{--                            </form>--}}
                        <!----// END Table form --->


                        </div> <!--// card box--->
                    </div> <!-- // col-md-12 -->
                </div>  <!-- END Awaiting dispatch content -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div> <!-- content page -->


    <!--order note modal-->
    <div class="modal fade" id="orderNoteModalView" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Note</h5>
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
    <!--End order note modal-->



    <!--order cancel reason modal -->
    <div class="modal fade" id="orderCancelModalView" tabindex="-1" role="dialog" aria-labelledby="orderNoteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($cancel_reasons)
                        @foreach($cancel_reasons as $reason)
                            <input type="radio" name="cancel_reason" value="{{$reason->id}}/{{$reason->increment_quantity}}" required> {{$reason->reason}} ({{($reason->increment_quantity == 1) ? 'This will increase quantity' : ((($reason->increment_quantity == 0)? 'This will not increase quantity' : 'This will do nothing'))}})<br>
                        @endforeach
                    @endisset
                    {{--                    <input type="radio" name="cancel_reason" value="Out of stock">Out of stock--}}
                    {{--                    <input type="radio" name="cancel_reason" value="Defect">Defect--}}
                    <input type="hidden" name="cancel_order_id" id="cancel_order_id" value="">
                    <input type="hidden" name="cancel_order_route" id="cancel_order_route" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary proceed_cancel_order">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    <!--End order cancel reason modal -->




    <script>

        //Select option jquery
        $('.select2').select2();


        function cancel_order_check(id,route){
            var check = confirm('Do you want to cancel this order ?');
            if(check){
                $('#cancel_order_id').val(id);
                $('#cancel_order_route').val(route);
                $('#orderCancelModalView').modal('show');
                return false;
            }else{
                return false;
            }
            // alert('Do you want to cancel this order ?')
        }

        $(document).ready(function(){
            $('.proceed_cancel_order').on('click',function () {
                var reason = $("input[name='cancel_reason']:checked").val();
                if(reason == undefined){
                    alert('Please select a reason');
                    return false;
                }
                var id = $('#cancel_order_id').val();
                var route = $('#cancel_order_route').val();
                {{--window.location.href = "{{url('processing/cancel-order/'"+id")}}";--}}
                var url_link = "{{url('/')}}";
                var link = url_link+'/'+route+'/cancel-order/'+id+'?reason='+reason;
                window.location.href = link;

                console.log(link);
            });
        });

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table").find(".collapse.in").not(this).collapse('toggle')
        })
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
                        $("#unread"+id).show();
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
                            // infoModal.find('.modal-body-view')[0].innerHTML = info;
                            // infoModal.modal();
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
            $("#ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
            });

            $('.order-note').click(function () {
                var id = $(this).attr('id');
                $('#order_id').val(id);
                $('#orderNoteModal').modal();
            });

            $('.select-picker-assign-button button').click(function () {
                var order_number = [];
                $('table tbody tr td :checkbox:checked').each(function(i){
                    order_number[i] = $(this).val();
                });
                if(order_number.length == 0){
                    alert('Please select an order');
                    return false;
                }
                var picker_id = $('.picker_id').val();
                if(picker_id == ''){
                    alert('Please select a picker');
                    return false;
                }
                console.log(picker_id);
                $.ajax({
                    type: "POST",
                    url: "{{url('picker-assign')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "picker_id" : picker_id,
                        "multiple_order" : order_number
                    },
                    success: function (response) {
                        if(response != 0) {
                            location.reload();
                        }else{
                            alert('Something went wrong');
                        }
                    }
                });
            });

            $('.modal-footer button.add-note').click(function () {
                var order_note = $('textarea#order_note').val();
                if(order_note == ''){
                    alert('Note filed is required.');
                    return false;
                }
                var order_id = $('#order_id').val();
                $.ajax({
                    type: "POST",
                    url:"{{url('add-order-note')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "order_id" : order_id,
                        "order_note" : order_note
                    },
                    success: function (response) {
                        if(response.data !== 'error'){
                            $('.modal-body p').show();
                            $('.modal-body p').html('Note added successfully').addClass('text-success').fadeOut(10000);
                            $('textarea#order_note').val('');
                            var html = '<br><label class="label label-success view-note" style="cursor: pointer" id="'+response.data.order_id+'"  onclick="view_note('+response.data.order_id +');">View Note</label>';
                            $('table tr td span.append_note'+response.data.order_id).html(html);
                            $('table tr td button.append_button'+response.data.order_id).hide();
                        }else{
                            $('.modal-body p').show();
                            $('.modal-body p').html('Something went wrong').addClass('text-danger').fadeOut(10000);
                            $('textarea#order_note').val('');
                        }
                    }
                });
            });
            $('#orderNoteModalView .modal-footer .update-note').click(function () {
                var id = $(this).attr('id');
                var order_note = $('textarea#order_note_view').val();
                if(order_note == ''){
                    alert('Note filed is required.');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url:"{{url('update-order-note')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "id" : id,
                        "note" : order_note
                    },
                    success: function (response) {
                        if(response.data !== 'error'){
                            $('#orderNoteModalView .modal-body-view p').show();
                            $('#orderNoteModalView .modal-body-view p').html('Note updated successfully').addClass('text-success').fadeOut(10000);
                            $('textarea#order_note').val('');
                        }else{
                            $('#orderNoteModalView .modal-body-view p').show();
                            $('#orderNoteModalView .modal-body-view p').html('Something went wrong').addClass('text-danger').fadeOut(10000);
                            $('textarea#order_note').val('');
                        }
                    }
                });
            });
            $('#orderNoteModalView .modal-footer .delete-note').click(function () {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url:"{{url('delete-order-note')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "id" : id
                    },
                    success: function (response) {
                        if(response.data !== 'error'){
                            $('#orderNoteModalView .modal-body-view p').show();
                            $('#orderNoteModalView .modal-body-view p').html('Note delete successfully').addClass('text-success').fadeOut(10000);
                            $('textarea#order_note').val('');
                        }else{
                            $('#orderNoteModalView .modal-body-view p').show();
                            $('#orderNoteModalView .modal-body-view p').html('Something went wrong').addClass('text-danger').fadeOut(10000);
                            $('textarea#order_note').val('');
                        }
                    }
                });
            });

            $('#search_oninput').on('input',function () {
                var search_value = $('#search_oninput').val();
                var order_search_status = $('#order_search_status').val();
                if(search_value.length != '' && search_value.length < 3){
                    return false;
                }
                console.log(order_search_status);
                $.ajax({
                    type: "POST",
                    url: "{{url('complete-order-general-search')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "search_value" : search_value,
                        "order_search_status" : order_search_status
                    },
                    beforeSend:function(){
                        $("#ajax_loader").show()
                    },
                    success: function (response) {
                        console.log(response);
                        $('table tbody tr').remove();
                        $('table tbody').append(response);
                    },
                    complete:function () {
                        $("#ajax_loader").hide()
                    }
                });
            });
        });



        //Datatable row-wise searchable option
        // $(document).ready(function(){
        //     $("#row-wise-search").on("keyup", function() {
        //         let value = $(this).val().toLowerCase();
        //         $("#table-body tr").filter(function() {
        //             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //         });
        //
        //     });
        // });

        //table header-search option toggle
        // $(document).ready(function(){
        //     $(".header-search").click(function(){
        //         $(".header-search-content").toggle();
        //     });
        // });

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
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


        // // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });
        //
        //
        // // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        function deleteOrderProduct(orderId, productId = null){
            const url = "{{url('delete-order-product')}}"+'/'+orderId+'/'+productId
            swal.fire({
                title: 'Are you sure to delete this ?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                        })
                            .done(function(response){
                                if(response.type == 'success'){
                                    swal.fire('Deleted!', response.msg,'success');
                                }
                                if(response.type == 'warning'){
                                    swal.fire('Oops!', response.msg,'warning');
                                }
                                if(response.type == 'error'){
                                    swal.fire('Oops...', response.msg,'error');
                                }

                            })
                            .fail(function(){
                                swal.fire('Oops...', 'Something went wrong with ajax !', 'error');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }


        // Check uncheck active catalogue counter
        var countCheckedAll = function() {
            var counter = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( counter + " awaiting dispatched selected!" );
            console.log(counter + ' awaiting dispatched selected!');
        };

        $(".checkBoxClass").on( "click", countCheckedAll );

        $('.ckbCheckAll').click(function (e) {
            $(this).closest('table').find('td .checkBoxClass').prop('checked', this.checked);
            countCheckedAll();
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

            $('button.bulk-complete').on('click', function () {
                var order_number = [];
                $('table tbody tr td :checkbox:checked').each(function(i){
                    order_number[i] = $(this).val();
                });
                if(order_number.length == 0){
                    Swal.fire('Oops!','Please select a order')
                    return false;
                }
                Swal.fire({
                    title: 'Are you sure to complete your selected order?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{url('bulk-complete-order')}}",
                            data: {
                                "_token" : "{{csrf_token()}}",
                                "multiple_checkbox" : order_number
                            },
                            success: function (response) {
                                if(response != 0){
                                    location.reload();
                                }else{
                                    Swal.fire('Oops!','Something Went Wrong','warning')
                                }
                            }
                        });
                    }
                })
            })

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

            $('.amazon-order-syncronize').click(function(){
                Swal.fire({
                    title: 'Are You Sure To Sync Order From Amazon ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        let url = "{{url('amazon/order-sync/manual')}}"
                        //let token = "{{csrf_token()}}"
                        // let dataObj = {
                        //     orderFetchType: 'manual',
                        // }
                        return fetch(url
                            // ,{
                            //     headers: {
                            //         'Content-Type': 'application/json',
                            //         'Accept': 'application/json',
                            //         'X-Requested-With': 'XMLHttpRequest',
                            //         'X-CSRF-TOKEN': token
                            //     },
                            //     method: 'post',
                            //     body: JSON.stringify(dataObj)
                            // }
                        )
                            .then(response => {
                                if(!response.ok){
                                    throw new Error(response.statusText)
                                }
                                return response.json()
                            })
                            .catch(error => {
                                Swal.showValidationMessage(`Request Failed: ${error}`)
                            })
                    }
                })
                    .then(data => {
                        if(data.isConfirmed){
                            if(data.value.type == 'success'){
                                Swal.fire('Success',data.value.msg,'success')
                            }else{
                                Swal.fire('Oops!',data.value.msg,'error')
                            }
                            setTimeout(() => {
                                window.location.reload()
                            }, 3000);
                        }
                    })
            })
            $('.receive-order').on('click','.ebay-inner-order-note', function(){
                let orderPKId = $(this).attr('id')
                let url = "{{asset('/read-buyer-message')}}"+"/"+orderPKId
                return fetch(url)
                    .then(response => {
                        if(!response.ok){
                            throw new Error(response.statusText);
                        }
                        return response.json()
                    })
                    .then(data => {
                        if(data.type == 'success'){
                            $('table tbody tr td.checkboxShowHide'+orderPKId).html('<input type="checkbox" class="checkBoxClass" id="customCheck'+orderPKId+'" value="'+orderPKId+'">')
                        }
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request Failed: ${error}`)
                    })
            })

            $('button.awating-dispatch-order-export-csv').on('click',function(){
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
        //End Check uncheck active catalogue counter


        //Ebay order note message length controll
        var text = document.querySelector('.buyer-text').innerText;
        var textLength = text.trim().length;
        console.log('Buyer message text is '+textLength);
        if(textLength >= 122){
            $('.ebay-inner-order-note').addClass('buyer-message');
        }

        function not_default_selected(e){
            $('select[name="order_status"] option[value="all-status"]').removeAttr('selected')
        }

    </script>




@endsection
