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
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['image']) && $setting['amazon']['amazon_pending_product']['image'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['image']) && $setting['amazon']['amazon_pending_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['id']) && $setting['amazon']['amazon_pending_product']['id'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['id']) && $setting['amazon']['amazon_pending_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-name" class="onoffswitch-checkbox" id="catalogue-name" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['catalogue-name']) && $setting['amazon']['amazon_pending_product']['catalogue-name'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['catalogue-name']) && $setting['amazon']['amazon_pending_product']['catalogue-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Title</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['category']) && $setting['amazon']['amazon_pending_product']['category'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['category']) && $setting['amazon']['amazon_pending_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['status']) && $setting['amazon']['amazon_pending_product']['status'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['status']) && $setting['amazon']['amazon_pending_product']['status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="stock" class="onoffswitch-checkbox" id="stock" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['stock']) && $setting['amazon']['amazon_pending_product']['stock'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['stock']) && $setting['amazon']['amazon_pending_product']['stock'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="product" class="onoffswitch-checkbox" id="product" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['product']) && $setting['amazon']['amazon_pending_product']['product'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['product']) && $setting['amazon']['amazon_pending_product']['product'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['creator']) && $setting['amazon']['amazon_pending_product']['creator'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['creator']) && $setting['amazon']['amazon_pending_product']['creator'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="creator">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Creator</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="modifier" class="onoffswitch-checkbox" id="modifier" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['modifier']) && $setting['amazon']['amazon_pending_product']['modifier'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['modifier']) && $setting['amazon']['amazon_pending_product']['modifier'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="modifier">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Modifier</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['sku']) && $setting['amazon']['amazon_pending_product']['sku'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['sku']) && $setting['amazon']['amazon_pending_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="qr" class="onoffswitch-checkbox" id="qr" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['qr']) && $setting['amazon']['amazon_pending_product']['qr'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['qr']) && $setting['amazon']['amazon_pending_product']['qr'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="qr">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>QR</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="variation" class="onoffswitch-checkbox" id="variation" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['variation']) && $setting['amazon']['amazon_pending_product']['variation'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['variation']) && $setting['amazon']['amazon_pending_product']['variation'] == 0) @else checked @endif>
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
                                            <input type="checkbox" name="ean" class="onoffswitch-checkbox" id="ean" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['ean']) && $setting['amazon']['amazon_pending_product']['ean'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['ean']) && $setting['amazon']['amazon_pending_product']['ean'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="ean">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>EAN</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="regular-price" class="onoffswitch-checkbox" id="regular-price" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['regular-price']) && $setting['amazon']['amazon_pending_product']['regular-price'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['regular-price']) && $setting['amazon']['amazon_pending_product']['regular-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="regular-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Regular Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sales-price" class="onoffswitch-checkbox" id="sales-price" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['sales-price']) && $setting['amazon']['amazon_pending_product']['sales-price'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['sales-price']) && $setting['amazon']['amazon_pending_product']['sales-price'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sales-price">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sales Price</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sold" class="onoffswitch-checkbox" id="sold" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['sold']) && $setting['amazon']['amazon_pending_product']['sold'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['sold']) && $setting['amazon']['amazon_pending_product']['sold'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sold">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Sold</p></div>
                                    </div><div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="available-qty" class="onoffswitch-checkbox" id="available-qty" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['available-qty']) && $setting['amazon']['amazon_pending_product']['available-qty'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['available-qty']) && $setting['amazon']['amazon_pending_product']['available-qty'] == 0) @else checked @endif>
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
                                                <input type="checkbox" name="shelf-qty" class="onoffswitch-checkbox" id="shelf-qty" tabindex="0" @if(isset($setting['amazon']['amazon_pending_product']['shelf-qty']) && $setting['amazon']['amazon_pending_product']['shelf-qty'] == 1) checked @elseif(isset($setting['amazon']['amazon_pending_product']['shelf-qty']) && $setting['amazon']['amazon_pending_product']['shelf-qty'] == 0) @else checked @endif>
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
                            <input type="hidden" id="secondKey" value="amazon_pending_product">
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
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">
                                    <div class="amazon-search-form">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Search on Amazon...." required>
                                            </div>
                                            <div class="submit-btn">
                                                <button class="search-btn waves-effect waves-light" type="submit" onclick="publish_catalogue_search();">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!--Pagination area start-->
                                    <div class="pagination-area">
                                        <form action="{{url('pagination-all')}}" method="post">
                                            @csrf
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num">{{$total_catalogue->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogue->currentPage() > 1)
                                                    <a class="first-page btn {{$total_catalogue->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_catalogue_info->first_page_url.$url : $total_catalogue_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$total_catalogue->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_catalogue_info->prev_page_url.$url : $total_catalogue_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$total_catalogue_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$total_catalogue_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="amazon/pending-catalogue">
                                                        <input type="hidden" name="query_params" value="{{$url}}">
                                                    </span>
                                                    @if($total_catalogue->currentPage() !== $total_catalogue->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $total_catalogue_info->next_page_url.$url : $total_catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $total_catalogue_info->last_page_url.$url : $total_catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                                    <div class="load__mask"></div>
                                    <span class="load__title">Content is loading...</span>
                                </div>
                            </div> --}}

                            <table class="amazon-table w-100 publish_search_result">
                                <thead>
                                    <form action="{{url('all-column-search')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="search_route" value="amazon/pending-catalogue">
                                        <tr>
                                            <th class="image text-center" style="width: 6% !important;">Image</th>
                                            <th class="id" style="width: 6%">
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
                                                    <div>ID</div>
                                                </div>
                                            </th>
                                            <th class="catalogue-name" style="width: 30%">
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
                                                            @if(isset($allCondition['category']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="category" value=" " class='btn btn-outline-info clear-params'><img src="{{asset('assets/common-assets/25.png')}}"></button>
                                                            </div>
                                                            @endif
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>
                                                    </div>
                                                    <div>Category</div>
                                                </div>
                                            </th>
                                            <th class="status" style="text-align: center !important; width: 10%">Status</th>
                                            <th class="stock filter-symbol" style="text-align: center !important; width: 8%;">
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
                                            <th class="product filter-symbol" style="text-align: center !important; width: 8%;">
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
                                            <th class="creator filter-symbol" style="width: 8%;">
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
                                            <th class="modifier filter-symbol" style="width: 8%;">
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
                                            <th style="width: 6%;">
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

                                <input type="hidden" id="amazon_status" name="amazon_status" value="amazon_ean_pending">
                                <input type="hidden" id="ean_status" name="ean_status" value="{{$ean}}">
                                <tbody id="search_reasult">
                                @isset($total_catalogue)
                                    @isset($allCondition)
                                    @if(count($total_catalogue) == 0 && count($allCondition) != 0)
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
                                    @if(isset($catalogue->ProductVariations[0]->stock) && $catalogue->ProductVariations[0]->stock > 0)
                                    <tr>
                                        <td class="image" style="width: 6%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                            <!--Start each row loader-->
                                            <div id="product_variation_loading{{$catalogue->id}}" class="variation_load" style="display: none;"></div>
                                            <!--End each row loader-->

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                             @isset($catalogue->single_image_info->image_url)
                                                <a href="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}"  title="Click to expand" target="_blank">
                                                    <img src="{{(filter_var($catalogue->single_image_info->image_url, FILTER_VALIDATE_URL) == FALSE) ? asset('/').$catalogue->single_image_info->image_url : $catalogue->single_image_info->image_url}}" class="amazon-image zoom" alt="catalogue-image">
                                                </a>
                                             @endisset
                                        </td>
{{--                                        <td class="id" style="width: 7%; text-align: center !important; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">--}}
                                        <td class="id" style="width: 7%; text-align: center !important;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$catalogue->id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="catalogue-name" style="width: 30%; cursor: pointer;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                            <a class="catalogue-name" href="{{route('product-draft.show',$catalogue->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Show Details">
                                                {!! Str::limit(strip_tags($catalogue->name),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <td class="category" style="text-align: center !important; cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle"> {{$catalogue->WooWmsCategory->category_name ?? ''}} </td>
                                        <td class="status text-center" style="cursor: pointer; width: 10%" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->status ?? ''}}</td>
                                        <td class="stock text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->ProductVariations[0]->stock ?? 0}}</td>
                                        <td class="product text-center" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">{{$catalogue->product_variations_count ?? 0}}</td>
                                        <td class="creator" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
                                            @if(isset($catalogue->user_info->name))
                                            <div class="wms-name-creator">
                                                <div data-tip="on {{date('d-m-Y', strtotime($catalogue->created_at))}}">
                                                    <strong class="@if($catalogue->user_info->deleted_at)text-danger @else text-success @endif">{{$catalogue->user_info->name ?? ''}}</strong>
                                                </div>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="modifier" style="cursor: pointer; width: 8%;" data-toggle="collapse" id="mtr-{{$catalogue->id}}" onclick="getVariation(this)" data-target="#demo{{$catalogue->id}}" class="accordion-toggle">
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
                                        <td class="actions" style="width: 6%;">
                                            <a href="{{url('amazon/create-amazon-product/'.$catalogue->id)}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="List On Amazon" target="_blank">
                                                <i class="fa fa-amazon"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!--hidden row -->
                                    <tr>
                                        <td colspan="13" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                            <div class="accordian-body collapse" id="demo{{$catalogue->id}}">
                                            </div> <!-- end accordion body -->
                                        </td> <!-- hide expand td-->
                                    </tr> <!-- hide expand row-->

                                    @endif
                                @endforeach
                                @endisset
                                </tbody>
                            </table>
                            <!--table below pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center"></div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num"> {{$total_catalogue->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($total_catalogue->currentPage() > 1)
                                                    <a class="first-page btn {{$total_catalogue->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_catalogue_info->first_page_url.$url : $total_catalogue_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$total_catalogue->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $total_catalogue_info->prev_page_url.$url : $total_catalogue_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1">{{$total_catalogue_info->current_page}} of<span class="total-pages">{{$total_catalogue_info->last_page}}</span></span>
                                                    </span>
                                                    @if($total_catalogue->currentPage() !== $total_catalogue->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $total_catalogue_info->next_page_url.$url : $total_catalogue_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $total_catalogue_info->last_page_url.$url : $total_catalogue_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
            console.log(ean_status)
            if(name == '' ){
                alert('Please type catalogue name in the search field.');
                return false;
            }
            ids = [0];
            searchPriority = 0;
            skip = 0;
            var status = $('#amazon_status').val();
            console.log(status)
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
            console.log(status);
            console.log(product_draft_id);
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
                    console.log(response)
                    $('#demo'+id).html(response);
                    console.log($('#demo'+id).html(response));
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

        //text hover shown
        $('.shown').on('hover', function(){
            var target = $(this).attr('hover-target');
            $(body).append(target);
            $('.'+target).display('toggle');
        });
    </script>
@endsection
