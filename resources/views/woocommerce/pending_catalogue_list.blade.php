@extends('master')

@section('title')
    WooCommerce | Pending Product | WMS360
@endsection

@section('content')

    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['image']) && $setting['woocommerce']['woocommerce_pending_product']['image'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['image']) && $setting['woocommerce']['woocommerce_pending_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['id']) && $setting['woocommerce']['woocommerce_pending_product']['id'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['id']) && $setting['woocommerce']['woocommerce_pending_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['catalogue-name']) && $setting['woocommerce']['woocommerce_pending_product']['catalogue-name'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['catalogue-name']) && $setting['woocommerce']['woocommerce_pending_product']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['category']) && $setting['woocommerce']['woocommerce_pending_product']['category'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['category']) && $setting['woocommerce']['woocommerce_pending_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['sold']) && $setting['woocommerce']['woocommerce_pending_product']['sold'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['sold']) && $setting['woocommerce']['woocommerce_pending_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['stock']) && $setting['woocommerce']['woocommerce_pending_product']['stock'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['stock']) && $setting['woocommerce']['woocommerce_pending_product']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['product']) && $setting['woocommerce']['woocommerce_pending_product']['product'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['product']) && $setting['woocommerce']['woocommerce_pending_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['creator']) && $setting['woocommerce']['woocommerce_pending_product']['creator'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['creator']) && $setting['woocommerce']['woocommerce_pending_product']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['modifier']) && $setting['woocommerce']['woocommerce_pending_product']['modifier'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['modifier']) && $setting['woocommerce']['woocommerce_pending_product']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['sku']) && $setting['woocommerce']['woocommerce_pending_product']['sku'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['sku']) && $setting['woocommerce']['woocommerce_pending_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['qr']) && $setting['woocommerce']['woocommerce_pending_product']['qr'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['qr']) && $setting['woocommerce']['woocommerce_pending_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['variation']) && $setting['woocommerce']['woocommerce_pending_product']['variation'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['variation']) && $setting['woocommerce']['woocommerce_pending_product']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['ean']) && $setting['woocommerce']['woocommerce_pending_product']['ean'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['ean']) && $setting['woocommerce']['woocommerce_pending_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['regular-price']) && $setting['woocommerce']['woocommerce_pending_product']['regular-price'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['regular-price']) && $setting['woocommerce']['woocommerce_pending_product']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['sales-price']) && $setting['woocommerce']['woocommerce_pending_product']['sales-price'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['sales-price']) && $setting['woocommerce']['woocommerce_pending_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['available-qty']) && $setting['woocommerce']['woocommerce_pending_product']['available-qty'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['available-qty']) && $setting['woocommerce']['woocommerce_pending_product']['available-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="available-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Available Qty</p></div>
                                    </div>
                                    @if($shelf_use == 1)
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_pending_product']['shelf-qty']) && $setting['woocommerce']['woocommerce_pending_product']['shelf-qty'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_pending_product']['shelf-qty']) && $setting['woocommerce']['woocommerce_pending_product']['shelf-qty'] == 0) @else checked @endif>
                                                <label class="onoffswitch-label" for="shelf-qty">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                            <div class="ml-1"><p>Shelf Qty</p></div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="woocommerce">
                            <input type="hidden" id="secondKey" value="woocommerce_pending_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                            <!--Pagination count, catalogue search by date and apply button section-->
                            <div class="d-flex justify-content-between align-items-center pagination-content">
                                <div>
                                    <form>
                                        <div><p class="pagination"><b>Pagination</b></p></div>
                                        <ul class="column-display d-flex align-items-center">
                                            <li>Number of items per page</li>
                                            <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                        </ul>
                                        <span class="pagination-mgs-show text-success"></span>
                                    </form>
                                </div>
                                <div class="d-flex align-items-center select-catalogue">
                                    <select class="form-control catalogue-form-con" name="catalogue_search_by_date" id="catalogue_search_by_date">
                                        <option value="">Catalogue By Date Or Stock</option>
                                        <option value="1">Today</option>
                                        <option value="7">Last 7 Days</option>
                                        <option value="15">Last 15 Days</option>
                                        <option value="30">Last 30 Days</option>
                                        <option value="instock">In Stock</option>
                                        <option value="outofstock">Out Of Stock</option>
                                    </select>
                                    <input type="hidden" name="status" id="status" value="publish">
                                    <input type="hidden" name="status_pending" id="status_pending" value="woocom_pending">
                                </div>
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
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
                            <li class="breadcrumb-item">Woocommerce</li>
                            <li class="breadcrumb-item active" aria-current="page">Pending Product</li>
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
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search on WooCommerce...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search();">Search</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$product_drafts->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$product_drafts_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$product_drafts_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="woocommerce/pending/catalogue/lists">
                                                    </span>
                                                    @if($product_drafts->currentPage() !== $product_drafts->lastPage())
                                                    <a class="next-page btn" href="{{ $url != '' ? $product_drafts_info->next_page_url.$url : $product_drafts_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $product_drafts_info->last_page_url.$url : $product_drafts_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                        <span class="screen-reader-text d-none">Last page</span>
                                                        <span aria-hidden="true">»</span>
                                                    </a>
                                                    @endif
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <!--End Pagination area start-->

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


                            <!--WooCommerce upload csv-->
                            <div class="row csv-upload-div" style="display: none">
                                <div class="col-6">
                                    <form action="{{url('upload-csv')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group input-group">
                                            <input type="file" name="csv_file" class="form-control">
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--End WooCommerce upload csv-->

                            <!--Start Table-->
                            <table class="draft_search_result product-draft-table w-100">
                                <!--start table head-->
                                <thead style="background-color: {{$setting->master_draft_catalogue->table_header_color ?? '#c5bdbd'}}; color: {{$setting->master_draft_catalogue->table_header_text_color ?? '#292424'}}">
                                <form action="{{url('all-column-search')}}" method="post">
                                @csrf
                                <input type="hidden" name="search_route" value="woocommerce/pending/catalogue/lists">
                                <input type="hidden" name="status" value="publish">
                                <tr>
                                    <th class="image" style="width: 15%; text-align: center !important;">Image</th>
                                    <th class="id" style="width: 6%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="catalogue_id" id="catalogueId" value="{{$allCondition['catalogue_id'] ?? ''}}">
                                                        <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="catalogue_opt_out" type="checkbox" name="catalogue_opt_out" value="1" @isset($allCondition['catalogue_opt_out']) checked @endisset><label for="catalogue_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out1" type="checkbox" name="opt_out" value="1"><label for="opt-out1">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="id">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['catalogue_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="catalogue_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>

                                    <th class="catalogue-name" style="width: 30%;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}" id="catalogueTitle">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="title_opt_out" type="checkbox" name="title_opt_out" value="1" @isset($allCondition['title_opt_out']) checked @endisset><label for="title_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="name">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div> Title</div>
                                        </div>
                                    </th>

                                    <th class="category" style=width: 10% !important>
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['category'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $woowms_category_info = \App\WooWmsCategory::orderBy('category_name', 'ASC')->get();
                                                        @endphp
                                                        <select class="form-control select3 b-r-0 js-select2" name="category[]" multiple>
                                                            @if(isset($woowms_category_info))
                                                                @if($woowms_category_info->count() == 1)
                                                                    @foreach($woowms_category_info as $category_name)
                                                                        <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option disabled value="">Select Category</option>
                                                                    @foreach($woowms_category_info as $category_name)
                                                                        @if(isset($allCondition['category']))
                                                                            @php
                                                                                $existCategory = null;
                                                                            @endphp
                                                                            @foreach($allCondition['category'] as $cat)
                                                                                @if($category_name->id == $cat)
                                                                                    <option value="{{$category_name->id}}" selected>{{$category_name->category_name}}</option>
                                                                                    @php
                                                                                        $existCategory = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existCategory == null)
                                                                                <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="category_opt_out" type="checkbox" name="category_opt_out" value="1" @isset($allCondition['category_opt_out']) checked @endisset><label for="category_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="woowms_category">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['category']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="category" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Category</div>
                                        </div>
                                    </th>

                                    <th class="rrp filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['rrp'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                            <select class="form-control" name="rrp_opt" id="catalogueRrpOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['rrp_opt']) && ($allCondition['rrp_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['rrp_opt']) && ($allCondition['rrp_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['rrp_opt']) && ($allCondition['rrp_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['rrp_opt']) && ($allCondition['rrp_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['rrp_opt']) && ($allCondition['rrp_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                            <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="rrp" id="catalogueRrp" value="{{$allCondition['rrp'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="rrp_opt_out" type="checkbox" name="rrp_opt_out" value="1" @isset($allCondition['rrp_opt_out']) checked @endisset><label for="rrp_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="rrp">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['rrp']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="rrp" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>RRP</div>
                                        </div>
                                    </th>

                                    <th class="base_price filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['base_price'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                            <select class="form-control" name="base_price_opt" id="catalogueBasePriceOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['base_price_opt']) && ($allCondition['base_price_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['base_price_opt']) && ($allCondition['base_price_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['base_price_opt']) && ($allCondition['base_price_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['base_price_opt']) && ($allCondition['base_price_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['base_price_opt']) && ($allCondition['base_price_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                            <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="base_price" id="catalogueBasePrice" value="{{$allCondition['base_price'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="base_price_opt_out" type="checkbox" name="base_price_opt_out" value="1" @isset($allCondition['base_price_opt_out']) checked @endisset><label for="base_price_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="base_price">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['base_price']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="base_price" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Base Price</div>
                                        </div>
                                    </th>

                                    <th class="sold filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['sold'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                            <select class="form-control" name="sold_opt" id="catalogueSoldOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['sold_opt']) && ($allCondition['sold_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['sold_opt']) && ($allCondition['sold_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['sold_opt']) && ($allCondition['sold_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['sold_opt']) && ($allCondition['sold_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['sold_opt']) && ($allCondition['sold_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                            <input type="number" class="form-control input-text symbol-filter-input-text" name="sold" id="catalogueSold" value="{{$allCondition['sold'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="sold_opt_out" type="checkbox" name="sold_opt_out" value="1" @isset($allCondition['sold_opt_out']) checked @endisset><label for="sold_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="sold">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['sold']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="sold" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Sold</div>
                                        </div>
                                    </th>

                                    <th class="stock filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['stock'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                            <select class="form-control" name="stock_opt" id="catalogueStockOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                            <input type="number" class="form-control input-text symbol-filter-input-text" name="stock" id="catalogueStock" value="{{$allCondition['stock'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="stock_opt_out" type="checkbox" name="stock_opt_out" value="1" @isset($allCondition['stock_opt_out']) checked @endisset><label for="stock_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="stock">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['stock']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="stock" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Stock</div>
                                        </div>
                                    </th>

                                    <th class="product filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['product'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                            <select class="form-control" name="product_opt" id="catalogurProductOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['product_opt']) && ($allCondition['product_opt'] == '≥')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                            <input type="number" class="form-control input-text symbol-filter-input-text" name="product" id="catalogueProduct" value="{{$allCondition['product'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="product_opt_out" type="checkbox" name="product_opt_out" value="1" @isset($allCondition['product_opt_out']) checked @endisset><label for="product_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="product">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Product</div>
                                        </div>
                                    </th>

                                    <th class="creator filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['creator'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $all_user_name = \App\User::get();
                                                        @endphp
                                                        <select class="form-control select2" name="creator" id="catalogueCreator">
                                                        <!-- <select class="form-control b-r-0" name="search_value"> -->
                                                            @if(isset($all_user_name))
                                                                @if($all_user_name->count() == 1)
                                                                    @foreach($all_user_name as $user_name)
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Creator</option>
                                                                    @foreach($all_user_name as $user_name)
                                                                        <!-- <option value="{{$user_name->id}}">{{$user_name->name}}</option> -->
                                                                    @if(isset($allCondition['creator']) && ($allCondition['creator'] == $user_name->id))
                                                                            <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                        @else
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="creator_opt_out" type="checkbox" name="creator_opt_out" value="1" @isset($allCondition['creator_opt_out']) checked @endisset><label for="creator_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="creator">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['creator']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="creator" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>

                                    <th class="modifier filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('woocommerce/pending/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['modifier'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $all_user_name = \App\User::get();
                                                        @endphp
                                                        <select class="form-control select2" name="modifier" id="catalogueModifier">
                                                        <!-- <select class="form-control b-r-0" name="search_value"> -->
                                                            @if(isset($all_user_name))
                                                                @if($all_user_name->count() == 1)
                                                                    @foreach($all_user_name as $user_name)
                                                                        <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Modifier</option>
                                                                    @foreach($all_user_name as $user_name)
                                                                        <!-- <option value="{{$user_name->id}}">{{$user_name->name}}</option> -->
                                                                        @if(isset($allCondition['modifier']) && ($allCondition['modifier'] == $user_name->id))
                                                                            <option value="{{$user_name->id}}" selected>{{$user_name->name}}</option>
                                                                        @else
                                                                            <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="modifier_opt_out" type="checkbox" name="modifier_opt_out" value="1" @isset($allCondition['modifier_opt_out']) checked @endisset><label for="modifier_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="modifier">
                                                        <input type="hidden" name="route_name" value="woo-pending-product">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['modifier']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="modifier" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Modifier</div>
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
                                <tbody id="search_reasult">
                                @isset($allCondition)
                                @if(count($product_drafts) == 0 && count($allCondition) != 0)
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
                                @foreach($product_drafts as $product_draft)
                                    <tr>
                                        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$product_draft->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                             @if(isset($product_draft->single_image_info->image_url))
                                                <a href="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                    <img src="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}" class="thumb-md zoom" alt="WooCommerce-image">
                                                </a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="WooCommerce-image">
                                            @endif

                                        </td>
{{--                                        <td class="id" style="width: 6%; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">--}}
                                        <td class="id" style="width: 6%; text-align: center !important;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_draft->id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="catalogue-name" style="width: 30%; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            <a class="catalogue-link" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">

                                                {!! Str::limit(strip_tags($product_draft->name),$limit = 100, $end = '...') !!}

                                            </a>
                                        </td>
                                        <td class="category" style="cursor: pointer; text-align: center !important; width: 10% !important" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{json_decode($product_draft)->woo_wms_category->category_name ?? ''}}</td>
                                        <td class="rrp" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->rrp ?? ''}}</td>
                                        <td class="base_price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->base_price ?? ''}}</td>
                                        @php
                                            $data = 0;
                                            if(count($product_draft->variations) > 0){
                                                foreach ($product_draft->variations as $variation){
                                                    if(isset($variation->order_products[0]->sold)){
                                                        $data += $variation->order_products[0]->sold;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$data ?? 0}}</td>
                                        <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->ProductVariations[0]->stock ?? 0}}</td>
                                        <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->product_variations_count ?? 0}}</td>
                                        <td class="creator" style="width: 10% !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            @if(isset($product_draft->user_info->name))
                                            <div class="wms-name-creator">
                                                <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                    <strong class="@if($product_draft->user_info->deleted_at)text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="width: 10% !important; cursor: pointer" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            @if(isset($product_draft->modifier_info->name))
                                                <div class="wms-name-modifier1">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->updated_at))}}">
                                                        <strong class="@if($product_draft->modifier_info->deleted_at)text-danger @else text-success @endif">{{$product_draft->modifier_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @elseif(isset($product_draft->user_info->name))
                                                <div class="wms-name-modifier2">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                        <strong class="@if($product_draft->user_info->deleted_at)text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="actions draft-list" style="width: 6%">
                                            <div class="align-items-center">
                                                <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On WooCommerce"><i class="fa fa-wordpress" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>


                                    <!--Hidden Row-->
                                    <tr>
                                        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse"  id="demo{{$product_draft->id}}">

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
                                                <span class="displaying-num"> {{$product_drafts->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$product_drafts_info->current_page}} of <span class="total-pages">{{$product_drafts_info->last_page}}</span></span>
                                                    </span>
                                                    @if($product_drafts->currentPage() !== $product_drafts->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $product_drafts_info->next_page_url.$url : $product_drafts_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $product_drafts_info->last_page_url.$url : $product_drafts_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                <!--End Cardbox start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->


    <script type="text/javascript">
    $(".select3").select2();
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
        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1];
            var status = $('#status_pending').val();
            console.log(id);

            $.ajax({
                type: "post",
                url: "<?php echo e(url('woocommerce/get-variation')); ?>",
                data: {
                    "_token" : "<?php echo e(csrf_token()); ?>",
                    "woocom_master_product_id" : id,
                    "status" : status,

                },
                beforeSend: function () {
                    $('#product_variation_loading'+id).show();
                },
                success: function (response) {
                    // $('#datatable_wrapper div:first').hide();
                    // $('#datatable_wrapper div:last').hide();
                    // $('.product-content ul.pagination').hide();
                    // $('.total-d-o span').hide();
                    // $('.draft_search_result').html(response.data);
                    console.log(response);
                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }


        function catalogue_search(){
            var name = $('#name').val();
            var ean_status = $('#ean_status').val();

            if(name == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            ids = [0];
            searchPriority = 0;
            skip = 0;
            var status = $('#status_pending').val();
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('/search-product-list').'?_token='.csrf_token()); ?>',
                data: {
                    "name": name,
                    "status":status,
                    "search_priority": searchPriority,
                    "skip": skip,
                    "take": take,
                    "ids": ids,
                    "ean_status": ean_status,
                },
                beforeSend: function(){

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
                    $('#search_reasult').html(response.html);
                    searchPriority = response.search_priority;
                    take = response.take;
                    skip = parseInt(response.skip)+10;
                    ids = ids.concat(response.ids);
                    // console.log(response.ids);
                    // console.log('********');
                    // console.log(ids);

                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }



        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }
                console.log(date_value);
                var status = $('#status').val();

                $.ajax({
                    type: "post",
                    url: "{{url('search-catalogue-by-date')}}",
                    data: {
                        "_token" : "{{csrf_token()}}",
                        "search_date" : date_value,
                        "status" : status
                    },
                    beforeSend: function () {
                        $('#ajax_loader').show();
                    },
                    success: function (response) {
                        // $('#datatable_wrapper div:first').hide();
                        // $('#datatable_wrapper div:last').hide();
                        // $('.product-content ul.pagination').hide();
                        // $('.total-d-o span').hide();
                        // $('.draft_search_result').html(response.data);
                        $('tbody').html(response.data);
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                })
            })

        } );


        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });

            $('.upload-csv-btn').click(function () {
                $('.csv-upload-div').slideToggle();
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

        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });

    </script>



@endsection
