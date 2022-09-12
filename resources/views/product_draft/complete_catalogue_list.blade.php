@extends('master')

@section('title')
    Active Catalogue | WMS360
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
                            <div class="col-lg-4 col-md-8">
                                <form action="{{URL::to('download-product-csv')}}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center">
                                        <div style="width: 100%">
                                            <input type="text" name="catalogue_id"  class="form-control" placeholder="Catalogue ID Example: 7821,98214,54878" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-default">Download CSV</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <hr class="mt-3" style="border-color: #48a3cc">

                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <div class="row content-inner mt-2 mb-2">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['image']) && $setting['catalogue']['active_catalogue']['image'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['image']) && $setting['catalogue']['active_catalogue']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['id']) && $setting['catalogue']['active_catalogue']['id'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['id']) && $setting['catalogue']['active_catalogue']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['channel']) && $setting['catalogue']['active_catalogue']['channel'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['channel']) && $setting['catalogue']['active_catalogue']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-type" class="onoffswitch-checkbox" id="product-type" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['product-type']) && $setting['catalogue']['active_catalogue']['product-type'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['product-type']) && $setting['catalogue']['active_catalogue']['product-type'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-type">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Type</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['catalogue-name']) && $setting['catalogue']['active_catalogue']['catalogue-name'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['catalogue-name']) && $setting['catalogue']['active_catalogue']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['category']) && $setting['catalogue']['active_catalogue']['category'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['category']) && $setting['catalogue']['active_catalogue']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2 mt-xs-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="rrp" class="onoffswitch-checkbox" id="rrp" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['rrp']) && $setting['catalogue']['active_catalogue']['rrp'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['rrp']) && $setting['catalogue']['active_catalogue']['rrp'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="rrp">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>RRP</p></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="base_price" class="onoffswitch-checkbox" id="base_price" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['base_price']) && $setting['catalogue']['active_catalogue']['base_price'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['base_price']) && $setting['catalogue']['active_catalogue']['base_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="base_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Base Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['sold']) && $setting['catalogue']['active_catalogue']['sold'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['sold']) && $setting['catalogue']['active_catalogue']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['stock']) && $setting['catalogue']['active_catalogue']['stock'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['stock']) && $setting['catalogue']['active_catalogue']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-sm-10 mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['product']) && $setting['catalogue']['active_catalogue']['product'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['product']) && $setting['catalogue']['active_catalogue']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['creator']) && $setting['catalogue']['active_catalogue']['creator'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['creator']) && $setting['catalogue']['active_catalogue']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['modifier']) && $setting['catalogue']['active_catalogue']['modifier'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['modifier']) && $setting['catalogue']['active_catalogue']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['sku']) && $setting['catalogue']['active_catalogue']['sku'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['sku']) && $setting['catalogue']['active_catalogue']['sku'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['qr']) && $setting['catalogue']['active_catalogue']['qr'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['qr']) && $setting['catalogue']['active_catalogue']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['variation']) && $setting['catalogue']['active_catalogue']['variation'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['variation']) && $setting['catalogue']['active_catalogue']['variation'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="variation">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Variation</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['ean']) && $setting['catalogue']['active_catalogue']['ean'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['ean']) && $setting['catalogue']['active_catalogue']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['regular-price']) && $setting['catalogue']['active_catalogue']['regular-price'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['regular-price']) && $setting['catalogue']['active_catalogue']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['sales-price']) && $setting['catalogue']['active_catalogue']['sales-price'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['sales-price']) && $setting['catalogue']['active_catalogue']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['available-qty']) && $setting['catalogue']['active_catalogue']['available-qty'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['available-qty']) && $setting['catalogue']['active_catalogue']['available-qty'] == 0) @else checked @endif>
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
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['catalogue']['active_catalogue']['shelf-qty']) && $setting['catalogue']['active_catalogue']['shelf-qty'] == 1) checked @elseif(isset($setting['catalogue']['active_catalogue']['shelf-qty']) && $setting['catalogue']['active_catalogue']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="active_catalogue">
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
{{--                                    <input type="hidden" name="status" id="status" value="publish">--}}
{{--                                </div>--}}
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
                            <li class="breadcrumb-item active" aria-current="page">Active Catalogue</li>
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
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">

                                    <div class="draft-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                        @csrf
                                            <div class="p-text-area">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search Catalogue..." required>
                                                <input type="hidden" name="searchFlag" id="name" value="" class="form-control" placeholder="Search Catalogue..." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="catalogue_search();">Search</button>
                                                <input type="hidden" name="status" id="status" value="publish">
                                            </div>

                                        </form>
                                    </div>

                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                    <!-- {{$product_drafts->appends(request()->all())->render()}} -->
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
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$product_drafts_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$product_drafts_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="completed-catalogue-list">
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
                                    <!--End Pagination area-->
                                </div>
                            </div>
                            <!--End table upper side content-->

                            <!--start loader-->
                            {{-- <div id="product_variation_loading" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content id loading...</span>
                                </div>
                            </div> --}}
                            <!--End loader-->

                            <!--Active Catalogue upload csv-->
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
                            <!--End Active Catalogue upload csv-->

                            <!--Active catalaogue Restore and checkbox counter-->
                            <!-- <div class="trash" style="margin-bottom:10px;">
                                <div>
                                @if (URL::current() == url('/trash'))
                                    <a href="{{url('completed-catalogue-list')}}" class="btn btn-primary"  target="_blank" data-toggle="tooltip" data-placement="top" title="Restore Selected"><i class="fas fa-undo-alt"></i></a>
                                @elseif(URL::current() == url('/completed-catalogue-list'))
                                <a href="{{url('trash')}}" class="btn btn-primary"  target="_blank" data-toggle="tooltip" data-placement="top" title="Go to Trash"><i class="fas fa-dumpster"></i></a>
                                @endif
                                </div> -->
                                <!-- <div class="checkbox-count font-16 ml-md-3"></div> -->
                            <!-- </div> -->
                            <!--End active catalaogue Restore and checkbox counter-->

                            <!--Active catalaogue bulk delete and checkbox counter-->
                            @if (URL::current() == url('/trash'))
                            <div class="active-catalogue-bulk-delete" style="display: none;">
                                <div>
                                    <a href="Javascript:void(0)" class="btn btn-primary master-catalogue-bulk-restore">Bulk Restore</a>
                                </div>
                                <div class="checkbox-count font-16 ml-md-3"></div>
                            </div>
                            @else
                            <div class="active-catalogue-bulk-delete" style="display: none;">
                                <div>
                                    <a href="Javascript:void(0)" class="btn btn-primary master-catalogue-bulk-delete">Bulk Delete</a>
                                </div>
                                <div class="checkbox-count font-16 ml-md-3"></div>
                            </div>
                            @endif
                            <!--End active catalaogue bulk delete and checkbox counter-->

                            <!--Start Table-->
                            <table class="draft_search_result product-draft-table w-100 ">
                                <!--start table head-->
                                <thead style="background-color: {{$setting->master_publish_catalogue->table_header_color ?? '#c5bdbd'}}; color: {{$setting->master_publish_catalogue->table_header_text_color ?? '#292424'}}">
                                <form action="{{url('all-column-search')}}" method="post" id="reset-column-data">
                                @csrf
                                <input type="hidden" name="search_route" value="completed-catalogue-list">
                                <input type="hidden" name="status" value="publish">
                                <tr>
                                    <th class="master-catalogue-checkbox" style="width: 3%"><input type="checkbox" name="multiple-checkbox" class="selectAllCheckbox ckbCheckAll"></th>
                                    <th class="image" style="width: 6%; text-align: center !important;">Image</th>
                                    <th class="id" style="width: 6%; text-align: center !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="catalogue_id" id="catalogueId" value="{{$allCondition['catalogue_id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="catalogue_opt_out" type="checkbox" name="catalogue_opt_out" value="1" @isset($allCondition['catalogue_opt_out']) checked @endisset><label for="catalogue_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="id">
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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

                                    <th class="channel" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['channel'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                        <select class="form-control b-r-0 select2" name="channel[]" id="channels" multiple>

                                                            @foreach($channels as $key=> $channel)
                                                                @if($key == "ebay")
                                                                    @if (Session::get('ebay') == 1)
                                                                    @foreach($channel as $key => $ebay)
                                                                        @if(isset($allCondition['channel']))
                                                                        @php
                                                                            $existEbayChannel = null;
                                                                        @endphp
                                                                            @foreach($allCondition['channel'] as $ch)
                                                                                @if($ebay == $ch)
                                                                                    <option value="{{$ebay}}" selected>{{$ebay}}</option>
                                                                                    @php
                                                                                        $existEbayChannel = 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                            @if($existEbayChannel == null)
                                                                                <option value="{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @else
                                                                            <option value="{{$ebay}}">{{$ebay}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @endif
                                                                @else
                                                                    @if ((($key == 'woocommerce') && (Session::get('woocommerce') == 1)) || (($key == 'onbuy') && (Session::get('onbuy') == 1)))
                                                                    @if(isset($allCondition['channel']))
                                                                        @php
                                                                            $existNotEbayChannel = null;
                                                                        @endphp
                                                                        @foreach($allCondition['channel'] as $ch)
                                                                            @if($channel == $ch)
                                                                                <option value="{{$key}}" selected>{{$channel}}</option>
                                                                                @php
                                                                                    $existNotEbayChannel = 1;
                                                                                @endphp
                                                                            @endif
                                                                        @endforeach
                                                                        @if($existNotEbayChannel == null)
                                                                            <option value="{{$key}}">{{$channel}}</option>
                                                                        @endif
                                                                    @else
                                                                        <option value="{{$key}}">{{$channel}}</option>
                                                                    @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="channel_opt_out" type="checkbox" name="channel_opt_out" value="1" @isset($allCondition['channel_opt_out']) checked @endisset><label for="channel_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="channel">
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['channel']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="channel" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Channel</div>
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
                                                        <input type="hidden" name="status" value="publish"> -->
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

                                    <th class="category" style="width: 10%">
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
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="category_opt_out" type="checkbox" name="category_opt_out" value="1" @isset($allCondition['category_opt_out']) checked @endisset><label for="category_opt_out">Opt Out</label>
                                                        </div>
                                                        <!-- <input type="hidden" name="column_name" value="woowms_category">
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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

                                    <th class="sold filter-symbol" style="width: 10% !important;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
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
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
                                                        @if(isset($allCondition['sold']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="sold" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                            </div>
                                            <div>Sold</div>
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
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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

                                    <th class="creator filter-symbol" style="width: 8% !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['creator'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="creator" id="catalogueCreator">
                                                            @isset($users)
                                                                @if($users->count() == 1)
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
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
                                                        <!-- <input type="hidden" name="column_name" value="creator">
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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
                                    <th class="modifier filter-symbol" style="width: 8% !important;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['modifier'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="modifier" id="catalogueModifier">
                                                            @isset($users)
                                                                @if($users->count() == 1)
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{$user->name}}</option>
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
                                                        <!-- <input type="hidden" name="column_name" value="modifier_id">
                                                        <input type="hidden" name="route_name" value="product-draft">
                                                        <input type="hidden" name="status" value="publish"> -->
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
                                <tbody id="search_reasult" class="scrollbar-lg">
                                @isset($product_drafts)
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
{{--                                @if(count($product_drafts) == 0)--}}
{{--                                    @php--}}
{{--                                        echo $searchValueNullMessage;--}}
{{--                                    @endphp--}}
{{--                                @else--}}
{{--                                    <h1>not empty</h1>--}}
{{--                                @endif--}}
                                @foreach($product_drafts as $key=> $product_draft)

                                    <tr class="variation_load_tr">
                                        <td style="width: 3%"><input type="checkbox" name="catalgueCheckbox" class="catalogueCheckbox checkBoxClass" value="{{$product_draft->id}}"></td>
                                        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;"  data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$product_draft->id}}" class="variation_load" style="display: none;"></div>
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
{{--                                        <td class="id" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->id}}</td>--}}
                                        <td class="id" style="width: 7%; text-align: center !important">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_draft->id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="channel" style="width: 10%, text-align: center !important">
                                        @if (Session::get('ebay') == 1)

                                            @if(isset($product_draft->ebayCatalogueInfo[0]))
                                                <div class="row mb-2">
                                                    @foreach($product_draft->ebayCatalogueInfo as $catalogueInfo)
                                                        @if($catalogueInfo->AccountInfo->account_name)
                                                            <div class="col-md-4 mb-1">
                                                                <a title="eBay({{$catalogueInfo->AccountInfo->account_name}})" href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" target="_blank">
                                                                    @if($catalogueInfo->product_status == "Active")
                                                                        @if(isset($catalogueInfo->AccountInfo->logo))
                                                                        <img style="height: 30px; width: 30px;" src="{{$catalogueInfo->AccountInfo->logo}}">
                                                                        @else

                                                                            <span class="account_trim_name">
                                                                                @php
                                                                                    $ac = $catalogueInfo->AccountInfo->account_name;
                                                                                    echo implode('', array_map(function($name)
                                                                                    { return $name[0];
                                                                                    },
                                                                                    explode(' ', $ac)));
                                                                                @endphp
                                                                            </span>

                                                                        @endif
{{--                                                                    @elseif($catalogueInfo->product_status == "Completed")--}}
{{--                                                                        @if($product_draft->ProductVariations[0]->stock == 0)--}}
{{--                                                                            @if(isset($catalogueInfo->AccountInfo->logo))--}}
{{--                                                                                <img style="height: 30px; width: 30px;" src="{{$catalogueInfo->AccountInfo->logo}}">--}}
{{--                                                                            @else--}}

{{--                                                                                <span class="account_trim_name">--}}
{{--                                                                                @php--}}
{{--                                                                                    $ac = $catalogueInfo->AccountInfo->account_name;--}}
{{--                                                                                    echo implode('', array_map(function($name)--}}
{{--                                                                                    { return $name[0];--}}
{{--                                                                                    },--}}
{{--                                                                                    explode(' ', $ac)));--}}
{{--                                                                                @endphp--}}
{{--                                                                            </span>--}}
{{--                                                                            @endif--}}
{{--                                                                        @endif--}}
                                                                    @endif

                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                            <div class="row">
                                            @if (Session::get('woocommerce') == 1)
                                                @isset($product_draft->woocommerce_catalogue_info)
                                                    <div class="col-md-4 mr-1">
                                                        <a title="WooCommerce" href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$product_draft->woocommerce_catalogue_info->id.'&action=edit'}}" class="form-group" target="_blank"><img style="height: auto; width: 40px;" src="https://www.pngitem.com/pimgs/m/533-5339688_icons-for-work-experience-png-download-logo-woocommerce.png"></a>
                                                    </div>
                                                @endisset
                                            @endif
                                            @if (Session::get('onbuy') == 1)
                                                @isset($product_draft->onbuy_product_info)
                                                    <div class="col-md-4">
                                                        <a title="OnBuy" href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$product_draft->onbuy_product_info->product_id.'/'}}" class="" target="_blank"><img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg"></a>
                                                    </div>
                                                @endisset
                                            @endif
                                            @if (Session::get('amazon') == 1)
                                                @isset($product_draft->amazonCatalogueInfo)
                                                    @foreach($product_draft->amazonCatalogueInfo as $amazon)
                                                        <div class="col-md-4">
                                                            <a title="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})" href="{{asset('/').$amazon->applicationInfo->accountInfo->account_logo}}" class="form-group" target="_blank">
                                                                <img style="height: 30px; width: 30px;" src="{{$amazon->applicationInfo->accountInfo->account_logo ? asset('/').$amazon->applicationInfo->accountInfo->account_logo : asset('/').$amazon->applicationInfo->application_logo}}" alt="{{$amazon->applicationInfo->accountInfo->account_name ?? ''}} ({{$amazon->applicationInfo->marketPlace->marketplace ?? ''}})">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endisset
                                            @endif
                                            @isset($product_draft->shopifyCatalogueInfo)
                                                    @foreach($product_draft->shopifyCatalogueInfo as $shopify)

                                                        {{-- <h6>{{ $shopify->shopifyUserInfo->account_name ?? '' }}</h6> --}}
                                                        <div class="col-md-4">
                                                            <a title="{{$shopify->shopifyUserInfo->account_name ?? ''}} ({{$shopify->shopifyUserInfo->account_name ?? ''}})" href="{{ $shopify->shopifyUserInfo->shop_url ?? '' }}" class="form-group" target="_blank">
                                                                <img style="height: 30px; width: 30px; margin:10px;" src="{{$shopify->shopifyUserInfo->account_logo ?? ''}}" alt="{{$shopify->shopifyUserInfo->account_name ?? ''}} ({{$shopify->shopifyUserInfo->account_name ?? ''}})">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </td>
                                        <td class="product-type" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            <div style="text-align: center;">
                                                @if($product_draft->type == 'simple')
                                                    Simple
                                                @else
                                                    Variation
                                                @endif
                                            </div>


                                        </td>
                                        <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            <a class="catalogue-link" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                <!-- {{ Str::limit($product_draft->name,60, $end = '...') }} -->
                                                {{$product_draft->name}}
                                            </a>
                                        </td>
                                        <td class="category" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{json_decode($product_draft)->woo_wms_category->category_name ?? ''}}</td>
                                        @php
                                            $data = 0;
                                            if(count($product_draft->variations) > 0){
                                                foreach ($product_draft->variations as $variation){
                                                    if(isset($variation->order_products) && (count($variation->order_products) > 0)){
                                                        foreach($variation->order_products as $product){
                                                            $data += $product->sold;
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <td class="rrp" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->rrp ?? ''}}</td>
                                        <td class="base_price" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->base_price ?? ''}}</td>
                                        <td class="sold" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$data ?? 0}}</td>
                                        <td class="stock" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->ProductVariations[0]->stock ?? 0}}</td>
                                        <td class="product" style="width: 10% !important; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">{{$product_draft->product_variations_count ?? 0}}</td>
                                        <td class="creator" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            @if(isset($product_draft->user_info->name))
                                                <div class="wms-name-creator">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
    {{--                                                <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                        <strong class="@if($product_draft->user_info->deleted_at)text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="width: 8% !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$product_draft->id}}" onclick="getVariation(this)" data-target="#demo{{$product_draft->id}}" class="accordion-toggle">
                                            @if(isset($product_draft->modifier_info->name))
                                                <div class="wms-name-modifier1">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->updated_at))}}">
{{--                                                    <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                        <strong class="@if($product_draft->modifier_info->deleted_at) text-danger @else text-success @endif">{{$product_draft->modifier_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @elseif(isset($product_draft->user_info->name))
                                                <div class="wms-name-modifier2">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($product_draft->created_at))}}">
{{--                                                    <div data-tip="{{$product_draft->created_at->diffForHumans()}}">--}}
                                                        <strong class="@if($product_draft->user_info->deleted_at)text-danger @else text-success @endif">{{$product_draft->user_info->name ?? ''}}</strong>
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
{{--                                                            <div class="align-items-center mr-2" data-toggle="tooltip" data-placement="top" title="Channel Listing"><a class="btn-size channel-listing-view-btn" href="#" data-toggle="modal" target="_blank" data-target="#channelListing{{$product_draft->id ?? ''}}"><i class="fas fa-atom" aria-hidden="true"></i></a></div>--}}
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size print-btn" href="{{url('print-bulk-barcode/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></div>
                                                            @if (Session::get('onbuy') == 1)
                                                            @if(!isset($product_draft->onbuy_product_info->id))
                                                                @if($product_draft->product_variations_count != 0)
                                                                    <div class="align-items-center mr-2"> <a class="btn-size list-onbuy-btn" href="{{url('onbuy/create-product/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>
                                                                @endif
                                                            @endif
                                                            @endif
                                                            <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$product_draft->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fas fa-chart-bar" aria-hidden="true"></i></a></div>
                                                            {{-- <div class="align-items-center"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                                            <div class="align-items-center" onclick="addTermsCatalog({{ $product_draft->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
                                                        </div>
                                                        <div class="action-2">
                                                            @if (Session::get('woocommerce') == 1)
                                                            @if(!isset($product_draft->woocommerce_catalogue_info->master_catalogue_id))
                                                                @if($product_draft->product_variations_count != 0)
                                                                    <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('woocommerce/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Woocommerce"><i class="fab fa-wordpress" aria-hidden="true"></i></a></div>
                                                                @endif
                                                            @endif
                                                            @endif
                                                            @if (Session::get('shopify') == 1)
                                                            @if($product_draft->product_variations_count != 0)
                                                                    <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('shopify/catalogue/create/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Shopify"><i class="fab fa-shopify" aria-hidden="true"></i></a></div>
                                                            @endif
                                                            @endif
                                                            <div class="align-items-center mr-2"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>
                                                            <div class="align-items-center mr-2"> <a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>
                                                            @if (Session::get('ebay') == 1)
                                                            @if($product_draft->product_variations_count != 0)
                                                                <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" href="{{url('create-ebay-product/'.$product_draft->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List on eBay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                                            @endif
                                                            @endif
                                                            <div class="align-items-center">
                                                                <form action="{{route('product-draft.destroy',$product_draft->id)}}" method="post" id="catalogueDelete{{$product_draft->id}}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteConfirmationMessage('catalogue','catalogueDelete{{$product_draft->id}}');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--End dropup content-->
                                            </div>
                                            <!--End manage button area-->

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

                                    <!--start hidden row-->
                                    <tr>
                                        <td  colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$product_draft->id}}">


                                            </div>
                                        </td>
                                    </tr>
                                    <!--hidden row -->

                                    <!-- channel listing modal -->
                                    <div class="modal fade" id="channelListing{{$product_draft->id ?? ''}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Channel Listing</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @isset($product_draft->woocommerce_catalogue_info)
                                                <div>
                                                    <h5>Website </h5>
                                                    <a href="{{$woocommerceSiteUrl->site_url.'wp-admin/post.php?post='.$product_draft->woocommerce_catalogue_info->id.'&action=edit'}}" class="btn btn-outline-secondary btn-sm ml-2" target="_blank">View On Website Admin</a>
                                                </div>
                                                @endisset
                                                @if(isset($product_draft->ebayCatalogueInfo[0]))
                                                <div>
                                                    <h5>eBay </h5>
                                                    @foreach($product_draft->ebayCatalogueInfo as $catalogueInfo)
                                                    <div class="mb-2">
                                                        <span>{{$catalogueInfo->AccountInfo->account_name}}</span>
                                                        <a href="{{'https://www.ebay.co.uk/itm/'.$catalogueInfo->item_id}}" class="btn btn-outline-warning btn-xs ml-2" target="_blank">View On eBay</a><br>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                @isset($product_draft->onbuy_product_info)
                                                <div>
                                                    <h5>OnBuy</h5>
                                                    <a href="{{'https://seller.onbuy.com/inventory/edit-product-basic-details/'.$product_draft->onbuy_product_info->product_id.'/'}}" class="btn btn-outline-info btn-sm ml-2" target="_blank">View On OnBuy Admin</a>
                                                </div>
                                                @endisset
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>


                                @endforeach
                            @endisset
                                </tbody>
                                <!--End table body-->

                            </table>
                            <!--End Table-->

                        <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                    <div id="seeMoreVisibility">
                                        <form action="Javascript:void(0);" method="post">
                                        @csrf
                                            <div class="p-text-area">
                                                <input type="hidden" name="seeMore" id="seeMore" value="{{$see_more ?? ''}}" class="form-control" placeholder="Search Catalogue..." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn btn btn-default waves-effect waves-light" type="submit" onclick="seeMoreButton();">See More</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$product_drafts->total() ?? ''}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($product_drafts->currentPage() > 1)
                                                    <a class="first-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->first_page_url.$url : $product_drafts_info->first_page_url}}}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$product_drafts->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $product_drafts_info->prev_page_url.$url : $product_drafts_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
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
                <!--Card box start-->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->


    <script type="text/javascript">

        // $(".js-select2").select2({
        //     closeOnSelect : false,
        //     placeholder : "Placeholder",
            // allowHtml: true,
        //     allowClear: true,
        //     tags: true // создает новые опции на лету
        // });

        $(".select2").select2();

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

                    $("#ajax_loader").show();
                },
                success: function(response){
                    // console.log(response.ids);
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
                            // if (response.ids.length === 0) {
                            //     $(document).ready(function() {
                            //         Swal.fire(
                            //             'No result found',
                            //             '',
                            //             'info'
                            //         )
                            //     });
                            // }
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


        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var id = product_draft_id[1]
            var searchKeyword = $('input#name').val();


            $.ajax({
                type: "post",
                url: "<?php echo e(url('get-variation')); ?>",
                data: {
                    "_token" : "<?php echo e(csrf_token()); ?>",
                    "product_draft_id" : id,
                    "searchKeyword" : searchKeyword

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

                    $('#demo'+id).html(response);
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }


        function changeQuantity(id){
            // $('button.change_quantity').on('click',function () {
            // var id = $(this).attr('id');

            var id_split = id.split('_');
            var variation_id = id_split[0]
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input.c_quantity_'+variation_id).attr('id','c_quantity_'+id);
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' button').attr('id',id);
            $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' span').attr('id',id);

            $('#myModal'+variation_id+' .change_quantity_div'+variation_id).slideToggle();
            // });
        }

        function changeQuantityDiv(var_id){
            // $('.change_quantity_div button').on('click',function () {
            var full_id = $('#myModal'+var_id+' .change_quantity_div'+var_id).find('button').attr('id');
            var id = full_id.split('_');
            var variation_id = id[0];
            var product_shelf_id = id[1];
            var quantity = $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input#c_quantity_'+full_id).val();
            var reason = $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' select.c_reason_'+variation_id).val();

            if(quantity == ''){
                alert('Please give change quantity.');
                return false;
            }
            if(reason == ''){
                alert('Please select a reason');
                return false;
            }
            // var reason = $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' textarea#c_reason').val();


            $.ajax({
                type: "POST",
                url: "<?php echo e(url('shelf_quantity_update')); ?>",
                data: {
                    "_token" : "<?php echo e(csrf_token()); ?>",
                    "product_shelf_id" : product_shelf_id,
                    "quantity" : quantity,
                    "reason" : reason
                },
                success: function (response) {
                    if(response.data == true){

                        $('.qnty_'+full_id).text(quantity);
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' span#'+full_id).addClass('text-success').html('Quantity updated successfully.')
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' input#c_quantity_'+full_id).val('');
                        $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' select.c_reason_'+variation_id).val('');
                        // $('#myModal'+variation_id+' .change_quantity_div'+variation_id+' textarea#c_reason').val('');
                    }
                }
            });
            // });
        }



        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();
            document.getElementById("seeMoreVisibility").style.visibility = "hidden";
            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }

                var status = $('#status').val();
                $.ajax({
                    type: "post",
                    url: "<?php echo e(url('search-catalogue-by-date')); ?>",
                    data: {
                        "_token" : "<?php echo e(csrf_token()); ?>",
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

            $('div.bulk-action-btn-group button.btn').click(function(){
                $('div.bulk-action-btn-group button.check-active').removeClass('btn-active');
                $(this).addClass('btn-active');
            });

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


        function priceQuantityUpdate(ids) {
            // $('form button').click(function(){
            // var edit_type = $(this).attr('id');
            var edit_type = ids.split('/');
            var var_id = edit_type[0];
            var field = edit_type[1];
            var variation_ids = [];
            variation_ids.push(var_id);
            // var input_value = $(this).closest('div').find('.input-text').val();
            // var input_field = $(this).closest('div').find('.input-field').val();
            var input_value = $('.input-text-'+field+var_id).val();
            var input_field = $('.input-field-'+field+var_id).val();

            // return false;

            if (input_value == '') {
                alert('Please give input value');
                return false;
            } else if (variation_ids.length == 0) {
                alert('Please select product');
                return false;
            }
            $.ajax({
                type: "post",
                url: "<?php echo e(url('variation-price-bulk-update')); ?>",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
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
            // });
        }


        // Sweetalert

        $(document).ready(function(){
            $('.selectAllCheckbox').click(function(){
                $('.catalogueCheckbox').prop('checked',$(this).prop('checked'))
                var masterCatalgueIds = catalogueIdArray()
            })
            $('.catalogueCheckbox').change(function(){
                if (!$(this).prop("checked")){
                    $(".selectAllCheckbox").prop("checked",false);
                }
                var masterCatalogueIds = catalogueIdArray()
            })

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
                    concelButtonColor: '#d33',
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
        })
        //bulk restore function
        $(document).ready(function(){
            $('.selectAllCheckbox').click(function(){
                $('.catalogueCheckbox').prop('checked',$(this).prop('checked'))
                var masterCatalgueIds = catalogueIdArray()
            })
            $('.catalogueCheckbox').change(function(){
                if (!$(this).prop("checked")){
                    $(".selectAllCheckbox").prop("checked",false);
                }
                var masterCatalogueIds = catalogueIdArray()
            })

            $('a.master-catalogue-bulk-restore').click(function(){
                var masterCatalogueIds = catalogueIdArray()
                console.log(masterCatalogueIds);

                if(masterCatalogueIds.length == 0){
                    Swal.fire('Oops..','Please select atleast one product','warning')
                    return false
                }
                Swal.fire({
                    title: 'Are you sure to restore that ?',
                    text: 'If delete, all associated variation will also be deleted',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButttonColor: '#3085d6',
                    concelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    showLoaderOnConfirm: true,
                    preConfirm:function(){
                        return new Promise(function(resolve){
                            $.ajax({
                                type: 'post',
                                url: "{{url('master-catalgue-bulk-restore')}}",
                                data: {
                                    "_token": "{{csrf_token()}}",
                                    "masterCatalogueIds": masterCatalogueIds
                                }
                            })
                            .done(function(response){
                                console.log(response);
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
        })

        function catalogueIdArray(){
            var catalogueIds= []
            $('table tbody tr td :checkbox:checked').each(function(i){

                catalogueIds[i] = $(this).val()
            })
            return catalogueIds
        }

        // Check uncheck active catalogue counter
        const countCheckedAll = function() {
            let countActiveCatalogue = $(".checkBoxClass:checked").length;
            $(".checkbox-count").html( countActiveCatalogue + " active catalogue selected!" );
            console.log(countActiveCatalogue + ' active catalogue selected!');
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
            $('.ckbCheckAll, .checkBoxClass').click(function () {
                if($('.ckbCheckAll:checked, .checkBoxClass:checked').length > 0) {
                    $('div.active-catalogue-bulk-delete').show(500);
                }else{
                    $('div.active-catalogue-bulk-delete').hide(500);
                }
            })
        });
        //End Check uncheck active catalogue counter

        //getSavedValue("channels");
        // document.getElementById("catalogueId").value = getSavedValue("catalogueId");
        // //document.getElementById("catalogue_opt_out").value = getSavedValue("catalogue_opt_out");
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
        function saveValue(e){
            var id = e.id;  // get the sender's id to save it .
            var val = e.value; // get the value.
            if(id == 'channels'){
                console.log($("#channels").val())
                // var channels = localStorage.channels ? JSON.parse(localStorage.channels) : [];
                localStorage.setItem(id, (JSON.stringify($("#channels").val())))
            }

            // console.log(e.value)
             localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override .
        }
        function getSavedValue(v){
            if (!localStorage.getItem(v)) {
                return "";// You can change this to your defualt value.
            }
            if(id == 'channels'){
                var channel = JSON.parse(localStorage.getItem(v))
                $("#channels > option").each(function() {
                    var selectText = this.text
                    channel.forEach((item, index) => {
                        console.log(item)
                        console.log('*****')
                        console.log(selectText)
                        if(selectText == item){
                            $('#channels option:contains('+selectText+')').attr('selected', 'selected');
                        }
                    })
                });
                return false
            }
            return localStorage.getItem(v);
        }


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
