@extends('master')

@section('title')
    Activity Logs | WMS360
@endsection

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">

                <!--screen option-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box screen-option-content p-t-30 p-b-30" style="display: none; padding-top: 25px; padding-bottom: 25px;">

                            <!--Order by channel sync area-->

                            <!--End Order by channel sync area-->


                            <!---------------------------ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->
                            <div class="row content-inner screen-option-responsive-content-inner">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="id" class="onoffswitch-checkbox" id="id" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['id']) && $setting['activitylog']['activity_log_active_product']['id'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['id']) && $setting['activitylog']['activity_log_active_product']['id'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="id">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>ID</p></div>
                                    </div>
                                    <!-- <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="url" class="onoffswitch-checkbox" id="url" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="url">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>URL</p></div>
                                    </div> -->
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="action_name" class="onoffswitch-checkbox" id="action_name" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['action_name']) && $setting['activitylog']['activity_log_active_product']['action_name'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['action_name']) && $setting['activitylog']['activity_log_active_product']['action_name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="action_name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Action Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="account_name" class="onoffswitch-checkbox" id="account_name" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['account_name']) && $setting['activitylog']['activity_log_active_product']['account_name'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['account_name']) && $setting['activitylog']['activity_log_active_product']['account_name'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="account_name">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Account Name</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="channel" class="onoffswitch-checkbox" id="channel" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['channel']) && $setting['activitylog']['activity_log_active_product']['channel'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['channel']) && $setting['activitylog']['activity_log_active_product']['channel'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="channel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Channel</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sku" class="onoffswitch-checkbox" id="sku" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['sku']) && $setting['activitylog']['activity_log_active_product']['sku'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['sku']) && $setting['activitylog']['activity_log_active_product']['sku'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="sku">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>SKU</p></div>
                                    </div>
                                    <!-- <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="request_data" class="onoffswitch-checkbox" id="request_data" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="request_data">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Request Data</p></div>
                                    </div> -->
                                </div>
                                <div class="col-md-4">
                                    <!-- <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="response_data" class="onoffswitch-checkbox" id="response_data" tabindex="0" checked>
                                            <label class="onoffswitch-label" for="response_data">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Response Data</p></div>
                                    </div> -->
                                    <div class="d-flex align-items-center mt-sm-10 ">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="action_by" class="onoffswitch-checkbox" id="action_by" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['action_by']) && $setting['activitylog']['activity_log_active_product']['action_by'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['action_by']) && $setting['activitylog']['activity_log_active_product']['action_by'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="action_by">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Action By</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="last_quantity" class="onoffswitch-checkbox" id="last_quantity" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['last_quantity']) && $setting['activitylog']['activity_log_active_product']['last_quantity'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['last_quantity']) && $setting['activitylog']['activity_log_active_product']['last_quantity'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="last_quantity">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Last Quantity</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="updated_quantity" class="onoffswitch-checkbox" id="updated_quantity" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['updated_quantity']) && $setting['activitylog']['activity_log_active_product']['updated_quantity'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['updated_quantity']) && $setting['activitylog']['activity_log_active_product']['updated_quantity'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="updated_quantity">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Updated Quantity</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="action_date" class="onoffswitch-checkbox" id="action_date" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['action_date']) && $setting['activitylog']['activity_log_active_product']['action_date'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['action_date']) && $setting['activitylog']['activity_log_active_product']['action_date'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="action_date">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Action Date</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="solve_status" class="onoffswitch-checkbox" id="solve_status" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['solve_status']) && $setting['activitylog']['activity_log_active_product']['solve_status'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['solve_status']) && $setting['activitylog']['activity_log_active_product']['solve_status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="solve_status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Solve Status</p></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center mt-sm-10">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="action_status" class="onoffswitch-checkbox" id="action_status" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['action_status']) && $setting['activitylog']['activity_log_active_product']['action_status'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['action_status']) && $setting['activitylog']['activity_log_active_product']['action_status'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="action_status">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Action Status</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="created_at" class="onoffswitch-checkbox" id="created_at" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['created_at']) && $setting['activitylog']['activity_log_active_product']['created_at'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['created_at']) && $setting['activitylog']['activity_log_active_product']['created_at'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="created_at">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Created At</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="updated_at" class="onoffswitch-checkbox" id="updated_at" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['updated_at']) && $setting['activitylog']['activity_log_active_product']['updated_at'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['updated_at']) && $setting['activitylog']['activity_log_active_product']['updated_at'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="updated_at">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Updated At</p></div>
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="deleted_at" class="onoffswitch-checkbox" id="deleted_at" tabindex="0" @if(isset($setting['activitylog']['activity_log_active_product']['deleted_at']) && $setting['activitylog']['activity_log_active_product']['deleted_at'] == 1) checked @elseif(isset($setting['activitylog']['activity_log_active_product']['deleted_at']) && $setting['activitylog']['activity_log_active_product']['deleted_at'] == 0) @else checked @endif>
                                            <label class="onoffswitch-label" for="deleted_at">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        <div class="ml-1"><p>Deleted At</p></div>
                                    </div>
                                </div>
                            </div>



                            <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                            <!--------------------------------------------------------------------------->


                            <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                            <input type="hidden" id="firstKey" value="activitylog">
                            <input type="hidden" id="secondKey" value="activity_log_active_product">
                            <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->

                            <!--Pagination Count and Apply Button Section-->
                            <div class="d-flex justify-content-between pagination-content">
                                <div>
                                    <form>
                                        <div><p class="pagination"><b>Pagination</b></p></div>
                                        <ul class="column-display d-flex align-items-center">
                                            <li>Number of items per page</li>
                                            <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                        </ul>
                                        <span class="pagination-mgs-show text-success"></span>
                                    </form>
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
                            <!-- <li class="breadcrumb-item">Order</li> -->
                            <li class="breadcrumb-item active" aria-current="page">Activity Logs</li>
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


                <!-- Awaiting dispatch content start-->
                <div class="row m-t-20 order-content">
                    <div class="col-md-12">
                        <div class="card-box shadow order-card table-responsive">

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {!! Session::get('success') !!}
                                </div>
                            @endif
                            @if(Session::has('assign_success_msg'))
                                <div class="alert alert-success">
                                    {!! Session::get('assign_success_msg') !!}
                                </div>
                            @endif

                            @if(Session::has('message'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{!! Session::get('message') !!}</strong>
                                </div>
                            @endif

                            @if(Session::has('no_data_found'))
                                <div class="alert alert-danger" role="alert">
                                    <strong>{!! Session::get('no_data_found') !!}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                        @endif

                        <!--Order Note Modal-->

                            <!--End Order Note Modal-->


                            <!--start table upper side content-->
                            <div class="product-inner dispatched-order">

                                <!--Awaiting dispatch search area-->
                                <div class="dispatched-search-area">
                                    <!-- <div data-tip="ID, Url, Action Name, Action Name, Account ID, Request Data,Response Data,Action By,Last Quantity,Updated Quantity,Action Date,Solve Status,Action Status,Created At,Updated At,Deleted At">
                                        <input type="text" class="form-control log-search dispatch-oninput-search" name="search_oninput" id="search_oninput" placeholder="Search..." required>
                                        <input type="hidden" name="log_search_status" id="log_search_status" value="processing">
                                    </div> -->
                                </div>
                                <!--End Awaiting dispatch search area-->

                                <!--Pagination area-->
                                <div class="pagination-area">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$allActivityLogs->total() ?? ''}} items</span>
                                            <span class="pagination-links d-flex">
                                                @if($allActivityLogs->currentPage() > 1)
                                                    <a class="first-page btn  {{$allActivityLogs->currentPage() > 1 ? '' : 'disable'}}" href="{{$activityLogs_info->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                    <a class="prev-page btn {{$allActivityLogs->currentPage() > 1 ? '' : 'disable'}}" href="{{$activityLogs_info->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                @endif
                                                    <span class="paging-input d-flex align-items-center">
                                                        <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                        <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$activityLogs_info->current_page}}" size="3" aria-describedby="table-paging">
                                                        <span class="datatable-paging-text d-flex">{{$activityLogs_info->current_page}} of <span class="total-pages">{{$activityLogs_info->last_page}}</span></span>
                                                        <input type="hidden" name="route_name" value="activity-log">
                                                    </span>
                                                    @if($allActivityLogs->currentPage() !== $allActivityLogs->lastPage())
                                                    <a class="next-page btn" href="{{$url != '' ? $activityLogs_info->next_page_url.$url : $activityLogs_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                    <a class="last-page btn" href="{{$url != '' ? $activityLogs_info->last_page_url.$url : $activityLogs_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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
                            <!--End table upper side content-->

                            <!--Awaiting dispatch select picker content-->

                            <!--End awaiting dispatch select picker content-->


                            <!--start table section-->
                            <table class="order-table w-100" style="border-collapse:collapse;">
                                <thead>
                                <form action="{{url('all-column-search')}}" method="post" id="reset-column-data">
                                    @csrf
                                    <input type="hidden" name="search_route" value="activity-log">
                                    <input type="hidden" name="status" value="publish">
                                    <tr>
                                        <!-- <th style="width: 4%; text-align: center"><input type="checkbox" class="ckbCheckAll" id="ckbCheckAll"><label for="selectall"></label></th> -->
                                        <th class="id" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['id'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="id" value="{{$allCondition['id'] ?? ''}}">
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
                                        <!-- <th class="url" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="url" value="url">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="url_opt_out" type="checkbox" name="url_opt_out" value="1" ><label for="url_opt_out">Opt Out</label>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>URL</div>
                                            </div>
                                        </th> -->
                                        <th class="action_name" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['action_name'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="action_name" value="{{$allCondition['action_name'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="action_name_opt_out" type="checkbox" name="action_name_opt_out" value="1" @isset($allCondition['action_name_opt_out']) checked @endisset><label for="action_name_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['action_name']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="action_name" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Action Name</div>
                                            </div>
                                        </th>
                                        <th class="account_name" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['account_name'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="account_name">

                                                            @isset($s_channels)
                                                                <option value="">Select Account Name</option>
                                                                @foreach($s_channels as $channel)
                                                                    @if(isset($allCondition['account_name']) && ($allCondition['account_name'] == $channel))
                                                                        <option value="{{$channel}}" selected>{{$channel}}</option>
                                                                    @else
                                                                        <option value="{{$channel}}">{{$channel}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endisset

                                                        </select>
                                                    <!-- <input type="text" class="form-control input-text" name="account_name" value="{{$allCondition['account_name'] ?? ''}}"> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="account_name_opt_out" type="checkbox" name="account_name_opt_out" value="1" @isset($allCondition['account_name_opt_out']) checked @endisset><label for="account_name_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['account_name']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="account_name" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Account Name</div>
                                            </div>
                                        </th>
                                        <th class="channel filter-symbol" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">

                                                    <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['channels'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>

                                                        <select class="form-control select2" name="channels[]" multiple>
                                                            <option value="">Manual</option>
                                                            @if (Session::get('ebay') == 1)
                                                                @foreach($channels as $key=> $channel)
                                                                    @if($key == "ebay")
                                                                        @foreach($channel as $key => $ebay)
                                                                            @if(isset($allCondition['channels']))
                                                                                @php
                                                                                    $existEbayChannel = null;
                                                                                    $getebay = 'ebay/'.$ebay;
                                                                                @endphp
                                                                                @foreach($allCondition['channels'] as $ch)
                                                                                    @if($getebay == $ch)
                                                                                        <option value="ebay/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                        @php
                                                                                            $existEbayChannel = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($existEbayChannel == null)
                                                                                    <option value="ebay/{{$ebay}}">{{$ebay}}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="ebay/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            @if (Session::get('woocommerce') == 1)
                                                                @foreach($wooChannels as $key=> $channel)
                                                                    @if($key == "woocommerce")
                                                                        @foreach($channel as $key => $ebay)
                                                                            @if(isset($allCondition['channels']))
                                                                                @php
                                                                                    $existEbayChannel = null;
                                                                                    $getebay = 'woocommerce/'.$ebay;
                                                                                @endphp
                                                                                @foreach($allCondition['channels'] as $ch)
                                                                                    @if($getebay == $ch)
                                                                                        <option value="woocommerce/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                        @php
                                                                                            $existEbayChannel = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($existEbayChannel == null)
                                                                                    <option value="woocommerce/{{$ebay}}">{{$ebay}}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="woocommerce/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            @if (Session::get('onbuy') == 1)
                                                                @foreach($onbuyChannels as $key=> $channel)
                                                                    @if($key == "onbuy")
                                                                        @foreach($channel as $key => $ebay)
                                                                            @if(isset($allCondition['channels']))
                                                                                @php
                                                                                    $existEbayChannel = null;
                                                                                    $getebay = 'onbuy/'.$ebay;
                                                                                @endphp
                                                                                @foreach($allCondition['channels'] as $ch)
                                                                                    @if($getebay == $ch)
                                                                                        <option value="onbuy/{{$ebay}}" selected>{{$ebay}}</option>
                                                                                        @php
                                                                                            $existEbayChannel = 1;
                                                                                        @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($existEbayChannel == null)
                                                                                    <option value="onbuy/{{$ebay}}">{{$ebay}}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="onbuy/{{$ebay}}">{{$ebay}}</option>
                                                                            @endif
                                                                        @endforeach

                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            @if (Session::get('amazon') == 1)
                                                                @if(isset($amazonChannels['amazon']) && count($amazonChannels['amazon']) > 0)
                                                                    @foreach($amazonChannels as $key=> $channel)
                                                                        @if($key == "amazon")
                                                                            @foreach($channel as $key => $amazon)
                                                                                @if(isset($allCondition['channels']))
                                                                                    @php
                                                                                        $existAmazonChannel = null;
                                                                                        $getamazon = 'amazon/'.$amazon;
                                                                                    @endphp
                                                                                    @foreach($allCondition['channels'] as $ch)
                                                                                        @if($getamazon == $ch)
                                                                                            <option value="amazon/{{$amazon}}" selected>{{$amazon}}</option>
                                                                                            @php
                                                                                                $existAmazonChannel = 1;
                                                                                            @endphp
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @if($existAmazonChannel == null)
                                                                                        <option value="amazon/{{$amazon}}">{{$amazon}}</option>
                                                                                    @endif
                                                                                @else
                                                                                    <option value="amazon/{{$amazon}}">{{$amazon}}</option>
                                                                                @endif
                                                                            @endforeach

                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="channel_opt_out" type="checkbox" name="channel_opt_out" value="1" @isset($allCondition['channel_opt_out']) checked @endisset><label for="channel_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['channels']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="channels" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div> Channel </div>
                                            </div>
                                        </th>
                                        <th class="sku" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['sku'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="sku" value="{{$allCondition['sku'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="sku_opt_out" type="checkbox" name="sku_opt_out" value="1" @isset($allCondition['sku_opt_out']) checked @endisset><label for="sku_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['sku']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="sku" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>SKU</div>
                                            </div>
                                        </th>
                                        <!-- <th class="request_data" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="request_data" value="request_data">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="request_data_opt_out" type="checkbox" name="request_data_opt_out" value="1" ><label for="request_data_opt_out">Opt Out</label>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Request Data</div>
                                            </div>
                                        </th>
                                        <th class="response_data" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                        <div class="dropdown-menu filter-content shadow" role="menu">
                                                            <p>Filter Value</p>
                                                            <input type="text" class="form-control input-text" name="response_data" value="response_data">
                                                            <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                                <input id="response_data_opt_out" type="checkbox" name="response_data_opt_out" value="1" ><label for="response_data_opt_out">Opt Out</label>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                        </div>

                                                </div>
                                                <div>Response Data</div>
                                            </div>
                                        </th> -->
                                        <th class="action_by" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['action_by'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        @php
                                                            $all_user_name = \App\User::get();
                                                        @endphp
                                                        <select class="form-control select2" name="action_by" id="action_by">
                                                            <!-- <select class="form-control b-r-0" name="search_value"> -->
                                                            @if(isset($all_user_name))
                                                                @if($all_user_name->count() == 1)
                                                                    @foreach($all_user_name as $user_name)
                                                                        <option value="{{$user_name->name}}">{{$user_name->name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Select Creator</option>
                                                                    @foreach($all_user_name as $user_name)
                                                                    <!-- <option value="{{$user_name->id}}">{{$user_name->name}}</option> -->
                                                                        @if(isset($allCondition['action_by']) && ($allCondition['action_by'] == $user_name->name))
                                                                            <option value="{{$user_name->name}}" selected>{{$user_name->name}}</option>
                                                                        @else
                                                                            <option value="{{$user_name->name}}">{{$user_name->name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </select>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="action_by_opt_out" type="checkbox" name="action_by_opt_out" value="1" @isset($allCondition['action_by_opt_out']) checked @endisset><label for="action_by_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['action_by']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="action_by" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Action By</div>
                                            </div>
                                        </th>
                                        <th class="last_quantity" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['last_quantity'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow stock-filter-content" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="last_quantity_opt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['last_quantity_opt']) && ($allCondition['last_quantity_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['last_quantity_opt']) && ($allCondition['last_quantity_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['last_quantity_opt']) && ($allCondition['last_quantity_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['last_quantity_opt']) && ($allCondition['last_quantity_opt'] == '<=')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['last_quantity_opt']) && ($allCondition['last_quantity_opt'] == '>=')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" class="form-control input-text symbol-filter-input-text" name="last_quantity" value="{{$allCondition['last_quantity'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="last_quantity_opt_out" type="checkbox" name="last_quantity_opt_out" value="1" @isset($allCondition['last_quantity_opt_out']) checked @endisset><label for="last_quantity_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['last_quantity']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="last_quantity" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Last Quantity</div>
                                            </div>
                                        </th>
                                        <th class="updated_quantity" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['updated_quantity'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow stock-filter-content" role="menu">
                                                        <p>Filter Value</p>
                                                        <div class="d-flex">
                                                            <div>
                                                                <select class="form-control" name="updated_quantity_opt">
                                                                    <option value=""></option>
                                                                    <option value="=" @if(isset($allCondition['updated_quantity_opt']) && ($allCondition['updated_quantity_opt'] == '=')) selected @endif>=</option>
                                                                    <option value="<" @if(isset($allCondition['updated_quantity_opt']) && ($allCondition['updated_quantity_opt'] == '<')) selected @endif><</option>
                                                                    <option value=">" @if(isset($allCondition['updated_quantity_opt']) && ($allCondition['updated_quantity_opt'] == '>')) selected @endif>></option>
                                                                    <option value="<=" @if(isset($allCondition['updated_quantity_opt']) && ($allCondition['updated_quantity_opt'] == '<=')) selected @endif>≤</option>
                                                                    <option value=">=" @if(isset($allCondition['updated_quantity_opt']) && ($allCondition['updated_quantity_opt'] == '>=')) selected @endif>≥</option>
                                                                </select>
                                                            </div>
                                                            <div class="ml-2">
                                                                <input type="number" class="form-control input-text symbol-filter-input-text" name="updated_quantity" value="{{$allCondition['updated_quantity'] ?? ''}}">
                                                            </div>
                                                        </div>
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="updated_quantity_opt_out" type="checkbox" name="updated_quantity_opt_out" value="1" @isset($allCondition['updated_quantity_opt_out']) checked @endisset><label for="updated_quantity_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['updated_quantity']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="updated_quantity" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Updated Quantity</div>
                                            </div>
                                        </th>
                                        <th class="action_date" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['action_date'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="action_date" value="{{$allCondition['action_date'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="action_date_opt_out" type="checkbox" name="action_date_opt_out" value="1" @isset($allCondition['action_date_opt_out']) checked @endisset><label for="action_date_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['action_date']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="action_date" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Action Date</div>
                                            </div>
                                        </th>
                                        <th class="solve_status" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['solve_status'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="solve_status" id="solve_status">
                                                            <option value="">Select Option</option>
                                                            <option value="1" @if(isset($allCondition['solve_status']) && $allCondition['solve_status'] == 1) selected @endif>Solved</option>
                                                            <option value="0" @if(isset($allCondition['solve_status']) && $allCondition['solve_status'] == 0) selected @endif>Unsolved</option>

                                                        </select>


                                                        <!-- <input type="text" class="form-control input-text" name="solve_status" value=""> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="solve_status_opt_out" type="checkbox" name="solve_status_opt_out" value="1" @isset($allCondition['solve_status_opt_out']) checked @endisset><label for="solve_status_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['solve_status']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="solve_status" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Solve Status</div>
                                            </div>
                                        </th>
                                        <th class="action_status" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['action_status'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <select class="form-control select2" name="action_status">
                                                            <option value="">Select Option</option>
                                                            <option value="1" @if(isset($allCondition['action_status']) && $allCondition['action_status'] == 1) selected @endif>Successful</option>
                                                            <option value="0" @if(isset($allCondition['action_status']) && $allCondition['action_status'] == 0) selected @endif>Unsuccessful</option>

                                                        </select>
                                                        <!-- <input type="text" class="form-control input-text" name="action_status" value=""> -->
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="action_status_opt_out" type="checkbox" name="action_status_opt_out" value="1" @isset($allCondition['action_status_opt_out']) checked @endisset><label for="action_status_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['action_status']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="action_status" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Action Status</div>
                                            </div>
                                        </th>
                                        <th class="created_at" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['created_at'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="created_at" value="{{$allCondition['created_at'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="created_at_opt_out" type="checkbox" name="created_at_opt_out" value="1" @isset($allCondition['created_at_opt_out']) checked @endisset><label for="created_at_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['created_at']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="created_at" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Created At</div>
                                            </div>
                                        </th>
                                        <th class="updated_at" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['updated_at'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="updated_at" value="{{$allCondition['updated_at'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="updated_at_opt_out" type="checkbox" name="updated_at_opt_out" value="1" @isset($allCondition['updated_at_opt_out']) checked @endisset><label for="updated_at_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['updated_at']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="updated_at" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Updated At</div>
                                            </div>
                                        </th>
                                        <th class="deleted_at" style="width: 10%; text-align: center">
                                            <div class="d-flex justify-content-center">
                                                <div class="btn-group">
                                                    <a type="button" class="dropdown-toggle filter-btn " data-toggle="dropdown">
                                                        <i class="fa @isset($allCondition['deleted_at'])text-warning @endisset" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu filter-content shadow" role="menu">
                                                        <p>Filter Value</p>
                                                        <input type="text" class="form-control input-text" name="deleted_at" value="{{$allCondition['deleted_at'] ?? ''}}">
                                                        <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                            <input id="deleted_at_opt_out" type="checkbox" name="deleted_at_opt_out" value="1" @isset($allCondition['deleted_at_opt_out']) checked @endisset><label for="deleted_at_opt_out">Opt Out</label>
                                                        </div>
                                                        @if(isset($allCondition['deleted_at']))
                                                            <div class="individual_clr">
                                                                <button title="Clear filters" type="submit" name="deleted_at" value=" " class='btn btn-outline-info clear-params'><i class="fas fa-times"></i></button>
                                                            </div>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                    </div>

                                                </div>
                                                <div>Deleted At</div>
                                            </div>
                                        </th>
                                        <th style="width: 8%">
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
                                <tbody>

                                @isset($allActivityLogs)
                                    @if(count($allActivityLogs) == 0)
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
                                    @foreach($allActivityLogs as $activity_log)
                                        @php
                                            if(!empty($activity_log->action_date)){
                                            $action_date = date("d-m-Y H:m:s", strtotime($activity_log->action_date));
                                            }else{
                                            $action_date = '';
                                            }
                                            if(!empty($activity_log->created_at)){
                                            $created_at = date("d-m-Y H:m:s", strtotime($activity_log->created_at));
                                            }else{
                                            $created_at = '';
                                            }
                                            if(!empty($activity_log->updated_at)){
                                            $updated_at = date("d-m-Y H:m:s", strtotime($activity_log->updated_at));
                                            }else{
                                            $updated_at = '';
                                            }
                                            if(!empty($activity_log->deleted_at)){
                                            $deleted_at = date("d-m-Y H:m:s", strtotime($activity_log->deleted_at));
                                            }else{
                                            $deleted_at = '';
                                            }
                                        @endphp
                                        <tr class="activity_log-{{$activity_log->id}} activity_log_border">
                                            <td class="id" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$activity_log->id ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="action_name" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">

                                                {{-- variation loader --}}
                                                <div id="product_variation_loading" class="variation_load" style="display: none;"></div>

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".error_log_popup-{{$activity_log->id}}">{{$activity_log->action_name ?? ''}}</button>

                                                <div class="modal fade error_log_popup-{{$activity_log->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">{{$activity_log->action_name ?? ''}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="activity-log modal-body">
                                                                <div class="text-left">
                                                                    <h5>Action URL</h5>
                                                                    <div class="url-sec">
                                                                        <p style="word-break:break-all;">{{$activity_log->action_url ?? ''}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="text-left">
                                                                    <h5>Request Data</h5>
                                                                    <div class="url-sec">
                                                                        <p style="word-break:break-all;">{{ $activity_log->request_data ?? ''}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="text-left">
                                                                    <h5>Response Data</h5>
                                                                    <div class="url-sec">
                                                                        <p style="word-break:break-all;">{{ $activity_log->response_data ?? ''}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                            <td class="account_name" style="cursor: pointer; text-align: center !important; width: 10%" data-toggle="collapse" data-target="#demo" class="accordion-toggle">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$activity_log->account_name ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="channel" style="text-align: center !important; width: 10%">
                                                @if(isset($activity_log->account_name))
                                                    {{-- <h6>{{ $activity_log->account_id }}</h6> --}}
                                                    @if($activity_log->account_name == 'Ebay')
                                                        <a title="eBay({{\App\EbayAccount::find($activity_log->account_id)->account_name ?? ''}})">
                                                            @if(!empty(\App\EbayAccount::find($activity_log->account_id)->logo))
                                                                <img style="height: 30px; width: 30px;" src="{{\App\EbayAccount::find($activity_log->account_id)->logo ?? ''}}">
                                                            @else
                                                                <span class="account_trim_name">
                                                            @php
                                                                $ac = \App\EbayAccount::find($activity_log->account_id);
                                                                if($ac){
                                                                    echo implode('', array_map(function($name)
                                                                    { return $name[0];
                                                                    },
                                                                    explode(' ', $ac->account_name)));
                                                                }
                                                            @endphp
                                                            </span>
                                                            @endif
                                                        </a>
                                                    @elseif($activity_log->account_name == 'Woocommerce')
                                                        <a title="WooComerece({{\App\WoocommerceAccount::find($activity_log->account_id)->account_name ?? ''}})" target="_blank">
                                                            <img style="height: 30px; width: 30px;" src="https://www.pngitem.com/pimgs/m/533-5339688_icons-for-work-experience-png-download-logo-woocommerce.png">
                                                        </a>
                                                    @elseif($activity_log->account_name == 'Onbuy')
                                                        <a title="OnBuy({{\App\OnbuyAccount::find($activity_log->account_id)->account_name ?? ''}})" target="_blank">
                                                            <img style="height: 30px; width: 30px;" src="https://www.onbuy.com/files/default/product/large/default.jpg">
                                                        </a>
                                                    @elseif($activity_log->account_name == 'Amazon')
                                                        @php
                                                            $logo = '';
                                                            $accountName = \App\amazon\AmazonAccountApplication::with(['accountInfo','marketPlace'])->find($activity_log->account_id);
                                                            if($accountName){
                                                            $logo = asset('/').$accountName->application_logo;
                                                            }
                                                        @endphp
                                                        <a title="Amazon({{$accountName->accountInfo->account_name ?? ''}} {{$accountName->marketPlace->marketplace ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                            <img style="height: 30px; width: 30px;" src="{{$logo}}">
                                                        </a>
                                                    @elseif($activity_log->account_name == 'Shopify')
                                                        {{-- @php
                                                            $logo = '';
                                                            $accountName = \App\shopify\ShopifyAccount::with(['accountInfo','marketPlace'])->find($activity_log->account_id);
                                                            if($accountName){
                                                            $logo = asset('/').$accountName->application_logo;
                                                            }
                                                        @endphp --}}
                                                        {{-- <a title="Amazon({{$accountName->accountInfo->account_name ?? ''}} {{$accountName->marketPlace->marketplace ?? ''}})" target="_blank" style="float:right; display:block; margin-right:10px;">
                                                            <img style="height: 30px; width: 30px;" src="{{$logo}}">
                                                        </a> --}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="sku" style="text-align: center !important; width: 10%; cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$activity_log->sku ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="action_by" style="text-align: center !important; width: 10%">
                                                {{$activity_log->action_by ?? ''}}
                                            </td>
                                            <td class="last_quantity" style="text-align: center !important; width: 10%;cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$activity_log->last_quantity ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="updated_quantity" style="text-align: center !important; width: 10%;cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$activity_log->updated_quantity ?? ''}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="action_date" style="text-align: center !important; width: 10%;cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$action_date}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="solve_status" style="text-align: center !important; width: 10%">
                                                @if(isset($activity_log->solve_status))
                                                    @if($activity_log->solve_status == 1)
                                                        <span class="label label-table label-status label-success">Solved</span>
                                                    @elseif($activity_log->solve_status == 0)
                                                        <span class="label label-table label-status label-warning">Unsolved</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="action_status" style="text-align: center !important; width: 10%">
                                                @if(isset($activity_log->action_status))
                                                    @if($activity_log->action_status == 1)
                                                        <span class="label label-table label-status label-success">Successful</span>
                                                    @elseif($activity_log->action_status == 0)
                                                        <span class="label label-table label-status label-warning">Unsuccessful</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="created_at" style="text-align: center !important; width: 10%;cursor:pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$created_at}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="updated_at" style="text-align: center !important; width: 10%;cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$updated_at}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>
                                            <td class="deleted_at" style="text-align: center !important; width: 10%;cursor: pointer">
                                                <div class="id_tooltip_container d-flex justify-content-center align-items-center">
                                                    <span onclick="textCopiedID(this);" class="">{{$deleted_at}}</span>
                                                    <span class="wms__id__tooltip__message" id="wms__id__tooltip__message">Copied!</span>
                                                </div>
                                            </td>

                                            <!--Action Button-->
                                            <td style="width: 8%">
                                                <form action="{{url('activity-log/edit/'.$activity_log->id)}}" method="PUT">
                                                    @csrf
                                                    @if($activity_log->solve_status == 1 && $activity_log->action_status == 1)
                                                        <button type="submit" name="solve_status" value="0" style="background-color:#5cb85c; color:#fff;" class="btn m-b-5 w-100 text-center order-complete" onclick="changeButtonColor()" data-placement="left" title="Mark As Unsolved">Solved</button>

                                                    @else
                                                        <button type="submit" name="solve_status" value="1" style="background-color:#ac2925; color:#fff;" class="btn m-b-5 w-100 text-center order-complete" onclick="changeButtonColor()" data-placement="left" title="Mark As Solved">Unsolved</button>

                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                            <!--End table section-->

                            <!--table footer pagination sec-->
                            <div class="row table-foo-sec">
                                <div class="col-md-6 d-flex justify-content-md-start align-items-center">
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-md-end align-items-center py-2">
                                        <div class="pagination-area">
                                            <div class="datatable-pages d-flex align-items-center">
                                                <span class="displaying-num pr-1">{{$allActivityLogs->total()}} items</span>
                                                <span class="pagination-links d-flex">
                                                    @if($allActivityLogs->currentPage() > 1)
                                                        <a class="first-page btn {{$allActivityLogs->currentPage() > 1 ? '' : 'disable'}}" href="{{$url != '' ? $activityLogs_info->first_page_url.$url : $activityLogs_info->first_page_url}}}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                        <span class="screen-reader-text d-none">First page</span>
                                                        <span aria-hidden="true">«</span>
                                                    </a>
                                                        <a class="prev-page btn {{$allActivityLogs->currentPage() > 1 ? '' : 'disable'}}" href=" {{$allActivityLogs->currentPage() > 1 ? '' : 'disable'}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                        <span class="screen-reader-text d-none">Previous page</span>
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                    @endif
                                                    <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                    <span class="paging-input d-flex align-items-center">
                                                        <span class="datatable-paging-text d-flex pl-1"> {{$activityLogs_info->current_page}} of <span class="total-pages">{{$activityLogs_info->last_page}}</span></span>
                                                    </span>
                                                    @if($allActivityLogs->currentPage() !== $allActivityLogs->lastPage())
                                                        <a class="next-page btn" href="{{$url != '' ? $activityLogs_info->next_page_url.$url : $activityLogs_info->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                        <span class="screen-reader-text d-none">Next page</span>
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                        <a class="last-page btn" href="{{$url != '' ? $activityLogs_info->last_page_url.$url : $activityLogs_info->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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

                            <!--End table footer pagination sec-->


                        {{--                            </form>--}}
                        <!----// END Table form --->


                        </div> <!--// card box--->
                    </div> <!-- // col-md-12 -->
                </div>  <!-- END Awaiting dispatch content -->
            </div> <!-- container -->
        </div> <!-- content -->

    </div> <!-- content page -->


    <!--order note modal-->

    <!--End order note modal-->



    <!--order cancel reason modal -->

    <!--End order cancel reason modal -->




    <script>

        //Select option jquery
        $('.select2').select2();

        //datatable toogle collapse/expand
        $('.accordian-body').on('show.bs.collapse', function () {
            $(this).closest("table")
                .find(".collapse.in")
                .not(this)
                .collapse('toggle')
        })

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


        // // Entire table row column display
        // $("#display-all").click(function(){
        //     $("table tr th, table tr td").show();
        //     $(".column-display .checkbox input[type=checkbox]").prop("checked", "true");
        // });
        //
        //
        // // After unchecked any column display all checkbox will be unchecked
        // $(".column-display .checkbox input[type=checkbox]").change(function(){
        //     if (!$(this).prop("checked")){
        //         $("#display-all").prop("checked",false);
        //     }
        // });



        // $(".checkBoxClass").on( "click", countCheckedAll );

        // $('.ckbCheckAll').click(function (e) {
        //     $(this).closest('table').find('td .checkBoxClass').prop('checked', this.checked);
        //     countCheckedAll();
        // })

        //End Check uncheck active catalogue counter

        function changeButtonColor() {
            var passedArray = <?php echo json_encode($allActivityLogs); ?>;

            document.getElementById("compleate").innerHTML = "Compleate";
            document.getElementById("compleate").style.background='#5cb85c';


        }
    </script>




@endsection




