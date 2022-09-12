@extends('master')

@section('title')
   Hold Order | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">


                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content p-t-30 p-b-30" style="display: none; padding-top: 25px; padding-bottom: 25px;">

                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="row content-inner screen-option-responsive-content-inner">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-no" class="onoffswitch-checkbox" id="order-no" tabindex="0" @if(isset($setting['order']['hold_order']['order-no']) && $setting['order']['hold_order']['order-no'] == 1) checked @elseif(isset($setting['order']['hold_order']['order-no']) && $setting['order']['hold_order']['order-no'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order No</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-date" class="onoffswitch-checkbox" id="order-date" tabindex="0" @if(isset($setting['order']['hold_order']['order-date']) && $setting['order']['hold_order']['order-date'] == 1) checked @elseif(isset($setting['order']['hold_order']['order-date']) && $setting['order']['hold_order']['order-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['order']['hold_order']['status']) && $setting['order']['hold_order']['status'] == 1) checked @elseif(isset($setting['order']['hold_order']['status']) && $setting['order']['hold_order']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['order']['hold_order']['channel']) && $setting['order']['hold_order']['channel'] == 1) checked @elseif(isset($setting['order']['hold_order']['channel']) && $setting['order']['hold_order']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="payment" class="onoffswitch-checkbox" id="payment" tabindex="0" @if(isset($setting['order']['hold_order']['payment']) && $setting['order']['hold_order']['payment'] == 1) checked @elseif(isset($setting['order']['hold_order']['payment']) && $setting['order']['hold_order']['payment'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="payment">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Payment</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ebay-user-id" class="onoffswitch-checkbox" id="ebay-user-id" tabindex="0" @if(isset($setting['order']['hold_order']['ebay-user-id']) && $setting['order']['hold_order']['ebay-user-id'] == 1) checked @elseif(isset($setting['order']['hold_order']['ebay-user-id']) && $setting['order']['hold_order']['ebay-user-id'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['order']['hold_order']['name']) && $setting['order']['hold_order']['name'] == 1) checked @elseif(isset($setting['order']['hold_order']['name']) && $setting['order']['hold_order']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="city" class="onoffswitch-checkbox" id="city" tabindex="0" @if(isset($setting['order']['hold_order']['city']) && $setting['order']['hold_order']['city'] == 1) checked @elseif(isset($setting['order']['hold_order']['city']) && $setting['order']['hold_order']['city'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="city">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>City</p></div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-product" class="onoffswitch-checkbox" id="order-product" tabindex="0" @if(isset($setting['order']['hold_order']['order-product']) && $setting['order']['hold_order']['order-product'] == 1) checked @elseif(isset($setting['order']['hold_order']['order-product']) && $setting['order']['hold_order']['order-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-price" class="onoffswitch-checkbox" id="total-price" tabindex="0" @if(isset($setting['order']['hold_order']['total-price']) && $setting['order']['hold_order']['total-price'] == 1) checked @elseif(isset($setting['order']['hold_order']['total-price']) && $setting['order']['hold_order']['total-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="hold-by" class="onoffswitch-checkbox" id="hold-by" tabindex="0" @if(isset($setting['order']['hold_order']['hold-by']) && $setting['order']['hold_order']['hold-by'] == 1) checked @elseif(isset($setting['order']['hold_order']['hold-by']) && $setting['order']['hold_order']['hold-by'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="hold-by">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Hold By</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="currency" class="onoffswitch-checkbox" id="currency" tabindex="0" @if(isset($setting['order']['hold_order']['currency']) && $setting['order']['hold_order']['currency'] == 1) checked @elseif(isset($setting['order']['hold_order']['currency']) && $setting['order']['hold_order']['currency'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="currency">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Currency</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-post-code" class="onoffswitch-checkbox" id="shipping-post-code" tabindex="0" @if(isset($setting['order']['hold_order']['shipping-post-code']) && $setting['order']['hold_order']['shipping-post-code'] == 1) checked @elseif(isset($setting['order']['hold_order']['shipping-post-code']) && $setting['order']['hold_order']['shipping-post-code'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-post-code">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Post Code</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="country" class="onoffswitch-checkbox" id="country" tabindex="0" @if(isset($setting['order']['hold_order']['country']) && $setting['order']['hold_order']['country'] == 1) checked @elseif(isset($setting['order']['hold_order']['country']) && $setting['order']['hold_order']['country'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="country">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Country</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-cost" class="onoffswitch-checkbox" id="shipping-cost" tabindex="0" @if(isset($setting['order']['hold_order']['shipping-cost']) && $setting['order']['hold_order']['shipping-cost'] == 1) checked @elseif(isset($setting['order']['hold_order']['shipping-cost']) && $setting['order']['hold_order']['shipping-cost'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="hold_order">
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
                            <li class="breadcrumb-item active" aria-current="page">Hold Order</li>
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



                <!-- Hold order content start-->
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

                            @if(Session::has('assign_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('assign_success_msg') !!}
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {!! Session::get('success') !!}
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

                            <!--Form inside search and checkbox button field --->
{{--                            <form class="example m-b-5 m-t-10" action="{{url('order-search')}}" method="post">--}}
{{--                                @csrf--}}

{{--                                <div class="order-search-field pb-2">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6 s-f-cursor">--}}
{{--                                            <input class="form-control" type="text" placeholder="Search.." name="search">--}}
{{--                                            <input type="hidden" name="status" value="on-hold">--}}
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
{{--                                        <div class="col-md-6 order-search-btn">--}}
{{--                                            <button type="submit"><i class="fa fa-search"></i></button>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                --}}
{{--                            </form>--}}
                                <!-- // END Form inside search and checkbox button field --->

                                <!--Modal start-->
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
                                <!--End Modal-->


                                    <!--Hold order search area-->
{{--                                    <div class="row datatip-right">--}}
{{--                                        <div class="col-md-8"></div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">--}}
{{--                                                <input type="text" class="form-control order-search" name="search_oninput" id="search_oninput" placeholder="Search...">--}}
{{--                                                <input type="hidden" name="order_search_status" id="order_search_status" value="on-hold">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                   <!--End Hold order search area-->


                                    <!--start table upper side content-->
                                    <div class="product-inner dispatched-order">
                                        <div class="dispatched-search-area">
                                            <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">
                                                <input type="text" class="form-control order-search dispatch-oninput-search ajax-order-search" name="search_oninput" id="search_oninput" placeholder="Search...">
                                                <input type="hidden" name="order_search_status" id="order_search_status" value="on-hold">
                                            </div>
                                        </div>

                                        <!--Pagination area-->
                                        <div class="pagination-area">
                                            <form action="{{url('pagination-all')}}" method="post">
                                                @csrf
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num">{{$all_hold_order->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($all_hold_order->currentPage() > 1)
                                                        <a class="first-page btn {{$all_hold_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_hold_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$all_hold_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_hold_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_hold_order->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_hold_order->last_page}}</span></span>
                                                            <input type="hidden" name="route_name" value="hold/order/list">
                                                        </span>
                                                        @if($all_hold_order->currentPage() !== $all_hold_order->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_hold_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_hold_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                                    <div class="hold-order-select-assign-picker" style="display: none;">
                                        @if($shelfUse == 1)
                                            <div class="order-select-picker">
                                                <select class="form-control picker_id select2 on-hold-assign-picker-id" name="picker_id" required>
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
                                                <button type="submit" class="btn btn-default on-hold-assign-picker"> Assign </button>
                                            </div>
                                            <div class="checkbox-count font-16 ml-md-3 ml-sm-3 a-d-count"></div>
                                        @endif
                                    </div>

                                   <!--start table section-->
                                    <table class="order-table w-100" style="border-collapse:collapse;" id="orderTable">
                                        <thead>
                                            <form action="{{url('all-column-search')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="search_route" value="hold/order/list">
                                                <input type="hidden" name="status" value="on-hold">
                                                <tr>
                                                    @if($shelfUse == 1)
                                                        <th class="text-center"><input type="checkbox" class="ckbCheckAll" id="ckbCheckAll"><label for="selectall"></label></th>
                                                    @endif
                                                    <th class="order-no" style="width: 10%; text-align: center;">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">

                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['order_number'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="text" class="form-control input-text" name="order_number" id="orderNo" value="{{$allCondition['order_number'] ?? ''}}">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="orderNo_opt_out" type="checkbox" name="orderNo_opt_out" value="1" @isset($allCondition['orderNo_opt_out']) checked @endisset><label for="orderNo_opt_out">Opt Out</label>
                                                                    </div>
                                                                    @if(isset($allCondition['order_number']))
                                                                        <div class="individual_clr">
                                                                            <button title="Clear filters" type="submit" name="order_number" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>

                                                        </div>
                                                        <div>Order No</div>
                                                    </div>
                                                    </th>
                                                    <th class="order-date" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['date_created'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <input type="text" class="form-control input-text" name="date_created" value="{{$allCondition['date_created'] ?? ''}}" placeholder="D-M-Y or Y-M-D">
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="date_created_optout" type="checkbox" name="date_created_optout" value="1" @isset($allCondition['date_created_optout']) checked @endisset><label for="date_created_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['date_created']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="date_created" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div>Date</div>
                                                        </div>
                                                    </th>
                                                    <th class="status filter-symbol" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['status'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <select class="form-control select2" name="status">
                                                                            @isset($distinct_status)
                                                                                @if($distinct_status->count() == 1)
                                                                                    @foreach($distinct_status as $onhold_exchangehold)
                                                                                        <option value="{{$onhold_exchangehold->status}}">{{ucfirst($onhold_exchangehold->status)}}</option>
                                                                                    @endforeach
                                                                                @else
                                                                                    <option selected value = "">Select Status</option>
                                                                                    @foreach($distinct_status as $onhold_exchangehold)
                                                                                        @if(isset($allCondition['status']) && ($allCondition['status'] == $onhold_exchangehold->status))
                                                                                            <option value="{{$onhold_exchangehold->status}}" selected>{{ucfirst($onhold_exchangehold->status)}}</option>
                                                                                        @else
                                                                                            <option value="{{$onhold_exchangehold->status}}">{{ucfirst($onhold_exchangehold->status)}}</option>
                                                                                        @endif

                                                                                    @endforeach
                                                                                @endif
                                                                            @endisset
                                                                        </select>
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="status_optout" type="checkbox" name="status_optout" value="1" @isset($allCondition['status_optout']) checked @endisset><label for="status_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['status']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="status" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right mt-3">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div> Status </div>
                                                        </div>
                                                    </th>
                                                    <th class="channel filter-symbol" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['channels'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <select class="form-control select2" name="channels[]" multiple>
                                                                            @isset($allChannels)
                                                                                @foreach($allChannels as $channel)
                                                                                    @if(isset($allCondition['channels']))
                                                                                        @php
                                                                                            $existChannel = null;
                                                                                            $getChannel = $channel['account'];
                                                                                        @endphp
                                                                                        @foreach($allCondition['channels'] as $ch)
                                                                                            @if($getChannel == $ch)
                                                                                                <option value="{{$channel['account']}}" selected>{{$channel['channel']}}</option>
                                                                                                @php
                                                                                                    $existChannel = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        @if($existChannel == null)
                                                                                            <option value="{{$channel['account']}}">{{$channel['channel']}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option value="{{$channel['account']}}">{{$channel['channel']}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endisset
                                                                        </select>
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="channel_opt_out" type="checkbox" name="channel_opt_out" value="1" @isset($allCondition['channel_opt_out']) checked @endisset><label for="channel_opt_out">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['channels']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="channels" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div> Channel </div>
                                                        </div>
                                                    </th>
                                                    <th class="payment" style="width: 15%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['payment'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <select class="form-control select2" name="payment[]" multiple>
                                                                            @isset($distinct_payment)
                                                                                {{-- @if($distinct_payment->count() == 1)
                                                                                    @foreach($distinct_payment as $pen_order_payment_method)
                                                                                        <option value="{{$pen_order_payment_method->payment_method}}">{{ucfirst($pen_order_payment_method->payment_method)}}</option>
                                                                                    @endforeach
                                                                                @else --}}
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
                                                                                {{-- @endif --}}
                                                                            @endisset
                                                                        </select>
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="payment_opt_out" type="checkbox" name="payment_opt_out" value="1" @isset($allCondition['payment_opt_out']) checked @endisset><label for="payment_opt_out">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['payment']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="payment" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
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
                                                    <th class="name" style="width: 10%; text-align: center;">
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
                                                                                <button title="Clear filters" type="submit" name="customer_name" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div>Name</div>
                                                        </div>
                                                    </th>
                                                    <th class="city" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['customer_city'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <input type="text" class="form-control input-text" name="customer_city" value="{{$allCondition['customer_city'] ?? ''}}">
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="customer_city_optout" type="checkbox" name="customer_city_optout" value="1" @isset($allCondition['customer_city_optout']) checked @endisset><label for="customer_city_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['customer_city']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="customer_city" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div>City</div>
                                                        </div>
                                                    </th>
                                                    
                                                    <th class="order-product filter-symbol" style="text-align: center; width: 10%">
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
                                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
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
                                                                                    @if(isset($allCondition['price_opt']))
                                                                                        @if($allCondition['price_opt'] == '=')
                                                                                            <option value="=" selected>=</option>
                                                                                        @else
                                                                                            <option value="=" >=</option>
                                                                                        @endif
                                                                                        @if($allCondition['price_opt'] == '<')
                                                                                            <option value="<" selected><</option>
                                                                                        @else
                                                                                            <option value="<"><</option>
                                                                                        @endif
                                                                                        @if($allCondition['price_opt'] == '>')
                                                                                            <option value=">" selected>></option>
                                                                                        @else
                                                                                            <option value=">">></option>
                                                                                        @endif
                                                                                        @if($allCondition['price_opt'] == '<=')
                                                                                            <option value="<=" selected>≤</option>
                                                                                        @else
                                                                                            <option value="<=">≤</option>
                                                                                        @endif
                                                                                        @if($allCondition['price_opt'] == '>=')
                                                                                            <option value=">=" selected>≥</option>
                                                                                        @else
                                                                                            <option value=">=">≥</option>
                                                                                        @endif
                                                                                    @else
                                                                                            <option value="=">=</option>
                                                                                            <option value="<"><</option>
                                                                                            <option value=">">></option>
                                                                                            <option value="<=">≤</option>
                                                                                            <option value=">=">≥</option>
                                                                                    @endif
                                                                                </select>
                                                                                <!-- <select class="form-control" name="price_opt">
                                                                                <option value=""></option>
                                                                                <option value="=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '=')) selected @endif>=</option>
                                                                                <option value="<" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '<')) selected @endif><</option>
                                                                                <option value=">" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '>')) selected @endif>></option>
                                                                                <option value="<=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '<=')) selected @endif>≤</option>
                                                                                <option value=">=" @if(isset($allCondition['price_opt']) && ($allCondition['price_opt'] == '>=')) selected @endif>≥</option>
                                                                                </select> -->
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
                                                                                <button title="Clear filters" type="submit" name="price" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div>Price</div>
                                                        </div>
                                                    </th>
                                                    <th class="hold-by filter-symbol" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                        <i class="fa @isset($allCondition['hold-by'])text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <select class="form-control select2 b-r-0" name="hold-by">
                                                                            @isset($userInfo)
                                                                                {{-- @if($userInfo->count() == 1)
                                                                                    @foreach($userInfo as $user)
                                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                    @endforeach
                                                                                @else --}}
                                                                                    <option selected value="">Select Assigner</option>
                                                                                    @foreach($userInfo as $user)
                                                                                        @if(isset($allCondition['hold-by']) && ($allCondition['hold-by'] == $user->id))
                                                                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                                        @else
                                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                {{-- @endif --}}
                                                                            @endisset
                                                                        </select>

                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="hold_by_optout" type="checkbox" name="hold_by_optout" value="1" @isset($allCondition['hold_by_optout']) checked @endisset><label for="hold_by_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['hold-by']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="hold-by" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div> Hold By </div>
                                                        </div>
                                                    </th>
                                                    <th class="currency filter-symbol" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

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

                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="currency_optout" type="checkbox" name="currency_optout" value="1" @isset($allCondition['currency_optout']) checked @endisset><label for="currency_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['currency']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="currency" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div> Currency </div>
                                                        </div>
                                                    </th>
                                                    <th class="shipping-post-code" style="text-align: center !important; width: 10%">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

                                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                        <i class="fa  @isset($allCondition['shipping_post_code']) text-warning @endisset" aria-hidden="true"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                                        <p>Filter Value</p>
                                                                        <input type="text" class="form-control input-text" name="shipping_post_code" value="{{$allCondition['shipping_post_code'] ?? ''}}">
                                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                            <input id="shipping_post_code_optout" type="checkbox" name="shipping_post_code_optout" value="1" @isset($allCondition['shipping_post_code_optout']) checked @endisset><label for="shipping_post_code_optout">Opt Out</label>
                                                                        </div>
                                                                        @if(isset($allCondition['shipping_post_code']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="shipping_post_code" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div>Post Code</div>
                                                        </div>
                                                    </th>
                                                    <th class="country" style="width: 10%; text-align: center;">
                                                        <div class="d-flex justify-content-center">
                                                            <div class="btn-group">

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
                                                                        @if(isset($allCondition['country']))
                                                                            <div class="individual_clr">
                                                                                <button title="Clear filters" type="submit" name="country" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                    </div>

                                                            </div>
                                                            <div> Country </div>
                                                        </div>
                                                    </th>
                                                    {{-- <th class="shipping-cost filter-symbol" style="width: 10%">Shipping Cost</th> --}}
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
                                                                            <button title="Clear filters" type="submit" name="shipping_fee" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>
                                                            </div>
                                                            <div>Shipping Fees</div>
                                                        </div>
                                                    </th>
                                                    <th style="width: 6%">
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
                                        @isset($all_hold_order)
                                            @isset($allCondition)
                                            @if(count($all_hold_order) == 0 && count($allCondition) != 0)
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
                                        @foreach($all_hold_order as $hold)
                                            <tr>
                                                @if($shelfUse == 1)
                                                    <td style="width: 4%; text-align: center !important;">
                                                        <input type="checkbox" class="checkBoxClass" id="customCheck{{$hold->id}}" value="{{$hold->id}}">
                                                    </td>
                                                @endif
                                                <td class="order-no" style="width: 10%; text-align: center !important;">
                                                    <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                        <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($hold->created_via,$hold) !!}</span>
                                                        <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                    </div>
                                                    @if($hold->exchange_order_id)
                                                        (Ac. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($hold->exchange_order_id)->order_number ?? ''}}</span>)
                                                    @endif
                                                    <span class="append_note{{$hold->id}}">
                                                        @isset($hold->order_note)
                                                            <label class="label label-success view-note" style="cursor: pointer" id="{{$hold->id}}" onclick="view_note({{$hold->id}});">View Note</label>
                                                         @endisset
                                                    </span>

                                                    {{-- Clear filters loader added --}}
                                                    <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                </td>
                                                <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
                                                    {{$CommonFunction->getDateByTimeZone($hold->date_created)}}
                                                </td>
                                                @if($hold->status == 'processing')
                                                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-warning label-status">{{$hold->status}}</span></td>
                                                @elseif($hold->status == 'completed')
                                                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-success label-status">{{$hold->status}}</span></td>
                                                @elseif($hold->status == 'on-hold')
                                                    <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle"><span class="label label-table label-primary label-status">{{$hold->status}}</span></td>
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
                                                @elseif($hold->created_via == 'shopify')
                                                    @php
                                                        $logo = '';
                                                        $accountName = \App\shopify\shopifyAccount::find($hold->account_id);
                                                        if($accountName){
                                                            $logo = $accountName->account_logo;
                                                        }
                                                    @endphp
                                                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
                                                        <div class="d-flex justify-content-center align-item-center" title="Shopify({{$accountName->account_name ?? ''}})">
                                                            <img src="{{$logo}}" alt="image" style="height: 40px; width: auto;">
                                                        </div>
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
                                                <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$hold->order_number}}" class="accordion-toggle">
                                                    {{substr($hold->shipping_method ?? 0.0,0,10)}}
                                                </td>
                                                <!--Action Button-->
                                                <td class="note_btn_append{{$hold->id}}" style="width: 6%">
                                                        <!-- <div class="btn-group dropup">
                                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Manage
                                                                </button>
                                                                    <div class="dropdown-menu">
                                                                        <div class="dropup-content">
                                                                            <div class="action-1">
                                                                                <a href="{{url('unhold-order/'.$hold->id)}}" class="btn-size hold-order-btn mr-2" data-toggle="tooltip" data-placement="top" title="Unhold Order"><i class="fa fa-pause" aria-hidden="true"></i></a>
                                                                                @if(!isset($hold->order_note))
                                                                                    <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note mr-2 append_button{{$hold->id}}" data-toggle="tooltip" data-placement="top" title="Add Note" id="{{$hold->id}}"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></button>
                                                                                @endif
                                                                                <a href="{{url('hold/cancel-order/'.$hold->id)}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Cancel" onclick="return cancel_order_check({{$hold->id}},'hold');"><i class="fa fa-window-close" aria-hidden="true"></i></a>

                                                                                <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$hold->order_number)}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                                <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$hold->order_number)}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div> -->
                                                    <a href="{{url('unhold-order/'.$hold->id)}}"><button class="btn btn-default btn-sm m-b-5 w-100 text-success">Unhold</button></a>
                                                    @if(!isset($hold->order_note))
                                                        <a href="#"><button type="button" class="btn btn-primary btn-sm order-note label-status m-b-5 w-100 append_button{{$hold->id}}" id="{{$hold->id}}">Add Note</button></a>
                                                    @endif
                                                        <a href="{{url('hold/cancel-order/'.$hold->id)}}" class="btn btn-danger order-btn m-b-5 w-100 text-center" onclick="return cancel_order_check({{$hold->id}},'hold');">Cancel</a>
                                                        <button type="button" class="btn btn-success btn-sm m-b-5 w-100 text-center create-royal-mail-order" data="{{$hold->order_number}}" style="background-color: #d42024 !important; color: #ffca00 !important">Create RM Order</button>
                                                        <button type="button" class="btn btn-light btn-sm m-b-5 w-100 border-secondary text-center text-danger create-dpd-order" data="{{$hold->order_number}}">Create DPD Order</button>
                                                        <div class="action-1">
                                                            <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$hold->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                            <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$hold->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                        </div>
                                                        </td>
                                                <!--End Action Button-->
                                            </tr>

                                            <!--hidden row start-->
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
                                                                                        <div class="mt-3">
                                                                                            <a href="{{url('exchange-order-product/'.$product->pivot->id)}}" class="label label-table label-success" target="_blank">Edit</a>
                                                                                        </div>
                                                                                    </h7>
                                                                                    @endisset
                                                                                </div>
                                                                                <div class="col-3 text-center">
                                                                                    <h7>
                                                                                        <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}} </span>
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
                                                                        <div class="shipping-billing px-4 py-3">
                                                                            <div class="shipping">
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
                                                                                    <h6 class="text-left"> Billing </h6>
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
                                            </tr>
                                            <!--End hidden row-->

                                        @endforeach
                                        @endisset
                                        </tbody>
                                    </table>
                                    <!--End table section-->


                                <!--table footer pagination sec-->
                                <div class="row table-foo-sec">
                                    <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-md-end align-items-center py-2">
                                            <div class="pagination-area">
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num pr-1">{{$all_hold_order->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($all_hold_order->currentPage() > 1)
                                                            <a class="first-page btn {{$all_hold_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_hold_order->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                            <a class="prev-page btn {{$all_hold_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_hold_order->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_hold_order->current_page}} of <span class="total-pages">{{$all_decode_hold_order->last_page}}</span></span>
                                                        </span>
                                                        @if($all_hold_order->currentPage() !== $all_hold_order->lastPage())
                                                            <a class="next-page btn" href="{{$all_decode_hold_order->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                            <a class="last-page btn" href="{{$all_decode_hold_order->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

{{--                                </div>  <!--// END Table plugin start--->--}}
{{--                            </form> --}}
                                <!----// END Table form start --->
                        </div> <!--// card box--->
                    </div> <!-- // col-md-12 -->
                </div> <!-- end row --> <!--// END Hold order content start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->

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
    <!--End Modal-->




    <!--Modal Start-->
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
    <!--End Modal-->




    <script>

        // select  option dropdown
        $('.select2').select2();
        // select  option dropdown

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


        // Drop down checkbox menu js

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

        // Drop down checkbox menu js






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
                            console.log(response.data);
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
                        $('table tbody').html(response);
                    },
                    complete:function () {
                        $("#ajax_loader").hide()
                    }
                });
            });

            $('.on-hold-assign-picker').on('click',function () {
                var picker_id = $('.on-hold-assign-picker-id').val();
                if(picker_id == ''){
                    alert('Please select a picker');
                    return false;
                }
                var order_number = [];
                $('table tbody tr td :checkbox:checked').each(function(i){
                    order_number[i] = $(this).val();
                });
                if(order_number.length == 0){
                    alert('Please select an order');
                    return false;
                }
                console.log(order_number);
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
            })
        });







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


        // Check uncheck active catalogue counter
        var countCheckedAll = function() {
            var counter = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( counter + " hold order selected!" );
            console.log(counter + ' hold order selected!');
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
                    $('div.hold-order-select-assign-picker').show(500);
                }else{
                    $('div.hold-order-select-assign-picker').hide(500);
                }
            })

            $('tbody').on('click','.create-royal-mail-order',function(){
                var orderNumber = $(this).attr('data')
                if((orderNumber == '') || (orderNumber == 'undefined') || (orderNumber == null)){
                    Swal.fire('Oops!','Order Number Not Found','error')
                    return false
                }
                var url = "{{url('create-royal-mail-order')}}"
                var token = "{{csrf_token()}}"
                var html = '<div class="form-group">'
                                +'<label class="required">Weight In Grams</label>'
                                +'<input type="text" class="form-control" id="weight_in_gram" placeholder="Enter The Parcel Weight" required>'
                            +'</div>'
                            +'<div class="form-group">'
                                +'<label class="required">Package Format</label>'
                                +'<select class="form-control" id="package_format" required>'
                                +'<option value="">Select Package</option>'
                                +'<option value="letter">Letter</option>'
                                +'<option value="largeLetter">LargeLetter</option>'
                                +'<option value="smallParcel">SmallParcel</option>'
                                +'<option value="mediumParcel">MediumParcel</option>'
                                +'<option value="parcel">Parcel</option>'
                                +'<option value="documents">Documents</option>'
                                +'<option value="undefined">Undefined</option>'
                                +'</select>'
                            +'</div>'
                            +'<div class="form-group">'
                                +'<label>Special Instruction</label>'
                                +'<input type="text" class="form-control" id="special_instruction" placeholder="Enter Special Instruction">'
                            +'</div>'
                Swal.fire({
                    title: 'Create Order In Royal Mail',
                    html: html,
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: function(){
                        var packageWeight = Swal.getPopup().querySelector('#weight_in_gram').value
                        var packageFormat = Swal.getPopup().querySelector('#package_format').value
                        var specialInstruction = Swal.getPopup().querySelector('#special_instruction').value
                        console.log(packageWeight,packageFormat)
                        if((packageWeight == '') || (packageFormat == '')){
                            Swal.showValidationMessage(`Enter Valid Value`)
                            return false
                        }
                        var dataObj = {
                            orderNumber: orderNumber,
                            packageWeight: packageWeight,
                            packageFormat: packageFormat,
                            specialInstruction: specialInstruction,
                        }
                        return fetch(url,{
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            method: 'post',
                            body: JSON.stringify(dataObj)
                        })
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .then(data => {
                            if(data.type == 'success'){
                                Swal.fire('Success',data.msg,'success')
                            }else{
                                Swal.fire('Oops!',data.msg,'error')
                            }
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request Failed: ${error}`)
                        })
                    }
                })
            })
        });
        //End Check uncheck active catalogue counter

    </script>

@endsection
