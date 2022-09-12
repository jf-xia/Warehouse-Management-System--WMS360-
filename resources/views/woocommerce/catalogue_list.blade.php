@extends('master')

@section('title')
    WooCommerce | {{$status_type == 'draft' ? 'Draft Product' : 'Active Product'}} | WMS360
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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['image']) && $setting['woocommerce']['woocommerce_active_product']['image'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['image']) && $setting['woocommerce']['woocommerce_active_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['id']) && $setting['woocommerce']['woocommerce_active_product']['id'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['id']) && $setting['woocommerce']['woocommerce_active_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['catalogue-name']) && $setting['woocommerce']['woocommerce_active_product']['catalogue-name'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['catalogue-name']) && $setting['woocommerce']['woocommerce_active_product']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['category']) && $setting['woocommerce']['woocommerce_active_product']['category'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['category']) && $setting['woocommerce']['woocommerce_active_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="rrp" class="onoffswitch-checkbox" id="rrp" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['rrp']) && $setting['woocommerce']['woocommerce_active_product']['rrp'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['rrp']) && $setting['woocommerce']['woocommerce_active_product']['rrp'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="rrp">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>RRP</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['sold']) && $setting['woocommerce']['woocommerce_active_product']['sold'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['sold']) && $setting['woocommerce']['woocommerce_active_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['stock']) && $setting['woocommerce']['woocommerce_active_product']['stock'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['stock']) && $setting['woocommerce']['woocommerce_active_product']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['product']) && $setting['woocommerce']['woocommerce_active_product']['product'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['product']) && $setting['woocommerce']['woocommerce_active_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['creator']) && $setting['woocommerce']['woocommerce_active_product']['creator'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['creator']) && $setting['woocommerce']['woocommerce_active_product']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['modifier']) && $setting['woocommerce']['woocommerce_active_product']['modifier'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['modifier']) && $setting['woocommerce']['woocommerce_active_product']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['sku']) && $setting['woocommerce']['woocommerce_active_product']['sku'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['sku']) && $setting['woocommerce']['woocommerce_active_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['qr']) && $setting['woocommerce']['woocommerce_active_product']['qr'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['qr']) && $setting['woocommerce']['woocommerce_active_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['variation']) && $setting['woocommerce']['woocommerce_active_product']['variation'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['variation']) && $setting['woocommerce']['woocommerce_active_product']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['ean']) && $setting['woocommerce']['woocommerce_active_product']['ean'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['ean']) && $setting['woocommerce']['woocommerce_active_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['regular-price']) && $setting['woocommerce']['woocommerce_active_product']['regular-price'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['regular-price']) && $setting['woocommerce']['woocommerce_active_product']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['sales-price']) && $setting['woocommerce']['woocommerce_active_product']['sales-price'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['sales-price']) && $setting['woocommerce']['woocommerce_active_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['available-qty']) && $setting['woocommerce']['woocommerce_active_product']['available-qty'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['available-qty']) && $setting['woocommerce']['woocommerce_active_product']['available-qty'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="available-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Available Qty</p></div>
                                    </div>
                                    @if($shelfUse == 1)
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['woocommerce']['woocommerce_active_product']['shelf-qty']) && $setting['woocommerce']['woocommerce_active_product']['shelf-qty'] == 1) checked @elseif(isset($setting['woocommerce']['woocommerce_active_product']['shelf-qty']) && $setting['woocommerce']['woocommerce_active_product']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="woocommerce_active_product">
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
                                    <input type="hidden" name="status" id="status" value="{{$status_type}}">
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
                            <li class="breadcrumb-item active" aria-current="page">{{$status_type == 'draft' ? 'Draft Product' : 'Active Product'}} </li>
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
                                                <span class="displaying-num">{{$woocommerce_list->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($woocommerce_list->currentPage() > 1)
                                                    <a class="first-page btn {{$woocommerce_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$catalogue_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$woocommerce_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$catalogue_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$catalogue_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> {{$catalogue_info->current_page}} of <span class="total-pages">{{$catalogue_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="woocommerce/{{$status_type}}/catalogue/list">
                                                    </span>
                                                    @if($woocommerce_list->currentPage() !== $woocommerce_list->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $catalogue_info->next_page_url.$url : $catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $catalogue_info->last_page_url.$url : $catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                                <div class="row bulk-complete-button" style="display: none;">
                                    <div class="col-md-12">
                                        @if($status_type == 'draft')
                                            <button type="button" class="btn btn-primary mt-3 bulk-complete">Bulk Complete</button>
                                        @else
                                            <button type="button" class="btn btn-danger mt-3 bulk-delete">Bulk Delete</button>
                                        @endif
                                        <span class="checkbox-count font-16 ml-md-3"></span>
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


                            <!--WooCommerce upload csv-->
                            <div class="row csv-upload-div" style="display: none">
                                <div class="col-6">
                                    <form action="{{url('woocommerce/upload-csv')}}" method="post" enctype="multipart/form-data">
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
                            <table class="draft_search_result product-draft-table product-draft-table-row-expand w-100">
                                <!--start table head-->
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post" id="reset-column-data">
                                @csrf

                                <input type="hidden" name="search_route" value="woocommerce/{{$status_type}}/catalogue/list">
                                <input type="hidden" name="status" value="publish">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th class="image" style="width: 15%; text-align: center !important;">Image</th>
                                    <th class="id" style="width: 6%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post"> -->
                                                   <!-- @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['master_catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="master_catalogue_id" id="master_catalogue_id" value="{{$allCondition['master_catalogue_id'] ?? ''}}">
                                                        <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="catalogue_opt_out" type="checkbox" name="catalogue_opt_out" value="1" @isset($allCondition['catalogue_opt_out']) checked @endisset><label for="catalogue_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out1" type="checkbox" name="opt_out" value="1"><label for="opt-out1">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="master_catalogue_id">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['master_catalogue_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="master_catalogue_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="catalogue-name" style="width: 30%;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
                                                    @csrf -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}" id="catalogueTitle">
                                                        <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="title_opt_out" type="checkbox" name="title_opt_out" value="1" @isset($allCondition['title_opt_out']) checked @endisset><label for="title_opt_out">Opt Out</label>

                                                            <!-- <input id="opt-out2" type="checkbox" name="opt_out" value="1"><label for="opt-out2">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="name">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Title</div>
                                        </div>
                                    </th>
                                    <th class="category" style="width: 10% !important">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="" method=""> -->
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <!-- <i class="fa" aria-hidden="true"></i> -->
                                                        <i class="fa @isset($allCondition['category'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>

                                                        <!-- <select class="form-control select2 b-r-0 js-select2" name="category[]" multiple>
                                                        @foreach($woocommerce_list as $list)
                                                        @if(isset($list->all_category))
                                                                @if($list->all_category->count() == 1)
                                                                    @foreach($list->all_category as $category_name)
                                                                        <option value="{{$category_name->category_name}}">{{$category_name->category_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Category</option>
                                                                    @foreach($list->all_category as $category_name)
                                                                        <option value="{{$category_name->category_name}}">{{$category_name->category_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endisset
                                                            @endforeach
                                                        </select> -->




                                                        @php
                                                            $woowms_category_info = \App\Category::orderBy('category_name', 'ASC')->get();
                                                        @endphp
                                                        <select class="form-control select2 b-r-0 js-select2" name="category[]" multiple>
                                                            @if(isset($woowms_category_info))
                                                                @if($woowms_category_info->count() == 1)
                                                                    @foreach($woowms_category_info as $category_name)
                                                                        <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                    @endforeach
                                                                @else
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

                                                        <!-- <input type="text" class="form-control input-text" name=""> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="category_opt_out" type="checkbox" name="category_opt_out" value="1" @isset($allCondition['category_opt_out']) checked @endisset><label for="category_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out3" type="checkbox" name="opt_out" value="1"><label for="opt-out3">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="">
                                                        <input type="hidden" name="route_name" value="">
                                                        <input type="hidden" name="status" value=""> -->
                                                        @if(isset($allCondition['category']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="category" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Category</div>
                                        </div>
                                    </th>
                                    <th class="rrp filter-symbol" style="width: 10% !important">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                                <!-- <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value"> -->
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="rrp_opt_out" type="checkbox" name="rrp_opt_out" value="1" @isset($allCondition['rrp_opt_out']) checked @endisset><label for="rrp_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="rrp">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['rrp']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="rrp" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>RRP</div>
                                        </div>
                                    </th>
                                    <th class="sold filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                                <!-- <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value"> -->
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="sold_opt_out" type="checkbox" name="sold_opt_out" value="1" @isset($allCondition['sold_opt_out']) checked @endisset><label for="sold_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="sold">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['sold']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="sold" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Sold</div>
                                        </div>
                                    </th>
                                    <th class="stock filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                                <!-- <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value"> -->
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="stock_opt_out" type="checkbox" name="stock_opt_out" value="1" @isset($allCondition['stock_opt_out']) checked @endisset><label for="stock_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out6" type="checkbox" name="opt_out" value="1"><label for="opt-out6">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="stock">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['stock']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="stock" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Stock</div>
                                        </div>
                                    </th>
                                    <th class="product filter-symbol" style="width: 10% !important; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                                <!-- <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value"> -->
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="product_opt_out" type="checkbox" name="product_opt_out" value="1" @isset($allCondition['product_opt_out']) checked @endisset><label for="product_opt_out">Opt Out</label>
                                                            <!-- <input id="opt-out7" type="checkbox" name="opt_out" value="1"><label for="opt-out7">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="product">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Product</div>
                                        </div>
                                    </th>
                                    <th class="creator" style="width: 10% !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                            <!-- <input id="opt-out8" type="checkbox" name="opt_out" value="1"><label for="opt-out8">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="user_id">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['creator']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="creator" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                <!-- </form> -->
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th class="modifier" style="width: 10% !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <!-- <form action="{{url('publish/woocommerce/catalogue/search')}}" method="post">
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
                                                            <!-- <input id="opt-out9" type="checkbox" name="opt_out" value="1"><label for="opt-out9">Opt Out</label> -->
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="modifier_id">
                                                        <input type="hidden" name="route_name" value="woocommerce_publish">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['modifier']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="modifier" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
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
                                <tbody id="woocomtdody">
                                @isset($allCondition)
                                @if(count($woocommerce_list) == 0 && count($allCondition) != 0)
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
                                @foreach($woocommerce_list as $list)
                                    <tr class="hide-after-complete-{{$list->id}}">
                                        <td><input type="checkbox" class="checkBoxClass" id="customCheck{{$list->id}}" value="{{$list->id}}"></td>
                                        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}"  data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$list->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                             @if(isset($list->single_image_info->image_url))
                                                <a href="{{$list->single_image_info->image_url}}"  title="Click to expand" target="_blank"><img src="{{$list->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image"></a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                                            @endif

                                        </td>
{{--                                        <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">--}}
                                        <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$list->master_catalogue_id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            <a class="catalogue-link" href="https://www.topbrandoutlet.co.uk/wp-admin/post.php?post={{$list->id}}&action=edit" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit On Woocommerce">
                                                {!! Str::limit(strip_tags($list->name),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <?php
                                        $data = '';
                                        foreach ($list->all_category as $category){
                                            $data .= $category->category_name.',';
                                        }
                                        // $total_sold = 0;
                                        // foreach ($list->sold_variations as $variations){
                                        //     foreach ($variations->order_products as $order_products){
                                        //         $total_sold += $order_products->sold;
                                        //     }
                                        // }
                                        ?>

                                        @php
                                            $total_sold = 0;
                                            if(count($list->sold_variations) > 0){
                                                foreach ($list->sold_variations as $variations){
                                                    foreach ($variations->order_products_without_cancel_and_return as $order_products){
                                                        $total_sold += $order_products->sold;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td class="category" style="cursor: pointer; text-align: start !important; width: 10% !important" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{rtrim($data,',')}}</td>
                                        <td class="rrp" style="cursor: pointer; text-align: center !important; width: 10% !important" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->rrp ?? ''}}</td>
                                        <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_sold ?? 0}}</td>
                                        <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->variations[0]->stock ?? 0}}</td>
                                        <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$list->variations_count ?? 0}}</td>
                                        <td class="creator" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            @if(isset($list->user_info->name))
                                            <div class="wms-name-creator">
                                                <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                                                    <strong class="@if($list->user_info->deleted_at)text-danger @else text-success @endif">{{$list->user_info->name ?? ''}}</strong>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="width: 10% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$list->id}}" data-target="#demo{{$list->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            @if(isset($list->modifier_info->name))
                                                <div class="wms-name-modifier1">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($list->updated_at))}}">
                                                        <strong class="@if($list->modifier_info->deleted_at)text-danger @else text-success @endif">{{$list->modifier_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @elseif(isset($list->user_info->name))
                                                <div class="wms-name-modifier2">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($list->created_at))}}">
                                                        <strong class="@if($list->user_info->deleted_at)text-danger @else text-success @endif">{{$list->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="actions draft-list" style="width: 6%">
                                            <!--start manage button area-->
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <!--start dropup content-->
                                                <div class="dropdown-menu">
                                                    <div class="dropup-content catalogue-dropup-content">
                                                        <div class="action-1">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{url('woocommerce/'.$status_type.'/catalogue/'.$list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{url('woocommerce/'.$status_type.'/catalogue/'.$list->id.'/show')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('woocommerce/catalogue/'.$list->id.'/variation')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                                            @if($list->status == 'draft')
                                                                <div class="align-items-center mr-2">
                                                                    <form action="{{url('woocommerce/catalogue/publish/'.$list->id)}}" method="post">
                                                                        @csrf
                                                                        <button class="del-pub publish-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i> </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                            <div class="align-items-center">
                                                                <form action="{{url('woocommerce/catalogue/delete/'.$list->id)}}" method="post">
                                                                    @csrf
                                                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
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
                                            <div class="accordian-body collapse" id="demo{{$list->id}}">

                                            </div>
                                        </td>

                                    </tr> <!-- hide expand row-->

                                @endforeach
                                </tbody>
                                <!--End table body-->
                            </table>
                            <!--End Table-->

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$woocommerce_list->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($woocommerce_list->currentPage() > 1)
                                                    <a class="first-page btn {{$woocommerce_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $catalogue_info->first_page_url.$url : $catalogue_info->first_page_url}}}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <a class="first-page btn {{$woocommerce_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $catalogue_info->first_page_url.$url : $catalogue_info->first_page_url}}}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$woocommerce_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $catalogue_info->prev_page_url.$url : $catalogue_info->prev_page_url}}}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$catalogue_info->current_page}} of <span class="total-pages">{{$catalogue_info->last_page}}</span></span>
                                                    </span>
                                                    @if($woocommerce_list->currentPage() !== $woocommerce_list->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $catalogue_info->next_page_url.$url : $catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $catalogue_info->last_page_url.$url : $catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
        $(".select2").select2();
        // $(".select2").select2();
        var searchPriority = 0;
        var skip = 0;
        var take = 10;
        var ids = [0];

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table").find(".collapse.in").not(this).collapse('toggle')
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
            console.log(status);
            $.ajax({
                type: 'POST',
                url: '{{url('woocommerce/search-catalogue-list').'?_token='.csrf_token()}}',
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
                    // Show image container
                    //console.log(name);
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
                    // $('.product-content ul.pagination').hide();
                    // $('.total-d-o span').hide();
                    // $('table.draft_search_result').html(response);
                    //console.log(response);
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


                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }

        $(document).bind("scroll", function(e){

            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){

                var name = $('#name').val();

                if(name != '' ){
                    //$('#ajaxCall').remove();
                    var category_id = $('#category_id').val();
                    var status = $('#status').val();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(url('woocommerce/search-catalogue-list').'?_token='.csrf_token()); ?>',
                        data: {
                            "name": name,
                            "status":status,
                            "category_id":category_id,
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
                            //console.log(response);
                            searchPriority = response.search_priority;
                            take = response.take;
                            skip = parseInt(response.skip)+10;
                            // var div = document.getElementById("woocomtdody");
                            // div.innerHTML +=response.html;
                            $('tbody tr:last').after(response.html);
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

        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1];
            var status = $('#status').val();
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

        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }
                var status = $('#status').val();
                console.log(date_value);
                $.ajax({
                    type: "post",
                    url: "{{url('woocommerce/search-catalogue-by-date')}}",
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
                        console.log(response.data);
                        // $('.draft_search_result').html(response.data);
                        $('tbody').html(response.data);
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                })
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

            $('.upload-csv-btn').click(function () {
                $('.csv-upload-div').slideToggle();
            });
            $('#selectAll').click(function(){
                $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                var catalogueIds = catalogueIdArray();
                countSelectedItem()
            });
            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
                var catalogueIds = catalogueIdArray();
                countSelectedItem()
            });
            $('div.bulk-complete-button button.bulk-complete').on('click',function (){
                var catalgoueIDs = catalogueIdArray();
                $.ajax({
                    type: "post",
                    url: "{{url('woocommerce/bulk-draft-catalogue-complete')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "catalogueIDs": catalgoueIDs
                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        if(response.data == 'success'){
                            catalgoueIDs.forEach(function (item){
                                $('table tr.hide-after-complete-'+item).hide();
                            })
                            Swal.fire({
                                title: 'Selected catalogue published successfully',
                                icon: 'success'
                            });
                        }else{
                            Swal.fire({
                                title: response.msg,
                                icon: 'error'
                            });
                        }
                        $('#ajax_loader').hide();
                    }
                });
            });

            $('button.bulk-delete').on('click', function(){
                var catalogueIDs = catalogueIdArray();
                if(catalogueIDs.length == 0){
                    Swal.fire('Oops!','Please select at least one product','warning')
                    return false
                }
                Swal.fire({
                    title: 'Are you sure to delete it?',
                    text: 'All associate products will also be deleted',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    showLoaderOnConfirm: true,
                    preConfirm:function(){
                        return new Promise(function(resolve){
                            $.ajax({
                                type: 'post',
                                url: "{{url('woocommerce/active-catalogue-bulk-delete')}}",
                                data: {
                                    "_token": "{{csrf_token()}}",
                                    "catalogueIDs": catalogueIDs
                                }
                            })
                            .done(function(response){
                                if(response.type == 'success'){
                                    catalogueIDs.forEach(function(item){
                                        $('tr.hide-after-complete-'+item).remove();
                                    })
                                    Swal.fire('Success',response.msg,'success')
                                }
                                if(response.type == 'warning'){
                                    Swal.fire('Oops...',response.msg,'warning')
                                }
                                if(response.type == 'error'){
                                    Swal.fire('Oops...',response.msg,'error')
                                }
                            })
                            .fail(function(){
                                Swal.fire('Oops...','Something went wrong','error')
                            })
                        })
                    },
                    allowOutsideClick: false
                })
            })
        });

        function countSelectedItem(){
            let countActiveCatalogue = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( countActiveCatalogue + " items selected!" );
        }

        function catalogueIdArray(){
            var order_number = [];
            $('table tbody tr td :checkbox:checked').each(function(i){
                order_number[i] = $(this).val();
            });
            if(order_number.length == 0){
                $('div.bulk-complete-button').hide('slow');
            }else{
                $('div.bulk-complete-button').show('slow');
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


        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });

        //getSavedValue("channels");
        // document.getElementById("catalogueId").value = getSavedValue("catalogueId");
        // document.getElementById("catalogue_opt_out").value = getSavedValue("catalogue_opt_out");
        // document.getElementById("catalogueTitle").value = getSavedValue("catalogueTitle");
        // document.getElementById("title_opt_out").value = getSavedValue("title_opt_out");
        // document.getElementById("catalogueRrpOpt").value = getSavedValue("catalogueRrpOpt");
        // document.getElementById("catalogueRrp").value = getSavedValue("catalogueRrp");
        // document.getElementById("rrp_opt_out").value = getSavedValue("rrp_opt_out");
        // document.getElementById("catalogueBasePriceOpt").value = getSavedValue("catalogueBasePriceOpt");
        // document.getElementById("catalogueBasePrice").value = getSavedValue("catalogueBasePrice");
        // document.getElementById("base_price_opt_out").value = getSavedValue("base_price_opt_out");
        // document.getElementById("catalogueSoldOpt").value = getSavedValue("catalogueSoldOpt");
        // document.getElementById("catalogueSold").value = getSavedValue("catalogueSold");
        // document.getElementById("sold_opt_out").value = getSavedValue("sold_opt_out");
        // document.getElementById("catalogueStockOpt").value = getSavedValue("catalogueStockOpt");
        // document.getElementById("catalogueStock").value = getSavedValue("catalogueStock");
        // document.getElementById("stock_opt_out").value = getSavedValue("stock_opt_out");
        // document.getElementById("catalogurProductOpt").value = getSavedValue("catalogurProductOpt");
        // document.getElementById("catalogueProduct").value = getSavedValue("catalogueProduct");
        // document.getElementById("product_opt_out").value = getSavedValue("product_opt_out");
        // document.getElementById("catalogueCreator").value = getSavedValue("catalogueCreator");
        // document.getElementById("creator_opt_out").value = getSavedValue("creator_opt_out");
        // document.getElementById("catalogueModifier").value = getSavedValue("catalogueModifier");
        // document.getElementById("modifier_opt_out").value = getSavedValue("modifier_opt_out");
        // function saveValue(e){
        //     var id = e.id;  // get the sender's id to save it .
        //     var val = e.value; // get the value.
        //     if(id == 'channels'){
        //         console.log($("#channels").val())
        //         // var channels = localStorage.channels ? JSON.parse(localStorage.channels) : [];
        //         localStorage.setItem(id, (JSON.stringify($("#channels").val())))
        //     }

        //     // console.log(e.value)
        //      localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
        // }
        // function getSavedValue(v){
        //     if (!localStorage.getItem(v)) {
        //         return "";// You can change this to your defualt value.
        //     }
        //     if(id == 'channels'){
        //         var channel = JSON.parse(localStorage.getItem(v))
        //         $("#channels > option").each(function() {
        //             var selectText = this.text
        //             channel.forEach((item, index) => {
        //                 console.log(item)
        //                 console.log('*****')
        //                 console.log(selectText)
        //                 if(selectText == item){
        //                     $('#channels option:contains('+selectText+')').attr('selected', 'selected');
        //                 }
        //             })
        //         });
        //         return false
        //     }
        //     return localStorage.getItem(v);
        // }


    </script>



    {{--    <script>--}}


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
    {{--            dir = "asc";--}}
    {{--            while (switching) {--}}
    {{--                switching = false;--}}
    {{--                rows = table.getElementsByTagName("TR");--}}
    {{--                for (i = 1; i < rows.length - 1; i++) {--}}
    {{--                    shouldSwitch = false;--}}
    {{--                    x = rows[i].getElementsByTagName("TD")[n];--}}
    {{--                    y = rows[i + 1].getElementsByTagName("TD")[n];--}}
    {{--                    if (dir == "asc") {--}}
    {{--                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {--}}
    {{--                            shouldSwitch = true;--}}
    {{--                            break;--}}
    {{--                        }--}}
    {{--                    } else if (dir == "desc") {--}}
    {{--                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {--}}
    {{--                            shouldSwitch = true;--}}
    {{--                            break;--}}
    {{--                        }--}}
    {{--                    }--}}
    {{--                }--}}
    {{--                if (shouldSwitch) {--}}
    {{--                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);--}}
    {{--                    switching = true;--}}
    {{--                    switchcount++;--}}
    {{--                } else {--}}
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
