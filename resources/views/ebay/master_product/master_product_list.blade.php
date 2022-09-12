@extends('master')

@section('title')
    {{$page_title}}
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
                        <div class="card-box screen-option-content" style="display: none">


                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="row content-inner ebay-content-inner mt-2 mb-2">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['image']) && $setting['ebay']['ebay_active_product']['image'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['image']) && $setting['ebay']['ebay_active_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="item-id" class="onoffswitch-checkbox" id="item-id" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['item-id']) && $setting['ebay']['ebay_active_product']['item-id'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['item-id']) && $setting['ebay']['ebay_active_product']['item-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="item-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Item ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-type" class="onoffswitch-checkbox" id="product-type" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['product-type']) && $setting['ebay']['ebay_active_product']['product-type'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['product-type']) && $setting['ebay']['ebay_active_product']['product-type'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-type">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Type</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-id" class="onoffswitch-checkbox" id="catalogue-id" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['catalogue-id']) && $setting['ebay']['ebay_active_product']['catalogue-id'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['catalogue-id']) && $setting['ebay']['ebay_active_product']['catalogue-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Catalogue ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="account" class="onoffswitch-checkbox" id="account" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['account']) && $setting['ebay']['ebay_active_product']['account'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['account']) && $setting['ebay']['ebay_active_product']['account'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="account">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Account</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-name" class="onoffswitch-checkbox" id="product-name" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['product-name']) && $setting['ebay']['ebay_active_product']['product-name'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['product-name']) && $setting['ebay']['ebay_active_product']['product-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['category']) && $setting['ebay']['ebay_active_product']['category'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['category']) && $setting['ebay']['ebay_active_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['stock']) && $setting['ebay']['ebay_active_product']['stock'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['stock']) && $setting['ebay']['ebay_active_product']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="profile" class="onoffswitch-checkbox" id="profile" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['profile']) && $setting['ebay']['ebay_active_product']['profile'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['profile']) && $setting['ebay']['ebay_active_product']['profile'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="profile">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Profile</p></div>
                                    </div>
{{--                                    <div class="d-flex align-items-center mt-2">--}}
{{--                                        <div class="onoffswitch">--}}
{{--                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['status']) && $setting['ebay']['ebay_active_product']['status'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['status']) && $setting['ebay']['ebay_active_product']['status'] == 0) @else checked @endif>--}}
{{--                                            <label class="onoffswitch-label" for="status">--}}
{{--                                                <span class="onoffswitch-inner"></span>--}}
{{--                                                <span class="onoffswitch-switch"></span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        <div class="ml-1"><p>Status</p></div>--}}
{{--                                    </div>--}}
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="promoted-listings" class="onoffswitch-checkbox" id="promoted-listings" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['promoted-listings']) && $setting['ebay']['ebay_active_product']['promoted-listings'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['promoted-listings']) && $setting['ebay']['ebay_active_product']['promoted-listings'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="promoted-listings">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Promoted Listings</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['creator']) && $setting['ebay']['ebay_active_product']['creator'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['creator']) && $setting['ebay']['ebay_active_product']['creator'] == 0) @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['modifier']) && $setting['ebay']['ebay_active_product']['modifier'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['modifier']) && $setting['ebay']['ebay_active_product']['modifier'] == 0) @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['sku']) && $setting['ebay']['ebay_active_product']['sku'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['sku']) && $setting['ebay']['ebay_active_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['sold']) && $setting['ebay']['ebay_active_product']['sold'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['sold']) && $setting['ebay']['ebay_active_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qty" class="onoffswitch-checkbox" id="qty" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['qty']) && $setting['ebay']['ebay_active_product']['qty'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['qty']) && $setting['ebay']['ebay_active_product']['qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Available Qty</p></div>
                                    </div>
                                    @if($shelfUse == 1)
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['shelf-qty']) && $setting['ebay']['ebay_active_product']['shelf-qty'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['shelf-qty']) && $setting['ebay']['ebay_active_product']['shelf-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shelf-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shelf Qty</p></div>
                                    </div>
                                    @endif
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['qr']) && $setting['ebay']['ebay_active_product']['qr'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['qr']) && $setting['ebay']['ebay_active_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['variation']) && $setting['ebay']['ebay_active_product']['variation'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['variation']) && $setting['ebay']['ebay_active_product']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="start-price" class="onoffswitch-checkbox" id="start-price" tabindex="0" @if(isset($setting['ebay']['ebay_active_product']['start-price']) && $setting['ebay']['ebay_active_product']['start-price'] == 1) checked @elseif(isset($setting['ebay']['ebay_active_product']['start-price']) && $setting['ebay']['ebay_active_product']['start-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="start-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Start Price</p></div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="ebay">
                            <input type="hidden" id="secondKey" value="ebay_active_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count and Apply Button Section-->

                            <div class="d-flex justify-content-between align-items-center pagination-content">
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


                                <!-- <div>
                                   <div class="submit" style="float: left">
                                        <a href="{{URL::to('check-ebay-end-listings')}}" class="btn submit-btn pagination-apply">Sync End List</a>
                                    </div>
                                </div> -->

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
                            <li class="breadcrumb-item">eBay</li>
                            <li class="breadcrumb-item active" aria-current="page">Active product</li>
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
                        <div class="card-box ebay table-responsive shadow">

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
                                <div class="product-inner">
                                    <div class="ebay-master-product-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search on eBay...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search();">Search</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!--Pagination area-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-not-all')}}" method="get">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">  {{$master_product_list->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$master_decode_product_list->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                        <input type="hidden" name="first_page_url" value="{{$master_decode_product_list->first_page_url}}">
                                                        <input type="hidden" name="route_name" value="ebay-master-product-list">
                                                        <input type="hidden" name="current_page" value="{{$master_product_list->currentPage()}}">
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$master_decode_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$master_decode_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                            </div>
                            <!--End table upper side content-->



                            <!--start loader-->
                            {{-- <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div> --}}
                            <!--End loader-->



                            <h5 class="search_result_count"></h5><!--search result count-->

                            <!--start table section-->
                            <!-- <div id="mytable"> -->
                            <table class="ebay-table w-100 mytable" id="testTable">
                                <!--start table head-->
                                <thead>
                                <tr>
                                    <th style="width: 6%; text-align: center"><input type="checkbox" id="checkAll">
                                        <div class="product-inner">
                                            <select id="checkCondition" required>
                                                <option selected disabled>Select Option</option>
                                                <option value="1">Relist</option>
                                                <option value="2">Check Status</option>
                                                <option value="3">Sync Quantity</option>
                                                <option value="4">End Product</option>
                                            </select>
                                        </div>
                                        <div class="product-inner"><button type="button" class="btn btn-default" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Send">Send</button></div>
                                    </th>
                                    <th class="image" style="width: 6% !important;">Image</th>
                                    <th class="item-id" style="width: 8%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('eBay/active/product/search')}}" method="get">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['item_id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="search_value[item_id][value]" value="{{isset($search_value['item_id']['value']) ? $search_value['item_id']['value'] : ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out1" type="checkbox" name="search_value[item_id][opt_out]" value="1" @isset($search_value['item_id']['opt_out']) checked @endisset><label for="opt-out1">Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="item_id">--}}
                                                        @if(isset($search_value['item_id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[item_id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="product-type" style="width: 6% !important;">Product Type</th>
                                    <th class="catalogue-id text-center" style="width: 8%;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['master_product_id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="search_value[master_product_id][value]" value="{{isset($search_value['master_product_id']['value']) ? $search_value['master_product_id']['value'] : ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out2" type="checkbox" name="search_value[master_product_id][opt_out]" value="1" @isset($search_value['master_product_id']['opt_out']) checked @endisset><label for="opt-out2" >Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="master_product_id">--}}
                                                        @if(isset($search_value['master_product_id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[master_product_id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Catalogue ID</div>
                                        </div>
                                    </th>
                                    <th class="account text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                {{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
                                                {{--                                                    @csrf--}}
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    @if(isset($search_value['account_name']['value']))
                                                        <i class="fa text-warning" aria-hidden="true"></i>
                                                    @else
                                                        <i class="fa" aria-hidden="true"></i>
                                                    @endif
                                                </a>
                                                @php
                                                    $account_name_list = \App\EbayAccount::orderBy('account_name', 'ASC')->get();
                                                @endphp
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <label>Filter Value</label>
                                                    <select class="form-control b-r-0" name="search_value[account_name][value]">
                                                        @isset($account_name_list)
                                                            @if($account_name_list->count() == 1)
                                                                @foreach($account_name_list as $account_name)
                                                                    <option value="{{$account_name->id}}">{{$account_name->account_name}}</option>
                                                                @endforeach
                                                            @else
                                                                @if(isset($search_value['account_name']['value']))
                                                                    <option value="">Select Account</option>
                                                                    @foreach($account_name_list as $account_name)

                                                                        @if($account_name->id == $search_value['account_name']['value'])
                                                                            <option value="{{$account_name->id}}" selected>{{$account_name->account_name}}</option>
                                                                        @else
                                                                            <option value="{{$account_name->id}}">{{$account_name->account_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option value="" selected>Select Account</option>
                                                                    @foreach($account_name_list as $account_name)
                                                                        <option value="{{$account_name->id}}">{{$account_name->account_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endisset
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out5" type="checkbox" name="search_value[account_name][opt_out]" value="1" @isset($search_value['account_name']['opt_out']) checked @endisset><label for="opt-out5" >Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="account_name">
                                                    @if(isset($search_value['account_name']['value']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="search_value[account_name][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                                {{--                                                </form>--}}
                                            </div>
                                            <div>Account</div>
                                        </div>
                                    </th>
                                    <th class="product-name" style="width: 20%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['title']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value[title][value]" value="{{isset($search_value['title']['value']) ? $search_value['title']['value']: ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out10" type="checkbox" name="search_value[title][opt_out]" value="1" @isset($search_value['title']['opt_out']) checked @endisset><label for="opt-out10">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="name">
                                                        @if(isset($search_value['title']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[title][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Product Name</div>
                                        </div>
                                    </th>
                                    <th class="category" style="width: 20%">Category</th>
                                    <th class="stock filter-symbol" style="width: 5%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['stock']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="search_value[stock][aggregate_condition]">
                                                                    @if(isset($search_value['stock']['aggregate_condition']))
                                                                        @if($search_value['stock']['aggregate_condition'] == '=')
                                                                            <option value="=" selected>=</option>
                                                                        @else
                                                                            <option value="=" >=</option>
                                                                        @endif
                                                                        @if($search_value['stock']['aggregate_condition'] == '<')
                                                                            <option value="<" selected><</option>
                                                                        @else
                                                                            <option value="<"><</option>
                                                                        @endif
                                                                        @if($search_value['stock']['aggregate_condition'] == '>')
                                                                            <option value=">" selected>></option>
                                                                        @else
                                                                            <option value=">">></option>
                                                                        @endif
                                                                        @if($search_value['stock']['aggregate_condition'] == '<=')
                                                                            <option value="<=" selected>≤</option>
                                                                        @else
                                                                            <option value="<=">≤</option>
                                                                        @endif
                                                                        @if($search_value['stock']['aggregate_condition'] == '>=')
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
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" class="form-control input-text symbol-filter-input-text" name="search_value[stock][value]" value="{{isset($search_value['stock']['value']) ? $search_value['stock']['value'] : ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out3" type="checkbox" name="search_value[stock][opt_out]" value="1" @isset($search_value['stock']['opt_out']) checked @endisset><label for="opt-out3" >Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="stock">--}}
                                                        @if(isset($search_value['stock']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[stock][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Stock</div>
                                        </div>
                                    </th>
                                    <th class="profile text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['profile_name']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="form-group dropdown-menu filter-content shadow" role="menu">
                                                        <label>Filter Value</label>
                                                        @php
                                                            $profile_name_list = \App\EbayProfile::orderBy('profile_name', 'ASC')->get();
                                                        @endphp
                                                        <select class="form-control select2 b-r-0" name="search_value[profile_name][value]">
                                                            @isset($profile_name_list)
                                                                @if($profile_name_list->count() == 1)
                                                                    @foreach($profile_name_list as $profile_name)
                                                                        <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['profile_name']['value']))
                                                                    <option value="">Select Profile</option>
                                                                        @foreach($profile_name_list as $profile_name)
                                                                            @if($search_value['profile_name']['value'] == $profile_name->profile_name)
                                                                                <option value="{{$profile_name->profile_name}}" selected>{{$profile_name->profile_name}}</option>
                                                                            @else
                                                                                <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Profile</option>
                                                                        @foreach($profile_name_list as $profile_name)
                                                                            <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out4" type="checkbox" name="search_value[profile_name][opt_out]" value="1" @isset($search_value['profile_name']['opt_out']) checked @endisset><label for="opt-out4" >Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="profile_name">--}}
                                                        @if(isset($search_value['profile_name']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[profile_name][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Profile</div>
                                        </div>
                                    </th>
{{--                                    <th class="status text-center" style="width: 8%">--}}
{{--                                        <div class="d-flex justify-content-center">--}}
{{--                                            <div class="btn-group">--}}
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                        @if(isset($search_value['product_status']['value']))--}}
{{--                                                            <i class="fa text-warning" aria-hidden="true"></i>--}}
{{--                                                        @else--}}
{{--                                                            <i class="fa" aria-hidden="true"></i>--}}
{{--                                                        @endif--}}
{{--                                                    </a>--}}
{{--                                                    <div class="form-group dropdown-menu filter-content shadow" role="menu">--}}
{{--                                                        <label>Filter Value</label>--}}
{{--                                                        @php--}}
{{--                                                            $profile_name_list = \App\EbayProfile::orderBy('profile_name', 'ASC')->get();--}}
{{--                                                        @endphp--}}
{{--                                                        <select class="form-control select2 b-r-0" name="search_value[product_status][value]">--}}
{{--                                                            @if(isset($search_value['product_status']['value']))--}}
{{--                                                                <option value="">Select Status</option>--}}
{{--                                                                @if($search_value['product_status']['value'] == 'Active')--}}
{{--                                                                    <option value="Active" selected>Active</option>--}}
{{--                                                                    <option value="Completed">Ended</option>--}}
{{--                                                                @else--}}
{{--                                                                    <option value="Active" >Active</option>--}}
{{--                                                                    <option value="Completed" selected>Ended</option>--}}
{{--                                                                @endif--}}
{{--                                                            @else--}}
{{--                                                                <option value=""selected>Select Status</option>--}}
{{--                                                                <option value="Active">Active</option>--}}
{{--                                                                <option value="Completed">Ended</option>--}}
{{--                                                            @endif--}}
{{--                                                        </select>--}}
{{--                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                            <input id="opt-out8" type="checkbox" name="search_value[product_status][opt_out]" value="1" @isset($search_value['product_status']['opt_out']) checked @endisset><label for="opt-out8" >Opt Out</label>--}}
{{--                                                        </div>--}}
{{--                                                        <input type="hidden" name="column_name" value="product_status">--}}
{{--                                                        @if(isset($search_value['product_status']['value']))--}}
{{--                                                            <div class="individual_clr">--}}
{{--                                                                <button title="Clear filters" type="submit" name="search_value['product_status']['value']" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>--}}
{{--                                                            </div>--}}
{{--                                                        @endif--}}
{{--                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                            <div>Status</div>--}}
{{--                                        </div>--}}
{{--                                    </th>--}}

                                    <th class="promoted-listings text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                {{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
                                                {{--                                                    @csrf--}}
{{--                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                    @if(isset($search_value['creator_id']['value']))--}}
{{--                                                        <i class="fa text-warning" aria-hidden="true"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    @endif--}}
{{--                                                </a>--}}
{{--                                                <div class="dropdown-menu filter-content shadow" role="menu">--}}
{{--                                                    <p>Filter Value</p>--}}
{{--                                                    <select class="form-control b-r-0" name="search_value[creator_id][value]">--}}
{{--                                                        @if(isset($user_list))--}}
{{--                                                            @if($user_list->count() == 1)--}}
{{--                                                                @foreach($user_list as $user_name)--}}
{{--                                                                    <option value="{{$user_name->id}}">{{$user_name->name}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            @else--}}
{{--                                                                @if(isset($search_value['creator_id']['value']))--}}
{{--                                                                    <option value="">Select Creator</option>--}}
{{--                                                                    @foreach($user_list as $user_name)--}}
{{--                                                                        @if($search_value['creator_id']['value'] == $user_name->id)--}}
{{--                                                                            <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>--}}
{{--                                                                        @else--}}
{{--                                                                            <option value="{{$user_name->id}}" >{{$user_name->name}}</option>--}}
{{--                                                                        @endif--}}
{{--                                                                    @endforeach--}}
{{--                                                                @else--}}
{{--                                                                    <option value="" selected>Select Creator</option>--}}
{{--                                                                    @foreach($user_list as $user_name)--}}
{{--                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                @endif--}}

{{--                                                            @endif--}}
{{--                                                        @endisset--}}
{{--                                                    </select>--}}
{{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                        <input id="opt-out6" type="checkbox" name="search_value[creator_id][opt_out]" value="1" @isset($search_value['creator_id']['opt_out']) checked @endisset><label for="opt-out6" >Opt Out</label>--}}
{{--                                                    </div>--}}
{{--                                                    --}}{{--                                                        <input type="hidden" name="column_name" value="creator_id">--}}
{{--                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                </div>--}}
{{--                                                --}}{{--                                                </form>--}}
{{--                                            </div>--}}
                                            <div>Promoted Listings</div>
                                        </div>
                                    </th>
                                    <th class="creator text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['creator_id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control b-r-0" name="search_value[creator_id][value]">
                                                            @if(isset($user_list))
                                                                @if($user_list->count() == 1)
                                                                    @foreach($user_list as $user_name)
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['creator_id']['value']))
                                                                        <option value="">Select Creator</option>
                                                                        @foreach($user_list as $user_name)
                                                                            @if($search_value['creator_id']['value'] == $user_name->id)
                                                                                <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                            @else
                                                                                <option value="{{$user_name->id}}" >{{$user_name->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Creator</option>
                                                                        @foreach($user_list as $user_name)
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endforeach
                                                                    @endif

                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out6" type="checkbox" name="search_value[creator_id][opt_out]" value="1" @isset($search_value['creator_id']['opt_out']) checked @endisset><label for="opt-out6" >Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="creator_id">--}}
                                                        @if(isset($search_value['creator_id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[creator_id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th class="modifier text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['modifier_id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control b-r-0" name="search_value[modifier_id][value]">
                                                            @if(isset($user_list))
                                                                @if($user_list->count() == 1)
                                                                    @foreach($user_list as $user_name)
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['modifier_id']['value']))
                                                                        <option value="" >Select Modifier</option>
                                                                        @foreach($user_list as $user_name)
                                                                            {{-- @if($user_name == $search_value['modifier_id']['value']) --}}
                                                                            @if($search_value['modifier_id']['value'] == $user_name->id)
                                                                                <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                            @else
                                                                                <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Modifier</option>
                                                                        @foreach($user_list as $user_name)
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out7" type="checkbox" name="search_value[modifier_id][opt_out]" value="1" @isset($search_value['modifier_id']['opt_out']) checked @endisset><label for="opt-out7" >Opt Out</label>
                                                        </div>
{{--                                                        <input type="hidden" name="column_name" value="modifier_id">--}}
                                                        @if(isset($search_value['modifier_id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[modifier_id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Modifier</div>
                                        </div>
                                    </th>
                                    {{--                                    <th>Queue ID</th>--}}
                                    {{--                                    <th>Product</th>--}}
                                    {{--                                    <th>Status</th>--}}
                                    <th style="width: 6%"><div class="d-flex justify-content-center">
                                        <div>Actions</div> &nbsp; &nbsp;
                                            @if(isset($search_value))
                                                <div><a title="Clear filters" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                            @endif
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <!--End table head-->

                                <!--start table body-->
                                <tbody id="ebay_search">
                                @isset($search_value)
                                @if(count($master_product_list) == 0 && count($search_value) != 0)
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
                                @foreach($master_product_list as $index => $product_list)

                                    <tr class="variation_load_tr">
                                        <td style="width: 6%; text-align: center !important;">

                                            {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
                                            <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">

                                        </td>
                                        <td class="image" style="cursor: pointer; width: 6% !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$product_list->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            @if(isset( \Opis\Closure\unserialize($product_list->master_images)[0]))
                                                <a href="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}"  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}" class="ebay-image zoom" alt="ebay-master-image"></a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image zoom" alt="ebay-master-image">
                                            @endif

                                        </td>
{{--                                        <td class="item-id" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                                        <td class="item-id" style="width: 8%">
                                            <span id="master_opc_{{$product_list->item_id}}">
                                                 <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                                    <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->item_id}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                 </div>
                                            </span>
                                        </td>
                                        <td class="product-type">
                                            <div style="text-align: center;">
                                                @if($product_list->type == 'simple')
                                                     Simple
                                                @else
                                                    Variation
                                                @endif
                                            </div>
                                        </td>
{{--                                        <td class="catalogue-id" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                                        <td class="catalogue-id" style="width: 8%; text-align: center !important;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->master_product_id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="account" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            @isset(\App\EbayAccount::find($product_list->account_id)->account_name)
                                                {{\App\EbayAccount::find($product_list->account_id)->account_name}}
                                            @endisset
                                        </td>
                                        <td class="product-name" style="cursor: pointer; width: 20%" data-toggle="collapse" id="mtr-{{$product_list->id}}" data-target="#demo{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top" title="Show Details">
                                            <a class="ebay-product-name" href="https://www.ebay.co.uk/itm/{{$product_list->item_id}}" target="_blank">
                                                {!! Str::limit(strip_tags($product_list->title),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <td class="category" style="cursor: pointer; width: 20%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$product_list->category_name}}</td>
                                       @php
                                           $total_quantity = 0;
                                           foreach ($product_list->variationProducts as $variation){
                                               $total_quantity += $variation->quantity;
                                           }
                                       @endphp
                                        <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}</td>
                                        <td class="profile" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            @isset(\App\EbayProfile::find($product_list->profile_id)->profile_name)
                                                {{\App\EbayProfile::find($product_list->profile_id)->profile_name}}
                                            @endisset
                                        </td>
{{--                                        <td class="status" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
{{--                                           @if($product_list->product_status == "Active")--}}
{{--                                               Active--}}
{{--                                            @elseif($product_list->product_status == "Completed")--}}
{{--                                                @php--}}
{{--                                                    $total_quantity = 0;--}}
{{--                                                    foreach ($product_list->variationProducts as $variation){--}}
{{--                                                        $total_quantity += $variation->quantity;--}}
{{--                                                    }--}}
{{--                                                    if ($total_quantity == 0){--}}
{{--                                                        echo "Sold Out";--}}
{{--                                                    }elseif ($total_quantity > 0){--}}
{{--                                                        echo "Ended";--}}
{{--                                                    }--}}
{{--                                                @endphp--}}

{{--                                           @endif--}}
{{--                                        </td>--}}

                                        <td class="promoted-listings" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            <?php

                                                    $campaign_array = \Opis\Closure\unserialize($product_list->campaign_data) ?? '';
                                                    $creatorInfo = \App\User::withTrashed()->find($product_list->creator_id);
                                                    $modifierInfo = \App\User::withTrashed()->find($product_list->modifier_id);

                                            ?>
                                            @if(isset($campaign_array['bidPercentage']) && isset($campaign_array['suggestedRate']))
                                                Promoted
                                            @elseif(isset($campaign_array['suggestedRate']))
                                                Eligible to promote
                                            @endif
                                            @if(isset($campaign_array['bidPercentage']))
                                                Your ad rate {{$campaign_array['bidPercentage']}}%
                                            @endif
                                            @if(isset($campaign_array['suggestedRate']))
                                                Suggested ad rate {{$campaign_array['suggestedRate']}}%
                                            @endif

                                        </td>
                                        <td class="creator" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            @if(isset($creatorInfo->name))
                                            <div class="wms-name-creator">
                                                <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                                                    <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                            @if(isset($modifierInfo->name))
                                                <div class="wms-name-modifier1">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_list->updated_at))}}">
                                                        <strong class="@if($modifierInfo->deleted_at) text-danger @else text-success @endif">{{$modifierInfo->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @elseif(isset($creatorInfo->name))
                                                <div class="wms-name-modifier2">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                                                        <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="actions" style="width: 6%">
                                            <!--start manage button area-->
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <!--start dropup content-->
                                                <div class="dropdown-menu">
                                                    <div class="dropup-content ebay-dropup-content" style="padding: 14px 20px 8px 20px !important;">
                                                        <div class="action-1">
                                                            @if($product_list->product_status == 'Completed' && $total_quantity !=0)
                                                                <div class="align-items-center mr-2"><a class="btn-size btn-dark" style="cursor: pointer" href="{{url('relist-end-listing/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Relist"><i class="fa fa-registered" aria-hidden="true"></i></a></div>
                                                            @endif
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2">
                                                                <form action="{{url('ebay-ended-product-check/page')}}" method="POST" >
                                                                    @csrf
                                                                    <input type="hidden" name="products[]" value="{{$product_list->id}}">
                                                                    <button type="submit" class="btn-size btn-dark check-status-btn" style="cursor: pointer" target="_blank" data-toggle="tooltip" data-placement="top" title="Check Status"><i class="fa fa-hourglass-end" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('ebay-delete-listing/'.$product_list->id.'/'.$product_list->item_id)}}" data-toggle="tooltip" data-placement="top" title="End Product" onclick="return check_delete('Master Product');"><i class="fas fa-gavel" aria-hidden="true"></i></a></div>
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
                                        <td colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$product_list->id}}">

                                            </div> <!-- end accordion body -->
                                        </td> <!-- hide expand td-->
                                    </tr> <!-- hide expand row-->


                                @endforeach
                                </tbody>
                                <!--End table body-->

                            </table>
                            <!-- </div> -->
                            <!--End table section-->

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">

                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num pr-1"> {{$master_product_list->total()}} items </span>
                                                <span class="pagination-links d-flex">
                                                    @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex pl-1"> {{$master_decode_product_list->current_page}} of <span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                    </span>
                                                    @php

                                                        if (isset($search_value)){
                                                            $search_value = \Opis\Closure\serialize($search_value);
                                                        }else{
                                                            $search_value = '';
                                                        }
                                                        $page =  $master_product_list->currentPage()+1;

                                                    @endphp
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
{{--                                                        <form action="{{$master_product_list->appends(request()->query())}}" class="next-page btn"  method="GET">--}}

{{--                                                            <span class="screen-reader-text d-none"></span>--}}
{{--                                                            <input type="hidden" name="page" value="{{$page}}">--}}
{{--                                                            <input type="hidden" name="search_value" value="{{$search_value}}">--}}
{{--                                                            <span class="screen-reader-text d-none">Next page</span>--}}
{{--                                                            <button type="submit" aria-hidden="true">›</button>--}}
{{--                                                        </form>--}}
                                                    <a class="next-page btn" href="{{$master_decode_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$master_decode_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        //Select option jquery
        $('.select2').select2();

        var searchPriority = 0;
        var skip = 0;
        var take = 10;
        var ids = [0];

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })


        function check_queue_id(id) {
            console.log(id);
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
                        console.log(response.status);
                        $('#master_opc_'+id).html(response.opc);
                        $('#status_show_'+id).html(response.status);
                    }else{
                        $('#status_show_'+id).html(response.status);
                    }
                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
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
                url: "{{url('ebay-master-product-search')}}",
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
                        $("#ajax_loader").hide();
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
                        url: '{{url('ebay-master-product-search')}}',
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
                            searchPriority = response.search_priority;
                            take = response.take;
                            skip = parseInt(response.skip)+10;
                            $('#ebay_search').append(response.html);
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


        $('.product-inner button').click(function () {
            var condition = $("#checkCondition").val();
            // console.log(condition)
            var account_id = $('select[name="search_value[account_name][value]"]').val();

            var url = '';
            var product_id = [];
            $('table tbody tr td :checkbox:checked').each(function(i){
                product_id[i] = $(this).val();
            });
            if (condition == 1){
                url = 'relist-end-listing';
            }else if(condition == 2){
                url = 'ebay-ended-product-check';
            }else if(condition == 3){
                url ='quantity-sync';
            }else if(condition == 4){
                url = 'end-product'
            }
            // console.log(url)
            if(url != ''){
                $.ajax({
                    type: "POST",
                    url: "{{URL::to('/')}}"+'/'+url,
                    data: {
                        "_token" : "{{csrf_token()}}",

                        "products" : product_id,
                        "account_id": account_id
                    },
                    beforeSend: function(){
                        // Show image container
                        $("#ajax_loader").show();
                    },
                    success: function (response) {
                        // console.log(response)
                        $("#ajax_loader").hide();
                        // console.log(response);

                        location.reload();
                        // }else{
                        //     // console.log('else');
                        //     alert(response);
                        // }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {

                        $("#ajax_loader").hide();
                        //alert("Status: " + textStatus);
                        // alert("Error: " + XMLHttpRequest.responseJSON.message);
                    }
                });
            }

        });


        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var status = $('ebay_status').val();
            var id = product_draft_id[1]


            $.ajax({
                type: "post",
                url: "{{url('get-ebay-variation')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "product_draft_id" : id,
                    "status" : status,
                },
                beforeSend: function () {
                   $('#product_variation_loading'+id).show();
                    console.log('product_variation_loading'+id);
                },
                success: function (response) {
                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }

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


        // $('.filter-btn').on('click', function() {
        //     $(this).closest('table thead tr th').toggleClass('filter-red');
        // })


    </script>



@endsection
