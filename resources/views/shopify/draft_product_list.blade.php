@extends('master')

@section('title')
    {{$page_title}}
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}">


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


                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="ebay">
                            <input type="hidden" id="secondKey" value="ebay_active_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                            <!--Pagination Count and Apply Button Section-->

                            <!--End Pagination Count and Apply Button Section-->

                        </div>
                    </div>
                </div>
                <!--//screen option-->


                 <!--Breadcrumb section-->
                 <div class="screen-option">
                    <div class="d-flex justify-content-start align-items-center">
                        <ol class="breadcrumb page-breadcrumb">
                            <li class="breadcrumb-item">Shopify</li>
                            <li class="breadcrumb-item active" aria-current="page">Draft Product</li>
                        </ol>
                    </div>
                    {{-- <div class="screen-option-btn">
                        <button class="btn btn-link waves-effect waves-light" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Screen Options &nbsp; <i class="fa" aria-hidden="true"></i>
                        </button>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion"></div>
                    </div> --}}
                </div>
                <!--End Breadcrumb section-->


                <!--Card box start-->
                <div class="row m-t-20">
                    <form class="col-md-12">
                        <div class="card-box ebay table-responsive shadow">

                            <!--Start Backend error handler-->


                            <!--End Backend error handler-->

                            <!--start table upper side content-->
                            <div class="m-b-20 m-t-10">
                                <div class="product-inner">
                                    <div class="ebay-master-product-search-form d-flex">
                                        <form class="d-flex" action="Javascript:void(0);" method="post">
                                            <div class="p-text-area">
                                                <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search on Shopify...." required>
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
                                                        <a class="first-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                        <a class="prev-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                    @endif
                                                        <span class="paging-input d-flex align-items-center">
                                                            <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                            <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$master_decode_product_list->current_page}}" size="3" aria-describedby="table-paging">
                                                            <span class="datatable-paging-text d-flex">of<span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                            <input type="hidden" name="first_page_url" value="{{$master_decode_product_list->first_page_url}}">
                                                            <input type="hidden" name="route_name" value="shopify/shopify-draft-product-list">
                                                            <input type="hidden" name="current_page" value="{{$master_product_list->currentPage()}}">
                                                        </span>
                                                        @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                        <a class="next-page btn" href="{{$master_decode_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                        <a class="last-page btn" href="{{$master_decode_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            <h5 class="search_result_count"></h5><!--search result count-->

                            <!--start table section-->
                            <!-- <div id="mytable"> -->
                            <table class="ebay-table w-100 mytable" id="testTable">
                                <!--start table head-->
                                <thead>
                                <tr>
                                    {{--                                    <th style="width: 6%; text-align: center"><input type="checkbox" id="checkAll">--}}
                                    {{--                                        <div class="product-inner">--}}
                                    {{--                                            <select id="checkCondition" required>--}}
                                    {{--                                                <option selected disabled>Select Option</option>--}}
                                    {{--                                                <option value="1">Relist</option>--}}
                                    {{--                                                <option value="2">Check Status</option>--}}
                                    {{--                                                <option value="3">Sync Quantity</option>--}}
                                    {{--                                                <option value="4">End Product</option>--}}
                                    {{--                                            </select>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <div class="product-inner"><button type="button" class="btn btn-default" style="cursor: pointer"  target="_blank" data-toggle="tooltip" data-placement="top" title="Send">Send</button></div>--}}
                                    {{--                                    </th>--}}
                                    <th class="image" style="width: 6% !important; text-align: center; vertical-align:top;">Image</th>
                                    <th class="item-id" style="width: 8%; vertical-align:top;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <form action="{{url('all-column-search')}}" method="post" id="reset-column-data">
                                                    @csrf
                                                    <input type="hidden" name="search_route" value="shopify/shopify-draft-product-list">
                                                    <input type="hidden" name="status" value="draft">
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="number" class="form-control input-text" name="id" id="id" value="{{$allCondition['id'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="id_opt_out" type="checkbox" name="id_opt_out" value="1" @isset($allCondition['id_opt_out']) checked @endisset><label for="id_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['id']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                            </div>
                                            <div>ID</div>
                                        </div>
                                    </th>
                                    <th class="product-type" style="width: 6% !important; vertical-align:top;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['product_type'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="product_type" id="product_type" value="{{$allCondition['product_type'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="product_type_opt_out" type="checkbox" name="product_type_opt_out" value="1" @isset($allCondition['product_type_opt_out']) checked @endisset><label for="product_type_opt_out">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['product_type']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="product_type" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Product Type</div>
                                        </div>
                                    </th>
                                    <th class="catalogue-id text-center" style="width: 8%; vertical-align:top;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['catalogue_id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="number" class="form-control input-text" name="catalogue_id" id="catalogue_id" value="{{$allCondition['catalogue_id'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="catalogue_opt_out" type="checkbox" name="catalogue_opt_out" value="1" @isset($allCondition['catalogue_opt_out']) checked @endisset><label for="catalogue_opt_out">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['catalogue_id']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="catalogue_id" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Catalogue ID</div>
                                        </div>
                                    </th>
                                    <th class="account text-center" style="width: 8%; vertical-align:top;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['account'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <!-- <input type="text" class="form-control input-text" name="search_value"> -->
                                                    <select class="form-control b-r-0 select2" name="account[]" id="account" multiple>

                                                        @foreach($channels as $channel)
                                                            @if(isset($allCondition['account']))
                                                                <option value="{{$channel->id}}" selected>{{$channel->account_name}}</option>
                                                            @else
                                                                <option value="{{$channel->id}}">{{$channel->account_name}}</option>
                                                            @endif

                                                        @endforeach
                                                    </select>
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="account_opt_out" type="checkbox" name="account_opt_out" value="1" @isset($allCondition['account_opt_out']) checked @endisset><label for="account_opt_out">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['account']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="account" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Account</div>
                                        </div>
                                    </th>
                                    <th class="product-name" style="width: 20%; vertical-align:top;">
                                        <div class="d-flex justify-content-start">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['title'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="title" id="title" value="{{$allCondition['title'] ?? ''}}">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="title_opt_out" type="checkbox" name="title_opt_out" value="1" @isset($allCondition['title_opt_out']) checked @endisset><label for="title_opt_out">Opt Out</label>
                                                    </div>
                                                    @if(isset($allCondition['title']))
                                                        <div class="individual_clr">
                                                            <button title="Clear filters" type="submit" name="title" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Product Name</div>
                                        </div>
                                    </th>
                                    {{--                                    <th class="category" style="width: 20%">Category</th>--}}
                                    <th class="stock filter-symbol" style="width: 5%; vertical-align:top;">
                                        <div class="d-flex justify-content-center">
                                            <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa @isset($allCondition['stock'])text-warning @endisset" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content stock-filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <div class="d-flex">
                                                        <div>
                                                            <select class="form-control" name="stock_opt" id="stockRrpOpt">
                                                                <option value=""></option>
                                                                <option value="=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '=')) selected @endif>=</option>
                                                                <option value="<" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '<')) selected @endif><</option>
                                                                <option value=">" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '>')) selected @endif>></option>
                                                                <option value="<=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '≤')) selected @endif>≤</option>
                                                                <option value=">=" @if(isset($allCondition['stock_opt']) && ($allCondition['stock_opt'] == '≥')) selected @endif>≥</option>
                                                            </select>
                                                        </div>
                                                        <div class="ml-2">
                                                            <input type="number" step="any" class="form-control input-text symbol-filter-input-text" name="stock" id="stock" value="{{$allCondition['stock'] ?? ''}}">
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
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply<i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Stock</div>
                                        </div>
                                    </th>
                                    {{--                                    <th class="profile text-center" style="width: 8%">--}}
                                    {{--                                        <div class="d-flex justify-content-center">--}}
                                    {{--                                            <div class="btn-group">--}}
                                    {{--                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
                                    {{--                                                    @if(isset($search_value['profile_name']['value']))--}}
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
                                    {{--                                                    <select class="form-control select2 b-r-0" name="search_value[profile_name][value]">--}}
                                    {{--                                                        @isset($profile_name_list)--}}
                                    {{--                                                            @if($profile_name_list->count() == 1)--}}
                                    {{--                                                                @foreach($profile_name_list as $profile_name)--}}
                                    {{--                                                                    <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>--}}
                                    {{--                                                                @endforeach--}}
                                    {{--                                                            @else--}}
                                    {{--                                                                @if(isset($search_value['profile_name']['value']))--}}
                                    {{--                                                                    <option value="">Select Profile</option>--}}
                                    {{--                                                                    @foreach($profile_name_list as $profile_name)--}}
                                    {{--                                                                        @if($search_value['profile_name']['value'] == $profile_name->profile_name)--}}
                                    {{--                                                                            <option value="{{$profile_name->profile_name}}" selected>{{$profile_name->profile_name}}</option>--}}
                                    {{--                                                                        @else--}}
                                    {{--                                                                            <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>--}}
                                    {{--                                                                        @endif--}}
                                    {{--                                                                    @endforeach--}}
                                    {{--                                                                @else--}}
                                    {{--                                                                    <option value="" selected>Select Profile</option>--}}
                                    {{--                                                                    @foreach($profile_name_list as $profile_name)--}}
                                    {{--                                                                        <option value="{{$profile_name->profile_name}}">{{$profile_name->profile_name}}</option>--}}
                                    {{--                                                                    @endforeach--}}
                                    {{--                                                                @endif--}}
                                    {{--                                                            @endif--}}
                                    {{--                                                        @endisset--}}
                                    {{--                                                    </select>--}}
                                    {{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
                                    {{--                                                        <input id="opt-out4" type="checkbox" name="search_value[profile_name][opt_out]" value="1" @isset($search_value['profile_name']['opt_out']) checked @endisset><label for="opt-out4" >Opt Out</label>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    @if(isset($search_value['profile_name']['value']))--}}
                                    {{--                                                        <div class="individual_clr">--}}
                                    {{--                                                            <button title="Clear filters" type="submit" name="search_value[profile_name][value]" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    @endif--}}
                                    {{--                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                            <div>Profile</div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </th>--}}
                                    <th class="status text-center" style="width: 8%; vertical-align:top;">
                                        <div class="d-flex justify-content-center">
{{--                                            <div class="btn-group">--}}
{{--                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">--}}
{{--                                                    @if(isset($search_value['product_status']['value']))--}}
{{--                                                        <i class="fa text-warning" aria-hidden="true"></i>--}}
{{--                                                    @else--}}
{{--                                                        <i class="fa" aria-hidden="true"></i>--}}
{{--                                                    @endif--}}
{{--                                                </a>--}}
{{--                                                <div class="form-group dropdown-menu filter-content shadow" role="menu">--}}
{{--                                                    <label>Filter Value</label>--}}
{{--                                                    <select class="form-control select2 b-r-0" name="search_value[product_status][value]">--}}
{{--                                                        @if(isset($search_value['product_status']['value']))--}}
{{--                                                            <option value="">Select Status</option>--}}
{{--                                                            @if($search_value['product_status']['value'] == 'Active')--}}
{{--                                                                <option value="Active" selected>Active</option>--}}
{{--                                                                <option value="Completed">Draft</option>--}}
{{--                                                            @else--}}
{{--                                                                <option value="Active" >Active</option>--}}
{{--                                                                <option value="Completed" selected>Draft</option>--}}
{{--                                                            @endif--}}
{{--                                                        @else--}}
{{--                                                            <option value=""selected>Select Status</option>--}}
{{--                                                            <option value="Active">Active</option>--}}
{{--                                                            <option value="Completed">Draft</option>--}}
{{--                                                        @endif--}}
{{--                                                    </select>--}}
{{--                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">--}}
{{--                                                        <input id="opt-out8" type="checkbox" name="search_value[product_status][opt_out]" value="1" @isset($search_value['product_status']['opt_out']) checked @endisset><label for="opt-out8" >Opt Out</label>--}}
{{--                                                    </div>--}}
{{--                                                    @if(isset($search_value['product_status']['value']))--}}
{{--                                                        <div class="individual_clr">--}}
{{--                                                            <button title="Clear filters" type="submit" name="search_value['product_status']['value']" value="" class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>--}}
{{--                                                        </div>--}}
{{--                                                    @endif--}}
{{--                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                            <div>Status</div>
                                        </div>
                                    </th>
                                    <th class="creator text-center" style="width: 8%; vertical-align:top;">
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
                                                            <button title="Clear filters" type="creator" name="product" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                        </div>
                                                    @endif
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </div>
                                            <div>Creator</div>
                                        </div>
                                    </th>
                                    <th class="modifier text-center" style="width: 8%; vertical-align:top;">
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
                                                                <button title="Clear filters" type="creator" name="modifier" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>
                                                </div>
                                            <div>Modifier</div>
                                        </div>
                                        </form>
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
                        </thead>
                        <!--End table head-->

                        <!--start table body-->
                        <tbody id="ebay_search">
                        @isset($master_product_list)
                            @isset($allCondition)
                            @if(count($master_product_list) == 0 && count($allCondition) != 0)
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

                            <tr class="variation_load_tr">
                                {{--                                <td style="width: 6%; text-align: center !important;">--}}
                                {{--                                    <input type="checkbox" class="checkBoxClass" id="checkItem{{$index}}" name="masterProduct[{{$index}}]" value="{{$product_list->id}}">--}}
                                {{--                                </td>--}}
                                <td class="image" style="cursor: pointer; width: 6% !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                    <!--Start each row loader-->
                                    <div id="product_variation_loading{{$product_list->id}}" class="variation_load" style="display: none;"></div>
                                    <!--End each row loader-->

                                    <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                    @if(isset( \Opis\Closure\unserialize($product_list->image)[0]['src']))
                                        <a href=""  title="Click to expand" target="_blank"><img src="{{\Opis\Closure\unserialize($product_list->image)[0]['src']}}" class="ebay-image zoom" alt="ebay-master-image"></a>
                                    @else
                                        <img src="{{asset('assets/common-assets/no_image.jpg')}}" class="ebay-image zoom" alt="ebay-master-image">
                                    @endif

                                </td>
                                <td class="item-id" style="width: 8%">
                                    <span id="master_opc_{{$product_list->id}}">
                                         <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->id}}</span>
                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                         </div>
                                    </span>
                                </td><td class="item-id" style="width: 8%">
                                    <span id="master_opc_{{$product_list->product_type}}">
                                         <div class="id_tooltip_container d-flex justify-content-start align-items-center">
                                            <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->product_type}}</span>
                                            <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                         </div>
                                    </span>
                                </td>
                                {{--                                <td class="product-type">--}}
                                {{--                                    <div style="text-align: center;">--}}
                                {{--                                        @if($product_list->type == 'simple')--}}
                                {{--                                            Simple--}}
                                {{--                                        @else--}}
                                {{--                                            Variation--}}
                                {{--                                        @endif--}}
                                {{--                                    </div>--}}
                                {{--                                </td>--}}
                                {{--                                        <td class="catalogue-id" style="cursor: pointer; width: 10%; text-align: center !important;" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                                <td class="catalogue-id" style="width: 8%; text-align: center !important;">
                                    <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                        <span title="Click to Copy" onclick="textCopiedID(this);" class="id_copy_button">{{$product_list->master_catalogue_id}}</span>
                                        <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                    </div>
                                </td>
                                <td class="account" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->account_id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->account_id}}" class="accordion-toggle">
                                    @isset(\App\shopify\ShopifyAccount::find($product_list->account_id)->account_name)
                                        {{\App\shopify\ShopifyAccount::find($product_list->account_id)->account_name}}
                                    @endisset
                                </td>
                                <td class="product-name" style="cursor: pointer; width: 20%" data-toggle="collapse" id="mtr-{{$product_list->id}}" data-target="#demo{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top" title="{{$product_list->title}}">
                                    <a class="ebay-product-name" href="" target="_blank">
                                        {!! Str::limit(strip_tags($product_list->title),$limit = 45, $end = '...') !!}
                                    </a>
                                </td>
                                @php
                                    $total_quantity = 0;
                                    foreach ($product_list->variationProducts as $variation){
                                        $total_quantity += $variation->stock;
                                    }
                                    $creatorInfo = \App\User::withTrashed()->find($product_list->creator_id);
                                    $modifierInfo = \App\User::withTrashed()->find($product_list->modifier_id);
                                @endphp
                                <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}
                                </td>
                                <td class="status" style="cursor: pointer; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" data-target="#demo{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle" data-toggle="tooltip" data-placement="top">
                                    {{$product_list->status}}
                                </td>
                                {{--                                <td class="category" style="cursor: pointer; width: 20%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$product_list->category_name}}</td>--}}
                                {{--                                <td class="stock" style="cursor: pointer; text-align: center !important; width: 5%" data-toggle="collapse" data-target="#demo{{$product_list->id}}" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" class="accordion-toggle">{{$total_quantity}}</td>--}}

                                {{--                                <td class="status" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">--}}
                                {{--                                    @if($product_list->product_status == "Active")--}}
                                {{--                                        Active--}}
                                {{--                                    @elseif($product_list->product_status == "Completed")--}}
                                {{--                                        @php--}}
                                {{--                                            $total_quantity = 0;--}}
                                {{--                                            foreach ($product_list->variationProducts as $variation){--}}
                                {{--                                                $total_quantity += $variation->quantity;--}}
                                {{--                                            }--}}
                                {{--                                            if ($total_quantity == 0){--}}
                                {{--                                                echo "Sold Out";--}}
                                {{--                                            }elseif ($total_quantity > 0){--}}
                                {{--                                                echo "Ended";--}}
                                {{--                                            }--}}
                                {{--                                        @endphp--}}

                                {{--                                    @endif--}}
                                {{--                                </td>--}}


                                <td class="creator" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                    @if(isset($creatorInfo->name))
                                    <div class="wms-name-creator">
                                        <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                                            <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                                <td class="modifier" style="cursor: pointer; text-align: center !important; width: 8%" data-toggle="collapse" id="mtr-{{$product_list->id}}" onclick="getVariation(this)" data-target="#demo{{$product_list->id}}" class="accordion-toggle">
                                    @if(isset($modifierInfo->name))
                                        <div class="wms-name-modifier1">
                                            <div data-tip="on {{date('d-m-Y', strtotime($product_list->updated_at))}}">
                                                <strong class="@if($modifierInfo->deleted_at) text-danger @else text-success @endif">{{$modifierInfo->name ?? ''}}</strong>
                                            </div>
                                        </div>
                                    @elseif(isset($creatorInfo->name))
                                        <div class="wms-name-modifier2">
                                            <div data-tip="on {{date('d-m-Y', strtotime($product_list->created_at))}}">
                                                <strong class="@if($creatorInfo->deleted_at) text-danger @else text-success @endif">{{$creatorInfo->name ?? ''}}</strong>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="actions" style="width: 6%">
                                        <div class="align-items-center mr-2"> <a class="btn-size list-woocommerce-btn" href="{{url('shopify/catalogue/active/'.$product_list->id)}}" data-toggle="tooltip" data-placement="top" title="Active Product"><i class="fab fa-shopify" aria-hidden="true"></i></a></div>
                                    <!--start manage button area-->
{{--                                    <div class="btn-group dropup">--}}
{{--                                        <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                            Manage--}}
{{--                                        </button>--}}
{{--                                        <!--start dropup content-->--}}
{{--                                        <div class="dropdown-menu">--}}
{{--                                            <div class="dropup-content ebay-dropup-content" style="padding: 14px 20px 8px 20px !important;">--}}
{{--                                                <div class="action-1">--}}
{{--                                                    @if($product_list->product_status == 'Completed' && $total_quantity !=0)--}}
{{--                                                        <div class="align-items-center mr-2"><a class="btn-size btn-dark" style="cursor: pointer" href="{{url('relist-end-listing/'.$product_list->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Relist"><i class="fa fa-registered" aria-hidden="true"></i></a></div>--}}
{{--                                                    @endif--}}
{{--                                                    <div class="align-items-center mr-2"><a class="btn-size edit-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id.'/edit')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a></div>--}}
{{--                                                    <div class="align-items-center mr-2"><a class="btn-size view-btn" style="cursor: pointer" href="{{url('ebay-master-product/'.$product_list->id).'/view'}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></div>--}}
{{--                                                    <div class="align-items-center mr-2">--}}
{{--                                                        <form action="{{url('ebay-ended-product-check')}}" method="POST" >--}}
{{--                                                            @csrf--}}
{{--                                                            <input type="hidden" name="products[]" value="{{$product_list->id}}">--}}
{{--                                                            <button type="submit" class="btn-size btn-dark check-status-btn" style="cursor: pointer" target="_blank" data-toggle="tooltip" data-placement="top" title="Check Status"><i class="fa fa-hourglass-end" aria-hidden="true"></i></button>--}}
{{--                                                        </form>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="align-items-center"> <a class="btn-size delete-btn" href="{{url('shopify/product-delete/'.$product_list->id)}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('Master Product');"><i class="fa fa-trash" aria-hidden="true"></i></a></div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <!--End dropup content-->--}}
{{--                                    </div>--}}
                                    <!--End manage button area-->
                                </td>
                            </tr>



                            <!--hidden row -->
                            <tr>
                                <td colspan="15" class="hiddenRow" style="padding: 0; background-color: #ccc">
                                    <div class="accordian-body collapse" id="demo{{$product_list->id}}">

                                    </div> <!-- end accordion body -->
                                </td> <!-- hide expand td-->
                            </tr> <!-- hide expand row-->


                        @endforeach
                        @endisset
                        </tbody>
                        <!--End table body-->

                        </table>
                        <!-- </div> -->
                        <!--End table section-->

                        <!--table below pagination sec-->
                        <div class="row table-foo-sec">
                            <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end align-items-center py-2">
                                    <div class="pagination-area">
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num pr-1"> {{$master_product_list->total()}} items </span>
                                            <span class="pagination-links d-flex">
                                                        @if($master_product_list->currentPage() > 1)
                                                    <a class="first-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                            <span class="screen-reader-text d-none">First page</span>
                                                            <span aria-hidden="true">«</span>
                                                        </a>
                                                    <a class="prev-page btn {{ $master_product_list->currentPage() > 1 ? '' : 'disabled' }}" href="{{$master_decode_product_list->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                            <span class="screen-reader-text d-none">Previous page</span>
                                                            <span aria-hidden="true">‹</span>
                                                        </a>
                                                @endif
                                                        <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                        <span class="paging-input d-flex align-items-center">
                                                            <span class="datatable-paging-text  d-flex pl-1"> {{$master_decode_product_list->current_page}} of <span class="total-pages">{{$master_decode_product_list->last_page}}</span></span>
                                                        </span>
                                                        @php
                                                            if (isset($search_value)){
                                                                $search_value = \Opis\Closure\serialize($search_value);
                                                            }else{
                                                                $search_value = '';
                                                            }
                                                            $page =  $master_product_list->currentPage()+1;

                                                        @endphp
                                                @if($master_product_list->currentPage() !== $master_product_list->lastPage())
                                                    <a class="next-page btn" href="{{$master_decode_product_list->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                            <span class="screen-reader-text d-none">Next page</span>
                                                            <span aria-hidden="true">›</span>
                                                        </a>
                                                    <a class="last-page btn" href="{{$master_decode_product_list->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        //Select option jquery
        $('.select2').select2();

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

            ids = [0];
            searchPriority = 0;
            skip = 0;
            // var category_id = $('#category_id').val();
            $.ajax({
                type: "POST",
                url: "{{url('ebay-master-product-search')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "name": search_value,
                    "search_priority": searchPriority,
                    "skip": skip,
                    "take": take,
                    "ids": ids,
                },
                beforeSend: function(){
                    // Show image container
                    $("#ajax_loader").show();
                },
                success: function(response){
                    if(response != 'error') {
                        $('tbody').html(response.html);
                        searchPriority = response.search_priority;
                        take = response.take;
                        skip = parseInt(response.skip)+10;
                        ids = ids.concat(response.ids);
                    }else{
                        $("#ajax_loader").hide();
                        alert('No Catalogue Found');
                    }
                },complete: function () {
                    $("#ajax_loader").hide();
                }
            });
        }

        $(document).bind("scroll", function(e){

            //if ($(document).scrollTop() >= ((parseFloat($(document).height()).toFixed(2)) * parseFloat((0.75).toFixed(2)))) {
            if($(window).scrollTop() >= ($(document).height() - $(window).height())-150){
                var search_value = $('#search_value').val();

                if(search_value != '' ){

                    $.ajax({
                        type: 'POST',
                        url: '{{url('ebay-master-product-search')}}',
                        data: {
                            "_token" : "{{csrf_token()}}",
                            "name": search_value,
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
                            $('#ebay_search').append(response.html);
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


        $('.product-inner button').click(function () {
            var condition = $("#checkCondition").val();
            // console.log(condition)
            var account_id = $('select[name="search_value[account_name][value]"]').val();

            var url = '';
            var product_id = [];
            $('table tbody tr td :checkbox:checked').each(function(i){
                product_id[i] = $(this).val();
            });
            if (condition == 1){
                url = 'relist-end-listing';
            }else if(condition == 2){
                url = 'ebay-ended-product-check';
            }else if(condition == 3){
                url ='quantity-sync';
            }else if(condition == 4){
                url = 'end-product'
            }
            console.log(url)
            if(url != ''){
                $.ajax({
                    type: "POST",
                    url: "{{URL::to('/')}}"+'/'+url,
                    data: {
                        "_token" : "{{csrf_token()}}",

                        "products" : product_id,
                        "account_id": account_id
                    },
                    beforeSend: function(){
                        // Show image container
                        $("#ajax_loader").show();
                    },
                    success: function (response) {
                        // console.log(response)
                        $("#ajax_loader").hide();
                        // console.log(response);
                        if(response != 0) {
                            location.reload();
                        }else{
                            // console.log('else');
                            alert(response);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('error');
                        $("#ajax_loader").hide();
                        //alert("Status: " + textStatus);
                        alert("Error: " + XMLHttpRequest.responseJSON.message);
                    }
                });
            }

        });


        function getVariation(e){
            var product_draft_id = e.id;
            product_draft_id = product_draft_id.split('-');
            var status = $('ebay_status').val();
            var id = product_draft_id[1]


            $.ajax({
                type: "post",
                url: "{{url('shopify/get-shopify-variation')}}",
                data: {
                    "_token" : "{{csrf_token()}}",
                    "product_draft_id" : id,
                    "status" : status,
                },
                beforeSend: function () {
                    $('#product_variation_loading'+id).show();
                    console.log('product_variation_loading'+id);
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


        // $('.filter-btn').on('click', function() {
        //     $(this).closest('table thead tr th').toggleClass('filter-red');
        // })


    </script>



@endsection
