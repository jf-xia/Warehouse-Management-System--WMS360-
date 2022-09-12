@extends('master')

@section('title')
    Dispatched Order | WMS360
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
                                            <input type="checkbox" name="order-no" class="onoffswitch-checkbox" id="order-no" tabindex="0" @if(isset($setting['order']['completed_order']['order-no']) && $setting['order']['completed_order']['order-no'] == 1) checked @elseif(isset($setting['order']['completed_order']['order-no']) && $setting['order']['completed_order']['order-no'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-no">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order No</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-date" class="onoffswitch-checkbox" id="order-date" tabindex="0" @if(isset($setting['order']['completed_order']['order-date']) && $setting['order']['completed_order']['order-date'] == 1) checked @elseif(isset($setting['order']['completed_order']['order-date']) && $setting['order']['completed_order']['order-date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['order']['completed_order']['status']) && $setting['order']['completed_order']['status'] == 1) checked @elseif(isset($setting['order']['completed_order']['status']) && $setting['order']['completed_order']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['order']['completed_order']['channel']) && $setting['order']['completed_order']['channel'] == 1) checked @elseif(isset($setting['order']['completed_order']['channel']) && $setting['order']['completed_order']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="payment" class="onoffswitch-checkbox" id="payment" tabindex="0" @if(isset($setting['order']['completed_order']['payment']) && $setting['order']['completed_order']['payment'] == 1) checked @elseif(isset($setting['order']['completed_order']['payment']) && $setting['order']['completed_order']['payment'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="payment">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Payment</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ebay-user-id" class="onoffswitch-checkbox" id="ebay-user-id" tabindex="0" @if(isset($setting['order']['completed_order']['ebay-user-id']) && $setting['order']['completed_order']['ebay-user-id'] == 1) checked @elseif(isset($setting['order']['completed_order']['ebay-user-id']) && $setting['order']['completed_order']['ebay-user-id'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['order']['completed_order']['name']) && $setting['order']['completed_order']['name'] == 1) checked @elseif(isset($setting['order']['completed_order']['name']) && $setting['order']['completed_order']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="city" class="onoffswitch-checkbox" id="city" tabindex="0" @if(isset($setting['order']['completed_order']['city']) && $setting['order']['completed_order']['city'] == 1) checked @elseif(isset($setting['order']['completed_order']['city']) && $setting['order']['completed_order']['city'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="city">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>City</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="order-product" class="onoffswitch-checkbox" id="order-product" tabindex="0" @if(isset($setting['order']['completed_order']['order-product']) && $setting['order']['completed_order']['order-product'] == 1) checked @elseif(isset($setting['order']['completed_order']['order-product']) && $setting['order']['completed_order']['order-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="order-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Order product</p></div>
                                    </div>
                                    @if($shelfUse == 1)
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="picker" class="onoffswitch-checkbox" id="picker" tabindex="0" @if(isset($setting['order']['completed_order']['picker']) && $setting['order']['completed_order']['picker'] == 1) checked @elseif(isset($setting['order']['completed_order']['picker']) && $setting['order']['completed_order']['picker'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="picker">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Picker</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="packer" class="onoffswitch-checkbox" id="packer" tabindex="0" @if(isset($setting['order']['completed_order']['packer']) && $setting['order']['completed_order']['packer'] == 1) checked @elseif(isset($setting['order']['completed_order']['packer']) && $setting['order']['completed_order']['packer'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="packer">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Packer</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="assigner" class="onoffswitch-checkbox" id="assigner" tabindex="0" @if(isset($setting['order']['completed_order']['assigner']) && $setting['order']['completed_order']['assigner'] == 1) checked @elseif(isset($setting['order']['completed_order']['assigner']) && $setting['order']['completed_order']['assigner'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="assigner">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Assigner</p></div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-price" class="onoffswitch-checkbox" id="total-price" tabindex="0" @if(isset($setting['order']['completed_order']['total-price']) && $setting['order']['completed_order']['total-price'] == 1) checked @elseif(isset($setting['order']['completed_order']['total-price']) && $setting['order']['completed_order']['total-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="currency" class="onoffswitch-checkbox" id="currency" tabindex="0" @if(isset($setting['order']['completed_order']['currency']) && $setting['order']['completed_order']['currency'] == 1) checked @elseif(isset($setting['order']['completed_order']['currency']) && $setting['order']['completed_order']['currency'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="currency">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Currency</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-post-code" class="onoffswitch-checkbox" id="shipping-post-code" tabindex="0" @if(isset($setting['order']['completed_order']['shipping-post-code']) && $setting['order']['completed_order']['shipping-post-code'] == 1) checked @elseif(isset($setting['order']['completed_order']['shipping-post-code']) && $setting['order']['completed_order']['shipping-post-code'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shipping-post-code">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Post Code</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="country" class="onoffswitch-checkbox" id="country" tabindex="0" @if(isset($setting['order']['completed_order']['country']) && $setting['order']['completed_order']['country'] == 1) checked @elseif(isset($setting['order']['completed_order']['country']) && $setting['order']['completed_order']['country'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="country">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Country</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shipping-cost" class="onoffswitch-checkbox" id="shipping-cost" tabindex="0" @if(isset($setting['order']['completed_order']['shipping-cost']) && $setting['order']['completed_order']['shipping-cost'] == 1) checked @elseif(isset($setting['order']['completed_order']['shipping-cost']) && $setting['order']['completed_order']['shipping-cost'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="completed_order">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                            <!--Pagination Count, start date, end date downloading csv and Apply Button Section-->
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

                                <div id="app" class="date-section mt-sm-20 mt-xs-10">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div><p class="mr-2">Start Date</p></div>
                                        <div>
                                            <input type="date" class="form-control" id="start_date" name="start_date" required v-model="newItem.start_date" placeholder="start date">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center mt-2">
                                        <div><p class="mr-2">End Date</p></div>
                                        <div>
                                            <input type="date" class="form-control" id="end_date" name="end_date" required v-model="newItem.end_date" placeholder="end date">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        {{ csrf_field() }}
                                        <p class="text-center alert alert-danger"
                                           v-if="blank">Please select date</p>

                                        <button class="btn btn-default float-right m-t-10 download-btn" v-on:click="createItem()">
                                            <span class="fa fa-download"></span>  Download CSV
                                        </button>

                                    </div>
                                </div>
                            </div>
                            <!--End Pagination Count, start date, end date downloading csv and Apply Button Section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->

                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Order</li>
                            <li class="breadcrumb-item active" aria-current="page"> Dispatched Order </li>
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



                <div id="Load" class="load" style="display: none;">
                    <div class="load__container">
                        <div class="load__animation"></div>
                        <div class="load__mask"></div>
                        <span class="load__title">Content is loading...</span>
                    </div>
                </div>


                <!--start Modal-->
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




                {{-- Receive invoice modal --}}
                <div id="receive-invoice-modal" class="category-modal receive-invoice-modal" style="display: none">
                    <div class="cat-header dis-return-order-header">
                        <div>
                            <label id="label_name" class="cat-label">Product receive invoice</label>
                        </div>
                        <div class="cursor-pointer" onclick="closeReceiveInvoiceModal(this)">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="cat-body restock-receive-invoice-modal-body">
                        @if(Session::has('receive_name'))
                            {!! Session::get('receive_name') !!}
                        @endif
                        <form class="receive-invoice-modal-form" action="{{url('save-catalogue-product-invoice-receive')}}" method="post">
                            @csrf
                            @if(Session::has('invoice_part'))
                                {!! Session::get('invoice_part') !!}
                            @endif
                            <div class="form-group row vendor-btn-top">
                                <div class="col-md-12 text-center">
                                    <button type="submit" style="color: #fff;"  class="vendor-btn"  class="btn btn-primary receiveInvoiceModalBtn">
                                        <b>Add</b>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- End receive invoice modal --}}




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


                            @if(Session::has('return_order_success_msg'))
                                <div id="returnOrderSuccessMsg" class="alert alert-success">
                                    {!! Session::get('return_order_success_msg') !!}
                                </div>
                            @endif

                            @if(Session::has('success'))
                                <div id="receiveInvoiceSuccessMessage" class="alert alert-success" style="display: none">
                                    {!! Session::get('success') !!}
                                </div>
                            @endif




                        <!--Form inside search and checkbox button field --->
{{--                            <div class="row">--}}
{{--                                <div class="col-12">--}}
{{--                                    <form class="example m-b-10 m-t-10" action="{{url('order-search')}}" method="post">--}}
{{--                                        @csrf--}}

{{--                                        <div class="order-search-field completed-order pb-2">--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md-6">--}}
{{--                                                    <input class="form-control" type="text" placeholder="Search.." name="search">--}}
{{--                                                    <input type="hidden" name="status" value="completed">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row py-2">--}}
{{--                                                <div class="col-md-6 order-checkbox">--}}
{{--                                                    <div class="d-flex justify-content-start order-checkbox-content">--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="order_number">&nbsp; Order No &nbsp; &nbsp;</div>--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="created_via">&nbsp; ChannelFactory &nbsp; &nbsp;</div>--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="customer_name">&nbsp; Name &nbsp; &nbsp;</div>--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="customer_country">&nbsp; Country &nbsp; &nbsp;</div>--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="city">&nbsp; City &nbsp; &nbsp;</div>--}}
{{--                                                        <div class="d-flex align-items-center"><input type="checkbox" name="chek_value[]" value="total_price">&nbsp; Total Price &nbsp; &nbsp;</div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md-6 order-search-btn">--}}
{{--                                                    <button type="submit"><i class="fa fa-search"></i></button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}

{{--                            </div>--}}



                            <!--// END Form inside search and checkbox button field --->

                                <!--start table upper side content-->
                                <div class="product-inner dispatched-order">
                                    <div class="dispatched-search-area">
{{--                                        <div data-tip="Search by OrderNo, CustomerName, City, PostCode, ProductName, Sku">--}}
{{--                                            <input type="text" class="form-control dispatch-oninput-search ajax-order-search" name="search_oninput" id="search_oninput" placeholder="Search...">--}}
{{--                                            <input type="hidden" name="order_search_status" id="order_search_status" value="completed">--}}
{{--                                        </div>--}}
                                    </div>

                                    <!--Pagination area-->
                                    <div class="pagination-area dispatched-pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$all_completed_order->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($all_completed_order->currentPage() > 1)
                                                    <a class="first-page btn {{$all_completed_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_completed_order_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_completed_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_completed_order_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_completed_order_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_completed_order_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="completed/order/list">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($all_completed_order->currentPage() !== $all_completed_order->lastPage())
                                                    <a class="next-page btn" href="{{$all_completed_order_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_completed_order_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


                                <!--start table section-->
                                <table class="order-table w-100" style="border-collapse:collapse;">
                                    <thead>
                                    <form action="{{url('all-column-search')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="search_route" value="completed/order/list">
                                        <input type="hidden" name="status" value="completed">
                                    <tr>
                                        {{--                                                <th><input type="checkbox" id="ckbCheckAll"  /><label for="selectall"></label></th>--}}
                                        <th class="order-no" style="width: 20%; text-align: center;">
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
                                        @if($shelfUse == 1)
                                        <th class="picker" style="text-align: center; width: 10%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['picker'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="picker">
                                                            <option value=""></option>
                                                            @isset($users)
                                                                {{-- @if($users->count() == 1)
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                @else --}}
                                                                    <option value="">Select Picker</option>
                                                                    @foreach($users as $user)
                                                                        @if(isset($allCondition['picker']) && ($allCondition['picker'] == $user->id))
                                                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                        @else
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                {{-- @endif --}}
                                                            @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="picker_optout" type="checkbox" name="picker_optout" value="1" @isset($allCondition['picker_optout']) checked @endisset><label for="picker_optout">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['picker']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="submit" name="picker" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Picker</div>
                                            </div>
                                        </th>
                                        <th class="packer" style="width: 10%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['packer'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="packer">
                                                            <option value=""></option>
                                                            @isset($users)
                                                                {{-- @if($users->count() == 1)
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                @else --}}
                                                                    <option value="">Select Packer</option>
                                                                    @foreach($users as $user)
                                                                        @if(isset($allCondition['packer']) && ($allCondition['packer'] == $user->id))
                                                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                        @else
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                {{-- @endif --}}
                                                            @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="packer_opt_out" type="checkbox" name="packer_opt_out" value="1" @isset($allCondition['packer_opt_out']) checked @endisset><label for="packer_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['packer']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="submit" name="packer" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Packer</div>
                                            </div>
                                        </th>
                                        <th class="assigner" style="width: 10%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['assigner'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="assigner">
                                                            <option value=""></option>
                                                            @isset($users)
                                                                {{-- @if($users->count() == 1)
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                                    @endforeach
                                                                @else --}}
                                                                    <option value="">Select Assigner</option>
                                                                    @foreach($users as $user)
                                                                        @if(isset($allCondition['assigner']) && ($allCondition['assigner'] == $user->id))
                                                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                        @else
                                                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                {{-- @endif --}}
                                                            @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="assigner_optout" type="checkbox" name="assigner_optout" value="1" @isset($allCondition['assigner_optout']) checked @endisset><label for="assigner_optout">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['assigner']))
                                                                <div class="individual_clr">
                                                                    <button title="Clear filters" type="submit" name="assigner" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                                </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div> Assigner </div>
                                            </div>
                                        </th>
                                        @endif
                                        <th class="total-price filter-symbol" style="width: 10%;">
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
                                        <th class="shipping-post-code" style="text-align: center !important; width: 10%;">
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
                                        {{-- <th class="shipping-cost filter-symbol" style="width: 10%;">Shipping Cost</th> --}}
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
                                        <div><div class="d-flex justify-content-center align-items-center">
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
                                    @isset($all_completed_order)
                                        @isset($allCondition)
                                        @if(count($all_completed_order) == 0 && count($allCondition) != 0)
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
                                    @foreach($all_completed_order as $completed_order)
                                        <tr>
                                            {{--                                                    <td>--}}
                                            {{--                                                        <input type="checkbox" class=" checkBoxClass" id="customCheck{{$completed_order->id}}" name="multiple_order[]" value="{{$completed_order->id}}" required>--}}
                                            {{--                                                    </td>--}}
                                            <td class="order-no" style="cursor: pointer; min-width: 10%; max-width: 20%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
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

                                                {{-- Clear filters loader added --}}
                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            </td>
                                            <td class="order-date" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                                                {{$CommonFunction->getDateByTimeZone($completed_order->date_created)}}
                                            </td>
                                            @if($completed_order->status == 'processing')
                                                <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-warning label-status">{{$completed_order->status}}</span></td>
                                            @elseif($completed_order->status == 'completed')
                                                <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><span class="label label-table label-success label-status">{{$completed_order->status}}</span></td>
                                            @else
                                                <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;">{{ucfirst($completed_order->status)}}</td>
                                            @endif
                                            @if(($completed_order->created_via == 'ebay' || $completed_order->created_via == 'Ebay') && ($completed_order->account_id == null))
                                                <td class="channel" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle"><i class="fab fa-ebay fa-3x"></i></td>
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
                                            
                                            <td class="order-product" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">{{count($completed_order->product_variations)}}</td>
                                            @if($shelfUse == 1)
                                                @php
                                                    $pickedTime = '';
                                                    foreach ($completed_order->product_variations as $variation){
                                                        //$pickedTime = $variation->pivot->updated_at ? date(('d-m-Y H:i:s'),strtotime($variation->pivot->updated_at)) : '';
                                                        $pickedTime = $CommonFunction->getDateByTimeZone($variation->pivot->updated_at);
                                                    }
                                                @endphp
                                                <td class="picker" style="cursor: pointer; text-align: center !important; width: 10%;" data-toggle="collapse" data-target="#demo{{$completed_order->order_number}}" class="accordion-toggle">
                                                <span title="{{$pickedTime ?? ''}}">{{$completed_order->picker_info->name ?? ''}}</span>
                                                    <!-- <a tabindex="0" class="label label-default" role="button" data-toggle="popover" data-placement="top" data-trigger="focus" title="Picked On" data-content="{{$pickedTime ?? ''}}">View Picked Time</a> -->
                                                    <!-- <p>Picked On</p>
                                                    <p class="text-nowrap">{{$pickedTime}}</p> -->
                                                </td>
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
                                                                {{--                                                            <a href="{{url('choose-return-product/'.$completed_order->id)}}"><button class="vendor_btn_edit btn-warning w-100 text-center">Return</button></a>--}}
                                                                {{-- <a href="{{url('choose-return-product/'.$completed_order->id)}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn mr-2" data-toggle="tooltip" data-placement="top" title="Return Order"><i class="fa fa-undo" aria-hidden="true"></i></button></a> --}}
                                                                <button style="cursor: pointer" onclick="dispatchedReturnOrderBtn(this,{{ $completed_order->id }})" class="btn-size order-return-btn mr-2" data-toggle="tooltip" data-placement="top" title="Return Order"><i class="fa fa-undo" aria-hidden="true"></i></button>
                                                                @if(!isset($completed_order->order_note))
                                                                    {{--                                                                <button type="button" class="btn btn-primary btn-sm order-note m-t-5 w-100 text-center append_button{{$completed_order->id}}" id="{{$completed_order->id}}">Add Note</button>--}}
                                                                    <button type="button" style="cursor: pointer" class="btn-size add-note-btn order-note append_button{{$completed_order->id}} mr-2" id="{{$completed_order->id}}" data-toggle="tooltip" data-placement="top" title="Add Note"><i class="fas fa-sticky-note" aria-hidden="true"></i></button>
                                                                @endif
                                                                <a href="{{url('manual-order/'.$completed_order->id)}}" target="_blank"><button style="cursor: pointer" class="btn-size order-return-btn" data-toggle="tooltip" data-placement="top" title="Exchange Return"><i class="fa fa-paper-plane" aria-hidden="true"></i></button></a>

                                                                <a style="background:skyblue !important; margin-right:7px; margin-left:7px;" href="{{url('order/list/pdf/'.$completed_order->order_number.'/1')}}" class="btn-size cancel-btn order-btn" data-toggle="tooltip" data-placement="top" title="Invoice"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
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
                                                        <form id="return-reason-form" class="return-reason-form" onsubmit="return returnReasonValidation(event)" onclick="abc({{ $completed_order->id }})" action="{{url('save-return-order')}}" method="post">
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
                                                                                            <td class="text-center" style="width: 5%">
                                                                                                <a target="_blank" title="Click to print" href="{{url('print-barcode/'.$product->id ?? '')}}">
                                                                                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(60)->generate($product->sku ?? ''); !!}
                                                                                                </a>
                                                                                            </td>
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
                                                                                    </div>
                                                                                    <input type="hidden" class="individual-return-reason" id="individual-return-reason-{{ $single_order_product->id }}" name="return_reasone">
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
                                                    </div><!--End return-order-modal-body-->
                                                </div><!--End return-order-modal-->
                                            </td>
                                            <!--End Action Button-->
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
                                                                                <h6 class="text-left">Shipping </h6>
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
                                                    <span class="displaying-num"> {{$all_completed_order->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                    @if($all_completed_order->currentPage() > 1)
                                                    <a class="first-page btn {{$all_completed_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_completed_order_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$all_completed_order->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_completed_order_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex pl-1"> {{$all_completed_order_info->current_page}} of <span class="total-pages">{{$all_completed_order_info->last_page}}</span></span>
                                                    </span>
                                                    @if($all_completed_order->currentPage() !== $all_completed_order->lastPage())
                                                    <a class="next-page btn" href="{{$all_completed_order_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_completed_order_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
    <!--End Modal Start-->




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
                        <button type="button" class="btn btn-primary addUpdateReason add_reason" onclick="addUpdate()">Add</button>
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






    {{--    vue script start--}}
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




    <script>
        // Select option jquery
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
        // table column hide and show toggle checkbox
        $("input:checkbox").click(function(){
            let column = "."+$(this).attr("name");
            $(column).toggle();
        });

        // Entire table row column display
        $("#display-all").click(function(){
            $("table tr th, table tr td").show();
            $(".disp-column-display li input[type=checkbox]").prop("checked", "true");
        });

        // After unchecked any column display all checkbox will be unchecked
        $(".disp-column-display li input[type=checkbox]").change(function(){
            if (!$(this).prop("checked")){
                $("#display-all").prop("checked",false);
            }
        });

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
        var button_name = $('button.addUpdateReason').text();
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



    function dispatchedReturnOrderBtn(e,id){
        // alert(id)
        $('#dispatchedReturnOrder'+id).show()
        $(e).closest('tr').css('background-color','#F7F635 !important')

    }

    function trashClick(e){
        $(e).closest('div.return-order-modal').hide()
        $(e).closest('tr').css('background-color', '#fafafa')
        $('input.individual-return-reason').val(null)
        $('div.return-reason').css('background-color','var(--wms-primary-color)')
    }

    function dispatchedReturnCost(e){
        // alert(e)
        if($(e).val() != ''){
            $(e).addClass('p-bottom')
            $('div.abc').show()
        }else{
            $(e).removeClass('p-bottom')
            $('div.abc').hide()
        }
    }

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

    $(document).ready(function(){
        var returnProductText = $('div#returnOrderSuccessMsg').text()
        // var id = returnProductText.replace(/[^0-9.]/g, "")
        // alert(id)
        if(returnProductText != ''){
            Swal.fire({
            icon: 'success',
            title: 'Return product added successfully. Do you want to restock this product?',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Restock',
            }).then((result) => {
                if (result.isConfirmed) {
                    // $('div#receive-invoice-modal-'+id).show()
                    $('div#receive-invoice-modal').show()
                } else if (result.isDenied) {
                    //
                }
            })
        }
    })


    function closeReceiveInvoiceModal(e){
        $(e).closest('div.receive-invoice-modal').hide()
    }

    $('select.shelver_user_id').first().on('change',function(){
        var getFirstSelectedValue = $(this).val()
        $('select.shelver_user_id option').each(function(){
            if(this.value == getFirstSelectedValue){
                $(this).attr('selected','selected')
            }
        })
    })

    $('button.remove-more-invoice').on('click',function(){
        var trCount = $('tr.invoice-row').length
        if(trCount != 1){
            $(this).closest('tr').remove()
        }else{
            //
        }

    })

    $('select#invoice_number').on('change',function (event) {
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            url: '{{url('/get-vendor').'?_token='.csrf_token()}}',
            data: {
                'invoice_number': value
            },
            success: function (data) {
                $('select[name="vendor_id"]').find('option').attr("selected",false);
                $('select[name="vendor_id"]').find('option[value='+data.vendor_id+']').attr("selected",true);
                //document.getElementById('vendor_id'). = 1;
                // document.getElementById("livesearch").style.border = "1px solid #A5ACB2";

            },
            error: function (jqXHR, exception) {

            }
        });

        // document.getElementById("invoice_number").value = value;
    });
    $('select[name="vendor_id"]').on('change',function(){
        var supplierId = $(this).val()
        if(supplierId == ''){
            alert('Please select supplier')
        }
        $('select[name="invoice_number"] > option').each(function(){
            if(this.id != ''){
                if(supplierId == this.id){
                    $("select[name='invoice_number'] option[id=" + this.id + "]").attr("selected",true);
                }else{
                    $("select[name='invoice_number'] option[id=" + this.id + "]").hide();
                }
            }
        })
    })


    $(document).ready(function(){
        var receiveInvoiceSuccessMessage = $('#receiveInvoiceSuccessMessage').text()
        if(receiveInvoiceSuccessMessage){
            Swal.fire({
                icon: 'success',
                title: ''+receiveInvoiceSuccessMessage+'',
            })
        }
    })


     //Modal button receive invoice modal spining btn
     $('button.receiveInvoiceModalBtn').click(function(){
        $(this).html(
            `<span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>Restocking this product`
        );
        $(this).addClass('changeCatalogBTnCss');
    })

</script>



@endsection
