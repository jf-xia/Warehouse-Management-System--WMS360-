
@extends('master')
@section('content')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <script type="text/javascript"
            src="https://www.viralpatel.net/demo/jquery/jquery.shorten.1.0.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content" style="display: none">

                            <div class="d-flex justify-content-between content-inner mt-2 mb-2">
                                <div class="d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue" class="onoffswitch-checkbox" id="catalogue" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="catalogue">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0">
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="available-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Available Qty</p></div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex align-items-center shelf-device-view ">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" >
                                            <label class="onoffswitch-label" for="shelf-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shelf Qty</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="low-qty" class="onoffswitch-checkbox" id="low-qty" tabindex="0" >
                                            <label class="onoffswitch-label" for="low-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Low Qty</p></div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between pagination-content">

                                <div>
                                    <form>
                                        <div><p class="pagination"><b>Pagination</b></p></div>
                                        <ul class="column-display d-flex align-items-center">
                                            <li>Number of items per page</li>
                                            <li><input type="number" class="pagination-count"></li>
                                        </ul>
                                        <div class="submit">
                                            <input type="submit" class="btn submit-btn" value="Apply">
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--//screen option-->



                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page">Product List</li>
                        </ol>
                    </div>
                    <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div>
                </div>



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


                <div class="card-box m-t-20 product-content shadow product-card table-responsive">
                    <div class="row">
                        <div class="col-md-12">

