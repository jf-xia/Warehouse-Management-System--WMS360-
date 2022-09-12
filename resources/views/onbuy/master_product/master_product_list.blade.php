@extends('master')

@section('title')
    {{$page_title}}
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

    <div class="content-page onbuy-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">

                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="row content-inner mt-2 mb-2">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['image']) && $setting['onbuy']['onbuy_active_product']['image'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['image']) && $setting['onbuy']['onbuy_active_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="opc" class="onoffswitch-checkbox" id="opc" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['opc']) && $setting['onbuy']['onbuy_active_product']['opc'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['opc']) && $setting['onbuy']['onbuy_active_product']['opc'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="opc">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>OPC</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-id" class="onoffswitch-checkbox" id="catalogue-id" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['catalogue-id']) && $setting['onbuy']['onbuy_active_product']['catalogue-id'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['catalogue-id']) && $setting['onbuy']['onbuy_active_product']['catalogue-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Catalogue ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-type" class="onoffswitch-checkbox" id="product-type" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['product-type']) && $setting['onbuy']['onbuy_active_product']['product-type'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['product-type']) && $setting['onbuy']['onbuy_active_product']['product-type'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-type">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Type</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="title" class="onoffswitch-checkbox" id="title" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['title']) && $setting['onbuy']['onbuy_active_product']['title'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['title']) && $setting['onbuy']['onbuy_active_product']['title'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="title">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['category']) && $setting['onbuy']['onbuy_active_product']['category'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['category']) && $setting['onbuy']['onbuy_active_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="master_base_price" class="onoffswitch-checkbox" id="master_base_price" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['master_base_price']) && $setting['onbuy']['onbuy_active_product']['master_base_price'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['master_base_price']) && $setting['onbuy']['onbuy_active_product']['master_base_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="master_base_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>MSP</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['product']) && $setting['onbuy']['onbuy_active_product']['product'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['product']) && $setting['onbuy']['onbuy_active_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['status']) && $setting['onbuy']['onbuy_active_product']['status'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['status']) && $setting['onbuy']['onbuy_active_product']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="queue-id" class="onoffswitch-checkbox" id="queue-id" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['queue-id']) && $setting['onbuy']['onbuy_active_product']['queue-id'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['queue-id']) && $setting['onbuy']['onbuy_active_product']['queue-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="queue-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Queue ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['sku']) && $setting['onbuy']['onbuy_active_product']['sku'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['sku']) && $setting['onbuy']['onbuy_active_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['qr']) && $setting['onbuy']['onbuy_active_product']['qr'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['qr']) && $setting['onbuy']['onbuy_active_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['variation']) && $setting['onbuy']['onbuy_active_product']['variation'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['variation']) && $setting['onbuy']['onbuy_active_product']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="rrp" class="onoffswitch-checkbox" id="rrp" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['rrp']) && $setting['onbuy']['onbuy_active_product']['rrp'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['rrp']) && $setting['onbuy']['onbuy_active_product']['rrp'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="rrp">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>RRP</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['sales-price']) && $setting['onbuy']['onbuy_active_product']['sales-price'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['sales-price']) && $setting['onbuy']['onbuy_active_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation_base_price" class="onoffswitch-checkbox" id="variation_base_price" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['variation_base_price']) && $setting['onbuy']['onbuy_active_product']['variation_base_price'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['variation_base_price']) && $setting['onbuy']['onbuy_active_product']['variation_base_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation_base_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation Base Price</p></div>
                                    </div>
                                    {{-- <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['sales-price']) && $setting['onbuy']['onbuy_active_product']['sales-price'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['sales-price']) && $setting['onbuy']['onbuy_active_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div> --}}
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation_max_price" class="onoffswitch-checkbox" id="variation_max_price" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['variation_max_price']) && $setting['onbuy']['onbuy_active_product']['variation_max_price'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['variation_max_price']) && $setting['onbuy']['onbuy_active_product']['variation_max_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation_max_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Max Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="condition" class="onoffswitch-checkbox" id="condition" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['condition']) && $setting['onbuy']['onbuy_active_product']['condition'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['condition']) && $setting['onbuy']['onbuy_active_product']['condition'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="condition">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Condition</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qty" class="onoffswitch-checkbox" id="qty" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['qty']) && $setting['onbuy']['onbuy_active_product']['qty'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['qty']) && $setting['onbuy']['onbuy_active_product']['qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Quantity</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="boost_listing_commission" class="onoffswitch-checkbox" id="boost_listing_commission" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['boost_listing_commission']) && $setting['onbuy']['onbuy_active_product']['boost_listing_commission'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['boost_listing_commission']) && $setting['onbuy']['onbuy_active_product']['boost_listing_commission'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="boost_listing_commission">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Boost Commission</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="lead_listing" class="onoffswitch-checkbox" id="lead_listing" tabindex="0" @if(isset($setting['onbuy']['onbuy_active_product']['lead_listing']) && $setting['onbuy']['onbuy_active_product']['lead_listing'] == 1) checked @elseif(isset($setting['onbuy']['onbuy_active_product']['lead_listing']) && $setting['onbuy']['onbuy_active_product']['lead_listing'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="lead_listing">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Lead Listing</p></div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="onbuy">
                            <input type="hidden" id="secondKey" value="onbuy_active_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                            <!--Pagination count and apply button section-->
                            <div class="d-flex justify-content-between pagination-content">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                    <div class="submit">
                                        <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                                    </div>
                                </div>
                                <div style="float: right">
                                    <a href="{{url('onbuy/lead-listing-check')}}" class="btn btn-primary">First Lead Check</a>
                                </div>
                            </div>
                            <!--End Pagination count and apply button section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">OnBuy</li>
                            <li class="breadcrumb-item active" aria-current="page">Active Product</li>
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


                <!--Card box start-->
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <div class="card-box table-responsive onbuy shadow">

                            <!--Start Backend error handler-->
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            @if(Session::has('no_data_found'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! Session::get('no_data_found') !!}</strong>
                                </div>
                            @endif

                            @if(Session::has('empty_data_submit'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{!! Session::get('empty_data_submit') !!}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!--End Backend error handler-->

                            <!--start table upper side content-->
                            <div class="m-b-20 m-t-10">
                                <form class="mobile-queueIdBulkCheck" action="Javascript:void(0);" method="post">
                                    <button type="button" class="btn btn-primary queueIdBulkCheck mb-2">Queue ID Bulk Check</button>
                                </form>

                                <div class="product-inner">
                                    <div class="onbuy-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search on OnBuy...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search();">Search</button>
                                            </div>
                                            <button type="button" class="btn btn-primary queueIdBulkCheck desktop-queueIdBulkCheck">Queue ID Bulk Check</button>
                                        </form>
                                    </div>
                                    <div class="m-l-10" style="width: 30%;">
                                        <select class="form-control" name="leadListing" id="leadListing">
                                            <option value="">Select Lead Listing Option</option>
{{--                                            <option value="1">Lead Listing</option>--}}
                                            <option value="0">Not Lead Listing</option>
                                        </select>
                                    </div>
                                    <div class="m-l-10 make-lead-button" style="width: 10%; display: none">
                                        <button class="btn btn-primary">Make Lead</button>
                                    </div>
                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{($master_product_list->total())}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $decode_master_product->first_page_url.$url : $decode_master_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $decode_master_product->prev_page_url.$url : $decode_master_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$decode_master_product->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$decode_master_product->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="onbuy/master-product-list">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $decode_master_product->next_page_url.$url : $decode_master_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $decode_master_product->last_page_url.$url : $decode_master_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                                <div class="m-t-20 bulk-add-sale-price" style="display: none">
                                    <div class="" style="border: 1px solid #ddd0d0;border-radius: 5px;">
                                        <div class="col-md-12">
                                            <h5>Sale Price and Boost Commission Information</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <form action="#" class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="sale_price">Sale Price</label>
                                                    <input type="text" class="form-control" name="sale_price" placeholder="Enter sale price">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sale_start_date">Sale Price Start Date</label>
                                                    <input type="date" class="form-control" name="sale_start_date">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sale_end_date">Sale Price End Price</label>
                                                    <input type="date" class="form-control" name="sale_end_date">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="boost_marketing_commission">Boost Marketing Commission</label>
                                                    <input type="text" class="form-control" name="boost_marketing_commission" placeholder="Enter boost commission value">
                                                </div>
                                                <button type="button" class="btn btn-primary m-b-10">Bulk update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End table upper side content-->

                            <!--Start Loader-->
                            {{-- <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div> --}}
                            <!--End Loader-->


                            <!--Start Table-->
                            <table class="onbuy-table w-100">
                                <!--start table head-->
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post">
                                @csrf

                                <input type="hidden" name="search_route" value="onbuy/master-product-list">
                                <!-- <input type="hidden" name="status" value="publish"> -->
                                <tr>
                                    <th class="chekbox-header text-center">
                                        <input type="checkbox" id="selectAllCheckbox">
                                    </th>
                                    <th class="image text-center" style="width: 6% !important;">Image</th>
                                    <th class="opc" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['opc'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="opc" value="{{$allCondition['opc'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opc_opt_out" type="checkbox" name="opc_opt_out" value="1" @isset($allCondition['opc_opt_out']) checked @endisset><label for="opc_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="opc"> -->
                                                        @if(isset($allCondition['opc']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="opc" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>OPC</div>
                                        </div>
                                    </th>
                                    <th class="catalogue-id" style="width: 12%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['woo_catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="woo_catalogue_id" value="{{$allCondition['woo_catalogue_id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="woo_catalogue_id_opt_out" type="checkbox" name="woo_catalogue_id_opt_out" value="1" @isset($allCondition['woo_catalogue_id_opt_out']) checked @endisset><label for="woo_catalogue_id_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="woo_catalogue_id"> -->
                                                        @if(isset($allCondition['woo_catalogue_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="woo_catalogue_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Catalogue ID</div>
                                        </div>
                                    </th>
                                    <th class="product-type" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['product_type'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <select class="form-control select2 b-r-0" name="product_type">
                                                        <option value="">Select Type</option>
                                                        <option value="simple" @if(isset($allCondition['product_type']) && ($allCondition['product_type'] == 'simple')) selected @endif>Simple</option>
                                                        <option value="variable" @if(isset($allCondition['product_type']) && ($allCondition['product_type'] == 'variable')) selected @endif>Variable</option>
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="product_type_opt_out" type="checkbox" name="product_type_opt_out" value="1" @isset($allCondition['product_type_opt_out']) checked @endisset><label for="product_type_opt_out">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['product_type']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="product_type" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Type</div>
                                        </div>
                                    </th>
                                    <th class="title pl-3" style="width: 26%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="title_opt_out" type="checkbox" name="title_opt_out" value="1" @isset($allCondition['title_opt_out']) checked @endisset><label for="title_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="product_name"> -->
                                                        @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Title</div>
                                        </div>
                                    </th>
                                    <th class="category" style="width: 14%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['category'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2 b-r-0" name="category[]" multiple>
                                                            @if(isset($distinct_category))
                                                                @if($distinct_category->count() == 1)
                                                                    @foreach($distinct_category as $product_list)
                                                                        <option value="{{$product_list->category_id}}">{{$product_list->name}} (<small>{{$product_list->category_tree}}</small>)</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach($distinct_category as $product_list)
                                                                        @if(isset($allCondition['category']))
                                                                            @php
                                                                                $existCategory = null;
                                                                            @endphp
                                                                            @foreach($allCondition['category'] as $cat)
                                                                                @if($product_list->category_id == $cat)
                                                                                    <option value="{{$product_list->category_id}}" selected>{{$product_list->name}} (<small>{{$product_list->category_tree}}</small>)</option>
                                                                                    @php
                                                                                        $existCategory = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existCategory == null)
                                                                            <option value="{{$product_list->category_id}}">{{$product_list->name}} (<small>{{$product_list->category_tree}}</small>)</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="{{$product_list->category_id}}">{{$product_list->name}} (<small>{{$product_list->category_tree}}</small>)</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="category_opt_out" type="checkbox" name="category_opt_out" value="1" @isset($allCondition['category_opt_out']) checked @endisset><label for="category_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="name"> -->
                                                        @if(isset($allCondition['category']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="category" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Category</div>
                                        </div>
                                    </th>
                                    <th class="master_base_price filter-symbol" style="width: 14%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['msp'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="msp_opt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['msp_opt']) && ($allCondition['msp_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['msp_opt']) && ($allCondition['msp_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['msp_opt']) && ($allCondition['msp_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['msp_opt']) && ($allCondition['msp_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['msp_opt']) && ($allCondition['msp_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="msp" value="{{$allCondition['msp'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="msp_opt_out" type="checkbox" name="msp_opt_out" value="1" @isset($allCondition['msp_opt_out']) checked @endisset><label for="msp_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="base_price"> -->
                                                        @if(isset($allCondition['msp']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="msp" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>MSP</div>
                                        </div>
                                    </th>
                                    <th class="product filter-symbol" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
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
                                                            <input id="product_opt_out" type="checkbox" name="product_opt_out" value="1" @isset($allCondition['product_opt_out']) checked @endisset><label for="product_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="product"> -->
                                                        @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Product</div>
                                        </div>
                                    </th>
                                    <th class="status" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['status'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2 b-r-0" name="status">
                                                            @if(isset($distinct_status))
                                                                @if($distinct_status->count() == 1)
                                                                    @foreach($distinct_status as $product_status)
                                                                        <option value="{{$product_status->status}}">{{ucfirst($product_status->status)}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Status</option>
                                                                     @foreach($distinct_status as $product_status)
                                                                        @if(isset($allCondition['status']) && ($allCondition['status'] == $product_status->status))
                                                                            <option value="{{$product_status->status}}" selected>{{ucfirst($product_status->status)}}</option>
                                                                        @else
                                                                            <option value="{{$product_status->status}}">{{ucfirst($product_status->status)}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="status_opt_out" type="checkbox" name="status_opt_out" value="1" @isset($allCondition['status_opt_out']) checked @endisset><label for="status_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="status"> -->
                                                        @if(isset($allCondition['status']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="status" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Status</div>
                                        </div>
                                    </th>
                                    <th class="queue-id" style="width: 10%">Queue ID</th>
                                    <th style="width: 6%">
                                        <div class="d-flex justify-content-center">
                                            <div>Actions</div> &nbsp; &nbsp;
                                            @if(count($allCondition) > 0)
                                                <div><a title="Clear filters" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                </form>
                                </thead>
                                <!--End table head-->

                                <!--start table body-->
                                <tbody>
                                @isset($allCondition)
                                @if(count($master_product_list) == 0 && count($allCondition) != 0)
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
                                @foreach($master_product_list as $product_list)
                                    <tr>
                                        <td class="text-center">
                                            @if($product_list->status == 'success')
                                                <input type="checkbox" class="checkBoxClass" value="{{$product_list->id}}">
                                            @endif
                                        </td>
                                        <td class="image" style="cursor: pointer; text-align: center !important; width: 6% !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$product_list->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            @if(isset($product_list->default_image))
                                                <a href="{{$product_list->default_image}}"  title="Click to expand" target="_blank"><img src="{{$product_list->default_image}}" class="onbuy-image zoom" alt="master-image"></a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="onbuy-image zoom" alt="master-image">
                                            @endif

                                        </td>

{{--                                        <td class="opc" style="text-align: center !important; width: 10%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                                        <td class="opc" style="text-align: center !important; width: 10%;">
                                            <span id="master_opc_{{$product_list->queue_id}}">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->opc}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </span>
                                        </td>

                                        <td class="catalogue-id text-center" style="width: 12%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            <span id="master_opc_{{$product_list->queue_id}}">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->woo_catalogue_id}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </span>
                                        </td>
                                        <td class="product-type" style="cursor: pointer; width: 14%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->product_type}}</td>
                                        <td class="title pl-3" style="cursor: pointer; width: 26%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            <a class="catalogue-name" href="https://seller.onbuy.com/inventory/edit-product-basic-details/{{$product_list->product_id}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                {!! Str::limit(strip_tags($product_list->product_name),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <td class="category" style="cursor: pointer; width: 14%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->category_info->name}}(<small>{{$product_list->category_info->category_tree}}</small>)</td>
                                        <td class="master_base_price" style="cursor: pointer; width: 14%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->base_price ?? ''}}</td>
                                        <td class="product text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">{{$product_list->variation_product_count}}</td>
                                        <td class="status" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle"><span class="label label-status label-@if($product_list->status == 'success')success @elseif($product_list->status == 'pending')warning @elseif($product_list->status == 'failed')danger @endif">{{$product_list->status}}</span></td>
{{--                                        <td class="queue-id" style="width: 10%">--}}
{{--                                            <div class="d-block">--}}
{{--                                                <div data-tip="{{$product_list->queue_id}}">--}}
{{--                                                    <button type="button" style="cursor: pointer" class="btn btn-success btn-sm" onclick="check_queue_id('{{$product_list->queue_id}}')">Check Status</button>--}}
{{--                                                </div>--}}
{{--                                                <div>--}}
{{--                                                    <span id="status_show_{{$product_list->queue_id}}" class="label label-default label-status"></span><br>--}}
{{--                                                    <span id="error_show_{{$product_list->queue_id}}" class="label label-danger label-status"></span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
                                        <td class="queue-id" style="width: 10%;">
                                            <div class="d-block">
                                                <div data-tip="{{$product_list->queue_id}}">
                                                    <button type="button" style="cursor: pointer" class="btn btn-success btn-sm" onclick="check_queue_id('{{$product_list->queue_id}}')">Check Status</button>
                                                </div>
                                                <div>
                                                    <span id="status_show_{{$product_list->queue_id}}" class="label label-default label-status"></span>
                                                    <span id="error_show_{{$product_list->queue_id}}" class="label label-danger label-status"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="actions" style="width: 6%">
                                            <!--start manage button area-->
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <!--start dropup content-->
                                                <div class="dropdown-menu">
                                                    <div class="dropup-content onbuy-dropup-content">
                                                        <div class="action-1">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('onbuy/edit-master-product/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('onbuy/master-product-details/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('onbuy/delete-listing/'.$product_list->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--End dropup content-->
                                            </div>
                                            <!--End manage button area-->

                                        </td>
                                    </tr>



                                    <!--hidden row -->
                                    <tr>
                                        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$product_list->id}}">

                                            </div> <!-- end accordion body -->
                                        </td> <!-- hide expand td-->
                                    </tr> <!-- hide expand row-->


                                @endforeach
                                </tbody>
                                <!--End table body-->

                            </table>
                            <!--End Table-->

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$master_product_list->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $decode_master_product->first_page_url.$url : $decode_master_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $decode_master_product->prev_page_url.$url : $decode_master_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1">{{$decode_master_product->current_page}} of<span class="total-pages">{{$decode_master_product->last_page}}</span></span>
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $decode_master_product->next_page_url.$url : $decode_master_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $decode_master_product->last_page_url.$url : $decode_master_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                        </div>
                    </div>
                </div>
                <!--End Card box start-->

            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->

    <script type="text/javascript">

        //Select option jquery
        $(".select2").select2();

        var searchPriority = 0;
        var skip = 0;
        var take = 10;
        var ids = [0];

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table").find(".collapse.in").not(this).collapse('toggle')
        })


        function check_queue_id(id) {

            $.ajax({
                type: "POST",
                url: "{{url('onbuy/check-queue-id')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "queue_id": id
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    if(response.status == 'success') {
                        $('#master_opc_'+id).html(response.opc);
                        $('#status_show_'+id).html(response.status);
                    }else if(response.status == 'failed'){
                        $('#status_show_'+id).html(response.status);
                        $('#error_show_' + id).html(response.error_message);
                    }
                    else{
                        $('#status_show_'+id).html(response.status);
                    }
                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }

        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            // var status = $('#onbuy_status').val();
            var status = 'active'
            var id = product_draft_id[1]
            $.ajax({
                type: "post",
                url: "{{url('get-onbuy-variation')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "product_draft_id" : id,
                    "status" : status,
                },
                beforeSend: function () {
                    $('#product_variation_loading'+id).show();
                },
                success: function (response) {
                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }

        function catalogue_search(){
            var search_value = $('#search_value').val();
            if(search_value == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }

            ids = [0];
            searchPriority = 0;
            skip = 0;
            // var category_id = $('#category_id').val();
            $.ajax({
                type: "POST",
                url: "{{url('onbuy/search-product-list')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "name": search_value,
                    "search_priority": searchPriority,
                    "skip": skip,
                    "take": take,
                    "ids": ids,
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    if (response.ids.length === 0) {
                        $(document).ready(function() {
                            Swal.fire(
                                'No result found',
                                '',
                                'info'
                            )
                        });
                    }
                    if(response != 'error') {
                        $('tbody').html(response.html);
                        searchPriority = response.search_priority;
                        take = response.take;
                        skip = parseInt(response.skip)+10;
                        ids = ids.concat(response.ids);
                    }else{
                        $("#product_variation_loading").hide();
                        alert('No Catalogue Found');
                    }
                },complete: function () {
                    $("#ajax_loader").hide();
                }
            });
        }

        $(document).bind("scroll", function(e){

            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){

                var search_value = $('#search_value').val();

                if(search_value != '' ){


                    $.ajax({
                        type: 'POST',
                        url: "{{url('onbuy/search-product-list')}}",
                        data: {
                            "_token" : "{{csrf_token()}}",
                            "name": search_value,
                            "search_priority": searchPriority,
                            "skip": skip,
                            "take": take,
                            'ids': ids
                        },
                        beforeSend: function(){
                            window.stop();
                        },
                        success: function(response){
                            if (response.ids.length === 0) {
                                $(document).ready(function() {
                                    Swal.fire(
                                        'No result found',
                                        '',
                                        'info'
                                    )
                                });
                            }
                            searchPriority = response.search_priority;
                            take = response.take;
                            skip = parseInt(response.skip)+10;

                            $('tbody tr:last').after(response.html);
                            // var div = document.getElementById('tbody');
                            // div.innerHTML +=response.html;

                            ids = ids.concat(response.ids);


                        },
                        complete:function(data){
                            // Hide image container
                            $("#ajax_loader").hide();
                            // call this to Enable
                        }
                    });
                }
            }
        });
        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });

            $('.queueIdBulkCheck').on('click', function () {
                $.ajax({
                    type: "GET",
                    url: "{{url('onbuy/queue-id-bulk-check')}}",
                    beforeSend: function(){
                        $("#ajax_loader").show();
                    },
                    success: function (response) {
                        if(response != 'no-data') {
                            response.results.forEach(function (item) {
                                if (item.status == 'success') {

                                    $('#master_opc_' + item.queue_id).html(item.opc);
                                    $('#status_show_' + item.queue_id).html(item.status);
                                } else if (item.status == 'failed') {

                                    $('#status_show_' + item.queue_id).html(item.status);
                                    $('#error_show_' + item.queue_id).html(item.error_message);
                                } else {
                                    $('#status_show_' + item.queue_id).html(item.status);
                                }
                            });
                        }else{
                            alert('No pending Queue Id found.')
                        }
                    },
                    complete:function(data){
                        $("#ajax_loader").hide();
                    }
                });
            })
            $('#selectAllCheckbox').click(function (){
                $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                var catalogueIds = catalogueIdArray();
            });
            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#selectAllCheckbox").prop("checked",false);
                }
                var catalogueIds = catalogueIdArray();
            });
            $('.bulk-add-sale-price button').on('click',function (){
                var catalgoueIDs = catalogueIdArray();
                var salePrice = $("input[name=sale_price]").val();
                var salePriceStartDate = $("input[name=sale_start_date]").val();
                var salePriceEndDate = $("input[name=sale_end_date]").val();
                var boostCommission = $("input[name=boost_marketing_commission]").val();
                if(salePrice){
                    if(salePriceStartDate == '' || salePriceEndDate == ''){
                        swal.fire({
                            position : 'top',
                            title : 'Please select sale price start and end date',
                            icon : 'warning'
                        });
                        return;
                    }
                }
                if(salePrice == '' && boostCommission == ''){
                    swal.fire({
                        position : 'top',
                        title : 'Please select sale price or boost commission value',
                        icon : 'warning'
                    });
                    return;
                }
                $.ajax({
                    type: "post",
                    url: "{{url('onbuy/bulk-sale-price-boost-commission')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "catalogueIDs": catalgoueIDs,
                        "salePrice": salePrice,
                        "salePriceStartDate": salePriceStartDate,
                        "salePriceEndDate": salePriceEndDate,
                        "boostCommission": boostCommission
                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        if(response.data == 'success'){
                            swal.fire({
                                title: response.msg,
                                icon: 'success'
                            });
                        }else{
                            swal.fire({
                                title: response.msg,
                                icon: 'error'
                            });
                        }
                        $('#ajax_loader').hide();
                    }
                });
            });

            $('select#leadListing').on('change',function (){
                var listingValue = $(this).val();
                $.ajax({
                    type: "post",
                    url: "{{url('onbuy/search-lead-listing-product')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "listingValue": listingValue
                    },
                    beforeSend: function (data){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        if(response.msg == 'success'){
                            $('tbody').html(response.data);
                        }
                    },
                    complete: function (){
                        $('#ajax_loader').hide();
                    }
                });
            });

            $('.make-lead-button button').click(function(){
                var catalogueIDs = catalogueIdArray();
                $.ajax({
                    type: "post",
                    url: "{{url('onbuy/make-lead-listing')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "catalogueIds": catalogueIDs
                    },
                    beforeSend: function(data){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        console.log(response);
                        if(response.msg == 'error'){
                            swal.fire({
                                title: response.exception,
                                icon: 'error'
                            });
                        }else if(response.msg == 'warning'){
                            swal.fire({
                                title: 'All product are in lead position',
                                icon: 'success'
                            });
                        }else {
                            var html = '<table class="table"><thead><tr><th scope="col">SKU</th><th scope="col">Old Price</th><th scope="col">Updated Price</th><th scope="col">Lead Price</th><th scope="col">Base Price</th></tr></thead><tbody>';
                            response.data.forEach(function (data) {
                                html += '<tr><td>' + data.sku + '</td><td>' + data.old_price + '</td><td>' + data.update_price + '</td><td>' + data.lead_price + '</td><td>' + data.base_price + '</td></tr>';
                            });
                            html += '</tbody></table>';
                            swal.fire({
                                title: 'Lead Price Set Successfully',
                                html: html,
                                icon: 'success'
                            });
                        }
                        $('#ajax_loader').hide();
                    }
                });
            });
        });

        function catalogueIdArray(){
            var order_number = [];
            var leadListingOption = $('select#leadListing').val();
            $('table tbody tr td :checkbox:checked').each(function (i) {
                order_number[i] = $(this).val();
            });
            if(leadListingOption == '' || leadListingOption == 1) {
                if (order_number.length == 0) {
                    $('div.bulk-add-sale-price').hide('slow');
                } else {
                    $('div.bulk-add-sale-price').show('slow');
                }
                $('.make-lead-button').hide('slow');
            }else{
                if(order_number.length == 0){
                    $('div.bulk-add-sale-price').hide('slow');
                    $('.make-lead-button').hide('slow');
                }else{
                    $('div.bulk-add-sale-price').hide('slow');
                    $('.make-lead-button').show('slow');
                }
            }
            return order_number;
        }

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

        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });


    </script>



@endsection
