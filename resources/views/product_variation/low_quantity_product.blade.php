@extends('master')

@section('title')
    Low Quantity | WMS360
@endsection

@section('content')


    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <style>
        .low-quantity-change {
            cursor: pointer;
        }
    </style>

    <div class="content-page draft-page">
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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['image']) && $setting['catalogue']['low_quantity_product']['image'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['image']) && $setting['catalogue']['low_quantity_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['id']) && $setting['catalogue']['low_quantity_product']['id'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['id']) && $setting['catalogue']['low_quantity_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Id</p></div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="name" class="onoffswitch-checkbox" id="name" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['name']) && $setting['catalogue']['low_quantity_product']['name'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['name']) && $setting['catalogue']['low_quantity_product']['name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sale-price" class="onoffswitch-checkbox" id="sale-price" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['sale-price']) && $setting['catalogue']['low_quantity_product']['sale-price'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['sale-price']) && $setting['catalogue']['low_quantity_product']['sale-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sale-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sale Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="total-product" class="onoffswitch-checkbox" id="total-product" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['total-product']) && $setting['catalogue']['low_quantity_product']['total-product'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['total-product']) && $setting['catalogue']['low_quantity_product']['total-product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="total-product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Total Product</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['sku']) && $setting['catalogue']['low_quantity_product']['sku'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['sku']) && $setting['catalogue']['low_quantity_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['variation']) && $setting['catalogue']['low_quantity_product']['variation'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['variation']) && $setting['catalogue']['low_quantity_product']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['ean']) && $setting['catalogue']['low_quantity_product']['ean'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['ean']) && $setting['catalogue']['low_quantity_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['sales-price']) && $setting['catalogue']['low_quantity_product']['sales-price'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['sales-price']) && $setting['catalogue']['low_quantity_product']['sales-price'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['sold']) && $setting['catalogue']['low_quantity_product']['sold'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['sold']) && $setting['catalogue']['low_quantity_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['available-qty']) && $setting['catalogue']['low_quantity_product']['available-qty'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['available-qty']) && $setting['catalogue']['low_quantity_product']['available-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="available-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Available Qty</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['shelf-qty']) && $setting['catalogue']['low_quantity_product']['shelf-qty'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['shelf-qty']) && $setting['catalogue']['low_quantity_product']['shelf-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="shelf-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Shelf Qty</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="low-qty" class="onoffswitch-checkbox" id="low-qty" tabindex="0" @if(isset($setting['catalogue']['low_quantity_product']['shelf-qty']) && $setting['catalogue']['low_quantity_product']['shelf-qty'] == 1) checked @elseif(isset($setting['catalogue']['low_quantity_product']['shelf-qty']) && $setting['catalogue']['low_quantity_product']['shelf-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="low-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Low Qty</p></div>
                                    </div>
                                </div>
                            </div>


                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="catalogue">
                            <input type="hidden" id="secondKey" value="low_quantity_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination count, catalogue search by date and apply button section-->
                            <div class="d-flex justify-content-between align-items-center pagination-content">
                                <div>
                                    <div><p class="pagination"><b>Pagination</b></p></div>
                                    <ul class="column-display d-flex align-items-center">
                                        <li>Number of items per page</li>
                                        <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                    </ul>
                                    <span class="pagination-mgs-show text-success"></span>
                                </div>
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn pagination-apply screen-option-setting" id="success" value="Apply">
                            </div>
                            <!--End Pagination count, catalogue search by date and apply button section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Catalogue</li>
                            <li class="breadcrumb-item active" aria-current="page"><label for="low_quantity">Low Quantity Product</label></li>
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
                        <div class="card-box table-responsive catalogue shadow">

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

                           <!--End Backend error handler-->


                            <!--start table upper side content-->
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">

                                    <div class="draft-search-form">
                                        <form class="d-flex" action="{{url('column-search')}}" method="post">
                                        @csrf
                                            <div class="p-text-area">
                                                <input type="text" name="search-value" id="search-value" class="form-control" placeholder="Search Catalogue..." required>
                                                <input type="hidden" name="route_name" value="{{$decode_low_product->path}}">
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit">Search</button>
                                            </div>
                                            <div style="float: right">
                                                <a href="{{url('low-quantity-product-list/hidden')}}" class="btn btn-primary">Hidden Low Quantity</a>
                                            </div>
                                        </form>
                                    </div>

                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$low_quantity_product->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($decode_low_product->current_page > 1)
                                                    <a class="first-page btn {{$decode_low_product->current_page > 1 ? '' : 'disable'}}" href="{{$decode_low_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$decode_low_product->current_page > 1 ? '' : 'disable'}}" href="{{$decode_low_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$decode_low_product->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$decode_low_product->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="{{$decode_low_product->path}}">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($low_quantity_product->currentPage() !== $low_quantity_product->lastPage())
                                                    <a class="next-page btn" href="{{$decode_low_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$decode_low_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            <!--Start Table-->
                            <table class="draft_search_result product-draft-table w-100 ">
                                <!--start table head-->
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post">
                                @csrf
                                <input type="hidden" name="search_route" value="{{Request::path()}}">
                                <tr>
                                    <th class="image" style="width: 6%; text-align: center !important;">Image</th>
                                    <th class="id" style="width: 6%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="catalogue_id" value="{{$allCondition['catalogue_id'] ?? ''}}">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>

                                    <th class="name" style="width: 30%;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div> Title</div>
                                        </div>
                                    </th>

                                    <th class="sale-price" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['sale_price'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <!-- <input type="text" class="form-control input-text" name="sale_price" value="{{$allCondition['sale_price'] ?? ''}}"> -->
                                                        <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="sale_price" value="{{$allCondition['sale_price'] ?? ''}}">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Sale Price</div>
                                        </div>
                                    </th>
                                    <th class="total-product" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['product'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="product" value="{{$allCondition['product'] ?? ''}}">
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Total Product</div>
                                        </div>
                                    </th>
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
                                <tbody id="search_reasult" class="scrollbar-lg">
                                @foreach($low_quantity_product as $lowQuantity)
                                    @if(isset($lowQuantity->product_draft->id))
                                        <tr class="variation_load_tr">
                                            <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;"  data-toggle="collapse" id="mtr-{{$lowQuantity->product_draft->id}}" data-target="#demo{{$lowQuantity->product_draft->id}}" class="accordion-toggle">

                                            @if(isset($lowQuantity->product_draft->single_image_info->image_url))
                                                <a href="{{(filter_var($lowQuantity->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$lowQuantity->product_draft->single_image_info->image_url : $lowQuantity->product_draft->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                    <img src="{{(filter_var($lowQuantity->product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$lowQuantity->product_draft->single_image_info->image_url : $lowQuantity->product_draft->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image">
                                                </a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                                            @endif
                                            </td>
                                            <td class="id" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$lowQuantity->product_draft->id}}" data-target="#demo{{$lowQuantity->product_draft->id}}" class="accordion-toggle">
                                                {{$lowQuantity->product_draft->id ?? 0}}
                                                {{-- variation loader --}}
                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>
                                            </td>
                                            <td class="name" style="width: 10% !important; text-align: left !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$lowQuantity->product_draft->id}}" data-target="#demo{{$lowQuantity->product_draft->id}}" class="accordion-toggle">{{$lowQuantity->product_draft->name ?? ''}}</td>
                                            <td class="sale-price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$lowQuantity->product_draft->id}}" data-target="#demo{{$lowQuantity->product_draft->id}}" class="accordion-toggle">{{$lowQuantity->product_draft->sale_price ?? 0}}</td>
                                            <td class="total-product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$lowQuantity->product_draft->id}}" data-target="#demo{{$lowQuantity->product_draft->id}}" class="accordion-toggle">{{is_array(json_decode($lowQuantity)->product_draft->catalogue_variation) ? count(json_decode($lowQuantity)->product_draft->catalogue_variation) : 0}}</td>
                                            <td class="actions draft-list" style="width: 6%">
                                                <!--start manage button area-->
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <!--start dropup content-->
                                                    <div class="dropdown-menu">
                                                        <div class="dropup-content">
                                                            <div class="action-1">
                                                                <div class="align-items-center mr-2"> <a class="btn-size hide-btn bg-purple text-white" href="{{url('hide-low-quantity-product/'.$lowQuantity->product_draft->id)}}" data-toggle="tooltip" data-placement="top" title="Hide"><i class="fa fa-eye-slash"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-bulk-barcode/'.$lowQuantity->product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!--End dropup content-->
                                                </div>
                                                <!--End manage button area-->
                                            </td>
                                        </tr>

                                        <!--start hidden row-->
                                       <tr>
                                            <td colspan="15" class="hiddenRow" style="padding: inherit;">
                                                <div class="accordian-body collapse" id="demo{{$lowQuantity->product_draft->id}}">
                                                    <!--hidden row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                <span class="screen-option"></span>
                                                                <!-- <div class="row-expand-height-control"> -->
                                                                    <!--row expand inner table-->
                                                                    <table class="product-draft-table row-expand-table w-100">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="id" style="text-align: center !important; width: 7%;">ID</th>
                                                                            <th class="sku" style="width: 10%">SKU</th>
                                                                            <th class="variation" style="width: 10%">Variation</th>
                                                                            <th class="ean" style="width: 10% !important; text-align: center !important;">EAN</th>
                                                                            <th class="sales-price" style="width: 10% !important; text-align: center !important;">Sales Price</th>
                                                                            <th class="sold" style="width: 5% !important; text-align: center !important;">Sold</th>
                                                                            <th class="available-qty" style="width: 10% !important; text-align: center !important;">Available Qty</th>
                                                                            @if($shelf_use == 1)
                                                                                <th class="shelf-qty" style="width: 10% !important; text-align: center !important;">Shelf Qty</th>
                                                                            @endif
                                                                            <th class="low-qty" style="width: 10% !important; text-align: center !important;">Low Qty</th>
                                                                            <th style="width: 6%">Actions</th>
                                                                        </tr>
                                                                        </thead>

                                                                        <!--row expand inner table body-->
                                                                        <tbody>
                                                                        @php
                                                                            $lowQuantity = json_decode($lowQuantity);
                                                                        @endphp
                                                                        @if(isset($lowQuantity->product_draft->catalogue_variation) && count($lowQuantity->product_draft->catalogue_variation) > 0)
                                                                            @foreach($lowQuantity->product_draft->catalogue_variation as $product_variation)
                                                                                @php
                                                                                    $data = \App\ShelfedProduct::where('variation_id',$product_variation->id)->sum('quantity');
                                                                                    $total_sold = 0;
                                                                                    foreach ($product_variation->order_products as $product){
                                                                                        $total_sold += $product->sold;
                                                                                    }
                                                                                @endphp
                                                                                <tr class="low-quantity-{{$product_variation->id}}">
                                                                                    <td class="id" style="text-align: center !important; width: 7%;">
                                                                                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_variation->id}}</span>
                                                                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="sku" style="width: 10%">
                                                                                        <div class="sku_tooltip_container d-flex justify-content-start">
                                                                                            <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                                                                            <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="variation" style="width: 10%">
                                                                                        @isset($product_variation->attribute)
                                                                                            @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute_value)
                                                                                                <label><b style="color: #7e57c2">{{$attribute_value['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute_value['terms_name']}}, </label>
                                                                                            @endforeach
                                                                                        @endisset
                                                                                    </td>
                                                                                    <td class="ean" style="width: 10%; text-align: center !important;">{{$product_variation->ean_no}}</td>
                                                                                    <td class="sales-price" style="width: 10% !important;">
                                                                                        <div class="d-flex justify-content-center align-items-center">
                                                                                            <div class="shown" id="sale_price_{{$product_variation->id}}">
                                                                                            <span>
                                                                                                {{$product_variation->sale_price}}
                                                                                            </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="sold" style="width: 5% !important; text-align: center !important;">{{$total_sold ?? 0}}</td>
                                                                                    <td class="available-qty" style="width: 5% !important; text-align: center !important;">
                                                                                    @if($data < $product_variation->low_quantity)
                                                                                        {{$product_variation->actual_quantity}}
                                                                                    @else
                                                                                        {{$product_variation->actual_quantity}}
                                                                                    @endif
                                                                                    </td>

                                                                                    @if($shelf_use == 1)
                                                                                        <td class="shelf-qty" style="width: 10% !important; text-align: center !important;">{{$data}}</td>
                                                                                    @endif
                                                                                    <td class="low-qty" style="width: 5% !important; text-align: center !important;">
                                                                                    <span class="label label-table label-danger">{{$product_variation->low_quantity ?? 0}}</span>
                                                                                    <br><span class="label label-table label-primary low-quantity-change">Reset Low Quantity</span></td>
                                                                                    <td class="actions" style="width: 6%">
                                                                                        <!--start manage button area-->
                                                                                        <div class="btn-group dropup">
                                                                                            <button type="button" class="btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                Manage
                                                                                            </button>
                                                                                            <!--start dropup content-->
                                                                                            <div class="dropdown-menu catalogue-active-catalogue">
                                                                                                <div class="dropup-content catalogue-dropup-content">
                                                                                                    <div class="action-1">
                                                                                                        <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-variation.edit',$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                                                        <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('variation-details/'.Crypt::encrypt($product_variation->id))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                                                        @if($shelf_use == 1)
                                                                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Shelf View"><a class="btn-size shelf-btn" href="#" data-toggle="modal" data-target="#myModal{{$product_variation->id}}"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></div>
                                                                                                        @endif
                                                                                                        <div class="align-items-center mr-2"><a class="btn-size invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$product_variation->product_draft_id.'/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class="fa fa-book" aria-hidden="true"></i></a></div>
                                                                                                        <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-barcode/'.$product_variation->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                                                                        <div class="align-items-center">
                                                                                                            <form action="{{route('product-variation.destroy',$product_variation->id)}}" method="post">
                                                                                                                @csrf
                                                                                                                @method('DELETE')
                                                                                                                <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('product');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                                                            </form>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--End dropup content-->
                                                                                        </div>
                                                                                        <!--End manage button area-->
                                                                                    </td>

                                                                                    <!--Start modal-->
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
                                                                                                                        <div class="col-6 text-center">
                                                                                                                            <h6> Shelf Name </h6>
                                                                                                                            <hr width="60%">
                                                                                                                        </div>
                                                                                                                        <div class="col-6 text-center">
                                                                                                                            <h6>Quantity</h6>
                                                                                                                            <hr width="40%">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    @foreach($product_variation->shelf_quantity as $shelf)
                                                                                                                        @if($shelf->pivot->quantity != 0)
                                                                                                                            @php
                                                                                                                                $ids = '"'.$product_variation->id.'_'.$shelf->pivot->id.'"';
                                                                                                                            @endphp
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-6 text-center m-b-10">
                                                                                                                                    <h7> {{$shelf->shelf_name}} </h7>
                                                                                                                                </div>

                                                                                                                                <div class="col-6 text-center m-b-10">
                                                                                                                                    <h7 class="qnty_{{$product_variation->id}}_{{$shelf->pivot->id}}"> {{$shelf->pivot->quantity}} </h7>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        @endif
                                                                                                                    @endforeach
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
                                                                                    </div>
                                                                                    <!--End modal-->
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                        </tbody>
                                                                        <!--End row expand inner table body-->
                                                                    </table>
                                                                    <!--End row expand inner table-->
                                                                <!-- </div> -->
                                                            </div> <!-- end card -->
                                                        </div> <!-- end col-12 -->
                                                    </div> <!-- end row -->
                                                </div>
                                            </td>
                                       </tr>
                                    @endif
                                    <!-- channel listing modal -->
                                @endforeach
                                </tbody>
                                <!--End table body-->
                            </table>
                            <!--End Table-->
                        </div>


                    </div>
                </div>
                <!--Card box start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->


    <script type="text/javascript">
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


        function catalogue_search(){

            var name = $('#name').val();

            if(name == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            ids = [0];
            searchPriority = 0;
            skip = 0;
            var category_id = $('#category_id').val();
            var status = $('#status').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('/search-product-list').'?_token='.csrf_token()); ?>',
                data: {
                    "name": name,
                    "status":status,
                    "category_id":category_id,
                    "search_priority": searchPriority,
                    "skip": skip,
                    "take": take,
                    "ids": ids,
                },
                beforeSend: function(){

                    $("#product_variation_loading").show();
                },
                success: function(response){
                    $('#search_reasult').html(response.html);
                    searchPriority = response.search_priority;
                    take = response.take;
                    skip = parseInt(response.skip)+10;
                    ids = ids.concat(response.ids);


                },
                complete:function(data){
                    // Hide image container
                    $("#product_variation_loading").hide();
                }
            });
        }

        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });

            $('span.low-quantity-change').on('click', function(){
                var columnId = $(this).closest('tr').attr('class').split('low-quantity-')[1]
                var url = "{{asset('change-low-quantity')}}" + '/' + columnId
                fetch(url)
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    if(data.type == 'success'){
                        $('tr.low-quantity-'+columnId).remove()
                        Swal.fire('Success',data.msg,'success')
                    }else{
                        Swal.fire('Error',data.msg,'error')
                    }
                })
                .catch(error => {
                    Swal.fire('Oops!',error,'error')
                })
            })
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
        $(document).on('click','.clear-params',function(){
            localStorage.clear();
            var path = "{{Request::path()}}"
            window.location.href = "{{asset('/')}}"+path;
            //resetForm($('#low-quantity-table'))
        })
        // function resetForm($form){
        //     $form.find('input:text, select').val('')
        //     $form.find('input:checkbox').prop('checked',false)
        // }

    </script>





@endsection


