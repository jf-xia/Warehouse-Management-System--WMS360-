@extends('master')
@section('title')
    Amazon | Pending Ean Product | WMS360
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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['image']) && $setting['amazon']['amazon_active_product']['image'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['image']) && $setting['amazon']['amazon_active_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['id']) && $setting['amazon']['amazon_active_product']['id'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['id']) && $setting['amazon']['amazon_active_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['catalogue-name']) && $setting['amazon']['amazon_active_product']['catalogue-name'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['catalogue-name']) && $setting['amazon']['amazon_active_product']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="application" class="onoffswitch-checkbox" id="application" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['application']) && $setting['amazon']['amazon_active_product']['application'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['application']) && $setting['amazon']['amazon_active_product']['application'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="application">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Application</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="account" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['account']) && $setting['amazon']['amazon_active_product']['account'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['account']) && $setting['amazon']['amazon_active_product']['account'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Account</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['category']) && $setting['amazon']['amazon_active_product']['category'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['category']) && $setting['amazon']['amazon_active_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['status']) && $setting['amazon']['amazon_active_product']['status'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['status']) && $setting['amazon']['amazon_active_product']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="master_sale_price" class="onoffswitch-checkbox" id="master_sale_price" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['master_sale_price']) && $setting['amazon']['amazon_active_product']['master_sale_price'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['master_sale_price']) && $setting['amazon']['amazon_active_product']['master_sale_price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="master_sale_price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sale Price</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['stock']) && $setting['amazon']['amazon_active_product']['stock'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['stock']) && $setting['amazon']['amazon_active_product']['stock'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="stock">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Stock</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['product']) && $setting['amazon']['amazon_active_product']['product'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['product']) && $setting['amazon']['amazon_active_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['creator']) && $setting['amazon']['amazon_active_product']['creator'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['creator']) && $setting['amazon']['amazon_pending_product']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['modifier']) && $setting['amazon']['amazon_active_product']['modifier'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['modifier']) && $setting['amazon']['amazon_active_product']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['sku']) && $setting['amazon']['amazon_active_product']['sku'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['sku']) && $setting['amazon']['amazon_active_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['qr']) && $setting['amazon']['amazon_active_product']['qr'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['qr']) && $setting['amazon']['amazon_active_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['variation']) && $setting['amazon']['amazon_active_product']['variation'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['variation']) && $setting['amazon']['amazon_active_product']['variation'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['ean']) && $setting['amazon']['amazon_active_product']['ean'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['ean']) && $setting['amazon']['amazon_active_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['regular-price']) && $setting['amazon']['amazon_active_product']['regular-price'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['regular-price']) && $setting['amazon']['amazon_active_product']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['sales-price']) && $setting['amazon']['amazon_active_product']['sales-price'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['sales-price']) && $setting['amazon']['amazon_active_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['sold']) && $setting['amazon']['amazon_pending_product']['sold'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['sold']) && $setting['amazon']['amazon_active_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div><div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['available-qty']) && $setting['amazon']['amazon_active_product']['available-qty'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['available-qty']) && $setting['amazon']['amazon_active_product']['available-qty'] == 0) @else checked @endif>
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
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['amazon']['amazon_active_product']['shelf-qty']) && $setting['amazon']['amazon_active_product']['shelf-qty'] == 1) checked @elseif(isset($setting['amazon']['amazon_active_product']['shelf-qty']) && $setting['amazon']['amazon_active_product']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="firstKey" value="amazon">
                            <input type="hidden" id="secondKey" value="amazon_active_product">
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
                                        <span class="pagination-mgs-show text-success"></span>
                                    </form>
                                </div>
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
                            <li class="breadcrumb-item">Amazon</li>
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
                        <div class="card-box amazon shadow">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                               {{Session::get('error')}}
                            </div>
                        @endif
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">
                                    <div class="amazon-search-form">
                                        <form class="d-flex" action="{{url('all-column-search')}}" method="post">
                                            @csrf
                                            <div class="p-text-area">
                                                <input type="text" name="search_value" id="search" value="{{$searchValue ?? ''}}" class="form-control" placeholder="Search...." required>
                                                <input type="hidden" name="search_route" value="amazon/active-catalogues">
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$total_catalogues->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogues->currentPage() > 1)
                                                    <a class="first-page btn {{$total_catalogues->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_decode_catalogues->first_page_url.$url : $total_decode_catalogues->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$total_catalogues->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_decode_catalogues->prev_page_url.$url : $total_decode_catalogues->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$total_decode_catalogues->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$total_decode_catalogues->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="amazon/active-catalogues">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($total_catalogues->currentPage() !== $total_catalogues->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $total_decode_catalogues->next_page_url.$url : $total_decode_catalogues->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $total_decode_catalogues->last_page_url.$url : $total_decode_catalogues->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            {{-- <div id="Load" class="load" style="display: none;">
                                <div class="load__container">
                                    <div class="load__animation"></div>
                                    <div product_variation_loading="load__mask"></div>
                                    <span product_variation_loading="load__title">Content is loading...</span>
                                </div>
                            </div> --}}

                            <table class="amazon-table w-100 publish_search_result">
                                <thead>
                                    <form action="{{url('all-column-search')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="search_route" value="amazon/active-catalogues">
                                        <tr>
                                            <th class="image text-center" style="width: 10% !important;">Image</th>
                                            <th class="id" style="width: 10%">
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
                                                            @if(isset($allCondition['catalogue_id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="catalogue_id" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>M.Catalogue Id</div>
                                                </div>
                                            </th>
                                            <th class="catalogue-name" style="width: 20%">
                                                <div class="d-flex justify-content-center">
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
                                                            @if(isset($allCondition['title']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Title</div>
                                                </div>
                                            </th>

                                            <th class="application filter-symbol" style="width: 10%;">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['application'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="application" id="application">
                                                                @isset($applications)
                                                                    @if($applications->count() == 1)
                                                                        @foreach($applications as $application)
                                                                            <option value="{{$application->id}}">{{$application->application_name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">Select Application</option>
                                                                        @foreach($applications as $application)
                                                                            @if(isset($allCondition['application']) && ($allCondition['application'] == $application->id))
                                                                                <option value="{{$application->id}}" selected>{{$application->application_name}}</option>
                                                                            @else
                                                                                <option value="{{$application->id}}">{{$application->application_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="application_opt_out" type="checkbox" name="application_opt_out" value="1" @isset($allCondition['application_opt_out']) checked @endisset><label for="application_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['application']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="application" name="application" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>App Name</div>
                                                </div>
                                            </th>

                                            <th class="account filter-symbol" style="width: 10%;">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['account'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <select class="form-control select2" name="account" id="account">
                                                                @isset($accountWithMarketPlaces)
                                                                    @if($accountWithMarketPlaces->count() == 1)
                                                                        @foreach($accountWithMarketPlaces as $marketPlaceAccount)
                                                                            <option value="{{$marketPlaceAccount->id}}">{{$marketPlaceAccount->marketplace ?? ''}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="">Select Application</option>
                                                                        @foreach($accountWithMarketPlaces as $marketPlaceAccount)
                                                                            @if(isset($allCondition['account']) && ($allCondition['account'] == $marketPlaceAccount->id))
                                                                                <option value="{{$marketPlaceAccount->id}}" selected>{{$marketPlaceAccount->marketplace ?? ''}}</option>
                                                                            @else
                                                                                <option value="{{$marketPlaceAccount->id}}">{{$marketPlaceAccount->marketplace ?? ''}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endisset
                                                            </select>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="account_opt_out" type="checkbox" name="account_opt_out" value="1" @isset($allCondition['account_opt_out']) checked @endisset><label for="account_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['account']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="account" name="account" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Account</div>
                                                </div>
                                            </th>

                                            <th class="stock filter-symbol" style="text-align: center !important; width: 5%;">
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
                                                            @if(isset($allCondition['stock']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="stock" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Stock</div>
                                                </div>
                                            </th>
                                            <th class="master_sale_price filter-symbol" style="text-align: center !important; width: 10%;">
                                                <div class="d-flex justify-content-center">
                                                    <div class="btn-group">
                                                        <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                            <i class="fa @isset($allCondition['master_sale_price'])text-warning @endisset" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <div class="d-flex">
                                                                <div>
                                                                    <select class="form-control" name="master_sale_price_opt" id="masterSalePriceOpt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['master_sale_price_opt']) && ($allCondition['master_sale_price_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['master_sale_price_opt']) && ($allCondition['master_sale_price_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['master_sale_price_opt']) && ($allCondition['master_sale_price_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['master_sale_price_opt']) && ($allCondition['master_sale_price_opt'] == '≤')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['master_sale_price_opt']) && ($allCondition['master_sale_price_opt'] == '≥')) selected @endif>≥</option>
                                                                    </select>
                                                                </div>
                                                                <div class="ml-2">
                                                                    <input type="text" class="form-control input-text symbol-filter-input-text" name="master_sale_price" id="master_sale_price" value="{{$allCondition['master_sale_price'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="master_sale_price_opt_out" type="checkbox" name="master_sale_price_opt_out" value="1" @isset($allCondition['master_sale_price_opt_out']) checked @endisset><label for="master_sale_price_opt_out">Opt Out</label>
                                                            </div>
                                                            @if(isset($allCondition['master_sale_price']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="master_sale_price" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Sale Price</div>
                                                </div>
                                            </th>
                                            <th class="product filter-symbol" style="text-align: center !important; width: 5%;">
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
                                                            @if(isset($allCondition['product']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="product" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Product</div>
                                                </div>
                                            </th>
                                            <th class="creator filter-symbol" style="width: 5%;">
                                                <div class="d-flex justify-content-center">
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
                                                            @if(isset($allCondition['creator']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="creator" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Creator</div>
                                                </div>
                                            </th>
                                            <th class="modifier filter-symbol" style="width: 5%;">
                                                <div class="d-flex justify-content-center">
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
                                                            @if(isset($allCondition['modifier']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="creator" name="modifier" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Modifier</div>
                                                </div>
                                            </th>
                                            <th style="width: 10%;">
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

                                <tbody id="search_reasult">
                                    @if(isset($total_catalogues))
                                        @isset($allCondition)
                                        @if(count($total_catalogues) == 0 && count($allCondition) != 0)
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
                                        @foreach($total_catalogues as $catalogue)
                                            <tr class="amazon-catalogue-row-{{$catalogue->id}}">
                                                <td class="image" style="width: 10%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                                    <!--Start each row loader-->
                                                    <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                                                    <!--End each row loader-->

                                                    <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                    @isset($catalogue->images)
                                                        <a href="{{$catalogue->images}}"  title="Click to expand" target="_blank"><img src="{{$catalogue->images}}" class="amazon-image zoom" alt="catalogue-image"></a>
                                                    @endisset
                                                </td>
                                                <td class="id" style="width: 10%; text-align: center !important;">
                                                    <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->master_product_id}}</span>
                                                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                    </div>
                                                </td>
                                                <td class="catalogue-name text-center" style="width: 20%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                                    @php
                                                        $amazonSite = $catalogue->applicationInfo->marketPlace->marketplace ?? '';
                                                    @endphp
                                                    <a href="https://www.amazon{{$amazonSite == 'UK' ? '.co.uk' : ($amazonSite == 'US' ? '.com' : '.com')}}/dp/{{$catalogue->master_asin}}" target="_blank" title="View In Amazon">{{$catalogue->title}}</a>
                                                </td>
                                                <td class="application text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->applicationInfo->application_name ?? ''}}</td>
                                                <td class="account text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->applicationInfo->marketPlace->marketplace ?? ''}}({{$catalogue->applicationInfo->accountInfo->account_name ?? ''}})</td>
                                                <td class="stock text-center" style="cursor: pointer; width: 5%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->variations[0]->stock ?? 0}}</td>
                                                <td class="master_sale_price text-center" style="cursor: pointer; width: 10%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->sale_price ?? 0}}</td>
                                                <td class="product text-center" style="cursor: pointer; width: 5%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->variations_count ?? 0}}</td>
                                                <td class="creator" style="cursor: pointer; width: 5%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                                    @if(isset($catalogue->user_info->name))
                                                    <div class="wms-name-creator">
                                                        <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                                                            <strong class="@if($catalogue->user_info->deleted_at)text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="modifier" style="cursor: pointer; width: 5%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}"  data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
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
                                                <td class="actions" style="width: 10%;">
                                                    <button type="button" class="btn btn-danger btn-sm delete-amazon-master-catalogue" id="{{$catalogue->id}}">Delete</button>
                                                    <!-- <form action="" method="post">
                                                        @csrf
                                                        <input type="hidden" name="amazon_master_catalogue_id" value="{{$catalogue->id}}">
                                                        <button type></button>
                                                    </form> -->
                                                </td>
                                            </tr>

                                            <!--hidden row -->
                                            <tr class="amazon-catalogue-row-{{$catalogue->id}}">
                                                <td colspan="11" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                                    <div class="accordian-body collapse" id="demo{{$catalogue->id}}">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card p-2 m-t-5 m-b-5 m-l-5 m-r-5">
                                                                    <span class="screen-option"></span>
                                                                    <div class="row-expand-height-control">
                                                                        <!--row expand inner table-->
                                                                        <table class="product-draft-table row-expand-table w-100">
                                                                            <thead>
                                                                            <tr>
                                                                                <th class="id" style="width: 10%">ID</th>
                                                                                <th class="variation" style="width: 20%">Variation</th>
                                                                                <th class="sku" style="width: 10%">SKU</th>
                                                                                <th class="asin" style="width: 10%">ASIN</th>
                                                                                <th class="ean" style="width: 10%">EAN</th>
                                                                                <th class="is-master-editable" style="width: 5%">Editable</th>
                                                                                <th class="sales-price" style="width: 10%">Sales Price</th>
                                                                                <th class="quantity" style="width: 10%">Quantity</th>
                                                                                <th class="sold" style="width: 5%">Sold</th>
                                                                                <th style="width: 10%">Actions</th>
                                                                            </tr>
                                                                            </thead>

                                                                            <!--row expand inner table body-->
                                                                            <tbody>
                                                                            @if(isset($catalogue->allVariations) && count($catalogue->allVariations) > 0)
                                                                                @foreach($catalogue->allVariations as $product_variation)
                                                                                    <tr class="amazon-variation-row-{{$product_variation->id}}">
                                                                                        <td class="id" style="width: 10%">
                                                                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_variation->id}}</span>
                                                                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="variation" style="width: 20%">
                                                                                        @if(isset($product_variation->attribute))
                                                                                            @foreach(\Opis\Closure\unserialize($product_variation->attribute) as $attribute_value)
                                                                                                <label><b style="color: #7e57c2">{{$attribute_value['attribute_name']}}</b> <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i> {{$attribute_value['terms_name']}}, </label>
                                                                                            @endforeach
                                                                                        @endif
                                                                                        </td>
                                                                                        <td class="sku" style="width: 10%">
                                                                                            <div class="sku_tooltip_container d-flex justify-content-start">
                                                                                                <span title="Click to Copy" onclick="wmsSkuCopied(this);" class="sku_copy_button">{{$product_variation->sku}}</span>
                                                                                                <span class="wms__sku__tooltip__message" id="wms__sku__tooltip__message">Copied!</span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="asin" style="width: 10%">
                                                                                            <div class="sku_tooltip_container d-flex justify-content-start">
                                                                                                @php
                                                                                                    $amazonSite = $catalogue->applicationInfo->marketPlace->marketplace ?? '';
                                                                                                @endphp
                                                                                                <span><a href="https://www.amazon{{$amazonSite == 'UK' ? '.co.uk' : ($amazonSite == 'US' ? '.com' : '.com')}}/dp/{{$product_variation->asin}}?th=1&psc=1" target="_blank" title="View In Amazon">{{$product_variation->asin}}</a></span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="ean" style="width: 10%">{{$product_variation->ean_no}}</td>
                                                                                        <td class="is-master-editable" style="width: 5%">{{$product_variation->is_master_editable == 1 ? 'Yes' : 'No'}}</td>

                                                                                        <td class="sales-price" style="width: 10% !important;">
                                                                                            <div class="d-flex justify-content-center align-items-center">
                                                                                                <div class="shown" id="sale_price_{{$product_variation->id}}">
                                                                                                    <span>
                                                                                                        {{$product_variation->sale_price}}
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="available-qty" style="width: 10%">
                                                                                            <div class="d-flex justify-content-center align-items-center">
                                                                                                <div class="shown" id="actual_quantity_{{$product_variation->id}}">
                                                                                                    <span>
                                                                                                        {{$product_variation->quantity}}
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        @php
                                                                                            $total_sold = 0;
                                                                                            if(count($product_variation->order_products) > 0){
                                                                                                foreach($product_variation->order_products as $product){
                                                                                                    $total_sold += $product->sold;
                                                                                                }
                                                                                            }
                                                                                        @endphp
                                                                                        <td class="sold" style="width: 5%">{{$total_sold ?? 0}}</td>
                                                                                        <td class="actions" style="width: 10%">
                                                                                            <!--start manage button area-->
                                                                                            <div class="btn-group" id="{{$product_variation->id}}">
                                                                                                <button type="button" class="btn btn-success btn-sm edit-amazon-variation mr-2">Edit Price</button>
                                                                                                <button type="button" class="btn btn-danger btn-sm delete-amazon-variation">Delete</button>
                                                                                                <!-- <button type="button" class="btn expand-manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    Manage
                                                                                                </button> -->
                                                                                                <!--start dropup content-->
                                                                                                <!-- <div class="dropdown-menu catalogue-active-catalogue">
                                                                                                    <div class="dropup-content catalogue-dropup-content">
                                                                                                        <div class="action-1">
                                                                                                            <div class="align-items-center mr-2"><button class="btn-size edit-btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></button></div>
                                                                                                            <div class="align-items-center">
                                                                                                                <button class="del-pub delete-btn delete-amazon-variation" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div> -->
                                                                                                <!--End dropup content-->
                                                                                            </div>
                                                                                            <!--End manage button area-->
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @endif
                                                                            </tbody>
                                                                            <!--End row expand inner table body-->
                                                                        </table>
                                                                        <!--End row expand inner table-->
                                                                    </div>
                                                                </div> <!-- end card -->
                                                            </div> <!-- end col-12 -->
                                                        </div> <!-- end row -->
                                                    </div> <!-- end accordion body -->
                                                </td> <!-- hide expand td-->
                                            </tr> <!-- hide expand row-->

                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$total_catalogues->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogues->currentPage() > 1)
                                                    <a class="first-page btn {{$total_catalogues->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_decode_catalogues->first_page_url.$url : $total_decode_catalogues->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$total_catalogues->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_decode_catalogues->prev_page_url.$url : $total_decode_catalogues->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1">{{$total_decode_catalogues->current_page}} of<span class="total-pages">{{$total_decode_catalogues->last_page}}</span></span>
                                                    </span>
                                                    @if($total_catalogues->currentPage() !== $total_catalogues->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $total_decode_catalogues->next_page_url.$url : $total_decode_catalogues->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $total_decode_catalogues->last_page_url.$url : $total_decode_catalogues->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })

        function publish_catalogue_search(){
            var name = $('#name').val();
            var ean_status = $('#ean_status').val();
            if(name == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            ids = [0];
            searchPriority = 0;
            skip = 0;
            var status = $('#amazon_status').val();
            $.ajax({
                type: "post",
                url: "{{url('search-product-list')}}",
                data: {
                    "_token": "{{csrf_token()}}",
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
                    $('#search_reasult').html(response.html);
                    searchPriority = response.search_priority;
                    take = response.take;
                    skip = parseInt(response.skip)+10;
                    ids = ids.concat(response.ids);
                },
                complete:function(data){
                    $("#ajax_loader").hide();
                }
            });
        }

        $(document).bind("scroll", function(e){
            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){
                var name = $('#name').val();
                if(name != '' ){
                    var status = $('#amazon_status').val();
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
                            searchPriority = response.search_priority;
                            take = response.take;
                            skip = parseInt(response.skip)+10;
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
            var status = $('#amazon_status').val();
            var id = product_draft_id[1]
            $.ajax({
                type: "post",
                url: "{{url('amazon/get-pending-master-variation')}}",
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
        //screen option toggle
        $(document).ready(function(){
            $(".screen-option-btn").click(function(){
                $(".screen-option-content").slideToggle(500);
            });

            $('.edit-amazon-variation').click(function(){
                var thisVal = $(this)
                let amazonVariationId = thisVal.closest('div').attr('id')
                let amazonVariationQuantity = thisVal.closest('tr').find('td.available-qty span').text().trim()
                let amazonVariationSalePrice = thisVal.closest('tr').find('td.sales-price span').text().trim()
                let amazonVariationIsMasterEditable = thisVal.closest('tr').find('td.is-master-editable').text().trim()
                var html = '<div class="form-group">'
                        +'<label>Quantity</label><small>(required)</small>'
                        +'<input type="number" class="form-control mb-2 amazon-quantity" value="'+amazonVariationQuantity+'" placeholder="Enter Quantity" readonly>'
                        +'<lable>Sales Price</lable><small>(required)</small>'
                        +'<input type="text" class="form-control mb-2 amazon-sale-price" value="'+amazonVariationSalePrice+'" placeholder="Enter Sale Price">'
                        +'<lable>Is Master Editable</lable><small>(required)</small>'
                        +'<select name="is_master_editable" class="form-control is-master-editable-option">'
                        +'<option value="1" '+(amazonVariationIsMasterEditable == 'Yes' ? 'selected' : '')+'>ON</option>'
                        +'<option value="0" '+(amazonVariationIsMasterEditable == 'No' ? 'selected' : '')+'>OFF</option>'
                        +'</select>'
                        +'</div>'
                Swal.fire({
                    title:'Edit Amazon Product Variation',
                    html:html,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Update',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        var quantity = Swal.getPopup().querySelector('.amazon-quantity').value
                        var salePrice = Swal.getPopup().querySelector('.amazon-sale-price').value
                        var isMasterEditable = Swal.getPopup().querySelector('.is-master-editable-option').value
                        if(quantity == '' || salePrice == '' || isMasterEditable == ''){
                            Swal.showValidationMessage(`Please Give Required Fields`)
                            return false
                        }
                        let url = "{{asset('amazon/update-variation')}}"
                        let token = "{{csrf_token()}}"
                        let dataObj = {
                            amazon_variation_id: amazonVariationId,
                            amazon_quantity: quantity,
                            amazon_sales_price: salePrice,
                            isMasterEditable: isMasterEditable,
                        }
                        return fetch(url, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': token
                            },
                            method: 'post',
                            body: JSON.stringify(dataObj)
                        })
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request Failed: ${error}`)
                        })
                    }
                })
                .then(result => {
                    if(result.isConfirmed){
                        if(result.value.type == 'success'){
                            Swal.fire('Success',result.value.msg,'success')
                            let rowSelect = $('table tr.amazon-variation-row-'+amazonVariationId)
                            rowSelect.find('td.available-qty span').text(result.value.updated_quantity)
                            rowSelect.find('td.sales-price span').text(result.value.updated_sale_price)
                        }else if(result.value.type == 'issue'){
                            var issueMessage = ''
                            result.value.issues.foreach(function(msg, attr){
                                issueMessage += attr+': '+msg+'<br>'
                            })
                            Swal.fire('Oops!',issueMessage,'error')
                        }
                        else{
                            Swal.fire('Oops!',result.value.msg,'error')
                        }
                    }
                })
            })

            $('.delete-amazon-variation').click(function(){
                let amazonVariationId = $(this).closest('div').attr('id')
                Swal.fire({
                    title:'Are You Sure To Delete This ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        let url = "{{asset('amazon/delete-variation')}}"
                        let token = "{{csrf_token()}}"
                        let dataObj = {
                            amazon_variation_id: amazonVariationId,
                        }
                        return fetch(url, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': token
                            },
                            method: 'post',
                            body: JSON.stringify(dataObj)
                        })
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request Failed: ${error}`)
                        })
                    }
                })
                .then(result => {
                    if(result.isConfirmed){
                        if(result.value.type == 'success'){
                            Swal.fire('Success',result.value.msg,'success')
                            $('table tr.amazon-variation-row-'+amazonVariationId).remove()
                        }else if(result.value.type == 'issue'){
                            var issueMessage = ''
                            result.value.issues.foreach(function(msg, attr){
                                issueMessage += attr+': '+msg+'<br>'
                            })
                            Swal.fire('Oops!',issueMessage,'error')
                        }
                        else{
                            Swal.fire('Oops!',result.value.msg,'error')
                        }
                    }
                })
            })

            $('.delete-amazon-master-catalogue').click(function(){
                let catalogueId = $(this).attr('id')
                console.log(catalogueId)
                Swal.fire({
                    title:'Are You Sure To Delete This ?',
                    text: 'All Associates Product Also Will Be Deleted',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        let url = "{{asset('amazon/delete-catalogue')}}"
                        let token = "{{csrf_token()}}"
                        let dataObj = {
                            amazon_catalogue_id: catalogueId,
                        }
                        return fetch(url, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': token
                            },
                            method: 'post',
                            body: JSON.stringify(dataObj)
                        })
                        .then(response => {
                            if(!response.ok){
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request Failed: ${error}`)
                        })
                    }
                })
                .then(result => {
                    if(result.isConfirmed){
                        if(result.value.type == 'success'){
                            Swal.fire('Success',result.value.msg,'success')
                            $('table tr.amazon-catalogue-row-'+catalogueId).remove()
                        }else if(result.value.type == 'issue'){
                            // var issueMessage = ''
                            // result.value.issues.foreach(function(msg, attr){
                            //     issueMessage += attr+': '+msg+'<br>'
                            // })
                            Swal.fire('Oops!','Something Went Wrong. Please Check All Product In WMS And Amazon Is Deleted Or Not ','error')
                        }
                        else{
                            Swal.fire('Oops!',result.value.msg,'error')
                        }
                    }
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