{{--                            <form class="example" action="javascript:void(0)">--}}
                                <div class="m-b-20 m-t-10">

                                    <div class="product-inner">
                                        <div class="p-text-area">
                                            <input type="text" name="variation_search_value" id="variation_search_value" class="form-control product--list" placeholder="Search by ID, SKU or EAN....">
                                        </div>
                                        <div class="submit-btn">
                                            <button class="search-btn" type="submit" id="" onclick="search_variation();"><i class="fa fa-search"></i></button>
                                        </div>
                                        <div class="product-list-empty"></div>
                                        <div class="pagination-area">
                                            <form class="example" action="{{url('pagination-all')}}" method="post">
                                                @csrf
                                                <div class="datatable-pages d-flex align-items-center">
                                                    <span class="displaying-num"> {{$total_variation}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        <a class="first-page btn" href="{{$all_variation_decode_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn" href="{{$all_variation_decode_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_variation_decode_info->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_variation_decode_info->last_page}}</span></span>
                                                            <input type="hidden" name="route_name" value="product-variation">
                                                        </span>
                                                        <a class="next-page btn" href="{{$all_variation_decode_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_variation_decode_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                            <span class="screen-reader-text d-none">Last page</span>
                                                            <span aria-hidden="true">»</span>
                                                        </a>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
{{--                            </form>--}}


{{--                                <div class="input-group p-text-area">--}}
{{--                                    <input type="text" name="sku" id="sku" class="form-control" placeholder="Search by ID, SKU or EAN...." aria-label="Search by ID, SKU or EAN...." aria-describedby="basic-addon2">--}}
{{--                                    <div class="input-group-append">--}}
{{--                                        <span class="input-group-text" id="basic-addon2">@example.com</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                                <div class="row position">--}}
{{--                                    <div class="col-md-9">--}}
{{--                                        {{$all_product_variation->links()}}--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-3">--}}
{{--                                        <div class="total-d-o font-bold" style="color: #81c868; padding-top: 25px">--}}
{{--                                            You are seeing : {{$variation_range->from}}-{{$variation_range->to}}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                            <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div>

                            <table id="table-sort-list" class="variation_search_result product-table w-100">
                                <thead>
                                <tr>

                                    <th class="image" style="text-align: center !important;">Image</th>

{{--                                    <div class="row mt-3 bulk-action-btn-group">--}}
{{--                                        <div class="col-md-8">--}}
{{--                                            <div class="d-flex justify-content-start align-items-center">--}}
{{--                                                <div class="action-btn">--}}
{{--                                                    <button class="btn check-active regular-price-btn btn-inactive" type="button" id="dropdownRegularPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        Regular Price--}}
{{--                                                    </button>--}}
{{--                                                    <form action="Javascript:void(0);">--}}
{{--                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownRegularPriceButton">--}}
{{--                                                            <input type="text" class="form-control input-text" name="field_value">--}}
{{--                                                            <input type="hidden" class="input-field" name="field_name" value="regular_price">--}}
{{--                                                            <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                                <div class="action-btn">--}}
{{--                                                    <button class="btn check-active sales-price-btn btn-inactive" type="button" id="dropdownSalesPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        Sales Price--}}
{{--                                                    </button>--}}
{{--                                                    <form action="Javascript:void(0);">--}}
{{--                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownSalesPriceButton">--}}
{{--                                                            <input type="text" class="form-control input-text" name="field_value">--}}
{{--                                                            <input type="hidden" class="input-field" name="field_name" value="sale_price">--}}
{{--                                                            <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                                <div class="action-btn">--}}
{{--                                                    <button class="btn check-active cost-price-btn btn-inactive" type="button" id="dropdownCostPriceButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        Cost Price--}}
{{--                                                    </button>--}}
{{--                                                    <form action="Javascript:void(0);">--}}
{{--                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownCostPriceButton">--}}
{{--                                                            <input type="text" class="form-control input-text" name="field_value">--}}
{{--                                                            <input type="hidden" class="input-field" name="field_name" value="cost_price">--}}
{{--                                                            <button type="button" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                                <div class="action-btn">--}}
{{--                                                    <button class="btn check-active available-qty-btn btn-inactive" type="button" id="dropdownAvailableQtyButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                        Available Quantity--}}
{{--                                                    </button>--}}
{{--                                                    <form action="Javascript:void(0);">--}}
{{--                                                        <div class="dropdown-menu bulk-action-drop-down-btn" aria-labelledby="dropdownAvailableQtyButton">--}}
{{--                                                            <input type="text" class="form-control input-text" name="field_value">--}}
{{--                                                            <input type="hidden" class="input-field" name="field_name" value="actual_quantity">--}}
{{--                                                            <button type="submit" class="btn btn-primary submit-btn" id="bulk_edit">Submit</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <div class="d-flex justify-content-end align-items-center">--}}
{{--                                                <div><a class="btn btn-outline-success m-r-10" href="{{url('catalogue/'.$product_draft_variation_results->id.'/product')}}">Add Product</a></div>--}}
{{--                                                <div><a class="btn btn-outline-success" href="{{url('add-additional-terms-draft/'.$product_draft_variation_results->id)}}">Add Terms to Catalogue</a></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


                                    <th class="id" style="width: 7%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out1" type="checkbox" name="opt_out" value="1"><label for="opt-out1">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="id">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="catalogue">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="name">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Title</div>
                                        </div>
                                    </th>
                                    <th class="sku" style="text-align: center !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="sku">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>SKU</div>
                                        </div>
                                    </th>
                                    <th class="qrCode" style="text-align: center !important;">
                                        <div class="d-flex justify-content-start">

                                            <div>QR Code</div>
                                        </div>
                                    </th>
                                    <th class="variation">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form>
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out4" type="checkbox" name="opt-out4" ><label for="opt-out4">Opt Out</label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Variation</div>
                                        </div>
                                    </th>
                                    <th class="ean">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="ean_no">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>EAN</div>
                                        </div>
                                    </th>
                                    <th class="sold filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn  check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2" name="aggregate_condition">
                                                                    <option value="=">=</option>
                                                                    <option value="<"><</option>
                                                                    <option value=">">></option>
                                                                    <option value="<=">≤</option>
                                                                    <option value=">=">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out6" type="checkbox" name="opt_out" value="1"><label for="opt-out6">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="sold">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Sold</div>
                                        </div>
                                    </th>
                                    <th class="available-qty filter-symbol" style="width: 15% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2" name="aggregate_condition">
                                                                    <option value="=">=</option>
                                                                    <option value="<"><</option>
                                                                    <option value=">">></option>
                                                                    <option value="<=">≤</option>
                                                                    <option value=">=">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out7" type="checkbox" name="opt_out" value="1"><label for="opt-out7">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="actual_quantity">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Available Qty</div>
                                        </div>
                                    </th>
                                    <th class="shelf-qty filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2" name="aggregate_condition">
                                                                    <option value="=">=</option>
                                                                    <option value="<"><</option>
                                                                    <option value=">">></option>
                                                                    <option value="<=">≤</option>
                                                                    <option value=">=">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out8" type="checkbox" name="opt_out" value="1"><label for="opt-out8">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="shelf_quantity">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Shelf Qty</div>
                                        </div>
                                    </th>
                                    <th class="low-qty filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form action="{{url('product-variation/search')}}" method="post">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn check-active btn-inactive" data-toggle="dropdown">
                                                        <i class="fa" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control select2" name="aggregate_condition">
                                                                    <option value="=">=</option>
                                                                    <option value="<"><</option>
                                                                    <option value=">">></option>
                                                                    <option value="<=">≤</option>
                                                                    <option value=">=">≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out9" type="checkbox" name="opt_out" value="1"><label for="opt-out9">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="low_quantity">
                                                        <input type="hidden" name="route_name" value="product-variation">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div>Low Qty</div>
                                        </div>
                                    </th>
                                    <th class="actions">Actions</th>

{{--                                        <th class="header-cell" onclick="sortTable(0)">ID</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Image</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">SKU</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Variation</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">EAN</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Sold</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Available Qty</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Shelf Qty</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Low Qty</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Catalogue</th>--}}
{{--                                        <th class="header-cell" onclick="sortTable(0)">Actions</th>--}}

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_product_variation as $product_variation)
                                    @php
                                        $total_sold = 0;
                                         foreach ($product_variation->order_products as $product){
                                             $total_sold += $product->sold;
                                         }
                                            $data = 0;
                                    @endphp
                                    @foreach($product_variation->shelf_quantity as $total)
                                        @php
                                            $data += $total->pivot->quantity;
                                        @endphp
                                    @endforeach
                                    @if($data != 0)
                                        <tr>
                                            {{--                                            <td>{!! str_limit(strip_tags($product_variation->description),$limit = 10,$end='...') !!}</td>--}}
                                            @if($product_variation->image != null)
                                                <td class="image text-center"><a href="{{$product_variation->image}}" target="_blank"><img class="product-img" src="{{$product_variation->image}}" alt="Responsive image"></a></td>
                                            @elseif(isset($product_variation->product_draft->product_catalogue_image->image_url))
                                                <td class="image text-center"><a href="{{$product_variation->product_draft->product_catalogue_image->image_url}}" target="_blank"><img class="product-img" src="{{$product_variation->product_draft->product_catalogue_image->image_url}}" alt="Responsive image"></a></td>
                                            @else
                                                <td class="image text-center"><img class="product-img" src="{{asset('assets/images/users/no_image.jpg')}}" alt="Responsive image"></td>
                                            @endif
                                            <td class="id" style="width: 7%; text-align: center !important;">{{$product_variation->id}}</td>
                                            <td class="catalogue"><a class="catalogue-name" href="{{route('product-draft.show',$product_variation->product_draft->id)}}" title="View Details" target="_blank">  {{$product_variation->product_draft->name}}  </a> </td>
                                            <td class="sku" style="text-align: center !important;">{{$product_variation->sku}}</td>
                                            <td class="" style="text-align: center !important;">{!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($product_variation->sku); !!}</td>
                                            {{--                                            @if($product_variation->barcode)--}}
                                            {{--                                                <td><a href="{{asset('barcode/'.$product_variation->barcode)}}" download="" title="click to dowmload"><img src="{{asset('barcode/'.$product_variation->barcode)}}" alt="sku barcode"></a>--}}
                                            {{--                                                    <span style="position: absolute;"><a href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank"><i class="fa fa-print"></i></a></span>--}}
                                            {{--                                                </td>--}}
                                            {{--                                            @else--}}
                                            {{--                                                <td><a href="{{url('print-barcode/'.$product_variation->id)}}" class="btn btn-success btn-sm" title="Click to print" target="_blank">Print Barcode</a></td>--}}
                                            {{--                                            @endif--}}
                                            <td class="variation">
                                                @if(isset($product_variation->attribute1))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(5)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute1}}, </label>
                                                @endif
                                                @if(isset($product_variation->attribute2))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(6)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute2}},</label>
                                                @endif

                                                @if(isset($product_variation->attribute3))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(7)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute3}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute4))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(8)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute4}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute5))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(9)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute5}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute6))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(10)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute6}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute7))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(11)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute7}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute8))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(12)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute8}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute9))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(13)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute9}}, </label>
                                                @endif

                                                @if(isset($product_variation->attribute10))
                                                    <label><b style="color: #7e57c2">{{\App\Attribute::find(14)->attribute_name}}</b> <i class="fa fa-long-arrow-right" aria-hidden="true"></i> {{$product_variation->attribute10}}, </label>
                                                @endif
                                            </td>
                                            <td class="ean">{{$product_variation->ean_no}}</td>
                                            <td class="sold" style="width: 10% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                            <td class="available-qty" style="width: 15% !important; text-align: center !important;">{{$product_variation->actual_quantity}}</td>

                                            @if($product_variation->notification_status == 1 && $data < $product_variation->low_quantity)
                                                <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}<br><span class="label label-table label-danger">Low Quantity {{$product_variation->low_quantity}}</span></td>
                                            @else
                                                <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}</td>
                                            @endif
                                            <td class="low-qty">{{$product_variation->low_quantity}}</td>
                                            <td class="actions">
                                                <!--action button-->
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Dropdown menu links -->
                                                        <div class="dropup-content">

                                                            <div class="d-flex justify-content-start">
                                                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-variation.edit',$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size invoice-btn invoice-btn-size" href="{{url('catalogue-product-invoice-receive/'.$product_variation->product_draft->id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><img src="{{asset('assets/images/receive-invoice.png')}}" width="30" height="30" class="filter"></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-barcode/'.$product_variation->id)}}" data-toggle="tooltip" data-placement="top" title="Click to print" target="_blank"><i class="fa fa-print"></i></a></div>
                                                                <div class="align-items-center">
                                                                    <form action="{{route('product-variation.destroy',$product_variation->id)}}" method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="del-pub delete-btn on-default remove-row" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--End action button-->
                                            </td>
                                            <div class="modal fade" id="myModal{{$product_variation->id}}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Shelf Product</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                        <div style="border: 1px solid #ccc;">
                                                                            <div class="row m-t-10">
                                                                                <div class="col-4 text-center">
                                                                                    <h6> Shelf Name </h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-4 text-center">
                                                                                    <h6>Quantity</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                                <div class="col-4 text-center">
                                                                                    <h6>Action</h6>
                                                                                    <hr width="60%">
                                                                                </div>
                                                                            </div>
                                                                            @foreach($product_variation->shelf_quantity as $shelf)
                                                                                @if($shelf->pivot->quantity != 0)
                                                                                    <div class="row">
                                                                                        <div class="col-4 text-center m-b-10">
                                                                                            <h7> {{$shelf->shelf_name}} </h7>
                                                                                        </div>
                                                                                        <div class="col-4 text-center m-b-10">
                                                                                            <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>
                                                                                        </div>
                                                                                        <div class="col-4 text-center m-b-10">
                                                                                            <button type="button" class="btn btn-primary btn-sm change_quantity" id="{{$product_variation->id}}_{{$shelf->pivot->id}}">Change Quantity</button>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                            <div class="row p-20 change_quantity_div" style="display: none;">
                                                                                <div class="col-12">
                                                                                    {{--                                                                                     <form action="Javascript:void(0);">--}}
                                                                                    <h3>Change Info:</h3><span></span>
                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <label class="required">Quantity</label>
                                                                                        <input type="text" class="form-control c_quantity_{{$product_variation->id}}" name="c_quantity" id="">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="">Reason</label>
                                                                                        <textarea class="form-control" name="c_reason" id="c_reason" cols="5" rows="3"></textarea>
                                                                                    </div>

                                                                                    <button type="button" class="btn btn-success">Add</button>
                                                                                    {{--                                                                                     </form>--}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- end card -->
                                                                </div> <!-- end col-12 -->
                                                            </div> <!-- end row -->
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger shadow" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>  <!-- // The Modal -->
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>

                            <!--table footer pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                    {{--                                    <div class="py-2">--}}
                                    {{--                                        <span class="font-bold float-lg-left" style="color: rgba(0, 0, 0, 0.44);"> Showing : {{$product_drafts_info->from}}-{{$product_drafts_info->to}} entries</span>--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        {{--                                        {{$product_drafts->links()}}--}}
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">Product list {{$total_variation}} items</span>
                                                <span class="pagination-links d-flex">
                                                    <a class="first-page btn" href="{{$all_variation_decode_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn" href="{{$all_variation_decode_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex"> {{$all_variation_decode_info->current_page}} of <span class="total-pages">{{$all_variation_decode_info->last_page}}</span></span>
                                                    </span>
                                                    <a class="next-page btn" href="{{$all_variation_decode_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$all_variation_decode_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End table footer pagination sec-->

                        </div>
                    </div> <!-- end row -->

                </div> <!-- end card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page -->


    <script type="text/javascript">

        function search_variation(){
            var variation_search_value = $('#variation_search_value').val();
            console.log(variation_search_value);
            var page_name = 'variation_page';
            if(variation_search_value == '' ){
                alert('Please type sku in the search field.');
                return false;
            }
            $.ajax({
                type: 'POST',
                url: '{{url('search-variation-list').'?_token='.csrf_token()}}',
                data: {
                    "variation_search_value" : variation_search_value,
                    "page_name" : page_name
                },
                beforeSend: function () {
                    // console.log(variation_search_value);
                    $('#ajax_loader').show();
                },
                success: function (response) {
                    $('table tbody').html(response);
                    // $('.variation_search_result').html(response);
                },
                complete: function () {
                    $('#ajax_loader').hide();
                }
            });
        }
        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#search_variation').on('click',function () {

                console.log('found');
            });

            $('button.change_quantity').on('click',function () {
                var id = $(this).attr('id');
                var id_split = id.split('_');
                $('#myModal'+id_split[0]+' .change_quantity_div input.c_quantity_'+id_split[0]).attr('id','c_quantity_'+id);
                $('#myModal'+id_split[0]+' .change_quantity_div button').attr('id',id);
                $('#myModal'+id_split[0]+' .change_quantity_div span').attr('id',id);
                console.log(id);
                $('#myModal'+id_split[0]+' .change_quantity_div').slideToggle();
            });

            $('.change_quantity_div button').on('click',function () {
                var full_id = $(this).attr('id');
                var id = full_id.split('_');
                var variation_id = id[0];
                var product_shelf_id = id[1];
                var quantity = $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val();
                if(quantity == ''){
                    alert('Please give change quantity.');
                    return false;
                }
                var reason = $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val();

                $.ajax({
                    type: "POST",
                    url: "{{url('shelf_quantity_update')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "product_shelf_id" : product_shelf_id,
                        "quantity" : quantity,
                        "reason" : reason
                    },
                    success: function (response) {
                        if(response.data == true){
                            $('.qnty_'+full_id).text(quantity);
                            $('#myModal'+variation_id+' .change_quantity_div span#'+full_id).addClass('text-success').html('Quantity updated successfully.')
                            $('#myModal'+variation_id+' .change_quantity_div input#c_quantity_'+full_id).val('');
                            $('#myModal'+variation_id+' .change_quantity_div textarea#c_reason').val('');
                        }
                    }
                });
            });

        } );






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


        // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });


        // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });

        //prevent onclick dropdown menu close
        $('.filter-content').on('click', function(event){
            event.stopPropagation();
        });



        // Filter Button active inactive
        // function myFunction() {
        //     if (document.getElementById("demo").style.background == "#ff77ee") {
        //         document.getElementById("demo").style.background = "#000";
        //     } else{
        //         document.getElementById("demo").style.background = "#ff77ee";
        //     }
        // }


        // Filter Button active inactive
        $(document).ready(function() {
            $('div.btn-group a.filter-btn').click(function () {
                $('div.btn-group a.check-active').removeClass('filter-btn-active');
                $(this).addClass('filter-btn-active');
            });
            $('div.btn-group a.check-active').removeClass('filter-btn-active');
             return false;
        })




    </script>



