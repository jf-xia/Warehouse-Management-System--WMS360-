@extends('master')
@section('title')
    Product Draft | WMS360
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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['image']) && $setting['catalogue']['draft_catalogue']['image'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['image']) && $setting['catalogue']['draft_catalogue']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['id']) && $setting['catalogue']['draft_catalogue']['id'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['id']) && $setting['catalogue']['draft_catalogue']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-type" class="onoffswitch-checkbox" id="product-type" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['product-type']) && $setting['catalogue']['draft_catalogue']['product-type'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['product-type']) && $setting['catalogue']['draft_catalogue']['product-type'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-type">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Type</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['catalogue-name']) && $setting['catalogue']['draft_catalogue']['catalogue-name'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['catalogue-name']) && $setting['catalogue']['draft_catalogue']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['category']) && $setting['catalogue']['draft_catalogue']['category'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['category']) && $setting['catalogue']['draft_catalogue']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>

                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="rrp" class="onoffswitch-checkbox" id="rrp" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['rrp']) && $setting['catalogue']['draft_catalogue']['rrp'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['rrp']) && $setting['catalogue']['draft_catalogue']['rrp'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="rrp">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>RRP</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="base_price" class="onoffswitch-checkbox" id="base_price" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['base_price']) && $setting['catalogue']['draft_catalogue']['base_price'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['base_price']) && $setting['catalogue']['draft_catalogue']['base_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="base_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Base Price</p></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['stock']) && $setting['catalogue']['draft_catalogue']['stock'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['stock']) && $setting['catalogue']['draft_catalogue']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['product']) && $setting['catalogue']['draft_catalogue']['product'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['product']) && $setting['catalogue']['draft_catalogue']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['creator']) && $setting['catalogue']['draft_catalogue']['creator'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['creator']) && $setting['catalogue']['draft_catalogue']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['modifier']) && $setting['catalogue']['draft_catalogue']['modifier'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['modifier']) && $setting['catalogue']['draft_catalogue']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['sku']) && $setting['catalogue']['draft_catalogue']['sku'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['sku']) && $setting['catalogue']['draft_catalogue']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div><div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['qr']) && $setting['catalogue']['draft_catalogue']['qr'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['qr']) && $setting['catalogue']['draft_catalogue']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['variation']) && $setting['catalogue']['draft_catalogue']['variation'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['variation']) && $setting['catalogue']['draft_catalogue']['variation'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['ean']) && $setting['catalogue']['draft_catalogue']['ean'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['ean']) && $setting['catalogue']['draft_catalogue']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['regular-price']) && $setting['catalogue']['draft_catalogue']['regular-price'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['regular-price']) && $setting['catalogue']['draft_catalogue']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['sales-price']) && $setting['catalogue']['draft_catalogue']['sales-price'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['sales-price']) && $setting['catalogue']['draft_catalogue']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['sold']) && $setting['catalogue']['draft_catalogue']['sold'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['sold']) && $setting['catalogue']['draft_catalogue']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="available-qty">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['available-qty']) && $setting['catalogue']['draft_catalogue']['available-qty'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['available-qty']) && $setting['catalogue']['draft_catalogue']['available-qty'] == 0) @else checked @endif>
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
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['catalogue']['draft_catalogue']['shelf-qty']) && $setting['catalogue']['draft_catalogue']['shelf-qty'] == 1) checked @elseif(isset($setting['catalogue']['draft_catalogue']['shelf-qty']) && $setting['catalogue']['draft_catalogue']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="firstKey" value="catalogue">
                            <input type="hidden" id="secondKey" value="draft_catalogue">
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
{{--                                <div class="d-flex align-items-center select-catalogue">--}}
{{--                                    <select class="form-control catalogue-form-con" name="catalogue_search_by_date" id="catalogue_search_by_date">--}}
{{--                                        <option value="">Catalogue By Date Or Stock</option>--}}
{{--                                        <option value="1">Today</option>--}}
{{--                                        <option value="7">Last 7 Days</option>--}}
{{--                                        <option value="15">Last 15 Days</option>--}}
{{--                                        <option value="30">Last 30 Days</option>--}}
{{--                                        <option value="instock">In Stock</option>--}}
{{--                                        <option value="outofstock">Out Of Stock</option>--}}
{{--                                    </select>--}}
{{--                                    <input type="hidden" name="status" id="status" value="draft">--}}
{{--                                </div>--}}
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn pagination-apply screen-option-setting" value="Apply">
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
                            <li class="breadcrumb-item active" aria-current="page">Product Draft</li>
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

                            @if ($message = Session::get('success_message'))
                                <div class="alert alert-success alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="success_message">{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('product_draft_id'))
                                <div id="success-product-draft-id" style="display: none">{{ $message }}</div>
                            @endif

                          <!--End Backend error handler-->

                            <!--start table upper side content-->
                            <div class="m-b-20 m-t-10 upper-side-content">
                                <div class="product-inner">

                                    <div class="draft-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search Catalogue...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search()">Search</button>
                                                <input type="hidden" name="status" id="status" value="draft">
                                            </div>
                                        </form>
                                    </div>

                                    <!-- add catalogue button start -->
                                            <div class="submit-btn">
                                                <a target="_blank" href="{{url('product-draft/create')}}"><button class="btn btn-default waves-effect waves-light">Add Catalogue</button></a>
                                                <!-- <input type="hidden" name="addcatalogue" id="addcatalogue" value="draft"> -->
                                            </div>
                                    <!-- add catalogue button end -->

                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                         <form action="{{url('pagination-all')}}" method="post">
                                             @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$product_drafts->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->first_page_url.$url : $product_drafts_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->prev_page_url.$url : $product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$product_drafts_info->current_page ?? '1'}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$product_drafts_info->last_page ?? '#'}}</span></span>
                                                        <input type="hidden" name="route_name" value="draft-catalogue-list">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
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
                                        </form>
                                    </div>
                                    <!--Pagination area End-->
                                </div>
                                <!--Bulk complete/delete and checkbox selected counter-->
                                <div class="row bulk-complete-button" style="display: none;">
                                    <div class="col-md-12 bulk-complete-content">
                                        <button type="button" class="btn btn-primary mt-3">Bulk Complete</button>
                                        <div class="mt-3 ml-2">
                                            <a href="Javascript:void(0)" class="btn btn-primary master-catalogue-bulk-delete">Bulk Delete</a>
                                        </div>
                                        <div class="checkbox-count font-16 ml-md-3 ml-sm-2 ml-xs-10 mt-4"></div>
                                    </div>
                                </div>
                                <!--End bulk complete/delete and checkbox selected counter-->
                            </div>
                            <!--End table upper side content-->

                            <!--start loader-->
                            {{-- <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content id loading...</span>
                                </div>
                            </div> --}}
                            <!--End loader-->

                            <!--Pending Catalogue upload csv-->
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
                            <!--Pending Catalogue upload csv-->

                                  <!--Start Table-->

                                <table class="draft_search_result product-draft-table product-draft-table-row-expand w-100">
                                    <!--start table head-->
                                    <thead style="background-color: {{$setting->master_draft_catalogue->table_header_color ?? '#c5bdbd'}};
                                        color: {{$setting->master_draft_catalogue->table_header_text_color ?? '#292424'}}">
                                    <form action="{{url('all-column-search')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="search_route" value="draft-catalogue-list">
                                    <input type="hidden" name="status" value="draft">
                                    <tr>
                                        <th style="width: 3%;"><input type="checkbox" class="ckbCheckAll" id="selectAll"></th>
                                        <th class="image" style="width: 6%; text-align: center !important;">Image</th>
                                        <th class="id" style="width: 6%; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="number" class="form-control input-text" name="catalogue_id" id="catalogue_id" value="{{$allCondition['catalogue_id'] ?? ''}}">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="catalogue_opt_out" type="checkbox" name="catalogue_opt_out" value="1" @isset($allCondition['catalogue_opt_out']) checked @endisset><label for="catalogue_opt_out">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="id">
                                                            <input type="hidden" name="route_name" value="product-draft">
                                                            <input type="hidden" name="status" value="draft"> -->
                                                            @if(isset($allCondition['catalogue_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="catalogue_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                </div>
                                                <div>ID</div>
                                            </div>
                                        </th>



                                        <th class="product-type" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['type'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                    <select class="form-control b-r-0 select2" name="type" id="channels">
                                                        <option value="">Select One</option>
                                                        @if(isset($allCondition['type']))
                                                            @if($allCondition['type'] == 'simple')
                                                            <option value="simple" selected>Simple</option>
                                                            <option value="variable">Variation</option>
                                                            @else
                                                            <option value="simple">Simple</option>
                                                            <option value="variable" selected>Variation</option>
                                                            @endif
                                                        @else
                                                            <option value="simple">Simple</option>
                                                            <option value="variable">Variation</option>
                                                        @endif
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="channel_opt_out" type="checkbox" name="type_opt_out" value="1" @isset($allCondition['type_opt_out']) checked @endisset><label for="channel_opt_out">Opt Out</label>
                                                    </div>
                                                    <!-- <input type="hidden" name="column_name" value="channel">
                                                    <input type="hidden" name="route_name" value="product-draft">
                                                    <input type="hidden" name="status" value="publish"> -->
                                                    @if(isset($allCondition['type']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="type" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>

                                            </div>
                                            <div>Product Type</div>
                                        </div>
                                    </th>

                                        <th class="catalogue-name" style="width: 30%;">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="title" value="{{$allCondition['title'] ?? ''}}" id="catalogueTitle">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="title_opt_out" type="checkbox" name="title_opt_out" value="1" @isset($allCondition['title_opt_out']) checked @endisset><label for="title_opt_out">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="name">
                                                            <input type="hidden" name="route_name" value="product-draft">
                                                            <input type="hidden" name="status" value="draft"> -->
                                                            @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div> Title</div>
                                            </div>
                                        </th>

                                        <th class="category" style="width: 10%;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['category'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            @php
                                                                $woowms_category_info = \App\WooWmsCategory::orderBy('category_name', 'ASC')->get();
                                                            @endphp
                                                            <select class="form-control select2 b-r-0" name="category[]" multiple>
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
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="category_opt_out" type="checkbox" name="category_opt_out" value="1" @isset($allCondition['category_opt_out']) checked @endisset><label for="category_opt_out">Opt Out</label>
                                                            </div>
                                                            <!-- <input type="hidden" name="column_name" value="woowms_category">
                                                            <input type="hidden" name="route_name" value="product-draft">
                                                            <input type="hidden" name="status" value="draft"> -->
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

                                        <th class="rrp filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['rrp'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="rrp_opt">
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
                                                            @if(isset($allCondition['rrp']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="rrp" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>RRP</div>
                                            </div>
                                        </th>

                                        <th class="base_price filter-symbol" style="width: 10% !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['base_price'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="base_price_opt">
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
                                                            @if(isset($allCondition['base_price']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="base_price" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Base Price</div>
                                            </div>
                                        </th>

                                        <th class="stock filter-symbol" style="width: 10% !important; text-align: center !important;">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['stock'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="stock_opt">
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
                                                            @if(isset($allCondition['stock']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="stock" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Stock</div>
                                            </div>
                                        </th>

                                        <th class="product filter-symbol" style="width: 10% !important; text-align: center !important;">
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
                                                                <input type="number" class="form-control input-text symbol-filter-input-text" name="product" id="catalogueProduct" value="{{$allCondition['product'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="product_opt_out" type="checkbox" name="product_opt_out" value="1" @isset($allCondition['product_opt_out']) checked @endisset><label for="product_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Product</div>
                                            </div>
                                        </th>

                                        <th class="creator filter-symbol" style="width: 8% !important">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['creator'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="creator">
                                                                @isset($users)
                                                                    @if($users->count() == 1)
                                                                        @foreach($users as $user)
                                                                            <option value="{{$user->id ?? ''}}">{{$user->name ?? ''}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">Select Creator</option>
                                                                        @foreach($users as $user)
                                                                            @if(isset($allCondition['creator']) && ($allCondition['creator'] == $user->id))
                                                                                <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                            @else
                                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="creator_opt_out" type="checkbox" name="creator_opt_out" value="1" @isset($allCondition['creator_opt_out']) checked @endisset><label for="creator_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['creator']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Creator</div>
                                            </div>
                                        </th>
                                        <th class="modifier filter-symbol" style="width: 8% !important">
                                            <div class="d-flex justify-content-start">
                                                <div class="btn-group">

                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['modifier'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="modifier">
                                                                @isset($users)
                                                                    @if($users->count() == 1)
                                                                        @foreach($users as $user)
                                                                            <option value="{{$user->id ?? ''}}">{{$user->name ?? ''}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">Select Modifier</option>
                                                                        @foreach($users as $user)
                                                                            @if(isset($allCondition['modifier']) && ($allCondition['modifier'] == $user->id))
                                                                                <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                                                            @else
                                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="modifier_opt_out" type="checkbox" name="modifier_opt_out" value="1" @isset($allCondition['modifier_opt_out']) checked @endisset><label for="modifier_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['modifier']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="modifier" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

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
                                    @if($product_drafts->count() > 0)
                                            @foreach($product_drafts as $product_draft)

                                                <tr class="variation_load_tr hide-after-complete-{{$product_draft->id}}">
                                                    <td style="width: 3%"><input type="checkbox" class="checkBoxClass" id="customCheck{{$product_draft->id}}" value="{{$product_draft->id}}"></td>
                                                    <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">

                                                        <!--Start each row loader-->
                                                        <div id="product_variation_loading{{$product_draft->id ?? ''}}" class="variation_load" style="display: none;"></div>
                                                        <!--End each row loader-->

                                                        <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                        @if(isset($product_draft->single_image_info->image_url))
                                                            <a href="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                                <img src="{{(filter_var($product_draft->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$product_draft->single_image_info->image_url : $product_draft->single_image_info->image_url}}" class="thumb-md zoom" alt="catalogue-image">
                                                            </a>
                                                        @else
                                                            <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="thumb-md zoom" alt="catalogue-image">
                                                        @endif

                                                    </td>
{{--                                                    <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">--}}
                                                    <td class="id" style="width: 6%; text-align: center !important;">
                                                        <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_draft->id ?? ''}}</span>
                                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                        </div>
                                                    </td>
                                                    <td class="product-type" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">
                                                        <div style="text-align: center;">
                                                            @if($product_draft->type == 'simple')
                                                                Simple
                                                            @else
                                                                Variation
                                                            @endif
                                                        </div>
                                                    </td><td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">
                                                        <a class="catalogue-link" href="{{route('product-draft.show',$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                            {{ Str::limit($product_draft->name,100, $end = '...')}}
                                                        </a>
                                                    </td>
                                                    <td class="category" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">{{json_decode($product_draft)->woo_wms_category->category_name ?? ''}}</td>

                                            <td class="rrp" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->rrp ?? ''}}</td>
                                            <td class="base_price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->base_price ?? ''}}</td>
                                            <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->ProductVariations[0]->stock ?? 0}}</td>
                                            <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->product_variations_count ?? 0}}</td>
                                            <td class="creator" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                                @if(isset($product_draft->user_info->name))
                                                <div class="wms-name-creator">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                        <strong class="@if($product_draft->user_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
{{--                                            <td class="modifier" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">--}}
                                            <td class="modifier" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id ?? ''}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id ?? ''}}" class="accordion-toggle">
                                                @if(isset($product_draft->modifier_info->name))
                                                    <div class="wms-name-modifier1">
                                                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->updated_at))}}">
                                                            <strong class="@if($product_draft->modifier_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->modifier_info->name ?? ''}}</strong>
                                                        </div>
                                                    </div>
                                                @elseif(isset($product_draft->user_info->name))
                                                    <div class="wms-name-modifier2">
                                                        <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
                                                            <strong class="@if($product_draft->user_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="actions draft-list" style="width: 6%">
                                                <div class="btn-group dropup">
                                                    <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Manage
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Dropdown menu links -->
                                                        <div class="dropup-content catalogue-dropup-content">
                                                            <div class="action-1">
                                                                <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-bulk-barcode/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$product_draft->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
                                                                {{-- <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                                                <div class="align-items-center" onclick="addTermsCatalog({{ $product_draft->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                                            </div>
                                                            <div class="action-2">
                                                                <div class="align-items-center mr-2">
                                                                    <form action="{{url('draft-make-complete')}}" method="post">
                                                                        @csrf
                                                                        <input  type="hidden" name="catalogue_id" value="{{$product_draft->id ?? ''}}">
                                                                        <button class="del-pub publish-btn" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Complete"><i class="fa fa-upload" aria-hidden="true"></i> </button>
                                                                    </form>
                                                                </div>
                                                                <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                                                <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$product_draft->id ?? '')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                                <div class="align-items-center">
                                                                    <form action="{{route('product-draft.destroy',$product_draft->id ?? '')}}" method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('catalogue');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Add terms catalogue modal --}}
                                                <div id="add-terms-catalog-modal-{{ $product_draft->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                                                    <div class="cat-header add-terms-catalog-modal-header">
                                                        <div>
                                                            <label id="label_name" class="cat-label">Add terms to catalogue({{ $product_draft->id }})</label>
                                                        </div>
                                                        <div class="cursor-pointer" onclick="trashClick(this)">
                                                            <i class="fa fa-close" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                    <div class="cat-body add-terms-catalog-body">
                                                        <form role="form" class="vendor-form mobile-responsive" action= {{url('save-additional-terms-draft')}} method="post">
                                                            @csrf

                                                            <div class="form-group row">
                                                                <div class="col-md-12">
                                                                    <label for="low_quantity" class="col-md-form-label required mb-1">Catalogue ID</label>
                                                                    <input type="text" class="form-control" name="product_draft_id" value="{{$product_draft->id ? $product_draft->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                                                </div>
                                                            </div>

                                                            <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $product_draft->id }}">
                                                                <div class="col-md-10">
                                                                    <p class="font-18 required_attributes"> Select variation from below attributes </p>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row pb-4">
                                                                <div class="col-md-12 text-center">
                                                                    <button type="submit" class="btn btn-primary draft-pro-btn waves-effect waves-light termsCatalogueBtn" style="margin-top:0px;">
                                                                        <b> Add </b>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                {{--End Add terms catalogue modal --}}

                                            </td>
                                        </tr>
                                        <tr>
                                            <td  colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                                <div class="accordian-body collapse" id="demo{{$product_draft->id ?? ''}}">

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <!--End table body-->
                                </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$product_drafts->total() ?? 0}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->first_page_url ?? '#'}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$product_drafts_info->prev_page_url ?? '#'}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$product_drafts_info->current_page ?? 0}} of <span class="total-pages">{{$product_drafts_info->last_page ?? 0}}</span></span>
                                                    </span>
                                                    @if($product_drafts->currentPage() !== $product_drafts->lastPage())
                                                    <a class="next-page btn" href="{{$product_drafts_info->next_page_url ?? '#'}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$product_drafts_info->last_page_url ?? '#'}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
        var searchPriority = 0;
        var skip = 0;
        var take = 10;
        var ids = [0];
        function changeQuantity(id){
            var id_split = id.split('_');
            var variation_id = id_split[0]
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input.c_quantity_'+variation_id).attr('id','c_quantity_'+id);
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' button').attr('id',id);
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' span').attr('id',id);
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id).slideToggle();
        }

        function changeQuantityDiv(var_id){
            var full_id = $('#myModal'+var_id+' .change_quantity_div'+var_id).find('button').attr('id');
            var id = full_id.split('_');
            var variation_id = id[0];
            var product_shelf_id = id[1];
            var quantity = $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input#c_quantity_'+full_id).val();
            if(quantity == ''){
                alert('Please give change quantity.');
                return false;
            }
            var reason = $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' textarea#c_reason').val();
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
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' span#'+full_id).addClass('text-success').html('Quantity updated successfully.')
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input#c_quantity_'+full_id).val('');
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' textarea#c_reason').val('');
                    }
                }
            });
        }

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
                    $('tbody').html(response.html);
                    searchPriority = response.search_priority;
                    take = response.take;
                    skip = parseInt(response.skip)+10;
                    ids = ids.concat(response.ids);


                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })

        {{--function catalogue_search(){--}}

        {{--    var name = $('#name').val();--}}

        {{--    if(name == '' ){--}}
        {{--        alert('Please type catalogue name in the search field.');--}}
        {{--        return false;--}}
        {{--    }--}}
        {{--    var category_id = $('#category_id').val();--}}
        {{--    var status = $('#status').val();--}}
        {{--    $.ajax({--}}
        {{--        type: 'POST',--}}
        {{--        url: '{{url('/search-product-list').'?_token='.csrf_token()}}',--}}
        {{--        data: {--}}
        {{--            "name": name,--}}
        {{--            "status":status,--}}
        {{--            "category_id":category_id,--}}
        {{--            "seeMore" : 0--}}
        {{--        },--}}
        {{--        beforeSend: function(){--}}
        {{--            // Show image container--}}
        {{--            $("#Load").show();--}}
        {{--        },--}}
        {{--        success: function(response){--}}
        {{--            $('tbody').html(response);--}}
        {{--        },--}}
        {{--        complete:function(data){--}}
        {{--            // Hide image container--}}
        {{--            $("#Load").hide();--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        $(document).bind("scroll", function(e){

            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){

                var name = $('#name').val();

                if(name != '' ){
                    $('#ajaxCall').remove();
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
                            'ids': ids
                        },
                        beforeSend: function(){
                            window.stop();
                        },
                        success: function(response){
                            searchPriority = response.search_priority;
                            take = response.take;
                            skip = parseInt(response.skip)+10;
                            $('tbody tr:last').after(response.html);
                            // var div = document.getElementById('table');
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

        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1]
            $.ajax({
                type: "post",
                url: "{{url('get-variation')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "product_draft_id" : id,
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

        $(document).ready(function() {
            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }
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
            $('#selectAll').click(function(){
                $('.checkBoxClass').prop('checked',$(this).prop('checked'));
                var catalogueIds = catalogueIdArray();
            });
            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
                var catalogueIds = catalogueIdArray();
            });
            $('div.bulk-complete-button button').on('click',function (){
                var catalgoueIDs = catalogueIdArray();
                $.ajax({
                    type: "post",
                    url: "{{url('bulk-draft-catalogue-complete')}}",
                    data: {
                        "_token": "{{csrf_token()}}",
                        "catalogueIDs": catalgoueIDs
                    },
                    beforeSend: function (){
                        $('#ajax_loader').show();
                    },
                    success: function (response){
                        if(response == 'success'){
                            catalgoueIDs.forEach(function (item){
                                $('table tr.hide-after-complete-'+item).hide();
                            })
                            swal.fire({
                                title: 'Selected catalogue completed successfully',
                                icon: 'success'
                            });
                        }else{
                            swal.fire({
                                title: 'Something went wrong',
                                icon: 'danger'
                            });
                        }
                        $('#ajax_loader').hide();
                    }
                });
            });

            $('a.master-catalogue-bulk-delete').click(function(){
                var masterCatalogueIds = catalogueIdArray()

                if(masterCatalogueIds.length == 0){
                    Swal.fire('Oops..','Please select atleast one product','warning')
                    return false
                }
                Swal.fire({
                    title: 'Are you sure to delete this ?',
                    text: 'If delete, all associated variation will also be deleted',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButttonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    showLoaderOnConfirm: true,
                    preConfirm:function(){
                        return new Promise(function(resolve){
                            $.ajax({
                                type: 'post',
                                url: "{{url('master-catalgue-bulk-delete')}}",
                                data: {
                                    "_token": "{{csrf_token()}}",
                                    "masterCatalogueIds": masterCatalogueIds
                                }
                            })
                            .done(function(response){

                                if(response.type == 'success'){
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

        function catalogueIdArray(){
            var catalogueIds= []
            $('table tbody tr td :checkbox:checked').each(function(i){

                catalogueIds[i] = $(this).val()
            })
            return catalogueIds
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

        function priceQuantityUpdate(ids) {
            var edit_type = ids.split('/');
            var var_id = edit_type[0];
            var field = edit_type[1];
            var variation_ids = [];
            variation_ids.push(var_id);
            // var input_value = $(this).closest('div').find('.input-text').val();
            // var input_field = $(this).closest('div').find('.input-field').val();
            var input_value = $('.input-text-'+field+var_id).val();
            var input_field = $('.input-field-'+field+var_id).val();
            if (input_value == '') {
                alert('Please give input value');
                return false;
            } else if (variation_ids.length == 0) {
                alert('Please select product');
                return false;
            }
            $.ajax({
                type: "post",
                url: "{{url('variation-price-bulk-update')}}",
                data: {
                    "_token": "{{csrf_token()}}",
                    "input_value": input_value,
                    "input_field": input_field,
                    "variation_ids": variation_ids
                },
                beforeSend: function () {
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function (response) {
                    if (response.msg == 'success') {
                        $.each(variation_ids, function (index, value) {
                            $('#' + input_field + '_' + value).text(input_value);
                        });
                        $('span.screen-option').html('Updated successfully').addClass('text-success');
                    } else {
                        $('span.screen-option').html(response.msg).addClass('text-danger');
                    }
                },
                complete: function (data) {
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
        }




        // Check uncheck product draft counter
        const countCheckedAll = function() {
            let countProductDraft = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( countProductDraft + " draft product selected!" );
            console.log(countProductDraft + ' draft product selected!');
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
        });
        //End check uncheck product draft counter


        function addTermsCatalog(id, e){
            $.ajax({
                type: "GET",
                url: '{{ url('add-additional-terms-draft-') }}'+id,
                data: {
                    "_token": "{{csrf_token()}}",
                    "id": id
                },
                beforeSend: function(){
                    $('div#sortableAttribute').remove()
                    $('#product_variation_loading'+id).show()
                },
                success: function(response){
                    // console.log(response.addCatalogTermsModal)
                    $('div#add-terms-catalog-modal-'+id).show()
                    $("#add-terms-tocatalog-modal-data-"+id).after(response.addCatalogTermsModal)
                    $('.selected_value').select2()
                    $('.variation-term-select2').select2()
                    $('div.attribute-terms-container').first().addClass('m-t-20')
                    $(e).closest('tr').css('background-color','#F7F635 !important')
                    $(e).find('a.add-terms-catalogue-btn').css('border', '2px solid yellow')
                },
                complete: function(){
                    $('#product_variation_loading'+id).hide();
                }
            })
        }

        function trashClick(e){
            $(e).closest('div.add-terms-to-catalog-modal').hide()
            $(e).closest('tr').css('background-color', '#fafafa')
            $(e).closest('div.add-terms-to-catalog-modal').prev('div.dropup').find('a.add-terms-catalogue-btn').css('border', 'inherit')
        }



         //Modal button variation terms adding spining btn
         $('button.termsCatalogueBtn').click(function(){
            $(this).html(
                `<span class="mr-2"><i class="fa fa-spinner fa-spin"></i></span>Variation adding`
            );
            $(this).addClass('changeCatalogBTnCss');
        })

        $(document).ready(function(){
            var successMessage = $('#success_message').text()
            var successProductDraftId = $('#success-product-draft-id').text()
            if(successMessage == 'New variation terms added successfully' && successProductDraftId){
                Swal.fire({
                    icon: 'success',
                    title: 'New variation terms added successfully('+successProductDraftId+')!'
                })
            }
        })


    </script>
@endsection
