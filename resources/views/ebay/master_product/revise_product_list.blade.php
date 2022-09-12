@extends('master')

@section('title')
    {{$page_title}}
@endsection


@section('content')

    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>

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

                            <div class="row content-inner catalogue-draft-details mt-2 mb-2">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="image" class="onoffswitch-checkbox" id="image" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['image']) && $setting['ebay']['ebay_revise_product']['image'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['image']) && $setting['ebay']['ebay_revise_product']['image'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="image">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Image</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="item-id" class="onoffswitch-checkbox" id="item-id" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['item-id']) && $setting['ebay']['ebay_revise_product']['item-id'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['item-id']) && $setting['ebay']['ebay_revise_product']['item-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="item-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Item ID</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="catalogue-id" class="onoffswitch-checkbox" id="catalogue-id" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['catalogue-id']) && $setting['ebay']['ebay_revise_product']['catalogue-id'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['catalogue-id']) && $setting['ebay']['ebay_revise_product']['catalogue-id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="catalogue-id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Catalogue ID</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="product-name" class="onoffswitch-checkbox" id="product-name" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['product-name']) && $setting['ebay']['ebay_revise_product']['product-name'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['product-name']) && $setting['ebay']['ebay_revise_product']['product-name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="product-name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Product Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="category" class="onoffswitch-checkbox" id="category" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['category']) && $setting['ebay']['ebay_revise_product']['category'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['category']) && $setting['ebay']['ebay_revise_product']['category'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="category">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Category</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="profile" class="onoffswitch-checkbox" id="profile" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['profile']) && $setting['ebay']['ebay_revise_product']['profile'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['profile']) && $setting['ebay']['ebay_revise_product']['profile'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="profile">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Profile</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="account" class="onoffswitch-checkbox" id="account" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['account']) && $setting['ebay']['ebay_revise_product']['account'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['account']) && $setting['ebay']['ebay_revise_product']['account'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="account">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Account</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="revise-status" class="onoffswitch-checkbox" id="revise-status" tabindex="0" @if(isset($setting['ebay']['ebay_revise_product']['revise-status']) && $setting['ebay']['ebay_revise_product']['revise-status'] == 1) checked @elseif(isset($setting['ebay']['ebay_revise_product']['revise-status']) && $setting['ebay']['ebay_revise_product']['revise-status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="revise-status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Revise Status</p></div>
                                    </div>
                                </div>
                            </div>

                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->

                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="ebay">
                            <input type="hidden" id="secondKey" value="ebay_revise_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count and Apply Button Section-->
                            <div class="d-flex justify-content-between pagination-content">
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
                            <li class="breadcrumb-item active" aria-current="page">Revise Product</li>
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
                                                        <a class="first-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$all_decode_revise_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                        <a class="prev-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$all_decode_revise_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_revise_product->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$all_decode_revise_product->last_page}}</span></span>
                                                        <input type="hidden" name="first_page_url" value="{{$all_decode_revise_product->first_page_url}}">
                                                        <input type="hidden" name="route_name" value="ebay-revise-product-list">
                                                        <input type="hidden" name="current_page" value="{{$master_product_list->currentPage()}}">
                                                    </span>
                                                    @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_revise_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                        <a class="last-page btn" href="{{$all_decode_revise_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            <table class="ebay-table ebay-table-n w-100">
                                <thead>
                                <tr>
                                    <th style="width: 6%; text-align: center"><input type="checkbox" id="checkAll"> <div class="product-inner"><button type="button" class="btn btn-default" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Revise">Revise</button></div></th>
                                    <th class="image text-center">Image</th>
                                    <th class="item-id" style="width: 8%">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('eBay/revise/product/search')}}" method="get">
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
                                            <div>Item ID</div>
                                        </div>
                                    </th>
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
                                                        <input id="opt-out2" type="checkbox" name="search_value[master_product_id][opt_out]" value="1" @isset($search_value['master_product_id']['opt_out']) checked @endisset><label for="opt-out2">Opt Out</label>
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
{{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                        <input id="opt-out2" type="checkbox" name="search_value[title][opt_out]" value="1" ><label for="opt-out2">Opt Out</label>--}}
{{--                                                    </div>--}}
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out6" type="checkbox" name="search_value[title][opt_out]" value="1" @isset($search_value['title']['opt_out']) checked @endisset><label for="opt-out6">Opt Out</label>
                                                    </div>
{{--                                                    <input type="hidden" name="column_name" value="name">--}}
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
{{--                                            <div class="btn-group">--}}
{{--                                                --}}{{--                                                <form action="{{url('eBay/pending/product/search')}}" method="post">--}}
{{--                                                --}}{{--                                                    @csrf--}}
{{--                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                    @if(isset($search_value['category']['value']))--}}
{{--                                                        <i class="fa text-warning" aria-hidden="true"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    @endif--}}
{{--                                                </a>--}}
{{--                                                <div class="dropdown-menu filter-content shadow" role="menu">--}}
{{--                                                    <p>Filter Value</p>--}}
{{--                                                    @php--}}
{{--                                                        $woowms_category_info = \App\WooWmsCategory::orderBy('category_name', 'ASC')->get();--}}
{{--                                                    @endphp--}}
{{--                                                    <select class="form-control b-r-0" name="search_value[category][value]">--}}
{{--                                                        @if(isset($woowms_category_info))--}}
{{--                                                            @if($woowms_category_info->count() == 1)--}}
{{--                                                                @foreach($woowms_category_info as $category_name)--}}
{{--                                                                    <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>--}}
{{--                                                                @endforeach--}}
{{--                                                            @else--}}
{{--                                                                @if(isset($search_value['category']['value']))--}}
{{--                                                                    <option value="">Select Category</option>--}}
{{--                                                                    @foreach($woowms_category_info as $category_name)--}}
{{--                                                                        @if($category_name->id == $search_value['category']['value'])--}}
{{--                                                                            <option value="{{$category_name->id}}" selected>{{$category_name->category_name}}</option>--}}
{{--                                                                        @else--}}
{{--                                                                            <option value="{{$category_name->id}}" >{{$category_name->category_name}}</option>--}}
{{--                                                                        @endif--}}
{{--                                                                    @endforeach--}}
{{--                                                                @else--}}
{{--                                                                    <option value="" selected>Select Category</option>--}}
{{--                                                                    @foreach($woowms_category_info as $category_name)--}}
{{--                                                                        <option value="{{$category_name->id}}">{{$category_name->category_name}}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}
{{--                                                        @endisset--}}
{{--                                                    </select>--}}
{{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                        <input id="opt-out3" type="checkbox" name="search_value[category][opt_out]" value="1"><label for="opt-out3">Opt Out</label>--}}
{{--                                                    </div>--}}
{{--                                                    <input type="hidden" name="column_name" value="woowms_category">--}}
{{--                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                </div>--}}
{{--                                                --}}{{--                                                </form>--}}
{{--                                            </div>--}}
                                            <div>Category</div>
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
                                                                    <option value="{{$profile_name->id}}">{{$profile_name->profile_name}}</option>
                                                                @endforeach
                                                            @else
                                                                @if(isset($search_value['profile_name']['value']))
                                                                    <option value="">Select Profile</option>
                                                                    @foreach($profile_name_list as $profile_name)
                                                                        @if($search_value['profile_name']['value'] == $profile_name->id)
                                                                            <option value="{{$profile_name->id}}" selected>{{$profile_name->profile_name}}</option>
                                                                        @else
                                                                            <option value="{{$profile_name->id}}">{{$profile_name->profile_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <option value="" selected>Select Profile</option>
                                                                    @foreach($profile_name_list as $profile_name)
                                                                        <option value="{{$profile_name->id}}">{{$profile_name->profile_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        @endisset
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out4" type="checkbox" name="search_value[profile_name][opt_out]" value="1" @isset($search_value['profile_name']['opt_out']) checked @endisset><label for="opt-out4">Opt Out</label>
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
                                                        <input id="opt-out5" type="checkbox" name="search_value[account_name][opt_out]" value="1" @isset($search_value['account_name']['opt_out']) checked @endisset><label for="opt-out5">Opt Out</label>
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
                                    <th class="revise-status text-center" style="width: 8%">
                                        <div class="d-flex justify-content-center">
{{--                                            <div class="btn-group">--}}
{{--                                                --}}{{--                                                <form action="{{url('eBay/active/product/search')}}" method="post">--}}
{{--                                                --}}{{--                                                    @csrf--}}
{{--                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                    @if(isset($search_value['revise_status']['value']))--}}
{{--                                                        <i class="fa text-warning" aria-hidden="true"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    @endif--}}
{{--                                                </a>--}}
{{--                                                <div class="form-group dropdown-menu filter-content shadow" role="menu">--}}
{{--                                                    <label>Filter Value</label>--}}
{{--                                                    @php--}}
{{--                                                        $profile_name_list = \App\EbayProfile::orderBy('profile_name', 'ASC')->get();--}}
{{--                                                    @endphp--}}
{{--                                                    <select class="form-control select2 b-r-0" name="search_value[product_status][value]">--}}
{{--                                                        @if(isset($search_value['revise_status']['value']))--}}
{{--                                                            <option value="">Select Status</option>--}}
{{--                                                            @if($search_value['revise_status']['value'] == 'Active')--}}
{{--                                                                <option value="1" selected>Active</option>--}}
{{--                                                                <option value="0">Ended</option>--}}
{{--                                                            @else--}}
{{--                                                                <option value="1" >Active</option>--}}
{{--                                                                <option value="0" selected>Ended</option>--}}
{{--                                                            @endif--}}
{{--                                                        @else--}}
{{--                                                            <option value=""selected>Select Status</option>--}}
{{--                                                            <option value="1">Active</option>--}}
{{--                                                            <option value="0">Ended</option>--}}
{{--                                                        @endif--}}
{{--                                                    </select>--}}
{{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                        <input id="opt-out8" type="checkbox" name="search_value[revise_status][opt_out]" value="1"><label for="opt-out8">Opt Out</label>--}}
{{--                                                    </div>--}}
{{--                                                    --}}{{--                                                        <input type="hidden" name="column_name" value="product_status">--}}
{{--                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                </div>--}}
{{--                                                --}}{{--                                                </form>--}}
{{--                                            </div>--}}
                                            <div>Status</div>
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
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
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
                                    <tr>
                                        <td style="width: 6%; text-align: center !important;">

                                                {{--                                                    <input type="checkbox" class="checkBoxClass" id="customCheck{{$pending->id}}" name="multiple_order[]" value="{{$pending->id}}">--}}
                                            <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">

                                        </td>
                                        <td class="image" style="text-align: center !important;">

                                            <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                            @if(isset( \Opis\Closure\unserialize($product_list->master_images)[0]))
                                                <a href=""  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->master_images)[0]}}" class="ebay-image" alt="revise-image"></a>
                                            @else
                                                <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image" alt="revise-image">
                                            @endif
                                        </td>
                                        <td class="item-id" style="text-align: center !important;"><span id="master_opc_{{$product_list->item_id}}">{{$product_list->item_id}}</span></td>
                                        <td class="catalogue-id" style="text-align: center !important;">
                                            <div class="id_tooltip_container d-flex justify-content-center align-items-start">
                                                <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->master_product_id}}</span>
                                                <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a class="ebay-product-name" class="ebay-product-name" href="https://www.ebay.co.uk/itm/{{$product_list->item_id}}" target="_blank">
                                                {!! Str::limit(strip_tags($product_list->title),$limit = 100, $end = '...') !!}
                                            </a>
                                        </td>
                                        <td class="category" style="text-align: center !important;">{{$product_list->category_name}}</td>
                                        <td class="profile" style="text-align: center !important;">
                                            @isset(\App\EbayProfile::find($product_list->profile_id)->profile_name)
                                                {{\App\EbayProfile::find($product_list->profile_id)->profile_name}}
                                            @endisset
                                        </td>
                                        <td class="account" style="text-align: center !important;">
                                            @isset(\App\EbayAccount::find($product_list->account_id)->account_name)
                                                {{\App\EbayAccount::find($product_list->account_id)->account_name}}
                                            @endisset
                                        </td>
                                        <td class="revise-status" style="text-align: center !important;">
                                            @if($product_list->profile_status == 0)
                                                <div class="align-items-center mr-2"><a class="btn-size btn-danger" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Profile changed"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a></div>
                                            @else
                                                <div class="align-items-center mr-2"><a class="btn-size btn-success" style="cursor: pointer" href="" target="_blank" data-toggle="tooltip" data-placement="top" title="No Changes"><i class="fa fa-check" aria-hidden="true"></i></a></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <div class="dropdown-menu">
                                                    <div class="ebay-dropup-content">
                                                        <div class="d-flex justify-content-start align-items-center">
                                                            <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
                                                            <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('ebay-delete-listing/'.$product_list->id.'/'.$product_list->item_id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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
                                                    <span class="displaying-num pr-1"> {{$master_product_list->total()}} items</span>
                                                    <span class="pagination-links d-flex">
                                                        @if($master_product_list->currentPage() > 1)
                                                        <a class="first-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_revise_product->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{$master_product_list->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_revise_product->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                        @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text  d-flex pl-1"> {{$all_decode_revise_product->current_page}} of <span class="total-pages">{{$all_decode_revise_product->last_page}}</span></span>
                                                        </span>
                                                        @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                        <a class="next-page btn" href="{{$all_decode_revise_product->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$all_decode_revise_product->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                <!--End Card box -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>  <!-- content page-->

    <script type="text/javascript">

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
            var category_id = $('#category_id').val();
            console.log(status);
            $.ajax({
                type: "POST",
                url: "{{url('onbuy/search-product-list')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "name": search_value
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    $('ul.pagination').hide();
                    $('table tbody').html(response);


                },
                complete:function(data){
                    // Hide image container
                    $("#ajax_loader").hide();
                }
            });
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



        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $('.product-inner button').click(function () {
            console.log('test');
            var product_id = [];
            $('table tbody tr td :checkbox:checked').each(function(i){
                product_id[i] = $(this).val();
            });

            $.ajax({
                type: "POST",
                url: "{{url('ebay-master-product-revise')}}",
                data: {
                    "_token" : "{{csrf_token()}}",

                    "products" : product_id
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function (response) {
                    $("#ajax_loader").hide();
                    console.log(response);
                    if(response != 0) {
                        location.reload();
                    }else{
                        alert(response);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    //console.log(XMLHttpRequest.responseJSON.message);
                    $("#ajax_loader").hide();
                    //alert("Status: " + textStatus);
                    alert("Error: " + XMLHttpRequest.responseJSON.message);
                }
            });
        });

    </script>



@endsection
