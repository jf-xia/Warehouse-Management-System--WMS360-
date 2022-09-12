
@extends('master')

@section('title')
    Return Order | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

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
                                            <input type="checkbox" name="order-no" class="onoffswitch-checkbox" id="order-no" tabindex="0" @if(isset($setting['order']['return_order']['order-no']) && $setting['order']['return_order']['order-no'] == 1) checked @elseif(isset($setting['order']['return_order']['order-no']) && $setting['order']['return_order']['order-no'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order No</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-date" class="onoffswitch-checkbox" id="order-date" tabindex="0" @if(isset($setting['order']['return_order']['order-date']) && $setting['order']['return_order']['order-date'] == 1) checked @elseif(isset($setting['order']['return_order']['order-date']) && $setting['order']['return_order']['order-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Ordered Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="return-date" class="onoffswitch-checkbox" id="return-date" tabindex="0" @if(isset($setting['order']['return_order']['return-date']) && $setting['order']['return_order']['return-date'] == 1) checked @elseif(isset($setting['order']['return_order']['return-date']) && $setting['order']['return_order']['return-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="return-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Return Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="returned_by" class="onoffswitch-checkbox" id="returned_by" tabindex="0" @if(isset($setting['order']['return_order']['returned_by']) && $setting['order']['return_order']['returned_by'] == 1) checked @elseif(isset($setting['order']['return_order']['returned_by']) && $setting['order']['return_order']['returned_by'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="returned_by">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Returned By</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['order']['return_order']['status']) && $setting['order']['return_order']['status'] == 1) checked @elseif(isset($setting['order']['return_order']['status']) && $setting['order']['return_order']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['order']['return_order']['channel']) && $setting['order']['return_order']['channel'] == 1) checked @elseif(isset($setting['order']['return_order']['channel']) && $setting['order']['return_order']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="payment" class="onoffswitch-checkbox" id="payment" tabindex="0" @if(isset($setting['order']['return_order']['payment']) && $setting['order']['return_order']['payment'] == 1) checked @elseif(isset($setting['order']['return_order']['payment']) && $setting['order']['return_order']['payment'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="payment">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Payment</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ebay-user-id" class="onoffswitch-checkbox" id="ebay-user-id" tabindex="0" @if(isset($setting['order']['return_order']['ebay-user-id']) && $setting['order']['return_order']['ebay-user-id'] == 1) checked @elseif(isset($setting['order']['return_order']['ebay-user-id']) && $setting['order']['return_order']['ebay-user-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ebay-user-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Ebay User Id</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['order']['return_order']['name']) && $setting['order']['return_order']['name'] == 1) checked @elseif(isset($setting['order']['return_order']['name']) && $setting['order']['return_order']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="city" class="onoffswitch-checkbox" id="city" tabindex="0" @if(isset($setting['order']['return_order']['city']) && $setting['order']['return_order']['city'] == 1) checked @elseif(isset($setting['order']['return_order']['city']) && $setting['order']['return_order']['city'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="city">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>City</p></div>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-product" class="onoffswitch-checkbox" id="order-product" tabindex="0" @if(isset($setting['order']['return_order']['order-product']) && $setting['order']['return_order']['order-product'] == 1) checked @elseif(isset($setting['order']['return_order']['order-product']) && $setting['order']['return_order']['order-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-price" class="onoffswitch-checkbox" id="total-price" tabindex="0" @if(isset($setting['order']['return_order']['total-price']) && $setting['order']['return_order']['total-price'] == 1) checked @elseif(isset($setting['order']['return_order']['total-price']) && $setting['order']['return_order']['total-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="currency" class="onoffswitch-checkbox" id="currency" tabindex="0" @if(isset($setting['order']['return_order']['currency']) && $setting['order']['return_order']['currency'] == 1) checked @elseif(isset($setting['order']['return_order']['currency']) && $setting['order']['return_order']['currency'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="currency">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Currency</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="return-reason" class="onoffswitch-checkbox" id="return-reason" tabindex="0" @if(isset($setting['order']['return_order']['return-reason']) && $setting['order']['return_order']['return-reason'] == 1) checked @elseif(isset($setting['order']['return_order']['return-reason']) && $setting['order']['return_order']['return-reason'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="return-reason">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Return Reason</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="return-cost" class="onoffswitch-checkbox" id="return-cost" tabindex="0" @if(isset($setting['order']['return_order']['return-cost']) && $setting['order']['return_order']['return-cost'] == 1) checked @elseif(isset($setting['order']['return_order']['return-cost']) && $setting['order']['return_order']['return-cost'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="return-cost">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Return Cost</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-post-code" class="onoffswitch-checkbox" id="shipping-post-code" tabindex="0" @if(isset($setting['order']['return_order']['shipping-post-code']) && $setting['order']['return_order']['shipping-post-code'] == 1) checked @elseif(isset($setting['order']['return_order']['shipping-post-code']) && $setting['order']['return_order']['shipping-post-code'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-post-code">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Post Code</p></div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="country" class="onoffswitch-checkbox" id="country" tabindex="0" @if(isset($setting['order']['return_order']['country']) && $setting['order']['return_order']['country'] == 1) checked @elseif(isset($setting['order']['return_order']['country']) && $setting['order']['return_order']['country'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="country">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Country</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-cost" class="onoffswitch-checkbox" id="shipping-cost" tabindex="0" @if(isset($setting['order']['return_order']['shipping-cost']) && $setting['order']['return_order']['shipping-cost'] == 1) checked @elseif(isset($setting['order']['return_order']['shipping-cost']) && $setting['order']['return_order']['shipping-cost'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-cost">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shipping Cost</p></div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->



                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="order">
                            <input type="hidden" id="secondKey" value="return_order">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count and Apply Button Section-->
                            <div class="d-flex justify-content-between align-items-center pagination-content">
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add / Show Reason</button>
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
                            <li class="breadcrumb-item active" aria-current="page"> Return Order </li>
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
                                    <button type="button" class="btn btn-primary reason add_reason">Add</button>
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
                                                    <a class="btn-size edit-btn btn-sm mr-2" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                    <a class="btn-size delete-btn btn-sm" style="cursor: pointer; color: #ffffff;" id="{{$reason->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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


                <!--Order note Modal-->
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
                <!--End Order note Modal-->



                <!-- Return order list content start-->
                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box shadow order-card table-responsive">

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
                                    <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">
                                        <input type="text" class="form-control dispatch-oninput-search ajax-order-search" name="search_oninput" id="search_oninput" placeholder="Search...">
                                        <input type="hidden" name="order_search_status" id="order_search_status" value="return">
                                    </div>
                                </div>

                                <!--Pagination area-->
                                <div class="pagination-area dispatched-pagination-area">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_return_order->total()}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($all_return_order->currentPage() > 1)
                                                <a class="first-page btn {{$all_return_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_return_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_return_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_return_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="paging-input d-flex align-items-center">
                                                    <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                    <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_return_product->current_page}}" size="3" aria-describedby="table-paging">
                                                    <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_return_product->last_page}}</span></span>
                                                    <input type="hidden" name="route_name" value="return/order/list">
                                                    <input type="hidden" name="query_params" value="{{$url}}">
                                                </span>
                                                @if($all_return_order->currentPage() !== $all_return_order->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_return_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_return_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            <!--Form inside search and checkbox button field --->
{{--                            <form class="example m-b-10 m-t-10" action="{{url('order-search')}}" method="post">--}}
{{--                                @csrf--}}

{{--                                <div class="order-search-field pb-2">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <input class="form-control" type="text" placeholder="Search.." name="search">--}}
{{--                                            <input type="hidden" name="status" value="processing">--}}
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
{{--                                    <div class="row pagination-sec">--}}
{{--                                        <div class="col-md-6 order-search-btn pb-2">--}}
{{--                                            <button type="submit"><i class="fa fa-search"></i></button>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <input type="text" class="form-control m-r-10" name="search_oninput" id="search_oninput" placeholder="Search by orderNo, CustomerName, city, ProductName, Sku">--}}
{{--                                            <input type="hidden" name="order_search_status" id="order_search_status" value="return">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="">--}}
{{--                                        <span class="total-return-order float-right"> Total Return Order : {{count($all_return_order)}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </form>--}}
                            <!--// END Form inside search and checkbox button field --->


                                    <!--start table section-->
                                    <table class="order-table w-100" style="border-collapse:collapse;">
                                            <thead>
                                            <form action="{{url('all-column-search')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="search_route" value="return/order/list">
                                                <input type="hidden" name="status" value="return">
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
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
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
                                                        <div>Ordered Date</div>
                                                    </div>
                                                </th>
                                                <th class="return-date" style="width: 10%; text-align: center;">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">

                                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['return_date'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <input type="text" class="form-control input-text" name="return_date" placeholder="D-M-Y or Y-M-D" value="{{$allCondition['return_date'] ?? ''}}">
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="return_date_opt_out" type="checkbox" name="return_date_opt_out" value="1" @isset($allCondition['return_date_opt_out']) checked @endisset><label for="return_date_opt_out">Opt Out</label>
                                                                    </div>
                                                                    @if(isset($allCondition['return_date']))
                                                                        <div class="individual_clr">
                                                                            <button title="Clear filters" type="submit" name="return_date" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>

                                                        </div>
                                                        <div>Return Date</div>
                                                    </div>
                                                </th>
                                                <th class="returned_by" style="width: 10%; text-align: center;">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">

                                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['return_by'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    @php
                                                                        // $all_user_name = \App\User::whereIn('id', [1, 2, 4, 10, 12])->get();
                                                                        $all_user_name = \App\User::get();
                                                                    @endphp
                                                                    <select class="form-control select2 b-r-0" name="return_by">
                                                                        @if(isset($all_user_name))
                                                                            {{-- @if($all_user_name->count() == 1)
                                                                                <option value="">Select Returner</option>
                                                                                @foreach($all_user_name as $user_name)
                                                                                    <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                                @endforeach
                                                                            @else --}}
                                                                                <option value="">Select Returner</option>
                                                                                @foreach($all_user_name as $user_name)
                                                                                    @if(isset($allCondition['return_by']) && ($allCondition['return_by'] == $user_name->id))
                                                                                        <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                                    @else
                                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                                {{-- <!-- <option value="">Select User</option>
                                                                                @foreach($all_user_name as $user_name)
                                                                                    <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                                @endforeach -->
                                                                            @endif --}}
                                                                        @endif
                                                                    </select>
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="return_by_opt_out" type="checkbox" name="return_by_opt_out" value="1" @isset($allCondition['return_by_opt_out']) checked @endisset><label for="return_by_opt_out">Opt Out</label>
                                                                    </div>
                                                                    @if(isset($allCondition['return_by']))
                                                                        <div class="individual_clr">
                                                                            <button title="Clear filters" type="submit" name="return_by" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>

                                                        </div>
                                                        <div>Returned By</div>
                                                    </div>
                                                </th>
                                                <th class="status filter-symbol" style="width: 10%; text-align: center;">Status</th>
                                                {{--                                        <th class="channel">--}}
                                                {{--                                            <form action="javascript:void(0);" method="post">--}}
                                                {{--                                                @csrf--}}
                                                {{--                                                <select class="form-control search_filter_option" name="search">--}}
                                                {{--                                                    <option>ChannelFactory</option>--}}
                                                {{--                                                    <option value="ebay">eBay</option>--}}
                                                {{--                                                    <option value="checkout">Website</option>--}}
                                                {{--                                                    <option value="onbuy">Onbuy</option>--}}
                                                {{--                                                    <option value="amazon">Amazon</option>--}}
                                                {{--                                                    <option value="rest-api">Manual</option>--}}
                                                {{--                                                </select>--}}
                                                {{--                                                <input type="hidden" name="status" class="select_opt_status" value="completed">--}}
                                                {{--                                                <input type="hidden" name="chek_value[]" class="select_opt_column" value="created_via">--}}
                                                {{--                                                <input type="checkbox" name="select_opt" class="select_opt_chk"> Opt Out--}}
                                                {{--                                                <button type="button" class="btn btn-primary select_opt_btn">Apply</button>--}}
                                                {{--                                            </form>--}}
                                                {{--                                        </th>--}}
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
                                                                                @foreach($distinct_payment as $return_payment_method)
                                                                                    <option value="{{$return_payment_method->payment_method}}">{{ucfirst($return_payment_method->payment_method)}}</option>
                                                                                @endforeach
                                                                            @else
                                                                                @foreach($distinct_payment as $return_payment_method)
                                                                                    @if(isset($allCondition['payment']))
                                                                                        @php
                                                                                            $selected = null;
                                                                                        @endphp
                                                                                        @foreach($allCondition['payment'] as $ch)
                                                                                            @if($return_payment_method->payment_method == $ch)
                                                                                                <option value="{{$return_payment_method->payment_method}}" selected>{{ucfirst($return_payment_method->payment_method)}}</option>
                                                                                                @php
                                                                                                    $selected = 1;
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        @if($selected == null)
                                                                                            <option value="{{$return_payment_method->payment_method}}">{{ucfirst($return_payment_method->payment_method)}}</option>
                                                                                        @endif
                                                                                    @else
                                                                                        <option value="{{$return_payment_method->payment_method}}">{{ucfirst($return_payment_method->payment_method)}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                                <!-- <option value="">Select Payment</option>
                                                                                @foreach($distinct_payment as $return_payment_method)
                                                                                    <option value="{{$return_payment_method->payment_method}}">{{ucfirst($return_payment_method->payment_method)}}</option>
                                                                                @endforeach -->
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
                                                
                                                <th class="order-product filter-symbol" style="text-align: center; width: 10%;">
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
                                                                    <select class="form-control select2 b-r-0" name="currency">
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
                                                        <div>Currency</div>
                                                    </div>
                                                </th>
                                                <th class="return-reason" style="width: 10%">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">

                                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['return_reason'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <select class="form-control select2" name="return_reason">
                                                                        @isset($distinct_return_reason)
                                                                            {{-- @if($distinct_return_reason->count() == 1)
                                                                                @foreach($distinct_return_reason as $return_order_reason)
                                                                                    <option value="{{$return_order_reason->return_reason}}">{{$return_order_reason->return_reason}}</option>
                                                                                @endforeach
                                                                            @else --}}
                                                                                <option value="">Select Reason</option>
                                                                                @foreach($distinct_return_reason as $return_order_reason)
                                                                                    @if(isset($allCondition['return_reason']) && ($allCondition['return_reason'] == $return_order_reason->return_reason))
                                                                                        <option value="{{$return_order_reason->return_reason}}" selected>{{$return_order_reason->return_reason}}</option>
                                                                                    @else
                                                                                        <option value="{{$return_order_reason->return_reason}}">{{$return_order_reason->return_reason}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            {{-- @endif --}}
                                                                        @endisset
                                                                    </select>
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                        <input id="return_reason_optout" type="checkbox" name="return_reason_optout" value="1" @isset($allCondition['return_reason_optout']) checked @endisset><label for="return_reason_optout">Opt Out</label>
                                                                    </div>
                                                                    @if(isset($allCondition['return_reason']))
                                                                        <div class="individual_clr">
                                                                            <button title="Clear filters" type="submit" name="return_reason" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>

                                                        </div>
                                                        <div>Return Reason</div>
                                                    </div>
                                                </th>
                                                <th class="return-cost filter-symbol" style="width: 10%">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="btn-group">

                                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['return_cost'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <div class="d-flex">
                                                                        <div>
                                                                            <select class="form-control" name="return_cost_opt">
                                                                            <option value=""></option>
                                                                            <option value="=" @if(isset($allCondition['return_cost_opt']) && ($allCondition['return_cost_opt'] == '=')) selected @endif>=</option>
                                                                            <option value="<" @if(isset($allCondition['return_cost_opt']) && ($allCondition['return_cost_opt'] == '<')) selected @endif><</option>
                                                                            <option value=">" @if(isset($allCondition['return_cost_opt']) && ($allCondition['return_cost_opt'] == '>')) selected @endif>></option>
                                                                            <option value="<=" @if(isset($allCondition['return_cost_opt']) && ($allCondition['return_cost_opt'] == '≤')) selected @endif>≤</option>
                                                                            <option value=">=" @if(isset($allCondition['return_cost_opt']) && ($allCondition['return_cost_opt'] == '≥')) selected @endif>≥</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="ml-2">
                                                                            <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="return_cost" value="{{$allCondition['return_cost'] ?? ''}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                    <input id="return_cost_optout" type="checkbox" name="return_cost_optout" value="1" @isset($allCondition['return_cost_optout']) checked @endisset><label for="return_cost_optout">Opt Out</label>
                                                                    </div>
                                                                    @if(isset($allCondition['return_cost']))
                                                                        <div class="individual_clr">
                                                                            <button title="Clear filters" type="submit" name="return_cost" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                        </div>
                                                                    @endif
                                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                                </div>

                                                        </div>
                                                        <div>Return Cost</div>
                                                    </div>
                                                </th>
                                                <th class="shipping-post-code" style="text-align: center !important; width: 10%">
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

                                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                                    <i class="fa @isset($allCondition['country'])text-warning @endisset" aria-hidden="true"></i>
                                                                </a>
                                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                                    <p>Filter Value</p>
                                                                    <select class="form-control select2" name="country">
                                                                        @isset($distinct_country)
                                                                            {{-- @if($distinct_country->count() == 1)
                                                                                @foreach($distinct_country as $return_order_customer_country)
                                                                                    <option value="{{$return_order_customer_country->customer_country}}">{{$return_order_customer_country->customer_country}}</option>
                                                                                @endforeach
                                                                            @else --}}
                                                                                <option value="">Select Country</option>
                                                                                @foreach($distinct_country as $return_order_customer_country)
                                                                                    @if(isset($allCondition['country']) && ($allCondition['country'] == $return_order_customer_country->customer_country))
                                                                                        <option value="{{$return_order_customer_country->customer_country}}" selected>{{$return_order_customer_country->customer_country}}</option>
                                                                                    @else
                                                                                        <option value="{{$return_order_customer_country->customer_country}}">{{$return_order_customer_country->customer_country}}</option>
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
                                                        <div>Country</div>
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
                                                <th class="actions" style="width: 6%">

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
                                            <tbody id="myTable">
                                            @isset($all_return_order)
                                                @isset($allCondition)
                                                @if(count($all_return_order) == 0 && count($allCondition) != 0)
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
                                            @foreach($all_return_order as $return_order)
                                                <tr>
                                                    <td class="order-no" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                            <span title="Click to view in channel" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{!! \App\Traits\CommonFunction::dynamicOrderLink($return_order->orders->created_via,$return_order->orders) !!}</span>
                                                            <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                        </div>
                                                        @isset($return_order->orders->exchange_order_id)
                                                            (Ex. Order No. &nbsp;<span class="text-danger">{{\App\Order::find($return_order->orders->exchange_order_id)->order_number ?? ''}}</span>)
                                                        @endisset
                                                        <span class="append_note{{$return_order->order_id}}">
                                                        @isset($return_order->order_note)
                                                            <label class="label label-success view-note" style="cursor: pointer" id="{{$return_order->order_id}}" onclick="view_note({{$return_order->order_id}});">View Note</label>
                                                        @endisset
                                                        </span>

                                                        {{-- Clear filters loader added --}}
                                                        <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                    </td>
                                                    <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        {{$CommonFunction->getDateByTimeZone($return_order->orders->date_created)}}
                                                    </td>
                                                    <td class="return-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        {{$CommonFunction->getDateByTimeZone($return_order->created_at)}}
                                                    </td>
                                                    <td class="returned_by" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">{{\App\User::find($return_order->returned_by)->name ?? ''}}</td>
                                                    @if($return_order->orders->status == 'processing')
                                                        <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><span class="label label-table label-status label-warning">{{$return_order->orders->status}}</span></td>
                                                    @elseif($return_order->orders->status == 'completed')
                                                        <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><span class="label label-table label-status label-success">{{$return_order->orders->status}}</span></td>
                                                    @else
                                                        <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($return_order->orders->status)}}</td>
                                                    @endif
                                                    @if(($return_order->orders->created_via == 'ebay' || $return_order->orders->created_via == 'Ebay') && ($return_order->orders->account_id == null))
                                                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle"><img src="{{asset('assets/common-assets/ebay-42x16.png')}}" alt="image"></td>
                                                    @elseif(($return_order->orders->created_via == 'ebay' || $return_order->orders->created_via == 'Ebay') && ($return_order->orders->account_id != null))
                                                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
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
                                                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
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
                                                    @elseif($return_order->orders->created_via == 'shopify')
                                                    @php
                                                        $logo = '';
                                                        $accountName = \App\shopify\shopifyAccount::find($return_order->orders->account_id);
                                                        if($accountName){
                                                            $logo = $accountName->account_logo;
                                                        }
                                                    @endphp
                                                    <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        <div class="d-flex justify-content-center align-item-center" title="Shopify({{$accountName->account_name ?? ''}})">
                                                            <img src="{{$logo}}" alt="image" style="height: 40px; width: auto;">
                                                        </div>
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
                                                    <td class="ebay-user-id" style="cursor: pointer; width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                            <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$return_order->orders->ebay_user_id ?? ""}}</span>
                                                            <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                        </div>
                                                    </td>
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
                                                    <td class="shipping-cost" style="cursor: pointer; text-align: center !important; width: 10%;" style="cursor: pointer; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$return_order->id}}" class="accordion-toggle">
                                                        {{substr($return_order->orders->shipping_method ?? 0.0,0,10)}}
                                                    </td>
                                                    <!--Action Button-->
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
                                                                            <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note append_button{{$return_order->order_id}} mr-2" id="{{$return_order->order_id}}" data-toggle="tooltip" data-placement="top" title="Add Note"><i class="fas fa-sticky-note"></i></button>
                                                                        @endif
                                                                            <a href="{{url('manual-order/'.$return_order->order_id.'/return')}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn" data-toggle="tooltip" data-placement="top" title="Exchange Return"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></a>

                                                                            <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$return_order->orders->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                            <a style="background:green !important; margin-right:7px;" href="{{url('order/list/pdf/'.$return_order->orders->order_number.'/2')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Packing Slip"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <!--End Action Button-->
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
                                                                                <div class="col-2 text-center">
                                                                                    <h6>SKU</h6>
                                                                                    <hr class="order-hr" width="60%">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h6>QR</h6>
                                                                                    <hr class="order-hr" width="60%">
                                                                                </div>
                                                                                <div class="col-2 text-center">
                                                                                    <h6> Return Quantity </h6>
                                                                                    <hr class="order-hr" width="60%">
                                                                                </div>
                                                                                <div class="col-1 text-center">
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
                                                                                                <buttton type="button" style="padding: 1px 4px;" class="btn btn-success btn-sm">Shelved</buttton>
                                                                                            @else
                                                                                                <span class="text-danger" id="btn_change_id{{$product->pivot->id}}">(Not shelved)
                                                                                                    <buttton type="button" style="padding: 1px 4px;" class="btn btn-primary btn-sm" onclick="shelve_return_product('{{$product->pivot->id}}')">Click to Shelve</buttton>
{{--                                                                                                    <a href="{{url('catalogue-product-invoice-receive/'.$product->product_draft_id.'/'.$product->id.'/return/'.$return_order->id)}}" target="_blank" class="btn btn-success btn-sm">Invoice</a>--}}
                                                                                                </span>
                                                                                            @endif
                                                                                        </h7>
                                                                                        @endisset
                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <h7>
                                                                                            <div class="order_page_tooltip_container d-flex justify-content-center align-items-center">
                                                                                                <span title="Click to Copy" onclick="wmsOrderPageTextCopied(this);" class="order_page_copy_button">{{$product->sku}}</span>
                                                                                                <span class="wms__order__page__tooltip__message" id="wms__order__page__tooltip__message">Copied!</span>
                                                                                            </div>
                                                                                        </h7>
                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <div class="row">
                                                                                            <div class="pt-2 pb-2 col-md-6">
                                                                                                <a target="_blank" href="{{url('print-barcode/'.$product->id ?? '')}}">
                                                                                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product->sku ?? ''); !!}
                                                                                                </a>
                                                                                            </div>
                                                                                            <div class="col-md-6 my-auto">
                                                                                                <a href="{{url('catalogue-product-invoice-receive/'.($return_order->return_product_save[0]->product_draft_id ?? 0).'/'.$return_order->order_id.'/return/'.$return_order->id.'/'.$product->id)}}" class="btn btn-success" target="_blank">Restock</a>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="col-2 text-center">
                                                                                        <h7> {{$product->pivot->return_product_quantity}} </h7>
                                                                                    </div>
                                                                                    <div class="col-1 text-center">
                                                                                        <h7> {{$product->pivot->price}} </h7>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

                                                                            <div class="row m-b-20">
                                                                                <div class="col-9 text-center">
                                                                                </div>
                                                                                <div class="col-2 d-flex justify-content-center">
                                                                                    <h7 class="font-weight-bold"> Return Cost</h7>
                                                                                </div>
                                                                                <div class="col-1 text-center">
                                                                                    <h7 class="font-weight-bold"> {{$return_order->return_cost}} </h7>
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
                                                                                        <h6 class="text-left"> Billing </h6>
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
                                                    <span class="displaying-num"> {{$all_return_order->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($all_return_order->currentPage() > 1)
                                                        <a class="first-page btn" href="{{$all_decode_return_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn" href="{{$all_decode_return_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text  d-flex pl-1"> {{$all_decode_return_product->current_page}} of <span class="total-pages">{{$all_decode_return_product->last_page}}</span></span>
                                                        </span>
                                                        @if($all_return_order->currentPage() !== $all_return_order->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_return_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_return_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                    </div> <!-- // col-md-12 -->
                </div> <!-- end row --> <!--// END Return order list content-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div> <!-- content page -->

    <!--Modal note view modal-->
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
    <!--End Modal note view modal-->




    <script>

        //Select 2 jquery select option
        $('.select2').select2();

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table").find(".collapse.in").not(this).collapse('toggle')
        });


        $(document).ready(function () {
            $('.modal .modal-footer .reason').on('click',function () {
                var reason = $('#reason').val();
                var button_name = $('.modal .modal-footer .reason').text();
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
                        }else if(button_name == 'Update'){
                            $('p.text-success').show().html('Updated successfully');
                            $('#row_id_'+id).children('td').first().html(reason);
                            $('#reason').val('');
                            $('.modal .modal-footer button').removeClass('update_reason');
                            $('.modal .modal-footer button').addClass('add_reason');
                            $('.modal .modal-footer button').text('Add');
                            console.log(response.data);
                        }
                    }
                });
            });

            $('.modal-body table tbody tr td a.edit-btn').on('click',function () {
                var id = $(this).attr('id');
                var text = $(this).closest('tr').children('td').first().html();
                $('#reason').val(text);
                $('.modal .modal-footer .reason').removeClass('add_reason');
                $('.modal .modal-footer .reason').addClass('update_reason');
                $('.modal .modal-footer .reason').text('Update');
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
                            $('p.text-success').show().html('Deleted successfully');
                            console.log(response.data);
                        }
                    });
                }else{
                    return false;
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
                        $('table tbody tr').remove();
                        $('table tbody').html(response);
                    },
                    complete:function () {
                        $("#ajax_loader").hide()
                    }
                });
            });
        });



        function shelve_return_product(id) {
            console.log(id);
            $.ajax({
                type: "post",
                url: "{{url('shelve-return-product')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "id" : id
                },
                success: function (response) {
                    if(response == 1){
                        $('div h7 #btn_change_id'+id).html('<buttton type="button" class="btn btn-success btn-sm">Shelved</buttton>');
                        console.log(response);
                    }else{
                        $('div h7 #btn_change_id'+id).html(response);
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



    </script>

@endsection
