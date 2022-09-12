@extends('master')

@section('title')
    Suppler || WMS360
@endsection

@section('content')

    <!-- Custombox -->
    <link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

    <!-- Modal-Effect -->
    <script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
    <script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>


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

                        <div class="d-flex justify-content-between content-inner mt-2 mb-2">
                            <div class="d-block">
                                <div class="d-flex align-items-center">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="registration-no" class="onoffswitch-checkbox" id="registration-no" tabindex="0" @if(isset($setting['supplier']['supplier_list']['registration-no']) && $setting['supplier']['supplier_list']['registration-no'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['registration-no']) && $setting['supplier']['supplier_list']['registration-no'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="registration-no">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Reg No</p></div>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="company-name" class="onoffswitch-checkbox" id="company-name" tabindex="0" @if(isset($setting['supplier']['supplier_list']['company-name']) && $setting['supplier']['supplier_list']['company-name'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['company-name']) && $setting['supplier']['supplier_list']['company-name'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="company-name">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Company Name</p></div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center mt-xs-10">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="vat-no" class="onoffswitch-checkbox" id="vat-no" tabindex="0" @if(isset($setting['supplier']['supplier_list']['vat-no']) && $setting['supplier']['supplier_list']['vat-no'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['vat-no']) && $setting['supplier']['supplier_list']['vat-no'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="vat-no">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>VAT No</p></div>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="email" class="onoffswitch-checkbox" id="email" tabindex="0" @if(isset($setting['supplier']['supplier_list']['email']) && $setting['supplier']['supplier_list']['email'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['email']) && $setting['supplier']['supplier_list']['email'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="email">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Email</p></div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center mt-sm-10">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="phone" class="onoffswitch-checkbox" id="phone" tabindex="0" @if(isset($setting['supplier']['supplier_list']['phone']) && $setting['supplier']['supplier_list']['phone'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['phone']) && $setting['supplier']['supplier_list']['phone'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="phone">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Phone</p></div>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="website" class="onoffswitch-checkbox" id="website" tabindex="0" @if(isset($setting['supplier']['supplier_list']['website']) && $setting['supplier']['supplier_list']['website'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['website']) && $setting['supplier']['supplier_list']['website'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="website">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Website</p></div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex align-items-center mt-sm-10 mt-xs-10 address">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="address" class="onoffswitch-checkbox" id="address" tabindex="0" @if(isset($setting['supplier']['supplier_list']['address']) && $setting['supplier']['supplier_list']['address'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['address']) && $setting['supplier']['supplier_list']['address'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="address">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Address</p></div>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="creator" class="onoffswitch-checkbox" id="creator" tabindex="0" @if(isset($setting['supplier']['supplier_list']['creator']) && $setting['supplier']['supplier_list']['creator'] == 1) checked @elseif(isset($setting['supplier']['supplier_list']['creator']) && $setting['supplier']['supplier_list']['creator'] == 0) @else checked @endif>
                                        <label class="onoffswitch-label" for="creator">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                    <div class="ml-1"><p>Creator</p></div>
                                </div>
                            </div>
                        </div>

                        <!---------------------------END ON OFF SWITCH BUTTON AREA------------------------>
                        <!--------------------------------------------------------------------------->



                        <!----ON OFF SWITCH ARRAY KEY DECLARATION---->
                        <input type="hidden" id="firstKey" value="supplier">
                        <input type="hidden" id="secondKey" value="supplier_list">
                        <!----END ON OFF SWITCH ARRAY KEY DECLARATION---->


                        <!--Pagination Count and Apply Button Section-->
                        <div class="d-flex justify-content-between align-items-center pagination-content">
                            <div>
                                <div><p class="pagination"><b>Pagination</b></p></div>
                                <ul class="column-display d-flex align-items-center">
                                    <li>Number of items per page</li>
                                    <li><input type="number" class="pagination-count" value="{{$pagination ?? 0}}"></li>
                                </ul>
                                <span class="pagination-mgs-show text-success"></span>
                                <div class="submit">
                                    <button type="submit" class="btn submit-btn pagination-apply">Apply</button>
                                </div>
                            </div>
                            <div class="mt-xs-15">
                                <a href="#addVendor" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"><button class="btn btn-default">Add Supplier</button></a>&nbsp;
                            </div>
                        </div>
                        <!--End Pagination and Apply Button Section-->

                    </div>
                </div>
            </div>
            <!--//screen option-->


            <!--Breadcrumb section-->
            <div class="screen-option">
                <div class="d-flex justify-content-start align-items-center">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="breadcrumb-item"> Supplier </li>
                        <li class="breadcrumb-item active" aria-current="page">Supplier</li>
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
                    <div class="card-box table-responsive shadow supplier-card">

                        <!--Start Backend error handler-->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('vendor_add_success_msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! Session::get('vendor_add_success_msg') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('vendor_edit_success_msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! Session::get('vendor_edit_success_msg') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('vendor_delete_success_msg'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! Session::get('vendor_delete_success_msg') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(Session::has('message'))
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{!! Session::get('message') !!}</strong>
                            </div>
                        @endif


                        @if(Session::has('no_data_found'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! Session::get('no_data_found') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                         @endif


                    <!--End Backend error handler-->

                        <!--start table upper side content-->
                        <div class="m-b-10 m-t-10">
                            <div class="d-flex justify-content-between product-inner p-b-10">
                                {{--                            <div class="row-wise-search search-terms">--}}
                                {{--                                <input class="form-control mb-1" id="row-wise-search" type="text" placeholder="Search....">--}}
                                {{--                            </div>--}}

                                <div class="draft-search-form">
                                    <form class="d-flex" action="{{URL('supplier/company/name/search')}}" method="post">
                                        @csrf
                                        <div class="p-text-area">
                                            <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search by Company Name, Reg No...">
                                        </div>
                                        <input type="hidden" name="route_name" value="supplier-list">
                                        <div class="submit-btn">
                                            <button type="submit" class="search-btn waves-effect waves-light" onclick="supplier_name_search()">Search</button>
                                        </div>
                                    </form>
                                </div>

                                <!--start pagination-->
                                <div class="pagination-area mt-xs-10 mb-xs-5">
                                    <form action="{{url('pagination-all')}}" method="post">
                                        @csrf
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_vendor->total()}} Suppliers</span>
                                            <span class="pagination-links d-flex">
                                            @if($all_vendor->currentPage() > 1)
                                            <a class="first-page btn {{$all_vendor->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_vendor->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                <span class="screen-reader-text d-none">First page</span>
                                                <span aria-hidden="true">«</span>
                                            </a>
                                            <a class="prev-page btn {{$all_vendor->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_vendor->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                <span class="screen-reader-text d-none">Previous page</span>
                                                <span aria-hidden="true">‹</span>
                                            </a>
                                            @endif
                                            <span class="paging-input d-flex align-items-center">
                                                <label for="current-page-selector" class="screen-reader-text d-none">Current Page</label>
                                                <input class="current-page" id="current-page-selector" type="text" name="paged" value="{{$all_decode_vendor->current_page}}" size="3" aria-describedby="table-paging">
                                                <span class="datatable-paging-text d-flex"> of <span class="total-pages">{{$all_decode_vendor->last_page}}</span></span>
                                                <input type="hidden" name="route_name" value="vendor-all-list">
                                            </span>
                                            @if($all_vendor->currentPage() !== $all_vendor->lastPage())
                                            <a class="next-page btn" href="{{$all_decode_vendor->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                <span class="screen-reader-text d-none">Next page</span>
                                                <span aria-hidden="true">›</span>
                                            </a>
                                            <a class="last-page btn" href="{{$all_decode_vendor->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
                                                <span class="screen-reader-text d-none">Last page</span>
                                                <span aria-hidden="true">»</span>
                                            </a>
                                            @endif
                                        </span>
                                        </div>
                                    </form>
                                </div>
                                <!--End pagination-->
                            </div>
                            <!--End table upper side content-->
                        </div>


                        <!--start table section-->
                        <!-- <table id="table-sort-list" class="supplier-table w-100" style="border-bottom: 1px solid #1ABC9C;"> -->
                        <table class="supplier-table w-100" style="border-bottom: 1px solid #1ABC9C;">
                            <thead>
                            <tr>
                                <th class="registration-no" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="number" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out1" name="opt_out" value="1"><label for="opt-out1">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="registration_no">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Reg No.</div>
                                    </div>
                                </th>
                                <th class="company-name" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out2" name="opt_out" value="1"><label for="opt-out2">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="company_name">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Company Name</div>
                                    </div>
                                </th>
                                <th class="vat-no" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out3" name="opt_out" value="1"><label for="opt-out3">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="vat_no">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>VAT No</div>
                                    </div>
                                </th>
                                <th class="email" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out4" name="opt_out" value="1"><label for="opt-out4">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="email">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Email</div>
                                    </div>
                                </th>
                                <th class="phone" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="number" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out5" name="opt_out" value="1"><label for="opt-out5">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="phone_no">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Phone</div>
                                    </div>
                                </th>
                                <th class="website" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out6" name="opt_out" value="1"><label for="opt-out6">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="website">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Website</div>
                                    </div>
                                </th>
                                <th class="address" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-start">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    <input type="text" class="form-control input-text" name="search_value">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input type="checkbox" id="opt-out7" name="opt_out" value="1"><label for="opt-out7">Opt Out</label>
                                                    </div>
                                                    <input type="hidden" name="column_name" value="address">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Address</div>
                                    </div>
                                </th>
                                <th class="creator" onclick="sortTable(0)">
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">
                                            <form action="{{URL('system/supplier/search')}}" method="post">
                                                @csrf
                                                <a type="button" class="dropdown-toggle filter-btn" data-toggle="dropdown">
                                                    <i class="fa" aria-hidden="true"></i>
                                                </a>

                                                <div class="dropdown-menu filter-content shadow" role="menu">
                                                    <p>Filter Value</p>
                                                    @php
                                                        $all_user_name = \App\User::get();
                                                    @endphp
                                                    <select class="form-control b-r-0" name="user_id">
                                                        @if(isset($all_user_name))
                                                            @if($all_user_name->count() == 1)
                                                                @foreach($all_user_name as $user_name)
                                                                    <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                @endforeach
                                                            @else
                                                                <option hidden>Select Creator</option>
                                                                @foreach($all_user_name as $user_name)
                                                                    <option value="{{$user_name->id}}">{{$user_name->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                    <input type="hidden" name="column_name" value="creator">
                                                    <input type="hidden" name="route_name" value="supplier-list">
                                                    <div class="checkbox checkbox-custom checkbox m-t-10 m-b-10">
                                                        <input id="opt-out8" type="checkbox" name="opt_out" value="1"><label for="opt-out8">Opt Out</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary filter-apply-btn float-right">Apply <i class="fa fa-arrow-circle-right ml-1"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <div>Creator</div>
                                    </div>
                                </th>
                                <th style="width: 6%">Actions</th>
                            </tr>
                            </thead>

                            <!--start table body-->
                            <tbody id="table-body">
                            @isset($all_vendor)
                                @foreach($all_vendor as $vendor)
                                    <tr>
                                        <td class="registration-no">{{$vendor->registration_no}}</td>
                                        <td class="company-name">{{$vendor->company_name}}</td>
                                        <td class="vat-no">{{$vendor->vat_no}}</td>
                                        <td class="email">{{$vendor->email}}</td>
                                        <td class="phone">{{$vendor->phone_no}}</td>
                                        <td class="website"><a href="{{$vendor->website}}" target="_blank">{{$vendor->website}}</a></td>
                                        <td class="address">{{$vendor->address}}</td>
                                        <td class="creator text-center">{{$vendor->user ? $vendor->user->find($vendor->user_id)->name : ''}}</td>
                                        <td style="width: 6%">
                                            <!--start manage button area-->
                                            <div class="btn-group dropup">
                                                <button type="button" class="btn manage-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Manage
                                                </button>
                                                <!--start dropup content-->
                                                <div class="dropdown-menu">
                                                    <div class="dropup-content catalogue-dropup-content">
                                                        <div class="action-1">
                                                             <div class="align-items-center mr-2">
                                                                 <a class="btn-size edit-btn" href="#editVendorList{{$vendor->id}}" data-animation="slit" data-plugin="custommodal" data-overlaySpeed="100" data-overlayColor="#36404a"  data-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                             </div>
                                                            <div class="align-items-center mr-2">
                                                                <a class="btn-size view-btn" href="{{url('vendor/'.$vendor->id)}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                            </div>
                                                            <div class="align-items-center">
                                                                <form action="{{url('vendor/'.$vendor->id)}}" method="post">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button class="del-pub delete-btn" style="cursor: pointer" href="#" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return check_delete('vendor');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--End dropup content-->
                                            </div>
                                            <!--End manage button area-->

                                            <!-- Edit Supplier Modal -->
                                            <div id="editVendorList{{$vendor->id}}" class="modal-demo">
                                                <button type="button" class="close" onclick="Custombox.close();">
                                                    <span>&times;</span><span class="sr-only">Close</span>
                                                </button>
                                                <h4 class="custom-modal-title">Edit Supplier</h4>
                                                <form role="form" class="vendor-form mobile-responsive" action="{{url('vendor/'.$vendor->id)}}" method="post" data-parsley-validate>
                                                    @method('PUT')
                                                    @csrf

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="company_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Company Name</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="company_name" class="form-control" id="company_name" data-parsley-maxlength="40" value="{{ $vendor->company_name ? $vendor->company_name: old('company_name') }}" required>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="address" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Address</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="address" class="form-control" id="address" value="{{ $vendor->address ? $vendor->address: old('address') }}" placeholder="Enter Address">
{{--                                                            <textarea name="address" class="form-control" id="address" value="" placeholder="Enter Addreess">{{ $vendor->address ? $vendor->address: old('address') }}</textarea>--}}
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="city" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">City</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="city" class="form-control" id="city" value="{{ $vendor->city ? $vendor->city: old('city') }}" placeholder="Enter City">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">County</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="country" class="form-control" id="country" value="{{ $vendor->country ? $vendor->country: old('country') }}" placeholder="Enter County">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="post_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Post Code</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="post_code" class="form-control" id="post_code" value="{{ $vendor->post_code ? $vendor->post_code: old('post_code') }}" placeholder="Enter Post Code">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="phone_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Phone Number</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="number" name="phone_no" class="form-control" id="phone_no" value="{{ $vendor->phone_no ? $vendor->phone_no: old('phone_no') }}" placeholder="Enter Phone Number">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Registration No.</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="number" name="registration_no" class="form-control" id="registration_no" value="{{ $vendor->registration_no ? $vendor->registration_no: old('registration_no') }}" placeholder="Enter Registration Number">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Website</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="url" name="website" class="form-control" id="website" value="{{ $vendor->website ? $vendor->website: old('website') }}" placeholder="Enter website Link">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="company_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">VAT No</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="text" name="vat_no" class="form-control" id="vat_no" value="{{ $vendor->vat_no ? $vendor->vat_no: old('vat_no') }}" placeholder="Enter VAT Number">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-1"></div>
                                                        <label for="email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Email Address</label>
                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                                                            <input type="email" name="email" class="form-control" id="email" value="{{ $vendor->email ? $vendor->email: old('email') }}" placeholder="Enter Email">
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

{{--                                                    <div class="form-group row">--}}
{{--                                                        <div class="col-md-1"></div>--}}
{{--                                                        <label for="state" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">State</label>--}}
{{--                                                        <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
{{--                                                            <input type="text" name="state" class="form-control" id="state" value="{{ $vendor->state ? $vendor->state: old('state') }}" placeholder="Enter state">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col-md-1"></div>--}}
{{--                                                    </div>--}}

                                                    <div class="form-group row">
                                                        <div class="col-md-12 text-center mb-5 mt-4">
                                                            <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                                                                <b>Update</b>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!--End Edit Supplier Modal -->

                                        </td>

                                    </tr>
                                @endforeach
                            @endisset
                            </tbody>
                            <!--End table body-->

                        </table>
                        <!--End table section-->

                        <!--table below pagination sec-->
                        <div class="row table-foo-sec">
                            <div class="col-md-6 d-flex justify-content-md-start align-items-center"> </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end align-items-center py-2">
                                    <div class="pagination-area">
                                        <div class="datatable-pages d-flex align-items-center">
                                            <span class="displaying-num">{{$all_vendor->total()}} Suppliers</span>
                                            <span class="pagination-links d-flex">
                                                @if($all_vendor->currentPage() > 1)
                                                <a class="first-page btn {{$all_vendor->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_vendor->first_page_url}}" data-toggle="tooltip" data-placement="top" title="First Page">
                                                    <span class="screen-reader-text d-none">First page</span>
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                                <a class="prev-page btn {{$all_vendor->currentPage() > 1 ? '' : 'disable'}}" href="{{$all_decode_vendor->prev_page_url}}" data-toggle="tooltip" data-placement="top" title="Previous Page">
                                                    <span class="screen-reader-text d-none">Previous page</span>
                                                    <span aria-hidden="true">‹</span>
                                                </a>
                                                @endif
                                                <span class="screen-reader-text" style="display: none;">Current Page</span>
                                                <span class="paging-input d-flex align-items-center">
                                                    <span class="datatable-paging-text d-flex pl-1"> {{$all_decode_vendor->current_page}} of <span class="total-pages"> {{$all_decode_vendor->last_page}} </span></span>
                                                </span>
                                                @if($all_vendor->currentPage() !== $all_vendor->lastPage())
                                                <a class="next-page btn" href="{{$all_decode_vendor->next_page_url}}" data-toggle="tooltip" data-placement="top" title="Next Page">
                                                    <span class="screen-reader-text d-none">Next page</span>
                                                    <span aria-hidden="true">›</span>
                                                </a>
                                                <a class="last-page btn" href="{{$all_decode_vendor->last_page_url}}" data-toggle="tooltip" data-placement="top" title="Last Page">
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


<!--Add Supplier Modal -->
<div id="addVendor" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Supplier</h4>
    <form role="form" class="vendor-form mobile-responsive" action="{{url('vendor/add-new')}}" method="post" data-parsley-validate>
        @csrf

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="company_name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25 required">Company Name</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="company_name" class="form-control" id="company_name" data-parsley-maxlength="30" value="{{ old('company_name') }}" placeholder="Enter Company Name" required>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="address" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Address</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" placeholder="Enter Address">
{{--                <textarea name="address" class="form-control" id="address" placeholder="Enter Addreess">{{ old('address') }}</textarea>--}}
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="city" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">City</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="city" class="form-control" id="city" value="{{ old('city') }}" placeholder="Enter City">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="country" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">County</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="country" class="form-control" id="country" value="{{ old('country') }}" placeholder="Enter County">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="zip_code" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Post Code</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="post_code" class="form-control" id="post_code" value="{{ old('post_code') }}" placeholder="Enter Post Code">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="phone_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Phone Number</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="number" name="phone_no" class="form-control" id="phone_no" value="{{ old('phone_no') }}" placeholder="Enter Phone Number">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="name" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Registration No.</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="number" name="registration_no" class="form-control" id="registration_no" value="{{ old('registration_no') }}" placeholder="Enter Registration Number">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="website" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Website</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="url" name="website" class="form-control" id="website" value="{{ old('website') }}" placeholder="Enter Website Link">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="vat_no" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">VAT No.</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="text" name="vat_no" class="form-control" id="vat_no" value="{{ old('vat_no') }}" placeholder="Enter VAT Number">
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="form-group row">
            <div class="col-md-1"></div>
            <label for="email" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">Email Address</label>
            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">
                <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Enter email">
            </div>
            <div class="col-md-1"></div>
        </div>

{{--        <div class="form-group row">--}}
{{--            <div class="col-md-1"></div>--}}
{{--            <label for="state" class="col-md-3 col-form-label ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">State</label>--}}
{{--            <div class="col-md-7 ml-sm-25 mr-sm-25 ml-xs-25 mr-xs-25">--}}
{{--                <input type="text" name="state" class="form-control" id="state" value="{{ old('state') }}" placeholder="Enter state">--}}
{{--            </div>--}}
{{--            <div class="col-md-1"></div>--}}
{{--        </div>--}}




        <div class="form-group row">
            <div class="col-md-12 text-center mb-5 mt-4">
                <button type="submit" class="btn btn-primary vendor-btn waves-effect waves-light">
                    <b>Submit</b>
                </button>
            </div>
        </div>


    </form>
</div>
<!--End Supplier Modal -->




<script>


    //Datatable row-wise searchable option
    $(document).ready(function(){
        $("#row-wise-search").on("keyup", function() {
            let value = $(this).val().toLowerCase();
            $("#table-body tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });
    });

    function supplier_name_search(){
        var name = $('#search_value').val();
        if(name == '' ){
            alert('Please type eBay profile name in the search field.');
        }
    }

    //sort ascending and descending table rows js
    function sortTable(n) {
        let table,
            rows,
            switching,
            i,
            x,
            y,
            shouldSwitch,
            dir,
            switchcount = 0;
        table = document.getElementById("table-sort-list");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "asc";
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < rows.length - 1; i++) { //Change i=0 if you have the header th a separate table.
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }


    // sort ascending descending icon active and active-remove js
    $('.header-cell').click(function() {
        let isSortedAsc  = $(this).hasClass('sort-asc');
        let isSortedDesc = $(this).hasClass('sort-desc');
        let isUnsorted = !isSortedAsc && !isSortedDesc;

        $('.header-cell').removeClass('sort-asc sort-desc');

        if (isUnsorted || isSortedDesc) {
            $(this).addClass('sort-asc');
        } else if (isSortedAsc) {
            $(this).addClass('sort-desc');
        }
    });


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


</script>



@endsection
