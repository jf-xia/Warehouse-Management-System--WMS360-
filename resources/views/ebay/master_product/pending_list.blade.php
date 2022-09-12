
@extends('master')

@section('title')
    {{$page_title}}
@endsection


@section('content')
    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid table-responsive">


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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['image']) && $setting['ebay']['ebay_pending_product']['image'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['image']) && $setting['ebay']['ebay_pending_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['id']) && $setting['ebay']['ebay_pending_product']['id'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['id']) && $setting['ebay']['ebay_pending_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-type" class="onoffswitch-checkbox" id="product-type" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['product-type']) && $setting['ebay']['ebay_pending_product']['product-type'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['product-type']) && $setting['ebay']['ebay_pending_product']['product-type'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-type">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Type</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['catalogue-name']) && $setting['ebay']['ebay_pending_product']['catalogue-name'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['catalogue-name']) && $setting['ebay']['ebay_pending_product']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['category']) && $setting['ebay']['ebay_pending_product']['category'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['category']) && $setting['ebay']['ebay_pending_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['status']) && $setting['ebay']['ebay_pending_product']['status'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['status']) && $setting['ebay']['ebay_pending_product']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['stock']) && $setting['ebay']['ebay_pending_product']['stock'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['stock']) && $setting['ebay']['ebay_pending_product']['stock'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['product']) && $setting['ebay']['ebay_pending_product']['product'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['product']) && $setting['ebay']['ebay_pending_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['creator']) && $setting['ebay']['ebay_pending_product']['creator'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['creator']) && $setting['ebay']['ebay_pending_product']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['modifier']) && $setting['ebay']['ebay_pending_product']['modifier'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['modifier']) && $setting['ebay']['ebay_pending_product']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['sku']) && $setting['ebay']['ebay_pending_product']['sku'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['sku']) && $setting['ebay']['ebay_pending_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['qr']) && $setting['ebay']['ebay_pending_product']['qr'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['qr']) && $setting['ebay']['ebay_pending_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['variation']) && $setting['ebay']['ebay_pending_product']['variation'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['variation']) && $setting['ebay']['ebay_pending_product']['variation'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['ean']) && $setting['ebay']['ebay_pending_product']['ean'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['ean']) && $setting['ebay']['ebay_pending_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['regular-price']) && $setting['ebay']['ebay_pending_product']['regular-price'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['regular-price']) && $setting['ebay']['ebay_pending_product']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['sales-price']) && $setting['ebay']['ebay_pending_product']['sales-price'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['sales-price']) && $setting['ebay']['ebay_pending_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['sold']) && $setting['ebay']['ebay_pending_product']['sold'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['sold']) && $setting['ebay']['ebay_pending_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['available-qty']) && $setting['ebay']['ebay_pending_product']['available-qty'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['available-qty']) && $setting['ebay']['ebay_pending_product']['available-qty'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['ebay']['ebay_pending_product']['shelf-qty']) && $setting['ebay']['ebay_pending_product']['shelf-qty'] == 1) checked @elseif(isset($setting['ebay']['ebay_pending_product']['shelf-qty']) && $setting['ebay']['ebay_pending_product']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="firstKey" value="ebay">
                            <input type="hidden" id="secondKey" value="ebay_pending_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count, Catalogue search by date and Apply Button Section-->
                            <div class="d-flex justify-content-between align-items-center pagination-content">
                                <div>
                                    <form>
                                        <div><p class="pagination"><b>Pagination</b></p></div>
                                        <ul class="column-display d-flex align-items-center">
                                            <li>Number of items per page</li>
                                            <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                        </ul>
{{--                                        <span class="pagination-mgs-show text-success"></span>--}}
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
{{--                                    <input type="hidden" name="status" id="status" value="publish">--}}
{{--                                </div>--}}
                            </div>

                            <div class="submit">
                                <input type="submit" class="btn submit-btn pagination-apply" value="Apply">
                            </div>

                            <!--End Pagination Count, Catalogue search by date and Apply Button Section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                <!--Breadcrumb section-->
                <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">eBay</li>
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
                        <div class="card-box ebay table-responsive shadow">

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


                            @if ($message = Session::get('success_message'))
                                <div class="alert alert-success alert-block" style="display: none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong id="success_message">{{ $message }}</strong>
                                </div>
                            @endif

                            @if ($message = Session::get('product_draft_id'))
                                <div id="success-product-draft-id" style="display: none">{{ $message }}</div>
                            @endif


                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">

                                    <div class="ebay-master-product-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search on eBay...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="publish_catalogue_search();">Search</button>
                                            </div>
                                        </form>
                                    </div>


                                    <!--Pagination area-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-not-all')}}" method="get">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">  {{$total_catalogue->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogue->currentPage() > 1)
                                                        <a class="first-page btn {{ $total_catalogue->currentPage() > 1 ? '' : 'disabled' }}" href="{{$total_catalogue_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                        <a class="prev-page btn {{ $total_catalogue->currentPage() > 1 ? '' : 'disabled' }}" href="{{$total_catalogue_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$total_catalogue_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$total_catalogue_info->last_page}}</span></span>
                                                        <input type="hidden" name="first_page_url" value="{{$total_catalogue_info->first_page_url}}">
                                                        <input type="hidden" name="route_name" value="ebay-pending-list">
                                                        <input type="hidden" name="current_page" value="{{$total_catalogue->currentPage()}}">
                                                    </span>
                                                    @if($total_catalogue->currentPage() !== $total_catalogue->lastPage())
                                                        <a class="next-page btn" href="{{$total_catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                        <a class="last-page btn" href="{{$total_catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


                            {{-- <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div> --}}


                            <table class="ebay-table w-100 publish_search_result">
                                <thead>
                                <tr>
                                    <th class="image text-center" style="width: 6% !important;">Image</th>
                                    <th class="id" style="width: 6%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <form action="{{url('eBay/pending/product/search')}}" method="get">
                                                    @csrf
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="search_value[id][value]" value="{{isset($search_value['id']['value']) ? $search_value['id']['value'] : ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out1" type="checkbox" name="search_value[id][opt_out]" value="1" @isset($search_value['id']['opt_out']) checked @endisset><label for="opt-out1">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="id">
                                                        @if(isset($search_value['id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="product-type" style="width: 10%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['type']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="search_value[type][value]" value="{{isset($search_value['type']['value']) ? $search_value['type']['value']: ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out2" type="checkbox" name="search_value[type][opt_out]" value="1" @isset($search_value['type']['opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="type">
                                                        @if(isset($search_value['type']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[type][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Product Type</div>
                                        </div>
                                    </th>
                                    <th class="catalogue-name" style="width: 30%">
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
                                                            <input id="opt-out2" type="checkbox" name="search_value[title][opt_out]" value="1" @isset($search_value['title']['opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
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
                                            <div>Title</div>
                                        </div>
                                    </th>
                                    <th class="category" style="width: 15%">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['category']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $woowms_category_info = \App\WooWmsCategory::orderBy('category_name', 'ASC')->get();
                                                        @endphp
                                                        <select class="form-control b-r-0" name="search_value[category][value]">
                                                            @if(isset($woowms_category_info))
                                                                @if($woowms_category_info->count() == 1)
                                                                    @foreach($woowms_category_info as $category_name)
                                                                        <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['category']['value']))
                                                                        <option value="">Select Category</option>
                                                                        @foreach($woowms_category_info as $category_name)
                                                                            @if($category_name->id == $search_value['category']['value'])
                                                                                <option value="{{$category_name->id}}" selected>{{$category_name->category_name}}</option>
                                                                            @else
                                                                                <option value="{{$category_name->id}}" >{{$category_name->category_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Category</option>
                                                                        @foreach($woowms_category_info as $category_name)
                                                                            <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out3" type="checkbox" name="search_value[category][opt_out]" value="1" @isset($search_value['category']['opt_out']) checked @endisset><label for="opt-out3">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="woowms_category">
                                                        @if(isset($search_value['category']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[category][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Category</div>
                                        </div>
                                    </th>
                                    <th class="status" style="text-align: center !important; width: 8%">Status</th>
                                    <th class="stock filter-symbol" style="text-align: center !important; width: 8%">Stock
{{--                                        <div class="d-flex justify-content-center">--}}
{{--                                            <div class="btn-group">--}}
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">--}}
{{--                                                        <p>Filter Value</p>--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <div>--}}
{{--                                                                <select class="form-control" name="aggregate_condition">--}}
{{--                                                                    <option value="=">=</option>--}}
{{--                                                                    <option value="<"><</option>--}}
{{--                                                                    <option value=">">></option>--}}
{{--                                                                    <option value="<=">≤</option>--}}
{{--                                                                    <option value=">=">≥</option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="ml-2">--}}
{{--                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                            <input id="opt-out4" type="checkbox" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>--}}
{{--                                                        </div>--}}
{{--                                                        <input type="hidden" name="column_name" value="stock">--}}
{{--                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                            <div>Stock</div>--}}
{{--                                        </div>--}}
                                    </th>
                                    <th class="product filter-symbol" style="text-align: center !important; width: 8%">Product
{{--                                        <div class="d-flex justify-content-center">--}}
{{--                                            <div class="btn-group">--}}
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">--}}
{{--                                                        <p>Filter Value</p>--}}
{{--                                                        <div class="d-flex">--}}
{{--                                                            <div>--}}
{{--                                                                <select class="form-control" name="aggregate_condition">--}}
{{--                                                                    <option value="=">=</option>--}}
{{--                                                                    <option value="<"><</option>--}}
{{--                                                                    <option value=">">></option>--}}
{{--                                                                    <option value="<=">≤</option>--}}
{{--                                                                    <option value=">=">≥</option>--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="ml-2">--}}
{{--                                                                <input type="text" class="form-control input-text symbol-filter-input-text" name="search_value">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                            <input id="opt-out5" type="checkbox" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>--}}
{{--                                                        </div>--}}
{{--                                                        <input type="hidden" name="column_name" value="product">--}}
{{--                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                    </div>--}}
{{--                                                </form>--}}
{{--                                            </div>--}}
{{--                                            <div>Product</div>--}}
{{--                                        </div>--}}
                                    </th>
                                    <th class="creator filter-symbol" style="width: 8%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                    @csrf--}}
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        @if(isset($search_value['user_id']['value']))
                                                            <i class="fa text-warning" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa" aria-hidden="true"></i>
                                                        @endif
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control" name="search_value[user_id][value]">
                                                              @isset($users)
                                                                @if($users->count() == 1)
                                                                    @foreach($users as $user_list)
                                                                        <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['user_id']['value']))
                                                                        <option value="">Select Creator</option>
                                                                        @foreach($users as $user_list)
                                                                            @if($user_list->id == $search_value['user_id']['value'])
                                                                                <option value="{{$user_list->id}}" selected>{{$user_list->name}}</option>
                                                                            @else
                                                                                <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Creator</option>
                                                                        @foreach($users as $user_list)
                                                                            <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                              @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out6" type="checkbox" name="search_value[user_id][opt_out]" value="1" @isset($search_value['user_id']['opt_out']) checked @endisset><label for="opt-out6">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="creator">
                                                        <input type="hidden" name="status" value="publish">
                                                        @if(isset($search_value['user_id']['value']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="search_value[user_id][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
{{--                                                </form>--}}
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th class="modifier filter-symbol" style="width: 8%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
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
                                                        <select class="form-control" name="search_value[modifier_id][value]">
                                                            @isset($users)
                                                                @if($users->count() == 1)
                                                                    @foreach($users as $user_list)
                                                                        <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @if(isset($search_value['modifier_id']['value']))
                                                                        <option value="">Select Modifier</option>
                                                                        @foreach($users as $user_list)
                                                                            @if($user_list->id == $search_value['modifier_id']['value'])
                                                                                <option value="{{$user_list->id}}" selected>{{$user_list->name}}</option>
                                                                            @else
                                                                                <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" selected>Select Modifier</option>
                                                                        @foreach($users as $user_list)
                                                                            <option value="{{$user_list->id}}">{{$user_list->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endisset
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="opt-out7" type="checkbox" name="search_value[modifier_id][opt_out]" value="1" @isset($search_value['modifier_id']['opt_out']) checked @endisset><label for="opt-out7">Opt Out</label>
                                                        </div>
                                                        <input type="hidden" name="column_name" value="modifier">
                                                        <input type="hidden" name="status" value="publish">

                                                        <!--expand ajax variation, getting ajax variation-->
                                                        <input type="hidden" id="ebay_status" name="ebay_status" value="ebay_pending">
                                                        <!--End expand ajax variation, getting ajax variation-->
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
                                    <th style="width: 6%"><div class="d-flex justify-content-center">
                                        <div>Actions</div> &nbsp; &nbsp;
                                            @if(isset($search_value))
                                            <div><a title="Clear filters" class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></a></div>
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="search_reasult">
                                @isset($search_value)
                                @if(count($total_catalogue) == 0 && count($search_value) != 0)
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
                                @foreach($total_catalogue as $catalogue)
                                    <tr>
                                        <td class="image" style="width:6% !important; cursor: pointer; text-align: center" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">

                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            @isset($catalogue->single_image_info->image_url)
                                                <a href="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                    <img src="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}" class="ebay-image zoom" alt="ebay-catalogue-image">
                                                </a>
                                            @endisset
                                        </td>
{{--                                    <td class="id" style="width: 6%; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">--}}
                                        <td class="id" style="width: 6%;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-start">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="product-type" style="width: 10%; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            <div style="text-align: center;">
                                                @if($catalogue->type == 'simple')
                                                    Simple
                                                @else
                                                    Variation
                                                @endif
                                            </div>
                                        </td>
                                        <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            <a class="ebay-product-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                {{Str::limit($catalogue->name,100, $end = '...') }}
                                            </a>
                                        </td>
                                        <?php
                                        $data = '';
                                        if(isset($catalogue->all_category)){
                                            foreach ($catalogue->all_category as $category){
                                                if(isset($category->category_name)){
                                                    $data .= $category->category_name.',';
                                                }
                                            }
                                        };
                                        ?>
{{--                                        <td class="category" style="cursor: pointer; width: 15%; text-align: center !important;" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{isset($catalogue->woowms_category) ? \App\WooWmsCategory::find($catalogue->woowms_category)->category_name ?? '' : ''}}  </td>--}}
                                        {{--                                        <td class="text-justify">{{Str::limit(strip_tags($published_product-> description,10, $end = '...') }}</td>--}}
                                        {{--                                        <td>{{$published_product->regular_price}}</td>--}}
                                        {{--                                        <td>{{$published_product->sale_price}}</td>--}}
                                        {{--                                        <td>{{$published_product->low_quantity}}</td>--}}
{{--                                        <td class="status text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>--}}
                                        <td class="stock text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
                                        <td class="product text-center" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
                                        <td class="creator" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            @if(isset($catalogue->user_info->name))
                                            <div class="wms-name-creator">
                                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                                                    <strong class="@if($catalogue->user_info->deleted_at)text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="cursor: pointer; width: 8%" data-toggle="collapse" data-target="#demo{{$catalogue->id}}" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" class="accordion-toggle">
                                            @if(isset($catalogue->modifier_info->name))
                                                <div class="wms-name-modifier1">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                                        <strong class="@if($catalogue->modifier_info->deleted_at)text-danger @else text-success @endif">{{$catalogue->modifier_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @elseif(isset($catalogue->user_info->name))
                                                <div class="wms-name-modifier2">
                                                    <div data-tip="on {{date('d-m-Y', strtotime($catalogue->updated_at))}}">
                                                        <strong class="@if($catalogue->user_info->deleted_at)text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="actions" style="width: 6%">

                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div class="dropup-content catalogue-dropup-content">
                                                        <div class="action-1">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" href="{{route('product-draft.edit',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
{{--                                                            @if(!isset($catalogue->onbuy_product_info->id))--}}
{{--                                                                <div class="align-items-center mr-2"> <a class="list-onbuy-btn btn-size" href="{{url('onbuy/create-product/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="List On Onbuy"><i class="fab fa-product-hunt" aria-hidden="true"></i></a></div>--}}
{{--                                                            @endif--}}
{{--                                                            <div class="align-items-center mr-2"><a class="btn-size catalogue-btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><img src="{{asset('assets/images/terms-catalogue.png')}}" alt="Add Terms To Catalogue" width="30" height="30" class="filter"></a></div>--}}
                                                            {{-- <div class="align-items-center mr-2"> <a class="btn-size add-terms-catalogue-btn" href="{{url('add-additional-terms-draft/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list"></i></a></div> --}}
                                                            <div class="align-items-center mr-2" onclick="addTermsCatalog({{ $catalogue->id }}, this)"> <a class="btn-size add-terms-catalogue-btn cursor-pointer" data-toggle="tooltip" data-placement="top" title="Add Terms to Catalogue"><i class="fas fa-list text-white"></i></a></div>
{{--                                                            <div class="align-items-center"><a class="btn-size invoice-btn invoice-btn-size" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><img src="{{asset('assets/images/receive-invoice.png')}}" alt="Receive Invoice" width="30" height="30" class="filter"></a></div>--}}
{{--                                                            <div class="align-items-center"><a class="btn-size catalogue-invoice-btn invoice-btn" href="{{url('catalogue-product-invoice-receive/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Receive Invoice"><i class='fa fa-book'></i></a></div>--}}
                                                        </div>
                                                        <div class="action-2">
                                                            <div class="align-items-center mr-2"> <a class="btn-size add-product-btn" href="{{url('catalogue/'.$catalogue->id.'/product')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Manage Variation"><i class="fa fa-chart-bar" aria-hidden="true"></i></a></div>
{{--                                                            <div class="align-items-center mr-2"><a class="btn-size duplicate-btn" href="{{url('duplicate-draft-catalogue/'.$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Duplicate"><i class="fa fa-clone" aria-hidden="true"></i></a></div>--}}
                                                            <div class="align-items-center mr-2"> <a class="btn-size list-on-ebay-btn" target="_blank" href="{{url('create-ebay-product/'.$catalogue->id)}}" data-toggle="tooltip" data-placement="top" title="List on Ebay"><i class="fab fa-ebay" aria-hidden="true"></i></a></div>
                                                            @if($catalogue->status == 'draft')
                                                            <div class="align-items-center mr-2">
                                                                <form action="{{route('product-draft.publish',$catalogue->id)}}" method="post">
                                                                    @csrf
                                                                    <button class="del-pub btn-size publish-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            @endif
                                                            <div class="align-items-center">
                                                                <form action="{{route('product-draft.destroy',$catalogue->id)}}" method="post">
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
                                            <div id="add-terms-catalog-modal-{{ $catalogue->id }}" class="category-modal add-terms-to-catalog-modal" style="display: none">
                                                <div class="cat-header add-terms-catalog-modal-header">
                                                    <div>
                                                        <label id="label_name" class="cat-label">Add terms to catalogue({{ $catalogue->id }})</label>
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
                                                                <input type="text" class="form-control" name="product_draft_id" value="{{$catalogue->id ? $catalogue->id : old('product_draft_id')}}" id="product_draft_id" placeholder="" required readonly>
                                                            </div>
                                                        </div>

                                                        <div class="row form-group select_variation_att" id="add-terms-tocatalog-modal-data-{{ $catalogue->id }}">
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


                                    <!--hidden row -->
                                    <tr>
                                        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$catalogue->id}}">

                                            </div> <!-- end accordion body -->
                                        </td> <!-- hide expand td-->
                                    </tr> <!-- hide expand row-->



                                @endforeach
                                </tbody>
                            </table>

                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num pr-1"> {{$total_catalogue->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogue->currentPage() > 1)
                                                    <a class="first-page btn {{ $total_catalogue->currentPage() > 1 ? '' : 'disabled' }}" href="{{$total_catalogue_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{ $total_catalogue->currentPage() > 1 ? '' : 'disabled' }}" href="{{$total_catalogue_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text  d-flex pl-1"> {{$total_catalogue_info->current_page}} of <span class="total-pages">{{$total_catalogue_info->last_page}}</span></span>
                                                    </span>
                                                    @if($total_catalogue->currentPage() !== $total_catalogue->lastPage())
                                                    <a class="next-page btn" href="{{$total_catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$total_catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
            var status = $('#ebay_status').val();
            console.log(status);
            console.log(id);
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
                },
                success: function (response) {
                    $('#demo'+id).html(response);
                    console.log($('#demo'+id).html(response));
                },
                complete: function () {
                    $('#product_variation_loading'+id).hide();
                }
            })
        }
        function publish_catalogue_search(){

            var name = $('#name').val();

            if(name == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            ids = [0];
            searchPriority = 0;
            skip = 0;
            var status = $('#ebay_status').val();
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

        $(document).bind("scroll", function(e){

            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){

                var name = $('#name').val();

                if(name != '' ){
                    var status = $('#ebay_status').val();

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo e(url('/search-product-list').'?_token='.csrf_token()); ?>',
                        data: {
                            "name": name,
                            "status":status,
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

        {{--function publish_catalogue_search(){--}}
        {{--    var name = $('#name').val();--}}
        {{--    // if(name == '' ){--}}
        {{--    //     alert('Please type catalogue name in the search field.');--}}
        {{--    //     return false;--}}
        {{--    // }--}}
        {{--    var status = ['draft','publish'];--}}
        {{--    console.log(status);--}}
        {{--    $.ajax({--}}
        {{--        type: 'POST',--}}
        {{--        url: '{{url('/search-product-list').'?_token='.csrf_token()}}',--}}
        {{--        data: {--}}
        {{--            "name": name,--}}
        {{--            "status":status,--}}
        {{--        },--}}
        {{--        beforeSend: function(){--}}
        {{--            // Show image container--}}
        {{--            console.log(name);--}}
        {{--            $("#Load").show();--}}
        {{--        },--}}
        {{--        success: function(response){--}}

        {{--            // $('.product-content ul.pagination').hide();--}}
        {{--            // $('.total-d-o span').hide();--}}
        {{--            // $('.publish_search_result').html(response);--}}
        {{--            $('tbody').html(response);--}}

        {{--        },--}}
        {{--        complete:function(data){--}}
        {{--            // Hide image container--}}
        {{--            $("#Load").hide();--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        $(document).ready(function() {

            // Default Datatable
            // $('#datatable').DataTable();

            $('#catalogue_search_by_date').on('change',function () {
                var date_value = $(this).val();
                if(date_value == ''){
                    date_value = 15;
                }
                console.log(date_value);
                var status = ['draft','publish'];
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
                        // $('.publish_search_result').html(response.data);
                        $('tbody').html(response.data);
                    },
                    complete: function () {
                        $('#ajax_loader').hide();
                    }
                })
            })

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

        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });

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
