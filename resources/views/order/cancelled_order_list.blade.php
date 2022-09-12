@extends('master')

@section('title')
    Cancelled Order | WMS360
@endsection

@section('content')


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

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
                                            <input type="checkbox" name="order-no" class="onoffswitch-checkbox" id="order-no" tabindex="0" @if(isset($setting['order']['cancelled_order']['order-no']) && $setting['order']['cancelled_order']['order-no'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['order-no']) && $setting['order']['cancelled_order']['order-no'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order No</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-date" class="onoffswitch-checkbox" id="order-date" tabindex="0" @if(isset($setting['order']['cancelled_order']['order-date']) && $setting['order']['cancelled_order']['order-date'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['order-date']) && $setting['order']['cancelled_order']['order-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['order']['cancelled_order']['channel']) && $setting['order']['cancelled_order']['channel'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['channel']) && $setting['order']['cancelled_order']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="payment" class="onoffswitch-checkbox" id="payment" tabindex="0" @if(isset($setting['order']['cancelled_order']['payment']) && $setting['order']['cancelled_order']['payment'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['payment']) && $setting['order']['cancelled_order']['payment'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="payment">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Payment</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ebay-user-id" class="onoffswitch-checkbox" id="ebay-user-id" tabindex="0" @if(isset($setting['order']['cancelled_order']['ebay-user-id']) && $setting['order']['cancelled_order']['ebay-user-id'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['ebay-user-id']) && $setting['order']['cancelled_order']['ebay-user-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ebay-user-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Ebay User ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['order']['cancelled_order']['name']) && $setting['order']['cancelled_order']['name'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['name']) && $setting['order']['cancelled_order']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-product" class="onoffswitch-checkbox" id="order-product" tabindex="0" @if(isset($setting['order']['cancelled_order']['order-product']) && $setting['order']['cancelled_order']['order-product'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['order-product']) && $setting['order']['cancelled_order']['order-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>product</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-price" class="onoffswitch-checkbox" id="total-price" tabindex="0" @if(isset($setting['order']['cancelled_order']['total-price']) && $setting['order']['cancelled_order']['total-price'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['total-price']) && $setting['order']['cancelled_order']['total-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="currency" class="onoffswitch-checkbox" id="currency" tabindex="0" @if(isset($setting['order']['cancelled_order']['currency']) && $setting['order']['cancelled_order']['currency'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['currency']) && $setting['order']['cancelled_order']['currency'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="currency">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Currency</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-post-code" class="onoffswitch-checkbox" id="shipping-post-code" tabindex="0" @if(isset($setting['order']['cancelled_order']['shipping-post-code']) && $setting['order']['cancelled_order']['shipping-post-code'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['shipping-post-code']) && $setting['order']['cancelled_order']['shipping-post-code'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-post-code">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Post Code</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="country" class="onoffswitch-checkbox" id="country" tabindex="0" @if(isset($setting['order']['cancelled_order']['country']) && $setting['order']['cancelled_order']['country'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['country']) && $setting['order']['cancelled_order']['country'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="country">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Country</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="city" class="onoffswitch-checkbox" id="city" tabindex="0" @if(isset($setting['order']['cancelled_order']['city']) && $setting['order']['cancelled_order']['city'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['city']) && $setting['order']['cancelled_order']['city'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="city">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>City</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="reason" class="onoffswitch-checkbox" id="reason" tabindex="0" @if(isset($setting['order']['cancelled_order']['reason']) && $setting['order']['cancelled_order']['reason'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['reason']) && $setting['order']['cancelled_order']['reason'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="reason">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Cancel Reason</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="cancelled_by" class="onoffswitch-checkbox" id="cancelled_by" tabindex="0" @if(isset($setting['order']['cancelled_order']['cancelled_by']) && $setting['order']['cancelled_order']['cancelled_by'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['cancelled_by']) && $setting['order']['cancelled_order']['cancelled_by'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="cancelled_by">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Cancelled By</p></div>
                                    </div>
                                    @if($shelfUse == 1)
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="picker" class="onoffswitch-checkbox" id="picker" tabindex="0" @if(isset($setting['order']['cancelled_order']['picker']) && $setting['order']['cancelled_order']['picker'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['picker']) && $setting['order']['cancelled_order']['picker'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="picker">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Picker</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="packer" class="onoffswitch-checkbox" id="packer" tabindex="0" @if(isset($setting['order']['cancelled_order']['packer']) && $setting['order']['cancelled_order']['packer'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['packer']) && $setting['order']['cancelled_order']['packer'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="packer">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Packer</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="assigner" class="onoffswitch-checkbox" id="assigner" tabindex="0" @if(isset($setting['order']['cancelled_order']['assigner']) && $setting['order']['cancelled_order']['assigner'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['assigner']) && $setting['order']['cancelled_order']['assigner'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="assigner">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Assigner</p></div>
                                    </div>
                                    @endif
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-cost" class="onoffswitch-checkbox" id="shipping-cost" tabindex="0" @if(isset($setting['order']['cancelled_order']['shipping-cost']) && $setting['order']['cancelled_order']['shipping-cost'] == 1) checked @elseif(isset($setting['order']['cancelled_order']['shipping-cost']) && $setting['order']['cancelled_order']['shipping-cost'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="cancelled_order">
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
                                <div class="mt-sm-20">
                                    <a data-toggle="modal" href="#Cancell-reason" class="btn btn-primary">Cancell Reason</a>
                                </div>
                            </div>
                            <!--Pagination Count and Apply Button Section-->
                        </div>
                    </div>
                </div>
                <!--//screen option-->

                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Order</li>
                            <li class="breadcrumb-item active" aria-current="page">Cancelled Order </li>
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


                <div class="modal fade" id="Cancell-reason">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Order Cancel Reason</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div><div class="container"></div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-success mb-3 add-reason float-right">Add Reason</button>
                            <!-- <a data-toggle="modal" href="#addReason" class="btn btn-primary mb-2">Add Reason</a> -->
                            <table class="table-hover w-100 bg-white cancell-reason-table">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th>Reason</th>
                                        <th>Increment Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($allOrderCancelReason)
                                        @foreach($allOrderCancelReason as $reason)
                                            <tr class="text-center border">
                                                <td class="text-center" id="reason-{{$reason->id}}">{{$reason->reason ?? ''}}</td>
                                                <td class="text-center" id="quantity-{{$reason->id}}">{{($reason->increment_quantity == 1) ? 'Yes' : (($reason->increment_quantity == 0) ? 'No' : 'Nothing')}}</td>
                                                <td class="text-center">
                                                    <button type="button" class="edit-reason btn-size edit-btn" style="cursor: pointer" id="{{$reason->id}}"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                    <button type="button" class="delete-reason btn-size delete-btn" style="cursor: pointer" id="{{$reason->id}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="btn">Close</a>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- <div class="modal fade" id="addReason" data-backdrop="static">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">2nd Modal title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div><div class="container"></div>
                        <div class="modal-body">
                        Content for the dialog / modal goes here.
                        Content for the dialog / modal goes here.
                        Content for the dialog / modal goes here.
                        Content for the dialog / modal goes here.
                        Content for the dialog / modal goes here.
                        </div>
                        <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn">Close</a>
                        <a href="#" class="btn btn-primary">Save changes</a>
                        </div>
                    </div>
                    </div>
                </div> -->


                <!--LOADER-->
                <div id="Load" class="load" style="display: none;">
                    <div class="load__container">
                        <div class="load__animation"></div>
                        <div class="load__mask"></div>
                        <span class="load__title">Content is loading...</span>
                    </div>
                </div>


                <!--Order note modal view-->
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
                <!--End Order note modal view-->



                <!-- Dispatched order content start-->
                <div class="row m-t-20 order-content" >
                    <div class="col-12">
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

                            <!--start table upper side content-->
                            <div class="product-inner dispatched-order">
                                <div class="dispatched-search-area">
{{--                                    <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">--}}
{{--                                        <input type="text" class="form-control dispatch-oninput-search ajax-order-search" name="search_oninput" id="search_oninput" placeholder="Search...">--}}
{{--                                        <input type="hidden" name="order_search_status" id="order_search_status" value="cancelled">--}}
{{--                                    </div>--}}
                                </div>

                                <!--Pagination area-->
                                <div class="pagination-area dispatched-pagination-area">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$cancelledOrderList->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($cancelledOrderList->currentPage() > 1)
                                                <a class="first-page btn {{$cancelledOrderList->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_cancelledOrderList->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$cancelledOrderList->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_cancelledOrderList->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_cancelledOrderList->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_cancelledOrderList->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="cancelled/order/list">
                                                </span>
                                                @if($cancelledOrderList->currentPage() !== $cancelledOrderList->lastPage())
                                                <a class="next-page btn" href="{{$all_cancelledOrderList->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_cancelledOrderList->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


                            <!--Start table section-->
                            <table class="order-table w-100" style="border-collapse:collapse;">
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="search_route" value="cancelled/order/list">
                                    <input type="hidden" name="status" value="cancelled">
                                    <tr>
                                        <th class="order-no" style="width: 15%; text-align: center;">
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
                                                            <input type="text" class="form-control input-text" name="date_created" placeholder="D-M-Y or Y-M-D" value="{{$allCondition['date_created'] ?? ''}}">
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
                                        
                                        <th class="order-product filter-symbol" style="cursor: pointer; width: 10%; text-align: center !important;">
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
                                        <th class="total-price filter-symbol" style="cursor: pointer; width: 10%; text-align: center !important;">
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
                                                                    <button title="Clear filters" type="submit" name="price" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Price</div>
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
                                                            <select class="form-control select2" name="currency">
                                                                @isset($distinct_currency)
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
                                                                @endisset
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
                                        <th class="shipping-post-code" style="cursor: pointer; width: 10%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['shipping_post_code'])text-warning @endisset" aria-hidden="true"></i>
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

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['country'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="country">
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
                                        <th class="reason" style="cursor: pointer; width: 10%; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                            <i class="fa  @isset($allCondition['reason'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2 b-r-0" name="reason">
                                                                @isset($cancel_reasons)
                                                                    {{-- @if($cancel_reasons->count() == 1)
                                                                        @foreach($cancel_reasons as $reason)
                                                                            <option value="{{$reason->id}}">{{$reason->reason}}</option>
                                                                        @endforeach
                                                                    @else --}}
                                                                        <option selected value = "">Select Reason</option>
                                                                        @foreach($cancel_reasons as $reason)
                                                                            @if(isset($allCondition['reason']) && ($allCondition['reason'] == $reason->id))
                                                                                <option value="{{$reason->id}}" selected>{{$reason->reason}}</option>
                                                                            @else
                                                                                <option value="{{$reason->id}}">{{$reason->reason}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    {{-- @endif --}}
                                                                @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="reason_optout" type="checkbox" name="reason_optout" value="1" @isset($allCondition['reason_optout']) checked @endisset><label for="reason_optout">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['reason']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="submit" name="reason" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Cancel Reason</div>
                                            </div>
                                        </th>
                                        <th class="cancelled_by" style="width: 10%; text-align: center;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['cancelled_by'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            @php
                                                                // $all_user_name = \App\User::whereIn('id', [1, 2, 4, 10, 12])->get();
                                                                $all_user_name = \App\User::get();
                                                            @endphp
                                                            <select class="form-control select2 b-r-0" name="cancelled_by">
                                                                @if(isset($all_user_name))
                                                                    {{-- @if($all_user_name->count() == 1)
                                                                        @foreach($all_user_name as $user_name)
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endforeach
                                                                    @else --}}
                                                                        <option selected value = "">Select User</option>
                                                                        @foreach($all_user_name as $user_name)
                                                                            @if(isset($allCondition['cancelled_by']) && ($allCondition['cancelled_by'] == $user_name->id))
                                                                                <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                            @else
                                                                                <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    {{-- @endif --}}
                                                                @endif
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="cancelled_by_optout" type="checkbox" name="cancelled_by_optout" value="1" @isset($allCondition['cancelled_by_optout']) checked @endisset><label for="cancelled_by_optout">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['cancelled_by']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="submit" name="cancelled_by" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Cancelled By</div>
                                            </div>
                                        </th>
                                        @if($shelfUse == 1)
                                            <th class="picker" style="cursor: pointer; width: 10%; text-align: center !important;">Picker</th>
                                            <th class="packer" style="cursor: pointer; width: 10%; text-align: center !important;">Packer</th>
                                            <th class="assigner" style="cursor: pointer; width: 10%; text-align: center !important;">Assigner</th>
                                        @endif
                                        {{-- <th class="shipping-cost filter-symbol" style="cursor: pointer; width: 10%; text-align: center !important;">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>Shipping Cost</div> &nbsp; &nbsp;
                                            </div>
                                        </th> --}}
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
                                        <th class="actions" style="width: 6%">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div>Invoice</div> &nbsp; &nbsp;
                                                @if(count($allCondition) > 0)
                                                    <div><a title="Clear filters" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                                @endif
                                            </div>
                                        </th>
                                       </tr>
                                   </form>
                                </thead>
                                <tbody>
                                @isset($cancelledOrderList)
                                    @isset($allCondition)
                                    @if(count($cancelledOrderList) == 0 && count($allCondition) != 0)
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
                                    @foreach($cancelledOrderList as $cancelledOrder)
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

                                                {{-- Clear filters loader added --}}
                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            </td>
                                            <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                                                {{$CommonFunction->getDateByTimeZone($cancelledOrder->date_created)}}
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
                                            <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->id}}" class="accordion-toggle">
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->orders->ebay_user_id ?? ""}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="name" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
                                                <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$cancelledOrder->customer_name}}</span>
                                                    <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            
                                            <td class="order-product" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{count($cancelledOrder->product_variations)}}</td>
                                            <td class="total-price" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->total_price}}</td>
                                            <td class="currency" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{$cancelledOrder->currency}}</td>
                                            <td class="shipping-post-code" style="cursor: pointer; width: 10%; text-align: center !important" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">
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
                                            <td class="cancelled_by" style="width: 10%; text-align: center!important; cursor: pointer" data-toggle="collapse" data-target="#demo{{$cancelledOrder->order_number}}" class="accordion-toggle">{{\App\User::find($cancelledOrder->cancelled_by)->name ?? ''}}</td>
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
                                            <td colspan="18" class="hiddenRow">
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
                                                                <div style="border: 1px solid #ccc" class="m-t-20">
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
                                                <span class="displaying-num"> {{$cancelledOrderList->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($cancelledOrderList->currentPage() > 1)
                                                    <a class="first-page btn {{$cancelledOrderList->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_cancelledOrderList->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$cancelledOrderList->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_cancelledOrderList->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex pl-1"> {{$all_cancelledOrderList->current_page}} of <span class="total-pages">{{$all_cancelledOrderList->last_page}}</span></span>
                                                    </span>
                                                    @if($cancelledOrderList->currentPage() !== $cancelledOrderList->lastPage())
                                                    <a class="next-page btn" href="{{$all_cancelledOrderList->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_cancelledOrderList->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


                        </div> <!--// card box--->
                    </div> <!-- // col-12 -->
                </div> <!-- end row --> <!--// END Dispatched order content start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->



    <!--Order note modal view-->
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
    <!--End Order note modal view-->



   <!-- Vue script start-->
    <script>
        const app = new Vue({
            el: '#app',
            data:{
                blank: false,
                message: 'test',
                newItem: {'start_date':'','end_date':''},
            },
            methods:{
                createItem: function createItem(){
                    console.log('test');
                    var _this = this;
                    var input = this.newItem;

                    if (input['start_date'] == '' || input['end_date'] == ''  ) {
                        this.blank = true;
                    } else {
                        this.blank = false;
                        axios({
                            url: "{{url('/complete/order/csv/download')}}",
                            method: "Post",
                            responseType: 'blob', // important
                            data: input,
                        }).then(function (response) {
                            // _this.newItem = { 'name': '', 'age': '', 'profession': '' };
                            // _this.getVueItems();
                            //console.log(response.data);
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download','order_data_'+input['start_date']+'_to_'+input['end_date']+'.csv');
                            document.body.appendChild(link);
                            link.click();
                        });
                        // this.hasDeleted = true;
                    }
                }
            }


        });
    </script>
    <!--End vue script-->



    <script>

        //Select2 select option jquery
        $('.select2').select2();

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table").find(".collapse.in").not(this).collapse('toggle')
        })

        //multiple select checkbox
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

        $('.select_opt_btn').on('click',function () {
            var search_value = $('.search_filter_option').val();
            var status = $('.select_opt_status').val();
            var column = $('.select_opt_column').val();
            var column_arr = [];
            column_arr.push(column);
            // var filter_optio = $('.select_opt_chk').val();
            var filter_option = 0;
            if ($('input.select_opt_chk').is(':checked')) {
                var filter_option = 1;
            }
            console.log(filter_option);
            $.ajax({
                type : "post",
                url : "{{url('order-search-filter-option')}}",
                data : {
                    "_token" : "{{csrf_token()}}",
                    "search" : search_value,
                    "column" : column_arr,
                    "status" : status,
                    "filter_option" : filter_option,
                    "page_number" : 0
                },
                beforeSend: function () {
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    $('table tbody').html(response);
                    $('.pagination').hide();
                },
                complete: function () {
                    $('#ajax_loader').hide();
                }
            });
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
                        $("#ajax_loader").show()
                    },
                    success: function (response) {
                        $('table tbody').html(response);
                    },
                    complete:function () {
                        $("#ajax_loader").hide()
                    }
                });
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
        })




        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });
        });

        // table column hide and show toggle checkbox
        $("input:checkbox").click(function(){
            var column = "."+$(this).attr("name");
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

        // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display li input[type=checkbox]").prop("checked", "true");
        // });
        //
        // // After unchecked any column display all checkbox will be unchecked
        // $(".column-display li input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        $(document).ready(function(){
            $('.add-reason').click('on',function(){
                Swal.fire({
                    title: 'Add Reason',
                    html: '<input type="text" id="reason" class="form-control" value="" placeholder="Enter Reason"><p>Quantity increment</p><div class="form-check-inline">'
                    +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1" checked>Yes'
                    +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No'
                    +'<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
                    +'</div>',
                    showCancelButton: true,
                    // confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Add',
                    closeOnConfirm: true,
                    showLoaderOnConfirm: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        const reason = Swal.getPopup().querySelector('#reason').value
                        const incrementQuantity = Swal.getPopup().querySelector('input[name="increment_quantity"]:checked').value
                        if(!reason || !incrementQuantity){
                            Swal.showValidationMessage(`Invalid reason or increment quantity`)
                        }
                        let url = "{{asset('add-order-cancel-reason')}}"
                        let token = "{{csrf_token()}}"
                        return fetch(url, {
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                                },
                            method: 'post',
                            body: JSON.stringify({
                                reason: reason,
                                increment_quantity: incrementQuantity
                            })
                        })
                        .then((response) => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(function(error) {
                            Swal.showValidationMessage(`Request failed: ${error}`)
                        });
                    }
                }).then(result => {
                    if(result.isConfirmed){
                        Swal.fire({
                            title: `${result.value.msg}`,
                            icon: 'success'
                        })
                    }
                })
            })

            $('.edit-reason').on('click',function(){
                let reasonId = $(this).attr('id')
                let reason = $('#reason-'+reasonId).text()
                let isQuantityIncrement = $('#quantity-'+reasonId).text()
                var htmlContent = '<input type="text" id="reason" class="form-control" value="'+reason+'" placeholder="Enter Reason"><p>Quantity increment</p><div class="form-check-inline">'
                if(isQuantityIncrement == 'Yes'){
                    htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1" checked>Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
                }else if(isQuantityIncrement == 'No'){
                    htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1">Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0" checked>No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2">No Action'
                }else{
                    htmlContent += '<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="1">Yes<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="0">No<input type="radio" name="increment_quantity" class="increment_quantity form-check-input ml-3" value="2" checked>No Action'
                }
                htmlContent += '</div>'
                Swal.fire({
                    title: 'Edit Reason',
                    html: htmlContent,
                    showCancelButton: true,
                    confirmButtonColor: '#81c868',
                    confirmButtonText: 'Update',
                    closeOnConfirm: true,
                    showLoaderOnConfirm: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        const reason = Swal.getPopup().querySelector('#reason').value
                        const incrementQuantity = Swal.getPopup().querySelector('input[name="increment_quantity"]:checked').value
                        if(!reason || !incrementQuantity){
                            Swal.showValidationMessage(`Invalid reason or increment quantity`)
                        }
                        let url = "{{asset('update-order-cancel-reason')}}"
                        let token = "{{csrf_token()}}"
                        return fetch(url,{
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                                },
                            method: 'post',
                            body: JSON.stringify({id: reasonId, reason: reason, incQuantity: incrementQuantity})
                        })
                        .then((response) => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(function(error) {
                            Swal.showValidationMessage(`Request faliled: ${error}`)
                        })
                    }
                })
                .then(result => {
                    if(result.isConfirmed){
                        Swal.fire({
                            title: result.value.msg,
                            icon: 'success'
                        })
                    }
                })
            })

            $('.delete-reason').click('on', function(){
                let id = $(this).attr('id')
                Swal.fire({
                    title: 'Are you sure to delete it ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Delete',
                    closeOnConfirm: true,
                    showLoaderOnConfirm: true,
                    focusConfirm: false,
                    preConfirm: () => {
                        let url = "{{asset('delete-order-cancel-reason')}}"
                        let token = "{{csrf_token()}}"
                        return fetch(url,{
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                                },
                            method: 'post',
                            body: JSON.stringify({id: id})
                        })
                        .then((response) => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(function(error){
                            Swal.showValidationMessage(`Request failed: ${error}`)
                        })
                    }
                })
                .then(result => {
                    if(result.isConfirmed){
                        Swal.fire({
                            title: result.value.msg,
                            icon: 'success'
                        })
                    }
                })
            })
        })


    </script>





@endsection