{{--    <script>--}}

{{--        //Datatable row-wise searchable option--}}
{{--        $(document).ready(function(){--}}
{{--            $("#row-wise-search").on("keyup", function() {--}}
{{--                let value = $(this).val().toLowerCase();--}}
{{--                $("#table-body tr").filter(function() {--}}
{{--                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)--}}
{{--                });--}}

{{--            });--}}
{{--        });--}}


{{--        //sort ascending and descending table rows js--}}
{{--        function sortTable(n) {--}}
{{--            let table,--}}
{{--                rows,--}}
{{--                switching,--}}
{{--                i,--}}
{{--                x,--}}
{{--                y,--}}
{{--                shouldSwitch,--}}
{{--                dir,--}}
{{--                switchcount = 0;--}}
{{--            table = document.getElementById("table-sort-list");--}}
{{--            switching = true;--}}
{{--            //Set the sorting direction to ascending:--}}
{{--            dir = "asc";--}}
{{--            /*Make a loop that will continue until--}}
{{--            no switching has been done:*/--}}
{{--            while (switching) {--}}
{{--                //start by saying: no switching is done:--}}
{{--                switching = false;--}}
{{--                rows = table.getElementsByTagName("TR");--}}
{{--                /*Loop through all table rows (except the--}}
{{--                first, which contains table headers):*/--}}
{{--                for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.--}}
{{--                    //start by saying there should be no switching:--}}
{{--                    shouldSwitch = false;--}}
{{--                    /*Get the two elements you want to compare,--}}
{{--                    one from current row and one from the next:*/--}}
{{--                    x = rows[i].getElementsByTagName("TD")[n];--}}
{{--                    y = rows[i + 1].getElementsByTagName("TD")[n];--}}
{{--                    /*check if the two rows should switch place,--}}
{{--                    based on the direction, asc or desc:*/--}}
{{--                    if (dir == "asc") {--}}
{{--                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {--}}
{{--                            //if so, mark as a switch and break the loop:--}}
{{--                            shouldSwitch = true;--}}
{{--                            break;--}}
{{--                        }--}}
{{--                    } else if (dir == "desc") {--}}
{{--                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {--}}
{{--                            //if so, mark as a switch and break the loop:--}}
{{--                            shouldSwitch = true;--}}
{{--                            break;--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--                if (shouldSwitch) {--}}
{{--                    /*If a switch has been marked, make the switch--}}
{{--                    and mark that a switch has been done:*/--}}
{{--                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);--}}
{{--                    switching = true;--}}
{{--                    //Each time a switch is done, increase this count by 1:--}}
{{--                    switchcount++;--}}
{{--                } else {--}}
{{--                    /*If no switching has been done AND the direction is "asc",--}}
{{--                    set the direction to "desc" and run the while loop again.*/--}}
{{--                    if (switchcount == 0 && dir == "asc") {--}}
{{--                        dir = "desc";--}}
{{--                        switching = true;--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}


{{--        // sort ascending descending icon active and active-remove js--}}
{{--        $('.header-cell').click(function() {--}}
{{--            let isSortedAsc  = $(this).hasClass('sort-asc');--}}
{{--            let isSortedDesc = $(this).hasClass('sort-desc');--}}
{{--            let isUnsorted = !isSortedAsc && !isSortedDesc;--}}

{{--            $('.header-cell').removeClass('sort-asc sort-desc');--}}

{{--            if (isUnsorted || isSortedDesc) {--}}
{{--                $(this).addClass('sort-asc');--}}
{{--            } else if (isSortedAsc) {--}}
{{--                $(this).addClass('sort-desc');--}}
{{--            }--}}
{{--        });--}}

{{--    </script>--}}




@endsection
